<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessionTool
 *
 * @author admin
 */
class SessionTool{
    public function __construct() {
//        session_set_save_handler($open, $close, $read, $write, $destroy, $gc)
        // 重写session的规则
         session_set_save_handler(
                 array($this,"open"),
                 array($this,"close"),
                 array($this,"read"),
                 array($this,"write"),
                 array($this,"destroy"),
                 array($this,"gc")
           );
           session_start();
    }
    public function open($path,$name){
    //    echo "open";
        //设定数据库的连接
//        require './DB.class.php';
        $GLOBALS["db"]=DB::getInstance($GLOBALS["config"]["db"]); 
    }
    //关闭
   public function close(){
    //    echo "close";
       
    }
    //读取
   public function read($sessId){
    //    echo "read";
    //      读取数据
    //    创建sql
        $sql="select * from `session` where sessid='$sessId'";
        //读取数据
        $row=$GLOBALS["db"]->fetchRow($sql);
        //返回读取的数据
        if($row){
            return $row["sessData"];
        }
    }
    //写入
   public function write($sessId,$sessData){
    //    echo "write";
    //    插入数据
        $sql="insert into `session` set sessid='$sessId',sessData='$sessData',lifeTime=unix_timestamp() on duplicate key update sessData='$sessData',lifeTime=unix_timestamp()";
    //  echo $sql;

    //执行语句
         $GLOBALS["db"]->query($sql);
    }
    //销毁
     public function destroy($sessId){
    //     echo "destory";
    //     删除数据
         $sql="delete from `session` where sessId='$sessId'";
          $GLOBALS["db"]->query($sql);
     }
    // 自动销毁
    public function gc($lifeTime){
    //     echo "gc";
         //删除过期的数据
          $sql="delete from `session` where lifeTime+$lifeTime<unix_timestamp()";
         $GLOBALS["db"]->query($sql); 
     }
}
