-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2025 at 07:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assign`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` char(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(4,2) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `photo`) VALUES
('B001', 'croissant', 3.50, '67d96fbb477af.jpg'),
('B002', 'sourdough bread', 4.50, 'sourdoughBread.jpg'),
('B003', 'garlic bread', 4.00, 'garlicBread.jpg'),
('B004', 'chocolate cake', 50.00, 'chocolateCake.jpg'),
('B005', 'toast', 5.00, 'toast.jpg'),
('B006', 'coffee bun', 4.50, 'coffeeBun.jpg'),
('B007', 'sausage bread', 3.70, 'sausageBread.jpg'),
('B008', 'egg tart', 2.70, 'eggTart.jpg'),
('B009', 'cheese cake', 25.00, 'cheeseCake.jpg'),
('B010', 'croissant pizza', 7.50, 'croissantPizza.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
