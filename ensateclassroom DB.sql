-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 21 juin 2020 à 21:56
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ensateclassroom`
--

-- --------------------------------------------------------

--
-- Structure de la table `affectations`
--

CREATE TABLE `affectations` (
  `affectations_id` int(11) NOT NULL,
  `affectations_classid` int(11) NOT NULL,
  `affectations_courseid` int(11) NOT NULL,
  `affectations_date` varchar(10) NOT NULL,
  `affectations_start` time NOT NULL,
  `affectations_end` time NOT NULL,
  `affectations_prof1` varchar(50) NOT NULL,
  `affectations_prof2` varchar(50) NOT NULL,
  `affectations_prof3` varchar(50) NOT NULL,
  `affectations_prof4` varchar(50) NOT NULL,
  `affectations_prof5` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `affectations`
--

INSERT INTO `affectations` (`affectations_id`, `affectations_classid`, `affectations_courseid`, `affectations_date`, `affectations_start`, `affectations_end`, `affectations_prof1`, `affectations_prof2`, `affectations_prof3`, `affectations_prof4`, `affectations_prof5`) VALUES
(1, 1, 2, '2020-06-21', '11:30:00', '13:30:00', '1.oussama.aoulad lahcene', '2.taha.raissouni', '3.yassir.aoulad benali', 'none', 'none'),
(2, 1, 3, '2020-06-20', '09:00:00', '11:00:00', '1.oussama.aoulad lahcene', '2.taha.raissouni', '3.yassir.aoulad benali', 'none', 'none'),
(3, 1, 4, '2020-06-20', '11:30:00', '13:30:00', '1.oussama.aoulad lahcene', '2.taha.raissouni', '3.yassir.aoulad benali', 'none', 'none'),
(4, 2, 4, '2020-06-20', '11:30:00', '13:30:00', '4.ahmed.assidah', '5.anass.amar', '6.mohamed ali.assidah', 'none', 'none'),
(5, 1, 5, '2020-06-22', '14:00:00', '16:00:00', '1.oussama.aoulad lahcene', '2.taha.raissouni', '3.yassir.aoulad benali', 'none', 'none'),
(6, 1, 10, '2020-06-23', '09:00:00', '11:00:00', '1.oussama.aoulad lahcene', '2.taha.raissouni', '4.ahmed.assidah', 'none', 'none'),
(7, 2, 2, '2020-06-21', '11:30:00', '13:30:00', '4.ahmed.assidah', '5.anass.amar', '6.mohamed ali.assidah', 'none', 'none'),
(8, 7, 2, '2020-06-21', '11:30:00', '13:30:00', '7.john.doe', '8.alae.haouti', '9.adnan.haouti', 'none', 'none'),
(9, 1, 7, '2020-06-21', '09:00:00', '11:00:00', '10.tarik.messoudi', '9.adnan.haouti', '7.john.doe', 'none', 'none'),
(10, 6, 7, '2020-06-21', '09:00:00', '11:00:00', '1.oussama.aoulad lahcene', '2.taha.raissouni', '6.mohamed ali.assidah', 'none', 'none'),
(11, 3, 9, '2020-06-24', '09:00:00', '13:30:00', '6.mohamed ali.assidah', '5.anass.amar', '3.yassir.aoulad benali', 'none', 'none'),
(12, 1, 9, '2020-06-24', '09:00:00', '13:30:00', '4.ahmed.assidah', '7.john.doe', '10.tarik.messoudi', 'none', 'none'),
(13, 7, 9, '2020-06-24', '09:00:00', '13:30:00', '1.oussama.aoulad lahcene', '8.alae.haouti', '9.adnan.haouti', 'none', 'none');

-- --------------------------------------------------------

--
-- Structure de la table `classrooms`
--

CREATE TABLE `classrooms` (
  `classrooms_id` int(11) NOT NULL,
  `classrooms_number` int(2) NOT NULL,
  `classrooms_floor` int(1) NOT NULL,
  `classrooms_seats` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `classrooms`
--

INSERT INTO `classrooms` (`classrooms_id`, `classrooms_number`, `classrooms_floor`, `classrooms_seats`) VALUES
(1, 105, 3, 25),
(2, 5, 1, 30),
(3, 201, 2, 20),
(4, 202, 2, 25),
(5, 101, 1, 22),
(6, 102, 1, 28),
(7, 203, 2, 30),
(8, 104, 1, 20);

-- --------------------------------------------------------

--
-- Structure de la table `courses`
--

CREATE TABLE `courses` (
  `courses_id` int(11) NOT NULL,
  `courses_name` varchar(40) NOT NULL,
  `courses_hours` int(2) NOT NULL,
  `courses_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `courses`
