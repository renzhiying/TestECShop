<?php
/**
 * Created by PhpStorm.
 * Author: Ren zhi yin
 * Date: 2018/10/22 0022
 * Time: 下午 9:47
 */
class GoodsController extends Controller{
    //显示商品列表
    public function listAction(){
        //获取分类数据，绑定在搜索下拉框
        $cateModel = new CategoryModel();
        $tree = $cateModel->getCategory();

        /*$goodsModel = new GoodsModel();
        $rows = $goodsModel->getGoodsList();*/

        //为分页而准备的
        //设置每页显示的数据条数
        $pageSize=isset($_GET["pageSize"])?$_GET["pageSize"]:8;
        //获取当前页码
        $page=isset($_GET["page"])?$_GET["page"]:1;
        $goods=new GoodsModel();
        //获取总页数
        $count=$goods->getRecordsCount();
        $pageTool=  PageTool::fpage("index.php?a=list&c=Goods&p=Admin", $pageSize,$count,$page);
        //获取所有数据
        //搜索的where条件
        $where = "";
        $rows=$goods->getList($page,$pageSize,"*",$where);

        require CURRENT_VIEW_PATH."/Goods/list.html";
    }

    //添加商品
    public function addAction(){
        $cateModel = new CategoryModel();
        $rows = $cateModel->getCategory();
        require CURRENT_VIEW_PATH."/Goods/add.html";
    }

    //插入商品数据
    public function insertAction(){
        //$con = mysqli_connect("127.0.0.1","root","123","testMvc");
        $data = $_POST;

        //获取单个上传文件的名称 便于保存到数据库
        $file = $_FILES["upload1"];
        $upload = new UploadFileTool();
        $goodsPic = $upload->upload($file);
        if(!$goodsPic){
            static::jump("index.php?p=Admin&c=Goods&a=add",3,$upload->error);
        }

        //如果勾选自动生成缩略图
        if(isset($data["auto_thumb"])){
            //调用缩略图工具类
            $fileName = ThumbTool::drawImg("./Public/upload/$goodsPic",200,200);
            $data["goodsThumb"] = $fileName;
        }

        $data["goodsPic"] = $goodsPic;
        $goodsModel = new GoodsModel();

        //实例化相册模型
        $photoModel = new PhotoModel();

        //上传多个图片
        $fileArr = $_FILES["img_url"];
        $url_arr = $upload->multiUpload($fileArr);
        $photo = [];

        if($goodsModel->insertOne($data)){

            //获得刚插入商品信息的goodsId
            //$goodsId = mysqli_insert_id($con);

            //将上传文件后的新文件名放到要保存的数组中去
            foreach($url_arr as $key=>$val){
                $photo[$key]["photoName"] = $val;
            }

            //将图片描述放到要保存的数组中去
            foreach($data["img_desc"] as $key=>$val1){
                $photo[$key]["photoIntro"] = $val1;
            }
            //将图片链接放到要保存的数组中去
            foreach($data["img_file"] as $key=>$val2){
                $photo[$key]["photoLink"] = $val2;
                //$photo[$key]["goodsId"] = $goodsId;
            }
            //循环插入相册数据
            foreach($photo as $val3){
                if(!$photoModel->insertPhoto($val3)){
                    static::jump("index.php?p=Admin&c=Goods&a=add",3,"插入相册数据失败！");
                }
            }
            static::jump("index.php?p=Admin&c=Goods&a=list",3,"插入数据成功！");
        }else{
            static::jump("index.php?p=Admin&c=Goods&a=add",3,"插入数据失败！");
        }
    }
}