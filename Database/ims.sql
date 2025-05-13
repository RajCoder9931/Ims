-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 06:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `aadhar` varchar(20) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `email`, `contact`, `address`, `aadhar`, `gender`, `created_at`) VALUES
(1, 'Ravi raj Tiwari', 'tiwariraviraj50@gmail.com', '9931993138', 'phagwara jct mill oppsite goverment labour colouny', '878552310052', 'male', '2024-12-25 04:12:14'),
(3, 'Prabh', 'sahejdhigra54@gmail.com', '9586543219', 'phagwara jct mill oppsite goverment labour colouny', '879645123698', 'male', '2024-12-27 08:02:12'),
(4, 'rajesh', 'Rajesh@gmail.com', '99157 25114', 'sassasas', '875412895623', 'male', '2024-12-29 09:16:25');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `aadhar` varchar(16) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `contact`, `dob`, `aadhar`, `gender`, `father_name`, `address`, `created_at`) VALUES
(1, 'Raj', 'raj@gmail.com', '9586543219', '2002-07-25', '878552310052', 'male', 'Vijay Kumar Tiwari', 'phagwara jct mill oppsite goverment labour colouny\r\nphagwara jct mill oppsite goverment labour colouny', '2024-12-25 04:24:32'),
(2, 'Raj', 'raj@gmail.com', '9586543219', '2002-07-25', '878552310052', 'male', 'Vijay Kumar Tiwari', 'phagwara jct mill oppsite goverment labour colouny\r\nphagwara jct mill oppsite goverment labour colouny', '2024-12-25 04:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `grn_number` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `invoice_number` varchar(50) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `challan_number` varchar(50) DEFAULT NULL,
  `challan_date` date DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `total_discount` decimal(10,2) NOT NULL,
  `total_gst` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `grn_number`, `date`, `customer_name`, `invoice_number`, `invoice_date`, `challan_number`, `challan_date`, `subtotal`, `total_discount`, `total_gst`, `total_amount`, `created_at`) VALUES
