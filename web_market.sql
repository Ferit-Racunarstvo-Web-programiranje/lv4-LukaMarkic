-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2023 at 02:27 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

CREATE DATABASE web_market;

USE web_market;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_market`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` float NOT NULL DEFAULT 0,
  `image_url` varchar(2083) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `image_url`) VALUES
(2, 'Grape', 3.99, 'https://img.imageboss.me/fourwinds/width/425/dpr:2/s/files/1/2336/3219/products/blackmonukka.jpg?v=1538780984'),
(7, 'Peach', 2.29, 'https://billsberryfarm.com/wp-content/uploads/2020/08/peach.png'),
(1, 'Apple', 1.29, 'https://www.applesfromny.com/wp-content/uploads/2020/05/20Ounce_NYAS-Apples2.png'),
(3, 'Avocado', 0.99, 'https://images.immediate.co.uk/production/volatile/sites/30/2020/02/Avocados-3d84a3a.jpg?quality=90&resize=556,505'),
(4, 'Banana', 1.46, 'https://shop.powerdoo.info/wp-content/uploads/2021/04/banana.jpg'),
(5, 'Orange', 1, 'https://www.quanta.org/orange/orange.jpg'),
(6, 'Lemon', 1.69, 'https://www.producemarketguide.com/media/user_5q6Kv4eMkN/241/lemon_commodity-page.png'),
(8, 'Strawberry', 1.99, 'https://admin.acceleratingscience.com/food/wp-content/uploads/sites/5/2015/08/single_strawberry__isolated_on_a_white_background.jpg'),
(9, 'Pineapple', 1.99, 'https://m.media-amazon.com/images/I/71+qAJehpkL.jpg'),
(10, 'Lettuce', 0.89, 'https://cdn.britannica.com/77/170677-050-F7333D51/lettuce.jpg'),
(11, 'Onion', 1.39, 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/25/Onion_on_White.JPG/1200px-Onion_on_White.JPG'),
(12, 'Carrot', 1.39, 'https://seed2plant.in/cdn/shop/products/carrotseeds.jpg?v=1604032858');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `address` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(30) NOT NULL,
  `item_price` float NOT NULL,
  `item_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`) VALUES
(1, 'admin@admin.com', 'admin123', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
