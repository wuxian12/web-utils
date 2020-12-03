<?php
namespace DummyNamespace;

use Wuxian\Rbac\Rbac;

class PermissionService
{
    protected $rbac;

    public function __construct()
    {
        $this->rbac = new Rbac();
    }

    public function list()
    {
        return $this->rbac->permissionList();
    }

    public function menu($user_id)
    {
        return $this->rbac->menu(intval($user_id));
    }

    public function add($params)
    {
        return $this->rbac->addPermission($params);
    }

    public function eidt($params)
    {
        return $this->rbac->editPermission(intval($params['id']),$params);
    }

    public function del($params)
    {
        return $this->rbac->delPermission($params);
    }

    public function info($params)
    {
        return $this->rbac->getPermissionInfo(intval($params['id']));
    }

    public function addPermissionIdsRoleId($params)
    {
        return $this->rbac->addPermissionIdsRoleId(intval($params['role_id']),$params['permission_ids']);
    }

    public function info($params)
    {
        return $this->rbac->getPermissionIdsByRoleId(intval($params['id']));
    }

    
}


