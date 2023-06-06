-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2023 at 08:36 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `oid` int(11) NOT NULL,
  `totalPrice` int(11) NOT NULL,
  `paymentMethod` int(11) NOT NULL,
  `orderDate` datetime NOT NULL,
  `uid` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `dateDelivered` datetime DEFAULT NULL
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
  `oid` int(11) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL
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
  `oid` int(11) NOT NULL,
  `pid` int(11) NOT NULL
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
  `bid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers_in_branch`
--

CREATE TABLE `suppliers_in_branch` (
  `sbid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `bid` int(11) NOT NULL
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
  `building` varchar(255) NOT NULL,
  `road` varchar(255) NOT NULL,
  `block` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `email`, `fName`, `hash`, `pcode`, `type`, `number`, `isDeleted`, `bid`, `building`, `road`, `block`) VALUES
(1, 'mohd1', 'mohdosama2025@gmail.com', 'Mohamed Ali', '$2y$10$qrvkrZ0JDY/LUosgNy0QPufbQhWxxpa6gAyY.CCYvtwAp9ZG4pn.a', '588514', 'admin', '', 0, NULL, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`bid`);

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
  ADD KEY `sid` (`sid`),
  ADD KEY `oid` (`oid`);

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
  ADD PRIMARY KEY (`sid`),
  ADD KEY `bid` (`bid`);

--
-- Indexes for table `suppliers_in_branch`
--
ALTER TABLE `suppliers_in_branch`
  ADD PRIMARY KEY (`sbid`),
  ADD KEY `sid` (`sid`),
  ADD KEY `bid` (`bid`);

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
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `suppliers_in_branch`
--
ALTER TABLE `suppliers_in_branch`
  MODIFY `sbid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `suppliers` (`sid`);

--
-- Constraints for table `products_in_branch`
--
ALTER TABLE `products_in_branch`
  ADD CONSTRAINT `products_in_branch_ibfk_3` FOREIGN KEY (`bid`) REFERENCES `branches` (`bid`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_in_branch_ibfk_4` FOREIGN KEY (`pid`) REFERENCES `products` (`pid`) ON DELETE CASCADE;

--
-- Constraints for table `products_in_order`
--
ALTER TABLE `products_in_order`
  ADD CONSTRAINT `products_in_order_ibfk_1` FOREIGN KEY (`oid`) REFERENCES `orders` (`oid`),
  ADD CONSTRAINT `products_in_order_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `products` (`pid`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`bid`) REFERENCES `branches` (`bid`);

--
-- Constraints for table `suppliers_in_branch`
--
ALTER TABLE `suppliers_in_branch`
  ADD CONSTRAINT `suppliers_in_branch_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `suppliers` (`sid`) ON DELETE CASCADE,
  ADD CONSTRAINT `suppliers_in_branch_ibfk_2` FOREIGN KEY (`bid`) REFERENCES `branches` (`bid`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`bid`) REFERENCES `branches` (`bid`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
