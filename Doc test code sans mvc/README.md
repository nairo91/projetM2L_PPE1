Info base de données : 

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 04 mars 2025 à 07:57
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_football`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

DROP TABLE IF EXISTS `appartenir`;
CREATE TABLE IF NOT EXISTS `appartenir` (
  `idJoueur` int NOT NULL,
  `idEquipe` int NOT NULL,
  PRIMARY KEY (`idJoueur`,`idEquipe`),
  KEY `idEquipe` (`idEquipe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `appartenir`
--

INSERT INTO `appartenir` (`idJoueur`, `idEquipe`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(2, 9),
(2, 10),
(2, 11),
(3, 4),
(3, 16),
(3, 17);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `idEquipe` int NOT NULL AUTO_INCREMENT,
  `nomEquipe` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idEquipe`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`idEquipe`, `nomEquipe`) VALUES
(4, 'Marseille'),
(5, 'Real Madrid'),
(6, 'Bayern'),
(7, 'Barcelone'),
(8, 'Paris'),
(10, 'Manchester'),
(12, 'Liverpool'),
(17, 'Salzourg'),
(16, 'Lyon'),
(15, 'Botafogo');

-- --------------------------------------------------------

--
-- Structure de la table `impliquer`
--

DROP TABLE IF EXISTS `impliquer`;
CREATE TABLE IF NOT EXISTS `impliquer` (
  `idEquipe` int NOT NULL,
  `idTournois` int NOT NULL,
  PRIMARY KEY (`idEquipe`,`idTournois`),
  KEY `idTournois` (`idTournois`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `impliquer`
--

INSERT INTO `impliquer` (`idEquipe`, `idTournois`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(2, 1),
(2, 2),
(2, 3),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(3, 1),
(3, 2),
(3, 3),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(4, 1),
(4, 2),
(4, 3),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 25),
(4, 26),
(4, 27),
(4, 28),
(4, 29),
(4, 30),
(4, 31),
(4, 32),
(4, 33),
(5, 1),
(5, 2),
(5, 3),
(5, 5),
(5, 6),
(5, 7),
(5, 8),
(5, 9),
(5, 10),
(5, 11),
(5, 12),
(5, 13),
(5, 14),
(5, 15),
(5, 16),
(5, 17),
(5, 18),
(5, 19),
(5, 20),
(5, 21),
(5, 22),
(5, 23),
(5, 24),
(5, 25),
(5, 26),
(5, 27),
(5, 28),
(5, 29),
(5, 30),
(5, 31),
(5, 32),
(5, 33),
(6, 1),
(6, 2),
(6, 3),
(6, 5),
(6, 6),
(6, 7),
(6, 8),
(6, 9),
(6, 10),
(6, 11),
(6, 12),
(6, 13),
(6, 14),
(6, 15),
(6, 16),
(6, 17),
(6, 18),
(6, 19),
(6, 20),
(6, 21),
(6, 22),
(6, 23),
(6, 24),
(6, 25),
(6, 26),
(6, 27),
(6, 28),
(6, 29),
(6, 30),
(6, 31),
(6, 32),
(7, 1),
(7, 2),
(7, 3),
(7, 5),
(7, 6),
(7, 7),
(7, 8),
(7, 9),
(7, 10),
(7, 11),
(7, 12),
(7, 13),
(7, 14),
(7, 15),
(7, 16),
(7, 17),
(7, 18),
(7, 19),
(7, 20),
(7, 21),
(7, 22),
(7, 23),
(7, 24),
(7, 25),
(7, 26),
(7, 27),
(7, 28),
(7, 29),
(7, 30),
(7, 31),
(7, 32),
(8, 1),
(8, 2),
(8, 3),
(8, 5),
(8, 6),
(8, 7),
(8, 8),
(8, 9),
(8, 10),
(8, 11),
(8, 12),
(8, 13),
(8, 14),
(8, 15),
(8, 16),
(8, 17),
(8, 18),
(8, 19),
(8, 20),
(8, 21),
(8, 22),
(8, 23),
(8, 24),
(8, 25),
(8, 26),
(8, 27),
(8, 28),
(8, 29),
(8, 30),
(8, 31),
(8, 32),
(8, 33),
(9, 10),
(9, 11),
(10, 10),
(10, 11),
(10, 12),
(10, 13),
(10, 14),
(10, 15),
(10, 16),
(10, 17),
(10, 18),
(10, 19),
(10, 20),
(10, 21),
(10, 22),
(10, 23),
(10, 24),
(10, 25),
(10, 26),
(10, 27),
(10, 28),
(10, 29),
(10, 30),
(10, 31),
(10, 32),
(10, 33),
(12, 11),
(12, 12),
(12, 13),
(12, 14),
(12, 15),
(12, 16),
(12, 17),
(12, 18),
(12, 19),
(12, 20),
(12, 21),
(12, 22),
(12, 23),
(12, 24),
(12, 25),
(12, 26),
(12, 27),
(12, 28),
(12, 29),
(12, 30),
(12, 31),
(12, 32),
(12, 33),
(15, 12),
(15, 13),
(15, 14),
(15, 15),
(15, 16),
(15, 17),
(15, 18),
(15, 19),
(15, 20),
(15, 21),
(15, 22),
(15, 23),
(15, 24),
(15, 25),
(15, 26),
(15, 27),
(15, 28),
(15, 29),
(15, 30),
(15, 31),
(15, 33),
(16, 33),
(17, 32),
(17, 33);

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

DROP TABLE IF EXISTS `joueurs`;
CREATE TABLE IF NOT EXISTS `joueurs` (
  `idJoueur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `niveau` enum('DÃ©butant','Joueur occasionnel','Expert') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('utilisateur','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'utilisateur',
  PRIMARY KEY (`idJoueur`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `joueurs`
--

INSERT INTO `joueurs` (`idJoueur`, `nom`, `prenom`, `age`, `pseudo`, `niveau`, `mot_de_passe`, `role`) VALUES
(1, 'MIRONA', 'Orian', 21, 'CR7', 'Joueur occasionnel', 'goat', 'utilisateur'),
(2, 'MIRONA', 'Orian', 56, 'test', 'DÃ©butant', '123', 'utilisateur'),
(3, 'MIRONA', 'Orian', 21, 'admin', 'Expert', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `matchs`
--

DROP TABLE IF EXISTS `matchs`;
CREATE TABLE IF NOT EXISTS `matchs` (
  `idMatch` int NOT NULL AUTO_INCREMENT,
  `type_match` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_joueurs_presents` int DEFAULT NULL,
  `nombre_joueurs_recherches` int DEFAULT NULL,
  `ville` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idEquipe` int DEFAULT NULL,
  `idEquipe1` int DEFAULT NULL,
  `idEquipe2` int DEFAULT NULL,
  `phase` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idTournois` int DEFAULT NULL,
  `winner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomMatch` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scoreEquipe1` int DEFAULT '0',
  `scoreEquipe2` int DEFAULT '0',
  PRIMARY KEY (`idMatch`),
  KEY `fk_tournoi` (`idTournois`)
) ENGINE=MyISAM AUTO_INCREMENT=277 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `matchs`
--

INSERT INTO `matchs` (`idMatch`, `type_match`, `nombre_joueurs_presents`, `nombre_joueurs_recherches`, `ville`, `idEquipe`, `idEquipe1`, `idEquipe2`, `phase`, `idTournois`, `winner`, `nomMatch`, `scoreEquipe1`, `scoreEquipe2`) VALUES
(1, 'match grigny3', NULL, 3, 'efef', 1, NULL, NULL, NULL, NULL, NULL, 'Match 1', 0, 0),
(2, 'match grigny3', NULL, 3, 'efef', 2, NULL, NULL, NULL, NULL, NULL, 'Match 2', 0, 0),
(3, 'match Fleury', NULL, 3, 'efef', 3, NULL, NULL, NULL, NULL, NULL, 'Match 3', 0, 0),
(4, 'Quart de finale', NULL, NULL, NULL, NULL, 1, 2, 'Quart de finale', 7, NULL, 'Match 4', 0, 0),
(5, 'Quart de finale', NULL, NULL, NULL, NULL, 3, 4, 'Quart de finale', 7, NULL, 'Match 5', 0, 0),
(6, 'Quart de finale', NULL, NULL, NULL, NULL, 5, 6, 'Quart de finale', 7, NULL, 'Match 6', 0, 0),
(7, 'Quart de finale', NULL, NULL, NULL, NULL, 7, 8, 'Quart de finale', 7, NULL, 'Match 7', 0, 0),
(8, 'Quart de finale', NULL, NULL, NULL, NULL, 1, 2, 'Quart de finale', 8, '1', 'Match 8', 0, 0),
(9, 'Quart de finale', NULL, NULL, NULL, NULL, 3, 4, 'Quart de finale', 8, '4', 'Match 9', 0, 0),
(10, 'Quart de finale', NULL, NULL, NULL, NULL, 5, 6, 'Quart de finale', 8, '5', 'Match 10', 0, 0),
(11, 'Quart de finale', NULL, NULL, NULL, NULL, 7, 8, 'Quart de finale', 8, '7', 'Match 11', 0, 0),
(12, 'Quart de finale', NULL, NULL, NULL, NULL, 1, 2, 'Quart de finale', 9, '2', 'Match 12', 0, 0),
(13, 'Quart de finale', NULL, NULL, NULL, NULL, 3, 4, 'Quart de finale', 9, NULL, 'Match 13', 0, 0),
(14, 'Quart de finale', NULL, NULL, NULL, NULL, 5, 6, 'Quart de finale', 9, '6', 'Match 14', 0, 0),
(15, 'Quart de finale', NULL, NULL, NULL, NULL, 7, 8, 'Quart de finale', 9, NULL, 'Match 15', 0, 0),
(16, 'match Fleury', NULL, 3, 'efef', 9, NULL, NULL, NULL, NULL, NULL, 'Match 16', 0, 0),
(17, 'match apagnan', NULL, 6, 'Marseille', 11, NULL, NULL, NULL, NULL, NULL, 'Match 17', 0, 0),
(18, 'Quart de finale', NULL, NULL, NULL, NULL, 3, 4, 'Quart de finale', 10, NULL, 'Match 18', 0, 0),
(19, 'Quart de finale', NULL, NULL, NULL, NULL, 5, 6, 'Quart de finale', 10, NULL, 'Match 19', 0, 0),
(20, 'Quart de finale', NULL, NULL, NULL, NULL, 7, 8, 'Quart de finale', 10, '7', 'Match 20', 0, 0),
(21, 'Quart de finale', NULL, NULL, NULL, NULL, 9, 10, 'Quart de finale', 10, NULL, 'Match 21', 0, 0),
(22, 'Amical', NULL, 10, 'Madrid', 13, NULL, NULL, NULL, NULL, NULL, 'Match 22', 0, 0),
(23, 'Amical', NULL, 10, 'Paris', 14, NULL, NULL, NULL, NULL, NULL, 'T1 VS GENG', 0, 0),
(24, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 11, '4', NULL, 0, 0),
(25, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 11, '6', NULL, 0, 0),
(26, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 9, 'Quart de finale', 11, '8', NULL, 0, 0),
(27, 'Quart de finale', NULL, NULL, NULL, NULL, 10, 12, 'Quart de finale', 11, '10', NULL, 0, 0),
(28, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 12, '4', NULL, 0, 0),
(29, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 12, '6', NULL, 0, 0),
(30, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 12, '8', NULL, 0, 0),
(31, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 12, '12', NULL, 0, 0),
(32, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 13, '4', NULL, 0, 0),
(33, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 13, '6', NULL, 0, 0),
(34, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 13, '8', NULL, 0, 0),
(35, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 13, '12', NULL, 0, 0),
(36, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(37, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(38, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(39, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(40, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(41, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(42, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(43, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(44, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(45, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(46, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(47, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(48, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(49, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(50, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(51, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(52, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(53, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(54, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(55, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(56, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(57, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(58, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(59, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(60, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(61, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(62, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(63, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(64, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(65, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(66, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(67, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(68, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(69, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(70, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(71, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(72, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(73, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(74, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(75, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(76, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(77, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(78, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(79, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(80, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(81, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(82, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(83, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(84, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(85, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(86, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(87, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(88, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(89, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(90, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(91, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(92, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(93, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(94, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(95, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(96, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(97, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(98, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(99, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(100, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(101, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(102, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(103, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(104, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(105, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(106, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(107, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(108, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(109, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(110, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(111, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(112, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(113, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(114, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(115, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(116, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(117, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(118, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(119, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(120, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(121, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 12, NULL, NULL, 0, 0),
(122, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(123, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Demi-finale', 13, NULL, NULL, 0, 0),
(124, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 12, NULL, NULL, 0, 0),
(125, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 12, NULL, NULL, 0, 0),
(126, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 13, '4', NULL, 0, 0),
(127, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 13, NULL, NULL, 0, 0),
(128, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 12, NULL, NULL, 0, 0),
(129, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 12, '8', NULL, 0, 0),
(130, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 13, NULL, NULL, 0, 0),
(131, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 13, NULL, NULL, 0, 0),
(132, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 12, '4', NULL, 0, 0),
(133, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 12, NULL, NULL, 0, 0),
(134, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 13, NULL, NULL, 0, 0),
(135, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 13, NULL, NULL, 0, 0),
(136, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 12, NULL, NULL, 0, 0),
(137, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 12, NULL, NULL, 0, 0),
(138, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Finale', 12, NULL, NULL, 0, 0),
(139, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 13, NULL, NULL, 0, 0),
(140, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 13, NULL, NULL, 0, 0),
(141, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 12, NULL, NULL, 0, 0),
(142, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 12, NULL, NULL, 0, 0),
(143, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 13, NULL, NULL, 0, 0),
(144, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 13, NULL, NULL, 0, 0),
(145, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 14, '4', NULL, 0, 0),
(146, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 14, '6', NULL, 0, 0),
(147, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 14, '8', NULL, 0, 0),
(148, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 14, '12', NULL, 0, 0),
(149, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 14, '4', NULL, 0, 0),
(150, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 14, NULL, NULL, 0, 0),
(151, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 14, NULL, NULL, 0, 0),
(152, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 14, '8', NULL, 0, 0),
(153, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 14, NULL, NULL, 0, 0),
(154, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 14, NULL, NULL, 0, 0),
(155, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Finale', 14, NULL, NULL, 0, 0),
(156, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 14, NULL, NULL, 0, 0),
(157, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 14, NULL, NULL, 0, 0),
(158, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 15, '4', NULL, 2, 0),
(159, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 15, '6', NULL, 1, 0),
(160, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 15, '8', NULL, 1, 0),
(161, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 15, '15', NULL, 0, 1),
(162, NULL, NULL, NULL, NULL, NULL, 8, 6, 'Demi-finale', 15, '8', NULL, 2, 0),
(163, NULL, NULL, NULL, NULL, NULL, 4, 12, 'Demi-finale', 15, '4', NULL, 1, 0),
(164, NULL, NULL, NULL, NULL, NULL, 4, 8, 'Finale', 15, '4', NULL, 1, 0),
(165, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 16, '5', NULL, 1, 2),
(166, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 16, '6', NULL, 1, 0),
(167, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 16, '8', NULL, 1, 0),
(168, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 16, '12', NULL, 1, 0),
(169, NULL, NULL, NULL, NULL, NULL, 12, 8, 'Demi-finale', 16, '12', NULL, 1, 0),
(170, NULL, NULL, NULL, NULL, NULL, 6, 5, 'Demi-finale', 16, '6', NULL, 1, 0),
(171, NULL, NULL, NULL, NULL, NULL, 12, 6, 'Finale', 16, '12', NULL, 1, 0),
(172, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 17, '4', NULL, 2, 0),
(173, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 17, '6', NULL, 3, 0),
(174, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 17, '8', NULL, 2, 1),
(175, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 17, '12', NULL, 3, 0),
(176, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 18, '4', NULL, 1, 0),
(177, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 18, '6', NULL, 2, 0),
(178, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 18, '8', NULL, 3, 0),
(179, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 18, '12', NULL, 4, 0),
(180, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 18, '4', NULL, 1, 0),
(181, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 18, '12', NULL, 0, 1),
(182, NULL, NULL, NULL, NULL, NULL, 4, 12, 'Finale', 18, '4', NULL, 1, 0),
(183, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 19, '4', NULL, 2, 0),
(184, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 19, '6', NULL, 3, 0),
(185, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 19, '8', NULL, 2, 1),
(186, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 19, '12', NULL, 3, 0),
(187, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 20, '4', NULL, 3, 0),
(188, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 20, '6', NULL, 2, 0),
(189, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 20, '8', NULL, 1, 0),
(190, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 20, '12', NULL, 2, 0),
(191, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 20, '4', NULL, 1, 0),
(192, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 20, '8', NULL, 2, 0),
(193, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 20, NULL, NULL, 0, 0),
(194, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 20, NULL, NULL, 0, 0),
(195, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 20, NULL, NULL, 0, 0),
(196, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 20, NULL, NULL, 0, 0),
(197, NULL, NULL, NULL, NULL, NULL, 4, 8, 'Finale', 20, '4', NULL, 3, 0),
(198, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 20, NULL, NULL, 0, 0),
(199, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 20, NULL, NULL, 0, 0),
(200, NULL, NULL, NULL, NULL, NULL, 4, 8, 'Finale', 20, NULL, NULL, 0, 0),
(201, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 21, '4', NULL, 1, 0),
(202, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 21, '6', NULL, 2, 0),
(203, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 21, '8', NULL, 3, 0),
(204, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 21, '12', NULL, 4, 0),
(205, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 22, '4', NULL, 0, 0),
(206, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 22, '6', NULL, 0, 0),
(207, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 22, '8', NULL, 0, 0),
(208, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 22, '12', NULL, 0, 0),
(209, NULL, NULL, NULL, NULL, NULL, 4, 12, 'Demi-finale', 22, '4', NULL, 0, 0),
(210, NULL, NULL, NULL, NULL, NULL, 8, 6, 'Demi-finale', 22, '8', NULL, 0, 0),
(211, NULL, NULL, NULL, NULL, NULL, 8, 4, 'Finale', 22, '8', NULL, 0, 0),
(212, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 23, '4', NULL, 1, 0),
(213, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 23, '6', NULL, 1, 0),
(214, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 23, '8', NULL, 1, 0),
(215, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 23, '12', NULL, 1, 0),
(216, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 24, '4', NULL, 2, 1),
(217, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 24, '6', NULL, 0, 0),
(218, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 24, '8', NULL, 0, 0),
(219, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 24, '12', NULL, 0, 0),
(220, NULL, NULL, NULL, NULL, NULL, 4, 8, 'Demi-finale', 24, '4', NULL, 0, 0),
(221, NULL, NULL, NULL, NULL, NULL, 12, 6, 'Demi-finale', 24, '12', NULL, 0, 0),
(222, NULL, NULL, NULL, NULL, NULL, 12, 4, 'Finale', 24, '12', NULL, 0, 0),
(223, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 25, '4', NULL, 2, 0),
(224, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 25, '6', NULL, 0, 2),
(225, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 25, '8', NULL, 2, 0),
(226, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 25, '12', NULL, 1, 0),
(227, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 26, '4', NULL, 1, 0),
(228, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 26, '6', NULL, 2, 0),
(229, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 26, '10', NULL, 0, 1),
(230, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 26, '12', NULL, 2, 0),
(231, NULL, NULL, NULL, NULL, NULL, 6, 4, 'Demi-finale', 26, '6', NULL, 1, 0),
(232, NULL, NULL, NULL, NULL, NULL, 10, 12, 'Demi-finale', 26, '10', NULL, 2, 0),
(233, NULL, NULL, NULL, NULL, NULL, 10, 6, 'Finale', 26, '10', NULL, 2, 0),
(234, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 27, '4', NULL, 2, 0),
(235, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 27, '6', NULL, 1, 0),
(236, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 27, '10', NULL, 0, 2),
(237, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 27, '12', NULL, 2, 0),
(238, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 28, '4', NULL, 2, 0),
(239, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 28, '7', NULL, 0, 2),
(240, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 28, '8', NULL, 2, 0),
(241, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 28, '12', NULL, 3, 0),
(242, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 29, '4', NULL, 1, 0),
(243, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 29, '6', NULL, 1, 0),
(244, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 29, '8', NULL, 1, 0),
(245, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 29, '12', NULL, 1, 0),
(246, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 30, '4', NULL, 2, 0),
(247, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 30, '6', NULL, 2, 0),
(248, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 30, '8', NULL, 1, 0),
(249, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 30, '12', NULL, 2, 0),
(250, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 30, NULL, NULL, 0, 0),
(251, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 30, NULL, NULL, 0, 0),
(252, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 30, NULL, NULL, 0, 0),
(253, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 30, NULL, NULL, 0, 0),
(254, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 30, NULL, NULL, 0, 0),
(255, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 30, NULL, NULL, 0, 0),
(256, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 31, '4', NULL, 2, 0),
(257, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 31, '6', NULL, 3, 0),
(258, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 31, '10', NULL, 0, 2),
(259, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 15, 'Quart de finale', 31, '12', NULL, 1, 0),
(260, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 31, '4', NULL, 2, 0),
(261, NULL, NULL, NULL, NULL, NULL, 10, 12, 'Demi-finale', 31, '10', NULL, 2, 0),
(262, NULL, NULL, NULL, NULL, NULL, 4, 10, 'Finale', 31, '4', NULL, 3, 0),
(263, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 32, '4', NULL, 2, 0),
(264, 'Quart de finale', NULL, NULL, NULL, NULL, 6, 7, 'Quart de finale', 32, '6', NULL, 2, 0),
(265, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 32, '8', NULL, 3, 0),
(266, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 17, 'Quart de finale', 32, '12', NULL, 2, 1),
(267, NULL, NULL, NULL, NULL, NULL, 4, 6, 'Demi-finale', 32, '4', NULL, 2, 0),
(268, NULL, NULL, NULL, NULL, NULL, 8, 12, 'Demi-finale', 32, '8', NULL, 1, 0),
(269, NULL, NULL, NULL, NULL, NULL, 4, 8, 'Finale', 32, '4', NULL, 2, 0),
(270, 'Quart de finale', NULL, NULL, NULL, NULL, 4, 5, 'Quart de finale', 33, '4', NULL, 2, 0),
(271, 'Quart de finale', NULL, NULL, NULL, NULL, 8, 10, 'Quart de finale', 33, '8', NULL, 2, 0),
(272, 'Quart de finale', NULL, NULL, NULL, NULL, 12, 17, 'Quart de finale', 33, '17', NULL, 0, 3),
(273, 'Quart de finale', NULL, NULL, NULL, NULL, 16, 15, 'Quart de finale', 33, '15', NULL, 0, 1),
(274, NULL, NULL, NULL, NULL, NULL, 4, 8, 'Demi-finale', 33, '4', NULL, 1, 0),
(275, NULL, NULL, NULL, NULL, NULL, 17, 15, 'Demi-finale', 33, '17', NULL, 1, 0),
(276, NULL, NULL, NULL, NULL, NULL, 4, 17, 'Finale', 33, '4', NULL, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

DROP TABLE IF EXISTS `participer`;
CREATE TABLE IF NOT EXISTS `participer` (
  `idJoueur` int NOT NULL,
  `idMatch` int NOT NULL,
  `nombre_buts` int DEFAULT '0',
  `nombre_passes_decisives` int DEFAULT '0',
  `nombre_arrets` int DEFAULT '0',
  PRIMARY KEY (`idJoueur`,`idMatch`),
  KEY `idMatch` (`idMatch`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participer`
--

INSERT INTO `participer` (`idJoueur`, `idMatch`, `nombre_buts`, `nombre_passes_decisives`, `nombre_arrets`) VALUES
(1, 3, 0, 0, 0),
(2, 16, 2, 0, 0),
(2, 17, 0, 0, 0),
(1, 17, 0, 0, 0),
(1, 22, 0, 0, 0),
(1, 23, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `tournois`
--

DROP TABLE IF EXISTS `tournois`;
CREATE TABLE IF NOT EXISTS `tournois` (
  `idTournois` int NOT NULL AUTO_INCREMENT,
  `nomTournois` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `villeTournois` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idTournois`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tournois`
--

INSERT INTO `tournois` (`idTournois`, `nomTournois`, `villeTournois`) VALUES
(33, 'EUROPA CONFERENCE', 'Paris'),
(32, 'Test tournois', 'Marseille'),
(31, 'LDC', 'Marseille');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
