# Chatroom
php+ajax轮询实现简易聊天室，使用数据库进行存储

本系统使用php+ajax轮询实现即时通讯的聊天室

用户登录进入聊天室页面（未实现注册，使用数据库user表的账号信息进行登陆）

进入聊天室页面后，用户发送消息，发送的消息以及相关信息（时间、发送者）被发送至sendMsg()，这些信息被存储至数据库chatinfo表

ajax每两秒执行getMsg()方法，通过向getMsg.php发送get请求，从数据库chatinfo表中读取消息列表（每次读取最后一条或者几条最新的数据）并显示出来

ajax每两秒执行getUsers()方法，通过向getUsers.php发送get请求，在数据库usersonline表中对在线用户信息（用户名，在线时间）进行更新，并获取在线用户信息并显示出来
