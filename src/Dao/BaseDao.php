<?php

declare(strict_types=1);

namespace Wuxian\WebUtils\Dao;


class BaseDao
{
    
    public function queryBuild(array $where = [])
    {
        $query = $this->query::query();
        foreach ($where as $k => $v) {
            if(!isset($v[1])){
                throw new \InvalidArgumentException("参数错误"); 
            }
            switch ($v[1]) {
                case 'between':
                    $query = $query->whereBetween($v[0],$v[2]);
                    unset($where[$k]);
                    break;
                case 'notBetween':
                    $query = $query->whereNotBetween($v[0],$v[2]);
                    unset($where[$k]);
                    break;
                case 'in':
                    $query = $query->whereIn($v[0],$v[2]);
                    unset($where[$k]);
                    break;
                case 'notIn':
                    $query = $query->whereNotIn($v[0],$v[2]);
                    unset($where[$k]);
                    break;
                default:
                    break;
            }
        }
        return $query->where($where);
        
    }
    
    public function countByWhere(array $where = [])
    {
        return $this->queryBuild($where)->count();
    }

    
    public function getOne(array $where = [], $field = ["*"], $order = ['id'=>'desc'])
    {
        $sql = $this->queryBuild($where);
        if(!empty($order)){
            foreach ($order as $k => $v) {
                $sql->orderBy($k,$v);
            }
        }
        if(is_array($field)){
            $info = $sql->first($field);
            if(empty($info)){
                return [];
            }else{
                return $info->toArray();
            }
        }else{
            return $sql->value($field);
        }
    }

    public function get(array $where = [], $field = ["*"], $order = ['id'=>'desc'])
    {
        $sql = $this->queryBuild($where);
        if(!empty($order)){
            foreach ($order as $k => $v) {
                $sql->orderBy($k,$v);
            }
        }
        if(is_array($field)){
            return $sql->get($field)->toArray();
        }else{
            return $sql->pluck($field)->toArray();
        }
    }


    public function create(array $data)
    {
        return $this->query::query()->create($data);
    }

    
    public function insert(array $data)
    {
        return $this->query::query()->insert($data);
    }

    
    public function insertGetId(array $data)
    {
        return $this->query::query()->insertGetId($data);
    }


    public function delete(array $where)
    {
        return $this->queryBuild($where)->delete();
    }

    
    public function updateByWhere($where = [], $data = [])
    {
        return $this->queryBuild($where)->update($data);
    }

    public function page($pageSize, $where = [], $field = ['*'], $pageName = 'page', $page = 0, $order = ['id'=>'desc'])
    {
        $sql = $this->queryBuild($where);
        if(!empty($order)){
            foreach ($order as $k => $v) {
                $sql->orderBy($k,$v);
            }
        }
        return $sql->paginate(intval($pageSize), $field, $pageName, intval($page))->toArray();
    }

    
}
