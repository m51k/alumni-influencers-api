-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 01, 2026 at 07:05 PM
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
-- Database: `alumni_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key_hash` varchar(64) NOT NULL,
  `label` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `revoked_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `permissions` varchar(255) NOT NULL DEFAULT 'read:alumni_of_day'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `user_id`, `key_hash`, `label`, `is_active`, `revoked_at`, `created_at`, `permissions`) VALUES
(1, 2, 'f23f0e736c38e55339dc188c648bc86496b464f5d612a36d7c4aa2eb4488b4c5', 'AR Client Key', 0, '2026-04-06 02:25:51', '2026-04-06 02:17:17', 'read:alumni_of_day'),
(2, 2, '070ba10e4debcce433c143b9bd0c7daa01f8a883df5fc0fff36a395456f8751a', 'AR Client Key', 0, '2026-04-06 02:20:22', '2026-04-06 02:20:21', 'read:alumni_of_day'),
(3, 2, 'fc8f403593f1856aa6c72cd70c4d99e27679659bf9702a8707eb25df5caf4cd7', 'testing', 1, NULL, '2026-04-06 02:23:08', 'read:alumni_of_day'),
(4, 2, '7ca0e2fe20552d6fbfa1367d9d3c9bc4a0cd920b232ffc74ca6b0af3cea4d06d', 'Analytics Dashboard Key', 1, NULL, '2026-05-01 00:19:19', 'read:alumni,read:analytics'),
(5, 2, '7bc13dae2c544668c78dc23babbdaf355a094692fdec5c768c4dbae7a0ac67d1', 'AR App Key', 1, NULL, '2026-05-01 00:20:17', 'read:alumni_of_day');

-- --------------------------------------------------------

--
-- Table structure for table `api_key_logs`
--

CREATE TABLE `api_key_logs` (
  `id` int(11) NOT NULL,
  `api_key_id` int(11) NOT NULL,
  `endpoint` varchar(255) NOT NULL,
  `method` varchar(10) NOT NULL,
  `accessed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `api_key_logs`
--

