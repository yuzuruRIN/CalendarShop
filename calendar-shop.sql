-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2024 at 04:54 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `calendar-shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `status` int(255) NOT NULL COMMENT '1=ยังขายอยู่ 0=ยกเลิกการขายแล้ว'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `price`, `img`, `category_id`, `amount`, `status`) VALUES
(1, 'ปฏิทินแบบตั้งโต๊ะสำหรับโต๊ะทำงาน', 100, '66324a8a189d88.41149790.png', 1, 10, 0),
(2, 'ปฏิทินแบบตั้งโต๊ะสำหรับโต๊ะทำงาน ปี2562', 100, '6632519b79ec99.70421834.png', 1, 10, 0),
(3, 'ปฏิทินแบบแขวน ปี2559', 80, '663251dae6fd20.22307950.jpg', 2, 20, 0),
(4, 'ปฏิทินแบบแขวน ปี2564', 80, '663251f6af3260.91758946.png', 2, 25, 0),
(5, 'ปฏิทินแบบตั้งโต๊ะ แบบแขวน ต้อนรับตรุษจีน', 80, '6632522dc2f7e4.71413660.png', 2, 30, 0),
(6, 'ปฏิทินพวงกุญแจแบบพกพา', 10, '66325254988211.66215510.jpg', 3, 0, 1),
(7, 'ปฏิทินแบบโปสเตอรดีไซต์สวยงามทันสมัย', 50, '663252863217e7.96507292.jpg', 4, 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `category_id` int(255) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`category_id`, `category_name`) VALUES
(1, 'ปฏิทินแบบตั้งโต๊ะ'),
(2, 'ปฏิทินแบบแขวน'),
(3, 'ปฏิทินแบบพกพา'),
(4, 'ปฏิทินแบบโปสเตอร');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `category_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
