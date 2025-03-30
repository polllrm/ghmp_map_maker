-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2025 at 07:41 AM
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
-- Database: `cms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `burial_reservations`
--

CREATE TABLE `burial_reservations` (
  `id` int(11) NOT NULL,
  `reservee_id` int(11) NOT NULL,
  `burial_lot` varchar(255) NOT NULL,
  `burial_date_time` datetime NOT NULL,
  `reservation_status` enum('Pending','Verified','Active','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cemetery_lots`
--

CREATE TABLE `cemetery_lots` (
  `id` int(11) NOT NULL,
  `lot_id` varchar(50) NOT NULL,
  `latitude_start` decimal(10,8) NOT NULL,
  `longitude_start` decimal(11,8) NOT NULL,
  `latitude_end` decimal(10,8) NOT NULL,
  `longitude_end` decimal(11,8) NOT NULL,
  `status` enum('Available','Reserved','Sold','Sold and Occupied') DEFAULT 'Available',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_form_submissions`
--

CREATE TABLE `contact_form_submissions` (
  `submission_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `username`, `email`, `password_hash`, `contact_number`, `address`, `created_at`, `updated_at`, `last_login`) VALUES
(1, 'Juan', 'Santos', 'De La Cruz', '', 'customer01', 'ejjose94@gmail.com', '$2y$10$b7Qs9P1WDTJ3X4.WnKYCuuDpJVqndUsbnuEgHBC1PPLLiwOfUOWwy', '+63912-123-1234', '123 Street, Town, Province', '2025-01-05 10:37:40', '2025-01-08 19:12:01', '2025-01-08 19:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `deceased`
--

CREATE TABLE `deceased` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `burial_date` date DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deceased`
--

INSERT INTO `deceased` (`id`, `full_name`, `first_name`, `middle_name`, `last_name`, `suffix`, `birth_date`, `death_date`, `burial_date`, `location`, `created_at`, `updated_at`) VALUES
(1, 'John A. Doe', 'John', 'A.', 'Doe', NULL, '1950-01-15', '2023-10-01', '2023-10-05', 'P1-C2L4', '2025-01-20 11:05:58', '2025-01-20 11:05:58'),
(2, 'Jane B. Smith', 'Jane', 'B.', 'Smith', NULL, '1965-06-20', '2022-12-15', '2022-12-20', 'P1-C2L5', '2025-01-20 11:05:58', '2025-01-20 11:05:58'),
(3, 'Robert C. Johnson', 'Robert', 'C.', 'Johnson', 'Sr.', '1942-03-10', '2021-05-12', '2021-05-18', 'P1-C2L7', '2025-01-20 11:05:58', '2025-01-20 11:05:58'),
(4, 'Emily D. Davis', 'Emily', 'D.', 'Davis', NULL, '1980-09-25', '2023-03-10', '2023-03-15', 'P1-C2L10', '2025-01-20 11:05:58', '2025-01-20 11:05:58'),
(5, 'Michael E. Brown', 'Michael', 'E.', 'Brown', 'Jr.', '1975-02-14', '2020-08-25', '2020-08-30', 'P1-C4L1', '2025-01-20 11:05:58', '2025-01-20 11:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `deceased_backup`
--

CREATE TABLE `deceased_backup` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `burial_date` date DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estates`
--

CREATE TABLE `estates` (
  `id` int(11) NOT NULL,
  `estate_id` varchar(10) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `latitude_start` decimal(10,7) NOT NULL,
  `longitude_start` decimal(10,7) NOT NULL,
  `latitude_end` decimal(10,7) NOT NULL,
  `longitude_end` decimal(10,7) NOT NULL,
  `status` enum('Available','Reserved','Sold','Sold and Occupied') NOT NULL DEFAULT 'Available',
  `occupancy` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estates`
--

INSERT INTO `estates` (`id`, `estate_id`, `owner_id`, `latitude_start`, `longitude_start`, `latitude_end`, `longitude_end`, `status`, `occupancy`, `capacity`, `created_at`, `updated_at`) VALUES
(28, 'E-C1', NULL, 14.8715127, 120.9769721, 14.8715487, 120.9770081, 'Available', 0, 6, '2025-02-01 05:45:47', '2025-03-24 16:25:48'),
(29, 'E-B1', NULL, 14.8714647, 120.9769721, 14.8715097, 120.9770036, 'Available', 0, 7, '2025-02-01 05:45:47', '2025-03-03 01:01:41'),
(30, 'E-A1', NULL, 14.8714167, 120.9769721, 14.8714617, 120.9770081, 'Available', 0, 8, '2025-02-01 05:45:47', '2025-03-03 01:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `estate_price_list`
--

CREATE TABLE `estate_price_list` (
  `estate` varchar(50) DEFAULT NULL,
  `sqm` decimal(10,2) DEFAULT NULL,
  `number_of_lots` int(11) DEFAULT NULL,
  `lot_price` decimal(15,2) DEFAULT NULL,
  `total_purchase_price` decimal(15,2) DEFAULT NULL,
  `cash_sale_10_discount` decimal(15,2) DEFAULT NULL,
  `6_months_5_discount` decimal(15,2) DEFAULT NULL,
  `down_payment_20` decimal(15,2) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT NULL,
  `monthly_amortization_1yr` decimal(15,2) DEFAULT NULL,
  `monthly_amortization_2yrs_10_interest` decimal(15,2) DEFAULT NULL,
  `monthly_amortization_3yrs_15_interest` decimal(15,2) DEFAULT NULL,
  `monthly_amortization_4yrs_20_interest` decimal(15,2) DEFAULT NULL,
  `monthly_amortization_5yrs_25_interest` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estate_price_list`
--

INSERT INTO `estate_price_list` (`estate`, `sqm`, `number_of_lots`, `lot_price`, `total_purchase_price`, `cash_sale_10_discount`, `6_months_5_discount`, `down_payment_20`, `balance`, `monthly_amortization_1yr`, `monthly_amortization_2yrs_10_interest`, `monthly_amortization_3yrs_15_interest`, `monthly_amortization_4yrs_20_interest`, `monthly_amortization_5yrs_25_interest`) VALUES
('Estate A', 20.00, 8, 500.00, 80560.00, 80504.00, 80532.00, 80112.00, 448.00, 37.33, 20.53, 14.31, 11.20, 9.33),
('Estate B', 17.50, 7, 449134.00, 573030.08, 522727.00, 547879.00, 170606.00, 402424.06, 33535.34, 18444.42, 12855.21, 10060.60, 8383.83),
('Estate C', 16.00, 6, 406342.40, 519103.49, 473593.00, 496348.00, 155021.00, 364082.79, 30340.23, 16687.13, 11630.42, 9102.07, 7585.06);

-- --------------------------------------------------------

--
-- Table structure for table `estate_price_list_backup`
--

CREATE TABLE `estate_price_list_backup` (
  `estate` varchar(50) DEFAULT NULL,
  `sqm` decimal(10,2) DEFAULT NULL,
  `number_of_lots` int(11) DEFAULT NULL,
  `lot_price` decimal(15,2) DEFAULT NULL,
  `total_purchase_price` decimal(15,2) DEFAULT NULL,
  `cash_sale_10_discount` decimal(15,2) DEFAULT NULL,
  `cash_sale_5_discount` decimal(15,2) DEFAULT NULL,
  `down_payment_20` decimal(15,2) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT NULL,
  `monthly_amortization_1yr` decimal(15,2) DEFAULT NULL,
  `monthly_amortization_2yrs_10_interest` decimal(15,2) DEFAULT NULL,
  `monthly_amortization_3yrs_15_interest` decimal(15,2) DEFAULT NULL,
  `monthly_amortization_4yrs_20_interest` decimal(15,2) DEFAULT NULL,
  `monthly_amortization_5yrs_25_interest` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estate_price_list_backup`
--

INSERT INTO `estate_price_list_backup` (`estate`, `sqm`, `number_of_lots`, `lot_price`, `total_purchase_price`, `cash_sale_10_discount`, `cash_sale_5_discount`, `down_payment_20`, `balance`, `monthly_amortization_1yr`, `monthly_amortization_2yrs_10_interest`, `monthly_amortization_3yrs_15_interest`, `monthly_amortization_4yrs_20_interest`, `monthly_amortization_5yrs_25_interest`) VALUES
('Estate A', 20.00, 8, 531016.00, 674737.92, 615264.00, 645001.00, 198948.00, 475790.34, 39649.19, 21807.06, 15198.86, 11894.76, 9912.30),
('Estate B', 17.50, 7, 449134.00, 573030.08, 522727.00, 547879.00, 170606.00, 402424.06, 33535.34, 18444.42, 12855.21, 10060.60, 8383.83),
('Estate C', 16.00, 6, 406342.40, 519103.49, 473593.00, 496348.00, 155021.00, 364082.79, 30340.23, 16687.13, 11630.42, 9102.07, 7585.06);

-- --------------------------------------------------------

--
-- Table structure for table `lot_reservations`
--

CREATE TABLE `lot_reservations` (
  `id` int(11) NOT NULL,
  `reservee_id` int(11) NOT NULL,
  `reserved_lot` varchar(255) NOT NULL,
  `lot_type` enum('Supreme','Special','Standard','Pending') NOT NULL DEFAULT 'Pending',
  `total_purchase_price` decimal(10,2) NOT NULL,
  `down_payment` decimal(10,2) DEFAULT NULL,
  `monthly_payment` decimal(10,2) DEFAULT NULL,
  `total_balance` decimal(10,2) NOT NULL,
  `payment_option` enum('Cash Sale: 10% Discount','6 Months: 5% Discount','Installment: 1 Year (0% Interest)','Installment: 2 Years (10% Interest)','Installment: 3 Years (15% Interest)','Installment: 4 Years (20% Interest)','Installment: 5 Years (25% Interest)','Pending') NOT NULL DEFAULT 'Pending',
  `reservation_status` enum('Pending','Verified','Active','Completed') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lot_reservations`
--

INSERT INTO `lot_reservations` (`id`, `reservee_id`, `reserved_lot`, `lot_type`, `total_purchase_price`, `down_payment`, `monthly_payment`, `total_balance`, `payment_option`, `reservation_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'P1-C29L3', 'Standard', 79378.40, NULL, NULL, 72441.00, 'Cash Sale: 10% Discount', 'Active', '2025-01-10 04:59:30', '2025-01-19 03:17:19'),
(2, 1, 'P1-C1L1', 'Supreme', 84342.24, 24868.45, 1486.84, 71368.55, 'Installment: 4 Years (20% Interest)', 'Active', '2025-01-10 10:47:27', '2025-01-19 03:17:23'),
(3, 1, 'P1-C29L4', 'Special', 81861.44, NULL, NULL, 78268.37, '6 Months: 5% Discount', 'Active', '2025-01-18 11:33:29', '2025-01-19 03:17:26'),
(4, 1, 'P1-C29L5', 'Supreme', 84342.24, NULL, NULL, 76908.02, 'Cash Sale: 10% Discount', 'Active', '2025-01-19 10:03:10', '2025-01-19 10:06:56'),
(5, 1, 'P1-C31L5', 'Supreme', 10560.00, NULL, NULL, 10504.00, 'Cash Sale: 10% Discount', 'Active', '2025-01-20 12:25:50', '2025-01-20 12:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `payment_plan` enum('Cash Sale','6 Months','1 Year','2 Years','3 Years','4 Years','5 Years') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` timestamp NULL DEFAULT NULL,
  `status` enum('Pending','Completed') NOT NULL DEFAULT 'Pending',
  `reference_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_plans`
--

CREATE TABLE `payment_plans` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `discount_rate` decimal(5,2) DEFAULT 0.00,
  `interest_rate` decimal(5,2) DEFAULT 0.00,
  `duration_months` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_plans`
--

INSERT INTO `payment_plans` (`plan_id`, `plan_name`, `discount_rate`, `interest_rate`, `duration_months`) VALUES
(1, 'Cash Sale', 10.00, 0.00, 0),
(2, '6 Months', 5.00, 0.00, 6),
(3, '1 Year', 0.00, 0.00, 12),
(4, '2 Years', 0.00, 10.00, 24),
(5, '3 Years', 0.00, 15.00, 36),
(6, '4 Years', 0.00, 20.00, 48),
(7, '5 Years', 0.00, 25.00, 60);

-- --------------------------------------------------------

--
-- Table structure for table `payment_terms`
--

CREATE TABLE `payment_terms` (
  `payment_term_id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `payment_option` enum('Cash Sale: 10% Discount','6 Months: 5% Discount','Installment: 1 Year (0% Interest)','Installment: 2 Years (10% Interest)','Installment: 3 Years (15% Interest)','Installment: 4 Years (20% Interest)','Installment: 5 Years (25% Interest)') NOT NULL,
  `installment_number` int(11) DEFAULT 1,
  `due_date` datetime NOT NULL,
  `amount_due` decimal(10,2) NOT NULL,
  `status` enum('Pending','Paid') DEFAULT 'Pending',
  `reference_number` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_terms`
--

INSERT INTO `payment_terms` (`payment_term_id`, `reservation_id`, `payment_option`, `installment_number`, `due_date`, `amount_due`, `status`, `reference_number`, `created_at`, `updated_at`) VALUES
(1, 4, 'Cash Sale: 10% Discount', 1, '2025-02-02 00:00:00', 76908.02, 'Paid', 'vY4we2P', '2025-01-19 18:08:21', '2025-01-21 12:30:49'),
(2, 5, 'Cash Sale: 10% Discount', 1, '2025-02-03 00:00:00', 10504.00, 'Pending', 'ybN6eko', '2025-01-20 20:27:13', '2025-01-21 12:30:50');

-- --------------------------------------------------------

--
-- Table structure for table `phase_price_list`
--

CREATE TABLE `phase_price_list` (
  `id` int(11) NOT NULL,
  `phase` varchar(10) NOT NULL,
  `lot_type` varchar(50) NOT NULL,
  `number_of_lots` int(11) NOT NULL DEFAULT 1,
  `lot_price` decimal(10,2) NOT NULL,
  `vat` decimal(5,2) DEFAULT 12.00,
  `memorial_care_fee` decimal(10,2) DEFAULT 10000.00,
  `total_purchase_price` decimal(10,2) NOT NULL,
  `cash_sale` decimal(10,2) NOT NULL,
  `cash_sale_discount` decimal(5,2) DEFAULT 10.00,
  `six_months` decimal(10,2) NOT NULL,
  `six_months_discount` decimal(5,2) DEFAULT 5.00,
  `down_payment` decimal(10,2) NOT NULL,
  `down_payment_rate` decimal(5,2) DEFAULT 20.00,
  `balance` decimal(10,2) NOT NULL,
  `monthly_amortization_one_year` decimal(10,2) NOT NULL,
  `one_year_interest_rate` decimal(5,2) DEFAULT 0.00,
  `monthly_amortization_two_years` decimal(10,2) NOT NULL,
  `two_years_interest_rate` decimal(5,2) DEFAULT 10.00,
  `monthly_amortization_three_years` decimal(10,2) NOT NULL,
  `three_years_interest_rate` decimal(5,2) DEFAULT 15.00,
  `monthly_amortization_four_years` decimal(10,2) NOT NULL,
  `four_years_interest_rate` decimal(5,2) DEFAULT 20.00,
  `monthly_amortization_five_years` decimal(10,2) NOT NULL,
  `five_years_interest_rate` decimal(5,2) DEFAULT 25.00,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phase_price_list`
--

INSERT INTO `phase_price_list` (`id`, `phase`, `lot_type`, `number_of_lots`, `lot_price`, `vat`, `memorial_care_fee`, `total_purchase_price`, `cash_sale`, `cash_sale_discount`, `six_months`, `six_months_discount`, `down_payment`, `down_payment_rate`, `balance`, `monthly_amortization_one_year`, `one_year_interest_rate`, `monthly_amortization_two_years`, `two_years_interest_rate`, `monthly_amortization_three_years`, `three_years_interest_rate`, `monthly_amortization_four_years`, `four_years_interest_rate`, `monthly_amortization_five_years`, `five_years_interest_rate`, `updated_at`) VALUES
(1, 'Phase 1', 'Supreme', 1, 500.00, 12.00, 10000.00, 10560.00, 10504.00, 10.00, 10532.00, 5.00, 10112.00, 20.00, 448.00, 37.33, 0.00, 20.53, 10.00, 14.31, 15.00, 11.20, 20.00, 9.33, 25.00, '2025-01-20 12:22:45'),
(2, 'Phase 1', 'Special', 1, 64162.00, 12.00, 10000.00, 81861.44, 74675.30, 10.00, 78268.37, 5.00, 24372.29, 20.00, 57489.15, 4790.76, 0.00, 2634.92, 10.00, 1836.46, 15.00, 1437.23, 20.00, 1197.69, 25.00, '2025-01-12 11:47:00'),
(3, 'Phase 1', 'Standard', 1, 61945.00, 12.00, 10000.00, 79378.40, 72441.00, 10.00, 75909.00, 5.00, 23786.00, 20.00, 55503.00, 4625.23, 0.00, 2543.87, 10.00, 1773.00, 15.00, 1387.57, 20.00, 1156.31, 25.00, '2025-01-12 11:47:00'),
(4, 'Phase 2', 'Supreme', 1, 64162.00, 12.00, 10000.00, 81861.44, 74675.30, 10.00, 78268.37, 5.00, 24372.29, 20.00, 57489.15, 4790.76, 0.00, 2634.92, 10.00, 1836.46, 15.00, 1437.23, 20.00, 1197.69, 25.00, '2025-01-20 11:22:22'),
(5, 'Phase 2', 'Standard', 1, 61945.00, 12.00, 10000.00, 79378.40, 72441.00, 10.00, 75909.00, 5.00, 23786.00, 20.00, 55503.00, 4625.23, 0.00, 2543.87, 10.00, 1773.00, 15.00, 1387.57, 20.00, 1156.31, 25.00, '2025-01-12 11:47:00'),
(6, 'Phase 3', 'Supreme', 1, 63491.00, 12.00, 10000.00, 81109.92, 73999.00, 10.00, 77554.00, 5.00, 24222.00, 20.00, 56888.00, 4740.66, 0.00, 2607.36, 10.00, 1817.25, 15.00, 1422.20, 20.00, 1185.17, 25.00, '2025-01-12 11:47:00'),
(7, 'Phase 3', 'Special', 1, 61372.00, 12.00, 10000.00, 78736.64, 71863.00, 10.00, 75300.00, 5.00, 23747.00, 20.00, 54989.00, 4582.44, 0.00, 2520.34, 10.00, 1756.60, 15.00, 1374.73, 20.00, 1145.61, 25.00, '2025-01-12 11:47:00'),
(8, 'Phase 3', 'Standard', 1, 59256.00, 12.00, 10000.00, 76366.72, 69730.00, 10.00, 73048.00, 5.00, 23273.00, 20.00, 53093.00, 4424.45, 0.00, 2433.45, 10.00, 1696.04, 15.00, 1327.33, 20.00, 1106.11, 25.00, '2025-01-12 11:47:00'),
(9, 'Phase 4', 'Supreme', 1, 63491.00, 12.00, 10000.00, 81109.92, 73999.00, 10.00, 77554.00, 5.00, 24222.00, 20.00, 56888.00, 4740.66, 0.00, 2607.36, 10.00, 1817.25, 15.00, 1422.20, 20.00, 1185.17, 25.00, '2025-01-12 11:47:00'),
(10, 'Phase 4', 'Special', 1, 61372.00, 12.00, 10000.00, 78736.64, 71863.00, 10.00, 75300.00, 5.00, 23747.00, 20.00, 54989.00, 4582.44, 0.00, 2520.34, 10.00, 1756.60, 15.00, 1374.73, 20.00, 1145.61, 25.00, '2025-01-12 11:47:00'),
(11, 'Phase 4', 'Standard', 1, 59256.00, 12.00, 10000.00, 76366.72, 69730.00, 10.00, 73048.00, 5.00, 23273.00, 20.00, 53093.00, 4424.45, 0.00, 2433.45, 10.00, 1696.04, 15.00, 1327.33, 20.00, 1106.11, 25.00, '2025-01-12 11:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `phase_price_list_backup`
--

CREATE TABLE `phase_price_list_backup` (
  `id` int(11) NOT NULL,
  `phase` varchar(10) NOT NULL,
  `lot_type` varchar(50) NOT NULL,
  `number_of_lots` int(11) NOT NULL DEFAULT 1,
  `lot_price` decimal(10,2) NOT NULL,
  `total_purchase_price` decimal(10,2) NOT NULL,
  `cash_sale_10_discount` decimal(10,2) NOT NULL,
  `cash_sale_5_discount` decimal(10,2) NOT NULL,
  `down_payment_20` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `monthly_amortization_1yr` decimal(10,2) NOT NULL,
  `monthly_amortization_2yrs_10_interest` decimal(10,2) NOT NULL,
  `monthly_amortization_3yrs_15_interest` decimal(10,2) NOT NULL,
  `monthly_amortization_4yrs_20_interest` decimal(10,2) NOT NULL,
  `monthly_amortization_5yrs_25_interest` decimal(10,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phase_price_list_backup`
--

INSERT INTO `phase_price_list_backup` (`id`, `phase`, `lot_type`, `number_of_lots`, `lot_price`, `total_purchase_price`, `cash_sale_10_discount`, `cash_sale_5_discount`, `down_payment_20`, `balance`, `monthly_amortization_1yr`, `monthly_amortization_2yrs_10_interest`, `monthly_amortization_3yrs_15_interest`, `monthly_amortization_4yrs_20_interest`, `monthly_amortization_5yrs_25_interest`, `updated_at`) VALUES
(1, 'Phase 1', 'Supreme Lot', 1, 66377.00, 84342.24, 76908.00, 80625.00, 24868.00, 59474.00, 4956.15, 2725.88, 1899.86, 1486.84, 1239.04, '2025-01-06 10:50:41'),
(2, 'Phase 1', 'Special Lot', 1, 64162.00, 81861.44, 74675.00, 78268.00, 24372.00, 57489.00, 4790.76, 2634.92, 1836.46, 1437.23, 1197.69, '2025-01-06 10:50:41'),
(3, 'Phase 1', 'Standard Lot', 1, 61945.00, 79378.40, 72441.00, 75909.00, 23786.00, 55503.00, 4625.23, 2543.87, 1773.00, 1387.57, 1156.31, '2025-01-06 10:50:41'),
(4, 'Phase 2', 'Supreme Lot', 1, 64162.00, 81861.44, 74675.00, 78268.00, 24372.00, 57489.00, 4790.76, 2634.92, 1836.46, 1437.23, 1197.69, '2025-01-06 10:50:41'),
(5, 'Phase 2', 'Standard Lot', 1, 61945.00, 79378.40, 72441.00, 75909.00, 23786.00, 55503.00, 4625.23, 2543.87, 1773.00, 1387.57, 1156.31, '2025-01-06 10:50:41'),
(6, 'Phase 3', 'Supreme Lot', 1, 63491.00, 81109.92, 73999.00, 77554.00, 24222.00, 56888.00, 4740.66, 2607.36, 1817.25, 1422.20, 1185.17, '2025-01-06 10:50:41'),
(7, 'Phase 3', 'Special Lot', 1, 61372.00, 78736.64, 71863.00, 75300.00, 23747.00, 54989.00, 4582.44, 2520.34, 1756.60, 1374.73, 1145.61, '2025-01-06 10:50:41'),
(8, 'Phase 3', 'Standard Lot', 1, 59256.00, 76366.72, 69730.00, 73048.00, 23273.00, 53093.00, 4424.45, 2433.45, 1696.04, 1327.33, 1106.11, '2025-01-06 10:50:41'),
(9, 'Phase 4', 'Supreme Lot', 1, 63491.00, 81109.92, 73999.00, 77554.00, 24222.00, 56888.00, 4740.66, 2607.36, 1817.25, 1422.20, 1185.17, '2025-01-06 10:50:41'),
(10, 'Phase 4', 'Special Lot', 1, 61372.00, 78736.64, 71863.00, 75300.00, 23747.00, 54989.00, 4582.44, 2520.34, 1756.60, 1374.73, 1145.61, '2025-01-06 10:50:41'),
(11, 'Phase 4', 'Standard Lot', 1, 59256.00, 76366.72, 69730.00, 73048.00, 23273.00, 53093.00, 4424.45, 2433.45, 1696.04, 1327.33, 1106.11, '2025-01-06 10:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_middlename` varchar(50) DEFAULT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_suffix` varchar(10) DEFAULT NULL,
  `role` enum('Admin','Manager','Viewer') DEFAULT 'Viewer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `user_firstname`, `user_middlename`, `user_lastname`, `user_suffix`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.com', '123', 'Admin', 'Michael', 'User', NULL, 'Admin', '2024-12-26 10:01:20', '2024-12-26 10:39:20'),
(2, 'manager_jane', 'jane.doe@example.com', 'hashed_password_2', 'Jane', 'Marie', 'Doe', NULL, 'Manager', '2024-12-26 10:01:20', '2024-12-26 10:01:20'),
(3, 'viewer_john', 'john.smith@example.com', 'hashed_password_3', 'John', 'David', 'Smith', 'Jr.', 'Viewer', '2024-12-26 10:01:20', '2024-12-26 10:01:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `burial_reservations`
--
ALTER TABLE `burial_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservee_id` (`reservee_id`);

--
-- Indexes for table `cemetery_lots`
--
ALTER TABLE `cemetery_lots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grave_id` (`lot_id`),
  ADD KEY `fk_customer_id` (`owner_id`);

--
-- Indexes for table `contact_form_submissions`
--
ALTER TABLE `contact_form_submissions`
  ADD PRIMARY KEY (`submission_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `deceased`
--
ALTER TABLE `deceased`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grave_id` (`location`);

--
-- Indexes for table `deceased_backup`
--
ALTER TABLE `deceased_backup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grave_id` (`location`);

--
-- Indexes for table `estates`
--
ALTER TABLE `estates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `estate_id` (`estate_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `lot_reservations`
--
ALTER TABLE `lot_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reserver_id` (`reservee_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `payment_plans`
--
ALTER TABLE `payment_plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `payment_terms`
--
ALTER TABLE `payment_terms`
  ADD PRIMARY KEY (`payment_term_id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `phase_price_list`
--
ALTER TABLE `phase_price_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phase_price_list_backup`
--
ALTER TABLE `phase_price_list_backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `burial_reservations`
--
ALTER TABLE `burial_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cemetery_lots`
--
ALTER TABLE `cemetery_lots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_form_submissions`
--
ALTER TABLE `contact_form_submissions`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deceased`
--
ALTER TABLE `deceased`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `deceased_backup`
--
ALTER TABLE `deceased_backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `estates`
--
ALTER TABLE `estates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `lot_reservations`
--
ALTER TABLE `lot_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_plans`
--
ALTER TABLE `payment_plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_terms`
--
ALTER TABLE `payment_terms`
  MODIFY `payment_term_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `phase_price_list`
--
ALTER TABLE `phase_price_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `phase_price_list_backup`
--
ALTER TABLE `phase_price_list_backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `burial_reservations`
--
ALTER TABLE `burial_reservations`
  ADD CONSTRAINT `burial_reservations_ibfk_1` FOREIGN KEY (`reservee_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `cemetery_lots`
--
ALTER TABLE `cemetery_lots`
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`owner_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `deceased_backup`
--
ALTER TABLE `deceased_backup`
  ADD CONSTRAINT `deceased_backup_ibfk_1` FOREIGN KEY (`location`) REFERENCES `cemetery_lots` (`lot_id`) ON DELETE CASCADE;

--
-- Constraints for table `lot_reservations`
--
ALTER TABLE `lot_reservations`
  ADD CONSTRAINT `lot_reservations_ibfk_1` FOREIGN KEY (`reservee_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `lot_reservations` (`id`);

--
-- Constraints for table `payment_terms`
--
ALTER TABLE `payment_terms`
  ADD CONSTRAINT `payment_terms_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `lot_reservations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
