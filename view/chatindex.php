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
            </div>
            <div style="height:75%; border-style: ridge; padding: 5px;">
                <div id="content" class="content" style="overflow: scroll; height: 95%"></div>
            </div>
            <div style="height:15%; border-style: ridge; padding: 5px;">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default"><?php echo $name; ?>:</span>
                    </div>
                    <input type="text" id="sendtext" class="form-control" onkeypress="send1()" aria-label="Default"
                           aria-describedby="inputGroup-sizing-default">
                    <button type="submit" id="send" class="btn btn-primary" onclick="sendMsg()">发送</button>
                </div>
            </div>
        </div>
        <div class="col-4" style="border-style: solid">
            <div style="overflow: scroll; height: 95%">
                <p>在线列表</p>
                <ul id="userlist" class="list-group">
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
<script src="http://code.jquery.com/jquery-latest.js"></script>
</body>
</html>


<script language="javascript" type="text/javascript">

    /*
     将用户输入的信息保存到数据库
     */
    function sendMsg() {
        //接受用户输入的内容
        var msg = document.getElementById("sendtext").value;
        if (msg == null || msg == "") {
            alert("发送信息不可为空");
            return false;
        }
        //获取当前用户名
        var user = document.getElementById("user").value;

        //定义请求的URL
        var url = "/chatroom/sendMsg.php";
        url = url + "?msg=" + msg + "&user=" + user + "&r=" + Math.random();
        //打开请求

        $.ajax({
            url: url,
            type: 'GET',
            async: false,
        });
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
            sendMsg();

        }

    }
    /*
     动态的查询数据库，两秒查询一次
     */
    var maxid = 0;

    function getMsg() {
        //获取当前用户名
        var user = document.getElementById("user").value;
        var url = "/chatroom/getMsg.php";
        url = url + "?maxid=" + maxid;

        $.ajax({
            url: url,
            type: 'GET',
            success: function (data, textStatus) {
                if (textStatus == "success") {
                    var start = data.indexOf("[");
                    if (start == 0) {
                        var result = JSON.parse(data);
                        var msg = document.getElementById("content").innerHTML;
                        for (var i = 0; i < result.length; i++) {
                            msg += "<b>" + result[i].IP + "</b> [" + result[i].createtime
                                + "]" + " " + result[i].user_name + " 说：<br>" + "    <font color='blue'>" +
                                result[i].content + "</font><br>";
                            maxid = result[i].chat_id;
                        }
                        document.getElementById("content").innerHTML = msg;
                        document.getElementById("content").scrollTop = document.getElementById("content").scrollHeight;
                    }
                }
            }
        })
    }

    setInterval("getMsg()", 2000);


    //****************************处理在线用户信息************************

    function getUsers() {
        //获取当前用户名
        var user = document.getElementById("user").value;
        var userslist = document.getElementById("userlist");
        var url = "/chatroom/getUsers.php";
        url = url + "?username=" + user;

        $.ajax({
            url: url,
            type: 'GET',
            success: function (data, textStatus) {
                if (textStatus == "success") {
                    var start = data.indexOf("[");
                    if (start == 0) {
                        $('#userlist li').each(function () {                      //4、移除ul下所有li
                            $(this).remove();
                        });
                        var result = JSON.parse(data);
                        for (var i = 0; i < result.length; i++) {
                            var li = document.createElement("li");
                            li.className = "list-group-item"
                            li.innerHTML = "<b>" + result[i].theip + "</b> [" + result[i].username
                                + "]" + " " + result[i].lasttime;
                            userslist.appendChild(li);
                        }
                    }
                }
            }
        })

    }

    setInterval("getUsers()", 2000);


</script>