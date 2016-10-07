-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Client :  tarikmerrpovh.mysql.db
-- Généré le :  Ven 07 Octobre 2016 à 16:25
-- Version du serveur :  5.5.46-0+deb7u1-log
-- Version de PHP :  5.4.45-0+deb7u4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tarikmerrpovh`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL,
  `content` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `userid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pseudo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userpage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `response` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `userid`, `pseudo`, `userpage`, `response`, `date`) VALUES
(1, 'Je poste un pti avis positif...', '1', 'toto', '2', '', '2016-09-07 17:11:41'),
(2, 'Trop bien ton son!', '4', 'Looping', '3', '', '2016-09-08 14:12:41'),
(3, 'Très bonne playlist :)', '9', 'Dj Dime', '3', '', '2016-09-09 12:44:39');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `thread_id`, `sender_id`, `body`, `created_at`) VALUES
(3, 2, 3, ' Salut', '2016-09-08 16:23:14'),
(4, 2, 6, 'Hi!', '2016-09-08 16:23:48'),
(5, 3, 12, ' Coucou', '2016-09-09 14:44:06');

-- --------------------------------------------------------

--
-- Structure de la table `message_metadata`
--

CREATE TABLE IF NOT EXISTS `message_metadata` (
  `id` int(11) NOT NULL,
  `message_id` int(11) DEFAULT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `message_metadata`
--

INSERT INTO `message_metadata` (`id`, `message_id`, `participant_id`, `is_read`) VALUES
(5, 3, 3, 1),
(6, 3, 6, 1),
(7, 4, 3, 1),
(8, 4, 6, 1),
(9, 5, 12, 1),
(10, 5, 6, 0);

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
-- Structure de la table `role_associative`
--

CREATE TABLE IF NOT EXISTS `role_associative` (
  `id` int(11) NOT NULL,
  `id_user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_role` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `role_associative`
--

INSERT INTO `role_associative` (`id`, `id_user`, `id_role`) VALUES
(3, '3', '3'),
(4, '4', '4'),
(5, '5', '3'),
(6, '6', '3'),
(7, '7', '3'),
(8, '8', '3'),
(9, '9', '3'),
(10, '10', '4'),
(11, '11', '3'),
(12, '12', '3'),
(13, '13', '4');

-- --------------------------------------------------------

--
-- Structure de la table `style`
--

CREATE TABLE IF NOT EXISTS `style` (
  `id` int(11) NOT NULL,
  `id_user` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deep` tinyint(1) DEFAULT NULL,
  `electro` tinyint(1) DEFAULT NULL,
  `house` tinyint(1) DEFAULT NULL,
  `years80` tinyint(1) DEFAULT NULL,
  `years90` tinyint(1) DEFAULT NULL,
  `disco` tinyint(1) DEFAULT NULL,
  `rock` tinyint(1) DEFAULT NULL,
  `dance` tinyint(1) DEFAULT NULL,
  `hiphop` tinyint(1) DEFAULT NULL,
  `reggae` tinyint(1) DEFAULT NULL,
  `rnb` tinyint(1) DEFAULT NULL,
  `latino` tinyint(1) DEFAULT NULL,
  `funk` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `style`
--

INSERT INTO `style` (`id`, `id_user`, `deep`, `electro`, `house`, `years80`, `years90`, `disco`, `rock`, `dance`, `hiphop`, `reggae`, `rnb`, `latino`, `funk`) VALUES
(1, '1', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, '3', 1, 0, 1, 1, 1, 0, 1, 1, 0, 0, 1, 1, 0),
(4, '5', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1),
(5, '6', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0),
(6, '7', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, '8', 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1),
(8, '9', 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(9, '10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `id` int(11) NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `is_spam` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `thread`
--

INSERT INTO `thread` (`id`, `created_by_id`, `subject`, `created_at`, `is_spam`) VALUES
(2, 3, 'Messages', '2016-09-08 16:23:14', 0),
(3, 12, 'Messages', '2016-09-09 14:44:06', 0);

-- --------------------------------------------------------

--
-- Structure de la table `thread_metadata`
--

CREATE TABLE IF NOT EXISTS `thread_metadata` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `last_participant_message_date` datetime DEFAULT NULL,
  `last_message_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `thread_metadata`
--

INSERT INTO `thread_metadata` (`id`, `thread_id`, `participant_id`, `is_deleted`, `last_participant_message_date`, `last_message_date`) VALUES
(3, 2, 3, 0, '2016-09-08 16:23:14', '2016-09-08 16:23:48'),
(4, 2, 6, 0, '2016-09-08 16:23:48', '2016-09-08 16:23:14'),
(5, 3, 12, 0, '2016-09-09 14:44:06', NULL),
(6, 3, 6, 0, NULL, '2016-09-09 14:44:06');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `style_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `presentation` varchar(4096) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dispo` varchar(4096) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `sound_clood_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `style_id`, `role_id`, `email`, `firstname`, `lastname`, `username`, `presentation`, `dispo`, `path`, `password`, `sound_clood_link`) VALUES
(3, 2, 3, 'bfabio202@gmail.com', 'Fab', 'Brites', 'Fab202', 'BEAT MY DJ are the best !!!!!!', NULL, 'default.png', '$2y$13$eGRfQEfMqNJQ.jIAiIU0H.b9dab3qu5FIs6eFqy0d7kMXlZHBIJGm', 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/beatmydj'),
(5, 4, 5, 'deejayburn@hotmail.fr', 'Flo', 'Chaillou', 'DJ BURN', 'Hello, DJ de 23 ans du 77.', NULL, '5.jpg', '$2y$13$6vzstzmpvadDa1n9g.X7AuGagnMlkXeaLUkA5nKZvp0O.vfWBWiJm', 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/beatmydj'),
(6, 5, 6, 'looping_91@hotmail.fr', 'Dj keke', 'keke', 'looping', 'Bonjour, \n\nSi vous avez une soirée posé en mode gangsta, je suis votre homme! Ecoutez un extrait de ma playlist sur mon profil.\nEfficace et pas cher même MMA ne fait pas mieux :p', NULL, '6.jpg', '$2y$13$3ZYb.tnvsKRNtJ4T0kmZXOpmFpZLWNCBSkbCje3qff/dCNs7M98du', 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/looping'),
(7, 6, 7, 'floriand@gmail.com', 'Florian', 'Didjouu', 'FloDijou', 'Bonjour à tous, je suis un Dj amateur ne faisant que des mixs de ma composition', NULL, '7.jpg', '$2y$13$HvQ18.93ss4Rm2hLvEBy2OAErqGuUXBts/0aTDKYqrR5CRcOrjBOK', 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/flodijou'),
(8, 7, 8, 'maxou77@gmail.com', 'Maxime', 'Lucquin', 'Maxou', 'Dj à mes heures perdues, je peux faire de votre soirée un événement inoubliable', NULL, '8.jpg', '$2y$13$LabmtEtIrDN6DmvcNdl6H.v3OMWKi769pM8Rd2g/XLmiLHAbY9lDK', 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/maxou'),
(9, 8, 9, 'mehdi7dhiab7@gmail.com', 'Mehdi', 'Dhiab', 'Dj Dime', 'Dj amateur, je fais votre soirée sur mesure', NULL, '9.jpg', '$2y$13$ijA79Ii7F.lyaQ9S64H6NuWxP2h/PbsfDpqWSptHNB/i./Db5ZKw.', 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/dj-dime'),
(10, 9, 10, 'axe.axe@gmail.com', 'Axel', 'PNF', 'Axe', 'Hello, I''m a new user of BEAT MY DJ ! :)', NULL, 'default.png', '$2y$13$mBFURrwnLRx9JqqieMBjReb4a6hBX2bFqlzVYF0Ny4HyasXKh2FVO', 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/beatmydj'),
(11, 10, 11, 'axedj@gmail.com', 'Axel', 'PNF', 'axedj', 'Hello, I''m a new user of BEAT MY DJ ! :)', NULL, 'default.png', '$2y$13$IlrDhys7C9mLtXIwyKFVzO86m6QjHYgrgYueMYnHCbVoK8D2iqFCW', 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/beatmydj'),
(12, 11, 12, 'axel@gmail.com', 'axel', 'pnf', 'djaxel', 'Hello, I''m a new user of BEAT MY DJ ! :)', NULL, 'default.png', '$2y$13$KkSrozxbIhpDMs4xBgLlqehbz2weQMW1fLiB54xWBbGk75XuzQpVu', 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/beatmydj'),
(13, 12, 13, 'axe@gmail.com', 'axe', 'axe', 'axe1', 'Hello, I''m a new user of BEAT MY DJ ! :)', NULL, 'default.png', '$2y$13$RMPHnmtZO9cq/S3D5seNru0XA2p4Zg8tfxEbR9QfSlltPdR6rCF5K', 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/beatmydj');

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
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_31204C83B03A8386` (`created_by_id`);

--
-- Index pour la table `thread_metadata`
--
ALTER TABLE `thread_metadata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_40A577C8E2904019` (`thread_id`),
  ADD KEY `IDX_40A577C89D1C3019` (`participant_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6BD307FE2904019` (`thread_id`),
  ADD KEY `IDX_B6BD307FF624B39D` (`sender_id`);

--
-- Index pour la table `message_metadata`
--
ALTER TABLE `message_metadata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4632F005537A1329` (`message_id`),
  ADD KEY `IDX_4632F0059D1C3019` (`participant_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRole`);

--
-- Index pour la table `role_associative`
--
ALTER TABLE `role_associative`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `style`
--
ALTER TABLE `style`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_33BDB86A6B3CA4B` (`id_user`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD KEY `IDX_8D93D649BACD6074` (`style_id`),
  ADD KEY `IDX_8D93D649D60322AC` (`role_id`);

--
-- Index pour la table `user_location`
--
ALTER TABLE `user_location`
  ADD PRIMARY KEY (`idLocation`),
  ADD UNIQUE KEY `idUser` (`idUser`);

--
-- Index pour la table `user_privileges`
--
ALTER TABLE `user_privileges`
  ADD PRIMARY KEY (`idPrivileges`),
  ADD UNIQUE KEY `idPrivileges` (`idPrivileges`),
  ADD UNIQUE KEY `idUser_3` (`idUser`),
  ADD KEY `idRole` (`idRole`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idUser_2` (`idUser`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `message_metadata`
--
ALTER TABLE `message_metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `idRole` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `role_associative`
--
ALTER TABLE `role_associative`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `style`
--
ALTER TABLE `style`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `thread`
--
ALTER TABLE `thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `thread_metadata`
--
ALTER TABLE `thread_metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
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
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307FE2904019` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`),
  ADD CONSTRAINT `FK_B6BD307FF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `message_metadata`
--
ALTER TABLE `message_metadata`
  ADD CONSTRAINT `FK_4632F005537A1329` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`),
  ADD CONSTRAINT `FK_4632F0059D1C3019` FOREIGN KEY (`participant_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `FK_31204C83B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `thread_metadata`
--
ALTER TABLE `thread_metadata`
  ADD CONSTRAINT `FK_40A577C89D1C3019` FOREIGN KEY (`participant_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_40A577C8E2904019` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649BACD6074` FOREIGN KEY (`style_id`) REFERENCES `style` (`id`),
  ADD CONSTRAINT `FK_8D93D649D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role_associative` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
