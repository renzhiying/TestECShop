<?php
class AdminController extends PlatformController{
	//  建立 登陆的界面
	public function loginAction(){
		//现在引入视图
		require CURRENT_VIEW_PATH."Admin/login.html";
	}
	//建立验证的方法
	public function checkAction(){
		//接收表单传递的数据
		$data = $_POST;
		//验证验证码是否正确
		if(!CaptchaTool::checkCode($data["captcha"])){
			static::jump("index.php?p=Admin&c=Admin&a=login",3,"验证码不正确！");
		}
		//读取数据
		$admin = new AdminModel();
		$row = $admin->check($data);
		// echo "检查成功";
		//如果能取得数据  记录下登陆的数据
		if($row){
			//正常登陆时  用session来标记  
			//开启session
			new SessionTool();
			//用session来记录登陆状态
			$_SESSION["isLogin"] = true;
			//$_SESSION["name"] = "renzhiying";
			//判定是否勾选记住登陆状态
			if(isset($data["remenber"])){
				//记录下id
				setcookie("id",$row["id"],time()+3600);
				//记录下用户名和密码
				setcookie("adminName",$row["adminName"],time()+3600);
				setcookie("adminPwd",$row["adminPwd"],time()+3600);
			}else{
				//记录id  就不再添加 保存时间了，浏览器关闭后
				//就直接销毁会话  下次还需要输入用户名和密码
				setcookie("id",$row["id"]);
				setcookie("adminName",$row["adminName"]);
				setcookie("adminPwd",$row["adminPwd"]);
			}
			static::jump("index.php?p=Admin&c=Main&a=index");
		}else{
			static::jump("index.php?p=Admin&c=Admin&a=login",3,"用户名或者密码错误");
		}
	}

	//注销方法
	public function logoutAction(){
		$_SESSION = [];
		if(isset($_COOKIE["id"])){
			setcookie("id","",time()-1);
		}
		if(isset($_COOKIE["adminName"])){
			setcookie("adminName","",time()-1);
		}
		if(isset($_COOKIE["adminPwd"])){
			setcookie("adminPwd","",time()-1);
		}
		session_destroy();
		static::jump("index.php?p=Admin&c=Admin&a=login",3,"注销成功");
	}


}


?>