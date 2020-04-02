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

--
-- Dumping data for table `accessory`
--

INSERT INTO `accessory` (`accessoryID`, `accessoryName`, `accessoryDesc`, `category`, `src`) VALUES
(1, 'Cappy', 'Accompanied Mario in his adventures!', 'equipHead', 'hat1.png'),
(2, 'Santa Hat', 'Ho ho ho! Merry Christmas Yoshi!', 'equipHead', 'hat2.png'),
(3, 'King\'s Crown', 'An essential for every king!', 'equipHead', 'hat3.png'),
(4, 'Poop Hat', 'A hat with a fragrant smell..', 'equipHead', 'hat4.png'),
(5, 'No Face Suit', 'Nobody can see me enjoying my life!', 'equipBody', 'body1.png'),
(6, 'Princess Dress', 'A princess dress for the pretty girl!', 'equipBody', 'body2.png'),
(7, 'Spidersuit', 'A Spidersuit specially created for Yoshi', 'equipBody', 'body3.png'),
(8, 'Ice Cream', 'I know you are thirsty, eat me!', 'equipHand', 'hand1.png'),
(9, 'Magic Wand', 'A wand with super powers!', 'equipHand', 'hand2.png'),
(10, 'Bomb', 'A bomb to protect yourself!', 'equipHand', 'hand3.png'),
(11, 'Water Gun', 'Let \'s other people be wet!', 'equipHand', 'hand4.png'),
(12, 'Cat Cat', 'Why one cat when you can have two?', 'equipPet', 'pet1.png'),
(13, 'Andrew Marlton', 'First dog on the moon; your best friend!', 'equipPet', 'pet2.png'),
(14, 'Jumbo', 'Dumbo\'s childhood friend!', 'equipPet', 'pet3.png'),
(15, 'Jake The Dog', 'Jake the Dog from Adventure Time!', 'equipPet', 'pet4.png');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
