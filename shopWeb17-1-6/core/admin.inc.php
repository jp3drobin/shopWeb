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
 * 添加管理员
 */
function addAdmin(){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
	if(insert("imooc_admin",$arr)){
		$mes="添加成功！<br/><a href='addAdmin.php'>继续添加</a>|<a href='listAdmin.php'>查看管理员列表</a>";
	}else{
		$mes="添加失败<br/><a href='addAdmin.php'>重新添加</a>";
			}
		return $mes;
}

/**
 * 得到管理员
 * @return array [<description>]
 */
function getAllAdmin(){
	$sql="select * from imooc_admin";
	$rows=fetchAll($sql);
	return $rows;
	
}

/**
 * 编辑管理员
 */
function editAdmin($id){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
	if(update("imooc_admin",$arr,"id={$id}")){
		$mes="编辑成功!<br/><a href ='listAdmin.php'>查看管理员列表</a>";
	}else{
		$mes="编辑失败<br/>！<a href='listAdmin.php'>重新修改</a>";
	}
	return $mes;
}

/**
 * 删除管理员
 */
function delAdmin($id){
	if(delete("imooc_admin","id={$id}")){
		$mes="删除成功！<br/><a href='listAdmin.php'>查看管理员列表</a>";
	}else{
		$mes="删除失败！<br/><a href='listAdmin.php'>请从新删除</a>";
	}
	return $mes;
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