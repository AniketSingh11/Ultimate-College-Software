-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 20, 2014 at 02:00 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `book_inventory`
--
CREATE DATABASE IF NOT EXISTS `book_inventory` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `book_inventory`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE IF NOT EXISTS `admin_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `username`, `password`, `email`) VALUES
(2, 'admin', '1234', 'demo@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--

CREATE TABLE IF NOT EXISTS `agency` (
  `a_id` int(10) NOT NULL AUTO_INCREMENT,
  `a_name` varchar(64) NOT NULL,
  `a_address` varchar(150) NOT NULL,
  `a_person` varchar(64) NOT NULL,
  `a_mobile` varchar(64) NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `agency`
--

INSERT INTO `agency` (`a_id`, `a_name`, `a_address`, `a_person`, `a_mobile`) VALUES
(1, 'Goyal', 'Chennai-600 092', 'Raj', '0123456789');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `b_id` int(10) NOT NULL AUTO_INCREMENT,
  `b_name` varchar(150) NOT NULL,
  `b_qtysold` int(10) NOT NULL,
  `b_qtyleft` int(10) NOT NULL,
  `b_price` decimal(10,2) NOT NULL,
  `category` varchar(10) NOT NULL,
  `c_id` int(10) NOT NULL,
  `s_id` int(10) NOT NULL,
  `a_id` int(10) NOT NULL,
  `n_id` int(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`b_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`b_id`, `b_name`, `b_qtysold`, `b_qtyleft`, `b_price`, `category`, `c_id`, `s_id`, `a_id`, `n_id`, `type`) VALUES
(1, 'LKG-Tamil', 10, 540, '25.00', 'C', 1, 2, 1, 0, 'B'),
(2, 'LKG English', 9, 41, '32.00', 'C', 1, 1, 1, 0, 'B'),
(4, 'Moral Science - UKG', 7, 43, '70.00', '', 2, 3, 1, 0, ''),
(5, 'School Uniform ', 8, 37, '450.00', 'M', 1, 1, 1, 0, 'B'),
(7, 'School Uniform', 4, 26, '700.00', 'F', 1, 1, 1, 0, 'B'),
(8, 'Kids Text book - A', 7, 5, '55.00', 'C', 1, 1, 1, 0, 'B'),
(11, 'Broad Four Ruled -192', 0, 0, '35.00', 'C', 1, 1, 1, 2, 'N'),
(12, 'T Shirt ', 3, 17, '150.00', 'C', 1, 1, 1, 0, 'B'),
(13, 'Broad Four Ruled -192', 0, 0, '35.00', 'C', 2, 3, 1, 2, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `c_id` int(10) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(64) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`c_id`, `c_name`) VALUES
(1, 'LKG'),
(2, 'UKG');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `i_id` int(10) NOT NULL AUTO_INCREMENT,
  `i_no` varchar(64) NOT NULL,
  `i_name` varchar(64) NOT NULL,
  `i_total` varchar(64) NOT NULL,
  `i_ptype` varchar(32) NOT NULL,
  `i_day` int(10) NOT NULL,
  `i_month` int(10) NOT NULL,
  `i_year` int(10) NOT NULL,
  `ss_id` int(10) NOT NULL,
  `c_id` int(10) NOT NULL,
  `s_id` int(10) NOT NULL,
  `se_id` int(10) NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`i_id`, `i_no`, `i_name`, `i_total`, `i_ptype`, `i_day`, `i_month`, `i_year`, `ss_id`, `c_id`, `s_id`, `se_id`) VALUES
