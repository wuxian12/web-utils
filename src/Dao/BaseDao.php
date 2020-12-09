<?php

declare(strict_types=1);

namespace Wuxian\WebUtils\Dao;


class BaseDao
{
    
    public function queryBuild(array $where = [])
    {
        $query = $this->query->newModelInstance();
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
        return $query->where($where)->orderBy('id','desc');
        
    }
    
    public function countByWhere(array $where = [])
    {
        return $this->queryBuild($where)->count();
    }

    
    public function getOne(array $where = [], $field = ["*"])
    {
        if(is_array($field)){
            $info = $this->queryBuild($where)->first($field);
            if(empty($info)){
                return [];
            }else{
                return $info->toArray();
            }
        }else{
            return $this->queryBuild($where)->value($field);
        }
    }

    public function get(array $where = [], $field = ["*"])
    {
        if(is_array($field)){
            return $this->queryBuild($where)->get($field)->toArray();
        }else{
            return $this->queryBuild($where)->pluck($field)->toArray();
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
        return $this->queryBuild($where)->delete();
    }

    
    public function updateByWhere($where = [], $data = [])
    {
        return $this->queryBuild($where)->update($data);
    }

    public function page($pageSize, $where = [], $field = ['*'])
    {
        return $this->queryBuild($where)->paginate(intval($pageSize), $field, 'page')->toArray();
    }

    
}
