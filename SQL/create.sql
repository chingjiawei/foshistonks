-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 02, 2020 at 11:16 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

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
COMMIT;


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

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`username`, `password`, `email`, `phoneNumber`, `telegramID`, `stonks`, `equipHead`, `equipBody`, `equipHand`, `equipPet`, `lastLogin`, `dailyStonks`) VALUES
('Amy', 'amy123', 'amy@gmail.com', '66667888', '23456', '100.00', NULL, 'body3.png', NULL, NULL, '2020-04-02 19:20:35', 0),
('James', 'james123', 'james@gmail.com', '98882345', '98572', '100.00', NULL, NULL, NULL, 'pet2.png', '2020-04-02 19:20:35', 0),
('mary', '123', 'mary@gmail.com', '74653725', '98972', '100.00', NULL, NULL, NULL, 'pet2.png', '2020-04-02 19:20:35', 0),
('Yoshi', 'youshi123', 'youshi@gmail.com', '67009000', '12345', '100.00', 'hat2.png', NULL, NULL, NULL, '2020-04-02 19:20:35', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--
DROP DATABASE IF EXISTS `inventory`;
CREATE DATABASE IF NOT EXISTS `inventory` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `inventory`;
-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `username` varchar(20) NOT NULL,
  `accessoryID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`username`,`accessoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`username`, `accessoryID`, `quantity`) VALUES
('Amy', 2, 1),
('James', 3, 1),
('mary', 3, 1),
('Yoshi', 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Database: `monitoring`
--
DROP DATABASE IF EXISTS `monitoring`;
CREATE DATABASE IF NOT EXISTS `monitoring` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `monitoring`;
-- --------------------------------------------------------

--
-- Table structure for table `monitoring`
--
CREATE TABLE IF NOT EXISTS `monitoring` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `log_content` varchar(500) NOT NULL,
  `log_from` varchar(128) NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Database: `position`
--
DROP DATABASE IF EXISTS `position`;
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
  `stockName` varchar(128) NOT NULL,
  `username` varchar(16) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `purchasetype` varchar(10) NOT NULL,
  `amount` int(10) NOT NULL,
  PRIMARY KEY (`time_stamp`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Database: `shop`
--
DROP DATABASE IF EXISTS `shop`;
CREATE DATABASE IF NOT EXISTS `shop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `shop`;
-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

DROP TABLE IF EXISTS `shop`;
CREATE TABLE IF NOT EXISTS `shop` (
  `shopID` int(11) NOT NULL,
  `accessoryID` int(11) NOT NULL,
  `inStock` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  PRIMARY KEY (`shopID`,`accessoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`shopID`, `accessoryID`, `inStock`, `price`) VALUES
(1, 1, 10, '20.50'),
(1, 2, 10, '24.50'),
(1, 3, 10, '40.00'),
(1, 4, 10, '28.50'),
(1, 5, 10, '45.00'),
(1, 6, 10, '50.00'),
(1, 7, 10, '55.00'),
(1, 8, 10, '15.50'),
(1, 9, 10, '18.00'),
(1, 10, 10, '16.50'),
(1, 11, 10, '18.00'),
(1, 12, 10, '25.00'),
(1, 13, 10, '26.50'),
(1, 14, 10, '27.50'),
(1, 15, 10, '28.00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Database: `stock`
--
DROP DATABASE IF EXISTS `stock`;
CREATE DATABASE IF NOT EXISTS `stock` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `stock`;
-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `stockid` int(11) NOT NULL AUTO_INCREMENT,
  `stockname` varchar(128) NOT NULL,
  `spoofname` varchar(128) NOT NULL,
  PRIMARY KEY (`stockid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stockid`, `stockname`, `spoofname`) VALUES
(4, 'A', 'DKBank Inc'),
(5, 'AA', 'ThisKong Pte Ltd'),
(6, 'DAL', 'Yeet and Yeehaw Advisory');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
