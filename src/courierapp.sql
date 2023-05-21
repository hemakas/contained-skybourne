-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 24, 2016 at 10:14 PM
-- Server version: 5.7.15-0ubuntu0.16.04.1
-- PHP Version: 5.6.23-2+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courierapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(10) CHARACTER SET latin1 NOT NULL,
  `full_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `address` text CHARACTER SET latin1 NOT NULL,
  `telephone` varchar(50) CHARACTER SET latin1 NOT NULL,
  `mobile` varchar(50) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` tinyint(4) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `active` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `active`, `updated_at`, `created_at`) VALUES
(1, 'Sri Lanka', 1, '2016-08-27 13:14:18', '2016-08-27 13:14:18'),
(2, 'India', 1, '2016-08-27 13:14:23', '2016-08-27 13:14:23'),
(4, 'China', 1, '2016-08-29 12:43:05', '2016-08-29 12:43:05'),
(5, 'England', 1, '2016-08-29 12:44:33', '2016-08-29 12:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `couriercharges`
--

DROP TABLE IF EXISTS `couriercharges`;
CREATE TABLE `couriercharges` (
  `id` int(11) NOT NULL,
  `courier_id` int(11) NOT NULL,
  `fromcountry_id` int(11) NOT NULL,
  `tocountry_id` int(11) NOT NULL,
  `charge_fromcountry` float NOT NULL,
  `charge_tocountry` float NOT NULL,
  `charge` float NOT NULL,
  `minweight` float NOT NULL COMMENT 'Minimum Volumetric Weight for this charge slot',
  `deliverydays` tinyint(4) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `couriercharges`
--

INSERT INTO `couriercharges` (`id`, `courier_id`, `fromcountry_id`, `tocountry_id`, `charge_fromcountry`, `charge_tocountry`, `charge`, `minweight`, `deliverydays`, `updated_at`, `created_at`) VALUES
(2, 2, 5, 1, 5, 6, 30, 3.5, 5, '2016-08-29 17:29:21', '2016-08-29 17:29:21'),
(3, 2, 5, 1, 6, 6, 80, 4.5, 5, '2016-08-29 17:50:01', '2016-08-29 17:50:01'),
(4, 1, 5, 1, 10, 10, 50, 5, 4, '2016-08-29 17:58:46', '2016-08-29 17:58:46'),
(5, 2, 5, 1, 5, 6, 25, 2.5, 5, '2016-08-29 17:29:21', '2016-08-29 17:29:21'),
(6, 2, 5, 1, 5, 6, 32, 3.2, 5, '2016-08-29 17:29:21', '2016-08-29 17:29:21'),
(7, 2, 5, 1, 5, 6, 55, 5.5, 6, '2016-08-29 17:29:21', '2016-08-29 17:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

DROP TABLE IF EXISTS `couriers`;
CREATE TABLE `couriers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `logo` varchar(255) COLLATE utf8_bin NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `logo`, `active`, `created_at`, `updated_at`) VALUES
(1, 'DHL', '277.large', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Trico', '207.large', 1, '0000-00-00 00:00:00', '2016-08-14 10:56:23'),
(3, 'UPS', '277.large', 1, '2016-06-27 20:30:15', '2016-08-27 12:17:04'),
(4, 'Fedex', '207.large', 1, '2016-06-27 20:31:14', '2016-06-27 20:31:14'),
(5, 'DX', '359.large', 1, '2016-06-27 20:33:12', '2016-06-27 20:33:12'),
(6, 'UPS', '359.large', 1, '2016-08-14 08:33:49', '2016-08-14 08:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

DROP TABLE IF EXISTS `deliveries`;
CREATE TABLE `deliveries` (
  `id` int(11) NOT NULL,
  `deliverystatus_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `admin_user_id` int(11) NOT NULL,
  `courier_id` int(11) NOT NULL,
  `from_country_id` int(11) NOT NULL,
  `to_country_id` int(11) NOT NULL,
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
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `deliverystatus`
--

DROP TABLE IF EXISTS `deliverystatus`;
CREATE TABLE `deliverystatus` (
  `id` int(11) NOT NULL,
  `status` varchar(50) COLLATE utf8_bin NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `deliverystatus`
--

INSERT INTO `deliverystatus` (`id`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Requested', '2016-08-27 20:38:29', '2016-08-27 20:36:23'),
(2, 'Collected', '2016-08-27 20:38:36', '2016-08-27 20:38:36'),
(3, 'Shipping', '2016-08-27 20:38:45', '2016-08-27 20:38:45'),
(4, 'Shiped', '2016-08-27 20:38:56', '2016-08-27 20:38:56'),
(6, 'Delivered', '2016-08-27 20:39:14', '2016-08-27 20:39:14');

-- --------------------------------------------------------

--
-- Table structure for table `ports`
--

DROP TABLE IF EXISTS `ports`;
CREATE TABLE `ports` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Dumping data for table `ports`
--

INSERT INTO `ports` (`id`, `country_id`, `name`, `active`, `updated_at`, `created_at`) VALUES
(2, 1, 'Galle', 1, '2016-08-27 13:57:33', '2016-08-27 13:57:33'),
(6, 1, 'Colombo', 1, '2016-08-27 19:04:39', '2016-08-27 14:01:56'),
(8, 2, 'Kattupalli', 1, '2016-08-29 12:42:33', '2016-08-29 12:42:33'),
(9, 4, 'Guganghxi', 1, '2016-08-29 12:43:50', '2016-08-29 12:43:50'),
(10, 5, 'Liverpool', 1, '2016-08-29 12:44:53', '2016-08-29 12:44:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `admin`, `username`, `firstname`, `lastname`, `password`, `email`, `mobile`, `address`, `remember_token`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 0, 'testuser', 'Ftest', 'Ltest', '599d6a3137c76286d358cced247b7cac39f30def', 'skaushalye@yahoo.com', '', '', '3ca3ae7fe58ae4176b59e8423b78e321', '1422966536', '2015-02-03 12:26:39', '2015-02-03 12:33:05'),
(2, 1, 'admin', 'Samurdhi', 'Kaush', '933ac5bba41d52054981eeb0d0e73f5302aa48ca', 'skaushalye@gmail.com', '', '', '783bffa2f01e485fcad9c5fe9f9c01e5', '1334944182', '2011-12-22 11:59:38', '2016-02-29 09:50:16'),
(16, 0, 'skaushalye@yahoo.co.uk', 's', 'm', '6b520a17dd4f480844421c1c3a645921838539ff', 'skaushalye@yahoo.co.uk', '2', 'a', NULL, '1460739000', '2015-12-16 16:09:37', '2016-04-15 16:50:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `couriercharges`
--
ALTER TABLE `couriercharges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliverystatus`
--
ALTER TABLE `deliverystatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ports`
--
ALTER TABLE `ports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `couriercharges`
--
ALTER TABLE `couriercharges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `deliverystatus`
--
ALTER TABLE `deliverystatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ports`
--
ALTER TABLE `ports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
