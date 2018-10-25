<?php
//引入Model父类
//require "./Framework/Model.class.php";
class UserModel extends Model{
    // 添加读取所有数据的方法法
    public function getList(){
//        //引入db类
//        require './Framework/Tool/DB.class.php';
//        //取得db类事例
//        $db=DB::getInstance();
        //构建sql语句
//         $sql="select * from User";
         //使用db事例 读取所有数据
         return $this->getAll();
    }
    //删除数据的方法
    public function remove($id){
//        引入db类
//   实例化db
   //引入db类
//        require './Framework/Tool/DB.class.php';
//        //取得db类事例
//        $db=DB::getInstance();
//   构建sql语句
//     $sql="delete from User where id=$id";
//   调用方法删除数据 按照编号进行删除
     return $this->deleteRowByPk($id);
    }
    //添加插入数据
    public function insertData($data){
//        $userName=$data["userName"];
//        $userPwd=$data["userPwd"];
//        //构造sql语句 
//        $sql="insert into User set userName='$userName',userPwd='$userPwd'";
        // 执行插入语句
        return $this->insert($data);
    }
    // 读取一条数据
     public function getRow($id){
//         构建sql、
//          $sql="select * from User where id=$id";
          return $this->getRowByPk($id);
     }
          
//     修改数据
     public function updateData($data){
//         $id=$data["id"];
//         $userName=$data["userName"];
//         $userPwd=$data["userPwd"];
//         //构建sql
//          $sql="update User set userName='$userName',userPwd='$userPwd' where id=$id";
          return  $this->updateByPk($data);
         
     }
}
