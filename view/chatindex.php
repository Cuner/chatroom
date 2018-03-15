<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once("../model/mysqldb.php");
$con = Mysqldb::getInstance()->connect();
$userSql = "SELECT * FROM user WHERE username='{$_POST['username']}' AND password='{$_POST['password']}'";
//echo $user ;return;
$reuslt = $con->query($userSql);
$rows = $reuslt->fetch_assoc();
$name = $_POST['username'];
if ($rows) {
    session_start();
    if (!isset($_SESSION['user'])) {
        $_SESSION['user'] = $name;
        $_SESSION['id'] = $rows['id'];
    }
} else {
    echo "登录失败，请重新登录";
    echo "<meta http-equiv='refresh' content = '1,url=login.php'/>";
}
?>

<!DOCTYPE html>
<html lang="en" style="height: 100%;">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>欢迎使用AJAX聊天室</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>

<!--    width="800" height="" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#993399"-->
    <body style="height: 100%">

        <div class="container" style="height: 90%; width: 80%; padding: 20px; margin: auto;">
           <div class="row" style="height:100%;">
               <div class="col-8" style="border-style: solid; padding: 0;">
                   <div style="height:10%; border-style: ridge; padding: 5px;">
                       <p>欢迎, <?php echo $name; ?> 进入聊天室</p>
                       <input type="hidden" id="user" value="<?php echo $name; ?>"/>
                       <input type="hidden" id="userId" value="<?php echo $_SESSION['id']; ?>"/>
                   </div>
                   <div style="height:75%; border-style: ridge; padding: 5px;">
                       <div id="content" class="content"></div>
                   </div>
                   <div style="height:15%; border-style: ridge; padding: 5px;">
                       <div class="input-group mb-3">
                           <div class="input-group-prepend">
                               <span class="input-group-text" id="inputGroup-sizing-default"><?php echo $name; ?>:</span>
                           </div>
                           <input type="text" id="sendtext" class="form-control" onkeypress="send1()" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                           <button type="submit" id="send" class="btn btn-primary">发送</button>
                       </div>
                   </div>
               </div>
               <div class="col-4" style="border-style: solid">
                   <div data-spy="scroll" data-offset="0">
                       <ul id="userlist" class="users">
                           <option>所有人</option>
                       </ul>
                   </div>
               </div>
           </div>
        </div>

        <p align="center">PHP方向版权所有 copyright 2011<br>聊天室采用ajax+json技术实现</p>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous"></script>
    </body>
</html>



<script language="javascript" type="text/javascript">

    function GetXmlHttpObject() {
        var xmlHttp = null;
        try {
            xmlHttp = new XMLHttpRequest();
        }
        catch (e) {
            try {
                xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
        }
        return xmlHttp;
    }

    /*
     将用户输入的信息保存到数据库
     */
    function sengMsg() {
        var xmlHttp = GetXmlHttpObject();
        //接受用户输入的内容
        var msg = document.getElementById("sendtext").value;
        if (msg == null || msg == "") {
            alert("发送信息不可为空");
            return false;
        }
        //获取当前用户名
        var user = document.getElementById("user").value;

        //定义请求的URL
        var url = "sendMsg.php";
        url = url + "?msg=" + msg + "&userId=" + user + "&r=" + Math.random();
        //打开请求
        xmlHttp.open("get", url, true);

        xmlHttp.send(null);

        document.getElementById("sendtext").value = "";
    }

    /*
     捕捉文本框按下或者按住事件
     */
    function send1() {
        //重写event事件
        var event = arguments[0] || window.event;
        //获得当前的ASC码
        var curKey = event.charCode || event.keyCode;
        //判断是否等于13，如如果是13则发送信息
        if (curKey == 13) {
            //调用发送方法
            sengMsg();

        }

    }
    /*
     动态的查询数据库，两秒查询一次
     */
    var maxid = 0;

    function getMsg() {
        var xmlHttp = GetXmlHttpObject();
        //获取当前用户名
        var user = document.getElementById("user").value;
        var url = "/chatroom/getMsg.php";
        url = url + "?maxid=" + maxid;
        //document.write(url);
        xmlHttp.onreadystatechange = function () {
            if (xmlHttp.readyState == 4 || xmlHttp.readystate == "complete") {
                var msgstr = document.getElementById("content").innerHTML;
                xmlDOC = xmlHttp.responseXML;
                var msg = xmlDOC.getElementsByTagName("msg");
                if (typeof(msg) !== 'undefined') {
                    for (var i = 0; i < msg.length; i++) {
                        msgstr += "<b>" + msg[i].childNodes[3].childNodes[0].nodeValue + "</b> [" + msg[i].childNodes[5].childNodes[0].nodeValue
                            + "]" + " " + msg[i].childNodes[9].childNodes[0].nodeValue + " 说：<br>" + "    <font color='blue'>" +
                            msg[i].childNodes[7].childNodes[0].nodeValue + "</font><br>";
                        //document.write(msgstr);
                        maxid = msg[i].childNodes[1].childNodes[0].nodeValue;
                    }
                    document.getElementById("content").innerHTML = msgstr;
                    //设置让滚动条跟随文字滚动
                    document.getElementById("content").scrollTop = document.getElementById("content").scrollHeight;
                }
            }
        }
        xmlHttp.open("get", url, true);
        xmlHttp.send(null);


    }

    setInterval("getMsg()", 2000);


    //****************************处理在线用户信息************************

    function getUsers() {
        //获取当前用户名
        var xmlHttp = GetXmlHttpObject();
        var user = document.getElementById("user").value;
        var userslist = document.getElementById("userlist");
        var url = "/chatroom/getUsers.php";
        url = url + "?username=" + user;
        xmlHttp.onreadystatechange = function () {
            if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
                xmlDOC = xmlHttp.responseXML;
                var users = xmlDOC.getElementsByTagName('user');
                userslist.options.length = 0;
                if (typeof(users) !== "undefined") {
                    for (var i = 0; i < users.length; i++) {
                        var opt = new Option(users[i].childNodes[1].childNodes[0].nodeValue + "[" + users[i].childNodes[3].childNodes[0].nodeValue + "]",
                            users[i].childNodes[1].childNodes[0].nodeValue + "[" + users[i].childNodes[3].childNodes[0].nodeValue + "]");
                        userslist.add(opt, null);
                    }
                }
            }
        }
        xmlHttp.open("get", url, true);
        xmlHttp.send(null);

    }

    setInterval("getUsers()", 2000);


</script>