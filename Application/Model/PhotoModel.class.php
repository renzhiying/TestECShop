<?php

/**
 * Created by PhpStorm.
 * Author: Ren zhi yin
 * Date: 2018/10/24 0024
 * Time: 下午 2:38
 */
class PhotoModel extends Model{
    public function insertPhoto($data){
        return $this->insert($data);
    }
}