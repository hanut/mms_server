-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 21, 2013 at 05:28 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mms_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `mms_login`
--

CREATE TABLE IF NOT EXISTS `mms_login` (
  `UserID` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(40) NOT NULL,
  `Private_Key` char(64) NOT NULL,
  `Secret_Key` char(64) NOT NULL,
  `UserType` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserName` (`UserName`),
  KEY `UserName_2` (`UserName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mms_login`
--

INSERT INTO `mms_login` (`UserID`, `UserName`, `Private_Key`, `Secret_Key`, `UserType`) VALUES
(1, 'hanut', '351363d72581e4bfee1118cb613f229ef8f0b3cf5d95da33875e44f995a248b6', 'ab1f0359380b5d54db719ec85e9333103b722456b1097ddcb073c221fefb188d', 99),
(2, 'aditya', 'b57d698341ffa7ad51d5a2db00748305caad62918ff0ac0860c6b0e93580cf6f', '90fc914dc2376036c0a6aae5ab22abf0f21c76ecfe2f423a61fea57fc503cc85', 99);

-- --------------------------------------------------------

--
-- Table structure for table `mms_patients`
--

CREATE TABLE IF NOT EXISTS `mms_patients` (
  `PatientID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Age` int(3) NOT NULL,
  `Address` varchar(500) NOT NULL,
  `Gender` enum('Male','Female') NOT NULL,
  `Allergies` text NOT NULL,
  PRIMARY KEY (`PatientID`),
  KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains details of all patients' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
