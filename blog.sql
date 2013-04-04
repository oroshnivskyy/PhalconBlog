-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 04, 2013 at 11:39 PM
-- Server version: 5.5.30
-- PHP Version: 5.4.13-2~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `users_id` int(10) unsigned NOT NULL,
  `posts_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_fk` (`posts_id`),
  KEY `users_fk` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `created`, `users_id`, `posts_id`) VALUES
(1, 'xcz', '2013-04-04 23:07:49', 1, 1),
(2, 'ascas', '2013-04-04 23:10:29', 1, 1),
(3, 'dsfds', '2013-04-04 23:11:08', 1, 1),
(4, 'sadasdas', '2013-04-04 23:11:45', 1, 1),
(5, 'sadasdas', '2013-04-04 23:11:55', 1, 1),
(6, 'sadasdas', '2013-04-04 23:15:04', 1, 1),
(7, 'sadasdas', '2013-04-04 23:18:24', 1, 1),
(8, 'dsds', '2013-04-04 23:19:10', 1, 1),
(9, 'dsds', '2013-04-04 23:19:50', 1, 1),
(10, 'czzxczx', '2013-04-04 23:31:14', 1, 16),
(11, 'czzxczxczxc', '2013-04-04 23:31:17', 1, 16),
(12, 'czzxczxczxcczxczx', '2013-04-04 23:31:23', 1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `users_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_users` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `created`, `users_id`) VALUES
(1, 'My first post', 'my-first-post', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor\r\n                        invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam\r\n                        et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est\r\n                        Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed\r\n                        diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam\r\n                        voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd\r\n                        gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', '2012-07-21 12:36:39', 4),
(16, 'wdwqdqw', 'dqwdqw', 'dqwdqw', '2013-04-04 21:02:58', 1),
(18, 'dfdsf', 'dsfdsf', 'dsfdsfds', '2013-04-04 21:22:33', 1),
(19, 'dwqdqwd', 'qwdqw', 'dqwdqw', '2013-04-04 21:28:55', 1),
(20, 'dsdsd', 'sdsd', 'sdsds', '2013-04-04 21:31:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `password` char(40) NOT NULL,
  `salt` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `salt`) VALUES
(1, 'admin', '09a8837143f46a3b9c5a640c6a4b26230c68818d', '4c2f107eb2'),
(4, 'oleh', '676e15fd4ffb960e499c2492512556643cd1d932', '61bdaae2af'),
(18, 'admin1', 'ccad1e48a2dfd14a612e46afcd31c1a55d304cd7', '24d6da76fd'),
(19, 'ttt', '87e46e1c2e471cb4a6b06a549529ed100ee47b5e', 'af5983dc47');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
