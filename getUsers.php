<?php   
//连接数据库
session_start();
$username=$_GET['username'];  
header('Content-Type: text/xml');
error_reporting(E_ALL ^ E_DEPRECATED);
require_once("mysqldb.php");    
$con=Mysqldb::getINStance()->connect(); 
$sql="SELECT * FROM usersonline WHERE theip='{$_SERVER['REMOTE_ADDR']}' AND username='{$username}'";
mysql_query("SET NAMES 'utf8'");
$result=mysql_query($sql,$con);
if(mysql_num_rows($result)){
	$sql="UPDATE usersonline SET lasttime=now() WHERE theip='{$_SERVER['REMOTE_ADDR']}' AND username='{$username}'";
	mysql_query($sql,$con);
}else{
	$sql="INSERT INTO usersonline(username,theip,lasttime) VALUES('{$username}','{$_SERVER['REMOTE_ADDR']}',now())"; 
	mysql_query($sql,$con);
}
$sql="DELETE FROM usersonline WHERE TIME_TO_SEC(now())-TIME_TO_SEC(lastTime)>10"; 
mysql_query($sql,$con);
ob_clean();
$sql="SELECT * FROM usersonline";
$result=mysql_query($sql,$con);
$xml="<?xml version='1.0' encoding='UTF-8'?>\n";  
$xml=$xml."<users>\n";
while($row = mysql_fetch_array($result))
 {
 	$xml=$xml."<user>\n";
 	$xml=$xml."<username>".$row['username']."</username>\n";
 	$xml=$xml."<theip>".$row['theip']."</theip>\n";
 	$xml=$xml."<lasttime>".$row['lasttime']."</lasttime>\n";
 	$xml=$xml."</user>\n";
 }
$xml=$xml."</users>";
echo $xml;
?> 