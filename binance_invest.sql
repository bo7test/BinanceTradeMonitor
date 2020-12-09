-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 09, 2020 at 06:48 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `binance_invest`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `symbol` text NOT NULL,
  `type` text NOT NULL,
  `currentAmount` float NOT NULL,
  `quantity` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `amount`, `symbol`, `type`, `currentAmount`, `quantity`) VALUES
(145, 0.6209, 'GHSTBUSD', 'buy', 0.6017, 1242);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(9) NOT NULL,
  `symbol` text NOT NULL,
  `currency` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `symbol`, `currency`) VALUES
(25, 'BTCUSDT', 'USDT'),
(26, 'ONEUSDT', 'USDT'),
(27, 'WAVESBNB', 'BNB'),
(28, 'BCDBTC', 'BTC'),
(29, 'ZRXUSDT', 'USDT'),
(30, 'FETUSDT', 'USDT'),
(31, 'VETUSDT', 'USDT'),
(32, 'HOTUSDT', 'USDT'),
(33, 'BNBUSDT', 'USDT'),
(34, 'BANDBTC', 'BTC'),
(35, 'DUSKBTC', 'BTC'),
(36, 'ADABTC', 'BTC'),
(37, 'BTGBTC', 'BTC'),
(38, 'XRPUSDT', 'USDT'),
(39, 'HBARBTC', 'BTC'),
(40, 'PHBBTC', 'BTC'),
(41, 'TFUELBNB', 'BNB'),
(42, 'WINUSDT', 'USDT'),
(43, 'ERDBNB', 'BNB'),
(44, 'DOGEUSDT', 'USDT'),
(45, 'XLMUSDT', 'USDt'),
(46, 'NKNBNB', 'BNB'),
(47, 'NPXSUSDT', 'USDT'),
(48, 'TRXBNB', 'BNB'),
(49, 'HOTBTC', 'BTC'),
(50, 'LINKUSDT', 'USDT'),
(51, 'ARDRUSDT', 'USDT'),
(52, 'ONGUSDT', 'USDT'),
(53, 'COCOSUSDT', 'USDT'),
(54, 'SXPDOWNUSDT', 'USDT'),
(55, 'CRVUSDT', 'USDT'),
(56, 'AUDIOUSDT', 'USDT'),
(57, 'UTKUSDT', 'USDT'),
(58, 'BELUSDT', 'USDT'),
(59, 'XRPUPUSDT', 'USDT'),
(60, 'COVERBUSD', 'BUSD'),
(61, 'XRPDOWNUSDT', 'USDT'),
(62, 'AKROUSDT', 'USDT'),
(63, 'GHSTBUSD', 'BUSD'),
(64, 'FIOUSDT', 'USDT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
