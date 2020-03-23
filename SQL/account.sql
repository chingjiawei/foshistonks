-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 21, 2020 at 09:13 AM
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
CREATE DATABASE IF NOT EXISTS `account` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `account`;

-- --------------------------------------------------------
--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `userid` varchar(128) NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phoneNumber` int(10) DEFAULT NULL,
  `telegramid` varchar(20) DEFAULT NULL,
  `type` TINYINT(1) NOT NULL,
  `stonks` int(10) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;


-- Dumping data for table `account`
--

INSERT INTO `account` (`userid`, `password`, `email`, `phoneNumber`, `telegramid`, `type`, `stonks`) VALUES
('Yoshi', 'youshi123', 'youshi@gmai.com', 67009000, 12345,0,0),
('Amy', 'amy123', 'amy@gmai.com', 66667888, 23456,1,0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
