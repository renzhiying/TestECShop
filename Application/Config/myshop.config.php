﻿<?php
return [
    //数据库配置信息
    "db"=>[
        "host"=>"127.0.0.1",
        "user"=>"root",
        "password"=>"123",
        "port"=>3306,
        "charset"=>"utf8",
        "dbName"=>"testMvc"
    ],
    //应用程序入口配置信息
    "app"=>[
        "p"=>"Admin",
        "c"=>"Admin",
        "a"=>"login"
    ],
    //文件上传配置信息
    "upload"=>[
        "dir"=>"./Public/upload/",
        "size"=>2*1024*1024,
        "type"=>["image/jpeg","image/png","image/gif"],
        "pre"=>"pic_"
    ],
    "thumb"=>[
        "dir"=>"./Public/upload/"
    ],
    "test"=>[
        "test_one"=>"one",
        "test_two"=>"two",
        "test_three"=>"three",
    ]
];