(1, '1000', 'Ravin', '57', 'card', 17, 5, 2014, 2, 1, 1, 0),
(3, '1002', 'tharun', '70.00', 'cash', 19, 5, 2014, 0, 2, 3, 0),
(4, '1003', 'surya', '70.00', 'cash', 19, 5, 2014, 0, 2, 3, 0),
(8, '1007', 'kamaraj', '70.00', 'cash', 19, 5, 2014, 8, 0, 3, 0),
(9, '1008', 'tharun', '70.00', 'card', 19, 5, 2014, 5, 2, 3, 0),
(16, '1013', 'Sai', '847.00', 'cash', 19, 5, 2014, 3, 1, 1, 0),
(19, '1016', 'Dhinesh', '1,699.00', 'cash', 20, 5, 2014, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_no`
--

CREATE TABLE IF NOT EXISTS `invoice_no` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `count` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `invoice_no`
--

INSERT INTO `invoice_no` (`id`, `count`) VALUES
(1, '1017');

-- --------------------------------------------------------

--
-- Table structure for table `notebook_purchese`
--

CREATE TABLE IF NOT EXISTS `notebook_purchese` (
  `n_id` int(10) NOT NULL AUTO_INCREMENT,
  `n_name` varchar(150) NOT NULL,
  `n_qtysold` int(10) NOT NULL,
  `n_qtyleft` int(10) NOT NULL,
  `n_price` decimal(10,2) NOT NULL,
  `a_id` int(10) NOT NULL,
  PRIMARY KEY (`n_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `notebook_purchese`
--

INSERT INTO `notebook_purchese` (`n_id`, `n_name`, `n_qtysold`, `n_qtyleft`, `n_price`, `a_id`) VALUES
(2, 'Broad Four Ruled -192', 4, 316, '35.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `salessumarry`
--

CREATE TABLE IF NOT EXISTS `salessumarry` (
  `sa_id` int(10) NOT NULL AUTO_INCREMENT,
  `i_id` int(10) NOT NULL,
  `b_id` int(10) NOT NULL,
  `b_name` varchar(150) NOT NULL,
  `sa_qty` varchar(100) NOT NULL,
  `sa_price` varchar(100) NOT NULL,
  `sa_total` varchar(100) NOT NULL,
  PRIMARY KEY (`sa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `salessumarry`
--

INSERT INTO `salessumarry` (`sa_id`, `i_id`, `b_id`, `b_name`, `sa_qty`, `sa_price`, `sa_total`) VALUES
(1, 1, 1, 'LKG-Tamil1', '1', '25', '25'),
(2, 1, 2, 'LKG English', '1', '32', '32'),
(3, 2, 1, 'LKG-Tamil1', '2', '25', '50'),
(4, 2, 2, 'LKG English', '1', '32', '32'),
(5, 3, 4, 'Moral Science - UKG', '1', '70.00', '70.00'),
(6, 4, 4, 'Moral Science - UKG', '1', '70.00', '70.00'),
(7, 5, 4, 'Moral Science - UKG', '1', '70.00', '70.00'),
(8, 6, 4, 'Moral Science - UKG', '1', '70.00', '70.00'),
(9, 7, 4, 'Moral Science - UKG', '1', '70.00', '70.00'),
(10, 8, 4, 'Moral Science - UKG', '1', '70.00', '70.00'),
(11, 9, 4, 'Moral Science - UKG', '1', '70.00', '70.00'),
(32, 16, 1, 'LKG-Tamil1', '1', '25.00', '25.00'),
(33, 16, 2, 'LKG English', '1', '32.00', '32.00'),
(34, 16, 7, 'School Uniform', '1', '700.00', '700.00'),
(35, 16, 8, 'Kids Text book - A', '1', '55.00', '55.00'),
(36, 16, 11, 'Broad Four Ruled -192', '1', '35.00', '35.00'),
(49, 19, 1, 'LKG-Tamil', '1', '25.00', '25.00'),
(50, 19, 2, 'LKG English', '1', '32.00', '32.00'),
(51, 19, 5, 'School Uniform ', '3', '450.00', '1,350.00'),
(52, 19, 8, 'Kids Text book - A', '1', '55.00', '55.00'),
(53, 19, 11, 'Broad Four Ruled -192', '1', '35.00', '35.00'),
(54, 19, 12, 'T Shirt ', '1', '150.00', '150.00');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE IF NOT EXISTS `section` (
  `s_id` int(10) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(64) NOT NULL,
  `c_id` int(10) NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`s_id`, `s_name`, `c_id`) VALUES
(1, 'A', 1),
(2, 'B', 1),
(3, 'A', 2);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `se_id` int(10) NOT NULL AUTO_INCREMENT,
  `se_price` decimal(10,2) NOT NULL,
  `c_id` int(10) NOT NULL,
  `s_id` int(10) NOT NULL,
  PRIMARY KEY (`se_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`se_id`, `se_price`, `c_id`, `s_id`) VALUES
(1, '52.00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `ss_id` int(10) NOT NULL AUTO_INCREMENT,
  `ss_roll` varchar(64) NOT NULL,
  `ss_gender` varchar(64) NOT NULL,
  `ss_name` varchar(64) NOT NULL,
  `s_id` int(10) NOT NULL,
  `c_id` int(10) NOT NULL,
  PRIMARY KEY (`ss_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`ss_id`, `ss_roll`, `ss_gender`, `ss_name`, `s_id`, `c_id`) VALUES
(1, 'LKG001', 'M', 'Dhinesh', 1, 1),
(2, 'LKG002', 'F', 'Ravin', 1, 1),
(3, 'LKG003', 'F', 'Sai', 1, 1),
(4, 'LKG004', 'M', 'Raj', 1, 1),
(5, 'UKG006', 'M', 'Raj', 3, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
