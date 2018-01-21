-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2018 at 10:42 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beontime`
--

-- --------------------------------------------------------

--
-- Table structure for table `companylocationmaster`
--

CREATE TABLE `companylocationmaster` (
  `CompanyLocationId` int(11) NOT NULL,
  `CompanyId` int(11) NOT NULL,
  `Address` varchar(125) NOT NULL,
  `City` varchar(20) NOT NULL,
  `Province` varchar(45) NOT NULL,
  `PostalCode` varchar(6) NOT NULL,
  `Latitude` decimal(11,8) NOT NULL,
  `Longitude` decimal(11,8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companylocationmaster`
--

INSERT INTO `companylocationmaster` (`CompanyLocationId`, `CompanyId`, `Address`, `City`, `Province`, `PostalCode`, `Latitude`, `Longitude`) VALUES
(10001, 1001, '330 Dufferin St', 'York', 'Ontario', 'M6N0A7', '43.71236080', '-79.53278200'),
(10002, 1001, '60 Weston Road', 'Etobicoke', 'Ontario', 'M9L1V7', '43.67371960', '-79.47047420'),
(10003, 1002, '2245 Islington Ave', 'Etobicoke', 'Ontario', 'M9W3W7', '43.71376590', '-79.55534900'),
(10004, 1003, '1620 Albion Rd', 'Etobicoke', 'Ontario', 'M9V4B4', '43.74225840', '-79.59047950'),
(10005, 1004, '205 Humber College Blvd', 'Etobicoke', 'Ontario', 'M9W5L7', '43.72876220', '-79.60786460');

-- --------------------------------------------------------

--
-- Table structure for table `companymaster`
--

