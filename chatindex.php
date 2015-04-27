<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once("mysqldb.php");
$con=Mysqldb::getInstance()->connect();
$user="SELECT * FROM user WHERE username='{$_POST['username']}' AND password='{$_POST['password']}'";
//echo $user ;return;
$result=mysql_query($user,$con);
$row=mysql_fetch_array($result);
$name=$_POST['username'];
if($row){
  session_start();   
  if(!isset($_SESSION['user'])){
    $_SESSION['user']=$name;   
  }      
}else{
  echo "登录失败，请重新登录";
  echo "<meta http-equiv='refresh' content = '1,url=login.php'/>";
}
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">   
<html xmlns="http://www.w3.org/1999/xhtml">   
<head>   
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
<title>欢迎使用AJAX聊天室</title>   
<style>   
.content{   
height:300px;   
width:616px;   
font-size:14px;   
color:#666666;   
overflow:scroll;   
background-color:#FFFF99;   
  
}   
.sendtext{   
color: #009900;   
background-color:#CCFFCC;   
font-size:14px;   
}   
.users{   
width:170px;   
}   
.send{   
width:60px;   
height:50px;   
color:#0033CC;}   
</style>   
</head>   
  
<body>   
<table width="800" height="360" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#993399">   
  <tr>   
    <th width="616" height="31" bgcolor="#FFFFFF" scope="col">欢迎, <?php echo $name; ?> 进入聊天室   
    <input type="hidden" id="user" value="<?php echo $name; ?>" /></th>   
    <th width="184" rowspan="3" valign="middle" bgcolor="#FFFFFF" scope="col"><select id="userlist" class="users" size="27"><option>所有人</option></select></th>   
  </tr>   
  <tr>   
    <td bgcolor="#FFFFFF"><div id="content" class="content"></div></td>   
  </tr>   
  <tr>   
    <td bgcolor="#FFFFFF">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">   
      <tr>    
        <td width="15%" align="right"><strong>我说：</strong></td>   
        <td width="60%"><textarea id="sendtext" class="sendtext" cols="60" rows="3" onkeypress="send1()"></textarea></td>   
        <td width="25%" align="center"><input type="button" class="send" value="发送" onclick="sengMsg()" /></td>   
      </tr>   
      </table>
    </td>   
  </tr>   
</table>   
<p align="center">PHP方向版权所有 copyright 2011<br>聊天室采用ajax+json技术实现</p>   
</body>   
</html>    
<script language="javascript" type="text/javascript">  

  function GetXmlHttpObject(){
    var xmlHttp=null;
    try{
      xmlHttp=new XMLHttpRequest();
    }
    catch (e){
      try{
        xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }catch(e){
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
    return xmlHttp;
  }  

/*  
将用户输入的信息保存到数据库  
*/
  function sengMsg(){
    var xmlHttp=GetXmlHttpObject();       
    //接受用户输入的内容   
    var msg=document.getElementById("sendtext").value;
    if(msg==null||msg==""){
      alert("发送信息不可为空");
      return false;
    }     
    //获取当前用户名   
    var user=document.getElementById("user").value;

    //定义请求的URL   
    var url="sendMsg.php";
    url=url+"?msg="+msg+"&user="+user+"&r="+Math.random(); 
    //打开请求   
    xmlHttp.open("get",url,true);   
       
    xmlHttp.send(null);   
       
    document.getElementById("sendtext").value="";   
  } 

 /*  
 捕捉文本框按下或者按住事件  
 */  
 function send1(){   
   //重写event事件   
   var event = arguments[0]||window.event;   
   //获得当前的ASC码   
   var curKey = event.charCode||event.keyCode;   
   //判断是否等于13，如如果是13则发送信息    
   if(curKey==13){   
   //调用发送方法   
      sengMsg();   
      
   }   
    
 }  
       
  /*  
  动态的查询数据库，两秒查询一次  
  */  
  var maxid=0;   
     
  function getMsg(){ 
     var xmlHttp=GetXmlHttpObject();
     //获取当前用户名 
     var user=document.getElementById("user").value;      
     var url="getMsg.php";
     url=url+"?maxid="+maxid;
     url=url+"&user="+user+Math.random();
     //document.write(url);
     xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4||xmlHttp.readystate=="complete"){
        var msgstr=document.getElementById("content").innerHTML;
        xmlDOC=xmlHttp.responseXML;
        var msg=xmlDOC.getElementsByTagName("msg");
        if(typeof(msg)!=='undefined'){
          for(var i=0;i<msg.length;i++){
            msgstr+="<b>"+msg[i].childNodes[3].childNodes[0].nodeValue+"</b> ["+msg[i].childNodes[5].childNodes[0].nodeValue
            +"]"+" "+msg[i].childNodes[9].childNodes[0].nodeValue+" 说：<br>"+"    <font color='blue'>"+
            msg[i].childNodes[7].childNodes[0].nodeValue+"</font><br>"; 
            //document.write(msgstr); 
            maxid=msg[i].childNodes[1].childNodes[0].nodeValue;
          }
          document.getElementById("content").innerHTML=msgstr;   
          //设置让滚动条跟随文字滚动   
          document.getElementById("content").scrollTop=document.getElementById("content").scrollHeight;
        }
      }
     }
     xmlHttp.open("get",url,true);   
     xmlHttp.send(null);  
  
      
  }     
     
 setInterval("getMsg()",2000);   
  
    
 //****************************处理在线用户信息************************   
    
 function getUsers(){   
     //获取当前用户名 
     var xmlHttp=GetXmlHttpObject();
     var user=document.getElementById("user").value;
     var userslist=document.getElementById("userlist");
     var url="getUsers.php";
     url=url+"?username="+user;
     var user=document.getElementById("user").value; 
     xmlHttp.onreadystatechange=function(){
      if(xmlHttp.readyState==4||xmlHttp.readyState=="complete"){
        xmlDOC=xmlHttp.responseXML;
        var users=xmlDOC.getElementsByTagName('user');
        userslist.options.length=0;
        if(typeof(users)!=="undefined"){
          for(var i=0;i<users.length;i++){
            var opt=new Option(users[i].childNodes[1].childNodes[0].nodeValue+"["+users[i].childNodes[3].childNodes[0].nodeValue+"]",
              users[i].childNodes[1].childNodes[0].nodeValue+"["+users[i].childNodes[3].childNodes[0].nodeValue+"]");
            userslist.add(opt,null);
          }
        }
      }
     }
     xmlHttp.open("get",url,true);   
     xmlHttp.send(null);

  }   

 setInterval("getUsers()",2000);   
    
     
</script>   