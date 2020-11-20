-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2020 at 07:14 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ot_bs`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `agent` varchar(20) NOT NULL,
  `total_refered` varchar(20) NOT NULL DEFAULT '0',
  `total_activated` varchar(20) DEFAULT '0',
  `earnings` varchar(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `symbol` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `name`, `symbol`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Bitcoin', 'BTC', 'Cryptocurrency', '2020-02-10 00:00:00', '2020-02-10 00:00:00'),
(2, 'Ethereum', 'ETH', 'Cryptocurrency', '2020-02-10 00:00:00', '2020-02-10 00:00:00'),
(3, 'Litecoin', 'LTC', 'Cryptocurrency', '2020-02-10 00:00:00', '2020-02-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` int(11) NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `wallet` varchar(20) DEFAULT NULL,
  `balance` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `user`, `wallet`, `balance`, `created_at`, `updated_at`) VALUES
(1, '18', 'USD', '5027', '2020-02-12 00:00:00', '2020-03-02 14:54:53'),
(2, '18', 'BTC', '0.30953048', '2020-02-12 15:51:20', '2020-03-02 14:53:11'),
(3, '18', 'ETH', '3.563504352909026', '2020-02-12 16:08:22', '2020-03-02 14:54:53'),
(4, '18', 'LTC', '4.9654528222654655', '2020-03-02 14:05:05', '2020-03-02 14:47:39'),
(5, '1', 'USD', '45.40000000000003', '2020-03-03 11:18:02', '2020-03-03 12:59:42'),
(6, '1', 'ETH', '0.21732750481620222', '2020-03-03 11:21:02', '2020-03-03 11:21:02'),
(7, '1', 'BTC', '0.011236743945840292', '2020-03-03 12:55:54', '2020-03-03 12:59:42');

-- --------------------------------------------------------

--
-- Table structure for table `cp_transactions`
--

