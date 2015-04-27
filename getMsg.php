<?php   
//连接数据库   
header('Content-Type: text/xml');
error_reporting(E_ALL ^ E_DEPRECATED);
require_once("mysqldb.php");    
$con=Mysqldb::getINStance()->connect(); 
$id=$_GET['maxid'];
//echo $id;return;
$sql="SELECT * FROM chatinfo WHERE chat_id>'{$id}'";
mysql_query("SET NAMES 'utf8'");
$result=mysql_query($sql,$con);
$xml="<?xml version='1.0' encoding='UTF-8'?>\n";  
$xml=$xml."<response>\n";
while($row = mysql_fetch_array($result))
 {
 	$xml=$xml."<msg>\n";
 	$xml=$xml."<chatid>".$row['chat_id']."</chatid>\n";
 	$xml=$xml."<user>".$row['spk_name']."</user>\n";
 	$xml=$xml."<ip>".$row['IP']."</ip>\n";
 	$xml=$xml."<content>".$row['content']."</content>\n";
 	$xml=$xml."<createtime>".$row['createtime']."</createtime>\n";
 	$xml=$xml."</msg>\n";
 }
$xml=$xml."</response>";
echo $xml;
?> 