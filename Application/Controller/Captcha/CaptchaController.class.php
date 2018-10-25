<?php
class CaptchaController{
	//建立方法输出验证码
	public function showAction(){
		ob_clean();
		CaptchaTool::Draw();
	}
}