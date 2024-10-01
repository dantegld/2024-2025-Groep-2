-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 30, 2024 at 12:55 PM
-- Server version: 10.6.18-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `groep2`
--
CREATE DATABASE IF NOT EXISTS `groep2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `groep2`;

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `functie_id` int(11) NOT NULL,
  `functienaam` text NOT NULL,
  `functiewaarde` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`functie_id`, `functienaam`, `functiewaarde`) VALUES
(1, 'onderhoudmodus', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbladres`
--

CREATE TABLE `tbladres` (
  `klant_id` int(11) NOT NULL,
  `adres_id` int(11) NOT NULL,
  `adres` text NOT NULL,
  `postcode_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblartikels`
--

CREATE TABLE `tblartikels` (
  `artikel_id` int(11) NOT NULL,
  `artikelnaam` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `prijs` int(11) NOT NULL,
  `merk_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblartikels`
--

INSERT INTO `tblartikels` (`artikel_id`, `artikelnaam`, `stock`, `prijs`, `merk_id`, `categorie_id`) VALUES
(1, 'Nike Jordan x Dior Low', 200, 1000, 1, 1),
(2, 'Nike Air max Plus', 200, 250, 1, 1),
(3, 'Jordan 11 Cool Grey', 200, 300, 1, 1),
(4, 'Adidas Campus 00\'s', 200, 120, 2, 1),
(5, 'Adidas Predator', 200, 500, 2, 2),
(6, 'Adidas terex', 200, 85, 2, 3),
(7, 'Newbalance MR530 Zwart', 200, 150, 3, 1),
(8, 'Newbalance MR350 Wit', 200, 150, 3, 1),
(9, 'Newbalance 550 Roze', 200, 150, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblbetaalmethodes`
--

CREATE TABLE `tblbetaalmethodes` (
  `methode_id` int(11) NOT NULL,
  `methodenaam` varchar(255) DEFAULT NULL,
  `icoon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcategorie`
--

CREATE TABLE `tblcategorie` (
  `categorie_id` int(11) NOT NULL,
  `categorienaam` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategorie`
--

INSERT INTO `tblcategorie` (`categorie_id`, `categorienaam`) VALUES
(1, 'Sneaker'),
(2, 'Voetbalschoen'),
(3, 'Wandelschoen');

-- --------------------------------------------------------

--
-- Table structure for table `tblklant`
--

CREATE TABLE `tblklant` (
  `klant_id` int(11) NOT NULL,
  `klantnaam` varchar(255) DEFAULT NULL,
  `wachtwoord` text NOT NULL,
  `schoenmaat` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblklant`
--

INSERT INTO `tblklant` (`klant_id`, `klantnaam`, `wachtwoord`, `schoenmaat`, `type`) VALUES
(1, 'dante', 'dante', '42', 'eigenaar'),
(2, 'tiago', 'tiago', '45', 'admin'),
(3, 'yassine', 'yassine', '43', 'admin'),
(4, 'victor', 'victor', '39', 'admin'),
(5, 'kerem', 'kerem', '63', 'admin'),
(6, 'wijns', 'wijns', '43', 'klant');

-- --------------------------------------------------------

--
-- Table structure for table `tblmerk`
--

CREATE TABLE `tblmerk` (
  `merk_id` int(11) NOT NULL,
  `merknaam` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblmerk`
--

INSERT INTO `tblmerk` (`merk_id`, `merknaam`) VALUES
(1, 'Nike'),
(2, 'Adidas'),
(3, 'New Balance');

-- --------------------------------------------------------

--
-- Table structure for table `tblpostcode`
--

CREATE TABLE `tblpostcode` (
  `postcode_id` int(11) NOT NULL,
  `postcode` int(11) NOT NULL,
  `plaats` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblrecensies`
--

CREATE TABLE `tblrecensies` (
  `recensie_id` int(11) NOT NULL,
  `klantnummer` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblsocialmedia`
--

CREATE TABLE `tblsocialmedia` (
  `socialmedia_id` int(11) NOT NULL,
  `socialmedianaam` int(11) NOT NULL,
  `icoon` int(11) NOT NULL,
  `beschikbaar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblwinkelwagen`
--

CREATE TABLE `tblwinkelwagen` (
  `klant_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `aantal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblwishlist`
--

CREATE TABLE `tblwishlist` (
  `klant_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`functie_id`);

--
-- Indexes for table `tbladres`
--
ALTER TABLE `tbladres`
  ADD PRIMARY KEY (`adres_id`,`klant_id`);

--
-- Indexes for table `tblartikels`
--
ALTER TABLE `tblartikels`
  ADD PRIMARY KEY (`artikel_id`);

--
-- Indexes for table `tblbetaalmethodes`
--
ALTER TABLE `tblbetaalmethodes`
  ADD PRIMARY KEY (`methode_id`);

--
-- Indexes for table `tblcategorie`
--
ALTER TABLE `tblcategorie`
  ADD PRIMARY KEY (`categorie_id`);

--
-- Indexes for table `tblklant`
--
ALTER TABLE `tblklant`
  ADD PRIMARY KEY (`klant_id`);

--
-- Indexes for table `tblmerk`
--
ALTER TABLE `tblmerk`
  ADD PRIMARY KEY (`merk_id`);

--
-- Indexes for table `tblpostcode`
--
ALTER TABLE `tblpostcode`
  ADD PRIMARY KEY (`postcode_id`);

--
-- Indexes for table `tblrecensies`
--
ALTER TABLE `tblrecensies`
  ADD PRIMARY KEY (`recensie_id`);

--
-- Indexes for table `tblsocialmedia`
--
ALTER TABLE `tblsocialmedia`
  ADD PRIMARY KEY (`socialmedia_id`);

--
-- Indexes for table `tblwinkelwagen`
--
ALTER TABLE `tblwinkelwagen`
  ADD PRIMARY KEY (`klant_id`),
  ADD KEY `artikel_id` (`artikel_id`);

--
-- Indexes for table `tblwishlist`
--
ALTER TABLE `tblwishlist`
  ADD PRIMARY KEY (`klant_id`,`artikel_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `functie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblartikels`
--
ALTER TABLE `tblartikels`
  MODIFY `artikel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblcategorie`
--
ALTER TABLE `tblcategorie`
  MODIFY `categorie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblklant`
--
ALTER TABLE `tblklant`
  MODIFY `klant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblmerk`
--
ALTER TABLE `tblmerk`
  MODIFY `merk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblpostcode`
--
ALTER TABLE `tblpostcode`
  MODIFY `postcode_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblrecensies`
--
ALTER TABLE `tblrecensies`
  MODIFY `recensie_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsocialmedia`
--
ALTER TABLE `tblsocialmedia`
  MODIFY `socialmedia_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblrecensies`
--
ALTER TABLE `tblrecensies`
  ADD CONSTRAINT `tblrecensies_ibfk_1` FOREIGN KEY (`klantnummer`) REFERENCES `tblklant` (`klant_id`);

--
-- Constraints for table `tblwinkelwagen`
--
ALTER TABLE `tblwinkelwagen`
  ADD CONSTRAINT `tblwinkelwagen_ibfk_1` FOREIGN KEY (`klant_id`) REFERENCES `tblklant` (`klant_id`),
  ADD CONSTRAINT `tblwinkelwagen_ibfk_2` FOREIGN KEY (`artikel_id`) REFERENCES `tblartikels` (`artikel_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;