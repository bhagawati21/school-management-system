-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 06, 2021 at 10:02 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserId` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserId`, `Password`) VALUES
(1, 'admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Description` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `Title`, `Description`, `Date`) VALUES
(2, 'Exams', 'Exams is coming up soon, be prepared.', '2021-06-09 07:43:47'),
(5, 'Another Notification', 'This is a test notification', '2021-06-09 16:55:35'),
(6, 'Announcement regarding fee payments', 'All the students who have not submitted the fee of this year is being notified that this is last chance to pay your fee otherwise you will have to pay extra charges as penalty..', '2021-06-18 09:20:23');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Description` text NOT NULL,
  `ClassId` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Attachment` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `Title`, `Description`, `ClassId`, `Date`, `Attachment`) VALUES
(3, 'Test', 'This is a third test of assignment module.', 5, '2021-06-12 16:46:00', 'Examination_Enrollment.pdf'),
(7, 'holiday assignment', 'this is a test.', 5, '2021-06-18 16:59:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` int(11) NOT NULL,
  `AssignmentId` int(11) NOT NULL,
  `StudentId` int(11) NOT NULL,
  `ClassId` int(11) NOT NULL,
  `Comments` varchar(255) DEFAULT NULL,
  `Attachment` varchar(255) NOT NULL,
  `SubmissionTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignment_submissions`
--

INSERT INTO `assignment_submissions` (`id`, `AssignmentId`, `StudentId`, `ClassId`, `Comments`, `Attachment`, `SubmissionTime`) VALUES
(1, 3, 14, 5, 'This is a comment.', 'A.pdf', '2021-06-12 14:23:31'),
(2, 3, 15, 5, 'This is a another comment', 'BCA VI SEMESTER DATA.pdf', '2021-06-16 09:51:05'),
(3, 7, 14, 5, '', 'A.pdf', '2021-06-16 11:55:31');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `StudentId` int(11) NOT NULL,
  `SubjectId` int(11) NOT NULL,
  `ClassId` int(11) NOT NULL,
  `AttendanceDate` date NOT NULL,
  `Attendance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `StudentId`, `SubjectId`, `ClassId`, `AttendanceDate`, `Attendance`) VALUES
(43, 14, 33, 5, '2021-06-04', 0),
(44, 15, 33, 5, '2021-06-04', 1),
(45, 16, 33, 5, '2021-06-04', 0),
(46, 17, 33, 5, '2021-06-04', 1),
(47, 14, 34, 5, '2021-06-04', 0),
(48, 15, 34, 5, '2021-06-04', 1),
(49, 16, 34, 5, '2021-06-04', 0),
(50, 17, 34, 5, '2021-06-04', 1),
(51, 14, 36, 5, '2021-06-04', 0),
(52, 15, 36, 5, '2021-06-04', 1),
(53, 16, 36, 5, '2021-06-04', 0),
(54, 17, 36, 5, '2021-06-04', 1),
(63, 14, 32, 5, '2021-06-05', 0),
(64, 15, 32, 5, '2021-06-05', 1),
(65, 16, 32, 5, '2021-06-05', 0),
(66, 17, 32, 5, '2021-06-05', 1),
(67, 14, 32, 5, '2021-06-07', 0),
(68, 15, 32, 5, '2021-06-07', 1),
(69, 16, 32, 5, '2021-06-07', 0),
(70, 17, 32, 5, '2021-06-07', 1),
(71, 14, 35, 5, '2021-06-07', 1),
(72, 15, 35, 5, '2021-06-07', 1),
(73, 16, 35, 5, '2021-06-07', 0),
(74, 17, 35, 5, '2021-06-07', 1),
(75, 14, 32, 5, '2021-06-11', 0),
(76, 15, 32, 5, '2021-06-11', 1),
(77, 16, 32, 5, '2021-06-11', 0),
(78, 17, 32, 5, '2021-06-11', 1),
(83, 14, 32, 5, '2021-06-23', 1),
(84, 15, 32, 5, '2021-06-23', 1),
(85, 16, 32, 5, '2021-06-23', 1),
(86, 17, 32, 5, '2021-06-23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `ClassName` varchar(50) NOT NULL,
  `ClassNameNumeric` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `ClassName`, `ClassNameNumeric`) VALUES
(1, 'First', 1),
(2, 'Second', 2),
(3, 'Third', 3),
(4, 'Fourth', 4),
(5, 'Fifth', 5);

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `ClassId` int(11) NOT NULL,
  `Fees` varchar(255) NOT NULL,
  `Total` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `ClassId`, `Fees`, `Total`) VALUES
(16, 1, 'a:3:{s:12:\"One Time Fee\";i:5000;s:10:\"Sports Fee\";i:1000;s:9:\"Other Fee\";i:500;}', '6500.00'),
(17, 2, 'a:3:{s:12:\"One Time Fee\";i:5000;s:10:\"Sports Fee\";i:1200;s:9:\"Other Fee\";i:500;}', '6700.00'),
(18, 3, 'a:3:{s:12:\"One Time Fee\";i:5000;s:10:\"Sports Fee\";i:1200;s:9:\"Other Fee\";i:500;}', '6700.00'),
(19, 4, 'a:0:{}', '0.00'),
(20, 5, 'a:0:{}', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `ClassId` int(11) NOT NULL,
  `SubjectId` int(11) NOT NULL,
  `Attachment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `Title`, `Description`, `ClassId`, `SubjectId`, `Attachment`) VALUES
