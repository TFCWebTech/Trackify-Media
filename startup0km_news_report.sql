-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 22, 2025 at 02:30 PM
-- Server version: 10.3.39-MariaDB
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `startup0km_news_report`
--

-- --------------------------------------------------------

--
-- Table structure for table `addrate`
--

CREATE TABLE `addrate` (
  `gidAddRate_id` bigint(20) UNSIGNED NOT NULL,
  `gidAddRate` varchar(45) DEFAULT NULL,
  `Rate` double NOT NULL DEFAULT 0,
  `Circulation_Fig` bigint(20) NOT NULL DEFAULT 0,
  `gidMediaType` varchar(50) NOT NULL,
  `gidMediaOutlet` varchar(50) NOT NULL,
  `gidEdition` varchar(50) NOT NULL,
  `gidSupplement` varchar(50) NOT NULL DEFAULT '1',
  `Status` int(11) NOT NULL DEFAULT 0,
  `CreatedOn` datetime NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `NewRate` double NOT NULL DEFAULT 0,
  `UpdatedOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--

CREATE TABLE `agency` (
  `gidAgency_id` bigint(20) UNSIGNED NOT NULL,
  `gidAgency` varchar(45) DEFAULT NULL,
  `Agency` varchar(45) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `CreatedOn` varchar(45) DEFAULT NULL,
  `CreatedBy` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artical_images`
--

CREATE TABLE `artical_images` (
  `artical_images_id` int(11) NOT NULL,
  `artical_images_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city_table`
--

CREATE TABLE `city_table` (
  `city_id` varchar(250) NOT NULL,
  `city_name` varchar(250) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='city''s that fall in zone';

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `client_keywords` varchar(255) DEFAULT NULL,
  `cilent_status` tinyint(4) NOT NULL DEFAULT 1,
  `create_at` datetime DEFAULT NULL,
  `sector_id` varchar(255) DEFAULT NULL,
  `client_type` varchar(255) DEFAULT NULL,
  `clients` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `blank_mail` varchar(255) DEFAULT NULL,
  `report_service` tinyint(4) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_competetor_industry`
--

CREATE TABLE `client_competetor_industry` (
  `client_competetor_industry_id` int(11) NOT NULL,
  `news_details_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `competitor_id` int(11) DEFAULT NULL,
  `Industry_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `competitor`
--

CREATE TABLE `competitor` (
  `competitor_id` int(11) NOT NULL,
  `Competitor_name` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `Keywords` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delete_news`
--

CREATE TABLE `delete_news` (
  `delete_news_id` int(11) NOT NULL,
  `news_details_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `is_delete` int(11) DEFAULT NULL,
  `is_hide` int(11) DEFAULT NULL,
  `headline` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `is_update` int(11) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `edition`
--

CREATE TABLE `edition` (
  `gidEdition_id` bigint(20) UNSIGNED NOT NULL,
  `gidEdition` varchar(45) DEFAULT NULL,
  `Edition` varchar(45) DEFAULT NULL,
  `EditionOrder` varchar(45) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `CreatedOn` datetime DEFAULT NULL,
  `CreatedBy` varchar(45) DEFAULT NULL,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` varchar(45) DEFAULT NULL,
  `MediaOutletId` varchar(45) NOT NULL,
  `ShortName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `industry`
--

CREATE TABLE `industry` (
  `Industry_id` int(11) NOT NULL,
  `Industry_name` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `competitor_id` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  `Keywords` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journalist`
--

CREATE TABLE `journalist` (
  `journalist_id` int(11) NOT NULL,
  `gidJournalist` varchar(45) DEFAULT NULL,
  `Journalist` varchar(500) DEFAULT NULL,
  `JEmailId` varchar(45) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `CreatedOn` varchar(45) DEFAULT NULL,
  `CreatedBy` varchar(45) DEFAULT NULL,
  `gigMediaOutlet` varchar(45) DEFAULT NULL,
  `phoneNo1` bigint(20) DEFAULT NULL,
  `phoneNo2` bigint(20) DEFAULT NULL,
  `mobNo1` bigint(20) DEFAULT NULL,
  `mobNo2` bigint(20) DEFAULT NULL,
  `LastMediaOutlets` varchar(300) DEFAULT NULL,
  `designation` varchar(300) DEFAULT NULL,
  `beats` text DEFAULT NULL,
  `twitter` text DEFAULT NULL,
  `facebook` text DEFAULT NULL,
  `quora` text DEFAULT NULL,
  `website` text DEFAULT NULL,
  `blog` text DEFAULT NULL,
  `linkedin` text DEFAULT NULL,
  `otherDetails` text DEFAULT NULL,
  `showOnNewJourno` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mail_template`
--

CREATE TABLE `mail_template` (
  `mail_template_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `trackify_link` varchar(255) DEFAULT NULL,
  `trackify_link_status` tinyint(4) NOT NULL DEFAULT 0,
  `menu_background_color` varchar(255) DEFAULT NULL,
  `menu_font_color` varchar(255) DEFAULT NULL,
  `menu_font` varchar(255) DEFAULT NULL,
  `menu_font_size` varchar(255) DEFAULT NULL,
  `menu_row_background` varchar(255) DEFAULT NULL,
  `menu_row_font_color` varchar(255) DEFAULT NULL,
  `menu_row_font` varchar(255) DEFAULT NULL,
  `menu_row_font_Size` varchar(255) DEFAULT NULL,
  `menu_no_news_text` varchar(255) DEFAULT NULL,
  `quick_links` varchar(255) DEFAULT NULL,
  `quick_links_url` varchar(255) DEFAULT NULL,
  `quick_links_position` varchar(255) DEFAULT NULL,
  `header_background_color` varchar(255) DEFAULT NULL,
  `header_logo_url` varchar(255) DEFAULT NULL,
  `logo_position` varchar(255) DEFAULT NULL,
  `header_title_name` varchar(255) DEFAULT NULL,
  `header_title_font_color` varchar(255) DEFAULT NULL,
  `header_title_font_size` varchar(255) DEFAULT NULL,
  `content_category` varchar(255) DEFAULT NULL,
  `content_publication` text DEFAULT NULL,
  `content_edition` text DEFAULT NULL,
  `content_news_summary_color` varchar(255) DEFAULT NULL,
  `content_news_summary_font_size` varchar(255) DEFAULT NULL,
  `content_headline_color` varchar(255) DEFAULT NULL,
  `content_headline_font` varchar(255) DEFAULT NULL,
  `content_headline_font_size` varchar(255) DEFAULT NULL,
  `content_media_details` varchar(255) DEFAULT NULL,
  `content_media_color` varchar(255) DEFAULT NULL,
  `content_media_font` varchar(255) DEFAULT NULL,
  `content_media_font_size` varchar(255) DEFAULT NULL,
  `content_context` varchar(255) DEFAULT NULL,
  `content_context_font` varchar(255) DEFAULT NULL,
  `content_context_font_size` varchar(255) DEFAULT NULL,
  `footer_background_color` varchar(255) DEFAULT NULL,
  `footer_logo_url` varchar(255) DEFAULT NULL,
  `footer_logo_position` varchar(255) DEFAULT NULL,
  `footer_title_name` varchar(255) DEFAULT NULL,
  `footer_title_font_color` varchar(255) DEFAULT NULL,
  `footer_title_font_size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mediaoutlet`
--

CREATE TABLE `mediaoutlet` (
  `gidMediaOutlet_id` int(11) NOT NULL,
  `gidMediaOutlet` varchar(45) DEFAULT NULL,
  `MediaOutlet` varchar(45) DEFAULT NULL,
  `ShortName` varchar(45) NOT NULL,
  `gidMediaType` varchar(45) DEFAULT NULL,
  `gidPublicationType` varchar(45) DEFAULT NULL,
  `gidTier` varchar(45) DEFAULT NULL,
  `Masthead` varchar(500) DEFAULT NULL,
  `Language` varchar(45) DEFAULT NULL,
  `CreatedOn` datetime DEFAULT NULL,
  `CreatedBy` varchar(45) DEFAULT NULL,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` varchar(45) DEFAULT NULL,
  `Status` int(11) NOT NULL,
  `Priority` decimal(10,3) NOT NULL DEFAULT 0.000,
  `IsCorrected` int(11) DEFAULT 0 COMMENT 'This field is introduced so as to identify which all mediaoutlets along with their details has been corrected.0 means not corrected 1 means corrected',
  `MediaOutletCorrections` int(11) NOT NULL,
  `ImpMediaOutlet` int(11) NOT NULL DEFAULT 0,
  `Country` int(11) DEFAULT 77
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mediatype`
--

CREATE TABLE `mediatype` (
  `gidMediaType_id` bigint(20) UNSIGNED NOT NULL,
  `gidMediaType` varchar(45) DEFAULT NULL,
  `MediaType` varchar(45) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `CreatedOn` datetime DEFAULT NULL,
  `CreatedBy` varchar(45) DEFAULT NULL,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` varchar(45) DEFAULT NULL,
  `LevelOrder` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newscity`
--

CREATE TABLE `newscity` (
  `gidNewscity_id` bigint(20) UNSIGNED NOT NULL,
  `gidNewscity` varchar(50) NOT NULL,
  `CityName` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `CreatedOn` datetime NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `CityOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_artical`
--

CREATE TABLE `news_artical` (
  `news_artical_id` int(11) NOT NULL,
  `news_details_id` int(11) NOT NULL,
  `artical_images_id` int(11) DEFAULT NULL,
  `news_artical` text DEFAULT NULL,
  `page_no` int(11) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_height` varchar(255) DEFAULT NULL,
  `image_width` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_details`
--

CREATE TABLE `news_details` (
  `news_details_id` int(11) NOT NULL,
  `media_type_id` varchar(255) DEFAULT NULL,
  `publication_id` varchar(255) DEFAULT NULL,
  `edition_id` varchar(255) DEFAULT NULL,
  `supplement_id` varchar(255) DEFAULT NULL,
  `journalist_id` varchar(255) DEFAULT NULL,
  `agencies_id` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `news_position` varchar(255) DEFAULT NULL,
  `news_city_id` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `head_line` text DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `is_send` tinyint(4) NOT NULL DEFAULT 0,
  `keywords` text DEFAULT NULL,
  `client_id` varchar(255) DEFAULT NULL,
  `company` text DEFAULT NULL,
  `sizeofArticle` varchar(255) DEFAULT NULL,
  `website_url` text DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publicationtype`
--

CREATE TABLE `publicationtype` (
  `gidPublicationType_id` bigint(20) UNSIGNED NOT NULL,
  `gidPublicationType` varchar(45) DEFAULT NULL,
  `PublicationType` varchar(45) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `CreatedOn` datetime DEFAULT NULL,
  `CreatedBy` varchar(45) DEFAULT NULL,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` varchar(45) DEFAULT NULL,
  `PubOrder` int(11) NOT NULL DEFAULT 0,
  `PubCoeff` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quick_links`
--

CREATE TABLE `quick_links` (
  `quick_links_id` int(11) NOT NULL,
  `mail_template_id` int(11) DEFAULT NULL,
  `quick_links_name` varchar(255) DEFAULT NULL,
  `quick_links_url` varchar(255) DEFAULT NULL,
  `quick_links_position` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sector`
--

CREATE TABLE `sector` (
  `id` bigint(20) NOT NULL,
  `sector_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `super_admin_id` int(11) NOT NULL,
  `super_admin_name` varchar(255) DEFAULT NULL,
  `super_admin_password` varchar(255) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplements`
--

CREATE TABLE `supplements` (
  `supplement_id` int(11) NOT NULL,
  `gidSupplement` varchar(45) NOT NULL,
  `Supplement` varchar(45) DEFAULT NULL,
  `gidEdition` varchar(45) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `CreatedOn` datetime DEFAULT NULL,
  `CreatedBy` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_status` tinyint(1) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `sector_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` timestamp NULL DEFAULT NULL,
  `user_password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_mails`
--

CREATE TABLE `users_mails` (
  `users_mails_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `users_mails` varchar(255) DEFAULT NULL,
  `report_service` tinyint(4) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addrate`
--
ALTER TABLE `addrate`
  ADD PRIMARY KEY (`gidAddRate_id`),
  ADD UNIQUE KEY `uq_addrate` (`gidMediaOutlet`,`gidEdition`,`gidSupplement`);

--
-- Indexes for table `agency`
--
ALTER TABLE `agency`
  ADD PRIMARY KEY (`gidAgency_id`),
  ADD UNIQUE KEY `uq_agency` (`Agency`);

--
-- Indexes for table `artical_images`
--
ALTER TABLE `artical_images`
  ADD PRIMARY KEY (`artical_images_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `city_table`
--
ALTER TABLE `city_table`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `client_competetor_industry`
--
ALTER TABLE `client_competetor_industry`
  ADD PRIMARY KEY (`client_competetor_industry_id`);

--
-- Indexes for table `competitor`
--
ALTER TABLE `competitor`
  ADD PRIMARY KEY (`competitor_id`);

--
-- Indexes for table `delete_news`
--
ALTER TABLE `delete_news`
  ADD PRIMARY KEY (`delete_news_id`);

--
-- Indexes for table `edition`
--
ALTER TABLE `edition`
  ADD PRIMARY KEY (`gidEdition_id`),
  ADD UNIQUE KEY `uq_edition` (`Edition`,`MediaOutletId`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `industry`
--
ALTER TABLE `industry`
  ADD PRIMARY KEY (`Industry_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journalist`
--
ALTER TABLE `journalist`
  ADD PRIMARY KEY (`journalist_id`);

--
-- Indexes for table `mail_template`
--
ALTER TABLE `mail_template`
  ADD PRIMARY KEY (`mail_template_id`);

--
-- Indexes for table `mediaoutlet`
--
ALTER TABLE `mediaoutlet`
  ADD PRIMARY KEY (`gidMediaOutlet_id`),
  ADD UNIQUE KEY `index2` (`MediaOutlet`,`gidMediaType`);

--
-- Indexes for table `mediatype`
--
ALTER TABLE `mediatype`
  ADD PRIMARY KEY (`gidMediaType_id`),
  ADD UNIQUE KEY `uq_mediatype` (`MediaType`),
  ADD KEY `lorder_index` (`LevelOrder`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newscity`
--
ALTER TABLE `newscity`
  ADD PRIMARY KEY (`gidNewscity_id`),
  ADD UNIQUE KEY `uq_city` (`CityName`);

--
-- Indexes for table `news_artical`
--
ALTER TABLE `news_artical`
  ADD PRIMARY KEY (`news_artical_id`);

--
-- Indexes for table `news_details`
--
ALTER TABLE `news_details`
  ADD PRIMARY KEY (`news_details_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `publicationtype`
--
ALTER TABLE `publicationtype`
  ADD PRIMARY KEY (`gidPublicationType_id`),
  ADD UNIQUE KEY `uq_publication` (`PublicationType`);

--
-- Indexes for table `quick_links`
--
ALTER TABLE `quick_links`
  ADD PRIMARY KEY (`quick_links_id`);

--
-- Indexes for table `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`super_admin_id`);

--
-- Indexes for table `supplements`
--
ALTER TABLE `supplements`
  ADD PRIMARY KEY (`supplement_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_name_unique` (`user_name`);

--
-- Indexes for table `users_mails`
--
ALTER TABLE `users_mails`
  ADD PRIMARY KEY (`users_mails_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addrate`
--
ALTER TABLE `addrate`
  MODIFY `gidAddRate_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agency`
--
ALTER TABLE `agency`
  MODIFY `gidAgency_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artical_images`
--
ALTER TABLE `artical_images`
  MODIFY `artical_images_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_competetor_industry`
--
ALTER TABLE `client_competetor_industry`
  MODIFY `client_competetor_industry_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `competitor`
--
ALTER TABLE `competitor`
  MODIFY `competitor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delete_news`
--
ALTER TABLE `delete_news`
  MODIFY `delete_news_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edition`
--
ALTER TABLE `edition`
  MODIFY `gidEdition_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `industry`
--
ALTER TABLE `industry`
  MODIFY `Industry_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journalist`
--
ALTER TABLE `journalist`
  MODIFY `journalist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_template`
--
ALTER TABLE `mail_template`
  MODIFY `mail_template_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mediaoutlet`
--
ALTER TABLE `mediaoutlet`
  MODIFY `gidMediaOutlet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mediatype`
--
ALTER TABLE `mediatype`
  MODIFY `gidMediaType_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newscity`
--
ALTER TABLE `newscity`
  MODIFY `gidNewscity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_artical`
--
ALTER TABLE `news_artical`
  MODIFY `news_artical_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_details`
--
ALTER TABLE `news_details`
  MODIFY `news_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publicationtype`
--
ALTER TABLE `publicationtype`
  MODIFY `gidPublicationType_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quick_links`
--
ALTER TABLE `quick_links`
  MODIFY `quick_links_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sector`
--
ALTER TABLE `sector`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `super_admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplements`
--
ALTER TABLE `supplements`
  MODIFY `supplement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_mails`
--
ALTER TABLE `users_mails`
  MODIFY `users_mails_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
