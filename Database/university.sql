-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2022 at 03:56 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `userLevel` int(11) NOT NULL,
  `isConnected` tinyint(1) NOT NULL,
  `ref_id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL DEFAULT 'example@example.com'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `pass`, `userLevel`, `isConnected`, `ref_id`, `email`) VALUES
(1, 'Admin', 'Admin', 1, 0, 1, 'admin@admin.com'),
(33, 'Seif Ahmed', 'doctor', 2, 0, 28, 'Please Enter Your E-mail'),
(36, 'mohammed Atef', 'student', 3, 0, 27, 'Please Enter Your E-mail'),
(37, 'youssef', 'student', 3, 0, 28, 'Please Enter Your E-mail'),
(39, 'Atef Ewais', 'doctor', 2, 0, 30, 'Please Enter Your E-mail'),
(40, 'Sayed Ahmed', 'student', 3, 0, 29, 'Please Enter Your E-mail'),
(44, 'Mohammed', '123', 1, 1, 0, 'mo25atef@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `hours`) VALUES
(10, 'Cpp', 3),
(11, 'Math I', 12),
(12, 'English I', 7),
(13, 'Python', 8),
(15, 'physics I', 12),
(16, 'Calcuclus II', 8);

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE `degree` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `crs_id` int(11) NOT NULL,
  `degree` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`id`, `std_id`, `crs_id`, `degree`) VALUES
(37, 27, 13, 8),
(38, 27, 10, 3),
(39, 29, 10, 3),
(40, 29, 11, 12),
(41, 27, 16, 8);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `img` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `name`, `img`) VALUES
(28, 'Seif Ahmed', '159590850_478289969843864_6802992252304473817_n.jpg'),
(30, 'Atef Ewais', 'home-character-01.png');

-- --------------------------------------------------------

--
-- Table structure for table `drcourse`
--

CREATE TABLE `drcourse` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `drcourse`
--

INSERT INTO `drcourse` (`id`, `course_id`, `doctor_id`) VALUES
(19, 12, 30);

-- --------------------------------------------------------

--
-- Table structure for table `regestcourse`
--

CREATE TABLE `regestcourse` (
  `id` int(11) NOT NULL,
  `student_Id` int(11) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `accepted` int(1) NOT NULL DEFAULT 0,
  `doc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `regestcourse`
--

INSERT INTO `regestcourse` (`id`, `student_Id`, `course_id`, `accepted`, `doc_id`) VALUES
(53, 27, 10, 1, 28),
(54, 27, 13, 1, 28),
(55, 27, 16, 1, 28),
(59, 29, 10, 1, 30),
(60, 29, 11, 1, 30),
(61, 29, 12, 1, 30),
(62, 28, 12, 1, 28),
(63, 28, 13, 1, 28);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `img` varchar(250) NOT NULL,
  `advisor` int(11) NOT NULL,
  `grade` int(11) NOT NULL DEFAULT 0,
  `hours` int(11) NOT NULL DEFAULT 0,
  `gpa` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `level`, `img`, `advisor`, `grade`, `hours`, `gpa`) VALUES
(27, 'mohammed Atef', 1, 'WhatsApp Image 2021-03-11 at 4.36.47 PM.jpeg', 28, 19, 19, 4),
(28, 'youssef', 1, 'WhatsApp Image 2021-03-11 at 4.36.47 PM.jpeg', 28, 0, 15, 0),
(29, 'Sayed Ahmed', 1, 'favicon.png', 30, 15, 22, 2.7272727272727);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student.id` (`std_id`),
  ADD KEY `course.id` (`crs_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drcourse`
--
ALTER TABLE `drcourse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `regestcourse`
--
ALTER TABLE `regestcourse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_Id` (`student_Id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `Doctor.id` (`doc_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Advisor` (`advisor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `degree`
--
ALTER TABLE `degree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `drcourse`
--
ALTER TABLE `drcourse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `regestcourse`
--
ALTER TABLE `regestcourse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `degree`
--
ALTER TABLE `degree`
  ADD CONSTRAINT `degree_ibfk_1` FOREIGN KEY (`std_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `degree_ibfk_2` FOREIGN KEY (`crs_id`) REFERENCES `course` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `drcourse`
--
ALTER TABLE `drcourse`
  ADD CONSTRAINT `drcourse_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `drcourse_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);

--
-- Constraints for table `regestcourse`
--
ALTER TABLE `regestcourse`
  ADD CONSTRAINT `regestcourse_ibfk_1` FOREIGN KEY (`student_Id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `regestcourse_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