(3, 'Test', 'This is a test', 5, 32, 'BCA VI SEMESTER DATA.pdf'),
(5, 'Chapter 1-4', 'description goes here.', 5, 33, 'week1 project report.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `StudentId` int(11) NOT NULL,
  `ClassId` int(11) NOT NULL,
  `Amount` decimal(12,2) NOT NULL,
  `Outstanding` decimal(12,2) NOT NULL,
  `Remarks` varchar(255) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `StudentId`, `ClassId`, `Amount`, `Outstanding`, `Remarks`, `Date`) VALUES
(1, 19, 1, '6500.00', '0.00', 'Full fee Payment Recieved.', '2021-07-05 12:11:18'),
(3, 20, 2, '6500.00', '200.00', '', '2021-07-05 12:52:05'),
(4, 20, 2, '200.00', '0.00', 'Rest of payment received.', '2021-07-05 16:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `StudentId` int(11) NOT NULL,
  `ClassId` int(11) NOT NULL,
  `TotalObtainedHYE` int(11) NOT NULL,
  `TotalObtainedYE` int(11) NOT NULL,
  `TotalObtained` int(10) NOT NULL,
  `TotalMaximum` int(11) NOT NULL,
  `MarksAll` text NOT NULL,
  `Percent` decimal(5,2) NOT NULL,
  `Result` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `StudentId`, `ClassId`, `TotalObtainedHYE`, `TotalObtainedYE`, `TotalObtained`, `TotalMaximum`, `MarksAll`, `Percent`, `Result`) VALUES
