# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.43)
# Database: foo
# Generation Time: 2020-07-17 20:19:28 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL DEFAULT '',
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uc_user_email_idx` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `email`, `first_name`, `last_name`, `created_at`, `updated_at`)
VALUES
	(1,'',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,'test1@example.com','Joe','Schmoe','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(3,'test2@example.com','Joe','Schmoe','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(4,'test3@example.com','Jack','Schmoe','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(5,'test4@example.com','Jill','Schmoe','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(6,'test5@example.com','Bob','Lob-Law','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(7,'test6@example.com','Aaron','Lob-Law','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(8,'test7@example.com','Jimmy','Jinglehimer-Schmitt','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(9,'test8@example.com','Jane',NULL,'2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(10,'test9@example.com','Jim','Flim','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(11,'test12@example.com','Joe','Jinglehimer-Schmitt','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(12,'test11@example.com','Steve','Wozniaki','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(13,'test13@example.com','Amber','Wozniaki','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(14,'test14@example.com','Bill','Wozniaki','2020-07-17 20:19:12','2020-07-17 20:19:12'),
	(15,'test15@example.com','Nick',NULL,'2020-07-17 20:19:12','2020-07-17 20:19:12');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
