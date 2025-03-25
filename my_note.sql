-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2024 at 08:27 PM
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
  `date` datetime NOT NULL,
  `priority` enum('Low','Normal','High','Urgent') NOT NULL,
  `users_id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `reminder_date` datetime DEFAULT NULL,
  `recurrence` varchar(20) DEFAULT NULL,
  `completion_status` varchar(255) DEFAULT 'Not Started'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`notesId`, `title`, `content`, `date`, `priority`, `users_id`, `category`, `reminder_date`, `recurrence`, `completion_status`) VALUES
(88, 'Project Meeting', 'Discuss Project Update', '2024-01-26 19:10:00', '', 33, 'work', '2024-01-22 08:00:00', 'daily', 'Not Started'),
(89, 'Coding Practice', 'Solve Coding Problems', '2024-01-31 10:00:00', 'High', 34, 'study', '2024-01-26 17:00:00', 'daily', 'Ongoing'),
(90, 'Book Club', 'Read assigned chapters', '2024-02-15 20:30:00', '', 34, 'personal', '2024-01-23 08:00:00', 'daily', 'Not Started'),
(91, 'SDT Assignment ', 'Database ERD ', '2024-01-24 20:27:00', 'Low', 32, 'study', '2024-01-21 20:27:00', '', 'Completed'),
(92, 'SDT Test', 'Note Management System', '2024-01-27 23:59:00', 'High', 32, 'study', '2024-01-21 23:27:00', 'weekly', 'Ongoing'),
(95, 'SDT Report', 'SDT Mini Project', '2024-01-27 20:00:00', 'High', 32, 'study', '2024-01-24 02:07:00', 'daily', 'Not Started');

-- --------------------------------------------------------

--
-- Table structure for table `note_assignments`
--

CREATE TABLE `note_assignments` (
  `assignment_id` int(11) NOT NULL,
  `notesId` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Not Started'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `note_assignments`
--

INSERT INTO `note_assignments` (`assignment_id`, `notesId`, `assigned_to`, `assigned_by`, `status`) VALUES
(18, 89, 32, 34, 'Not Started'),
(19, 90, 33, 34, 'Ongoing'),
(20, 90, 34, 34, 'Not Started'),
(21, 91, 33, 32, 'Ongoing'),
(22, 91, 34, 32, 'Not Started'),
(26, 95, 33, 32, 'Not Started'),
(27, 95, 34, 32, 'Ongoing'),
(28, 95, 36, 32, 'Not Started');

-- --------------------------------------------------------

--
-- Table structure for table `users_mulyani`
--

CREATE TABLE `users_mulyani` (
  `users_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_mulyani`
--

INSERT INTO `users_mulyani` (`users_id`, `username`, `password`, `email`) VALUES
(32, 'Alina', '$2y$10$IVrOea2h.NzkOrjqJNypi.roma/KIEOrECdnW9ac8t3h7i5uJ7YhK', 'mulyanisaripuddin28@gmail.com'),
(33, 'amni', '$2y$10$E8dFOBg7gZayksCviczGOu8.DxlwF9dMMZjoK8Wz2tUjSiUVg1rKi', 'amni@gmail.com'),
(34, 'amanina', '$2y$10$MsuZeTj35idk4MeXPgHrveSnzJ0H7SFMeohuzHU7Y9NzVR05udzIi', 'amanina@gmail.com'),
(35, 'putih', '$2y$10$gBzSNNq5GssdHdosQfaYReYUpwcHqurmHHn5VFp8YXKKiui1e8iY2', 'putih@gmail.com'),
(36, 'Airin', '$2y$10$K9fhzY7mgVFEo2OasRlX1uT.Uf5nphGUgH2oQvzx1wN8hLmDyjRnS', 'airin@gmail.com'),
(37, 'Julaiha', '$2y$10$GHq7xo.3SKlB3iiteP9DX.hPSGta8S6hSzrfgqvlGnj/oh6T1RMDe', 'julaiha@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`notesId`),
  ADD KEY `fk_users_id` (`users_id`);

--
-- Indexes for table `note_assignments`
--
ALTER TABLE `note_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `fk_assigned_to` (`assigned_to`),
  ADD KEY `fk_assigned_by` (`assigned_by`),
  ADD KEY `fk_notesId` (`notesId`);

--
-- Indexes for table `users_mulyani`
--
ALTER TABLE `users_mulyani`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `notesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `note_assignments`
--
ALTER TABLE `note_assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users_mulyani`
--
ALTER TABLE `users_mulyani`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `fk_users_id` FOREIGN KEY (`users_id`) REFERENCES `users_mulyani` (`users_id`) ON DELETE CASCADE;

--
-- Constraints for table `note_assignments`
--
ALTER TABLE `note_assignments`
  ADD CONSTRAINT `fk_assigned_by` FOREIGN KEY (`assigned_by`) REFERENCES `users_mulyani` (`users_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_assigned_to` FOREIGN KEY (`assigned_to`) REFERENCES `users_mulyani` (`users_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_notesId` FOREIGN KEY (`notesId`) REFERENCES `notes` (`notesId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
