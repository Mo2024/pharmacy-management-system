-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2023 at 10:07 PM
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
-- Database: `geohub`
--

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `choiceId` int(11) NOT NULL,
  `choice` varchar(255) NOT NULL,
  `questionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`choiceId`, `choice`, `questionId`) VALUES
(5, 'Riffa', 2),
(6, 'Saar', 2),
(7, 'Manama', 2),
(8, 'Zallaq', 2),
(21, 'Asia ', 9),
(22, 'Africa', 9),
(23, 'Australia', 9),
(24, 'Europe', 9),
(25, 'Berlin', 14),
(26, 'Munich ', 14),
(27, 'Frankfurt', 14),
(28, 'Hamburg', 14);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `questionId` int(11) NOT NULL,
  `quizId` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `score` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`questionId`, `quizId`, `type`, `score`, `question`, `answer`) VALUES
(2, 2, 'MCQ', 5, 'The Capital City of Bahrain Is?', 'Manama'),
(3, 2, 'TF', 5, 'Bahrain is located at Europe? ', 'false'),
(4, 2, 'TF', 5, 'Bahrain is located in the Middle East', 'true'),
(5, 2, 'FITB', 5, 'Bahrain\'s Flag color is white and  _____ .', 'red'),
(9, 6, 'MCQ', 5, 'Which continent is known as the \"Land Down Under\"?', 'Australia'),
(10, 6, 'TF', 5, 'Antarctica is the coldest continent on Earth.', 'true'),
(11, 6, 'FITB', 5, ' North America is connected to South America by the ___________ Ocean.', 'Pacific'),
(12, 7, 'TF', 3, 'The capital city of Egypt is Cario.', 'true'),
(13, 7, 'FITB', 3, 'The Capital City of Bahrain is _______.', 'Manama'),
(14, 7, 'MCQ', 3, 'The capital city of Germany is', 'Berlin');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quizid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `nQuestions` int(11) NOT NULL,
  `totalTime` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `dateCreated` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quizid`, `title`, `description`, `nQuestions`, `totalTime`, `uid`, `dateCreated`) VALUES
(2, 'My Country', 'This Quiz is about my country Bahrain. ', 4, 300, 1, 'May 25, 2023'),
(6, 'The Continents', 'This quiz is about the 7 continents. ', 3, 600, 3, 'May 25, 2023'),
(7, 'Capital Cities', 'The Quiz is about the Capitial Cities of some world countries. ', 3, 300, 3, 'May 25, 2023');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `resultId` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `timeElapsed` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `quizId` int(11) NOT NULL,
  `dateConducted` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`resultId`, `score`, `timeElapsed`, `userId`, `quizId`, `dateConducted`) VALUES
