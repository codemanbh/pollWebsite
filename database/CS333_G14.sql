-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2023 at 10:55 PM
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
-- Database: `cs333_g14`
--
CREATE DATABASE IF NOT EXISTS `cs333_g14` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cs333_g14`;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `oid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `option` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`oid`, `qid`, `option`) VALUES
(1, 5, 'chicken'),
(2, 5, 'egg'),
(3, 6, 'cereal'),
(4, 6, 'milk'),
(5, 7, 'engine'),
(6, 7, 'car body'),
(7, 9, 'I would rather kill the man'),
(8, 9, 'Die as an innocent'),
(9, 9, 'Rather not say'),
(10, 12, 'Virus'),
(11, 12, 'Infection'),
(12, 12, 'Fungi'),
(13, 12, 'Bacteria'),
(14, 11, 'Red'),
(15, 11, 'Blue'),
(18, 11, 'Green'),
(19, 11, 'Violet'),
(20, 11, 'White'),
(21, 11, 'Orange'),
(22, 13, 'Cobb was still dreaming.'),
(23, 13, 'Cobb was awake by the end.'),
(24, 13, 'I haven\'t seen the movie.'),
(25, 14, 'Sedan'),
(26, 14, 'Coupe'),
(27, 14, 'Pickup truck'),
(28, 14, 'SUV'),
(31, 14, 'Convertible'),
(32, 14, 'Sports'),
(33, 15, 'BMW'),
(34, 15, 'Honda'),
(35, 8, 'million dollars'),
(36, 8, 'loyal dog'),
(37, 10, 'Less than 1 hour'),
(38, 10, '1-2 hours'),
(39, 10, '2-4 hours'),
(40, 10, '4-6 hours'),
(41, 10, 'More than 6 hours');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `qid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `qstatus` varchar(15) NOT NULL,
  `reported` int(11) NOT NULL DEFAULT 0,
  `dueDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`qid`, `uid`, `question`, `qstatus`, `reported`, `dueDate`) VALUES
(5, 1, 'What came first, the chicken or the egg ?', 'Active', 0, NULL),
(6, 1, 'Cereal first or milk first ?', 'Active', 0, NULL),
(7, 2, 'What is built first, the engine or the car body?\r\n', 'Deactivated', 1, NULL),
(8, 4, 'Would you rather have a million dollars or a loyal dog?', 'Active', 0, NULL),
(9, 2, 'Would you rather kill an innocent man or die as one yourself?', 'Active', 0, NULL),
(10, 2, 'How much social media would you say you use in a day on average?', 'Ended', 0, NULL),
(11, 3, 'Which visible light wavelength goes deepest into the sea?', 'Active', 0, NULL),
(12, 3, 'The common cold is caused by?', 'Deactivated', 0, NULL),
(13, 4, 'What is your take on the ending of the movie \"Inception\"?', 'Deactivated', 0, NULL),
(14, 3, 'Whats your favorite type of car?', 'Active', 1, NULL),
(15, 9, 'What is your favorite car ?', 'Ended', 0, '2023-12-27 06:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `uemail` varchar(255) NOT NULL,
  `upassword` varchar(255) NOT NULL,
  `utype` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `uname`, `uemail`, `upassword`, `utype`) VALUES
(1, 'Ahmed', 'Ahmed@gmail.com', '$2y$10$RyQr8qhqVDY7PNacRgoWkOP3c6YVvddDqz/8SXvULvHsr05E5hB6O', 'admin'),
(2, 'Mohammed', 'Mohammed@gmail.com', '$2y$10$XTEV4v6mkMYWtXzQ4Cbh.u4DNGEyJ/zlN4dWl8D1zf4ELMj1yvDDG', 'user'),
(3, 'Ebrahim', 'Ebrahim@gmail.com', '$2y$10$PWk6cBC3yeDZ91KqaWOSF.ASWj9B7jn1.FZ60sWboiyJbziaKb.5q', 'user'),
(4, 'Shakeel', 'shakeel@gmail.com', '$2y$10$pwJVPTssMaVfwEoUBJsKI.GeFP8LYiyWy6XAp3SOrncAhS.yUlkmy', 'user'),
(5, 'Levi', 'leviackerman@gmail.com', '$2y$10$j4XWYjkbtLOfTPJRwV/HaOFVL/lxxPUFSuhz9.U7f.pq5c6WHxRg2', 'user'),
(8, 'killswitch', 'Shakeelmbasharat@gmail.com', '$2y$10$tGOaFVKdhHFpEDrljfkqG.Gtx9sHwiUgojmJBBDiVoTFsdZ1F5dLu', 'user'),
(9, 'Ahmed', 'Ahmed123@gmail.com', '$2y$10$RyQr8qhqVDY7PNacRgoWkOP3c6YVvddDqz/8SXvULvHsr05E5hB6O', 'user'),
(10, 'Ebrahim', 'Ebrahim123@gmail.com', '$2y$10$PWk6cBC3yeDZ91KqaWOSF.ASWj9B7jn1.FZ60sWboiyJbziaKb.5q', 'admin'),
(11, 'Mohammed', 'Mohammed123@gmail.com', '$2y$10$XTEV4v6mkMYWtXzQ4Cbh.u4DNGEyJ/zlN4dWl8D1zf4ELMj1yvDDG', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `vid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `oid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`vid`, `uid`, `qid`, `oid`) VALUES
(1, 2, 5, 1),
(2, 1, 5, 2),
(3, 3, 6, 3),
(4, 3, 5, 1),
(5, 3, 7, 5),
(6, 1, 6, 4),
(7, 2, 6, 3),
(8, 1, 12, 10),
(10, 1, 7, 5),
(27, 4, 14, 32),
(28, 1, 13, 23),
(29, 5, 13, 23),
(30, 5, 14, 28),
(31, 5, 12, 10),
(32, 5, 11, 14),
(33, 5, 9, 8),
(34, 9, 15, 33),
(35, 3, 15, 33),
(36, 10, 11, 19),
(37, 8, 6, 3),
(38, 9, 6, 4),
(39, 10, 5, 2),
(40, 10, 6, 3),
(41, 10, 8, 35),
(42, 9, 5, 1),
(43, 9, 9, 8),
(44, 9, 11, 14),
(45, 9, 14, 26),
(46, 1, 10, 37),
(47, 2, 10, 38),
(48, 3, 10, 40),
(49, 4, 10, 41),
(50, 5, 10, 40),
(51, 8, 10, 40),
(52, 9, 10, 39),
(53, 10, 10, 39),
(54, 11, 10, 37),
(59, 5, 15, 34),
(60, 4, 15, 33);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `qid` (`qid`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`qid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `uemail` (`uemail`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`vid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `qid` (`qid`),
  ADD KEY `oid` (`oid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`qid`) REFERENCES `questions` (`qid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`qid`) REFERENCES `questions` (`qid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vote_ibfk_3` FOREIGN KEY (`oid`) REFERENCES `options` (`oid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
