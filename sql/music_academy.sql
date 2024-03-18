-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 18, 2024 at 06:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music_academy`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_username`, `admin_password`, `admin_status`) VALUES
(1, 'sshyamm', 'shyam', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `age_groups`
--

CREATE TABLE `age_groups` (
  `age_group_id` int(11) NOT NULL,
  `age_group_name` varchar(255) NOT NULL,
  `age_group_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `age_groups`
--

INSERT INTO `age_groups` (`age_group_id`, `age_group_name`, `age_group_status`) VALUES
(1, '11-20', 'Active'),
(2, '21-30', 'Active'),
(3, '31-40', 'Active'),
(4, '6-10', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `state_parent_id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `city_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `state_parent_id`, `city_name`, `city_status`) VALUES
(1, 1, 'Coimbatore', 'Active'),
(2, 2, 'London', 'Active'),
(3, 3, 'Kochi', 'Active'),
(4, 4, 'Kuala Lampur', 'Active'),
(5, 5, 'Ipoh', 'Active'),
(6, 1, 'Chennai', 'Active'),
(7, 7, 'Jeffna', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `course_parent_id` int(11) NOT NULL,
  `user_parent_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `date_of_class` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `class_status` enum('Upcoming','Ongoing','Finished','Cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `course_parent_id`, `user_parent_id`, `start_time`, `end_time`, `date_of_class`, `created_at`, `updated_at`, `class_status`) VALUES
(21, 1, 5, '23:54:00', '23:55:00', '2024-03-13', '2024-03-17 11:54:46', '2024-03-17 11:54:46', 'Ongoing'),
(22, 2, 4, '23:54:00', '21:00:00', '2024-03-22', '2024-03-17 11:55:09', '2024-03-17 11:55:09', 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `class_rooms`
--

CREATE TABLE `class_rooms` (
  `class_room_id` int(11) NOT NULL,
  `class_parent_id` int(11) NOT NULL,
  `user_parent_id` int(11) NOT NULL,
  `attendance` enum('Present','Absent','Late') NOT NULL,
  `attendance_time` varchar(255) NOT NULL,
  `class_room_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_rooms`
--

INSERT INTO `class_rooms` (`class_room_id`, `class_parent_id`, `user_parent_id`, `attendance`, `attendance_time`, `class_room_status`) VALUES
(3, 21, 1, 'Absent', 'Absent', 'Active'),
(4, 22, 3, 'Present', '2024-03-17 17:43:09', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `country_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `country_status`) VALUES
(1, 'India', 'Active'),
(2, 'England', 'Active'),
(3, 'Malaysia', 'Active'),
(4, 'Sri Lanka', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_desc` longtext NOT NULL,
  `course_img` varchar(255) NOT NULL,
  `course_icon` varchar(255) NOT NULL,
  `course_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_desc`, `course_img`, `course_icon`, `course_status`) VALUES
(1, 'Violin', 'Violin', 'teach.png', 'shyam.png', 'Active'),
(2, 'Guitar', 'Guitar', '', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `interest_id` int(11) NOT NULL,
  `user_parent_id` int(11) DEFAULT NULL,
  `course_parent_id` int(11) DEFAULT NULL,
  `level_parent_id` int(11) DEFAULT NULL,
  `interest_date` date DEFAULT NULL,
  `interest_status` enum('Joined','New') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` (`interest_id`, `user_parent_id`, `course_parent_id`, `level_parent_id`, `interest_date`, `interest_status`) VALUES
(1, 2, 1, 1, '2024-02-09', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(255) NOT NULL,
  `level_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`level_id`, `level_name`, `level_status`) VALUES
(1, 'Beginner', 'Active'),
(2, 'Intermediate', 'Active'),
(3, 'Expert', 'Active'),
(6, 'Advanced', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state_id` int(11) NOT NULL,
  `country_parent_id` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL,
  `state_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `country_parent_id`, `state_name`, `state_status`) VALUES
(1, 1, 'Tamil Nadu', 'Active'),
(2, 2, 'South England', 'Active'),
(3, 1, 'Kerala', 'Active'),
(4, 3, 'Selangor', 'Active'),
(5, 3, 'Perak', 'Active'),
(7, 4, 'Colombo', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_parent_id` int(11) DEFAULT NULL,
  `phone_num` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `age_group_parent_id` int(11) DEFAULT NULL,
  `course_parent_id` int(11) DEFAULT NULL,
  `level_parent_id` int(11) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `blood_group` enum('A+','A-','B+','B-','O-','O+','AB+','AB-') DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pincode` varchar(11) DEFAULT NULL,
  `city_parent_id` int(11) DEFAULT NULL,
  `state_parent_id` int(11) DEFAULT NULL,
  `country_parent_id` int(11) DEFAULT NULL,
  `student_status` enum('Enquired','Active','Inactive') DEFAULT NULL,
  `joined_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_parent_id`, `phone_num`, `email`, `age_group_parent_id`, `course_parent_id`, `level_parent_id`, `emergency_contact`, `blood_group`, `address`, `pincode`, `city_parent_id`, `state_parent_id`, `country_parent_id`, `student_status`, `joined_date`) VALUES
(1, 1, '9188103943', 'shyam27sps@gmail.com', 1, 1, 1, '9447196749', 'B+', '54/2, BHARATHI PARK ROAD, SAI BABA COLONY , COIMBATORE - 641011', '641011', 1, 1, 1, 'Active', '2024-02-01'),
(3, 2, '8756545643', 'arun@gmail.com', 3, 1, 1, '8565667675', 'A-', '54/2, BHARATHI PARK ROAD, SAI BABA COLONY , COIMBATORE - 641011', '641012', 4, 4, 3, 'Active', '2024-02-15'),
(4, 3, '7564566673', 'suresh@gmail.com', 3, 1, 2, '7566667874', 'AB+', '54/2, BHARATHI PARK ROAD, SAI BABA COLONY , COIMBATORE - 641011', '641011', 6, 1, 1, 'Enquired', '2024-02-25'),
(36, 3, '7564566673', 'suresh@gmail.com', 3, 1, 2, '7566667874', 'AB+', '54/2, BHARATHI PARK ROAD, SAI BABA COLONY , COIMBATORE - 641011', '641011', 3, 3, 1, 'Active', '2024-02-29');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_title` varchar(255) NOT NULL,
  `task_desc` longtext NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `priority` enum('Critical','High','Moderate','Less') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `estimated_hours` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `task_status` enum('Active','Inactive','Completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_title`, `task_desc`, `assigned_to`, `assigned_by`, `deadline`, `priority`, `created_at`, `updated_at`, `estimated_hours`, `file_path`, `task_status`) VALUES
(1, 'Introduction To Guitar', 'Completion EOD', 2, 4, '2024-02-24', 'High', '2024-02-21 02:53:19', '2024-03-17 11:49:54', 5, '', 'Inactive'),
(9, 'Introduction To Guitar', '5', 3, 5, '2024-03-14', 'High', '2024-03-15 09:32:21', '2024-03-17 12:12:46', 4, '', 'Active'),
(10, 'Introduction To Violin', 'b', 1, 4, '2024-03-20', 'Critical', '2024-03-15 09:34:38', '2024-03-17 12:12:56', -1, '', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `user_parent_id` int(11) NOT NULL,
  `teacher_phone` varchar(255) DEFAULT NULL,
  `teacher_email` varchar(255) DEFAULT NULL,
  `teacher_address` varchar(255) DEFAULT NULL,
  `course_parent_id` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `teacher_exp` int(11) DEFAULT NULL,
  `contract_date` date DEFAULT NULL,
  `current_salary` int(11) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `teacher_status` enum('Active','Inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `user_parent_id`, `teacher_phone`, `teacher_email`, `teacher_address`, `course_parent_id`, `qualification`, `teacher_exp`, `contract_date`, `current_salary`, `join_date`, `teacher_status`) VALUES
(1, 4, '95675765675', 'teacher@gmail.com', '54/2, BHARATHI PARK ROAD, SAI BABA COLONY , COIMBATORE - 641011', '2', 'Music.tech', 2, '2025-02-22', 12000, '2024-02-24', 'Inactive'),
(4, 5, '975744675', 'jennie@gmail.com', '54/2, BHARATHI PARK ROAD, SAI BABA COLONY , COIMBATORE - 641011', '1', 'V.Tech', 5, '2024-03-31', 12000, '2024-03-17', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` enum('Student','Teacher') NOT NULL,
  `user_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_type`, `user_status`) VALUES
(1, 'Shyam', 'shy123', 'Student', 'Active'),
(2, 'Arun', 'arun123', 'Student', 'Active'),
(3, 'Suresh', 'sur123', 'Student', 'Active'),
(4, 'Ann', 'ann123', 'Teacher', 'Active'),
(5, 'Jennie', 'jenn123', 'Teacher', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `age_groups`
--
ALTER TABLE `age_groups`
  ADD PRIMARY KEY (`age_group_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `class_rooms`
--
ALTER TABLE `class_rooms`
  ADD PRIMARY KEY (`class_room_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`interest_id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `age_groups`
--
ALTER TABLE `age_groups`
  MODIFY `age_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `class_rooms`
--
ALTER TABLE `class_rooms`
  MODIFY `class_room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
