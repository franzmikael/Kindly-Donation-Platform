-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2021 at 08:11 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `donation`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(2, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(3, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(4, '2016_06_01_000004_create_oauth_clients_table', 1),
(5, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(6, '2020_03_26_041209_create_m_user', 1),
(7, '2020_05_26_092502_create_t_submissions', 1),
(8, '2020_05_26_092552_create_t_donations', 1),
(9, '2020_06_02_112405_create_t_withdraw', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE `m_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_is_admin` tinyint(1) NOT NULL,
  `user_is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`user_id`, `user_name`, `user_mail`, `user_phone`, `user_foto`, `user_password`, `user_is_admin`, `user_is_active`, `created_at`, `updated_at`) VALUES
(2, 'Marco Christopher', 'marco@gmail.com', '089123412341', 'default.png', '$2y$12$pM7vhGqTOysxcmzupS8HB.a6JsAeNMMgFC4X5vu8axJaSrsjzRIJO', 0, 1, '2020-06-09 15:54:26', '2020-06-09 15:54:26'),
(3, 'Admin Admin', 'admin@gmail.com', '089123412341', 'default.png', '$2y$12$pM7vhGqTOysxcmzupS8HB.a6JsAeNMMgFC4X5vu8axJaSrsjzRIJO', 1, 1, '2020-06-09 16:15:13', '2020-06-18 17:44:30'),
(4, 'John', 'john@gmail.com', '089123412341', 'default.png', '$2y$12$pM7vhGqTOysxcmzupS8HB.a6JsAeNMMgFC4X5vu8axJaSrsjzRIJO', 0, 1, '2020-06-12 12:06:50', '2020-06-12 12:06:50'),
(5, 'Devara Wijaya', 'terry@gmail.com', '089123412341', 'default.png', '$2y$12$pM7vhGqTOysxcmzupS8HB.a6JsAeNMMgFC4X5vu8axJaSrsjzRIJO', 0, 1, '2020-06-12 12:07:41', '2020-06-12 12:07:41'),
(6, 'Franz Mikael', 'franz@gmail.com', '089123412341', '1592502270.jpeg', '$2y$12$pM7vhGqTOysxcmzupS8HB.a6JsAeNMMgFC4X5vu8axJaSrsjzRIJO', 0, 1, '2020-06-12 12:48:27', '2020-06-18 17:51:10'),
(7, 'Jun Tanaka', 'jun@gmail.com', '089123412341', 'default.png', '$2y$12$pM7vhGqTOysxcmzupS8HB.a6JsAeNMMgFC4X5vu8axJaSrsjzRIJO', 0, 1, '2020-06-12 12:56:41', '2020-06-12 12:56:41'),
(8, 'Monesy Asd', 'monesy@gmail.com', '089123412341', '1592502270.jpeg', '$2y$10$GKSy5cnBx3OZB4fVbUj2n.ugw9ShulJL4YMVVsnSIQvGrNVM3uCyW', 0, 1, '2020-06-18 17:53:27', '2020-06-18 17:53:27');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0048d2265f9108b706c3cfbc58eb73ff7c427e33d493fc5cc8c6da41c7fe1e182f546574e59857f5', 3, 3, 'authToken', '[]', 0, '2020-06-12 13:03:57', '2020-06-12 13:03:57', '2021-06-12 20:03:57'),
('06b864368868ae4d394dfe540a56cae6ce3de1587c3c9731e269db014ce2916f3e57490230936f98', 3, 3, 'authToken', '[]', 0, '2020-06-12 12:19:35', '2020-06-12 12:19:35', '2021-06-12 19:19:35'),
('0ecd1f45e2bf2bab95c6c8a4df7f86f0f0771b635f95f9f5de682dc080fd7885f0ad894a43be3f97', 3, 5, 'authToken', '[]', 0, '2020-06-18 17:33:07', '2020-06-18 17:33:07', '2021-06-19 00:33:07'),
('105f25b579b01b1d369caeb994b81abcc4cc18bd4931fac003e8f114cd03f85c9038ca3c5854800f', 6, 9, 'authToken', '[]', 0, '2021-04-07 05:43:58', '2021-04-07 05:43:58', '2022-04-07 12:43:58'),
('1c45937f40f9b2d880e35f9aa271252869eb88f85d4bc040ac8aa46021336549cf9653887f29af82', 2, 5, 'authToken', '[]', 0, '2020-06-15 10:03:40', '2020-06-15 10:03:40', '2021-06-15 17:03:40'),
('2bfe530ff2827f05c599081b9990034b0611549f5030734752e242bb38e67854fcfc092eb1b589d4', 2, 3, 'authToken', '[]', 0, '2020-06-12 11:32:52', '2020-06-12 11:32:52', '2021-06-12 18:32:52'),
('3acb5242760a8db9e60526dd86d91a1da38388e55e8a8b3ac0565397e5dd0fb05127b2ec257b4032', 2, 3, 'authToken', '[]', 0, '2020-06-12 12:25:08', '2020-06-12 12:25:08', '2021-06-12 19:25:08'),
('3d0e7d46fd6694b541b50c88dd9697fe997bd04a16e4a2565deb0b37de2b6a456d2f467ca9926665', 6, 11, 'authToken', '[]', 0, '2021-04-07 06:05:33', '2021-04-07 06:05:33', '2022-04-07 13:05:33'),
('3f30e00e6ecd36670fbf54c5c137b3d2812e2fd91c767a3717616389e318d7831f8c30f617cfebfc', 3, 5, 'authToken', '[]', 0, '2020-06-15 09:58:43', '2020-06-15 09:58:43', '2021-06-15 16:58:43'),
('42ce33e25a5290375efddfed8e82f14aaa3afa717f45a543bb7e4737faeb8e25bb84496a1d2ee52b', 7, 3, 'authToken', '[]', 0, '2020-06-12 12:56:59', '2020-06-12 12:56:59', '2021-06-12 19:56:59'),
('4f8c42d348ca0095a42eb34f6999f3b9c5bc6807af56fbc6ffb73f00f1a1c26726640068cba073e0', 3, 5, 'authToken', '[]', 0, '2020-06-18 17:52:39', '2020-06-18 17:52:39', '2021-06-19 00:52:39'),
('545b4e784268a26aa618436541b156f10d0841ef050b2c11a072c70d3ecca90714c15d184057c84f', 2, 3, 'authToken', '[]', 0, '2020-06-12 11:32:53', '2020-06-12 11:32:53', '2021-06-12 18:32:53'),
('5715e6377b3e76950f20da78462d5c75d33681c58ccd8a351b9462df84726ad4d3fb2a95af380b87', 6, 11, 'authToken', '[]', 0, '2021-04-07 06:02:36', '2021-04-07 06:02:36', '2022-04-07 13:02:36'),
('57e47c1b5e74d7b869b2fe139959b7ad8efa6d6c41ab8d9c7a682375980758a56662e6f0e52c23eb', 6, 11, 'authToken', '[]', 0, '2021-04-07 06:02:35', '2021-04-07 06:02:35', '2022-04-07 13:02:35'),
('59f91756b6cd8bdf0814875932613a22ebae5e827000c40bfd13306245c2ebb30e496bb75a1e1942', 3, 3, 'authToken', '[]', 0, '2020-06-12 12:10:56', '2020-06-12 12:10:56', '2021-06-12 19:10:56'),
('5c21d3d8fc25542506e770be553b917625bbeb9b66cc97e7b4d3a699baf00d03ed8f781dea227a14', 2, 3, 'authToken', '[]', 0, '2020-06-12 11:32:54', '2020-06-12 11:32:54', '2021-06-12 18:32:54'),
('620882166952afe3f424657fe8ec36392a9ba177e13c2884d44badcb2a4dfabcb65eab455516f40b', 2, 3, 'authToken', '[]', 0, '2020-06-12 03:49:42', '2020-06-12 03:49:42', '2021-06-12 10:49:42'),
('68a94a293657004b8c0974311038452796b704b43e19879b5ab1e9a057457d0d10e240017b277529', 2, 3, 'authToken', '[]', 0, '2020-06-12 11:32:50', '2020-06-12 11:32:50', '2021-06-12 18:32:50'),
('6e7e028a24812e630858076faf1461a104a7bb57a671dd6b733b1ab391442f601a26fea93bec5e7a', 2, 3, 'authToken', '[]', 0, '2020-06-12 12:17:44', '2020-06-12 12:17:44', '2021-06-12 19:17:44'),
('718a5c17ad6f0349c7681ad95d4f6d443c34dc1ad8bc7b6616ea6f81aeddce9558edc948d169999c', 2, 3, 'authToken', '[]', 0, '2020-06-12 12:12:35', '2020-06-12 12:12:35', '2021-06-12 19:12:35'),
('7296ef34b187101be6b4039759ad728f28342a83d73714f592c2235e90f14d5778e522ff840bdea4', 2, 3, 'authToken', '[]', 0, '2020-06-12 03:49:42', '2020-06-12 03:49:42', '2021-06-12 10:49:42'),
('7a92afc80eaae753ceb915e4da725036eacb9244c629d37cc330e8a2e12a77636213307acebc606f', 2, 3, 'authToken', '[]', 0, '2020-06-09 15:56:16', '2020-06-09 15:56:16', '2021-06-09 22:56:16'),
('8b890595f3343aa11c5ae0fe1cc7792f861689652a811281b9e838a3d4c83c54244b9aaef89a01b1', 6, 5, 'authToken', '[]', 0, '2020-06-18 17:47:46', '2020-06-18 17:47:46', '2021-06-19 00:47:46'),
('926d52f47d1e16efb457a5efbb0a90419c897ef59c535a25ad1223a476d04db78989f0808c1cd43c', 2, 3, 'authToken', '[]', 0, '2020-06-12 03:49:43', '2020-06-12 03:49:43', '2021-06-12 10:49:43'),
('a491f95d241ce537361003248694eb596023733cb676332bb5662696fd98e34cb67e8d2b2e907c2c', 6, 3, 'authToken', '[]', 0, '2020-06-12 12:48:42', '2020-06-12 12:48:42', '2021-06-12 19:48:42'),
('a63cf57e29861bb430e4c6f3bdd609f8638eda77dcd96d479be7fcbacd2d14d8bba7e354e20cf822', 5, 3, 'authToken', '[]', 0, '2020-06-12 12:14:26', '2020-06-12 12:14:26', '2021-06-12 19:14:26'),
('b96a695001d1de5fc1b23a26fb00bd2ce482fa6f59b8e1d3f13eb3849efbe26872c1af9d73bab996', 3, 3, 'authToken', '[]', 0, '2020-06-12 03:50:00', '2020-06-12 03:50:00', '2021-06-12 10:50:00'),
('bd75cb11bca8f91c4336b4e434b53ddfdf806a294ab96df41f9c60df65ab2419a030bdf00438fa7d', 3, 3, 'authToken', '[]', 0, '2020-06-09 16:15:47', '2020-06-09 16:15:47', '2021-06-09 23:15:47'),
('cc34fb5d204a70189a0b590f0877f250c877f84dc576eda2f24c22c6cc2c07317c637c4e9e7a2c3f', 2, 3, 'authToken', '[]', 0, '2020-06-12 11:33:22', '2020-06-12 11:33:22', '2021-06-12 18:33:22'),
('dfe488c2de396cc40d6869a7bdf8346014794760bfa60cc53861157c30ab506a392475f5b392acef', 4, 3, 'authToken', '[]', 0, '2020-06-12 12:09:17', '2020-06-12 12:09:17', '2021-06-12 19:09:17'),
('e07cf3f4d91baad0f277ca34aa69bf2cf8b30347d75138e80734ed43e603f071b831fc6111f7a57b', 5, 3, 'authToken', '[]', 0, '2020-06-12 12:10:16', '2020-06-12 12:10:16', '2021-06-12 19:10:16'),
('e86e75bd1bd60705891419e6a3eb63d60f315ad3bc256153bf2e6c104b8714ba7411868fbe9e76d2', 2, 3, 'authToken', '[]', 0, '2020-06-09 16:34:53', '2020-06-09 16:34:53', '2021-06-09 23:34:53'),
('fcf637468e9d59cdb6637b6ce77261b8734b36539ade37035d499e81135ecc0b6f6ef1c2b31c1cb7', 2, 3, 'authToken', '[]', 0, '2020-06-12 11:32:54', '2020-06-12 11:32:54', '2021-06-12 18:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'BZYY73HqwVFe9p916KgP80C7qZxlZR0wKgmWV8is', NULL, 'http://localhost', 1, 0, 0, '2020-06-09 15:55:40', '2020-06-09 15:55:40'),
(2, NULL, 'Laravel Password Grant Client', 'aG12brsIhYbdaLyRk8rTFB5LE7WvUxk62XuKgnUl', 'users', 'http://localhost', 0, 1, 0, '2020-06-09 15:55:40', '2020-06-09 15:55:40'),
(3, NULL, 'Laravel Personal Access Client', 'UsbeBp8TyE2bOzMWfeFrllpfh41RF0FoyqqQjrx9', NULL, 'http://localhost', 1, 0, 0, '2020-06-09 15:55:50', '2020-06-09 15:55:50'),
(4, NULL, 'Laravel Password Grant Client', 'GrM2Q9bafIjn0IM9C0oXgmLuvkHJqo3TMk4OVoTD', 'users', 'http://localhost', 0, 1, 0, '2020-06-09 15:55:50', '2020-06-09 15:55:50'),
(5, NULL, 'Laravel Personal Access Client', 'CkNZlU9UN9dJKCL66funxdxVfIvzUv8eEscM1rNq', NULL, 'http://localhost', 1, 0, 0, '2020-06-15 09:57:29', '2020-06-15 09:57:29'),
(6, NULL, 'Laravel Password Grant Client', '0WHt5nzVnPS3ncP1G9sa5ygxTRZzZKfW0QOlfd6y', 'users', 'http://localhost', 0, 1, 0, '2020-06-15 09:57:29', '2020-06-15 09:57:29'),
(7, NULL, 'Laravel Personal Access Client', 'y3CMjHTytbMx0C9GgQPoXlOEO1x9Rtyy9iCwkRvb', NULL, 'http://localhost', 1, 0, 0, '2021-04-07 04:53:25', '2021-04-07 04:53:25'),
(8, NULL, 'Laravel Password Grant Client', 'f0TsDXpEq4Kn5ukVBgRlkuDUO3pMQH952bbir0uk', 'users', 'http://localhost', 0, 1, 0, '2021-04-07 04:53:26', '2021-04-07 04:53:26'),
(9, NULL, 'Laravel Personal Access Client', 'bC5k4kIDFYcrf6WlebABO2jzNIy7cM239jDVflTJ', NULL, 'http://localhost', 1, 0, 0, '2021-04-07 05:22:28', '2021-04-07 05:22:28'),
(10, NULL, 'Laravel Password Grant Client', 'JoUbNIa0oBfTSfcdY3kYdw0B5dZBfd5gF9O4yHRt', 'users', 'http://localhost', 0, 1, 0, '2021-04-07 05:22:28', '2021-04-07 05:22:28'),
(11, NULL, 'Laravel Personal Access Client', 'wdxC5xs1c2nWSTO3GAqRhqYpwk4iH8TOZng98wfD', NULL, 'http://localhost', 1, 0, 0, '2021-04-07 05:57:22', '2021-04-07 05:57:22'),
(12, NULL, 'Laravel Password Grant Client', 'hRaOIPrIao8ujP5rfU0VVee5ELYLOcWgSi5ygMjq', 'users', 'http://localhost', 0, 1, 0, '2021-04-07 05:57:22', '2021-04-07 05:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-06-09 15:55:40', '2020-06-09 15:55:40'),
(2, 3, '2020-06-09 15:55:50', '2020-06-09 15:55:50'),
(3, 5, '2020-06-15 09:57:29', '2020-06-15 09:57:29'),
(4, 7, '2021-04-07 04:53:26', '2021-04-07 04:53:26'),
(5, 9, '2021-04-07 05:22:28', '2021-04-07 05:22:28'),
(6, 11, '2021-04-07 05:57:22', '2021-04-07 05:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_donations`
--

CREATE TABLE `t_donations` (
  `donation_id` int(10) UNSIGNED NOT NULL,
  `submisi_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `donation_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `donation_mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `donation_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `donation_nominal` int(11) NOT NULL,
  `donation_is_anonymous` tinyint(1) NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_donations`
--

INSERT INTO `t_donations` (`donation_id`, `submisi_id`, `user_id`, `donation_name`, `donation_mail`, `donation_phone`, `donation_nominal`, `donation_is_anonymous`, `payment_type`, `created_at`, `updated_at`) VALUES
(4, 1, 4, 'Dewa Sukietra', 'dewa@gmail.com', '08786543211', 500000, 0, 'BCA', '2020-06-12 12:09:31', '2020-06-12 12:09:31'),
(5, 3, 4, 'Dewa Sukietra', 'dewa@gmail.com', '08786543211', 100000, 1, 'BCA', '2020-06-12 12:09:50', '2020-06-12 12:09:50'),
(6, 2, 5, 'Reiner Terry', 'terry@gmail.com', '085289582467', 800000, 0, 'BCA', '2020-06-12 12:10:30', '2020-06-12 12:10:30'),
(7, 3, 7, 'Jun Jun', 'jun@gmail.com', '087810928762', 40000, 1, 'BCA', '2020-06-12 13:01:05', '2020-06-12 13:01:05'),
(8, 1, 0, 'wati', 'wati@gmail.com', '081111231231', 200000, 1, 'BCA', '2020-06-15 09:51:10', '2020-06-15 09:51:10'),
(9, 2, 0, 'samuel', 'samuel@gmail.com', '089123443211', 500000, 0, 'BCA', '2020-06-15 09:52:04', '2020-06-15 09:52:04'),
(10, 3, 0, 'frans', 'frans@gmail.com', '078912341234', 300000, 0, 'BCA', '2020-06-15 09:52:44', '2020-06-15 09:52:44'),
(11, 2, 0, 'adri', 'adrian123@gmail.com', '067123456789', 1000000, 0, 'BCA', '2020-06-15 09:54:45', '2020-06-15 09:54:45');

-- --------------------------------------------------------

--
-- Table structure for table `t_submissions`
--

CREATE TABLE `t_submissions` (
  `submisi_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `submisi_judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submisi_penerima` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `submisi_cerita` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `submisi_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submisi_tipe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submisi_target` int(11) NOT NULL,
  `submisi_terkumpul` int(11) NOT NULL,
  `submisi_foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submisi_is_active` tinyint(1) NOT NULL,
  `submisi_expired_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_submissions`
--

INSERT INTO `t_submissions` (`submisi_id`, `user_id`, `submisi_judul`, `submisi_penerima`, `submisi_cerita`, `submisi_phone`, `submisi_tipe`, `submisi_target`, `submisi_terkumpul`, `submisi_foto`, `submisi_is_active`, `submisi_expired_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Tolong Anak Ini agar bisa bersekolah kembali', 'Andi', 'Tolong bantu dia agar sekolah lagi, Andi', '085289582467', 'Kemanusiaan', 25000000, 700000, '1591718363.jpg', 1, '2022-08-30', '2020-06-09 15:59:23', '2020-06-09 15:59:23'),
(2, 2, 'Tolong Bantu Ibu ini membangun rumah nya kembali', 'Ibu Marsinah', 'Tolong Bantu Ibu Marsinah membangun rumah yang telah hancur karena tsunami', '085289582467', 'Kemanusiaan', 100000000, 2300000, '1591718488.jpg', 1, '2022-09-24', '2020-06-09 16:01:28', '2020-06-09 16:01:28'),
(3, 2, 'Bantu Ibu ini agar tidak mengemis belaskasihan', 'Ibu Melyi', 'Kasihan Ibu ini karena tidak punya penghasilan iya terpaksa  mengemis belas kasihan di jalan', '085289582467', 'Kemanusiaan', 10000000, 440000, '1591718645.jpg', 1, '2022-07-30', '2020-06-09 16:04:05', '2020-06-09 16:04:05'),
(4, 5, 'Tolong agar tidak terjadi pengudulan hutan', 'Masyarakat Wirogomo', 'Sedih sekali warga disini', '085289582467', 'Bencana Alam', 100000000, 0, '1591964219.jpg', 1, '2022-07-27', '2020-06-12 12:16:59', '2020-06-12 12:16:59'),
(5, 6, 'Kasihan sekali Ibu ini Tolong dibantu agar cepat sembuh', 'Ibu Yanti', 'Kasihan sekali Ibu ini', '08657891234', 'Kemanusiaan', 100000000, 0, '1591966294.jpg', 1, '2022-08-07', '2020-06-12 12:51:34', '2020-06-12 12:51:34'),
(6, 7, 'Bantu Ibu ini yang berada di pinggir jalan', 'Ibu Yanti', 'Tolong bantu ibu ini . Terima Kasih', '087810928762', 'Kemanusiaan', 10000000, 0, '1591966766.jpg', 1, '2022-09-15', '2020-06-12 12:59:26', '2020-06-12 12:59:26'),
(7, 6, 'Asd', 'Asdads', 'Aasfasdfasdfsadfasdfsa  sdf asdf asdf asdf', '089123412341', 'Pendidikan', 12000000, 0, '1592502711.png', 1, '2022-06-27', '2020-06-18 17:51:51', '2020-06-18 17:51:51');

-- --------------------------------------------------------

--
-- Table structure for table `t_withdraw`
--

CREATE TABLE `t_withdraw` (
  `withdraw_id` int(10) UNSIGNED NOT NULL,
  `submisi_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `withdraw_nominal` int(11) NOT NULL,
  `withdraw_bank_number` int(11) NOT NULL,
  `withdraw_is_approved` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_withdraw`
--

INSERT INTO `t_withdraw` (`withdraw_id`, `submisi_id`, `user_id`, `withdraw_nominal`, `withdraw_bank_number`, `withdraw_is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 300000, 345678659, 1, '2020-06-12 12:19:07', '2020-06-12 13:06:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_donations`
--
ALTER TABLE `t_donations`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `t_donations_submisi_id_foreign` (`submisi_id`);

--
-- Indexes for table `t_submissions`
--
ALTER TABLE `t_submissions`
  ADD PRIMARY KEY (`submisi_id`),
  ADD KEY `t_submissions_user_id_foreign` (`user_id`);

--
-- Indexes for table `t_withdraw`
--
ALTER TABLE `t_withdraw`
  ADD PRIMARY KEY (`withdraw_id`),
  ADD KEY `t_withdraw_submisi_id_foreign` (`submisi_id`),
  ADD KEY `t_withdraw_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `m_user`
--
ALTER TABLE `m_user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_donations`
--
ALTER TABLE `t_donations`
  MODIFY `donation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `t_submissions`
--
ALTER TABLE `t_submissions`
  MODIFY `submisi_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t_withdraw`
--
ALTER TABLE `t_withdraw`
  MODIFY `withdraw_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_donations`
--
ALTER TABLE `t_donations`
  ADD CONSTRAINT `t_donations_submisi_id_foreign` FOREIGN KEY (`submisi_id`) REFERENCES `t_submissions` (`submisi_id`) ON DELETE CASCADE;

--
-- Constraints for table `t_submissions`
--
ALTER TABLE `t_submissions`
  ADD CONSTRAINT `t_submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `t_withdraw`
--
ALTER TABLE `t_withdraw`
  ADD CONSTRAINT `t_withdraw_submisi_id_foreign` FOREIGN KEY (`submisi_id`) REFERENCES `t_submissions` (`submisi_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_withdraw_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
