-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 22 jan. 2022 à 19:53
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_bdd_2`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE IF NOT EXISTS `adresse` (
  `id_adresse` int(11) NOT NULL AUTO_INCREMENT,
  `rue` varchar(100) NOT NULL,
  `code_postal` varchar(5) NOT NULL,
  `ville` varchar(100) NOT NULL,
  PRIMARY KEY (`id_adresse`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id_adresse`, `rue`, `code_postal`, `ville`) VALUES
(1, '24 place de la République', '72000', 'Le Mans'),
(2, '18 place de la République', '72000', 'Le Mans'),
(3, '54 Rue Davidson', '06300', 'Nice');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(100) NOT NULL,
  `facebook_account` varchar(100) DEFAULT NULL,
  `instagram_account` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_phone` int(11) NOT NULL,
  `id_adresse` int(11) NOT NULL,
  `id_fidelite` int(11) NOT NULL,
  PRIMARY KEY (`id_client`),
  KEY `id_phone` (`id_phone`),
  KEY `id_adresse` (`id_adresse`),
  KEY `id_fidelite` (`id_fidelite`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom_client`, `facebook_account`, `instagram_account`, `email`, `id_phone`, `id_adresse`, `id_fidelite`) VALUES
(1, 'Charles', '@charles', '@charles.insta', 'test@email.fr', 1, 1, 1),
(2, 'Sarah', '', '', 'test@email.fr', 2, 2, 2),
(3, 'Max', '', '', 'test@email.fr', 3, 3, 9);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_order` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `date` date NOT NULL,
  `prix` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_order`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_order`, `id_client`, `date`, `prix`) VALUES
(1, 1, '2022-01-22', 786.45);

-- --------------------------------------------------------

--
-- Structure de la table `depense_points`
--

DROP TABLE IF EXISTS `depense_points`;
CREATE TABLE IF NOT EXISTS `depense_points` (
  `id_fidelite` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `id_limited_points` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `nb_points` int(11) NOT NULL,
  PRIMARY KEY (`id_fidelite`,`id_invoice`),
  KEY `id_invoice` (`id_invoice`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `external_stock`
--

DROP TABLE IF EXISTS `external_stock`;
CREATE TABLE IF NOT EXISTS `external_stock` (
  `id_item` int(11) NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `quantite` int(11) NOT NULL,
  PRIMARY KEY (`id_item`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `fidelite`
--

DROP TABLE IF EXISTS `fidelite`;
CREATE TABLE IF NOT EXISTS `fidelite` (
  `id_fidelite` int(11) NOT NULL AUTO_INCREMENT,
  `nb_point` int(11) NOT NULL DEFAULT '0',
  `id_membership` int(11) NOT NULL,
  PRIMARY KEY (`id_fidelite`),
  KEY `id_membership` (`id_membership`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fidelite`
--

INSERT INTO `fidelite` (`id_fidelite`, `nb_point`, `id_membership`) VALUES
(1, 0, 2),
(2, 0, 1),
(3, 0, 1),
(4, 0, 1),
(5, 0, 2),
(6, 0, 2),
(7, 0, 2),
(8, 0, 1),
(9, 0, 3);

-- --------------------------------------------------------

--
-- Structure de la table `gagne_points`
--

