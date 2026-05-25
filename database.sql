-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 25, 2026 at 05:28 PM
-- Server version: 12.2.2-MariaDB
-- PHP Version: 8.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koltsegvetes`
--
CREATE DATABASE IF NOT EXISTS `koltsegvetes` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci;
USE `koltsegvetes`;

-- --------------------------------------------------------

--
-- Table structure for table `adatok`
--

CREATE TABLE `adatok` (
  `nev` varchar(100) NOT NULL,
  `jelszo` varchar(255) NOT NULL,
  `egyenleg` bigint(20) NOT NULL,
  `keret` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `adatok`
--

INSERT INTO `adatok` (`nev`, `jelszo`, `egyenleg`, `keret`) VALUES
('dani', '$2y$12$AuMEGv4.yB5w/uKYYbWpMuDcFWnKaDyGdew3Xog7TCINFR93.nLFO', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tranzakciok`
--

CREATE TABLE `tranzakciok` (
  `id` int(11) NOT NULL,
  `osszeg` bigint(20) NOT NULL,
  `idopont` date NOT NULL,
  `kategoria` varchar(30) NOT NULL,
  `note` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `tranzakciok`
--

INSERT INTO `tranzakciok` (`id`, `osszeg`, `idopont`, `kategoria`, `note`) VALUES
(1, 100, '2026-05-23', 'Bevétel', 'Eltört a cipőm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adatok`
--
ALTER TABLE `adatok`
  ADD PRIMARY KEY (`nev`);

--
-- Indexes for table `tranzakciok`
--
ALTER TABLE `tranzakciok`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tranzakciok`
--
ALTER TABLE `tranzakciok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
