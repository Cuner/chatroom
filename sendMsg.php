<?php   
//连接数据库   
error_reporting(E_ALL ^ E_DEPRECATED);
require_once("mysqldb.php");    
$con=Mysqldb::getINStance()->connect(); 
$datetime=date('Y-M-D H:i:s',time());
$sql="INSERT INTO chatinfo(spk_name,IP,content,createtime)   
                 VALUES('{$_GET['user']}','{$_SERVER['REMOTE_ADDR']}','{$_GET['msg']}','{$datetime}')";   
//执行插入语句   
//echo $sql;return;
mysql_query("SET NAMES 'utf8'");
mysql_query($sql,$con);   
 ?> 