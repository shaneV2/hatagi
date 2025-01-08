-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 12:43 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hatagi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `comment_text`, `date_created`) VALUES
(43, 64, 23, 'comment1', '2025-01-05 11:08:30'),
(44, 64, 23, 'idea from comment', '2025-01-05 11:08:57'),
(45, 64, 24, '*comment from other user*', '2025-01-05 11:09:50'),
(46, 66, 23, '*add item5*', '2025-01-05 11:13:25'),
(47, 65, 23, '*needs List4', '2025-01-05 11:13:42');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_description` varchar(255) NOT NULL,
  `post_list` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `post_description`, `post_list`, `date_created`) VALUES
(64, 23, 'Description Test 1', ', idea from comment, *comment from other user*', '2025-01-05 11:08:23'),
(65, 24, 'Description Test2', 'List1, List2, List3', '2025-01-05 11:10:29'),
(66, 25, 'Description Test3', 'Item1, Item2, Item3, Item4, *add item5*', '2025-01-05 11:11:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `date_created`) VALUES
(23, 'shane2001', 'shanearranguez@gmail.com', '$2y$10$4bD8Djh5kNtUYM1LWBxDwuLkohb8HbpxmyixQQMxlNOnEvkNeAW3i', '2025-01-05 19:01:58'),
(24, 'johndoe23', 'johndoe@gmail.com', '$2y$10$EzoRWVCpbatM6sfO42sXy.f8rCLPxMlYQ7.6sbZ3p0TCBalUqF0c2', '2025-01-05 19:03:35'),
(25, 'admin', 'admin6@gmail.com', '$2y$10$gMMOHZAyKZtezXeuzTjxae/z7lt9UwpohzGvPOF.U9xUCzKM.2bvy', '2025-01-05 19:10:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
