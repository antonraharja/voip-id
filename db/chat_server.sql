-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 25, 2014 at 09:11 PM
-- Server version: 5.5.35-1ubuntu1
-- PHP Version: 5.5.9-1ubuntu2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chat_server`
--

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` varchar(20) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` varchar(20) NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `email`, `website`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@host.local', '', '', '2014-03-25 20:11:19', '2014-03-25 20:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` varchar(20) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` varchar(20) NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `profile_id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', '$2y$10$9AAuMc6iI7Twl0punfHGbeWftgwxcc.b04FRdC8enZAlA9lStSktu', '2014-03-25 20:11:19', '2014-03-25 20:11:19');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
