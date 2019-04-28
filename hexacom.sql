-- MySQL dump 10.13  Distrib 8.0.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: hexacom
-- ------------------------------------------------------
-- Server version	5.7.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `hexacom`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `hexacom` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `hexacom`;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `clients` (
  `client_id` int(255) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact_no` bigint(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `landline_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Graeham','Solis',9122391670,'graesolis@gmail.com',NULL,NULL,NULL,NULL),(2,'Rachelle ','Muyargas',9456781234,'rachmuyargas@gmail.com',NULL,NULL,NULL,NULL),(3,'Clarence','Juanata',912222222,'clarence@gmail.com',NULL,NULL,NULL,NULL),(4,'Michael','Johnson',9123435666,'mjampaguey@gmail.com',NULL,NULL,NULL,NULL),(5,'Rico','Pangan',9456577899,'rico@gmail.com',NULL,NULL,NULL,NULL),(6,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(7,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(8,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(9,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(10,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(11,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(12,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(13,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(14,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(15,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(16,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(17,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(18,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(19,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(20,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(21,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(22,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(23,'321321','3213',23,'232@d','21321',NULL,NULL,NULL),(24,'thankstesting','thankstesting',12312,'aslo@pensada','thankstesting',NULL,NULL,NULL),(25,'thankstesting','thankstesting',12312,'aslo@pensada','thankstesting',NULL,NULL,NULL),(26,'thankstesting','thankstesting',12312,'aslo@pensada','thankstesting',NULL,NULL,NULL),(27,'thankstesting','thankstesting',12312,'aslo@pensada','thankstesting',NULL,NULL,NULL),(28,'thankstesting','thankstesting',12312,'aslo@pensada','thankstesting',NULL,NULL,NULL),(29,'thankstesting','thankstesting',12312,'aslo@pensada','thankstesting',NULL,NULL,NULL),(30,'ricotesting2','ricotesting2',12312,'ricotesting2@ricotesting2','ricotesting2',NULL,NULL,NULL),(31,'ricotesting2','ricotesting2',12312,'ricotesting2@ricotesting2','ricotesting2',NULL,NULL,NULL),(32,'ricotesting2','ricotesting2',12312,'ricotesting2@ricotesting2','ricotesting2',NULL,NULL,NULL),(33,'ricotesting2','ricotesting2',12312,'ricotesting2@ricotesting2','ricotesting2',NULL,NULL,NULL),(34,'ricotesting2','ricotesting2',12312,'ricotesting2@ricotesting2','ricotesting2',NULL,NULL,NULL),(35,'ricotesting2','ricotesting2',12312,'ricotesting2@ricotesting2','ricotesting2',NULL,NULL,NULL),(36,'try123','try123',123,'try123@try123','try123','123',NULL,NULL),(37,'try123','try123',123,'try123@try123','try123','123',NULL,NULL),(38,'asdsa','sad',321213,'sadsa@12321','asdsa','21321',NULL,NULL),(39,'asdsa','sad',321213,'sadsa@12321','asdsa','21321',NULL,NULL),(40,'asdsa','sad',321213,'sadsa@12321','asdsa','21321',NULL,NULL),(41,'qwewq','ewqe',1231,'312@21','wqewq','21121',NULL,NULL),(42,'qwewq','ewqe',1231,'312@21','wqewq','21121',NULL,NULL),(43,'12321','213',21321,'12321@1231','12321','21321',NULL,NULL),(44,'21321','21321',12321,'12@wqe','21321312',NULL,NULL,NULL),(45,'canontesting','canontesting',21321,'canontesting@canontesting','canontesting',NULL,'2019-03-09 07:00:25','2019-03-09 07:00:25'),(46,'canontesting','canontesting',21321,'canontesting@canontesting','canontesting',NULL,'2019-03-09 07:09:29','2019-03-09 07:09:29'),(47,'kanyon','kanyon',12312,'kanyon@kanyon','kanyon',NULL,'2019-03-09 07:10:13','2019-03-09 07:10:13'),(48,'kanyon2','kanyon2',212,'kanyon2@kanyon2','kanyon2',NULL,'2019-03-09 07:13:39','2019-03-09 07:13:39'),(49,'kanyon2','kanyon2',212,'kanyon2@kanyon2','kanyon2',NULL,'2019-03-09 07:13:55','2019-03-09 07:13:55'),(50,'kanyon2','kanyon2',212,'kanyon2@kanyon2','kanyon2',NULL,'2019-03-09 07:14:10','2019-03-09 07:14:10'),(51,'acer','acer',21312,'acer@acer','acer',NULL,'2019-03-09 07:14:33','2019-03-09 07:14:33'),(52,'other','other',12321,'other@other','other',NULL,'2019-03-09 07:15:01','2019-03-09 07:15:01');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `inventory` (
  `item_id` int(255) NOT NULL AUTO_INCREMENT,
  `item` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL DEFAULT 'Generic',
  `model` varchar(255) NOT NULL DEFAULT 'not specified',
  `description` varchar(10000) NOT NULL DEFAULT 'not specified',
  `serial_no` varchar(255) NOT NULL DEFAULT 'no entry',
  `cost` int(255) NOT NULL,
  `stock` int(255) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `date_recieved` varchar(50) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (1,'Hard Drive','Seagate','Barracuda','1TB','STV2432432432',2650,6,'PCWorkx','05-20-2018'),(2,'Flash Drive','Imation','SEGA','16GB','IAG345345435',350,12,'Imation','02-27-2019'),(3,'PC Casing','Cool Air','Ice','-','-',850,20,'PCWorkx','12-23-2017'),(4,'Power Supply','Tiger','Cub','-','-',2150,8,'Tiongsan','05-23-2015'),(5,'Processor','Intel','Core-i5','6th Gen','IASD324234324324',15000,10,'PCWorkx','08-24-2017'),(7,'RAM','Generic','not specified','not specified','R34243',10000,5,'PC Works','2-20-2019'),(8,'Laptop','Acer','apire3','not specified','12312a',1230,2,'PC Bondats','02-20-2019');
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sales` (
  `sale_id` int(255) NOT NULL AUTO_INCREMENT,
  `or_num` int(255) NOT NULL,
  `cash_invoice` int(255) NOT NULL,
  `cost` int(255) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL,
  `srf_no` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `item_id` int(255) NOT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `user_id` (`user_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (4,1232,1111,2650,'Done',1345,1,1),(5,1223,1222,150,'Done',1232,2,2),(6,4059,4994,350,'Waiting',2343,3,3),(7,2222,9390,0,'In Progress',2445,4,4);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `services` (
  `service_id` int(255) NOT NULL AUTO_INCREMENT,
  `srf_no` int(255) NOT NULL,
  `or_number` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `warranty` varchar(255) NOT NULL,
  `date` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `cost` int(255) NOT NULL DEFAULT '0',
  `date_finished` varchar(50) NOT NULL,
  `user_id` int(255) NOT NULL,
  `client_id` int(255) NOT NULL COMMENT 'items sa inventory',
  `item_id` int(45) DEFAULT NULL,
  `serial` varchar(255) DEFAULT NULL,
  `accessories` varchar(255) DEFAULT NULL,
  `repair_model` varchar(255) DEFAULT NULL,
  `case_id` varchar(255) DEFAULT NULL,
  `unit_password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`service_id`),
  KEY `client_id` (`client_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `services_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`),
  CONSTRAINT `services_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,3654,NULL,NULL,'Not Warranted','-','Repair','Waiting',500,'06-23-2019',6,2,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,1055,NULL,NULL,'Not Warranted','03-15-2100','Replacement of Harddrive','In Progress',0,'02-22-2019',6,2,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,2930,NULL,NULL,'Not Warranted','03-27-2020','Repair','In Progress',0,'04-12-2019',3,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,3403,NULL,NULL,'Not Warranted','-','Repair','Done',2560,'04-13-2019',4,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,2234,NULL,NULL,'Not Warranted','-','Cleaning','Done',150,'09-22-2019',5,3,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,12312,NULL,NULL,'no warranty','02-20-2019','bondats cleaning','Waiting',1200,'02-21-2019',5,5,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,880035,NULL,NULL,'Not Warranted','2019-12-12','ricotesting2','waiting',0,'N/A',6,31,0,'12312','mouse, N/A, no additional accessories','ricotesting2',NULL,NULL,NULL,NULL),(8,880035,NULL,NULL,'Not Warranted','2019-12-12','ricotesting2','waiting',0,'N/A',6,32,0,'12312','mouse, N/A, no additional accessories','ricotesting2',NULL,NULL,NULL,NULL),(9,880035,NULL,NULL,'Not Warranted','2019-12-12','ricotesting2','waiting',0,'N/A',6,33,0,'12312','mouse, N/A, no additional accessories','ricotesting2',NULL,NULL,NULL,NULL),(10,880035,NULL,NULL,'Not Warranted','2019-12-12','ricotesting2','waiting',0,'N/A',6,34,0,'12312','mouse, N/A, no additional accessories','ricotesting2',NULL,NULL,NULL,NULL),(11,880035,NULL,NULL,'Not Warranted','2019-12-12','ricotesting2','waiting',0,'N/A',6,35,0,'12312','mouse, N/A, no additional accessories','ricotesting2',NULL,NULL,NULL,NULL),(12,484988,NULL,NULL,'Not Warranted','1222-03-12','try123','waiting',0,'N/A',6,37,0,'try123','mouse, charger, try123','try123','try123',NULL,NULL,NULL),(13,190503,NULL,'MSIC','Not Warranted','1212-12-12','213','waiting',0,'N/A',6,41,0,'2131','mouse, charger, 12312','12312','21321',NULL,NULL,NULL),(14,190503,NULL,'MSIC','Not Warranted','1212-12-12','213','waiting',0,'N/A',6,42,0,'2131','mouse, charger, 12312','12312','21321',NULL,NULL,NULL),(15,580403,NULL,'MSIC2','Not Warranted','0012-02-21','21321','waiting',0,'N/A',6,43,0,'312','no mouse, no charger, no additional accessories','321','12321','12312',NULL,NULL),(16,781155,NULL,'Canon','Not Warranted','12312-12-12','12321','waiting',0,'N/A',6,44,0,'2131','no mouse, no charger, no additional accessories','12123',NULL,NULL,NULL,NULL),(17,154639,NULL,'canon','Not Warranted','2019-03-07','canontesting, canontesting, canontesting','Waiting',0,'N/A',6,45,0,'canontesting','canontesting','canontesting','canontesting','canontesting','2019-03-09 07:00:25','2019-03-09 07:00:25'),(18,154639,NULL,'canon','Not Warranted','2019-03-07','canontesting, canontesting, canontesting','Waiting',0,'N/A',6,46,0,'canontesting','canontesting','canontesting','canontesting','canontesting','2019-03-09 07:09:30','2019-03-09 07:09:30'),(19,239059,NULL,'canon','Not Warranted','0012-12-12','kanyon, kanyon','Waiting',0,'N/A',6,47,0,'kanyon','kanyon','kanyon','kanyon','kanyon','2019-03-09 07:10:13','2019-03-09 07:10:13'),(20,340155,NULL,'canon','Not Warranted','275760-03-21','kanyon2','Waiting',0,'N/A',6,48,0,'21321','kanyon2','3123','31','kanyon2','2019-03-09 07:13:39','2019-03-09 07:13:39'),(21,340155,NULL,'canon','Not Warranted','275760-03-21','kanyon2','Waiting',0,'N/A',6,49,0,'21321','kanyon2','3123','31','kanyon2','2019-03-09 07:13:56','2019-03-09 07:13:56'),(22,340155,NULL,'canon','Not Warranted','275760-03-21','kanyon2','Waiting',0,'N/A',6,50,0,'21321','kanyon2','3123','31','kanyon2','2019-03-09 07:14:10','2019-03-09 07:14:10'),(23,287905,NULL,'acer','Not Warranted','0031-12-13','acer','Waiting',0,'N/A',6,51,0,'acer','acer','acer','acer','acer','2019-03-09 07:14:34','2019-03-09 07:14:34'),(24,620145,NULL,'other','Not Warranted','0031-12-26','other','Waiting',0,'N/A',6,52,0,'other','other','other','other','other','2019-03-09 07:15:02','2019-03-09 07:15:02');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `user_id` int(255) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` date NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'service engineer',
  `email` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `profile_pic` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Christopher','Bautista','christopher','SH@#$%#@#2342344','2019-03-11','service engineer','sample@email.com','1996-03-20','default.png','2019-03-03 16:00:00','2019-03-11 15:46:10'),(2,'Malou','Yanila','yanilamalou','Sad98247897897433','2019-03-11','administrator','sample@email.com','1996-03-20','default.png','2019-03-03 16:00:00','2019-03-11 15:46:10'),(3,'Jerwin','Mariano','Jerwinpogi','2424242','2019-03-11','service engineer','sample@email.com','1996-03-20','default.png','2019-03-03 16:00:00','2019-03-11 15:46:10'),(4,'Jeff','Alveraz','jefferson','*****324324were','2019-03-11','service engineer','sample@email.com','1996-03-20','default.png','2019-03-03 16:00:00','2019-03-11 15:46:10'),(5,'Jonalyn','Laurian','JonalynLaurian','23445sddrdfhty','2019-03-11','administrator','sample@email.com','1996-03-20','default.png','2019-03-03 16:00:00','2019-03-11 15:46:10'),(6,'rico','edit','rico','$2y$10$jiT1JaIPNRRi5OD9FRPmbOyRm/1zWo6ulnvkpcv8ma7UliWPdineS','2019-03-11','service engineer','sample@email.com','1996-03-22','1552119565.png','2019-03-03 16:00:00','2019-03-11 15:46:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-12 10:48:51
