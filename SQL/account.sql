-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 28, 2020 at 04:40 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+08:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
--
-- Database: `account`
--
DROP DATABASE IF EXISTS `account`;
CREATE DATABASE IF NOT EXISTS `account` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `account`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phoneNumber` varchar(8) NOT NULL,
  `telegramID` varchar(128) NOT NULL,
  `stonks` decimal(8,2) NOT NULL,
  `equipHead` varchar(128) DEFAULT NULL,
  `equipBody` varchar(128) DEFAULT NULL,
  `equipHand` varchar(128) DEFAULT NULL,
  `equipPet` varchar(128) DEFAULT NULL,
  `lastLogin` datetime NOT NULL,
  `dailyStonks` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `telegramID` (`telegramID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

---
--- Dumping data for table `account`
---

INSERT INTO `account` (`username`, `password`, `email`, `phoneNumber`, `telegramid`, `stonks`, `equipHead`, `equipBody`, `equipHand`, `equipPet`,`lastLogin` = now(),`dailyStonks`) VALUES 
('Yoshi', 'youshi123', 'youshi@gmail.com', '67009000', '12345', 100.00, 'hat2.png', Null, Null, Null, now(), 0), 
('James', 'james123', 'james@gmail.com', '98882345', '98572', 100.00, Null, Null, Null, 'pet2.png', now(), 0), 
('mary', '123', 'mary@gmail.com', '74653725', '98972', 100.00, Null, Null, Null, 'pet2.png', now(), 0), 
('Amy', 'amy123', 'amy@gmail.com', '66667888', '23456', 100.00, Null, 'body3.png', Null, Null, now(), 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
