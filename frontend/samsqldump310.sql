-- MySQL dump 10.13  Distrib 8.0.23, for Linux (x86_64)
 --
 -- Host: localhost    Database: FantasySports
 -- ------------------------------------------------------
 -- Server version	8.0.23-0ubuntu0.20.04.1

 /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
 /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
 /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 /*!50503 SET NAMES utf8mb4 */;
 /*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
 /*!40103 SET TIME_ZONE='+00:00' */;
 /*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
 /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
 /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
 /*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

 --
 -- Table structure for table `ApiGame`
 --

 DROP TABLE IF EXISTS `ApiGame`;
 /*!40101 SET @saved_cs_client     = @@character_set_client */;
 /*!50503 SET character_set_client = utf8mb4 */;
 CREATE TABLE `ApiGame` (
   `GameId` int NOT NULL AUTO_INCREMENT,
   `ApiGameId` varchar(255) DEFAULT NULL,
   `HomeTeam` varchar(255) DEFAULT NULL,
   `AwayTeam` varchar(255) DEFAULT NULL,
   PRIMARY KEY (`GameId`)
 ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;
 /*!40101 SET character_set_client = @saved_cs_client */;

 --
 -- Dumping data for table `ApiGame`
 --

 LOCK TABLES `ApiGame` WRITE;
 /*!40000 ALTER TABLE `ApiGame` DISABLE KEYS */;
 INSERT INTO `ApiGame` VALUES (1,'a5d48aa3-df24-424d-973e-f9b280287831','Memphis Grizzlies','Washington Wizards'),(2,'ed238559-8f25-40fd-96e0-07450e995186','Dallas Mavericks','San Antonio Spurs');
 /*!40000 ALTER TABLE `ApiGame` ENABLE KEYS */;
 UNLOCK TABLES;

 --
 -- Table structure for table `BBStatLine`
 --

 DROP TABLE IF EXISTS `BBStatLine`;
 /*!40101 SET @saved_cs_client     = @@character_set_client */;
 /*!50503 SET character_set_client = utf8mb4 */;
 CREATE TABLE `BBStatLine` (
   `BBStatLineID` int NOT NULL AUTO_INCREMENT,
   `PlayerID` int NOT NULL,
   `StatDate` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   `Point` double(10,3) NOT NULL,
   `Assists` double(10,3) NOT NULL,
   `Rebounds` double(10,3) NOT NULL,
   `Steals` double(10,3) NOT NULL,
   `Blocks` double(10,3) NOT NULL,
   `FgPercent` double(10,3) NOT NULL,
   `TptPercent` double(10,3) NOT NULL,
   `FtPercent` double(10,3) NOT NULL,
   `FullName` varchar(255) DEFAULT NULL,
   PRIMARY KEY (`BBStatLineID`),
   KEY `PlayerID` (`PlayerID`),
   CONSTRAINT `BBStatLine_ibfk_1` FOREIGN KEY (`PlayerID`) REFERENCES `Player` (`PlayerID`)
 ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;
 /*!40101 SET character_set_client = @saved_cs_client */;

 --
 -- Dumping data for table `BBStatLine`
 --

 LOCK TABLES `BBStatLine` WRITE;
 /*!40000 ALTER TABLE `BBStatLine` DISABLE KEYS */;
 INSERT INTO `BBStatLine` VALUES (1,695,'2021-03-08 13:18:39',29.000,14.000,10.000,3.000,1.000,0.667,0.500,0.714,NULL);
 /*!40000 ALTER TABLE `BBStatLine` ENABLE KEYS */;
 UNLOCK TABLES;

 --
 -- Table structure for table `League`
 --

 DROP TABLE IF EXISTS `League`;
 /*!40101 SET @saved_cs_client     = @@character_set_client */;
 /*!50503 SET character_set_client = utf8mb4 */;
 CREATE TABLE `League` (
   `LeagueID` int NOT NULL AUTO_INCREMENT,
   `LeagueName` varchar(255) NOT NULL,
   `CreatorID` int DEFAULT NULL,
   `CreatorName` varchar(255) DEFAULT NULL,
   PRIMARY KEY (`LeagueID`),
   UNIQUE KEY `LeagueName` (`LeagueName`)
 ) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 ;
 /*!40101 SET character_set_client = @saved_cs_client */;

 --
 -- Dumping data for table `League`
 --

 LOCK TABLES `League` WRITE;
 /*!40000 ALTER TABLE `League` DISABLE KEYS */;
 INSERT INTO `League` VALUES (1,'FirstLeague',NULL,NULL),(2,'secondleague',NULL,NULL),(26,'bro',1,'testUser'),(27,'testing again',1,'testUser'),(28,'testing alert',1,'testUser'),(29,'pls for the love of God',1,'testUser'),(30,'trying 1 more time',1,'testUser'),(31,'new leagueeeee',1,'testUser'),(32,'newest league rn',1,'testUser'),(33,'im tired',1,'testUser'),(36,'plssss',1,'testUser'),(37,'fuck this man',1,'testUser'),(38,'this is like my 12th try',1,'testUser'),(39,'13th try i guess',1,'testUser'),(40,'trying refresh',1,'testUser'),(42,'trying refresh!',1,'testUser'),(43,'can it work',1,'testUser'),(44,'good',1,'testUser'),(46,'testing alert pop up',1,'testUser');
 /*!40000 ALTER TABLE `League` ENABLE KEYS */;
 UNLOCK TABLES;

 --
 -- Table structure for table `Player`
 --

 DROP TABLE IF EXISTS `Player`;
 /*!40101 SET @saved_cs_client     = @@character_set_client */;
 /*!50503 SET character_set_client = utf8mb4 */;
 CREATE TABLE `Player` (
   `PlayerID` int NOT NULL AUTO_INCREMENT,
   `FirstName` varchar(255) DEFAULT NULL,
   `LastName` varchar(255) DEFAULT NULL,
   `FullName` varchar(255) NOT NULL,
   `ActualTeam` varchar(255) DEFAULT 'Free Agent',
   `Age` int DEFAULT NULL,
   `TeamID` int DEFAULT '0',
   `ApiId` varchar(255) DEFAULT NULL,
   `AbvTeam` varchar(255) DEFAULT NULL,
   `Position` varchar(255) DEFAULT NULL,
   PRIMARY KEY (`PlayerID`),
   KEY `TeamID` (`TeamID`)
 ) ENGINE=InnoDB AUTO_INCREMENT=1015 DEFAULT CHARSET=utf8mb4 ;
 /*!40101 SET character_set_client = @saved_cs_client */;

 --
 -- Dumping data for table `Player`
 --

 LOCK TABLES `Player` WRITE;
 /*!40000 ALTER TABLE `Player` DISABLE KEYS */;
 INSERT INTO `Player` VALUES (513,NULL,NULL,'Precious Achiuwa','Miami',21,2,NULL,'Mia','F'),(514,NULL,NULL,'Jaylen Adams','Milwaukee',25,1,NULL,'Mil','G'),(515,NULL,NULL,'Steven Adams','New Orleans',28,1,NULL,'Nor','C'),(516,NULL,NULL,'Bam Adebayo','Miami',24,0,NULL,'Mia','C'),(517,NULL,NULL,'LaMarcus Aldridge','San Antonio',36,0,NULL,'San','C'),(518,NULL,NULL,'Ty-Shon Alexander','Phoenix',23,0,NULL,'Pho','G'),(519,NULL,NULL,'Nickeil Alexander-Walker','New Orleans',23,0,NULL,'Nor','G'),(520,NULL,NULL,'Grayson Allen','Memphis',25,0,NULL,'Mem','G');
 /*!40000 ALTER TABLE `Player` ENABLE KEYS */;
 UNLOCK TABLES;

 --
 -- Table structure for table `PlayerImport`
 --

 DROP TABLE IF EXISTS `PlayerImport`;
 /*!40101 SET @saved_cs_client     = @@character_set_client */;
 /*!50503 SET character_set_client = utf8mb4 */;
 CREATE TABLE `PlayerImport` (
   `Rank` int DEFAULT NULL,
   `FullName` varchar(255) DEFAULT NULL,
   `AbvTeam` varchar(255) DEFAULT NULL,
   `Team` varchar(255) DEFAULT NULL,
   `Pos` varchar(255) DEFAULT NULL,
   `Age` int DEFAULT NULL,
   `Ft` double(10,5) DEFAULT NULL,
   `Tp` double(10,5) DEFAULT NULL,
   `Fg` double(10,5) DEFAULT NULL,
   `Ppg` double(10,5) DEFAULT NULL,
   `Rpg` double(10,5) DEFAULT NULL,
   `Apg` double(10,5) DEFAULT NULL,
   `Spg` double(10,5) DEFAULT NULL,
   `Bpg` double(10,5) DEFAULT NULL
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
 /*!40101 SET character_set_client = @saved_cs_client */;

 --
 -- Dumping data for table `PlayerImport`
 --

 LOCK TABLES `PlayerImport` WRITE;
 /*!40000 ALTER TABLE `PlayerImport` DISABLE KEYS */;
 INSERT INTO `PlayerImport` VALUES (1,'Precious Achiuwa','Mia','Miami','F',21,0.55700,0.00000,0.58100,6.10000,4.00000,0.60000,0.39000,0.55000),(2,'Jaylen Adams','Mil','Milwaukee','G',25,0.00000,0.00000,0.12500,0.30000,0.40000,0.30000,0.00000,0.00000),(3,'Steven Adams','Nor','New Orleans','C',28,0.45700,0.00000,0.60900,8.10000,9.20000,2.20000,0.94000,0.61000),(4,'Bam Adebayo','Mia','Miami','C',24,0.84700,0.33300,0.56900,19.50000,9.70000,5.50000,0.91000,1.06000),(5,'LaMarcus Aldridge','San','San Antonio','C',36,0.83800,0.36000,0.51800,13.70000,4.50000,1.70000,0.38000,0.86000),(6,'Ty-Shon Alexander','Pho','Phoenix','G',23,0.00000,0.00000,0.00000,0.00000,0.30000,0.30000,0.00000,0.00000),(7,'Nickeil Alexander-Walker','Nor','New Orleans','G',23,0.78800,0.29700,0.48500,8.00000,2.30000,1.90000,1.00000,0.30000),(8,'Grayson Allen','Mem','Memphis','G',25,0.89500,0.40700,0.54900,9.30000,2.80000,2.20000,1.00000,0.13000);
 /*!40000 ALTER TABLE `PlayerImport` ENABLE KEYS */;
 UNLOCK TABLES;

 --
 -- Table structure for table `Relation`
 --

 DROP TABLE IF EXISTS `Relation`;
 /*!40101 SET @saved_cs_client     = @@character_set_client */;
 /*!50503 SET character_set_client = utf8mb4 */;
 CREATE TABLE `Relation` (
   `from` varchar(255) NOT NULL,
   `to` varchar(255) NOT NULL,
   `status` varchar(255) NOT NULL,
   `since` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`from`,`to`,`status`),
   KEY `since` (`since`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
 /*!40101 SET character_set_client = @saved_cs_client */;

 --
 -- Dumping data for table `Relation`
 --

 LOCK TABLES `Relation` WRITE;
 /*!40000 ALTER TABLE `Relation` DISABLE KEYS */;
 INSERT INTO `Relation` VALUES ('michiinunez','testUser','F','2021-03-10 14:03:57'),('testUser','michiinunez','F','2021-03-10 14:03:57'),('mnunez','testUser','F','2021-03-10 14:39:33'),('testUser','mnunez','F','2021-03-10 14:39:33'),('mnunez','michii','F','2021-03-10 14:40:21'),('michii','mnunez','F','2021-03-10 14:40:30'),('testUser','SecUser','F','2021-03-10 14:41:25'),('SecUser','testUser','F','2021-03-10 14:41:43'),('SecUser','neverUsed','F','2021-03-10 14:42:54'),('neverUsed','SecUser','F','2021-03-10 14:43:02');
 /*!40000 ALTER TABLE `Relation` ENABLE KEYS */;
 UNLOCK TABLES;

 --
 -- Table structure for table `Team`
 --

 DROP TABLE IF EXISTS `Team`;
 /*!40101 SET @saved_cs_client     = @@character_set_client */;
 /*!50503 SET character_set_client = utf8mb4 */;
 CREATE TABLE `Team` (
   `TeamID` int NOT NULL AUTO_INCREMENT,
   `LeagueID` int DEFAULT NULL,
   `UserID` int DEFAULT NULL,
   `TeamName` varchar(255) NOT NULL,
   `Wins` int NOT NULL DEFAULT '0',
   `Losses` int NOT NULL DEFAULT '0',
   `Ties` int NOT NULL DEFAULT '0',
   PRIMARY KEY (`TeamID`),
   KEY `UserID` (`UserID`),
   KEY `LeagueID` (`LeagueID`),
   CONSTRAINT `Team_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`)
 ) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 ;
 /*!40101 SET character_set_client = @saved_cs_client */;

 --
 -- Dumping data for table `Team`
 --

 LOCK TABLES `Team` WRITE;
 /*!40000 ALTER TABLE `Team` DISABLE KEYS */;
 INSERT INTO `Team` VALUES (1,1,1,'testTeam',0,0,0),(2,1,2,'Of The Eyes',0,0,0),(3,2,1,'yikes',0,0,0),(11,26,1,'Team testUser',0,0,0),(12,26,3,'Team mnunez',0,0,0),(13,26,4,'Team michiinunez',0,0,0),(14,26,5,'Team neverUsed',0,0,0),(15,27,1,'Team testUser',0,0,0),(16,27,4,'Team michiinunez',0,0,0),(17,28,1,'Team testUser',0,0,0),(18,28,4,'Team michiinunez',0,0,0),(19,28,3,'Team mnunez',0,0,0),(20,29,1,'Team testUser',0,0,0),(21,29,4,'Team michiinunez',0,0,0),(22,29,3,'Team mnunez',0,0,0),(23,30,1,'Team testUser',0,0,0),(24,30,5,'Team neverUsed',0,0,0),(25,30,3,'Team mnunez',0,0,0),(26,31,1,'Team testUser',0,0,0),(27,31,3,'Team mnunez',0,0,0),(28,32,1,'Team testUser',0,0,0),(29,32,5,'Team neverUsed',0,0,0),(30,33,1,'Team testUser',0,0,0),(31,33,4,'Team michiinunez',0,0,0),(32,36,1,'Team testUser',0,0,0),(33,36,3,'Team mnunez',0,0,0),(34,37,1,'Team testUser',0,0,0),(35,37,3,'Team mnunez',0,0,0),(36,38,1,'Team testUser',0,0,0),(37,38,3,'Team mnunez',0,0,0),(38,39,1,'Team testUser',0,0,0),(39,39,3,'Team mnunez',0,0,0),(40,40,1,'Team testUser',0,0,0),(41,40,5,'Team neverUsed',0,0,0),(42,42,1,'Team testUser',0,0,0),(43,42,5,'Team neverUsed',0,0,0),(44,43,1,'Team testUser',0,0,0),(45,43,2,'Team SecUser',0,0,0),(46,44,1,'Team testUser',0,0,0),(47,44,4,'Team michiinunez',0,0,0),(48,46,1,'Team testUser',0,0,0),(49,46,4,'Team michiinunez',0,0,0),(50,46,3,'Team mnunez',0,0,0);
 /*!40000 ALTER TABLE `Team` ENABLE KEYS */;
 UNLOCK TABLES;

 --
 -- Table structure for table `UserHistory`
 --

 DROP TABLE IF EXISTS `UserHistory`;
 /*!40101 SET @saved_cs_client     = @@character_set_client */;
 /*!50503 SET character_set_client = utf8mb4 */;
 CREATE TABLE `UserHistory` (
   `UserID` int DEFAULT NULL,
   `TeamID` int DEFAULT NULL,
   `LeagueID` int DEFAULT NULL
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
 /*!40101 SET character_set_client = @saved_cs_client */;

 --
 -- Dumping data for table `UserHistory`
 --

 LOCK TABLES `UserHistory` WRITE;
 /*!40000 ALTER TABLE `UserHistory` DISABLE KEYS */;
 /*!40000 ALTER TABLE `UserHistory` ENABLE KEYS */;
 UNLOCK TABLES;

 --
 -- Table structure for table `Users`
 --

 DROP TABLE IF EXISTS `Users`;
 /*!40101 SET @saved_cs_client     = @@character_set_client */;
 /*!50503 SET character_set_client = utf8mb4 */;
 CREATE TABLE `Users` (
   `UserID` int NOT NULL AUTO_INCREMENT,
   `Username` varchar(255) NOT NULL,
   `Password` varchar(255) NOT NULL,
   `FirstName` varchar(255) NOT NULL,
   `LastName` varchar(255) NOT NULL,
   `email` varchar(255) DEFAULT NULL,
   PRIMARY KEY (`UserID`),
   UNIQUE KEY `Username` (`Username`)
 ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
 /*!40101 SET character_set_client = @saved_cs_client */;

 --
 -- Dumping data for table `Users`
 --

 LOCK TABLES `Users` WRITE;
 /*!40000 ALTER TABLE `Users` DISABLE KEYS */;
 INSERT INTO `Users` VALUES (1,'testUser','testPass','Our','Test',NULL),(2,'SecUser','Pass','Tony','Delvecchio',NULL),(3,'mnunez','1234','Michelle','Nunez',NULL),(4,'michiinunez','1234','michii','nunez',NULL),(5,'neverUsed','1234','Michii','Nunez',NULL),(6,'michii','1234','mich','nune',NULL);
 /*!40000 ALTER TABLE `Users` ENABLE KEYS */;
 UNLOCK TABLES;
 /*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

 /*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
 /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
 /*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
 /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
 /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
 /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
 /*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

 -- Dump completed on 2021-03-10 17:21:44
