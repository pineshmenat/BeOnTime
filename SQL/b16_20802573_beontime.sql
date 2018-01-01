-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: b16_20802573_beontime
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.17.10.1

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
-- Table structure for table `companylocationmaster`
--

DROP TABLE IF EXISTS `companylocationmaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companylocationmaster` (
  `CompanyLocationId` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyId` int(11) NOT NULL,
  `Address` varchar(125) NOT NULL,
  `City` varchar(20) NOT NULL,
  `Province` varchar(45) NOT NULL,
  `PostalCode` varchar(6) NOT NULL,
  `Latitude` decimal(10,8) NOT NULL,
  `Longitude` decimal(10,8) NOT NULL,
  PRIMARY KEY (`CompanyLocationId`),
  KEY `FK_companylocationmaster_CompanyId_idx` (`CompanyId`),
  CONSTRAINT `FK_companylocationmaster_CompanyId` FOREIGN KEY (`CompanyId`) REFERENCES `companymaster` (`CompanyId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10005 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companylocationmaster`
--

LOCK TABLES `companylocationmaster` WRITE;
/*!40000 ALTER TABLE `companylocationmaster` DISABLE KEYS */;
INSERT INTO `companylocationmaster` VALUES (10001,1001,'205 Humber College Blvd','Etobicoke','Ontario','M9W5L7',43.72889340,-79.60761770),(10002,1001,'206 Humber College Blvd','Etobicoke','Ontario','M9W5L7',45.11111111,-78.22222222),(10003,1002,'207 Humber College Blvd','Etobicoke','Ontario','M9W5L7',46.33333333,-78.55555555),(10004,1003,'208 Humber College Blvd','Etobicoke','Ontario','M9W5L7',43.11111111,-72.22222222);
/*!40000 ALTER TABLE `companylocationmaster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companymaster`
--

DROP TABLE IF EXISTS `companymaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companymaster` (
  `CompanyId` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(100) NOT NULL,
  `CompanyEmail` varchar(50) NOT NULL,
  `CompanyURL` varchar(50) NOT NULL,
  `CompanyPassword` varchar(50) NOT NULL,
  `CompanyStreetNumber` int(11) NOT NULL,
  `CompanyStreetName` varchar(150) NOT NULL,
  `CompanyCity` varchar(50) NOT NULL,
  `CompanyState` varchar(50) NOT NULL,
  `CompanyPostal` varchar(7) NOT NULL,
  `CompanyCountry` varchar(50) NOT NULL,
  PRIMARY KEY (`CompanyId`)
) ENGINE=InnoDB AUTO_INCREMENT=1004 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companymaster`
--

LOCK TABLES `companymaster` WRITE;
/*!40000 ALTER TABLE `companymaster` DISABLE KEYS */;
INSERT INTO `companymaster` VALUES (1001,'Bell','bell@beontime.com','www.bell.ca','password1',1,'street name 2','Toronto','Ontario','Q1Q 2W2','Canada'),(1002,'Walmart','walmart@beontime.com','www.walmart.ca','password2',2,'street name 3','Toronto','Ontario','Q1Q 2W2','Canada'),(1003,'Sunny Foodmart','sunny@beontime.com','www.sunnyfoodmart.ca','password3',4,'street name 5','Toronto','Ontario','Q1Q 2W2','Canada');
/*!40000 ALTER TABLE `companymaster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dummytable`
--

DROP TABLE IF EXISTS `dummytable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dummytable` (
  `Latitude` varchar(45) NOT NULL,
  `Longitude` varchar(45) NOT NULL,
  `City` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dummytable`
--

LOCK TABLES `dummytable` WRITE;
/*!40000 ALTER TABLE `dummytable` DISABLE KEYS */;
INSERT INTO `dummytable` VALUES ('45.6017','-73.6673','Montreal'),('43.647992','-79.370907','Toronto'),('43.667333','-79.399429','Toronto'),('45.6117','-73.6773','Montreal');
/*!40000 ALTER TABLE `dummytable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employeedesignationmaster`
--

DROP TABLE IF EXISTS `employeedesignationmaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employeedesignationmaster` (
  `empDesignationId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `empDesignationName` varchar(45) NOT NULL,
  `EntryDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) NOT NULL,
  PRIMARY KEY (`empDesignationId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employeedesignationmaster`
--

LOCK TABLES `employeedesignationmaster` WRITE;
/*!40000 ALTER TABLE `employeedesignationmaster` DISABLE KEYS */;
INSERT INTO `employeedesignationmaster` VALUES (1,'Expert','2017-12-06 00:14:34','2017-12-06 00:14:34',10001),(2,'Intermediate','2017-12-06 00:14:34','2017-12-06 00:14:34',10001),(3,'Junior','2017-12-06 00:14:34','2017-12-06 00:14:34',10001);
/*!40000 ALTER TABLE `employeedesignationmaster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rolemaster`
--

DROP TABLE IF EXISTS `rolemaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rolemaster` (
  `RoleId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(45) NOT NULL,
  `EntryDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) NOT NULL,
  PRIMARY KEY (`RoleId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rolemaster`
--

LOCK TABLES `rolemaster` WRITE;
/*!40000 ALTER TABLE `rolemaster` DISABLE KEYS */;
INSERT INTO `rolemaster` VALUES (10,'Manager','2017-12-06 00:14:34','2017-12-06 00:14:34',10001),(11,'Client','2017-12-06 00:14:34','2017-12-06 00:14:34',10001),(12,'Employee','2017-12-06 00:14:34','2017-12-06 00:14:34',10001);
/*!40000 ALTER TABLE `rolemaster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shiftmaster`
--

DROP TABLE IF EXISTS `shiftmaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shiftmaster` (
  `ShiftId` int(11) NOT NULL AUTO_INCREMENT,
  `empDesignationId` tinyint(4) NOT NULL,
  `AssignedBy` int(11) NOT NULL,
  `AssignedTo` int(11) DEFAULT NULL,
  `CompanyId` int(11) NOT NULL,
  `CompanyLocationId` int(11) NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `ActualWorkingStartTime` datetime DEFAULT NULL,
  `ActualWorkingEndTime` datetime DEFAULT NULL,
  `EntryDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ShiftStatus` varchar(1) NOT NULL,
  `SpecialNote` varchar(150) DEFAULT NULL,
  `WorkplaceLat` decimal(10,8) DEFAULT NULL,
  `WorkplaceLong` decimal(10,8) DEFAULT NULL,
  `LogInLat` decimal(10,8) DEFAULT NULL,
  `LogInLong` decimal(10,8) DEFAULT NULL,
  `LogOutLat` decimal(10,8) DEFAULT NULL,
  `LogOutLong` decimal(10,8) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ShiftId`),
  KEY `FK_shiftmaster_empDesignation_Idx` (`empDesignationId`),
  KEY `FK_shiftmaster_AssignedBy_idx` (`AssignedBy`),
  KEY `FK_shiftmaster_AssignedTo_idx` (`AssignedTo`),
  KEY `FK_shiftmaster_CompanyId_idx` (`CompanyId`),
  KEY `FK_shiftmaster_CompanyLocationId_idx` (`CompanyLocationId`),
  CONSTRAINT `FK_shiftmaster_AssignedBy` FOREIGN KEY (`AssignedBy`) REFERENCES `usermaster` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_shiftmaster_AssignedTo` FOREIGN KEY (`AssignedTo`) REFERENCES `usermaster` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_shiftmaster_CompanyId` FOREIGN KEY (`CompanyId`) REFERENCES `companymaster` (`CompanyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_shiftmaster_CompanyLocationId` FOREIGN KEY (`CompanyLocationId`) REFERENCES `companylocationmaster` (`CompanyLocationId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_shiftmaster_empDesignationId` FOREIGN KEY (`empDesignationId`) REFERENCES `employeedesignationmaster` (`empDesignationId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=500004 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shiftmaster`
--

LOCK TABLES `shiftmaster` WRITE;
/*!40000 ALTER TABLE `shiftmaster` DISABLE KEYS */;
INSERT INTO `shiftmaster` VALUES (500001,1,10001,10005,1001,10001,'2017-12-30 20:55:00','2017-12-30 23:59:00',NULL,NULL,'2017-11-20 09:00:00','2017-11-20 09:00:00','N',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(500002,2,10001,NULL,1001,10002,'2017-12-31 15:55:00','2017-12-31 20:59:00',NULL,NULL,'2017-11-20 09:00:00','2017-11-20 09:00:00','N',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(500003,1,10001,NULL,1002,10003,'2018-01-02 09:00:00','2018-01-02 16:00:00',NULL,NULL,'2017-11-20 09:00:00','2017-11-20 09:00:00','N',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `shiftmaster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usermaster`
--

DROP TABLE IF EXISTS `usermaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usermaster` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `RoleId` tinyint(4) NOT NULL,
  `CompanyId` int(11) NOT NULL,
  `empDesignationId` tinyint(4) NOT NULL,
  `UserName` varchar(45) NOT NULL,
  `Password` varbinary(150) NOT NULL,
  `PasswordExpiry` datetime NOT NULL,
  `PasswordCounter` tinyint(4) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `FirstLogin` bit(1) NOT NULL,
  `UserStatus` tinyint(4) NOT NULL,
  `EMail` varchar(65) NOT NULL,
  `SIN` int(11) NOT NULL,
  `Address` varchar(150) NOT NULL,
  `City` varchar(45) NOT NULL,
  `Province` varchar(45) NOT NULL,
  `PostalCode` varchar(6) NOT NULL,
  `DesiredDay` varchar(7) DEFAULT NULL,
  `RegistrationDate` datetime NOT NULL,
  `EntryDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModDateTime` varchar(45) NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
  PRIMARY KEY (`UserId`),
  KEY `FK_usermaster_RoleId_idx` (`RoleId`),
  KEY `FK_usermaster_CompanyId_idx` (`CompanyId`),
  KEY `FK_usermaster_empDesignation_Idx` (`empDesignationId`),
  CONSTRAINT `FK_usermaster_CompanyId` FOREIGN KEY (`CompanyId`) REFERENCES `companymaster` (`CompanyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_usermaster_RoleId` FOREIGN KEY (`RoleId`) REFERENCES `rolemaster` (`RoleId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_usermaster_empDesignationId` FOREIGN KEY (`empDesignationId`) REFERENCES `employeedesignationmaster` (`empDesignationId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10014 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usermaster`
--

LOCK TABLES `usermaster` WRITE;
/*!40000 ALTER TABLE `usermaster` DISABLE KEYS */;
INSERT INTO `usermaster` VALUES (10001,10,1001,0,'fzhongjie','123','2018-01-01 00:00:00',0,'Zhongjie','Fan','\0',0,'fzhongjie@msn.com',123456789,'205 Humber College Blvd','Toronto','Ontario','M9W5L7',NULL,'2017-12-06 18:59:32','2017-12-06 18:59:32','CURRENT_TIMESTAMP'),(10002,10,1001,0,'pineshmenat','123','2018-01-01 00:00:00',0,'Pinesh','Menat','\0',0,'pineshmenat@gmail.com',123456789,'205 Humber College Blvd','Toronto','Ontario','M9W5L7',NULL,'2017-12-06 18:59:32','2017-12-06 18:59:32','CURRENT_TIMESTAMP'),(10003,10,1001,0,'manager1','123','2018-01-01 00:00:00',0,'f1','l1','\0',0,'fzhongjie@msn.com',123456789,'205 Humber College Blvd','Toronto','Ontario','M9W5L7',NULL,'2017-12-06 18:59:32','2017-12-06 18:59:32','CURRENT_TIMESTAMP'),(10004,11,1001,0,'vaishnavi','123','2018-01-01 00:00:00',0,'f2','l2','\0',0,'fzhongjie@msn.com',123456789,'205 Humber College Blvd','Toronto','Ontario','M9W5L7',NULL,'2017-12-07 21:54:14','2017-12-07 21:54:14','CURRENT_TIMESTAMP'),(10005,12,1001,2,'employee1','123','2018-01-01 00:00:00',0,'f3','l3','\0',0,'fzhongjie@msn.com',123456789,'205 Humber College Blvd','Toronto','Ontario','M9W5L7','0000011','2017-12-06 18:59:32','2017-12-06 18:59:32','CURRENT_TIMESTAMP'),(10006,11,1002,0,'client2','123','2018-01-01 00:00:00',0,'f4','l4','\0',0,'fzhongjie@msn.com',123456789,'205 Humber College Blvd','Toronto','Ontario','M9W5L7',NULL,'2017-12-06 18:59:33','2017-12-06 18:59:33','CURRENT_TIMESTAMP'),(10007,12,1002,3,'employee2','123','2018-01-01 00:00:00',0,'f5','l5','\0',0,'fzhongjie@msn.com',123456789,'205 Humber College Blvd','Toronto','Ontario','M9W5L7','1111111','2017-12-06 18:59:33','2017-12-06 18:59:33','CURRENT_TIMESTAMP'),(10008,12,1003,1,'employee3','123','2019-01-01 00:00:00',0,'f6','l6','\0',0,'fzhongjie@msn.com',123456789,'240 McLeod St','Ottawa','Ontario','K2P2R1','0000011','2017-12-06 18:59:33','2017-12-06 18:59:33','CURRENT_TIMESTAMP'),(10009,12,1001,2,'employee4','123','2019-01-01 00:00:00',0,'f7','l7','\0',0,'fzhongjie@msn.com',123456789,'4555 Erie Ave','Niagara Fall','Ontario','L2E7G9','1000010','2017-12-06 18:59:33','2017-12-06 18:59:33','CURRENT_TIMESTAMP'),(10010,12,1003,3,'employee5','123','2019-01-01 00:00:00',0,'f8','l8','\0',0,'fzhongjie@msn.com',123456789,'88 Bronte College Ct','Mississauga','Ontario','L5B1M9','1100010','2017-12-06 18:59:33','2017-12-06 18:59:33','CURRENT_TIMESTAMP'),(10011,12,1002,1,'employee6','123','2019-01-01 00:00:00',0,'f9','l9','\0',0,'fzhongjie@msn.com',123456789,'680 Rexdale Blvd','Toronto','Ontario','M9W6T4','1000001','2017-12-06 18:59:33','2017-12-06 18:59:33','CURRENT_TIMESTAMP'),(10013,10,1001,2,'jsmith','123','2018-01-01 00:00:00',0,'Jason','Smith','\0',0,'jsmith@mail.com',123456789,'205 Humber College Blvd','Toronto','Ontario','M9W5L7',NULL,'2017-12-22 22:15:31','2017-12-22 22:15:31','CURRENT_TIMESTAMP');
/*!40000 ALTER TABLE `usermaster` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-31 20:24:26
