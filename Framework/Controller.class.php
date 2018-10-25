<?php
class Controller {
    //设计静态跳转方法
    public static function jump($url,$time=0,$msg=""){
        //检测该用什么方式进行跳转  服务器是否允许跳转
        if(headers_sent()){            
            //使用客户端跳转
            if($time==0){
                echo "<script>location.href=$url</script>";
            }else{
                
                echo $msg;
                $time=$time*1000;
                echo "<script>setTimeout(function(){location.href='$url'},$time)</script>";
            }
        }else{
            //使用服务器端跳转
            if($time==0){
                header("location:$url");
            }else{
                echo $msg;
                //服务器延时跳转
                header("refresh:$time;$url");
         
            }
        } 
        exit;       
    }
}
