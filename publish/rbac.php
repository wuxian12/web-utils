<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'type' => 'hyperf',  //框架类型
    'super' => [1],   //超级管理员id

    'table_num' => 4,  //表的数量 角色用户一对一可以是4张表也可以5张,角色用户多对多就是5张表
    'permission_table' => '', //权限表名
    'admin_table' => '', //用户表名
    'role_table' => '', //角色表名
    'role_admin_table' => '', //角色用户表名
    'role_permission_table' => '', //角色权限表名

    'admin_table_duplicate' => 'name', //用户表去重判断
    'role_table_duplicate' => 'name', //角色表去重判断
    'permission_table_duplicate' => 'name', //权限表去重判断
    'false_delete_key' => 'is_del', //假删除的key
    
    'admin_table_role_id' => 'role_id',  //四张表的用户表里的角色id,
    'admin_role_table_admin_id' => 'admin_id',  //用户角色表里的用户id,
    'admin_role_table_role_id' => 'role_id',  //用户角色表里的角色id,
    'role_permission_table_permission_id' => 'permission_id',  //角色权限表的权限id,
    'role_permission_table_role_id' => 'role_id',  //角色权限表的角色id,
    
    'permission_model' => '', //自定义的权限模型
    'admin_model' => '', //自定义的管理员模型
    'role_model' => '', //自定义的角色模型
    'role_admin_model' => '', //自定义的角色用户模型
    'role_permission_model' => '', //自定义的角色权限模型
    
    'permission_fillable' => [], //权限表结构
    'admin_fillable' => [], //用户表结构
    'role_fillable' => [], //角色表结构
    'role_admin_fillable' => [], //角色用户表结构
    'role_permission_fillable' => [], //角色权限表结构
];
