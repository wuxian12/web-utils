<?php
namespace DummyNamespace;

use App\Controller\AbstractController;
use DummyServer;

class RoleController extends AbstractController
{
    public function list()
    {
        $params = $this->request->all();
        $data = make(RoleService::class)->list($params);
        return $this->success('获取成功', $data['data'], $data['total']);
    }

    public function add()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $id = make(RoleService::class)->add($params);
        return $this->success('添加成功', $id);
    }

    public function eidt()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $id = make(RoleService::class)->eidt($params);
        return $this->success('编辑成功', $id);
    }

    public function del()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $id = make(RoleService::class)->del($params);
        return $this->success('删除成功', $id);
    }

    public function info()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $info = make(RoleService::class)->info($params);
        return $this->success('获取成功', $info);
    }

    public function all()
    {
        $list = make(RoleService::class)->roleAll();
        return $this->success('获取成功', $list);
    }


    
}


