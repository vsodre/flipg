-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2015 at 07:19 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `secure_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`user_id`, `time`) VALUES
(2, '1426877813'),
(2, '1427131314'),
(2, '1427131328'),
(4, '1427405901'),
(2, '1427494115'),
(2, '1428251514');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
`id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `email`, `password`, `salt`) VALUES
(2, 'nate', 'nate@test.com', '98fba03a20792bbe1c553b363408ba876435d92f83976d18ed4ef1cf138dd29c96cd5d32fbf933660ddc8a09ee284ed8079c4aa7c4048f3d6bc98d5a6c5ee19d', 'de9189ea845a4641b07973f41c728001f3627ff1920b760167190615cff50f2e86bf9b5f188da881d97d76126f98180d645adcae7962081716d18384036d8c9d'),
(7, 'Josh', 'JoshHipke@something.com', 'e0453b455e12cd4a78473c3e4e99c52bf69d8c6565effc592c589303b941494da65f8e9da6d21b5828bcae6b9c08ff40181f554098645ff1b04f514c6937bc5b', '66f72c53082277d84b70ec0c6803a44b10abadbdfbd747d31bce423bf3ff7e95542c9612c25627a6b6ef13909ffe2ae45d3f0c4704cf10919fd31668b7b2f08a'),
(8, 'meow', 'cat@kitty.com', '32f60180a41c5af078d01ca98b686e6e8537a5a70fe32a13230df25bddc0575e3088ca861bab59786ded63c8495060899b74adba4dca9092213a6afd80602a12', 'f5737a52e0693fb7eec80cf58b801e7ff4a9f0fed5fdcf4d08534fb50b78597a4ac7ea14b4a2ecd4b79000bf31edf60f57de4857be3596a755820161170ec74a'),
(9, 'New_User', 'NewUser@new.com', '28e939b8629cdcc1744e0c12cc2937fe37de44a8222973765913db04c0fe5494a6a93be63ae90d2f616a345c7ed8c18023cf2fd0dc9113939b61fa5fc2895f0e', '296a83560faa3da1ecff82f4b8f4c2a1d7bc61f7206511d8f9953d852c7d13817db418f9c0f933432a519381b149989e495c595399c640ff48d1dbafa73c0b87'),
(10, 'Guest', 'guest@account.com', '8d94c63de747609dbf247db5abc180afaa412e8cb08efce595eeb54462c20b7b0b68ca3aa26c6fb7156311d60ac4f4669afdddcd89eefec2bc4022266a5147c4', 'fb04d5172d8450437c427269b2d9085f6f2eb6b5d52ff57371254d38b701119a20ddbc3d7f905950a96fda9c7ec469329ae35608e90453a0499686313f7e8e69');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
