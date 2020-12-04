<?php

declare(strict_types=1);

namespace Wuxian\WebUtils\Dao;


class BaseDao
{
    protected $query;

    public function queryBuild(array $where = [])
    {
        foreach ($where as $k => $v) {
            if(!isset($v[1])){
                throw new \InvalidArgumentException("参数错误",); 
            }
            switch ($v[1]) {
                case 'between':
                    $this->query = $this->query->whereBetween($v[0],$v[2]);
                    unset($where[$k]);
                    break;
                case 'notBetween':
                    $this->query = $this->query->whereNotBetween($v[0],$v[2]);
                    unset($where[$k]);
                    break;
                case 'in':
                    $this->query = $this->query->whereIn($v[0],$v[2]);
                    unset($where[$k]);
                    break;
                case 'notIn':
                    $this->query = $this->query->whereNotIn($v[0],$v[2]);
                    unset($where[$k]);
                    break;
                default:
                    break;
            }
        }
        $this->query = $this->query->where($where);
        
    }
    
    public function countByWhere(array $where = [])
    {
        return $this->query->queryBuild($where)->count();
    }

    
    public function getOne(array $where = [], $field = ["*"])
    {
        if(is_array($field)){
            return $this->query->queryBuild($where)->first($field);
        }else{
            return $this->query->queryBuild($where)->value($field);
        }
    }

    public function get(array $where = [], $field = ["*"])
    {
        if(is_array($field)){
            return $this->query->queryBuild($where)->get($field);
        }else{
            return $this->query->queryBuild($where)->value($field);
        }
    }


    public function create(array $data)
    {
        return $this->query->create($data);
    }

    
    public function insert(array $data)
    {
        return $this->query->insert($data);
    }

    
    public function insertGetId(array $data)
    {
        return $this->query->insertGetId($data);
    }


    public function delete(array $where)
    {
        return $this->query->where($where)->delete();
    }

    
    public function updateByWhere($where = [], $data = [])
    {
        return $this->query->where($where)->update($data);
    }

    public function page($pageSize, $where = [], $field = ['*'])
    {
        return $this->query->where($where)->paginate(intval($pageSize), $field, 'page')->toArray();
    }

    public function pluck($where = [], $field)
    {
        return $this->query->where($where)->pluck($field)->toArray();
    }

    
}