(10, 19, 1, 205, 215, 420, 600, 'a:4:{i:0;a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}i:1;a:2:{i:0;a:3:{i:0;s:2:\"65\";i:1;s:2:\"50\";i:2;s:2:\"90\";}i:1;a:3:{i:0;s:1:\"B\";i:1;s:1:\"C\";i:2;s:2:\"A+\";}}i:2;a:2:{i:0;a:3:{i:0;s:2:\"70\";i:1;s:2:\"60\";i:2;s:2:\"85\";}i:1;a:3:{i:0;s:1:\"A\";i:1;s:1:\"B\";i:2;s:2:\"A+\";}}i:3;a:3:{i:0;i:135;i:1;i:110;i:2;i:175;}}', '70.00', 'Pass'),
(11, 20, 2, 78, 62, 140, 600, 'a:4:{i:0;a:3:{i:0;s:1:\"4\";i:1;s:1:\"5\";i:2;s:1:\"6\";}i:1;a:2:{i:0;a:3:{i:0;s:2:\"23\";i:1;s:2:\"30\";i:2;s:2:\"25\";}i:1;a:3:{i:0;s:1:\"F\";i:1;s:1:\"F\";i:2;s:1:\"F\";}}i:2;a:2:{i:0;a:3:{i:0;s:2:\"30\";i:1;s:2:\"23\";i:2;s:1:\"9\";}i:1;a:3:{i:0;s:1:\"F\";i:1;s:1:\"F\";i:2;s:1:\"F\";}}i:3;a:3:{i:0;i:53;i:1;i:53;i:2;i:34;}}', '23.33', 'Fail'),
(12, 18, 4, 395, 267, 662, 1000, 'a:4:{i:0;a:5:{i:0;s:2:\"27\";i:1;s:2:\"28\";i:2;s:2:\"29\";i:3;s:2:\"30\";i:4;s:2:\"31\";}i:1;a:2:{i:0;a:5:{i:0;s:2:\"96\";i:1;s:2:\"89\";i:2;s:2:\"78\";i:3;s:2:\"56\";i:4;s:2:\"76\";}i:1;a:5:{i:0;s:2:\"A+\";i:1;s:2:\"A+\";i:2;s:1:\"A\";i:3;s:1:\"C\";i:4;s:1:\"A\";}}i:2;a:2:{i:0;a:5:{i:0;s:2:\"47\";i:1;s:2:\"50\";i:2;s:2:\"70\";i:3;s:2:\"60\";i:4;s:2:\"40\";}i:1;a:5:{i:0;s:1:\"D\";i:1;s:1:\"C\";i:2;s:1:\"A\";i:3;s:1:\"B\";i:4;s:1:\"D\";}}i:3;a:5:{i:0;i:143;i:1;i:139;i:2;i:148;i:3;i:116;i:4;i:116;}}', '66.20', 'Pass'),
(13, 14, 5, 250, 250, 500, 1000, 'a:4:{i:0;a:5:{i:0;s:2:\"32\";i:1;s:2:\"33\";i:2;s:2:\"34\";i:3;s:2:\"35\";i:4;s:2:\"36\";}i:1;a:2:{i:0;a:5:{i:0;s:2:\"50\";i:1;s:2:\"50\";i:2;s:2:\"50\";i:3;s:2:\"50\";i:4;s:2:\"50\";}i:1;a:5:{i:0;s:1:\"C\";i:1;s:1:\"C\";i:2;s:1:\"C\";i:3;s:1:\"C\";i:4;s:1:\"C\";}}i:2;a:2:{i:0;a:5:{i:0;s:2:\"50\";i:1;s:2:\"50\";i:2;s:2:\"50\";i:3;s:2:\"50\";i:4;s:2:\"50\";}i:1;a:5:{i:0;s:1:\"C\";i:1;s:1:\"C\";i:2;s:1:\"C\";i:3;s:1:\"C\";i:4;s:1:\"C\";}}i:3;a:5:{i:0;i:100;i:1;i:100;i:2;i:100;i:3;i:100;i:4;i:100;}}', '50.00', 'Pass'),
(14, 15, 5, 375, 375, 750, 1000, 'a:4:{i:0;a:5:{i:0;s:2:\"32\";i:1;s:2:\"33\";i:2;s:2:\"34\";i:3;s:2:\"35\";i:4;s:2:\"36\";}i:1;a:2:{i:0;a:5:{i:0;s:2:\"75\";i:1;s:2:\"75\";i:2;s:2:\"75\";i:3;s:2:\"75\";i:4;s:2:\"75\";}i:1;a:5:{i:0;s:1:\"A\";i:1;s:1:\"A\";i:2;s:1:\"A\";i:3;s:1:\"A\";i:4;s:1:\"A\";}}i:2;a:2:{i:0;a:5:{i:0;s:2:\"75\";i:1;s:2:\"75\";i:2;s:2:\"75\";i:3;s:2:\"75\";i:4;s:2:\"75\";}i:1;a:5:{i:0;s:1:\"A\";i:1;s:1:\"A\";i:2;s:1:\"A\";i:3;s:1:\"A\";i:4;s:1:\"A\";}}i:3;a:5:{i:0;i:150;i:1;i:150;i:2;i:150;i:3;i:150;i:4;i:150;}}', '75.00', 'Pass');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `RollNumber` int(11) NOT NULL,
  `EnrollmentNumber` int(50) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `FatherName` varchar(200) NOT NULL,
  `MotherName` varchar(200) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `DOB` date NOT NULL,
  `Age` int(4) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `ParentPhoneNumber` varchar(20) NOT NULL,
  `ClassId` int(11) NOT NULL,
  `Photo` varchar(255) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ParentEmail` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `RollNumber`, `EnrollmentNumber`, `Name`, `FatherName`, `MotherName`, `Address`, `Email`, `DOB`, `Age`, `PhoneNumber`, `ParentPhoneNumber`, `ClassId`, `Photo`, `Gender`, `Password`, `ParentEmail`) VALUES
(14, 501, 1501, 'Naveet Agrawal', 'Bhagawati lal', 'Priya Agrawal', '2/389 Bapu bazar, Udaipur', 'naveet@gmail.com', '2001-02-15', 21, '9823948596', '9414703254', 5, 'Naveet Agrawal.jpg', 'Male', '123', 'Test@gmail.com'),
(15, 502, 1502, 'Kunal Jain', 'Rajesh Jain', 'Leena jain', '2/190 Jai Shree Colony, Udaipur', 'kunal0705@gmail.com', '2000-05-18', 20, '8440010584', '9602016942', 5, 'Kunal Jain.jpeg', 'Male', '123', 'Test@gmail.com'),
(16, 503, 1503, 'Priya Soni', 'Ganesh Soni', 'Lalita Devi', '1/150 Bapu Bazar, Udaipur', 'priya@gmail.com', '2001-12-19', 20, '9823948593', '9414703254', 5, 'Priya Soni.jpeg', 'Female', '123', 'Test@gmail.com'),
(17, 504, 1504, 'Abhilasha Sharma', 'Shekhar Sharma', 'Neha Sharma', '1/59 Hari Krishana Colony, udaipur', 'abhilasha@gmail.com', '2001-10-12', 19, '6375031022', '9999999999', 5, 'Abhilasha Sharma.jpeg', 'Female', '123', 'Test@gmail.com'),
(18, 401, 1401, 'Aditya Ranawat', 'Udai Lal Ranawat', 'Manu Ranawat', '1/149 pratap nagar, udaipur', 'aditya@gmail.com', '2000-03-29', 21, '9854394583', '8754532345', 4, 'Aditya Ranawat.jpeg', 'Male', '123', 'Test@gmail.com'),
(19, 101, 1101, 'Manisha Bagwan', 'Kailash Bagwan', 'Lalita Bagwan', '1/250 meera nagar, Udaipur', 'manisha@gmail.com', '2001-04-12', 19, '9843535968', '8794848399', 1, 'Manisha Bagwan.jpg', 'Female', '123', 'Test@gmail.com'),
(20, 201, 1201, 'Navneet Sharma', 'Jignesh Sharma', 'Aasha Sharma', '2/130 meera nagar, Udaipur', 'naveet@gmail.com', '2000-12-20', 22, '9823968583', '8794648379', 2, 'Navneet Sharma.jpeg', 'Male', '123', 'Test@gmail.com'),
(21, 301, 1301, 'Pooja Mali', 'Pappu mali', 'Sunita Devi', '2/130 Panch Vihar Colony, Udaipur', 'pooja123@gmail.com', '2001-10-25', 20, '8435458834', '8534357453', 3, 'Pooja Mali.jpg', 'Female', '123', 'Test@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `SubjectCode` varchar(50) NOT NULL,
  `SubjectName` varchar(150) NOT NULL,
  `ClassId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `SubjectCode`, `SubjectName`, `ClassId`) VALUES
