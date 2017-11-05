-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 05, 2017 at 02:49 PM
-- Server version: 5.6.37
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ignoucal_tutor`
--
CREATE DATABASE IF NOT EXISTS `ignoucal_tutor` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ignoucal_tutor`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `wrong_logins` int(2) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `area_id` int(11) NOT NULL,
  `area_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area_id`, `area_name`) VALUES
(1, 'Aashiana'),
(2, 'Adarsh Nagar'),
(3, 'Ahmamau'),
(4, 'Aishbagh'),
(5, 'Alambagh'),
(6, 'Alamnagar'),
(7, 'Aliganj'),
(8, 'Amar Shaheed Path'),
(9, 'Amausi'),
(10, 'Amber Ganj '),
(11, 'Anand Nagar '),
(12, 'AP Sen Marg '),
(13, 'Arjunganj'),
(14, 'Arya Nagar'),
(15, 'Ashiyana Colony '),
(16, 'Ashok Marg'),
(17, 'Balaganj '),
(18, 'Banthra '),
(19, 'Barha'),
(20, 'Behta Saboli'),
(21, 'Bhadrukh'),
(22, 'Bharat Nagar '),
(23, 'Bijnaur'),
(24, 'Chand Ganj'),
(25, 'Charbagh '),
(26, 'Chaupatiyan'),
(27, 'Chinhat '),
(28, 'Civil Lines '),
(29, 'Dalibagh Colony '),
(30, 'Daliganj'),
(31, 'Darulshafa '),
(32, 'Deva Road '),
(33, 'Dilkusha Garden '),
(34, 'DLF Garden City '),
(35, 'Faizabad Road '),
(36, 'Ganesh Ganj'),
(37, 'Gari Chunauti '),
(38, 'Ghaila'),
(39, 'Ghazipur'),
(40, 'Goila'),
(41, 'Gokhale Marg '),
(42, 'Gomti Nagar '),
(43, 'Gudamba Thaana Road'),
(44, 'Guramba'),
(45, 'HAL'),
(46, 'Hazratganj '),
(47, 'Husainabad'),
(48, 'Hussainganj'),
(49, 'IIM Road '),
(50, 'Indira Nagar '),
(51, 'Jal Vayu Vihar '),
(52, 'Jankipuram '),
(53, 'Jopling Road '),
(54, 'Jugor'),
(55, 'Kalyanpur '),
(56, 'Kamalabad Barhauli'),
(57, 'Kanpur Road '),
(58, 'Kuroni'),
(59, 'Kursi Road '),
(60, 'Lalbagh'),
(61, 'Lucknow Cantonment'),
(62, 'Madion '),
(63, 'Mahanagar '),
(64, 'Mahipatmau'),
(65, 'Malesemau'),
(66, 'Manak Nagar '),
(67, 'Manas Nagar'),
(68, 'Maunda'),
(69, 'Miranpur Pinvat'),
(70, 'Mohan Meking Road '),
(71, 'Narayan Nagar '),
(72, 'Natkur'),
(73, 'Naubasta'),
(74, 'Naveen Galla Mandi '),
(75, 'Navi Kot Nandana'),
(76, 'New Ganeshganj'),
(77, 'New Hyderabad '),
(78, 'Nijampur Malhor'),
(79, 'Nilmatha'),
(80, 'Nirala Nagar '),
(81, 'Nirala Nagar '),
(82, 'Nishatganj '),
(83, 'Paikaramau'),
(84, 'Pan Dariba Marg '),
(85, 'Park Road '),
(86, 'Pawanpuri'),
(87, 'Piparsand'),
(88, 'Prag Narain Road '),
(89, 'Rae Bareli Road'),
(90, 'Rahim Nagar'),
(91, 'Rajajipuram '),
(92, 'Rajendra Nagar '),
(93, 'Ram Mohan Rai Marg '),
(94, 'Rasoolpur Sadat'),
(95, 'Ruchi Khand-II '),
(96, 'Saadatganj '),
(97, 'Sadrauna'),
(98, 'Sapru Marg '),
(99, 'Sarai Mali Khan'),
(100, 'Sarojini Nagar'),
(101, 'Sarosa Bharosa'),
(102, 'Sarvodaya Nagar '),
(103, 'Sector-14'),
(104, 'Sector-18'),
(105, 'Sector-B'),
(106, 'Sector-D'),
(107, 'Shahnajaf Road '),
(108, 'Sharda Nagar '),
(109, 'Shyam Vihar Colony'),
(110, 'Sikrauri'),
(111, 'Singar Nagar'),
(112, 'Subhash Marg'),
(113, 'Sujanpura'),
(114, 'Sunder Bagh'),
(115, 'Sushant Golf City '),
(116, 'Telibagh '),
(117, 'Thakurganj '),
(118, 'The Mall Avenue '),
(119, 'Tilak Marg '),
(120, 'Triveni Nagar '),
(121, 'Uattardhona'),
(122, 'Utrathia'),
(123, 'vasant kunj '),
(124, 'Vibhuti Khand '),
(125, 'Vikas Nagar '),
(126, 'Vineet Khand'),
(127, 'VIP Road '),
(128, 'Vishesh Khand '),
(129, 'Vivekanand puri '),
(130, 'Vrindavan Yojana '),
(131, 'Wazirganj'),
(132, 'Yahiaganj');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`) VALUES
(1, 'Nursery'),
(2, 'KG'),
(3, 'First'),
(4, 'Second'),
(5, 'Third'),
(6, 'Fourth'),
(7, 'Fifth'),
(8, 'Sixth'),
(9, 'Seventh'),
(10, 'Eighth'),
(11, 'Ninth'),
(12, 'Tenth'),
(13, 'Eleventh'),
(14, 'Twelfth');

-- --------------------------------------------------------

--
-- Table structure for table `class_subject`
--

CREATE TABLE `class_subject` (
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_subject`
--

