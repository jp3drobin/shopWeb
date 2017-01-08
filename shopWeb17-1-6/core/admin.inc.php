<?php 
/**
 * 检查管理员是否存在
 * @param unknown_type $sql
 * @return Ambigous <multitype:, multitype:>
 */
//封装一个验证账户登录的函数
function checkAdmin($sql)
{
  return fetchOne($sql); //该方法定义在文件 mysql.func.php 中(基本的数据库操作方法文件)
}
/**
 * 检测是否有管理员登陆.
 */
function checkLogined(){
	if(@$_SESSION['adminId']==""&&@$_COOKIE['adminId']==""){
		alertMes("请先登陆","login.php");
	}
}
/**
 * 注销管理员
 */
function logout(){
	$_SESSION=array();
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(),"",time()-1);
	}
	if(isset($_COOKIE['adminId'])){
		setcookie("adminId","",time()-1);
	}
	if(isset($_COOKIE['adminName'])){
		setcookie("adminName","",time()-1);
	}
	session_destroy();
	header("location:login.php");
}