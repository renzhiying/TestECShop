<?php
//创建验证码通用工具类
class CaptchaTool{
	//产生验证码字符串
	private static function makeCode($size=4){
		//验证码原始字符串
		$str = "1234567890QWERTYUIOPASDFGHJKLZXCVBNM";
		//打乱字符串
		$str = str_shuffle($str);
		//产生验证码 字串
		return substr($str,0,$size);
	}
	//绘制验证码
	public static function draw(){
		//创建一个真彩色的画布
		// $img=imagecreatetruecolor(300, 100);
		//产生随机数
		$i=rand(1,5);
		$img=imagecreatefromjpeg("./Public/Captcha/captcha_bg$i.jpg");
		//设定一个颜色
		$color2=imagecolorallocate($img, 255, 255, 255);
		//为画布设定边框
		imagerectangle($img, 0, 0, 144, 19, $color2);
		//数组 保存0，255
        $colorArr=[0,255];
        $bgColor=$colorArr[rand(0, 1)];//取得0 或255的一个值
        //设定一个颜色
        $color=imagecolorallocate($img,$bgColor,$bgColor,$bgColor);
        //  绘制炸点
          for($j=0;$j<100;$j++){
              $color1=  imagecolorallocate($img, rand(0,255), rand(0,255), rand(0,255));
              //绘制炸点
              imagesetpixel( $img,  rand(0, 144) ,rand(0,19), $color1);
          }
         //绘制5条干扰线
          for($k=0;$k<8;$k++){
              $color3=  imagecolorallocate($img, rand(0,255), rand(0,255), rand(0,255));
              imageline($img, rand(0, 145), rand(0,20), rand(0, 145), rand(0,20), $color3);
          }
          //取得验证码
           $code = self::makeCode();
           //保存在session
           new SessionTool();
           $_SESSION["code"]=$code;
           //绘制 文字
          imagestring($img, 5, 50, 3, $code, $color);
          //设定 网页的格式 为 图片 格式
          header("Content-type:image/gif");
          //绘制画布
          imagegif($img);
          //释放资源
          imagedestroy($img);
	}
	//制作验证码 校验
	public static function checkCode($code){
		//开启session
		new SessionTool();
		//判断$_SESSION["code"]是否存在
		if(isset($_SESSION["code"]))
			return strtolower($code)==strtolower($_SESSION["code"]);
		else
			return false;
	}
}