-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2013 at 02:54 AM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `msma-amp`
--
CREATE DATABASE IF NOT EXISTS `msma-amp` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `msma-amp`;

-- --------------------------------------------------------

--
-- Table structure for table `actor`
--

CREATE TABLE IF NOT EXISTS `actor` (
  `Name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `YearsActing` smallint(11) NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `actsin`
--

CREATE TABLE IF NOT EXISTS `actsin` (
  `ActorName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `MovieName` varchar(75) COLLATE latin1_general_ci NOT NULL,
  `MovieYear` smallint(6) NOT NULL,
  `Role` varchar(75) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`ActorName`,`MovieName`,`MovieYear`),
  KEY `MovieName` (`MovieName`),
  KEY `MovieYear` (`MovieYear`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `director`
--

CREATE TABLE IF NOT EXISTS `director` (
  `Name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `YearsDirecting` smallint(11) NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `directs`
--

CREATE TABLE IF NOT EXISTS `directs` (
  `DirectorName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `MovieName` varchar(75) COLLATE latin1_general_ci NOT NULL,
  `MovieYear` smallint(6) NOT NULL,
  PRIMARY KEY (`DirectorName`,`MovieName`,`MovieYear`),
  KEY `MovieName` (`MovieName`),
  KEY `MovieYear` (`MovieYear`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interestin`
--

CREATE TABLE IF NOT EXISTS `interestin` (
  `PersonName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `MovieName` varchar(75) COLLATE latin1_general_ci NOT NULL,
  `MovieYear` smallint(6) NOT NULL,
  PRIMARY KEY (`PersonName`,`MovieName`,`MovieYear`),
  KEY `MovieName` (`MovieName`),
  KEY `MovieYear` (`MovieYear`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE IF NOT EXISTS `movie` (
  `Title` varchar(75) COLLATE latin1_general_ci NOT NULL,
  `Year` smallint(6) NOT NULL,
  `Genre` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `Premise` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`Title`,`Year`),
  KEY `Year` (`Year`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `Name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(75) COLLATE latin1_general_ci NOT NULL,
  `Password` char(128) COLLATE latin1_general_ci NOT NULL,
  `Salt` char(128) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `watched`
--

CREATE TABLE IF NOT EXISTS `watched` (
  `PersonName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `MovieName` varchar(75) COLLATE latin1_general_ci NOT NULL,
  `MovieYear` smallint(6) NOT NULL,
  `StarRating` smallint(6) NOT NULL,
  PRIMARY KEY (`PersonName`,`MovieName`,`MovieYear`),
  KEY `MovieName` (`MovieName`),
  KEY `MovieYear` (`MovieYear`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actsin`
--
ALTER TABLE `actsin`
  ADD CONSTRAINT `actsin_ibfk_3` FOREIGN KEY (`MovieYear`) REFERENCES `movie` (`Year`),
  ADD CONSTRAINT `actsin_ibfk_1` FOREIGN KEY (`ActorName`) REFERENCES `actor` (`Name`),
  ADD CONSTRAINT `actsin_ibfk_2` FOREIGN KEY (`MovieName`) REFERENCES `movie` (`Title`);

--
-- Constraints for table `directs`
--
ALTER TABLE `directs`
  ADD CONSTRAINT `directs_ibfk_3` FOREIGN KEY (`MovieYear`) REFERENCES `movie` (`Year`),
  ADD CONSTRAINT `directs_ibfk_1` FOREIGN KEY (`DirectorName`) REFERENCES `director` (`Name`),
  ADD CONSTRAINT `directs_ibfk_2` FOREIGN KEY (`MovieName`) REFERENCES `movie` (`Title`);

--
-- Constraints for table `interestin`
--
ALTER TABLE `interestin`
  ADD CONSTRAINT `interestin_ibfk_3` FOREIGN KEY (`MovieYear`) REFERENCES `movie` (`Year`),
  ADD CONSTRAINT `interestin_ibfk_1` FOREIGN KEY (`PersonName`) REFERENCES `person` (`Name`),
  ADD CONSTRAINT `interestin_ibfk_2` FOREIGN KEY (`MovieName`) REFERENCES `movie` (`Title`);

--
-- Constraints for table `watched`
--
ALTER TABLE `watched`
  ADD CONSTRAINT `watched_ibfk_3` FOREIGN KEY (`MovieYear`) REFERENCES `movie` (`Year`),
  ADD CONSTRAINT `watched_ibfk_1` FOREIGN KEY (`PersonName`) REFERENCES `person` (`Name`),
  ADD CONSTRAINT `watched_ibfk_2` FOREIGN KEY (`MovieName`) REFERENCES `movie` (`Title`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
