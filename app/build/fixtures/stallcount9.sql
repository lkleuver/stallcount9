-- phpMyAdmin SQL Dump
-- version 3.3.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 13, 2011 at 10:42 PM
-- Server version: 5.5.11
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stallcount9`
--

-- --------------------------------------------------------

--
-- Table structure for table `brackets`
--

CREATE TABLE IF NOT EXISTS `brackets` (
  `nrteams` int(11) NOT NULL DEFAULT '0',
  `nrrounds` int(11) NOT NULL DEFAULT '0',
  `round` int(11) NOT NULL DEFAULT '0',
  `matchnr` int(11) NOT NULL DEFAULT '0',
  `home` int(11) DEFAULT NULL,
  `away` int(11) DEFAULT NULL,
  `winplace` int(11) DEFAULT NULL,
  `loseplace` int(11) DEFAULT NULL,
  PRIMARY KEY (`nrteams`,`nrrounds`,`round`,`matchnr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brackets`
--

INSERT INTO `brackets` (`nrteams`, `nrrounds`, `round`, `matchnr`, `home`, `away`, `winplace`, `loseplace`) VALUES
(5, 3, 1, 1, 1, 5, NULL, NULL),
(5, 3, 1, 2, 4, 2, NULL, NULL),
(5, 3, 1, 3, 3, NULL, NULL, NULL),
(5, 3, 2, 1, 1, 3, NULL, NULL),
(5, 3, 2, 2, 2, 5, NULL, NULL),
(5, 3, 2, 3, 4, NULL, NULL, NULL),
(5, 3, 3, 1, 1, 2, 1, 2),
(5, 3, 3, 2, 4, 3, 3, 4),
(5, 3, 3, 3, 5, NULL, 5, NULL),
(8, 3, 1, 1, 1, 8, NULL, NULL),
(8, 3, 1, 2, 5, 4, NULL, NULL),
(8, 3, 1, 3, 6, 3, NULL, NULL),
(8, 3, 1, 4, 7, 2, NULL, NULL),
(8, 3, 2, 1, 1, 4, NULL, NULL),
(8, 3, 2, 2, 3, 2, NULL, NULL),
(8, 3, 2, 3, 8, 5, NULL, NULL),
(8, 3, 2, 4, 6, 7, NULL, NULL),
(8, 3, 3, 1, 1, 2, 1, 2),
(8, 3, 3, 2, 3, 4, 3, 4),
(8, 3, 3, 3, 5, 6, 5, 6),
(8, 3, 3, 4, 7, 8, 7, 8),
(9, 3, 1, 1, 1, 8, NULL, NULL),
(9, 3, 1, 2, 5, 4, NULL, NULL),
(9, 3, 1, 3, 6, 3, NULL, NULL),
(9, 3, 1, 4, 7, 2, NULL, NULL),
(9, 3, 1, 5, 9, NULL, NULL, NULL),
(9, 3, 2, 1, 1, 4, NULL, NULL),
(9, 3, 2, 2, 3, 2, NULL, NULL),
(9, 3, 2, 3, 9, 6, NULL, NULL),
(9, 3, 2, 4, 8, 7, NULL, NULL),
(9, 3, 2, 5, 5, NULL, NULL, NULL),
(9, 3, 3, 1, 1, 2, 1, 2),
(9, 3, 3, 2, 3, 4, 3, 4),
(9, 3, 3, 3, 5, 7, 5, 6),
(9, 3, 3, 4, 8, 9, 7, 9),
(9, 3, 3, 5, 6, NULL, 8, NULL),
(10, 3, 1, 1, 1, 8, NULL, NULL),
(10, 3, 1, 2, 6, 3, NULL, NULL),
(10, 3, 1, 3, 4, 5, NULL, NULL),
(10, 3, 1, 4, 7, 2, NULL, NULL),
(10, 3, 1, 5, 9, 10, NULL, NULL),
(10, 3, 2, 1, 1, 3, NULL, NULL),
(10, 3, 2, 2, 4, 2, NULL, NULL),
(10, 3, 2, 3, 6, 8, NULL, NULL),
(10, 3, 2, 4, 5, 10, NULL, NULL),
(10, 3, 2, 5, 7, 9, NULL, NULL),
(10, 3, 3, 1, 1, 2, 1, 2),
(10, 3, 3, 2, 3, 4, 3, 4),
(10, 3, 3, 3, 6, 5, 5, 6),
(10, 3, 3, 4, 7, 8, 7, 8),
(10, 3, 3, 5, 9, 10, 9, 10);

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE IF NOT EXISTS `division` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tournament_id_idx` (`tournament_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`id`, `title`, `tournament_id`) VALUES
(1, 'open', 1),
(2, 'mixed', 1),
(3, 'women', 1);

-- --------------------------------------------------------

--
-- Table structure for table `field`
--

CREATE TABLE IF NOT EXISTS `field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tournament_id_idx` (`tournament_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `field`
--

INSERT INTO `field` (`id`, `title`, `tournament_id`, `comments`, `rank`) VALUES
(1, 'Field 1', 1, '', 1),
(2, 'Field 2', 1, '', 2),
(3, 'Field 3', 1, '', 3),
(4, 'Field 4', 1, '', 4),
(5, 'Field 5', 1, '', 5),
(6, 'Field 6', 1, '', 6),
(7, 'Field 7', 1, '', 7),
(8, 'Field 8', 1, '', 8),
(9, 'Field 9', 1, '', 9),
(10, 'Field 10', 1, '', 10),
(11, 'Field 11', 1, '', 11),
(12, 'Field 12', 1, 'artificial grass', 12),
(13, 'Field 13', 1, 'artificial grass', 13),
(14, 'Field 14', 1, '', 14),
(15, 'Field 15', 1, '', 15),
(16, 'Field 16', 1, '', 16),
(17, 'Field 17', 1, '', 17),
(18, 'Field 18', 1, '', 18),
(19, 'Field 19', 1, '', 19),
(20, 'Field 20', 1, '', 20);

-- --------------------------------------------------------

--
-- Table structure for table `pool`
--

CREATE TABLE IF NOT EXISTS `pool` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currentround` int(11) DEFAULT '0',
  `pool_ruleset_id` int(11) DEFAULT NULL,
  `stage_id` int(11) DEFAULT NULL,
  `spots` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pool_ruleset_id_idx` (`pool_ruleset_id`),
  KEY `stage_id_idx` (`stage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `pool`
--

INSERT INTO `pool` (`id`, `title`, `currentround`, `pool_ruleset_id`, `stage_id`, `spots`, `rank`) VALUES
(1, 'Registration seeding', 0, 5, 1, 41, 1),
(2, 'Swissdraw', 0, 6, 2, 42, 1),
(3, 'Top Playoff', 0, 7, 3, 8, 1),
(4, 'Upper Playoff', 0, 7, 3, 8, 2),
(5, 'Middle Playoff', 0, 7, 3, 8, 3),
(6, 'Lower Playoff', 0, 7, 3, 8, 4),
(7, 'Playout', 0, 7, 3, 9, 5),
(8, 'Registration seeding', 0, 5, 4, 27, 1),
(9, 'Swissdraw', 0, 6, 5, 28, 1),
(10, 'Top Playoff', 0, 7, 6, 8, 1),
(11, 'Middle Playoff', 0, 7, 6, 8, 2),
(12, 'Lower Playoff', 0, 7, 6, 8, 3),
(13, 'Playout', 0, 8, 6, 3, 4),
(14, 'Registration seeding', 0, 5, 7, 13, 1),
(15, 'Swissdraw', 0, 6, 8, 14, 1),
(16, 'Playoff', 0, 7, 9, 8, 1),
(17, 'Playout', 0, 7, 9, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pool_move`
--

CREATE TABLE IF NOT EXISTS `pool_move` (
  `pool_id` int(11) NOT NULL DEFAULT '0',
  `source_pool_id` int(11) NOT NULL DEFAULT '0',
  `sourcespot` int(11) NOT NULL DEFAULT '0',
  `destinationspot` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pool_id`,`source_pool_id`,`sourcespot`,`destinationspot`),
  KEY `pool_move_source_pool_id_pool_id` (`source_pool_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pool_move`
--

INSERT INTO `pool_move` (`pool_id`, `source_pool_id`, `sourcespot`, `destinationspot`) VALUES
(2, 1, 1, 1),
(2, 1, 2, 2),
(2, 1, 3, 3),
(2, 1, 4, 4),
(2, 1, 5, 5),
(2, 1, 6, 6),
(2, 1, 7, 7),
(2, 1, 8, 8),
(2, 1, 9, 9),
(2, 1, 10, 10),
(2, 1, 11, 11),
(2, 1, 12, 12),
(2, 1, 13, 13),
(2, 1, 14, 14),
(2, 1, 15, 15),
(2, 1, 16, 16),
(2, 1, 17, 17),
(2, 1, 18, 18),
(2, 1, 19, 19),
(2, 1, 20, 20),
(2, 1, 21, 21),
(2, 1, 22, 22),
(2, 1, 23, 23),
(2, 1, 24, 24),
(2, 1, 25, 25),
(2, 1, 26, 26),
(2, 1, 27, 27),
(2, 1, 28, 28),
(2, 1, 29, 29),
(2, 1, 30, 30),
(2, 1, 31, 31),
(2, 1, 32, 32),
(2, 1, 33, 33),
(2, 1, 34, 34),
(2, 1, 35, 35),
(2, 1, 36, 36),
(2, 1, 37, 37),
(2, 1, 38, 38),
(2, 1, 39, 39),
(2, 1, 40, 40),
(2, 1, 41, 41),
(3, 2, 1, 1),
(3, 2, 2, 2),
(3, 2, 3, 3),
(3, 2, 4, 4),
(3, 2, 5, 5),
(3, 2, 6, 6),
(3, 2, 7, 7),
(3, 2, 8, 8),
(4, 2, 9, 1),
(4, 2, 10, 2),
(4, 2, 11, 3),
(4, 2, 12, 4),
(4, 2, 13, 5),
(4, 2, 14, 6),
(4, 2, 15, 7),
(4, 2, 16, 8),
(5, 2, 17, 1),
(5, 2, 18, 2),
(5, 2, 19, 3),
(5, 2, 20, 4),
(5, 2, 21, 5),
(5, 2, 22, 6),
(5, 2, 23, 7),
(5, 2, 24, 8),
(6, 2, 25, 1),
(6, 2, 26, 2),
(6, 2, 27, 3),
(6, 2, 28, 4),
(6, 2, 29, 5),
(6, 2, 30, 6),
(6, 2, 31, 7),
(6, 2, 32, 8),
(7, 2, 33, 1),
(7, 2, 34, 2),
(7, 2, 35, 3),
(7, 2, 36, 4),
(7, 2, 37, 5),
(7, 2, 38, 6),
(7, 2, 39, 7),
(7, 2, 40, 8),
(7, 2, 41, 9),
(9, 8, 1, 1),
(9, 8, 2, 2),
(9, 8, 3, 3),
(9, 8, 4, 4),
(9, 8, 5, 5),
(9, 8, 6, 6),
(9, 8, 7, 7),
(9, 8, 8, 8),
(9, 8, 9, 9),
(9, 8, 10, 10),
(9, 8, 11, 11),
(9, 8, 12, 12),
(9, 8, 13, 13),
(9, 8, 14, 14),
(9, 8, 15, 15),
(9, 8, 16, 16),
(9, 8, 17, 17),
(9, 8, 18, 18),
(9, 8, 19, 19),
(9, 8, 20, 20),
(9, 8, 21, 21),
(9, 8, 22, 22),
(9, 8, 23, 23),
(9, 8, 24, 24),
(9, 8, 25, 25),
(9, 8, 26, 26),
(9, 8, 27, 27),
(10, 9, 1, 1),
(10, 9, 2, 2),
(10, 9, 3, 3),
(10, 9, 4, 4),
(10, 9, 5, 5),
(10, 9, 6, 6),
(10, 9, 7, 7),
(10, 9, 8, 8),
(11, 9, 9, 1),
(11, 9, 10, 2),
(11, 9, 11, 3),
(11, 9, 12, 4),
(11, 9, 13, 5),
(11, 9, 14, 6),
(11, 9, 15, 7),
(11, 9, 16, 8),
(12, 9, 17, 1),
(12, 9, 18, 2),
(12, 9, 19, 3),
(12, 9, 20, 4),
(12, 9, 21, 5),
(12, 9, 22, 6),
(12, 9, 23, 7),
(12, 9, 24, 8),
(13, 9, 25, 1),
(13, 9, 26, 2),
(13, 9, 27, 3),
(15, 14, 1, 1),
(15, 14, 2, 2),
(15, 14, 3, 3),
(15, 14, 4, 4),
(15, 14, 5, 5),
(15, 14, 6, 6),
(15, 14, 7, 7),
(15, 14, 8, 8),
(15, 14, 9, 9),
(15, 14, 10, 10),
(15, 14, 11, 11),
(15, 14, 12, 12),
(15, 14, 13, 13),
(16, 15, 1, 1),
(16, 15, 2, 2),
(16, 15, 3, 3),
(16, 15, 4, 4),
(16, 15, 5, 5),
(16, 15, 6, 6),
(16, 15, 7, 7),
(16, 15, 8, 8),
(17, 15, 9, 1),
(17, 15, 10, 2),
(17, 15, 11, 3),
(17, 15, 12, 4),
(17, 15, 13, 5);

-- --------------------------------------------------------

--
-- Table structure for table `pool_ruleset`
--

CREATE TABLE IF NOT EXISTS `pool_ruleset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pool_strategy_id` int(11) DEFAULT NULL,
  `numberofrounds` int(11) DEFAULT NULL,
  `matchlength` int(11) DEFAULT NULL,
  `qualificationcutoff` int(11) DEFAULT NULL,
  `winningscore` int(11) DEFAULT NULL,
  `byescore` int(11) DEFAULT NULL,
  `byeagainst` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pool_strategy_id_idx` (`pool_strategy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pool_ruleset`
--

INSERT INTO `pool_ruleset` (`id`, `title`, `pool_strategy_id`, `numberofrounds`, `matchlength`, `qualificationcutoff`, `winningscore`, `byescore`, `byeagainst`) VALUES
(5, 'Setup', 5, 0, 0, 0, NULL, NULL, NULL),
(6, 'Swissdraw', 6, 5, 90, 0, 15, 12, 15),
(7, 'Bracket', 7, 0, 90, 0, 15, NULL, NULL),
(8, 'RoundRobin', 8, 0, 90, 0, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pool_strategy`
--

CREATE TABLE IF NOT EXISTS `pool_strategy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pool_strategy`
--

INSERT INTO `pool_strategy` (`id`, `title`, `description`) VALUES
(5, 'ManualRanking', 'manually rank pool'),
(6, 'Swissdraw', 'Swissdraw matchmaking according to victory points'),
(7, 'Bracket', 'Bracket'),
(8, 'RoundRobin', 'RoundRobin');

-- --------------------------------------------------------

--
-- Table structure for table `pool_team`
--

CREATE TABLE IF NOT EXISTS `pool_team` (
  `pool_id` int(11) NOT NULL DEFAULT '0',
  `team_id` int(11) NOT NULL DEFAULT '0',
  `rank` int(11) DEFAULT NULL,
  `seed` int(11) DEFAULT NULL,
  PRIMARY KEY (`pool_id`,`team_id`),
  KEY `pool_team_team_id_team_id` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pool_team`
--

INSERT INTO `pool_team` (`pool_id`, `team_id`, `rank`, `seed`) VALUES
(1, 1, 19, 1),
(1, 2, 27, 2),
(1, 3, 34, 3),
(1, 4, 28, 4),
(1, 5, 25, 5),
(1, 6, 21, 6),
(1, 7, 36, 7),
(1, 8, 31, 8),
(1, 9, 20, 9),
(1, 10, 32, 10),
(1, 11, 22, 11),
(1, 12, 4, 12),
(1, 13, 41, 13),
(1, 14, 33, 14),
(1, 15, 15, 15),
(1, 16, 23, 16),
(1, 17, 16, 17),
(1, 18, 6, 18),
(1, 19, 1, 19),
(1, 20, 10, 20),
(1, 21, 8, 21),
(1, 22, 40, 22),
(1, 23, 14, 23),
(1, 24, 26, 24),
(1, 25, 39, 25),
(1, 26, 5, 26),
(1, 27, 18, 27),
(1, 28, 37, 28),
(1, 29, 3, 29),
(1, 30, 24, 30),
(1, 31, 7, 31),
(1, 32, 9, 32),
(1, 33, 30, 33),
(1, 34, 38, 34),
(1, 35, 2, 35),
(1, 36, 17, 36),
(1, 37, 12, 37),
(1, 38, 35, 38),
(1, 39, 13, 39),
(1, 40, 11, 40),
(1, 41, 29, 41),
(2, 42, 1, 42),
(8, 43, 6, 1),
(8, 44, 8, 2),
(8, 45, 9, 3),
(8, 46, 7, 4),
(8, 47, 2, 5),
(8, 48, 12, 6),
(8, 49, 23, 7),
(8, 50, 18, 8),
(8, 51, 14, 9),
(8, 52, 20, 10),
(8, 53, 16, 11),
(8, 54, 3, 12),
(8, 55, 19, 13),
(8, 56, 13, 14),
(8, 57, 22, 15),
(8, 58, 11, 16),
(8, 59, 10, 17),
(8, 60, 25, 18),
(8, 61, 21, 19),
(8, 62, 1, 20),
(8, 63, 15, 21),
(8, 64, 26, 22),
(8, 65, 17, 23),
(8, 66, 4, 24),
(8, 67, 27, 25),
(8, 68, 24, 26),
(8, 69, 5, 27),
(9, 70, 28, 28),
(14, 71, 13, 1),
(14, 72, 4, 2),
(14, 73, 5, 3),
(14, 74, 6, 4),
(14, 75, 7, 5),
(14, 76, 12, 6),
(14, 77, 8, 7),
(14, 78, 1, 8),
(14, 79, 11, 9),
(14, 80, 2, 10),
(14, 81, 3, 11),
(14, 82, 10, 12),
(14, 83, 9, 13),
(15, 84, 14, 14);

-- --------------------------------------------------------

--
-- Table structure for table `round`
--

CREATE TABLE IF NOT EXISTS `round` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) DEFAULT NULL,
  `matchlength` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pool_id_idx` (`pool_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

--
-- Dumping data for table `round`
--

INSERT INTO `round` (`id`, `pool_id`, `matchlength`, `rank`) VALUES
(1, 9, 90, 1),
(2, 9, 90, 2),
(3, 9, 90, 3),
(4, 9, 90, 4),
(5, 9, 90, 5),
(6, 10, 90, 1),
(7, 10, 90, 2),
(8, 10, 90, 3),
(9, 11, 90, 1),
(10, 11, 90, 2),
(11, 11, 90, 3),
(12, 12, 90, 1),
(13, 12, 90, 2),
(14, 12, 90, 3),
(15, 13, 90, 1),
(16, 13, 90, 2),
(17, 13, 90, 3),
(18, 15, 90, 1),
(19, 15, 90, 2),
(20, 15, 90, 3),
(21, 15, 90, 4),
(22, 15, 90, 5),
(23, 16, 90, 1),
(24, 16, 90, 2),
(25, 16, 90, 3),
(26, 17, 90, 1),
(27, 17, 90, 2),
(28, 17, 90, 3),
(29, 2, 90, 1),
(30, 2, 90, 2),
(31, 2, 90, 3),
(32, 2, 90, 4),
(33, 2, 90, 5),
(34, 3, 90, 1),
(35, 3, 90, 2),
(36, 3, 90, 3),
(37, 4, 90, 1),
(38, 4, 90, 2),
(39, 4, 90, 3),
(40, 5, 90, 1),
(41, 5, 90, 2),
(42, 5, 90, 3),
(43, 6, 90, 1),
(44, 6, 90, 2),
(45, 6, 90, 3),
(46, 7, 90, 1),
(47, 7, 90, 2),
(48, 7, 90, 3);

-- --------------------------------------------------------

--
-- Table structure for table `round_match`
--

CREATE TABLE IF NOT EXISTS `round_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `round_id` int(11) DEFAULT NULL,
  `scheduledtime` bigint(20) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `matchname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `homename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `awayname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `home_team_id` int(11) DEFAULT NULL,
  `away_team_id` int(11) DEFAULT NULL,
  `homescore` int(11) DEFAULT NULL,
  `awayscore` int(11) DEFAULT NULL,
  `homespirit` int(11) DEFAULT NULL,
  `awayspirit` int(11) DEFAULT NULL,
  `scoresubmittime` bigint(20) DEFAULT NULL,
  `spiritsubmittime` bigint(20) DEFAULT NULL,
  `bestpossiblerank` int(11) DEFAULT NULL,
  `worstpossiblerank` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_id_idx` (`field_id`),
  KEY `home_team_id_idx` (`home_team_id`),
  KEY `away_team_id_idx` (`away_team_id`),
  KEY `round_id_idx` (`round_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=337 ;

--
-- Dumping data for table `round_match`
--

INSERT INTO `round_match` (`id`, `round_id`, `scheduledtime`, `field_id`, `matchname`, `homename`, `awayname`, `rank`, `home_team_id`, `away_team_id`, `homescore`, `awayscore`, `homespirit`, `awayspirit`, `scoresubmittime`, `spiritsubmittime`, `bestpossiblerank`, `worstpossiblerank`) VALUES
(1, 1, 1308297600, 1, 'Match rank 1', 'Seed 1', 'Seed 15', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 1308297600, 2, 'Match rank 2', 'Seed 2', 'Seed 16', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 1308297600, 3, 'Match rank 3', 'Seed 3', 'Seed 17', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, 1308297600, 10, 'Match rank 4', 'Seed 4', 'Seed 18', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 1308297600, 11, 'Match rank 5', 'Seed 5', 'Seed 19', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 1308297600, 12, 'Match rank 6', 'Seed 6', 'Seed 20', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 1308297600, 13, 'Match rank 7', 'Seed 7', 'Seed 21', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 1308297600, 14, 'Match rank 8', 'Seed 8', 'Seed 22', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 1, 1308297600, 15, 'Match rank 9', 'Seed 9', 'Seed 23', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 1308297600, 16, 'Match rank 10', 'Seed 10', 'Seed 24', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, 1308297600, 17, 'Match rank 11', 'Seed 11', 'Seed 25', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 1, 1308297600, 18, 'Match rank 12', 'Seed 12', 'Seed 26', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 1, 1308297600, 19, 'Match rank 13', 'Seed 13', 'Seed 27', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, 1308297600, NULL, 'BYE Match Round 1', 'Seed 14', 'BYE', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 2, 1308306600, 20, 'Match rank 1', 'Round 1 aprx rank 1', 'Round 1 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 2, 1308306600, 19, 'Match rank 2', 'Round 1 aprx rank 3', 'Round 1 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 2, 1308306600, 18, 'Match rank 3', 'Round 1 aprx rank 5', 'Round 1 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 2, 1308306600, 11, 'Match rank 4', 'Round 1 aprx rank 7', 'Round 1 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 2, 1308306600, 10, 'Match rank 5', 'Round 1 aprx rank 9', 'Round 1 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 2, 1308306600, 9, 'Match rank 6', 'Round 1 aprx rank 11', 'Round 1 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 2, 1308306600, 8, 'Match rank 7', 'Round 1 aprx rank 13', 'Round 1 aprx rank 14', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 2, 1308306600, 7, 'Match rank 8', 'Round 1 aprx rank 15', 'Round 1 aprx rank 16', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 2, 1308306600, 6, 'Match rank 9', 'Round 1 aprx rank 17', 'Round 1 aprx rank 18', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 2, 1308306600, 5, 'Match rank 10', 'Round 1 aprx rank 19', 'Round 1 aprx rank 20', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 2, 1308306600, 4, 'Match rank 11', 'Round 1 aprx rank 21', 'Round 1 aprx rank 22', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 2, 1308306600, 3, 'Match rank 12', 'Round 1 aprx rank 23', 'Round 1 aprx rank 24', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 2, 1308306600, 2, 'Match rank 13', 'Round 1 aprx rank 25', 'Round 1 aprx rank 26', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 2, 1308306600, NULL, 'BYE Match Round 1', 'Round 1 team', 'BYE', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 3, 1308317400, 5, 'Match rank 1', 'Round 2 aprx rank 1', 'Round 2 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 3, 1308317400, 4, 'Match rank 2', 'Round 2 aprx rank 3', 'Round 2 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 3, 1308317400, 3, 'Match rank 3', 'Round 2 aprx rank 5', 'Round 2 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 3, 1308317400, 2, 'Match rank 4', 'Round 2 aprx rank 7', 'Round 2 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 3, 1308317400, 1, 'Match rank 5', 'Round 2 aprx rank 9', 'Round 2 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 3, 1308317400, 20, 'Match rank 6', 'Round 2 aprx rank 11', 'Round 2 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 3, 1308317400, 19, 'Match rank 7', 'Round 2 aprx rank 13', 'Round 2 aprx rank 14', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 3, 1308317400, 18, 'Match rank 8', 'Round 2 aprx rank 15', 'Round 2 aprx rank 16', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 3, 1308317400, 17, 'Match rank 9', 'Round 2 aprx rank 17', 'Round 2 aprx rank 18', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 3, 1308317400, 9, 'Match rank 10', 'Round 2 aprx rank 19', 'Round 2 aprx rank 20', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 3, 1308317400, 6, 'Match rank 11', 'Round 2 aprx rank 21', 'Round 2 aprx rank 22', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 3, 1308317400, 7, 'Match rank 12', 'Round 2 aprx rank 23', 'Round 2 aprx rank 24', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 3, 1308317400, 8, 'Match rank 13', 'Round 2 aprx rank 25', 'Round 2 aprx rank 26', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 3, 1308317400, NULL, 'BYE Match Round 2', 'Round 2 team', 'BYE', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 4, 1308385800, 7, 'Match rank 1', 'Round 3 aprx rank 1', 'Round 3 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 4, 1308385800, 8, 'Match rank 2', 'Round 3 aprx rank 3', 'Round 3 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 4, 1308385800, 9, 'Match rank 3', 'Round 3 aprx rank 5', 'Round 3 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 4, 1308385800, 10, 'Match rank 4', 'Round 3 aprx rank 7', 'Round 3 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 4, 1308385800, 11, 'Match rank 5', 'Round 3 aprx rank 9', 'Round 3 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 4, 1308385800, 12, 'Match rank 6', 'Round 3 aprx rank 11', 'Round 3 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 4, 1308385800, 13, 'Match rank 7', 'Round 3 aprx rank 13', 'Round 3 aprx rank 14', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 4, 1308385800, 14, 'Match rank 8', 'Round 3 aprx rank 15', 'Round 3 aprx rank 16', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 4, 1308385800, 15, 'Match rank 9', 'Round 3 aprx rank 17', 'Round 3 aprx rank 18', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 4, 1308385800, 16, 'Match rank 10', 'Round 3 aprx rank 19', 'Round 3 aprx rank 20', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 4, 1308385800, 17, 'Match rank 11', 'Round 3 aprx rank 21', 'Round 3 aprx rank 22', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 4, 1308385800, 18, 'Match rank 12', 'Round 3 aprx rank 23', 'Round 3 aprx rank 24', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 4, 1308385800, 19, 'Match rank 13', 'Round 3 aprx rank 25', 'Round 3 aprx rank 26', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 4, 1308385800, NULL, 'BYE Match Round 3', 'Round 3 team', 'BYE', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 5, 1308396600, 10, 'Match rank 1', 'Round 4 aprx rank 1', 'Round 4 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 5, 1308396600, 11, 'Match rank 2', 'Round 4 aprx rank 3', 'Round 4 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 5, 1308396600, 12, 'Match rank 3', 'Round 4 aprx rank 5', 'Round 4 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 5, 1308396600, 7, 'Match rank 4', 'Round 4 aprx rank 7', 'Round 4 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 5, 1308396600, 8, 'Match rank 5', 'Round 4 aprx rank 9', 'Round 4 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 5, 1308396600, 9, 'Match rank 6', 'Round 4 aprx rank 11', 'Round 4 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 5, 1308396600, 5, 'Match rank 7', 'Round 4 aprx rank 13', 'Round 4 aprx rank 14', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 5, 1308396600, 6, 'Match rank 8', 'Round 4 aprx rank 15', 'Round 4 aprx rank 16', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 5, 1308396600, 1, 'Match rank 9', 'Round 4 aprx rank 17', 'Round 4 aprx rank 18', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 5, 1308396600, 2, 'Match rank 10', 'Round 4 aprx rank 19', 'Round 4 aprx rank 20', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 5, 1308396600, 3, 'Match rank 11', 'Round 4 aprx rank 21', 'Round 4 aprx rank 22', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 5, 1308396600, 20, 'Match rank 12', 'Round 4 aprx rank 23', 'Round 4 aprx rank 24', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 5, 1308396600, 4, 'Match rank 13', 'Round 4 aprx rank 25', 'Round 4 aprx rank 26', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 5, 1308396600, NULL, 'BYE Match Round 4', 'Round 4 team', 'BYE', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 6, 1308407400, 1, 'Quarterfinals 1', 'Team 1', 'Team 8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(72, 6, 1308407400, 2, 'Quarterfinals 2', 'Team 5', 'Team 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(73, 6, 1308407400, 3, 'Quarterfinals 3', 'Team 6', 'Team 3', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(74, 6, 1308407400, 4, 'Quarterfinals 4', 'Team 7', 'Team 2', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(75, 7, 1308466800, 20, 'Semifinals 1', 'Winner Quarterfinals 1', 'Winner Quarterfinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 4),
(76, 7, 1308466800, 18, 'Semifinals 2', 'Winner Quarterfinals 3', 'Winner Quarterfinals 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 4),
(77, 7, 1308466800, 16, 'Semifinals 3', 'Loser Quarterfinals 1', 'Loser Quarterfinals 2', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 8),
(78, 7, 1308466800, 14, 'Semifinals 4', 'Loser Quarterfinals 3', 'Loser Quarterfinals 4', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 8),
(79, 8, 1308484800, 8, 'Finals 1', 'Winner Semifinals 1', 'Winner Semifinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2),
(80, 8, 1308477600, 2, 'Finals 2', 'Loser Semifinals 2', 'Loser Semifinals 1', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 4),
(81, 8, 1308477600, 4, 'Finals 3', 'Winner Semifinals 3', 'Winner Semifinals 4', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 6),
(82, 8, 1308477600, 5, 'Finals 4', 'Loser Semifinals 4', 'Loser Semifinals 3', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 8),
(83, 9, 1308407400, 5, 'Quarterfinals 1', 'Team 1', 'Team 8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 16),
(84, 9, 1308407400, 12, 'Quarterfinals 2', 'Team 5', 'Team 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 16),
(85, 9, 1308407400, 13, 'Quarterfinals 3', 'Team 6', 'Team 3', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 16),
(86, 9, 1308407400, 14, 'Quarterfinals 4', 'Team 7', 'Team 2', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 16),
(87, 10, 1308466800, 19, 'Semifinals 1', 'Winner Quarterfinals 1', 'Winner Quarterfinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 12),
(88, 10, 1308466800, 17, 'Semifinals 2', 'Winner Quarterfinals 3', 'Winner Quarterfinals 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 12),
(89, 10, 1308466800, 15, 'Semifinals 3', 'Loser Quarterfinals 1', 'Loser Quarterfinals 2', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 16),
(90, 10, 1308466800, 13, 'Semifinals 4', 'Loser Quarterfinals 3', 'Loser Quarterfinals 4', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 16),
(91, 11, 1308477600, 5, 'Finals 1', 'Winner Semifinals 1', 'Winner Semifinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 10),
(92, 11, 1308477600, 7, 'Finals 2', 'Loser Semifinals 2', 'Loser Semifinals 1', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, 12),
(93, 11, 1308477600, 14, 'Finals 3', 'Winner Semifinals 3', 'Winner Semifinals 4', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 14),
(94, 11, 1308477600, 15, 'Finals 4', 'Loser Semifinals 4', 'Loser Semifinals 3', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, 16),
(95, 12, 1308407400, 15, 'Quarterfinals 1', 'Team 1', 'Team 8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 24),
(96, 12, 1308407400, 16, 'Quarterfinals 2', 'Team 5', 'Team 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 24),
(97, 12, 1308407400, 17, 'Quarterfinals 3', 'Team 6', 'Team 3', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 24),
(98, 12, 1308407400, 18, 'Quarterfinals 4', 'Team 7', 'Team 2', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 24),
(99, 13, 1308466800, 11, 'Semifinals 1', 'Winner Quarterfinals 1', 'Winner Quarterfinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 20),
(100, 13, 1308466800, 10, 'Semifinals 2', 'Winner Quarterfinals 3', 'Winner Quarterfinals 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 20),
(101, 13, 1308466800, 12, 'Semifinals 3', 'Loser Quarterfinals 1', 'Loser Quarterfinals 2', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, 24),
(102, 13, 1308466800, 9, 'Semifinals 4', 'Loser Quarterfinals 3', 'Loser Quarterfinals 4', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, 24),
(103, 14, 1308477600, 16, 'Finals 1', 'Winner Semifinals 1', 'Winner Semifinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 18),
(104, 14, 1308477600, 17, 'Finals 2', 'Loser Semifinals 2', 'Loser Semifinals 1', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 19, 20),
(105, 14, 1308477600, 18, 'Finals 3', 'Winner Semifinals 3', 'Winner Semifinals 4', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, 22),
(106, 14, 1308477600, 19, 'Finals 4', 'Loser Semifinals 4', 'Loser Semifinals 3', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23, 24),
(107, 15, NULL, 1, 'Match rank 1', 'Team 1', 'Team 3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 15, NULL, 2, 'BYE match', 'Team 2', 'BYE', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 16, NULL, 3, 'BYE match', 'Team 1', 'BYE', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 16, NULL, 4, 'Match rank 2', 'Team 3', 'Team 2', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 17, NULL, 5, 'Match rank 1', 'Team 1', 'Team 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 17, NULL, 6, 'BYE match', 'BYE', 'Team 3', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 18, 1308297600, 4, 'Match rank 1', 'Seed 1', 'Seed 8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 18, 1308297600, 5, 'Match rank 2', 'Seed 2', 'Seed 9', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 18, 1308297600, 6, 'Match rank 3', 'Seed 3', 'Seed 10', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 18, 1308297600, 7, 'Match rank 4', 'Seed 4', 'Seed 11', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 18, 1308297600, 8, 'Match rank 5', 'Seed 5', 'Seed 12', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 18, 1308297600, 9, 'Match rank 6', 'Seed 6', 'Seed 13', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 18, 1308297600, NULL, 'BYE Match Round 1', 'Seed 7', 'BYE', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 19, 1308306600, 12, 'Match rank 1', 'Round 1 aprx rank 1', 'Round 1 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 19, 1308306600, 13, 'Match rank 2', 'Round 1 aprx rank 3', 'Round 1 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 19, 1308306600, 14, 'Match rank 3', 'Round 1 aprx rank 5', 'Round 1 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 19, 1308306600, 15, 'Match rank 4', 'Round 1 aprx rank 7', 'Round 1 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 19, 1308306600, 16, 'Match rank 5', 'Round 1 aprx rank 9', 'Round 1 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 19, 1308306600, 17, 'Match rank 6', 'Round 1 aprx rank 11', 'Round 1 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 19, 1308306600, NULL, 'BYE Match Round 1', 'Round 1 team', 'BYE', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 20, 1308317400, 10, 'Match rank 1', 'Round 2 aprx rank 1', 'Round 2 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 20, 1308317400, 11, 'Match rank 2', 'Round 2 aprx rank 3', 'Round 2 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 20, 1308317400, 12, 'Match rank 3', 'Round 2 aprx rank 5', 'Round 2 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 20, 1308317400, 13, 'Match rank 4', 'Round 2 aprx rank 7', 'Round 2 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 20, 1308317400, 14, 'Match rank 5', 'Round 2 aprx rank 9', 'Round 2 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 20, 1308317400, 15, 'Match rank 6', 'Round 2 aprx rank 11', 'Round 2 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(133, 20, 1308317400, NULL, 'BYE Match Round 2', 'Round 2 team', 'BYE', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(134, 21, 1308385800, 1, 'Match rank 1', 'Round 3 aprx rank 1', 'Round 3 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(135, 21, 1308385800, 2, 'Match rank 2', 'Round 3 aprx rank 3', 'Round 3 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(136, 21, 1308385800, 3, 'Match rank 3', 'Round 3 aprx rank 5', 'Round 3 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(137, 21, 1308385800, 4, 'Match rank 4', 'Round 3 aprx rank 7', 'Round 3 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(138, 21, 1308385800, 5, 'Match rank 5', 'Round 3 aprx rank 9', 'Round 3 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(139, 21, 1308385800, 6, 'Match rank 6', 'Round 3 aprx rank 11', 'Round 3 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 21, 1308385800, NULL, 'BYE Match Round 3', 'Round 3 team', 'BYE', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, 22, 1308396600, 14, 'Match rank 1', 'Round 4 aprx rank 1', 'Round 4 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 22, 1308396600, 15, 'Match rank 2', 'Round 4 aprx rank 3', 'Round 4 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(143, 22, 1308396600, 16, 'Match rank 3', 'Round 4 aprx rank 5', 'Round 4 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(144, 22, 1308396600, 17, 'Match rank 4', 'Round 4 aprx rank 7', 'Round 4 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 22, 1308396600, 18, 'Match rank 5', 'Round 4 aprx rank 9', 'Round 4 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(146, 22, 1308396600, 19, 'Match rank 6', 'Round 4 aprx rank 11', 'Round 4 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(147, 22, 1308396600, NULL, 'BYE Match Round 4', 'Round 4 team', 'BYE', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(148, 23, 1308407400, 6, 'Quarterfinals 1', 'Team 1', 'Team 8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(149, 23, 1308407400, 7, 'Quarterfinals 2', 'Team 5', 'Team 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(150, 23, 1308407400, 8, 'Quarterfinals 3', 'Team 6', 'Team 3', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(151, 23, 1308407400, 9, 'Quarterfinals 4', 'Team 7', 'Team 2', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(152, 24, 1308466800, 3, 'Semifinals 1', 'Winner Quarterfinals 1', 'Winner Quarterfinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 4),
(153, 24, 1308466800, 4, 'Semifinals 2', 'Winner Quarterfinals 3', 'Winner Quarterfinals 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 4),
(154, 24, 1308466800, 5, 'Semifinals 3', 'Loser Quarterfinals 1', 'Loser Quarterfinals 2', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 8),
(155, 24, 1308466800, 6, 'Semifinals 4', 'Loser Quarterfinals 3', 'Loser Quarterfinals 4', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 8),
(156, 25, 1308481200, 3, 'Finals 1', 'Winner Semifinals 1', 'Winner Semifinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2),
(157, 25, 1308477600, 10, 'Finals 2', 'Loser Semifinals 2', 'Loser Semifinals 1', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 4),
(158, 25, 1308477600, 11, 'Finals 3', 'Winner Semifinals 3', 'Winner Semifinals 4', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 6),
(159, 25, 1308477600, 12, 'Finals 4', 'Loser Semifinals 4', 'Loser Semifinals 3', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 8),
(160, 26, 1308407400, 10, 'Quarterfinals 1', 'Team 1', 'Team 5', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 13),
(161, 26, 1308407400, 11, 'Quarterfinals 2', 'Team 4', 'Team 2', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 12),
(162, 26, 1308407400, NULL, 'Quarterfinals BYE Match', 'Team 3', 'BYE', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 12),
(163, 27, 1308466800, 7, 'Semifinals 1', 'Winner Quarterfinals 1', 'Team 3', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 12),
(164, 27, 1308466800, 8, 'Semifinals 2', 'Winner Quarterfinals 2', 'Loser Quarterfinals 1', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 13),
(165, 27, 1308466800, NULL, 'Semifinals BYE Match', 'Loser Quarterfinals 2', 'BYE', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, 12),
(166, 28, 1308477600, 12, 'Finals 1', 'Winner Semifinals 1', 'Winner Semifinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 10),
(167, 28, 1308477600, 13, 'Finals 2', 'Loser Quarterfinals 2', 'Loser Semifinals 1', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, 12),
(168, 28, 1308477600, NULL, 'Finals BYE Match', 'Loser Semifinals 2', 'BYE', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 13),
(169, 29, 1308302100, 1, 'Match rank 1', 'Seed 1', 'Seed 22', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(170, 29, 1308302100, 2, 'Match rank 2', 'Seed 2', 'Seed 23', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(171, 29, 1308302100, 3, 'Match rank 3', 'Seed 3', 'Seed 24', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(172, 29, 1308302100, 4, 'Match rank 4', 'Seed 4', 'Seed 25', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(173, 29, 1308302100, 5, 'Match rank 5', 'Seed 5', 'Seed 26', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(174, 29, 1308302100, 6, 'Match rank 6', 'Seed 6', 'Seed 27', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(175, 29, 1308302100, 7, 'Match rank 7', 'Seed 7', 'Seed 28', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(176, 29, 1308302100, 8, 'Match rank 8', 'Seed 8', 'Seed 29', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(177, 29, 1308302100, 9, 'Match rank 9', 'Seed 9', 'Seed 30', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(178, 29, 1308302100, 10, 'Match rank 10', 'Seed 10', 'Seed 31', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(179, 29, 1308302100, 11, 'Match rank 11', 'Seed 11', 'Seed 32', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(180, 29, 1308302100, 12, 'Match rank 12', 'Seed 12', 'Seed 33', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(181, 29, 1308302100, 13, 'Match rank 13', 'Seed 13', 'Seed 34', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(182, 29, 1308302100, 14, 'Match rank 14', 'Seed 14', 'Seed 35', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(183, 29, 1308302100, 15, 'Match rank 15', 'Seed 15', 'Seed 36', 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(184, 29, 1308302100, 16, 'Match rank 16', 'Seed 16', 'Seed 37', 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(185, 29, 1308302100, 17, 'Match rank 17', 'Seed 17', 'Seed 38', 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(186, 29, 1308302100, 18, 'Match rank 18', 'Seed 18', 'Seed 39', 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(187, 29, 1308302100, 19, 'Match rank 19', 'Seed 19', 'Seed 40', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(188, 29, 1308302100, 20, 'Match rank 20', 'Seed 20', 'Seed 41', 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(189, 29, 1308302100, NULL, 'BYE Match Round 1', 'Seed 21', 'BYE', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(190, 30, 1308312000, 20, 'Match rank 1', 'Round 1 aprx rank 1', 'Round 1 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(191, 30, 1308312000, 19, 'Match rank 2', 'Round 1 aprx rank 3', 'Round 1 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(192, 30, 1308312000, 18, 'Match rank 3', 'Round 1 aprx rank 5', 'Round 1 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(193, 30, 1308312000, 17, 'Match rank 4', 'Round 1 aprx rank 7', 'Round 1 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(194, 30, 1308312000, 16, 'Match rank 5', 'Round 1 aprx rank 9', 'Round 1 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(195, 30, 1308312000, 15, 'Match rank 6', 'Round 1 aprx rank 11', 'Round 1 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(196, 30, 1308312000, 14, 'Match rank 7', 'Round 1 aprx rank 13', 'Round 1 aprx rank 14', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(197, 30, 1308312000, 13, 'Match rank 8', 'Round 1 aprx rank 15', 'Round 1 aprx rank 16', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(198, 30, 1308312000, 12, 'Match rank 9', 'Round 1 aprx rank 17', 'Round 1 aprx rank 18', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(199, 30, 1308312000, 11, 'Match rank 10', 'Round 1 aprx rank 19', 'Round 1 aprx rank 20', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(200, 30, 1308312000, 10, 'Match rank 11', 'Round 1 aprx rank 21', 'Round 1 aprx rank 22', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(201, 30, 1308312000, 9, 'Match rank 12', 'Round 1 aprx rank 23', 'Round 1 aprx rank 24', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(202, 30, 1308312000, 8, 'Match rank 13', 'Round 1 aprx rank 25', 'Round 1 aprx rank 26', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(203, 30, 1308312000, 7, 'Match rank 14', 'Round 1 aprx rank 27', 'Round 1 aprx rank 28', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(204, 30, 1308312000, 6, 'Match rank 15', 'Round 1 aprx rank 29', 'Round 1 aprx rank 30', 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(205, 30, 1308312000, 5, 'Match rank 16', 'Round 1 aprx rank 31', 'Round 1 aprx rank 32', 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(206, 30, 1308312000, 4, 'Match rank 17', 'Round 1 aprx rank 33', 'Round 1 aprx rank 34', 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(207, 30, 1308312000, 3, 'Match rank 18', 'Round 1 aprx rank 35', 'Round 1 aprx rank 36', 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(208, 30, 1308312000, 2, 'Match rank 19', 'Round 1 aprx rank 37', 'Round 1 aprx rank 38', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(209, 30, 1308312000, 1, 'Match rank 20', 'Round 1 aprx rank 39', 'Round 1 aprx rank 40', 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(210, 30, 1308312000, NULL, 'BYE Match Round 1', 'Round 1 team', 'BYE', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211, 31, 1308322800, 11, 'Match rank 1', 'Round 2 aprx rank 1', 'Round 2 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(212, 31, 1308322800, 12, 'Match rank 2', 'Round 2 aprx rank 3', 'Round 2 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(213, 31, 1308322800, 13, 'Match rank 3', 'Round 2 aprx rank 5', 'Round 2 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(214, 31, 1308322800, 14, 'Match rank 4', 'Round 2 aprx rank 7', 'Round 2 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(215, 31, 1308322800, 15, 'Match rank 5', 'Round 2 aprx rank 9', 'Round 2 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(216, 31, 1308322800, 16, 'Match rank 6', 'Round 2 aprx rank 11', 'Round 2 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(217, 31, 1308322800, 17, 'Match rank 7', 'Round 2 aprx rank 13', 'Round 2 aprx rank 14', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(218, 31, 1308322800, 18, 'Match rank 8', 'Round 2 aprx rank 15', 'Round 2 aprx rank 16', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(219, 31, 1308322800, 19, 'Match rank 9', 'Round 2 aprx rank 17', 'Round 2 aprx rank 18', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(220, 31, 1308322800, 20, 'Match rank 10', 'Round 2 aprx rank 19', 'Round 2 aprx rank 20', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(221, 31, 1308322800, 1, 'Match rank 11', 'Round 2 aprx rank 21', 'Round 2 aprx rank 22', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(222, 31, 1308322800, 2, 'Match rank 12', 'Round 2 aprx rank 23', 'Round 2 aprx rank 24', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(223, 31, 1308322800, 3, 'Match rank 13', 'Round 2 aprx rank 25', 'Round 2 aprx rank 26', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(224, 31, 1308322800, 4, 'Match rank 14', 'Round 2 aprx rank 27', 'Round 2 aprx rank 28', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(225, 31, 1308322800, 5, 'Match rank 15', 'Round 2 aprx rank 29', 'Round 2 aprx rank 30', 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(226, 31, 1308322800, 6, 'Match rank 16', 'Round 2 aprx rank 31', 'Round 2 aprx rank 32', 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(227, 31, 1308322800, 7, 'Match rank 17', 'Round 2 aprx rank 33', 'Round 2 aprx rank 34', 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(228, 31, 1308322800, 8, 'Match rank 18', 'Round 2 aprx rank 35', 'Round 2 aprx rank 36', 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(229, 31, 1308322800, 9, 'Match rank 19', 'Round 2 aprx rank 37', 'Round 2 aprx rank 38', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(230, 31, 1308322800, 10, 'Match rank 20', 'Round 2 aprx rank 39', 'Round 2 aprx rank 40', 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(231, 31, 1308322800, NULL, 'BYE Match Round 2', 'Round 2 team', 'BYE', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(232, 32, 1308380400, 1, 'Match rank 1', 'Round 3 aprx rank 1', 'Round 3 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(233, 32, 1308380400, 2, 'Match rank 2', 'Round 3 aprx rank 3', 'Round 3 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(234, 32, 1308380400, 3, 'Match rank 3', 'Round 3 aprx rank 5', 'Round 3 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(235, 32, 1308380400, 10, 'Match rank 4', 'Round 3 aprx rank 7', 'Round 3 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(236, 32, 1308380400, 14, 'Match rank 5', 'Round 3 aprx rank 9', 'Round 3 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(237, 32, 1308380400, 15, 'Match rank 6', 'Round 3 aprx rank 11', 'Round 3 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(238, 32, 1308380400, 16, 'Match rank 7', 'Round 3 aprx rank 13', 'Round 3 aprx rank 14', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(239, 32, 1308380400, 11, 'Match rank 8', 'Round 3 aprx rank 15', 'Round 3 aprx rank 16', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(240, 32, 1308380400, 12, 'Match rank 9', 'Round 3 aprx rank 17', 'Round 3 aprx rank 18', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(241, 32, 1308380400, 13, 'Match rank 10', 'Round 3 aprx rank 19', 'Round 3 aprx rank 20', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(242, 32, 1308380400, 17, 'Match rank 11', 'Round 3 aprx rank 21', 'Round 3 aprx rank 22', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(243, 32, 1308380400, 18, 'Match rank 12', 'Round 3 aprx rank 23', 'Round 3 aprx rank 24', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(244, 32, 1308380400, 4, 'Match rank 13', 'Round 3 aprx rank 25', 'Round 3 aprx rank 26', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(245, 32, 1308380400, 5, 'Match rank 14', 'Round 3 aprx rank 27', 'Round 3 aprx rank 28', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(246, 32, 1308380400, 6, 'Match rank 15', 'Round 3 aprx rank 29', 'Round 3 aprx rank 30', 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(247, 32, 1308380400, 7, 'Match rank 16', 'Round 3 aprx rank 31', 'Round 3 aprx rank 32', 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(248, 32, 1308380400, 8, 'Match rank 17', 'Round 3 aprx rank 33', 'Round 3 aprx rank 34', 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(249, 32, 1308380400, 9, 'Match rank 18', 'Round 3 aprx rank 35', 'Round 3 aprx rank 36', 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(250, 32, 1308380400, 19, 'Match rank 19', 'Round 3 aprx rank 37', 'Round 3 aprx rank 38', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(251, 32, 1308380400, 20, 'Match rank 20', 'Round 3 aprx rank 39', 'Round 3 aprx rank 40', 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(252, 32, 1308380400, NULL, 'BYE Match Round 3', 'Round 3 team', 'BYE', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(253, 33, 1308391200, 1, 'Match rank 1', 'Round 4 aprx rank 1', 'Round 4 aprx rank 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(254, 33, 1308391200, 11, 'Match rank 2', 'Round 4 aprx rank 3', 'Round 4 aprx rank 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(255, 33, 1308391200, 12, 'Match rank 3', 'Round 4 aprx rank 5', 'Round 4 aprx rank 6', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(256, 33, 1308391200, 18, 'Match rank 4', 'Round 4 aprx rank 7', 'Round 4 aprx rank 8', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(257, 33, 1308391200, 19, 'Match rank 5', 'Round 4 aprx rank 9', 'Round 4 aprx rank 10', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(258, 33, 1308391200, 2, 'Match rank 6', 'Round 4 aprx rank 11', 'Round 4 aprx rank 12', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(259, 33, 1308391200, 3, 'Match rank 7', 'Round 4 aprx rank 13', 'Round 4 aprx rank 14', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(260, 33, 1308391200, 13, 'Match rank 8', 'Round 4 aprx rank 15', 'Round 4 aprx rank 16', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(261, 33, 1308391200, 14, 'Match rank 9', 'Round 4 aprx rank 17', 'Round 4 aprx rank 18', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(262, 33, 1308391200, 15, 'Match rank 10', 'Round 4 aprx rank 19', 'Round 4 aprx rank 20', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(263, 33, 1308391200, 16, 'Match rank 11', 'Round 4 aprx rank 21', 'Round 4 aprx rank 22', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(264, 33, 1308391200, 17, 'Match rank 12', 'Round 4 aprx rank 23', 'Round 4 aprx rank 24', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(265, 33, 1308391200, 4, 'Match rank 13', 'Round 4 aprx rank 25', 'Round 4 aprx rank 26', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(266, 33, 1308391200, 5, 'Match rank 14', 'Round 4 aprx rank 27', 'Round 4 aprx rank 28', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(267, 33, 1308391200, 6, 'Match rank 15', 'Round 4 aprx rank 29', 'Round 4 aprx rank 30', 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(268, 33, 1308391200, 7, 'Match rank 16', 'Round 4 aprx rank 31', 'Round 4 aprx rank 32', 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(269, 33, 1308391200, 8, 'Match rank 17', 'Round 4 aprx rank 33', 'Round 4 aprx rank 34', 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(270, 33, 1308391200, 9, 'Match rank 18', 'Round 4 aprx rank 35', 'Round 4 aprx rank 36', 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(271, 33, 1308391200, 10, 'Match rank 19', 'Round 4 aprx rank 37', 'Round 4 aprx rank 38', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(272, 33, 1308391200, 20, 'Match rank 20', 'Round 4 aprx rank 39', 'Round 4 aprx rank 40', 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(273, 33, 1308391200, NULL, 'BYE Match Round 4', 'Round 4 team', 'BYE', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(274, 34, 1308402000, 12, 'Quarterfinals 1', 'Team 1', 'Team 8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(275, 34, 1308402000, 13, 'Quarterfinals 2', 'Team 5', 'Team 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(276, 34, 1308402000, 14, 'Quarterfinals 3', 'Team 6', 'Team 3', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(277, 34, 1308402000, 8, 'Quarterfinals 4', 'Team 7', 'Team 2', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
(278, 35, 1308412800, 1, 'Semifinals 1', 'Winner Quarterfinals 1', 'Winner Quarterfinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 4),
(279, 35, 1308412800, 2, 'Semifinals 2', 'Winner Quarterfinals 3', 'Winner Quarterfinals 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 4),
(280, 35, 1308412800, 7, 'Semifinals 3', 'Loser Quarterfinals 1', 'Loser Quarterfinals 2', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 8),
(281, 35, 1308412800, 15, 'Semifinals 4', 'Loser Quarterfinals 3', 'Loser Quarterfinals 4', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 8),
(282, 36, 1308488400, 3, 'Finals 1', 'Winner Semifinals 1', 'Winner Semifinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2),
(283, 36, 1308472200, 2, 'Finals 2', 'Loser Semifinals 2', 'Loser Semifinals 1', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 4),
(284, 36, 1308472200, 4, 'Finals 3', 'Winner Semifinals 3', 'Winner Semifinals 4', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 6),
(285, 36, 1308472200, 5, 'Finals 4', 'Loser Semifinals 4', 'Loser Semifinals 3', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 8),
(286, 37, 1308402000, 9, 'Quarterfinals 1', 'Team 1', 'Team 8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 16),
(287, 37, 1308402000, 10, 'Quarterfinals 2', 'Team 5', 'Team 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 16),
(288, 37, 1308402000, 5, 'Quarterfinals 3', 'Team 6', 'Team 3', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 16),
(289, 37, 1308402000, 6, 'Quarterfinals 4', 'Team 7', 'Team 2', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 16),
(290, 38, 1308412800, 8, 'Semifinals 1', 'Winner Quarterfinals 1', 'Winner Quarterfinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 12),
(291, 38, 1308412800, 9, 'Semifinals 2', 'Winner Quarterfinals 3', 'Winner Quarterfinals 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 12),
(292, 38, 1308412800, 17, 'Semifinals 3', 'Loser Quarterfinals 1', 'Loser Quarterfinals 2', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 16),
(293, 38, 1308412800, 18, 'Semifinals 4', 'Loser Quarterfinals 3', 'Loser Quarterfinals 4', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 16),
(294, 39, 1308472200, 5, 'Finals 1', 'Winner Semifinals 1', 'Winner Semifinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 10),
(295, 39, 1308472200, 6, 'Finals 2', 'Loser Semifinals 2', 'Loser Semifinals 1', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, 12),
(296, 39, 1308472200, 7, 'Finals 3', 'Winner Semifinals 3', 'Winner Semifinals 4', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 14),
(297, 39, 1308472200, 8, 'Finals 4', 'Loser Semifinals 4', 'Loser Semifinals 3', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, 16),
(298, 40, 1308402000, 7, 'Quarterfinals 1', 'Team 1', 'Team 8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 24),
(299, 40, 1308402000, 18, 'Quarterfinals 2', 'Team 5', 'Team 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 24),
(300, 40, 1308402000, 19, 'Quarterfinals 3', 'Team 6', 'Team 3', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 24),
(301, 40, 1308402000, 11, 'Quarterfinals 4', 'Team 7', 'Team 2', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 24),
(302, 41, 1308412800, 19, 'Semifinals 1', 'Winner Quarterfinals 1', 'Winner Quarterfinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 20),
(303, 41, 1308412800, 20, 'Semifinals 2', 'Winner Quarterfinals 3', 'Winner Quarterfinals 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 20),
(304, 41, 1308412800, 10, 'Semifinals 3', 'Loser Quarterfinals 1', 'Loser Quarterfinals 2', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, 24),
(305, 41, 1308412800, 13, 'Semifinals 4', 'Loser Quarterfinals 3', 'Loser Quarterfinals 4', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, 24),
(306, 42, 1308472200, 9, 'Finals 1', 'Winner Semifinals 1', 'Winner Semifinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 18),
(307, 42, 1308472200, 10, 'Finals 2', 'Loser Semifinals 2', 'Loser Semifinals 1', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 19, 20),
(308, 42, 1308472200, 11, 'Finals 3', 'Winner Semifinals 3', 'Winner Semifinals 4', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, 22),
(309, 42, 1308472200, 12, 'Finals 4', 'Loser Semifinals 4', 'Loser Semifinals 3', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23, 24),
(310, 43, 1308402000, 15, 'Quarterfinals 1', 'Team 1', 'Team 8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 32),
(311, 43, 1308402000, 16, 'Quarterfinals 2', 'Team 5', 'Team 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 32),
(312, 43, 1308402000, 17, 'Quarterfinals 3', 'Team 6', 'Team 3', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 32),
(313, 43, 1308402000, 1, 'Quarterfinals 4', 'Team 7', 'Team 2', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 32),
(314, 44, 1308412800, 14, 'Semifinals 1', 'Winner Quarterfinals 1', 'Winner Quarterfinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 28),
(315, 44, 1308412800, 11, 'Semifinals 2', 'Winner Quarterfinals 3', 'Winner Quarterfinals 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 28),
(316, 44, 1308412800, 12, 'Semifinals 3', 'Loser Quarterfinals 1', 'Loser Quarterfinals 2', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 32),
(317, 44, 1308412800, 3, 'Semifinals 4', 'Loser Quarterfinals 3', 'Loser Quarterfinals 4', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 32),
(318, 45, 1308472200, 13, 'Finals 1', 'Winner Semifinals 1', 'Winner Semifinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 26),
(319, 45, 1308472200, 14, 'Finals 2', 'Loser Semifinals 2', 'Loser Semifinals 1', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 27, 28),
(320, 45, 1308472200, 15, 'Finals 3', 'Winner Semifinals 3', 'Winner Semifinals 4', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 30),
(321, 45, 1308472200, 16, 'Finals 4', 'Loser Semifinals 4', 'Loser Semifinals 3', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 31, 32),
(322, 46, 1308402000, 2, 'Quarterfinals 1', 'Team 1', 'Team 8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 33, 41),
(323, 46, 1308402000, 3, 'Quarterfinals 2', 'Team 5', 'Team 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 33, 38),
(324, 46, 1308402000, 4, 'Quarterfinals 3', 'Team 6', 'Team 3', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 33, 41),
(325, 46, 1308402000, 20, 'Quarterfinals 4', 'Team 7', 'Team 2', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 33, 41),
(326, 46, 1308402000, NULL, 'Quarterfinals BYE Match', 'Team 9', 'BYE', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 40, 41),
(327, 47, 1308412800, 4, 'Semifinals 1', 'Winner Quarterfinals 1', 'Winner Quarterfinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 33, 36),
(328, 47, 1308412800, 5, 'Semifinals 2', 'Winner Quarterfinals 3', 'Winner Quarterfinals 4', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 33, 36),
(329, 47, 1308412800, 6, 'Semifinals 3', 'Team 9', 'Loser Quarterfinals 3', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 40, 41),
(330, 47, 1308412800, 16, 'Semifinals 4', 'Loser Quarterfinals 1', 'Loser Quarterfinals 4', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, 41),
(331, 47, 1308412800, NULL, 'Semifinals BYE Match', 'Loser Quarterfinals 2', 'BYE', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, 38),
(332, 48, 1308472200, 17, 'Finals 1', 'Winner Semifinals 1', 'Winner Semifinals 2', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 33, 34),
(333, 48, 1308472200, 18, 'Finals 2', 'Loser Semifinals 2', 'Loser Semifinals 1', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 35, 36),
(334, 48, 1308472200, 19, 'Finals 3', 'Loser Quarterfinals 2', 'Winner Semifinals 4', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, 39),
(335, 48, 1308472200, 20, 'Finals 4', 'Loser Semifinals 4', 'Loser Semifinals 3', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 40, 41),
(336, 48, 1308472200, NULL, 'Finals BYE Match', 'Winner Semifinals 3', 'BYE', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, 38);

-- --------------------------------------------------------

--
-- Table structure for table `stage`
--

CREATE TABLE IF NOT EXISTS `stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `placement` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `division_id_idx` (`division_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `stage`
--

INSERT INTO `stage` (`id`, `title`, `division_id`, `rank`, `locked`, `placement`) VALUES
(1, 'Registration stage', 1, 1, NULL, NULL),
(2, 'Swissdraw', 1, 2, NULL, NULL),
(3, 'Playoff', 1, 3, NULL, NULL),
(4, 'Registration stage', 2, 1, NULL, NULL),
(5, 'Swissdraw', 2, 2, NULL, NULL),
(6, 'Playoff', 2, 3, NULL, NULL),
(7, 'Registration stage', 3, 1, NULL, NULL),
(8, 'Swissdraw', 3, 2, NULL, NULL),
(9, 'Playoffs', 3, 3, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `s_m_s`
--

CREATE TABLE IF NOT EXISTS `s_m_s` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) DEFAULT NULL,
  `round_id` int(11) DEFAULT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `createtime` bigint(20) DEFAULT NULL,
  `submittime` bigint(20) DEFAULT NULL,
  `senttime` bigint(20) DEFAULT NULL,
  `receivedtime` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tournament_id_idx` (`tournament_id`),
  KEY `team_id_idx` (`team_id`),
  KEY `round_id_idx` (`round_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `s_m_s`
--


-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shortname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contactname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile3` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile4` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile5` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `tournament_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `byestatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tournament_id_idx` (`tournament_id`),
  KEY `division_id_idx` (`division_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=85 ;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `shortname`, `email1`, `email2`, `contactname`, `city`, `country`, `mobile1`, `mobile2`, `mobile3`, `mobile4`, `mobile5`, `comment`, `tournament_id`, `division_id`, `byestatus`) VALUES
(1, 'Gentle', 'Gentle', 'johanbommie@yahoo.com', '', 'korneel', 'Gent', 'Belgium', '32486652562', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(2, 'France National Master Team', 'FranceMaster', 'pierril9@yahoo.com', 'jygoliard@yahoo.com', 'jano', 'ALL AROUND', 'FRANCE', '33685554475', '33650741660', NULL, NULL, NULL, '', NULL, 1, NULL),
(3, 'Rainbow Warriors', 'Rainbow Warriors', 'thomas.kuypers@laposte.net', 'thomas.kuypers@laposte.net', 'Thomas Kuypers', 'Lille/BesanÌ¤on/Clermont', 'France', '33626820763', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(4, 'Carapedos', 'Carapedos', 'db@davidbender.de', 'hauck@ghost-o-one.de', 'Torsten', 'Wuppertal/ Dortmund', 'Germany', '491752015296', '491732716004', '491725766639', NULL, NULL, '', NULL, 1, NULL),
(5, 'KoBOld', 'KoBOld', 'tim.oehr@gmail.com', 'timoehr@uni-bremen.de', 'Tim Oehr', 'Bremen, Oldenburg, Osnabrueck', 'Germany', '491777157468', '4915111667320', '4917663048053', '491732112759', '4917621714819', '', NULL, 1, NULL),
(6, 'Hardfisch', 'Hardfisch', 'tieiben@gmail.com', 'tieiben@gmail.com', 'Tarek Iko Eiben', 'Hamburg', 'Germany', '491729047847', '4915788484214', '491776052828', '491774454771', '4916095730116', '', NULL, 1, NULL),
(7, 'Tsunami Vintage', 'Tsunami', 'cyrille.perez@wanadoo.Fr', 'cyrille.perez@wanadoo.fr', 'cyrille', 'Nemours', 'FRANCE', '33650634651', '33625651587', '33661239577', '33670427292', '33632517820', '', NULL, 1, NULL),
(8, 'Xlr8rs', 'Xlr8rs', 'lucchome@yahoo.com', 'tsasfra@gmail.com', 'FRANZ TSAS', 'Brussels', 'Belgium', '32486036417', '32497056317', '32485454818', NULL, NULL, '', NULL, 1, NULL),
(9, 'Mooncatchers', 'Mooncatchers', 'cbihin@gmail.com', 'calimemo@hotmail.com', 'Nicolas De Mesmaeker', 'Brussels', 'Belgium', '32487178892', '32495866466', '32474816536', '32495785634', NULL, '', NULL, 1, NULL),
(10, 'MAM Friends', 'MAM', 'sbeltramo@wanadoo.fr', 'seb.beltramo@gmail.com', 'Bab', 'Manies', 'France', '33601171070', '33620698325', NULL, NULL, NULL, '', NULL, 1, NULL),
(11, 'Rebel Ultimate', 'Rebel', 'rebelultimate@gmail.com', 'flashdan9@gmail.com', 'Brian O''Callaghan', 'Cork', 'Ireland', '353877811008', '353860859092', '31652100534', '353863448084', '353868801012', '', NULL, 1, NULL),
(12, 'Silence', 'Silence', 'ondrej.bouska@gmail.com', 'frankie@praguedevils.org', 'Ondrej Bouska', 'Prague', 'Czech Republic', '420775686147', '420603751806', '420732944669', '420604344735', '420724773365', '', NULL, 1, NULL),
(13, 'Funatics', 'Funatics', 'vorstand@funaten.de', 'mario-tonini@wanadoo.fr', 'Mario', 'Hannover', 'Germany', '491799781163', '491789388635', '4917664856234', '491782090301', '491753593883', '', NULL, 1, NULL),
(14, 'Pissotte', 'Pissotte', 'richard.francheteau@gmail.com', 'spiroo@laposte.net', 'Spiroo', 'Open national team', 'France', '33672716922', '33664220255', '33618086583', '33616708685', '33670901003', '', NULL, 1, NULL),
(15, 'theBigEz - Vienna', 'theBigEz', '', 'christian_holzinger@inode.at', 'Christian Holzinger', 'Vienna', 'Austria', '436505411902', '436502443256', '436642165781', '436764742685', NULL, '', NULL, 1, NULL),
(16, 'Solebang', 'Solebang', 'mario_baumann@hotmail.com', 'benji@gnadelos.ch', 'Benji Fischer', 'Cham', 'Schweiz', '41763377106', '41788867050', '41788032851', '41763606791', '41786814639', '', NULL, 1, NULL),
(17, 'CUS Bologna', 'Bologna', 'info@bodisc.it', 'info#@bodisc.it', 'Davide Morri', 'Bologna', 'Italy', '393334064008', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(18, 'M.U.C.', 'M.U.C.', 'michy@zamperl.com', 'jens91@mnet-online.de', 'Jens Achenbach', 'Munich', 'Germany', '491739438483', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(19, 'Flying Angels Bern (FAB)', 'Flying Angels', 'info@flyingangels.ch', 'christian.brethaut@gmail.com', 'Chris', 'Bern', 'Switzerland', '41792066331', '41787962969', NULL, NULL, NULL, '', NULL, 1, NULL),
(20, 'Spain National Team', 'Spain', 'tim.kohlstadt@gmail.com', 'ajpalmer@gmail.com', 'Tim + Justin', 'Spain', 'Spain', '34649172116', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(21, 'Iznogood', 'Iznogood', 'ckriss9-izno@yahoo.fr', 'Francoiszoubir@yahoo.fr', 'Francois', 'Paris ', 'France', '330698001248', '330698001248', NULL, NULL, NULL, '', NULL, 1, NULL),
(22, 'UL Ninjas', 'UL Ninjas', 'ulultimatefrisbee@gmail.com', 'jamesmoore@o2.ie', 'James Moore', 'Limerick', 'Ireland', '353852702485', '353879216409', '353857048535', '353863989799', '353877811008', '', NULL, 1, NULL),
(23, 'German Junior Open', 'German Junior', 'Matthias@brucklacher.com', 'matthias@brucklacher.com', 'Matthias', 'allover germany', 'germany', '491727058899', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(24, 'Gummibaerchen', 'Gummibaerchen', 'trainer@ultimate-karlsruhe.de', 'turniere@ultimate-karlsruhe.de', 'Felix Mach', 'Karlsruhe', 'Germany', '4917682121421', '4915159247750', NULL, NULL, NULL, '', NULL, 1, NULL),
(25, 'Disc Club Panthers', 'Panthers', 'info@dcp.ch', 'l.schaer@gmx.net', 'Lukas Schaer', 'Bern', 'Switzerland', '41794596728', '41792430667', NULL, NULL, NULL, '', NULL, 1, NULL),
(26, 'Russia National Team', 'Russia', 'av@rusultimate.org', 'avasilyev18@gmail.com', 'Anatoly Vasilyev', '', 'Russia', '79670919059', '79161537629', '79162117731', '79161586615', '79263879408', '', NULL, 1, NULL),
(27, 'Buggoli', 'Buggoli', 'earley.mark@gmail.com', 'coach@broccoliultimate.com', 'David Rickard', 'Dublin', 'Ireland', '353877431088', '447816540534', '447525475977', '353871226693', '353873530108', 'Great idea lads!  To clarify the team name: Broccoli and BUG are combining their squads, so you can call us Buggoli if you like!', NULL, 1, NULL),
(28, 'Soimii Patriei', 'Soimii', 'pasalega_adrian@yahoo.com', 'c_relu@yahoo.com', 'Adrian Pasalega', 'Cluj-Napoca', 'ROMANIA', '40766772772', '40745383562', NULL, NULL, NULL, '', NULL, 1, NULL),
(29, 'Denmark National Team', 'Denmark', 'administrator@dfsu.dk', 'elite@dfsu.dk', 'Taiyo JÌ¦nsson', 'Copenhagen', 'Denmark', '4528185684', '4551506588', '4561338010', '4527388129', '4551923885', '', NULL, 1, NULL),
(30, 'Sun', 'Sun', 'sunFrisbee@gmail.com', 'pabs_agro@yahoo.fr', 'Pablo Lopez', 'CrÌ©teil', 'France', '33677090606', '33607560464', NULL, NULL, NULL, '', NULL, 1, NULL),
(31, 'Friselis Club Ultimate Versailles', 'Friselis', 'friselisclubversailles@gmail.com', 'augustinscala@gmail.com', 'Gus', 'Versailles', 'France', '33688435794', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(32, '7 Schwaben', '7Schwaben', 'schlecht@selk-stuttgart.de', 'wolfi.a@gmx.de', 'Philipp Haas, Wolfgang Alder', 'Stuttgart', 'Germany', '', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(33, 'Barbastreji', 'Barbastreji', 'info@ultimatepadova.it', 'diego_melisi@yahoo.it', 'Diego', 'Padova', 'Italy', '393483609600', '393409799795', '393463243176', '393288456619', '393497319366', 'formerly PUF - Padova Ultimate Frisbee', NULL, 1, NULL),
(34, 'Ultimate deLux', 'deLux', 'contact@ultimate-delux.org', 'richardson_jt@yahoo.com', 'JT Richardson', 'Luxembourg', 'Luxembourg', '4916095063547', '352621699507', '491781897744', NULL, NULL, '', NULL, 1, NULL),
(35, 'Freespeed', 'Freespeed', 'info@freespeed.ch', 'flow@freespeed.ch', 'Florian Kaeser', 'Basel', 'Switzerland', '41764173505', '41788795948', NULL, NULL, NULL, '', NULL, 1, NULL),
(36, 'Flying Bisc', 'Flying Bisc', 'tuscanultimate@gmail.com', '', 'Massimo Duradoni', 'Florence', 'Italy', '', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(37, 'Red Lights', 'Red Lights', 'tedbeute@upcmail.nl', '', 'Ted Beute', 'Amsterdam', 'Nederland', '31614994428', '31619618365', '31644550455', '31651401141', '31647047588', '', NULL, 1, NULL),
(38, 'Les etoiles o', 'Les etoiles o', 'sigibodson@yahoo.com', 'bodsonsigi@hotmail.com', 'Sigi Bodson', 'Hasselt + Huy', 'Belgium', '32476782806', '32497305258', NULL, NULL, NULL, '', NULL, 1, NULL),
(39, 'Cambo Cakes', 'Cambo Cakes', 'wombatcummings@hotmail.com', 'miccwvdl@hotmail.com', 'Michiel van de Leur', 'Amsterdam', 'Netherlands', '31643045677', '31611000974', NULL, NULL, NULL, '', NULL, 1, NULL),
(40, 'Holland National Team', 'Netherlands', 'dutchnationalteam@gmail.com', 'tomwaijers@yahoo.com', 'Tom Waaijers', '', 'Netherlands', '', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(41, 'German masters', 'German Masters', 'froetsch@gmx.de', '', 'Bernhard Froetschl', '', 'Germany', '', '', NULL, NULL, NULL, '', NULL, 1, NULL),
(42, 'BYE Team', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(43, 'Disco Stu', 'Disco Stu', 'raffarufus@hotmail.it', 'raffarufus@hotmail.it', 'raffaele de curtis (rufus)', 'modena', 'italy', '393331433038', '393290237770', NULL, NULL, NULL, 'Sorry, someone else made a "disco stu" team before me and in the previous registration form i chose the wrong one.\n\nrufus', NULL, 2, NULL),
(44, 'Superfly', 'Superfly', 'tomsummerbee@yahoo.com', 'tomsummerbee@yahoo.com', 'Tom Summerbee', 'Birmingham', 'England', '33611488080', '', NULL, NULL, NULL, 'Hi,\nI''m sorry but I just sent a message asking when registration opened, so please ignore that message. If you could let me know how to pay the team fee I will get that done as soon as possible.\n\nMany thanks\nTom Summerbee', NULL, 2, NULL),
(45, 'PUF', 'PUF', 'lutzmuerau@hotmail.com', 'ravi.a.vasudevan@gmail.com', 'Lutz, Ravi', 'Delft, Den Haag, Leiden', 'Netherlands', '31634313251', '31681163086', '31646690049', '31634034778', '31650894721', '', NULL, 2, NULL),
(46, 'Quijotes+Dulcineas', 'Quijotes', 'quijotesultimate@gmail.com', 'ajpalmer@gmail.com', 'Justin', 'Madrid', 'Spain', '34687278957', '34656824603', NULL, NULL, NULL, 'Looking forward to Windmill again!We finished 14th last year with half the team and a handful of pickups, but the stories we brought back seem to have convinced the rest of the team to come along this year...', NULL, 2, NULL),
(47, 'France National Team', 'France', 'intendant.mixte@ffdf.fr', 'intendant.mixte@ffdf.fr', 'Guillaume CANAL', '', 'France', '33672615141', '33688472848', NULL, NULL, NULL, '', NULL, 2, NULL),
(48, 'Stockholm Syndromes', 'Stockholm', 'ssufc@stockholmsyndromes.se', 'paul.eriksson@frisbeesport.se', 'Paul Eriksson', 'Stockholm', 'Sweden', '46739960557', '46733783257', NULL, NULL, NULL, 'Hej,\n\nWe are the Stockholm Syndromes, have never been to a Dutch tournament, but have heard only great things. Beside the Swedish guys and girls, we are a pretty international squad from Stockholm and are aiming for a fun mixed experience :-)', NULL, 2, NULL),
(49, 'Spirit on Lemon', 'Spirit on Lemon', '', 'tailor82@gmail.com', 'Tom', 'Sosnowiec', 'Poland', '48502489694', '48507120311', NULL, NULL, NULL, 'Hello\nMy nam is Tom. I''am a capitan of Spirit on Lemon Ultimate Frisbee Team from Poland!\nI would like to register my team Spirit on Lemon from Poland for this year  Windmill Windup!\nIt would be pleasure to join you!\nTom', NULL, 2, NULL),
(50, 'Cheek2Cheek', 'Cheek2Cheek', 'christoph.obenhuber@gmx.at', 'florian.eywo@gmx.at', 'Christoph Obenhuber', 'Vienna', 'Austria', '436508050081', '436504783764', NULL, NULL, NULL, 'Hi guys,\n\nWe are the current Austrian Mixed Champion and would love to come to windmill with our girlz and boyz. We have been at windmill for the last few years with our open team (bigez) and now we are looking forward to join the windmill mixed experience ;-)\n\ncheers,\nchristoph', NULL, 2, NULL),
(51, 'TeamAustria Mixed', 'Austria', 'hnowak@gmx.at', 'upsadaisy@gmx.at', 'harald nowak', 'vienna - rest of austria', 'austria', '436602266725', '', NULL, NULL, NULL, '', NULL, 2, NULL),
(52, 'Rusty Bikes', 'Rusty Bikes', 'mariekebuijs@gmail.com', 'mariekebuijs@gmail.com', 'Marleen Vervoort, Marieke Buijs', 'Amsterdam', 'the netherlands', '31648357529', '31633695574', NULL, NULL, NULL, '', NULL, 2, NULL),
(53, 'Nuts''n Berries', 'Nuts''nBerries', 'hexemexe@web.de', 'hexemexe@web.de', 'Kathleen', 'Halle', 'Germany', '17648391108', '', NULL, NULL, NULL, '', NULL, 2, NULL),
(54, 'German National Team', 'Germany', 'heiko.karpowski@googlemail.com', 'heiko.karpowski@googlemail.com', 'Heiko Karpowski, Janne Lepthin', '', 'Germany', '1917681187476', '491757002822', NULL, NULL, NULL, '', NULL, 2, NULL),
(55, 'Robiram Project', 'Robiram', 'tloustik@gmail.com', 'julik8@gmail.com', 'Petra Moravkova, Julia Navratova', 'Bratislava', 'Slovakia', '421904566535', '421903172634', '421903363033', '421903227746', '447877749695', '', NULL, 2, NULL),
(56, 'Holland National Team', 'Holland', 'frisbeemeisje@gmail.com', 'frisbeemeisje@gmail.com', 'roelien', 'all over', 'nederland', '31648408847', '31649393448', '31614957591', '31644822275', '31614867760', '', NULL, 2, NULL),
(57, 'WAF', 'WAF', 'waf@wur.nl', 'pnmdejongh@gmail.com,  bramtebrake1@gmail.com', 'Niek', 'Wageningen', 'Netherlands', '31634317858', '31646036901', '31634449486', '31619054127', '31644591879', '', NULL, 2, NULL),
(58, 'Akka', 'Akka', 'akka@frisbee.se', 'hanna@frisbee.se', 'Hanna', 'Lund', 'Sweden', '46722768111', '46730292948', '393397456579', '33688947876', '393282926595', '', NULL, 2, NULL),
(59, 'Ireland National Team', 'Ireland', 'irelandmixed2011@gmail.com', 'peter.forde@gmail.com', 'Peter', 'Dublin', 'Ireland', '353857068828', '353857203563', '353861994086', '353879302429', '447833645624', '', NULL, 2, NULL),
(60, 'Turkey National Team', 'Turkey', 'ord-yk@googlegroups.com', 'demir.emra@gmail.com', 'Emrah Demir', 'Ä°stanbul - Ankara', 'Turkey', '905337107856', '905373843878', NULL, NULL, NULL, '', NULL, 2, NULL),
(61, 'Cranberry Snack', 'Cranberry', 'juleclech@gmail.com', 'klaatii@gmail.com', 'Klaus Walther', 'Karlsruhe', 'Germany', '491782331741', '491631622448', NULL, NULL, NULL, 'Hey Windmillers,\n\n\n\nwe did a mistake a registered us for the Open Division, but we''re naturally mixed. We want to be registered for the MIXED DIVISON!\n\n\n\nCould you please help us to switch the division.\n\nI''m so sorry, i tried to register us several times for open. I just dont realize that i need to register especialy for mixed ;)\n\nI hope you could unterstand my doing.\n\n\n\nPlease contact me if something goes wrong or ask Nan. He should know me now ;)\n\n\n\nMy contact is: klaatii@gmail.com  \n\n\n\nThank you so much, i will bring you a present for that!\n\n\n\nSee you all in june!\n\nKlaus - Cranberry Snack\n\n\n\n', NULL, 2, NULL),
(62, 'Frizzly Bears', 'Frizzly Bears', 'hanstiro@gmx.de', '', '', '', '', '', '', NULL, NULL, NULL, '', NULL, 2, NULL),
(63, 'Moscow Chapiteau', 'Moscow', 'moscowsharks@gmail.com', 'chernykh.ira@gmail.com', 'Alexey, Irina', 'Moscow', 'Russia', '79639785897', '79060639113', NULL, NULL, NULL, '', NULL, 2, NULL),
(64, 'Sexy Legs', 'Sexy Legs', '', 'liisa.licht@mail.ee', 'Liisa Licht', 'we''re an international team', 'mainly from Estonia', '37256218415', '37256563967', NULL, NULL, NULL, 'We''re an international team that played last year as "Tallinn Frisbee Club" in mixed division', NULL, 2, NULL),
(65, 'Frisbee Family', 'Frisbee Family', 'verena@frisbee-family.de', 'matthias@brucklacher.com', 'Doerthe, Mattes', 'Duesseldorf', 'Germany', '4917666631600', '491727071718', '491727058899', '4917620494927', NULL, '', NULL, 2, NULL),
(66, 'Switzerland National Team', 'Switzerland', 'international-coordinator@ultimate.ch', 'kian.rieben@gmail.com', 'Nef', 'Switzerland', 'Switzerland', '41763703078', '41765862927', NULL, NULL, NULL, '', NULL, 2, NULL),
(67, 'Drehst''n Deckel', 'Drehst''nDeckel', 'ulle@drehstn-deckel.de', 'kirvel@gmx.ch', 'Christian Kirvel', 'Dresden', 'Germany', '491785381277', '', NULL, NULL, NULL, '', NULL, 2, NULL),
(68, 'Aye-Aye Ultimate (UEA)', 'Aye-Aye', 'b.hutton@uea.ac.uk', 'b.hutton@uea.ac.uk', 'Ben Hutton', 'Norwich', 'England', '7595739460', '7840391708', NULL, NULL, NULL, 'We have already registered for the open division earlier this year. We have since decided that our team would be better suited to play in the mixed division. I will therefore be removing our open division bid after submitting this bid. Sorry for all the confusion, thanks.\n\n\n\nBen Hutton\n\nAye-Aye president', NULL, 2, NULL),
(69, 'Russo Turisto', 'Russia', 'av@rusultimate.org', 'shebouniaev@yandex.ru ', 'Toly', '', 'Russia', '79670919059', '79162117731', NULL, NULL, NULL, '', NULL, 2, NULL),
(70, 'BYE Team', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1),
(71, 'Chakalakas', 'Chakalakas', 'marysmile@gmx.de', 'esther.kunay@gmx.de', 'Esther', 'all over Germany', 'Germany', '491638826584', '4915787628464', NULL, NULL, NULL, '', NULL, 3, NULL),
(72, 'Hot Beaches', 'Hot Beaches', '', 'aja_sem@centrum.cz', 'aja, katy', 'Prague', 'Czech Republic', '420774858308', '420736286157', '420774114711', '420724119726', '420606133565', '', NULL, 3, NULL),
(73, 'France National Team', 'France', 'angodet@yahoo.fr', 'angodet@yahoo.fr', 'AL', 'Paris', 'France', '33679592052', '3383103015', NULL, NULL, NULL, 'The team will count around 23 players + 3 coachs.\n\nThanks !', NULL, 3, NULL),
(74, 'Denmark National Team', 'Denmark', 'administrator@dfsu.dk', 'elite@dfsu.dk', 'Taiyo JÃ¶nsson', 'Copenhagen', 'Denmark', '4522664242', '4526247090', '4523956204', '4530381084', '4551900103', 'The National Team of Denmark would like to apply for a spot in the Windmill Womens Division 2011.', NULL, 3, NULL),
(75, 'Ireland National Team', 'Ireland', 'ladiescaptain@gmail.com', 'ladiescaptain@gmail.com', 'Laura, Linda', 'Dublin', 'Ireland', '353833702663', '32498311237', NULL, NULL, NULL, '', NULL, 3, NULL),
(76, 'Seagulls', 'Seagulls', 'info@fischbees.de', 'Britta_Kipcke@web.de', 'Britta', 'Hamburg', 'Germany', '491708150105', '', NULL, NULL, NULL, '', NULL, 3, NULL),
(77, 'Italy National Team', 'Italy', 'Frixsven@gmail.com', 'Britneyz88@yahoo.it', 'Frida Svensson', '', 'Italy', '393287016841', '393289123854', '393395980966', NULL, NULL, '', NULL, 3, NULL),
(78, 'GB National Team', 'GB', 'jennat49@yahoo.co.uk', 'me01gmt@googlemail.com', 'Jenna Thomson', '', 'United Kingdom', '447590382152', '447976364407', '447855446423', '447950315532', '447843254472', '', NULL, 3, NULL),
(79, 'Thalys', 'Thalys', 'paulinette71@yahoo.fr', 'paulinette71@yahoo.fr', 'Pauline Vicard', 'Lille/Bruxelles', 'France/Belgium', '33683049712', '33609553008', NULL, NULL, NULL, '', NULL, 3, NULL),
(80, 'DNT National Team', 'Germany', 'oburch@web.de', 'oburch@web.de', 'Silke Oldenburg', 'all over Germany', 'Germany', '4917661265079', '4917661197134', NULL, NULL, NULL, '', NULL, 3, NULL),
(81, 'Switzerland National Team', 'Switzerland', 'vogel.simone@gmail.com', 'vogel.simone@gmail.com', 'Simone Vogel', 'Geneva', 'Switzerland', '41786735048', '41793500034', NULL, NULL, NULL, '', NULL, 3, NULL),
(82, 'Holland National Team', 'Holland', 'luzia.helfer@gmail.com', 'iris.terpstra@gmail.com', 'Iris', '', 'The Netherlands', '31625266393', '31626507460', '31648797084', '31641479141', NULL, '', NULL, 3, NULL),
(83, 'Russia National Team', 'Russia', 'astreya2004@yandex.ru', 'astreya2004@yandex.ru', 'Margarita', 'Moscow', 'Russian Federation', '79647962477', '37257309038', NULL, NULL, NULL, '', NULL, 3, NULL),
(84, 'BYE Team', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tournament`
--

CREATE TABLE IF NOT EXISTS `tournament` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `startdate` bigint(20) DEFAULT NULL,
  `enddate` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tournament`
--

INSERT INTO `tournament` (`id`, `title`, `state`, `startdate`, `enddate`) VALUES
(1, 'Windmill Windup 2011', 1, 1308261600, 1308434400);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user`
--


-- --------------------------------------------------------

--
-- Table structure for table `victory_points`
--

CREATE TABLE IF NOT EXISTS `victory_points` (
  `margin` int(11) NOT NULL DEFAULT '0',
  `victorypoints` int(11) DEFAULT NULL,
  PRIMARY KEY (`margin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `victory_points`
--

INSERT INTO `victory_points` (`margin`, `victorypoints`) VALUES
(-15, 0),
(-14, 1),
(-13, 2),
(-12, 3),
(-11, 4),
(-10, 5),
(-9, 6),
(-8, 7),
(-7, 8),
(-6, 9),
(-5, 10),
(-4, 11),
(-3, 12),
(-2, 13),
(-1, 14),
(0, 15),
(1, 16),
(2, 17),
(3, 18),
(4, 19),
(5, 20),
(6, 21),
(7, 22),
(8, 23),
(9, 24),
(10, 25),
(11, 25),
(12, 25),
(13, 25),
(14, 25),
(15, 25);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `division`
--
ALTER TABLE `division`
  ADD CONSTRAINT `division_tournament_id_tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `field`
--
ALTER TABLE `field`
  ADD CONSTRAINT `field_tournament_id_tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`id`);

--
-- Constraints for table `pool`
--
ALTER TABLE `pool`
  ADD CONSTRAINT `pool_pool_ruleset_id_pool_ruleset_id` FOREIGN KEY (`pool_ruleset_id`) REFERENCES `pool_ruleset` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pool_stage_id_stage_id` FOREIGN KEY (`stage_id`) REFERENCES `stage` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pool_move`
--
ALTER TABLE `pool_move`
  ADD CONSTRAINT `pool_move_pool_id_pool_id` FOREIGN KEY (`pool_id`) REFERENCES `pool` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pool_move_source_pool_id_pool_id` FOREIGN KEY (`source_pool_id`) REFERENCES `pool` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pool_ruleset`
--
ALTER TABLE `pool_ruleset`
  ADD CONSTRAINT `pool_ruleset_pool_strategy_id_pool_strategy_id` FOREIGN KEY (`pool_strategy_id`) REFERENCES `pool_strategy` (`id`);

--
-- Constraints for table `pool_team`
--
ALTER TABLE `pool_team`
  ADD CONSTRAINT `pool_team_pool_id_pool_id` FOREIGN KEY (`pool_id`) REFERENCES `pool` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pool_team_team_id_team_id` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `round`
--
ALTER TABLE `round`
  ADD CONSTRAINT `round_pool_id_pool_id` FOREIGN KEY (`pool_id`) REFERENCES `pool` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `round_match`
--
ALTER TABLE `round_match`
  ADD CONSTRAINT `round_match_away_team_id_team_id` FOREIGN KEY (`away_team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `round_match_field_id_field_id` FOREIGN KEY (`field_id`) REFERENCES `field` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `round_match_home_team_id_team_id` FOREIGN KEY (`home_team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `round_match_round_id_round_id` FOREIGN KEY (`round_id`) REFERENCES `round` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stage`
--
ALTER TABLE `stage`
  ADD CONSTRAINT `stage_division_id_division_id` FOREIGN KEY (`division_id`) REFERENCES `division` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `s_m_s`
--
ALTER TABLE `s_m_s`
  ADD CONSTRAINT `s_m_s_round_id_round_id` FOREIGN KEY (`round_id`) REFERENCES `round` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `s_m_s_team_id_team_id` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `s_m_s_tournament_id_tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_division_id_division_id` FOREIGN KEY (`division_id`) REFERENCES `division` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_tournament_id_tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`id`) ON DELETE CASCADE;
