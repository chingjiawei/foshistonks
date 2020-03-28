-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 28, 2020 at 04:44 PM
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
-- Database: `accessory`
--
DROP DATABASE IF EXISTS `accessory`;
CREATE DATABASE IF NOT EXISTS `accessory` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `accessory`;

-- --------------------------------------------------------

--
-- Table structure for table `accessory`
--

DROP TABLE IF EXISTS `accessory`;
CREATE TABLE IF NOT EXISTS `accessory` (
  `accessoryID` int(11) NOT NULL AUTO_INCREMENT,
  `accessoryName` varchar(128) NOT NULL,
  `accessoryDesc` varchar(256) NOT NULL,
  `category` varchar(128) NOT NULL,
  `src` varchar(128) NOT NULL,
  PRIMARY KEY (`accessoryID`),
  UNIQUE KEY `accessoryID` (`accessoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
