/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.11-MariaDB-log : Database - zadachnik
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`zadachnik` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `zadachnik`;

/*Table structure for table `authors` */

DROP TABLE IF EXISTS `authors`;

CREATE TABLE `authors` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `authors` */

insert  into `authors`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'Вася','2021-11-12 09:32:27',NULL),
(2,'Фёдор','2021-11-12 09:32:36',NULL),
(3,'Дима','2021-11-12 09:32:41',NULL);

/*Table structure for table `tasks` */

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `author_id` int(20) DEFAULT NULL,
  `tstatus_id` int(20) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_authors_connection` (`author_id`),
  KEY `tasks_status_connection` (`tstatus_id`),
  CONSTRAINT `tasks_authors_connection` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tasks_status_connection` FOREIGN KEY (`tstatus_id`) REFERENCES `tasks_status` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tasks` */

insert  into `tasks`(`id`,`name`,`author_id`,`tstatus_id`,`created_at`,`updated_at`) values 
(3,'Сварить себе пельмени',2,3,'2021-11-12 09:45:09',NULL),
(4,'Съездить в отпуск',3,3,'2021-11-12 09:45:39',NULL),
(5,'Научится играть на гитаре',2,4,'2021-11-12 09:46:09',NULL),
(8,'Сварить себе пельмени',2,3,'2021-11-12 12:59:51',NULL),
(9,'Съездить в отпуск',3,3,'2021-11-12 12:59:51',NULL),
(10,'Научится играть на гитаре',2,4,'2021-11-12 12:59:51',NULL),
(15,'Сварить себе пельмени',2,3,'2021-11-12 12:59:55',NULL),
(16,'Съездить в отпуск',3,3,'2021-11-12 12:59:55',NULL),
(17,'Научится играть на гитаре',2,4,'2021-11-12 12:59:55',NULL),
(20,'Сварить себе пельмени',2,3,'2021-11-12 12:59:55',NULL),
(21,'Съездить в отпуск',3,3,'2021-11-12 12:59:55',NULL),
(22,'Научится играть на гитаре',2,4,'2021-11-12 12:59:55',NULL),
(28,'Купить слона',1,1,'2021-11-12 12:59:59',NULL),
(29,'Купить корма для слона',1,2,'2021-11-12 12:59:59',NULL),
(30,'Сварить себе пельмени',2,3,'2021-11-12 12:59:59',NULL),
(31,'Съездить в отпуск',3,3,'2021-11-12 12:59:59',NULL),
(33,'Купить слона',1,1,'2021-11-12 12:59:59',NULL),
(35,'Сварить себе пельмени',2,3,'2021-11-12 12:59:59',NULL),
(36,'Съездить в отпуск',3,3,'2021-11-12 12:59:59',NULL),
(38,'Купить слона',1,1,'2021-11-12 12:59:59',NULL),
(39,'Купить корма для слона',1,2,'2021-11-12 12:59:59',NULL),
(40,'Сварить себе пельмени',2,3,'2021-11-12 12:59:59',NULL),
(41,'Съездить в отпуск',3,3,'2021-11-12 12:59:59',NULL),
(43,'Купить слона',1,1,'2021-11-12 12:59:59',NULL),
(44,'Купить корма для слона',1,2,'2021-11-12 12:59:59',NULL),
(45,'Сварить себе пельмени',2,3,'2021-11-12 12:59:59',NULL),
(46,'Съездить в отпуск',3,3,'2021-11-12 12:59:59',NULL);

/*Table structure for table `tasks_status` */

DROP TABLE IF EXISTS `tasks_status`;

CREATE TABLE `tasks_status` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tasks_status` */

insert  into `tasks_status`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'Срочная','2021-11-12 09:32:53',NULL),
(2,'Очень срочная','2021-11-12 09:33:03',NULL),
(3,'Обычная','2021-11-12 09:33:09',NULL),
(4,'Не срочная','2021-11-12 09:33:18',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
