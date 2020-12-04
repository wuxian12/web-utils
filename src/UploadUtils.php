<?php

declare(strict_types=1);

namespace Wuxian\WebUtils;

use Hyperf\HttpMessage\Upload\UploadedFile;

/**
 * 文件上传
 * Class UploadUtils
 * @package Wuxian\WebUtils
 */
class UploadUtils extends UploadedFile 
{
    protected $img_path = 'images/'; // 图片目录
    protected $maxSize = 8 * 1024 * 1024; //允许上传的文件大小
    protected $size = 0;
    protected $allowSuffix = ['jpg','bmp','png','gif','svg','jpeg','webp']; //允许的后缀
    protected $allowMine = ['image/jpg','image/png','image/gif']; //允许的mine
    protected $suffix; // 文件后缀
    protected $newName; //文件新名称
    protected $filemd5; //文件的md5值
    protected $fileold; //文件旧名称
    protected $filemime;


    public function uploadFile($file)
    {
        //传输文件不符合要求
        if (!($file instanceof UploadedFile)) {
            throw new \RuntimeException('file obj is error');
        }
        // 获取文件信息
        $this->getFileInfo($file);


        // 判断文件大小是否超过范围
        $this->checkSize();
        //$this->checkSuffix();
        $this->checkMine();
        $target = $this->createNewName();
        $this->moveTo($target);
        return $this;
    }
    //设置允许文件上传后缀
    public function setSuffix($suffix = [])
    {
        $this->allowSuffix = $suffix;
    }

    //设置允许文件上传mine
    public function setMine($allowMine = [])
    {
        $this->allowMine = $allowMine;
    }

    //设置文件后缀
    public function setFileSuffix($suffix)
    {
        $this->suffix = $suffix;
    }

    //设置文件存储目录名
    public function setFileDir($fileDir)
    {
        $this->img_path = $fileDir;
    }

    //设置允许文件上传大小
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    
    //获取文件大小
    public function getSize()
    {
        return $this->size;
    }
    //获取文件md5值
    public function getFilemd5()
    {
        return $this->filemd5;
    }
    //获取上传后的路径
    public function getPath()
    {
        return $this->newName;
    }
    //获取文件名字
    public function getFileName()
    {
        return $this->fileold;
    }

    //获取文件类型
    public function getMimeType()
    {
        return $this->filemime;
    }


    public function getFileInfo(UploadedFile $file)
    {
        $this->size = $file->getSize();
        $this->suffix = $file->getExtension();
        $this->filemd5 = md5_file($file->getRealPath());
        $this->fileold = $file->getClientFilename();
        $this->filemime = $file->getMimeType();
        return $this;
    }

    /**
     * 判断文件大小
     */
    protected function checkSize()
    {
        if ($this->size > $this->maxSize) {
            $max = $this->maxSize/(1024*1024);
            throw new \InvalidArgumentException('文件不能超过'.$max.'M');
        }
    }

    /**
     * 判断后缀
     */
    protected function checkSuffix()
    {
        if (count($this->allowSuffix) > 0 && !in_array($this->suffix, $this->allowSuffix)) {
            throw new \InvalidArgumentException('文件不被支持');
        }
    }

    /**
     * 判断mine
     */
    protected function checkMine()
    {
        if (count($this->allowMine) > 0 && !in_array($this->filemime, $this->allowMine)) {
            throw new \InvalidArgumentException('文件不被支持');
        }
    }

    /**
     * 创建新名称
     */
    protected function createNewName()
    {
        $dir = env('DOCUMENT_ROOT', BASE_PATH . '/runtime').DIRECTORY_SEPARATOR.$this->img_path.date('Ymd');
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }
        $this->newName = $dir . DIRECTORY_SEPARATOR .uniqid() . '.' . $this->suffix;
        return $this->newName;
    }
}