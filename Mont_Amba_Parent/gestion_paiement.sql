-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 21 mai 2026 à 12:16
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_paiement`
--

-- --------------------------------------------------------

--
-- Structure de la table `calendriers`
--

DROP TABLE IF EXISTS `calendriers`;
CREATE TABLE IF NOT EXISTS `calendriers` (
  `id_calendrier` int NOT NULL AUTO_INCREMENT,
  `jour` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dates` date NOT NULL,
  `evenement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_calendrier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `eleves`
--

DROP TABLE IF EXISTS `eleves`;
CREATE TABLE IF NOT EXISTS `eleves` (
  `id_eleve` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classe` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frais_total` int NOT NULL,
  `frais_paye` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_eleve`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
CREATE TABLE IF NOT EXISTS `evenements` (
  `id_evenement` int NOT NULL AUTO_INCREMENT,
  `classe_concernee` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frais_transport` int NOT NULL,
  `frais_entree` int NOT NULL,
  `frais_encadrement` int NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_evenement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

DROP TABLE IF EXISTS `paiements`;
CREATE TABLE IF NOT EXISTS `paiements` (
  `id_paiement` int NOT NULL AUTO_INCREMENT,
  `categorie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motif` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` int NOT NULL,
  `mode_paiement` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int DEFAULT NULL,
  `id_eleve` int DEFAULT NULL,
  `id_evenement` int DEFAULT NULL,
  PRIMARY KEY (`id_paiement`),
  KEY `id_user` (`id_user`),
  KEY `id_eleve` (`id_eleve`),
  KEY `id_evenement` (`id_evenement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD CONSTRAINT `eleves_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD CONSTRAINT `paiements_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `paiements_ibfk_2` FOREIGN KEY (`id_eleve`) REFERENCES `eleves` (`id_eleve`),
  ADD CONSTRAINT `paiements_ibfk_3` FOREIGN KEY (`id_evenement`) REFERENCES `evenements` (`id_evenement`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
