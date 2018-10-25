<?php
class MainController extends PlatformController{
	//建立后台index方法
	public function indexAction(){
		// 引入视图
		 require CURRENT_VIEW_PATH."Main/show.html";
	}
	//添加top方法
    public function topAction(){
//        引入头部视图
        require CURRENT_VIEW_PATH."Main/top.html";
    }
    //添加left方法
    public function leftAction(){
//        引入头部视图
        require CURRENT_VIEW_PATH."Main/left.html";
    }
    //添加drag方法
    public function dragAction(){
//        引入头部视图
        require CURRENT_VIEW_PATH."Main/drag.html";
    }
    //添加right方法
    public function rightAction(){
//        引入头部视图
        require CURRENT_VIEW_PATH."Main/right.html";
    }





}
?>