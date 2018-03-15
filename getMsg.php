<?php   
//连接数据库   
error_reporting(E_ALL ^ E_DEPRECATED);
require_once("model/mysqldb.php");

$id=$_GET['maxid'];
$con=Mysqldb::getINStance()->connect();
$sql="SELECT * FROM chatinfo WHERE chat_id>'{$id}'";
$con->query("\"SET NAMES 'utf8'\"");
$result=$con->query($sql);

while($row = $result->fetch_assoc())
 {
 	$response [] = (object)[
 		'chat_id' => $row['chat_id'],
        'user_id' => $row['user_id'],
		'IP' => $row['IP'],
		'content' => $row['content'],
		'createtime' => $row['createtime']
	];
 }
 echo json_encode($response);
?>