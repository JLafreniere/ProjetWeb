-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 24 Mai 2016 à 19:31
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `diablos`
--
CREATE DATABASE IF NOT EXISTS `diablos` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `diablos`;

-- --------------------------------------------------------

--
-- Structure de la table `bourses`
--

CREATE TABLE IF NOT EXISTS `bourses` (
  `id_bourse` int(6) NOT NULL AUTO_INCREMENT,
  `id_joueur` int(6) NOT NULL,
  `montant` double(8,2) NOT NULL,
  `provenance` varchar(50) NOT NULL,
  `annee` int(4) NOT NULL,
  PRIMARY KEY (`id_bourse`),
  KEY `id_joueur` (`id_joueur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `certifications_entraineurs`
--

CREATE TABLE IF NOT EXISTS `certifications_entraineurs` (
  `id_certification` int(6) NOT NULL AUTO_INCREMENT,
  `id_entraineur` int(6) NOT NULL,
  `annee_obtention` int(4) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id_certification`),
  KEY `id_entraineur` (`id_entraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `detail_sejour`
--

CREATE TABLE IF NOT EXISTS `detail_sejour` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `idEndroitSejour` int(6) NOT NULL,
  `demandeAchat` varchar(10) NOT NULL,
  `nbChambre` int(2) NOT NULL,
  `nbNuit` int(2) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idEndroitSejour` (`idEndroitSejour`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `endroit_sejour`
--

CREATE TABLE IF NOT EXISTS `endroit_sejour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(125) NOT NULL,
  `rue` varchar(125) NOT NULL,
  `ville` varchar(125) NOT NULL,
  `codePostal` varchar(7) NOT NULL,
  `no_tel` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `endroit_sejour`
--

INSERT INTO `endroit_sejour` (`id`, `nom`, `rue`, `ville`, `codePostal`, `no_tel`) VALUES
(1, 'Hotel Delta', '2050, Rue Notre-Dame', 'Trois-Rivières', 'G9A 6E5', '8196957452'),
(3, 'Hotel Mariott', '132, Boul. Becancour', 'Becancour', 'D3W 4T7', '8196684213'),
(6, 'Hotel Hilton', '1100, boulevard René-Lévesque Est', 'Québec', 'G1R 4P3', '4186674545');

-- --------------------------------------------------------

--
-- Structure de la table `entraineurs`
--

CREATE TABLE IF NOT EXISTS `entraineurs` (
  `id_entraineur` int(6) NOT NULL AUTO_INCREMENT,
  `id_personne` int(6) NOT NULL,
  `no_embauche` varchar(6) NOT NULL,
  `note` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id_entraineur`),
  KEY `id_personne` (`id_personne`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `entraineurs`
--

INSERT INTO `entraineurs` (`id_entraineur`, `id_personne`, `no_embauche`, `note`, `type`) VALUES
(5, 15, '445666', '', 'Entraîneur-chef'),
(6, 16, '', 'A rejoint l''université McGill', ''),
(7, 17, '', 'Entraîneur de la ligne offensive', ''),
(8, 18, '', 'Assistant au coordonnateur offensif et entraineur des quarts-arriÃ¨res', ''),
(9, 19, '', 'Entraîneur-chef du football collégial division 2', ''),
(10, 23, '458897', '', 'Médical');

-- --------------------------------------------------------

--
-- Structure de la table `entraineur_equipe`
--

CREATE TABLE IF NOT EXISTS `entraineur_equipe` (
  `id_entraineur_equipe` int(6) NOT NULL AUTO_INCREMENT,
  `id_entraineur` int(6) NOT NULL,
  `id_equipe` int(6) NOT NULL,
  `role` varchar(30) NOT NULL,
  `photo_profil` varchar(255) NOT NULL,
  PRIMARY KEY (`id_entraineur_equipe`),
  KEY `id_entraneur` (`id_entraineur`),
  KEY `id_equipe` (`id_equipe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `equipes`
--

CREATE TABLE IF NOT EXISTS `equipes` (
  `id_equipe` int(6) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `sexe` char(1) NOT NULL,
  `saison` varchar(20) NOT NULL,
  `photo_equipe` varchar(255) NOT NULL,
  `id_sport` int(6) NOT NULL,
  PRIMARY KEY (`id_equipe`),
  KEY `id_sport` (`id_sport`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `equipes`
--

INSERT INTO `equipes` (`id_equipe`, `nom`, `sexe`, `saison`, `photo_equipe`, `id_sport`) VALUES
(3, 'Basketball masculin D2', 'M', '2015-2016', '', 1),
(4, 'Basketball masculin D2', 'M', '2015-2016', '', 1),
(5, 'Volleyball féminin D1', 'F', '2015-2016', '', 0),
(6, 'Volleyball féminin D1', 'F', '2015-2016', '', 0),
(8, 'Cheerleading (mixte)', 'X', '2015-2016', '', 7);

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE IF NOT EXISTS `evenement` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `idTransport` int(6) DEFAULT NULL,
  `statusTransport` int(1) DEFAULT NULL,
  `idSejour` int(6) DEFAULT NULL,
  `statusSejour` int(1) DEFAULT NULL,
  `noteSejour` varchar(255) DEFAULT NULL,
  `idSport` int(6) DEFAULT NULL,
  `equipeReceveur` varchar(75) DEFAULT NULL,
  `equipeVisiteur` varchar(75) DEFAULT NULL,
  `type` varchar(80) DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `date` date NOT NULL,
  `endroit` varchar(125) DEFAULT NULL,
  `ville` varchar(125) DEFAULT NULL,
  `rue` varchar(125) DEFAULT NULL,
  `codePostal` varchar(7) DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idTransport` (`idTransport`,`idSejour`),
  KEY `idTransport_2` (`idTransport`),
  KEY `idSejour` (`idSejour`),
  KEY `idEquipeReceveur` (`equipeReceveur`),
  KEY `idEquipeVisiteur` (`equipeVisiteur`),
  KEY `idSport` (`idSport`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `evenement`
--

INSERT INTO `evenement` (`id`, `idTransport`, `statusTransport`, `idSejour`, `statusSejour`, `noteSejour`, `idSport`, `equipeReceveur`, `equipeVisiteur`, `type`, `heure`, `date`, `endroit`, `ville`, `rue`, `codePostal`, `status`, `description`) VALUES
(1, 1, 1, NULL, 1, 'Pas d''hotel', 1, 'Dragons Basketball masculin D2', 'Diablos Basketball masculin D2', 'Match de saison', '13:00:00', '2016-03-01', 'Stade Diablos', 'Trois-Rivieres', 'Des Forges', 'G9A 6E5', '1', 'Tous les joueurs seront present'),
(2, 1, 1, 3, 2, NULL, 0, 'Diablos Volleyball féminin D1', 'Dragons Volleyball féminin D1', 'Tournoi', '14:00:00', '2016-02-22', 'Salle Bernard', 'Sainte-Margerite', 'La Rue', 'G1F 3S5', '1', ''),
(3, 1, 2, 6, 1, '', 1, 'Dragons Basketball masculin D2', 'Diablos Basketball masculin D2', 'Match', '05:45:00', '2016-02-22', 'Salle municipale', 'Deschaillons-sur-Saint-Laurent', '18e Avenue', 'G0S 1G0', '3', ''),
(5, 2, 1, 1, 3, '', 1, 'Diablos Basketball masculin D2', 'Dragons Basketball masculin D2', 'Tournoi', '19:00:00', '2016-02-22', 'Stade Diablos', 'Trois-Rivieres', 'Des Forges', 'G0S 1G0', '2', ''),
(6, 3, 1, 6, 2, NULL, 7, 'Diablos Cheerleading (mixte)', 'Rouge et or Cheerleading (mixte)', 'compétition', '09:30:00', '2016-03-11', 'Salle Bernard', 'Québec', 'Louis XIV', 'G0S 1G0', '2', ''),
(7, 4, 2, NULL, 1, NULL, 1, 'Diablos Basketball masculin D2', 'Dragons Basketball masculin D2', 'match', '08:50:00', '2016-03-02', 'Stade Diablos', 'Trois-Rivières', 'Des Forges', 'G0S 1G0', '3', ''),
(8, 1, 1, NULL, 1, NULL, 1, 'Dragons Basketball masculin D2', 'Diablos Basketball masculin D2', 'Match de saison', '13:00:00', '2016-03-05', 'Stade Diablos', 'Trois-Rivieres', 'Des Forges', 'G9A 6E5', '1', 'Tous les joueurs seront present'),
(9, 1, 1, 3, 2, NULL, 0, 'Diablos Volleyball féminin D1', 'Dragons Volleyball féminin D1', 'Tournoi', '14:00:00', '2016-02-22', 'Salle Bernard', 'Sainte-Margerite', 'La Rue', 'G1F 3S5', '1', ''),
(10, 1, 1, 3, 2, NULL, 0, 'Diablos Volleyball féminin D1', 'Dragons Volleyball féminin D1', 'Tournoi', '14:00:00', '2016-03-09', 'Stade Diablos', 'Sainte-Margerite', 'La Rue', 'G1F 3S5', '1', ''),
(11, 1, 1, 3, 2, '', 0, 'Diablos Volleyball féminin D1', 'Dragons Volleyball féminin D1', 'Tournoi', '14:00:00', '2016-03-21', 'Salle Bernard', 'Sainte-Margerite', 'La Rue', 'G1F 3S5', '1', ''),
(12, 1, 1, 3, 2, NULL, 0, 'Diablos Volleyball féminin D1', 'Dragons Volleyball féminin D1', 'Tournoi', '14:00:00', '2016-03-09', 'Salle Bernard', 'Sainte-Margerite', 'La Rue', 'G1F 3S5', '1', '');

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE IF NOT EXISTS `joueurs` (
  `id_joueur` int(6) NOT NULL AUTO_INCREMENT,
  `id_personne` int(6) NOT NULL,
  `taille` int(3) NOT NULL,
  `poids` double(5,2) NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`id_joueur`),
  KEY `id_personne` (`id_personne`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `joueurs_equipes`
--

CREATE TABLE IF NOT EXISTS `joueurs_equipes` (
  `id_joueur_equipe` int(6) NOT NULL AUTO_INCREMENT,
  `id_joueur` int(6) NOT NULL,
  `id_equipe` int(6) NOT NULL,
  `id_position` int(6) NOT NULL,
  `numero` int(3) NOT NULL,
  `photo_profil` varchar(255) NOT NULL,
  PRIMARY KEY (`id_joueur_equipe`),
  KEY `id_joueur` (`id_joueur`),
  KEY `id_equipe` (`id_equipe`),
  KEY `id_position` (`id_position`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `membres_personnel`
--

CREATE TABLE IF NOT EXISTS `membres_personnel` (
  `id_membre` int(6) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `sexe` char(1) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `no_tel` varchar(10) DEFAULT NULL,
  `posteTelephonique` varchar(6) DEFAULT NULL,
  `courriel` varchar(150) NOT NULL,
  `rue` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ville` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `province` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
  `code_postal` varchar(7) CHARACTER SET utf8 DEFAULT NULL,
  `no_embauches` varchar(80) DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Contenu de la table `membres_personnel`
--

INSERT INTO `membres_personnel` (`id_membre`, `nom`, `prenom`, `sexe`, `date_naissance`, `no_tel`, `posteTelephonique`, `courriel`, `rue`, `ville`, `province`, `code_postal`, `no_embauches`) VALUES
(15, 'Lapiere', 'Jasmine', 'F', '1992-03-08', '8192694444', '1234', 'jlp@hotmail.com', '450 rang 10', 'st-sylvère', 'Québec', 'g9a 4g1', '0'),
(16, 'Turcotte Létourneau', 'Olivier', 'M', '1986-03-08', '8195551456', '4567', 'olitl@hotmail.com', '550 Richelieu', '  Trois-Rivières', 'Québec', 'g8t 2v3', '0'),
(17, 'De Jean', 'Pierre', 'M', '1977-01-10', '8195559875', NULL, 'djPierre@hotmail.com', '1200 Patry', '  Trois-Rivières', 'Québec', 'g8t 5v1', '0'),
(18, 'Szabo', 'Richard', 'M', '1986-03-08', '8195551884', NULL, 'szabo@hotmail.com', '225 Dieppe', '  Trois-Rivières', 'Québec', 'g8t 1r7', '0'),
(19, 'Dussault', 'François', 'M', '1986-03-08', '8192261442', NULL, 'fdussault@hotmail.com', '660 Despins', ' Trois-Rivières', 'Québec', 'g8t 1r1', '0'),
(20, 'Demers', 'Laurent', 'M', '0000-00-00', '8195552424', NULL, 'laurent,demers@hotmail.com', '', '', '', '', '0'),
(22, 'Bernier', 'Julie', 'F', NULL, '8196952432', '1547', 'julieb@gmail.ca', NULL, NULL, NULL, NULL, '0'),
(23, 'Dubois', 'Christian', 'M', NULL, '8196942278', '', 'c.dubois@gmail.ca', NULL, NULL, NULL, NULL, '0'),
(24, 'Héroux', 'Albert', 'M', NULL, '', '', '', NULL, NULL, NULL, NULL, '0'),
(25, 'Bob', 'Bob', 'M', NULL, '8191111111', '111', 'bob.bob@hotmail.com', NULL, NULL, NULL, NULL, '12345;123;');

-- --------------------------------------------------------

--
-- Structure de la table `personnes`
--

CREATE TABLE IF NOT EXISTS `personnes` (
  `id_personne` int(6) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `sexe` char(1) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `no_tel` varchar(10) DEFAULT NULL,
  `posteTelephonique` varchar(6) DEFAULT NULL,
  `courriel` varchar(150) NOT NULL,
  `rue` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ville` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `province` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
  `code_postal` varchar(7) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Contenu de la table `personnes`
--

INSERT INTO `personnes` (`id_personne`, `nom`, `prenom`, `sexe`, `date_naissance`, `no_tel`, `posteTelephonique`, `courriel`, `rue`, `ville`, `province`, `code_postal`) VALUES
(15, 'Lapiere', 'Jasmine', 'F', '1992-03-08', '8192694444', '1234', 'jlp@hotmail.com', '450 rang 10', 'st-sylvère', 'Québec', 'g9a 4g1'),
(16, 'Turcotte Létourneau', 'Olivier', 'M', '1986-03-08', '8195551456', '4567', 'olitl@hotmail.com', '550 Richelieu', '  Trois-Rivières', 'Québec', 'g8t 2v3'),
(17, 'De Jean', 'Pierre', 'M', '1977-01-10', '8195559875', NULL, 'djPierre@hotmail.com', '1200 Patry', '  Trois-Rivières', 'Québec', 'g8t 5v1'),
(18, 'Szabo', 'Richard', 'M', '1986-03-08', '8195551884', NULL, 'szabo@hotmail.com', '225 Dieppe', '  Trois-Rivières', 'Québec', 'g8t 1r7'),
(19, 'Dussault', 'François', 'M', '1986-03-08', '8192261442', NULL, 'fdussault@hotmail.com', '660 Despins', ' Trois-Rivières', 'Québec', 'g8t 1r1'),
(20, 'Demers', 'Laurent', 'M', '0000-00-00', '8195552424', NULL, 'laurent,demers@hotmail.com', '', '', '', ''),
(22, 'Bernier', 'Julie', 'M', NULL, '8196952432', '1547', 'julieb@gmail.ca', NULL, NULL, NULL, NULL),
(23, 'Dubois', 'Christian', 'M', NULL, '8196942278', '', 'c.dubois@gmail.ca', NULL, NULL, NULL, NULL),
(24, 'Héroux', 'Albert', 'M', NULL, '', '', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `positions`
--

CREATE TABLE IF NOT EXISTS `positions` (
  `id_position` int(6) NOT NULL AUTO_INCREMENT,
  `id_sport` int(6) NOT NULL,
  `position` varchar(50) NOT NULL,
  PRIMARY KEY (`id_position`),
  KEY `id_sport` (`id_sport`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `responsable_plateau`
--

CREATE TABLE IF NOT EXISTS `responsable_plateau` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `id_personne` int(6) NOT NULL,
  `idEvenement` int(6) NOT NULL,
  `role` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idEvenement` (`idEvenement`),
  KEY `idType` (`role`),
  KEY `id_personne` (`id_personne`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `responsable_plateau`
--

INSERT INTO `responsable_plateau` (`id`, `id_personne`, `idEvenement`, `role`) VALUES
(1, 15, 1, 'Physiothérapeute'),
(2, 16, 2, 'Infirmier'),
(4, 15, 1, 'Infirmier');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `role_responsable`
--

CREATE TABLE IF NOT EXISTS `role_responsable` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `id_personne` int(6) NOT NULL,
  `role` varchar(80) NOT NULL,
  `no_embauche` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_personne` (`id_personne`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `role_responsable`
--

INSERT INTO `role_responsable` (`id`, `id_personne`, `role`, `no_embauche`) VALUES
(5, 15, 'Physiothérapeute', '445866'),
(6, 15, 'Infirmier', '114588'),
(7, 16, 'Médecin', '335988'),
(8, 22, 'Caméraman', '557844'),
(13, 22, 'Physiothérapeute', '557845');

-- --------------------------------------------------------

--
-- Structure de la table `sports`
--

CREATE TABLE IF NOT EXISTS `sports` (
  `id_sport` int(6) NOT NULL AUTO_INCREMENT,
  `sport` varchar(50) NOT NULL,
  PRIMARY KEY (`id_sport`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `sports`
--

INSERT INTO `sports` (`id_sport`, `sport`) VALUES
(0, 'Volleyball'),
(1, 'Basketball'),
(2, 'Football'),
(3, 'Natation'),
(4, 'Soccer'),
(5, 'Cross-country'),
(6, 'Badminton'),
(7, 'Cheerleading'),
(8, 'Hockey'),
(9, 'Golf');

-- --------------------------------------------------------

--
-- Structure de la table `statut_joueurs`
--

CREATE TABLE IF NOT EXISTS `statut_joueurs` (
  `id_statut` int(6) NOT NULL AUTO_INCREMENT,
  `id_joueur_equipe` int(6) NOT NULL,
  `statut` varchar(200) NOT NULL,
  `date_arret` date NOT NULL,
  `date_retour` date NOT NULL,
  PRIMARY KEY (`id_statut`),
  KEY `id_joueur_equipe` (`id_joueur_equipe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `transport`
--

CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `idTransporteur` int(6) NOT NULL,
  `heureDepart` time NOT NULL,
  `heureRetour` time NOT NULL,
  `demandeAchat` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `dateRetour` date DEFAULT NULL,
  `note` varchar(255) NOT NULL,
  `typeTransport` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idTransporteur` (`idTransporteur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `transport`
--

INSERT INTO `transport` (`id`, `idTransporteur`, `heureDepart`, `heureRetour`, `demandeAchat`, `date`, `dateRetour`, `note`, `typeTransport`) VALUES
(1, 1, '06:30:00', '22:30:00', '', '2016-03-01', '0000-00-00', '', 'autobus scolaire'),
(2, 2, '18:15:00', '23:00:00', 'abc', '2016-02-13', '0000-00-00', '', 'autobus voyageur'),
(3, 1, '00:00:00', '00:00:00', '', '0000-00-00', NULL, '', ''),
(4, 1, '00:00:00', '00:00:00', '1234', '2016-03-02', NULL, '', 'autobus scolaire');

-- --------------------------------------------------------

--
-- Structure de la table `transporteur`
--

CREATE TABLE IF NOT EXISTS `transporteur` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `nom` varchar(125) NOT NULL,
  `type` varchar(100) NOT NULL,
  `nombrePlace` int(2) NOT NULL,
  `rue` varchar(100) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `codePostal` varchar(7) NOT NULL,
  `courriel` varchar(125) NOT NULL,
  `siteWeb` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `transporteur`
--

INSERT INTO `transporteur` (`id`, `nom`, `type`, `nombrePlace`, `rue`, `ville`, `codePostal`, `courriel`, `siteWeb`) VALUES
(1, 'Gaetan Demers', '', 30, 'Marie-Victorin', 'Bécancour', 'G0Z 1H0', 'g.demers@hotmail.com', ''),
(2, 'Aline Leblanc', '', 15, 'Des Fleurs', 'Saint-Rosaire', 'G1S 1F3', 'aline.leblanc@gmail.com', '');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `nomUtilisateur` varchar(30) CHARACTER SET utf8 NOT NULL,
  `motPasse` varchar(255) CHARACTER SET utf8 NOT NULL,
  `estAdmin` tinyint(1) NOT NULL,
  `estActif` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomUtilisateur` (`nomUtilisateur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nomUtilisateur`, `motPasse`, `estAdmin`, `estActif`) VALUES
(1, 'aline2', '$2y$10$qiOE48WChi6zCPA3vDgdiubPP008ROI/QFbuJJ2x1jqAuKOf3c4kK', 0, 1),
(2, 'george', '$2y$10$eC5ohucIF/LPLUeGxQ2Dv.f/SyqgNE8prUOXsrnvs2PXPYGQFNRIC', 0, 1),
(9, 'anthony', '$2y$10$cEqjsgVo8a4wrgePCZ5Hdue4yLQoJoIpBIpMp5/Sh5x1LH0UpIqp6', 0, 1),
(10, 'admin', '$2y$10$0/49ep818/KzhJ.nnLbpte/93hJWrauBFPerGfjn0mdRf7RugtThy', 1, 1),
(11, 'danielle', '$2y$10$4CuCO0Sjlz6B.lEck2QvDeOo6lHLymzmVtoo6S91WkMmgC6khRsie', 0, 1),
(12, 'olivier', '$2y$10$0vmLd7SHM/0iB1ZfoyVvPe9D/Ejj2LJHSS859YqVHMTiAeTEGpOhi', 0, 0),
(13, 'jeremie', '$2y$10$iJiYVASngjQtI/Yn39vvruV1xn37BWdztOwQSm8KXaV7riqPzwb6W', 0, 1),
(14, 'frank12', '$2y$10$ZLLIxbVyhMjlB8l3/Clo/.A6.9tb1oFqE1PKzc8viyT3hN7fwxCDS', 0, 1),
(15, 'bobby45', '$2y$10$XHTlgRr7nBleQfKo87Mjg.9aliL0uHf8HiKXYcMrEjnbc5WGG9qH2', 0, 1),
(16, 'lucy', '$2y$10$PcLg/rf20Ij.72dLRXKzWevUX98jPDfc5byhM3RNpAj8gR0oQpmVG', 0, 1),
(17, 'lemay03', '$2y$10$ylPNrP4Ng/IkUIa6iCNm7uTKffwKP6ebYO/y6SbQndEXAx/54W4G2', 0, 1),
(18, 'paul', '$2y$10$1xEooG.dyCZN.fjTLugJleZfy.5iWgsa9Y70jTqGyAMORQlyctrGi', 0, 1),
(19, 'guy', '$2y$10$9Kwmgih1lMsesfCS1ZGT7e7OrVDjWiA2ADK64SV/WB90nwTX3FNKC', 0, 1),
(20, 'denis', '$2y$10$YMjgSzpW1ynlDhAjbksYxOowpDflcbUB80HCF6R96VsEKH.8MYebK', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

CREATE TABLE IF NOT EXISTS `villes` (
  `no_ville` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(5) NOT NULL,
  `designation` varchar(15) NOT NULL,
  `municipalite` varchar(75) NOT NULL,
  `mrc` varchar(75) NOT NULL,
  `region` varchar(75) NOT NULL,
  PRIMARY KEY (`no_ville`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1112 ;

--
-- Contenu de la table `villes`
--

INSERT INTO `villes` (`no_ville`, `code`, `designation`, `municipalite`, `mrc`, `region`) VALUES
(1, 46005, 'Village', 'Abercorn', 'Brome-Missisquoi', 'Montérégie'),
(2, 48028, 'Ville', 'Acton Vale', 'Acton', 'Montérégie'),
(3, 31056, 'Municipalité', 'Adstock', 'Les Appalaches', 'Chaudière-Appalaches'),
(4, 98030, 'Municipalité', 'Aguanish', 'Minganie', 'Côte-Nord'),
(5, 92030, 'Municipalité', 'Albanel', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(6, 7025, 'Municipalité', 'Albertville', 'La Matapédia', 'Bas-Saint-Laurent'),
(7, 84050, 'Municipalité', 'Alleyn-et-Cawood', 'Pontiac', 'Outaouais'),
(8, 93042, 'Ville', 'Alma', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(9, 78070, 'Canton', 'Amherst', 'Les Laurentides', 'Laurentides'),
(10, 88055, 'Ville', 'Amos', 'Abitibi', 'Abitibi-Témiscamingue'),
(11, 7047, 'Ville', 'Amqui', 'La Matapédia', 'Bas-Saint-Laurent'),
(12, 55008, 'Municipalité', 'Ange-Gardien', 'Rouville', 'Montérégie'),
(13, 85080, 'Village', 'Angliers', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(14, 19037, 'Municipalité', 'Armagh', 'Bellechasse', 'Chaudière-Appalaches'),
(15, 78060, 'Canton', 'Arundel', 'Les Laurentides', 'Laurentides'),
(16, 40043, 'Ville', 'Asbestos', 'Les Sources', 'Estrie'),
(17, 41055, 'Municipalité', 'Ascot Corner', 'Le Haut-Saint-François', 'Estrie'),
(18, 50013, 'Municipalité', 'Aston-Jonction', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(19, 13045, 'Municipalité', 'Auclair', 'Témiscouata', 'Bas-Saint-Laurent'),
(20, 30055, 'Municipalité', 'Audet', 'Le Granit', 'Estrie'),
(21, 83090, 'Canton', 'Aumond', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(22, 45085, 'Municipalité', 'Austin', 'Memphrémagog', 'Estrie'),
(23, 87050, 'Municipalité', 'Authier', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(24, 87100, 'Municipalité', 'Authier-Nord', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(25, 45035, 'Village', 'Ayer''s Cliff', 'Memphrémagog', 'Estrie'),
(26, 96020, 'Ville', 'Baie-Comeau', 'Manicouagan', 'Côte-Nord'),
(27, 66112, 'Ville', 'Baie-D''Urfé', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(28, 8080, 'Municipalité', 'Baie-des-Sables', 'La Matanie', 'Bas-Saint-Laurent'),
(29, 50100, 'Municipalité', 'Baie-du-Febvre', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(30, 99060, 'Municipalité', 'Baie-James', 'Hors MRC', 'Nord-du-Québec'),
(31, 98035, 'Municipalité', 'Baie-Johan-Beetz', 'Minganie', 'Côte-Nord'),
(32, 16013, 'Ville', 'Baie-Saint-Paul', 'Charlevoix', 'Capitale-Nationale'),
(33, 15065, 'Municipalité', 'Baie-Sainte-Catherine', 'Charlevoix-Est', 'Capitale-Nationale'),
(34, 96005, 'Village', 'Baie-Trinité', 'Manicouagan', 'Côte-Nord'),
(35, 78050, 'Ville', 'Barkmere', 'Les Laurentides', 'Laurentides'),
(36, 44045, 'Municipalité', 'Barnston-Ouest', 'Coaticook', 'Estrie'),
(37, 88022, 'Municipalité', 'Barraute', 'Abitibi', 'Abitibi-Témiscamingue'),
(38, 37210, 'Municipalité', 'Batiscan', 'Les Chenaux', 'Mauricie'),
(39, 66107, 'Ville', 'Beaconsfield', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(40, 85020, 'Municipalité', 'Béarn', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(41, 27028, 'Ville', 'Beauceville', 'Robert-Cliche', 'Chaudière-Appalaches'),
(42, 70022, 'Ville', 'Beauharnois', 'Beauharnois-Salaberry \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(43, 31008, 'Municipalité', 'Beaulac-Garthby', 'Les Appalaches', 'Chaudière-Appalaches'),
(44, 19105, 'Municipalité', 'Beaumont', 'Bellechasse', 'Chaudière-Appalaches'),
(45, 21025, 'Ville', 'Beaupré', 'La Côte-de-Beaupré \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(46, 38010, 'Ville', 'Bécancour', 'Bécancour', 'Centre-du-Québec'),
(47, 46040, 'Canton', 'Bedford', 'Brome-Missisquoi', 'Montérégie'),
(48, 46035, 'Ville', 'Bedford', 'Brome-Missisquoi', 'Montérégie'),
(49, 94250, 'Municipalité', 'Bégin', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(50, 89050, 'Municipalité', 'Belcourt', 'La Vallée-de-l''Or', 'Abitibi-Témiscamingue'),
(51, 85065, 'Ville', 'Belleterre', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(52, 57040, 'Ville', 'Beloeil', 'La Vallée-du-Richelieu \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(53, 88070, 'Municipalité', 'Berry', 'Abitibi', 'Abitibi-Témiscamingue'),
(54, 18065, 'Municipalité', 'Berthier-sur-Mer', 'Montmagny', 'Chaudière-Appalaches'),
(55, 52035, 'Ville', 'Berthierville', 'D''Autray', 'Lanaudière'),
(56, 48005, 'Municipalité', 'Béthanie', 'Acton', 'Montérégie'),
(57, 13055, 'Municipalité', 'Biencourt', 'Témiscouata', 'Bas-Saint-Laurent'),
(58, 73015, 'Ville', 'Blainville', 'Thérèse-De Blainville \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(59, 98005, 'Municipalité', 'Blanc-Sablon', 'Le Golfe-du-Saint-Laurent', 'Côte-Nord'),
(60, 83045, 'Municipalité', 'Blue Sea', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(61, 80115, 'Municipalité', 'Boileau', 'Papineau', 'Outaouais'),
(62, 73030, 'Ville', 'Bois-des-Filion', 'Thérèse-De Blainville \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(63, 83085, 'Municipalité', 'Bois-Franc', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(64, 73005, 'Ville', 'Boisbriand', 'Thérèse-De Blainville \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(65, 21045, 'Municipalité', 'Boischatel', 'La Côte-de-Beaupré \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(66, 45095, 'Municipalité', 'Bolton-Est', 'Memphrémagog', 'Estrie'),
(67, 46065, 'Municipalité', 'Bolton-Ouest', 'Brome-Missisquoi', 'Montérégie'),
(68, 5045, 'Ville', 'Bonaventure', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(69, 98010, 'Municipalité', 'Bonne-Espérance', 'Le Golfe-du-Saint-Laurent', 'Côte-Nord'),
(70, 42040, 'Municipalité', 'Bonsecours', 'Le Val-Saint-François', 'Estrie'),
(71, 58033, 'Ville', 'Boucherville', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(72, 83050, 'Municipalité', 'Bouchette', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(73, 80145, 'Municipalité', 'Bowman', 'Papineau', 'Outaouais'),
(74, 78075, 'Paroisse', 'Brébeuf', 'Les Laurentides', 'Laurentides'),
(75, 46090, 'Municipalité', 'Brigham', 'Brome-Missisquoi', 'Montérégie'),
(76, 84005, 'Municipalité', 'Bristol', 'Pontiac', 'Outaouais'),
(77, 46070, 'Village', 'Brome', 'Brome-Missisquoi', 'Montérégie'),
(78, 46078, 'Ville', 'Bromont', 'Brome-Missisquoi', 'Montérégie'),
(79, 58007, 'Ville', 'Brossard', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(80, 76043, 'Ville', 'Brownsburg-Chatham', 'Argenteuil', 'Laurentides'),
(81, 84025, 'Municipalité', 'Bryson', 'Pontiac', 'Outaouais'),
(82, 41070, 'Municipalité', 'Bury', 'Le Haut-Saint-François', 'Estrie'),
(83, 12057, 'Municipalité', 'Cacouna', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(84, 59030, 'Paroisse', 'Calixa-Lavallée', 'Marguerite-D''Youville \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(85, 84030, 'Municipalité', 'Campbell''s Bay', 'Pontiac', 'Outaouais'),
(86, 67020, 'Ville', 'Candiac', 'Roussillon \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(87, 82020, 'Municipalité', 'Cantley', 'Les Collines-de-l''Outaouais', 'Outaouais'),
(88, 4047, 'Ville', 'Cap-Chat', 'La Haute-Gaspésie', 'Gaspésie–Îles-de-la-Madeleine'),
(89, 18045, 'Municipalité', 'Cap-Saint-Ignace', 'Montmagny', 'Chaudière-Appalaches'),
(90, 34030, 'Ville', 'Cap-Santé', 'Portneuf', 'Capitale-Nationale'),
(91, 5060, 'Municipalité', 'Caplan', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(92, 57010, 'Ville', 'Carignan', 'La Vallée-du-Richelieu \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(93, 6013, 'Ville', 'Carleton-sur-Mer', 'Avignon', 'Gaspésie–Îles-de-la-Madeleine'),
(94, 5077, 'Municipalité', 'Cascapédia–Saint-Jules', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(95, 7018, 'Ville', 'Causapscal', 'La Matapédia', 'Bas-Saint-Laurent'),
(96, 83040, 'Municipalité', 'Cayamant', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(97, 57005, 'Ville', 'Chambly', 'La Vallée-du-Richelieu \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(98, 91020, 'Municipalité', 'Chambord', 'Le Domaine-du-Roy', 'Saguenay–Lac-Saint-Jean'),
(99, 37220, 'Municipalité', 'Champlain', 'Les Chenaux', 'Mauricie'),
(100, 88005, 'Municipalité', 'Champneuf', 'Abitibi', 'Abitibi-Témiscamingue'),
(101, 2028, 'Ville', 'Chandler', 'Le Rocher-Percé', 'Gaspésie–Îles-de-la-Madeleine'),
(102, 99020, 'Ville', 'Chapais', 'Hors MRC', 'Nord-du-Québec'),
(103, 51080, 'Municipalité', 'Charette', 'Maskinongé', 'Mauricie'),
(104, 60005, 'Ville', 'Charlemagne', 'L''Assomption \\ Communauté métropolitaine de Montréal', 'Lanaudière'),
(105, 41020, 'Municipalité', 'Chartierville', 'Le Haut-Saint-François', 'Estrie'),
(106, 21035, 'Ville', 'Château-Richer', 'La Côte-de-Beaupré \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(107, 67050, 'Ville', 'Châteauguay', 'Roussillon \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(108, 87095, 'Municipalité', 'Chazel', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(109, 82025, 'Municipalité', 'Chelsea', 'Les Collines-de-l''Outaouais', 'Outaouais'),
(110, 80103, 'Municipalité', 'Chénéville', 'Papineau', 'Outaouais'),
(111, 62047, 'Municipalité', 'Chertsey', 'Matawinie', 'Lanaudière'),
(112, 39030, 'Municipalité', 'Chesterville', 'Arthabaska', 'Centre-du-Québec'),
(113, 99025, 'Ville', 'Chibougamau', 'Hors MRC', 'Nord-du-Québec'),
(114, 84090, 'Canton', 'Chichester', 'Pontiac', 'Outaouais'),
(115, 96035, 'Village', 'Chute-aux-Outardes', 'Manicouagan', 'Côte-Nord'),
(116, 79065, 'Municipalité', 'Chute-Saint-Philippe', 'Antoine-Labelle', 'Laurentides'),
(117, 84015, 'Municipalité', 'Clarendon', 'Pontiac', 'Outaouais'),
(118, 87110, 'Canton', 'Clermont', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(119, 15035, 'Ville', 'Clermont', 'Charlevoix-Est', 'Capitale-Nationale'),
(120, 87075, 'Municipalité', 'Clerval', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(121, 42110, 'Canton', 'Cleveland', 'Le Val-Saint-François', 'Estrie'),
(122, 3010, 'Canton', 'Cloridorme', 'La Côte-de-Gaspé', 'Gaspésie–Îles-de-la-Madeleine'),
(123, 44037, 'Ville', 'Coaticook', 'Coaticook', 'Estrie'),
(124, 95050, 'Municipalité', 'Colombier', 'La Haute-Côte-Nord', 'Côte-Nord'),
(125, 44071, 'Municipalité', 'Compton', 'Coaticook', 'Estrie'),
(126, 59035, 'Ville', 'Contrecoeur', 'Marguerite-D''Youville \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(127, 41038, 'Ville', 'Cookshire-Eaton', 'Le Haut-Saint-François', 'Estrie'),
(128, 98015, 'Municipalité', 'Côte-Nord-du-Golfe-du-Saint-Laurent', 'Le Golfe-du-Saint-Laurent', 'Côte-Nord'),
(129, 66058, 'Ville', 'Côte-Saint-Luc', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(130, 71040, 'Ville', 'Coteau-du-Lac', 'Vaudreuil-Soulanges', 'Montérégie'),
(131, 30090, 'Municipalité', 'Courcelles', 'Le Granit', 'Estrie'),
(132, 46080, 'Ville', 'Cowansville', 'Brome-Missisquoi', 'Montérégie'),
(133, 61013, 'Municipalité', 'Crabtree', 'Joliette', 'Lanaudière'),
(134, 40047, 'Ville', 'Danville', 'Les Sources', 'Estrie'),
(135, 39155, 'Ville', 'Daveluyville', 'Arthabaska', 'Centre-du-Québec'),
(136, 13005, 'Ville', 'Dégelis', 'Témiscouata', 'Bas-Saint-Laurent'),
(137, 83070, 'Municipalité', 'Déléage', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(138, 67025, 'Ville', 'Delson', 'Roussillon \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(139, 83005, 'Municipalité', 'Denholm', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(140, 93005, 'Ville', 'Desbiens', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(141, 38070, 'Municipalité', 'Deschaillons-sur-Saint-Laurent', 'Bécancour', 'Centre-du-Québec'),
(142, 34058, 'Municipalité', 'Deschambault-Grondines', 'Portneuf', 'Capitale-Nationale'),
(143, 72010, 'Ville', 'Deux-Montagnes', 'Deux-Montagnes \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(144, 31020, 'Paroisse', 'Disraeli', 'Les Appalaches', 'Chaudière-Appalaches'),
(145, 31015, 'Ville', 'Disraeli', 'Les Appalaches', 'Chaudière-Appalaches'),
(146, 44023, 'Municipalité', 'Dixville', 'Coaticook', 'Estrie'),
(147, 92022, 'Ville', 'Dolbeau-Mistassini', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(148, 66142, 'Ville', 'Dollard-Des Ormeaux', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(149, 34025, 'Ville', 'Donnacona', 'Portneuf', 'Capitale-Nationale'),
(150, 66087, 'Ville', 'Dorval', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(151, 33040, 'Municipalité', 'Dosquet', 'Lotbinière', 'Chaudière-Appalaches'),
(152, 49058, 'Ville', 'Drummondville', 'Drummond', 'Centre-du-Québec'),
(153, 41117, 'Municipalité', 'Dudswell', 'Le Haut-Saint-François', 'Estrie'),
(154, 80135, 'Municipalité', 'Duhamel', 'Papineau', 'Outaouais'),
(155, 85030, 'Municipalité', 'Duhamel-Ouest', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(156, 69075, 'Canton', 'Dundee', 'Le Haut-Saint-Laurent', 'Montérégie'),
(157, 46050, 'Ville', 'Dunham', 'Brome-Missisquoi', 'Montérégie'),
(158, 87005, 'Ville', 'Duparquet', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(159, 87085, 'Municipalité', 'Dupuy', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(160, 49015, 'Municipalité', 'Durham-Sud', 'Drummond', 'Centre-du-Québec'),
(161, 41060, 'Ville', 'East Angus', 'Le Haut-Saint-François', 'Estrie'),
(162, 31122, 'Municipalité', 'East Broughton', 'Les Appalaches', 'Chaudière-Appalaches'),
(163, 46085, 'Municipalité', 'East Farnham', 'Brome-Missisquoi', 'Montérégie'),
(164, 44010, 'Municipalité', 'East Hereford', 'Coaticook', 'Estrie'),
(165, 45093, 'Municipalité', 'Eastman', 'Memphrémagog', 'Estrie'),
(166, 83075, 'Municipalité', 'Egan-Sud', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(167, 69050, 'Municipalité', 'Elgin', 'Le Haut-Saint-Laurent', 'Montérégie'),
(168, 62053, 'Municipalité', 'Entrelacs', 'Matawinie', 'Lanaudière'),
(169, 6025, 'Municipalité', 'Escuminac', 'Avignon', 'Gaspésie–Îles-de-la-Madeleine'),
(170, 10005, 'Municipalité', 'Esprit-Saint', 'Rimouski-Neigette', 'Bas-Saint-Laurent'),
(171, 77011, 'Ville', 'Estérel', 'Les Pays-d''en-Haut', 'Laurentides'),
(172, 46112, 'Ville', 'Farnham', 'Brome-Missisquoi', 'Montérégie'),
(173, 80005, 'Municipalité', 'Fassett', 'Papineau', 'Outaouais'),
(174, 94220, 'Municipalité', 'Ferland-et-Boilleau', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(175, 79097, 'Municipalité', 'Ferme-Neuve', 'Antoine-Labelle', 'Laurentides'),
(176, 97035, 'Ville', 'Fermont', 'Caniapiscau', 'Côte-Nord'),
(177, 95045, 'Ville', 'Forestville', 'La Haute-Côte-Nord', 'Côte-Nord'),
(178, 84060, 'Village', 'Fort-Coulonge', 'Pontiac', 'Outaouais'),
(179, 38047, 'Municipalité', 'Fortierville', 'Bécancour', 'Centre-du-Québec'),
(180, 22010, 'Ville', 'Fossambault-sur-le-Lac', 'La Jacques-Cartier \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(181, 26005, 'Municipalité', 'Frampton', 'La Nouvelle-Beauce', 'Chaudière-Appalaches'),
(182, 69010, 'Municipalité', 'Franklin', 'Le Haut-Saint-Laurent', 'Montérégie'),
(183, 96015, 'Municipalité', 'Franquelin', 'Manicouagan', 'Côte-Nord'),
(184, 46010, 'Municipalité', 'Frelighsburg', 'Brome-Missisquoi', 'Montérégie'),
(185, 30025, 'Municipalité', 'Frontenac', 'Le Granit', 'Estrie'),
(186, 85055, 'Municipalité', 'Fugèreville', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(187, 87020, 'Municipalité', 'Gallichan', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(188, 3005, 'Ville', 'Gaspé', 'La Côte-de-Gaspé', 'Gaspésie–Îles-de-la-Madeleine'),
(189, 81017, 'Ville', 'Gatineau', 'Hors MRC', 'Outaouais'),
(190, 92055, 'Municipalité', 'Girardville', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(191, 96010, 'Village', 'Godbout', 'Manicouagan', 'Côte-Nord'),
(192, 69060, 'Canton', 'Godmanchester', 'Le Haut-Saint-Laurent', 'Montérégie'),
(193, 76025, 'Canton', 'Gore', 'Argenteuil', 'Laurentides'),
(194, 83032, 'Ville', 'Gracefield', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(195, 47017, 'Ville', 'Granby', 'La Haute-Yamaska', 'Montérégie'),
(196, 9060, 'Municipalité', 'Grand-Métis', 'La Mitis', 'Bas-Saint-Laurent'),
(197, 83095, 'Municipalité', 'Grand-Remous', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(198, 50065, 'Municipalité', 'Grand-Saint-Esprit', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(199, 2015, 'Ville', 'Grande-Rivière', 'Le Rocher-Percé', 'Gaspésie–Îles-de-la-Madeleine'),
(200, 3020, 'Municipalité', 'Grande-Vallée', 'La Côte-de-Gaspé', 'Gaspésie–Îles-de-la-Madeleine'),
(201, 35040, 'Village', 'Grandes-Piles', 'Mékinac', 'Mauricie'),
(202, 76055, 'Village', 'Grenville', 'Argenteuil', 'Laurentides'),
(203, 76052, 'Municipalité', 'Grenville-sur-la-Rouge', 'Argenteuil', 'Laurentides'),
(204, 98014, 'Municipalité', 'Gros-Mécatina', 'Le Golfe-du-Saint-Laurent', 'Côte-Nord'),
(205, 1042, 'Municipalité', 'Grosse-Île', 'Hors MRC', 'Gaspésie–Îles-de-la-Madeleine'),
(206, 8015, 'Municipalité', 'Grosses-Roches', 'La Matanie', 'Bas-Saint-Laurent'),
(207, 85095, 'Canton', 'Guérin', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(208, 39010, 'Canton', 'Ham-Nord', 'Arthabaska', 'Centre-du-Québec'),
(209, 40005, 'Municipalité', 'Ham-Sud', 'Les Sources', 'Estrie'),
(210, 41075, 'Canton', 'Hampden', 'Le Haut-Saint-François', 'Estrie'),
(211, 66062, 'Ville', 'Hampstead', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(212, 76065, 'Canton', 'Harrington', 'Argenteuil', 'Laurentides'),
(214, 45043, 'Municipalité', 'Hatley', 'Memphrémagog', 'Estrie'),
(215, 69005, 'Canton', 'Havelock', 'Le Haut-Saint-Laurent', 'Montérégie'),
(216, 98040, 'Municipalité', 'Havre-Saint-Pierre', 'Minganie', 'Côte-Nord'),
(217, 93020, 'Municipalité', 'Hébertville', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(218, 93025, 'Village', 'Hébertville-Station', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(219, 68015, 'Canton', 'Hemmingford', 'Les Jardins-de-Napierville', 'Montérégie'),
(220, 68010, 'Village', 'Hemmingford', 'Les Jardins-de-Napierville', 'Montérégie'),
(221, 56042, 'Municipalité', 'Henryville', 'Le Haut-Richelieu', 'Montérégie'),
(222, 35035, 'Paroisse', 'Hérouxville', 'Mékinac', 'Mauricie'),
(223, 69045, 'Municipalité', 'Hinchinbrooke', 'Le Haut-Saint-Laurent', 'Montérégie'),
(224, 19070, 'Municipalité', 'Honfleur', 'Bellechasse', 'Chaudière-Appalaches'),
(225, 5025, 'Canton', 'Hope', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(226, 5020, 'Municipalité', 'Hope Town', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(227, 69025, 'Municipalité', 'Howick', 'Le Haut-Saint-Laurent', 'Montérégie'),
(228, 78065, 'Municipalité', 'Huberdeau', 'Les Laurentides', 'Laurentides'),
(229, 71100, 'Ville', 'Hudson', 'Vaudreuil-Soulanges \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(230, 69055, 'Ville', 'Huntingdon', 'Le Haut-Saint-Laurent', 'Montérégie'),
(231, 32058, 'Municipalité', 'Inverness', 'L''Érable', 'Centre-du-Québec'),
(232, 31040, 'Municipalité', 'Irlande', 'Les Appalaches', 'Chaudière-Appalaches'),
(233, 78042, 'Municipalité', 'Ivry-sur-le-Lac', 'Les Laurentides', 'Laurentides'),
(234, 61025, 'Ville', 'Joliette', 'Joliette', 'Lanaudière'),
(235, 14050, 'Municipalité', 'Kamouraska', 'Kamouraska', 'Bas-Saint-Laurent'),
(236, 83015, 'Municipalité', 'Kazabazua', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(237, 79025, 'Municipalité', 'Kiamika', 'Antoine-Labelle', 'Laurentides'),
(238, 42070, 'Village', 'Kingsbury', 'Le Val-Saint-François', 'Estrie'),
(239, 39097, 'Ville', 'Kingsey Falls', 'Arthabaska', 'Centre-du-Québec'),
(240, 31105, 'Municipalité', 'Kinnear''s Mills', 'Les Appalaches', 'Chaudière-Appalaches'),
(241, 85010, 'Municipalité', 'Kipawa', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(242, 66102, 'Ville', 'Kirkland', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(243, 23057, 'Ville', 'L''Ancienne-Lorette', 'Hors MRC \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(244, 82005, 'Municipalité', 'L''Ange-Gardien', 'Les Collines-de-l''Outaouais', 'Outaouais'),
(245, 21040, 'Municipalité', 'L''Ange-Gardien', 'La Côte-de-Beaupré \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(246, 94210, 'Municipalité', 'L''Anse-Saint-Jean', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(247, 79050, 'Municipalité', 'L''Ascension', 'Antoine-Labelle', 'Laurentides'),
(248, 93065, 'Paroisse', 'L''Ascension-de-Notre-Seigneur', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(249, 6060, 'Municipalité', 'L''Ascension-de-Patapédia', 'Avignon', 'Gaspésie–Îles-de-la-Madeleine'),
(250, 60028, 'Ville', 'L''Assomption', 'L''Assomption \\ Communauté métropolitaine de Montréal', 'Lanaudière'),
(251, 49025, 'Municipalité', 'L''Avenir', 'Drummond', 'Centre-du-Québec'),
(252, 60040, 'Paroisse', 'L''Épiphanie', 'L''Assomption', 'Lanaudière'),
(253, 60035, 'Ville', 'L''Épiphanie', 'L''Assomption', 'Lanaudière'),
(254, 71095, 'Ville', 'L''Île-Cadieux', 'Vaudreuil-Soulanges \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(255, 98020, 'Municipalité', 'L''Île-d''Anticosti', 'Minganie', 'Côte-Nord'),
(256, 66092, 'Ville', 'L''Île-Dorval', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(257, 84035, 'Municipalité', 'L''Île-du-Grand-Calumet', 'Pontiac', 'Outaouais'),
(258, 71060, 'Ville', 'L''Île-Perrot', 'Vaudreuil-Soulanges \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(259, 84082, 'Municipalité', 'L''Isle-aux-Allumettes', 'Pontiac', 'Outaouais'),
(260, 16023, 'Municipalité', 'L''Isle-aux-Coudres', 'Charlevoix', 'Capitale-Nationale'),
(261, 12043, 'Municipalité', 'L''Isle-Verte', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(262, 17078, 'Municipalité', 'L''Islet', 'L''Islet', 'Chaudière-Appalaches'),
(263, 90017, 'Municipalité', 'La Bostonnais', 'Hors MRC', 'Mauricie'),
(264, 78115, 'Municipalité', 'La Conception', 'Les Laurentides', 'Laurentides'),
(265, 88030, 'Municipalité', 'La Corne', 'Abitibi', 'Abitibi-Témiscamingue'),
(266, 91050, 'Paroisse', 'La Doré', 'Le Domaine-du-Roy', 'Saguenay–Lac-Saint-Jean'),
(267, 19090, 'Paroisse', 'La Durantaye', 'Bellechasse', 'Chaudière-Appalaches'),
(268, 29030, 'Village', 'La Guadeloupe', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(269, 79047, 'Municipalité', 'La Macaza', 'Antoine-Labelle', 'Laurentides'),
(270, 15013, 'Ville', 'La Malbaie', 'Charlevoix-Est', 'Capitale-Nationale'),
(271, 4030, 'Municipalité', 'La Martre', 'La Haute-Gaspésie', 'Gaspésie–Îles-de-la-Madeleine'),
(272, 78130, 'Municipalité', 'La Minerve', 'Les Laurentides', 'Laurentides'),
(273, 88015, 'Municipalité', 'La Morandière', 'Abitibi', 'Abitibi-Témiscamingue'),
(274, 88045, 'Municipalité', 'La Motte', 'Abitibi', 'Abitibi-Témiscamingue'),
(275, 41027, 'Municipalité', 'La Patrie', 'Le Haut-Saint-François', 'Estrie'),
(276, 82035, 'Municipalité', 'La Pêche', 'Les Collines-de-l''Outaouais', 'Outaouais'),
(277, 14085, 'Ville', 'La Pocatière', 'Kamouraska', 'Bas-Saint-Laurent'),
(278, 67015, 'Ville', 'La Prairie', 'Roussillon \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(279, 54035, 'Municipalité', 'La Présentation', 'Les Maskoutains', 'Montérégie'),
(280, 9005, 'Paroisse', 'La Rédemption', 'La Mitis', 'Bas-Saint-Laurent'),
(281, 87080, 'Municipalité', 'La Reine', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(282, 87090, 'Ville', 'La Sarre', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(283, 10010, 'Paroisse', 'La Trinité-des-Monts', 'Rimouski-Neigette', 'Bas-Saint-Laurent'),
(284, 90012, 'Ville', 'La Tuque', 'Hors MRC', 'Mauricie'),
(285, 52050, 'Municipalité', 'La Visitation-de-l''Île-Dupas', 'D''Autray', 'Lanaudière'),
(286, 50085, 'Municipalité', 'La Visitation-de-Yamaska', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(287, 78120, 'Municipalité', 'Labelle', 'Les Laurentides', 'Laurentides'),
(288, 93055, 'Municipalité', 'Labrecque', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(289, 7057, 'Municipalité', 'Lac-au-Saumon', 'La Matapédia', 'Bas-Saint-Laurent'),
(290, 35010, 'Paroisse', 'Lac-aux-Sables', 'Mékinac', 'Mauricie'),
(291, 22040, 'Municipalité', 'Lac-Beauport', 'La Jacques-Cartier \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(292, 91005, 'Municipalité', 'Lac-Bouchette', 'Le Domaine-du-Roy', 'Saguenay–Lac-Saint-Jean'),
(293, 46075, 'Ville', 'Lac-Brome', 'Brome-Missisquoi', 'Montérégie'),
(294, 22030, 'Ville', 'Lac-Delage', 'La Jacques-Cartier \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(295, 13060, 'Municipalité', 'Lac-des-Aigles', 'Témiscouata', 'Bas-Saint-Laurent'),
(296, 79078, 'Municipalité', 'Lac-des-Écorces', 'Antoine-Labelle', 'Laurentides'),
(297, 80130, 'Municipalité', 'Lac-des-Plages', 'Papineau', 'Outaouais'),
(298, 77055, 'Municipalité', 'Lac-des-Seize-Îles', 'Les Pays-d''en-Haut', 'Laurentides'),
(299, 30080, 'Municipalité', 'Lac-Drolet', 'Le Granit', 'Estrie'),
(300, 79015, 'Municipalité', 'Lac-du-Cerf', 'Antoine-Labelle', 'Laurentides'),
(301, 90027, 'Municipalité', 'Lac-Édouard', 'Hors MRC', 'Mauricie'),
(302, 28053, 'Municipalité', 'Lac-Etchemin', 'Les Etchemins', 'Chaudière-Appalaches'),
(303, 18010, 'Municipalité', 'Lac-Frontière', 'Montmagny', 'Chaudière-Appalaches'),
(304, 30030, 'Ville', 'Lac-Mégantic', 'Le Granit', 'Estrie'),
(305, 29095, 'Village', 'Lac-Poulin', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(306, 79060, 'Village', 'Lac-Saguay', 'Antoine-Labelle', 'Laurentides'),
(307, 22015, 'Ville', 'Lac-Saint-Joseph', 'La Jacques-Cartier \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(308, 79105, 'Municipalité', 'Lac-Saint-Paul', 'Antoine-Labelle', 'Laurentides'),
(309, 83020, 'Municipalité', 'Lac-Sainte-Marie', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(310, 34120, 'Ville', 'Lac-Sergent', 'Portneuf', 'Capitale-Nationale'),
(311, 80095, 'Municipalité', 'Lac-Simon', 'Papineau', 'Outaouais'),
(312, 78095, 'Municipalité', 'Lac-Supérieur', 'Les Laurentides', 'Laurentides'),
(313, 78127, 'Municipalité', 'Lac-Tremblant-Nord', 'Les Laurentides', 'Laurentides'),
(314, 76020, 'Ville', 'Lachute', 'Argenteuil', 'Laurentides'),
(315, 56023, 'Municipalité', 'Lacolle', 'Le Haut-Richelieu', 'Montérégie'),
(316, 85070, 'Municipalité', 'Laforce', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(317, 93060, 'Municipalité', 'Lamarche', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(318, 30095, 'Municipalité', 'Lambton', 'Le Granit', 'Estrie'),
(319, 88035, 'Canton', 'Landrienne', 'Abitibi', 'Abitibi-Témiscamingue'),
(320, 52017, 'Municipalité', 'Lanoraie', 'D''Autray', 'Lanaudière'),
(321, 78015, 'Municipalité', 'Lantier', 'Les Laurentides', 'Laurentides'),
(322, 94265, 'Municipalité', 'Larouche', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(323, 85060, 'Cantons unis', 'Latulipe-et-Gaboury', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(324, 88080, 'Canton', 'Launay', 'Abitibi', 'Abitibi-Témiscamingue'),
(325, 33060, 'Village', 'Laurier-Station', 'Lotbinière', 'Chaudière-Appalaches'),
(326, 32072, 'Municipalité', 'Laurierville', 'L''Érable', 'Centre-du-Québec'),
(327, 65005, 'Ville', 'Laval', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Laval'),
(328, 52007, 'Ville', 'Lavaltrie', 'D''Autray', 'Lanaudière'),
(329, 85050, 'Municipalité', 'Laverlochère', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(330, 42045, 'Village', 'Lawrenceville', 'Le Val-Saint-François', 'Estrie'),
(331, 99005, 'Ville', 'Lebel-sur-Quévillon', 'Hors MRC', 'Nord-du-Québec'),
(332, 33123, 'Municipalité', 'Leclercville', 'Lotbinière', 'Chaudière-Appalaches'),
(333, 49020, 'Municipalité', 'Lefebvre', 'Drummond', 'Centre-du-Québec'),
(334, 13050, 'Municipalité', 'Lejeune', 'Témiscouata', 'Bas-Saint-Laurent'),
(335, 38020, 'Municipalité', 'Lemieux', 'Bécancour', 'Centre-du-Québec'),
(336, 67055, 'Ville', 'Léry', 'Roussillon \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(337, 95018, 'Municipalité', 'Les Bergeronnes', 'La Haute-Côte-Nord', 'Côte-Nord'),
(338, 71050, 'Municipalité', 'Les Cèdres', 'Vaudreuil-Soulanges \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(339, 71033, 'Municipalité', 'Les Coteaux', 'Vaudreuil-Soulanges', 'Montérégie'),
(340, 16048, 'Municipalité', 'Les Éboulements', 'Charlevoix', 'Capitale-Nationale'),
(341, 95025, 'Municipalité', 'Les Escoumins', 'La Haute-Côte-Nord', 'Côte-Nord'),
(342, 9015, 'Municipalité', 'Les Hauteurs', 'La Mitis', 'Bas-Saint-Laurent'),
(343, 1023, 'Municipalité', 'Les Îles-de-la-Madeleine', 'Hors MRC', 'Gaspésie–Îles-de-la-Madeleine'),
(344, 8005, 'Municipalité', 'Les Méchins', 'La Matanie', 'Bas-Saint-Laurent'),
(345, 25213, 'Ville', 'Lévis', 'Hors MRC \\ Communauté métropolitaine de Québec', 'Chaudière-Appalaches'),
(346, 41085, 'Canton', 'Lingwick', 'Le Haut-Saint-François', 'Estrie'),
(347, 84040, 'Municipalité', 'Litchfield', 'Pontiac', 'Outaouais'),
(348, 80055, 'Canton', 'Lochaber', 'Papineau', 'Outaouais'),
(349, 80060, 'Canton', 'Lochaber-Partie-Ouest', 'Papineau', 'Outaouais'),
(350, 98045, 'Municipalité', 'Longue-Pointe-de-Mingan', 'Minganie', 'Côte-Nord'),
(351, 95032, 'Municipalité', 'Longue-Rive', 'La Haute-Côte-Nord', 'Côte-Nord'),
(352, 58227, 'Ville', 'Longueuil', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(353, 73025, 'Ville', 'Lorraine', 'Thérèse-De Blainville \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(354, 85037, 'Municipalité', 'Lorrainville', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(355, 33115, 'Municipalité', 'Lotbinière', 'Lotbinière', 'Chaudière-Appalaches'),
(356, 51015, 'Ville', 'Louiseville', 'Maskinongé', 'Mauricie'),
(357, 83010, 'Canton', 'Low', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(358, 32065, 'Municipalité', 'Lyster', 'L''Érable', 'Centre-du-Québec'),
(359, 87058, 'Ville', 'Macamic', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(360, 39165, 'Canton', 'Maddington', 'Arthabaska', 'Centre-du-Québec'),
(361, 45072, 'Ville', 'Magog', 'Memphrémagog', 'Estrie'),
(362, 89015, 'Ville', 'Malartic', 'La Vallée-de-l''Or', 'Abitibi-Témiscamingue'),
(363, 52095, 'Municipalité', 'Mandeville', 'D''Autray', 'Lanaudière'),
(364, 83065, 'Ville', 'Maniwaki', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(365, 38028, 'Municipalité', 'Manseau', 'Bécancour', 'Centre-du-Québec'),
(366, 84065, 'Municipalité', 'Mansfield-et-Pontefract', 'Pontiac', 'Outaouais'),
(367, 6005, 'Municipalité', 'Maria', 'Avignon', 'Gaspésie–Îles-de-la-Madeleine'),
(368, 42065, 'Municipalité', 'Maricourt', 'Le Val-Saint-François', 'Estrie'),
(369, 55048, 'Ville', 'Marieville', 'Rouville', 'Montérégie'),
(370, 4025, 'Village', 'Marsoui', 'La Haute-Gaspésie', 'Gaspésie–Îles-de-la-Madeleine'),
(371, 30035, 'Canton', 'Marston', 'Le Granit', 'Estrie'),
(372, 44060, 'Municipalité', 'Martinville', 'Coaticook', 'Estrie'),
(373, 64015, 'Ville', 'Mascouche', 'Les Moulins \\ Communauté métropolitaine de Montréal', 'Lanaudière'),
(374, 51008, 'Municipalité', 'Maskinongé', 'Maskinongé', 'Mauricie'),
(375, 53010, 'Village', 'Massueville', 'Pierre-De Saurel', 'Montérégie'),
(376, 99015, 'Ville', 'Matagami', 'Hors MRC', 'Nord-du-Québec'),
(377, 8053, 'Ville', 'Matane', 'La Matanie', 'Bas-Saint-Laurent'),
(378, 6045, 'Municipalité', 'Matapédia', 'Avignon', 'Gaspésie–Îles-de-la-Madeleine'),
(379, 80065, 'Municipalité', 'Mayo', 'Papineau', 'Outaouais'),
(380, 57025, 'Municipalité', 'McMasterville', 'La Vallée-du-Richelieu \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(381, 42075, 'Canton', 'Melbourne', 'Le Val-Saint-François', 'Estrie'),
(382, 67045, 'Ville', 'Mercier', 'Roussillon \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(383, 83060, 'Municipalité', 'Messines', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(384, 93012, 'Ville', 'Métabetchouan–Lac-à-la-Croix', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(385, 9048, 'Ville', 'Métis-sur-Mer', 'La Mitis', 'Bas-Saint-Laurent'),
(386, 30040, 'Municipalité', 'Milan', 'Le Granit', 'Estrie'),
(387, 76030, 'Municipalité', 'Mille-Isles', 'Argenteuil', 'Laurentides'),
(388, 74005, 'Ville', 'Mirabel', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(389, 85075, 'Municipalité', 'Moffet', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(390, 14005, 'Municipalité', 'Mont-Carmel', 'Kamouraska', 'Bas-Saint-Laurent'),
(391, 9077, 'Ville', 'Mont-Joli', 'La Mitis', 'Bas-Saint-Laurent'),
(392, 79088, 'Ville', 'Mont-Laurier', 'Antoine-Labelle', 'Laurentides'),
(393, 66072, 'Ville', 'Mont-Royal', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(394, 56097, 'Municipalité', 'Mont-Saint-Grégoire', 'Le Haut-Richelieu', 'Montérégie'),
(395, 57035, 'Ville', 'Mont-Saint-Hilaire', 'La Vallée-du-Richelieu \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(396, 79110, 'Municipalité', 'Mont-Saint-Michel', 'Antoine-Labelle', 'Laurentides'),
(397, 4015, 'Village', 'Mont-Saint-Pierre', 'La Haute-Gaspésie', 'Gaspésie–Îles-de-la-Madeleine'),
(398, 78102, 'Ville', 'Mont-Tremblant', 'Les Laurentides', 'Laurentides'),
(399, 78055, 'Municipalité', 'Montcalm', 'Les Laurentides', 'Laurentides'),
(400, 83088, 'Municipalité', 'Montcerf-Lytton', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(401, 80010, 'Municipalité', 'Montebello', 'Papineau', 'Outaouais'),
(402, 18050, 'Ville', 'Montmagny', 'Montmagny', 'Chaudière-Appalaches'),
(403, 80090, 'Municipalité', 'Montpellier', 'Papineau', 'Outaouais'),
(404, 66023, 'Ville', 'Montréal', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(405, 66007, 'Ville', 'Montréal-Est', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(406, 66047, 'Ville', 'Montréal-Ouest', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(407, 77050, 'Municipalité', 'Morin-Heights', 'Les Pays-d''en-Haut', 'Laurentides'),
(408, 80085, 'Municipalité', 'Mulgrave-et-Derry', 'Papineau', 'Outaouais'),
(409, 3025, 'Ville', 'Murdochville', 'La Côte-de-Gaspé', 'Gaspésie–Îles-de-la-Madeleine'),
(410, 80110, 'Municipalité', 'Namur', 'Papineau', 'Outaouais'),
(411, 30045, 'Municipalité', 'Nantes', 'Le Granit', 'Estrie'),
(412, 68030, 'Municipalité', 'Napierville', 'Les Jardins-de-Napierville', 'Montérégie'),
(413, 98025, 'Canton', 'Natashquan', 'Minganie', 'Côte-Nord'),
(414, 85100, 'Canton', 'Nédélec', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(415, 34007, 'Ville', 'Neuville', 'Portneuf', 'Capitale-Nationale'),
(416, 5040, 'Municipalité', 'New Carlisle', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(417, 5070, 'Ville', 'New Richmond', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(418, 41037, 'Municipalité', 'Newport', 'Le Haut-Saint-François', 'Estrie'),
(419, 50072, 'Ville', 'Nicolet', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(420, 79030, 'Municipalité', 'Nominingue', 'Antoine-Labelle', 'Laurentides'),
(421, 92040, 'Ville', 'Normandin', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(422, 87115, 'Municipalité', 'Normétal', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(423, 45050, 'Village', 'North Hatley', 'Memphrémagog', 'Estrie'),
(424, 19010, 'Paroisse', 'Notre-Dame-Auxiliatrice-de-Buckland', 'Bellechasse', 'Chaudière-Appalaches'),
(425, 80015, 'Municipalité', 'Notre-Dame-de-Bonsecours', 'Papineau', 'Outaouais'),
(426, 39015, 'Municipalité', 'Notre-Dame-de-Ham', 'Arthabaska', 'Centre-du-Québec'),
(427, 71065, 'Ville', 'Notre-Dame-de-l''Île-Perrot', 'Vaudreuil-Soulanges \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(428, 62055, 'Municipalité', 'Notre-Dame-de-la-Merci', 'Matawinie', 'Lanaudière'),
(429, 80020, 'Municipalité', 'Notre-Dame-de-la-Paix', 'Papineau', 'Outaouais'),
(430, 82010, 'Municipalité', 'Notre-Dame-de-la-Salette', 'Les Collines-de-l''Outaouais', 'Outaouais'),
(431, 92060, 'Municipalité', 'Notre-Dame-de-Lorette', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(432, 61045, 'Municipalité', 'Notre-Dame-de-Lourdes', 'Joliette', 'Lanaudière'),
(433, 32080, 'Paroisse', 'Notre-Dame-de-Lourdes', 'L''Érable', 'Centre-du-Québec'),
(434, 35005, 'Municipalité', 'Notre-Dame-de-Montauban', 'Mékinac', 'Mauricie'),
(435, 79010, 'Municipalité', 'Notre-Dame-de-Pontmain', 'Antoine-Labelle', 'Laurentides'),
(436, 46100, 'Municipalité', 'Notre-Dame-de-Stanbridge', 'Brome-Missisquoi', 'Montérégie'),
(437, 23015, 'Paroisse', 'Notre-Dame-des-Anges', 'Hors MRC', 'Capitale-Nationale'),
(438, 30010, 'Municipalité', 'Notre-Dame-des-Bois', 'Le Granit', 'Estrie'),
(439, 15025, 'Municipalité', 'Notre-Dame-des-Monts', 'Charlevoix-Est', 'Capitale-Nationale'),
(440, 11045, 'Municipalité', 'Notre-Dame-des-Neiges', 'Les Basques', 'Bas-Saint-Laurent'),
(441, 29120, 'Paroisse', 'Notre-Dame-des-Pins', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(442, 61030, 'Ville', 'Notre-Dame-des-Prairies', 'Joliette', 'Lanaudière'),
(443, 12045, 'Paroisse', 'Notre-Dame-des-Sept-Douleurs', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(444, 49080, 'Paroisse', 'Notre-Dame-du-Bon-Conseil', 'Drummond', 'Centre-du-Québec'),
(445, 49075, 'Village', 'Notre-Dame-du-Bon-Conseil', 'Drummond', 'Centre-du-Québec'),
(446, 79005, 'Municipalité', 'Notre-Dame-du-Laus', 'Antoine-Labelle', 'Laurentides'),
(447, 37235, 'Paroisse', 'Notre-Dame-du-Mont-Carmel', 'Les Chenaux', 'Mauricie'),
(448, 85090, 'Municipalité', 'Notre-Dame-du-Nord', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(449, 12080, 'Municipalité', 'Notre-Dame-du-Portage', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(450, 18040, 'Municipalité', 'Notre-Dame-du-Rosaire', 'Montmagny', 'Chaudière-Appalaches'),
(451, 33085, 'Paroisse', 'Notre-Dame-du-Sacré-Coeur-d''Issoudun', 'Lotbinière', 'Chaudière-Appalaches'),
(452, 6020, 'Municipalité', 'Nouvelle', 'Avignon', 'Gaspésie–Îles-de-la-Madeleine'),
(453, 56015, 'Municipalité', 'Noyan', 'Le Haut-Richelieu', 'Montérégie'),
(454, 45020, 'Municipalité', 'Ogden', 'Memphrémagog', 'Estrie'),
(455, 72032, 'Municipalité', 'Oka', 'Deux-Montagnes \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(456, 45115, 'Canton', 'Orford', 'Memphrémagog', 'Estrie'),
(457, 69037, 'Municipalité', 'Ormstown', 'Le Haut-Saint-Laurent', 'Montérégie'),
(458, 84055, 'Municipalité', 'Otter Lake', 'Pontiac', 'Outaouais'),
(459, 57030, 'Ville', 'Otterburn Park', 'La Vallée-du-Richelieu \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(460, 13015, 'Paroisse', 'Packington', 'Témiscouata', 'Bas-Saint-Laurent'),
(461, 9040, 'Municipalité', 'Padoue', 'La Mitis', 'Bas-Saint-Laurent'),
(462, 87025, 'Municipalité', 'Palmarolle', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(463, 80037, 'Municipalité', 'Papineauville', 'Papineau', 'Outaouais'),
(464, 38055, 'Paroisse', 'Parisville', 'Bécancour', 'Centre-du-Québec'),
(465, 5032, 'Ville', 'Paspébiac', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(466, 2005, 'Ville', 'Percé', 'Le Rocher-Percé', 'Gaspésie–Îles-de-la-Madeleine'),
(467, 92010, 'Municipalité', 'Péribonka', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(468, 94205, 'Municipalité', 'Petit-Saguenay', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(469, 16005, 'Municipalité', 'Petite-Rivière-Saint-François', 'Charlevoix', 'Capitale-Nationale'),
(470, 3015, 'Municipalité', 'Petite-Vallée', 'La Côte-de-Gaspé', 'Gaspésie–Îles-de-la-Madeleine'),
(471, 77030, 'Municipalité', 'Piedmont', 'Les Pays-d''en-Haut', 'Laurentides'),
(472, 50113, 'Municipalité', 'Pierreville', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(473, 46025, 'Municipalité', 'Pike River', 'Brome-Missisquoi', 'Montérégie'),
(474, 71070, 'Ville', 'Pincourt', 'Vaudreuil-Soulanges \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(475, 30020, 'Municipalité', 'Piopolis', 'Le Granit', 'Estrie'),
(476, 80045, 'Municipalité', 'Plaisance', 'Papineau', 'Outaouais'),
(477, 32045, 'Paroisse', 'Plessisville', 'L''Érable', 'Centre-du-Québec'),
(478, 32040, 'Ville', 'Plessisville', 'L''Érable', 'Centre-du-Québec'),
(479, 13095, 'Ville', 'Pohénégamook', 'Témiscouata', 'Bas-Saint-Laurent'),
(480, 6030, 'Municipalité', 'Pointe-à-la-Croix', 'Avignon', 'Gaspésie–Îles-de-la-Madeleine'),
(481, 96030, 'Village', 'Pointe-aux-Outardes', 'Manicouagan', 'Côte-Nord'),
(482, 72020, 'Municipalité', 'Pointe-Calumet', 'Deux-Montagnes \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(483, 66097, 'Ville', 'Pointe-Claire', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(484, 71055, 'Village', 'Pointe-des-Cascades', 'Vaudreuil-Soulanges \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(485, 71140, 'Village', 'Pointe-Fortune', 'Vaudreuil-Soulanges', 'Montérégie'),
(486, 96025, 'Village', 'Pointe-Lebel', 'Manicouagan', 'Côte-Nord'),
(487, 34017, 'Ville', 'Pont-Rouge', 'Portneuf', 'Capitale-Nationale'),
(488, 82030, 'Municipalité', 'Pontiac', 'Les Collines-de-l''Outaouais', 'Outaouais'),
(489, 97022, 'Ville', 'Port-Cartier', 'Sept-Rivières', 'Côte-Nord'),
(490, 2047, 'Municipalité', 'Port-Daniel–Gascons', 'Le Rocher-Percé', 'Gaspésie–Îles-de-la-Madeleine'),
(491, 84020, 'Village', 'Portage-du-Fort', 'Pontiac', 'Outaouais'),
(492, 34048, 'Ville', 'Portneuf', 'Portneuf', 'Capitale-Nationale'),
(493, 95040, 'Municipalité', 'Portneuf-sur-Mer', 'La Haute-Côte-Nord', 'Côte-Nord'),
(494, 45030, 'Canton', 'Potton', 'Memphrémagog', 'Estrie'),
(495, 87035, 'Municipalité', 'Poularies', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(496, 88090, 'Municipalité', 'Preissac', 'Abitibi', 'Abitibi-Témiscamingue'),
(497, 75040, 'Ville', 'Prévost', 'La Rivière-du-Nord', 'Laurentides'),
(498, 9065, 'Village', 'Price', 'La Mitis', 'Bas-Saint-Laurent'),
(499, 32033, 'Ville', 'Princeville', 'L''Érable', 'Centre-du-Québec'),
(500, 23027, 'Ville', 'Québec', 'Hors MRC \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(501, 42032, 'Municipalité', 'Racine', 'Le Val-Saint-François', 'Estrie'),
(502, 96040, 'Paroisse', 'Ragueneau', 'Manicouagan', 'Côte-Nord'),
(503, 87010, 'Municipalité', 'Rapide-Danseur', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(504, 84100, 'Municipalité', 'Rapides-des-Joachims', 'Pontiac', 'Outaouais'),
(505, 62037, 'Municipalité', 'Rawdon', 'Matawinie', 'Lanaudière'),
(506, 85105, 'Municipalité', 'Rémigny', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(507, 60013, 'Ville', 'Repentigny', 'L''Assomption \\ Communauté métropolitaine de Montréal', 'Lanaudière'),
(508, 55057, 'Ville', 'Richelieu', 'Rouville \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(509, 42098, 'Ville', 'Richmond', 'Le Val-Saint-François', 'Estrie'),
(510, 71133, 'Municipalité', 'Rigaud', 'Vaudreuil-Soulanges', 'Montérégie'),
(511, 10043, 'Ville', 'Rimouski', 'Rimouski-Neigette', 'Bas-Saint-Laurent'),
(512, 80078, 'Municipalité', 'Ripon', 'Papineau', 'Outaouais'),
(513, 6035, 'Canton', 'Ristigouche-Partie-Sud-Est', 'Avignon', 'Gaspésie–Îles-de-la-Madeleine'),
(514, 4020, 'Municipalité', 'Rivière-à-Claude', 'La Haute-Gaspésie', 'Gaspésie–Îles-de-la-Madeleine'),
(515, 34135, 'Municipalité', 'Rivière-à-Pierre', 'Portneuf', 'Capitale-Nationale'),
(516, 98055, 'Municipalité', 'Rivière-au-Tonnerre', 'Minganie', 'Côte-Nord'),
(517, 71005, 'Municipalité', 'Rivière-Beaudette', 'Vaudreuil-Soulanges', 'Montérégie'),
(518, 13025, 'Municipalité', 'Rivière-Bleue', 'Témiscouata', 'Bas-Saint-Laurent'),
(519, 12072, 'Ville', 'Rivière-du-Loup', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(520, 94215, 'Municipalité', 'Rivière-Éternité', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(521, 89010, 'Municipalité', 'Rivière-Héva', 'La Vallée-de-l''Or', 'Abitibi-Témiscamingue'),
(522, 14065, 'Municipalité', 'Rivière-Ouelle', 'Kamouraska', 'Bas-Saint-Laurent'),
(523, 79037, 'Ville', 'Rivière-Rouge', 'Antoine-Labelle', 'Laurentides'),
(524, 98050, 'Municipalité', 'Rivière-Saint-Jean', 'Minganie', 'Côte-Nord'),
(525, 91025, 'Ville', 'Roberval', 'Le Domaine-du-Roy', 'Saguenay–Lac-Saint-Jean'),
(526, 88010, 'Municipalité', 'Rochebaucourt', 'Abitibi', 'Abitibi-Témiscamingue'),
(527, 87015, 'Municipalité', 'Roquemaure', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(528, 73020, 'Ville', 'Rosemère', 'Thérèse-De Blainville \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(529, 55037, 'Municipalité', 'Rougemont', 'Rouville', 'Montérégie'),
(530, 86042, 'Ville', 'Rouyn-Noranda', 'Hors MRC', 'Abitibi-Témiscamingue'),
(531, 48015, 'Canton', 'Roxton', 'Acton', 'Montérégie'),
(532, 48010, 'Village', 'Roxton Falls', 'Acton', 'Montérégie'),
(533, 47047, 'Municipalité', 'Roxton Pond', 'La Haute-Yamaska', 'Montérégie'),
(534, 95010, 'Municipalité', 'Sacré-Coeur', 'La Haute-Côte-Nord', 'Côte-Nord'),
(535, 31130, 'Paroisse', 'Sacré-Coeur-de-Jésus', 'Les Appalaches', 'Chaudière-Appalaches'),
(536, 94068, 'Ville', 'Saguenay', 'Hors MRC', 'Saguenay–Lac-Saint-Jean'),
(537, 17015, 'Municipalité', 'Saint-Adalbert', 'L''Islet', 'Chaudière-Appalaches'),
(538, 8030, 'Paroisse', 'Saint-Adelme', 'La Matanie', 'Bas-Saint-Laurent'),
(539, 35015, 'Paroisse', 'Saint-Adelphe', 'Mékinac', 'Mauricie'),
(540, 77065, 'Municipalité', 'Saint-Adolphe-d''Howard', 'Les Pays-d''en-Haut', 'Laurentides'),
(541, 40010, 'Municipalité', 'Saint-Adrien', 'Les Sources', 'Estrie'),
(542, 31095, 'Municipalité', 'Saint-Adrien-d''Irlande', 'Les Appalaches', 'Chaudière-Appalaches'),
(543, 33045, 'Municipalité', 'Saint-Agapit', 'Lotbinière', 'Chaudière-Appalaches'),
(544, 53015, 'Municipalité', 'Saint-Aimé', 'Pierre-De Saurel', 'Montérégie'),
(545, 15030, 'Municipalité', 'Saint-Aimé-des-Lacs', 'Charlevoix-Est', 'Capitale-Nationale'),
(546, 79022, 'Municipalité', 'Saint-Aimé-du-Lac-des-Îles', 'Antoine-Labelle', 'Laurentides'),
(547, 34097, 'Municipalité', 'Saint-Alban', 'Portneuf', 'Capitale-Nationale'),
(548, 39085, 'Municipalité', 'Saint-Albert', 'Arthabaska', 'Centre-du-Québec'),
(549, 56055, 'Municipalité', 'Saint-Alexandre', 'Le Haut-Richelieu', 'Montérégie'),
(550, 14035, 'Municipalité', 'Saint-Alexandre-de-Kamouraska', 'Kamouraska', 'Bas-Saint-Laurent'),
(551, 7065, 'Paroisse', 'Saint-Alexandre-des-Lacs', 'La Matapédia', 'Bas-Saint-Laurent'),
(552, 63023, 'Municipalité', 'Saint-Alexis', 'Montcalm', 'Lanaudière'),
(553, 6050, 'Municipalité', 'Saint-Alexis-de-Matapédia', 'Avignon', 'Gaspésie–Îles-de-la-Madeleine'),
(554, 51065, 'Paroisse', 'Saint-Alexis-des-Monts', 'Maskinongé', 'Mauricie'),
(555, 27015, 'Municipalité', 'Saint-Alfred', 'Robert-Cliche', 'Chaudière-Appalaches'),
(556, 5065, 'Municipalité', 'Saint-Alphonse', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(557, 47010, 'Municipalité', 'Saint-Alphonse-de-Granby', 'La Haute-Yamaska', 'Montérégie'),
(558, 62025, 'Municipalité', 'Saint-Alphonse-Rodriguez', 'Matawinie', 'Lanaudière'),
(559, 59015, 'Municipalité', 'Saint-Amable', 'Marguerite-D''Youville \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(560, 94255, 'Municipalité', 'Saint-Ambroise', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(561, 61040, 'Paroisse', 'Saint-Ambroise-de-Kildare', 'Joliette', 'Lanaudière'),
(562, 10030, 'Paroisse', 'Saint-Anaclet-de-Lessard', 'Rimouski-Neigette', 'Bas-Saint-Laurent'),
(563, 14040, 'Municipalité', 'Saint-André', 'Kamouraska', 'Bas-Saint-Laurent'),
(564, 80027, 'Municipalité', 'Saint-André-Avellin', 'Papineau', 'Outaouais'),
(565, 76008, 'Municipalité', 'Saint-André-d''Argenteuil', 'Argenteuil', 'Laurentides'),
(566, 6040, 'Municipalité', 'Saint-André-de-Restigouche', 'Avignon', 'Gaspésie–Îles-de-la-Madeleine'),
(567, 91010, 'Village', 'Saint-André-du-Lac-Saint-Jean', 'Le Domaine-du-Roy', 'Saguenay–Lac-Saint-Jean'),
(568, 69070, 'Municipalité', 'Saint-Anicet', 'Le Haut-Saint-Laurent', 'Montérégie'),
(569, 19062, 'Municipalité', 'Saint-Anselme', 'Bellechasse', 'Chaudière-Appalaches'),
(570, 18070, 'Paroisse', 'Saint-Antoine-de-l''Isle-aux-Grues', 'Montmagny', 'Chaudière-Appalaches'),
(571, 33095, 'Municipalité', 'Saint-Antoine-de-Tilly', 'Lotbinière', 'Chaudière-Appalaches'),
(572, 57075, 'Municipalité', 'Saint-Antoine-sur-Richelieu', 'La Vallée-du-Richelieu', 'Montérégie'),
(573, 12015, 'Paroisse', 'Saint-Antonin', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(574, 33090, 'Municipalité', 'Saint-Apollinaire', 'Lotbinière', 'Chaudière-Appalaches'),
(575, 46017, 'Municipalité', 'Saint-Armand', 'Brome-Missisquoi', 'Montérégie'),
(576, 12065, 'Paroisse', 'Saint-Arsène', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(577, 13100, 'Municipalité', 'Saint-Athanase', 'Témiscouata', 'Bas-Saint-Laurent'),
(578, 17055, 'Municipalité', 'Saint-Aubert', 'L''Islet', 'Chaudière-Appalaches'),
(579, 98012, 'Municipalité', 'Saint-Augustin', 'Le Golfe-du-Saint-Laurent', 'Côte-Nord'),
(580, 92005, 'Paroisse', 'Saint-Augustin', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(581, 23072, 'Ville', 'Saint-Augustin-de-Desmaures', 'Hors MRC \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(582, 30005, 'Paroisse', 'Saint-Augustin-de-Woburn', 'Le Granit', 'Estrie'),
(583, 51025, 'Paroisse', 'Saint-Barnabé', 'Maskinongé', 'Mauricie'),
(584, 54105, 'Municipalité', 'Saint-Barnabé-Sud', 'Les Maskoutains', 'Montérégie'),
(585, 52055, 'Paroisse', 'Saint-Barthélemy', 'D''Autray', 'Lanaudière'),
(586, 34038, 'Ville', 'Saint-Basile', 'Portneuf', 'Capitale-Nationale'),
(587, 57020, 'Ville', 'Saint-Basile-le-Grand', 'La Vallée-du-Richelieu \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(588, 28025, 'Municipalité', 'Saint-Benjamin', 'Les Etchemins', 'Chaudière-Appalaches'),
(589, 45080, 'Municipalité', 'Saint-Benoît-du-Lac', 'Memphrémagog', 'Estrie'),
(590, 29100, 'Municipalité', 'Saint-Benoît-Labre', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(591, 26055, 'Municipalité', 'Saint-Bernard', 'La Nouvelle-Beauce', 'Chaudière-Appalaches'),
(592, 68005, 'Paroisse', 'Saint-Bernard-de-Lacolle', 'Les Jardins-de-Napierville', 'Montérégie'),
(593, 54115, 'Municipalité', 'Saint-Bernard-de-Michaudville', 'Les Maskoutains', 'Montérégie'),
(594, 56065, 'Municipalité', 'Saint-Blaise-sur-Richelieu', 'Le Haut-Richelieu', 'Montérégie'),
(595, 49125, 'Municipalité', 'Saint-Bonaventure', 'Drummond', 'Centre-du-Québec'),
(596, 51085, 'Municipalité', 'Saint-Boniface', 'Maskinongé', 'Mauricie'),
(597, 93030, 'Municipalité', 'Saint-Bruno', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(598, 85045, 'Municipalité', 'Saint-Bruno-de-Guigues', 'Témiscamingue', 'Abitibi-Témiscamingue');
INSERT INTO `villes` (`no_ville`, `code`, `designation`, `municipalite`, `mrc`, `region`) VALUES
(599, 14010, 'Municipalité', 'Saint-Bruno-de-Kamouraska', 'Kamouraska', 'Bas-Saint-Laurent'),
(600, 58037, 'Ville', 'Saint-Bruno-de-Montarville', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(601, 63055, 'Municipalité', 'Saint-Calixte', 'Montcalm', 'Lanaudière'),
(602, 40025, 'Canton', 'Saint-Camille', 'Les Sources', 'Estrie'),
(603, 28070, 'Paroisse', 'Saint-Camille-de-Lellis', 'Les Etchemins', 'Chaudière-Appalaches'),
(604, 34078, 'Municipalité', 'Saint-Casimir', 'Portneuf', 'Capitale-Nationale'),
(605, 50035, 'Municipalité', 'Saint-Célestin', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(606, 50030, 'Village', 'Saint-Célestin', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(607, 55023, 'Ville', 'Saint-Césaire', 'Rouville', 'Montérégie'),
(608, 61035, 'Municipalité', 'Saint-Charles-Borromée', 'Joliette', 'Lanaudière'),
(609, 19097, 'Municipalité', 'Saint-Charles-de-Bellechasse', 'Bellechasse', 'Chaudière-Appalaches'),
(610, 94260, 'Municipalité', 'Saint-Charles-de-Bourget', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(611, 9010, 'Paroisse', 'Saint-Charles-Garnier', 'La Mitis', 'Bas-Saint-Laurent'),
(612, 57057, 'Municipalité', 'Saint-Charles-sur-Richelieu', 'La Vallée-du-Richelieu', 'Montérégie'),
(613, 39060, 'Paroisse', 'Saint-Christophe-d''Arthabaska', 'Arthabaska', 'Centre-du-Québec'),
(614, 69017, 'Municipalité', 'Saint-Chrysostome', 'Le Haut-Saint-Laurent', 'Montérégie'),
(615, 42100, 'Municipalité', 'Saint-Claude', 'Le Val-Saint-François', 'Estrie'),
(616, 11005, 'Paroisse', 'Saint-Clément', 'Les Basques', 'Bas-Saint-Laurent'),
(617, 7090, 'Paroisse', 'Saint-Cléophas', 'La Matapédia', 'Bas-Saint-Laurent'),
(618, 52075, 'Municipalité', 'Saint-Cléophas-de-Brandon', 'D''Autray', 'Lanaudière'),
(619, 71045, 'Municipalité', 'Saint-Clet', 'Vaudreuil-Soulanges', 'Montérégie'),
(620, 75005, 'Ville', 'Saint-Colomban', 'La Rivière-du-Nord', 'Laurentides'),
(621, 62065, 'Paroisse', 'Saint-Côme', 'Matawinie', 'Lanaudière'),
(622, 29057, 'Municipalité', 'Saint-Côme–Linière', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(623, 67035, 'Ville', 'Saint-Constant', 'Roussillon \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(624, 52062, 'Municipalité', 'Saint-Cuthbert', 'D''Autray', 'Lanaudière'),
(625, 28040, 'Paroisse', 'Saint-Cyprien', 'Les Etchemins', 'Chaudière-Appalaches'),
(626, 12005, 'Municipalité', 'Saint-Cyprien', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(627, 68035, 'Municipalité', 'Saint-Cyprien-de-Napierville', 'Les Jardins-de-Napierville', 'Montérégie'),
(628, 17045, 'Paroisse', 'Saint-Cyrille-de-Lessard', 'L''Islet', 'Chaudière-Appalaches'),
(629, 49070, 'Municipalité', 'Saint-Cyrille-de-Wendover', 'Drummond', 'Centre-du-Québec'),
(630, 54017, 'Municipalité', 'Saint-Damase', 'Les Maskoutains', 'Montérégie'),
(631, 7105, 'Paroisse', 'Saint-Damase', 'La Matapédia', 'Bas-Saint-Laurent'),
(632, 17040, 'Municipalité', 'Saint-Damase-de-L''Islet', 'L''Islet', 'Chaudière-Appalaches'),
(633, 62075, 'Paroisse', 'Saint-Damien', 'Matawinie', 'Lanaudière'),
(634, 19030, 'Paroisse', 'Saint-Damien-de-Buckland', 'Bellechasse', 'Chaudière-Appalaches'),
(635, 53005, 'Municipalité', 'Saint-David', 'Pierre-De Saurel', 'Montérégie'),
(636, 94245, 'Municipalité', 'Saint-David-de-Falardeau', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(637, 14055, 'Municipalité', 'Saint-Denis-De La Bouteillerie', 'Kamouraska', 'Bas-Saint-Laurent'),
(638, 42025, 'Municipalité', 'Saint-Denis-de-Brompton', 'Le Val-Saint-François', 'Estrie'),
(639, 57068, 'Municipalité', 'Saint-Denis-sur-Richelieu', 'La Vallée-du-Richelieu', 'Montérégie'),
(640, 52090, 'Paroisse', 'Saint-Didace', 'D''Autray', 'Lanaudière'),
(641, 54060, 'Municipalité', 'Saint-Dominique', 'Les Maskoutains', 'Montérégie'),
(642, 88065, 'Municipalité', 'Saint-Dominique-du-Rosaire', 'Abitibi', 'Abitibi-Témiscamingue'),
(643, 9030, 'Paroisse', 'Saint-Donat', 'La Mitis', 'Bas-Saint-Laurent'),
(644, 62060, 'Municipalité', 'Saint-Donat', 'Matawinie', 'Lanaudière'),
(645, 49100, 'Paroisse', 'Saint-Edmond-de-Grantham', 'Drummond', 'Centre-du-Québec'),
(646, 92050, 'Municipalité', 'Saint-Edmond-les-Plaines', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(647, 68045, 'Municipalité', 'Saint-Édouard', 'Les Jardins-de-Napierville', 'Montérégie'),
(648, 85015, 'Paroisse', 'Saint-Édouard-de-Fabre', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(649, 33080, 'Paroisse', 'Saint-Édouard-de-Lotbinière', 'Lotbinière', 'Chaudière-Appalaches'),
(650, 51050, 'Municipalité', 'Saint-Édouard-de-Maskinongé', 'Maskinongé', 'Mauricie'),
(651, 51075, 'Municipalité', 'Saint-Élie-de-Caxton', 'Maskinongé', 'Mauricie'),
(652, 11035, 'Paroisse', 'Saint-Éloi', 'Les Basques', 'Bas-Saint-Laurent'),
(653, 50095, 'Paroisse', 'Saint-Elphège', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(654, 26022, 'Municipalité', 'Saint-Elzéar', 'La Nouvelle-Beauce', 'Chaudière-Appalaches'),
(655, 5050, 'Municipalité', 'Saint-Elzéar', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(656, 13085, 'Municipalité', 'Saint-Elzéar-de-Témiscouata', 'Témiscouata', 'Bas-Saint-Laurent'),
(657, 80125, 'Municipalité', 'Saint-Émile-de-Suffolk', 'Papineau', 'Outaouais'),
(658, 29112, 'Municipalité', 'Saint-Éphrem-de-Beauce', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(659, 12030, 'Municipalité', 'Saint-Épiphane', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(660, 63030, 'Municipalité', 'Saint-Esprit', 'Montcalm', 'Lanaudière'),
(661, 70030, 'Municipalité', 'Saint-Étienne-de-Beauharnois', 'Beauharnois-Salaberry', 'Montérégie'),
(662, 45100, 'Municipalité', 'Saint-Étienne-de-Bolton', 'Memphrémagog', 'Estrie'),
(663, 51090, 'Paroisse', 'Saint-Étienne-des-Grès', 'Maskinongé', 'Mauricie'),
(664, 49105, 'Municipalité', 'Saint-Eugène', 'Drummond', 'Centre-du-Québec'),
(665, 92065, 'Municipalité', 'Saint-Eugène-d''Argentenay', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(666, 85085, 'Municipalité', 'Saint-Eugène-de-Guigues', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(667, 10075, 'Paroisse', 'Saint-Eugène-de-Ladrière', 'Rimouski-Neigette', 'Bas-Saint-Laurent'),
(668, 13030, 'Paroisse', 'Saint-Eusèbe', 'Témiscouata', 'Bas-Saint-Laurent'),
(669, 72005, 'Ville', 'Saint-Eustache', 'Deux-Montagnes \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(670, 29025, 'Municipalité', 'Saint-Évariste-de-Forsyth', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(671, 10070, 'Paroisse', 'Saint-Fabien', 'Rimouski-Neigette', 'Bas-Saint-Laurent'),
(672, 18015, 'Paroisse', 'Saint-Fabien-de-Panet', 'Montmagny', 'Chaudière-Appalaches'),
(673, 78047, 'Municipalité', 'Saint-Faustin–Lac-Carré', 'Les Laurentides', 'Laurentides'),
(674, 91042, 'Ville', 'Saint-Félicien', 'Le Domaine-du-Roy', 'Saguenay–Lac-Saint-Jean'),
(675, 94225, 'Municipalité', 'Saint-Félix-d''Otis', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(676, 88060, 'Municipalité', 'Saint-Félix-de-Dalquier', 'Abitibi', 'Abitibi-Témiscamingue'),
(677, 49005, 'Municipalité', 'Saint-Félix-de-Kingsey', 'Drummond', 'Centre-du-Québec'),
(678, 62007, 'Municipalité', 'Saint-Félix-de-Valois', 'Matawinie', 'Lanaudière'),
(679, 32013, 'Municipalité', 'Saint-Ferdinand', 'L''Érable', 'Centre-du-Québec'),
(680, 21010, 'Municipalité', 'Saint-Ferréol-les-Neiges', 'La Côte-de-Beaupré \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(681, 33052, 'Municipalité', 'Saint-Flavien', 'Lotbinière', 'Chaudière-Appalaches'),
(682, 31030, 'Municipalité', 'Saint-Fortunat', 'Les Appalaches', 'Chaudière-Appalaches'),
(683, 6055, 'Municipalité', 'Saint-François-d''Assise', 'Avignon', 'Gaspésie–Îles-de-la-Madeleine'),
(684, 20005, 'Municipalité', 'Saint-François-de-l''Île-d''Orléans', 'L''Île-d''Orléans \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(685, 18060, 'Municipalité', 'Saint-François-de-la-Rivière-du-Sud', 'Montmagny', 'Chaudière-Appalaches'),
(686, 91015, 'Municipalité', 'Saint-François-de-Sales', 'Le Domaine-du-Roy', 'Saguenay–Lac-Saint-Jean'),
(687, 50128, 'Municipalité', 'Saint-François-du-Lac', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(688, 42020, 'Municipalité', 'Saint-François-Xavier-de-Brompton', 'Le Val-Saint-François', 'Estrie'),
(689, 12025, 'Municipalité', 'Saint-François-Xavier-de-Viger', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(690, 27065, 'Paroisse', 'Saint-Frédéric', 'Robert-Cliche', 'Chaudière-Appalaches'),
(691, 94235, 'Municipalité', 'Saint-Fulgence', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(692, 52080, 'Ville', 'Saint-Gabriel', 'D''Autray', 'Lanaudière'),
(693, 52085, 'Paroisse', 'Saint-Gabriel-de-Brandon', 'D''Autray', 'Lanaudière'),
(694, 9025, 'Municipalité', 'Saint-Gabriel-de-Rimouski', 'La Mitis', 'Bas-Saint-Laurent'),
(695, 22025, 'Municipalité', 'Saint-Gabriel-de-Valcartier', 'La Jacques-Cartier \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(696, 14075, 'Municipalité', 'Saint-Gabriel-Lalemant', 'Kamouraska', 'Bas-Saint-Laurent'),
(697, 93035, 'Municipalité', 'Saint-Gédéon', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(698, 29013, 'Municipalité', 'Saint-Gédéon-de-Beauce', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(699, 29073, 'Ville', 'Saint-Georges', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(700, 56010, 'Municipalité', 'Saint-Georges-de-Clarenceville', 'Le Haut-Richelieu', 'Montérégie'),
(701, 40032, 'Municipalité', 'Saint-Georges-de-Windsor', 'Les Sources', 'Estrie'),
(702, 53085, 'Paroisse', 'Saint-Gérard-Majella', 'Pierre-De Saurel', 'Montérégie'),
(703, 14045, 'Paroisse', 'Saint-Germain', 'Kamouraska', 'Bas-Saint-Laurent'),
(704, 49048, 'Municipalité', 'Saint-Germain-de-Grantham', 'Drummond', 'Centre-du-Québec'),
(705, 19075, 'Municipalité', 'Saint-Gervais', 'Bellechasse', 'Chaudière-Appalaches'),
(706, 34060, 'Paroisse', 'Saint-Gilbert', 'Portneuf', 'Capitale-Nationale'),
(707, 33035, 'Paroisse', 'Saint-Gilles', 'Lotbinière', 'Chaudière-Appalaches'),
(708, 5015, 'Canton', 'Saint-Godefroi', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(709, 49113, 'Municipalité', 'Saint-Guillaume', 'Drummond', 'Centre-du-Québec'),
(710, 11020, 'Municipalité', 'Saint-Guy', 'Les Basques', 'Bas-Saint-Laurent'),
(711, 19068, 'Municipalité', 'Saint-Henri', 'Bellechasse', 'Chaudière-Appalaches'),
(712, 93070, 'Municipalité', 'Saint-Henri-de-Taillon', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(713, 44015, 'Municipalité', 'Saint-Herménégilde', 'Coaticook', 'Estrie'),
(714, 29020, 'Paroisse', 'Saint-Hilaire-de-Dorset', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(715, 16050, 'Paroisse', 'Saint-Hilarion', 'Charlevoix', 'Capitale-Nationale'),
(716, 75045, 'Municipalité', 'Saint-Hippolyte', 'La Rivière-du-Nord', 'Laurentides'),
(717, 94240, 'Municipalité', 'Saint-Honoré', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(718, 29038, 'Municipalité', 'Saint-Honoré-de-Shenley', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(719, 13090, 'Municipalité', 'Saint-Honoré-de-Témiscouata', 'Témiscouata', 'Bas-Saint-Laurent'),
(720, 12010, 'Municipalité', 'Saint-Hubert-de-Rivière-du-Loup', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(721, 54100, 'Municipalité', 'Saint-Hugues', 'Les Maskoutains', 'Montérégie'),
(722, 54048, 'Ville', 'Saint-Hyacinthe', 'Les Maskoutains', 'Montérégie'),
(723, 52045, 'Municipalité', 'Saint-Ignace-de-Loyola', 'D''Autray', 'Lanaudière'),
(724, 46095, 'Municipalité', 'Saint-Ignace-de-Stanbridge', 'Brome-Missisquoi', 'Montérégie'),
(725, 15005, 'Paroisse', 'Saint-Irénée', 'Charlevoix-Est', 'Capitale-Nationale'),
(726, 67040, 'Paroisse', 'Saint-Isidore', 'Roussillon \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(727, 26063, 'Municipalité', 'Saint-Isidore', 'La Nouvelle-Beauce', 'Chaudière-Appalaches'),
(728, 41012, 'Municipalité', 'Saint-Isidore-de-Clifton', 'Le Haut-Saint-François', 'Estrie'),
(729, 63013, 'Municipalité', 'Saint-Jacques', 'Montcalm', 'Lanaudière'),
(730, 31140, 'Municipalité', 'Saint-Jacques-de-Leeds', 'Les Appalaches', 'Chaudière-Appalaches'),
(731, 31025, 'Paroisse', 'Saint-Jacques-le-Majeur-de-Wolfestown', 'Les Appalaches', 'Chaudière-Appalaches'),
(732, 68040, 'Municipalité', 'Saint-Jacques-le-Mineur', 'Les Jardins-de-Napierville', 'Montérégie'),
(733, 33065, 'Municipalité', 'Saint-Janvier-de-Joly', 'Lotbinière', 'Chaudière-Appalaches'),
(734, 57033, 'Municipalité', 'Saint-Jean-Baptiste', 'La Vallée-du-Richelieu \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(735, 31100, 'Municipalité', 'Saint-Jean-de-Brébeuf', 'Les Appalaches', 'Chaudière-Appalaches'),
(736, 8010, 'Paroisse', 'Saint-Jean-de-Cherbourg', 'La Matanie', 'Bas-Saint-Laurent'),
(737, 11010, 'Municipalité', 'Saint-Jean-de-Dieu', 'Les Basques', 'Bas-Saint-Laurent'),
(738, 20015, 'Municipalité', 'Saint-Jean-de-l''Île-d''Orléans', 'L''Île-d''Orléans \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(739, 13010, 'Municipalité', 'Saint-Jean-de-la-Lande', 'Témiscouata', 'Bas-Saint-Laurent'),
(740, 62015, 'Municipalité', 'Saint-Jean-de-Matha', 'Matawinie', 'Lanaudière'),
(741, 17070, 'Municipalité', 'Saint-Jean-Port-Joli', 'L''Islet', 'Chaudière-Appalaches'),
(742, 56083, 'Ville', 'Saint-Jean-sur-Richelieu', 'Le Haut-Richelieu', 'Montérégie'),
(743, 75017, 'Ville', 'Saint-Jérôme', 'La Rivière-du-Nord', 'Laurentides'),
(744, 21020, 'Paroisse', 'Saint-Joachim', 'La Côte-de-Beaupré \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(745, 47040, 'Municipalité', 'Saint-Joachim-de-Shefford', 'La Haute-Yamaska', 'Montérégie'),
(746, 27043, 'Ville', 'Saint-Joseph-de-Beauce', 'Robert-Cliche', 'Chaudière-Appalaches'),
(747, 31045, 'Municipalité', 'Saint-Joseph-de-Coleraine', 'Les Appalaches', 'Chaudière-Appalaches'),
(748, 14030, 'Paroisse', 'Saint-Joseph-de-Kamouraska', 'Kamouraska', 'Bas-Saint-Laurent'),
(749, 9070, 'Paroisse', 'Saint-Joseph-de-Lepage', 'La Mitis', 'Bas-Saint-Laurent'),
(750, 53050, 'Ville', 'Saint-Joseph-de-Sorel', 'Pierre-De Saurel', 'Montérégie'),
(751, 27050, 'Municipalité', 'Saint-Joseph-des-Érables', 'Robert-Cliche', 'Chaudière-Appalaches'),
(752, 72025, 'Municipalité', 'Saint-Joseph-du-Lac', 'Deux-Montagnes \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(753, 54110, 'Municipalité', 'Saint-Jude', 'Les Maskoutains', 'Montérégie'),
(754, 27055, 'Paroisse', 'Saint-Jules', 'Robert-Cliche', 'Chaudière-Appalaches'),
(755, 31035, 'Municipalité', 'Saint-Julien', 'Les Appalaches', 'Chaudière-Appalaches'),
(756, 18005, 'Municipalité', 'Saint-Just-de-Bretenières', 'Montmagny', 'Chaudière-Appalaches'),
(757, 13040, 'Municipalité', 'Saint-Juste-du-Lac', 'Témiscouata', 'Bas-Saint-Laurent'),
(758, 51045, 'Paroisse', 'Saint-Justin', 'Maskinongé', 'Mauricie'),
(759, 58012, 'Ville', 'Saint-Lambert', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(760, 87120, 'Paroisse', 'Saint-Lambert', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(761, 26070, 'Municipalité', 'Saint-Lambert-de-Lauzon', 'La Nouvelle-Beauce', 'Chaudière-Appalaches'),
(762, 20020, 'Municipalité', 'Saint-Laurent-de-l''Île-d''Orléans', 'L''Île-d''Orléans \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(763, 71105, 'Ville', 'Saint-Lazare', 'Vaudreuil-Soulanges \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(764, 19050, 'Municipalité', 'Saint-Lazare-de-Bellechasse', 'Bellechasse', 'Chaudière-Appalaches'),
(765, 8065, 'Paroisse', 'Saint-Léandre', 'La Matanie', 'Bas-Saint-Laurent'),
(766, 19020, 'Paroisse', 'Saint-Léon-de-Standon', 'Bellechasse', 'Chaudière-Appalaches'),
(767, 7030, 'Paroisse', 'Saint-Léon-le-Grand', 'La Matapédia', 'Bas-Saint-Laurent'),
(768, 51035, 'Paroisse', 'Saint-Léon-le-Grand', 'Maskinongé', 'Mauricie'),
(769, 50042, 'Municipalité', 'Saint-Léonard-d''Aston', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(770, 34115, 'Municipalité', 'Saint-Léonard-de-Portneuf', 'Portneuf', 'Capitale-Nationale'),
(771, 54072, 'Municipalité', 'Saint-Liboire', 'Les Maskoutains', 'Montérégie'),
(772, 63065, 'Paroisse', 'Saint-Liguori', 'Montcalm', 'Lanaudière'),
(773, 63048, 'Ville', 'Saint-Lin–Laurentides', 'Montcalm', 'Lanaudière'),
(774, 54120, 'Municipalité', 'Saint-Louis', 'Les Maskoutains', 'Montérégie'),
(775, 39170, 'Municipalité', 'Saint-Louis-de-Blandford', 'Arthabaska', 'Centre-du-Québec'),
(776, 70035, 'Paroisse', 'Saint-Louis-de-Gonzague', 'Beauharnois-Salaberry', 'Montérégie'),
(777, 28035, 'Municipalité', 'Saint-Louis-de-Gonzague', 'Les Etchemins', 'Chaudière-Appalaches'),
(778, 21015, 'Paroisse', 'Saint-Louis-de-Gonzague-du-Cap-Tourmente', 'La Côte-de-Beaupré \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(779, 13080, 'Paroisse', 'Saint-Louis-du-Ha! Ha!', 'Témiscouata', 'Bas-Saint-Laurent'),
(780, 28060, 'Municipalité', 'Saint-Luc-de-Bellechasse', 'Les Etchemins', 'Chaudière-Appalaches'),
(781, 37225, 'Municipalité', 'Saint-Luc-de-Vincennes', 'Les Chenaux', 'Mauricie'),
(782, 49030, 'Municipalité', 'Saint-Lucien', 'Drummond', 'Centre-du-Québec'),
(783, 30072, 'Municipalité', 'Saint-Ludger', 'Le Granit', 'Estrie'),
(784, 93080, 'Municipalité', 'Saint-Ludger-de-Milot', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(785, 28075, 'Municipalité', 'Saint-Magloire', 'Les Etchemins', 'Chaudière-Appalaches'),
(786, 49095, 'Paroisse', 'Saint-Majorique-de-Grantham', 'Drummond', 'Centre-du-Québec'),
(787, 19025, 'Paroisse', 'Saint-Malachie', 'Bellechasse', 'Chaudière-Appalaches'),
(788, 44003, 'Municipalité', 'Saint-Malo', 'Coaticook', 'Estrie'),
(789, 88040, 'Paroisse', 'Saint-Marc-de-Figuery', 'Abitibi', 'Abitibi-Témiscamingue'),
(790, 34065, 'Ville', 'Saint-Marc-des-Carrières', 'Portneuf', 'Capitale-Nationale'),
(791, 13020, 'Paroisse', 'Saint-Marc-du-Lac-Long', 'Témiscouata', 'Bas-Saint-Laurent'),
(792, 57050, 'Municipalité', 'Saint-Marc-sur-Richelieu', 'La Vallée-du-Richelieu', 'Montérégie'),
(793, 17020, 'Municipalité', 'Saint-Marcel', 'L''Islet', 'Chaudière-Appalaches'),
(794, 54125, 'Municipalité', 'Saint-Marcel-de-Richelieu', 'Les Maskoutains', 'Montérégie'),
(795, 10025, 'Paroisse', 'Saint-Marcellin', 'Rimouski-Neigette', 'Bas-Saint-Laurent'),
(796, 29045, 'Paroisse', 'Saint-Martin', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(797, 55065, 'Municipalité', 'Saint-Mathias-sur-Richelieu', 'Rouville \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(798, 67005, 'Municipalité', 'Saint-Mathieu', 'Roussillon \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(799, 88050, 'Municipalité', 'Saint-Mathieu-d''Harricana', 'Abitibi', 'Abitibi-Témiscamingue'),
(800, 57045, 'Municipalité', 'Saint-Mathieu-de-Beloeil', 'La Vallée-du-Richelieu \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(801, 11050, 'Paroisse', 'Saint-Mathieu-de-Rioux', 'Les Basques', 'Bas-Saint-Laurent'),
(802, 51070, 'Municipalité', 'Saint-Mathieu-du-Parc', 'Maskinongé', 'Mauricie'),
(803, 37230, 'Paroisse', 'Saint-Maurice', 'Les Chenaux', 'Mauricie'),
(804, 4010, 'Municipalité', 'Saint-Maxime-du-Mont-Louis', 'La Haute-Gaspésie', 'Gaspésie–Îles-de-la-Madeleine'),
(805, 11025, 'Municipalité', 'Saint-Médard', 'Les Basques', 'Bas-Saint-Laurent'),
(806, 68050, 'Municipalité', 'Saint-Michel', 'Les Jardins-de-Napierville', 'Montérégie'),
(807, 19110, 'Municipalité', 'Saint-Michel-de-Bellechasse', 'Bellechasse', 'Chaudière-Appalaches'),
(808, 62085, 'Municipalité', 'Saint-Michel-des-Saints', 'Matawinie', 'Lanaudière'),
(809, 13065, 'Paroisse', 'Saint-Michel-du-Squatec', 'Témiscouata', 'Bas-Saint-Laurent'),
(810, 12020, 'Municipalité', 'Saint-Modeste', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(811, 7095, 'Paroisse', 'Saint-Moïse', 'La Matapédia', 'Bas-Saint-Laurent'),
(812, 37240, 'Paroisse', 'Saint-Narcisse', 'Les Chenaux', 'Mauricie'),
(813, 33030, 'Paroisse', 'Saint-Narcisse-de-Beaurivage', 'Lotbinière', 'Chaudière-Appalaches'),
(814, 10015, 'Paroisse', 'Saint-Narcisse-de-Rimouski', 'Rimouski-Neigette', 'Bas-Saint-Laurent'),
(815, 93045, 'Municipalité', 'Saint-Nazaire', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(816, 48050, 'Paroisse', 'Saint-Nazaire-d''Acton', 'Acton', 'Montérégie'),
(817, 19015, 'Paroisse', 'Saint-Nazaire-de-Dorchester', 'Bellechasse', 'Chaudière-Appalaches'),
(818, 19045, 'Municipalité', 'Saint-Nérée-de-Bellechasse', 'Bellechasse', 'Chaudière-Appalaches'),
(819, 7100, 'Village', 'Saint-Noël', 'La Matapédia', 'Bas-Saint-Laurent'),
(820, 52070, 'Paroisse', 'Saint-Norbert', 'D''Autray', 'Lanaudière'),
(821, 39043, 'Municipalité', 'Saint-Norbert-d''Arthabaska', 'Arthabaska', 'Centre-du-Québec'),
(822, 9055, 'Paroisse', 'Saint-Octave-de-Métis', 'La Mitis', 'Bas-Saint-Laurent'),
(823, 27035, 'Paroisse', 'Saint-Odilon-de-Cranbourne', 'Robert-Cliche', 'Chaudière-Appalaches'),
(824, 17005, 'Municipalité', 'Saint-Omer', 'L''Islet', 'Chaudière-Appalaches'),
(825, 14080, 'Municipalité', 'Saint-Onésime-d''Ixworth', 'Kamouraska', 'Bas-Saint-Laurent'),
(826, 53032, 'Ville', 'Saint-Ours', 'Pierre-De Saurel', 'Montérégie'),
(827, 14070, 'Municipalité', 'Saint-Pacôme', 'Kamouraska', 'Bas-Saint-Laurent'),
(828, 17010, 'Ville', 'Saint-Pamphile', 'L''Islet', 'Chaudière-Appalaches'),
(829, 14018, 'Ville', 'Saint-Pascal', 'Kamouraska', 'Bas-Saint-Laurent'),
(830, 33025, 'Municipalité', 'Saint-Patrice-de-Beaurivage', 'Lotbinière', 'Chaudière-Appalaches'),
(831, 68025, 'Municipalité', 'Saint-Patrice-de-Sherrington', 'Les Jardins-de-Napierville', 'Montérégie'),
(832, 61005, 'Municipalité', 'Saint-Paul', 'Joliette', 'Lanaudière'),
(833, 55015, 'Municipalité', 'Saint-Paul-d''Abbotsford', 'Rouville', 'Montérégie'),
(834, 56035, 'Municipalité', 'Saint-Paul-de-l''Île-aux-Noix', 'Le Haut-Richelieu', 'Montérégie'),
(835, 12035, 'Paroisse', 'Saint-Paul-de-la-Croix', 'Rivière-du-Loup', 'Bas-Saint-Laurent'),
(836, 18030, 'Municipalité', 'Saint-Paul-de-Montminy', 'Montmagny', 'Chaudière-Appalaches'),
(837, 51060, 'Municipalité', 'Saint-Paulin', 'Maskinongé', 'Mauricie'),
(838, 19005, 'Paroisse', 'Saint-Philémon', 'Bellechasse', 'Chaudière-Appalaches'),
(839, 29065, 'Municipalité', 'Saint-Philibert', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(840, 67010, 'Municipalité', 'Saint-Philippe', 'Roussillon \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(841, 14060, 'Paroisse', 'Saint-Philippe-de-Néri', 'Kamouraska', 'Bas-Saint-Laurent'),
(842, 54008, 'Ville', 'Saint-Pie', 'Les Maskoutains', 'Montérégie'),
(843, 49130, 'Paroisse', 'Saint-Pie-de-Guire', 'Drummond', 'Centre-du-Québec'),
(844, 61020, 'Village', 'Saint-Pierre', 'Joliette', 'Lanaudière'),
(845, 32050, 'Paroisse', 'Saint-Pierre-Baptiste', 'L''Érable', 'Centre-du-Québec'),
(846, 31135, 'Municipalité', 'Saint-Pierre-de-Broughton', 'Les Appalaches', 'Chaudière-Appalaches'),
(847, 20025, 'Municipalité', 'Saint-Pierre-de-l''Île-d''Orléans', 'L''Île-d''Orléans \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(848, 18055, 'Paroisse', 'Saint-Pierre-de-la-Rivière-du-Sud', 'Montmagny', 'Chaudière-Appalaches'),
(849, 13075, 'Municipalité', 'Saint-Pierre-de-Lamy', 'Témiscouata', 'Bas-Saint-Laurent'),
(850, 38065, 'Municipalité', 'Saint-Pierre-les-Becquets', 'Bécancour', 'Centre-du-Québec'),
(851, 72043, 'Municipalité', 'Saint-Placide', 'Deux-Montagnes', 'Laurentides'),
(852, 71020, 'Municipalité', 'Saint-Polycarpe', 'Vaudreuil-Soulanges', 'Montérégie'),
(853, 91035, 'Municipalité', 'Saint-Prime', 'Le Domaine-du-Roy', 'Saguenay–Lac-Saint-Jean'),
(854, 28020, 'Municipalité', 'Saint-Prosper', 'Les Etchemins', 'Chaudière-Appalaches'),
(855, 37250, 'Municipalité', 'Saint-Prosper-de-Champlain', 'Les Chenaux', 'Mauricie'),
(856, 19082, 'Municipalité', 'Saint-Raphaël', 'Bellechasse', 'Chaudière-Appalaches'),
(857, 34128, 'Ville', 'Saint-Raymond', 'Portneuf', 'Capitale-Nationale'),
(858, 68055, 'Ville', 'Saint-Rémi', 'Les Jardins-de-Napierville', 'Montérégie'),
(859, 39020, 'Municipalité', 'Saint-Rémi-de-Tingwick', 'Arthabaska', 'Centre-du-Québec'),
(860, 29050, 'Paroisse', 'Saint-René', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(861, 8035, 'Municipalité', 'Saint-René-de-Matane', 'La Matanie', 'Bas-Saint-Laurent'),
(862, 53020, 'Municipalité', 'Saint-Robert', 'Pierre-De Saurel', 'Montérégie'),
(863, 30070, 'Municipalité', 'Saint-Robert-Bellarmin', 'Le Granit', 'Estrie'),
(864, 63035, 'Municipalité', 'Saint-Roch-de-l''Achigan', 'Montcalm', 'Lanaudière'),
(865, 35045, 'Paroisse', 'Saint-Roch-de-Mékinac', 'Mékinac', 'Mauricie'),
(866, 53040, 'Municipalité', 'Saint-Roch-de-Richelieu', 'Pierre-De Saurel', 'Montérégie'),
(867, 17065, 'Paroisse', 'Saint-Roch-des-Aulnaies', 'L''Islet', 'Chaudière-Appalaches'),
(868, 63040, 'Municipalité', 'Saint-Roch-Ouest', 'Montcalm', 'Lanaudière'),
(869, 30100, 'Municipalité', 'Saint-Romain', 'Le Granit', 'Estrie'),
(870, 39145, 'Paroisse', 'Saint-Rosaire', 'Arthabaska', 'Centre-du-Québec'),
(871, 39130, 'Municipalité', 'Saint-Samuel', 'Arthabaska', 'Centre-du-Québec'),
(872, 77043, 'Ville', 'Saint-Sauveur', 'Les Pays-d''en-Haut', 'Laurentides'),
(873, 56050, 'Municipalité', 'Saint-Sébastien', 'Le Haut-Richelieu', 'Montérégie'),
(874, 30085, 'Municipalité', 'Saint-Sébastien', 'Le Granit', 'Estrie'),
(875, 51030, 'Paroisse', 'Saint-Sévère', 'Maskinongé', 'Mauricie'),
(876, 35020, 'Paroisse', 'Saint-Séverin', 'Mékinac', 'Mauricie'),
(877, 27070, 'Paroisse', 'Saint-Séverin', 'Robert-Cliche', 'Chaudière-Appalaches'),
(878, 15058, 'Municipalité', 'Saint-Siméon', 'Charlevoix-Est', 'Capitale-Nationale'),
(879, 5055, 'Paroisse', 'Saint-Siméon', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(880, 11055, 'Paroisse', 'Saint-Simon', 'Les Basques', 'Bas-Saint-Laurent'),
(881, 54090, 'Municipalité', 'Saint-Simon', 'Les Maskoutains', 'Montérégie'),
(882, 29125, 'Municipalité', 'Saint-Simon-les-Mines', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(883, 80070, 'Municipalité', 'Saint-Sixte', 'Papineau', 'Outaouais'),
(884, 37245, 'Municipalité', 'Saint-Stanislas', 'Les Chenaux', 'Mauricie'),
(885, 92070, 'Municipalité', 'Saint-Stanislas', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(886, 70040, 'Municipalité', 'Saint-Stanislas-de-Kostka', 'Beauharnois-Salaberry', 'Montérégie'),
(887, 60020, 'Paroisse', 'Saint-Sulpice', 'L''Assomption \\ Communauté métropolitaine de Montréal', 'Lanaudière'),
(888, 38005, 'Municipalité', 'Saint-Sylvère', 'Bécancour', 'Centre-du-Québec'),
(889, 33007, 'Municipalité', 'Saint-Sylvestre', 'Lotbinière', 'Chaudière-Appalaches'),
(890, 71015, 'Municipalité', 'Saint-Télesphore', 'Vaudreuil-Soulanges', 'Montérégie'),
(891, 7070, 'Paroisse', 'Saint-Tharcisius', 'La Matapédia', 'Bas-Saint-Laurent'),
(892, 48045, 'Municipalité', 'Saint-Théodore-d''Acton', 'Acton', 'Montérégie'),
(893, 29005, 'Municipalité', 'Saint-Théophile', 'Beauce-Sartigan', 'Chaudière-Appalaches'),
(894, 61027, 'Municipalité', 'Saint-Thomas', 'Joliette', 'Lanaudière'),
(895, 92045, 'Municipalité', 'Saint-Thomas-Didyme', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(896, 34085, 'Paroisse', 'Saint-Thuribe', 'Portneuf', 'Capitale-Nationale'),
(897, 35027, 'Ville', 'Saint-Tite', 'Mékinac', 'Mauricie'),
(898, 21005, 'Municipalité', 'Saint-Tite-des-Caps', 'La Côte-de-Beaupré \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(899, 34090, 'Municipalité', 'Saint-Ubalde', 'Portneuf', 'Capitale-Nationale'),
(900, 8073, 'Municipalité', 'Saint-Ulric', 'La Matanie', 'Bas-Saint-Laurent'),
(901, 16055, 'Paroisse', 'Saint-Urbain', 'Charlevoix', 'Capitale-Nationale'),
(902, 70005, 'Municipalité', 'Saint-Urbain-Premier', 'Beauharnois-Salaberry', 'Montérégie'),
(903, 56030, 'Municipalité', 'Saint-Valentin', 'Le Haut-Richelieu', 'Montérégie'),
(904, 39135, 'Municipalité', 'Saint-Valère', 'Arthabaska', 'Centre-du-Québec'),
(905, 10060, 'Paroisse', 'Saint-Valérien', 'Rimouski-Neigette', 'Bas-Saint-Laurent'),
(906, 54065, 'Municipalité', 'Saint-Valérien-de-Milton', 'Les Maskoutains', 'Montérégie'),
(907, 19117, 'Municipalité', 'Saint-Vallier', 'Bellechasse', 'Chaudière-Appalaches'),
(908, 44005, 'Municipalité', 'Saint-Venant-de-Paquette', 'Coaticook', 'Estrie'),
(909, 7075, 'Municipalité', 'Saint-Vianney', 'La Matapédia', 'Bas-Saint-Laurent'),
(910, 27008, 'Municipalité', 'Saint-Victor', 'Robert-Cliche', 'Chaudière-Appalaches'),
(911, 50023, 'Municipalité', 'Saint-Wenceslas', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(912, 28005, 'Municipalité', 'Saint-Zacharie', 'Les Etchemins', 'Chaudière-Appalaches'),
(913, 62080, 'Municipalité', 'Saint-Zénon', 'Matawinie', 'Lanaudière'),
(914, 7035, 'Paroisse', 'Saint-Zénon-du-Lac-Humqui', 'La Matapédia', 'Bas-Saint-Laurent'),
(915, 50090, 'Paroisse', 'Saint-Zéphirin-de-Courval', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(916, 71025, 'Municipalité', 'Saint-Zotique', 'Vaudreuil-Soulanges', 'Montérégie'),
(917, 77022, 'Ville', 'Sainte-Adèle', 'Les Pays-d''en-Haut', 'Laurentides'),
(918, 33017, 'Municipalité', 'Sainte-Agathe-de-Lotbinière', 'Lotbinière', 'Chaudière-Appalaches'),
(919, 78032, 'Ville', 'Sainte-Agathe-des-Monts', 'Les Laurentides', 'Laurentides'),
(920, 9035, 'Municipalité', 'Sainte-Angèle-de-Mérici', 'La Mitis', 'Bas-Saint-Laurent'),
(921, 55030, 'Municipalité', 'Sainte-Angèle-de-Monnoir', 'Rouville', 'Montérégie'),
(922, 51055, 'Municipalité', 'Sainte-Angèle-de-Prémont', 'Maskinongé', 'Mauricie'),
(923, 21030, 'Ville', 'Sainte-Anne-de-Beaupré', 'La Côte-de-Beaupré \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(924, 66117, 'Ville', 'Sainte-Anne-de-Bellevue', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(925, 37205, 'Municipalité', 'Sainte-Anne-de-la-Pérade', 'Les Chenaux', 'Mauricie'),
(926, 14090, 'Paroisse', 'Sainte-Anne-de-la-Pocatière', 'Kamouraska', 'Bas-Saint-Laurent'),
(927, 42050, 'Municipalité', 'Sainte-Anne-de-la-Rochelle', 'Le Val-Saint-François', 'Estrie'),
(928, 56060, 'Paroisse', 'Sainte-Anne-de-Sabrevois', 'Le Haut-Richelieu', 'Montérégie'),
(929, 53065, 'Municipalité', 'Sainte-Anne-de-Sorel', 'Pierre-De Saurel', 'Montérégie'),
(930, 77035, 'Paroisse', 'Sainte-Anne-des-Lacs', 'Les Pays-d''en-Haut', 'Laurentides'),
(931, 4037, 'Ville', 'Sainte-Anne-des-Monts', 'La Haute-Gaspésie', 'Gaspésie–Îles-de-la-Madeleine'),
(932, 73035, 'Ville', 'Sainte-Anne-des-Plaines', 'Thérèse-De Blainville \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(933, 79115, 'Municipalité', 'Sainte-Anne-du-Lac', 'Antoine-Labelle', 'Laurentides'),
(934, 39150, 'Municipalité', 'Sainte-Anne-du-Sault', 'Arthabaska', 'Centre-du-Québec'),
(935, 18025, 'Paroisse', 'Sainte-Apolline-de-Patton', 'Montmagny', 'Chaudière-Appalaches'),
(936, 28015, 'Municipalité', 'Sainte-Aurélie', 'Les Etchemins', 'Chaudière-Appalaches'),
(937, 69065, 'Municipalité', 'Sainte-Barbe', 'Le Haut-Saint-Laurent', 'Montérégie'),
(938, 62020, 'Municipalité', 'Sainte-Béatrix', 'Matawinie', 'Lanaudière'),
(939, 56105, 'Municipalité', 'Sainte-Brigide-d''Iberville', 'Le Haut-Richelieu', 'Montérégie'),
(940, 22045, 'Ville', 'Sainte-Brigitte-de-Laval', 'La Jacques-Cartier \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(941, 49085, 'Paroisse', 'Sainte-Brigitte-des-Saults', 'Drummond', 'Centre-du-Québec'),
(942, 67030, 'Ville', 'Sainte-Catherine', 'Roussillon \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(943, 45060, 'Municipalité', 'Sainte-Catherine-de-Hatley', 'Memphrémagog', 'Estrie'),
(944, 22005, 'Ville', 'Sainte-Catherine-de-la-Jacques-Cartier', 'La Jacques-Cartier \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(945, 38060, 'Paroisse', 'Sainte-Cécile-de-Lévrard', 'Bécancour', 'Centre-du-Québec'),
(946, 47055, 'Municipalité', 'Sainte-Cécile-de-Milton', 'La Haute-Yamaska', 'Montérégie'),
(947, 30050, 'Municipalité', 'Sainte-Cécile-de-Whitton', 'Le Granit', 'Estrie'),
(948, 48020, 'Paroisse', 'Sainte-Christine', 'Acton', 'Montérégie'),
(949, 34105, 'Municipalité', 'Sainte-Christine-d''Auvergne', 'Portneuf', 'Capitale-Nationale'),
(950, 19055, 'Municipalité', 'Sainte-Claire', 'Bellechasse', 'Chaudière-Appalaches'),
(951, 68020, 'Municipalité', 'Sainte-Clotilde', 'Les Jardins-de-Napierville', 'Montérégie'),
(952, 31060, 'Municipalité', 'Sainte-Clotilde-de-Beauce', 'Les Appalaches', 'Chaudière-Appalaches'),
(953, 39117, 'Municipalité', 'Sainte-Clotilde-de-Horton', 'Arthabaska', 'Centre-du-Québec'),
(954, 33102, 'Municipalité', 'Sainte-Croix', 'Lotbinière', 'Chaudière-Appalaches'),
(955, 44055, 'Canton', 'Sainte-Edwidge-de-Clifton', 'Coaticook', 'Estrie'),
(956, 52030, 'Municipalité', 'Sainte-Élisabeth', 'D''Autray', 'Lanaudière'),
(957, 39090, 'Municipalité', 'Sainte-Élizabeth-de-Warwick', 'Arthabaska', 'Centre-du-Québec'),
(958, 62070, 'Municipalité', 'Sainte-Émélie-de-l''Énergie', 'Matawinie', 'Lanaudière'),
(959, 50005, 'Municipalité', 'Sainte-Eulalie', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(960, 18035, 'Municipalité', 'Sainte-Euphémie-sur-Rivière-du-Sud', 'Montmagny', 'Chaudière-Appalaches'),
(961, 20010, 'Paroisse', 'Sainte-Famille', 'L''Île-d''Orléans \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(962, 8023, 'Municipalité', 'Sainte-Félicité', 'La Matanie', 'Bas-Saint-Laurent'),
(963, 17025, 'Municipalité', 'Sainte-Félicité', 'L''Islet', 'Chaudière-Appalaches'),
(964, 9085, 'Paroisse', 'Sainte-Flavie', 'La Mitis', 'Bas-Saint-Laurent'),
(965, 7010, 'Municipalité', 'Sainte-Florence', 'La Matapédia', 'Bas-Saint-Laurent'),
(966, 11030, 'Paroisse', 'Sainte-Françoise', 'Les Basques', 'Bas-Saint-Laurent'),
(967, 38035, 'Municipalité', 'Sainte-Françoise', 'Bécancour', 'Centre-du-Québec'),
(968, 37215, 'Paroisse', 'Sainte-Geneviève-de-Batiscan', 'Les Chenaux', 'Mauricie'),
(969, 52040, 'Municipalité', 'Sainte-Geneviève-de-Berthier', 'D''Autray', 'Lanaudière'),
(970, 87030, 'Municipalité', 'Sainte-Germaine-Boulé', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(971, 88085, 'Municipalité', 'Sainte-Gertrude-Manneville', 'Abitibi', 'Abitibi-Témiscamingue'),
(972, 91030, 'Municipalité', 'Sainte-Hedwidge', 'Le Domaine-du-Roy', 'Saguenay–Lac-Saint-Jean'),
(973, 14025, 'Municipalité', 'Sainte-Hélène', 'Kamouraska', 'Bas-Saint-Laurent'),
(974, 54095, 'Municipalité', 'Sainte-Hélène-de-Bagot', 'Les Maskoutains', 'Montérégie'),
(975, 39035, 'Municipalité', 'Sainte-Hélène-de-Chester', 'Arthabaska', 'Centre-du-Québec'),
(976, 87070, 'Paroisse', 'Sainte-Hélène-de-Mancebourg', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(977, 26040, 'Paroisse', 'Sainte-Hénédine', 'La Nouvelle-Beauce', 'Chaudière-Appalaches'),
(978, 7040, 'Paroisse', 'Sainte-Irène', 'La Matapédia', 'Bas-Saint-Laurent'),
(979, 9020, 'Paroisse', 'Sainte-Jeanne-d''Arc', 'La Mitis', 'Bas-Saint-Laurent'),
(980, 92015, 'Village', 'Sainte-Jeanne-d''Arc', 'Maria-Chapdelaine', 'Saguenay–Lac-Saint-Jean'),
(981, 59010, 'Ville', 'Sainte-Julie', 'Marguerite-D''Youville \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(982, 63060, 'Municipalité', 'Sainte-Julienne', 'Montcalm', 'Lanaudière'),
(983, 28045, 'Municipalité', 'Sainte-Justine', 'Les Etchemins', 'Chaudière-Appalaches'),
(984, 71115, 'Municipalité', 'Sainte-Justine-de-Newton', 'Vaudreuil-Soulanges', 'Montérégie'),
(985, 17060, 'Paroisse', 'Sainte-Louise', 'L''Islet', 'Chaudière-Appalaches'),
(986, 9092, 'Municipalité', 'Sainte-Luce', 'La Mitis', 'Bas-Saint-Laurent'),
(987, 18020, 'Municipalité', 'Sainte-Lucie-de-Beauregard', 'Montmagny', 'Chaudière-Appalaches'),
(988, 78020, 'Municipalité', 'Sainte-Lucie-des-Laurentides', 'Les Laurentides', 'Laurentides'),
(989, 54025, 'Village', 'Sainte-Madeleine', 'Les Maskoutains', 'Montérégie'),
(990, 4005, 'Municipalité', 'Sainte-Madeleine-de-la-Rivière-Madeleine', 'La Haute-Gaspésie', 'Gaspésie–Îles-de-la-Madeleine'),
(991, 62030, 'Municipalité', 'Sainte-Marcelline-de-Kildare', 'Matawinie', 'Lanaudière'),
(992, 26035, 'Paroisse', 'Sainte-Marguerite', 'La Nouvelle-Beauce', 'Chaudière-Appalaches'),
(993, 77012, 'Ville', 'Sainte-Marguerite-du-Lac-Masson', 'Les Pays-d''en-Haut', 'Laurentides'),
(994, 7005, 'Municipalité', 'Sainte-Marguerite-Marie', 'La Matapédia', 'Bas-Saint-Laurent'),
(995, 26030, 'Ville', 'Sainte-Marie', 'La Nouvelle-Beauce', 'Chaudière-Appalaches'),
(996, 38015, 'Municipalité', 'Sainte-Marie-de-Blandford', 'Bécancour', 'Centre-du-Québec'),
(997, 54030, 'Paroisse', 'Sainte-Marie-Madeleine', 'Les Maskoutains', 'Montérégie'),
(998, 63005, 'Paroisse', 'Sainte-Marie-Salomé', 'Montcalm', 'Lanaudière'),
(999, 71110, 'Municipalité', 'Sainte-Marthe', 'Vaudreuil-Soulanges', 'Montérégie'),
(1000, 72015, 'Ville', 'Sainte-Marthe-sur-le-Lac', 'Deux-Montagnes \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(1001, 70012, 'Municipalité', 'Sainte-Martine', 'Beauharnois-Salaberry', 'Montérégie'),
(1002, 61050, 'Municipalité', 'Sainte-Mélanie', 'Joliette', 'Lanaudière'),
(1003, 93075, 'Municipalité', 'Sainte-Monique', 'Lac-Saint-Jean-Est', 'Saguenay–Lac-Saint-Jean'),
(1004, 50057, 'Municipalité', 'Sainte-Monique', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(1005, 8040, 'Municipalité', 'Sainte-Paule', 'La Matanie', 'Bas-Saint-Laurent'),
(1006, 17030, 'Municipalité', 'Sainte-Perpétue', 'L''Islet', 'Chaudière-Appalaches'),
(1007, 50050, 'Paroisse', 'Sainte-Perpétue', 'Nicolet-Yamaska', 'Centre-du-Québec'),
(1008, 20030, 'Village', 'Sainte-Pétronille', 'L''Île-d''Orléans \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(1009, 31050, 'Paroisse', 'Sainte-Praxède', 'Les Appalaches', 'Chaudière-Appalaches'),
(1010, 11015, 'Municipalité', 'Sainte-Rita', 'Les Basques', 'Bas-Saint-Laurent'),
(1011, 28030, 'Municipalité', 'Sainte-Rose-de-Watford', 'Les Etchemins', 'Chaudière-Appalaches'),
(1012, 94230, 'Paroisse', 'Sainte-Rose-du-Nord', 'Le Fjord-du-Saguenay', 'Saguenay–Lac-Saint-Jean'),
(1013, 28065, 'Paroisse', 'Sainte-Sabine', 'Les Etchemins', 'Chaudière-Appalaches'),
(1014, 46105, 'Municipalité', 'Sainte-Sabine', 'Brome-Missisquoi', 'Montérégie'),
(1015, 39105, 'Paroisse', 'Sainte-Séraphine', 'Arthabaska', 'Centre-du-Québec'),
(1016, 75028, 'Municipalité', 'Sainte-Sophie', 'La Rivière-du-Nord', 'Laurentides'),
(1017, 32023, 'Municipalité', 'Sainte-Sophie-d''Halifax', 'L''Érable', 'Centre-du-Québec'),
(1018, 38040, 'Paroisse', 'Sainte-Sophie-de-Lévrard', 'Bécancour', 'Centre-du-Québec'),
(1019, 35050, 'Municipalité', 'Sainte-Thècle', 'Mékinac', 'Mauricie'),
(1020, 73010, 'Ville', 'Sainte-Thérèse', 'Thérèse-De Blainville \\ Communauté métropolitaine de Montréal', 'Laurentides'),
(1021, 2010, 'Municipalité', 'Sainte-Thérèse-de-Gaspé', 'Le Rocher-Percé', 'Gaspésie–Îles-de-la-Madeleine'),
(1022, 83055, 'Municipalité', 'Sainte-Thérèse-de-la-Gatineau', 'La Vallée-de-la-Gatineau', 'Outaouais'),
(1023, 51040, 'Paroisse', 'Sainte-Ursule', 'Maskinongé', 'Mauricie'),
(1024, 53025, 'Municipalité', 'Sainte-Victoire-de-Sorel', 'Pierre-De Saurel', 'Montérégie'),
(1025, 26010, 'Paroisse', 'Saints-Anges', 'La Nouvelle-Beauce', 'Chaudière-Appalaches'),
(1026, 39005, 'Paroisse', 'Saints-Martyrs-Canadiens', 'Arthabaska', 'Centre-du-Québec'),
(1027, 70052, 'Ville', 'Salaberry-de-Valleyfield', 'Beauharnois-Salaberry', 'Montérégie'),
(1028, 7085, 'Municipalité', 'Sayabec', 'La Matapédia', 'Bas-Saint-Laurent'),
(1029, 97040, 'Ville', 'Schefferville', 'Caniapiscau', 'Côte-Nord'),
(1030, 41080, 'Ville', 'Scotstown', 'Le Haut-Saint-François', 'Estrie'),
(1031, 26048, 'Municipalité', 'Scott', 'La Nouvelle-Beauce', 'Chaudière-Appalaches'),
(1032, 89045, 'Paroisse', 'Senneterre', 'La Vallée-de-l''Or', 'Abitibi-Témiscamingue'),
(1033, 89040, 'Ville', 'Senneterre', 'La Vallée-de-l''Or', 'Abitibi-Témiscamingue'),
(1034, 66127, 'Village', 'Senneville', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(1035, 97007, 'Ville', 'Sept-Îles', 'Sept-Rivières', 'Côte-Nord'),
(1036, 22020, 'Municipalité', 'Shannon', 'La Jacques-Cartier \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(1037, 36033, 'Ville', 'Shawinigan', 'Hors MRC', 'Mauricie'),
(1038, 84010, 'Municipalité', 'Shawville', 'Pontiac', 'Outaouais'),
(1039, 84095, 'Municipalité', 'Sheenboro', 'Pontiac', 'Outaouais'),
(1040, 47035, 'Canton', 'Shefford', 'La Haute-Yamaska', 'Montérégie'),
(1041, 43027, 'Ville', 'Sherbrooke', 'Hors MRC', 'Estrie'),
(1042, 5010, 'Municipalité', 'Shigawake', 'Bonaventure', 'Gaspésie–Îles-de-la-Madeleine'),
(1043, 53052, 'Ville', 'Sorel-Tracy', 'Pierre-De Saurel', 'Montérégie'),
(1044, 46045, 'Municipalité', 'Stanbridge East', 'Brome-Missisquoi', 'Montérégie'),
(1045, 46030, 'Municipalité', 'Stanbridge Station', 'Brome-Missisquoi', 'Montérégie'),
(1046, 45025, 'Canton', 'Stanstead', 'Memphrémagog', 'Estrie'),
(1047, 45008, 'Ville', 'Stanstead', 'Memphrémagog', 'Estrie'),
(1048, 44050, 'Municipalité', 'Stanstead-Est', 'Coaticook', 'Estrie'),
(1049, 42005, 'Municipalité', 'Stoke', 'Le Val-Saint-François', 'Estrie'),
(1050, 22035, 'Cantons unis', 'Stoneham-et-Tewkesbury', 'La Jacques-Cartier \\ Communauté métropolitaine de Québec', 'Capitale-Nationale'),
(1051, 30105, 'Municipalité', 'Stornoway', 'Le Granit', 'Estrie'),
(1052, 30110, 'Canton', 'Stratford', 'Le Granit', 'Estrie'),
(1053, 45105, 'Village', 'Stukely-Sud', 'Memphrémagog', 'Estrie'),
(1054, 46058, 'Ville', 'Sutton', 'Brome-Missisquoi', 'Montérégie'),
(1055, 95005, 'Village', 'Tadoussac', 'La Haute-Côte-Nord', 'Côte-Nord'),
(1056, 87042, 'Municipalité', 'Taschereau', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(1057, 85005, 'Ville', 'Témiscaming', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(1058, 13073, 'Ville', 'Témiscouata-sur-le-Lac', 'Témiscouata', 'Bas-Saint-Laurent'),
(1059, 71075, 'Municipalité', 'Terrasse-Vaudreuil', 'Vaudreuil-Soulanges \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(1060, 64008, 'Ville', 'Terrebonne', 'Les Moulins \\ Communauté métropolitaine de Montréal', 'Lanaudière'),
(1061, 31084, 'Ville', 'Thetford Mines', 'Les Appalaches', 'Chaudière-Appalaches'),
(1062, 84045, 'Municipalité', 'Thorne', 'Pontiac', 'Outaouais'),
(1063, 80050, 'Ville', 'Thurso', 'Papineau', 'Outaouais'),
(1064, 39025, 'Municipalité', 'Tingwick', 'Arthabaska', 'Centre-du-Québec'),
(1065, 17035, 'Municipalité', 'Tourville', 'L''Islet', 'Chaudière-Appalaches'),
(1066, 88075, 'Canton', 'Trécesson', 'Abitibi', 'Abitibi-Témiscamingue'),
(1067, 71125, 'Municipalité', 'Très-Saint-Rédempteur', 'Vaudreuil-Soulanges', 'Montérégie'),
(1068, 69030, 'Paroisse', 'Très-Saint-Sacrement', 'Le Haut-Saint-Laurent', 'Montérégie'),
(1069, 27060, 'Village', 'Tring-Jonction', 'Robert-Cliche', 'Chaudière-Appalaches'),
(1070, 11040, 'Ville', 'Trois-Pistoles', 'Les Basques', 'Bas-Saint-Laurent'),
(1071, 35055, 'Municipalité', 'Trois-Rives', 'Mékinac', 'Mauricie'),
(1072, 37067, 'Ville', 'Trois-Rivières', 'Hors MRC', 'Mauricie'),
(1073, 42078, 'Municipalité', 'Ulverton', 'Le Val-Saint-François', 'Estrie'),
(1074, 48038, 'Municipalité', 'Upton', 'Acton', 'Montérégie'),
(1075, 33070, 'Municipalité', 'Val-Alain', 'Lotbinière', 'Chaudière-Appalaches'),
(1076, 7080, 'Municipalité', 'Val-Brillant', 'La Matapédia', 'Bas-Saint-Laurent'),
(1077, 89008, 'Ville', 'Val-d''Or', 'La Vallée-de-l''Or', 'Abitibi-Témiscamingue'),
(1078, 78010, 'Village', 'Val-David', 'Les Laurentides', 'Laurentides'),
(1079, 80140, 'Municipalité', 'Val-des-Bois', 'Papineau', 'Outaouais'),
(1080, 78100, 'Municipalité', 'Val-des-Lacs', 'Les Laurentides', 'Laurentides'),
(1081, 82015, 'Municipalité', 'Val-des-Monts', 'Les Collines-de-l''Outaouais', 'Outaouais'),
(1082, 42095, 'Municipalité', 'Val-Joli', 'Le Val-Saint-François', 'Estrie'),
(1083, 78005, 'Municipalité', 'Val-Morin', 'Les Laurentides', 'Laurentides'),
(1084, 30015, 'Paroisse', 'Val-Racine', 'Le Granit', 'Estrie'),
(1085, 87105, 'Municipalité', 'Val-Saint-Gilles', 'Abitibi-Ouest', 'Abitibi-Témiscamingue'),
(1086, 42060, 'Canton', 'Valcourt', 'Le Val-Saint-François', 'Estrie'),
(1087, 42055, 'Ville', 'Valcourt', 'Le Val-Saint-François', 'Estrie'),
(1088, 26015, 'Municipalité', 'Vallée-Jonction', 'La Nouvelle-Beauce', 'Chaudière-Appalaches'),
(1089, 59020, 'Ville', 'Varennes', 'Marguerite-D''Youville \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(1090, 71083, 'Ville', 'Vaudreuil-Dorion', 'Vaudreuil-Soulanges \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(1091, 71090, 'Village', 'Vaudreuil-sur-le-Lac', 'Vaudreuil-Soulanges \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(1092, 56005, 'Municipalité', 'Venise-en-Québec', 'Le Haut-Richelieu', 'Montérégie'),
(1093, 59025, 'Municipalité', 'Verchères', 'Marguerite-D''Youville \\ Communauté métropolitaine de Montréal', 'Montérégie'),
(1094, 39062, 'Ville', 'Victoriaville', 'Arthabaska', 'Centre-du-Québec'),
(1095, 85025, 'Ville', 'Ville-Marie', 'Témiscamingue', 'Abitibi-Témiscamingue'),
(1096, 32085, 'Municipalité', 'Villeroy', 'L''Érable', 'Centre-du-Québec'),
(1097, 84070, 'Municipalité', 'Waltham', 'Pontiac', 'Outaouais'),
(1098, 47030, 'Village', 'Warden', 'La Haute-Yamaska', 'Montérégie'),
(1099, 39077, 'Ville', 'Warwick', 'Arthabaska', 'Centre-du-Québec'),
(1100, 47025, 'Ville', 'Waterloo', 'La Haute-Yamaska', 'Montérégie'),
(1101, 44080, 'Ville', 'Waterville', 'Coaticook', 'Estrie'),
(1102, 41098, 'Municipalité', 'Weedon', 'Le Haut-Saint-François', 'Estrie'),
(1103, 76035, 'Canton', 'Wentworth', 'Argenteuil', 'Laurentides'),
(1104, 77060, 'Municipalité', 'Wentworth-Nord', 'Les Pays-d''en-Haut', 'Laurentides'),
(1105, 41065, 'Canton', 'Westbury', 'Le Haut-Saint-François', 'Estrie'),
(1106, 66032, 'Ville', 'Westmount', 'Hors MRC \\ Communauté métropolitaine de Montréal', 'Montréal'),
(1107, 49040, 'Municipalité', 'Wickham', 'Drummond', 'Centre-du-Québec'),
(1108, 42088, 'Ville', 'Windsor', 'Le Val-Saint-François', 'Estrie'),
(1109, 40017, 'Municipalité', 'Wotton', 'Les Sources', 'Estrie'),
(1110, 51020, 'Municipalité', 'Yamachiche', 'Maskinongé', 'Mauricie'),
(1111, 53072, 'Municipalité', 'Yamaska', 'Pierre-De Saurel', 'Montérégie');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `bourses`
--
ALTER TABLE `bourses`
  ADD CONSTRAINT `FK_JOUEUR_BOURSE` FOREIGN KEY (`id_joueur`) REFERENCES `joueurs` (`id_joueur`);

--
-- Contraintes pour la table `certifications_entraineurs`
--
ALTER TABLE `certifications_entraineurs`
  ADD CONSTRAINT `FK_ENTRAINEUR_CERT` FOREIGN KEY (`id_entraineur`) REFERENCES `entraineurs` (`id_entraineur`);

--
-- Contraintes pour la table `detail_sejour`
--
ALTER TABLE `detail_sejour`
  ADD CONSTRAINT `detail_sejour_ibfk_1` FOREIGN KEY (`idEndroitSejour`) REFERENCES `endroit_sejour` (`id`);

--
-- Contraintes pour la table `entraineurs`
--
ALTER TABLE `entraineurs`
  ADD CONSTRAINT `FK_ENTRAINEUR_PERS` FOREIGN KEY (`id_personne`) REFERENCES `personnes` (`id_personne`);

--
-- Contraintes pour la table `entraineur_equipe`
--
ALTER TABLE `entraineur_equipe`
  ADD CONSTRAINT `entraineur_equipe_ibfk_1` FOREIGN KEY (`id_equipe`) REFERENCES `equipes` (`id_equipe`),
  ADD CONSTRAINT `fk_entraineur` FOREIGN KEY (`id_entraineur`) REFERENCES `entraineurs` (`id_entraineur`);

--
-- Contraintes pour la table `equipes`
--
ALTER TABLE `equipes`
  ADD CONSTRAINT `FK_EQUIPE_SPORT` FOREIGN KEY (`id_sport`) REFERENCES `sports` (`id_sport`);

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`idTransport`) REFERENCES `transport` (`id`),
  ADD CONSTRAINT `evenement_ibfk_3` FOREIGN KEY (`idSejour`) REFERENCES `endroit_sejour` (`id`),
  ADD CONSTRAINT `evenement_sport` FOREIGN KEY (`idSport`) REFERENCES `sports` (`id_sport`);

--
-- Contraintes pour la table `joueurs`
--
ALTER TABLE `joueurs`
  ADD CONSTRAINT `FK_JOUEUR_PERSONNE` FOREIGN KEY (`id_personne`) REFERENCES `personnes` (`id_personne`);

--
-- Contraintes pour la table `joueurs_equipes`
--
ALTER TABLE `joueurs_equipes`
  ADD CONSTRAINT `FK_EQUIPE` FOREIGN KEY (`id_equipe`) REFERENCES `equipes` (`id_equipe`),
  ADD CONSTRAINT `FK_JOUEUR_EQUIPE` FOREIGN KEY (`id_joueur`) REFERENCES `joueurs` (`id_joueur`),
  ADD CONSTRAINT `FK_JOUEUR_POSITION` FOREIGN KEY (`id_position`) REFERENCES `positions` (`id_position`);

--
-- Contraintes pour la table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `FK_POSITION_SPORT` FOREIGN KEY (`id_sport`) REFERENCES `sports` (`id_sport`);

--
-- Contraintes pour la table `responsable_plateau`
--
ALTER TABLE `responsable_plateau`
  ADD CONSTRAINT `responsable_plateau_pers` FOREIGN KEY (`id_personne`) REFERENCES `membres_personnel` (`id_membre`),
  ADD CONSTRAINT `responsable_plateau_ibfk_1` FOREIGN KEY (`idEvenement`) REFERENCES `evenement` (`id`);

--
-- Contraintes pour la table `role_responsable`
--
ALTER TABLE `role_responsable`
  ADD CONSTRAINT `personne_role` FOREIGN KEY (`id_personne`) REFERENCES `personnes` (`id_personne`);

--
-- Contraintes pour la table `statut_joueurs`
--
ALTER TABLE `statut_joueurs`
  ADD CONSTRAINT `FK_POSITION_JOUEUR` FOREIGN KEY (`id_joueur_equipe`) REFERENCES `joueurs_equipes` (`id_joueur_equipe`);

--
-- Contraintes pour la table `transport`
--
ALTER TABLE `transport`
  ADD CONSTRAINT `transport_ibfk_1` FOREIGN KEY (`idTransporteur`) REFERENCES `transporteur` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
