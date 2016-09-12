-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 05 Septembre 2016 à 18:22
-- Version du serveur :  10.1.9-MariaDB
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `beatmydj`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `userid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pseudo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userpage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `response` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `thread_id`, `sender_id`, `body`, `created_at`) VALUES
(1, 1, 2, ' ezai', '2016-09-02 17:58:41'),
(2, 1, 1, 'T nul', '2016-09-02 17:59:56');

-- --------------------------------------------------------

--
-- Structure de la table `message_metadata`
--

CREATE TABLE `message_metadata` (
  `id` int(11) NOT NULL,
  `message_id` int(11) DEFAULT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `message_metadata`
--

INSERT INTO `message_metadata` (`id`, `message_id`, `participant_id`, `is_read`) VALUES
(1, 1, 2, 0),
(2, 1, 1, 1),
(3, 2, 2, 0),
(4, 2, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `idRole` bigint(20) NOT NULL,
  `role` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `role_associative` (
  `id` int(11) NOT NULL,
  `id_user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_role` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `role_associative`
--

INSERT INTO `role_associative` (`id`, `id_user`, `id_role`) VALUES
(1, '1', '3'),
(2, '2', '3');

-- --------------------------------------------------------

--
-- Structure de la table `style`
--

CREATE TABLE `style` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `style`
--

INSERT INTO `style` (`id`, `id_user`, `deep`, `electro`, `house`, `years80`, `years90`, `disco`, `rock`, `dance`, `hiphop`, `reggae`, `rnb`, `latino`, `funk`) VALUES
(1, '1', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `thread`
--

CREATE TABLE `thread` (
  `id` int(11) NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `is_spam` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `thread`
--

INSERT INTO `thread` (`id`, `created_by_id`, `subject`, `created_at`, `is_spam`) VALUES
(1, 2, 'Hi there', '2016-09-02 17:58:41', 0);

-- --------------------------------------------------------

--
-- Structure de la table `thread_metadata`
--

CREATE TABLE `thread_metadata` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `last_participant_message_date` datetime DEFAULT NULL,
  `last_message_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `thread_metadata`
--

INSERT INTO `thread_metadata` (`id`, `thread_id`, `participant_id`, `is_deleted`, `last_participant_message_date`, `last_message_date`) VALUES
(1, 1, 2, 0, '2016-09-02 17:58:41', '2016-09-02 17:59:56'),
(2, 1, 1, 0, '2016-09-02 17:59:56', '2016-09-02 17:58:41');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `style_id`, `role_id`, `email`, `firstname`, `lastname`, `username`, `presentation`, `dispo`, `path`, `password`, `sound_clood_link`) VALUES
(1, 1, 1, 'zodar', 'Tarik', 'Merabet', 'toto', 'Hello, I''m a new user of BEAT MY DJ ! :)', NULL, 'default.png', '$2y$13$LY6oQDnncSE8HTsUlH1PrORs/MehUiQrqibkjkYB/imd71NMRY4Zq', 'https://soundcloud.com/beat-my-dj-beat-my-dj/sets/beatmydj'),
(2, NULL, 2, 'adminhjg', 'Oualid', 'Merabet', 'wawa', 'Hello, I''m a new user of BEAT MY DJ ! :)', NULL, 'default.png', '$2y$13$YqeOrMCdWAuwrhO.hIA8Cuh3QDlgYnxazm577L4dDMQ0.NRNbiIfu', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_location`
--

CREATE TABLE `user_location` (
  `idLocation` bigint(20) NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `codePostal` varchar(200) NOT NULL,
  `ville` varchar(200) NOT NULL,
  `pays` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `user_privileges` (
  `idPrivileges` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `idRole` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `message_metadata`
--
ALTER TABLE `message_metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `idRole` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `role_associative`
--
ALTER TABLE `role_associative`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `style`
--
ALTER TABLE `style`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `thread`
--
ALTER TABLE `thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `thread_metadata`
--
ALTER TABLE `thread_metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `user_location`
--
ALTER TABLE `user_location`
  MODIFY `idLocation` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `user_privileges`
--
ALTER TABLE `user_privileges`
  MODIFY `idPrivileges` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