(4, 'GRN001', '2025-01-03', 'Rajesh ', '1515', '2025-01-03', '212121', '2025-01-18', 2520.00, 12.00, 378.00, 2535.00, '2025-01-01 10:24:26'),
(5, 'GRN002', '2025-01-02', 'Ravi Raj Tiwari', '124587', '2025-01-10', '214578', '2025-01-02', 23950.00, 50.00, 4311.00, 23986.00, '2025-01-01 10:31:10'),
(7, 'GRN003', '2025-01-16', 'prabh', '10102', '2025-01-22', '21212', '0000-00-00', 1395.00, 5.00, 251.10, 1641.10, '2025-01-02 03:02:46'),
(8, 'GRN004', '2025-01-08', 'Rakesh Kumar', '10102', '2025-01-15', '1212212', '2025-01-25', 4985.00, 15.00, 897.30, 5867.30, '2025-01-19 07:08:48'),
(9, 'GRN005', '2025-02-14', 'durgesh kumar', '1515', '2025-02-01', '21212', '2025-02-21', 2265.00, 15.00, 226.50, 2476.50, '2025-02-10 15:22:22'),
(10, 'GRN006', '2025-02-12', 'Print Done With Main ', '1304', '2025-02-10', '15454', '2025-02-12', 2238.00, 12.00, 402.84, 2628.84, '2025-02-10 15:29:36'),
(11, 'GRN007', '2025-03-06', 'Ravi raj Tiwari', '1515', '2025-01-30', '21212', '2025-01-28', 2235.00, 15.00, 335.25, 2555.25, '2025-02-10 15:31:04'),
(12, 'GRN008', '0000-00-00', 'Ravi raj Tiwari', '1515', '2025-02-07', '15151', '2025-02-13', 1303.00, 33.00, 234.54, 1504.54, '2025-02-10 15:32:02'),
(15, 'GRN009', '2025-05-13', 'ims', '1501', '2025-05-13', '2518', '2025-05-28', 22485.00, 15.00, 6745.50, 29215.50, '2025-05-13 04:03:34');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `item_code` varchar(50) DEFAULT NULL,
  `item_description` varchar(255) DEFAULT NULL,
  `uom` varchar(50) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `unit_price` decimal(10,2) DEFAULT 0.00,
  `discount` decimal(10,2) DEFAULT 0.00,
  `gst` decimal(5,2) DEFAULT 0.00,
  `total_price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `item_code`, `item_description`, `uom`, `quantity`, `unit_price`, `discount`, `gst`, `total_price`) VALUES
(2, 4, '122', 'Hello', 'asas', 12.00, 211.00, 12.00, 15.00, 2535.00),
(3, 5, '101', 'Hanji edit ', 'asas', 10.00, 150.00, 15.00, 18.00, 1503.00),
(4, 5, '102', 'ho gya', 'pcs', 15.00, 1500.00, 35.00, 18.00, 22483.00),
(6, 7, 'asasa', 'asasa', 'pcs', 10.00, 140.00, 5.00, 18.00, 1646.10),
(7, 8, '1212', 'check the data print', 'asasas', 10.00, 500.00, 15.00, 18.00, 5882.30),
(8, 9, '1212', 'adass', 'pcs', 15.00, 152.00, 15.00, 10.00, 2491.50),
(9, 10, '151', 'asas', 'pcs', 15.00, 150.00, 12.00, 18.00, 2640.84),
(10, 11, '1010', 'fgg', 'pcs', 15.00, 150.00, 15.00, 15.00, 2570.25),
(11, 12, '1010', 'fdsfs', 'pcs', 101.00, 11.00, 15.00, 18.00, 1293.28),
(12, 12, '110', 'dfdfdf', 'pcs', 15.00, 15.00, 18.00, 18.00, 244.26),
(19, 15, '501', 'ims entered', 'dozen', 150.00, 150.00, 15.00, 30.00, 29230.50);

-- --------------------------------------------------------

--
-- Table structure for table `loandetails`
--

CREATE TABLE `loandetails` (
  `loan_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `principal_amount` decimal(10,2) DEFAULT NULL,
  `down_payment` decimal(10,2) DEFAULT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `emi_months` int(11) DEFAULT NULL,
  `loan_total_amount` decimal(10,2) DEFAULT NULL,
  `loan_interest` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `amount_to_be_paid` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `uom` varchar(50) DEFAULT NULL,
  `quantity` varchar(50) NOT NULL,
  `hns_code` varchar(255) DEFAULT NULL,
  `discount` varchar(50) DEFAULT NULL,
  `gst_no` varchar(50) DEFAULT NULL,
  `preferred_vendor` varchar(255) DEFAULT NULL,
  `price` varchar(50) NOT NULL,
  `daily` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `product_name`, `uom`, `quantity`, `hns_code`, `discount`, `gst_no`, `preferred_vendor`, `price`, `daily`, `created_at`) VALUES
