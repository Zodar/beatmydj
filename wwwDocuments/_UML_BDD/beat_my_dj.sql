-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 13 Juin 2016 à 10:33
-- Version du serveur :  5.6.21
-- Version de PHP :  5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `beat_my_dj`
--

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
`idRole` bigint(20) NOT NULL,
  `role` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`idRole`, `role`) VALUES
(1, 'admin'),
(3, 'DJ'),
(4, 'client');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`idUser` bigint(20) unsigned NOT NULL,
  `nom` varchar(200) NOT NULL,
  `prenom` varchar(200) NOT NULL,
  `pseudo` varchar(200) NOT NULL,
  `mail` varchar(200) NOT NULL,
  `mot de passe` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`idUser`, `nom`, `prenom`, `pseudo`, `mail`, `mot de passe`) VALUES
(1, 'Merabet', 'Tarik', 'Zodar', 'zodar@live.fr', '0ef05d81587798f709430675d532ea984a480d30'),
(2, 'PANOFF', 'Axel', 'Axel', 'panoff_a@etna-alternance.net', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c'),
(3, 'Handoura', 'Oualid', 'Wall-e', 'handou_o@etna-alternance.net', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c'),
(4, 'Benzai', 'Lasaad', 'Dofus_du75', 'benzai_l@etna-alternance.net', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c');

-- --------------------------------------------------------

--
-- Structure de la table `user_location`
--

CREATE TABLE IF NOT EXISTS `user_location` (
`idLocation` bigint(20) NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `codePostal` varchar(200) NOT NULL,
  `ville` varchar(200) NOT NULL,
  `pays` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user_location`
--

INSERT INTO `user_location` (`idLocation`, `idUser`, `adresse`, `codePostal`, `ville`, `pays`, `tel`) VALUES
(1, 1, 'avenue des tulipes', '93 370', 'Montfermeil', 'France', '06 18 80 08 78'),
(2, 2, 'Pas trop loin de là', '75001', 'Paris', 'France', '0102030405');

-- --------------------------------------------------------

--
-- Structure de la table `user_privileges`
--

CREATE TABLE IF NOT EXISTS `user_privileges` (
`idPrivileges` bigint(20) unsigned NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `idRole` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user_privileges`
--

INSERT INTO `user_privileges` (`idPrivileges`, `idUser`, `idRole`) VALUES
(1, 1, 1),
(2, 2, 3),
(3, 4, 3),
(4, 3, 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`idRole`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`idUser`), ADD UNIQUE KEY `id` (`idUser`);

--
-- Index pour la table `user_location`
--
ALTER TABLE `user_location`
 ADD PRIMARY KEY (`idLocation`), ADD UNIQUE KEY `idUser` (`idUser`);

--
-- Index pour la table `user_privileges`
--
ALTER TABLE `user_privileges`
 ADD PRIMARY KEY (`idPrivileges`), ADD UNIQUE KEY `idPrivileges` (`idPrivileges`), ADD UNIQUE KEY `idUser_3` (`idUser`), ADD KEY `idRole` (`idRole`), ADD KEY `idUser` (`idUser`), ADD KEY `idUser_2` (`idUser`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
MODIFY `idRole` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
MODIFY `idUser` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `user_location`
--
ALTER TABLE `user_location`
MODIFY `idLocation` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `user_privileges`
--
ALTER TABLE `user_privileges`
MODIFY `idPrivileges` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
