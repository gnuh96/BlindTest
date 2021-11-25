-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 04 Avril 2019 à 14:45
-- Version du serveur :  5.1.73
-- Version de PHP :  7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `prugne2u`
--

-- --------------------------------------------------------

--
-- Structure de la table `Auteur`
--

CREATE TABLE IF NOT EXISTS `Auteur` (
  `idAuteur` int(5) NOT NULL AUTO_INCREMENT,
  `nomArtiste` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`idAuteur`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `Auteur`
--

INSERT INTO `Auteur` (`idAuteur`, `nomArtiste`) VALUES
(1, 'Johnny Hallyday'),
(2, 'ABBA'),
(3, 'Alan Walker'),
(4, 'Ariana Grande'),
(5, 'DJ Snake'),
(6, 'Imagine Dragons'),
(7, 'David Guetta'),
(8, 'Charlie Puth'),
(9, 'Fetty Wap'),
(10, 'Drake');

-- --------------------------------------------------------

--
-- Structure de la table `Categorie`
--

CREATE TABLE IF NOT EXISTS `Categorie` (
  `idCateg` int(2) NOT NULL AUTO_INCREMENT,
  `nomCateg` int(4) DEFAULT NULL,
  PRIMARY KEY (`idCateg`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Categorie`
--

INSERT INTO `Categorie` (`idCateg`, `nomCateg`) VALUES
(1, 1980),
(2, 1990),
(3, 2000),
(4, 2010);

-- --------------------------------------------------------

--
-- Structure de la table `Classement`
--

CREATE TABLE IF NOT EXISTS `Classement` (
  `idClassement` int(5) NOT NULL AUTO_INCREMENT,
  `score` int(3) DEFAULT NULL,
  `token` varchar(25) DEFAULT NULL,
  `idJoueur` int(5) DEFAULT NULL,
  PRIMARY KEY (`idClassement`),
  KEY `idJoueur` (`idJoueur`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `Classement`
--

INSERT INTO `Classement` (`idClassement`, `score`, `token`, `idJoueur`) VALUES
(1, 3, 'Partiebbc78b77', 1),
(2, 11, 'Partie02b51b0e', 2),
(3, 3, 'Partie8287957d', 2),
(4, 0, 'Partiefb50e861', 2),
(5, 0, 'Partie3e3be621', 4),
(6, 4, 'Partiee6ee52fa', 5),
(7, 4, 'Partieb1f52535', 7);

-- --------------------------------------------------------

--
-- Structure de la table `Compose`
--

CREATE TABLE IF NOT EXISTS `Compose` (
  `idCompose` int(5) NOT NULL AUTO_INCREMENT,
  `idMusique` int(5) DEFAULT NULL,
  `idAuteur` int(5) DEFAULT NULL,
  PRIMARY KEY (`idCompose`),
  KEY `idMusique` (`idMusique`),
  KEY `idAuteur` (`idAuteur`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `Compose`
--

INSERT INTO `Compose` (`idCompose`, `idMusique`, `idAuteur`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8),
(9, 9, 9),
(10, 10, 10),
(11, 11, 4),
(12, 12, 4),
(13, 13, 4),
(14, 14, 4),
(15, 15, 4),
(16, 16, 4),
(17, 17, 4),
(18, 18, 4),
(19, 19, 4),
(20, 20, 4);

-- --------------------------------------------------------

--
-- Structure de la table `Genre`
--

CREATE TABLE IF NOT EXISTS `Genre` (
  `idGenre` int(2) NOT NULL AUTO_INCREMENT,
  `nomGenre` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`idGenre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `Genre`
--

INSERT INTO `Genre` (`idGenre`, `nomGenre`) VALUES
(1, 'Chanson'),
(2, 'Europop'),
(3, 'Tropical House'),
(4, 'Disco'),
(5, 'Dance Pop'),
(6, 'Modern Rock'),
(7, 'Hip Hop'),
(8, 'Canadian Hip Hop');

-- --------------------------------------------------------

--
-- Structure de la table `Historique`
--

CREATE TABLE IF NOT EXISTS `Historique` (
  `idHistorique` int(5) NOT NULL AUTO_INCREMENT,
  `idMusique` int(5) NOT NULL,
  `token` varchar(25) NOT NULL,
  PRIMARY KEY (`idHistorique`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Contenu de la table `Historique`
--

INSERT INTO `Historique` (`idHistorique`, `idMusique`, `token`) VALUES
(1, 15, 'Partiebbc78b77'),
(2, 14, 'Partiebbc78b77'),
(3, 19, 'Partiebbc78b77'),
(4, 16, 'Partiebbc78b77'),
(5, 14, 'Partiebbc78b77'),
(6, 12, 'Partiebbc78b77'),
(7, 15, 'Partiebbc78b77'),
(8, 18, 'Partiebbc78b77'),
(9, 5, 'Partiebbc78b77'),
(10, 13, 'Partiebbc78b77'),
(11, 11, 'Partiebbc78b77'),
(12, 18, 'Partie02b51b0e'),
(13, 1, 'Partie02b51b0e'),
(14, 5, 'Partie02b51b0e'),
(15, 3, 'Partie02b51b0e'),
(16, 19, 'Partie02b51b0e'),
(17, 6, 'Partie02b51b0e'),
(18, 4, 'Partie02b51b0e'),
(19, 2, 'Partie02b51b0e'),
(20, 7, 'Partie02b51b0e'),
(21, 3, 'Partie02b51b0e'),
(22, 13, 'Partie8287957d'),
(23, 16, 'Partie8287957d'),
(24, 9, 'Partie8287957d'),
(25, 14, 'Partie8287957d'),
(26, 4, 'Partie8287957d'),
(27, 7, 'Partie8287957d'),
(28, 15, 'Partie8287957d'),
(29, 3, 'Partie8287957d'),
(30, 3, 'Partie8287957d'),
(31, 10, 'Partie8287957d'),
(32, 18, 'Partiebbc78b77'),
(33, 12, 'Partiefb50e861'),
(34, 13, 'Partiefb50e861'),
(35, 17, 'Partiefb50e861'),
(36, 3, 'Partiefb50e861'),
(37, 16, 'Partiefb50e861'),
(38, 7, 'Partiefb50e861'),
(39, 16, 'Partiefb50e861'),
(40, 12, 'Partiefb50e861'),
(41, 19, 'Partiefb50e861'),
(42, 5, 'Partiefb50e861'),
(43, 4, 'Partie12cc9a99'),
(44, 11, 'Partie22a1d1aa'),
(45, 14, 'Partie3e3be621'),
(46, 17, 'Partie3e3be621'),
(47, 19, 'Partie3e3be621'),
(48, 18, 'Partie3e3be621'),
(49, 16, 'Partie3e3be621'),
(50, 14, 'Partie3e3be621'),
(51, 4, 'Partie308b585f'),
(52, 17, 'Partie3e3be621'),
(53, 17, 'Partie3e3be621'),
(54, 18, 'Partie3e3be621'),
(55, 7, 'Partie3e3be621'),
(56, 18, 'Partie3e3be621'),
(57, 14, 'Partie3e3be621'),
(58, 19, 'Partie3e3be621'),
(59, 8, 'Partie3e3be621'),
(60, 5, 'Partiee6ee52fa'),
(61, 2, 'Partiee6ee52fa'),
(62, 8, 'Partiee6ee52fa'),
(63, 15, 'Partiee6ee52fa'),
(64, 18, 'Partiee6ee52fa'),
(65, 13, 'Partiee6ee52fa'),
(66, 3, 'Partiee6ee52fa'),
(67, 7, 'Partiee6ee52fa'),
(68, 10, 'Partiee6ee52fa'),
(69, 3, 'Partieb1f52535'),
(70, 7, 'Partieb1f52535'),
(71, 15, 'Partieb1f52535'),
(72, 10, 'Partieb1f52535'),
(73, 14, 'Partieb1f52535'),
(74, 6, 'Partieb1f52535'),
(75, 13, 'Partieb1f52535'),
(76, 5, 'Partieb1f52535'),
(77, 2, 'Partieb1f52535'),
(78, 1, 'Partieb1f52535');

-- --------------------------------------------------------

--
-- Structure de la table `Jouer`
--

CREATE TABLE IF NOT EXISTS `Jouer` (
  `idJouer` int(5) NOT NULL AUTO_INCREMENT,
  `idJoueur` int(5) DEFAULT NULL,
  `token` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idJouer`),
  KEY `idJoueur` (`idJoueur`),
  KEY `token` (`token`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `Jouer`
--

INSERT INTO `Jouer` (`idJouer`, `idJoueur`, `token`) VALUES
(1, 1, '87cfcd02');

-- --------------------------------------------------------

--
-- Structure de la table `Joueur`
--

CREATE TABLE IF NOT EXISTS `Joueur` (
  `idJoueur` int(5) NOT NULL AUTO_INCREMENT,
  `pseudonyme` varchar(50) DEFAULT NULL,
  `motdepasse` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idJoueur`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `Joueur`
--

INSERT INTO `Joueur` (`idJoueur`, `pseudonyme`, `motdepasse`) VALUES
(1, 'Robs', '$2y$12$ZF1WkWt7.1/FHw5SQH.uX.r0RVfJP4E8o0t/hZ6sY2DAxKgmfnfUG'),
(2, 'Tom', '$2y$12$3/GP5qmYo8SYiMn2x3/TW./q.DMbUHDFs6B4OjvPORITOzOWlXh1i'),
(3, 'Joueur46', NULL),
(4, 'Joueur11', NULL),
(5, 'AntonioLOVE', '$2y$12$T7GOpwnveiDqX1jKo39jf.Se5R7d589Z/.KXiGncdimektCAI.FYW'),
(6, 'Joueur83', NULL),
(7, 'Joueur99', NULL),
(8, 'pepe', '$2y$12$jEQcD9.kfLoGaXSzRT4r.uTCEDOBJ4nUQ8ebsMnKJQoOEoRva4UGa');

-- --------------------------------------------------------

--
-- Structure de la table `Musique`
--

CREATE TABLE IF NOT EXISTS `Musique` (
  `idMusique` int(5) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `idCateg` int(2) DEFAULT NULL,
  `idGenre` int(2) DEFAULT NULL,
  PRIMARY KEY (`idMusique`),
  KEY `idCateg` (`idCateg`),
  KEY `idGenre` (`idGenre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `Musique`
--

INSERT INTO `Musique` (`idMusique`, `titre`, `date`, `idCateg`, `idGenre`) VALUES
(1, 'Allumer le feu', '1998', 2, 1),
(2, 'Money Money Money', '2008', 3, 2),
(3, 'Faded', '2015', 4, 3),
(4, 'thank u next', '2019', 4, 5),
(5, 'Taki Taki', '2018', 4, 5),
(6, 'Bad Liar', '2018', 4, 6),
(7, 'Better When You''re Gone', '2019', 4, 5),
(8, 'One Call Away', '2016', 4, 5),
(9, 'Trap Queen', '2014', 4, 7),
(10, 'God''s Plan', '2018', 4, 8),
(11, '7 rings', '2019', 4, 5),
(12, 'break up with your girlfriend, i''m bored', '2019', 4, 5),
(13, 'needy', '2019', 4, 5),
(14, 'bloodline', '2019', 4, 5),
(15, 'NASA', '2019', 4, 5),
(16, 'imagine', '2019', 4, 5),
(17, 'bad idea', '2019', 4, 5),
(18, 'fake smile', '2019', 4, 5),
(19, 'make up', '2019', 4, 5),
(20, 'in my head', '2019', 4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `Partie`
--

CREATE TABLE IF NOT EXISTS `Partie` (
  `token` varchar(25) NOT NULL DEFAULT '',
  `partage` varchar(200) DEFAULT NULL,
  `nbJoueurs` int(2) DEFAULT NULL,
  PRIMARY KEY (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Partie`
--

INSERT INTO `Partie` (`token`, `partage`, `nbJoueurs`) VALUES
('Partiebd0415d6', NULL, 1),
('Partie80fc0d37', NULL, 1),
('Partie685055de', NULL, 1),
('Partie098e27b1', NULL, 1),
('Partie42e84edf', NULL, 1),
('Partie33c9e96e', NULL, 1),
('Partie8291532b', NULL, 1),
('Partieef3326ac', 'Partieef3326ac', 4),
('Partiec1f5e189', '/S3/ProjetTutores/s3c_s07_aubert_nguyen_prugne_vallera/blindtest/Blind-Test/partage-Jouer/Partiec1f5e189', 1),
('Partiea3d0f1cc', NULL, 1),
('Partie6ce0145a', NULL, 1),
('Partiebbc78b77', '/S3/s3c_s07_aubert_nguyen_prugne_vallera/blindtest/Blind-Test/partage-Jouer/Partiebbc78b77', 1),
('Partie02b51b0e', NULL, 1),
('Partie8287957d', NULL, 1),
('Partiefb50e861', '/www/aubert117u/s3c_s07_aubert_nguyen_prugne_vallera/blindtest/Blind-Test/partage-Jouer/Partiefb50e861', 1),
('Partie3e3be621', '/S3/s3c_s07_aubert_nguyen_prugne_vallera/blindtest/Blind-Test/partage-Jouer/Partie3e3be621', 1),
('Partiee6ee52fa', NULL, 1),
('Partieb1f52535', '/www/prugne2u/s3c_s07_aubert_nguyen_prugne_vallera/blindtest/Blind-Test/partage-Jouer/Partieb1f52535', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
