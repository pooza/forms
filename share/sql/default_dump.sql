-- MySQL dump 10.13  Distrib 5.1.39, for apple-darwin10.0.0 (i386)
--
-- Host: localhost    Database: forms
-- ------------------------------------------------------
-- Server version	5.1.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `field`
--

DROP TABLE IF EXISTS `field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `field` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` smallint(5) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `label` varchar(64) NOT NULL,
  `field_type_id` varchar(16) NOT NULL DEFAULT 'text',
  `choices` text,
  `required` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rank` tinyint(3) unsigned DEFAULT NULL,
  `status` enum('show','hide') NOT NULL DEFAULT 'hide',
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`form_id`,`name`),
  CONSTRAINT `field_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field`
--

LOCK TABLES `field` WRITE;
/*!40000 ALTER TABLE `field` DISABLE KEYS */;
INSERT INTO `field` VALUES (1,1,'choice','志望','multi_answer','中学校普通コース\n中学校音楽コース\n高等学校普通科:特別進学コース\n高等学校普通科:総合進学コース\n高等学校普通科:一般入試\n高等学校音楽科:演奏家コース\n高等学校音楽科:器楽・声楽コース',1,1,'show','2009-10-06 12:16:52','2009-10-06 15:04:44'),(2,1,'lastname','氏名・姓','text',NULL,1,4,'show','2009-10-06 12:19:52','2009-10-06 15:04:44'),(3,1,'firstname','氏名・名','text',NULL,1,5,'show','2009-10-06 12:20:13','2009-10-06 15:04:44'),(4,1,'lastname_read','氏名フリガナ・姓','reading',NULL,1,2,'show','2009-10-06 12:23:23','2009-10-06 15:04:44'),(5,1,'firstname_read','氏名フリガナ・名','reading',NULL,1,3,'show','2009-10-06 12:23:46','2009-10-06 15:04:44'),(6,1,'gender','性別','single_answer','男性\n女性',1,6,'show','2009-10-06 12:24:10','2009-10-06 17:39:01'),(7,1,'school','学校名','text',NULL,1,7,'show','2009-10-06 12:24:55','2009-10-06 15:04:44'),(8,1,'grade','学年','number',NULL,1,8,'show','2009-10-06 12:25:16','2009-10-06 15:04:44'),(9,1,'zipcode','郵便番号','zipcode',NULL,1,9,'show','2009-10-06 12:26:08','2009-10-06 15:04:44'),(10,1,'pref','都道府県','pref',NULL,1,10,'show','2009-10-06 12:26:44','2009-10-06 15:04:44'),(11,1,'addr','住所','text',NULL,1,11,'show','2009-10-06 12:27:45','2009-10-06 15:04:44'),(12,1,'tel','TEL','phone',NULL,1,12,'show','2009-10-06 12:28:14','2009-10-06 15:04:44'),(13,1,'fax','FAX','phone',NULL,0,13,'show','2009-10-06 12:28:47','2009-10-06 15:04:44'),(14,1,'email','メールアドレス','email',NULL,1,14,'show','2009-10-06 12:29:18','2009-10-06 15:04:44'),(15,1,'parent_lastname','保護者氏名・姓','text',NULL,1,17,'show','2009-10-06 12:32:05','2009-10-06 15:04:45'),(16,1,'parent_firstname','保護者氏名・名','text',NULL,1,18,'show','2009-10-06 12:32:29','2009-10-06 15:04:45'),(17,1,'parent_lastname_read','保護者氏名フリガナ・姓','text',NULL,1,15,'show','2009-10-06 12:33:05','2009-10-06 15:04:44'),(18,1,'parent_firstname_read','保護者氏名フリガナ・名','text',NULL,1,16,'show','2009-10-06 12:33:40','2009-10-06 15:04:44'),(19,1,'instrument','専門楽器','text',NULL,0,19,'show','2009-10-06 12:35:29','2009-10-06 15:04:45');
/*!40000 ALTER TABLE `field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field_type`
--

DROP TABLE IF EXISTS `field_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `field_type` (
  `id` varchar(16) NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field_type`
--

LOCK TABLES `field_type` WRITE;
/*!40000 ALTER TABLE `field_type` DISABLE KEYS */;
INSERT INTO `field_type` VALUES ('agreement','同意'),('email','メールアドレス'),('english','英数字'),('multi_answer','複数回答'),('number','数値'),('phone','電話番号'),('pref','都道府県'),('reading','フリガナ'),('single_answer','単一回答'),('text','テキスト'),('zipcode','郵便番号');
/*!40000 ALTER TABLE `field_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `status` enum('show','hide') NOT NULL DEFAULT 'hide',
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form`
--

LOCK TABLES `form` WRITE;
/*!40000 ALTER TABLE `form` DISABLE KEYS */;
INSERT INTO `form` VALUES (1,'上野学園中学校・高等学校　資料請求','show','2009-10-06 12:13:37','2009-10-06 22:55:31');
/*!40000 ALTER TABLE `form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pref`
--

DROP TABLE IF EXISTS `pref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pref` (
  `id` tinyint(3) unsigned NOT NULL,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pref`
--

LOCK TABLES `pref` WRITE;
/*!40000 ALTER TABLE `pref` DISABLE KEYS */;
INSERT INTO `pref` VALUES (1,'北海道'),(2,'青森県'),(3,'岩手県'),(4,'宮城県'),(5,'秋田県'),(6,'山形県'),(7,'福島県'),(8,'茨城県'),(9,'栃木県'),(10,'群馬県'),(11,'埼玉県'),(12,'千葉県'),(13,'東京都'),(14,'神奈川県'),(15,'新潟県'),(16,'富山県'),(17,'石川県'),(18,'福井県'),(19,'山梨県'),(20,'長野県'),(21,'岐阜県'),(22,'静岡県'),(23,'愛知県'),(24,'三重県'),(25,'滋賀県'),(26,'京都府'),(27,'大阪府'),(28,'兵庫県'),(29,'奈良県'),(30,'和歌山県'),(31,'鳥取県'),(32,'島根県'),(33,'岡山県'),(34,'広島県'),(35,'山口県'),(36,'徳島県'),(37,'香川県'),(38,'愛媛県'),(39,'高知県'),(40,'福岡県'),(41,'佐賀県'),(42,'長崎県'),(43,'熊本県'),(44,'大分県'),(45,'宮崎県'),(46,'鹿児島県'),(47,'沖縄県');
/*!40000 ALTER TABLE `pref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration`
--

DROP TABLE IF EXISTS `registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` smallint(5) unsigned NOT NULL,
  `user_agent` tinytext NOT NULL,
  `remote_host` tinytext NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  CONSTRAINT `registration_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `field` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration`
--

LOCK TABLES `registration` WRITE;
/*!40000 ALTER TABLE `registration` DISABLE KEYS */;
/*!40000 ALTER TABLE `registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_detail`
--

DROP TABLE IF EXISTS `registration_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration_detail` (
  `registration_id` int(10) unsigned NOT NULL,
  `field_id` smallint(5) unsigned NOT NULL,
  `answer` text,
  PRIMARY KEY (`registration_id`,`field_id`),
  KEY `field_id` (`field_id`),
  CONSTRAINT `registration_detail_ibfk_1` FOREIGN KEY (`registration_id`) REFERENCES `registration` (`id`) ON DELETE CASCADE,
  CONSTRAINT `registration_detail_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `field` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_detail`
--

LOCK TABLES `registration_detail` WRITE;
/*!40000 ALTER TABLE `registration_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `registration_detail` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-10-06 23:50:25
