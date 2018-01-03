-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql210.byetcluster.com
-- Generation Time: Jan 03, 2018 at 04:51 PM
-- Server version: 5.6.35-81.0
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b16_20802573_beontime`
--

-- --------------------------------------------------------

--
-- Table structure for table `companylocationmaster`
--

CREATE TABLE IF NOT EXISTS `companylocationmaster` (
  `CompanyLocationId` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyId` int(11) NOT NULL,
  `Address` varchar(125) NOT NULL,
  `City` varchar(20) NOT NULL,
  `Province` varchar(45) NOT NULL,
  `PostalCode` varchar(6) NOT NULL,
  `Latitude` decimal(11,8) NOT NULL,
  `Longitude` decimal(11,8) NOT NULL,
  PRIMARY KEY (`CompanyLocationId`),
  KEY `FK_companylocationmaster_CompanyId_idx` (`CompanyId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10005 ;

--
-- Dumping data for table `companylocationmaster`
--

INSERT INTO `companylocationmaster` (`CompanyLocationId`, `CompanyId`, `Address`, `City`, `Province`, `PostalCode`, `Latitude`, `Longitude`) VALUES
(10001, 1001, '205 Humber College Blvd', 'Etobicoke', 'Ontario', 'M9W5L7', '43.72889340', '-79.60761770'),
(10002, 1001, '206 Humber College Blvd', 'Etobicoke', 'Ontario', 'M9W5L7', '45.11111111', '-78.22222222'),
(10003, 1002, '207 Humber College Blvd', 'Etobicoke', 'Ontario', 'M9W5L7', '46.33333333', '-78.55555555'),
(10004, 1003, '208 Humber College Blvd', 'Etobicoke', 'Ontario', 'M9W5L7', '43.11111111', '-72.22222222');

-- --------------------------------------------------------

--
-- Table structure for table `companymaster`
--

CREATE TABLE IF NOT EXISTS `companymaster` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1004 ;

--
-- Dumping data for table `companymaster`
--

INSERT INTO `companymaster` (`CompanyId`, `CompanyName`, `CompanyEmail`, `CompanyURL`, `CompanyPassword`, `CompanyStreetNumber`, `CompanyStreetName`, `CompanyCity`, `CompanyState`, `CompanyPostal`, `CompanyCountry`) VALUES
(1001, 'Bell', 'bell@beontime.com', 'www.bell.ca', 'password1', 1, 'street name 2', 'Toronto', 'Ontario', 'Q1Q 2W2', 'Canada'),
(1002, 'Walmart', 'walmart@beontime.com', 'www.walmart.ca', 'password2', 2, 'street name 3', 'Toronto', 'Ontario', 'Q1Q 2W2', 'Canada'),
(1003, 'Sunny Foodmart', 'sunny@beontime.com', 'www.sunnyfoodmart.ca', 'password3', 4, 'street name 5', 'Toronto', 'Ontario', 'Q1Q 2W2', 'Canada');

-- --------------------------------------------------------

--
-- Table structure for table `dummytable`
--

CREATE TABLE IF NOT EXISTS `dummytable` (
  `Latitude` varchar(45) NOT NULL,
  `Longitude` varchar(45) NOT NULL,
  `City` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dummytable`
--

INSERT INTO `dummytable` (`Latitude`, `Longitude`, `City`) VALUES
('45.6017', '-73.6673', 'Montreal'),
('43.647992', '-79.370907', 'Toronto'),
('43.667333', '-79.399429', 'Toronto'),
('45.6117', '-73.6773', 'Montreal');

-- --------------------------------------------------------

--
-- Table structure for table `employeedesignationmaster`
--

CREATE TABLE IF NOT EXISTS `employeedesignationmaster` (
  `empDesignationId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `empDesignationName` varchar(45) NOT NULL,
  `EntryDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) NOT NULL,
  PRIMARY KEY (`empDesignationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `employeedesignationmaster`
--

INSERT INTO `employeedesignationmaster` (`empDesignationId`, `empDesignationName`, `EntryDateTime`, `ModDateTime`, `ModifiedBy`) VALUES
(1, 'Expert', '2017-12-06 00:14:34', '2017-12-06 00:14:34', 10001),
(2, 'Intermediate', '2017-12-06 00:14:34', '2017-12-06 00:14:34', 10001),
(3, 'Junior', '2017-12-06 00:14:34', '2017-12-06 00:14:34', 10001);

-- --------------------------------------------------------

--
-- Table structure for table `rolemaster`
--

CREATE TABLE IF NOT EXISTS `rolemaster` (
  `RoleId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(45) NOT NULL,
  `EntryDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) NOT NULL,
  PRIMARY KEY (`RoleId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `rolemaster`
--

INSERT INTO `rolemaster` (`RoleId`, `RoleName`, `EntryDateTime`, `ModDateTime`, `ModifiedBy`) VALUES
(10, 'Manager', '2017-12-06 00:14:34', '2017-12-06 00:14:34', 10001),
(11, 'Client', '2017-12-06 00:14:34', '2017-12-06 00:14:34', 10001),
(12, 'Employee', '2017-12-06 00:14:34', '2017-12-06 00:14:34', 10001);

-- --------------------------------------------------------

--
-- Table structure for table `shiftmaster`
--

CREATE TABLE IF NOT EXISTS `shiftmaster` (
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
  `CurrentLat` decimal(11,8) DEFAULT NULL,
  `CurrentLong` decimal(11,8) DEFAULT NULL,
  `LogInLat` decimal(11,8) DEFAULT NULL,
  `LogInLong` decimal(11,8) DEFAULT NULL,
  `LogOutLat` decimal(11,8) DEFAULT NULL,
  `LogOutLong` decimal(11,8) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ShiftId`),
  KEY `FK_shiftmaster_empDesignation_Idx` (`empDesignationId`),
  KEY `FK_shiftmaster_AssignedBy_idx` (`AssignedBy`),
  KEY `FK_shiftmaster_AssignedTo_idx` (`AssignedTo`),
  KEY `FK_shiftmaster_CompanyId_idx` (`CompanyId`),
  KEY `FK_shiftmaster_CompanyLocationId_idx` (`CompanyLocationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=500008 ;

--
-- Dumping data for table `shiftmaster`
--

INSERT INTO `shiftmaster` (`ShiftId`, `empDesignationId`, `AssignedBy`, `AssignedTo`, `CompanyId`, `CompanyLocationId`, `StartTime`, `EndTime`, `ActualWorkingStartTime`, `ActualWorkingEndTime`, `EntryDateTime`, `ModDateTime`, `ShiftStatus`, `SpecialNote`, `CurrentLat`, `CurrentLong`, `LogInLat`, `LogInLong`, `LogOutLat`, `LogOutLong`, `City`) VALUES
(500001, 1, 10001, 10005, 1001, 10001, '2017-11-18 09:00:00', '2017-11-18 14:00:00', NULL, NULL, '2017-12-06 00:16:51', '2017-12-06 00:16:51', 'N', NULL, '43.65389990', '-79.38113870', NULL, NULL, NULL, NULL, 'Toronto'),
(500002, 2, 10001, 10007, 1002, 10003, '2017-11-20 09:00:00', '2017-11-20 14:00:00', NULL, NULL, '2017-12-06 00:16:51', '2017-12-06 00:16:51', 'A', NULL, '43.64662060', '-79.38857800', NULL, NULL, NULL, NULL, 'Toronto'),
(500003, 3, 10001, 10007, 1001, 10002, '2017-11-21 07:00:00', '2017-11-21 12:00:00', NULL, NULL, '2017-12-06 00:16:51', '2017-12-06 00:16:51', 'R', NULL, '43.63562720', '-79.41721870', NULL, NULL, NULL, NULL, NULL),
(500004, 1, 10001, 10007, 1001, 10001, '2017-12-16 17:03:00', '2017-12-16 22:00:00', NULL, NULL, '2017-11-20 09:00:00', '2017-11-20 09:00:00', 'A', NULL, '43.64097800', '-79.35685930', NULL, NULL, NULL, NULL, NULL),
(500006, 1, 10001, 10007, 1001, 10001, '2018-01-01 22:40:00', '2018-01-01 23:50:00', '2018-01-01 23:01:44', '2018-01-01 23:05:01', '2017-11-20 09:00:00', '2017-11-20 09:00:00', 'R', NULL, '43.63039040', '-79.65433450', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usermaster`
--

CREATE TABLE IF NOT EXISTS `usermaster` (
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
  KEY `FK_usermaster_empDesignation_Idx` (`empDesignationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10014 ;

--
-- Dumping data for table `usermaster`
--

INSERT INTO `usermaster` (`UserId`, `RoleId`, `CompanyId`, `empDesignationId`, `UserName`, `Password`, `PasswordExpiry`, `PasswordCounter`, `FirstName`, `LastName`, `FirstLogin`, `UserStatus`, `EMail`, `SIN`, `Address`, `City`, `Province`, `PostalCode`, `DesiredDay`, `RegistrationDate`, `EntryDateTime`, `ModDateTime`) VALUES
(10001, 10, 1001, 0, 'fzhongjie', '123', '2018-01-01 00:00:00', 0, 'Zhongjie', 'Fan', b'0', 0, 'fzhongjie@msn.com', 123456789, '205 Humber College Blvd', 'Toronto', 'Ontario', 'M9W5L7', NULL, '2017-12-06 18:59:32', '2017-12-06 18:59:32', 'CURRENT_TIMESTAMP'),
(10002, 10, 1001, 0, 'pineshmenat', '123', '2018-01-01 00:00:00', 0, 'Pinesh', 'Menat', b'0', 0, 'pineshmenat@gmail.com', 123456789, '205 Humber College Blvd', 'Toronto', 'Ontario', 'M9W5L7', NULL, '2017-12-06 18:59:32', '2017-12-06 18:59:32', 'CURRENT_TIMESTAMP'),
(10003, 10, 1001, 0, 'manager1', '123', '2018-01-01 00:00:00', 0, 'f1', 'l1', b'0', 0, 'fzhongjie@msn.com', 123456789, '205 Humber College Blvd', 'Toronto', 'Ontario', 'M9W5L7', NULL, '2017-12-06 18:59:32', '2017-12-06 18:59:32', 'CURRENT_TIMESTAMP'),
(10004, 11, 1001, 0, 'vaishnavi', '123', '2018-01-01 00:00:00', 0, 'f2', 'l2', b'0', 0, 'fzhongjie@msn.com', 123456789, '205 Humber College Blvd', 'Toronto', 'Ontario', 'M9W5L7', NULL, '2017-12-07 21:54:14', '2017-12-07 21:54:14', 'CURRENT_TIMESTAMP'),
(10005, 12, 1001, 2, 'employee1', '123', '2018-01-01 00:00:00', 0, 'f3', 'l3', b'0', 0, 'fzhongjie@msn.com', 123456789, '205 Humber College Blvd', 'Toronto', 'Ontario', 'M9W5L7', '0000011', '2017-12-06 18:59:32', '2017-12-06 18:59:32', 'CURRENT_TIMESTAMP'),
(10006, 11, 1002, 0, 'client2', '123', '2018-01-01 00:00:00', 0, 'f4', 'l4', b'0', 0, 'fzhongjie@msn.com', 123456789, '205 Humber College Blvd', 'Toronto', 'Ontario', 'M9W5L7', NULL, '2017-12-06 18:59:33', '2017-12-06 18:59:33', 'CURRENT_TIMESTAMP'),
(10007, 12, 1002, 3, 'employee2', '123', '2018-01-01 00:00:00', 0, 'Jack', 'Smith', b'0', 0, 'fzhongjie@msn.com', 123456789, '205 Humber College Blvd', 'Toronto', 'Ontario', 'M9W5L7', '1111111', '2017-12-06 18:59:33', '2017-12-06 18:59:33', 'CURRENT_TIMESTAMP'),
(10008, 12, 1003, 1, 'employee3', '123', '2019-01-01 00:00:00', 0, 'f6', 'l6', b'0', 0, 'fzhongjie@msn.com', 123456789, '240 McLeod St', 'Ottawa', 'Ontario', 'K2P2R1', '0000011', '2017-12-06 18:59:33', '2017-12-06 18:59:33', 'CURRENT_TIMESTAMP'),
(10009, 12, 1001, 2, 'employee4', '123', '2019-01-01 00:00:00', 0, 'f7', 'l7', b'0', 0, 'fzhongjie@msn.com', 123456789, '4555 Erie Ave', 'Niagara Fall', 'Ontario', 'L2E7G9', '1000010', '2017-12-06 18:59:33', '2017-12-06 18:59:33', 'CURRENT_TIMESTAMP'),
(10010, 12, 1003, 3, 'employee5', '123', '2019-01-01 00:00:00', 0, 'f8', 'l8', b'0', 0, 'fzhongjie@msn.com', 123456789, '88 Bronte College Ct', 'Mississauga', 'Ontario', 'L5B1M9', '1100010', '2017-12-06 18:59:33', '2017-12-06 18:59:33', 'CURRENT_TIMESTAMP'),
(10011, 12, 1002, 1, 'employee6', '123', '2019-01-01 00:00:00', 0, 'f9', 'l9', b'0', 0, 'fzhongjie@msn.com', 123456789, '680 Rexdale Blvd', 'Toronto', 'Ontario', 'M9W6T4', '1000001', '2017-12-06 18:59:33', '2017-12-06 18:59:33', 'CURRENT_TIMESTAMP'),
(10013, 10, 1001, 2, 'jsmith', '123', '2018-01-01 00:00:00', 0, 'Jason', 'Smith', b'0', 0, 'jsmith@mail.com', 123456789, '205 Humber College Blvd', 'Toronto', 'Ontario', 'M9W5L7', NULL, '2017-12-22 22:15:31', '2017-12-22 22:15:31', 'CURRENT_TIMESTAMP');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
