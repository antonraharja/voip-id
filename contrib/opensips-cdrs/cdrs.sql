-- phpMyAdmin SQL Dump
-- version 3.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2015 at 02:49 PM
-- Server version: 5.5.40
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `opensips`
--

-- --------------------------------------------------------

--
-- Table structure for table `cdrs`
--

DROP TABLE IF EXISTS `cdrs` ;
CREATE TABLE `cdrs` (
  `cdr_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `call_start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `duration` int(10) unsigned NOT NULL DEFAULT '0',
  `sip_call_id` varchar(128) NOT NULL DEFAULT '',
  `sip_from_tag` varchar(128) NOT NULL DEFAULT '',
  `sip_to_tag` varchar(128) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `src_uri` varchar(128) NOT NULL DEFAULT '',
  `dst_uri` varchar(128) NOT NULL DEFAULT '',
  `caller_domain` varchar(128) NOT NULL DEFAULT '',
  `callee_domain` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`cdr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
