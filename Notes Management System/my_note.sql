-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2023 at 06:37 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_note`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `notesId` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`notesId`, `title`, `content`, `date`) VALUES
(4, 'Project Proposal', 'Project Proposal submit on 9/11 ', '2023-10-30'),
(7, 'Data structure and Algorithm', 'Exam test 1 (Chapter1-5) (DONE)', '2023-11-20'),
(8, 'Nettwork Communication', 'Exam test 1', '2023-11-16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `username`, `password`) VALUES
(5, 'kucingbau', '$2y$10$hKsRbWZsYpKGol9D9Gccu.zABDNVJwKK3cwgpzlv2A9Djxwe7q5NO'),
(6, 'kucing', '$2y$10$wYFJv0PMbpC0Djq3nAv1peL.WnGIRnVnMCbaWHdXsIOlFkCikwd42'),
(7, 'ayam', '$2y$10$gTZLh5JlV2oQZ.8/LI6qSeZCvbQP1DKrwqKeEVpMAmwUMloyyEtHy'),
(8, 'monyet', '$2y$10$hqrF56ndhnaFbaGwsGiqSOCHXdvCTUlWP44qcljVt9rpreKm4aIyS'),
(9, 'kambing', '$2y$10$4tp8rJsFVcpzQpFy5J.nEOOk3vggmN/qMIXexTexTXarxogHXSmG2'),
(10, 'kuda', '$2y$10$AeKRaLEGOZLR0bVM3oPb3Od.Dh2Gw37W.nypVx1SMCObzr1gXSQo6'),
(11, 'kelawar', '$2y$10$7Yq8AOOecOtYFditP55Wuu.0W9C.t.pmTw.4n.I2RNKY5m1NU2ANq'),
(12, 'rama', '$2y$10$EInvSULghc98jEq5YuJKbeCWdh9Xfov/SRXKYSl5t8t5cwL17VSjC'),
(13, 'rima', '$2y$10$Lh5JP9kktT3mhv5maXMIHe3/WHSCLwvpxYTeA.wtdfbOV0e1vdzhq'),
(14, 'amni', '$2y$10$zyVVcAGNx3YnT26A5eve0OF8WkaDqymVOY7kUA48Ej9z6guDj83Ui');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`notesId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `notesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
