<?php   
//连接数据库
session_start();
$username=$_GET['username'];  
error_reporting(E_ALL ^ E_DEPRECATED);
require_once("model/mysqldb.php");
$con=Mysqldb::getINStance()->connect(); 
$sql="SELECT * FROM usersonline WHERE username='{$username}'";
$con->query("SET NAMES 'utf8'");
$result=$con->query($sql);
if($result->num_rows){
	$sql="UPDATE usersonline SET lasttime=now() WHERE theip='{$_SERVER['REMOTE_ADDR']}' AND username='{$username}'";
	$con->query($sql);
}else{
	$sql="INSERT INTO usersonline(username,theip,lasttime) VALUES('{$username}','{$_SERVER['REMOTE_ADDR']}',now())";
    $con->query($sql);
}
$sql="DELETE FROM usersonline WHERE TIME_TO_SEC(now())-TIME_TO_SEC(lastTime)>10";
$con->query($sql);
ob_clean();
$sql="SELECT * FROM usersonline";
$result=$con->query($sql);

while($row = $result->fetch_assoc())
 {
 	$response [] = (object) [
 		'id' => $row['id'],
		'username' => $row['username'],
		'theip' => $row['theip'],
		'lasttime' => $row['lasttime']

	];
 }

 echo json_encode($response);

?> 