INSERT INTO `class_subject` (`class_id`, `subject_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(3, 4),
(3, 8),
(4, 1),
(4, 4),
(4, 8),
(5, 1),
(5, 4),
(5, 8),
(6, 1),
(6, 4),
(6, 8),
(7, 1),
(7, 4),
(7, 8),
(8, 1),
(8, 4),
(8, 6),
(8, 8),
(9, 1),
(9, 4),
(9, 6),
(9, 8),
(10, 1),
(10, 4),
(10, 6),
(10, 8),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 5),
(11, 6),
(11, 7),
(11, 8),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(12, 6),
(12, 7),
(12, 8),
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(13, 6),
(13, 7),
(13, 8),
(13, 9),
(14, 2),
(14, 3),
(14, 4),
(14, 5),
(14, 6),
(14, 7),
(14, 8),
(14, 9),
(10, 10),
(10, 11),
(10, 12),
(11, 10),
(11, 11),
(11, 12),
(12, 10),
(12, 11),
(12, 12),
(13, 10),
(13, 11),
(13, 12),
(14, 10),
(14, 11),
(14, 12);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `topic` varchar(50) NOT NULL,
  `message` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `job_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `guardian` varchar(255) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `salary` int(5) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `job_applied`
--

CREATE TABLE `job_applied` (
  `job_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`) VALUES
(1, 'All Subjects'),
(2, 'PCM'),
(3, 'PCB'),
(4, 'Maths'),
(5, 'Accountancy'),
(6, 'Computers'),
(7, 'Economics'),
(8, 'English'),
(9, 'Other'),
(10, 'Physics'),
(11, 'Chemistry'),
(12, 'Biology');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_area`
--

CREATE TABLE `teacher_area` (
  `user_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_class_subject`
--

CREATE TABLE `teacher_class_subject` (
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(9) NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `wrong_logins` int(9) NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_role` int(1) NOT NULL DEFAULT '1',
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `confirm_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `contact` varchar(10) DEFAULT NULL,
  `bio` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `salary` int(5) NOT NULL,
  `experience` int(2) NOT NULL,
  `qualification` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `class_subject`
--
ALTER TABLE `class_subject`
  ADD KEY `class_id` (`class_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `job_applied`
--
ALTER TABLE `job_applied`
  ADD KEY `job_id` (`job_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teacher_area`
--
ALTER TABLE `teacher_area`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `area_id` (`area_id`);

--
-- Indexes for table `teacher_class_subject`
--
ALTER TABLE `teacher_class_subject`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_subject`
--
ALTER TABLE `class_subject`
  ADD CONSTRAINT `class_subject_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `class_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);

--
-- Constraints for table `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `job_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`),
  ADD CONSTRAINT `job_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `job_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `job_ibfk_4` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `job_applied`
--
ALTER TABLE `job_applied`
  ADD CONSTRAINT `job_applied_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job` (`job_id`),
  ADD CONSTRAINT `job_applied_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `teacher_area`
--
ALTER TABLE `teacher_area`
  ADD CONSTRAINT `teacher_area_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `teacher_area_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`);

--
-- Constraints for table `teacher_class_subject`
--
ALTER TABLE `teacher_class_subject`
  ADD CONSTRAINT `teacher_class_subject_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `teacher_class_subject_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `teacher_class_subject_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
