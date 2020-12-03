<?php
namespace DummyNamespace;

use Wuxian\Rbac\Rbac;

class AdminService
{
    protected $rbac;

    public function __construct()
    {
        $this->rbac = new Rbac();
    }

    public function list($params)
    {
        return $this->rbac->adminList(intval($params['page_size'] ?? 15));
    }

    public function add($params)
    {
        return $this->rbac->addAdmin($params);
    }

    public function eidt($params)
    {
        return $this->rbac->editAdmin(intval($params['id']),$params);
    }

    public function del($params)
    {
        return $this->rbac->delAdmin($params);
    }

    public function info($params)
    {
        return $this->rbac->getAdminInfo(intval($params['id']));
    }

    
}