--

INSERT INTO `courses` (`courses_id`, `courses_name`, `courses_hours`, `courses_type`) VALUES
(2, 'PHP', 30, 'td'),
(3, 'langage C', 40, 'cour'),
(4, 'c++/c#', 25, 'tp'),
(5, 'laravel', 10, 'td'),
(6, 'Linux', 10, 'cour'),
(7, 'SQL', 8, 'cour'),
(9, 'Java', 20, 'cour'),
(10, 'Js', 35, 'tp'),
(11, 'electronique numerique', 32, 'td');

-- --------------------------------------------------------

--
-- Structure de la table `professors`
--

CREATE TABLE `professors` (
  `professors_id` int(11) NOT NULL,
  `professors_cni` varchar(10) NOT NULL,
  `professors_firstname` varchar(20) NOT NULL,
  `professors_lastname` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `professors`
--

INSERT INTO `professors` (`professors_id`, `professors_cni`, `professors_firstname`, `professors_lastname`) VALUES
(1, 'P123456', 'oussama', 'aoulad lahcene'),
(2, 'P654332', 'taha', 'raissouni'),
(3, 'P135235', 'yassir', 'aoulad benali'),
(4, 'P927399', 'ahmed', 'assidah'),
(5, 'P121213', 'anass', 'amar'),
(6, 'P927395', 'mohamed ali', 'assidah'),
(7, 'P432567', 'john', 'doe'),
(8, 'P987564', 'alae', 'haouti'),
(9, 'P342719', 'adnan', 'haouti'),
(10, 'P928464', 'tarik', 'messoudi');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `users_firstname` varchar(20) NOT NULL,
  `users_lastname` varchar(20) NOT NULL,
  `users_username` varchar(20) NOT NULL,
  `users_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`users_id`, `users_firstname`, `users_lastname`, `users_username`, `users_password`) VALUES
(1, 'Oussama', 'Aoulad Lahcene', 'admin', '$2y$10$0jMlrd.6xsoIkCiqj2wt4.RiSZtydPD..LAlG6X8NMYPMjTYdblpW');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `affectations`
--
ALTER TABLE `affectations`
  ADD PRIMARY KEY (`affectations_id`),
  ADD KEY `affectations_classid` (`affectations_classid`),
  ADD KEY `affectations_courseid` (`affectations_courseid`);

--
-- Index pour la table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`classrooms_id`);

--
-- Index pour la table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courses_id`);

--
-- Index pour la table `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`professors_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `affectations`
--
ALTER TABLE `affectations`
  MODIFY `affectations_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `classrooms_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `courses`
--
ALTER TABLE `courses`
  MODIFY `courses_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `professors`
--
ALTER TABLE `professors`
  MODIFY `professors_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affectations`
--
ALTER TABLE `affectations`
  ADD CONSTRAINT `affectations_ibfk_1` FOREIGN KEY (`affectations_classid`) REFERENCES `classrooms` (`classrooms_id`),
  ADD CONSTRAINT `affectations_ibfk_2` FOREIGN KEY (`affectations_courseid`) REFERENCES `courses` (`courses_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
