-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 06:25 PM
-- Server version: 8.0.39
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `msu_tutor_connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `tutoravailability`
--

CREATE TABLE `tutoravailability` (
  `id` int NOT NULL,
  `tutor_id` int DEFAULT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutoravailability`
--

INSERT INTO `tutoravailability` (`id`, `tutor_id`, `day_of_week`, `start_time`, `end_time`) VALUES
(1, 1, 'Monday', '18:00:00', '20:30:00'),
(2, 1, 'Tuesday', '14:00:00', '16:00:00'),
(3, 1, 'Wednesday', '00:00:00', '00:00:00'),
(4, 1, 'Thursday', '00:00:00', '00:00:00'),
(5, 1, 'Friday', '00:00:00', '00:00:00'),
(6, 1, 'Saturday', '00:00:00', '00:00:00'),
(7, 1, 'Sunday', '00:00:00', '00:00:00'),
(15, 3, 'Monday', '05:06:00', '05:08:00'),
(16, 3, 'Tuesday', '00:00:00', '00:00:00'),
(17, 3, 'Wednesday', '00:00:00', '00:00:00'),
(18, 3, 'Thursday', '00:00:00', '00:00:00'),
(19, 3, 'Friday', '00:00:00', '00:00:00'),
(20, 3, 'Saturday', '00:00:00', '00:00:00'),
(21, 3, 'Sunday', '00:00:00', '00:00:00'),
(31, 4, 'Monday', '22:11:00', '12:11:00'),
(32, 4, 'Tuesday', '00:00:00', '12:11:00'),
(33, 4, 'Wednesday', NULL, '21:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `tutoring_requests`
--

CREATE TABLE `tutoring_requests` (
  `request_id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `tutor_id` int DEFAULT NULL,
  `subject` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('pending','accepted','rejected') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `submitted_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `tutor_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `bio` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`tutor_id`, `name`, `subject`, `email`, `bio`, `created_at`, `image`) VALUES
(1, 'Test User', 'AHwe', 'anas14529@gmail.com', 'adasd', '2025-05-04 05:04:45', NULL),
(3, 'Test User', 'Test HTML Email', 'f4futuretech@gmail.com', 'asdsa', '2025-05-04 05:06:38', 'tutor_6816af8e82cb30.32199293.jpg'),
(4, 'Test User1', 'AHwe1', 'aaaa@gmail.com1', 'adasda111', '2025-05-04 21:11:33', 'tutor_681792a34bf3f0.38008011.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('student','admin') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'MSU Admin', 'admin@mtc.com', '$2y$10$9jjVpmh2xVB8JRKm33gXIOKd5k19SBbJSMBMCISw1t.7VEETgTkQG', 'admin', '2025-05-04 02:15:09'),
(2, 'Test User', 'abc@xyz.com', '$2y$10$9jjVpmh2xVB8JRKm33gXIOKd5k19SBbJSMBMCISw1t.7VEETgTkQG', 'student', '2025-05-04 02:17:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tutoravailability`
--
ALTER TABLE `tutoravailability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `tutoring_requests`
--
ALTER TABLE `tutoring_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`tutor_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tutoravailability`
--
ALTER TABLE `tutoravailability`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tutoring_requests`
--
ALTER TABLE `tutoring_requests`
  MODIFY `request_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `tutor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tutoravailability`
--
ALTER TABLE `tutoravailability`
  ADD CONSTRAINT `tutoravailability_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`) ON DELETE CASCADE;

--
-- Constraints for table `tutoring_requests`
--
ALTER TABLE `tutoring_requests`
  ADD CONSTRAINT `tutoring_requests_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tutoring_requests_ibfk_2` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
