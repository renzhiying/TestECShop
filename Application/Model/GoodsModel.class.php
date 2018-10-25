<?php
/**
 * Created by PhpStorm.
 * Author: Ren zhi yin
 * Date: 2018/10/22 0022
 * Time: 下午 9:46
 */
class GoodsModel extends Model{
    //从数据库中拿到所有商品的数据
    public function getGoodsList(){
        return $this->getAll();
    }

    //获取分页后的每页列表
    public function getList($page,$pageSize,$fields,$where){
        return $this->getPage($page,$pageSize,$fields,$where);
    }

    //获取总条数
    public function getRecordsCount(){
        return $this->getCount();
    }

    //插入数据
    public function insertOne($data){
        if(!isset($data["goodsName"])||empty($data["goodsName"])){
            return false;
        }else{
            //遍历$data["goodsStatus"]
            $status = 0;
            if(isset($data["goodsStatus"])){
                foreach($data["goodsStatus"] as $val){
                    $status = $status+$val;
                }
                $data["goodsStatus"]=$status;
            }
            return $this->insert($data);
        }
    }
}