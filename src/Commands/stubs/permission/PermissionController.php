<?php
namespace DummyNamespace;

use App\Controller\AbstractController;
use DummyServer;

class PermissionController extends AbstractController
{
    public function list()
    {
        $data = make(PermissionService::class)->permissionList();
        return $this->success('获取成功', $data);
    }

    public function menu()
    {
        //TODO 获取用户id
        $data = make(PermissionService::class)->menu($user_id);
        return $this->success('获取成功', $data);
    }

    public function add()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $id = make(PermissionService::class)->add($params);
        return $this->success('添加成功', $id);
    }

    public function eidt()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $id = make(PermissionService::class)->eidt($params);
        return $this->success('编辑成功', $id);
    }

    public function del()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $id = make(PermissionService::class)->del($params);
        return $this->success('删除成功', $id);
    }

    public function info()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $info = make(PermissionService::class)->info($params);
        return $this->success('获取成功', $info);
    }

    public function addPermissionIdsRoleId()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $info = make(PermissionService::class)->addPermissionIdsRoleId($params);
        return $this->success('添加成功', $info);
    }

    public function getPermissionIdsByRoleId()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $info = make(PermissionService::class)->getPermissionIdsByRoleId($params);
        return $this->success('获取成功', $info);
    }


    
}


