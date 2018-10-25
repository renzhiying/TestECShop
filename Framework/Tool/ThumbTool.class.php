<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of ThumbTool
 *
 * @author admin
 */
class ThumbTool {
    
    //声明一个数组
       public static $creatImg=[
            "image/jpeg"=>"imagecreatefromjpeg",
            "image/png"=>"imagecreatefrompng",
            "image/gif"=>"imagecreatefromgif",
        ];
        //定义输出图片数组
       public static $outImg=[
            "image/jpeg"=>"imagejpeg",
            "image/png"=>"imagepng",
            "image/gif"=>"imagegif",
        ];

        //定义扩展名数组
       public static $extension=[
            "image/jpeg"=>".jpg",
            "image/png"=>".png",
            "image/gif"=>".gif",
        ];
    public static function  drawImg($path,$width,$height){
         $dir=$GLOBALS["config"]["thumb"]["dir"];
        //获取原始图形属性
        $attr=  getimagesize($path);
        //var_dump($attr);
        
        //创建原始画布
        //取得图片类型
        $type=$attr["mime"];
        //取得创建画布的方式
        $createPic =  self::$creatImg[$type];
        $img= $createPic($path);
        //创建目标画布
        $dst=  imagecreatetruecolor($width, $height);
        //求比例
        $bili=$attr[0]/$width>$attr[1]/$height?$attr[0]/$width:$attr[1]/$height;
        //求取目标图形大小
        $w=$attr[0]/$bili;
        $h=$attr[1]/$bili;
         //填充背景颜色
        $color=  imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $color);
        //拷贝图片到目标
        imagecopyresampled($dst, $img, ($width-$w)/2, ($height-$h)/2, 0, 0, $w, $h, $attr[0], $attr[1]);
       
        //为缩略图设定名字
        $name=  uniqid("thumb_");
        $extName=self::$extension[$type];
        //文件名
         $fileName=$name.$extName;
 
         //输出图片
        $outPic=self::$outImg[$type];
        $outPic($dst,"$dir"."$fileName");
        return $fileName;
    }
}
