<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//设置此页面的过期时间(用格林威治时间表示)，只要是已经过去的日期即可。
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");

//设置此页面的最后更新日期(用格林威治时间表示)为当天，可以强制浏览器获取最新资料
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

//告诉客户端浏览器不使用缓存，HTTP 1.1 协议
header("Cache-Control: no-cache,no-store, must-revalidate");

//告诉客户端浏览器不使用缓存，兼容HTTP 1.0 协议
header("Pragma: no-cache");

// 应用入口文件a

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

//当前是后台系统，使用单模块即可
define('BIND_MODULE','Admin');
define('ROOT_PATH',__DIR__.'/');
// 定义应用目录
define('APP_PATH',ROOT_PATH.'/Application/');

// 引入ThinkPHP入口文件
require dirname(ROOT_PATH).'/ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单