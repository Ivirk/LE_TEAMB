-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 20, 2025 at 01:10 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shjp`
--

-- --------------------------------------------------------

--
-- Table structure for table `Administrator`
--

CREATE TABLE `Administrator` (
  `admin_id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Administrator`
--

INSERT INTO `Administrator` (`admin_id`, `name`, `email`, `contact_number`, `username`, `password`) VALUES
(1, 'TeamB', 'teamb@gmail.com', '09123456789', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `BaptismalCertificate`
--

CREATE TABLE `BaptismalCertificate` (
  `baptismal_id` int NOT NULL,
  `request_id` int DEFAULT NULL,
  `date_baptism` date DEFAULT NULL,
  `place_baptism` varchar(255) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `godparents` varchar(255) DEFAULT NULL,
  `priest_name` varchar(100) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `certificate_number` int DEFAULT NULL,
  `date_issued` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `BaptismalRecords`
--

CREATE TABLE `BaptismalRecords` (
  `baptismalrecord_id` int NOT NULL,
  `admin_id` int DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `date_baptism` date DEFAULT NULL,
  `place_baptism` varchar(255) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `godfather` varchar(255) DEFAULT NULL,
  `godmother` varchar(255) DEFAULT NULL,
  `priest_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `BaptismalRecords`
--

