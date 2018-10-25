<?php

class UserController extends Controller {
    // 添加读取所有数据的方法法
    public function listAction(){
        //引入userModel.class.php
       // require "./Application/Model/UserModel.class.php";
        //实例化model
         $user=new UserModel();
         //获取所有数据
         $rows=$user->getList();
//         var_dump($rows);
         //引入视图
         require CURRENT_VIEW_PATH."User/list.html";
    }
    
    //添加删除方法
    public function delAction(){
//        引入UserModel 事例化
       /// require "./Application/Model/UserModel.class.php";
        //实例化model
         $user=new UserModel();
//   读取传递编号
      $id=$_GET["id"];
//   事例model 调用方法 删除数据
       $user->remove($id);
//   跳转到list方法
//        header("location:index.php?p=Admin&c=User&a=list");
        static::jump("index.php?p=Admin&c=User&a=list",1,"翔少被 干掉了  ");
    }
    //添加一个录入数据的方法
     public function addAction(){
         //引入视图  制作表单
         require CURRENT_VIEW_PATH."User/add.html";
     }
     //插入数据的方法
     public function insertAction(){
         $data=$_POST;
         //实例化model
         $user=new UserModel();
        if($user->insertData($data))
         //跳转到列表也
             static::jump("index.php?p=Admin&c=User&a=list");
        else 
            static::jump("index.php?p=Admin&c=User&a=add",3,"录入失败");
     }
    //添加编辑方法
      public function editAction(){
          //获取编号
           $id=$_GET["id"];
           //读取一条数据
           //实例化model
            $user=new UserModel();
            $row=$user->getRow($id);
            //绑定视图数据
            require CURRENT_VIEW_PATH."User/edit.html";
      }
      //制作修改方法
      public function updateAction(){
          $data=$_POST;
          //实例化model
           $user=new UserModel();
           $user->updateData($data);
           //跳转到列表也
           static::jump("index.php?p=Admin&c=User&a=list");
      }
}
