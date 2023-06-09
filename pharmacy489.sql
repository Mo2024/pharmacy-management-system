-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2023 at 10:50 PM
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
(2, 'dadfs', 'adffsa', 'sasa'),
(3, 'gsdgsd', 'dsgdgs', 'dsgdgs'),
(5, 'miasksa', 'dsadasd', 'ads'),
(6, 'sdff', 'sdfdfs', 'dsfdsf'),
(7, '1266', '3338', '433'),
(8, 'asd2', 'asdas3', 'asdsa'),
(9, '1266', '3338', '433'),
(10, 'jjjj', 'aa', 'bbb');

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
(1, 'Manama Branch', 'Manama', '3335', '1255', '422');

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
  `isDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `name`, `type`, `price`, `sid`, `isDeleted`) VALUES
(1, 'Panadol', 'Medicine', 12.671, 2, 0),
(2, 'Colgate', 'Personal Care', 43.11, 2, 0),
(3, 'asdsa', 'asd', 23, 2, 0),
(4, 'asdas', 'asdsa', 231, 2, 0),
(5, 'asdasd', 'adssaads', 23, 2, 0),
(6, 'sdaasd', 'asdasd', 23223, 2, 0);

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
  `dateAdded` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`sid`, `name`, `area`, `road`, `building`, `block`, `dateAdded`) VALUES
(2, 'Ahmed Ali', 'Jidhafs', '3338', '1266', '433', 'June 09, 2023');

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
  `dateCreated` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `email`, `fName`, `hash`, `pcode`, `type`, `number`, `isDeleted`, `bid`, `dateCreated`) VALUES
(1, 'mohd1', 'mohdosama2025@gmail.com', 'Mohamed Ali', '$2y$10$qrvkrZ0JDY/LUosgNy0QPufbQhWxxpa6gAyY.CCYvtwAp9ZG4pn.a', '588514', 'admin', '211', 0, NULL, 'June 09, 2023'),
(2, 'dasasd', 'mkrfs2002@gmail.coms', 'sadsad', '$2y$10$XPxB.hbtoe2qwGRvKzuhyePnwJPdhNpwDCy.nNZPWumJrDvT.EdGG', '', 'admin', '256965', 0, NULL, 'June 09, 2023'),
(3, 'ssgd', 'mkrfs2002@gmail.com', 'dfsdsf', '$2y$10$En1GxmPF7HwPSOT4JDX6s.Ozbr5he2Nnq1ZFnzVgBSTXB.pfu.FFy', '', 'admin', '5735534', 0, NULL, 'June 09, 2023'),
(5, 'mohd2', 'mrkvsbusiness@gmail.com', 'mohd osama', '$2y$10$ifyu73Iyw2hL7mdWn73Ote0BALx16wWTVet4M4FO0xHODzw3cir/2', '', 'pharmacist', '33270524', 0, 1, 'June 09, 2023'),
(6, 'hadi1', 'had@gmail.com', 'hadi aman', '$2y$10$boLRqa1KEpq/SG9Mqr1eB.PNaGrwss4rRdltGn3.0leQBAhUUfJp.', '0', 'patient', '33270276', 1, NULL, 'June 09, 2023'),
(7, 'adsfsa', 'lsds@gmail.com', 'adsf saadf', '$2y$10$gP1DIRiJgeWvlkfh0H/sjOO2qBGomaY21mFCDUchbKYWsH1zSWLVm', '0', 'patient', '222234', 1, NULL, 'June 09, 2023'),
(8, 'mohd3', 'mkrfs2025@gmail.com', 'Mohamed Osama', '$2y$10$Ebxy8FD82vltBGmUdOAGL./H.vvZkfptSNz0ykXxYZsBOUx1bmSIq', '', 'patient', '33270527', 1, NULL, 'June 09, 2023'),
(9, 'asas', 'hasd@gmail.com', 'dsasd asd', '$2y$10$VJYCY3wi9dN50aVU0.Cx2u7wmp.tiLIh7NpSxHB1F1gTN7OAsMZTq', '', 'patient', '33270527', 1, NULL, 'June 09, 2023'),
(10, 'Mosbsd', 'lkadjn@gmail.com', 'asdsa asdfdf', '$2y$10$pivqXKT1reXT4nPtrYsg3uZM9FkS0h0/epjgZdVsd5goLt4zbk7uW', '', 'patient', '1266', 1, NULL, 'June 09, 2023');

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
  ADD KEY `sid` (`sid`);

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
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers_in_branch`
--
ALTER TABLE `suppliers_in_branch`
  MODIFY `sbid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `suppliers` (`sid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