(1, '101', 'Shoes', 'pcs', '10', '15487', '', '15', 'Ravi Raj', '500', 'aas', '2024-12-25 10:12:18'),
(2, '102', 'Bags', 'pcs', '10', '15487', '5%', '15', 'Ravi Raj', '500', 'aas', '2024-12-25 10:17:50'),
(3, '103', 'Tables', 'pcs', '10', '15487', '5%', '15', 'Ravi Raj', '500', 'aas', '2024-12-25 10:18:42'),
(4, '104', 'I-Phone', 'pcs', '10', '15487', '5%', '15', 'Ravi Raj', '500', 'aas', '2024-12-25 10:18:46'),
(6, '106', 'Glass', 'pcs', '10', '15487', '5%', '15', 'Ravi Raj', '500', 'aas', '2024-12-25 10:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `saleinvoiceitems`
--

CREATE TABLE `saleinvoiceitems` (
  `item_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `item_description` varchar(255) DEFAULT NULL,
  `uom` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `gst_percent` decimal(5,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saleinvoiceitems`
--

INSERT INTO `saleinvoiceitems` (`item_id`, `invoice_id`, `item_description`, `uom`, `quantity`, `unit_price`, `discount`, `gst_percent`, `total_price`) VALUES
(88, 28, 'shoes', 'pcs', 2, 15000.00, 15.00, 17.00, 35082.45),
(89, 27, 'cassa', 'pcs', 15, 150.00, 18.00, 16.00, 2589.12),
(90, 29, 'asas', 'asa', 111, 11.00, 2.00, 16.00, 1414.04),
(91, 30, '101', 'pcs', 15, 5.00, 5.00, 18.00, 82.60);

-- --------------------------------------------------------

--
-- Table structure for table `saleinvoices`
--

CREATE TABLE `saleinvoices` (
  `invoice_id` int(11) NOT NULL,
  `invoice_number` varchar(20) NOT NULL,
  `date` date DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `payment_mode` enum('cash','loan','gpay') NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `total_discount` decimal(10,2) DEFAULT NULL,
  `total_gst` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saleinvoices`
--

INSERT INTO `saleinvoices` (`invoice_id`, `invoice_number`, `date`, `customer_name`, `mobile_no`, `email`, `city`, `state`, `payment_mode`, `total_amount`, `subtotal`, `total_discount`, `total_gst`) VALUES
(27, 'INV0001', '2025-01-12', 'data is checked', '9368527140', 'as@gmail.com', 'asasa', 'sasas', 'cash', 2571.12, 2232.00, 18.00, 357.12),
(28, 'INV0002', '2025-01-04', 'Ravi raj', '09931993138', 'tiwariraviraj50@gmail.com', 'phagawara', 'Punjab', 'loan', 35067.45, 29985.00, 15.00, 5097.45),
(29, 'INV0003', '2025-01-10', 'done checked by ravi', '9368527140', 'as@gmail.com', 'asasa', 'asas', 'gpay', 1412.04, 1219.00, 2.00, 195.04),
(30, 'INV0004', '2025-05-13', 'ims', '8585858565', 'abc@gmai.com', 'ims', 'ims', 'cash', 77.60, 70.00, 5.00, 12.60);

-- --------------------------------------------------------

--
-- Table structure for table `uoms`
--

CREATE TABLE `uoms` (
  `id` int(11) NOT NULL,
  `uom_name` varchar(255) NOT NULL,
  `uom_type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uoms`
--

INSERT INTO `uoms` (`id`, `uom_name`, `uom_type`, `created_at`) VALUES
(2, 'Packets', 'pcs', '2024-12-29 06:26:34'),
(11, 'Dozen', 'Dozens', '2024-12-31 12:50:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','employee','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `user_type`, `created_at`) VALUES
(0, 'Bipin_kumar', 'Bipinkumar@gmail.com', '$2y$10$9Ww8iJpT/rD1L.zFibVs5OgcZ8XFSPy7ffjorBbqUpNPfl3s/K48e', 'admin', '2024-12-25 06:19:44'),
(1, 'raviraj99', 'raviraj50@gmail.com', '$2y$10$exfaNHA.JRLglymbvnO/ceoKlioG7TetokzEqU68siQR2.UBx5VKq', 'admin', '2024-12-23 15:12:48'),
(2, 'Rakesh', 'rakeshsah98@gmail.com', '$2y$10$iJGJM.FjH/yGFAreIXrea.vyqr5J3aVzghEiMidI93YZvyKNftH6C', 'employee', '2024-12-24 07:03:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `aadhar` (`aadhar`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `loandetails`
--
ALTER TABLE `loandetails`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saleinvoiceitems`
--
ALTER TABLE `saleinvoiceitems`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `saleinvoices`
--
ALTER TABLE `saleinvoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `uoms`
--
ALTER TABLE `uoms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `loandetails`
--
ALTER TABLE `loandetails`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `saleinvoiceitems`
--
ALTER TABLE `saleinvoiceitems`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `saleinvoices`
--
ALTER TABLE `saleinvoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `uoms`
--
ALTER TABLE `uoms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loandetails`
--
ALTER TABLE `loandetails`
  ADD CONSTRAINT `loandetails_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `saleinvoices` (`invoice_id`) ON DELETE CASCADE;

--
-- Constraints for table `saleinvoiceitems`
--
ALTER TABLE `saleinvoiceitems`
  ADD CONSTRAINT `saleinvoiceitems_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `saleinvoices` (`invoice_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