DROP TABLE IF EXISTS `gagne_points`;
CREATE TABLE IF NOT EXISTS `gagne_points` (
  `id_fidelite` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `date` date NOT NULL,
  `nb_points` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_fidelite`,`id_invoice`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `id_invoice` int(11) NOT NULL AUTO_INCREMENT,
  `total_invoice_price` float NOT NULL,
  `id_order` int(11) NOT NULL,
  PRIMARY KEY (`id_invoice`),
  KEY `id_order` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `nom_item` varchar(100) NOT NULL,
  `item_price` float NOT NULL,
  `description` text,
  `stock` int(11) NOT NULL DEFAULT '0',
  `id_item_status` int(11) NOT NULL,
  PRIMARY KEY (`id_item`),
  KEY `id_item_status` (`id_item_status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id_item`, `nom_item`, `item_price`, `description`, `stock`, `id_item_status`) VALUES
(1, 'Channel', 10.5, 'Parfum Channel', 92, 1),
(2, 'Boss', 50.99, NULL, 90, 2),
(3, 'Dior', 100, NULL, 97, 1);

-- --------------------------------------------------------

--
-- Structure de la table `item_status`
--

DROP TABLE IF EXISTS `item_status`;
CREATE TABLE IF NOT EXISTS `item_status` (
  `id_item_status` int(11) NOT NULL AUTO_INCREMENT,
  `nom_item_status` varchar(20) NOT NULL,
  PRIMARY KEY (`id_item_status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `item_status`
--

INSERT INTO `item_status` (`id_item_status`, `nom_item_status`) VALUES
(1, 'En stock'),
(2, 'Stock indisponible'),
(3, 'Disponible'),
(4, 'Indisponible');

-- --------------------------------------------------------

--
-- Structure de la table `limited_points`
--

DROP TABLE IF EXISTS `limited_points`;
CREATE TABLE IF NOT EXISTS `limited_points` (
  `id_limited_points` int(11) NOT NULL AUTO_INCREMENT,
  `nb_point` int(11) NOT NULL,
  `date_expiration` date NOT NULL,
  `id_fidelite` int(11) NOT NULL,
  PRIMARY KEY (`id_limited_points`),
  KEY `id_fidelite` (`id_fidelite`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `membership`
--

DROP TABLE IF EXISTS `membership`;
CREATE TABLE IF NOT EXISTS `membership` (
  `id_membership` int(11) NOT NULL AUTO_INCREMENT,
  `nom_membership` enum('Silver','Gold','Platinium','Ultimate') NOT NULL DEFAULT 'Silver',
  PRIMARY KEY (`id_membership`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membership`
--

INSERT INTO `membership` (`id_membership`, `nom_membership`) VALUES
(1, 'Silver'),
(2, 'Gold'),
(3, 'Platinium'),
(4, 'Ultimate'),
(5, 'Silver'),
(6, 'Gold'),
(7, 'Silver'),
(8, 'Silver'),
(9, 'Silver'),
(10, 'Gold'),
(11, 'Gold'),
(12, 'Gold'),
(13, 'Silver'),
(14, 'Platinium');

-- --------------------------------------------------------

--
-- Structure de la table `order_content`
--

DROP TABLE IF EXISTS `order_content`;
CREATE TABLE IF NOT EXISTS `order_content` (
  `id_order` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_total` float NOT NULL DEFAULT '0',
  `date_expedition` date DEFAULT NULL,
  `date_livraison` date DEFAULT NULL,
  PRIMARY KEY (`id_order`,`id_item`) USING BTREE,
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `order_content`
--

INSERT INTO `order_content` (`id_order`, `id_item`, `quantite`, `prix_total`, `date_expedition`, `date_livraison`) VALUES
(1, 1, 3, 31.5, '2022-01-17', '2022-01-23'),
(1, 2, 5, 254.95, '2022-01-17', NULL),
(1, 3, 5, 500, '2022-01-19', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
CREATE TABLE IF NOT EXISTS `order_status` (
  `id_order_status` int(11) NOT NULL AUTO_INCREMENT,
  `nom_order_status` varchar(50) NOT NULL,
  `id_order` int(11) NOT NULL,
  PRIMARY KEY (`id_order_status`),
  KEY `id_order` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id_payement` int(11) NOT NULL,
  `datePayement` date NOT NULL,
  `somme` float NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `id_payment_method` int(11) NOT NULL,
  PRIMARY KEY (`id_invoice`) USING BTREE,
  KEY `id_payment_method` (`id_payment_method`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `payment_method`
--

DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE IF NOT EXISTS `payment_method` (
  `id_payment_method` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id_payment_method`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `telephone`
--

DROP TABLE IF EXISTS `telephone`;
CREATE TABLE IF NOT EXISTS `telephone` (
  `id_phone` int(11) NOT NULL AUTO_INCREMENT,
  `noPhone` varchar(20) NOT NULL,
  PRIMARY KEY (`id_phone`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `telephone`
--

INSERT INTO `telephone` (`id_phone`, `noPhone`) VALUES
(1, '0645896541'),
(2, '0456325874'),
(3, '0256987456');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`id_phone`) REFERENCES `telephone` (`id_phone`),
  ADD CONSTRAINT `client_ibfk_2` FOREIGN KEY (`id_adresse`) REFERENCES `adresse` (`id_adresse`),
  ADD CONSTRAINT `fk_id_fidelite` FOREIGN KEY (`id_fidelite`) REFERENCES `fidelite` (`id_fidelite`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `depense_points`
--
ALTER TABLE `depense_points`
  ADD CONSTRAINT `depense_points_ibfk_1` FOREIGN KEY (`id_fidelite`) REFERENCES `fidelite` (`id_fidelite`),
  ADD CONSTRAINT `depense_points_ibfk_2` FOREIGN KEY (`id_invoice`) REFERENCES `invoice` (`id_invoice`);

--
-- Contraintes pour la table `external_stock`
--
ALTER TABLE `external_stock`
  ADD CONSTRAINT `external_stock_ibfk_1` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`);

--
-- Contraintes pour la table `fidelite`
--
ALTER TABLE `fidelite`
  ADD CONSTRAINT `fk_membership` FOREIGN KEY (`id_membership`) REFERENCES `membership` (`id_membership`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `commande` (`id_order`);

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`id_item_status`) REFERENCES `item_status` (`id_item_status`);

--
-- Contraintes pour la table `limited_points`
--
ALTER TABLE `limited_points`
  ADD CONSTRAINT `fk_fidelite` FOREIGN KEY (`id_fidelite`) REFERENCES `fidelite` (`id_fidelite`);

--
-- Contraintes pour la table `order_content`
--
ALTER TABLE `order_content`
  ADD CONSTRAINT `order_content_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `commande` (`id_order`),
  ADD CONSTRAINT `order_content_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`);

--
-- Contraintes pour la table `order_status`
--
ALTER TABLE `order_status`
  ADD CONSTRAINT `order_status_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `commande` (`id_order`);

--
-- Contraintes pour la table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`id_invoice`) REFERENCES `invoice` (`id_invoice`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`id_payment_method`) REFERENCES `payment_method` (`id_payment_method`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