INSERT INTO `api_key_logs` (`id`, `api_key_id`, `endpoint`, `method`, `accessed_at`) VALUES
(1, 3, 'api/v1/alumni/today', 'GET', '2026-04-06 02:27:16'),
(2, 3, 'api/v1/alumni/today', 'GET', '2026-04-06 02:27:41'),
(3, 3, 'api/v1/alumni/today', 'GET', '2026-04-06 02:30:54'),
(4, 5, 'api/v1/alumni/today', 'GET', '2026-05-01 00:20:24');

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `slot_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('active','cancelled') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`id`, `user_id`, `slot_date`, `amount`, `status`, `created_at`) VALUES
(1, 1, '2026-04-07', 200.00, 'cancelled', '2026-04-06 02:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `bid_winners`
--

CREATE TABLE `bid_winners` (
  `id` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `slot_date` date NOT NULL,
  `selected_at` datetime NOT NULL DEFAULT current_timestamp(),
  `appearance_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certifications`
--

CREATE TABLE `certifications` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `issuer` varchar(255) NOT NULL,
  `issued_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certifications`
--

INSERT INTO `certifications` (`id`, `profile_id`, `title`, `issuer`, `issued_at`) VALUES
(2, 1, 'AWS Solutions Architect', 'Amazon', '2023-06-01'),
(3, 1, 'Google Cloud Professional', 'Google', '2024-01-15'),
(4, 2, 'Google Cloud Professional', 'Google', '2024-03-01'),
(5, 2, 'TensorFlow Developer Certificate', 'Google', '2024-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('v7setuof7bra739smnjbeg4v2e5ql80f', '::1', 1777602065, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373630323036353b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('116glaa336inid1t9o5pf3t0p2dl9u2l', '::1', 1777602917, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373630323931373b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('s2phfns4d4aa93l31f4cgv2tdfed2946', '::1', 1777602998, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373630323939383b),
('95b1t6aoogcd9rc3tsd6di120ol7qtli', '::1', 1777607272, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373630373237313b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('p0i07gfdr7vjovnqp7qsuc3336pn0kqq', '::1', 1777603195, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373630333137393b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('h4stcqnntb3ronsgl87k430pj9qopvsa', '::1', 1777607273, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373630373237313b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('aovvltrg0sa1g4csmpevjn224cauhfue', '::1', 1777625056, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373632353035363b757365725f69647c733a313a2231223b726f6c657c733a373a22616c756d6e7573223b),
('n7ifcud2pl7d2fctt48kk53lhe228rkr', '::1', 1777620100, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373632303130303b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('p71gs2nk7bdjkools4jl5rtc9bdrtss5', '::1', 1777619759, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373631393735393b),
('ckvb3a0q7s52irnl9d0kb0ojfdc40ua1', '::1', 1777621417, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373632313431373b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('7ls6vkkfh8n0cgnom95alo4khknk3bdm', '::1', 1777621858, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373632313835383b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('ranqpnmp517sec9f8g9jivd1b2r1q07b', '::1', 1777622173, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373632323137333b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('dfbo2n2tmhhi1cap7rb45vm30ea9g9ma', '::1', 1777624134, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373632343133343b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('33tf418ghal2j73uf80sra7vuphcoras', '::1', 1777625296, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373632353239363b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('o6hb7vc5l0uigevsf4qp17taqi2p8p02', '::1', 1777625287, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373632353238303b757365725f69647c733a313a2234223b726f6c657c733a373a22616c756d6e7573223b),
('f464aoq8fovboosf7bpg48brtgr48oiq', '::1', 1777625296, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373632353239363b757365725f69647c733a313a2233223b726f6c657c733a353a227374616666223b),
('fqgh61fhqdkssjh57si8l9sntk8h1j6d', '::1', 1777651322, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373635313332323b),
('7pvivdu2939r5bs0e4bknsrn2a6ql5ra', '::1', 1777651322, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373635313332323b);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `completed_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `profile_id`, `title`, `provider`, `completed_at`) VALUES
(2, 1, 'Machine Learning', 'Coursera', '2023-09-01'),
(3, 1, 'Agile and Scrum', 'Udemy', '2024-02-01'),
(4, 2, 'Deep Learning Specialisation', 'Coursera', '2024-01-15'),
(5, 2, 'SQL for Data Science', 'Udemy', '2024-03-10'),
(6, 2, 'Machine Learning', 'Coursera', '2023-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `degrees`
--

CREATE TABLE `degrees` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `grad_year` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `degrees`
--

INSERT INTO `degrees` (`id`, `profile_id`, `institution`, `qualification`, `grad_year`) VALUES
(2, 1, 'University of Eastminster', 'BSc Computer Science', '2023'),
(3, 2, 'University of Eastminster', 'BSc Data Science', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `employment`
--

CREATE TABLE `employment` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employment`
--

INSERT INTO `employment` (`id`, `profile_id`, `company`, `role`, `start_date`, `end_date`) VALUES
(2, 1, 'Phantasmagoria Ltd', 'Software Engineer', '2023-09-01', NULL),
(3, 2, 'DataCorp Ltd', 'Data Analyst', '2024-09-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_attendance`
--

CREATE TABLE `event_attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_attendance`
--

INSERT INTO `event_attendance` (`id`, `user_id`, `event_name`, `event_date`) VALUES
(1, 1, 'Alumni Networking Night', '2026-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `licences`
--

CREATE TABLE `licences` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `issuer` varchar(255) NOT NULL,
  `expires_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `licences`
--

INSERT INTO `licences` (`id`, `profile_id`, `title`, `issuer`, `expires_at`) VALUES
(2, 1, 'Driving Licence', 'DVLA', '2030-01-01'),
(3, 2, 'Certified Data Protection Officer', 'IAPP', '2027-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `programme` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `linkedin_url`, `image_path`, `is_complete`, `programme`, `location`) VALUES
(1, 1, 'https://linkedin.com/in/testalumnus', NULL, 1, 'BSc Computer Science', 'London'),
(2, 4, 'https://linkedin.com/in/datascialumnus', NULL, 1, 'BSc Data Science', 'Manchester');

-- --------------------------------------------------------

--
-- Table structure for table `rate_limits`
--

CREATE TABLE `rate_limits` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `endpoint` varchar(255) NOT NULL,
  `requests` int(11) NOT NULL DEFAULT 1,
  `window_start` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rate_limits`
--

INSERT INTO `rate_limits` (`id`, `ip_address`, `endpoint`, `requests`, `window_start`) VALUES
(1, '::1', 'api/v1/auth/register', 1, '2026-04-06 02:02:14'),
(2, '::1', 'api/v1/auth/verify/a6c864441ec0ac8d4e40ca4b62347be3dde63ef668bcdff5be60c88e889a8cbb', 1, '2026-04-06 02:02:47'),
(3, '::1', 'api/v1/auth/login', 1, '2026-04-06 02:02:51'),
(4, '::1', 'api/v1/auth/login', 1, '2026-04-06 02:14:31'),
(5, '::1', 'api/v1/alumnus/profile', 3, '2026-04-06 02:14:38'),
(6, '::1', 'api/v1/alumnus/degrees', 1, '2026-04-06 02:14:38'),
(7, '::1', 'api/v1/alumnus/degrees/1', 2, '2026-04-06 02:14:38'),
(8, '::1', 'api/v1/alumnus/certifications', 1, '2026-04-06 02:14:38'),
(9, '::1', 'api/v1/alumnus/certifications/1', 1, '2026-04-06 02:14:38'),
(10, '::1', 'api/v1/alumnus/licences', 1, '2026-04-06 02:14:38'),
(11, '::1', 'api/v1/alumnus/licences/1', 1, '2026-04-06 02:14:39'),
(12, '::1', 'api/v1/alumnus/courses', 1, '2026-04-06 02:14:39'),
(13, '::1', 'api/v1/alumnus/courses/1', 1, '2026-04-06 02:14:39'),
(14, '::1', 'api/v1/alumnus/employment', 1, '2026-04-06 02:14:39'),
(15, '::1', 'api/v1/alumnus/employment/1', 1, '2026-04-06 02:14:39'),
(16, '::1', 'api/v1/alumnus/event', 2, '2026-04-06 02:14:39'),
(17, '::1', 'api/v1/alumnus/bid/slot', 1, '2026-04-06 02:15:47'),
(18, '::1', 'api/v1/alumnus/bid', 2, '2026-04-06 02:15:47'),
(19, '::1', 'api/v1/alumnus/bid/1', 3, '2026-04-06 02:15:47'),
(20, '::1', 'api/v1/alumnus/bid/status', 1, '2026-04-06 02:15:47'),
(21, '::1', 'api/v1/alumnus/bid/history', 1, '2026-04-06 02:15:47'),
(22, '::1', 'api/v1/alumnus/bid/limit', 1, '2026-04-06 02:15:47'),
(23, '::1', 'api/v1/auth/register', 1, '2026-04-06 02:16:42'),
(24, '::1', 'api/v1/auth/verify/ea5a96ee9be99f9664022d8aca51c365455ccf12f438a71691e8160e83bb3900', 1, '2026-04-06 02:17:01'),
(25, '::1', 'api/v1/auth/login', 1, '2026-04-06 02:17:05'),
(26, '::1', 'api/v1/developer/keys', 2, '2026-04-06 02:17:17'),
(27, '::1', 'api/v1/auth/login', 1, '2026-04-06 02:20:15'),
(28, '::1', 'api/v1/developer/keys', 3, '2026-04-06 02:20:21'),
(29, '::1', 'api/v1/developer/keys/2/stats', 1, '2026-04-06 02:20:22'),
(30, '::1', 'api/v1/developer/keys/2', 2, '2026-04-06 02:20:22'),
(31, '::1', 'api/v1/alumnus/profile', 4, '2026-04-06 02:22:28'),
(32, '::1', 'api/v1/auth/login', 1, '2026-04-06 02:22:52'),
(33, '::1', 'api/v1/developer/keys', 5, '2026-04-06 02:22:56'),
(34, '::1', 'api/v1/alumnus/profile', 13, '2026-04-06 02:25:00'),
(35, '::1', 'api/v1/auth/logout', 1, '2026-04-06 02:25:18'),
(36, '::1', 'api/v1/auth/login', 1, '2026-04-06 02:25:41'),
(37, '::1', 'api/v1/developer/keys', 3, '2026-04-06 02:25:43'),
(38, '::1', 'api/v1/developer/keys/1', 1, '2026-04-06 02:25:51'),
(39, '::1', 'api/v1/developer/keys/2', 1, '2026-04-06 02:25:55'),
(40, '::1', 'api/v1/alumnus/profile', 1, '2026-04-06 02:26:20'),
(41, '::1', 'api/v1/auth/login', 1, '2026-04-06 02:27:11'),
(42, '::1', 'api/v1/alumni/today', 4, '2026-04-06 02:27:16'),
(43, '::1', 'api/v1/alumnus/profile', 1, '2026-04-06 02:28:03'),
(44, '::1', 'api/v1/developer/keys', 1, '2026-04-06 02:28:03'),
(45, '::1', 'api/v1/alumnus/profile', 3, '2026-04-06 02:29:42'),
(46, '::1', 'api/v1/developer/keys', 2, '2026-04-06 02:29:42'),
(47, '::1', 'api/v1/alumni/today', 1, '2026-04-06 02:30:54'),
(48, '::1', 'api/v1/alumnus/profile', 1, '2026-04-30 23:50:07'),
(49, '::1', 'api/v1/alumnus/profile', 1, '2026-04-30 23:55:43'),
(50, '::1', 'api/v1/auth/register', 1, '2026-05-01 00:05:44'),
(51, '::1', 'api/v1/auth/verify/ceb88ee1a022344b40ee47dd51d9d58c23c9000a9b1d3cbd41b5aa56dcdc6ced', 1, '2026-05-01 00:07:26'),
(52, '::1', 'api/v1/auth/login', 1, '2026-05-01 00:07:31'),
(53, '::1', 'api/v1/auth/login', 1, '2026-05-01 00:09:33'),
(54, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 00:10:26'),
(55, '::1', 'api/v1/auth/login', 1, '2026-05-01 00:13:18'),
(56, '::1', 'api/v1/analytics/filters', 2, '2026-05-01 00:13:20'),
(57, '::1', 'api/v1/analytics/alumni', 7, '2026-05-01 00:13:25'),
(58, '::1', 'api/v1/analytics/skills-gap', 2, '2026-05-01 00:13:38'),
(59, '::1', 'api/v1/analytics/employment', 2, '2026-05-01 00:13:43'),
(60, '::1', 'api/v1/analytics/job-titles', 2, '2026-05-01 00:13:45'),
(61, '::1', 'api/v1/analytics/employers', 2, '2026-05-01 00:13:52'),
(62, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 00:13:52'),
(63, '::1', 'api/v1/analytics/certifications', 1, '2026-05-01 00:13:52'),
(64, '::1', 'api/v1/analytics/courses', 1, '2026-05-01 00:13:52'),
(65, '::1', 'api/v1/analytics/trends', 1, '2026-05-01 00:13:52'),
(66, '::1', 'api/v1/analytics/alumni', 1, '2026-05-01 00:15:22'),
(67, '::1', 'api/v1/auth/logout', 1, '2026-05-01 00:18:54'),
(68, '::1', 'api/v1/auth/login', 1, '2026-05-01 00:19:07'),
(69, '::1', 'api/v1/developer/keys', 2, '2026-05-01 00:19:19'),
(70, '::1', 'api/v1/alumni/today', 2, '2026-05-01 00:20:24'),
(71, '::1', 'api/v1/developer/keys', 1, '2026-05-01 00:20:52'),
(72, '::1', 'api/v1/auth/login', 1, '2026-05-01 01:00:28'),
(73, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 01:00:28'),
(74, '::1', 'api/v1/analytics/alumni', 1, '2026-05-01 01:00:28'),
(75, '::1', 'api/v1/analytics/employment', 1, '2026-05-01 01:00:28'),
(76, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 01:00:28'),
(77, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 01:00:28'),
(78, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 01:00:28'),
(79, '::1', 'api/v1/analytics/filters', 16, '2026-05-01 01:09:56'),
(80, '::1', 'api/v1/analytics/alumni', 16, '2026-05-01 01:09:56'),
(81, '::1', 'api/v1/analytics/employment', 16, '2026-05-01 01:09:56'),
(82, '::1', 'api/v1/analytics/employers', 16, '2026-05-01 01:09:56'),
(83, '::1', 'api/v1/analytics/job-titles', 16, '2026-05-01 01:09:56'),
(84, '::1', 'api/v1/analytics/geographic', 16, '2026-05-01 01:09:56'),
(85, '::1', 'api/v1/auth/logout', 2, '2026-05-01 01:10:07'),
(86, '::1', 'api/v1/auth/role', 1, '2026-05-01 01:10:25'),
(87, '::1', 'api/v1/auth/role', 7, '2026-05-01 01:11:38'),
(88, '::1', 'api/v1/analytics/filters', 7, '2026-05-01 01:11:38'),
(89, '::1', 'api/v1/analytics/alumni', 2, '2026-05-01 01:11:38'),
(90, '::1', 'api/v1/analytics/employment', 2, '2026-05-01 01:11:38'),
(91, '::1', 'api/v1/analytics/employers', 2, '2026-05-01 01:11:38'),
(92, '::1', 'api/v1/analytics/job-titles', 2, '2026-05-01 01:11:38'),
(93, '::1', 'api/v1/analytics/geographic', 2, '2026-05-01 01:11:38'),
(94, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 01:13:35'),
(95, '::1', 'api/v1/analytics/alumni', 1, '2026-05-01 01:13:35'),
(96, '::1', 'api/v1/analytics/employment', 1, '2026-05-01 01:13:35'),
(97, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 01:13:35'),
(98, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 01:13:35'),
(99, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 01:13:35'),
(100, '::1', 'api/v1/auth/role', 1, '2026-05-01 01:15:30'),
(101, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 01:15:30'),
(102, '::1', 'api/v1/analytics/alumni', 1, '2026-05-01 01:15:30'),
(103, '::1', 'api/v1/analytics/employment', 1, '2026-05-01 01:15:30'),
(104, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 01:15:30'),
(105, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 01:15:30'),
(106, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 01:15:30'),
(107, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 01:17:51'),
(108, '::1', 'api/v1/analytics/alumni', 1, '2026-05-01 01:17:51'),
(109, '::1', 'api/v1/analytics/employment', 1, '2026-05-01 01:17:51'),
(110, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 01:17:51'),
(111, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 01:17:51'),
(112, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 01:17:51'),
(113, '::1', 'api/v1/analytics/filters', 20, '2026-05-01 01:19:24'),
(114, '::1', 'api/v1/analytics/alumni', 20, '2026-05-01 01:19:24'),
(115, '::1', 'api/v1/analytics/employment', 20, '2026-05-01 01:19:24'),
(116, '::1', 'api/v1/analytics/employers', 20, '2026-05-01 01:19:24'),
(117, '::1', 'api/v1/analytics/job-titles', 20, '2026-05-01 01:19:24'),
(118, '::1', 'api/v1/analytics/geographic', 20, '2026-05-01 01:19:24'),
(119, '::1', 'api/v1/auth/role', 1, '2026-05-01 02:21:05'),
(120, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 02:21:05'),
(121, '::1', 'api/v1/analytics/alumni', 2, '2026-05-01 02:21:05'),
(122, '::1', 'api/v1/analytics/employment', 1, '2026-05-01 02:21:05'),
(123, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 02:21:05'),
(124, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 02:21:05'),
(125, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 02:21:05'),
(126, '::1', 'api/v1/analytics/certifications', 1, '2026-05-01 02:21:05'),
(127, '::1', 'api/v1/analytics/courses', 1, '2026-05-01 02:21:05'),
(128, '::1', 'api/v1/analytics/skills-gap', 1, '2026-05-01 02:21:05'),
(129, '::1', 'api/v1/analytics/trends', 1, '2026-05-01 02:21:05'),
(130, '::1', 'api/v1/alumnus/profile', 1, '2026-05-01 02:23:41'),
(131, '::1', 'api/v1/auth/role', 2, '2026-05-01 02:35:17'),
(132, '::1', 'api/v1/analytics/filters', 2, '2026-05-01 02:35:17'),
(133, '::1', 'api/v1/analytics/alumni', 4, '2026-05-01 02:35:17'),
(134, '::1', 'api/v1/analytics/employment', 2, '2026-05-01 02:35:17'),
(135, '::1', 'api/v1/analytics/employers', 2, '2026-05-01 02:35:18'),
(136, '::1', 'api/v1/analytics/job-titles', 2, '2026-05-01 02:35:18'),
(137, '::1', 'api/v1/analytics/geographic', 2, '2026-05-01 02:35:18'),
(138, '::1', 'api/v1/analytics/certifications', 2, '2026-05-01 02:35:18'),
(139, '::1', 'api/v1/analytics/courses', 2, '2026-05-01 02:35:18'),
(140, '::1', 'api/v1/analytics/skills-gap', 2, '2026-05-01 02:35:18'),
(141, '::1', 'api/v1/analytics/trends', 2, '2026-05-01 02:35:18'),
(142, '::1', 'api/v1/auth/logout', 1, '2026-05-01 02:36:38'),
(143, '::1', 'api/v1/auth/login', 1, '2026-05-01 02:36:45'),
(144, '::1', 'api/v1/alumnus/profile', 2, '2026-05-01 02:36:52'),
(145, '::1', 'api/v1/alumnus/degrees', 1, '2026-05-01 02:36:52'),
(146, '::1', 'api/v1/alumnus/certifications', 2, '2026-05-01 02:36:52'),
(147, '::1', 'api/v1/alumnus/courses', 2, '2026-05-01 02:36:52'),
(148, '::1', 'api/v1/alumnus/employment', 1, '2026-05-01 02:36:52'),
(149, '::1', 'api/v1/alumnus/licences', 1, '2026-05-01 02:36:52'),
(150, '::1', 'api/v1/auth/role', 2, '2026-05-01 02:36:57'),
(151, '::1', 'api/v1/analytics/filters', 2, '2026-05-01 02:36:57'),
(152, '::1', 'api/v1/analytics/alumni', 4, '2026-05-01 02:36:57'),
(153, '::1', 'api/v1/analytics/employment', 2, '2026-05-01 02:36:57'),
(154, '::1', 'api/v1/analytics/employers', 2, '2026-05-01 02:36:57'),
(155, '::1', 'api/v1/analytics/job-titles', 2, '2026-05-01 02:36:57'),
(156, '::1', 'api/v1/analytics/geographic', 2, '2026-05-01 02:36:57'),
(157, '::1', 'api/v1/analytics/certifications', 2, '2026-05-01 02:36:57'),
(158, '::1', 'api/v1/analytics/courses', 2, '2026-05-01 02:36:57'),
(159, '::1', 'api/v1/analytics/skills-gap', 2, '2026-05-01 02:36:57'),
(160, '::1', 'api/v1/analytics/trends', 2, '2026-05-01 02:36:57'),
(161, '::1', 'api/v1/analytics/alumni', 3, '2026-05-01 02:38:00'),
(162, '::1', 'api/v1/analytics/employment', 2, '2026-05-01 02:38:08'),
(163, '::1', 'api/v1/analytics/certifications', 2, '2026-05-01 02:38:13'),
(164, '::1', 'api/v1/analytics/courses', 2, '2026-05-01 02:38:17'),
(165, '::1', 'api/v1/alumnus/profile', 1, '2026-05-01 02:38:40'),
(166, '::1', 'api/v1/auth/role', 1, '2026-05-01 02:38:42'),
(167, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 02:38:42'),
(168, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 02:38:42'),
(169, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 02:38:42'),
(170, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 02:38:42'),
(171, '::1', 'api/v1/analytics/skills-gap', 1, '2026-05-01 02:38:42'),
(172, '::1', 'api/v1/analytics/trends', 1, '2026-05-01 02:38:42'),
(173, '::1', 'api/v1/analytics/alumni', 3, '2026-05-01 02:39:02'),
(174, '::1', 'api/v1/auth/logout', 1, '2026-05-01 02:39:34'),
(175, '::1', 'api/v1/auth/login', 1, '2026-05-01 02:39:39'),
(176, '::1', 'api/v1/analytics/alumni', 4, '2026-05-01 03:47:51'),
(177, '::1', 'api/v1/analytics/geographic', 2, '2026-05-01 03:47:51'),
(178, '::1', 'api/v1/analytics/certifications', 2, '2026-05-01 03:47:51'),
(179, '::1', 'api/v1/analytics/courses', 2, '2026-05-01 03:47:51'),
(180, '::1', 'api/v1/analytics/skills-gap', 2, '2026-05-01 03:47:51'),
(181, '::1', 'api/v1/analytics/trends', 2, '2026-05-01 03:47:51'),
(182, '::1', 'api/v1/analytics/employment', 2, '2026-05-01 03:47:51'),
(183, '::1', 'api/v1/analytics/employers', 2, '2026-05-01 03:47:52'),
(184, '::1', 'api/v1/analytics/job-titles', 2, '2026-05-01 03:47:52'),
(185, '::1', 'api/v1/auth/login', 2, '2026-05-01 07:15:52'),
(186, '::1', 'api/v1/alumnus/profile', 1, '2026-05-01 07:15:56'),
(187, '::1', 'api/v1/auth/role', 3, '2026-05-01 07:15:59'),
(188, '::1', 'api/v1/analytics/filters', 2, '2026-05-01 07:15:59'),
(189, '::1', 'api/v1/analytics/alumni', 5, '2026-05-01 07:16:38'),
(190, '::1', 'api/v1/analytics/employment', 1, '2026-05-01 07:16:38'),
(191, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 07:16:38'),
(192, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 07:16:38'),
(193, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 07:16:38'),
(194, '::1', 'api/v1/analytics/certifications', 1, '2026-05-01 07:16:38'),
(195, '::1', 'api/v1/analytics/courses', 1, '2026-05-01 07:16:38'),
(196, '::1', 'api/v1/analytics/skills-gap', 1, '2026-05-01 07:16:38'),
(197, '::1', 'api/v1/analytics/trends', 1, '2026-05-01 07:16:38'),
(198, '::1', 'api/v1/auth/role', 1, '2026-05-01 07:21:40'),
(199, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 07:21:40'),
(200, '::1', 'api/v1/analytics/alumni', 4, '2026-05-01 07:21:40'),
(201, '::1', 'api/v1/analytics/employment', 1, '2026-05-01 07:21:40'),
(202, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 07:21:40'),
(203, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 07:21:40'),
(204, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 07:21:40'),
(205, '::1', 'api/v1/analytics/certifications', 1, '2026-05-01 07:21:40'),
(206, '::1', 'api/v1/analytics/courses', 1, '2026-05-01 07:21:40'),
(207, '::1', 'api/v1/analytics/skills-gap', 1, '2026-05-01 07:21:40'),
(208, '::1', 'api/v1/analytics/trends', 1, '2026-05-01 07:21:40'),
(209, '::1', 'api/v1/auth/role', 1, '2026-05-01 07:43:37'),
(210, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 07:43:37'),
(211, '::1', 'api/v1/analytics/alumni', 2, '2026-05-01 07:43:37'),
(212, '::1', 'api/v1/analytics/employment', 1, '2026-05-01 07:43:37'),
(213, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 07:43:37'),
(214, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 07:43:37'),
(215, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 07:43:37'),
(216, '::1', 'api/v1/analytics/certifications', 1, '2026-05-01 07:43:37'),
(217, '::1', 'api/v1/analytics/courses', 1, '2026-05-01 07:43:37'),
(218, '::1', 'api/v1/analytics/skills-gap', 1, '2026-05-01 07:43:37'),
(219, '::1', 'api/v1/analytics/trends', 1, '2026-05-01 07:43:37'),
(220, '::1', 'api/v1/auth/role', 1, '2026-05-01 07:47:35'),
(221, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 07:47:36'),
(222, '::1', 'api/v1/analytics/alumni', 5, '2026-05-01 07:47:36'),
(223, '::1', 'api/v1/analytics/employment', 1, '2026-05-01 07:47:36'),
(224, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 07:47:36'),
(225, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 07:47:36'),
(226, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 07:47:36'),
(227, '::1', 'api/v1/analytics/certifications', 1, '2026-05-01 07:47:36'),
(228, '::1', 'api/v1/analytics/courses', 1, '2026-05-01 07:47:36'),
(229, '::1', 'api/v1/analytics/skills-gap', 1, '2026-05-01 07:47:36'),
(230, '::1', 'api/v1/analytics/trends', 1, '2026-05-01 07:47:36'),
(231, '::1', 'api/v1/auth/role', 1, '2026-05-01 07:50:58'),
(232, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 07:50:58'),
(233, '::1', 'api/v1/analytics/alumni', 14, '2026-05-01 07:50:58'),
(234, '::1', 'api/v1/analytics/employment', 5, '2026-05-01 07:50:58'),
(235, '::1', 'api/v1/analytics/employers', 5, '2026-05-01 07:50:58'),
(236, '::1', 'api/v1/analytics/job-titles', 5, '2026-05-01 07:50:58'),
(237, '::1', 'api/v1/analytics/geographic', 5, '2026-05-01 07:50:58'),
(238, '::1', 'api/v1/analytics/certifications', 5, '2026-05-01 07:50:58'),
(239, '::1', 'api/v1/analytics/courses', 5, '2026-05-01 07:50:58'),
(240, '::1', 'api/v1/analytics/skills-gap', 5, '2026-05-01 07:50:58'),
(241, '::1', 'api/v1/analytics/trends', 5, '2026-05-01 07:50:58'),
(242, '::1', 'api/v1/auth/role', 1, '2026-05-01 07:53:21'),
(243, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 07:53:21'),
(244, '::1', 'api/v1/analytics/alumni', 5, '2026-05-01 07:53:21'),
(245, '::1', 'api/v1/analytics/employment', 1, '2026-05-01 07:53:21'),
(246, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 07:53:22'),
(247, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 07:53:22'),
(248, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 07:53:22'),
(249, '::1', 'api/v1/analytics/certifications', 1, '2026-05-01 07:53:22'),
(250, '::1', 'api/v1/analytics/courses', 1, '2026-05-01 07:53:22'),
(251, '::1', 'api/v1/analytics/skills-gap', 1, '2026-05-01 07:53:22'),
(252, '::1', 'api/v1/analytics/trends', 1, '2026-05-01 07:53:22'),
(253, '::1', 'api/v1/analytics/alumni', 1, '2026-05-01 07:56:13'),
(254, '::1', 'api/v1/auth/role', 6, '2026-05-01 08:28:54'),
(255, '::1', 'api/v1/analytics/filters', 6, '2026-05-01 08:28:54'),
(256, '::1', 'api/v1/analytics/alumni', 12, '2026-05-01 08:28:54'),
(257, '::1', 'api/v1/analytics/employment', 6, '2026-05-01 08:28:54'),
(258, '::1', 'api/v1/analytics/employers', 6, '2026-05-01 08:28:54'),
(259, '::1', 'api/v1/analytics/job-titles', 6, '2026-05-01 08:28:54'),
(260, '::1', 'api/v1/analytics/geographic', 6, '2026-05-01 08:28:54'),
(261, '::1', 'api/v1/analytics/certifications', 6, '2026-05-01 08:28:54'),
(262, '::1', 'api/v1/analytics/courses', 6, '2026-05-01 08:28:54'),
(263, '::1', 'api/v1/analytics/skills-gap', 6, '2026-05-01 08:28:54'),
(264, '::1', 'api/v1/analytics/trends', 6, '2026-05-01 08:28:54'),
(265, '::1', 'api/v1/auth/register', 1, '2026-05-01 08:44:16'),
(266, '::1', 'api/v1/auth/verify/c21775fecaa81babe20b006b0f2cf4c9288c855fc754f3d3c07b0ad6d0c72619', 1, '2026-05-01 08:44:44'),
(267, '::1', 'api/v1/auth/logout', 1, '2026-05-01 08:47:31'),
(268, '::1', 'api/v1/auth/login', 1, '2026-05-01 08:48:00'),
(269, '::1', 'api/v1/alumnus/profile', 2, '2026-05-01 08:48:07'),
(270, '::1', 'api/v1/alumnus/degrees', 1, '2026-05-01 08:48:07'),
(271, '::1', 'api/v1/alumnus/certifications', 2, '2026-05-01 08:48:07'),
(272, '::1', 'api/v1/alumnus/courses', 3, '2026-05-01 08:48:07'),
(273, '::1', 'api/v1/alumnus/employment', 1, '2026-05-01 08:48:07'),
(274, '::1', 'api/v1/alumnus/licences', 1, '2026-05-01 08:48:07'),
(275, '::1', 'api/v1/auth/role', 1, '2026-05-01 08:48:16'),
(276, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 08:48:16'),
(277, '::1', 'api/v1/analytics/alumni', 2, '2026-05-01 08:48:16'),
(278, '::1', 'api/v1/analytics/employment', 1, '2026-05-01 08:48:16'),
(279, '::1', 'api/v1/analytics/employers', 1, '2026-05-01 08:48:16'),
(280, '::1', 'api/v1/analytics/job-titles', 1, '2026-05-01 08:48:16'),
(281, '::1', 'api/v1/analytics/geographic', 1, '2026-05-01 08:48:16'),
(282, '::1', 'api/v1/analytics/certifications', 1, '2026-05-01 08:48:16'),
(283, '::1', 'api/v1/analytics/courses', 1, '2026-05-01 08:48:16'),
(284, '::1', 'api/v1/analytics/skills-gap', 1, '2026-05-01 08:48:16'),
(285, '::1', 'api/v1/analytics/trends', 1, '2026-05-01 08:48:16'),
(286, '::1', 'api/v1/auth/role', 2, '2026-05-01 16:02:02'),
(287, '::1', 'api/v1/analytics/filters', 1, '2026-05-01 16:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token_hash` varchar(64) NOT NULL,
  `type` enum('verify','reset') NOT NULL,
  `expires_at` datetime NOT NULL,
  `used_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `token_hash`, `type`, `expires_at`, `used_at`) VALUES
(1, 1, 'a602270754bd8f9bdfd859e30290786744eabe0c16f945ab20876ef0f0cb777f', 'verify', '2026-04-06 03:02:14', '2026-04-06 02:02:47'),
(2, 2, 'a389a0bc60fd174086292e453fbd23648c0ea9b90bc7081cdb53d8a4c66d763a', 'verify', '2026-04-06 03:16:42', '2026-04-06 02:17:01'),
(3, 3, 'e8b195cb6836b8c77e3118fb7f983cd45f9ded4d59dc1be3bcf1fa9708357503', 'verify', '2026-05-01 01:05:44', '2026-05-01 00:07:26'),
(4, 4, '7d78183d504795a9e74f427bf74f1d7bf6152f53692ecd03d78fbfeb43cc9ea2', 'verify', '2026-05-01 09:44:16', '2026-05-01 08:44:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `role` enum('alumnus','developer','staff') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `is_verified`, `role`, `created_at`) VALUES
(1, 'alumnus@gmail.com', '$2y$10$1YZOmS1h9s9k215PKvnvke6XFCu9kO8pJh/r7gFnHs1T744RqyZ0a', 1, 'alumnus', '2026-04-06 02:02:14'),
(2, 'developer@gmail.com', '$2y$10$RX02onAEYvV2oPeBvz1rzeOBLY6zqiCZojuvkVCOa3Shb9RGHsMqq', 1, 'developer', '2026-04-06 02:16:42'),
(3, 'staff@gmail.com', '$2y$10$v8A4K9sywEz8LGAXPHNSHO8jU3DmuIFDVllRMj8bB64yAqVFrIji.', 1, 'staff', '2026-05-01 00:05:44'),
(4, 'datasci@gmail.com', '$2y$10$xUV37kB3cArpnTXLU6HAJOTe7jQh8GxD4obj77kT52EFGUUof.g5e', 1, 'alumnus', '2026-05-01 08:44:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_hash` (`key_hash`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `api_key_logs`
--
ALTER TABLE `api_key_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `api_key_id` (`api_key_id`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `slot_date` (`slot_date`);

--
-- Indexes for table `bid_winners`
--
ALTER TABLE `bid_winners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slot_date` (`slot_date`),
  ADD KEY `bid_id` (`bid_id`);

--
-- Indexes for table `certifications`
--
ALTER TABLE `certifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `degrees`
--
ALTER TABLE `degrees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `employment`
--
ALTER TABLE `employment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `licences`
--
ALTER TABLE `licences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `rate_limits`
--
ALTER TABLE `rate_limits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_endpoint` (`ip_address`,`endpoint`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_hash` (`token_hash`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `api_key_logs`
--
ALTER TABLE `api_key_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bid_winners`
--
ALTER TABLE `bid_winners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certifications`
--
ALTER TABLE `certifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `degrees`
--
ALTER TABLE `degrees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employment`
--
ALTER TABLE `employment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `licences`
--
ALTER TABLE `licences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rate_limits`
--
ALTER TABLE `rate_limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD CONSTRAINT `api_keys_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `api_key_logs`
--
ALTER TABLE `api_key_logs`
  ADD CONSTRAINT `api_key_logs_key_fk` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bid_winners`
--
ALTER TABLE `bid_winners`
  ADD CONSTRAINT `bid_winners_bid_fk` FOREIGN KEY (`bid_id`) REFERENCES `bids` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certifications`
--
ALTER TABLE `certifications`
  ADD CONSTRAINT `certifications_profile_fk` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_profile_fk` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `degrees`
--
ALTER TABLE `degrees`
  ADD CONSTRAINT `degrees_profile_fk` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employment`
--
ALTER TABLE `employment`
  ADD CONSTRAINT `employment_profile_fk` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD CONSTRAINT `event_attendance_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `licences`
--
ALTER TABLE `licences`
  ADD CONSTRAINT `licences_profile_fk` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