(1, 0, 1, 1, 2, 'May 25, 2023'),
(2, 15, 5, 1, 2, 'May 25, 2023'),
(3, 10, 10, 1, 2, 'May 25, 2023'),
(4, 5, 44, 1, 2, 'May 25, 2023'),
(5, 20, 10, 1, 2, 'May 25, 2023'),
(6, 0, 9, 1, 2, 'May 25, 2023'),
(7, 20, 16, 1, 2, 'May 25, 2023'),
(8, 15, 19, 1, 2, 'May 25, 2023'),
(9, 0, 1, 1, 2, 'May 25, 2023'),
(10, 0, 1, 1, 2, 'May 25, 2023'),
(11, 20, 19, 2, 2, 'May 25, 2023'),
(12, 0, 1, 2, 2, 'May 25, 2023'),
(13, 0, 1, 2, 2, 'May 25, 2023'),
(14, 0, 1, 1, 2, 'May 25, 2023'),
(15, 0, 1, 2, 2, 'May 25, 2023'),
(16, 15, 15, 3, 2, 'May 25, 2023'),
(17, 3, 13, 3, 7, 'May 25, 2023'),
(18, 0, 4, 3, 7, 'May 25, 2023'),
(19, 6, 23, 3, 7, 'May 26, 2023'),
(20, 0, 300, 3, 2, 'May 26, 2023'),
(21, 0, 300, 3, 2, 'May 26, 2023'),
(22, 0, 300, 3, 2, 'May 26, 2023'),
(23, 0, 300, 3, 2, 'May 26, 2023'),
(24, 0, 1, 3, 2, 'May 26, 2023'),
(25, 0, 300, 3, 2, 'May 26, 2023'),
(26, 0, 1, 3, 2, 'May 26, 2023'),
(27, 0, 2, 3, 2, 'May 26, 2023'),
(28, 0, 300, 3, 2, 'May 26, 2023'),
(29, 0, 1, 3, 2, 'May 26, 2023'),
(30, 5, 4, 3, 2, 'May 26, 2023'),
(31, 5, 3, 3, 2, 'May 26, 2023'),
(32, 5, 2, 3, 2, 'May 26, 2023'),
(33, 5, 6, 1, 2, 'May 26, 2023'),
(34, 5, 14, 1, 2, 'May 26, 2023'),
(35, 15, 5, 1, 2, 'May 26, 2023'),
(36, 0, 1, 1, 2, 'May 26, 2023'),
(37, 0, 1, 1, 2, 'May 26, 2023'),
(38, 0, 1, 1, 2, 'May 26, 2023'),
(39, 0, 7, 1, 2, 'May 26, 2023'),
(40, 0, 1, 1, 2, 'May 26, 2023'),
(41, 0, 5, 1, 2, 'May 26, 2023'),
(42, 0, 3, 1, 2, 'May 26, 2023'),
(43, 0, 2, 1, 2, 'May 26, 2023'),
(44, 0, 10, 1, 2, 'May 26, 2023'),
(45, 0, 1, 1, 2, 'May 26, 2023'),
(46, 0, 1, 1, 2, 'May 26, 2023'),
(47, 0, 1, 1, 2, 'May 26, 2023'),
(48, 0, 4, 1, 2, 'May 26, 2023'),
(49, 0, 300, 1, 2, 'May 26, 2023'),
(50, 0, 7, 1, 2, 'May 26, 2023'),
(51, 0, 1, 1, 2, 'May 26, 2023'),
(52, 0, 300, 1, 2, 'May 26, 2023'),
(53, 0, 300, 1, 2, 'May 26, 2023'),
(54, 0, 300, 1, 2, 'May 26, 2023'),
(55, 0, 59, 1, 2, 'May 26, 2023'),
(56, 5, 3, 1, 6, 'May 26, 2023'),
(57, 0, 300, 1, 2, 'May 26, 2023'),
(58, 0, 6, 1, 6, 'May 26, 2023'),
(59, 0, 3, 1, 6, 'May 26, 2023'),
(60, 0, 22, 1, 6, 'May 26, 2023'),
(61, 0, 1, 1, 6, 'May 26, 2023'),
(62, 0, 600, 1, 6, 'May 26, 2023'),
(63, 0, 600, 1, 6, 'May 26, 2023'),
(64, 0, 600, 1, 6, 'May 26, 2023'),
(65, 0, 11, 1, 6, 'May 26, 2023'),
(66, 0, 8, 1, 6, 'May 26, 2023'),
(67, 0, 1, 1, 6, 'May 26, 2023'),
(68, 0, 1, 1, 6, 'May 26, 2023'),
(69, 0, 1, 1, 6, 'May 26, 2023'),
(70, 0, 6, 1, 6, 'May 26, 2023'),
(71, 0, 2, 1, 6, 'May 26, 2023'),
(72, 0, 2, 1, 6, 'May 26, 2023'),
(73, 0, 1, 1, 6, 'May 26, 2023'),
(74, 0, 600, 1, 6, 'May 26, 2023'),
(75, 0, 2, 1, 6, 'May 26, 2023'),
(76, 15, 4, 1, 2, 'May 26, 2023'),
(77, 0, 2, 1, 6, 'May 26, 2023'),
(78, 0, 300, 1, 2, 'May 26, 2023'),
(79, 0, 1, 1, 2, 'May 26, 2023'),
(80, 0, 2, 1, 2, 'May 26, 2023'),
(81, 0, 11, 1, 2, 'May 26, 2023'),
(82, 0, 11, 1, 2, 'May 26, 2023'),
(83, 20, 11, 1, 2, 'May 26, 2023');

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
  `pcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `email`, `fName`, `hash`, `pcode`) VALUES
(1, 'mohd', 'mohdosama2025@gmail.com', 'mohd', '$2y$10$p9lfVNtOiEBMk9hmx0/WCu6koVo/HrP7jltcE.4fdQjMgHbVY26ya', '481383'),
(2, 'mohd1', 'mrkvsbusiness@gmail.com', 'mohd', '$2y$10$pT/qDmhaJCUj4GfoVRPcC.LcJkZHKGBNjocanG4mIsO7TvNuigKP6', '727981'),
(3, 'hassanJ', 'mkrfs2002@gmail.omc', 'Hassan', '$2y$10$pT/qDmhaJCUj4GfoVRPcC.LcJkZHKGBNjocanG4mIsO7TvNuigKP6', ''),
(4, 'naeem123', 'mohammednaeem3636@gmail.com', 'naeem mohd', '$2y$10$IwLKbmbjzLbKluPWRLa12u1VrfYMt3ujA12.prRzPOPUKqzG4p.nu', '0'),
(7, 'asdsa', 'asd@gmail.com', 'asokld asjkl', '$2y$10$cO4d29/YvMYxmWhUuMehZ.qR3UV2rmHSo2BBcSXTa.JLY0asvc5E2', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`choiceId`),
  ADD KEY `questionId` (`questionId`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`questionId`),
  ADD KEY `quizId` (`quizId`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quizid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`resultId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `quizId` (`quizId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `choiceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `questionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quizid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `resultId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `choices`
--
ALTER TABLE `choices`
  ADD CONSTRAINT `choices_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `questions` (`questionId`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quizId`) REFERENCES `quiz` (`quizid`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`quizId`) REFERENCES `quiz` (`quizid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
