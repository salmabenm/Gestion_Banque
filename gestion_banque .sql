-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 16 nov. 2023 à 16:38
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_banque`
--

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `id_sender` int(11) NOT NULL,
  `id_receiver` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `statut` enum('success','failure') DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `id_sender`, `id_receiver`, `amount`, `statut`, `transaction_date`) VALUES
(1, 55, 54, 55.00, 'success', '2023-11-16 15:31:10'),
(2, 56, 55, 400.00, 'success', '2023-11-16 15:37:07'),
(3, 56, 54, 500.00, 'success', '2023-11-16 15:37:16');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'client',
  `phone` int(100) NOT NULL,
  `soldeCompte` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `phone`, `soldeCompte`) VALUES
(40, 'banquier', 'bq@gmail.com', '161ebd7d45089b3446ee4e0d86dbcf92', 'banquier', 689238310, 30000),
(52, 'Salma Benmoussa', 'salma.ben@gmail.com', '161ebd7d45089b3446ee4e0d86dbcf92', 'client', 689238313, 27950),
(53, 'Salma Ben', 'Salma@gmail.com', '161ebd7d45089b3446ee4e0d86dbcf92', 'client', 689238312, 6050),
(54, 'Benmoussa', 'benmoudssa@gmail.com', '161ebd7d45089b3446ee4e0d86dbcf92', 'client', 689238311, 2555),
(55, 'Salma ', 'salma.benmoudssa@gmail.com', '6ee6ea22790b793ba3e072309c4e057e', 'banquier', 689239310, 400),
(56, 'bq', 'salsa@gmail.com', '6ee6ea22790b793ba3e072309c4e057e', 'client', 689238316, 6877);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sender` (`id_sender`),
  ADD KEY `id_receiver` (`id_receiver`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`id_sender`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`id_receiver`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
