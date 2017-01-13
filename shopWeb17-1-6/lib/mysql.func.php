<?php 
/**
 * 连接数据库
 * @return resource
 */

// function connect(){
// 	$link=mysql_connect(DB_HOST,DB_USER,DB_PWD) or die("数据库连接失败Error:".mysql_errno().":".mysql_error());
// 	mysql_set_charset(DB_CHARSET);
// 	mysql_select_db(DB_DBNAME) or die("指定数据库打开失败");
// 	return $link;
// }
function connect()
{
  $link = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_DBNAME);
  mysqli_set_charset($link, DB_CHARSET);
//  检测连接
  if ($link->connect_error) {
    die("连接失败：" . $link->connect_error);
  }
  return $link;
}

/**
 * 完成记录插入的操作
 * @param string $table
 * @param array $array
 * @return number
 */

// function insert($table,$array){
// 	$keys=join(",",array_keys($array));
// 	$vals="'".join("','",array_values($array))."'";
// 	$sql="insert {$table}($keys) values({$vals})";
// 	mysql_query($sql);
// 	return mysql_insert_id();
// }
	function insert($table,$array){
	$conn=connect();
	$keys=join(",",array_keys($array));
	$vals = "'" . join("','", array_values($array)) . "'";
	$sql="INSERT INTO {$table} ({$keys})VALUES ({$vals})";
	//  mysqli_query($sql);
	//  return mysqli_insert_id();
    if ($conn->query($sql) === true) {
	//    echo "数据插入成功";
    return true;
  	} else {
    	echo "Error:" . $sql . "<br>" . $conn->error;
    	return $sql;
  }
}


//update imooc_admin set username='king' where id=1
/**
 * 记录的更新操作
 * @param string $table
 * @param array $array
 * @param string $where
 * @return number
 */
// function update($table,$array,$where=null){
// 	foreach($array as $key=>$val){
// 		if($str==null){
// 			$sep="";
// 		}else{
// 			$sep=",";
// 		}
// 		$str.=$sep.$key."='".$val."'";
// 	}
// 		$sql="UPDATE {$table} SET {$str} ".($where==null?null:" where ".$where);
// 		$result=mysql_query($sql);
// 		//var_dump($result);
// 		//var_dump(mysql_affected_rows());exit;
// 		if($result){
// 			return mysql_affected_rows();
// 		}else{
// 			return false;
// 		}
// }
function update($table, $array, $where = null)
{
  $str = "";
  foreach ($array as $key => $val) { //$key即为要修改的值
    if ($str == null) {
      $sep = "";
    } else {
      $sep = ",";
    }
    $str .= $sep . $key . "='" . $val . "'";
//    echo $cName . "<br/>";
  }
  $sql = "update {$table} set {$str} " . ($where == null ? null : " where " . $where);
//  echo $sql . "<br/>";
  $result = mysqli_query(connect(), $sql);
  return $result; //存在的问题，没有阻止更新到一个数据库中已经存在的值
}

/**
 *	删除记录
 * @param string $table
 * @param string $where
 * @return number
 */
// function delete($table,$where=null){
// 	$where=$where==null?null:" where ".$where;
// 	$sql="delete from {$table} {$where}";
// 	mysql_query($sql);
// 	return mysql_affected_rows();
// }
function delete($table, $where = null)
{
  mysqli_set_charset(connect(), 'utf8');
  mysqli_select_db(connect(), "$table");
  $where = ($where == null ? null : " where " . $where);
  $sql = "DELETE FROM $table {$where}";
  $res = mysqli_query(connect(), $sql);
  return $res;
}


/**
 *得到指定一条记录
 * @param string $sql
 * @param string $result_type
 * @return multitype:
 */
// function fetchOne($sql,$result_type=MYSQL_ASSOC){
// 	@$result=mysql_query($sql);
// 	@$row=mysql_fetch_array($result,$result_type);
// 	return $row;
// }
function fetchOne($sql,$result_type=MYSQLI_ASSOC)
{
	$result = mysqli_query(connect(),$sql);
   if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {	
      return $row;
    }
  } else {
    echo "未查询到数据";
  }
  }
/**
 * 得到结果集中所有记录 ...
 * @param string $sql
 * @param string $result_type
 * @return multitype:
 */
// function fetchAll($sql,$result_type=MYSQL_ASSOC){
// 	$result=mysql_query($sql);
// 	while(@$row=mysql_fetch_array($result,$result_type)){
// 		$rows[]=$row;
// 	}
// 	return $rows;
// }
function fetchAll($sql, $result_type = MYSQLI_ASSOC)
{
//  $result = mysqli_query($sql);
//  while (@$row = mysqli_fetch_array($result, $result_type)) {
//    $rows[] = $row;
//  }
//  return $rows;
  $conn = connect();
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    //输出每行数据
    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
  } else {
    echo "未查询到结果";
  }
  return $rows;
}

/**
 * 得到结果集中的记录条数
 * @param unknown_type $sql
 * @return number
 */
// function getResultNum($sql){
// 	$result=mysql_query($sql);
// 	return mysql_num_rows($result);
// }
function getResultNum($sql)
{
//  $result = mysqli_query($sql);
//  return mysql_num_rows($result);
  $conn = connect();
  $result = $conn->query($sql);
  $totalRows = $result->num_rows;
  return $totalRows;
}
/**
 * 得到上一步插入记录的ID号
 * @return number
 */
function getInsertId(){
	return mysql_insert_id();
}

