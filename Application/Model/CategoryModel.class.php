<?php

/**
 * Created by PhpStorm.
 * Author: Ren zhi yin
 * Date: 2018/10/22 0022
 * Time: 上午 9:44
 */
class CategoryModel extends Model{
    //获取所有商品分类的方法
    public function getCategory(){
        $row = $this->getAll();
        return $this->getTree($row);
    }

    //对数据进行处理
    public function getTree($data,$parentId=0,$deep=0){
        //静态变量保存所有执行完毕的数据
         static $arr = array();
        //对数组进行遍历
        foreach($data as $row){
            if($row["parentId"] == $parentId){
                $row["deep"] = $deep;
                $row["nbsp"] = str_repeat("&nbsp;",$deep*8);
                $row["fields"] = str_repeat("&nbsp;",$deep*8).$row["cateName"];
                $arr[] = $row;
                //递归找寻以自己id为父类id的子类
                $this->getTree($data,$row['id'],$deep+1);
            }
        }
        return $arr;

    }

    //对数据进行处理
    public function getTree1($data,$id,$parentId=0,$deep=0){
        //静态变量保存所有执行完毕的数据
        static $arr = array();
        //对数组进行遍历
        foreach($data as $row){
            if(($row["id"]!=$id)&&($row["parentId"]!=$id)&&($row["parentId"] == $parentId)){
                $row["deep"] = $deep;
                $row["nbsp"] = str_repeat("&nbsp;",$deep*8);
                $row["fields"] = str_repeat("&nbsp;",$deep*8).$row["cateName"];
                $arr[] = $row;
                //递归找寻以自己id为父类id的子类
                $this->getTree1($data,$id,$row['id'],$deep+1);
            }
        }
        return $arr;

    }

    //获取除去自身及其子类数据的分类
    public function getCateName($id){
        $data = $this->getAll();
        $tree = $this->getTree1($data,$id);
        return $tree;
    }

    //插入分类数据的实现方法
    public function insertCate($data){
        if(!isset($data["cateName"])||empty($data["cateName"])){
            return false;
        }else{
            $list = $this->getCategory();
            foreach($list as $row){
                if($row["cateName"] == $data["cateName"]){
                    return false;
                }
            }
            return $this->insert($data);
        }
    }

    //查找一条数据的方法
    public function getOne($id){
        return $this->getRowByPk($id);
    }

    //修改分类的方法
    public function updateCate($data){
        if(!isset($data["cateName"])||empty($data["cateName"])){
            return false;
        }else{
            $list = $this->getAll();
            foreach($list as $row){
                if($row["cateName"] == $data["cateName"] && $row["id"]==$data["id"]){
                    return false;
                }
            }
            return $this->updateByPk($data);
        }
    }

    //删除分类的方法
    public function del($id){
        //获取所有父类id信息
        $arr = [];
        $rows = $this->getCategory();
        //将所有的父类ID组成一个去重后的数组
        foreach($rows as $row){
            $arr[] = $row['parentId'];
        }
        $arr_parent = array_unique($arr);

        if(!in_array($id,$arr_parent)){
            return $this->deleteRowByPk($id);
        }else{
            return false;
        }
    }

}