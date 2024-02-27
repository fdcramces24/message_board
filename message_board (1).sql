-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 27, 2024 at 10:55 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `message_board`
--

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE `connections` (
  `id` int(11) NOT NULL,
  `name` char(1) NOT NULL DEFAULT '_',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `connections`
--

INSERT INTO `connections` (`id`, `name`, `created_at`) VALUES
(1, '_', '2024-02-27 11:49:17'),
(2, '_', '2024-02-27 11:50:18'),
(3, '_', '2024-02-27 11:57:23'),
(4, '_', '2024-02-27 15:09:20'),
(5, '_', '2024-02-27 15:20:07');

-- --------------------------------------------------------

--
-- Table structure for table `connection_members`
--

CREATE TABLE `connection_members` (
  `id` int(11) NOT NULL,
  `connection_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `connection_members`
--

INSERT INTO `connection_members` (`id`, `connection_id`, `user_id`) VALUES
(1, 2, 2),
(2, 2, 1),
(3, 3, 3),
(4, 3, 2),
(5, 4, 1),
(6, 4, 3),
(7, 5, 4),
(8, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `connection_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `connection_id`, `user_id`, `content`, `created_at`) VALUES
(1, 2, 2, 'asdfasfasdf', '2024-02-27 11:50:18'),
(2, 3, 3, 'asdfasdfasf', '2024-02-27 11:57:23'),
(3, 2, 1, 'asdfasdf', '2024-02-27 13:11:30'),
(4, 2, 1, 'asdfasdfasdfasdfasdf', '2024-02-27 13:30:49'),
(5, 4, 1, 'asdfasdfasdf', '2024-02-27 15:09:20'),
(6, 3, 2, 'asdfasdfasfd', '2024-02-27 15:10:11'),
(7, 5, 4, 'testtttt', '2024-02-27 15:20:08'),
(8, 4, 1, 'Sure oyssssss', '2024-02-27 16:36:56'),
(9, 5, 4, 'Hi', '2024-02-27 16:37:32'),
(10, 5, 4, 'wew', '2024-02-27 16:37:44'),
(11, 5, 1, 'wew sad', '2024-02-27 16:37:49'),
(12, 2, 1, 'sdfsfsdfsdf', '2024-02-27 17:28:58'),
(13, 2, 1, 'aaaaaaa', '2024-02-27 17:29:01'),
(14, 2, 2, 'asdfasdfasdfasdfasdf', '2024-02-27 17:33:34'),
(15, 2, 1, 'aaasdfasf', '2024-02-27 17:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` tinyint(4) DEFAULT NULL COMMENT '1 is for male, 2 is for female',
  `hubby` text DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `profile_photo` varchar(100) DEFAULT NULL,
  `last_logged_in` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `gender`, `hubby`, `birthdate`, `profile_photo`, `last_logged_in`, `created_at`, `updated_at`) VALUES
(1, 'Ramces Basubasss', 'ramcesbasubas@gmail.com', '$2a$10$MWtEWpfMhBApgp3JYI2BzejJ3Ph5W.NdffWPKKXP5ozbAHOoH9l.C', 1, 'sdadasdasdfasdf', '1995-07-24 00:00:00', '', '2024-02-27 10:16:03', '2024-02-27 11:42:01', '2024-02-27 10:16:03'),
(2, 'Ada Margarette', 'ada@gmail.com', '$2a$10$ticuLiMpMIc21VcrjEuFuOvU7rSJnZ0oNlOydlkvwrGG31L42acVm', NULL, NULL, NULL, NULL, '2024-02-27 10:32:14', '2024-02-27 11:48:58', '2024-02-27 10:32:14'),
(3, 'Genneva', 'gen@gmail.com', '$2a$10$ZRwfmLgzsZvD9SfRbSFBEOHSJB2g/OUVyTWKGU3E9Sv6dUw.ONcxq', NULL, NULL, NULL, NULL, '2024-02-27 04:57:02', '2024-02-27 11:57:02', '2024-02-27 04:57:02'),
(4, 'Khael Basubas', 'khael@gmail.com', '$2a$10$pheiCEHHJapuue4vLwB4guCm8WzESFIWUxKaRdG7m.SrQRVU67zjq', NULL, NULL, NULL, NULL, '2024-02-27 08:18:47', '2024-02-27 15:18:47', '2024-02-27 08:18:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `connection_members`
--
ALTER TABLE `connection_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `connections`
--
ALTER TABLE `connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `connection_members`
--
ALTER TABLE `connection_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
