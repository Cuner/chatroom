CREATE DATABASE `chatroom`;

USE `chatroom`;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`password`) values (1,'tobi','123'),(2,'cuner','123'),(3,'hoan','123');

/*Table structure for table `usersonline` */

DROP TABLE IF EXISTS `usersonline`;

CREATE TABLE `usersonline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `theip` varchar(20) NOT NULL,
  `lasttime` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `chatinfo` */

DROP TABLE IF EXISTS `chatinfo`;

CREATE TABLE `chatinfo` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR (20) NOT NULL,
  `IP` varchar(15) NOT NULL,
  `content` text NOT NULL,
  `createtime` varchar(30) NOT NULL,
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Data for the table `chatinfo` */

insert  into `chatinfo`(`chat_id`,`user_name`,`IP`,`content`,`createtime`) values (1,'tobi','::1','hello world','2017-Apr-Thu 09:11:1'),(2,'cuner','::1','hello?','2018-Apr-Thu 09:11:4'),(3,'hoan','::1','world','2017-Apr-Thu 09:13:2');