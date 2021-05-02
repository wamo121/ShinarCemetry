-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2021 at 06:14 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shinarcemetry`
--

-- --------------------------------------------------------

--
-- Table structure for table `grave`
--

CREATE TABLE `grave` (
  `GraveID` int(8) NOT NULL,
  `PlotNum` int(8) NOT NULL,
  `LotNum` int(8) NOT NULL,
  `GraveNum` int(8) NOT NULL COMMENT 'Each lot has four gravesites',
  `GraveStatus` int(1) DEFAULT 0 COMMENT 'Is the grave available\r\n0=Available\r\n1=Occupied',
  `FName` text DEFAULT NULL COMMENT 'FName of Plot Owner',
  `MName` text DEFAULT NULL,
  `LName` text DEFAULT NULL COMMENT 'LName of Plot Owner',
  `BirthMonth` int(11) DEFAULT NULL COMMENT 'Birth Month',
  `BirthDay` int(11) DEFAULT NULL COMMENT 'Birth Day',
  `BirthYear` int(11) DEFAULT NULL COMMENT 'Birth Year',
  `DeathMonth` int(11) DEFAULT NULL COMMENT 'Death Month',
  `DeathDay` int(11) DEFAULT NULL COMMENT 'Death Day',
  `DeathYear` int(11) DEFAULT NULL COMMENT 'Death Year',
  `IsVeteran` int(1) NOT NULL DEFAULT 0,
  `Notes` varchar(256) DEFAULT NULL COMMENT 'Comments',
  `ContactInfo` varchar(32) DEFAULT NULL COMMENT 'Contact Information in event of damage'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lot`
--

CREATE TABLE `lot` (
  `LotID` int(8) NOT NULL,
  `PlotNum` int(8) NOT NULL,
  `LotNum` int(8) NOT NULL,
  `RowNum` int(8) NOT NULL,
  `ColumnNum` int(8) NOT NULL,
  `Comment` varchar(32) DEFAULT NULL COMMENT 'Layout or position of lot'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `plot`
--

CREATE TABLE `plot` (
  `PlotID` int(11) NOT NULL,
  `PlotNum` int(8) NOT NULL COMMENT 'Plot Num 1-4',
  `Description` varchar(128) DEFAULT NULL COMMENT 'Lot size, orientation, or unique features'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Plot Information';

-- --------------------------------------------------------

--
-- Table structure for table `veteran`
--

CREATE TABLE `veteran` (
  `VetID` int(8) NOT NULL,
  `WarID` int(8) DEFAULT NULL COMMENT 'Select Veteran Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grave`
--
ALTER TABLE `grave`
  ADD PRIMARY KEY (`GraveID`),
  ADD KEY `LotNum` (`LotNum`),
  ADD KEY `PlotConstraint` (`PlotNum`),
  ADD KEY `Veteran` (`IsVeteran`);

--
-- Indexes for table `lot`
--
ALTER TABLE `lot`
  ADD PRIMARY KEY (`LotID`),
  ADD KEY `PlotNum` (`PlotNum`),
  ADD KEY `LotNum` (`LotNum`);

--
-- Indexes for table `plot`
--
ALTER TABLE `plot`
  ADD PRIMARY KEY (`PlotID`),
  ADD KEY `PlotNum` (`PlotNum`);

--
-- Indexes for table `veteran`
--
ALTER TABLE `veteran`
  ADD PRIMARY KEY (`VetID`),
  ADD KEY `WarID` (`WarID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grave`
--
ALTER TABLE `grave`
  MODIFY `GraveID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lot`
--
ALTER TABLE `lot`
  MODIFY `LotID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plot`
--
ALTER TABLE `plot`
  MODIFY `PlotID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `veteran`
--
ALTER TABLE `veteran`
  MODIFY `VetID` int(8) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grave`
--
ALTER TABLE `grave`
  ADD CONSTRAINT `GraveConstraint` FOREIGN KEY (`LotNum`) REFERENCES `lot` (`LotNum`),
  ADD CONSTRAINT `PlotConstraint` FOREIGN KEY (`PlotNum`) REFERENCES `plot` (`PlotNum`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
