-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 06:51 PM
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
-- Database: `jdrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `ADMIN_ID` varchar(100) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `ADMIN_ID`, `PASSWORD`, `name`) VALUES
(1, 'andrei', '123', 'Andrei'),
(2, 'glenn', '321', 'Glenn');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CUST_NUM` int(100) NOT NULL,
  `LAST_NAME` varchar(100) NOT NULL,
  `FIRST_NAME` varchar(100) NOT NULL,
  `MIDDLE_NAME` varchar(100) NOT NULL,
  `BIRTHDAY` date NOT NULL,
  `COMPANY` varchar(100) NOT NULL,
  `COMPANY_LOCATION` varchar(100) NOT NULL,
  `PHONE` varchar(15) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `RESIDENT_LOCATION` varchar(100) NOT NULL,
  `MODE_OF_PAY` varchar(20) NOT NULL,
  `ADD_INFO` varchar(200) NOT NULL,
  `IMG` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CUST_NUM`, `LAST_NAME`, `FIRST_NAME`, `MIDDLE_NAME`, `BIRTHDAY`, `COMPANY`, `COMPANY_LOCATION`, `PHONE`, `EMAIL`, `RESIDENT_LOCATION`, `MODE_OF_PAY`, `ADD_INFO`, `IMG`) VALUES
(1, 'Gopez', 'Glenn', 'Cosme', '2024-02-28', 'dfgsd', 'sf', '4242', 'glenngopez@gmail.com', 'sf', 'sf', 'sf', '1.png');

-- --------------------------------------------------------

--
-- Table structure for table `customer_orders`
--

CREATE TABLE `customer_orders` (
  `ORDER_NUM` int(11) NOT NULL,
  `FURNITURE_ID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `TOTAL_COST` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_orders`
--

INSERT INTO `customer_orders` (`ORDER_NUM`, `FURNITURE_ID`, `QUANTITY`, `TOTAL_COST`) VALUES
(1, 2, 1, 7500.00),
(2, 2, 2, 100500.00),
(3, 3, 1, 2850.00),
(4, 4, 1, 3998.00),
(5, 5, 4, 13950.00),
(6, 6, 1, 24999.00),
(7, 7, 1, 1999.00),
(8, 8, 1, 13699.00),
(9, 9, 12, 3504.00),
(456, 41, 2, 2626.00),
(457, 42, 1, 2.00),
(457, 43, 1, 1221.00);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `USERNAME` varchar(100) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `CONFIRM_PASSWORD` varchar(100) NOT NULL,
  `LAST_NAME` varchar(100) NOT NULL,
  `FIRST_NAME` varchar(100) NOT NULL,
  `MIDDLE_NAME` varchar(100) NOT NULL,
  `IMG` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `USERNAME`, `PASSWORD`, `CONFIRM_PASSWORD`, `LAST_NAME`, `FIRST_NAME`, `MIDDLE_NAME`, `IMG`) VALUES
(1, 'art', '456', '', '', 'Artryan', '', ''),
(2, 'monsi', '654', '', '', 'Raymond', '', ''),
(3, 'dfd', 'dfd', 'dfd', 'dfd', 'fdf', 'df', ''),
(4, 'sds', 'sds', 'sds', 'sdsd', 'sds', 'sds', ''),
(5, 'dfdfff', 'dfd', 'dfd', 'dfdffff', 'dfd', 'dfdf', '5.png'),
(6, 'dfd', 'fdf', 'fdf', 'fdf', 'fdf', 'fdf', '6.jpg'),
(7, 'sfsd', 'dsds', '', 'xcx', 'xcx', 'xcxc', '7.png'),
(34, 'sfsd', 'dsds', '', 'xcx', 'xcx', 'xcxc', '7.png'),
(35, 'df', 'df', '', 'df', 'df', 'df', '35.png'),
(36, 'df', 'df', '', 'df', 'df', 'df', '36.png'),
(37, 'df', 'df', '', 'df', 'df', 'df', '37.png'),
(38, 'dfdfff', 'dfd', '', 'dfdffff', 'dfd', 'dfdf', '38.png'),
(39, 'rere', 'rere', '', 'df', 'df', 'tuliao', '39.png');

-- --------------------------------------------------------

--
-- Table structure for table `furnitures`
--

CREATE TABLE `furnitures` (
  `FURNITURE_ID` int(11) NOT NULL,
  `FURNITURE_NAME` varchar(255) NOT NULL,
  `PRICE` decimal(10,2) NOT NULL,
  `MATERIAL` varchar(255) NOT NULL,
  `COLOR` varchar(255) NOT NULL,
  `STYLE` varchar(255) NOT NULL,
  `FEATURES` varchar(4000) NOT NULL,
  `FURNITURE_IMG` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `furnitures`
--

INSERT INTO `furnitures` (`FURNITURE_ID`, `FURNITURE_NAME`, `PRICE`, `MATERIAL`, `COLOR`, `STYLE`, `FEATURES`, `FURNITURE_IMG`) VALUES
(1, 'Chair', 7500.00, 'Wood', 'Red', 'Filipino', 'Experience the epitome of comfort and style with our chair, meticulously designed to enhance every moment of relaxation or productivity. Crafted with a sturdy yet elegant frame, it offers durability and aesthetic appeal in equal measure. Sink into its plush upholstery, available in a range of luxurious fabrics and finishes, and feel supported by its ergonomic design, promoting proper posture and reducing strain. Adjustable elements cater to individual preferences, while sleek contours and thoughtful details add a touch of sophistication to any room. Whether lounging in the living room or commanding the boardroom, our chair is the perfect fusion of form and function, inviting you to indulge in moments of tranquility or tackle tasks with renewed vigor.\n\n\n\n\n\n\n', '1.png'),
(2, 'Sofa', 50250.00, 'Leather', 'Red', 'Sectional', 'Indulge in the epitome of relaxation with our luxurious sofa, meticulously crafted to marry comfort and style effortlessly. Sink into the plush cushions enveloped in premium upholstery, offering a sumptuous embrace after a long day. Its spacious design accommodates gatherings with loved ones or solitary moments of tranquility, while the sturdy frame ensures durability for years to come.', '2.png'),
(3, 'Table', 2850.00, 'Glass', 'Black', 'Modern', 'Behold the table, a timeless centerpiece of functionality and style. Crafted with precision and care, its sturdy surface offers a canvas for culinary creations, study sessions, and heartfelt conversations alike. From sleek minimalist designs to intricately carved masterpieces, tables come in an array of styles to suit every taste and space. ', '3.png'),
(4, 'Coffee Table', 3998.00, '', '', '', '', '4.png\r\n'),
(5, 'Cabinet', 3487.50, '', '', '', '', '5.png'),
(6, 'Dining Set', 24999.00, '', '', '', '', '6.png'),
(7, 'Clock', 1999.00, '', '', '', '', '7.png'),
(8, 'Baby Rocker', 13699.00, '', '', '', '', '8.png'),
(9, 'Stool', 292.00, '', '', '', '', '9.png'),
(41, 'asdad', 1313.00, 'cow', 'browny', '', 'kpop idol', '41.jfif'),
(42, 'asdasd1', 2.00, 'sofasf', 'awdq', '', 'asd', '42.jfif'),
(43, 'asdsad', 1221.00, 'xczxc', 'asd', '', 'asdsd', '43.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ORDER_NUM` int(11) NOT NULL,
  `CUST_NUM` int(255) NOT NULL,
  `ORDER_DATE` date NOT NULL,
  `EST_DATE` date NOT NULL,
  `ORDER_COST` decimal(10,2) NOT NULL,
  `STATUS` varchar(30) NOT NULL,
  `ADD_INFO` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ORDER_NUM`, `CUST_NUM`, `ORDER_DATE`, `EST_DATE`, `ORDER_COST`, `STATUS`, `ADD_INFO`) VALUES
(1, 1, '2015-04-16', '2024-02-04', 7500.00, 'Shipping', 'Please deliver near white porch.'),
(2, 1, '2016-05-19', '2024-02-04', 100500.00, 'Pending', ''),
(3, 1, '2016-08-07', '2024-02-04', 0.00, 'Delivered', ''),
(4, 1, '2016-06-02', '2024-02-04', 3998.00, 'Delivered', ''),
(6, 1, '2018-03-14', '2024-02-04', 24999.00, 'Delivered', ''),
(9, 1, '2020-08-06', '2024-02-04', 3504.00, 'Delivered', ''),
(454, 1, '2024-04-24', '2024-04-10', 0.00, 'Out For Delivery', 'adsfasdf'),
(455, 1, '2024-04-24', '2024-04-10', 0.00, 'Out For Delivery', 'adfasdf'),
(456, 1, '2024-04-24', '2024-04-11', 2626.00, 'Shipping', 'ghghgh'),
(457, 1, '2024-04-24', '2024-04-02', 1223.00, 'Delivered', 'asd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CUST_NUM`);

--
-- Indexes for table `customer_orders`
--
ALTER TABLE `customer_orders`
  ADD PRIMARY KEY (`ORDER_NUM`,`FURNITURE_ID`),
  ADD KEY `FK_PK2` (`FURNITURE_ID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `furnitures`
--
ALTER TABLE `furnitures`
  ADD PRIMARY KEY (`FURNITURE_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ORDER_NUM`),
  ADD KEY `CUST_NUM` (`CUST_NUM`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CUST_NUM` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `furnitures`
--
ALTER TABLE `furnitures`
  MODIFY `FURNITURE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ORDER_NUM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=458;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
