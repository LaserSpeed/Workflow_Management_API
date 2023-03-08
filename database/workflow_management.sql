-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2023 at 10:48 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workflow_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `workflow`
--

CREATE TABLE `workflow` (
  `workflow_id` int(11) NOT NULL,
  `workflow_name` varchar(100) NOT NULL,
  `workflow_description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workflow`
--

INSERT INTO `workflow` (`workflow_id`, `workflow_name`, `workflow_description`, `created_at`) VALUES
(1, 'InternAttendenceSheet', 'This sheet is used by intern to keep the daily records.', '2023-03-08 10:49:05'),
(2, 'Telephone Bill', 'This workflow for handle telephone bill', '2023-03-08 10:59:20');

-- --------------------------------------------------------

--
-- Table structure for table `workflow_step`
--

CREATE TABLE `workflow_step` (
  `step_id` int(11) NOT NULL,
  `workflow_id` int(11) NOT NULL,
  `step_name` varchar(255) NOT NULL,
  `step_order` int(11) NOT NULL,
  `step_type` varchar(50) NOT NULL,
  `step_handleby` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workflow_step`
--

INSERT INTO `workflow_step` (`step_id`, `workflow_id`, `step_name`, `step_order`, `step_type`, `step_handleby`) VALUES
(1, 1, 'Reporting Officer', 0, 'Define Role', '700162'),
(2, 1, 'HR', 1, 'Custom ID', '700161'),
(3, 1, 'Finance Department', 2, 'define Group', 'Finance');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `workflow`
--
ALTER TABLE `workflow`
  ADD PRIMARY KEY (`workflow_id`),
  ADD UNIQUE KEY `workflow_name` (`workflow_name`);

--
-- Indexes for table `workflow_step`
--
ALTER TABLE `workflow_step`
  ADD PRIMARY KEY (`step_id`),
  ADD KEY `workflow_id` (`workflow_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `workflow`
--
ALTER TABLE `workflow`
  MODIFY `workflow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `workflow_step`
--
ALTER TABLE `workflow_step`
  MODIFY `step_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `workflow_step`
--
ALTER TABLE `workflow_step`
  ADD CONSTRAINT `workflow_step_ibfk_1` FOREIGN KEY (`workflow_id`) REFERENCES `workflow` (`workflow_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
