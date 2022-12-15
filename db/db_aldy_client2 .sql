-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Nov 2022 pada 07.51
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_aldy_client2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `action`
--

CREATE TABLE `action` (
  `id` int(11) UNSIGNED NOT NULL,
  `controller_id` varchar(255) NOT NULL,
  `action_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `action`
--

INSERT INTO `action` (`id`, `controller_id`, `action_id`, `name`, `alias`) VALUES
(254, '\\App\\Controllers\\Admin\\Dashboard', 'index', 'index (GET]', 'admin.dashboard'),
(265, '\\App\\Controllers\\Rbac\\Role', 'action', 'action (GET]', 'admin.rbac.role.action'),
(268, '\\App\\Controllers\\Rbac\\Role', 'menu', 'menu (GET]', 'admin.rbac.role.menu'),
(269, '\\App\\Controllers\\Rbac\\Role', 'saveMenu', 'saveMenu (POST]', 'admin.rbac.role.save-menu'),
(272, '\\App\\Controllers\\Rbac\\Role', 'updateAction', 'updateAction (POST]', 'admin.rbac.role.update-action'),
(279, '\\App\\Controllers\\Rbac\\Menu', 'updateOrder', 'updateOrder (POST]', 'admin.rbac.menu.update-order'),
(318, '\\App\\Controllers\\Rbac\\Menu', 'index', 'index (GET]', 'admin.rbac.menu.index'),
(322, '\\App\\Controllers\\Rbac\\Menu', 'store', 'store (POST]', 'admin.rbac.menu.store'),
(344, '\\App\\Controllers\\Rbac\\Menu', 'orderable', 'orderable (GET]', 'admin.rbac.menu.orderable'),
(345, '\\App\\Controllers\\Admin\\User', 'index', 'index (GET]', 'admin.user.index'),
(349, '\\App\\Controllers\\Admin\\User', 'store', 'store (POST]', 'admin.user.store'),
(351, '\\App\\Controllers\\Rbac\\Role', 'index', 'index (GET]', 'admin.rbac.role.index'),
(352, '\\App\\Controllers\\Rbac\\Role', 'store', 'store (POST]', 'admin.rbac.role.store'),
(356, '\\App\\Controllers\\Admin\\User', 'datatable', 'datatable (GET]', 'admin.user.datatable'),
(357, '\\App\\Controllers\\Rbac\\Role', 'datatable', 'datatable (GET]', 'admin.rbac.role.datatable'),
(358, '\\App\\Controllers\\Rbac\\Menu', 'datatable', 'datatable (GET]', 'admin.rbac.menu.datatable'),
(359, '\\App\\Controllers\\Admin\\User', 'destroy', 'destroy (DELETE]', 'admin.user.destroy'),
(360, '\\App\\Controllers\\Admin\\User', 'show', 'show (GET]', 'admin.user.show'),
(361, '\\App\\Controllers\\Admin\\User', 'update', 'update (PUT]', 'admin.user.update'),
(362, '\\App\\Controllers\\Rbac\\Role', 'destroy', 'destroy (DELETE]', 'admin.rbac.role.destroy'),
(363, '\\App\\Controllers\\Rbac\\Role', 'show', 'show (GET]', 'admin.rbac.role.show'),
(364, '\\App\\Controllers\\Rbac\\Role', 'update', 'update (PUT]', 'admin.rbac.role.update'),
(365, '\\App\\Controllers\\Rbac\\Menu', 'destroy', 'destroy (DELETE]', 'admin.rbac.menu.destroy'),
(366, '\\App\\Controllers\\Rbac\\Menu', 'show', 'show (GET]', 'admin.rbac.menu.show'),
(367, '\\App\\Controllers\\Rbac\\Menu', 'update', 'update (PUT]', 'admin.rbac.menu.update'),
(368, '\\App\\Controllers\\Admin\\User', 'storeProfile', 'storeProfile (POST]', 'admin.user.store-profile'),
(369, '\\App\\Controllers\\Admin\\User', 'profile', 'profile (GET]', 'admin.user.profile'),
(370, '\\App\\Controllers\\Admin\\TokenPeruri', 'index', 'index (GET)', 'admin.token-peruri.index'),
(371, '\\App\\Controllers\\Admin\\TokenPeruri', 'get', 'get (GET)', 'admin.token-peruri.get'),
(372, '\\App\\Controllers\\Admin\\TokenPeruri', 'refresh', 'refresh (POST)', 'admin.token-peruri.refresh'),
(373, '\\App\\Controllers\\Admin\\UnggahDokumen', 'index', 'index (GET)', 'admin.unggah-dokumen.index'),
(374, '\\App\\Controllers\\Admin\\UnggahDokumen', 'store', 'store (POST)', 'admin.unggah-dokumen.store'),
(375, '\\App\\Controllers\\Admin\\User', 'select2', 'select2 (GET)', 'admin.user.select2'),
(376, '\\App\\Controllers\\Admin\\History', 'index', 'index (GET)', 'admin.history.index'),
(377, '\\App\\Controllers\\Admin\\History', 'datatable', 'datatable (GET)', 'admin.history.datatable'),
(378, '\\App\\Controllers\\Admin\\History', 'show', 'show (GET)', 'admin.history.show'),
(379, '\\App\\Controllers\\Admin\\DocumentProcess', 'datatable', 'datatable (GET)', 'admin.document-process.datatable'),
(380, '\\App\\Controllers\\Admin\\DocumentProcess', 'detail', 'detail (GET)', 'admin.document-process.detail'),
(381, '\\App\\Controllers\\Admin\\DocumentProcess', 'show', 'show (GET)', 'admin.document-process.show'),
(382, '\\App\\Controllers\\Admin\\Dashboard', 'datatable', 'datatable (GET)', 'admin.dashboard.datatable'),
(388, '\\App\\Controllers\\Admin\\V2\\Dashboard', 'index', 'index (GET)', 'admin.v2.dashboard.index'),
(389, '\\App\\Controllers\\Admin\\V2\\Dashboard', 'datatable', 'datatable (GET)', 'admin.v2.dashboard.datatable'),
(390, '\\App\\Controllers\\Admin\\V2\\History', 'index', 'index (GET)', 'admin.v2.history.index'),
(391, '\\App\\Controllers\\Admin\\V2\\History', 'show', 'show (GET)', 'admin.v2.history.show'),
(392, '\\App\\Controllers\\Admin\\V2\\History', 'datatable', 'datatable (GET)', 'admin.v2.history.datatable'),
(393, '\\App\\Controllers\\Admin\\V2\\FileContent', 'datatable', 'datatable (GET)', 'admin.v2.file-content.datatable'),
(394, '\\App\\Controllers\\Admin\\V2\\FileContent', 'show', 'show (GET)', 'admin.v2.file-content.show'),
(395, '\\App\\Controllers\\Admin\\V2\\History', 'export', 'export (GET)', 'admin.v2.history.export'),
(396, '\\App\\Controllers\\Admin\\V2\\History', 'status', 'status (GET)', 'admin.v2.history.status'),
(397, '\\App\\Controllers\\Admin\\V2\\FileContent', 'process', 'process (POST)', 'admin.v2.file-content.process');

-- --------------------------------------------------------

--
-- Struktur dari tabel `document_process`
--

CREATE TABLE `document_process` (
  `id` int(11) NOT NULL,
  `email_file_owner` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `name_owner` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `document_process`
--

INSERT INTO `document_process` (`id`, `email_file_owner`, `status`, `file_id`, `name_owner`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`, `description`, `data`) VALUES
(1, 'defrindr@gmail.com', 1, 1, 'Defri Indra Mahardika', '2022-11-03 01:06:08', '1', '2022-11-03 01:06:08', '1', NULL, '', 'Sukses Upload', '-'),
(2, 'AldyAnugrah@gmail.com', 0, 1, 'Aldy Anugrah', '2022-11-03 01:06:08', '1', '2022-11-03 01:06:08', '1', NULL, '', 'Sukses Upload', '-'),
(3, 'defrindr@gmail.com', 1, 2, 'Defri Indra Mahardika', '2022-11-03 01:06:08', '1', '2022-11-03 01:06:08', '1', NULL, '', 'Sukses Upload', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `document_process_detail`
--

CREATE TABLE `document_process_detail` (
  `id` int(11) NOT NULL,
  `id_document` int(11) DEFAULT NULL,
  `email_penandatangan` varchar(100) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `lower_left_x` int(11) DEFAULT NULL,
  `lower_left_y` int(11) DEFAULT NULL,
  `upper_right_x` int(11) DEFAULT NULL,
  `upper_right_y` int(11) DEFAULT NULL,
  `page` int(11) DEFAULT NULL,
  `sign_date` timestamp NULL DEFAULT NULL,
  `send_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `document_process_detail`
--

INSERT INTO `document_process_detail` (`id`, `id_document`, `email_penandatangan`, `action`, `lower_left_x`, `lower_left_y`, `upper_right_x`, `upper_right_y`, `page`, `sign_date`, `send_date`, `status`, `description`) VALUES
(1, 1, 'defrindr@gmail.com', 'signing', 12, 12, 12, 12, 1, '2022-11-02 18:08:09', '2022-11-03 01:08:09', 1, 'Sukses Signing 1'),
(2, 1, 'defrindr@gmail.com', 'signing', 12, 12, 12, 12, 1, '2022-11-02 18:08:09', '2022-11-03 01:08:09', NULL, 'Sukses Signing 2'),
(3, 1, 'defrindr@gmail.com', 'signing', 12, 12, 12, 12, 1, '2022-11-02 18:08:09', '2022-11-03 01:08:09', NULL, 'Sukses Signing 3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `file_contents`
--

CREATE TABLE `file_contents` (
  `id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `email_peserta` varchar(100) DEFAULT NULL,
  `nama_peserta` varchar(100) DEFAULT NULL,
  `email_penandatangan` varchar(100) DEFAULT NULL,
  `nama_penandatangan` varchar(100) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `lower_left_x` int(11) DEFAULT NULL,
  `lower_left_y` int(11) DEFAULT NULL,
  `upper_right_x` int(11) DEFAULT NULL,
  `upper_right_y` int(11) DEFAULT NULL,
  `page` int(11) DEFAULT NULL,
  `sign_date` timestamp NULL DEFAULT NULL,
  `send_date` timestamp NULL DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `content_line` text DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `baris` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pos` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `status_file` int(11) NOT NULL,
  `result_code` varchar(100) NOT NULL,
  `result_desc` varchar(100) NOT NULL,
  `file_name_done` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `file_contents`
--

INSERT INTO `file_contents` (`id`, `file_id`, `email_peserta`, `nama_peserta`, `email_penandatangan`, `nama_penandatangan`, `action`, `lower_left_x`, `lower_left_y`, `upper_right_x`, `upper_right_y`, `page`, `sign_date`, `send_date`, `status`, `content_line`, `description`, `baris`, `created_at`, `updated_at`, `pos`, `file_name`, `order_id`, `status_file`, `result_code`, `result_desc`, `file_name_done`) VALUES
(1, 2, 'AldyAnugrah@gmail.com', 'Aldy Anugrah', 'Aldy.id@gmail.com', 'Indah puspitasari', 'Signed', 12, 120, 128, 329, 1200, '2022-11-06 06:22:31', NULL, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'We\'ll match the product prices of key online and local competitors for immediately', 12, '2022-11-06 06:22:31', '2022-11-13 06:07:27', 0, '', '', 0, '', '', ''),
(2, 2, 'AldyAnugrah@gmail.com', 'Aldy Anugrah', 'Aldy.id@gmail.com', 'Indah puspitasari', 'Signed', 12, 120, 128, 329, 1200, '2022-11-06 06:22:31', NULL, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'We\'ll match the product prices of key online and local competitors for immediately', 12, '2022-11-06 06:22:31', '2022-11-13 06:46:00', 0, '', '', 0, '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `file_upload`
--

CREATE TABLE `file_upload` (
  `id` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deskripsi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `file_upload`
--

INSERT INTO `file_upload` (`id`, `file_name`, `status`, `created_at`, `updated_at`, `deskripsi`) VALUES
(1, 'dummy.pdf', 1, '2022-11-02 18:16:09', '2022-11-02 18:16:09', 'Ini Deskripsi File'),
(2, 'dummy.pdf', 1, '2022-11-02 19:16:09', '2022-11-02 20:16:09', 'Contoh File Sign');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL DEFAULT '#',
  `action` varchar(255) NOT NULL DEFAULT 'index',
  `icon` varchar(255) NOT NULL,
  `order` int(11) DEFAULT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `name`, `controller`, `action`, `icon`, `order`, `parent_id`) VALUES
(15, 'Riwayat Dokumen', 'admin.v2.history.index', '', 'fa-envelope', 2, NULL),
(16, 'MENU RBAC', '#', '', 'fa-unlock-alt', 5, NULL),
(17, 'MENU', 'admin.rbac.menu.index', '', 'fa-circle-o', 1, 16),
(18, 'HAK AKSES', 'admin.rbac.role.index', '', 'fa-exclamation-circle', 0, 16),
(19, 'PENGGUNA', 'admin.user.index', '', 'fa-users', 3, NULL),
(28, 'Dashboard', 'admin.v2.dashboard.index', '', 'fa-envelope', 0, NULL),
(29, 'Manage Token', 'admin.token-peruri.index', '', 'fa-key', 4, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(11, '2022-11-01-020407', 'App\\Database\\Migrations\\Role', 'default', 'App', 1667404690, 1),
(12, '2022-11-01-020810', 'App\\Database\\Migrations\\Action', 'default', 'App', 1667404690, 1),
(13, '2022-11-01-021026', 'App\\Database\\Migrations\\Menu', 'default', 'App', 1667404690, 1),
(14, '2022-11-01-021412', 'App\\Database\\Migrations\\RoleAction', 'default', 'App', 1667404690, 1),
(15, '2022-11-01-021457', 'App\\Database\\Migrations\\RoleMenu', 'default', 'App', 1667404690, 1),
(16, '2022-11-01-021718', 'App\\Database\\Migrations\\Users', 'default', 'App', 1667404690, 1),
(17, '2022-11-01-021758', 'App\\Database\\Migrations\\TokenPeruri', 'default', 'App', 1667404690, 1),
(18, '2022-11-02-153130', 'App\\Database\\Migrations\\FileUpload', 'default', 'App', 1667404690, 1),
(19, '2022-11-02-153139', 'App\\Database\\Migrations\\DocumentProcess', 'default', 'App', 1667404691, 1),
(20, '2022-11-02-153632', 'App\\Database\\Migrations\\DocumentProcessDetail', 'default', 'App', 1667404691, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Super Administrator'),
(3, 'Regular User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_action`
--

CREATE TABLE `role_action` (
  `id` int(11) UNSIGNED NOT NULL,
  `role_id` int(11) UNSIGNED NOT NULL,
  `action_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `role_action`
--

INSERT INTO `role_action` (`id`, `role_id`, `action_id`) VALUES
(99, 1, 265),
(106, 1, 272),
(113, 1, 279),
(116, 1, 268),
(118, 1, 269),
(141, 1, 254),
(148, 1, 318),
(152, 1, 322),
(166, 1, 351),
(167, 1, 352),
(171, 1, 344),
(172, 1, 345),
(175, 1, 349),
(177, 1, 357),
(178, 1, 358),
(179, 1, 356),
(180, 1, 362),
(181, 1, 363),
(182, 1, 364),
(183, 1, 365),
(184, 1, 366),
(185, 1, 367),
(186, 1, 359),
(187, 1, 360),
(188, 1, 361),
(189, 1, 368),
(190, 1, 369),
(191, 1, 370),
(192, 1, 371),
(193, 1, 372),
(194, 1, 373),
(195, 1, 374),
(196, 1, 375),
(197, 1, 376),
(198, 1, 377),
(199, 1, 378),
(200, 1, 379),
(201, 1, 380),
(202, 1, 381),
(203, 1, 382),
(209, 1, 388),
(210, 1, 389),
(211, 1, 390),
(212, 1, 391),
(213, 1, 392),
(214, 1, 393),
(215, 1, 394),
(216, 1, 395),
(217, 3, 254),
(218, 3, 382),
(219, 3, 388),
(220, 3, 389),
(221, 3, 376),
(222, 3, 377),
(223, 3, 378),
(224, 3, 390),
(225, 3, 391),
(226, 3, 392),
(227, 3, 395),
(228, 1, 397);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_menu`
--

CREATE TABLE `role_menu` (
  `id` int(11) UNSIGNED NOT NULL,
  `role_id` int(11) UNSIGNED NOT NULL,
  `menu_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `role_menu`
--

INSERT INTO `role_menu` (`id`, `role_id`, `menu_id`) VALUES
(62, 1, 28),
(82, 1, 15),
(83, 1, 19),
(85, 1, 16),
(86, 1, 18),
(87, 1, 17),
(88, 3, 28),
(89, 3, 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `token_peruri`
--

CREATE TABLE `token_peruri` (
  `id` int(11) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `expired_time` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `token_peruri`
--

INSERT INTO `token_peruri` (`id`, `token`, `expired_time`, `created_at`, `created_by`) VALUES
(0, 'eyJraWQiOiJzc29zIiwiYWxnIjoiUlMyNTYifQ.eyJzdWIiOiJBZG1pbmlzdHJhdG9yIiwiYXVkIjoiUGVydXJpIiwibmJmIjoxN', '2022-11-04 00:06:37', '2022-11-02 12:07:35', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(25) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) UNSIGNED NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `login_token` varchar(255) DEFAULT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `username`, `password`, `role_id`, `photo_url`, `login_token`, `is_active`) VALUES
(1, 'Developer Aldy', 'dev@mail.com', '0882009714993', 'dev', '$2y$10$3gmvdMxrHcumWLn8jIwu6.sDyE6dGMnU7r6MbWoFO/VjIKxulYf.O', 1, '', '1_2022-11-13 13:49:55_qhaEcYwyK3iRUF2lWmTp', 1),
(6, 'admin', 'admin@adminmail.com', '085158116223', 'admin', '$2y$10$npb/mF2KvP1IJPEQ5.VCZOcwk5Nt9wviJsUbs7tS8hxEVXono4wXO', 3, NULL, NULL, 0),
(8, 'alldy', 'aldyanugrah@gmail.com', '085121433123', 'alldy', '$2y$10$TGvQvSZS7R95i72JBRJ8celUL.bnx90BzCqaYrINTcn6z51.J0DkO', 3, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `document_process`
--
ALTER TABLE `document_process`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `document_process_detail`
--
ALTER TABLE `document_process_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_process_detail_FK` (`id_document`);

--
-- Indeks untuk tabel `file_contents`
--
ALTER TABLE `file_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_contents_FK` (`file_id`);

--
-- Indeks untuk tabel `file_upload`
--
ALTER TABLE `file_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_parent_id_foreign` (`parent_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role_action`
--
ALTER TABLE `role_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_action_role_id_foreign` (`role_id`),
  ADD KEY `role_action_action_id_foreign` (`action_id`);

--
-- Indeks untuk tabel `role_menu`
--
ALTER TABLE `role_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_menu_role_id_foreign` (`role_id`),
  ADD KEY `role_menu_menu_id_foreign` (`menu_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `action`
--
ALTER TABLE `action`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=398;

--
-- AUTO_INCREMENT untuk tabel `document_process`
--
ALTER TABLE `document_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `document_process_detail`
--
ALTER TABLE `document_process_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `file_contents`
--
ALTER TABLE `file_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `file_upload`
--
ALTER TABLE `file_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `role_action`
--
ALTER TABLE `role_action`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT untuk tabel `role_menu`
--
ALTER TABLE `role_menu`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `document_process_detail`
--
ALTER TABLE `document_process_detail`
  ADD CONSTRAINT `document_process_detail_FK` FOREIGN KEY (`id_document`) REFERENCES `document_process` (`id`);

--
-- Ketidakleluasaan untuk tabel `file_contents`
--
ALTER TABLE `file_contents`
  ADD CONSTRAINT `file_contents_FK` FOREIGN KEY (`file_id`) REFERENCES `file_upload` (`id`);

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_action`
--
ALTER TABLE `role_action`
  ADD CONSTRAINT `role_action_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `action` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_action_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_menu`
--
ALTER TABLE `role_menu`
  ADD CONSTRAINT `role_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_menu_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
