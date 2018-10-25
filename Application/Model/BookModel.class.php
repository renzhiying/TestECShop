<?php

class BookModel extends Model{
    //添加一个getList方法
    public function getList(){
        //构建sql语句
//        $sql="select * from Book";
        //执行sql语句
        return $this->getAll();
    }
    //制作删除方法
    public function remove($id){
        //构建sql语句
        $sql="delete from Book where id=$id";
        //执行sql语句
        return $this->db->query($sql);
    }
            
}
