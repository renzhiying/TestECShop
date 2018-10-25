<?php

class PlatformController extends Controller{
    //在构造函数中  验证 session为true 不再进行验证  验证cookie 不存在 或者是 没有读取到数据 读取到数据
//    和cookie中的数据都跳转到登录界面
       public function __construct() {
           //排除  后台的登录不验证  检查用户不验证
           if(CONTROLLER_NAME=="AdminController"&&ACTION_NAME=="loginAction"){
               return;
           }
            if(CONTROLLER_NAME=="AdminController"&&ACTION_NAME=="checkAction"){
               return;
           }
//            验证 session为true 不再进行验证
           new SessionTool();
           if(isset($_SESSION["isLogin"])&&$_SESSION["isLogin"]==true){
               return;
           }
//            验证cookie 不存在
           if(!isset($_COOKIE["id"])||!isset($_COOKIE["adminName"])||!isset($_COOKIE["adminPwd"])){
                 static::jump ("index.php?p=Admin&c=Admin&a=login",3,"你不能强制进入后台");
            }else{
                //通过id读取一条数据
                 $admin=new AdminModel();
                 $row=$admin->getOnce($_COOKIE["id"]);    
//                  没有读取到数据 读取到数据
//                  和cookie中的数据都跳转到登录界面
                 if(!$row||$row["adminName"]!=$_COOKIE["adminName"]||$row["adminPwd"]!=$_COOKIE["adminPwd"]){
                    static::jump ("index.php?p=Admin&c=Admin&a=login",3,"你不能强制进入后台");
                 }  
            }
       }
 
    
}
