-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 11:55 PM
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
-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS msu_tutor_connect;
USE msu_tutor_connect;

-- Create the user and assign privileges
CREATE USER IF NOT EXISTS 'msu_tutor_user'@'localhost' IDENTIFIED BY 'StrongPassword123!';
GRANT ALL PRIVILEGES ON msu_tutor_connect.* TO 'msu_tutor_user'@'localhost';
FLUSH PRIVILEGES;
-- --------------------------------------------------------

--
-- Table structure for table `tutoravailability`
--

CREATE TABLE `tutoravailability` (
  `id` int NOT NULL,
  `tutor_id` int DEFAULT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutoravailability`
--

INSERT INTO `tutoravailability` (`id`, `tutor_id`, `day_of_week`, `start_time`, `end_time`) VALUES
(41, 1, 'Monday', '09:00:00', '11:00:00'),
(42, 1, 'Wednesday', '14:00:00', '16:00:00'),
(43, 1, 'Friday', '10:00:00', '12:00:00'),
(44, 2, 'Tuesday', '13:00:00', '15:00:00'),
(45, 2, 'Thursday', '09:00:00', '11:00:00'),
(46, 3, 'Monday', '15:00:00', '17:00:00'),
(47, 3, 'Wednesday', '10:00:00', '12:00:00'),
(48, 3, 'Friday', '13:00:00', '15:00:00'),
(49, 4, 'Tuesday', '10:00:00', '12:00:00'),
(50, 4, 'Thursday', '14:00:00', '16:00:00'),
(51, 4, 'Saturday', '09:00:00', '11:00:00'),
(52, 5, 'Wednesday', '09:00:00', '11:00:00'),
(53, 5, 'Friday', '14:00:00', '16:00:00'),
(54, 6, 'Monday', '10:00:00', '12:00:00'),
(55, 6, 'Tuesday', '15:00:00', '17:00:00'),
(56, 6, 'Thursday', '13:00:00', '15:00:00'),
(57, 6, 'Saturday', '11:00:00', '13:00:00'),
(58, 7, 'Tuesday', '10:00:00', '12:00:00'),
(59, 7, 'Wednesday', '14:00:00', '16:00:00'),
(60, 7, 'Friday', '09:00:00', '11:00:00'),
(61, 8, 'Monday', '11:00:00', '13:00:00'),
(62, 8, 'Thursday', '14:00:00', '16:00:00'),
(63, 9, 'Tuesday', '13:00:00', '15:00:00'),
(64, 9, 'Wednesday', '09:00:00', '11:00:00'),
(65, 9, 'Friday', '15:00:00', '17:00:00'),
(66, 10, 'Monday', '10:00:00', '12:00:00'),
(67, 10, 'Thursday', '11:00:00', '13:00:00'),
(68, 10, 'Saturday', '14:00:00', '16:00:00'),
(70, 11, 'Monday', '10:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tutoring_requests`
--

CREATE TABLE `tutoring_requests` (
  `request_id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `tutor_id` int DEFAULT NULL,
  `subject` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('pending','accepted','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `submitted_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutoring_requests`
--

INSERT INTO `tutoring_requests` (`request_id`, `student_id`, `tutor_id`, `subject`, `message`, `status`, `submitted_at`) VALUES
(4, 2, 1, 'Math', 'Hi there, I want to have your tutoring.', 'rejected', '2025-05-04 23:30:37'),
(5, 2, 9, 'Eco', 'Tutoring on Monday.', 'accepted', '2025-05-04 23:31:05');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `tutor_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`tutor_id`, `name`, `subject`, `email`, `bio`, `created_at`, `image`) VALUES
(1, 'Alice Johnson', 'Mathematics', 'alice.johnson@example.com', 'Passionate math tutor with over 5 years of experience.', '2025-05-04 23:21:44', 'tutor.png'),
(2, 'Brian Smith', 'Physics', 'brian.smith@example.com', 'Physics enthusiast and high school tutor.', '2025-05-04 23:21:44', 'tutor.png'),
(3, 'Catherine Lee', 'English', 'catherine.lee@example.com', 'Loves teaching literature and creative writing.', '2025-05-04 23:21:44', 'tutor.png'),
(4, 'David Chen', 'Chemistry', 'david.chen@example.com', 'Chemistry graduate helping students understand complex reactions.', '2025-05-04 23:21:44', 'tutor.png'),
(5, 'Eva Thompson', 'Biology', 'eva.thompson@example.com', 'Biology tutor with a passion for genetics and ecology.', '2025-05-04 23:21:44', 'tutor.png'),
(6, 'Frank Miller', 'History', 'frank.miller@example.com', 'Helps students dive deep into world history and culture.', '2025-05-04 23:21:44', 'tutor.png'),
(7, 'Grace Kim', 'Computer Science', 'grace.kim@example.com', 'Teaches programming and algorithms in an easy-to-grasp manner.', '2025-05-04 23:21:44', 'tutor.png'),
(8, 'Hassan Ali', 'Geography', 'hassan.ali@example.com', 'Specializes in physical and human geography.', '2025-05-04 23:21:44', 'tutor.png'),
(9, 'Isabella Garcia', 'Economics', 'isabella.garcia@example.com', 'Economics tutor focusing on micro and macroeconomics.', '2025-05-04 23:21:44', 'tutor.png'),
(10, 'Jason Wright', 'French', 'jason.wright@example.com', 'Fluent French speaker and language tutor.', '2025-05-04 23:21:44', 'tutor.png'),
(11, 'Test Tutor Name', 'CSIT 355', 'tutor@gmail.com', 'HArdworking, focused.', '2025-05-04 23:29:07', 'tutor_6817b1f372c5f3.89564301.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('student','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'MSU Admin', 'admin@mtc.com', '$2y$10$9jjVpmh2xVB8JRKm33gXIOKd5k19SBbJSMBMCISw1t.7VEETgTkQG', 'admin', '2025-05-04 02:15:09'),
(2, 'Test User', 'test@gmail.com', '$2y$10$9jjVpmh2xVB8JRKm33gXIOKd5k19SBbJSMBMCISw1t.7VEETgTkQG', 'student', '2025-05-04 02:17:37');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tutoring_requests`
--
ALTER TABLE `tutoring_requests`
  MODIFY `request_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `tutor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
