-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2021 at 01:24 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cradadmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `aqar_category`
--

CREATE TABLE `aqar_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aqar_category`
--

INSERT INTO `aqar_category` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(2, 'سكني', '2021-07-04 09:31:22', '2021-07-04 09:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `canonical` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_img_alt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `single_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_num` int(11) NOT NULL,
  `number_of_visits` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `seo_title`, `description`, `canonical`, `main_img_alt`, `single_photo`, `slug`, `meta_description`, `sort_num`, `number_of_visits`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Aut et ut voluptatem', 'Ut laboris accusanti', 'Mollitia molestiae t', 'Esse et accusantium', 'uploads/blog/-513-.download (1).png', 'uploads/blog/-436-.download (1).png', 'Fugiat recusandae Q', 'Voluptatibus expedit', 14, 528, 0, '2021-07-01 13:42:54', '2021-07-04 07:43:08');

-- --------------------------------------------------------

--
-- Table structure for table `call_time`
--

CREATE TABLE `call_time` (
  `id` int(10) UNSIGNED NOT NULL,
  `call_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `call_time`
--

INSERT INTO `call_time` (`id`, `call_time`, `created_at`, `updated_at`) VALUES
(1, 'من 9 صباحا الى 5 مساء', '2021-07-04 09:44:20', '2021-07-04 09:44:20'),
(2, 'من 5 مساء الى 12 صباحا', '2021-07-04 09:44:54', '2021-07-04 09:44:54');

-- --------------------------------------------------------

--
-- Table structure for table `compound`
--

CREATE TABLE `compound` (
  `id` int(10) UNSIGNED NOT NULL,
  `compound` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `compound`
--

INSERT INTO `compound` (`id`, `compound`, `created_at`, `updated_at`) VALUES
(1, 'Golden City', '2021-07-04 09:56:35', '2021-07-04 09:56:35'),
(2, 'Grand City Al Morshedy', '2021-07-04 09:57:17', '2021-07-04 09:57:17');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `id` int(10) UNSIGNED NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `govern_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `district`, `govern_id`, `created_at`, `updated_at`) VALUES
(1, 'المعادي', 1, '2021-07-04 11:03:56', '2021-07-04 11:03:56'),
(2, 'الأميرية', 1, '2021-07-04 11:04:16', '2021-07-04 11:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finish_type`
--

CREATE TABLE `finish_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `finish_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finish_type`
--

INSERT INTO `finish_type` (`id`, `finish_type`, `created_at`, `updated_at`) VALUES
(1, 'اكسترا سوبرلوكس', '2021-07-04 11:48:33', '2021-07-04 11:48:33'),
(2, 'سوبرلوكس', '2021-07-04 11:48:46', '2021-07-04 11:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `floor`
--

CREATE TABLE `floor` (
  `id` int(10) UNSIGNED NOT NULL,
  `floor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `floor`
--

INSERT INTO `floor` (`id`, `floor`, `created_at`, `updated_at`) VALUES
(1, 'البيزمنت', '2021-07-04 11:59:14', '2021-07-04 11:59:14'),
(2, 'الارضي', '2021-07-04 11:59:39', '2021-07-04 11:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `governrate`
--

CREATE TABLE `governrate` (
  `id` int(10) UNSIGNED NOT NULL,
  `governrate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `governrate`
--

INSERT INTO `governrate` (`id`, `governrate`, `created_at`, `updated_at`) VALUES
(1, 'القاهره', '2021-07-04 10:19:33', '2021-07-04 10:19:33'),
(2, 'الإسكندرية', '2021-07-04 10:19:48', '2021-07-04 10:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `license_type`
--

CREATE TABLE `license_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `license_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `license_type`
--

INSERT INTO `license_type` (`id`, `license_type`, `created_at`, `updated_at`) VALUES
(1, 'سكني', '2021-07-04 12:16:31', '2021-07-04 12:16:31'),
(2, 'سكني و اداري', '2021-07-04 12:17:33', '2021-07-04 12:17:33');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_07_01_131151_create_blogs_table', 2),
(5, '2021_07_04_102357_create_offer_type_table', 3),
(7, '2021_07_04_110935_create_property_type_table', 4),
(8, '2021_07_04_112454_create_aqar_category_table', 5),
(9, '2021_07_04_113832_create_call_time_table', 6),
(10, '2021_07_04_114548_create_compound_table', 7),
(11, '2021_07_04_120523_create_governrate_table', 8),
(12, '2021_07_04_123357_create_district_table', 9),
(13, '2021_07_04_133118_create_finish_type_table', 10),
(15, '2021_07_04_135112_create_floor_table', 11),
(16, '2021_07_04_141057_create_license_type_table', 12),
(17, '2021_07_05_084426_create_subarea_table', 13),
(18, '2021_07_05_085314_create_services_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `offer_type`
--

CREATE TABLE `offer_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_offer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offer_type`
--

INSERT INTO `offer_type` (`id`, `type_offer`, `created_at`, `updated_at`) VALUES
(1, 'كاش', '2021-07-04 08:34:49', '2021-07-04 08:55:26');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE `property_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`id`, `property_type`, `created_at`, `updated_at`) VALUES
(1, 'شقة', '2021-07-04 09:21:51', '2021-07-04 09:21:51'),
(2, 'فلل خاصه', '2021-07-04 09:23:24', '2021-07-04 09:23:24');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `Service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `Service`, `created_at`, `updated_at`) VALUES
(1, 'شركات نقل الاثاث', '2021-07-05 07:03:18', '2021-07-05 07:03:18'),
(2, 'شركات تشطيب و اعمال الديكور', '2021-07-05 07:03:31', '2021-07-05 07:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `subarea`
--

CREATE TABLE `subarea` (
  `id` int(10) UNSIGNED NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subarea`
--

INSERT INTO `subarea` (`id`, `area`, `created_at`, `updated_at`) VALUES
(1, 'زهراء المعادي', '2021-07-05 06:50:50', '2021-07-05 06:50:50'),
(2, 'سرايات المعادي', '2021-07-05 06:51:08', '2021-07-05 06:51:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'eslam', 'admin@admin.com', NULL, '$2y$10$4ZXBoJjgUE7chx1GCrZNhu0rP0O5ER2T0k6RpyV3iPtYYpFn34RjS', NULL, '2021-07-01 09:54:04', '2021-07-01 09:54:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aqar_category`
--
ALTER TABLE `aqar_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `call_time`
--
ALTER TABLE `call_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compound`
--
ALTER TABLE `compound`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district_govern_id_foreign` (`govern_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `finish_type`
--
ALTER TABLE `finish_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `floor`
--
ALTER TABLE `floor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `governrate`
--
ALTER TABLE `governrate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `license_type`
--
ALTER TABLE `license_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_type`
--
ALTER TABLE `offer_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subarea`
--
ALTER TABLE `subarea`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aqar_category`
--
ALTER TABLE `aqar_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `call_time`
--
ALTER TABLE `call_time`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `compound`
--
ALTER TABLE `compound`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finish_type`
--
ALTER TABLE `finish_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `governrate`
--
ALTER TABLE `governrate`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `license_type`
--
ALTER TABLE `license_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `offer_type`
--
ALTER TABLE `offer_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subarea`
--
ALTER TABLE `subarea`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `district_govern_id_foreign` FOREIGN KEY (`govern_id`) REFERENCES `governrate` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
