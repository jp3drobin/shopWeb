<?php
header("content-type:text/html;charset=utf-8");
//date_default_timezone_set('PRC')设置中国时区
date_default_timezone_set("PRC");
session_start();
//dirname():这是一个PHP的内置函数，用于给出一个包含有指向一个文件的全路径的字符串，本函数返回去掉文件名后的目录名,__FILE__是一个预定义变量，返回的是文件所在的路径；
define("ROOT", dirname(__FILE__));  
//set_include_path() 函数可以在php程序中动态改变php的 include_path 参数，其参数是一个字符串，多个不同的目录可以串联在一起作为一个参数一起提交——不同的目录间使用目录分割符号分开，在类unix的系统中这个分隔符是“:”，在windows系统中这个分隔符是“;”，所以php提供一个常量 PATH_SEPARATOR 来表示当前系统中的这个分隔符。
set_include_path(".".PATH_SEPARATOR.ROOT."/lib".PATH_SEPARATOR.ROOT."/core".PATH_SEPARATOR.ROOT."/configs".PATH_SEPARATOR.get_include_path());
require_once 'mysql.func.php';
require_once 'image.func.php';
require_once 'common.func.php';
require_once 'string.func.php';
//require_once 'page.func.php';
require_once "configs.php";
require_once 'admin.inc.php';
//require_once 'cate.inc.php';
//require_once 'pro.inc.php';
//require_once 'album.inc.php';
//require_once 'upload.func.php';
//require_once 'user.inc.php';
//connect();
