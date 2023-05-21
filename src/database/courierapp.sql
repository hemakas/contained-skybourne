-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 27, 2016 at 10:34 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.6.22-4+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `courierapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(10) CHARACTER SET latin1 NOT NULL,
  `full_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `address` text CHARACTER SET latin1 NOT NULL,
  `telephone` varchar(50) CHARACTER SET latin1 NOT NULL,
  `mobile` varchar(50) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` tinyint(4) NOT NULL,
  `modifiedon` datetime NOT NULL,
  `createdon` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `couriercharges`
--

CREATE TABLE IF NOT EXISTS `couriercharges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `courier_id` int(11) NOT NULL,
  `fromport_id` int(11) NOT NULL,
  `toport_id` int(11) NOT NULL,
  `charge_fromcountry` float NOT NULL,
  `charge_tocountry` float NOT NULL,
  `charge` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE IF NOT EXISTS `couriers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'DHL', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Trico', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'DPD', 1, '2016-06-27 20:30:15', '2016-06-27 20:30:15'),
(4, 'Fedex', 1, '2016-06-27 20:31:14', '2016-06-27 20:31:14'),
(5, 'DX', 1, '2016-06-27 20:33:12', '2016-06-27 20:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE IF NOT EXISTS `deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `admin_user_id` int(11) NOT NULL,
  `courier_id` int(11) NOT NULL,
  `from_port_id` int(11) NOT NULL,
  `to_port_id` int(11) NOT NULL,
  `collection_date` date NOT NULL,
  `collection_from_time` time NOT NULL,
  `collection_to_time` time NOT NULL,
  `tracking_no` varchar(255) COLLATE utf8_bin NOT NULL,
  `collected_datetime` datetime NOT NULL,
  `collection_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `collection_address` text COLLATE utf8_bin NOT NULL,
  `collection_phone` varchar(50) COLLATE utf8_bin NOT NULL,
  `collection_mobile` varchar(50) COLLATE utf8_bin NOT NULL,
  `collection_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `collection_note` text COLLATE utf8_bin NOT NULL,
  `drop_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `drop_address` text COLLATE utf8_bin NOT NULL,
  `drop_phone` varchar(50) COLLATE utf8_bin NOT NULL,
  `drop_mobile` varchar(50) COLLATE utf8_bin NOT NULL,
  `drop_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `drop_note` text COLLATE utf8_bin NOT NULL,
  `length` int(8) NOT NULL,
  `width` int(8) NOT NULL,
  `height` int(8) NOT NULL,
  `weight` float NOT NULL,
  `amount` float NOT NULL,
  `discount` float NOT NULL,
  `charge` float NOT NULL,
  `note` text COLLATE utf8_bin NOT NULL,
  `delivery_status` int(11) NOT NULL,
  `modifiedon` datetime NOT NULL,
  `createdon` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `deliverystatus`
--

CREATE TABLE IF NOT EXISTS `deliverystatus` (
  `id` int(11) NOT NULL,
  `status` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ports`
--

CREATE TABLE IF NOT EXISTS `ports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `countryid` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin` tinyint(1) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `last_login` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `admin`, `username`, `firstname`, `lastname`, `password`, `email`, `mobile`, `address`, `remember_token`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 0, 'testuser', 'Ftest', 'Ltest', '599d6a3137c76286d358cced247b7cac39f30def', 'skaushalye@yahoo.com', '', '', '3ca3ae7fe58ae4176b59e8423b78e321', '1422966536', '2015-02-03 12:26:39', '2015-02-03 12:33:05'),
(2, 1, 'admin', 'Samurdhi', 'Kaush', '933ac5bba41d52054981eeb0d0e73f5302aa48ca', 'skaushalye@gmail.com', '', '', '783bffa2f01e485fcad9c5fe9f9c01e5', '1334944182', '2011-12-22 11:59:38', '2016-02-29 09:50:16'),
(16, 0, 'skaushalye@yahoo.co.uk', 's', 'm', '6b520a17dd4f480844421c1c3a645921838539ff', 'skaushalye@yahoo.co.uk', '2', 'a', NULL, '1460739000', '2015-12-16 16:09:37', '2016-04-15 16:50:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
