-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2024 at 11:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u578783310_myshoes`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblids_google`
--

CREATE TABLE `tblids_google` (
  `api_id` int(11) NOT NULL,
  `client_id` text NOT NULL,
  `client_secret` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblids_google`
--

INSERT INTO `tblids_google` (`api_id`, `client_id`, `client_secret`) VALUES
(1, '267762598007-rt1je04qcbodlri0lqp9ihfkd83b5j64.apps.googleusercontent.com', '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');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblids_google`
--
ALTER TABLE `tblids_google`
  ADD PRIMARY KEY (`api_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblids_google`
--
ALTER TABLE `tblids_google`
  MODIFY `api_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
