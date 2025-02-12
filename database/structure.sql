-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 fév. 2025 à 16:34
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `app_enchére`
--

-- --------------------------------------------------------

--
-- Structure de la table `agriculteur`
--

CREATE TABLE `agriculteur` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `rib` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `payment` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `id_client_commande_id` int(11) NOT NULL,
  `livraison_id` int(11) NOT NULL,
  `produit` varchar(255) NOT NULL,
  `prix` double NOT NULL,
  `adresse` longtext NOT NULL,
  `num_tel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250212142221', '2025-02-12 15:22:41', 454),
('DoctrineMigrations\\Version20250212145944', '2025-02-12 16:00:42', 318),
('DoctrineMigrations\\Version20250212150032', '2025-02-12 16:02:07', 314),
('DoctrineMigrations\\Version20250212151501', '2025-02-12 16:15:10', 133),
('DoctrineMigrations\\Version20250212151742', '2025-02-12 16:17:52', 686);

-- --------------------------------------------------------

--
-- Structure de la table `enchere`
--

CREATE TABLE `enchere` (
  `id` int(11) NOT NULL,
  `id_gagnant_id` int(11) NOT NULL,
  `id_agriculteur_id` int(11) NOT NULL,
  `id_produit_enchere_id` int(11) NOT NULL,
  `derniere_prix` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `id` int(11) NOT NULL,
  `offre` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

CREATE TABLE `livraison` (
  `id` int(11) NOT NULL,
  `id_transporteur_id` int(11) NOT NULL,
  `is_etat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `id_client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier_produit_store`
--

CREATE TABLE `panier_produit_store` (
  `panier_id` int(11) NOT NULL,
  `produit_store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit_enchere`
--

CREATE TABLE `produit_enchere` (
  `id` int(11) NOT NULL,
  `agriculteur_id_id` int(11) NOT NULL,
  `categorie_id_id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `quantie` int(11) NOT NULL,
  `path_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit_store`
--

CREATE TABLE `produit_store` (
  `id` int(11) NOT NULL,
  `agriculteur_id_id` int(11) NOT NULL,
  `categorie_id_id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `quantite` double NOT NULL,
  `prix` double NOT NULL,
  `path_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `id` int(11) NOT NULL,
  `id_user_id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `is_etat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `id` int(11) NOT NULL,
  `user_id_id` int(11) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `transporteur`
--

CREATE TABLE `transporteur` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `is_disponible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `adresse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agriculteur`
--
ALTER TABLE `agriculteur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6EEAA67D83B9C0` (`id_client_commande_id`),
  ADD KEY `IDX_6EEAA67D8E54FB25` (`livraison_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `enchere`
--
ALTER TABLE `enchere`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_38D1870FC211E559` (`id_produit_enchere_id`),
  ADD KEY `IDX_38D1870FA773C26F` (`id_gagnant_id`),
  ADD KEY `IDX_38D1870F43DD3C08` (`id_agriculteur_id`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A60C9F1F7E96AC2C` (`id_transporteur_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_24CC0DF299DED506` (`id_client_id`);

--
-- Index pour la table `panier_produit_store`
--
ALTER TABLE `panier_produit_store`
  ADD PRIMARY KEY (`panier_id`,`produit_store_id`),
  ADD KEY `IDX_CC2EEE7DF77D927C` (`panier_id`),
  ADD KEY `IDX_CC2EEE7D998D9A02` (`produit_store_id`);

--
-- Index pour la table `produit_enchere`
--
ALTER TABLE `produit_enchere`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FE2A0C7612F42B4A` (`agriculteur_id_id`),
  ADD KEY `IDX_FE2A0C768A3C7387` (`categorie_id_id`);

--
-- Index pour la table `produit_store`
--
ALTER TABLE `produit_store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CFCB3FE312F42B4A` (`agriculteur_id_id`),
  ADD KEY `IDX_CFCB3FE38A3C7387` (`categorie_id_id`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CE60640479F37AE5` (`id_user_id`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5FB6DEC79D86650F` (`user_id_id`);

--
-- Index pour la table `transporteur`
--
ALTER TABLE `transporteur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agriculteur`
--
ALTER TABLE `agriculteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `enchere`
--
ALTER TABLE `enchere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit_enchere`
--
ALTER TABLE `produit_enchere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit_store`
--
ALTER TABLE `produit_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `transporteur`
--
ALTER TABLE `transporteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67D83B9C0` FOREIGN KEY (`id_client_commande_id`) REFERENCES `panier` (`id`),
  ADD CONSTRAINT `FK_6EEAA67D8E54FB25` FOREIGN KEY (`livraison_id`) REFERENCES `livraison` (`id`);

--
-- Contraintes pour la table `enchere`
--
ALTER TABLE `enchere`
  ADD CONSTRAINT `FK_38D1870F43DD3C08` FOREIGN KEY (`id_agriculteur_id`) REFERENCES `agriculteur` (`id`),
  ADD CONSTRAINT `FK_38D1870FA773C26F` FOREIGN KEY (`id_gagnant_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_38D1870FC211E559` FOREIGN KEY (`id_produit_enchere_id`) REFERENCES `produit_enchere` (`id`);

--
-- Contraintes pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD CONSTRAINT `FK_A60C9F1F7E96AC2C` FOREIGN KEY (`id_transporteur_id`) REFERENCES `transporteur` (`id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `FK_24CC0DF299DED506` FOREIGN KEY (`id_client_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `panier_produit_store`
--
ALTER TABLE `panier_produit_store`
  ADD CONSTRAINT `FK_CC2EEE7D998D9A02` FOREIGN KEY (`produit_store_id`) REFERENCES `produit_store` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CC2EEE7DF77D927C` FOREIGN KEY (`panier_id`) REFERENCES `panier` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produit_enchere`
--
ALTER TABLE `produit_enchere`
  ADD CONSTRAINT `FK_FE2A0C7612F42B4A` FOREIGN KEY (`agriculteur_id_id`) REFERENCES `agriculteur` (`id`),
  ADD CONSTRAINT `FK_FE2A0C768A3C7387` FOREIGN KEY (`categorie_id_id`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `produit_store`
--
ALTER TABLE `produit_store`
  ADD CONSTRAINT `FK_CFCB3FE312F42B4A` FOREIGN KEY (`agriculteur_id_id`) REFERENCES `agriculteur` (`id`),
  ADD CONSTRAINT `FK_CFCB3FE38A3C7387` FOREIGN KEY (`categorie_id_id`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `FK_CE60640479F37AE5` FOREIGN KEY (`id_user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `FK_5FB6DEC79D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
