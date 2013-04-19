-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 02, 2011 at 10:02 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dvdgames_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(6) NOT NULL AUTO_INCREMENT,
  `inv_id` int(6) NOT NULL DEFAULT '0',
  `cart_session` varchar(255) NOT NULL,
  `cart_tgl` datetime NOT NULL,
  `qty_total` int(3) NOT NULL DEFAULT '0',
  `dvd_total` int(3) NOT NULL DEFAULT '0',
  `dvd_harga` int(7) NOT NULL DEFAULT '0',
  `bonus_total` int(3) NOT NULL DEFAULT '0',
  `bonus_harga` int(7) NOT NULL DEFAULT '0',
  `grand_total` int(8) NOT NULL DEFAULT '0',
  `cart_status` int(1) NOT NULL DEFAULT '0',
  `on_status_all` int(1) NOT NULL DEFAULT '0',
  `modifed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cart_id`),
  KEY `inv_id` (`inv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cart_detail`
--

CREATE TABLE IF NOT EXISTS `cart_detail` (
  `cart_id` int(6) NOT NULL,
  `dvd_id` int(6) NOT NULL,
  `qty` int(3) NOT NULL DEFAULT '1',
  `jml_dvd` int(3) NOT NULL DEFAULT '0',
  `total_harga` int(7) NOT NULL DEFAULT '0',
  `on_status` int(1) NOT NULL DEFAULT '0',
  `modifed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `cart_id` (`cart_id`),
  KEY `dvd_id` (`dvd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `inv_id` int(6) NOT NULL AUTO_INCREMENT,
  `cart_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `inv_no` int(11) NOT NULL,
  `inv_code` varchar(6) NOT NULL,
  `inv_unix` int(3) NOT NULL,
  `inv_tgl` datetime NOT NULL,
  `inv_status` int(2) NOT NULL DEFAULT '0',
  `sync_id` int(6) NOT NULL,
  `tiki_paket` varchar(3) NOT NULL,
  `tiki_tariff` int(7) NOT NULL,
  `tiki_noresi` bigint(20) NOT NULL,
  `tiki_status` int(1) NOT NULL,
  `tiki_kirim` datetime NOT NULL,
  `grand_total_all` int(8) NOT NULL,
  `keterangan` text NOT NULL,
  `resend_mail` int(2) NOT NULL DEFAULT '0',
  `modifed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`inv_id`),
  KEY `cart_id` (`cart_id`),
  KEY `user_id` (`user_id`),
  KEY `sync_id` (`sync_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `master_dvd`
--

CREATE TABLE IF NOT EXISTS `master_dvd` (
  `dvd_id` int(6) NOT NULL AUTO_INCREMENT,
  `kat_id` int(6) NOT NULL,
  `dvd_kode` varchar(50) NOT NULL,
  `dvd_nama` varchar(50) NOT NULL,
  `dvd_review` text NOT NULL,
  `dvd_jumlah` int(1) NOT NULL,
  `dvd_release` date NOT NULL,
  `dvd_serial` text NOT NULL,
  `dvd_cheat` text NOT NULL,
  `dvd_link` text NOT NULL,
  `dvd_gambar` varchar(100) NOT NULL,
  `dvd_rating` int(1) NOT NULL DEFAULT '2',
  `keterangan` text NOT NULL,
  `dvd_status` int(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modifed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dvd_id`),
  KEY `kat_id` (`kat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=172 ;

--
-- Dumping data for table `master_dvd`
--

INSERT INTO `master_dvd` (`dvd_id`, `kat_id`, `dvd_kode`, `dvd_nama`, `dvd_review`, `dvd_jumlah`, `dvd_release`, `dvd_serial`, `dvd_cheat`, `dvd_link`, `dvd_gambar`, `dvd_rating`, `keterangan`, `dvd_status`, `created`, `modifed`) VALUES
(1, 1, 'D01.001', 'THE SIMS 2 3IN1', '', 1, '2011-04-27', '', '', '', '019f057445.jpg', 10, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'D01.002', 'THE SIMS 2 BON VOYAGE', '', 1, '0000-00-00', '', '', '', '4f184edab8.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 'D01.003', 'THE SIMS 2 DELUXE', '', 1, '0000-00-00', '', '', '', 'ee069fd973.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 1, 'D01.004', 'THE SIMS 2 GOLD', '', 1, '0000-00-00', '', '', '', '7954eb82d4.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 1, 'D01.005', 'THE SIMS 2 SEASONS', '', 1, '0000-00-00', '', '', '', '7ed1dc8082.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 1, 'D01.006', 'THE SIMS 2 TEEN STYLE STUFF', '', 1, '0000-00-00', '', '', '', 'c3ce234a2a.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 1, 'D01.007', 'THE SIMS 3', '', 2, '0000-00-00', '', '', '', 'cd66620011.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 1, 'D01.008', 'THE SIMS 3 AMBITIONS', '', 1, '0000-00-00', '', '', '', '389075b4f3.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 1, 'D01.009', 'THE SIMS 3 CREATE A SIM', '', 1, '0000-00-00', '', '', '', 'b9dc900eee.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 1, 'D01.010', 'THE SIMS 3 FAST LANE', '', 1, '0000-00-00', '', '', '', 'e2ced68605.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 1, 'D01.011', 'THESIMS 3 HIGH-AND LOFT STUFF', '', 1, '0000-00-00', '', '', '', 'b17a41ff47.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 1, 'D01.012', 'THE SIMS 3 LATE NIGHT', '', 2, '0000-00-00', '', '', '', '8580d5a4c3.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 1, 'D01.013', 'THE SIMS 3 WORLD ADVENTURE', '', 1, '0000-00-00', '', '', '', '6a4e9beeaa.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 1, 'D01.014', 'THE SIMS CASTAWAY STORIES', '', 1, '0000-00-00', '', '', '', '412263f272.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 1, 'D01.015', 'THE SIMS MASTER COLLECTION', '', 2, '0000-00-00', '', '', '', '68b5ea6499.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 1, 'D01.016', 'THE SIMS MEDIEVAL', '', 2, '0000-00-00', '', '', '', 'd5480c9638.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 1, 'D01.017', '10 WHEELS OF STEEL BIG CITY RIG', '', 1, '0000-00-00', '', '', '', 'ab46ea69f6.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 1, 'D01.018', 'CITIES XL 2011', '', 1, '0000-00-00', '', '', '', '8eac87c68a.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 1, 'D01.019', 'SIMCITY SOCIATIES DELUXE EDITION', '', 1, '0000-00-00', '', '', '', 'e10633b2ad.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 1, 'D01.020', 'SIMCITY SOCIETIES', '', 1, '0000-00-00', '', '', '', '7ad4e7a0ce.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 1, 'D01.021', 'GUITAH HERO LEGENDS OF ROCK', '', 2, '0000-00-00', '', '', '', 'c17ee4d232.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 1, 'D01.022', 'GUITAR HERO AEROSMITE', '', 1, '0000-00-00', '', '', '', '6815b19682.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 1, 'D01.023', 'GUITAR HERO WORLD TOUR', '', 1, '0000-00-00', '', '', '', 'bd1bc6c0d8.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 1, 'D01.024', 'RIG N'' ROLL', '', 1, '0000-00-00', '', '', '', '60b4e890c5.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 2, 'D02.001', 'ALIEN BREED 3', '', 1, '0000-00-00', '', '', '', '6755a6aaa4.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 2, 'D02.002', 'ALPHA PROTOKOL', '', 3, '0000-00-00', '', '', '', '18fefe0e14.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 2, 'D02.003', 'ARMA 2 OPERATION ARROWEAD', '', 2, '0000-00-00', '', '', '', '6898423d88.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 2, 'D02.004', 'BATTLEFIELD 2', '', 1, '0000-00-00', '', '', '', '69c63c1171.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 2, 'D02.005', 'BATTLEFIELD BAD COMPANY 2', '', 1, '0000-00-00', '', '', '', 'b4823920e0.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 2, 'D02.006', 'BATTLEFIELD 2142', '', 1, '0000-00-00', '', '', '', '1c977c0fa5.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 2, 'D02.007', 'BORDERLANDS', '', 2, '0000-00-00', '', '', '', '05264b7ffb.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 2, 'D02.008', 'BORDERLANDS NEW ROBOT REVOLUTION', '', 1, '0000-00-00', '', '', '', '2e93b0f0fe.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 2, 'D02.009', 'BORDELANDS GENERAL KNOXX', '', 1, '0000-00-00', '', '', '', '333c6fe150.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 2, 'D02.010', 'BORDERLANDS THE ZOMBIE ISLAND OF DR.NED', '', 1, '0000-00-00', '', '', '', '1cd5cfb137.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 2, 'D02.011', 'CALL OF DUTY 2', '', 1, '0000-00-00', '', '', '', 'e02c15d57b.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 2, 'D02.012', 'CALL OF DUTY BALCK OPS', '', 2, '0000-00-00', '', '', '', 'f75cd58b88.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 2, 'D02.013', 'CALL OF DUTY MODERN WARVARE', '', 2, '0000-00-00', '', '', '', 'd842d2c96d.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 2, 'D02.014', 'CALL OF DUTY MODERN WARFARE 2', '', 3, '0000-00-00', '', '', '', '5be7ec7eaf.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 2, 'D02.015', 'CALL OF DUTY WORLD AT WAR', '', 2, '0000-00-00', '', '', '', 'e0ace3f280.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 2, 'D02.016', 'COUNTER STRIKE SOURCE 2010', '', 1, '0000-00-00', '', '', '', 'd76420be40.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 2, 'D02.017', 'COUNTER STRIKE SOURCE UPDATE 18.3', '', 1, '0000-00-00', '', '', '', '67d977436d.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 2, 'D02.018', 'CRYOSTASIS', '', 1, '0000-00-00', '', '', '', '5622495526.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 2, 'D02.019', 'CRYSIS', '', 2, '0000-00-00', '', '', '', '84297451da.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 2, 'D02.020', 'CRYSIS 2', '', 2, '0000-00-00', '', '', '', 'e40c3aaa36.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 2, 'D02.021', 'CRYSIS WARHEAD', '', 2, '0000-00-00', '', '', '', 'd84f7aedd7.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 2, 'D02.022', 'DARKVOIO', '', 2, '0000-00-00', '', '', '', '47ce8ee95b.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 2, 'D02.023', 'DEAD SPACE 2', '', 3, '0000-00-00', '', '', '', '3238a981b5.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 2, 'D02.024', 'DEAD SPACE', '', 2, '0000-00-00', '', '', '', '183449c966.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 2, 'D02.025', 'DELTA FORCE XTREME 2', '', 1, '0000-00-00', '', '', '', '07232bc191.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 2, 'D02.026', 'FALLOUT 3', '', 2, '0000-00-00', '', '', '', '317cfcf33b.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 2, 'D02.027', 'FALLOUT 3 BROKEN STEEL', '', 1, '0000-00-00', '', '', '', '8ff9054f5b.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 2, 'D02.028', 'FALLOUT 3 THE PITT', '', 1, '0000-00-00', '', '', '', '28e64f17ab.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 2, 'D02.029', 'FALLOUT NEW VEGAS', '', 2, '0000-00-00', '', '', '', '7c4a35c1ed.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 2, 'D02.030', 'FARCRY 2', '', 1, '0000-00-00', '', '', '', 'fc1d175c26.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 2, 'D02.031', 'FEAR', '', 1, '0000-00-00', '', '', '', '271a492c9d.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 2, 'D02.032', 'FEAR 2 PROJECT ORIGIN', '', 3, '0000-00-00', '', '', '', 'bd284e2c5d.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 2, 'D02.033', 'FEAR PERSEUS MANDATE', '', 1, '0000-00-00', '', '', '', 'b4b2bffaaa.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 2, 'D02.034', 'GHOST RECON', '', 1, '0000-00-00', '', '', '', '262bb90e1b.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 2, 'D02.035', 'GHOST RECON 2', '', 1, '0000-00-00', '', '', '', '00cbde2717.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 2, 'D02.036', 'HOME FRONT', '', 1, '0000-00-00', '', '', '', 'b545e18c93.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 2, 'D02.037', 'LEFT 4 DEAD', '', 1, '0000-00-00', '', '', '', 'fef48ec7fb.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 2, 'D02.038', 'LEFT 4 DEAD 2', '', 1, '0000-00-00', '', '', '', 'f1f82c3134.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 2, 'D02.039', 'OPERATION FLASH POINT', '', 1, '0000-00-00', '', '', '', 'd89eb4d372.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 2, 'D02.040', 'MASS EFFECT', '', 2, '0000-00-00', '', '', '', 'f6638e4f21.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 2, 'D02.041', 'MASS EFFECT 2 LAIR OF THE SHADOW BROKEN', '', 1, '0000-00-00', '', '', '', 'eaba6f3230.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 2, 'D02.042', 'MASS EFFECT 2', '', 3, '0000-00-00', '', '', '', '5a45239592.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 2, 'D02.043', 'MEDAL OF HONOR', '', 2, '0000-00-00', '', '', '', '99542ccedd.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 2, 'D02.044', 'MEDAL OF HONOR AIRBORNE', '', 2, '0000-00-00', '', '', '', 'db657bd3e4.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 2, 'D02.045', 'MEDAL OF HONOR PACIFIC ASSAULT', '', 1, '0000-00-00', '', '', '', 'a68c849a4d.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 2, 'D02.046', 'RESIDENT EVIL 5', '', 2, '0000-00-00', '', '', '', '01c960f5c2.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 2, 'D02.047', 'RESIDENT EVIL 4', '', 1, '0000-00-00', '', '', '', '0d8a8b0063.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 2, 'D02.048', 'SCARFACE', '', 1, '0000-00-00', '', '', '', '588f7cf78a.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 2, 'D02.049', 'SINGULARITY', '', 2, '0000-00-00', '', '', '', 'eda4c434d6.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, 2, 'D02.050', 'SNIPER ELITE', '', 1, '0000-00-00', '', '', '', '2154a60ce6.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(75, 2, 'D02.051', 'SNIPER GHOST WARRIOR', '', 1, '0000-00-00', '', '', '', '8d93dff2e5.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, 2, 'D02.052', 'SOLDIER OF FORTUNE PAYBACK', '', 1, '0000-00-00', '', '', '', 'a9dbdabb76.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(77, 2, 'D02.053', 'SPLINTER CELL CHAOS THEORY', '', 1, '0000-00-00', '', '', '', 'd5b8fc281d.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(78, 2, 'D02.054', 'SPLINTER CELL CONVICTION', '', 2, '0000-00-00', '', '', '', '0ce9c809a0.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(79, 2, 'D02.055', 'STALKER', '', 1, '0000-00-00', '', '', '', 'c904bf94d8.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(80, 2, 'D02.056', 'BATTLE FOT THE PASIFIC', '', 1, '0000-00-00', '', '', '', '235d39fe79.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(81, 2, 'D02.057', 'BULLET STRORM', '', 2, '0000-00-00', '', '', '', 'e16416bc26.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(82, 2, 'D02.058', 'LOST PLANET 2', '', 3, '0000-00-00', '', '', '', '72748e8a5a.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(83, 2, 'D02.059', 'PAINKILLER REDAMTION', '', 1, '0000-00-00', '', '', '', '6047f27df9.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(84, 2, 'D02.060', 'RAINBOW SIX VEGAS 2', '', 2, '0000-00-00', '', '', '', '0d2851b853.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(85, 2, 'D02.061', 'SHADOW HARVEST PHANTOM OPS', '', 1, '0000-00-00', '', '', '', '0649d53958.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(86, 2, 'D02.062', 'SPLINTER CELL DOUBLE AGENT', '', 2, '0000-00-00', '', '', '', 'a713cc915f.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(87, 2, 'D02.063', 'TERMINATOR SALVATION', '', 2, '0000-00-00', '', '', '', '7a87cc8568.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(88, 2, 'D02.064', 'TERRORIST TAKEDOWN 3', '', 1, '0000-00-00', '', '', '', '3ee8076bdf.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, 2, 'D02.065', 'VIETCONG 2', '', 1, '0000-00-00', '', '', '', 'f38e98c6a0.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(90, 2, 'D02.066', 'WOLF ENSTEIN', '', 2, '0000-00-00', '', '', '', '335eaecdcd.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(91, 2, 'D02.067', 'XENUS II', '', 1, '0000-00-00', '', '', '', '0401db8721.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, 2, 'D02.068', 'XENUS II WHITE GOLD', '', 1, '0000-00-00', '', '', '', '057dd4d684.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, 3, 'D03.001', 'ARCANIA GHOTIC 4', '', 2, '0000-00-00', '', '', '', 'e41fd0150b.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(94, 3, 'D03.002', 'BLADES', '', 1, '0000-00-00', '', '', '', '90127d28fa.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(95, 3, 'D03.003', 'BLOOD BOWL', '', 1, '0000-00-00', '', '', '', '4102bdc45a.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(96, 3, 'D03.004', 'DARK SIDERS', '', 3, '0000-00-00', '', '', '', '51ca52bbfe.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(97, 3, 'D03.005', 'DARKNESS WITHIN 2', '', 1, '0000-00-00', '', '', '', '37d236dd3d.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(98, 3, 'D03.006', 'DEATHSPANK', '', 1, '0000-00-00', '', '', '', '957de3eb69.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(99, 3, 'D03.007', 'DISCIPLES 3', '', 2, '0000-00-00', '', '', '', '6f397bdb98.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(100, 3, 'D03.008', 'DIVINITY II', '', 2, '0000-00-00', '', '', '', 'a25ec35958.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(101, 3, 'D03.009', 'DEVIL MAYCRY', '', 1, '0000-00-00', '', '', '', 'e0d3d98604.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(102, 3, 'D03.010', 'DEVIL MAYCRY 4', '', 2, '0000-00-00', '', '', '', '9ba31067a9.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(103, 3, 'D03.011', 'DAWN OF MAGIC 2', '', 1, '0000-00-00', '', '', '', '04a154c494.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(104, 3, 'D03.012', 'DOWN OF WAR CHAOS RISING', '', 1, '0000-00-00', '', '', '', '0e3517e151.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 3, 'D03.013', 'DRAGON AGE 2', '', 2, '0000-00-00', '', '', '', '23a26d4406.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 3, 'D03.014', 'DRAGON AGE AWAKENING', '', 1, '0000-00-00', '', '', '', 'd0ecb8459a.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(107, 3, 'D03.015', 'DRAGON AGE WITCH HUNT', '', 1, '0000-00-00', '', '', '', '3391ecefbb.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(108, 3, 'D03.016', 'DRAGON AGE THE GOLMS OF AMGARRAK', '', 1, '0000-00-00', '', '', '', 'af3ff36b2f.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(109, 3, 'D03.017', 'DRAGON AGE ORIGINS', '', 2, '0000-00-00', '', '', '', '1112eac5cd.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(110, 3, 'D03.018', 'DYNASTY WARRIOR 6', '', 1, '0000-00-00', '', '', '', '5700cb8374.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(111, 3, 'D03.019', 'DYNASTY WARRIOR 4', '', 1, '0000-00-00', '', '', '', '7ba3ae1866.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(112, 3, 'D03.020', 'ELEMENTAL WAR OF MAGIC', '', 1, '0000-00-00', '', '', '', 'ae80c69f6a.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(113, 3, 'D03.021', 'FINAL FANTASY XII', '', 1, '0000-00-00', '', '', '', 'ba8402987f.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(114, 3, 'D03.022', 'G-FORCE', '', 1, '0000-00-00', '', '', '', '52d2a1d978.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(115, 3, 'D03.023', 'GHOTIC 3', '', 1, '0000-00-00', '', '', '', '54bbd739f9.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(116, 3, 'D03.024', 'GRAND THEFT AUTO 4', '', 3, '0000-00-00', '', '', '', 'd87f44192f.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(117, 3, 'D03.025', 'GRAND THEFT AUTO EPISODES FROM LIBERTY CITY', '', 2, '0000-00-00', '', '', '', '05a4357ff8.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(118, 3, 'D03.026', 'GRAND THEFT AUTO SAN ANDREAS', '', 1, '0000-00-00', '', '', '', 'fd938f0e9c.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(119, 3, 'D03.027', 'WORLD OF WARCRAFT BURNING CRUSIDE', '', 1, '0000-00-00', '', '', '', '1042623ef0.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(120, 3, 'D03.028', 'KUNGFU PANDA', '', 1, '0000-00-00', '', '', '', '5fde665a35.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(121, 3, 'D03.029', 'MAJESTY 2', '', 1, '0000-00-00', '', '', '', '6f071e57da.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(122, 3, 'D03.030', 'MAJESTY 2 BATTLES OF ARDANIA', '', 1, '0000-00-00', '', '', '', '8c6e0a4872.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(123, 3, 'D03.031', 'MINI NINJAS', '', 2, '0000-00-00', '', '', '', '801337e9b9.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(124, 3, 'D03.032', 'MIRRORS EDGE', '', 2, '0000-00-00', '', '', '', '0c28fe489d.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(125, 4, 'D04.001', 'NINJA BLADE', '', 1, '0000-00-00', '', '', '', '5296d25ee8.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(126, 3, 'D03.033', 'PRINCE OF PERSIA', '', 2, '0000-00-00', '', '', '', '014a1a9e05.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(127, 3, 'D03.034', 'PRINCE OF PERSIA THE TWO THRONES', '', 1, '0000-00-00', '', '', '', '3323119162.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(128, 3, 'D03.035', 'PRINCE OF PERSIA FORGOTTEN SANDS', '', 2, '0000-00-00', '', '', '', '84e58264f7.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(129, 3, 'D03.036', 'RISEN', '', 2, '0000-00-00', '', '', '', '60fb884186.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(130, 4, 'D04.002', 'SAINT ROW 2', '', 2, '0000-00-00', '', '', '', '80b7a0e1c2.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(131, 3, 'D03.037', 'SAMURAY WARRIOR', '', 1, '0000-00-00', '', '', '', '38f034c954.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(132, 3, 'D03.038', 'SHANK', '', 1, '0000-00-00', '', '', '', '3a2010976d.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(133, 3, 'D03.039', 'SHREK', '', 1, '0000-00-00', '', '', '', 'b70eb8143a.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(134, 3, 'D03.040', 'SHERLOCK HOLMS THE JACK VS RIPPER', '', 1, '0000-00-00', '', '', '', '331b88f53b.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(135, 3, 'D03.041', 'SILENT HILL 4 THE ROOM', '', 1, '0000-00-00', '', '', '', '00068d50f5.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(136, 4, 'D04.003', 'SPIDER-MAN SHATTERED DIMENSIONS', '', 2, '0000-00-00', '', '', '', '56ae7e838e.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(137, 3, 'D03.042', 'THE ELDER SCROLLS IV KNIGHTS OF THE NINE', '', 1, '0000-00-00', '', '', '', 'cd5587d80e.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(138, 3, 'D03.043', 'THE ELDER SCROLLS SHIVERING ISLES', '', 1, '0000-00-00', '', '', '', '45fc82eabe.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(139, 3, 'D03.044', 'THE ELDER SCROLL IV OBLIVION', '', 1, '0000-00-00', '', '', '', '524e6e17dd.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(140, 3, 'D03.045', 'THE LORD OF THE RING CONQUEST', '', 2, '0000-00-00', '', '', '', 'c38e9da5cc.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 4, 'D04.004', 'AVATAR THE GAME', '', 1, '0000-00-00', '', '', '', '1dd1a3cb14.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 4, 'D04.005', 'AMNESIA THE DARK DESCENT', '', 1, '0000-00-00', '', '', '', 'cbf0925e9c.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(143, 4, 'D04.006', 'ASSASSINS CREED', '', 2, '0000-00-00', '', '', '', '335daf2283.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 4, 'D04.007', 'ASSASSIN CREED BROTERHOOD', '', 2, '0000-00-00', '', '', '', '52b2019b26.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(145, 4, 'D04.008', 'ASSASSIN CREED 2', '', 2, '0000-00-00', '', '', '', '7eda2215e6.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(146, 4, 'D04.009', 'BATMAN ARKHAM ASYLUM', '', 2, '0000-00-00', '', '', '', 'da9c0726d2.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(147, 4, 'D04.010', 'BIONIC', '', 2, '0000-00-00', '', '', '', '429c2725b4.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(148, 3, 'D03.046', 'BLACK MIRROR II', '', 1, '0000-00-00', '', '', '', '1bb969c7e8.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(149, 4, 'D04.011', 'BLOOD STOONE 007', '', 2, '0000-00-00', '', '', '', '8c2146779d.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(150, 3, 'D03.047', 'BULLY', '', 1, '0000-00-00', '', '', '', '8d6951bf22.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(151, 3, 'D03.048', 'DEAD RISING', '', 2, '0000-00-00', '', '', '', 'e94d145a8f.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(152, 5, 'D05.001', 'NEED FOR SPEED CARBON', '', 1, '0000-00-00', '', '', '', '0f3c65fbda.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(153, 5, 'D05.002', 'NEED FOR SPEED HOT PURSUIT', '', 2, '0000-00-00', '', '', '', 'e20cdaaa42.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(154, 5, 'D05.003', 'NEED FOR SPEED MOSTWANTED', '', 1, '0000-00-00', '', '', '', 'edeab074c5.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(155, 5, 'D05.004', 'NEED FOR SPEED PROSTREET', '', 2, '0000-00-00', '', '', '', '1bdc641a04.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(156, 5, 'D05.005', 'NEED FOR SPEED SHIFT', '', 2, '0000-00-00', '', '', '', '6ed7ba76e4.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(157, 5, 'D05.006', 'NEED FOR SPEED SHIFT 2 UNLEASHED', '', 2, '0000-00-00', '', '', '', '3cde6640bb.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(158, 5, 'D05.007', 'NEED FOR SPEED UNDER COVER', '', 1, '0000-00-00', '', '', '', '342f3399fd.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(159, 5, 'D05.008', 'BLUR', '', 2, '0000-00-00', '', '', '', '45786580cd.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(160, 5, 'D05.009', 'BURNOUT PARADISE THE ULTIMATE', '', 1, '0000-00-00', '', '', '', '9ec82ab58b.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(161, 5, 'D05.010', 'SPLIT/SECOND', '', 2, '0000-00-00', '', '', '', 'a30efe2522.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(162, 5, 'D05.011', 'TEST DRIVE UNLIMITED', '', 2, '0000-00-00', '', '', '', '165a5922ea.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(163, 6, 'D06.001', 'PRO EVOLUTION SOCCER 2011', '', 2, '0000-00-00', '', '', '', '1693051739.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(164, 6, 'D06.002', 'PRO EVOLUTION SOCCER 2010', '', 2, '0000-00-00', '', '', '', 'f25e89c69a.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(165, 6, 'D06.003', 'PRO EVOLUTION SOCCER 2009', '', 2, '0000-00-00', '', '', '', 'd42fd7e84e.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(166, 6, 'D06.004', 'PRO EVOLUTION SOCCER 2008', '', 1, '0000-00-00', '', '', '', '7319486b04.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(167, 6, 'D06.005', 'PRO EVOLUTION SOCCER 6', '', 1, '0000-00-00', '', '', '', '219097d178.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(168, 6, 'D06.006', 'FOOTBALL MANAGER 2011', '', 1, '0000-00-00', '', '', '', 'd995e295aa.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(169, 6, 'D06.007', 'FOOTBALL MANAGER 2010', '', 1, '0000-00-00', '', '', '', '81c85d3234.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(170, 6, 'D06.008', 'FIFA MANAGER 2011', '', 1, '0000-00-00', '', '', '', '4ce1cf4833.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(171, 6, 'D06.009', 'FIFA 2011', '', 2, '0000-00-00', '', '', '', 'c7813343ec.jpg', 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `master_kategori`
--

CREATE TABLE IF NOT EXISTS `master_kategori` (
  `kat_id` int(6) NOT NULL AUTO_INCREMENT,
  `kat_nama` varchar(50) NOT NULL,
  `kat_gambar` varchar(100) NOT NULL,
  PRIMARY KEY (`kat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `master_kategori`
--

INSERT INTO `master_kategori` (`kat_id`, `kat_nama`, `kat_gambar`) VALUES
(1, 'SIMULASI', ''),
(2, 'SHOOTER', ''),
(3, 'ADVENTURE', ''),
(4, 'ACTION', ''),
(5, 'RACING', ''),
(6, 'SPORT', ''),
(9, 'BOARD', '');

-- --------------------------------------------------------

--
-- Table structure for table `master_sync_jne`
--

CREATE TABLE IF NOT EXISTS `master_sync_jne` (
  `sync_id` int(6) NOT NULL AUTO_INCREMENT,
  `sync_code` varchar(20) NOT NULL,
  `sync_name` varchar(100) NOT NULL,
  `sync_ss` int(6) NOT NULL DEFAULT '0',
  `sync_reg` int(6) NOT NULL DEFAULT '0',
  `sync_yes` int(6) NOT NULL DEFAULT '0',
  `sync_oke` int(6) NOT NULL DEFAULT '0',
  `modifed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sync_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `master_sync_jne`
--

INSERT INTO `master_sync_jne` (`sync_id`, `sync_code`, `sync_name`, `sync_ss`, `sync_reg`, `sync_yes`, `sync_oke`, `modifed`) VALUES
(1, 'UEdLMTAzMDFK', 'MENTOK,KELAPA', 0, 0, 0, 27000, '2011-11-24 08:04:04'),
(2, 'Qk9PMTAwMDBK', 'BOGOR', 0, 0, 14000, 6000, '2011-11-24 08:04:45'),
(3, 'QkRPMjA3MDBK', 'GARUT', 0, 8000, 10000, 6000, '2011-11-24 08:05:07'),
(4, 'QkRPMjA1MDBK', 'CIAMIS, KAB.CIAMIS', 0, 9000, 12000, 6000, '2011-11-24 08:05:27'),
(5, 'Q0JOMjAzMDBK', 'MAJALENGKA, KAB MAJALENGKA', 0, 0, 0, 14000, '2011-11-24 08:06:17'),
(6, 'Qk9PMjAxMzBK', 'CITEUREUP, CIBINONG', 0, 0, 0, 9500, '2011-11-24 08:06:45'),
(7, 'Q0dLMTAwMDBK', 'JAKARTA', 0, 0, 12000, 6000, '2011-11-24 08:07:04'),
(8, 'UExXMTAwMDBK', 'PALU', 0, 0, 0, 17000, '2011-11-24 15:05:34'),
(9, 'UEtVMTAwMDBK', 'PEKANBARU', 0, 0, 24000, 15000, '2011-11-24 15:06:09'),
(10, 'UE5LMTAwMDBK', 'PONTIANAK', 0, 0, 27000, 15000, '2011-11-24 15:11:00'),
(11, 'R1RPMTAwMDBK', 'GORONTALO', 0, 0, 0, 37000, '2011-11-24 15:26:59'),
(12, 'VVBHMjAzMDhK', 'RIAU ALE,BULUKUMBA', 0, 0, 0, 40500, '2011-11-25 06:51:34'),
(13, 'UExNMTAwMDBK', 'PALEMBANG', 0, 0, 22000, 13000, '2011-11-25 11:45:01'),
(14, 'UERHMTAwMDBK', 'PADANG', 0, 0, 24000, 15000, '2011-11-25 11:45:15'),
(15, 'Q0dLMTAzMDBK', 'JAKARTA PUSAT', 0, 0, 12000, 6000, '2011-11-25 13:43:02'),
(16, 'UERHMTAwMTRK', 'PADANG BARAT, PADANG', 0, 0, 0, 15000, '2011-11-25 13:50:56'),
(17, 'REpKMTAwMDBK', 'JAYAPURA', 0, 0, 0, 35000, '2011-11-29 08:51:51'),
(18, 'Qk9PMTAwMzBK', 'BOGOR UTARA, BOGOR', 0, 0, 0, 6000, '2011-11-29 16:02:01'),
(19, 'QkRPMjAyMDBK', 'SUMEDANG', 0, 9000, 10500, 6000, '2011-11-29 16:22:16'),
(20, 'QkRPMjAyNTJK', 'SUMEDANG SELATAN,SUMEDANG', 0, 17000, 10500, 8000, '2011-11-29 19:03:53'),
(21, 'QktTMTAwMDBK', 'BENGKULU', 0, 0, 25000, 15000, '2011-11-30 07:35:43'),
(22, 'U01JMjAxMDVK', 'CIBINONG,CIANJUR', 0, 0, 0, 8000, '2011-11-30 13:53:52'),
(23, 'QkRPMjAxMDBK', 'CIMAHI', 0, 4000, 7000, 3000, '2011-11-30 13:56:07'),
(24, 'VEdSMTAwMDBK', 'TANGERANG', 0, 0, 14000, 6000, '2011-12-01 16:25:16'),
(25, 'Qk9PMTAwMjhK', 'BOGOR TENGAH, BOGOR', 0, 0, 0, 6000, '2011-12-02 18:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `sessions_admin`
--

CREATE TABLE IF NOT EXISTS `sessions_admin` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessions_shop`
--

CREATE TABLE IF NOT EXISTS `sessions_shop` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sys_counter`
--

CREATE TABLE IF NOT EXISTS `sys_counter` (
  `tahun` varchar(4) NOT NULL DEFAULT '2011',
  `bulan` varchar(2) NOT NULL DEFAULT '11',
  `inv_no` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sys_user`
--

CREATE TABLE IF NOT EXISTS `sys_user` (
  `usr_id` int(4) NOT NULL AUTO_INCREMENT,
  `usr_login` varchar(20) NOT NULL DEFAULT '',
  `usr_pwd1` varchar(50) DEFAULT NULL,
  `usr_pwd2` varchar(50) NOT NULL DEFAULT '',
  `usr_nama` varchar(100) DEFAULT NULL,
  `usr_image` varchar(100) DEFAULT NULL,
  `ucat_id` int(11) NOT NULL DEFAULT '2',
  `lastTime_log` datetime DEFAULT NULL,
  `lastIP_log` varchar(50) DEFAULT NULL,
  `newTime_log` datetime DEFAULT NULL,
  `newIP_log` varchar(50) DEFAULT NULL,
  `offTime_log` datetime DEFAULT NULL,
  `offIP_log` varchar(50) DEFAULT NULL,
  `login_status` int(11) NOT NULL DEFAULT '1',
  `logon_status` int(1) NOT NULL DEFAULT '0',
  `logon_session` text NOT NULL,
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_login` (`usr_login`),
  KEY `usr_name` (`usr_nama`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=0 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sys_user`
--

INSERT INTO `sys_user` (`usr_id`, `usr_login`, `usr_pwd1`, `usr_pwd2`, `usr_nama`, `usr_image`, `ucat_id`, `lastTime_log`, `lastIP_log`, `newTime_log`, `newIP_log`, `offTime_log`, `offIP_log`, `login_status`, `logon_status`, `logon_session`) VALUES
(1, 'admin', 'cb3bae31bb1c443fbf3db8889055f2fe', 'a78fcd9fb593b0654192c8ffcba9a254', NULL, NULL, 2, '2011-04-28 10:31:04', '::1', '2011-12-02 21:28:12', '::1', NULL, NULL, 1, 1, 'ntchgnv5ppc82ntg5rnh11qjj3');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(6) NOT NULL AUTO_INCREMENT,
  `user_nama` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_alamat` text NOT NULL,
  `user_pobox` varchar(10) NOT NULL,
  `user_telp` varchar(15) NOT NULL,
  `user_fuid` int(11) NOT NULL,
  `user_fb_site` varchar(50) NOT NULL,
  `modifed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_nama`, `user_email`, `user_alamat`, `user_pobox`, `user_telp`, `user_fuid`, `user_fb_site`, `modifed`) VALUES
(1, 'Achri Kurniadi', 'achri@localhost', 'Bupas c2 no2', '1231231231', '12312312', 0, '', '2011-11-25 04:09:03');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
