/*
SQLyog v10.2 
MySQL - 5.6.17 : Database - practice
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`practice` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `practice`;

/*Table structure for table `chatinfo` */

DROP TABLE IF EXISTS `chatinfo`;

CREATE TABLE `chatinfo` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `spk_name` varchar(10) NOT NULL,
  `IP` varchar(15) NOT NULL,
  `content` text NOT NULL,
  `createtime` varchar(20) NOT NULL,
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `chatinfo` */

insert  into `chatinfo`(`chat_id`,`spk_name`,`IP`,`content`,`createtime`) values (1,'123','::1','asdasda','2015-Apr-Thu 09:11:1'),(2,'123','::1','asd','2015-Apr-Thu 09:11:4'),(3,'123','::1','ceshi','2015-Apr-Thu 09:13:2'),(4,'123','::1','a','2015-Apr-Thu 09:13:2'),(5,'123','::1','s','2015-Apr-Thu 09:13:2'),(6,'123','::1','hello','2015-Apr-Thu 09:20:3'),(7,'123','::1','success','2015-Apr-Thu 09:20:4'),(8,'123','::1','哈哈','2015-Apr-Thu 09:21:1'),(9,'123','::1','说话','2015-Apr-Thu 09:22:4'),(10,'123','::1','滚动条','2015-Apr-Thu 09:24:3'),(11,'123','::1','最下面','2015-Apr-Thu 09:24:3'),(12,'123','::1','我也进来了','2015-Apr-Thu 09:26:3'),(13,'123','::1','谢金雨','2015-Apr-Thu 12:12:4'),(14,'xiaoqiao','::1','我是肖桥','2015-Apr-Thu 17:41:3'),(15,'123','::1','我是123','2015-Apr-Thu 17:41:4');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`password`) values (6,'123','123'),(7,'xiaoqiao','123');

/*Table structure for table `usersonline` */

DROP TABLE IF EXISTS `usersonline`;

CREATE TABLE `usersonline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `theip` varchar(20) NOT NULL,
  `lasttime` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `usersonline` */

insert  into `usersonline`(`id`,`username`,`theip`,`lasttime`) values (4,'xiaoqiao','::1','2015-04-26 23:17:19');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
