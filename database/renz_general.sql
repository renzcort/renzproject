-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2019 at 09:46 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbrenzproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `renz_general`
--

CREATE TABLE `renz_general` (
  `id` int(5) NOT NULL,
  `systemname` varchar(100) DEFAULT NULL,
  `status` int(5) DEFAULT NULL,
  `timezone` int(5) DEFAULT NULL,
  `created_by` int(5) NOT NULL,
  `updated_by` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `renz_general`
--

INSERT INTO `renz_general` (`id`, `systemname`, `status`, `timezone`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(0, NULL, NULL, NULL, 1, 1, '2019-05-13 09:33:06', '2019-05-13 09:36:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `renz_general`
--
ALTER TABLE `renz_general`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
