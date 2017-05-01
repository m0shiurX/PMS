-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2016 at 12:51 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `kp_category`
--

CREATE TABLE IF NOT EXISTS `kp_category` (
  `cat_id` int(3) NOT NULL,
  `cat_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Category name for products table, parents to products';

-- --------------------------------------------------------

--
-- Table structure for table `kp_production`
--

CREATE TABLE IF NOT EXISTS `kp_production` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pro_id` int(11) NOT NULL,
  `pro_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kp_products`
--

CREATE TABLE IF NOT EXISTS `kp_products` (
  `pro_id` int(3) NOT NULL COMMENT 'Product identity no',
  `pro_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Product name',
  `pro_unit` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Product unit',
  `pro_category` varchar(20) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL COMMENT 'Product category: Child of kp_category table',
  `pro_details` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Product details',
  `pro_color` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Color of product',
  `pro_length` float NOT NULL COMMENT 'Length of product',
  `pro_radious` float NOT NULL COMMENT 'Radious of the product',
  `pro_max` int(11) NOT NULL COMMENT 'Maximum limit of products',
  `pro_min` int(11) NOT NULL COMMENT 'Minimum required products',
  `pro_dropped` int(1) NOT NULL DEFAULT '0' COMMENT 'If a product is dropped or not'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table for individuals products';

--
-- Dumping data for table `kp_products`
--

INSERT INTO `kp_products` (`pro_id`, `pro_name`, `pro_unit`, `pro_category`, `pro_details`, `pro_color`, `pro_length`, `pro_radious`, `pro_max`, `pro_min`, `pro_dropped`) VALUES
(1, 'alu', 'kg', 'vegetables', 'Alooo', 'red', 5, 2, 5, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kp_raw`
--

CREATE TABLE IF NOT EXISTS `kp_raw` (
  `raw_id` int(3) NOT NULL COMMENT 'Raw id',
  `raw_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL COMMENT 'Raw name',
  `raw_unit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `raw_quantity` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table for raw products';

--
-- Dumping data for table `kp_raw`
--

INSERT INTO `kp_raw` (`raw_id`, `raw_name`, `raw_unit`, `raw_quantity`) VALUES
(1, 'komuna', 'kg', 0),
(2, 'foinni', 'pickometer', 0),
(3, 'a', 'b', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kp_stocking`
--

CREATE TABLE IF NOT EXISTS `kp_stocking` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `pro_sold` int(11) NOT NULL,
  `pro_waste` int(11) NOT NULL,
  `pro_return` int(11) NOT NULL,
  `pro_avail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kp_user`
--

CREATE TABLE IF NOT EXISTS `kp_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_pwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `c_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `authentication` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kp_user`
--

INSERT INTO `kp_user` (`user_id`, `user_name`, `user_pwd`, `full_name`, `email`, `contact`, `address`, `c_date`, `authentication`) VALUES
(2, 'misu', '$2y$10$xllqQzBr7NU4/tgWlGdlWejLNntL4EL8FSZABvpR40dQv09pW5aBi', 'Musfiqur Rahman', NULL, '01715465858', NULL, '2016-11-27 23:32:23', 0),
(3, 'moshiur', '$2y$10$qruGJXZAArxFNQnvDCmgHOETK31GSqrvsL5l0H/3.cOYaJo7FTaEq', 'Moshiur Rahman', 'unimrgm@gmail.com', '01719454658', 'Uposhohor, Bogra', '2016-11-27 23:33:30', 1),
(11, 'another', '$2y$10$xMugMtccCmHX5/ndF7I6le.cE6kYpHbly0Evg5HbeudN6uR5wSfsS', 'Another User', 'another@email.com', '01746521452', 'Nowhere', '2016-12-05 22:57:44', 0),
(31, 'fatema', '$2y$10$4Q5jVYSzzqITRoASvYBdCeeBgBj0cnyLXNIgmfbi6XZ2IsqJneyDG', 'Fatema tuz Zohra', 'ftzohra07@gmail.com', '555', 'Bogra', '2016-12-10 17:33:55', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pro_finished`
--

CREATE TABLE IF NOT EXISTS `pro_finished` (
  `pro_id` int(11) NOT NULL,
  `pro_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pro_unfinished`
--

CREATE TABLE IF NOT EXISTS `pro_unfinished` (
  `pro_id` int(11) NOT NULL,
  `pro_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kp_category`
--
ALTER TABLE `kp_category`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `cat_name` (`cat_name`);

--
-- Indexes for table `kp_production`
--
ALTER TABLE `kp_production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kp_products`
--
ALTER TABLE `kp_products`
  ADD PRIMARY KEY (`pro_id`),
  ADD UNIQUE KEY `pro_name` (`pro_name`),
  ADD KEY `pro_category` (`pro_category`);

--
-- Indexes for table `kp_raw`
--
ALTER TABLE `kp_raw`
  ADD PRIMARY KEY (`raw_id`),
  ADD UNIQUE KEY `raw_name` (`raw_name`);

--
-- Indexes for table `kp_stocking`
--
ALTER TABLE `kp_stocking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kp_user`
--
ALTER TABLE `kp_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `pro_finished`
--
ALTER TABLE `pro_finished`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `pro_unfinished`
--
ALTER TABLE `pro_unfinished`
  ADD PRIMARY KEY (`pro_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kp_category`
--
ALTER TABLE `kp_category`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kp_production`
--
ALTER TABLE `kp_production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kp_products`
--
ALTER TABLE `kp_products`
  MODIFY `pro_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Product identity no',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `kp_raw`
--
ALTER TABLE `kp_raw`
  MODIFY `raw_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Raw id',AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kp_user`
--
ALTER TABLE `kp_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `pro_finished`
--
ALTER TABLE `pro_finished`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pro_unfinished`
--
ALTER TABLE `pro_unfinished`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
