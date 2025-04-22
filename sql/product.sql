-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2025 at 10:56 AM
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
  `description` varchar(300) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `description`, `photo`, `stock`) VALUES
('B001', 'croissant', 3.50, 'A croissant is a buttery, flaky pastry made from simple ingredients like flour, butter, yeast, milk, sugar, and salt. Its crescent shape and layered texture come from a special folding technique, resulting in a crisp exterior and soft, airy interior.', 'croissant.jpg', 60),
('B002', 'sourdough bread', 4.50, 'Sourdough bread is a tangy, chewy bread made from flour, water, and naturally fermented wild yeast. Its crisp crust and airy interior develop through a slow fermentation process, giving it a rich flavor and hearty texture.', 'sourdoughBread.jpg', 40),
('B003', 'garlic bread', 4.00, 'Garlic bread is a crispy, buttery bread infused with garlic and herbs. Made by spreading garlic butter on bread and baking until golden, it has a rich, savory flavor and a soft, warm interior.', 'garlicBread.jpg', 90),
('B004', 'chocolate cake', 50.00, 'Chocolate cake is a rich, moist dessert made with cocoa or melted chocolate. Baked to a soft, fluffy texture, it has a deep, sweet flavor and is often topped with frosting or ganache for extra indulgence.', 'chocolateCake.jpg', 95),
('B005', 'toast', 5.00, 'Toast is sliced bread that is browned by heat until crisp and golden. It has a crunchy texture and a warm, slightly nutty flavor, often enjoyed with butter, jam, or other toppings.', 'toast.jpg', 90),
('B006', 'coffee bun', 4.50, 'A coffee bun is a soft, sweet bread with a crispy, coffee-flavored topping. Baked to a golden brown, it has a light, fluffy interior and a rich aroma, often with a buttery or creamy filling inside.', 'coffeeBun.jpg', 90),
('B007', 'sausage bread', 3.70, 'Sausage bread is a soft, fluffy bun baked with a savory sausage inside. Often topped with ketchup, mayonnaise, or cheese, it has a slightly sweet dough that complements the juicy, flavorful sausage.', 'sausageBread.jpg', 90),
('B008', 'egg tart', 2.70, 'An egg tart is a small, flaky pastry filled with smooth, creamy egg custard. Baked until golden, it has a crisp crust and a sweet, silky filling with a rich, vanilla-like flavor.', 'eggTart.jpg', 95),
('B009', 'cheese cake', 25.00, 'Cheesecake is a creamy, rich dessert made with cream cheese, sugar, and eggs on a graham cracker crust. It has a smooth, velvety texture and can be topped with fruits, chocolate, or other flavorings.', 'cheeseCake.jpg', 90),
('B010', 'croissant pizza', 7.50, 'Croissant pizza is a fusion dish that combines the flaky, buttery texture of a croissant with the savory toppings of a pizza. The croissant dough is shaped like a pizza crust and topped with ingredients like cheese, tomato sauce, and meats or vegetables before being baked to golden perfection.', 'croissantPizza.jpg', 90);

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
