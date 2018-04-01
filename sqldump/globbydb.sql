-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2018 at 05:09 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `globbydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `gamehistory`
--

CREATE TABLE `gamehistory` (
  `UID` int(11) NOT NULL,
  `GID` int(11) NOT NULL,
  `win` int(11) NOT NULL,
  `loss` int(11) NOT NULL,
  `draw` int(11) NOT NULL,
  `lastPlayed` date NOT NULL,
  `lastOpponent` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `GID` int(11) NOT NULL,
  `gName` text NOT NULL,
  `gType` varchar(20) NOT NULL,
  `numPlayed` int(11) DEFAULT NULL,
  `lastPlayed` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`GID`, `gName`, `gType`, `numPlayed`, `lastPlayed`) VALUES
(1, 'Tic Tac Toe', 'Arcade', 0, '0000-00-00'),
(2, 'Rock Paper Scissors', 'Arcade', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `playerhistory`
--

CREATE TABLE `playerhistory` (
  `UID` int(11) NOT NULL,
  `wins` int(11) NOT NULL,
  `losses` int(11) NOT NULL,
  `draws` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UID` int(11) NOT NULL,
  `uName` varchar(20) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(40) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'F'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UID`, `uName`, `email`, `password`, `status`) VALUES
(2, 'username1', 'username1@email.com', 'b637c2f3a5b392ec0676d5e78c7309c7ccc5e3b6', 'F'),
(3, 'username2', 'username2@email.com', 'f9306bf530fa1b23907a4089a242c6928cad5973', 'F'),
(4, 'username3', 'username3@email.com', '5aa3abad3e81c2269e6063fee54cc442af366e18', 'G'),
(5, 'username4', 'username4@email.com', '783b79cf784999033417e1dbbdc9cc589b2d8de5', 'F'),
(6, 'username5', 'username5@email.com', '9003a7d1fd319989358cceedd6cb81f2abc1e449', 'G'),
(7, 'username6', 'username6@email.com', 'cbef6562517377b73f8aa51ddb63c85920d3d5fe', 'F'),
(8, 'username7', 'username7@email.com', '5d7a1e1e406e720a5e3e86ca157773454a01788f', 'F'),
(9, 'username8', 'username8@email.com', '9a3034cd0e45788ad3af0f88b546e3afbb6d7800', 'F'),
(10, 'username9', 'username9@email.com', 'b1bef7b1f583083842bf314e566717f2987d28f0', 'F'),
(11, 'username10', 'username10@email.com', 'f4b0becc73c3cd3c564626e167ac02720843bc26', 'F');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gamehistory`
--
ALTER TABLE `gamehistory`
  ADD PRIMARY KEY (`UID`,`GID`),
  ADD UNIQUE KEY `UID` (`UID`,`GID`),
  ADD KEY `GID` (`GID`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`GID`);

--
-- Indexes for table `playerhistory`
--
ALTER TABLE `playerhistory`
  ADD KEY `UID` (`UID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `GID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gamehistory`
--
ALTER TABLE `gamehistory`
  ADD CONSTRAINT `gamehistory_ibfk_1` FOREIGN KEY (`GID`) REFERENCES `games` (`GID`),
  ADD CONSTRAINT `gamehistory_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `users` (`UID`);

--
-- Constraints for table `playerhistory`
--
ALTER TABLE `playerhistory`
  ADD CONSTRAINT `playerhistory_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `users` (`UID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
