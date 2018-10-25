<?php

/**
 * Created by PhpStorm.
 * Author: Ren zhi yin
 * Date: 2018/10/22 0022
 * Time: 上午 9:29
 */
class CategoryController extends Controller{
    //分类显示方法
    public function listAction(){
        //实例化商品分类模型
        $cateModel = new CategoryModel();
        $rows = $cateModel->getCategory();
        require CURRENT_VIEW_PATH."/Category/list.html";
    }

    //添加分类方法
    public function addCateAction(){
        //实例化分类模型
        $cateModel = new CategoryModel();
        $rows = $cateModel->getCategory();
        require CURRENT_VIEW_PATH."/Category/add.html";
    }

    //添加插入分类数据方法
    public function insertAction(){
        $data = $_POST;
        //实例化分类模型
        $cateModel = new CategoryModel();
        $result = $cateModel->insertCate($data);
        if($result){
            static::jump("index.php?p=Admin&c=Category&a=list",3,"插入分类成功！");
        }else{
            static::jump("index.php?p=Admin&c=Category&a=addCate",3,"操作失败！检查分类重名或者分类名为空！");
        }
    }

    //修改分类数据的方法
    public function editAction(){
        $id = $_GET['id'];
        //获取当前id对应的数据
        $cateModel = new CategoryModel();
        $data = $cateModel->getOne($id);

        //获取所有分类的数据
        $rows = $cateModel->getCateName($id);
        //将数据绑定到编辑页面
        require CURRENT_VIEW_PATH."/Category/edit.html";
    }

    //修改方法
    public function updateAction(){
        $data = $_POST;
        //实例化分类模型
        $cateModel = new CategoryModel();
        $res = $cateModel->updateCate($data);
        if($res){
            static::jump("index.php?p=Admin&c=Category&a=list",3,"修改分类成功！");
        }else{
            static::jump("index.php?p=Admin&c=Category&a=edit&id=".$data['id']."",3,"修改分类失败！考虑重名或者为空");
        }
    }

    //删除分类方法
    public function deleteAction(){
        $id = $_GET['id'];
        //实例化分类模型
        $cateModel = new CategoryModel();
        //判断删除是否符合条件 将有子分类的不允许删除
        if($cateModel->del($id)){
            static::jump("index.php?p=Admin&c=Category&a=list",3,"删除分类成功！");
        }else{
            static::jump("index.php?p=Admin&c=Category&a=list",3,"当前分类下还有子分类，请删除后再试！");
        }
    }

}