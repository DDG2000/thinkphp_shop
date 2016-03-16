<?php
define('DOMAIN', 'http://admin.shop.com');  //定义根目录
return array(
    //'配置项'=>'配置值'
    'DEFAULT_MODULE' => 'Admin',  // 默认模块
    'DEFAULT_CONTROLLER' => 'Menu', // 默认控制器名称
    'DEFAULT_ACTION' => 'index', // 默认操作名称

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
    'PAGE_SIZE' => 3,
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
    ),
    'PAGE_SIZE' => 3,
    'UPLOAD_SETTING' => array(
//        'mimes' => array('image/jpeg', 'image/png', 'image/gif'), //允许上传的文件MiMe类型
        'maxSize' => 2 * 1024 * 1024, //上传的文件大小限制 (0-不做限制)
        'exts' => array('jpg', 'jpeg', 'gif', 'png'), //允许上传的文件后缀
        'autoSub' => true, //自动子目录保存文件
        'subName' => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt' => '', //文件保存后缀，空则使用原后缀
        'replace' => false, //存在同名是否覆盖
        'hash' => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调，如果存在返回文件信息数组
        'driver' => 'Qiniu', // 文件上传驱动
        'driverConfig' => array(
            'secrectKey' => 'ffgyN4DpQ41-kZdCP4mftojZ4jLUiPzdYrdBqxFz', //七牛服务器
            'accessKey' => 'e_f3x1V0KDnX5xvHsJLaccsu2ztlGa0jRtmm0B47', //七牛用户
            'domain' => '7xrolb.com1.z0.glb.clouddn.com', //七牛域名
            'bucket' => 'test', //空间名称
            'timeout' => 300, //超时时间
        ),
    ),
    );