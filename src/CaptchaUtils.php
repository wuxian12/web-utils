<?php

declare(strict_types=1);

namespace Wuxian\WebUtils;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Psr\SimpleCache\CacheInterface;

class CaptchaUtils
{
	//缓存验证码
	protected $cache = null;

	protected $codeLen = 4;

	protected $codeStr = '0123456789';

	protected $prefix = 'code_';

	protected $ttl = 120;

	public function __construct(CacheInterface $cache = null, $codeLen = 4, $ttl = 120)
	{
		$this->cache = $cache;
		$this->codeLen = $codeLen;
		$this->ttl = $ttl;
	}
	//生成验证码
	public function generationCode()
	{
        $phraseBuilder = new PhraseBuilder($this->codeLen, $this->getCodeStr());

        $builder = new CaptchaBuilder(null, $phraseBuilder);
     	$builder->build();
        if(!empty($this->cache)){
        	$cacheKey = $this->prefix.$this->uniqueNum();
        	$this->cache->set($cacheKey,$this->ttl,$builder->getPhrase());
            return ['content' => $builder->inline(), 'key' => $cacheKey];
        }else{
        	return ['content' => $builder->inline(), 'code' => $builder->getPhrase()];
        }
        
	}

	//验证验证码
	public function verify($cacheKey,$code)
	{
        $ccode = $this->cache->get($cacheKey);
        return $ccode == $code;
	}

	//验证码字符串
	public function getCodeStr()
	{
		return $this->codeStr;
	}

	//设置验证码字符串
	public function setCodeStr($val)
	{
		$this->codeStr = $val;
		return $this;
	}

	//生成缓存验证码的key
    public function uniqueNum()
    {
        mt_srand();
        return \md5((uniqid(strval(mt_rand()), true)));

    }

	
}