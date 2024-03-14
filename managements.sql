-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 14 mars 2024 à 11:19
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `managements`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `reference_mouvement` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `compte_PCOP` int DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` text COLLATE utf8mb4_unicode_ci,
  `conditionnement` text COLLATE utf8mb4_unicode_ci,
  `unite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_peremption` date DEFAULT NULL,
  `provenance` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entree` int DEFAULT NULL,
  `etat_article` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `articles_service_id_foreign` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `service_id`, `reference_mouvement`, `compte_PCOP`, `reference`, `designation`, `conditionnement`, `unite`, `date_peremption`, `provenance`, `entree`, `etat_article`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'BL/MARCHE 07/22', 6111, '6111-49', 'Agenda 2021_2022 GM', NULL, 'Unité', NULL, 'RASOANORO Volaniaina Nirina cecilia', 3, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:42', NULL),
(2, 2, 'BL/MARCHE 07/22', 6111, '6111-01', 'Agenda 2023-2024 PM,NL', NULL, 'Unité', NULL, 'RASOANORO Volaniaina Nirina cecilia', 3, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:42', NULL),
(3, 3, 'BL/MARCHE 07/22', 6111, '6111-48', 'Agrafe 24/6 GM', NULL, 'Unité', NULL, 'RASOANORO Volaniaina Nirina cecilia', 9, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:42', NULL),
(4, 3, 'BL 007/2022', 6114, '6114-14', 'Brosse WC avec socle', NULL, 'Unité', NULL, 'RAVONIARISOA Estelle', 7, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:42', NULL),
(5, 1, 'BL 007/2022', 6114, '6114-19', 'Canard WC', NULL, 'Unité', NULL, 'RAVONIARISOA Estelle', 4, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:42', NULL),
(6, 2, 'BL 007/2022', 6114, '6114-05', 'Chamoisine', NULL, 'Flacon', NULL, 'RAVONIARISOA Estelle', 4, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:42', NULL),
(7, 3, 'BL 007/2022', 6114, '6114-04', 'Chiffon microfibre', NULL, 'Paquet/10', NULL, 'RAVONIARISOA Estelle', 6, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:42', NULL),
(8, 1, 'BL/MARCHE 07/22', 6111, '6111-49', 'Agenda 2021_2022 GM', NULL, 'Unité', NULL, 'RASOANORO Volaniaina Nirina cecilia', 3, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:52', '2024-03-11 08:09:52', NULL),
(9, 2, 'BL/MARCHE 07/22', 6111, '6111-01', 'Agenda 2023-2024 PM,NL', NULL, 'Unité', NULL, 'RASOANORO Volaniaina Nirina cecilia', 3, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:52', '2024-03-11 08:09:52', NULL),
(10, 3, 'BL/MARCHE 07/22', 6111, '6111-48', 'Agrafe 24/6 GM', NULL, 'Unité', NULL, 'RASOANORO Volaniaina Nirina cecilia', 9, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:52', '2024-03-11 08:09:52', NULL),
(11, 3, 'BL 007/2022', 6114, '6114-14', 'Brosse WC avec socle', NULL, 'Unité', NULL, 'RAVONIARISOA Estelle', 7, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:52', '2024-03-11 08:09:52', NULL),
(12, 1, 'BL 007/2022', 6114, '6114-19', 'Canard WC', NULL, 'Unité', NULL, 'RAVONIARISOA Estelle', 4, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:52', '2024-03-11 08:09:52', NULL),
(13, 2, 'BL 007/2022', 6114, '6114-05', 'Chamoisine', NULL, 'Flacon', NULL, 'RAVONIARISOA Estelle', 4, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:52', '2024-03-11 08:09:52', NULL),
(14, 3, 'BL 007/2022', 6114, '6114-04', 'Chiffon microfibre', NULL, 'Paquet/10', NULL, 'RAVONIARISOA Estelle', 6, 'Neuf', 2, 2, NULL, '2024-03-11 08:09:52', '2024-03-11 08:09:52', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `autorisation_absences`
--

DROP TABLE IF EXISTS `autorisation_absences`;
CREATE TABLE IF NOT EXISTS `autorisation_absences` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `personnel_id` bigint UNSIGNED NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `jour_prise` int NOT NULL,
  `jour_reste` int NOT NULL,
  `motif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'stand by',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `autorisation_absences_personnel_id_foreign` (`personnel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `autorisation_absences`
--

INSERT INTO `autorisation_absences` (`id`, `personnel_id`, `date_debut`, `date_fin`, `jour_prise`, `jour_reste`, `motif`, `observation`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '2024-02-12', '2024-02-14', 0, 15, 'rien', 'rien', 'refused', 2, 2, NULL, '2024-02-09 00:47:06', '2024-02-09 07:20:35', NULL),
(2, 2, '2024-02-12', '2024-02-14', 3, 12, 'RIEN', 'EI', 'validated', 2, 2, NULL, '2024-02-09 07:33:44', '2024-02-09 07:33:49', NULL),
(3, 2, '2024-02-19', '2024-02-21', 0, 12, 'rien', 'rien', 'refused', 2, 2, NULL, '2024-02-09 07:39:38', '2024-02-09 07:39:44', NULL),
(4, 3, '2024-02-12', '2024-02-14', 0, 15, 'rien', 'rien', 'refused', 2, 2, NULL, '2024-02-09 07:55:15', '2024-02-11 04:24:54', NULL),
(5, 3, '2024-02-12', '2024-02-14', 3, 12, 'erz', 'erze', 'validated', 2, 2, NULL, '2024-02-11 04:25:29', '2024-02-11 04:25:37', NULL),
(6, 2, '2024-06-26', '2024-06-28', 3, 9, 'mala', 'mal', 'validated', 2, 2, NULL, '2024-02-11 06:03:08', '2024-02-11 06:03:13', NULL),
(8, 3, '2024-07-15', '2024-07-17', 3, 9, 'df', 'etrze', 'validated', 2, 2, NULL, '2024-02-11 08:13:22', '2024-02-11 08:13:31', NULL),
(9, 4, '2024-05-13', '2024-05-15', 3, 12, 'GF', 'DFG', 'validated', 2, 2, NULL, '2024-02-11 09:54:47', '2024-02-11 09:54:51', NULL),
(10, 5, '2024-02-12', '2024-02-14', 0, 15, 'SDFS', 'SF', 'validated', 2, 2, NULL, '2024-02-11 10:15:42', '2024-02-27 11:02:58', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `conge_cumules`
--

DROP TABLE IF EXISTS `conge_cumules`;
CREATE TABLE IF NOT EXISTS `conge_cumules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `personnel_id` bigint UNSIGNED NOT NULL,
  `annee` year DEFAULT NULL,
  `jour_total` int DEFAULT NULL,
  `jour_prise` int DEFAULT NULL,
  `jour_reste` int DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `conge_cumules_personnel_id_foreign` (`personnel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `conge_cumules`
--

INSERT INTO `conge_cumules` (`id`, `personnel_id`, `annee`, `jour_total`, `jour_prise`, `jour_reste`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 2, 2020, 14, 0, 14, 2, 2, NULL, '2024-01-28 12:23:46', '2024-02-08 09:22:44', NULL),
(4, 2, 2021, 12, 0, 12, 2, 2, NULL, '2024-02-08 00:21:05', '2024-02-08 09:16:34', NULL),
(5, 4, 2020, 30, 0, 30, 2, 2, NULL, '2024-02-11 09:54:13', '2024-02-11 09:54:13', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `conge_prises`
--

DROP TABLE IF EXISTS `conge_prises`;
CREATE TABLE IF NOT EXISTS `conge_prises` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `personnel_id` bigint UNSIGNED NOT NULL,
  `annee` int NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `nombre_jour` int NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `conge_prises_personnel_id_foreign` (`personnel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `conge_prises`
--

INSERT INTO `conge_prises` (`id`, `personnel_id`, `annee`, `date_debut`, `date_fin`, `nombre_jour`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 2020, '2024-02-08', '2024-02-11', 4, 2, 2, 2, '2024-02-07 08:55:18', '2024-02-08 09:11:11', '2024-02-08 09:11:11'),
(2, 2, 2021, '2024-02-09', '2024-02-11', 3, 2, 2, 2, '2024-02-08 09:13:51', '2024-02-08 09:16:34', '2024-02-08 09:16:34'),
(3, 2, 2020, '2024-02-09', '2024-02-13', 5, 2, 2, 2, '2024-02-08 09:18:51', '2024-02-08 09:19:43', '2024-02-08 09:19:43'),
(4, 2, 2020, '2024-02-09', '2024-02-16', 8, 2, 2, 2, '2024-02-08 09:20:33', '2024-02-08 09:22:44', '2024-02-08 09:22:44');

-- --------------------------------------------------------

--
-- Structure de la table `cotisation_socials`
--

DROP TABLE IF EXISTS `cotisation_socials`;
CREATE TABLE IF NOT EXISTS `cotisation_socials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `mission_id` bigint UNSIGNED NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'non payé',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cotisation_socials_mission_id_foreign` (`mission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `demande_articles`
--

DROP TABLE IF EXISTS `demande_articles`;
CREATE TABLE IF NOT EXISTS `demande_articles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `demande_id` bigint UNSIGNED DEFAULT NULL,
  `personnel_id` bigint UNSIGNED DEFAULT NULL,
  `article_id` bigint UNSIGNED DEFAULT NULL,
  `quantity` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'En attente',
  `livrer` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Non',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `demande_articles`
--

INSERT INTO `demande_articles` (`id`, `demande_id`, `personnel_id`, `article_id`, `quantity`, `status`, `livrer`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, NULL, 3, 1, 1, 'Valider', 'Non', 2, 2, NULL, '2024-03-11 08:32:48', '2024-03-11 08:38:28', NULL),
(3, NULL, 3, 1, 1, 'Valider', 'Non', 2, 2, NULL, '2024-03-13 07:32:55', '2024-03-13 07:34:38', NULL),
(4, NULL, 3, 2, 1, 'Valider', 'Non', 2, 2, NULL, '2024-03-13 07:32:58', '2024-03-13 07:34:41', NULL),
(5, NULL, 4, 1, 1, 'Valider', 'Non', 3, 3, NULL, '2024-03-13 10:19:38', '2024-03-13 10:19:49', NULL),
(6, NULL, 10, 1, 1, 'Valider', 'Non', 6, 2, NULL, '2024-03-13 13:29:22', '2024-03-14 08:14:56', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `etat_stocks`
--

DROP TABLE IF EXISTS `etat_stocks`;
CREATE TABLE IF NOT EXISTS `etat_stocks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` bigint UNSIGNED NOT NULL,
  `entree` bigint UNSIGNED DEFAULT NULL,
  `sortie` bigint UNSIGNED DEFAULT NULL,
  `stock_final` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `etat_stocks_article_id_foreign` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etat_stocks`
--

INSERT INTO `etat_stocks` (`id`, `article_id`, `entree`, `sortie`, `stock_final`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 6, 1, 3, 2, 6, NULL, '2024-03-11 08:09:42', '2024-03-13 13:29:22', NULL),
(2, 2, 6, 1, 5, 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-13 07:32:58', NULL),
(3, 3, 18, 0, 18, 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:52', NULL),
(4, 4, 14, 0, 14, 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:52', NULL),
(5, 5, 8, 0, 8, 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:52', NULL),
(6, 6, 8, 0, 8, 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:52', NULL),
(7, 7, 12, 0, 12, 2, 2, NULL, '2024-03-11 08:09:42', '2024-03-11 08:09:52', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_01_26_014527_create_services_table', 1),
(7, '2024_01_27_191929_create_permission_tables', 1),
(8, '2024_01_28_064536_create_personnels_table', 1),
(9, '2024_01_28_130920_create_conge_cumules_table', 2),
(10, '2024_01_28_144301_create_repos_medicals_table', 3),
(11, '2024_01_28_172406_create_missions_table', 4),
(12, '2024_01_29_055937_create_cotisation_socials_table', 5),
(13, '2024_01_29_093058_create_conge_prises_table', 6),
(14, '2024_02_08_071838_create_autorisation_absences_table', 7),
(15, '2024_02_26_121633_create_stock_services_table', 8),
(16, '2024_03_03_145615_add_service_to_users_table', 9),
(17, '2024_03_03_165702_create_articles_table', 10),
(18, '2024_03_04_040317_create_etat_stocks_table', 11),
(19, '2024_03_04_074908_create_sortie_articles_table', 12),
(21, '2024_03_04_082036_create_demande_articles_table', 13),
(22, '2024_03_05_185709_add_user_id_to_personnels_table', 14);

-- --------------------------------------------------------

--
-- Structure de la table `missions`
--

DROP TABLE IF EXISTS `missions`;
CREATE TABLE IF NOT EXISTS `missions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `personnel_id` bigint UNSIGNED DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `observation` text COLLATE utf8mb4_unicode_ci,
  `lieu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_jour` int DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `missions_personnel_id_foreign` (`personnel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `missions`
--

INSERT INTO `missions` (`id`, `personnel_id`, `date_debut`, `date_fin`, `observation`, `lieu`, `nombre_jour`, `type`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '2024-01-29', '2024-02-02', 'test', 'antsirabe', 4, 'PTF', 2, 2, 2, '2024-01-28 15:07:09', '2024-01-29 04:00:06', '2024-01-29 04:00:06'),
(2, 2, '2024-01-29', '2024-02-02', 'test', 'Antsirabe', 4, 'PTF', 2, 2, 2, '2024-01-29 04:00:32', '2024-03-01 07:47:11', '2024-03-01 07:47:11'),
(3, 3, '2024-02-05', '2024-02-09', 'tset', 'Tamatave', 4, 'OR', 2, 2, NULL, '2024-01-29 04:07:08', '2024-01-29 04:34:41', NULL),
(4, 3, '2024-02-05', '2024-02-09', 'TSET', 'TAMATAVE', 4, 'PTF', 2, 2, NULL, '2024-01-29 10:14:46', '2024-01-29 10:14:46', NULL),
(5, 2, '2024-02-12', '2024-02-16', 'test', 'Fenerive Est', 4, 'PTF', 2, 2, 2, '2024-02-05 10:16:17', '2024-03-01 13:52:50', '2024-03-01 13:52:50'),
(6, 2, '2024-02-28', '2024-02-29', 'drts', 'abc', 1, 'PTF', 2, 2, 2, '2024-02-27 11:01:07', '2024-03-01 08:06:59', '2024-03-01 08:06:59');

-- --------------------------------------------------------

--
-- Structure de la table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(6, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(7, 'App\\Models\\User', 7),
(8, 'App\\Models\\User', 8),
(8, 'App\\Models\\User', 9),
(8, 'App\\Models\\User', 10),
(8, 'App\\Models\\User', 11),
(8, 'App\\Models\\User', 12),
(8, 'App\\Models\\User', 13),
(8, 'App\\Models\\User', 14),
(8, 'App\\Models\\User', 15),
(8, 'App\\Models\\User', 16),
(8, 'App\\Models\\User', 17),
(8, 'App\\Models\\User', 18),
(8, 'App\\Models\\User', 19),
(8, 'App\\Models\\User', 20),
(8, 'App\\Models\\User', 21),
(8, 'App\\Models\\User', 22);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'services.*', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(2, 'personnels.*', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(3, 'conge.*', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(4, 'repos-medical.*', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(5, 'mission.*', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(6, 'authorisation-absence.*', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(7, 'Cotisation.*', 'web', '2024-03-13 15:27:51', '2024-03-13 14:27:59'),
(8, 'Article.*', 'web', '2024-03-13 15:28:49', '2024-03-13 14:28:55');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personnels`
--

DROP TABLE IF EXISTS `personnels`;
CREATE TABLE IF NOT EXISTS `personnels` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cin` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_cin` date DEFAULT NULL,
  `com_cin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duplicata` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_duplicata` date DEFAULT NULL,
  `ddn` date DEFAULT NULL,
  `age` int DEFAULT NULL,
  `genre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fonction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matricule` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indice` int DEFAULT NULL,
  `corps` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_effet_avancement` date DEFAULT NULL,
  `fin_date_effet_avancement` date DEFAULT NULL,
  `classe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `echelon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personnels_cin_unique` (`cin`),
  KEY `personnels_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personnels`
--

INSERT INTO `personnels` (`id`, `user_id`, `service_id`, `nom`, `prenom`, `cin`, `date_cin`, `com_cin`, `duplicata`, `date_duplicata`, `ddn`, `age`, `genre`, `adresse`, `email`, `contact`, `fonction`, `matricule`, `indice`, `corps`, `grade`, `date_effet_avancement`, `fin_date_effet_avancement`, `classe`, `echelon`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 2, 'Alias incididunt odi', 'Itaque velit laborio', '342 423 423 423', '2022-02-19', 'Quos enim iste conse', NULL, '2001-11-06', '1996-06-12', 28, 'Féminin', 'Qui quidem proident', '	\nwest.lukas@example.com', '+342 34 234 23 42', 'Anim modi esse lore', '234 242', 65, 'Nesciunt aut pariat', 'Id sed nobis non mol', '2011-10-18', '1971-10-02', 'Est voluptas perfere', 'Libero nihil qui com', 2, 2, 2, '2024-01-28 09:32:33', '2024-01-28 09:32:50', '2024-01-28 09:32:50'),
(2, NULL, 1, 'RAKOTO', 'Kapoaka', '234 234 234 234', '1979-08-05', 'Quo quo omnis esse m', 'on', '1970-04-30', '1979-09-30', 45, 'Masculin', 'Et irure suscipit et', 'moguk@mailinator.com', '+423 42 342 34 12', 'Minim anim dolores e', '234 242', 58, 'Consequatur occaeca', 'Quia eaque eiusmod v', '1983-05-15', '2018-05-09', 'Soluta consequatur', 'Ut dicta odio quisqu', 2, 2, NULL, '2024-01-28 10:30:42', '2024-02-05 10:17:14', NULL),
(3, 2, 1, 'RAMANGASOAVINA', 'Iloniaina Jan Lucien', '424 234 234 234', '2005-11-09', 'Cumque incidunt nes', 'on', '1975-07-19', '2017-10-22', 7, 'Féminin', 'Est amet accusamus', 'ilocacsu@gmail.com', '+423 42 342 34 34', 'Sapiente nesciunt a', '424 234', 3, 'Laudantium commodi', 'Ea porro et doloribu', '2022-12-18', '1986-09-21', 'Numquam incidunt no', 'Mollit ex excepturi', 2, 2, NULL, '2024-01-28 10:37:14', '2024-02-05 10:15:14', NULL),
(4, 3, 4, 'ROLLAND', 'Avilahy', '242 342 342 423', '1990-03-04', 'FSFSDFSD', NULL, NULL, '1990-03-12', 34, 'Féminin', 'Possimus sequi ut v', 'kaquxuz@mailinator.com', '+345 35 345 34 53', 'Eos culpa ut est', '324 234', 3, 'FSDFSD', 'DFSDFS', NULL, NULL, 'RZ', 'SDFS', 2, 2, NULL, '2024-02-11 09:53:48', '2024-02-11 09:53:48', NULL),
(5, NULL, 3, 'Blanditiis et recusa', 'Eaque omnis libero a', '324 242 342 342', '1984-02-05', 'Quas esse et ea comm', NULL, '1984-11-12', '1971-07-26', 53, 'Féminin', 'Molestias lorem solu', 'cyqedywy@mailinator.com', '+234 23 424 23 42', 'Cum rem perspiciatis', '324 234', 36, 'Et sed necessitatibu', 'Nostrud officia qui', '1976-08-13', '1995-10-24', 'Atque esse ut in as', 'Atque excepteur eos', 2, 2, NULL, '2024-02-11 10:15:18', '2024-02-11 10:15:18', NULL),
(10, 6, 1, 'RAKOTONANDRASANA', 'Minosoa Haingo Lalaina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Féminin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 3, NULL, '2024-03-13 12:15:57', '2024-03-13 12:15:57', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `repos_medicals`
--

DROP TABLE IF EXISTS `repos_medicals`;
CREATE TABLE IF NOT EXISTS `repos_medicals` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `personnel_id` bigint UNSIGNED DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `nombre_jour` int DEFAULT NULL,
  `motif` text COLLATE utf8mb4_unicode_ci,
  `observation` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `repos_medicals_personnel_id_foreign` (`personnel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `repos_medicals`
--

INSERT INTO `repos_medicals` (`id`, `personnel_id`, `date_debut`, `date_fin`, `nombre_jour`, `motif`, `observation`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, '2024-01-04', '2024-01-06', 2, 'etste', 'tsere', 2, 2, 2, '2024-01-28 12:20:10', '2024-01-28 12:21:41', '2024-01-28 12:21:41');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(2, 'Ressource Humaine', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(3, 'Depositaire Comptable', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(4, 'SSE', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(5, 'SMF', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(6, 'SPSS', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(7, 'Chefferie', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(8, 'User', 'web', '2024-01-28 05:58:49', '2024-01-28 05:58:49');

-- --------------------------------------------------------

--
-- Structure de la table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 3);

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `nom`, `description`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'SPSS', 'SPSS', 2, 2, NULL, NULL, '2024-01-28 09:31:14', '2024-01-28 09:31:14'),
(2, 'SSE', 'Suivi', 2, 2, NULL, NULL, '2024-01-28 09:31:21', '2024-01-28 09:31:21'),
(3, 'SMF', 'SMF', 2, 2, NULL, NULL, '2024-02-05 10:17:31', '2024-02-05 10:17:31'),
(4, 'CHEFFERIE', 'CHEFFERIE', 2, 2, NULL, NULL, '2024-02-05 10:19:40', '2024-02-05 10:19:40'),
(5, 'TEST', 'TEST', 2, 2, NULL, NULL, '2024-02-05 10:20:18', '2024-02-05 10:20:18');

-- --------------------------------------------------------

--
-- Structure de la table `sortie_articles`
--

DROP TABLE IF EXISTS `sortie_articles`;
CREATE TABLE IF NOT EXISTS `sortie_articles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` bigint UNSIGNED NOT NULL,
  `personnel_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sortie_articles_article_id_foreign` (`article_id`),
  KEY `sortie_articles_personnel_id_foreign` (`personnel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stock_services`
--

DROP TABLE IF EXISTS `stock_services`;
CREATE TABLE IF NOT EXISTS `stock_services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id` bigint UNSIGNED NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_article` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_initial` int UNSIGNED NOT NULL,
  `entree` int UNSIGNED DEFAULT NULL,
  `sortie` int UNSIGNED DEFAULT NULL,
  `stock_final` int UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_services_service_id_foreign` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_service_id_foreign` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `service_id`, `remember_token`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Ms. Luz Yundt', 'west.lukas@example.com', '2024-01-28 05:58:49', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'Super Admin', 2, '7ZDOrCCLfpMYq2FuIuB2Bu5v6DGtKJyg3RuztbDxNPq5iDzEn6cxEGfE97rc', NULL, 1, NULL, NULL, '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(2, 'Iloniaina', 'ilocacsu@gmail.com', '2024-01-28 05:58:49', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'Super Admin', 1, 'aGly2GN0Z4Xksrov62ZLsw03nWrS0MPB0LoQ5heAUrvYWPWqIYKCSpiOKFbh', NULL, 2, NULL, NULL, '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(3, 'ROLLAND Avilahy', 'avilahyr9y@gmail.com', '2024-01-28 05:58:49', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'Chefferie', 4, 'OcTETWELfm9ORK6lzfDTtxo7RixBDZATsl8eGCgo9WeW7xlIUbpsmpBZkctC', NULL, 3, NULL, NULL, '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(4, 'Dr Mahefa', 'mahefarat@yahoo.fr', '2024-01-28 05:58:49', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'SSE', NULL, 'ryWsEwwzA7', NULL, NULL, NULL, NULL, '2024-01-28 05:58:49', '2024-01-28 05:58:49'),
(5, 'Dr. Franck', 'maherinirinafranck@gmail.com', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'i9Fc3vDiAK', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(6, 'Mme Haingo', 'haingo@gmail.com', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'Ressource Humaine', 1, '848tLulMNUiJShlK060fCfbPPdEufiBSxLnNRbbMZJhByuRYOzv3oJDmsiSH', NULL, 6, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(7, 'Margarete Purdy', 'lonny89@example.org', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'SMF', NULL, 'W0xmOMOABI', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(8, 'Miss Ophelia Wintheiser', 'miller71@example.com', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'fUHEGIDwgm', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(9, 'Delphine Beier', 'vincent.goodwin@example.org', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'WxBTl19Dcn', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(10, 'Raleigh Kohler', 'uklein@example.com', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'sHpC68rMwTKAs18LUlntMbzueTQhSDwQzd4siUBCkouJAIVPBUJxxZ0b7ASM', NULL, 10, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(11, 'Branson Medhurst', 'nfahey@example.net', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'IZvJWjofOk', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(12, 'Salvador Kunze', 'tania75@example.org', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'X5qqKe7k9w', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(13, 'Mrs. Annalise Ryan', 'lessie.lakin@example.net', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'sxoNBd7VD7', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(14, 'Prof. Benton Sipes PhD', 'rodolfo.hintz@example.com', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'Pe7xEdSCyhjYGLosgrYpNPH1mjG11RiOuTgzYew1m7j3RjO2EMl0D8obFKmL', NULL, 14, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(15, 'Eloise Reilly', 'sunny04@example.com', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'Y63SRoDfJY', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(16, 'Miss Anjali Klein', 'feeney.lisa@example.com', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, '762CR99ZSs', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(17, 'Garnet O\'Keefe', 'crystal39@example.org', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'VmNEuWTn9k', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(18, 'Camron Luettgen', 'daniel.bethany@example.com', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'AG5xgiMuV8', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(19, 'Fern Swift', 'buckridge.gennaro@example.org', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'tWQriSrA3i', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(20, 'Miss Lesly Fadel', 'wiegand.tess@example.org', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'WijeWfz1ey', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(21, 'Otha Wisoky', 'mann.ellsworth@example.net', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'oQoSBJMp8v', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50'),
(22, 'Orin Goldner', 'hessel.barrett@example.org', '2024-01-28 05:58:50', '$2y$12$qhzKIGiqyRiQw3PP0ViVeu3315AiSMV28J04jUy2.zSn79Da40rs.', 'User', NULL, 'P8vBUobgWm', NULL, NULL, NULL, NULL, '2024-01-28 05:58:50', '2024-01-28 05:58:50');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Contraintes pour la table `autorisation_absences`
--
ALTER TABLE `autorisation_absences`
  ADD CONSTRAINT `autorisation_absences_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnels` (`id`);

--
-- Contraintes pour la table `conge_cumules`
--
ALTER TABLE `conge_cumules`
  ADD CONSTRAINT `conge_cumules_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnels` (`id`);

--
-- Contraintes pour la table `conge_prises`
--
ALTER TABLE `conge_prises`
  ADD CONSTRAINT `conge_prises_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnels` (`id`);

--
-- Contraintes pour la table `cotisation_socials`
--
ALTER TABLE `cotisation_socials`
  ADD CONSTRAINT `cotisation_socials_mission_id_foreign` FOREIGN KEY (`mission_id`) REFERENCES `missions` (`id`);

--
-- Contraintes pour la table `etat_stocks`
--
ALTER TABLE `etat_stocks`
  ADD CONSTRAINT `etat_stocks_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`);

--
-- Contraintes pour la table `missions`
--
ALTER TABLE `missions`
  ADD CONSTRAINT `missions_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnels` (`id`);

--
-- Contraintes pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `personnels`
--
ALTER TABLE `personnels`
  ADD CONSTRAINT `personnels_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `repos_medicals`
--
ALTER TABLE `repos_medicals`
  ADD CONSTRAINT `repos_medicals_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnels` (`id`);

--
-- Contraintes pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sortie_articles`
--
ALTER TABLE `sortie_articles`
  ADD CONSTRAINT `sortie_articles_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `sortie_articles_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnels` (`id`);

--
-- Contraintes pour la table `stock_services`
--
ALTER TABLE `stock_services`
  ADD CONSTRAINT `stock_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
