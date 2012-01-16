-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 16, 2012 at 04:50 AM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `randomquotes`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(30) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`uid`, `user`, `pass`) VALUES
(1, 'admin', '132bde3149a74d3da2179365ad3fdea8');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE IF NOT EXISTS `quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `time` bigint(22) NOT NULL,
  `author` varchar(255) NOT NULL,
  `approved` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `quotes`
--

