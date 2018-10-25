<?php
class Frame {
    //定义运行方法 run
    public static function run(){
        self::initPath();
        self::initConfig();
        
        //注册一个自己的方法 替代 __autoload
        spl_autoload_register("self::autoLoad");
        self::initParam();
    }
    //定义路径常量的方法
    public static function initPath(){
        //定义路径常量
        //脚本程序所在路径
         //获取分隔符常量；
        // echo DIRECTORY_SEPARATOR; exit;
        defined("DS") or define("DS",  DIRECTORY_SEPARATOR);
        $str=$_SERVER["SCRIPT_FILENAME"];
        //获取所在的文件夹
        $str=  dirname($str);
         //定义站定所在路径常量
         defined("ROOT_PATH") or define("ROOT_PATH",  $str.DS);

        //定义应用程序路劲
        defined("APPLICATION_PATH") or define("APPLICATION_PATH",  ROOT_PATH."Application".DS);
        //定义controller常量
        defined("CONTROLLER_PATH") or define("CONTROLLER_PATH",  APPLICATION_PATH."Controller".DS);
        //定义model常量
         defined("MODEL_PATH") or define("MODEL_PATH",  APPLICATION_PATH."Model".DS);
        //定义视图view常量
         defined("VIEW_PATH") or define("VIEW_PATH",  APPLICATION_PATH."View".DS);
        //定义框架
         defined("FRAME_PATH") or define("FRAME_PATH",  ROOT_PATH."Framework".DS);
        // 定义工具类路径
         defined("TOOL_PATH") or define("TOOL_PATH",  FRAME_PATH."Tool".DS);
    }
    //设置配置文件的方法
     public static function initConfig(){
         //引入配置文件的页面
         $GLOBALS["config"]=require './Application/Config/myshop.config.php';         
     }
//     设置平台参数的方法 initParam()
     public static  function initParam(){
         //获取平台 控制 方法的三个参数
        $p=  isset($_GET["p"])?$_GET["p"]:$GLOBALS["config"]["app"]["p"];
        $c=isset($_GET["c"])?$_GET["c"]:$GLOBALS["config"]["app"]["c"];
        $a=isset($_GET["a"])?$_GET["a"]:$GLOBALS["config"]["app"]["a"];
          // 定义 当前所指向的平台路径
        defined("CURRENT_CONTROLLER_PATH") or define("CURRENT_CONTROLLER_PATH",  CONTROLLER_PATH.$p.DS);
         // 定义 当前所指向的视图平台路径
         defined("CURRENT_VIEW_PATH") or define("CURRENT_VIEW_PATH",  VIEW_PATH.$p.DS);
         $controllerName=$c."Controller";
         defined("CONTROLLER_NAME") or define("CONTROLLER_NAME",$controllerName);
        //设定一个方法名称
         $actionName=$a."Action";
         defined("ACTION_NAME") or define("ACTION_NAME",$actionName);
        //引入控制器
      //  require CURRENT_CONTROLLER_PATH."$controllerName.class.php";
        //事例化 控制器
        $obj=new $controllerName();
        //调用方法
        $obj->$actionName();
     }
//     制作自动加载的方法 autoLoad()
      public static function autoLoad($className){
            //声明一个数组 保存特殊路径
        $mapping=[
            "Model"=>FRAME_PATH.$className.".class.php",
            "DB"=>TOOL_PATH.$className.".class.php",
            "Controller"=>FRAME_PATH.$className.".class.php"          
        ];
        //判定当前的类名 和 特殊的类名是否相等
        if(isset($mapping[$className])){
            require $mapping[$className];
        }elseif(substr($className,-10)=="Controller"){
            //判定类名 以Controller结尾类名 认为是当前控制器 
            //引入控制器
            require CURRENT_CONTROLLER_PATH.$className.".class.php";
        }elseif(substr($className,-5)=="Model"){
            //引入model子类
            require MODEL_PATH.$className.".class.php";
        }elseif(substr($className,-4)=="Tool"){
            require TOOL_PATH.$className.".class.php";
        }
      }
    
}
