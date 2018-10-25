<?php
/**
 * Created by PhpStorm.
 * Author: Ren zhi yin
 * Date: 2018/10/24 0024
 * Time: 上午 11:44
 */
class UploadFileTool{
    //文件路径
    private $dir;
    //文件大小
    private $size;
    //文件格式
    private $type=[];
    //错误提示
    public $error;
    //文件名前缀
    private $pre;

    //初始化属性
    public function __construct(){
        $this->dir=isset($GLOBALS["config"]["upload"]["dir"])?$GLOBALS["config"]["upload"]["dir"]:"./";
        $this->size=isset($GLOBALS["config"]["upload"]["size"])?$GLOBALS["config"]["upload"]["size"]:2*1024*1024;
        $this->type=isset($GLOBALS["config"]["upload"]["type"])?$GLOBALS["config"]["upload"]["type"]:["image/jpeg","image/png","image/gif"];
        $this->pre=isset($GLOBALS["config"]["upload"]["pre"])?$GLOBALS["config"]["upload"]["pre"]:"";
    }

    //添加上传方法
    public function upload($file){
        //上传的错误信息
        if($file["error"]!=0){
            $this->error = "系统配置错误";
            return false;
        }
        //判定大小是否有误
        if($file["size"]>$this->size){
            $this->error = "文件太大，不允许上海窜";
            return false;
        }
        //判定文件格式
        if(!in_array($file["type"], $this->type)){
            $this->error="文件格式错误";
            return false;
        }

        //构建上传文件保存的名字
        $name = uniqid($this->pre);
        $extName = pathinfo($file["name"])["extension"];
        $fileName = $name.".".$extName;

        //上传文件
        move_uploaded_file($file['tmp_name'],$this->dir.$fileName);
        return $fileName;
    }

    //多文件上传
    public function multiUpload($fileArr){
        //声明一个数组 保存名字
        $nameArr=[];
        for($i=0;$i<count($fileArr["name"]);$i++){
            //分离成单个的file文件 才实现上传
            $file=[];
            $file["name"]=$fileArr["name"][$i];
            $file["type"]=$fileArr["type"][$i];
            $file["tmp_name"]=$fileArr["tmp_name"][$i];
            $file["error"]=$fileArr["error"][$i];
            $file["size"]=$fileArr["size"][$i];
            $nameArr[$i]=$this->upload($file);
        }
        return $nameArr;
    }
}