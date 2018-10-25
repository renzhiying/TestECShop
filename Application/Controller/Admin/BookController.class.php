<?php

class BookController extends Controller {
    //添加一个读取数据的方法
    public function listAction(){
        //从model子类取得数据
        $book=new BookModel();
        $rows=$book->getList();
        //引入视图
        require CURRENT_VIEW_PATH."Book/list.html";
        
    }
    //添加删除方法
    public function delAction(){
        $id=$_GET["id"];
        //实例化model
        $book=new BookModel();
        $book->remove($id);
        //制作跳转
//        header("location:index.php?p=Admin&c=Book&a=list");
        static::jump("index.php?p=Admin&c=Book&a=list");
    }
}
