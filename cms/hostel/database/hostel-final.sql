-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2015 at 01:28 PM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sms_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `hms_cash_deposit`
--

CREATE TABLE IF NOT EXISTS `hms_cash_deposit` (
`hcd_id` int(4) NOT NULL,
  `amount` varchar(40) NOT NULL,
  `ay_id` int(4) NOT NULL,
  `date` varchar(10) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hms_cash_deposit`
--

INSERT INTO `hms_cash_deposit` (`hcd_id`, `amount`, `ay_id`, `date`, `date_time`) VALUES
(3, '5000', 2, '2015-04-15', '2015-04-15 14:12:21');

-- --------------------------------------------------------

--
-- Table structure for table `hms_category`
--

CREATE TABLE IF NOT EXISTS `hms_category` (
`h_id` int(4) NOT NULL,
  `h_name` varchar(200) NOT NULL,
  `h_address` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 - live 1- no live',
  `date` varchar(10) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hms_category`
--

INSERT INTO `hms_category` (`h_id`, `h_name`, `h_address`, `status`, `date`, `date_time`) VALUES
(1, 'Akshaya Men Hostel', 'chennai', 0, '2015-04-06', '2015-04-10 07:09:59'),
(2, 'Akshaya Women Hostel', 'chennai', 0, '2015-04-06', '2015-04-10 07:10:37');

-- --------------------------------------------------------

--
-- Table structure for table `hms_feestype`
--

CREATE TABLE IF NOT EXISTS `hms_feestype` (
`hft_id` int(4) NOT NULL,
  `hfs_id` int(4) NOT NULL,
  `room_type` int(4) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `date` varchar(10) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hms_feestype`
--

INSERT INTO `hms_feestype` (`hft_id`, `hfs_id`, `room_type`, `amount`, `date`, `date_time`) VALUES
(3, 2, 1, '30000', '2015-04-15', '2015-04-15 09:53:08'),
(4, 2, 2, '40000', '2015-04-15', '2015-04-15 09:53:08'),
(5, 2, 3, '10', '2015-04-15', '2015-04-15 08:38:19'),
(6, 3, 1, '30000', '2015-04-15', '2015-04-15 14:20:18'),
(7, 3, 2, '40000', '2015-04-15', '2015-04-15 14:20:18'),
(8, 4, 1, '40000', '2015-04-20', '2015-04-20 11:14:17'),
(9, 4, 2, '50000', '2015-04-20', '2015-04-20 11:14:26'),
(10, 5, 1, '40000', '2015-04-20', '2015-04-20 11:14:40'),
(11, 5, 2, '50000', '2015-04-20', '2015-04-20 11:14:40'),
(12, 6, 1, '40000', '2015-04-20', '2015-04-20 11:14:47'),
(13, 6, 2, '50000', '2015-04-20', '2015-04-20 11:14:47'),
(14, 7, 1, '40000', '2015-04-20', '2015-04-20 11:14:56'),
(15, 7, 2, '50000', '2015-04-20', '2015-04-20 11:14:56'),
(16, 8, 1, '40000', '2015-04-20', '2015-04-20 11:15:06'),
(17, 8, 2, '50000', '2015-04-20', '2015-04-20 11:15:06'),
(18, 9, 1, '40000', '2015-04-20', '2015-04-20 11:15:17'),
(19, 9, 2, '50000', '2015-04-20', '2015-04-20 11:15:17'),
(20, 10, 1, '40000', '2015-04-20', '2015-04-20 11:15:24'),
(21, 10, 2, '50000', '2015-04-20', '2015-04-20 11:15:24'),
(22, 11, 1, '40000', '2015-04-20', '2015-04-20 11:15:31'),
(23, 11, 2, '50000', '2015-04-20', '2015-04-20 11:15:31'),
(24, 12, 1, '40000', '2015-04-20', '2015-04-20 11:15:40'),
(25, 12, 2, '50000', '2015-04-20', '2015-04-20 11:15:40'),
(26, 13, 1, '40000', '2015-04-20', '2015-04-20 11:15:47'),
(27, 13, 2, '50000', '2015-04-20', '2015-04-20 11:15:47'),
(28, 14, 1, '40000', '2015-04-20', '2015-04-20 11:15:53'),
(29, 14, 2, '50000', '2015-04-20', '2015-04-20 11:15:53'),
(30, 15, 1, '40000', '2015-04-20', '2015-04-20 11:15:59'),
(31, 15, 2, '50000', '2015-04-20', '2015-04-20 11:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `hms_fees_structure`
--

CREATE TABLE IF NOT EXISTS `hms_fees_structure` (
`hfs_id` int(4) NOT NULL,
  `section` int(4) NOT NULL,
  `role` varchar(200) NOT NULL,
  `ay_id` int(4) NOT NULL,
  `status` int(4) NOT NULL COMMENT '0 - live 1- no live',
  `date` varchar(10) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hms_fees_structure`
--

INSERT INTO `hms_fees_structure` (`hfs_id`, `section`, `role`, `ay_id`, `status`, `date`, `date_time`) VALUES
(2, 10, 'Hostel Fees', 2, 0, '2015-04-15', '2015-04-15 09:19:37'),
(3, 9, 'Hostel Fees', 2, 0, '2015-04-15', '2015-04-15 14:20:18'),
(4, 11, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:14:17'),
(5, 12, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:14:40'),
(6, 13, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:14:47'),
(7, 14, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:14:56'),
(8, 15, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:15:06'),
(9, 16, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:15:17'),
(10, 17, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:15:24'),
(11, 18, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:15:31'),
(12, 19, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:15:40'),
(13, 21, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:15:47'),
(14, 22, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:15:53'),
(15, 23, 'Hostel Fees', 2, 0, '2015-04-20', '2015-04-20 11:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `hms_floor`
--

CREATE TABLE IF NOT EXISTS `hms_floor` (
`hf_id` int(4) NOT NULL,
  `category` int(4) NOT NULL,
  `floor_name` varchar(200) NOT NULL,
  `status` int(4) NOT NULL COMMENT '0 - live 1- no live',
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hms_floor`
--

INSERT INTO `hms_floor` (`hf_id`, `category`, `floor_name`, `status`, `date_time`) VALUES
(1, 1, 'Ist floor', 0, '2015-04-09 07:59:34'),
(2, 1, '2st floor', 0, '2015-04-09 07:59:37'),
(3, 2, 'Ist floors', 0, '2015-04-06 07:17:48'),
(4, 1, '3 floor', 0, '2015-04-10 12:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `hms_hinvoice`
--

CREATE TABLE IF NOT EXISTS `hms_hinvoice` (
`hin_id` int(4) NOT NULL,
  `in_no` varchar(200) NOT NULL,
  `hsr_id` int(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `admission_no` varchar(100) NOT NULL,
  `ay_id` int(4) NOT NULL,
  `h_total` varchar(70) NOT NULL,
  `paid_date` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fees_type` varchar(100) NOT NULL,
  `pay_type` varchar(50) NOT NULL,
  `fi_by` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hms_hinvoice_sumarry`
--

CREATE TABLE IF NOT EXISTS `hms_hinvoice_sumarry` (
`ibs_id` int(4) NOT NULL,
  `hin_id` int(4) NOT NULL,
  `hsr_id` varchar(200) NOT NULL,
  `hr_id` varchar(200) NOT NULL,
  `hrc_id` varchar(200) NOT NULL,
  `ay_id` int(4) NOT NULL,
  `fees_name` varchar(200) NOT NULL,
  `fees_type` varchar(200) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `date` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hms_invoice_no`
--

CREATE TABLE IF NOT EXISTS `hms_invoice_no` (
`hin_id` int(4) NOT NULL,
  `count` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hms_invoice_no`
--

INSERT INTO `hms_invoice_no` (`hin_id`, `count`) VALUES
(1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `hms_room`
--

CREATE TABLE IF NOT EXISTS `hms_room` (
`hr_id` int(4) NOT NULL,
  `category` int(4) NOT NULL,
  `floor` int(4) NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `no_cart` int(4) NOT NULL,
  `available_qty` int(4) NOT NULL,
  `status` int(4) NOT NULL COMMENT '0 -live 1- no live',
  `date` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hms_room`
--

INSERT INTO `hms_room` (`hr_id`, `category`, `floor`, `room_number`, `room_name`, `room_type`, `no_cart`, `available_qty`, `status`, `date`, `date_time`) VALUES
(5, 1, 1, '2', '', '1', 4, 4, 0, '2015-04-06', '2015-04-20 11:21:29'),
(6, 1, 2, '1', 'Student', '1', 6, 6, 0, '2015-04-06', '2015-04-20 11:25:34'),
(7, 2, 3, '1', '', '1', 2, 2, 0, '2015-04-10', '2015-04-11 07:22:29'),
(13, 1, 1, '3', '', '1', 2, 2, 0, '2015-04-10', '2015-04-20 11:17:50'),
(14, 1, 1, '4', '', '1', 2, 2, 0, '2015-04-10', '2015-04-20 08:39:52'),
(15, 1, 1, '5', '', '1', 3, 3, 0, '2015-04-10', '2015-04-20 11:21:52'),
(16, 1, 1, '6', '', '1', 5, 5, 0, '2015-04-10', '2015-04-20 07:56:19'),
(17, 1, 1, '7', '', '2', 6, 6, 0, '2015-04-10', '2015-04-20 11:21:44'),
(18, 2, 3, '2', '', '2', 1, 1, 0, '2015-04-10', '2015-04-20 08:47:31');

-- --------------------------------------------------------

--
-- Table structure for table `hms_room_cart`
--

CREATE TABLE IF NOT EXISTS `hms_room_cart` (
`hrc_id` int(4) NOT NULL,
  `category` int(4) NOT NULL,
  `floor` int(4) NOT NULL,
  `hr_id` int(4) NOT NULL,
  `cart_name` varchar(150) NOT NULL,
  `status` int(4) NOT NULL COMMENT '0 - live 1- no live',
  `room_status` int(4) NOT NULL COMMENT '0- free 1-booked',
  `date` varchar(10) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hms_room_cart`
--

INSERT INTO `hms_room_cart` (`hrc_id`, `category`, `floor`, `hr_id`, `cart_name`, `status`, `room_status`, `date`, `date_time`) VALUES
(8, 1, 1, 5, 'A', 0, 0, '2015-04-06', '2015-04-20 11:17:20'),
(9, 1, 1, 5, 'B', 0, 0, '2015-04-06', '2015-04-20 07:13:44'),
(10, 1, 1, 5, 'C', 0, 0, '2015-04-06', '2015-04-09 09:15:54'),
(11, 1, 2, 6, 'A', 0, 0, '2015-04-06', '2015-04-18 11:39:55'),
(12, 1, 2, 6, 'B', 0, 0, '2015-04-06', '2015-04-20 11:25:34'),
(14, 1, 2, 6, 'C', 0, 0, '2015-04-06', '2015-04-18 10:09:22'),
(15, 1, 2, 6, 'D', 0, 0, '2015-04-06', '2015-04-18 10:09:04'),
(16, 1, 2, 6, 'E', 0, 0, '2015-04-07', '2015-04-20 07:17:46'),
(17, 2, 3, 7, 'A', 0, 0, '2015-04-10', '2015-04-10 07:24:52'),
(18, 2, 3, 7, 'B', 0, 0, '2015-04-10', '2015-04-10 07:24:52'),
(37, 1, 1, 13, 'a', 0, 0, '2015-04-10', '2015-04-20 11:17:50'),
(38, 1, 1, 13, 'b', 1, 0, '2015-04-10', '2015-04-10 09:54:46'),
(39, 1, 1, 14, 'd', 0, 0, '2015-04-10', '2015-04-20 08:39:52'),
(40, 1, 1, 14, 'f', 0, 0, '2015-04-10', '2015-04-18 10:08:40'),
(41, 1, 1, 15, '1', 0, 0, '2015-04-10', '2015-04-11 12:15:37'),
(42, 1, 1, 15, '2', 0, 0, '2015-04-10', '2015-04-20 08:43:30'),
(43, 1, 1, 15, '3', 0, 0, '2015-04-10', '2015-04-10 08:58:31'),
(44, 1, 1, 16, 'I', 0, 0, '2015-04-10', '2015-04-20 07:56:19'),
(45, 1, 1, 16, 'II', 0, 0, '2015-04-10', '2015-04-18 09:51:10'),
(46, 1, 1, 16, 'III', 0, 0, '2015-04-10', '2015-04-10 08:58:31'),
(47, 1, 1, 16, 'IV', 0, 0, '2015-04-10', '2015-04-10 08:58:31'),
(48, 1, 1, 16, 'V', 0, 0, '2015-04-10', '2015-04-10 08:58:31'),
(49, 1, 1, 17, 'A', 0, 0, '2015-04-10', '2015-04-20 11:17:44'),
(50, 1, 1, 17, 'B', 0, 0, '2015-04-10', '2015-04-20 11:17:32'),
(51, 1, 1, 17, 'C', 0, 0, '2015-04-10', '2015-04-10 08:58:31'),
(52, 1, 1, 17, 'A1', 0, 0, '2015-04-10', '2015-04-20 11:17:37'),
(53, 1, 1, 17, 'B1', 0, 0, '2015-04-10', '2015-04-20 11:17:27'),
(54, 1, 1, 17, 'C1', 0, 0, '2015-04-10', '2015-04-10 08:58:31'),
(55, 1, 1, 13, 'c', 0, 0, '2015-04-10', '2015-04-20 08:47:19'),
(57, 1, 1, 5, 'D', 0, 0, '2015-04-10', '2015-04-10 09:28:35'),
(59, 2, 3, 18, 'A', 0, 0, '2015-04-10', '2015-04-20 08:47:31'),
(60, 1, 2, 6, 'F', 0, 0, '2015-04-10', '2015-04-10 13:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `hms_room_type`
--

CREATE TABLE IF NOT EXISTS `hms_room_type` (
`hrt_id` int(4) NOT NULL,
  `room_type` varchar(200) NOT NULL,
  `status` int(4) NOT NULL COMMENT '0 - live 1- no live'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hms_room_type`
--

INSERT INTO `hms_room_type` (`hrt_id`, `room_type`, `status`) VALUES
(1, 'NON A/C Rooms', 0),
(2, 'A/C Room', 0),
(3, 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hms_staff_room`
--

CREATE TABLE IF NOT EXISTS `hms_staff_room` (
`hsr_id` int(4) NOT NULL,
  `category` int(4) NOT NULL,
  `floor` int(4) NOT NULL,
  `hr_id` int(4) NOT NULL,
  `hrc_id` int(4) NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `r_ay_id` int(4) NOT NULL COMMENT 'register ',
  `v_ay_id` varchar(80) NOT NULL COMMENT 'vacate ',
  `join_date` varchar(20) NOT NULL,
  `vacate_date` varchar(10) NOT NULL,
  `status` int(4) NOT NULL COMMENT '0 - live 1- no live',
  `date` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hms_staff_room`
--

INSERT INTO `hms_staff_room` (`hsr_id`, `category`, `floor`, `hr_id`, `hrc_id`, `staff_id`, `firstname`, `lastname`, `r_ay_id`, `v_ay_id`, `join_date`, `vacate_date`, `status`, `date`, `date_time`) VALUES
(3, 1, 2, 6, 12, 'ST004', 'Anitha', 'S', 2, '2', '2015-04-20', '2015-04-20', 1, '2015-04-20', '2015-04-20 11:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `hms_studentcash_amount`
--

CREATE TABLE IF NOT EXISTS `hms_studentcash_amount` (
`hsca_id` int(4) NOT NULL,
  `hsr_id` int(4) NOT NULL,
  `admission_number` varchar(100) NOT NULL,
  `amount` varchar(150) NOT NULL,
  `given_amount` int(4) NOT NULL,
  `vacate_date` varchar(10) NOT NULL,
  `r_ay_id` int(11) NOT NULL COMMENT 'register year',
  `v_ay_id` varchar(50) NOT NULL COMMENT 'vacate year',
  `payment_status` int(4) NOT NULL COMMENT '0 - receive 1-delivered',
  `date` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hms_studentflow_room`
--

CREATE TABLE IF NOT EXISTS `hms_studentflow_room` (
`hsfr_id` int(4) NOT NULL,
  `reg_id` int(4) NOT NULL,
  `role` varchar(100) NOT NULL,
  `hostel` varchar(200) NOT NULL,
  `floor` varchar(200) NOT NULL,
  `room_number` varchar(200) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_type` varchar(200) NOT NULL,
  `start_date` varchar(20) NOT NULL,
  `end_date` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hms_student_changeroom`
--

CREATE TABLE IF NOT EXISTS `hms_student_changeroom` (
`hscr_id` int(4) NOT NULL,
  `hsr_id` int(4) NOT NULL,
  `category` int(4) NOT NULL,
  `floor` int(4) NOT NULL,
  `hr_id` int(4) NOT NULL,
  `hrc_id` int(4) NOT NULL,
  `admission_number` varchar(200) NOT NULL,
  `ay_id` int(4) NOT NULL,
  `join_date` varchar(20) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `payment_status` int(4) NOT NULL,
  `payment_type` int(4) NOT NULL COMMENT '0 - no given amount 1- given amount',
  `date` varchar(10) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hms_student_room`
--

CREATE TABLE IF NOT EXISTS `hms_student_room` (
`hsr_id` int(4) NOT NULL,
  `category` int(4) NOT NULL,
  `floor` int(4) NOT NULL,
  `hr_id` int(4) NOT NULL,
  `hrc_id` int(4) NOT NULL,
  `admission_number` varchar(255) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `reg_class` int(4) NOT NULL,
  `r_ay_id` int(4) NOT NULL COMMENT 'register ',
  `v_ay_id` varchar(80) NOT NULL COMMENT 'vacate ',
  `room_date` varchar(20) NOT NULL,
  `join_date` varchar(20) NOT NULL,
  `vacate_date` varchar(10) NOT NULL,
  `status` int(4) NOT NULL COMMENT '0 - live 1- no live',
  `date` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hms_worker`
--

CREATE TABLE IF NOT EXISTS `hms_worker` (
`hw_id` int(4) NOT NULL,
  `category` int(4) NOT NULL,
  `job_name` varchar(200) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `status` int(4) NOT NULL COMMENT '0 - live 1- no live',
  `date` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hms_worker`
--

INSERT INTO `hms_worker` (`hw_id`, `category`, `job_name`, `name`, `position`, `qualification`, `status`, `date`, `date_time`) VALUES
(1, 2, '', 'sivasekar', 'MANGEMENTS', 'BCA,MCA', 0, '2015-04-09', '2015-04-09 10:10:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hms_cash_deposit`
--
ALTER TABLE `hms_cash_deposit`
 ADD PRIMARY KEY (`hcd_id`);

--
-- Indexes for table `hms_category`
--
ALTER TABLE `hms_category`
 ADD PRIMARY KEY (`h_id`);

--
-- Indexes for table `hms_feestype`
--
ALTER TABLE `hms_feestype`
 ADD PRIMARY KEY (`hft_id`);

--
-- Indexes for table `hms_fees_structure`
--
ALTER TABLE `hms_fees_structure`
 ADD PRIMARY KEY (`hfs_id`);

--
-- Indexes for table `hms_floor`
--
ALTER TABLE `hms_floor`
 ADD PRIMARY KEY (`hf_id`);

--
-- Indexes for table `hms_hinvoice`
--
ALTER TABLE `hms_hinvoice`
 ADD PRIMARY KEY (`hin_id`);

--
-- Indexes for table `hms_hinvoice_sumarry`
--
ALTER TABLE `hms_hinvoice_sumarry`
 ADD PRIMARY KEY (`ibs_id`);

--
-- Indexes for table `hms_invoice_no`
--
ALTER TABLE `hms_invoice_no`
 ADD PRIMARY KEY (`hin_id`);

--
-- Indexes for table `hms_room`
--
ALTER TABLE `hms_room`
 ADD PRIMARY KEY (`hr_id`);

--
-- Indexes for table `hms_room_cart`
--
ALTER TABLE `hms_room_cart`
 ADD PRIMARY KEY (`hrc_id`), ADD UNIQUE KEY `unique_index` (`hr_id`,`cart_name`);

--
-- Indexes for table `hms_room_type`
--
ALTER TABLE `hms_room_type`
 ADD PRIMARY KEY (`hrt_id`);

--
-- Indexes for table `hms_staff_room`
--
ALTER TABLE `hms_staff_room`
 ADD PRIMARY KEY (`hsr_id`);

--
-- Indexes for table `hms_studentcash_amount`
--
ALTER TABLE `hms_studentcash_amount`
 ADD PRIMARY KEY (`hsca_id`);

--
-- Indexes for table `hms_studentflow_room`
--
ALTER TABLE `hms_studentflow_room`
 ADD PRIMARY KEY (`hsfr_id`);

--
-- Indexes for table `hms_student_changeroom`
--
ALTER TABLE `hms_student_changeroom`
 ADD PRIMARY KEY (`hscr_id`);

--
-- Indexes for table `hms_student_room`
--
ALTER TABLE `hms_student_room`
 ADD PRIMARY KEY (`hsr_id`);

--
-- Indexes for table `hms_worker`
--
ALTER TABLE `hms_worker`
 ADD PRIMARY KEY (`hw_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hms_cash_deposit`
--
ALTER TABLE `hms_cash_deposit`
MODIFY `hcd_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `hms_category`
--
ALTER TABLE `hms_category`
MODIFY `h_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hms_feestype`
--
ALTER TABLE `hms_feestype`
MODIFY `hft_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `hms_fees_structure`
--
ALTER TABLE `hms_fees_structure`
MODIFY `hfs_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `hms_floor`
--
ALTER TABLE `hms_floor`
MODIFY `hf_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hms_hinvoice`
--
ALTER TABLE `hms_hinvoice`
MODIFY `hin_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `hms_hinvoice_sumarry`
--
ALTER TABLE `hms_hinvoice_sumarry`
MODIFY `ibs_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `hms_invoice_no`
--
ALTER TABLE `hms_invoice_no`
MODIFY `hin_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hms_room`
--
ALTER TABLE `hms_room`
MODIFY `hr_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `hms_room_cart`
--
ALTER TABLE `hms_room_cart`
MODIFY `hrc_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `hms_room_type`
--
ALTER TABLE `hms_room_type`
MODIFY `hrt_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `hms_staff_room`
--
ALTER TABLE `hms_staff_room`
MODIFY `hsr_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `hms_studentcash_amount`
--
ALTER TABLE `hms_studentcash_amount`
MODIFY `hsca_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `hms_studentflow_room`
--
ALTER TABLE `hms_studentflow_room`
MODIFY `hsfr_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `hms_student_changeroom`
--
ALTER TABLE `hms_student_changeroom`
MODIFY `hscr_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `hms_student_room`
--
ALTER TABLE `hms_student_room`
MODIFY `hsr_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `hms_worker`
--
ALTER TABLE `hms_worker`
MODIFY `hw_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
