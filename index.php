<?php
////设置编码
header("Content-type:text/html;charset=utf-8");
//引入框架基础类
require './Framework/Frame.class.php';
//调用run方法 static 只能在类中 或 子类中调用静态方法
Frame::run();