CREATE TABLE `cp_transactions` (
  `id` int(11) NOT NULL,
  `txn_id` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `amount_paid` varchar(100) DEFAULT NULL,
  `user_plan` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `user_tele_id` varchar(200) DEFAULT NULL,
  `amount1` varchar(100) DEFAULT NULL,
  `amount2` varchar(100) DEFAULT NULL,
  `currency1` varchar(100) DEFAULT NULL,
  `currency2` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `status_text` varchar(255) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `cp_p_key` varchar(255) DEFAULT NULL,
  `cp_pv_key` varchar(255) DEFAULT NULL,
  `cp_m_id` varchar(255) DEFAULT NULL,
  `cp_ipn_secret` varchar(255) DEFAULT NULL,
  `cp_debug_email` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cp_transactions`
--

INSERT INTO `cp_transactions` (`id`, `txn_id`, `item_name`, `item_number`, `amount_paid`, `user_plan`, `user_id`, `user_tele_id`, `amount1`, `amount2`, `currency1`, `currency2`, `status`, `status_text`, `type`, `created_at`, `updated_at`, `cp_p_key`, `cp_pv_key`, `cp_m_id`, `cp_ipn_secret`, `cp_debug_email`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, '2018-08-05 00:00:00', '2020-01-09 22:23:42', 'aa3f6948307c4fc318be48571d0f33603f9479d9e084ab9eee0601eeb25b09ad', 'd57F069303fFDa7a88A6Ba121E7bFd19C4026Fcb789c874D04190773873E80Df', '6c0ec8a4a9fc05cc6843418cbdd5c08e', 'lpskjkviim94', 'khjhjhj@jhj.jd');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(11) NOT NULL,
  `txn_id` varchar(200) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `uname` varchar(30) DEFAULT NULL,
  `amount` varchar(20) NOT NULL,
  `payment_mode` varchar(20) NOT NULL,
  `plan` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `proof` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `txn_id`, `user`, `uname`, `amount`, `payment_mode`, `plan`, `status`, `proof`, `created_at`, `updated_at`) VALUES
(9, NULL, '17', NULL, '1100', 'Bank transfer', '24', 'Pending', 'IMG-20190810-WA0009.jpg', '2020-01-10 06:41:33', '2020-01-10 06:45:10'),
(10, NULL, '17', NULL, '1000', 'Bank transfer', '24', 'Pending', 'IMG-20190810-WA0009.jpg', '2020-01-10 06:48:38', '2020-01-10 06:48:38'),
(11, NULL, '18', NULL, '40', 'Bank transfer', 'Subscription Trading', 'Pending', 'Brynamics logo-white.png', '2020-04-02 11:14:35', '2020-04-02 11:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `user` varchar(50) DEFAULT NULL,
  `asset` varchar(50) DEFAULT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `open_price` varchar(50) DEFAULT NULL,
  `close_price` varchar(50) DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `p_l` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `pack_id` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `investments`
--

INSERT INTO `investments` (`id`, `user`, `asset`, `amount`, `duration`, `open_price`, `close_price`, `closed_at`, `p_l`, `type`, `pack_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '18', 'BTC', '900', NULL, '0.09186301876577747', '0.09186301876577747', '2020-02-11 12:02:20', NULL, NULL, NULL, 'closed', '2020-02-11 12:02:20', '2020-02-11 12:02:20'),
(2, '18', 'ETH', '299', NULL, '1.3443458790628244', '1.1822647320861588', '2020-02-12 09:49:48', '339.9910417106913', NULL, NULL, 'closed', '2020-02-11 12:03:19', '2020-02-12 09:49:48'),
(3, '18', 'ETH', '200', NULL, '0.8980288267253379', '0.09186301876577747', '2020-02-11 12:02:20', NULL, NULL, NULL, 'closed', '2020-02-11 12:05:47', '2020-02-11 12:05:47'),
(4, '18', 'BTC', '788', NULL, '0.08035871805409528', '0.0763083112744695', '2020-02-12 11:15:57', '829.826643638659', NULL, NULL, 'closed', '2020-02-11 12:12:31', '2020-02-12 11:15:57'),
(5, '18', 'BTC', '500', NULL, '0.05085438416662988', '0.048698674345549475', '2020-02-12 09:55:42', '522.1331468469164', NULL, NULL, 'closed', '2020-02-11 12:21:32', '2020-02-12 09:55:42'),
(7, '18', 'BTC', '200', NULL, '0.01936535284689568', '0.019616725877290193', '2020-02-13 10:31:21', '197.4371561088538', NULL, NULL, 'closed', '2020-02-12 10:41:34', '2020-02-13 10:31:21'),
(8, '18', 'BTC', '222', NULL, '0.021495541660054206', '0.021557479914750304', '2020-02-12 10:55:30', '221.36215677356958', NULL, NULL, 'closed', '2020-02-12 10:42:14', '2020-02-12 10:55:30'),
(9, '18', 'BTC', '300', NULL, '0.02913720086292734', NULL, NULL, NULL, NULL, NULL, 'active', '2020-02-12 10:54:27', '2020-02-12 10:54:27'),
(10, '18', 'LTC', '200', NULL, '2.5216547098205844', '2.5279609545307546', '2020-02-13 10:27:05', '199.50108052904315', NULL, NULL, 'closed', '2020-02-12 11:15:28', '2020-02-13 10:27:05'),
(11, '18', 'ETH', '500', NULL, '1.957138663274293', '1.9671881901572392', '2020-02-12 12:11:55', '497.4457128877581', NULL, NULL, 'closed', '2020-02-12 11:16:40', '2020-02-12 12:11:55'),
(12, '18', 'BTC', '200', NULL, '0.019643472930655888', NULL, NULL, NULL, NULL, NULL, 'active', '2020-02-13 10:26:25', '2020-02-13 10:26:25'),
(13, '18', 'ETH', '400', NULL, '1.5176982588206724', NULL, NULL, NULL, NULL, NULL, 'active', '2020-02-13 10:30:30', '2020-02-13 10:30:30'),
(14, '18', 'BTC', '43', NULL, '0.00567207941333287', '0.005700301995530543', '2020-04-25 16:48:08', '42.7871040805467', NULL, NULL, 'closed', '2020-04-24 09:25:44', '2020-04-25 16:48:08'),
(15, '18', 'BTC', '43', NULL, '0.00567207941333287', '0.005700838875550344', '2020-04-25 16:47:15', '42.78307457861067', NULL, NULL, 'closed', '2020-04-24 09:25:50', '2020-04-25 16:47:15'),
(16, '18', 'BTC', '43', NULL, '0.00567207941333287', '0.005700301995530543', '2020-04-25 16:47:54', '42.7871040805467', NULL, NULL, 'closed', '2020-04-24 09:26:09', '2020-04-25 16:47:54'),
(17, '18', 'BTC', '43', NULL, '0.00567207941333287', '0.005700838875550344', '2020-04-25 16:46:56', '42.78307457861067', NULL, NULL, 'closed', '2020-04-24 09:26:22', '2020-04-25 16:46:56'),
(18, '18', 'BTC', '20', NULL, '0.0026517932884702945', NULL, NULL, NULL, NULL, NULL, 'active', '2020-04-25 16:46:38', '2020-04-25 16:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `investment_packs`
--

CREATE TABLE `investment_packs` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `cur_1` varchar(50) DEFAULT NULL,
  `cur_2` varchar(50) DEFAULT NULL,
  `cur_3` varchar(50) DEFAULT NULL,
  `cur_4` varchar(50) DEFAULT NULL,
  `cur_5` varchar(50) DEFAULT NULL,
  `cur_6` varchar(50) DEFAULT NULL,
  `cur_7` varchar(50) DEFAULT NULL,
  `cur_8` varchar(50) DEFAULT NULL,
  `cur_9` varchar(50) DEFAULT NULL,
  `cur_10` varchar(50) DEFAULT NULL,
  `cur_11` varchar(50) DEFAULT NULL,
  `cur_12` varchar(50) DEFAULT NULL,
  `cur_13` varchar(50) DEFAULT NULL,
  `cur_14` varchar(50) DEFAULT NULL,
  `cur_15` varchar(50) DEFAULT NULL,
  `cur_16` varchar(50) DEFAULT NULL,
  `cur_17` varchar(50) DEFAULT NULL,
  `cur_18` varchar(50) DEFAULT NULL,
  `cur_19` varchar(50) DEFAULT NULL,
  `cur_20` varchar(50) DEFAULT NULL,
  `cur_21` varchar(50) DEFAULT NULL,
  `share_1` varchar(50) DEFAULT '0',
  `share_2` varchar(50) DEFAULT '0',
  `share_3` varchar(50) DEFAULT '0',
  `share_4` varchar(50) DEFAULT '0',
  `share_5` varchar(50) DEFAULT '0',
  `share_6` varchar(50) DEFAULT '0',
  `share_7` varchar(50) DEFAULT '0',
  `share_8` varchar(50) DEFAULT '0',
  `share_9` varchar(50) DEFAULT '0',
  `share_10` varchar(50) DEFAULT '0',
  `share_11` varchar(50) DEFAULT '0',
  `share_12` varchar(50) DEFAULT '0',
  `share_13` varchar(50) DEFAULT '0',
  `share_14` varchar(50) DEFAULT '0',
  `share_15` varchar(50) DEFAULT '0',
  `share_16` varchar(50) DEFAULT '0',
  `share_17` varchar(50) DEFAULT '0',
  `share_18` varchar(50) DEFAULT '0',
  `share_19` varchar(50) DEFAULT '0',
  `share_20` varchar(50) DEFAULT '0',
  `share_21` varchar(50) DEFAULT '0',
  `duration` varchar(50) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `investment_packs`
--

INSERT INTO `investment_packs` (`id`, `name`, `price`, `cur_1`, `cur_2`, `cur_3`, `cur_4`, `cur_5`, `cur_6`, `cur_7`, `cur_8`, `cur_9`, `cur_10`, `cur_11`, `cur_12`, `cur_13`, `cur_14`, `cur_15`, `cur_16`, `cur_17`, `cur_18`, `cur_19`, `cur_20`, `cur_21`, `share_1`, `share_2`, `share_3`, `share_4`, `share_5`, `share_6`, `share_7`, `share_8`, `share_9`, `share_10`, `share_11`, `share_12`, `share_13`, `share_14`, `share_15`, `share_16`, `share_17`, `share_18`, `share_19`, `share_20`, `share_21`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Combo 1', '100', 'BTC', 'ETH', 'LTC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '80', '10', '10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4', 'active', '2020-02-16 16:45:05', '2020-02-16 17:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `markets`
--

CREATE TABLE `markets` (
  `id` int(11) NOT NULL,
  `market` varchar(50) DEFAULT NULL,
  `base_curr` varchar(50) DEFAULT NULL,
  `quote_curr` varchar(50) DEFAULT NULL,
  `current_pair` varchar(50) DEFAULT NULL,
  `default_mark` varchar(50) DEFAULT NULL,
  `commission_type` varchar(50) DEFAULT NULL,
  `commission_fee` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `markets`
--

INSERT INTO `markets` (`id`, `market`, `base_curr`, `quote_curr`, `current_pair`, `default_mark`, `commission_type`, `commission_fee`, `created_at`, `updated_at`) VALUES
(1, 'Cryptocurrency', 'BTC', 'USD', 'BTC/USD', 'MAG', NULL, NULL, '0000-00-00 00:00:00', '2020-02-12 20:36:00'),
(5, 'Cryptocurrency', 'LTC', 'USD', NULL, NULL, NULL, NULL, '2020-01-24 11:32:00', '2020-02-14 11:01:21'),
(6, 'Cryptocurrency', 'LTC', 'BTC', NULL, NULL, NULL, NULL, '2020-01-24 11:36:13', '2020-03-03 10:10:52'),
(7, 'Cryptocurrency', 'ETH', 'USD', NULL, NULL, NULL, NULL, '2020-02-12 20:37:06', '2020-02-14 11:03:07'),
(8, 'Cryptocurrency', 'ETH', 'BTC', NULL, NULL, NULL, NULL, '2020-02-14 11:05:59', '2020-02-14 11:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mt4details`
--

CREATE TABLE `mt4details` (
  `id` int(11) NOT NULL,
  `client_id` int(255) DEFAULT NULL,
  `mt4_id` varchar(255) DEFAULT NULL,
  `mt4_password` varchar(200) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `account_type` varchar(100) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `leverage` varchar(255) DEFAULT NULL,
  `server` varchar(255) DEFAULT NULL,
  `options` varchar(255) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mt4details`
--

INSERT INTO `mt4details` (`id`, `client_id`, `mt4_id`, `mt4_password`, `type`, `account_type`, `currency`, `leverage`, `server`, `options`, `duration`, `created_at`, `updated_at`, `start_date`, `end_date`) VALUES
(4, 17, 'Klama30', 'acm3care3@1', NULL, 'Basic', 'YEN', '1:600', 'Aim Global', NULL, 'Monthly', '2020-01-17 03:48:02', '2020-04-02 14:07:15', '2020-04-02 15:07:15', '2020-05-02 15:07:15'),
(6, 1, '86345679', 'test123456', NULL, 'ECN', 'USD', '1:1000', 'ForexTimeFXTM-FXTM ECN', NULL, 'Quaterly', '2020-04-03 08:37:43', '2020-04-03 08:37:59', '2020-04-03 09:37:59', '2020-08-03 09:37:59');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `base_c` varchar(20) DEFAULT NULL,
  `quote_c` varchar(20) DEFAULT NULL,
  `base_amount` varchar(50) DEFAULT NULL,
  `quote_amount` varchar(50) DEFAULT NULL,
  `closed_amount` varchar(50) DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('Rejoice2017@gmail.com', '1a637489097377dbf21c8a7a7ba973d63a25f2f4ef2c483edb62f104a2182f1c', '2017-02-26 23:29:47'),
('rialebrume@gmail.com', 'd53c6a25865107ac7400f22436e6d37da6721bcdd36e9a67b86afee9c9fc9b7d', '2017-03-09 18:19:02'),
('dynamixng@gmail.com', '$2y$10$nel4xzM2Dvii86czm4YQxuH0nzdDUximHJM3QVkkkRmky1C.48GRy', '2018-08-14 12:44:33'),
('test123@happ.com', '$2y$10$Ue8EEVYbIRIRA0EA7o1aJ.h.K5MZLyip4ZMuiSpbxsq3xUp0DN.cu', '2018-09-11 06:22:04'),
('humble5y@gmail.com', '$2y$10$IM0FlP6UaB7N1rTdGgo04elJiex9bdHYXc2K3IaLWSduq99zTUr3O', '2018-09-15 22:48:32'),
('ranawaseemsajid@outlook.com', '$2y$10$VRnunT6BauJemm2mKqp/N.yXb8C5HHOJGnBOSZYdyAj1otmP.y1Ru', '2018-09-25 21:53:33'),
('test1234@happ.com', '$2y$10$.rvGmEIKCMxwCTMW2Ftlcec77Lv1hUjz/qH/aGdS4tbRVmQKzhVqS', '2018-10-11 08:58:43'),
('johnsteiner530@gmail.com', '$2y$10$V5QsjmZUSymjpNSTIfMTluwTn4bBKE34hKQSu7NZ58unUHRQganH6', '2019-10-17 12:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `w_limit` varchar(50) DEFAULT NULL,
  `price` varchar(20) NOT NULL,
  `min_price` varchar(20) DEFAULT NULL,
  `max_price` varchar(20) DEFAULT NULL,
  `minr` varchar(50) NOT NULL,
  `maxr` varchar(50) NOT NULL,
  `gift` varchar(50) NOT NULL,
  `expected_return` varchar(20) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `increment_interval` varchar(20) NOT NULL,
  `increment_type` varchar(20) NOT NULL,
  `increment_amount` varchar(20) DEFAULT NULL,
  `expiration` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `w_limit`, `price`, `min_price`, `max_price`, `minr`, `maxr`, `gift`, `expected_return`, `type`, `created_at`, `updated_at`, `increment_interval`, `increment_type`, `increment_amount`, `expiration`) VALUES
(23, 'Starter', '100', '5000', '5000', '5000', '500', '1000', '50', '1000', 'Main', '2019-11-20 21:29:06', '2019-12-10 10:51:37', 'Weekly', 'Percentage', '5', 'One week'),
(24, 'Premium', '300', '1000', '200', '3000', '322', '353', '444', '20', 'Main', '2019-11-22 00:44:46', '2019-12-10 10:55:51', 'Daily', 'Percentage', '5', 'Three months');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `total_investors` int(50) NOT NULL DEFAULT 0,
  `active_investors` int(50) NOT NULL DEFAULT 0,
  `contracted_companies` int(50) NOT NULL DEFAULT 0,
  `currency` varchar(100) NOT NULL,
  `s_currency` varchar(20) DEFAULT NULL,
  `bank_name` varchar(50) DEFAULT NULL,
  `account_name` varchar(50) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `eth_address` varchar(200) DEFAULT NULL,
  `btc_address` varchar(200) DEFAULT NULL,
  `ltc_address` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `s_s_k` varchar(200) DEFAULT NULL,
  `s_p_k` varchar(200) DEFAULT NULL,
  `pp_cs` varchar(200) DEFAULT NULL,
  `pp_ci` varchar(200) DEFAULT NULL,
  `keywords` varchar(255) NOT NULL,
  `site_title` varchar(100) NOT NULL,
  `site_address` varchar(100) NOT NULL,
  `bot_link` varchar(200) DEFAULT NULL,
  `logo` varchar(200) NOT NULL,
  `trade_mode` varchar(20) DEFAULT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `referral_commission` varchar(20) DEFAULT NULL,
  `referral_commission1` varchar(10) DEFAULT NULL,
  `referral_commission2` varchar(10) DEFAULT NULL,
  `referral_commission3` varchar(10) DEFAULT NULL,
  `referral_commission4` varchar(10) DEFAULT NULL,
  `referral_commission5` varchar(10) DEFAULT NULL,
  `signup_bonus` varchar(20) DEFAULT NULL,
  `files_key` varchar(50) DEFAULT NULL,
  `tawk_to` text DEFAULT NULL,
  `enable_2fa` varchar(20) NOT NULL DEFAULT 'no',
  `enable_kyc` varchar(20) NOT NULL DEFAULT 'no',
  `enable_verification` varchar(255) NOT NULL DEFAULT 'true',
  `withdrawal_option` varchar(20) NOT NULL DEFAULT 'auto',
  `dashboard_option` varchar(20) DEFAULT NULL,
  `site_preference` varchar(20) DEFAULT NULL,
  `bot_activate` varchar(20) DEFAULT NULL,
  `telegram_token` varchar(255) DEFAULT NULL,
  `bot_group_chat` varchar(200) DEFAULT NULL,
  `bot_channel` varchar(200) DEFAULT NULL,
  `site_colour` varchar(50) DEFAULT NULL,
  `commission_type` varchar(50) DEFAULT NULL,
  `commission_fee` varchar(50) DEFAULT NULL,
  `monthlyfee` varchar(50) DEFAULT NULL,
  `quaterlyfee` varchar(50) DEFAULT NULL,
  `yearlyfee` varchar(50) DEFAULT NULL,
  `update` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `description`, `total_investors`, `active_investors`, `contracted_companies`, `currency`, `s_currency`, `bank_name`, `account_name`, `account_number`, `eth_address`, `btc_address`, `ltc_address`, `payment_mode`, `s_s_k`, `s_p_k`, `pp_cs`, `pp_ci`, `keywords`, `site_title`, `site_address`, `bot_link`, `logo`, `trade_mode`, `contact_email`, `referral_commission`, `referral_commission1`, `referral_commission2`, `referral_commission3`, `referral_commission4`, `referral_commission5`, `signup_bonus`, `files_key`, `tawk_to`, `enable_2fa`, `enable_kyc`, `enable_verification`, `withdrawal_option`, `dashboard_option`, `site_preference`, `bot_activate`, `telegram_token`, `bot_group_chat`, `bot_channel`, `site_colour`, `commission_type`, `commission_fee`, `monthlyfee`, `quaterlyfee`, `yearlyfee`, `update`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'Online Trade', 'Dreams can only be succeeded if you work towards them. Even building wealth is no different. Online Trade is here to provide a fast lane of online investment,  risk management and advisory services to both institutional and individual investor around the globe as we are', 7763, 3001, 5, '$', 'USD', 'First International Bank PLC', 'Admin Account name', '2123343493659', NULL, 'jhxghh878ehhghcuy8ehudu88e98938j4', 'jhxghh878ehhghcuy8jjfehudu88e98938j4kdk', '123456', 'sk_test_BQokikJOvBiI2HlWgH4olfQ2', 'pk_test_6pRNASCoBOKtIshFeQd4XMUh', NULL, NULL, 'make money online, portfolio management stock, forex, cryptocurrency me pooo', 'Create your investment management platform in minutes and 3 seconds', 'yoursiteurl.com/trade', 'https://t.me/onlinetradeofficialbotdd', 'brynamicsot.PNG', 'off', 'Support@onlinetrade.com', '2.53', '23', '1.73', '1.23', '13', '0.53', '203', 'OT_TItUA', 'hbhlhahihlhlhuAJHO347T8UGQ0U[I9ghp', 'no', 'yes', 'false', 'manual', 'Online Trade', 'Web dashboard only', 'false', 'jhlhgohghgoygynouyoq', 'https://t.me/joinchat/IXw1_UrqB788hd-9Qff', 'https://t.me/OT_Official_channeldd', 'default', 'Percentage', '3', '40', '60', '80', 'It can only get better with our Trading Platform or with any other platform', '2017-02-27 01:10:03', '2020-04-03 09:34:58', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `tp_transactions`
--

CREATE TABLE `tp_transactions` (
  `id` int(11) NOT NULL,
  `plan` varchar(20) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `amount` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userlogs`
--

CREATE TABLE `userlogs` (
  `id` int(11) NOT NULL,
  `user` int(20) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlogs`
--

INSERT INTO `userlogs` (`id`, `user`, `ip`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, '127.0.0.1', 'login', '2019-11-27 20:45:09', '2019-11-27 20:45:09'),
(2, 1, '127.0.0.1', 'login', '2019-11-27 21:56:54', '2019-11-27 21:56:54'),
(4, 10, '127.0.0.1', 'login', '2019-11-27 22:16:34', '2019-11-27 22:16:34'),
(5, NULL, '127.0.0.1', 'Register', '2019-11-27 22:17:59', '2019-11-27 22:17:59'),
(6, NULL, '127.0.0.1', 'Register', '2019-11-27 22:18:48', '2019-11-27 22:18:48'),
(7, NULL, '127.0.0.1', 'Register', '2019-11-27 23:24:46', '2019-11-27 23:24:46'),
(8, 15, '127.0.0.1', 'Register', '2019-11-28 01:42:45', '2019-11-28 01:42:45'),
(9, 16, '127.0.0.1', 'Register', '2019-11-28 01:44:09', '2019-11-28 01:44:09'),
(10, 1, '127.0.0.1', 'login', '2019-11-28 17:22:11', '2019-11-28 17:22:11'),
(11, 8, '127.0.0.1', 'login', '2019-11-28 18:36:36', '2019-11-28 18:36:36'),
(12, 1, '127.0.0.1', 'login', '2019-11-28 22:05:00', '2019-11-28 22:05:00'),
(13, 8, '127.0.0.1', 'login', '2019-12-02 17:45:59', '2019-12-02 17:45:59'),
(14, 1, '127.0.0.1', 'login', '2019-12-02 17:47:59', '2019-12-02 17:47:59'),
(15, 8, '127.0.0.1', 'login', '2019-12-02 22:29:35', '2019-12-02 22:29:35'),
(16, 1, '127.0.0.1', 'login', '2019-12-02 22:41:09', '2019-12-02 22:41:09'),
(17, 1, '127.0.0.1', 'login', '2019-12-03 00:58:56', '2019-12-03 00:58:56'),
(18, 1, '127.0.0.1', 'login', '2019-12-03 17:23:26', '2019-12-03 17:23:26'),
(19, 1, '127.0.0.1', 'login', '2019-12-03 23:04:24', '2019-12-03 23:04:24'),
(20, 8, '127.0.0.1', 'login', '2019-12-03 23:24:33', '2019-12-03 23:24:33'),
(21, 8, '127.0.0.1', 'login', '2019-12-04 00:43:41', '2019-12-04 00:43:41'),
(22, 8, '127.0.0.1', 'login', '2019-12-04 01:11:05', '2019-12-04 01:11:05'),
(23, 8, '127.0.0.1', 'login', '2019-12-04 17:35:59', '2019-12-04 17:35:59'),
(24, 1, '127.0.0.1', 'login', '2019-12-04 17:37:26', '2019-12-04 17:37:26'),
(25, 8, '127.0.0.1', 'login', '2019-12-06 01:15:49', '2019-12-06 01:15:49'),
(26, 8, '127.0.0.1', 'login', '2019-12-06 17:53:29', '2019-12-06 17:53:29'),
(27, 8, '127.0.0.1', 'login', '2019-12-06 20:21:45', '2019-12-06 20:21:45'),
(28, 1, '127.0.0.1', 'login', '2019-12-07 00:20:35', '2019-12-07 00:20:35'),
(29, 8, '127.0.0.1', 'login', '2019-12-07 01:02:42', '2019-12-07 01:02:42'),
(30, 1, '127.0.0.1', 'login', '2019-12-07 16:58:46', '2019-12-07 16:58:46'),
(31, 1, '127.0.0.1', 'login', '2019-12-13 00:14:13', '2019-12-13 00:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `tele_id` varchar(200) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `l_name` varchar(50) DEFAULT NULL,
  `dob` varchar(50) DEFAULT NULL,
  `adress` text DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `areacode` varchar(50) DEFAULT NULL,
  `token_2fa` varchar(255) DEFAULT NULL,
  `token_2fa_expiry` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `dashboard_style` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_name` varchar(50) DEFAULT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `btc_address` varchar(255) DEFAULT NULL,
  `eth_address` varchar(255) DEFAULT NULL,
  `ltc_address` varchar(255) DEFAULT NULL,
  `plan` varchar(25) DEFAULT '0',
  `user_plan` varchar(20) DEFAULT NULL,
  `promo_plan` varchar(20) NOT NULL DEFAULT '0',
  `confirmed_plan` varchar(25) DEFAULT '0',
  `inv_duration` varchar(100) DEFAULT NULL,
  `account_bal` varchar(20) NOT NULL DEFAULT '0',
  `roi` varchar(50) NOT NULL DEFAULT '0',
  `bonus` varchar(50) DEFAULT NULL,
  `ref_bonus` varchar(20) NOT NULL DEFAULT '0',
  `signup_bonus` varchar(20) DEFAULT NULL,
  `bonus_released` varchar(20) NOT NULL DEFAULT '0',
  `ref_by` varchar(20) DEFAULT NULL,
  `ref_link` varchar(100) DEFAULT NULL,
  `bot_ref_link` varchar(200) DEFAULT NULL,
  `id_card` varchar(255) DEFAULT NULL,
  `passport` varchar(255) DEFAULT NULL,
  `account_verify` varchar(20) DEFAULT NULL,
  `entered_at` datetime DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `last_growth` datetime DEFAULT NULL,
  `status` varchar(25) DEFAULT 'active',
  `act_session` varchar(255) DEFAULT NULL,
  `trade_mode` varchar(20) NOT NULL DEFAULT 'on',
  `type` varchar(25) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `tele_id`, `name`, `l_name`, `dob`, `adress`, `email`, `phone_number`, `areacode`, `token_2fa`, `token_2fa_expiry`, `photo`, `dashboard_style`, `password`, `remember_token`, `bank_name`, `account_name`, `account_no`, `btc_address`, `eth_address`, `ltc_address`, `plan`, `user_plan`, `promo_plan`, `confirmed_plan`, `inv_duration`, `account_bal`, `roi`, `bonus`, `ref_bonus`, `signup_bonus`, `bonus_released`, `ref_by`, `ref_link`, `bot_ref_link`, `id_card`, `passport`, `account_verify`, `entered_at`, `activated_at`, `last_growth`, `status`, `act_session`, `trade_mode`, `type`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Test', NULL, NULL, NULL, 'test123@happ.com', '0985678999', '', '93669', '2020-04-23 10:34:47', NULL, 'light', '$2y$10$4sYtScImx93NShw8jNzqW.yMvqHHolSjjYJHpjUI7ZZ96TClaDYHC', 'xIghamUkbUWSmEJhjheVOkF3ifrASxdmL2FgixL54dXTkneRICOX0bHVzKSI', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '0', '0', NULL, '825.0683705707233', '10', '10', '25', 'received', '0', NULL, 'alphalogicsystem.com/ref/1', NULL, 'new update.png', 'new update.png', 'yes', NULL, NULL, NULL, 'active', NULL, 'on', '1', '2019-11-08 14:54:06', '2020-04-23 10:34:47'),
(18, NULL, 'BS Test', NULL, NULL, NULL, 'test1234@happ.com', '087656789876', NULL, NULL, '2020-04-25 17:01:37', NULL, 'dark', '$2y$10$IbzDWmkyEh2C4z1uUh5O1.GfO46fiuwNxEU55GGyES/8a5DkCKCjS', 'WTmB1kxelHX2dUyoTEWgBRaPxY3zycv6myJLxo3kiRFkoEg7OqcNts1B2NxL', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '0', '0', NULL, '3144.837295813805', '1000', '183', '0', 'received', '0', NULL, 'yoursiteurl.com/trade/ref/18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'J6O6fR3NjswzzJD9MDuP649pWorIxcSTdkNbVR4W', 'on', '0', '2020-01-24 10:29:31', '2020-04-25 17:01:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_packs`
--

CREATE TABLE `user_packs` (
  `id` int(11) NOT NULL,
  `user` varchar(50) DEFAULT NULL,
  `investment_pack` varchar(50) DEFAULT NULL,
  `p_l` varchar(50) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `open_price_1` varchar(50) DEFAULT NULL,
  `close_price_1` varchar(50) DEFAULT NULL,
  `open_price_2` varchar(50) DEFAULT NULL,
  `close_price_2` varchar(50) DEFAULT NULL,
  `open_price_3` varchar(50) DEFAULT NULL,
  `close_price_3` varchar(50) DEFAULT NULL,
  `open_price_4` varchar(50) DEFAULT NULL,
  `close_price_4` varchar(50) DEFAULT NULL,
  `open_price_5` varchar(50) DEFAULT NULL,
  `close_price_5` varchar(50) DEFAULT NULL,
  `open_price_6` varchar(50) DEFAULT NULL,
  `close_price_6` varchar(50) DEFAULT NULL,
  `open_price_7` varchar(50) DEFAULT NULL,
  `close_price_7` varchar(50) DEFAULT NULL,
  `open_price_8` varchar(50) DEFAULT NULL,
  `close_price_8` varchar(50) DEFAULT NULL,
  `open_price_9` varchar(50) DEFAULT NULL,
  `close_price_9` varchar(50) DEFAULT NULL,
  `open_price_10` varchar(50) DEFAULT NULL,
  `close_price_10` varchar(50) DEFAULT NULL,
  `open_price_11` varchar(50) DEFAULT NULL,
  `close_price_11` varchar(50) DEFAULT NULL,
  `open_price_12` varchar(50) DEFAULT NULL,
  `close_price_12` varchar(50) DEFAULT NULL,
  `open_price_13` varchar(50) DEFAULT NULL,
  `close_price_13` varchar(50) DEFAULT NULL,
  `open_price_14` varchar(50) DEFAULT NULL,
  `close_price_14` varchar(50) DEFAULT NULL,
  `open_price_15` varchar(50) DEFAULT NULL,
  `close_price_15` varchar(50) DEFAULT NULL,
  `open_price_16` varchar(50) DEFAULT NULL,
  `close_price_16` varchar(50) DEFAULT NULL,
  `open_price_17` varchar(50) DEFAULT NULL,
  `close_price_17` varchar(50) DEFAULT NULL,
  `open_price_18` varchar(50) DEFAULT NULL,
  `close_price_18` varchar(50) DEFAULT NULL,
  `open_price_19` varchar(50) DEFAULT NULL,
  `close_price_19` varchar(50) DEFAULT NULL,
  `open_price_20` varchar(50) DEFAULT NULL,
  `close_price_20` varchar(50) DEFAULT NULL,
  `open_price_21` varchar(50) DEFAULT NULL,
  `close_price_21` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `created_at` datetime NOT NULL,
  `closed_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_packs`
--

INSERT INTO `user_packs` (`id`, `user`, `investment_pack`, `p_l`, `duration`, `open_price_1`, `close_price_1`, `open_price_2`, `close_price_2`, `open_price_3`, `close_price_3`, `open_price_4`, `close_price_4`, `open_price_5`, `close_price_5`, `open_price_6`, `close_price_6`, `open_price_7`, `close_price_7`, `open_price_8`, `close_price_8`, `open_price_9`, `close_price_9`, `open_price_10`, `close_price_10`, `open_price_11`, `close_price_11`, `open_price_12`, `close_price_12`, `open_price_13`, `close_price_13`, `open_price_14`, `close_price_14`, `open_price_15`, `close_price_15`, `open_price_16`, `close_price_16`, `open_price_17`, `close_price_17`, `open_price_18`, `close_price_18`, `open_price_19`, `close_price_19`, `open_price_20`, `close_price_20`, `open_price_21`, `close_price_21`, `status`, `created_at`, `closed_at`, `updated_at`) VALUES
(1, '1', '1', '100.06837057072339', '4', '0.008335277861275706', '0.008331937613143619', '0.04060215892560386', '0.04050431960746713', '0.14376323942627484', '0.14358887174756846', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'closed', '2020-02-17 13:31:24', '2020-02-17 13:34:29', '2020-02-17 13:34:29'),
(2, '1', '1', NULL, '4', '0.008341583899873894', NULL, '0.04053492431722254', NULL, '0.14368757699768228', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', '2020-02-17 13:33:04', NULL, '2020-02-17 13:33:04'),
(3, '1', '1', NULL, '4', '0.008328862004501614', NULL, '0.03946316395411874', NULL, '0.1388457599247123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', '2020-02-17 14:55:30', NULL, '2020-02-17 14:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_plans`
--

CREATE TABLE `user_plans` (
  `id` int(11) NOT NULL,
  `plan` varchar(20) DEFAULT NULL,
  `w_limit` varchar(50) DEFAULT NULL,
  `amount` varchar(20) DEFAULT '0',
  `user` varchar(20) DEFAULT NULL,
  `active` varchar(20) DEFAULT NULL,
  `inv_duration` varchar(50) DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `last_growth` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wdmethods`
--

CREATE TABLE `wdmethods` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `minimum` varchar(50) NOT NULL,
  `maximum` varchar(50) NOT NULL,
  `charges_fixed` varchar(50) NOT NULL,
  `charges_percentage` varchar(50) NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wdmethods`
--

INSERT INTO `wdmethods` (`id`, `name`, `minimum`, `maximum`, `charges_fixed`, `charges_percentage`, `duration`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bitcoin', '10', '20000', '2', '2', 'instant', 'withdrawal', 'enabled', '2019-11-09 09:05:00', '2019-11-09 09:05:23'),
(2, 'Ethereum', '5', '10000', '2', '2', 'instant', 'withdrawal', 'enabled', '2019-11-09 09:11:21', '2019-11-09 09:11:21'),
(5, 'Bank transfer', '100', '100000', '2', '2', '2 working days', 'withdrawal', 'enabled', '2019-11-09 11:36:37', '2019-11-09 11:36:37'),
(4, 'Litecoin', '10', '2', '4000', '2', '2', 'withdrawal', 'enabled', '2019-11-09 11:35:35', '2019-11-09 11:35:35'),
(6, 'Credit Card', '10', '100000', '2', '2', '2 working days', 'withdrawal', 'enabled', '2019-12-11 18:51:04', '2019-12-11 18:51:04');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(11) NOT NULL,
  `txn_id` varchar(200) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `uname` varchar(30) DEFAULT NULL,
  `amount` varchar(20) NOT NULL,
  `to_deduct` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `payment_mode` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `txn_id`, `user`, `uname`, `amount`, `to_deduct`, `status`, `payment_mode`, `created_at`, `updated_at`) VALUES
(6, NULL, '17', NULL, '1000', '1022', 'Pending', 'Bitcoin', '2019-12-11 20:34:40', '2019-12-11 20:34:40'),
(7, NULL, '17', NULL, '1000', '1022', 'Processed', 'Bank transfer', '2019-12-11 20:41:13', '2019-12-11 20:41:41'),
(8, NULL, '17', NULL, '1000', '1022', 'Pending', 'Credit Card', '2019-12-11 20:50:40', '2019-12-11 20:50:40'),
(9, NULL, '17', NULL, '100', '104', 'Pending', 'Bank transfer', '2019-12-13 23:14:28', '2019-12-13 23:14:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `agents` ADD FULLTEXT KEY `agent` (`agent`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_transactions`
--
ALTER TABLE `cp_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment_packs`
--
ALTER TABLE `investment_packs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `markets`
--
ALTER TABLE `markets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mt4details`
--
ALTER TABLE `mt4details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_transactions`
--
ALTER TABLE `tp_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlogs`
--
ALTER TABLE `userlogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `users` ADD FULLTEXT KEY `name` (`name`,`email`);
ALTER TABLE `users` ADD FULLTEXT KEY `name_2` (`name`,`l_name`,`email`);

--
-- Indexes for table `user_packs`
--
ALTER TABLE `user_packs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_plans`
--
ALTER TABLE `user_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wdmethods`
--
ALTER TABLE `wdmethods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cp_transactions`
--
ALTER TABLE `cp_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=565;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `investment_packs`
--
ALTER TABLE `investment_packs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `markets`
--
ALTER TABLE `markets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mt4details`
--
ALTER TABLE `mt4details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tp_transactions`
--
ALTER TABLE `tp_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userlogs`
--
ALTER TABLE `userlogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_packs`
--
ALTER TABLE `user_packs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_plans`
--
ALTER TABLE `user_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `wdmethods`
--
ALTER TABLE `wdmethods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
