-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 13, 2017 at 09:45 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ltz`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  `done_reading` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `fileid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `userip` varchar(15) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_size` int(30) NOT NULL DEFAULT '0',
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `downloaded` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL DEFAULT '0',
  `uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed` enum('1','0','-1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `userid`, `file_name`, `file_type`, `file_size`, `link`, `ip`, `downloaded`, `rating`, `uploaded`, `confirmed`) VALUES
(1, 0, '01.WebServices Part 1 - Introduction (concept).mp4', 'video', 0, '', '127.0.0.1', 0, 0, '2017-08-13 00:30:23', '-1'),
(2, 0, '10.jpg', 'image', 0, '', '127.0.0.1', 0, 0, '2017-08-13 00:31:16', '-1'),
(3, 0, '02 - Tera Mera Rishta-(MyMp3Singer.mp3', 'music', 0, '', '127.0.0.1', 0, 0, '2017-08-13 00:31:37', '1'),
(4, 0, 'Ubuntu Kylin Theme.deb', 'software', 0, '', '127.0.0.1', 0, 0, '2017-08-13 00:32:57', '1'),
(5, 0, 'git.deb', 'software', 0, '', '127.0.0.1', 0, 0, '2017-08-13 00:51:03', '-1'),
(6, 0, 'Web Development In 2017 - A Practical Guide - YouTube.MP4', 'video', 0, '', '127.0.0.1', 0, 0, '2017-08-13 00:51:31', '-1'),
(7, 0, 'Tamma Tamma Loge -  Thanedaar (Original) 320Kbps.mp3', 'music', 0, '', '127.0.0.1', 0, 0, '2017-08-13 00:52:01', '1'),
(8, 0, 'Afreen Afreen-(Mr-Jatt.com) (1).mp3', 'music', 0, '', '127.0.0.1', 0, 0, '2017-08-13 00:52:05', '-1'),
(9, 0, 'Dil Mein Sanam Ki Surat - Kumar Sanu 320Kbps.mp3', 'music', 0, '', '127.0.0.1', 0, 0, '2017-08-13 00:52:09', '-1'),
(10, 0, 'Ki Banu Duniya Da-(Mr-Jatt.com).mp3', 'music', 0, '', '127.0.0.1', 0, 0, '2017-08-13 00:52:13', '-1'),
(11, 0, 'Wafa-Ka-Kaisa-Sila-Diya-Female (SongsMp3.Com).mp3', 'music', 0, '', '127.0.0.1', 0, 0, '2017-08-13 01:24:26', '-1'),
(12, 0, 'The Chainsmokers - Closer (Lyric) ft. Halsey (320  kbps).mp3', 'music', 0, '', '127.0.0.1', 0, 0, '2017-08-13 01:36:11', '1'),
(13, 0, '02 Udja Re.mp3', 'music', 0, '', '127.0.0.1', 0, 0, '2017-08-13 01:50:35', '-1'),
(14, 0, 'Work from Home.mp3', 'music', 0, '', '127.0.0.1', 1, 0, '2017-08-13 07:42:10', '0'),
(15, 0, 'Tum Hi Ho.m4a', 'music', 0, '', '127.0.0.1', 0, 0, '2017-08-13 07:42:10', '0'),
(16, 0, 'love-you-like-a-love-song-selena-gomez-the-scene--1411570461.mp3', 'music', 0, '', '127.0.0.1', 0, 0, '2017-08-13 07:42:10', '0'),
(17, 0, 'Move Your Body.m4a', 'music', 0, '', '127.0.0.1', 0, 0, '2017-08-13 07:42:11', '0'),
(18, 0, 'Addicted - Enrique Iglesias.mp3', 'music', 10077816, '', '127.0.0.1', 0, 0, '2017-08-13 07:50:10', '1'),
(19, 0, 'Monster.mp3', 'music', 10103255, '', '127.0.0.1', 0, 0, '2017-08-13 07:50:10', '0'),
(20, 0, 'Ciara Dance Like We re Making Love (CDQ) .mp3', 'music', 10281816, '', '127.0.0.1', 0, 0, '2017-08-13 07:50:10', '-1'),
(21, 0, 'Mirrors_1.mp3', 'music', 10022286, '', '127.0.0.1', 0, 0, '2017-08-13 07:50:10', '0'),
(22, 0, 'Soch Hardy Sandhu.mp3', 'music', 9591676, '', '127.0.0.1', 0, 0, '2017-08-13 13:25:03', '0'),
(23, 0, 'Tu Zaroori.mp3', 'music', 11718781, '', '127.0.0.1', 0, 0, '2017-08-13 13:26:33', '0');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `fileid` int(11) NOT NULL,
  `ip` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `uploaded_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) DEFAULT 'Unnamed',
  `last_name` varchar(30) DEFAULT 'User',
  `username` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `premium` tinyint(1) NOT NULL DEFAULT '0',
  `restrict_download_speed` int(8) NOT NULL DEFAULT '500',
  `total_uploads` int(5) NOT NULL DEFAULT '0',
  `total_downloads` int(5) NOT NULL DEFAULT '0',
  `avatar` mediumblob,
  `last_ip` varchar(15) DEFAULT NULL,
  `locations` varchar(500) DEFAULT NULL,
  `is_logged_in` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1: Yes 0: No',
  `allow_access` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Allow 0: Block',
  `allow_download` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Allow 0: Block',
  `allow_upload` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Allow 0: Block',
  `no_of_login` int(11) NOT NULL DEFAULT '0',
  `no_of_files_uploaded` int(11) NOT NULL DEFAULT '0',
  `no_of_files_downloaded` int(11) NOT NULL DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `premium`, `restrict_download_speed`, `total_uploads`, `total_downloads`, `avatar`, `last_ip`, `locations`, `is_logged_in`, `allow_access`, `allow_download`, `allow_upload`, `no_of_login`, `no_of_files_uploaded`, `no_of_files_downloaded`, `verified`, `token`, `created_at`, `updated_at`) VALUES
(1, 'Sumeet', 'Dewangan', 'dewangan.sumeet700@gmail.com', 'Sumeet@1234', 0, 0, 0, 1, NULL, '127.0.0.1', NULL, 0, 1, 0, 1, 20, 0, 0, 0, '', '2017-08-10 15:29:01', '2017-08-10 15:29:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_upload_id` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `fk_upload_id` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
