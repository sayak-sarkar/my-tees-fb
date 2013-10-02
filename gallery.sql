-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 01, 2013 at 07:15 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `photo_name` varchar(200) NOT NULL,
  `comment` varchar(140) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `photo_name`, `date_added`) VALUES
(1, 'the_golden_hour-wallpaper-1366x768.jpg', 'sample1', '2013-10-01 19:09:15'),
(2, 'Apple-vs-Droid.jpg', 'sample3','2013-10-01 19:13:18'),
(3, 'german_landscapes-1366x768.jpg', 'sample4','2013-10-01 19:13:51'),
(4, 'new_battlefield_3-1366x768.jpg', 'sample5','2013-10-01 19:14:17');
(5, 'mercedes_benz_cls63-1366x768.jpg', 'sample5','2013-10-01 19:15:18');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
