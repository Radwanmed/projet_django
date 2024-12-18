-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 17 déc. 2024 à 22:29
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `auth_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `calendrier`
--

CREATE TABLE `calendrier` (
  `id` int(11) NOT NULL,
  `event_date` date DEFAULT NULL,
  `details` text DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `calendrier`
--

INSERT INTO `calendrier` (`id`, `event_date`, `details`, `user_id`) VALUES
(1, '2024-12-16', 'fff', 12);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pp` varchar(255) NOT NULL DEFAULT 'default-pp.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `fname`, `username`, `password`, `pp`) VALUES
(1, 'radwan med', 'rad', '$2y$10$TRK3mWbq80f/yGju9W1bk.gEW7ycL.S9t7c9NEfQBbOlvd893Zpvy', 'rad6756881960b256.97559530.png'),
(2, 'radwan mohamed ', 'rad', '$2y$10$PwBoBMs05IuMUPeoFcJqDeLUCtYYRJRN0NFBTLBpmG.TYUCX4khsW', 'rad6756e35dd948c4.65681610.png'),
(3, 'ray', 'jackson', '$2y$10$sL65AOtC3HYkPqOin4ya/uBewQ3EbYtRLZfHeTy1obdkJ20P7CD3K', 'jackson67570880d50788.87642880.jpg'),
(4, 'radwan mohamed omar', 'radstar', '$2y$10$XSJV6kx2CbR1cEVcW2RZXeka1qqq61Z/2bBz3Ldx773kxVMTmrV6S', 'radstar6757331473d238.75249600.png'),
(5, 'radddd', 'lol', '12345678', 'default-pp.png'),
(6, 'ral', 'rloi', 'radwan123', 'default-pp.png'),
(7, 'aaa', 'aaaa', 'radwan1234', 'aaaa675be1d2ec4744.03704350.png'),
(8, 'rrrr', 'r', '$2y$10$GU/Kywc43rN.9tOiQZvf5.t.MGw985Al8sqPPQ0JifrWyOeI2liC6', 'r675be2dc090ac4.17180430.png'),
(9, 'radwan mohamed', 'radstar', '$2y$10$wCLYSgFkjzm.iVpULjO.z.8sCLiHDPt2V1WT5372mhBLwblZICYde', 'radstar675d40e10d4dd6.93288205.png'),
(10, 'r', 'a', '$2y$10$I2VSstMCMtKbvXaZ5sDfK.c36lgy2jn0Jq8et0/QpYB1LnmFQYbR2', 'a675d41ac0a74d7.24245098.png'),
(11, 'uio', 'mop', '$2y$10$Mt8sFBiv7K82GnSwbYS7E.0kQWQuviJPlkFzqxPET.YBOnQo9t3ry', 'm675d435bb1e330.47554079.png'),
(12, 'p', 'n', '$2y$10$LDMvKFgeWa/HLFdJ1p7jx.LbZsws8PuvlHwDS4jA2Err9aB..lSDi', 'n676133d02384a4.44571256.png'),
(13, 'r', 'a', '$2y$10$CKDjuW1hDw00w/96cEaEMeGqXGhleUonmSzSX0oaRxaL5eEnd6l2q', 'default-pp.png'),
(14, 't', 'i', '$2y$10$KTqPaMx/jXl0OMy6voaf1ODgqQlZY9rWepKWN3z2AVoON0.aMOOX.', 'default-pp.png');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`) VALUES
(1, 'radwanmed', 'radwan123');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `calendrier`
--
ALTER TABLE `calendrier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `calendrier`
--
ALTER TABLE `calendrier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `calendrier`
--
ALTER TABLE `calendrier`
  ADD CONSTRAINT `calendrier_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