(1, 'HI01', 'Hindi', 1),
(2, 'MT01', 'Mathematics', 1),
(3, 'E01', 'English', 1),
(4, 'HI02', 'Hindi', 2),
(5, 'MT02', 'Mathematics', 2),
(6, 'E02', 'English', 2),
(7, 'HI03', 'Hindi', 3),
(8, 'MT03', 'Mathematics', 3),
(25, 'E03', 'English', 3),
(26, 'SC03', 'Science', 3),
(27, 'HI04', 'Hindi', 4),
(28, 'MT04', 'Mathematics', 4),
(29, 'E04', 'English', 4),
(30, 'SC04', 'Science', 4),
(31, 'SS04', 'Social Science', 4),
(32, 'HI05', 'Hindi', 5),
(33, 'MT05', 'Mathematics', 5),
(34, 'E05', 'English', 5),
(35, 'SC05', 'Science', 5),
(36, 'SS05', 'Social Science', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ClassId` (`ClassId`);

--
-- Indexes for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `AssignmentId` (`AssignmentId`),
  ADD KEY `assignment_submissions_ibfk_2` (`ClassId`),
  ADD KEY `assignment_submissions_ibfk_3` (`StudentId`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ClassId` (`ClassId`),
  ADD KEY `SubjectId` (`SubjectId`),
  ADD KEY `StudentId` (`StudentId`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fees_ibfk_1` (`ClassId`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ClassId` (`ClassId`),
  ADD KEY `SubjectId` (`SubjectId`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ClassId` (`ClassId`),
  ADD KEY `StudentId` (`StudentId`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `results_ibfk_2` (`ClassId`),
  ADD KEY `results_ibfk_3` (`StudentId`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_ibfk_1` (`ClassId`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_ibfk_1` (`ClassId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`ClassId`) REFERENCES `classes` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD CONSTRAINT `assignment_submissions_ibfk_1` FOREIGN KEY (`AssignmentId`) REFERENCES `assignments` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `assignment_submissions_ibfk_2` FOREIGN KEY (`ClassId`) REFERENCES `classes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `assignment_submissions_ibfk_3` FOREIGN KEY (`StudentId`) REFERENCES `students` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`ClassId`) REFERENCES `classes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`SubjectId`) REFERENCES `subjects` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`StudentId`) REFERENCES `students` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fees_ibfk_1` FOREIGN KEY (`ClassId`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`ClassId`) REFERENCES `classes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`SubjectId`) REFERENCES `subjects` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`ClassId`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`StudentId`) REFERENCES `students` (`id`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`ClassId`) REFERENCES `classes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `results_ibfk_3` FOREIGN KEY (`StudentId`) REFERENCES `students` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`ClassId`) REFERENCES `classes` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`ClassId`) REFERENCES `classes` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
