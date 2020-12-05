<?php

declare(strict_types=1);

namespace Wuxian\WebUtils;

use Firebase\JWT\JWT;
use Wuxian\WebUtils\Constants\ErrorCode;

class JwtUtils
{
    public static $exp = 25920000; //token的过期时间
    public static $overtime = 25920000; //刷新token的过期时间

    /**
     * @param array $info
     * @param string $user  签发者
     * @param string $key jwt的签发密钥，验证token的时候需要用到
     * @return array
     * @Description  生成token
     */
    public static function authorizations(array $info, $key, string $user = 'php')
    {
        $access_token = static::createJwt($info, $key, static::$exp, $user);
        return $access_token;//方便前端,去除刷新token
        // $refresh_token = static::createJwt($info, $key, static::$overtime, $user);
        // return ['token' => $access_token, 'refresh_token' => $refresh_token];
    }

    // 生成token
    public static function createJwt(array $info, $key, int $exp = 0, string $user = 'php')
    {
        $nbf = time();
        empty($exp) ? $exp = static::$exp : '';
        $expire = $nbf + $exp;
        $token = array_merge($info, [
            "iss" => $user, //签发者 可以为空
            "aud" => "", //面象的用户，可以为空
            "iat" => $nbf, //签发时间
            "nbf" => $nbf, //在什么时候jwt开始生效  （这里表示生成10秒后才生效）
            "exp" => $expire, //token 过期时间
        ]);
        return JWT::encode($token, $key);
    }

    public static function checkToken(string $authorization, $key)
    {
        if (empty($authorization)) {
            throw new \InvalidArgumentException("沒有Token值", ErrorCode::TOKEN_AVIAL);
        }
        return static::verifyJwt($authorization, $key);
  
    }

    //校验jwt权限API
    protected static function verifyJwt(string $jwt, $key)
    {
        // 处理jwt的值 Bearer
        $jwt_list = explode(" ", $jwt);
        if ($jwt_list[0] != 'Bearer') {
        	throw new \InvalidArgumentException("Token格式不对", ErrorCode::TOKEN_AVIAL);
        }
        $jwt = $jwt_list[1];
        try {
            $jwtAuth = json_encode(JWT::decode($jwt, $key, array('HS256')));
            return json_decode($jwtAuth, true);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
        	throw new \LogicException("Token格式不对", ErrorCode::TOKEN_AVIAL);
        } catch (\Firebase\JWT\ExpiredException $e) {
        	throw new \LogicException("Token过期,请重新登陆", ErrorCode::TOKEN_AVIAL);
        } catch (\Exception $e) {
        	throw new \RuntimeException($e->getMessage(), ErrorCode::TOKEN_AVIAL);
           
        }
    }

    /**
     * 刷新重新生成并返回token
     * @return array
     */
    public static function refreshToken(string $refresh_token, $key, array $change_info = [])
    {
        try {
            $authInfo = static::verifyJwt($refresh_token, $key);
            $authInfo = array_merge($authInfo, $change_info);
            return static::createJwt($authInfo, $key, static::$exp);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            throw new \LogicException("Token格式不对", ErrorCode::TOKEN_AVIAL);
        } catch (\Firebase\JWT\ExpiredException $e) {
            throw new \LogicException("Token过期,请重新登陆", ErrorCode::TOKEN_AVIAL);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage(), ErrorCode::TOKEN_AVIAL);
        }
    }

	
}