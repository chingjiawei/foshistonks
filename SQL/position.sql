-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Mar 26, 2020 at 08:03 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+08:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `position`
--
CREATE DATABASE IF NOT EXISTS `position` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `position`;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
CREATE TABLE IF NOT EXISTS `position` (
  `time_stamp` datetime NOT NULL,
  `stockid` int(10) NOT NULL,
  `username` varchar(16) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `purchasetype` varchar(10) NOT NULL,
  `amount` int(10) NOT NULL,
  PRIMARY KEY (`time_stamp`, `username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;
