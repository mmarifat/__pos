-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2019 at 11:29 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `addedTime` datetime DEFAULT current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `image`, `code`, `name`, `addedBy`, `addedTime`, `deleted`) VALUES
(1, 'c8479467a338ffd7dfa572d441149d01.jpg', 'Soft Drinks', 'All Kinds of Soft Drinks', 2, '2019-12-04 14:06:22', 0),
(2, 'c4928d39e5b1a5dd602a285eb77b61b4.png', 'General Store', 'All general store items', 2, '2019-12-04 14:06:45', 0),
(3, 'e7380c7ba202e13ea7e793ab75ffadca.jpg', 'Service', 'Service related', 2, '2019-12-04 14:07:06', 0),
(4, '3f13dbafd29ccaf4a6f5a4a1d2d9e1ca.jpg', 'Chips', 'All kinds of chips', 2, '2019-12-04 14:15:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `addedTime` datetime DEFAULT current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `contact`, `address`, `addedBy`, `addedTime`, `deleted`) VALUES
(1, 'Walk-In-Customer', NULL, NULL, NULL, 1, '2019-12-04 13:53:28', 0),
(2, 'Rahim', 'rahim@yahoo.com', '0174859632', 'Kapasia, Gazipur', 2, '2019-12-04 13:54:55', 0),
(3, 'Karim', 'karim@hotmail.com', '0134512478', 'Dhaka', 2, '2019-12-04 13:55:18', 0),
(4, 'Fahad', 'fahad@gmail.com', '0134578556', 'Gazipur', 2, '2019-12-04 13:55:44', 0),
(5, 'Abid', 'abid@gmail.com', '014785684', 'Kapasia, Gazipur', 2, '2019-12-04 14:03:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `date` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `addedTime` datetime DEFAULT current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `date`, `reference`, `amount`, `note`, `addedBy`, `addedTime`, `deleted`) VALUES
(1, '2019-12-04', 'EXP-190412S51L0001', 500, 'Ex1', 2, '2019-12-04 14:48:36', 0),
(2, '2019-12-11', 'EXP-1911125BO70002', 500, 'polithin', 2, '2019-12-11 22:12:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `saleID` int(11) DEFAULT NULL,
  `customerID` int(11) DEFAULT NULL,
  `addedDate` datetime DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `due` double DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `adBy` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `saleID`, `customerID`, `addedDate`, `amount`, `due`, `note`, `adBy`, `deleted`) VALUES
(1, 1, 2, '2019-12-04 14:36:21', 500, NULL, '', 2, 0),
(2, 2, 5, '2019-12-04 14:37:15', 1000, NULL, '', 2, 0),
(3, 3, 1, '2019-12-04 14:46:57', 1000, NULL, '', 2, 0),
(4, 4, 4, '2019-12-04 14:47:29', 150, 20, '', 2, 0),
(5, 5, 3, '2019-12-04 14:47:41', 200, 90, '', 2, 0),
(6, 6, 1, '2019-12-10 11:23:36', 200, NULL, '', 2, 0),
(7, 7, 3, '2019-12-10 11:24:01', 165, 0, '', 2, 0),
(8, 8, 1, '2019-12-11 22:14:59', 1000, NULL, '', 2, 0),
(9, 9, 3, '2019-12-11 22:19:05', 500, 380, '', 2, 0),
(10, 10, 1, '2019-12-11 22:33:14', 300, NULL, '', 2, 0),
(11, 11, 1, '2019-12-18 09:38:17', 500, NULL, '', 2, 0),
(12, 12, 1, '2019-12-18 10:00:14', 550, NULL, '', 2, 0),
(13, 13, 1, '2019-12-18 10:00:39', 80, NULL, '', 2, 0),
(14, 14, 3, '2019-12-18 10:01:33', 200, 37, '', 2, 0),
(15, 15, 1, '2019-12-19 21:25:42', 175, NULL, '', 2, 0),
(16, 16, 1, '2019-12-20 23:58:26', 300, NULL, '', 2, 0),
(17, 17, 5, '2019-12-20 23:58:48', 250, 30, '', 2, 0),
(18, 18, 4, '2019-12-22 09:36:33', 1000, NULL, '', 2, 0),
(19, 19, 1, '2019-12-23 10:08:34', 300, NULL, '', 2, 0),
(20, 20, 3, '2019-12-23 15:41:55', 170, NULL, '', 2, 0),
(21, 21, 1, '2019-12-23 16:27:00', 110, NULL, '', 4, 0),
(22, 22, 4, '2019-12-23 16:27:19', 150, NULL, '', 4, 0),
(23, 23, 3, '2019-12-23 16:27:48', 165, NULL, '', 4, 0),
(24, 24, 1, '2019-12-23 16:28:25', 170, NULL, '', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `addedTime` datetime DEFAULT current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `image`, `code`, `name`, `type`, `category`, `quantity`, `cost`, `price`, `addedBy`, `addedTime`, `deleted`) VALUES
(1, 'a2026fd01ca58a28fcbeaf07964d9626.jpg', 'P0412P1', 'Coca Cola [CAN]', 'product', '1', 141, 19, 25, 2, '2019-12-04 14:27:10', 0),
(2, '7b1c6beecb8d78960fae368ba1c56c63.jpg', 'P0412P2', 'Coca Cola [GLASS - BOTTLE]', 'product', '1', 148, 16, 20, 2, '2019-12-04 14:27:32', 0),
(3, '4f8af4c22b78a4c7f9f8285bb5df5255.jpg', 'P0412H3', 'Coca Cola [BOTTLE - 1lt]', 'product', '1', 46, 51, 55, 2, '2019-12-04 14:28:07', 0),
(4, 'f796a29bb8bded7e2b01c6fb6d1d56ce.png', 'P0412Y4', 'Sprite [BOTTLE - 400ml]', 'product', '1', 140, 23, 25, 2, '2019-12-04 14:28:24', 0),
(5, '4e757f645dac3987cf72289602fef31e.jpg', 'P0412Q5', 'Dew [BOTTLE - 500ml]', 'product', '1', 112, 27, 30, 2, '2019-12-04 14:29:07', 0),
(6, '219058c0ff095827abc2f8581196e75a.jpg', 'P0412I6', 'চাষী চিনিগুড়া চাল [১ কেজি]', 'product', '2', 193, 98, 110, 2, '2019-12-04 14:29:18', 0),
(7, '2a1bece5e4ba72b00555903ac4ecf55f.jpg', 'P0412Z7', 'ফ্রেশ চিনিগুড়া চাল [১ কেজি]', 'product', '2', 493, 95, 108, 2, '2019-12-04 14:29:30', 0),
(8, '5958289c654ecdeeaa2e9d116a885b2e.jpg', 'P0412M8', 'Sprite [CAN]', 'product', '1', 79, 28, 35, 2, '2019-12-04 14:29:42', 0),
(9, '6e90c9c01098c6707d5058c14d00f165.jpg', 'P0412P9', 'ক্রিকেট বল ', 'product', '2', 41, 38, 50, 2, '2019-12-04 14:30:00', 0),
(10, 'fe672655d80cfeeb9eabb0f50ac6029e.png', 'P0412I10', 'Sun Chips', 'product', '4', 96, 21, 25, 2, '2019-12-04 14:30:12', 0),
(11, '9c8ca2740c27aad907d33a8ea999f3f3.jpg', 'P0412611', 'Maggie [Small Pack]', 'product', '2', 694, 14, 17, 2, '2019-12-04 14:30:24', 0),
(12, '46276b98915b44f5c60692ca5fb7d43d.jpg', 'P0412312', 'Maggie [Large Pack]', 'product', '2', 95, 60, 65, 2, '2019-12-04 14:30:36', 0),
(13, '713a87133434209c40d8118d9993615a.jpg', 'P0412O13', 'Molla Super Salt', 'product', '2', 116, 17, 21, 2, '2019-12-04 14:30:48', 0),
(14, 'bc7aae9caa87016d6b19529df562a8dc.jpg', 'P0412U14', 'রুচি চানাচুর', 'product', '2', 40, 3.75, 5, 2, '2019-12-04 14:30:58', 0),
(15, '8831a6abf999f3ad0ebacdaef5b9c04f.jpg', 'P0412I15', 'রুচি চিকেন কারি পেস্ট', 'product', '2', 442, 75, 80, 2, '2019-12-04 14:31:10', 0),
(16, '5c95a74d751fa7c3ccd3a3fde1182ecf.jpg', 'P0412H16', 'রুচি রেড চিলি সস', 'product', '2', 118, 50, 55, 2, '2019-12-04 14:31:22', 0),
(17, '5e5c2ec9f04d61afdae43f5923883a29.jpg', 'P0412O17', 'Dairy Milk [Large]', 'product', '2', 1245, 75, 90, 2, '2019-12-04 14:31:39', 0),
(18, NULL, 'P0412E18', 'Test Item 1', 'product', '2', 11, 5, 6, 2, '2019-12-04 14:31:50', 0),
(19, NULL, 'P0412319', 'Test Item 2', 'product', '2', 121, 10, 12, 2, '2019-12-04 14:32:01', 0),
(20, NULL, 'P0412320', 'Test Item 3', 'product', '2', 194, 12, 14, 2, '2019-12-04 14:32:11', 0),
(21, NULL, 'P0412X21', 'Test Item 4', 'product', '2', 58, 241, 250, 2, '2019-12-04 14:32:19', 0),
(22, NULL, 'P0412122', 'Test Item 5', 'product', '2', 22, 121, 140, 2, '2019-12-04 14:32:31', 0),
(23, NULL, 'P0412Z23', 'Test Item 6', 'product', '2', 8, 155, 170, 2, '2019-12-04 14:32:42', 0),
(24, NULL, 'P2312I24', 'fyj', 'product', '2', 200, 15, 19.99, 2, '2019-12-23 15:31:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `date` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `product` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` double DEFAULT NULL,
  `totalAmount` double DEFAULT NULL,
  `vendor` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `received` int(11) DEFAULT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `addedTime` datetime DEFAULT current_timestamp(),
  `deleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `date`, `reference`, `product`, `total`, `totalAmount`, `vendor`, `received`, `addedBy`, `addedTime`, `deleted`) VALUES
(1, '2019-12-04', 'PUR-190412CGB60001', '1', 150, 2850, '2', 1, 2, '2019-12-04 14:27:10', 0),
(2, '2019-12-04', 'PUR-190412PH910002', '2', 154, 2464, '2', 1, 2, '2019-12-04 14:27:32', 0),
(3, '2019-12-04', 'PUR-190412U0VZ0003', '3', 75, 3825, '2', 1, 2, '2019-12-04 14:28:07', 0),
(4, '2019-12-04', 'PUR-1904120Z6V0004', '4', 147, 3381, '3', 1, 2, '2019-12-04 14:28:24', 0),
(5, '2019-12-04', 'PUR-190412R1MT0005', '5', 125, 3375, '11', 1, 2, '2019-12-04 14:29:07', 0),
(6, '2019-12-04', 'PUR-190412OKJD0006', '6', 200, 19600, '8', 1, 2, '2019-12-04 14:29:18', 0),
(7, '2019-12-04', 'PUR-190412JREP0007', '7', 500, 47500, '4', 1, 2, '2019-12-04 14:29:30', 0),
(8, '2019-12-04', 'PUR-190412ND260008', '8', 90, 2520, '3', 1, 2, '2019-12-04 14:29:42', 0),
(9, '2019-12-04', 'PUR-190412FTW60009', '9', 48, 1824, '1', 1, 2, '2019-12-04 14:30:00', 0),
(10, '2019-12-04', 'PUR-190412RPEN0010', '10', 101, 2121, '7', 1, 2, '2019-12-04 14:30:12', 0),
(11, '2019-12-04', 'PUR-1904127PSR0011', '11', 700, 9800, '9', 1, 2, '2019-12-04 14:30:24', 0),
(12, '2019-12-04', 'PUR-190412MS0L0012', '12', 98, 5880, '9', 1, 2, '2019-12-04 14:30:36', 0),
(13, '2019-12-04', 'PUR-190412YWJG0013', '13', 121, 2057, '10', 1, 2, '2019-12-04 14:30:48', 0),
(14, '2019-12-04', 'PUR-190412ARSO0014', '14', 45, 168.75, '5', 1, 2, '2019-12-04 14:30:58', 0),
(15, '2019-12-04', 'PUR-190412NA430015', '15', 450, 33750, '5', 1, 2, '2019-12-04 14:31:10', 0),
(16, '2019-12-04', 'PUR-1904122WYF0016', '16', 125, 6250, '5', 0, 2, '2019-12-04 14:31:22', 0),
(17, '2019-12-04', 'PUR-190412I3VF0017', '17', 1254, 94050, '1', 0, 2, '2019-12-04 14:31:39', 0),
(18, '2019-12-04', 'PUR-190412SW1Y0018', '18', 12, 60, '1', 0, 2, '2019-12-04 14:31:50', 0),
(19, '2019-12-04', 'PUR-190412XM4N0019', '19', 124, 1240, '1', 1, 2, '2019-12-04 14:32:01', 0),
(20, '2019-12-04', 'PUR-190412VIEF0020', '20', 200, 2400, '1', 1, 2, '2019-12-04 14:32:11', 0),
(21, '2019-12-04', 'PUR-190412FBYK0021', '21', 58, 13978, '1', 1, 2, '2019-12-04 14:32:19', 0),
(22, '2019-12-04', 'PUR-1904121PRU0022', '22', 25, 3025, '1', 1, 2, '2019-12-04 14:32:31', 0),
(23, '2019-12-04', 'PUR-19041219ZD0023', '23', 12, 1860, '1', 1, 2, '2019-12-04 14:32:42', 0),
(24, '2019-12-23', 'PUR-1923127RJ00024', '24', 200, 3000, '1', 0, 2, '2019-12-23 15:31:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `saleitems`
--

CREATE TABLE `saleitems` (
  `id` int(11) NOT NULL,
  `saleID` int(11) DEFAULT NULL,
  `saleDate` datetime DEFAULT NULL,
  `productID` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `orgSubTotal` double DEFAULT NULL,
  `salePrice` double DEFAULT NULL,
  `subTotal` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `addBy` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `saleitems`
--

INSERT INTO `saleitems` (`id`, `saleID`, `saleDate`, `productID`, `qty`, `cost`, `orgSubTotal`, `salePrice`, `subTotal`, `discount`, `addBy`, `deleted`) VALUES
(1, 1, '2019-12-04 14:36:21', 1, 2, 19, 38, 25, 50, 0, 2, 0),
(2, 1, '2019-12-04 14:36:21', 2, 2, 16, 32, 20, 40, 0, 2, 0),
(3, 1, '2019-12-04 14:36:21', 3, 2, 51, 102, 55, 110, 0, 2, 0),
(4, 1, '2019-12-04 14:36:21', 4, 2, 23, 46, 25, 50, 0, 2, 0),
(5, 1, '2019-12-04 14:36:21', 8, 2, 28, 56, 35, 70, 0, 2, 0),
(6, 1, '2019-12-04 14:36:21', 13, 2, 17, 34, 21, 42, 0, 2, 0),
(7, 1, '2019-12-04 14:36:21', 19, 2, 10, 20, 12, 24, 0, 2, 0),
(8, 1, '2019-12-04 14:36:21', 20, 2, 12, 24, 14, 28, 0, 2, 0),
(9, 2, '2019-12-04 14:37:15', 6, 2, 98, 196, 109, 218, 2, 2, 0),
(10, 2, '2019-12-04 14:37:15', 7, 3, 95, 285, 108, 324, 0, 2, 0),
(11, 2, '2019-12-04 14:37:15', 9, 2, 38, 76, 50, 100, 0, 2, 0),
(12, 2, '2019-12-04 14:37:15', 15, 2, 75, 150, 80, 160, 0, 2, 0),
(13, 2, '2019-12-04 14:37:15', 16, 2, 50, 100, 55, 110, 0, 2, 0),
(14, 3, '2019-12-04 14:46:57', 6, 2, 98, 196, 110, 220, 0, 2, 0),
(15, 3, '2019-12-04 14:46:57', 15, 2, 75, 150, 80, 160, 0, 2, 0),
(16, 3, '2019-12-04 14:46:57', 23, 3, 155, 465, 169, 507, 3, 2, 0),
(17, 4, '2019-12-04 14:47:29', 2, 2, 16, 32, 20, 40, 0, 2, 0),
(18, 4, '2019-12-04 14:47:29', 8, 2, 28, 56, 35, 70, 0, 2, 0),
(19, 4, '2019-12-04 14:47:29', 11, 2, 14, 28, 17, 34, 0, 2, 0),
(20, 4, '2019-12-04 14:47:29', 20, 2, 12, 24, 14, 28, 0, 2, 0),
(21, 5, '2019-12-04 14:47:41', 3, 2, 51, 102, 55, 110, 0, 2, 0),
(22, 5, '2019-12-04 14:47:41', 17, 2, 75, 150, 90, 180, 0, 2, 0),
(23, 6, '2019-12-10 11:23:36', 9, 2, 38, 76, 48, 96, 4, 2, 0),
(24, 6, '2019-12-10 11:23:36', 14, 2, 3.75, 7.5, 5, 10, 0, 2, 0),
(25, 7, '2019-12-10 11:24:01', 3, 3, 51, 153, 55, 165, 0, 2, 0),
(26, 8, '2019-12-11 22:14:59', 1, 3, 19, 57, 25, 75, 0, 2, 0),
(27, 8, '2019-12-11 22:14:59', 3, 6, 51, 306, 53, 318, 12, 2, 0),
(28, 9, '2019-12-11 22:19:05', 3, 2, 51, 102, 55, 110, 0, 2, 0),
(29, 9, '2019-12-11 22:19:05', 4, 1, 23, 23, 25, 25, 0, 2, 0),
(30, 9, '2019-12-11 22:19:05', 5, 2, 27, 54, 30, 60, 0, 2, 0),
(31, 9, '2019-12-11 22:19:05', 6, 2, 98, 196, 109, 218, 2, 2, 0),
(32, 9, '2019-12-11 22:19:05', 7, 2, 95, 190, 108, 216, 0, 2, 0),
(33, 9, '2019-12-11 22:19:05', 10, 1, 21, 21, 25, 25, 0, 2, 0),
(34, 9, '2019-12-11 22:19:05', 17, 1, 75, 75, 90, 90, 0, 2, 0),
(35, 9, '2019-12-11 22:19:05', 22, 1, 121, 121, 140, 140, 0, 2, 0),
(36, 10, '2019-12-11 22:33:14', 1, 2, 19, 38, 25, 50, 0, 2, 0),
(37, 10, '2019-12-11 22:33:14', 8, 2, 28, 56, 35, 70, 0, 2, 0),
(38, 10, '2019-12-11 22:33:14', 11, 1, 14, 14, 17, 17, 0, 2, 0),
(39, 10, '2019-12-11 22:33:14', 12, 1, 60, 60, 65, 65, 0, 2, 0),
(40, 10, '2019-12-11 22:33:14', 13, 1, 17, 17, 21, 21, 0, 2, 0),
(41, 10, '2019-12-11 22:33:14', 18, 1, 5, 5, 6, 6, 0, 2, 0),
(42, 11, '2019-12-18 09:38:17', 6, 1, 98, 98, 110, 110, 0, 2, 0),
(43, 11, '2019-12-18 09:38:17', 8, 1, 28, 28, 35, 35, 0, 2, 0),
(44, 11, '2019-12-18 09:38:17', 10, 1, 21, 21, 25, 25, 0, 2, 0),
(45, 11, '2019-12-18 09:38:17', 15, 1, 75, 75, 80, 80, 0, 2, 0),
(46, 11, '2019-12-18 09:38:17', 16, 1, 50, 50, 55, 55, 0, 2, 0),
(47, 11, '2019-12-18 09:38:17', 19, 1, 10, 10, 12, 12, 0, 2, 0),
(48, 11, '2019-12-18 09:38:17', 23, 1, 155, 155, 170, 170, 0, 2, 0),
(49, 12, '2019-12-18 10:00:14', 3, 1, 51, 51, 55, 55, 0, 2, 0),
(50, 12, '2019-12-18 10:00:14', 4, 1, 23, 23, 25, 25, 0, 2, 0),
(51, 12, '2019-12-18 10:00:14', 5, 1, 27, 27, 30, 30, 0, 2, 0),
(52, 12, '2019-12-18 10:00:14', 7, 2, 95, 190, 108, 216, 0, 2, 0),
(53, 12, '2019-12-18 10:00:14', 9, 2, 38, 76, 50, 100, 0, 2, 0),
(54, 12, '2019-12-18 10:00:14', 14, 2, 3.75, 7.5, 5, 10, 0, 2, 0),
(55, 12, '2019-12-18 10:00:14', 16, 2, 50, 100, 55, 110, 0, 2, 0),
(56, 13, '2019-12-18 10:00:39', 3, 1, 51, 51, 55, 55, 0, 2, 0),
(57, 13, '2019-12-18 10:00:39', 4, 1, 23, 23, 25, 25, 0, 2, 0),
(58, 14, '2019-12-18 10:01:33', 1, 1, 19, 19, 25, 25, 0, 2, 0),
(59, 14, '2019-12-18 10:01:33', 3, 1, 51, 51, 55, 55, 0, 2, 0),
(60, 14, '2019-12-18 10:01:33', 10, 2, 21, 42, 25, 50, 0, 2, 0),
(61, 14, '2019-12-18 10:01:33', 11, 1, 14, 14, 17, 17, 0, 2, 0),
(62, 14, '2019-12-18 10:01:33', 17, 1, 75, 75, 90, 90, 0, 2, 0),
(63, 15, '2019-12-19 21:25:42', 4, 1, 23, 23, 25, 25, 0, 2, 0),
(64, 15, '2019-12-19 21:25:42', 8, 1, 28, 28, 35, 35, 0, 2, 0),
(65, 15, '2019-12-19 21:25:42', 10, 1, 21, 21, 25, 25, 0, 2, 0),
(66, 15, '2019-12-19 21:25:42', 17, 1, 75, 75, 90, 90, 0, 2, 0),
(67, 16, '2019-12-20 23:58:26', 2, 2, 16, 32, 20, 40, 0, 2, 0),
(68, 16, '2019-12-20 23:58:26', 11, 2, 14, 28, 17, 34, 0, 2, 0),
(69, 16, '2019-12-20 23:58:26', 17, 2, 75, 150, 90, 180, 0, 2, 0),
(70, 16, '2019-12-20 23:58:26', 20, 2, 12, 24, 14, 28, 0, 2, 0),
(71, 17, '2019-12-20 23:58:48', 1, 1, 19, 19, 25, 25, 0, 2, 0),
(72, 17, '2019-12-20 23:58:48', 3, 1, 51, 51, 55, 55, 0, 2, 0),
(73, 17, '2019-12-20 23:58:48', 9, 1, 38, 38, 50, 50, 0, 2, 0),
(74, 17, '2019-12-20 23:58:48', 12, 1, 60, 60, 65, 65, 0, 2, 0),
(75, 17, '2019-12-20 23:58:48', 14, 1, 3.75, 3.75, 5, 5, 0, 2, 0),
(76, 17, '2019-12-20 23:58:48', 15, 1, 75, 75, 80, 80, 0, 2, 0),
(77, 18, '2019-12-22 09:36:33', 3, 1, 51, 51, 55, 55, 0, 2, 0),
(78, 18, '2019-12-22 09:36:33', 4, 1, 23, 23, 25, 25, 0, 2, 0),
(79, 18, '2019-12-22 09:36:33', 5, 1, 27, 27, 30, 30, 0, 2, 0),
(80, 18, '2019-12-22 09:36:33', 8, 1, 28, 28, 35, 35, 0, 2, 0),
(81, 18, '2019-12-22 09:36:33', 12, 1, 60, 60, 65, 65, 0, 2, 0),
(82, 18, '2019-12-22 09:36:33', 15, 2, 75, 150, 80, 160, 0, 2, 0),
(83, 18, '2019-12-22 09:36:33', 16, 2, 50, 100, 55, 110, 0, 2, 0),
(84, 18, '2019-12-22 09:36:33', 22, 2, 121, 242, 140, 280, 0, 2, 0),
(85, 19, '2019-12-23 10:08:34', 8, 2, 28, 56, 35, 70, 0, 2, 0),
(86, 19, '2019-12-23 10:08:34', 13, 2, 17, 34, 21, 42, 0, 2, 0),
(87, 19, '2019-12-23 10:08:34', 17, 2, 75, 150, 90, 180, 0, 2, 0),
(88, 20, '2019-12-23 15:41:55', 3, 2, 51, 102, 55, 110, 0, 2, 0),
(89, 20, '2019-12-23 15:41:55', 5, 2, 27, 54, 30, 60, 0, 2, 0),
(90, 21, '2019-12-23 16:27:00', 3, 2, 51, 102, 55, 110, 0, 4, 0),
(91, 22, '2019-12-23 16:27:19', 5, 5, 27, 135, 30, 150, 0, 4, 0),
(92, 23, '2019-12-23 16:27:48', 3, 3, 51, 153, 55, 165, 0, 4, 0),
(93, 24, '2019-12-23 16:28:25', 3, 2, 51, 102, 55, 110, 0, 3, 0),
(94, 24, '2019-12-23 16:28:25', 5, 2, 27, 54, 30, 60, 0, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `customerID` int(11) DEFAULT NULL,
  `paymentStatus` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `saleNote` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` double DEFAULT NULL,
  `orderedDiscount` double DEFAULT NULL,
  `grandTotal` double DEFAULT NULL,
  `orgCostTotal` double DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `itemType` int(11) DEFAULT NULL,
  `staffNote` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `date`, `customerID`, `paymentStatus`, `reference`, `saleNote`, `total`, `orderedDiscount`, `grandTotal`, `orgCostTotal`, `item`, `itemType`, `staffNote`, `addedBy`, `deleted`) VALUES
(1, '2019-12-04 14:36:21', 2, 'Paid', 'INV-190412XNYS0001', '', 414, 4, 410, 352, 16, 8, '', 2, 0),
(2, '2019-12-04 14:37:15', 5, 'Paid', 'INV-190412V5U00002', '', 912, 2, 910, 807, 11, 5, '', 2, 0),
(3, '2019-12-04 14:46:57', 1, 'Paid', 'INV-190412680O0003', 'Note 1', 887, 2, 885, 811, 7, 3, '', 2, 0),
(4, '2019-12-04 14:47:29', 4, 'Due', 'INV-190412YF450004', '', 172, 2, 170, 140, 8, 4, '', 2, 0),
(5, '2019-12-04 14:47:41', 3, 'Due', 'INV-1904123SZK0005', '', 290, 0, 290, 252, 4, 2, '', 2, 0),
(6, '2019-12-10 11:23:36', 1, 'Paid', 'INV-1910125DSB0006', '', 106, 6, 100, 83.5, 4, 2, '', 2, 0),
(7, '2019-12-10 11:24:01', 3, 'Paid', 'INV-191012T3610007', '', 165, 0, 165, 153, 3, 1, '', 2, 0),
(8, '2019-12-11 22:14:59', 1, 'Paid', 'INV-191112MC5K0008', '', 393, 3, 390, 363, 9, 2, '', 2, 0),
(9, '2019-12-11 22:19:05', 3, 'Due', 'INV-191112S6WA0009', '', 884, 4, 880, 782, 12, 8, '', 2, 0),
(10, '2019-12-11 22:33:14', 1, 'Paid', 'INV-1911123AIE0010', '', 229, 0, 229, 190, 8, 6, '', 2, 0),
(11, '2019-12-18 09:38:17', 1, 'Paid', 'INV-191812G4QO0011', '', 487, 0, 487, 437, 7, 7, '', 2, 0),
(12, '2019-12-18 10:00:14', 1, 'Paid', 'INV-191812SLDH0012', '', 546, 3, 543, 474.5, 11, 7, '', 2, 0),
(13, '2019-12-18 10:00:39', 1, 'Paid', 'INV-191812S9U10013', '', 80, 0, 80, 74, 2, 2, '', 2, 0),
(14, '2019-12-18 10:01:33', 3, 'Due', 'INV-191812CR440014', '', 237, 0, 237, 201, 6, 5, '', 2, 0),
(15, '2019-12-19 21:25:42', 1, 'Paid', 'INV-191912759Q0015', '', 175, 0, 175, 147, 4, 4, '', 2, 0),
(16, '2019-12-20 23:58:26', 1, 'Paid', 'INV-192012APAB0016', '', 282, 2, 280, 234, 8, 4, '', 2, 0),
(17, '2019-12-20 23:58:48', 5, 'Due', 'INV-192012WHLT0017', '', 280, 0, 280, 246.75, 6, 6, '', 2, 0),
(18, '2019-12-22 09:36:33', 4, 'Paid', 'INV-192212R5U60018', '', 760, 0, 760, 681, 11, 8, '', 2, 0),
(19, '2019-12-23 10:08:34', 1, 'Paid', 'INV-192312ZSIC0019', '', 292, 2, 290, 240, 6, 3, '', 2, 0),
(20, '2019-12-23 15:41:55', 3, 'Paid', 'INV-192312AG6U0020', '', 170, 0, 170, 156, 4, 2, '', 2, 0),
(21, '2019-12-23 16:27:00', 1, 'Paid', 'INV-192312KSI50021', '', 110, 0, 110, 102, 2, 1, '', 4, 0),
(22, '2019-12-23 16:27:19', 4, 'Paid', 'INV-1923124MSI0022', '', 150, 0, 150, 135, 5, 1, '', 4, 0),
(23, '2019-12-23 16:27:48', 3, 'Paid', 'INV-192312KFTS0023', '', 165, 0, 165, 153, 3, 1, '', 4, 0),
(24, '2019-12-23 16:28:25', 1, 'Paid', 'INV-192312L39C0024', '', 170, 0, 170, 156, 4, 2, '', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `favicon` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateBy` int(11) DEFAULT NULL,
  `addedTime` datetime DEFAULT current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `image`, `favicon`, `name`, `address`, `updateBy`, `addedTime`, `deleted`) VALUES
(1, '30a3006dedf7a5a5f6830cefef4989d5.svg', 'de454128d6b40b37f1f4585e5db10a46.ico', 'FnF Shop', 'Kapasia, Gazipur', 2, '2019-12-23 15:24:59', 0);

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `topBar` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `sideBar` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `centerBrand` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `colorBrand` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `borderMenu` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `flippedSideBar` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `footerOption` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`id`, `userID`, `topBar`, `sideBar`, `centerBrand`, `colorBrand`, `borderMenu`, `flippedSideBar`, `footerOption`) VALUES
(1, 1, 'navbar-light bg-white', 'menu-light', '', NULL, '', NULL, 'light'),
(2, 2, 'navbar-light bg-white', 'menu-light', 'navbar-brand-center', ' ', 'menu-bordered', 'static', 'light'),
(3, 3, 'navbar-light bg-white', 'menu-light', '', NULL, '', NULL, 'light'),
(4, 4, 'navbar-light bg-white', 'menu-light', '', NULL, '', NULL, 'light'),
(5, 5, 'navbar-light bg-white', 'menu-light', '', NULL, '', NULL, 'light');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `addedBy` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `addedTime` datetime DEFAULT current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `image`, `name`, `email`, `password`, `type`, `ip`, `addedBy`, `addedTime`, `deleted`) VALUES
(1, NULL, 'Owner', 'owner@gmail.com', 'ec842048570700e0d57cfcb45a03844ad7a683a9f11e9e7a573a7d56028e151f05a1d55f2f9da5cabe32f3d4e6640893cdde5a702b19201de986cc3ed4cb7cfd+gbP0+KebnroQW4pkNeOVi8yEVjymtJ44MTksxItrp8=', 'owner', NULL, NULL, '2019-12-04 13:53:28', 0),
(2, '4ade543920cb82fc5939b9e9e2ff9b43.jpg', 'Minhaz Ahamed', 'mma.rifat66@gmail.com', '8bfcc7eac426e4ccdd0f5a16b93f3b4900bda2245c93787d0e3fd4ada306bade542b8b6af462812a9e4cdb4668efe474022cde142ecc7e8073fe7da009b7d5e8tPNMfbE1tcVQv/u7qTQGwFJfcl9/kguFomuyYDk2jGE=', 'owner', '::1', 'Owner', '2019-12-04 13:53:48', 1),
(3, NULL, 'Foysal Khan', 'foysal@gmail.com', 'eb3b48a5b7afc799df4b8db43772cf960864ae5cbf87279a0d23f9386de907b16e361c62753c05bbdd2cfd3841331aa3dd9524678040d8b92559435bf15ef4b8vEx54TtgOLOEtLVZhymz1I8SVq7gKxsFuN94GiWmRvs=', 'owner', '::1', 'Minhaz Ahamed', '2019-12-04 13:54:13', 0),
(4, NULL, 'Fahim F', 'fahim@gmail.com', 'd0b99b8771d01c97a27c89cf92cc0d269415dba89f87379de3dab487e6d7420a5f5f5e7fec98d433a2337faf6cd507734c22b8a0c17335b12453c271231cf5821oPkNthhuK5KUDyMJxSUYuAgoddxU4pLGpsR9yU//z8=', 'staff', '::1', 'Minhaz Ahamed', '2019-12-04 13:54:24', 0),
(5, NULL, 'Md. Minhaz Ahamed', 'mma.rifat66@gmail.com', '289b31466e3ff8827dbb9115ccec69c9b0d3e89146e112b3d1e47d5f663acd39f52464790cc163a1e3e96ca44609f60125ff2f5cb80b7af867c9e64af4ece3ca8Ui0I+UzsPICOAXIIhiDzeBROL0HyvRZE2YjGW6QK9I=', 'owner', '::1', 'Foysal Khan', '2019-12-23 16:29:02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `companyName` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `addedTime` datetime DEFAULT current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `companyName`, `name`, `email`, `contact`, `address`, `addedBy`, `addedTime`, `deleted`) VALUES
(1, 'Test Vendor', 'Test Executive', 'test@gmail.com', '01478541256', 'Dhaka', 2, '2019-12-04 13:56:35', 0),
(2, 'Coca Cola', 'Alam', 'coca@gmail.com', '014785696445', 'Gazipur, Dhaka', 2, '2019-12-04 13:57:13', 0),
(3, 'Sprite', 'Shadhin', 'sprite@helpline.com', '0145785364', 'Dhaka', 2, '2019-12-04 13:57:42', 0),
(4, 'Fresh', 'Abir', 'fresh@helpline.com', '0174589661', 'Dhak', 2, '2019-12-04 13:58:10', 0),
(5, 'Ruci', 'Robin', 'ruci@yahoo.com', '014785154685', 'Dhaka', 2, '2019-12-04 13:59:16', 0),
(6, 'Lays', 'Labib', 'lays@gmail.com', '0147854455', 'Dhaka', 2, '2019-12-04 14:00:02', 0),
(7, 'Sun Chips', 'Subir', '', '01784489565', 'Dhaka', 2, '2019-12-04 14:00:21', 0),
(8, 'চাষী', 'চয়ন', '', '1744875747', 'ঢাকা', 2, '2019-12-04 14:00:58', 0),
(9, 'Maggie', 'Mahfuz', 'maggie@gmail.com', '0145781254', 'Dhaka', 2, '2019-12-04 14:02:02', 0),
(10, 'Molla Salt', 'Motin', 'mollasalt@gmail.com', '0147856996', 'Norsingdi', 2, '2019-12-04 14:02:55', 0),
(11, 'Dew', 'Delwar', '', '0458775674', 'Dhaka', 2, '2019-12-04 14:28:56', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saleitems`
--
ALTER TABLE `saleitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `saleitems`
--
ALTER TABLE `saleitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
