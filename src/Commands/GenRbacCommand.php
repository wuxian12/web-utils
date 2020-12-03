<?php

declare(strict_types=1);

namespace Wuxian\WebUtils\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Hyperf\Command\Command as HyperfCommand;
use Throwable;

class GenRbacCommand extends HyperfCommand
{
    /**
     * Create a new migration install command instance.
     */
    public function __construct()
    {
        parent::__construct('gen:rbac');
        $this->setDescription('Create new rbac');

    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 你想要做的任何操作
        $cnamespace = $this->output->ask('请输入控制器命名空间','App\\Controller');
        $snamespace = $this->output->ask('请输入service层命名空间','App\\Service');
        $dir = $this->output->ask('请输入文件目录',BASE_PATH);
        $controllerDir = $this->getControllerPath($dir,$cnamespace);
        $serviceDir = $this->getControllerPath($dir,$snamespace);
        $this->genFile($controllerDir,$serviceDir,$cnamespace,$snamespace);
        $this->output->writeln('gen suceess');
    }

    public function genFile($controllerDir,$serviceDir,$cnamespace,$snamespace)
    {
        
        $ccontent = file_get_contents(__DIR__. '/stubs/admin/AdminController.php');
        $ccontent = str_replace(['DummyNamespace','DummyServer'],[$cnamespace,$snamespace.'\\AdminService'],$ccontent);
        $scontent = file_get_contents(__DIR__. '/stubs/admin/AdminService.php');
        $scontent = str_replace('DummyNamespace',$snamespace,$scontent);
        file_put_contents($controllerDir.'/AdminController.php', $ccontent);
        file_put_contents($serviceDir.'/AdminService.php', $scontent);
        
        $ccontent = file_get_contents(__DIR__. '/stubs/role/RoleController.php');
        $ccontent = str_replace(['DummyNamespace','DummyServer'],[$cnamespace,$snamespace.'\\RoleService'],$ccontent);
        $scontent = file_get_contents(__DIR__. '/stubs/role/RoleService.php');
        $scontent = str_replace('DummyNamespace',$snamespace,$scontent);
        file_put_contents($controllerDir.'/RoleController.php', $ccontent);
        file_put_contents($serviceDir.'/RoleService.php', $scontent);
       
        $ccontent = file_get_contents(__DIR__. '/stubs/permission/PermissionController.php');
        $ccontent = str_replace(['DummyNamespace','DummyServer'],[$cnamespace,$snamespace.'\\PermissionService'],$ccontent);
        $scontent = file_get_contents(__DIR__. '/stubs/permission/PermissionService.php');
        $scontent = str_replace('DummyNamespace',$snamespace,$scontent);
        file_put_contents($controllerDir.'/PermissionController.php', $ccontent);
        file_put_contents($serviceDir.'/PermissionService.php', $scontent);
        
        
    }

    public function getControllerPath($dir,$cnamespace)
    {
        $dir = $this->getDir($dir);
        $cdir = rtrim($dir,'/').'/'.str_replace('\\', '/', $cnamespace);
        return $this->exsitDir($cdir);
    }

    public function getServicePath($dir,$snamespace)
    {
        $dir = $this->getDir($dir);
        $sdir = rtrim($dir,'/').'/'.str_replace('\\', '/', $snamespace);
        $this->exsitDir($sdir);
    }

    public function exsitDir($dir)
    {
        $dir = str_replace('App','app',$dir);
        if(!is_dir($dir)){
            mkdir($dir, 0777, true);
        }
        return $dir;
    }

    public function getDir($dir)
    {
        if($dir){
            return $dir;
        }else{
            return BASE_PATH;
        }
    }
}
