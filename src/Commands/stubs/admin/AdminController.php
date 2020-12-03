<?php
namespace DummyNamespace;

use App\Controller\AbstractController;
use DummyServer;

class AdminController extends AbstractController
{
    public function list()
    {
        $params = $this->request->all();
        $data = make(AdminService::class)->list($params);
        return $this->success('获取成功', $data['data'], $data['total']);
    }

    public function add()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $id = make(AdminService::class)->add($params);
        return $this->success('添加成功', $id);
    }

    public function eidt()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $id = make(AdminService::class)->eidt($params['id'],$params);
        return $this->success('编辑成功', $id);
    }

    public function del()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $id = make(AdminService::class)->del($params);
        return $this->success('删除成功', $id);
    }

    public function info()
    {
        $params = $this->request->all();
        //TODO 处理参数验证
        $info = make(AdminService::class)->info($params['id']);
        return $this->success('获取成功', $info);
    }


    
}


