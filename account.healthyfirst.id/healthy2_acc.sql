-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Inang: localhost:3306
-- Waktu pembuatan: 15 Apr 2017 pada 02.16
-- Versi Server: 5.6.35-log
-- Versi PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `healthy2_acc`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_appointments`
--

CREATE TABLE IF NOT EXISTS `ea_appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `book_datetime` datetime DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `notes` text,
  `hash` text,
  `is_unavailable` tinyint(4) DEFAULT '0',
  `id_users_provider` bigint(20) unsigned DEFAULT NULL,
  `pref_provider_gender` varchar(8) NOT NULL DEFAULT '0' COMMENT '0 Male 1 Female',
  `id_users_customer` bigint(20) unsigned DEFAULT NULL,
  `id_services` bigint(20) unsigned DEFAULT NULL,
  `duration` int(10) unsigned NOT NULL DEFAULT '0',
  `id_google_calendar` text,
  `address` text,
  `payment` varchar(50) DEFAULT 'Cash' COMMENT 'Payment Type',
  `fee` double DEFAULT NULL,
  `pay` double DEFAULT NULL,
  `voucher` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = waiting, 1 appointed, 2 canceled, 3 reject, 4 done',
  PRIMARY KEY (`id`),
  KEY `id_users_customer` (`id_users_customer`),
  KEY `id_services` (`id_services`),
  KEY `id_users_provider` (`id_users_provider`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=95 ;

--
-- Dumping data untuk tabel `ea_appointments`
--

INSERT INTO `ea_appointments` (`id`, `book_datetime`, `start_datetime`, `end_datetime`, `notes`, `hash`, `is_unavailable`, `id_users_provider`, `pref_provider_gender`, `id_users_customer`, `id_services`, `duration`, `id_google_calendar`, `address`, `payment`, `fee`, `pay`, `voucher`, `status`) VALUES
(63, '2016-12-10 08:39:37', '2016-12-12 09:15:00', '2016-12-12 10:15:00', '', 'c96fc9452be726ef6540abf89e58eaf9', 0, 85, 'Male', 86, 1, 90, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(64, '2017-01-14 08:43:58', '2017-01-14 15:45:00', '2017-01-14 16:45:00', '', NULL, 1, 85, 'Male', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(65, '2017-03-16 19:36:50', '2017-03-16 19:43:00', '2017-03-16 20:45:00', '', '6d40e52165c99ee4996075de7654fe91', 0, 85, 'Male', 91, 1, 90, NULL, NULL, 'Cash', NULL, NULL, NULL, 0),
(66, '2017-03-19 14:32:11', '2017-03-19 14:45:00', '2017-03-19 15:45:00', '', 'b3036faefc0da17ce2a73a0ed470ebb3', 0, 85, 'Male', 91, 1, 90, NULL, 'Kelapa Gading', 'Cash', NULL, NULL, NULL, 0),
(67, '2017-03-27 00:55:48', '2017-03-19 14:45:00', '2017-03-19 15:45:00', '', '626b17e0bb078da3d415c27a0a048b1d', 0, 85, 'Male', 86, 1, 90, NULL, 'Poris, Tangerang', 'Cash', 120000, 120000, NULL, 4),
(68, '2017-03-27 00:50:19', '2017-03-19 14:45:00', '2017-03-19 15:45:00', NULL, '7b1ac6e7a6ec9e7961ef24d4e1642a61', 0, 85, 'Male', 86, 1, 90, NULL, 'Cengkareng', 'Cash', 120000, 120000, NULL, 1),
(69, '2017-03-27 01:11:27', '2017-03-27 01:09:29', NULL, NULL, '7844165f616024d4585cf6ec627e09ab', 0, 90, 'Male', 86, 1, 65, NULL, 'Daan Mogot Mall', 'Cash', 85000, 85000, NULL, 1),
(72, '2017-03-31 18:05:59', '2017-03-31 20:20:00', NULL, NULL, 'c740eee7f9896749f63d05635c28c7ea', 0, 0, 'Male', 86, 3, 60, NULL, 'jakarta', 'Cash', 160000, NULL, NULL, 0),
(73, '2017-04-01 13:17:14', '2017-03-28 20:20:20', NULL, NULL, '1909d554ed3a14cd4b0c3a8295bd7afd', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(74, '2017-04-01 13:17:21', '2017-03-28 20:20:20', NULL, NULL, 'bacaf44ab7f74a4a6eccf16b9df3d15c', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(75, '2017-04-01 13:17:26', '2017-03-28 20:20:20', NULL, NULL, 'c9dc55432b7966456d1c99023b1f9fe1', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(76, '2017-04-01 13:17:33', '2017-03-28 20:20:20', NULL, NULL, 'd2d0af96a58610e0712b195e4a1676ac', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(77, '2017-04-01 19:50:25', '2017-03-28 20:20:20', NULL, NULL, '667701aa716fafca07f57e58f462d430', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(78, '2017-04-01 19:55:06', '2017-03-28 20:20:20', NULL, NULL, '307aae6b101468ef7b698967eb42c4c4', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(79, '2017-04-01 19:58:26', '2017-03-28 20:20:20', NULL, NULL, '55e2149f454e969f186ddcb93403daac', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(80, '2017-04-01 19:58:44', '2017-03-28 20:20:20', NULL, NULL, 'f8092ec1fe42b48390235028036bff4f', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(81, '2017-04-01 22:39:02', '2017-04-02 09:00:00', NULL, NULL, '55a07d1b2281dd10eb28f3bbf38829f3', 0, 85, 'Male', 91, 3, 60, NULL, 'asdasfagasffasd', 'Cash', 160000, 100000, NULL, 0),
(82, '2017-04-01 23:47:53', '2017-04-20 20:20:20', NULL, NULL, '2ffb50be6419886c64ee54e52e563b18', 0, 85, 'Male', 94, 3, 60, NULL, 'sdasfasfasdf', 'Cash', 160000, 100000, NULL, 0),
(83, '2017-04-01 23:48:35', '2017-04-28 10:00:00', NULL, NULL, '61f58c96277bf91d16ed5621f7da9bce', 0, 85, 'Male', 94, 3, 60, NULL, 'sadfrasfsafasf', 'Cash', 160000, 100000, NULL, 0),
(84, '2017-04-01 23:52:11', '2017-04-27 10:00:00', NULL, NULL, '3340822a22ffaf43696904a7d9cb1187', 0, 85, 'Male', 94, 3, 60, NULL, 'asfasfasfas', 'Cash', 160000, 100000, NULL, 3),
(85, '2017-04-04 14:18:29', '2017-03-28 20:20:20', NULL, NULL, 'ffb8979acb8f6bd78808947e2fed5293', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(86, '2017-04-04 14:18:33', '2017-03-28 20:20:20', NULL, NULL, '23a25c3a7de0c3e00e4f6c20c6fe632f', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(87, '2017-04-10 03:38:42', '2017-03-28 20:20:20', NULL, NULL, '6fb2cdba1a57996966dd42d64541553f', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(88, '2017-04-10 03:43:25', '2017-03-28 20:20:20', NULL, NULL, '4317e0743e0cd6b970fbe8ecd705e7e2', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(89, '2017-04-11 15:16:11', '2017-03-28 20:20:20', NULL, NULL, '1cf93eb31c9fef3822d900d943c66c9a', 0, 0, 'Male', 91, 3, 60, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 160000, NULL, 'MARETCERIA', 0),
(90, '2017-04-13 11:14:06', '2017-04-13 09:57:26', NULL, NULL, '34dda823a04569cc9e1953110ad58bdb', 0, 0, 'Female', 91, 21, 135, NULL, 'Jl. Kebayoran Lama No. 123 Jakarta Selatan', 'Cash', 260000, NULL, '', 0),
(91, '2017-04-14 19:08:37', '2017-04-13 12:00:00', NULL, NULL, '16144d281af60a823c31d4366657eae6', 0, 96, 'Male', 91, 3, 60, NULL, 'jalan kebayoran', 'Cash', 160000, 100000, NULL, 0),
(92, '2017-04-14 19:42:32', '2017-04-14 20:00:00', NULL, NULL, '74b05a1e8e9a4f959822ee26d0dae955', 0, 96, 'Male', 91, 3, 60, NULL, 'jalan kebayoran', 'Cash', 160000, 200000, NULL, 3),
(93, '2017-04-14 19:29:06', '2017-04-14 19:00:00', NULL, NULL, '89227a02dfaa4dd49671a90099c4e99a', 0, 96, 'Male', 91, 3, 60, NULL, 'jalan baru', 'Cash', 160000, 200000, NULL, 0),
(94, '2017-04-14 20:25:49', '2017-04-14 19:30:00', NULL, NULL, '5ba709b14b2d3e5c8fff1ceb2819d25d', 0, 85, 'Male', 91, 3, 60, NULL, 'jalan senayan', 'Cash', 160000, 200000, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_items`
--

CREATE TABLE IF NOT EXISTS `ea_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `ea_items`
--

INSERT INTO `ea_items` (`id`, `name`, `description`, `stock`) VALUES
(4, 'PEVONIA', '', 100),
(5, 'COCONA', '', 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_item_usage`
--

CREATE TABLE IF NOT EXISTS `ea_item_usage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemid` int(11) NOT NULL DEFAULT '0',
  `appid` int(11) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_roles`
--

CREATE TABLE IF NOT EXISTS `ea_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `slug` varchar(256) DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT NULL COMMENT '0',
  `appointments` int(4) DEFAULT NULL COMMENT '0',
  `customers` int(4) DEFAULT NULL COMMENT '0',
  `services` int(4) DEFAULT NULL COMMENT '0',
  `users` int(4) DEFAULT NULL COMMENT '0',
  `inventory` int(4) NOT NULL,
  `system_settings` int(4) DEFAULT NULL COMMENT '0',
  `user_settings` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `ea_roles`
--

INSERT INTO `ea_roles` (`id`, `name`, `slug`, `is_admin`, `appointments`, `customers`, `services`, `users`, `inventory`, `system_settings`, `user_settings`) VALUES
(1, 'Administrator', 'admin', 1, 15, 15, 15, 15, 15, 15, 15),
(2, 'Provider', 'provider', 0, 15, 15, 0, 0, 0, 0, 15),
(3, 'Customer', 'customer', 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'Secretary', 'secretary', 0, 15, 15, 0, 0, 0, 0, 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_secretaries_providers`
--

CREATE TABLE IF NOT EXISTS `ea_secretaries_providers` (
  `id_users_secretary` bigint(20) unsigned NOT NULL,
  `id_users_provider` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_users_secretary`,`id_users_provider`),
  KEY `fk_ea_secretaries_providers_1` (`id_users_secretary`),
  KEY `fk_ea_secretaries_providers_2` (`id_users_provider`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_services`
--

CREATE TABLE IF NOT EXISTS `ea_services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `description` text,
  `availabilities_type` varchar(32) DEFAULT 'flexible',
  `attendants_number` int(11) DEFAULT '1',
  `id_service_categories` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_service_categories` (`id_service_categories`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data untuk tabel `ea_services`
--

INSERT INTO `ea_services` (`id`, `name`, `duration`, `price`, `currency`, `description`, `availabilities_type`, `attendants_number`, `id_service_categories`) VALUES
(1, 'REFLEXOLOGY COCONA', NULL, NULL, 'IDR', 'Teknik pijat dengan melakukan tekanan dengan pilihan durasi 60 s/d 120 menit pada titik-titik tubuh yang terdapat pada bagian kaki, telapak kaki,tangan,telapak tangan,bahu,punggung, leher hingga kepala dengan menggunakan massage oil berkualitas', 'flexible', 1, 2),
(2, 'BODY MASSAGE PEVONIA', NULL, NULL, 'IDR', '', 'flexible', 20, 1),
(3, 'REFLEXOLOGY PEVONIA', NULL, NULL, NULL, 'Teknik pijat dengan melakukan tekanan dengan pilihan durasi 60 s/d 120 menit pada titik-titik tubuh yang terdapat pada bagian kaki, telapak kaki,tangan,telapak tangan,bahu,punggung, leher hingga kepala dengan menggunakan massage oil berkualitas', 'flexible', 1, 2),
(4, 'BODY MASSAGE COCONA', NULL, NULL, NULL, '', 'flexible', 1, 1),
(5, 'BODY SCRUB COCONA', NULL, NULL, NULL, '', 'flexible', 1, 4),
(6, 'BODY SCRUB PEVONIA', NULL, NULL, NULL, '', 'flexible', 1, 4),
(7, 'FACE ACCUPRESURE', NULL, NULL, NULL, '', 'flexible', 1, 3),
(21, 'MASSAGE + BODY SCRUB COCONA', NULL, NULL, NULL, '', 'flexible', 1, 5),
(22, 'MASSAGE + BODY SCRUB PEVONIA', NULL, NULL, NULL, '', 'flexible', 1, 5),
(23, 'MASSAGE + FACE ACCUPRESSURE COCONA', NULL, NULL, NULL, '', 'flexible', 1, 6),
(24, 'MASSAGE + FACE ACCUPRESSURE PEVONIA', NULL, NULL, NULL, '', 'flexible', 1, 6),
(25, 'DRY MASSAGE', NULL, NULL, NULL, '', 'flexible', 1, 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_services_pack_prices`
--

CREATE TABLE IF NOT EXISTS `ea_services_pack_prices` (
  `serviceid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `duration` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`serviceid`,`duration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `ea_services_pack_prices`
--

INSERT INTO `ea_services_pack_prices` (`serviceid`, `duration`, `price`, `currency`) VALUES
(3, 60, '160000.00', NULL),
(3, 90, '190000.00', NULL),
(3, 120, '240000.00', NULL),
(4, 60, '140000.00', NULL),
(4, 90, '170000.00', NULL),
(4, 120, '220000.00', NULL),
(5, 45, '140000.00', NULL),
(6, 45, '160000.00', NULL),
(7, 45, '130000.00', NULL),
(13, 60, '130000.00', NULL),
(13, 90, '150000.00', NULL),
(13, 120, '200000.00', NULL),
(14, 60, '160000.00', NULL),
(14, 90, '190000.00', NULL),
(14, 120, '240000.00', NULL),
(15, 60, '120000.00', NULL),
(16, 60, '150000.00', NULL),
(16, 90, '170000.00', NULL),
(16, 120, '220000.00', NULL),
(17, 60, '140000.00', NULL),
(17, 90, '170000.00', NULL),
(17, 120, '220000.00', NULL),
(18, 45, '140000.00', NULL),
(19, 45, '160000.00', NULL),
(20, 45, '130000.00', NULL),
(21, 105, '230000.00', NULL),
(21, 135, '260000.00', NULL),
(22, 105, '280000.00', NULL),
(22, 135, '310000.00', NULL),
(23, 105, '220000.00', NULL),
(23, 135, '250000.00', NULL),
(24, 105, '220000.00', NULL),
(24, 135, '270000.00', NULL),
(25, 60, '185000.00', NULL),
(25, 90, '235000.00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_services_providers`
--

CREATE TABLE IF NOT EXISTS `ea_services_providers` (
  `id_users` bigint(20) unsigned NOT NULL,
  `id_services` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_users`,`id_services`),
  KEY `id_services` (`id_services`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `ea_services_providers`
--

INSERT INTO `ea_services_providers` (`id_users`, `id_services`) VALUES
(85, 1),
(90, 1),
(96, 1),
(90, 2),
(96, 2),
(90, 3),
(90, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_service_categories`
--

CREATE TABLE IF NOT EXISTS `ea_service_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data untuk tabel `ea_service_categories`
--

INSERT INTO `ea_service_categories` (`id`, `name`, `description`) VALUES
(1, 'BODY MASSAGE', 'Pemijatan pada titik-titik tertentu untuk mengurangi kekauan otot dan memberikan relaksasi menyeluruh pada tubuh dan pikiran menjadi rileks, mengurangi stress dan memperlancar peredaran darah.'),
(2, 'REFLEXOLOGY', 'Teknik pijat dengan melakukan tekanan pada titik-titik tubuh yang terdapat pada bagian kaki, telapak kaki, tangan, telapak tangan, bahu, punggung, leher hingga kepala dengan menggunakan Oil berkualitas'),
(3, 'FACE ACCUPRESSURE', 'Merangsang sirkulasi darah, meningkatkan oksigen di wajah, merangsang produksi collagen, membantu menyembuhkan penyakit sinusitis, vertigo, migren dan mengencangkan jaringan kulit wajah serta membuat pikiran anda lebih rileks'),
(4, 'BODY SCRUB', 'Membuat tubuh dan pikiran andra lebih rileks, memperlancar peredaran darah, mengangkat kotoran serta sel-sel kulit mati dan dapat menghaluskan kulit. Sehingga badan semakin sehat dan kulit semakin halus'),
(5, 'MASSAGE + BODY SCRUB', 'Membuat tubuh dan pikiran anda lebih rileks, memperlancar peredaran darah, mengangkat kotoran serta sel-sel kulit mati dan dapat menghaluskan kulit. Sehingga badan semakin sehar dan kulit semakin halus.'),
(6, 'MASSAGE + FACE ACCUPRESSURE', 'Merangsang sirkulasi darah, meningkatkan oksigen di wajah, merangsang produksi collagen, membantu menyembuhkan penyakit sinusitis, vertigo, migres dan mengencangkan jaringan kulit wajah serta membuat pikiran anda lebih rileks'),
(7, 'DRY MASSAGE', 'Pemijatan pada titik-titik tertentu untuk mengurangi kekauan otot dan memberikan relaksasi menyeluruh pada tubuh dan pikiran menjadi rileks, mengurangi stress dan memperlancar peredaran darah. Tanpa menggunakan massage oil. ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_settings`
--

CREATE TABLE IF NOT EXISTS `ea_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) DEFAULT NULL,
  `value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data untuk tabel `ea_settings`
--

INSERT INTO `ea_settings` (`id`, `name`, `value`) VALUES
(16, 'company_working_plan', '{"monday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"tuesday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"wednesday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"thursday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"friday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"saturday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"sunday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]}}'),
(17, 'book_advance_timeout', '30'),
(18, 'google_analytics_code', ''),
(19, 'customer_notifications', '1'),
(20, 'date_format', 'DMY'),
(21, 'require_captcha', '0'),
(22, 'company_name', 'HealthyFirst'),
(23, 'company_email', 'webmaster@healthyfirst.id'),
(24, 'company_link', 'http://healthyfirst.id');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_users`
--

CREATE TABLE IF NOT EXISTS `ea_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(256) DEFAULT NULL,
  `last_name` varchar(512) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `mobile_number` varchar(128) DEFAULT NULL,
  `phone_number` varchar(128) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `city` varchar(256) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `zip_code` varchar(64) DEFAULT NULL,
  `notes` text,
  `id_roles` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `id_roles` (`id_roles`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

--
-- Dumping data untuk tabel `ea_users`
--

INSERT INTO `ea_users` (`id`, `first_name`, `last_name`, `email`, `mobile_number`, `phone_number`, `address`, `city`, `state`, `zip_code`, `notes`, `id_roles`) VALUES
(84, 'Healthy', 'First', 'webmaster@healthyfirst.id', '', '99999999999', '', '', '', '', '', 1),
(85, 'Johnny', 'Doeel zaw', 'john@doe.com', '', '0123456789', '', '', '', '', '', 2),
(86, 'test', 'aja', 'testing@test.com', NULL, '123123', 'Lokasari', '', NULL, '', '', 3),
(87, 'test', 'lagi', 'testing@test2.com', NULL, '123123123', '', '', NULL, '', '', 3),
(88, 'jack', 'azhar', 'muhammad.azhar3893@gmail.com', '', '085775245188', 'jalan sunter', 'jakarta', '', '11722', '', 1),
(89, 'Healthy1', 'Bowo', 'Healthy1@yahoo.com', '', '082111159032', 'dwijaya', 'jakarta', '', '121542', '', 1),
(90, 'Mahroza', 'Pradana', 'viviojja@gmail.com', '081382437894', '021092139123', 'jalan kemuning', 'bekasi', '', '', '', 2),
(91, 'Always', 'Del Heru', 'alwaysdelheru@gmail.com', '087878787', '087878787', 'Bandung', 'Bandung', NULL, '40989', 'Register from API', 3),
(92, 'bowo', 'satriyo', 'bowosatriyo09@gmail.com', '081390030060', '', '', 'Kebayoran Baru', NULL, '12400', 'Register from API', 3),
(93, 'Always', 'Del Heru', 'alwsysdelheru@ymail.com', '087812341234', '022123456', 'Jl. Jakarta No. 21', 'Bandung', NULL, '43212', 'Register from API', 3),
(94, 'mahroza', 'pradana', 'viviojja@yahoo.co.id', NULL, '0818135085', 'bekasi', 'bekasi', NULL, '17131', 'sdakhdajhda', 3),
(96, 'therapist1', 'azhar', 'therapist@healthy.com', '', '088712345678', '', '', '', '', '', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ea_user_settings`
--

CREATE TABLE IF NOT EXISTS `ea_user_settings` (
  `id_users` bigint(20) unsigned NOT NULL,
  `username` varchar(64) DEFAULT NULL,
  `password` varchar(512) DEFAULT NULL,
  `salt` varchar(512) DEFAULT NULL,
  `working_plan` text,
  `notifications` tinyint(4) DEFAULT '0',
  `google_sync` tinyint(4) DEFAULT '0',
  `google_token` text,
  `google_calendar` varchar(128) DEFAULT NULL,
  `sync_past_days` int(11) DEFAULT '5',
  `sync_future_days` int(11) DEFAULT '5',
  `calendar_view` varchar(32) DEFAULT 'default',
  PRIMARY KEY (`id_users`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `ea_user_settings`
--

INSERT INTO `ea_user_settings` (`id_users`, `username`, `password`, `salt`, `working_plan`, `notifications`, `google_sync`, `google_token`, `google_calendar`, `sync_past_days`, `sync_future_days`, `calendar_view`) VALUES
(84, 'admin', 'cb02c0f68fdb95097a974f5477d30ea96e0fefc1b987f5529a2045a0dbac35b3', '80b95577c5915599d45922832cbd7e7eac17d7031030abb0b305b5b305dc7e87', NULL, 1, 0, NULL, NULL, 5, 5, 'default'),
(85, 'johndoe', '450f25ab6eafe7261b4df7a30097b31352c93114bed038c526f60cf4a528033e', '644e9683ccb3f2156d8bc8f1057fc78860de1e36b19e63f3cfbe765f788b15d7', '{"monday":{"start":"09:00","end":"18:00","breaks":[{"start":"12:00","end":"13:00"}]},"tuesday":{"start":"09:00","end":"18:00","breaks":[{"start":"12:00","end":"13:00"}]},"wednesday":{"start":"09:00","end":"18:00","breaks":[{"start":"12:00","end":"13:00"}]},"thursday":{"start":"09:00","end":"18:00","breaks":[{"start":"12:00","end":"13:00"}]},"friday":{"start":"09:00","end":"18:00","breaks":[{"start":"12:00","end":"13:00"}]},"saturday":null,"sunday":null}', 0, 0, NULL, NULL, 5, 5, 'default'),
(86, 'test', 'bf4067d043a7f534b9f4bec5b56e6c79c8185085c63d23e43a43a61eb4f46e67', '4b0030df67a584f7c1d95bb03f02b4637fa10ddc49af1a9996a733c09ae371ae', NULL, 0, 0, NULL, NULL, 5, 5, 'default'),
(87, 'testqwe', 'dae1970cec0efbb52078c153ae1844f9838b492598193ce0f8b222bd86b69895', '9e726b523aa4b9af39cd71476c0df7d40e5bd7f14aaff3c3934074cf5e7c7eca', NULL, 0, 0, NULL, NULL, 5, 5, 'default'),
(88, 'azhar', '4888d2e8c99e9fe6b606cd8002f3e95c140ded2a523159733fe440193b5f6e33', '25d620959d5d7bbecc83b029147116e56aba742f370c31b634b5856a2fd8bd3b', NULL, 1, 0, NULL, NULL, 5, 5, 'default'),
(89, 'healthy1', 'd86465ad1b1677383a8d92cbf7ce5c902b60acca5ddbca34ed9fdb14663a2b88', '5db25b8520505b204b0dca60369f8f17581f1d82efda701d376f30ed93e6e912', NULL, 0, 0, NULL, NULL, 5, 5, 'default'),
(90, 'mahroza', '9101ce23dbdbec08f4775833a698ed313777a30410110d092f77d456dccc3ded', '8a544b5cdc4ec8b0808c98e4d0d49e4079dfc1696678bf78dba62a8676aff534', '{"monday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"tuesday":null,"wednesday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"thursday":null,"friday":null,"saturday":null,"sunday":null}', 0, 0, NULL, NULL, 5, 5, 'table'),
(91, 'alwaysdelheru', 'f5bf866b259d1f08c099c79574e82a60b7c1e1b045db144372f22798682c4196', 'c12207131a7c71adbe21defec6e6ae8aaa5d063d8541e88fed26bf28ee04f894', NULL, 0, 0, NULL, NULL, 5, 5, 'default'),
(92, 'bowo', '342845db1c5b00eb1103c804c3f7eb8e2b6dfb0d79c0cf21d29b87f1527a20ae', 'cc4b586fc2fdc329489c8eaeeddcac160ae8dcb8b793f6fbe17458c20ea89f09', NULL, 0, 0, NULL, NULL, 5, 5, 'default'),
(93, 'alwaysdelheru2', 'fd41f3c36fb9d95644f4620d2920b162fcf4303be1c01eec4aa1860e01b14333', 'd432015be7bc1766f5935bbe362fd9883e404f8652ed5086e6e54ae41ea5fb5e', NULL, 0, 0, NULL, NULL, 5, 5, 'default'),
(94, 'ojan', '3657e5a292ff8280fdad6880f337178f117f037d78137a95ac733bb6c023a42a', '6e51c885aa1ea9062307a676776a0e03e28a6e69be0f2d63838683d1ef112c72', NULL, 0, 0, NULL, NULL, 5, 5, 'default'),
(96, 'therapist1', '63e105da8cb9e62f44220d2032a236836595ec5ce2ec7b0d6e7fb981b74ed20e', '86baa5efdc8750685c570594e4d27116e5efd49cb63c11d7b42ccf0b3ec8968d', '{"monday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"tuesday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"wednesday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"thursday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"friday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"saturday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"sunday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]}}', 0, 0, NULL, NULL, 5, 5, 'default');

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `ea_secretaries_providers`
--
ALTER TABLE `ea_secretaries_providers`
  ADD CONSTRAINT `fk_ea_secretaries_providers_1` FOREIGN KEY (`id_users_secretary`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ea_secretaries_providers_2` FOREIGN KEY (`id_users_provider`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ea_services`
--
ALTER TABLE `ea_services`
  ADD CONSTRAINT `ea_services_ibfk_1` FOREIGN KEY (`id_service_categories`) REFERENCES `ea_service_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ea_services_providers`
--
ALTER TABLE `ea_services_providers`
  ADD CONSTRAINT `ea_services_providers_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ea_services_providers_ibfk_2` FOREIGN KEY (`id_services`) REFERENCES `ea_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ea_users`
--
ALTER TABLE `ea_users`
  ADD CONSTRAINT `ea_users_ibfk_1` FOREIGN KEY (`id_roles`) REFERENCES `ea_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ea_user_settings`
--
ALTER TABLE `ea_user_settings`
  ADD CONSTRAINT `ea_user_settings_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