CREATE TABLE `companymaster` (
  `CompanyId` int(11) NOT NULL,
  `CompanyName` varchar(100) NOT NULL,
  `CompanyEmail` varchar(50) NOT NULL,
  `CompanyURL` varchar(50) NOT NULL,
  `CompanyPassword` varchar(50) NOT NULL,
  `CompanyPhone` varchar(10) NOT NULL,
  `CompanyStreetNumber` int(11) NOT NULL,
  `CompanyStreetName` varchar(150) NOT NULL,
  `CompanyCity` varchar(50) NOT NULL,
  `CompanyState` varchar(50) NOT NULL,
  `CompanyPostal` varchar(7) NOT NULL,
  `CompanyCountry` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companymaster`
--

INSERT INTO `companymaster` (`CompanyId`, `CompanyName`, `CompanyEmail`, `CompanyURL`, `CompanyPassword`, `CompanyPhone`, `CompanyStreetNumber`, `CompanyStreetName`, `CompanyCity`, `CompanyState`, `CompanyPostal`, `CompanyCountry`) VALUES
(1001, 'Bell', 'dhruvin.mind.freak@gmail.com', 'http://www.bell.ca', '123', '6475710747', 209, 'Humber College Boulevard', 'Toronto', 'ON', 'M8Z3A5', 'Canada'),
(1002, 'Walmart', 'walmart@beontime.com', 'www.walmart.ca', '123', '', 2, 'Islington Ave', 'Toronto', 'Ontario', 'Q1Q 2W2', 'Canada'),
(1003, 'Sunny Foodmart', 'sunny@beontime.com', 'www.sunnyfoodmart.ca', '123', '', 4, 'Albion Rd', 'Toronto', 'Ontario', 'Q1Q 2W2', 'Canada'),
(1004, 'Humber College', 'inqury@humber.com', 'www.humber.ca', '123', '', 205, 'Humber Blvd', 'Toronto', 'Ontario', 'M9W5L7', 'Canada');

-- --------------------------------------------------------

--
-- Table structure for table `dummytable`
--

CREATE TABLE `dummytable` (
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

CREATE TABLE `employeedesignationmaster` (
  `empDesignationId` tinyint(4) NOT NULL,
  `empDesignationName` varchar(45) NOT NULL,
  `payPerHour` decimal(10,2) NOT NULL,
  `EntryDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employeedesignationmaster`
--

INSERT INTO `employeedesignationmaster` (`empDesignationId`, `empDesignationName`, `payPerHour`, `EntryDateTime`, `ModDateTime`, `ModifiedBy`) VALUES
(1, 'Expert', '25.00', '2017-12-06 00:14:34', '2017-12-06 00:14:34', 10001),
(2, 'Intermediate', '20.00', '2017-12-06 00:14:34', '2017-12-06 00:14:34', 10001),
(3, 'Junior', '14.05', '2017-12-06 00:14:34', '2017-12-06 00:14:34', 10001);

-- --------------------------------------------------------

--
-- Table structure for table `rolemaster`
--

CREATE TABLE `rolemaster` (
  `RoleId` tinyint(4) NOT NULL,
  `RoleName` varchar(45) NOT NULL,
  `EntryDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModDateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE `shiftmaster` (
  `ShiftId` int(11) NOT NULL,
  `empDesignationId` tinyint(4) NOT NULL,
  `AssignedBy` int(11) DEFAULT NULL,
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
  `StarRating` tinyint(4) DEFAULT NULL,
  `ClientReview` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shiftmaster`
--

INSERT INTO `shiftmaster` (`ShiftId`, `empDesignationId`, `AssignedBy`, `AssignedTo`, `CompanyId`, `CompanyLocationId`, `StartTime`, `EndTime`, `ActualWorkingStartTime`, `ActualWorkingEndTime`, `EntryDateTime`, `ModDateTime`, `ShiftStatus`, `SpecialNote`, `CurrentLat`, `CurrentLong`, `LogInLat`, `LogInLong`, `LogOutLat`, `LogOutLong`, `City`, `StarRating`, `ClientReview`) VALUES
(500001, 1, NULL, NULL, 1001, 10001, '2018-01-23 13:30:00', '2018-01-23 22:30:00', NULL, NULL, '2017-11-20 09:00:00', '2017-11-20 09:00:00', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(500002, 1, 10001, 10008, 1004, 10005, '2018-01-23 12:00:00', '2018-01-23 20:00:00', NULL, NULL, '2017-12-06 00:16:51', '2017-12-06 00:16:51', 'C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Toronto', NULL, NULL),
(500003, 1, 10001, 10008, 1004, 10005, '2018-01-20 12:00:00', '2018-01-20 20:00:00', NULL, NULL, '2017-12-06 00:16:51', '2017-12-06 00:16:51', 'A', NULL, '43.72895100', '-79.60660090', NULL, NULL, NULL, NULL, 'Toronto', NULL, NULL),
(500004, 1, 10001, 10002, 1001, 10001, '2018-01-23 07:00:00', '2018-01-23 16:00:00', NULL, NULL, '2017-12-06 00:16:51', '2017-12-06 00:16:51', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Toronto', NULL, NULL),
(500005, 1, NULL, NULL, 1002, 10003, '2018-01-23 07:00:00', '2018-01-23 16:00:00', NULL, NULL, '2017-12-06 00:16:51', '2017-12-06 00:16:51', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Toronto', NULL, NULL),
(500006, 1, NULL, NULL, 1003, 10004, '2018-01-23 05:00:00', '2018-01-23 12:00:00', NULL, NULL, '2017-12-06 00:16:51', '2017-12-06 00:16:51', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Toronto', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usermaster`
--

CREATE TABLE `usermaster` (
  `UserId` int(11) NOT NULL,
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
  `Phone` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usermaster`
--

INSERT INTO `usermaster` (`UserId`, `RoleId`, `CompanyId`, `empDesignationId`, `UserName`, `Password`, `PasswordExpiry`, `PasswordCounter`, `FirstName`, `LastName`, `FirstLogin`, `UserStatus`, `EMail`, `SIN`, `Address`, `City`, `Province`, `PostalCode`, `DesiredDay`, `RegistrationDate`, `EntryDateTime`, `ModDateTime`, `Phone`) VALUES
(10001, 10, 1001, 1, 'zhongjie', 0x313233, '2018-01-01 00:00:00', 0, 'Zhongjie', 'Fan', b'1111111111111111111111111111111', 0, 'fzhongjie@msn.com', 123456789, '205 Humber College Blvd', 'Toronto', 'Ontario', 'M9W5L7', '1100011', '2017-12-06 18:59:32', '2017-12-06 18:59:32', 'CURRENT_TIMESTAMP', ''),
(10002, 12, 1001, 1, 'pinesh', 0x313233, '2018-01-01 00:00:00', 0, 'Pinesh', 'Menat', b'1111111111111111111111111111111', 0, 'pineshmenat@gmail.com', 123456789, '1889 Kipling Ave', 'Toronto', 'Ontario', 'M9W5L7', '0000111', '2017-12-06 18:59:32', '2017-12-06 18:59:32', 'CURRENT_TIMESTAMP', ''),
(10004, 11, 1001, 1, 'vaishnavi', 0x313233, '2018-01-01 00:00:00', 0, 'Vaishnavi', 'Panchal', b'1111111111111111111111111111111', 0, 'vaishnavi.panchalk@gmail.com', 123456789, '205 Humber College Blvd', 'Toronto', 'Ontario', 'M9W5L7', '1100011', '2017-12-07 21:54:14', '2017-12-07 21:54:14', 'CURRENT_TIMESTAMP', ''),
(10005, 10, 1001, 1, 'anubhav', 0x313233, '2018-03-01 00:00:00', 0, 'Anubhav', 'Narasimhan', b'1111111111111111111111111111111', 0, 'anbhav93@gmail.com', 123456789, '205 Humber College Blvd', 'Toronto', 'Ontario', 'M9W5L7', '1100011', '2018-01-06 16:59:54', '2018-01-06 16:59:54', 'CURRENT_TIMESTAMP', ''),
(10003, 10, 1001, 1, 'dhruvin.mind.freak@gmail.com', 0x313233, '2018-03-01 00:00:00', 0, 'Dhruvin', 'Parikh', b'1111111111111111111111111111111', 0, 'dhruvin.mind.freak@gmail.com', 123456789, '209 Humber College Boulevard', 'Toronto', 'ON', 'M8Z3A5', '1100011', '2018-01-06 16:56:24', '2018-01-06 16:56:24', 'CURRENT_TIMESTAMP', '6475710747'),
(10006, 12, 1001, 1, 'jsmith', 0x313233, '2018-03-01 00:00:00', 0, 'Jason', 'Smith', b'1111111111111111111111111111111', 0, 'jsmith@gmail.com', 123456700, '1309 Carling Ave Unit 27', 'Ottawa', 'Ontario', 'K1Z7L3', '0100011', '2018-01-08 18:58:23', '2018-01-08 18:58:23', 'CURRENT_TIMESTAMP', ''),
(10008, 12, 1001, 1, 'mbell', 0x313233, '2018-01-01 00:00:00', 0, 'Michael', 'Bell', b'1111111111111111111111111111111', 0, 'mbell@gmail.com', 123456789, '262 Finch Blvd', 'Toronto', 'Ontario', 'M9W5L7', '1100001', '2017-12-06 18:59:32', '2017-12-06 18:59:32', 'CURRENT_TIMESTAMP', ''),
(10007, 12, 1001, 1, 'mkim', 0x313233, '2018-03-01 00:00:00', 0, 'Mary', 'Kim', b'1111111111111111111111111111111', 0, 'mkim@gmail.com', 123456700, '3120 Dixie Rd', 'Mississauga', 'Ontario', 'L4Y2A6', '1100001', '2018-01-08 18:58:23', '2018-01-08 18:58:23', 'CURRENT_TIMESTAMP', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companylocationmaster`
--
ALTER TABLE `companylocationmaster`
  ADD PRIMARY KEY (`CompanyLocationId`),
  ADD KEY `FK_companylocationmaster_CompanyId_idx` (`CompanyId`);

--
-- Indexes for table `companymaster`
--
ALTER TABLE `companymaster`
  ADD PRIMARY KEY (`CompanyId`);

--
-- Indexes for table `employeedesignationmaster`
--
ALTER TABLE `employeedesignationmaster`
  ADD PRIMARY KEY (`empDesignationId`);

--
-- Indexes for table `rolemaster`
--
ALTER TABLE `rolemaster`
  ADD PRIMARY KEY (`RoleId`);

--
-- Indexes for table `shiftmaster`
--
ALTER TABLE `shiftmaster`
  ADD PRIMARY KEY (`ShiftId`),
  ADD KEY `FK_shiftmaster_empDesignation_Idx` (`empDesignationId`),
  ADD KEY `FK_shiftmaster_AssignedBy_idx` (`AssignedBy`),
  ADD KEY `FK_shiftmaster_AssignedTo_idx` (`AssignedTo`),
  ADD KEY `FK_shiftmaster_CompanyId_idx` (`CompanyId`),
  ADD KEY `FK_shiftmaster_CompanyLocationId_idx` (`CompanyLocationId`);

--
-- Indexes for table `usermaster`
--
ALTER TABLE `usermaster`
  ADD PRIMARY KEY (`UserId`),
  ADD KEY `FK_usermaster_RoleId_idx` (`RoleId`),
  ADD KEY `FK_usermaster_CompanyId_idx` (`CompanyId`),
  ADD KEY `FK_usermaster_empDesignation_Idx` (`empDesignationId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companylocationmaster`
--
ALTER TABLE `companylocationmaster`
  MODIFY `CompanyLocationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10006;
--
-- AUTO_INCREMENT for table `companymaster`
--
ALTER TABLE `companymaster`
  MODIFY `CompanyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;
--
-- AUTO_INCREMENT for table `employeedesignationmaster`
--
ALTER TABLE `employeedesignationmaster`
  MODIFY `empDesignationId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rolemaster`
--
ALTER TABLE `rolemaster`
  MODIFY `RoleId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `shiftmaster`
--
ALTER TABLE `shiftmaster`
  MODIFY `ShiftId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500013;
--
-- AUTO_INCREMENT for table `usermaster`
--
ALTER TABLE `usermaster`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10014;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
