-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 10, 2021 at 08:56 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `samsql`
--

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Relation`
--
ALTER TABLE `Relation`
  ADD PRIMARY KEY (`from`,`to`,`status`),
  ADD KEY `since` (`since`);
