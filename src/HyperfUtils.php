<?php

declare(strict_types=1);

namespace Wuxian\WebUtils;

use Hyperf\Logger\Logger;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Context;
use Wuxian\WebUtils\GrpcClientUtils;
use Pb\Params;
use Pb\Reply;


class HyperfUtils
{
    //生成订单号
    public static function orderNo(): string
    {
        return date('YmdHis') . static::randomNum();
    }

    //生成唯一字符串
    public static function uniqueNum(): string
    {
        mt_srand();
        return \md5((uniqid(strval(mt_rand()), true)));

    }
    //生成uuid
    public static function uuid()
    {
        mt_srand();
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    //生成随机数
    public static function randomNum()
    {
        mt_srand();
        $uniqid = sprintf('%u', crc32(uniqid(strval(mt_rand()), true)));
        return $uniqid;
    }


    //获取redis锁
    public static function getLock($key, $expires = 10)
    {
        $key = 'lock_' . $key;
        $token = uniqid();
        $container = ApplicationContext::getContainer();
        $redis = $container->get(Redis::class);
        $res = $redis->set($key, $token, ['NX', 'EX' => $expires]);
        if ($res) {
            $lock = [
                'key' => $key,
                'token' => $token,
            ];
            return $lock;
        }
        return false;
    }

    //删除redis锁
    public static function delLock($lock)
    {
        $key = $lock['key'];
        $token = $lock['token'];
        $container = ApplicationContext::getContainer();
        $redis = $container->get(Redis::class);
        $script = '
            if redis.call("GET", KEYS[1]) == ARGV[1] then
                return redis.call("DEL", KEYS[1])
            else
                return 0
            end
        ';
        return $redis->eval($script, [$key, $token], 1);
    }

    /**
     * 记录日志
     * @param $message  //日志描述
     * @param string $context  //日志的内容
     * @param string $context  //日志channel
     */
    public static function info($desc = '', $context = [], $name = 'log')
    {
        if (Context::has('co_trace_id')) {
            $trace_id = Context::get('co_trace_id', '');
        } else {
            $trace_id = static::randomNum();
            Context::set('co_trace_id', $trace_id);
        }
        $log = ApplicationContext::getContainer()->get(\Hyperf\Logger\LoggerFactory::class)->get($trace_id);
        $log->info($desc, $context);
    }

    //将下划线命名转换为驼峰式命名
    public static function convertUnderline($str, $ucfirst = true)
    {
        $str = explode('_', $str);
        foreach ($str as $key => $val) {
            $str[$key] = ucfirst($val);
        }

        if (!$ucfirst) {
            $str[0] = strtolower($str[0]);
        }

        return implode('', $str);
    }

    //获取毫秒时间戳
    public static function getMillisecond()
    {
        return sprintf('%.0f', microtime(true) * 1000);
    }

    //AES加密
    public static function opensslEncrypt($data, $aes_key = '', $aes_iv = '', $method = 'aes-256-cbc')
    {
        if (empty($aes_key)) {
            $aes_key = config('web.aes_key');
        }
        if (empty($aes_iv)) {
            $aes_iv = config('web.aes_iv');
        }
        return \base64_encode(openssl_encrypt($data, $method, $aes_key, OPENSSL_RAW_DATA, $aes_iv));
    }

    //AES加密
    public static function opensslDecrypt($data, $aes_key = '', $aes_iv = '', $method = 'aes-256-cbc')
    {
        if (empty($aes_key)) {
            $aes_key = config('web.aes_key');
        }
        if (empty($aes_iv)) {
            $aes_iv = config('web.aes_iv');
        }
        return openssl_decrypt(\base64_decode($data), $method, $aes_key, OPENSSL_RAW_DATA, $aes_iv);
    }

    //grpc客户端
    public static function grpcClient($data = [], $hostname = '', $options = [], $method = 'aes-256-cbc')
    {
        $client = new GrpcClientUtils($hostname, $options);
        $request = new Params();
        $request->setRequest(Json::encode($data));
        $request->setController('\\App\\Service\\Api\\TaskService');
        $request->setMethod('addTask');

        list($reply, $status) = $client->curdClient($request);
        if ($reply->getErrCode() == 0) {
            $data = $reply->getData();
            return $data;
        } else {
            throw new \Exception(500, $reply->getMsg());
        }
    }

    

	
}