-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2024 at 02:51 PM
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
-- Database: `asset_tracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(50) NOT NULL,
  `admin_fname` varchar(50) NOT NULL,
  `admin_lname` varchar(50) NOT NULL,
  `admin_num` varchar(50) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_pass` varchar(50) NOT NULL,
  `admin_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_fname`, `admin_lname`, `admin_num`, `admin_email`, `admin_pass`, `admin_role`) VALUES
(80, 'Jimmy', 'Jimmy', 'Jimmy', 'Jimmy', '$2y$10$Mt75d9S6b6Y/cqEI.7f00uvhrLZUx9xT3ZQAavEr2/B', 'Admin'),
(81, 'Janny', 'Janny', 'Janny', 'Janny', '$2y$10$he4qYYkLpA8gid2VWOSxtejSJlXGwxo1HBx62PYGVwf', 'Instructor'),
(83, 'Janrey', 'Janrey', 'Janrey', 'Janrey', '$2y$10$O917sUa4O9GQa8urYVydruvIsh5W2tHBgsE8cp7eOB0', 'Admin'),
(84, 'Lani', 'Lani', 'Lani', 'Lani', '$2y$10$uUPRUj0mwKAyTao2izV5nuDjWklBd00H0r4vTaZxxwO', 'Instructor'),
(85, 'Hary', 'Hary', 'Hary', 'Hary', 'Hary', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `asset_id` int(50) NOT NULL,
  `asset_brand` varchar(50) NOT NULL,
  `asset_type` varchar(50) NOT NULL,
  `asset_status` varchar(50) NOT NULL,
  `asset_desc` varchar(50) NOT NULL,
  `asset_quant` int(50) NOT NULL,
  `sup_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`asset_id`, `asset_brand`, `asset_type`, `asset_status`, `asset_desc`, `asset_quant`, `sup_id`) VALUES
(312, 'Razer', 'Scanner', 'New', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 6, 58),
(313, '', 'Scanner', 'New', '', 0, 68),
(314, '', 'Router', 'New', '', 0, 68),
(315, '', 'Router', 'New', '', 0, 68),
(316, '', 'Router', 'New', '', 0, 68),
(317, '', 'Network Switch', 'New', '', 0, 68),
(318, '', 'Network Switch', 'New', '', 0, 68),
(319, '', 'Network Switch', 'New', '', 0, 58),
(320, '', 'Headset', 'New', '', 0, 68),
(321, '', 'Headset', 'New', '', 0, 65),
(322, '', 'Headset', 'New', '', 0, 68),
(323, '', 'Headset', 'New', '', 0, 68),
(324, '', 'Microphone', 'New', '', 0, 68),
(325, '', 'Microphone', 'New', '', 0, 65),
(326, '', 'Camera', 'New', '', 0, 65),
(327, '', 'Camera', 'New', '', 0, 65),
(328, '', 'Printer', 'New', '', 0, 65),
(329, '', 'Printer', 'New', '', 0, 65),
(330, 'Razers', 'Desktop Computer', 'New', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 0, 65),
(332, 'asddd', 'Projector', 'New', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 6, 65);

-- --------------------------------------------------------

--
-- Table structure for table `laboratories`
--

CREATE TABLE `laboratories` (
  `lab_id` int(20) NOT NULL,
  `lab_name` varchar(50) NOT NULL,
  `lab_date` varchar(50) NOT NULL,
  `admin_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laboratories`
--

INSERT INTO `laboratories` (`lab_id`, `lab_name`, `lab_date`, `admin_id`) VALUES
(402, 'Laboratory123333', '242024-12-02', 84),
(403, 'laboratory123sssss', '0022-12-12', 84),
(404, '4th Floor Laboratorys', '2024-12-20', 84),
(420, 'LaboratoryName', '2024-05-02', 81);

-- --------------------------------------------------------

--
-- Table structure for table `request_asset`
--

CREATE TABLE `request_asset` (
  `req_id` int(50) NOT NULL,
  `req_name` varchar(50) NOT NULL,
  `req_status` varchar(50) NOT NULL,
  `quantity_asset` int(50) NOT NULL,
  `lab_id` int(50) NOT NULL,
  `req_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_asset`
--

INSERT INTO `request_asset` (`req_id`, `req_name`, `req_status`, `quantity_asset`, `lab_id`, `req_date`) VALUES
(174, 'Mouse', '', 4, 403, 'Feb-02-2024'),
(175, 'Keyboard', 'Processing', 6, 404, 'Feb-02-2024'),
(176, 'asd', 'Pending', 1, 402, 'Feb-02-2024'),
(177, 'asd', 'Pending', 1, 402, 'Feb-02-2024'),
(178, 'asd', 'Pending', 1, 402, 'Feb-02-2024'),
(179, 'asd', 'Received', 1, 402, 'Feb-02-2024'),
(180, 'asd', 'Pending', 1, 402, 'Feb-02-2024'),
(181, 'asd', 'Cancelled', 1, 402, 'Feb-02-2024');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `sup_id` int(50) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `sup_fname` varchar(50) NOT NULL,
  `sup_lname` varchar(50) NOT NULL,
  `contact_num` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`sup_id`, `company_name`, `sup_fname`, `sup_lname`, `contact_num`, `email`, `address`) VALUES
(58, 'asdds', 'asdd', 'asd', '09432.213417', 'asd@gmail.com', 'Abuno Kry-Ass Tungkop'),
(65, 'Janrey', 'Janrey', 'Janrey', '097495132321', 'Janrey@gmail.com', 'Abuno Kry-Ass Tungkop'),
(68, 'JANJANs', 'JANJANs', 'JANJANs', 'JANJANs', 'JANJANs@gmail.com', 'JANJANs');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_table`
--

CREATE TABLE `transaction_table` (
  `trans_id` int(50) NOT NULL,
  `asset_id` int(50) NOT NULL,
  `lab_id` int(50) NOT NULL,
  `sup_id` int(50) NOT NULL,
  `asset_stat` varchar(50) NOT NULL,
  `trans_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_table`
--

INSERT INTO `transaction_table` (`trans_id`, `asset_id`, `lab_id`, `sup_id`, `asset_stat`, `trans_date`) VALUES
(206, 312, 402, 58, 'New', 'Feb-02-2024'),
(207, 312, 402, 58, 'Maintenance', 'Feb-02-2024'),
(208, 312, 402, 58, 'Maintenance', 'Feb-02-2024'),
(209, 312, 402, 58, 'New', 'Feb-02-2024'),
(210, 312, 402, 58, 'New', 'Feb-02-2024'),
(211, 312, 402, 58, 'New', 'Feb-02-2024');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`asset_id`),
  ADD KEY `sup_id` (`sup_id`);

--
-- Indexes for table `laboratories`
--
ALTER TABLE `laboratories`
  ADD PRIMARY KEY (`lab_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `request_asset`
--
ALTER TABLE `request_asset`
  ADD PRIMARY KEY (`req_id`),
  ADD KEY `lab_id` (`lab_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`sup_id`);

--
-- Indexes for table `transaction_table`
--
ALTER TABLE `transaction_table`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `lab_id` (`lab_id`),
  ADD KEY `sup_id` (`sup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `asset_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT for table `laboratories`
--
ALTER TABLE `laboratories`
  MODIFY `lab_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=421;

--
-- AUTO_INCREMENT for table `request_asset`
--
ALTER TABLE `request_asset`
  MODIFY `req_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sup_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `transaction_table`
--
ALTER TABLE `transaction_table`
  MODIFY `trans_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`sup_id`) REFERENCES `supplier` (`sup_id`);

--
-- Constraints for table `laboratories`
--
ALTER TABLE `laboratories`
  ADD CONSTRAINT `laboratories_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`);

--
-- Constraints for table `request_asset`
--
ALTER TABLE `request_asset`
  ADD CONSTRAINT `request_asset_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `laboratories` (`lab_id`);

--
-- Constraints for table `transaction_table`
--
ALTER TABLE `transaction_table`
  ADD CONSTRAINT `transaction_table_ibfk_2` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`),
  ADD CONSTRAINT `transaction_table_ibfk_3` FOREIGN KEY (`lab_id`) REFERENCES `laboratories` (`lab_id`),
  ADD CONSTRAINT `transaction_table_ibfk_4` FOREIGN KEY (`sup_id`) REFERENCES `supplier` (`sup_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
