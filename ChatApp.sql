-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 21, 2015 at 06:32 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ChatApp`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `sid` char(60) NOT NULL,
  `usr` varchar(255) DEFAULT NULL,
  `t` datetime DEFAULT NULL,
  `message` enum('online','busy','offline') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`sid`, `usr`, `t`, `message`) VALUES
('mouvj4hbn945phco4qmcoli1c2', 'arjun', '2015-03-19 19:58:30', 'online');

-- --------------------------------------------------------

--
-- Table structure for table `convo`
--

CREATE TABLE IF NOT EXISTS `convo` (
`cid` int(11) NOT NULL,
  `usr1` varchar(255) DEFAULT NULL,
  `usr2` varchar(255) DEFAULT NULL,
  `t` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
`mid` int(32) NOT NULL,
  `fuser` varchar(255) DEFAULT NULL,
  `tuser` varchar(255) DEFAULT NULL,
  `del1` enum('1','0') DEFAULT '0',
  `del2` enum('1','0') DEFAULT '0',
  `msg` blob,
  `t` datetime DEFAULT NULL,
  `receipt` enum('read','unread') DEFAULT 'unread',
  `cid` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

--
-- Dumping data for table `messages`
--



--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(255) NOT NULL,
  `email` varchar(320) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `avatar` varchar(320) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
 ADD PRIMARY KEY (`sid`), ADD KEY `chat_ibfk_1` (`usr`);

--
-- Indexes for table `convo`
--
ALTER TABLE `convo`
 ADD PRIMARY KEY (`cid`), ADD KEY `usr1` (`usr1`), ADD KEY `usr2` (`usr2`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
 ADD PRIMARY KEY (`mid`), ADD KEY `fuser` (`fuser`), ADD KEY `tuser` (`tuser`), ADD KEY `cid` (`cid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`username`), ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `convo`
--
ALTER TABLE `convo`
MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
MODIFY `mid` int(32) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=110;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`usr`) REFERENCES `users` (`username`);

--
-- Constraints for table `convo`
--
ALTER TABLE `convo`
ADD CONSTRAINT `convo_ibfk_1` FOREIGN KEY (`usr1`) REFERENCES `users` (`username`),
ADD CONSTRAINT `convo_ibfk_2` FOREIGN KEY (`usr2`) REFERENCES `users` (`username`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`fuser`) REFERENCES `users` (`username`),
ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`tuser`) REFERENCES `users` (`username`),
ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`cid`) REFERENCES `convo` (`cid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
