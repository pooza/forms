-- MySQL dump 10.13  Distrib 5.1.39, for apple-darwin10.0.0 (i386)
--
-- Host: localhost    Database: prof
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
-- Temporary table structure for view `blog_feed_entry`
--

DROP TABLE IF EXISTS `blog_feed_entry`;
/*!50001 DROP VIEW IF EXISTS `blog_feed_entry`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `blog_feed_entry` (
  `id` bigint(20) unsigned,
  `feed_id` int(10) unsigned,
  `name` varchar(128),
  `url` varchar(128),
  `body` text,
  `entry_date` datetime,
  `profile_id` int(10) unsigned
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `feed`
--

DROP TABLE IF EXISTS `feed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `profile_id` int(10) unsigned DEFAULT NULL,
  `service_id` char(8) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `url` varchar(128) NOT NULL,
  `feed_url` varchar(128) DEFAULT NULL,
  `site_url` varchar(128) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_id` (`profile_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `feed_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE,
  CONSTRAINT `feed_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feed`
--

LOCK TABLES `feed` WRITE;
/*!40000 ALTER TABLE `feed` DISABLE KEYS */;
INSERT INTO `feed` VALUES (1,1,'hateb','poozaのブックマーク','http://b.hatena.ne.jp/pooza/',NULL,NULL,'2009-09-30 15:29:42','2009-09-30 15:29:42'),(2,1,'twitter','Twitter / pooza','http://twitter.com/pooza',NULL,NULL,'2009-09-30 15:30:03','2009-09-30 15:30:03'),(3,1,NULL,'b-shock. Fortress','http://d.hatena.ne.jp/pooza/',NULL,NULL,'2009-09-30 15:30:16','2009-09-30 15:30:16');
/*!40000 ALTER TABLE `feed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feed_entry`
--

DROP TABLE IF EXISTS `feed_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feed_entry` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feed_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(128) NOT NULL,
  `url` varchar(128) DEFAULT NULL,
  `body` text,
  `entry_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `feed_id` (`feed_id`,`url`),
  KEY `entry_date` (`entry_date`),
  CONSTRAINT `feed_entry_ibfk_1` FOREIGN KEY (`feed_id`) REFERENCES `feed` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feed_entry`
--

LOCK TABLES `feed_entry` WRITE;
/*!40000 ALTER TABLE `feed_entry` DISABLE KEYS */;
INSERT INTO `feed_entry` VALUES (1,1,'あまり知られていないけれど、HTML5では正規表現が使えるようになる － Publickey','http://www.publickey.jp/blog/09/html5_3.html',NULL,'2009-09-29 17:57:08'),(2,1,'使い慣れた日本語入力プログラムを再び... | 物書堂','http://www.monokakido.jp/2009/09/kawasemi-intro.html',NULL,'2009-09-28 11:13:31'),(3,1,'初歩的な管理ミスで3300もの有名サイトがソースコードを盗まれる','http://jp.techcrunch.com/archives/20090923basic-flaw-reveals-source-code-to-3300-popular-websites/',NULL,'2009-09-25 17:47:22'),(4,1,'IEでもGoogle Waveを満喫できる：Google、IEを“Chrome並みに”改良するプラグイン「Chrome Frame」リリース - ITmedia エンタープライズ','http://www.itmedia.co.jp/enterprise/articles/0909/23/news010.html',NULL,'2009-09-23 22:19:37'),(5,1,'PHP の mbstring に関するメモ','http://www.asahi-net.or.jp/~wv7y-kmr/memo/php_mbstring.html',NULL,'2009-09-22 01:10:27'),(6,1,'void GraphicWizardsLair( void ); // www抜きのアドレスをwww付きにリダイレクトするhttpd.conf','http://www.otsune.com/diary/2008/05/20/1.html#200805201',NULL,'2009-09-19 02:25:48'),(7,1,'Gruml | Google Reader for Mac OS','http://www.grumlapp.com/',NULL,'2009-09-16 19:10:45'),(8,1,'mb_check_encoding() の代替関数 - t_komuraの日記','http://d.hatena.ne.jp/t_komura/20090705/1246802468',NULL,'2009-09-15 20:38:50'),(9,1,'[Mac OS X] シェルスクリプトとかの CUI アプリケーションを Mac OS X 方式の .app にする方法 [簡単 5 ステップ]','http://www.pqrs.org/tekezo/macosx/doc/makeapp/',NULL,'2009-09-11 03:31:11'),(10,1,'Growl Beta','http://growl.info/beta.html',NULL,'2009-09-10 11:57:33'),(11,1,'ウイルス・スパイウェア対策 | アンチウイルスソフト Kaspersky(カスペルスキー)Anti-Virus for Mac','http://www.justsystems.com/jp/products/kasperskymac/',NULL,'2009-09-03 00:31:48'),(12,1,'エムロジック放課後プロジェクト: TemplateSetExporter アーカイブ','http://labs.m-logic.jp/cat2/templatesetexporter/',NULL,'2009-09-02 17:38:45'),(13,1,'自宅サーバの道しるべ【空メール（自動返信メール）】','http://my-server.homelinux.com/emptymail.php',NULL,'2009-08-31 21:28:05'),(14,1,'D&D　はじめの一歩','http://rainbow.s140.xrea.com/cdspe/hajime35/hajime35_index.html',NULL,'2009-08-30 17:32:16'),(15,1,'Snow LeopardでイーモバイルのUSBモデムを使う方法','http://blog.s21g.com/articles/1589',NULL,'2009-08-28 22:01:44'),(16,1,'BINDでDynamic DNS環境構築','http://www.atmarkit.co.jp/flinux/rensai/bind04/bind04.html',NULL,'2009-08-27 22:50:21'),(17,1,'Windows ユーザー エクスペリエンス ガイドライン','http://msdn.microsoft.com/ja-jp/windows/ee340680.aspx',NULL,'2009-08-25 13:55:07'),(18,1,'「パッチを当ててやってもいいんだぞ、お前が嫌なら」 - muddy brown thang','http://d.hatena.ne.jp/moriyoshi/20090804/1249380306',NULL,'2009-08-23 16:35:44'),(19,1,'Canny template library - Smarty for Ruby','http://canny.sourceforge.net/',NULL,'2009-08-23 16:00:58'),(20,1,'FreeBSDでNagiosのインストール (Bloom World)','http://blog.dualarch.jp/hiya/2007/03/freebsdnagios.html',NULL,'2009-08-21 14:35:45'),(21,2,'pooza: 請求処理終了。あとは送るだけ。今日は郵便局の近くで食事にしよう。','http://twitter.com/pooza/statuses/4488565215',NULL,'2009-09-30 12:26:36'),(22,2,'pooza: @rsky 8.5→8.6は無償ではなかったでしょうか。','http://twitter.com/pooza/statuses/4474233235',NULL,'2009-09-30 01:50:06'),(23,2,'pooza: /etc/sudoersで \"Defaults requiretty\" がデフォルトになっている件、ちょっと余計なお世話。','http://twitter.com/pooza/statuses/4468309223',NULL,'2009-09-29 21:01:06'),(24,2,'pooza: 一区切りついたので一杯やるです','http://twitter.com/pooza/statuses/4445118576',NULL,'2009-09-29 00:33:27'),(25,2,'pooza: yumのせいで仕事おわんねーよ','http://twitter.com/pooza/statuses/4444634061',NULL,'2009-09-29 00:11:57'),(26,2,'pooza: yumが不安定で泣ける。pam-develをrpmコマンドで直接ねじ込んだ。','http://twitter.com/pooza/statuses/4444618577',NULL,'2009-09-29 00:11:14'),(27,2,'pooza: ドトール@表参道','http://twitter.com/pooza/statuses/4435680258',NULL,'2009-09-28 14:02:51'),(28,2,'pooza: しびらんか 明太子チーズ','http://twitter.com/pooza/statuses/4388281634',NULL,'2009-09-26 14:48:20'),(29,2,'pooza: 十番に食事に行くです。ズンタカポーン','http://twitter.com/pooza/statuses/4387552003',NULL,'2009-09-26 14:02:31'),(30,2,'pooza: あとは実機が届くのを待つだけ。ZFSとか動くといいなー。','http://twitter.com/pooza/statuses/4372467539',NULL,'2009-09-26 01:46:44'),(31,2,'pooza: USBメモリに詰めたFreeNAS 0.7RC1が正常起動することを、最近使ってないAspire oneで確認。','http://twitter.com/pooza/statuses/4372430069',NULL,'2009-09-26 01:45:10'),(32,2,'pooza: アマゾンから1,000円で調達したUSBメモリに、FreeNASを詰める。','http://twitter.com/pooza/statuses/4371496385',NULL,'2009-09-26 01:05:04'),(33,2,'pooza: クローラーはこんなものか。クローラーのUserAgent名を考えよう。（現実逃避','http://twitter.com/pooza/statuses/4365622443',NULL,'2009-09-25 19:39:52'),(34,2,'pooza: strtotimeを信用してよいものか。悩ましい。','http://twitter.com/pooza/statuses/4365531281',NULL,'2009-09-25 19:32:54'),(35,2,'pooza: StuffIt Deluxe 2010がUS$29.99。もし64bitネイティブなら、即購入させて頂くのだが。','http://twitter.com/pooza/statuses/4363522694',NULL,'2009-09-25 16:37:30'),(36,2,'pooza: http://bit.ly/31sm3j 主張はもっともだが、それなら、IE6/IE7からの移行にもっと協力してほしい。','http://twitter.com/pooza/statuses/4362879927',NULL,'2009-09-25 15:41:44'),(37,2,'pooza: うちの隣のカフェ、けっこうタグ貼られてる。なかなかおもしろいね。','http://twitter.com/pooza/statuses/4362233145',NULL,'2009-09-25 14:50:41'),(38,2,'pooza: 遅ればせながらセカイカメラを入れてみた。ポストしたタグって、実際に貼り付けられるまで時間がかかる？','http://twitter.com/pooza/statuses/4362175669',NULL,'2009-09-25 14:46:26'),(39,2,'pooza: 氷結','http://twitter.com/pooza/statuses/4342879440',NULL,'2009-09-24 23:36:07'),(40,2,'pooza: アマゾンで\"Samba\"で検索すると最上位に出てくるやつが、一番新しくて普通にオススメっぽい。','http://twitter.com/pooza/statuses/4341987914',NULL,'2009-09-24 22:54:01'),(41,3,'favicon wars','http://d.hatena.ne.jp/pooza/20090918',NULL,'2009-09-18 00:00:00'),(42,3,'Smartyのテンプレート関数 assign','http://d.hatena.ne.jp/pooza/20090821/1250872741',NULL,'2009-08-22 01:39:01'),(43,3,'ドロップダウンメニュー usermenu.js 一部修正','http://d.hatena.ne.jp/pooza/20090821/1250871992',NULL,'2009-08-22 01:26:32'),(44,3,'Leopardのリゾルバキャッシュをクリア','http://d.hatena.ne.jp/pooza/20090806/1249557089',NULL,'2009-08-06 20:11:29'),(45,3,'ちょっとE! エンタメをチョイス!! ChoE!','http://d.hatena.ne.jp/pooza/20090803/1249283585',NULL,'2009-08-03 16:13:05'),(46,3,'ドロップダウンメニュー usermenu.js','http://d.hatena.ne.jp/pooza/20090727/1248685964',NULL,'2009-07-27 18:12:44');
/*!40000 ALTER TABLE `feed_entry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pref`
--

DROP TABLE IF EXISTS `pref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pref` (
  `id` tinyint(3) unsigned NOT NULL DEFAULT '0',
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
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `name_read` varchar(64) DEFAULT NULL,
  `name_en` varchar(64) DEFAULT NULL,
  `login_id` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` char(40) NOT NULL,
  `attorney_id` int(10) unsigned NOT NULL,
  `body` text,
  `birthday` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `pref_id` tinyint(3) unsigned DEFAULT NULL,
  `hometown` varchar(64) DEFAULT NULL,
  `tel` varchar(16) DEFAULT NULL,
  `fax` varchar(16) DEFAULT NULL,
  `view_count` bigint(20) unsigned NOT NULL DEFAULT '0',
  `status` enum('show','hide') NOT NULL DEFAULT 'show',
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `attorney_id` (`attorney_id`),
  UNIQUE KEY `login_id` (`login_id`),
  KEY `pref_id` (`pref_id`),
  CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`pref_id`) REFERENCES `pref` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (1,'小石達也','コイシタツヤ','Tatsuya Koishi','pooza','tkoishi@b-shock.co.jp','695f56b787f7fa14a109352df2f9e1ffddf07bda',1,'よろしく\nhttp://www.b-shock.co.jp/','1970-10-01',NULL,NULL,NULL,NULL,NULL,7,'show','2009-09-30 15:10:48','2009-09-30 16:34:52'),(2,'ぷーざ','プーザ','pooza','pooza2','pooza@b-shock.org','695f56b787f7fa14a109352df2f9e1ffddf07bda',2,NULL,'1970-10-01',NULL,NULL,NULL,NULL,NULL,0,'show','2009-09-30 16:08:36','2009-09-30 16:10:38');
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile_service`
--

DROP TABLE IF EXISTS `profile_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile_service` (
  `profile_id` int(10) unsigned NOT NULL,
  `service_id` char(8) NOT NULL,
  `account_id` varchar(64) NOT NULL,
  PRIMARY KEY (`account_id`,`service_id`),
  UNIQUE KEY `account_id` (`service_id`,`account_id`),
  KEY `profile_id` (`profile_id`),
  CONSTRAINT `profile_service_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE CASCADE,
  CONSTRAINT `profile_service_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile_service`
--

LOCK TABLES `profile_service` WRITE;
/*!40000 ALTER TABLE `profile_service` DISABLE KEYS */;
INSERT INTO `profile_service` VALUES (1,'hateb','pooza'),(1,'twitter','pooza');
/*!40000 ALTER TABLE `profile_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile_tag`
--

DROP TABLE IF EXISTS `profile_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile_tag` (
  `profile_id` int(10) unsigned NOT NULL DEFAULT '0',
  `tag_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`profile_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `profile_tag_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE CASCADE,
  CONSTRAINT `profile_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile_tag`
--

LOCK TABLES `profile_tag` WRITE;
/*!40000 ALTER TABLE `profile_tag` DISABLE KEYS */;
INSERT INTO `profile_tag` VALUES (1,3),(1,5),(1,8),(1,9),(1,12),(1,13),(1,17);
/*!40000 ALTER TABLE `profile_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service` (
  `id` char(8) NOT NULL,
  `name` varchar(64) NOT NULL,
  `id_pattern` varchar(64) NOT NULL DEFAULT '[_[:alnum:]]+',
  `url` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES ('hateb','はてなブックマーク','[_[:alnum:]]+','http://b.hatena.ne.jp/%s/'),('ipippi','ipippi','[[:digit:]][[:digit:]]*','http://ipippi.jp/page.php?p=f_home&target_c_member_id=%d'),('mixi','mixi','[[:digit:]][[:digit:]]*','http://mixi.jp/show_friend.pl?id=%d'),('skype','Skype','[_[:alnum:]]+','skype:call?name=%s'),('twitter','twitter','[_[:alnum:]]+','http://twitter.com/%s');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `is_common` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'電気',1,'2009-09-28 22:10:47'),(2,'電子',1,'2009-09-28 22:10:47'),(3,'通信',1,'2009-09-28 22:10:47'),(4,'情報処理',1,'2009-09-28 22:10:47'),(5,'ソフトウェア',1,'2009-09-28 22:10:47'),(6,'機械',1,'2009-09-28 22:10:47'),(7,'物理',1,'2009-09-28 22:10:47'),(8,'光学',1,'2009-09-28 22:10:47'),(9,'化学',1,'2009-09-28 22:10:47'),(10,'材料',1,'2009-09-28 22:10:47'),(11,'医療',1,'2009-09-28 22:10:47'),(12,'バイオ',1,'2009-09-28 22:10:47'),(13,'ipippi',0,'2009-09-30 15:31:06'),(17,'ほげ ほげ',0,'2009-09-30 15:56:00');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `tag_count`
--

DROP TABLE IF EXISTS `tag_count`;
/*!50001 DROP VIEW IF EXISTS `tag_count`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `tag_count` (
  `id` smallint(5) unsigned,
  `name` varchar(64),
  `is_common` tinyint(3) unsigned,
  `create_date` datetime,
  `cnt` bigint(21)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `blog_feed_entry`
--

/*!50001 DROP TABLE IF EXISTS `blog_feed_entry`*/;
/*!50001 DROP VIEW IF EXISTS `blog_feed_entry`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `blog_feed_entry` AS select `feed_entry`.`id` AS `id`,`feed_entry`.`feed_id` AS `feed_id`,`feed_entry`.`name` AS `name`,`feed_entry`.`url` AS `url`,`feed_entry`.`body` AS `body`,`feed_entry`.`entry_date` AS `entry_date`,`feed`.`profile_id` AS `profile_id` from (`feed` join `feed_entry`) where ((`feed_entry`.`feed_id` = `feed`.`id`) and isnull(`feed`.`service_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tag_count`
--

/*!50001 DROP TABLE IF EXISTS `tag_count`*/;
/*!50001 DROP VIEW IF EXISTS `tag_count`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `tag_count` AS select `tag`.`id` AS `id`,`tag`.`name` AS `name`,`tag`.`is_common` AS `is_common`,`tag`.`create_date` AS `create_date`,count(`profile_tag`.`tag_id`) AS `cnt` from (`tag` left join `profile_tag` on((`tag`.`id` = `profile_tag`.`tag_id`))) group by `tag`.`id` order by `tag`.`is_common` desc,count(`profile_tag`.`tag_id`) desc,`tag`.`create_date` desc,`tag`.`name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-09-30 21:40:47
