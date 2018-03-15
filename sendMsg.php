<?php   
//连接数据库   
error_reporting(E_ALL ^ E_DEPRECATED);
require_once("model/mysqldb.php");
$con=Mysqldb::getINStance()->connect(); 
$datetime=date('Y-M-D H:i:s',time());
$sql="INSERT INTO chatinfo(user_id,IP,content,createtime)   
                 VALUES('{$_GET['userId']}','{$_SERVER['REMOTE_ADDR']}','{$_GET['msg']}','{$datetime}')";
//执行插入语句   
$con->query("SET NAMES 'utf8'");
$result = $con->query($sql);
echo 'success';
 ?> 