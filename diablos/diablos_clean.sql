-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 29 Mai 2016 à 19:32
-- Version du serveur :  5.7.9
-- Version de PHP :  7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `diablos`
--
CREATE DATABASE IF NOT EXISTS `diablos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ;
USE `diablos`;

-- --------------------------------------------------------

--
-- Structure de la table `bourses`
--

DROP TABLE IF EXISTS `bourses`;
CREATE TABLE IF NOT EXISTS `bourses` (
  `id_bourse` int(6) NOT NULL AUTO_INCREMENT,
  `id_joueur` int(6) NOT NULL,
  `montant` double(8,2) NOT NULL,
  `provenance` varchar(50) NOT NULL,
  `annee` int(4) NOT NULL,
  PRIMARY KEY (`id_bourse`),
  KEY `id_joueur` (`id_joueur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `certifications_entraineurs`
--

DROP TABLE IF EXISTS `certifications_entraineurs`;
CREATE TABLE IF NOT EXISTS `certifications_entraineurs` (
  `id_certification` int(6) NOT NULL AUTO_INCREMENT,
  `id_entraineur` int(6) NOT NULL,
  `annee_obtention` int(4) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id_certification`),
  KEY `id_entraineur` (`id_entraineur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `detail_sejour`
--

DROP TABLE IF EXISTS `detail_sejour`;
CREATE TABLE IF NOT EXISTS `detail_sejour` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `idEndroitSejour` int(6) NOT NULL,
  `demandeAchat` varchar(10) NOT NULL,
  `nbChambre` int(2) NOT NULL,
  `nbNuit` int(2) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idEndroitSejour` (`idEndroitSejour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `endroit_sejour`
--

DROP TABLE IF EXISTS `endroit_sejour`;
CREATE TABLE IF NOT EXISTS `endroit_sejour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(125) NOT NULL,
  `rue` varchar(125) NOT NULL,
  `ville` varchar(125) NOT NULL,
  `codePostal` varchar(7) NOT NULL,
  `no_tel` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `entraineurs`
--

DROP TABLE IF EXISTS `entraineurs`;
CREATE TABLE IF NOT EXISTS `entraineurs` (
  `id_entraineur` int(6) NOT NULL AUTO_INCREMENT,
  `id_personne` int(6) NOT NULL,
  `no_embauche` varchar(6) NOT NULL,
  `note` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id_entraineur`),
  KEY `id_personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `entraineur_equipe`
--

DROP TABLE IF EXISTS `entraineur_equipe`;
CREATE TABLE IF NOT EXISTS `entraineur_equipe` (
  `id_entraineur_equipe` int(6) NOT NULL AUTO_INCREMENT,
  `id_entraineur` int(6) NOT NULL,
  `id_equipe` int(6) NOT NULL,
  `role` varchar(30) NOT NULL,
  `photo_profil` varchar(255) NOT NULL,
  PRIMARY KEY (`id_entraineur_equipe`),
  KEY `id_entraneur` (`id_entraineur`),
  KEY `id_equipe` (`id_equipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `equipes`
--

