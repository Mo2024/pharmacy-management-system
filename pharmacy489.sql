-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2023 at 10:26 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy489`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `uid` int(11) NOT NULL,
  `building` varchar(255) DEFAULT NULL,
  `road` varchar(255) DEFAULT NULL,
  `block` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`uid`, `building`, `road`, `block`) VALUES
(1, '4821', '8884', '453'),
(12, '134', '213', '233'),
(13, '334', '3413', '2343');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `bid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `road` varchar(255) NOT NULL,
  `building` varchar(255) NOT NULL,
  `block` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`bid`, `name`, `area`, `road`, `building`, `block`) VALUES
(1, 'Manama Branch', 'Manama', '3335', '1255', '422'),
(2, 'Seef Muharraq Branch', 'Muharraq ', '34', '27823', '423');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `oid` varchar(255) NOT NULL,
  `totalPrice` int(11) NOT NULL,
  `paymentMethod` varchar(255) NOT NULL,
  `orderDate` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `dateDelivered` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `sid` int(11) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `cid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_in_branch`
--

CREATE TABLE `products_in_branch` (
  `pbid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_in_order`
--

CREATE TABLE `products_in_order` (
  `poid` int(11) NOT NULL,
  `oid` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `sid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `road` varchar(255) NOT NULL,
  `building` varchar(255) NOT NULL,
  `block` varchar(255) NOT NULL,
  `dateAdded` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `pcode` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `bid` int(11) DEFAULT NULL,
  `dateCreated` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `email`, `fName`, `hash`, `pcode`, `type`, `number`, `isDeleted`, `bid`, `dateCreated`) VALUES
(1, 'mohd1', 'mohdosama2025@gmail.com', 'Mohamed Ali', '$2y$10$qrvkrZ0JDY/LUosgNy0QPufbQhWxxpa6gAyY.CCYvtwAp9ZG4pn.a', '588514', 'admin', '211', 0, NULL, 'June 09, 2023'),
(12, 'mohd2', 'mkrfs2002@gmail.com', 'Mohamed Osama ', '$2y$10$SjY1OsuEKudD0qxAvaQNLemzr21Qepj8gcU5ZZtdUiMKwaQOHvhgC', '', 'patient', '34532345', 0, NULL, 'June 14, 2023'),
(13, 'mohd3', 'mkrfs2025@gmail.com', 'Mohamed Osama', '$2y$10$RVsHlG8VCuDeagztvV9XO.9SbI9DCyTxqvGDocyF4P2Wi9A5UeAgq', '', 'pharmacist', '234687232', 0, 1, 'June 14, 2023');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `products_ibfk_1` (`sid`),
  ADD KEY `products_ibfk_2` (`cid`);

--
-- Indexes for table `products_in_branch`
--
ALTER TABLE `products_in_branch`
  ADD PRIMARY KEY (`pbid`),
  ADD KEY `bid` (`bid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `products_in_order`
--
ALTER TABLE `products_in_order`
  ADD PRIMARY KEY (`poid`),
  ADD KEY `oid` (`oid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `bid` (`bid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_in_branch`
--
ALTER TABLE `products_in_branch`
  MODIFY `pbid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_in_order`
--
ALTER TABLE `products_in_order`
  MODIFY `poid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `uid` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `suppliers` (`sid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `category` (`cid`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `products_in_branch`
--
ALTER TABLE `products_in_branch`
  ADD CONSTRAINT `products_in_branch_ibfk_3` FOREIGN KEY (`bid`) REFERENCES `branches` (`bid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_in_branch_ibfk_4` FOREIGN KEY (`pid`) REFERENCES `products` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_in_order`
--
ALTER TABLE `products_in_order`
  ADD CONSTRAINT `products_in_order_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `products` (`pid`),
  ADD CONSTRAINT `products_in_order_ibfk_3` FOREIGN KEY (`oid`) REFERENCES `orders` (`oid`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`bid`) REFERENCES `branches` (`bid`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
