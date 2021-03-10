-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 10, 2021 at 09:49 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `samsql`
--

-- --------------------------------------------------------

--
-- Table structure for table `BBStatLine`
--

CREATE TABLE `BBStatLine` (
  `BBStatLineID` int(11) NOT NULL,
  `PlayerID` int(11) NOT NULL,
  `StatDate` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Point` double(10,3) NOT NULL,
  `Assists` double(10,3) NOT NULL,
  `Rebounds` double(10,3) NOT NULL,
  `Steals` double(10,3) NOT NULL,
  `Blocks` double(10,3) NOT NULL,
  `FgPercent` double(10,3) NOT NULL,
  `TptPercent` double(10,3) NOT NULL,
  `FtPercent` double(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `League`
--

CREATE TABLE `League` (
  `LeagueID` int(11) NOT NULL,
  `LeagueName` varchar(255) NOT NULL,
  `CreatorId` int(11) DEFAULT NULL,
  `CreatorName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `League`
--

INSERT INTO `League` (`LeagueID`, `LeagueName`, `CreatorId`, `CreatorName`) VALUES
(1, 'FirstLeague', NULL, NULL),
(2, 'secondleague', NULL, NULL),
(26, 'bro', 1, 'testUser'),
(27, 'testing again', 1, 'testUser'),
(28, 'testing alert', 1, 'testUser'),
(29, 'pls for the love of God', 1, 'testUser'),
(30, 'trying 1 more time', 1, 'testUser'),
(31, 'new leagueeeee', 1, 'testUser'),
(32, 'newest league rn', 1, 'testUser'),
(33, 'im tired', 1, 'testUser'),
(36, 'plssss', 1, 'testUser'),
(37, 'fuck this man', 1, 'testUser'),
(38, 'this is like my 12th try', 1, 'testUser'),
(39, '13th try i guess', 1, 'testUser'),
(40, 'trying refresh', 1, 'testUser'),
(42, 'trying refresh!', 1, 'testUser'),
(43, 'can it work', 1, 'testUser'),
(44, 'good', 1, 'testUser'),
(46, 'testing alert pop up', 1, 'testUser');

-- --------------------------------------------------------

--
-- Table structure for table `Player`
--

CREATE TABLE `Player` (
  `PlayerID` int(11) NOT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `FullName` varchar(255) NOT NULL,
  `ApiId` varchar(255) NOT NULL,
  `ActualTeam` varchar(255) DEFAULT 'Free Agent',
  `Age` int(11) DEFAULT '0',
  `TeamID` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Player`
--

INSERT INTO `Player` (`PlayerID`, `FirstName`, `LastName`, `FullName`, `ApiId`, `ActualTeam`, `Age`, `TeamID`) VALUES
(33, 'Steven', 'Adams', 'Steven Adams', '123', 'New Orleans', 22, 1),
(34, 'Jaylen', 'Adams', 'Jaylen Adams', '124', 'Milwaukee', 24, 1),
(35, 'Precious', 'Achiuwa', 'Precious Achiuwa', '125', 'Miami', 26, 2),
(40, 'Dummy', 'Player', 'Dummy Player', '183', 'Nashville', 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PlayerImport`
--

CREATE TABLE `PlayerImport` (
  `Rank` int(11) DEFAULT NULL,
  `FullName` varchar(255) DEFAULT NULL,
  `AbvTeam` varchar(255) DEFAULT NULL,
  `Team` varchar(255) DEFAULT NULL,
  `Pos` varchar(255) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Ft` double(10,5) DEFAULT NULL,
  `Tp` double(10,5) DEFAULT NULL,
  `Fg` double(10,5) DEFAULT NULL,
  `Ppg` double(10,5) DEFAULT NULL,
  `Rpg` double(10,5) DEFAULT NULL,
  `Apg` double(10,5) DEFAULT NULL,
  `Spg` double(10,5) DEFAULT NULL,
  `Bpg` double(10,5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `PlayerImport`
--

INSERT INTO `PlayerImport` (`Rank`, `FullName`, `AbvTeam`, `Team`, `Pos`, `Age`, `Ft`, `Tp`, `Fg`, `Ppg`, `Rpg`, `Apg`, `Spg`, `Bpg`) VALUES
(1, 'Precious Achiuwa', 'Mia', 'Miami', 'F', 21, 0.55700, 0.00000, 0.58100, 6.10000, 4.00000, 0.60000, 0.39000, 0.55000),
(2, 'Jaylen Adams', 'Mil', 'Milwaukee', 'G', 25, 0.00000, 0.00000, 0.12500, 0.30000, 0.40000, 0.30000, 0.00000, 0.00000),
(3, 'Steven Adams', 'Nor', 'New Orleans', 'C', 28, 0.45700, 0.00000, 0.60900, 8.10000, 9.20000, 2.20000, 0.94000, 0.61000),
(4, 'Dummy Player', 'NA', 'Nashville', 'F', 32, 0.21230, 0.12300, 0.23100, 0.23100, 0.23100, 0.31230, 0.31200, 0.31230);

-- --------------------------------------------------------

--
-- Table structure for table `Relation`
--

CREATE TABLE `Relation` (
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `since` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Relation`
--

INSERT INTO `Relation` (`from`, `to`, `status`, `since`) VALUES
('michiinunez', 'testUser', 'F', '2021-03-10 14:03:57'),
('testUser', 'michiinunez', 'F', '2021-03-10 14:03:57'),
('mnunez', 'testUser', 'F', '2021-03-10 14:39:33'),
('testUser', 'mnunez', 'F', '2021-03-10 14:39:33'),
('mnunez', 'michii', 'F', '2021-03-10 14:40:21'),
('michii', 'mnunez', 'F', '2021-03-10 14:40:30'),
('testUser', 'SecUser', 'F', '2021-03-10 14:41:25'),
('SecUser', 'testUser', 'F', '2021-03-10 14:41:43'),
('SecUser', 'neverUsed', 'F', '2021-03-10 14:42:54'),
('neverUsed', 'SecUser', 'F', '2021-03-10 14:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `Team`
--

CREATE TABLE `Team` (
  `TeamID` int(11) NOT NULL,
  `LeagueID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TeamName` varchar(255) NOT NULL,
  `Wins` int(11) NOT NULL DEFAULT '0',
  `Losses` int(11) NOT NULL DEFAULT '0',
  `Ties` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Team`
--

INSERT INTO `Team` (`TeamID`, `LeagueID`, `UserID`, `TeamName`, `Wins`, `Losses`, `Ties`) VALUES
(1, 1, 1, 'testTeam', 0, 0, 0),
(2, 1, 2, 'Of The Eyes', 0, 0, 0),
(3, 2, 1, 'yikes', 0, 0, 0),
(11, 26, 1, 'Team testUser', 0, 0, 0),
(12, 26, 3, 'Team mnunez', 0, 0, 0),
(13, 26, 4, 'Team michiinunez', 0, 0, 0),
(14, 26, 5, 'Team neverUsed', 0, 0, 0),
(15, 27, 1, 'Team testUser', 0, 0, 0),
(16, 27, 4, 'Team michiinunez', 0, 0, 0),
(17, 28, 1, 'Team testUser', 0, 0, 0),
(18, 28, 4, 'Team michiinunez', 0, 0, 0),
(19, 28, 3, 'Team mnunez', 0, 0, 0),
(20, 29, 1, 'Team testUser', 0, 0, 0),
(21, 29, 4, 'Team michiinunez', 0, 0, 0),
(22, 29, 3, 'Team mnunez', 0, 0, 0),
(23, 30, 1, 'Team testUser', 0, 0, 0),
(24, 30, 5, 'Team neverUsed', 0, 0, 0),
(25, 30, 3, 'Team mnunez', 0, 0, 0),
(26, 31, 1, 'Team testUser', 0, 0, 0),
(27, 31, 3, 'Team mnunez', 0, 0, 0),
(28, 32, 1, 'Team testUser', 0, 0, 0),
(29, 32, 5, 'Team neverUsed', 0, 0, 0),
(30, 33, 1, 'Team testUser', 0, 0, 0),
(31, 33, 4, 'Team michiinunez', 0, 0, 0),
(32, 36, 1, 'Team testUser', 0, 0, 0),
(33, 36, 3, 'Team mnunez', 0, 0, 0),
(34, 37, 1, 'Team testUser', 0, 0, 0),
(35, 37, 3, 'Team mnunez', 0, 0, 0),
(36, 38, 1, 'Team testUser', 0, 0, 0),
(37, 38, 3, 'Team mnunez', 0, 0, 0),
(38, 39, 1, 'Team testUser', 0, 0, 0),
(39, 39, 3, 'Team mnunez', 0, 0, 0),
(40, 40, 1, 'Team testUser', 0, 0, 0),
(41, 40, 5, 'Team neverUsed', 0, 0, 0),
(42, 42, 1, 'Team testUser', 0, 0, 0),
(43, 42, 5, 'Team neverUsed', 0, 0, 0),
(44, 43, 1, 'Team testUser', 0, 0, 0),
(45, 43, 2, 'Team SecUser', 0, 0, 0),
(46, 44, 1, 'Team testUser', 0, 0, 0),
(47, 44, 4, 'Team michiinunez', 0, 0, 0),
(48, 46, 1, 'Team testUser', 0, 0, 0),
(49, 46, 4, 'Team michiinunez', 0, 0, 0),
(50, 46, 3, 'Team mnunez', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `Username`, `Password`, `FirstName`, `LastName`) VALUES
(1, 'testUser', 'testPass', 'Our', 'Test'),
(2, 'SecUser', 'Pass', 'Tony', 'Delvecchio'),
(3, 'mnunez', '1234', 'Michelle', 'Nunez'),
(4, 'michiinunez', '1234', 'michii', 'nunez'),
(5, 'neverUsed', '1234', 'Michii', 'Nunez'),
(6, 'michii', '1234', 'mich', 'nune');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BBStatLine`
--
ALTER TABLE `BBStatLine`
  ADD PRIMARY KEY (`BBStatLineID`),
  ADD KEY `PlayerID` (`PlayerID`);

--
-- Indexes for table `League`
--
ALTER TABLE `League`
  ADD PRIMARY KEY (`LeagueID`),
  ADD UNIQUE KEY `LeagueName` (`LeagueName`);

--
-- Indexes for table `Player`
--
ALTER TABLE `Player`
  ADD PRIMARY KEY (`PlayerID`),
  ADD KEY `TeamID` (`TeamID`);

--
-- Indexes for table `Relation`
--
ALTER TABLE `Relation`
  ADD PRIMARY KEY (`from`,`to`,`status`),
  ADD KEY `since` (`since`);

--
-- Indexes for table `Team`
--
ALTER TABLE `Team`
  ADD PRIMARY KEY (`TeamID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `LeagueID` (`LeagueID`),
  ADD KEY `TeamName` (`TeamName`) USING BTREE;

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `BBStatLine`
--
ALTER TABLE `BBStatLine`
  MODIFY `BBStatLineID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `League`
--
ALTER TABLE `League`
  MODIFY `LeagueID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `Player`
--
ALTER TABLE `Player`
  MODIFY `PlayerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `Team`
--
ALTER TABLE `Team`
  MODIFY `TeamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `BBStatLine`
--
ALTER TABLE `BBStatLine`
  ADD CONSTRAINT `BBStatLine_ibfk_1` FOREIGN KEY (`PlayerID`) REFERENCES `Player` (`PlayerID`);

--
-- Constraints for table `Team`
--
ALTER TABLE `Team`
  ADD CONSTRAINT `Team_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`),
  ADD CONSTRAINT `Team_ibfk_2` FOREIGN KEY (`LeagueID`) REFERENCES `League` (`LeagueID`);
