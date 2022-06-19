-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2021 at 04:46 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exceptional`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `admin_mail` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilePic` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `admin_mail`, `password`, `profilePic`, `type`) VALUES
(1, 'Chaudhry Faheem Irfan', 'abc@gmail.com', '6fda7c0b9ba6148a2191ed93d1da83eb', '1625228653.jpg', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `postContent` text NOT NULL,
  `postDate` varchar(20) NOT NULL,
  `admin` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` text NOT NULL,
  `post` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `postContent`, `postDate`, `admin`, `title`, `status`, `post`) VALUES
(1, '', 'July 02, 2021', 1, 'Website Project in Hindi/Urdu |Using HTML,CSS,Bootstrap,JQuery Ajax,PHP and MySQL Part 1', 'video', 'byLpnGbt3eY');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `categorie` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categorie`) VALUES
(1, 'Computer Science');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `courseId` int(11) NOT NULL,
  `lectureName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `content`, `courseId`, `lectureName`) VALUES
(1, '<p style=\"text-align:center\">&nbsp;</p>\r\n\r\n<p><iframe frameborder=\"0\" height=\"315\" scrolling=\"no\" src=\"https://www.youtube.com/embed/nDAjmLcyiIc\" title=\"YouTube video player\" width=\"560\"></iframe></p>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:24px\"><span style=\"color:#4e5f70\">Student Registration System Login Panel Part 1</span></span></p>\r\n\r\n<p>Student Management System | Student Registration System in Java Complete Project Complete student registration system. In this project you will learn how to create a project in short time period. How to insert, retrieve, delete, update and search data in java. How to make connection with SQL XAMPP in java? Facebook: https://www.facebook.com/ExceptionalProgrammers/</p>\r\n', 1, 'Student registration system  Login Panel Part One');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `cover` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `categorieId` int(11) NOT NULL,
  `instructorId` int(11) NOT NULL,
  `bookId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `cover`, `description`, `categorieId`, `instructorId`, `bookId`) VALUES
(1, 'Student Registration System', '1625122793.png', 'Student Management System | Student Registration System in Java Complete Project\r\n\r\nComplete student registration system. In this project you will learn how to create a project in short time period. How to insert, retrieve, delete, update and search data in java. How to make connection with SQL XAMPP in java?', 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `categorieId` int(11) NOT NULL,
  `description` text NOT NULL,
  `book` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`id`, `name`, `categorieId`, `description`, `book`, `image`) VALUES
(2, 'Exceptional Programmers Projects', 1, 'We are a group of exceptional programmers, our aim is to promote programming. \r\nIf you are a programmer then contact us to secure your future.', '1625230555.pdf', '1625230555.png');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `image` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `mail`, `phone`, `image`, `qualification`, `description`) VALUES
(1, 'Chaudhry Faheem', 'abc@gmail.com', '0300-1234567', '1625161331.jpg', 'M Phil', 'I am software engineer with passion for teaching as well as security specialist. I have a passion for anything digital technology related, enjoy programing and challenge of successful digital experience.');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `image`, `qualification`) VALUES
(1, 'Chaudhry Faheem Irfan', '1625230980.jpg', 'M Phil'),
(4, 'Muhammad Saim', '1625231086.jpg', 'BSCS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
