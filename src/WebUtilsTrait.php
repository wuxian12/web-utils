<?php

declare (strict_types = 1);

namespace Wuxian\WebUtils;

use Wuxian\Rbac\Rbac;

trait WebApiTrait
{

	/**
     * @param integer $code  返回前端的code码  1成功 其它失败
     * @param string $msg   返回给前端的提示语
     * @param [type] $data  返回给前端的数据
     * @param integer $total  分页的总页数
     * @return array
     * @Description  http返回客户端的数据格式
     */
    public static function send(int $code = 1, string $msg = '', $data = [], int $total = 1): array
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data, 'total' => $total];

    }
    
    //验证jwt
    public static function chekcJwt($authorization, $key)
    {
    	return JwtUtils::checkToken($authorization, $key);
    }

    //获取用户左侧边栏
    public static function chekcJwt($userId)
    {
        $rbac = new Rbac();
        return $rbac->menu($userId);
    }

    //用户是否拥有api访问权限
    public static function apiAccessible($userId,$apiUrl)
    {
        $rbac = new Rbac();
        return $rbac->permissionIsOk($userId,$apiUrl);
    }
}