INSERT INTO `BaptismalRecords` (`baptismalrecord_id`, `admin_id`, `full_name`, `date_baptism`, `place_baptism`, `father_name`, `mother_name`, `godfather`, `godmother`, `priest_name`) VALUES
(1, NULL, 'Kervy How', '2006-05-14', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Jose How', 'Maria How', 'Antonio Reyes', 'Teresa Lopez', 'Fr. Miguel Alonzo'),
(2, NULL, 'Serc Noan Buque', '2008-11-23', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Manuel Buque', 'Anna Buque', 'Roberto Cruz', 'Lily Flores', 'Fr. Ricardo Medina'),
(3, NULL, 'Joshua Delos Santos', '2010-01-05', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Luis Delos Santos', 'Teresa Delos Santos', 'Gabriel Aquino', 'Kristine Tan', 'Fr. Antonio Garcia'),
(4, NULL, 'Joaquin Cabañero', '2015-03-12', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Daniel Cabañero', 'Lourdes Cabañero', 'Carlos Bautista', 'Patricia Morales', 'Fr. Jose Fernandez'),
(5, NULL, 'Mary Jash Malintad', '2011-08-30', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Kevin Malintad', 'Michelle Malintad', 'Ronald Santos', 'Catherine Ramos', 'Fr. Emmanuel Cruz'),
(6, NULL, 'Queenie Thea Edurece', '2007-09-17', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Rafael Edurece', 'Lourdes Edurece', 'Angel Ortiz', 'Nicole Perez', 'Fr. Benjamin Alcantara'),
(7, NULL, 'Carlo Tan', '2018-12-05', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Jose Tan', 'Maria Tan', 'Victor De Leon', 'Angelica Estrada', 'Fr. Manuel Santos'),
(8, NULL, 'Patricia Flores', '2019-11-22', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Roberto Flores', 'Cristina Flores', 'Kevin Malonzo', 'Lucinda Cortez', 'Fr. Ricardo Alcantara'),
(9, NULL, 'Jose Dela Rosa', '2005-06-03', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Roberto Dela Rosa', 'Gloria Dela Rosa', 'Marc Santos', 'Luisa Miranda', 'Fr. Lorenzo Reyes'),
(10, NULL, 'Maria Carina Mercado', '2014-04-10', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Orlando Mercado', 'Diana Mercado', 'Fabian Ordonez', 'Elvira Santos', 'Fr. Francisco Cruz'),
(11, NULL, 'Kristoffer Garcia', '2020-10-01', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Joshua Garcia', 'Anna Garcia', 'Samuel Castillo', 'Valerie De Guzman', 'Fr. Emilio Dizon'),
(12, NULL, 'Carmen Bautista', '2017-07-08', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Mark Bautista', 'Liza Bautista', 'Danilo Santos', 'Carmen dela Vega', 'Fr. Gregorio Fernandez'),
(13, NULL, 'Francis Pangilinan', '2012-05-21', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Antonio Pangilinan', 'Lourdes Pangilinan', 'Mark Velasco', 'Teresa Gonzales', 'Fr. Daniel Velarde'),
(14, NULL, 'Angel Aquino', '2021-09-15', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Miguel Aquino', 'Elisa Aquino', 'Jordan Malonzo', 'Sabrina Rios', 'Fr. Eugene Navarro'),
(15, NULL, 'Paolo Santos', '2023-11-03', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Renato Santos', 'Valerie Santos', 'James Perez', 'Amanda Cortez', 'Fr. Roberto Matias');

-- --------------------------------------------------------

--
-- Table structure for table `CertificateRequests`
--

CREATE TABLE `CertificateRequests` (
  `request_id` int NOT NULL,
  `parishioner_id` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `type` enum('Baptismal','Confirmation') DEFAULT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `date_requested` date DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT NULL,
  `date_approved` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ConfirmationCertificate`
--

CREATE TABLE `ConfirmationCertificate` (
  `confirmation_id` int NOT NULL,
  `request_id` int DEFAULT NULL,
  `date_confirmation` date DEFAULT NULL,
  `place_confirmation` varchar(255) DEFAULT NULL,
  `officiant_name` varchar(100) DEFAULT NULL,
  `sponsors` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `certificate_number` varchar(50) DEFAULT NULL,
  `date_issued` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ConfirmationRecords`
--

CREATE TABLE `ConfirmationRecords` (
  `confirmationrecord_id` int NOT NULL,
  `admin_id` int DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `date_confirmation` date DEFAULT NULL,
  `place_confirmation` varchar(255) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `sponsors` varchar(255) DEFAULT NULL,
  `priest_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ConfirmationRecords`
--

INSERT INTO `ConfirmationRecords` (`confirmationrecord_id`, `admin_id`, `full_name`, `date_confirmation`, `place_confirmation`, `father_name`, `mother_name`, `sponsors`, `priest_name`) VALUES
(1, NULL, 'Maria Cecilia Dela Cruz', '2006-12-02', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Roberto Dela Cruz', 'Lucinda Dela Cruz', 'Gabriel Santos and Ana Lopez', 'Fr. Daniel Santos'),
(2, NULL, 'John Michael Reyes', '2009-08-15', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Jose Reyes', 'Maria Reyes', 'Christian Bautista and Miriam Santos', 'Fr. Miguel Garcia'),
(3, NULL, 'Vanessa Garcia', '2011-03-18', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Manuel Garcia', 'Teresa Garcia', 'Carlos Dominguez and Patricia Gomez', 'Fr. Antonio Fernandez'),
(4, NULL, 'Angelica Santos', '2013-05-22', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Ramon Santos', 'Ana Santos', 'Mark Tuazon and Angel Aquino', 'Fr. Lorenzo Cruz'),
(5, NULL, 'Kevin dela Vega', '2016-11-05', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Alberto dela Vega', 'Isabel dela Vega', 'Joshua Cruz and Teresa Malonzo', 'Fr. Jose Alfaro'),
(6, NULL, 'Patricia Flores', '2018-01-13', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Ricardo Flores', 'Cynthia Flores', 'Mark Reyes and Rachel Cortez', 'Fr. Eduardo Garcia'),
(7, NULL, 'Paolo Hernandez', '2019-06-30', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Daniel Hernandez', 'Teresa Hernandez', 'Anthony Delos Santos and Michelle Lopez', 'Fr. Manuel Aquino'),
(8, NULL, 'Maria Lourdes Gonzales', '2020-12-12', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Francisco Gonzales', 'Lucia Gonzales', 'Victor Mercado and Maricel Gutierrez', 'Fr. Ramon Santos'),
(9, NULL, 'Carla Joy Mendoza', '2021-03-21', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Luis Mendoza', 'Maria Mendoza', 'Gabriel Reyes and Cristina dela Cruz', 'Fr. Ronald Alonzo'),
(10, NULL, 'Mark Anthony Rivera', '2022-08-19', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Jose Rivera', 'Ann Rivera', 'Paolo Santos and Giselle Lopez', 'Fr. Nickolas Fernandez'),
(11, NULL, 'Angelica Cruz', '2023-04-15', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Ernesto Cruz', 'Maria Cruz', 'Dennis Ortiz and Francesca Ramos', 'Fr. Andrew Mendoza'),
(12, NULL, 'Francis Paolo Alvarez', '2008-09-10', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Alfonso Alvarez', 'Gloria Alvarez', 'Rodelio Aquino and Jessica Flores', 'Fr. Roberto Garcia'),
(13, NULL, 'Helen Grace Aquino', '2014-02-28', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Vicente Aquino', 'Aurora Aquino', 'Martin Reyes and Erika Santos', 'Fr. Enrico del Rosario'),
(14, NULL, 'Cesar Valencia', '2015-06-17', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Victor Valencia', 'Maria Valencia', 'Eduardo Santos and Lourdes Cruz', 'Fr. Eduardo Dela Rosa'),
(15, NULL, 'Jessa Marie Sanchez', '2007-10-05', 'Sacred Heart Of Jesus Parish Bo. Obero', 'Carlos Sanchez', 'Theresa Sanchez', 'Rolando Aquino and Celia Hernandez', 'Fr. Andres Gonzalez');

-- --------------------------------------------------------

--
-- Table structure for table `Parishioners`
--

CREATE TABLE `Parishioners` (
  `parishioner_id` int NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_registered` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Administrator`
--
ALTER TABLE `Administrator`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `BaptismalCertificate`
--
ALTER TABLE `BaptismalCertificate`
  ADD PRIMARY KEY (`baptismal_id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `BaptismalRecords`
--
ALTER TABLE `BaptismalRecords`
  ADD PRIMARY KEY (`baptismalrecord_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `CertificateRequests`
--
ALTER TABLE `CertificateRequests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `parishioner_id` (`parishioner_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `ConfirmationCertificate`
--
ALTER TABLE `ConfirmationCertificate`
  ADD PRIMARY KEY (`confirmation_id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `ConfirmationRecords`
--
ALTER TABLE `ConfirmationRecords`
  ADD PRIMARY KEY (`confirmationrecord_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `Parishioners`
--
ALTER TABLE `Parishioners`
  ADD PRIMARY KEY (`parishioner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Administrator`
--
ALTER TABLE `Administrator`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `BaptismalCertificate`
--
ALTER TABLE `BaptismalCertificate`
  MODIFY `baptismal_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `BaptismalRecords`
--
ALTER TABLE `BaptismalRecords`
  MODIFY `baptismalrecord_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `CertificateRequests`
--
ALTER TABLE `CertificateRequests`
  MODIFY `request_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ConfirmationCertificate`
--
ALTER TABLE `ConfirmationCertificate`
  MODIFY `confirmation_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ConfirmationRecords`
--
ALTER TABLE `ConfirmationRecords`
  MODIFY `confirmationrecord_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Parishioners`
--
ALTER TABLE `Parishioners`
  MODIFY `parishioner_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `BaptismalCertificate`
--
ALTER TABLE `BaptismalCertificate`
  ADD CONSTRAINT `baptismalcertificate_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `CertificateRequests` (`request_id`);

--
-- Constraints for table `BaptismalRecords`
--
ALTER TABLE `BaptismalRecords`
  ADD CONSTRAINT `baptismalrecords_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `Administrator` (`admin_id`);

--
-- Constraints for table `CertificateRequests`
--
ALTER TABLE `CertificateRequests`
  ADD CONSTRAINT `certificaterequests_ibfk_1` FOREIGN KEY (`parishioner_id`) REFERENCES `Parishioners` (`parishioner_id`),
  ADD CONSTRAINT `certificaterequests_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `Administrator` (`admin_id`);

--
-- Constraints for table `ConfirmationCertificate`
--
ALTER TABLE `ConfirmationCertificate`
  ADD CONSTRAINT `confirmationcertificate_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `CertificateRequests` (`request_id`);

--
-- Constraints for table `ConfirmationRecords`
--
ALTER TABLE `ConfirmationRecords`
  ADD CONSTRAINT `confirmationrecords_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `Administrator` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