DROP TABLE IF EXISTS `equipes`;
CREATE TABLE IF NOT EXISTS `equipes` (
  `id_equipe` int(6) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `sexe` char(1) NOT NULL,
  `saison` varchar(20) NOT NULL,
  `photo_equipe` varchar(255) DEFAULT NULL,
  `id_sport` int(6) NOT NULL,
  PRIMARY KEY (`id_equipe`),
  KEY `id_sport` (`id_sport`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

DROP TABLE IF EXISTS `evenement`;
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

DROP TABLE IF EXISTS `joueurs`;
CREATE TABLE IF NOT EXISTS `joueurs` (
  `id_joueur` int(6) NOT NULL AUTO_INCREMENT,
  `id_personne` int(6) NOT NULL,
  `taille` int(3) NOT NULL,
  `poids` double(5,2) NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`id_joueur`),
  KEY `id_personne` (`id_personne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `joueurs_equipes`
--

DROP TABLE IF EXISTS `joueurs_equipes`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `membres_personnel`
--

DROP TABLE IF EXISTS `membres_personnel`;
CREATE TABLE IF NOT EXISTS `membres_personnel` (
  `id_membre` int(6) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `sexe` char(1) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `no_tel` varchar(60) DEFAULT NULL,
  `posteTelephonique` varchar(6) DEFAULT NULL,
  `courriel` varchar(150) NOT NULL,
  `rue` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ville` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `province` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
  `code_postal` varchar(7) CHARACTER SET utf8 DEFAULT NULL,
  `no_embauches` varchar(80) DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `personnes`
--

DROP TABLE IF EXISTS `personnes`;
CREATE TABLE IF NOT EXISTS `personnes` (
  `id_personne` int(6) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `sexe` char(1) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `no_tel` varchar(60) DEFAULT NULL,
  `posteTelephonique` varchar(6) DEFAULT NULL,
  `courriel` varchar(150) NOT NULL,
  `rue` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ville` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `province` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
  `code_postal` varchar(7) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `positions`
--

DROP TABLE IF EXISTS `positions`;
CREATE TABLE IF NOT EXISTS `positions` (
  `id_position` int(6) NOT NULL AUTO_INCREMENT,
  `id_sport` int(6) NOT NULL,
  `position` varchar(50) NOT NULL,
  PRIMARY KEY (`id_position`),
  KEY `id_sport` (`id_sport`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `responsable_plateau`
--

DROP TABLE IF EXISTS `responsable_plateau`;
CREATE TABLE IF NOT EXISTS `responsable_plateau` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `id_personne` int(6) NOT NULL,
  `idEvenement` int(6) NOT NULL,
  `role` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idEvenement` (`idEvenement`),
  KEY `idType` (`role`),
  KEY `id_personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `role_responsable`
--

DROP TABLE IF EXISTS `role_responsable`;
CREATE TABLE IF NOT EXISTS `role_responsable` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `id_personne` int(6) NOT NULL,
  `role` varchar(80) NOT NULL,
  `no_embauche` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `sports`
--

DROP TABLE IF EXISTS `sports`;
CREATE TABLE IF NOT EXISTS `sports` (
  `id_sport` int(6) NOT NULL AUTO_INCREMENT,
  `sport` varchar(50) NOT NULL,
  `roles` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_sport`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `statut_joueurs`
--

DROP TABLE IF EXISTS `statut_joueurs`;
CREATE TABLE IF NOT EXISTS `statut_joueurs` (
  `id_statut` int(6) NOT NULL AUTO_INCREMENT,
  `id_joueur_equipe` int(6) NOT NULL,
  `statut` varchar(200) NOT NULL,
  `date_arret` date NOT NULL,
  `date_retour` date NOT NULL,
  PRIMARY KEY (`id_statut`),
  KEY `id_joueur_equipe` (`id_joueur_equipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `transport`
--

DROP TABLE IF EXISTS `transport`;
CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `idTransporteur` int(6) NOT NULL,
  `heureDepart` time NOT NULL,
  `heureRetour` time NOT NULL,
  `demandeAchat` varchar(10) NOT NULL,
  `date` date DEFAULT NULL,
  `dateRetour` date DEFAULT NULL,
  `note` varchar(255) NOT NULL,
  `typeTransport` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idTransporteur` (`idTransporteur`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `transporteur`
--

DROP TABLE IF EXISTS `transporteur`;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `nomUtilisateur` varchar(30) CHARACTER SET utf8 NOT NULL,
  `motPasse` varchar(255) CHARACTER SET utf8 NOT NULL,
  `estAdmin` tinyint(1) NOT NULL,
  `estActif` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomUtilisateur` (`nomUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

DROP TABLE IF EXISTS `villes`;
CREATE TABLE IF NOT EXISTS `villes` (
  `no_ville` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(5) NOT NULL,
  `designation` varchar(15) NOT NULL,
  `municipalite` varchar(75) NOT NULL,
  `mrc` varchar(75) NOT NULL,
  `region` varchar(75) NOT NULL,
  PRIMARY KEY (`no_ville`)
) ENGINE=InnoDB AUTO_INCREMENT=1112 DEFAULT CHARSET=utf8mb4;

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
  ADD CONSTRAINT `responsable_plateau_ibfk_1` FOREIGN KEY (`idEvenement`) REFERENCES `evenement` (`id`),
  ADD CONSTRAINT `responsable_plateau_pers` FOREIGN KEY (`id_personne`) REFERENCES `membres_personnel` (`id_membre`);

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
