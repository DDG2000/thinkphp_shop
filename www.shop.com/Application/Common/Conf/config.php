<?php
define('DOMAIN', 'http://www.shop.com');  //定义根目录
return array(
    //'配置项'=>'配置值'
    'DEFAULT_MODULE' => 'Home',  // 默认模块
    'DEFAULT_CONTROLLER' => 'Member', // 默认控制器名称
    'DEFAULT_ACTION' => 'register', // 默认操作名称

    'DB_TYPE' => 'mysql',     // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'mall',          // 数据库名
    'DB_USER' => 'root',      // 用户名
    'DB_PWD' => '123456',          // 密码
    'DB_PORT' => '3306',        // 端口
    'DB_PREFIX' => '',    // 数据库表前缀
    'DB_PARAMS' => array(), // 数据库连接参数
    'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE' => false,        // 启用字段缓存
    'DB_CHARSET' => 'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE' => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE' => false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM' => 1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO' => '', // 指定从服务器序号
    'SHOW_PAGE_TRACE' => true,
    'URL_MODEL' => 1,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    'TMPL_PARSE_STRING' => array(
        '__CSS__' => DOMAIN . '/Public/CSS',
        '__JS__' => DOMAIN . '/Public/JS',
        '__IMG__' => DOMAIN . '/Public/IMG',
        '__HTTP__' => 'http://',
        '__UPLOAD_URL__' => DOMAIN . '/Uploads',    //上传文件的保存位置
        '__UPLOADIFY__' => DOMAIN . '/Public/EXT/uploadify',  //uploadifu插件路径
        '__LAYER__' => DOMAIN . '/Public/EXT/layer',  //layer插件路径
        '__ZTREE__' => DOMAIN . '/Public/EXT/ztree',  //ztree插件路径
        '__TREEGRID__' => DOMAIN . '/Public/EXT/treegrid',  //ztree插件路径
        '__UEDITOR__' => DOMAIN . '/Public/EXT/ueditor',  //ueditor插件路径
        '__JQUERY_VALIDATION__' => DOMAIN . '/Public/EXT/jquery_validation/dist',   //jquery_validation插件路径
    ),
);