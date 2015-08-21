-- phpMyAdmin SQL Dump
-- version 4.4.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2015 at 04:23 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cantein_empty`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `user_id` int(11) NOT NULL,
  `balance` float NOT NULL,
  `validity` date NOT NULL COMMENT 'This will have a date 30 days from the registration.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`user_id`, `balance`, `validity`) VALUES
(4, 0, '2015-09-30');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE IF NOT EXISTS `menu_item` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `cost` float NOT NULL,
  `category_id` int(11) NOT NULL,
  `halfs` tinyint(1) NOT NULL DEFAULT '0',
  `available` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`id`, `name`, `cost`, `category_id`, `halfs`, `available`) VALUES
(1, 'Sunny Side Ups', 25, 1, 0, 1),
(2, 'Hard Boiled Egg', 20, 1, 0, 1),
(3, 'Plain Omelette', 40, 1, 0, 1),
(4, 'Onion and Mushroom Omelette', 55, 1, 0, 1),
(6, 'Tomato Soup', 80, 3, 0, 1),
(7, 'Mushroom Soup', 100, 3, 0, 1),
(8, 'Chicken Soup', 120, 3, 0, 1),
(9, 'Mixed Beans Soup', 80, 3, 0, 1),
(10, 'Veg. Chowmein', 80, 4, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_category`
--

CREATE TABLE IF NOT EXISTS `menu_item_category` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_item_category`
--

INSERT INTO `menu_item_category` (`id`, `name`) VALUES
(1, 'Egg and Omelettes'),
(4, 'Momos and Chowmein'),
(3, 'Soups');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `quantity` float NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `served` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `permission` enum('MANAGER','STAFF','EMPLOYEE') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fname`, `lname`, `email`, `permission`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'mr.', 'admin', 'admin@admin.com', 'MANAGER'),
(3, 'staff', '1253208465b1efa876f982d8a9e73eef', 'mr.', 'staff', 'staff@staff.com', 'STAFF'),
(4, 'vivek', '061a01a98f80f415b1431236b62bb10b', 'vivek', 'shakya', 'vivek@vivek.com', 'EMPLOYEE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `menu_item_category`
--
ALTER TABLE `menu_item_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_item_id` (`menu_item_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `menu_item_category`
--
ALTER TABLE `menu_item_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
