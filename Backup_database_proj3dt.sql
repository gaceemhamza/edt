-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `edt`
--
CREATE DATABASE IF NOT EXISTS `edt` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `edt`;

-- --------------------------------------------------------

--
-- Structure de la table `alerte`
--

CREATE TABLE `alerte` (
  `num_alerte` int(11) NOT NULL,
  `libelle_alerte` varchar(100) DEFAULT NULL,
  `motif_alerte` varchar(100) DEFAULT NULL,
  `statut_alerte` tinyint(1) DEFAULT NULL,
  `num_seance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `batiment`
--

CREATE TABLE `batiment` (
  `code_batiment` varchar(6) NOT NULL,
  `libelle_batiment` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `diplome`
--

CREATE TABLE `diplome` (
  `code_diplome` varchar(10) CHARACTER SET latin1 NOT NULL,
  `niveau` varchar(5) CHARACTER SET latin1 NOT NULL,
  `libelle_diplome` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `annee_debut` year(4) DEFAULT NULL,
  `annee_fin` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `diplome`
--

INSERT INTO `diplome` (`code_diplome`, `niveau`, `libelle_diplome`, `annee_debut`, `annee_fin`) VALUES
('L1DOC', 'L1', 'Licence 1 Documentation', 2019, 2020),
('L2DOC', 'L2', 'Licence 2 Documentation', 2019, 2020),
('L3DOC', 'L3', 'Licence 3 Documentation', 2019, 2020),
('L3EN', 'L3', 'Licence Pro Édition parcours édition numérique ', 2018, 2019),
('M1INFODOC', 'M1', 'Information-Documentation', 2018, 2019),
('M2ARI', 'M2', 'Archives et images', 2018, 2019),
('M2EIN', 'M2', 'Edition imprimée et numérique ', 2018, 2019),
('M2I2N', 'M2', 'Ingénierie de l\'information numérique ', 2018, 2019);

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

CREATE TABLE `enseignant` (
  `num_enseignant` int(11) NOT NULL,
  `nom_enseignant` varchar(30) DEFAULT NULL,
  `prenom_enseignant` varchar(30) DEFAULT NULL,
  `mail_enseignant` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `tel_enseignant` varchar(10) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `enseignant`
--

INSERT INTO `enseignant` (`num_enseignant`, `nom_enseignant`, `prenom_enseignant`, `mail_enseignant`, `tel_enseignant`) VALUES
(5, 'DKAKI', 'Taoufiq', 'dkaki.taoufiq@irit.fr', '0600000000'),
(6, 'COSTES', 'Mylène', 'mylene.costes@univ-tlse2.fr', '0600000000'),
(8, 'CRAMA', 'Isabelle', 'isabellec@graphique.net', '0600000000'),
(12, 'MORENO', 'José', 'moreno.jose@univ-tlse.fr', '0600000000'),
(13, 'BARTHE-GAY', 'Clarisse', 'c.barthe@uni-tlse2.fr', '0500000023'),
(14, 'MAGNAN', 'François', 'francois.magnan@gmail.com', '0500000056'),
(15, 'AUSSET', 'Laurent', 'lausset@univ-tlse2.fr', '0500000045'),
(16, 'FERRANTE', 'Eric', 'eric.ferrante@univ-tlse2.fr', '0500000021'),
(17, 'DIAKITE', 'Madié', 'm.diakite@idstrategie.fr', '0500000024'),
(18, 'DU CHATEAU', 'Stefan', 'stefan.du-chateau@univ-tlse2.fr', '0500000078'),
(19, 'CHARREL', 'Pierre-Jean', 'charrek@univ-tlse2.fr', '0500000032'),
(20, 'FILIPPI', 'Bruno', 'bruno.filippi@univ-tlse2.fr', '0500000047'),
(21, 'BARBAS', 'Stéphan', 's.barbas@univ-tlse2.fr', '0500000021'),
(22, 'AUZZEL', 'Dominique', 'd.auzzel@univ-tlse2.fr', '0545002100'),
(25, 'juan', 'pablo', 'te@yahoo.fr', '0602510185');

-- --------------------------------------------------------

--
-- Structure de la table `enseigner`
--

CREATE TABLE `enseigner` (
  `num_enseignant` int(11) NOT NULL,
  `num_matiere` int(11) NOT NULL,
  `volume_horaire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `enseigner`
--

INSERT INTO `enseigner` (`num_enseignant`, `num_matiere`, `volume_horaire`) VALUES
(5, 38, NULL),
(5, 47, NULL),
(5, 51, NULL),
(6, 40, NULL),
(8, 45, NULL),
(12, 49, NULL),
(13, 44, NULL),
(13, 52, NULL),
(13, 60, NULL),
(14, 41, NULL),
(15, 43, NULL),
(16, 39, NULL),
(17, 42, NULL),
(17, 59, NULL),
(18, 48, NULL),
(18, 56, NULL),
(18, 57, NULL),
(18, 58, NULL),
(20, 50, NULL),
(21, 99, NULL),
(22, 97, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `num_etu` int(11) NOT NULL,
  `nom_etu` varchar(50) DEFAULT NULL,
  `prenom_etu` varchar(50) DEFAULT NULL,
  `mail_etu` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `former`
--

CREATE TABLE `former` (
  `num_etu` int(11) NOT NULL,
  `num_groupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `gerer`
--

CREATE TABLE `gerer` (
  `identifiant_user` int(11) NOT NULL,
  `code_diplome` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `gerer`
--

INSERT INTO `gerer` (`identifiant_user`, `code_diplome`) VALUES
(1, 'M2I2N'),
(2, 'L2DOC'),
(3, 'M1INFODOC'),
(3, 'M2EIN'),
(4, 'L3EN'),
(5, 'M2EIN'),
(12, 'M2ARI'),
(14, 'M2ARI');

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `num_groupe` int(11) NOT NULL,
  `libelle_groupe` varchar(50) DEFAULT NULL,
  `nature_groupe` varchar(50) DEFAULT NULL COMMENT 'Groupe principal / Sous-groupe',
  `code_diplome` varchar(10) NOT NULL,
  `num_groupe_compose` varchar(11) NOT NULL COMMENT 'reste vide si le groupe est principal/ si sous-groupe alors enregistrer clé primaire du groupe parent'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `groupe`
--

INSERT INTO `groupe` (`num_groupe`, `libelle_groupe`, `nature_groupe`, `code_diplome`, `num_groupe_compose`) VALUES
(2, 'M2I2N', 'Groupe Principal', 'M2I2N', ''),
(3, 'LicenceDoc', 'Groupe Principal', 'L3EN', ''),
(4, 'Groupe1', 'Sous-groupe', 'L3EN', '3');

-- --------------------------------------------------------

--
-- Structure de la table `intervenir`
--

CREATE TABLE `intervenir` (
  `code_diplome` varchar(10) NOT NULL,
  `num_enseignant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `intervenir`
--

INSERT INTO `intervenir` (`code_diplome`, `num_enseignant`) VALUES
('L3DOC', 21),
('L3DOC', 22),
('L3EN', 6),
('M1INFODOC', 5),
('M1INFODOC', 6),
('M1INFODOC', 13),
('M1INFODOC', 15),
('M1INFODOC', 22),
('M2ARI', 13),
('M2ARI', 17),
('M2ARI', 18),
('M2EIN', 13),
('M2EIN', 22),
('M2I2N', 5),
('M2I2N', 6),
('M2I2N', 8),
('M2I2N', 12),
('M2I2N', 13),
('M2I2N', 14),
('M2I2N', 15),
('M2I2N', 16),
('M2I2N', 17),
('M2I2N', 19),
('M2I2N', 20);

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `num_matiere` int(11) NOT NULL,
  `libelle_matiere` varchar(50) DEFAULT NULL,
  `volume_horaire` int(11) NOT NULL,
  `code_ue` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`num_matiere`, `libelle_matiere`, `volume_horaire`, `code_ue`) VALUES
(7, 'La bande dessinée ', 0, 'AM0E904V'),
(8, 'Conception graphique', 0, 'AM0E903V'),
(9, 'La fonction éditoriale ', 0, 'AM0E901V'),
(10, 'Projet éditorial : présentation', 0, 'AM0E905V'),
(11, 'Diffusion et commercialisation du livre ', 0, 'AM0E902V'),
(12, 'Correction', 0, 'AM0E903V'),
(13, 'Économie du livre', 0, 'AM0E901V'),
(14, 'Droit de la propriété intellectuelle ', 0, 'AM0E901V'),
(15, 'Édition numérique : les outils ', 0, 'AM0E902V'),
(16, 'Histoire du livre et de l\'édition 1', 0, 'AM0E901V'),
(17, 'Projet éditorial : élaboration ', 0, 'AM0E905V'),
(18, 'Projet éditorial : communication', 0, 'AM0E112V'),
(19, 'La chaîne du livre numérique ', 0, 'AM0E902V'),
(20, 'Projet éditorial : recherche iconographique ', 0, 'AM0E906V'),
(21, 'Droit de l\'édition', 0, 'AM0E901V'),
(22, 'Sociologie de la lecture ', 0, 'AM0E901V'),
(23, 'L\'édition en région ', 0, 'AM0E901V'),
(24, 'Projet éditorial : réécriture', 0, 'AM0E112V'),
(25, 'Projet éditorial : mise en page', 0, 'AM0E113V'),
(26, 'Fabrication du livre ', 0, 'AM0E902V'),
(27, 'Histoire du livre et de l\'édition 2', 0, 'AM0E901V'),
(28, 'L\'édition jeunesse', 0, 'AM0E114V'),
(29, 'Anglais professionnel ', 0, 'AM0E907V'),
(30, 'Journée aux PUM', 0, 'AM0E904V'),
(31, 'Les aides à l\'édition', 0, 'AM0E901V'),
(32, 'Le livre d\'art', 0, 'AM0E114V'),
(33, 'Les relations entre diffuseur et éditeur', 0, 'AM0E902V'),
(34, 'Visite de l\'imprimerie Art & Caractère', 0, 'AM0E902V'),
(35, 'Le livre pratique', 0, 'AM0E904V'),
(36, 'L\'édition littéraire', 0, 'AM0E114V'),
(37, 'Livre et industrie culturelle', 0, 'AM0E901V'),
(38, 'Algorithmique et programmation', 0, 'AM0I901V'),
(39, 'Création site web ', 0, 'AM0I112V'),
(40, 'Pratiques documentaires', 0, 'AM0I904V'),
(41, 'Source d\'info et veille', 0, 'AM0I902V'),
(42, 'Gestion de projet transversal ', 0, 'AM0I905V'),
(43, 'Audit des SI', 0, 'AM0I903V'),
(44, 'Droit', 0, 'AM0I903V'),
(45, 'Multimédia : Photoshop', 0, 'AM0I905V'),
(46, 'Méthodes de conception', 0, 'AM0I903V'),
(47, 'Bases de données ', 0, 'AM0I907V'),
(48, 'XML ', 0, 'AM0I907V'),
(49, 'JavaScript ', 0, 'AM0I907V'),
(50, 'Plateforme CMS', 0, 'AM0I113V'),
(51, 'Informatique et programmation', 0, 'AM0I901V'),
(52, 'Droit des brevets et de la protection des données', 0, 'AM0I903V'),
(53, 'Archivistique : présentation', 0, 'AM0A901V'),
(54, 'Archivistique 1 : Introduction à l\'archivistique ', 0, 'AM0A904V'),
(55, 'Archivistique 1 : Histoire des archives ', 0, 'AM0A904V'),
(56, 'Mise à niveau informatique ', 0, 'AM0A901V'),
(57, 'Informatique - algorithmique niv.2 ', 0, 'AM0A901V'),
(58, 'Interfaces Web : HTML5, CSS, ActionScript,JavaScri', 0, 'AM0A901V'),
(59, 'Gestion de projet ', 0, 'AM0A905V'),
(60, 'Droit de la propriété intellectuelle', 0, 'AM0A907V'),
(61, 'Archivistique 1 : Législation des archives', 0, 'AM0A904V'),
(62, 'Archivistique 1 : Visite du dépôt ', 0, 'AM0A904V'),
(63, 'Archivistique 1 : les fonds figurés - le service p', 0, 'AM0A904V'),
(64, 'Déconstruire-co/construire l\'image', 0, 'AM0A902V'),
(65, 'Images 1 : Histoire de la photographie', 0, 'AM0A902V'),
(66, 'Documentation audiovisuelle ', 0, 'AM0A903V'),
(67, 'Archivistique 1 : Les instruments de recherche', 0, 'AM0A904V'),
(68, 'Pratique professionnelle de l\'anglais', 0, 'AM0A902V'),
(69, 'Les normes de description archivistique ', 0, 'AM0A901V'),
(70, 'BDD, XML', 0, 'AM0A901V'),
(71, 'Technologie de l\'image numérique ', 0, 'AM0A901V'),
(72, 'Image 2 : Histoire de la photographie', 0, 'AM0A903V'),
(95, 'Panorama de la littérature contemporaine ', 0, 'AM0B402V'),
(96, 'Mener une recherche documentaire ', 0, 'AM0B402V'),
(97, 'Introduction à l\'édition ', 0, 'AM0B402V'),
(98, 'Indexation ', 0, 'AM00501V'),
(99, 'Recherche d\'information', 0, 'AM00501V');

-- --------------------------------------------------------

--
-- Structure de la table `originaire`
--

CREATE TABLE `originaire` (
  `num_initial` int(11) NOT NULL,
  `num_seance` int(11) NOT NULL,
  `num_salle` varchar(7) NOT NULL,
  `num_groupe` int(11) NOT NULL,
  `num_alerte` int(11) NOT NULL,
  `num_enseignant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `num_profil` int(11) NOT NULL,
  `libelle_profil` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`num_profil`, `libelle_profil`) VALUES
(1, 'Administrateur'),
(2, 'Éditeur'),
(3, 'Gestionnaire');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `num_salle` varchar(7) NOT NULL,
  `capacite` int(11) DEFAULT NULL,
  `num_type_salle` int(11) NOT NULL,
  `code_batiment` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `seance`
--

CREATE TABLE `seance` (
  `num_seance` int(11) NOT NULL,
  `libelle_seance` varchar(50) DEFAULT NULL,
  `num_matiere` int(11) DEFAULT NULL COMMENT 'elle contient l''id de la matière programmée dans la séance',
  `type_seance` varchar(15) DEFAULT '' COMMENT 'CM, TD, Seminaire, Exposé',
  `mutualisation` int(1) DEFAULT NULL COMMENT 'oui (1) / non (0)',
  `commentaire` text,
  `etat` int(50) DEFAULT NULL COMMENT 'Séance active(1) ou pas (0)',
  `panier` int(1) DEFAULT NULL,
  `statut_attribution` int(1) DEFAULT NULL,
  `start_seance` datetime DEFAULT NULL COMMENT 'date de debut de la seance',
  `end_seance` datetime DEFAULT NULL COMMENT 'date de fin de la séance',
  `num_salle` varchar(50) DEFAULT '',
  `enseignant_seance` varchar(50) NOT NULL DEFAULT '' COMMENT 'l''enseignant chargé de diriger la séance',
  `num_enseignant` int(11) DEFAULT NULL COMMENT 'pourrait servir pour calculer le volume horaire',
  `groupe_seance` varchar(100) DEFAULT NULL COMMENT 'Les groupes qui participent à la séance : qd il y a plusieurs; ils sont séparés par un antislash',
  `color_seance` varchar(50) NOT NULL COMMENT 'couleur de la seance'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `seance`
--

INSERT INTO `seance` (`num_seance`, `libelle_seance`, `num_matiere`, `type_seance`, `mutualisation`, `commentaire`, `etat`, `panier`, `statut_attribution`, `start_seance`, `end_seance`, `num_salle`, `enseignant_seance`, `num_enseignant`, `groupe_seance`, `color_seance`) VALUES
(75, 'Programmation PHP', 51, 'TP', NULL, '', NULL, NULL, NULL, '2019-03-25 09:00:00', '2019-03-25 12:00:00', 'GH131', 'DKAKI Taoufiq', 5, 'M2I2N', '#FF8C00'),
(76, 'Pratiques documentaires', 40, 'TD', NULL, '', NULL, NULL, NULL, '2019-03-25 14:00:00', '2019-03-25 17:00:00', '', 'COSTES Mylène', 6, 'M2I2N', '#4ca85e'),
(77, 'CMS', 50, 'TP', NULL, '', NULL, NULL, NULL, '2019-03-26 08:30:00', '2019-03-26 12:30:00', 'GH131', 'FILIPPI Bruno', 20, 'M2I2N', '#FFD700'),
(80, 'Droit', 44, 'CM', NULL, '', NULL, NULL, NULL, '2019-03-27 09:00:00', '2019-03-27 12:00:00', 'GH131', 'BARTHE-GAY Clarisse', 13, 'M2I2N', '#0071c5'),
(82, 'Audit des SI', 43, 'CM', NULL, '', NULL, NULL, NULL, '2019-03-27 14:00:00', '2019-03-27 17:00:00', 'GH132', 'AUSSET Laurent', 15, 'M2I2N', '#0071c5'),
(85, 'HTML/CSS', 39, 'CM', NULL, '', NULL, NULL, NULL, '2019-03-26 14:00:00', '2019-03-26 16:30:00', '', 'FERRANTE Eric', 16, 'M2I2N', '#cb73e0');

-- --------------------------------------------------------

--
-- Structure de la table `seance_initial`
--

CREATE TABLE `seance_initial` (
  `num_initial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `type_salle`
--

CREATE TABLE `type_salle` (
  `num_type_salle` int(11) NOT NULL,
  `libelle_type_salle` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ue`
--

CREATE TABLE `ue` (
  `code_ue` char(10) NOT NULL,
  `libelle_ue` varchar(50) NOT NULL,
  `code_diplome` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ue`
--

INSERT INTO `ue` (`code_ue`, `libelle_ue`, `code_diplome`) VALUES
('AM00101V', 'Bibliothèques, éditeurs et librairies aujourd\'hui', 'L1DOC'),
('AM00102V', 'Archives, documentation audiovisuelle aujourd\'hui', 'L1DOC'),
('AM00105V', 'Connaître les métiers du livre et de la documentat', 'L1DOC'),
('AM00201V', 'Documents : livres, périodiques, images', 'L1DOC'),
('AM00202V', 'Documents : archives, documents numériques', 'L1DOC'),
('AM00205V', 'Lecture et pratique des écrits professionnels ', 'L1DOC'),
('AM00301V', 'Approche historique des documents', 'L2DOC'),
('AM00302V', 'Droit public, bibliothéconomie et archivistique', 'L2DOC'),
('AM00305V', 'Expression écrite et orale - concours professionne', 'L2DOC'),
('AM00401V', 'Décrire les documents : métadonnées descriptives', 'L2DOC'),
('AM00405V', 'Informatique documentaire', 'L2DOC'),
('AM00501V', 'Indexation 1 et recherche d\'information', 'L3DOC'),
('AM00601V', 'Droit de la culture - Indexation 2', 'L3DOC'),
('AM00605V', 'Expression orale et écrite 2 - Informatique docume', 'L3DOC'),
('AM0A111V', 'Mémoire et stage', 'M2ARI'),
('AM0A112V', 'Archivistique 2', 'M2ARI'),
('AM0A113V', 'Gestion de projet 2', 'M2ARI'),
('AM0A114V', 'Gestion de projet 3', 'M2ARI'),
('AM0A402V', 'Archives 1', 'L2DOC'),
('AM0A502V', 'Archives 2', 'L3DOC'),
('AM0A503V', 'Archives 3', 'L3DOC'),
('AM0A505V', 'Archives 4', 'L3DOC'),
('AM0A602V', 'Archives 5', 'L3DOC'),
('AM0A603V', 'Archives 6', 'L3DOC'),
('AM0A901V', 'Informatique et gestion informatisée des fonds doc', 'M2ARI'),
('AM0A902V', 'Images 1', 'M2ARI'),
('AM0A903V', 'Images 2', 'M2ARI'),
('AM0A904V', 'Archivistique 1', 'M2ARI'),
('AM0A905V', 'Gestion de projet 1', 'M2ARI'),
('AM0A906V', 'Pratique professionnelle de l\'anglais', 'M2ARI'),
('AM0A907V', 'Droit', 'M2ARI'),
('AM0B402V', 'Bibliothèque 1', 'L2DOC'),
('AM0B502V', 'Bibliothèque 2', 'L3DOC'),
('AM0B503V', 'Bibliothèque 3', 'L3DOC'),
('AM0B505V', 'Bibliothèque 4', 'L3DOC'),
('AM0B602V', 'Bibliothèque 5', 'L3DOC'),
('AM0B603V', 'Bibliothèque 6', 'L3DOC'),
('AM0D402V', 'Image 1', 'L2DOC'),
('AM0D502V', 'Images 2', 'L3DOC'),
('AM0D503V', 'Image 3', 'L3DOC'),
('AM0D505V', 'Image 4', 'L3DOC'),
('AM0D602V', 'Image 5', 'L3DOC'),
('AM0D603V', 'Image 6', 'L3DOC'),
('AM0E111V', 'Mémoire et stage', 'M2EIN'),
('AM0E112V', 'Projet éditorial 2', 'M2EIN'),
('AM0E113V', 'Porjet éditorial 3', 'M2EIN'),
('AM0E114V', 'Les secteurs éditoriaux 2', 'M2EIN'),
('AM0E901V', 'L\'édition et son environnement', 'M2EIN'),
('AM0E902V', 'L\'activité éditoriale', 'M2EIN'),
('AM0E903V', 'Les outils de l\'éditeur', 'M2EIN'),
('AM0E904V', 'Les secteurs éditoriaux 1', 'M2EIN'),
('AM0E905V', 'Gestion de projet', 'M2EIN'),
('AM0E906V', 'Projet éditorial 1', 'M2EIN'),
('AM0E907V', 'Anglais professionnel', 'M2EIN'),
('AM0I111V', 'Mémoire et stage', 'M2I2N'),
('AM0I112V', 'Conception des systèmes d\'information 2', 'M2I2N'),
('AM0I113V', 'Conception et développement de sites web', 'M2I2N'),
('AM0I114V', 'Conception et gestion d\'objets multimédia 2', 'M2I2N'),
('AM0I901V', 'Programmation et production web', 'M2I2N'),
('AM0I902V', 'Sources d\'info, veille stratégique et documentaire', 'M2I2N'),
('AM0I903V', 'Conception des systèmes d\'information 1 et Droit', 'M2I2N'),
('AM0I904V', 'Pratiques documentaires', 'M2I2N'),
('AM0I905V', 'Gestion de projet', 'M2I2N'),
('AM0I906V', 'Conception et gestion d\'objets multimédia 1', 'M2I2N'),
('AM0I907V', 'Bases de données', 'M2I2N');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `identifiant_user` int(11) NOT NULL,
  `login_user` varchar(50) DEFAULT NULL,
  `mdp_user` varchar(255) NOT NULL,
  `mail_user` varchar(50) DEFAULT NULL,
  `nom_user` varchar(50) DEFAULT NULL,
  `prenom_user` varchar(50) DEFAULT NULL,
  `num_profil` int(11) NOT NULL,
  `etat` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`identifiant_user`, `login_user`, `mdp_user`, `mail_user`, `nom_user`, `prenom_user`, `num_profil`, `etat`) VALUES
(1, 't.dkaki', '1234', 'taoufiq.dkaki@irit.fr ', 'Dkaki', 'Taoufiq', 1, 1),
(2, 'p.mouly', '1234', 'dam@univ-tlse2.fr ', 'Mouly', 'Patricia', 3, 1),
(3, 'l.ausset', '1234', 'lausset@univ-tlse2.fr', 'Ausset', 'Laurent', 2, 1),
(4, 'm.costes', '1234', 'mylene.costes@univ-tlse2.fr ', 'Costes', 'Mylène', 2, 1),
(5, 'c.barthe', '1234', 'cbarthe@univ-tlse2.fr', 'Barthe-Gay', 'Clarisse', 2, 1),
(6, 'd.auzel', '1234', 'd.auzel@gmail.com', 'Auzel', 'Domique', 2, 0),
(8, 's.barbas', '1234', 'sbarbas@hotmail.fr', 'Barbas', 'Stephan', 2, 1),
(9, 'i.bastide', '1234', 'isabelle.bastide@univ-tlse2.fr', 'Bastide-Vanneau ', 'Isabelle', 2, 1),
(10, 'f.mazzone', '1234', 'fanny.mazzone@univ-tlse2.fr', 'Mazzone', 'Fanny', 2, 1),
(11, 'a.moulis', '1234', 'amoulis@univ-tlse2.fr', 'Moulis', 'Anne-Marie', 2, 1),
(12, 'i.theiller', '1234', 'isabelle.theiller@univ-tlse2.fr', 'Theiller', 'Isabelle', 2, 0),
(14, 't.zoum', '$2y$10$hek5/apQij6Fx8ht6Qx.luSYGIFZm.HUVLWFFRj2/yZfMWdu4Om6O', 'tzsouhaib1@yahoo.fr', 'TOU', 'Zoum', 1, 0),
(15, 'zoum', 'zoum', 'tzsouhaib1@yahoo.fr', 'Zoum', 'TOU', 2, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `alerte`
--
ALTER TABLE `alerte`
  ADD PRIMARY KEY (`num_alerte`),
  ADD KEY `Alerte_seance0_FK` (`num_seance`);

--
-- Index pour la table `batiment`
--
ALTER TABLE `batiment`
  ADD PRIMARY KEY (`code_batiment`);

--
-- Index pour la table `diplome`
--
ALTER TABLE `diplome`
  ADD PRIMARY KEY (`code_diplome`);

--
-- Index pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`num_enseignant`);

--
-- Index pour la table `enseigner`
--
ALTER TABLE `enseigner`
  ADD PRIMARY KEY (`num_enseignant`,`num_matiere`),
  ADD KEY `enseigner_matiere1_FK` (`num_matiere`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`num_etu`);

--
-- Index pour la table `former`
--
ALTER TABLE `former`
  ADD PRIMARY KEY (`num_etu`,`num_groupe`),
  ADD KEY `former_groupe1_FK` (`num_groupe`);

--
-- Index pour la table `gerer`
--
ALTER TABLE `gerer`
  ADD PRIMARY KEY (`identifiant_user`,`code_diplome`),
  ADD KEY `gerer_diplome1_FK` (`code_diplome`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`num_groupe`),
  ADD KEY `groupe_diplome0_FK` (`code_diplome`);

--
-- Index pour la table `intervenir`
--
ALTER TABLE `intervenir`
  ADD PRIMARY KEY (`code_diplome`,`num_enseignant`),
  ADD KEY `intervenir_enseignant1_FK` (`num_enseignant`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`num_matiere`),
  ADD KEY `matiere_ue0_FK` (`code_ue`);

--
-- Index pour la table `originaire`
--
ALTER TABLE `originaire`
  ADD PRIMARY KEY (`num_initial`,`num_seance`,`num_salle`,`num_groupe`,`num_alerte`,`num_enseignant`) USING BTREE,
  ADD KEY `originaire_seance1_FK` (`num_seance`),
  ADD KEY `originaire_salle5_FK` (`num_salle`),
  ADD KEY `originaire_groupe6_FK` (`num_groupe`),
  ADD KEY `originaire_Alerte8_FK` (`num_alerte`),
  ADD KEY `originaire_enseignant9_FK` (`num_enseignant`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`num_profil`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`num_salle`),
  ADD KEY `salle_type_salle0_FK` (`num_type_salle`),
  ADD KEY `salle_batiment1_FK` (`code_batiment`);

--
-- Index pour la table `seance`
--
ALTER TABLE `seance`
  ADD PRIMARY KEY (`num_seance`),
  ADD KEY `seance_matiere1_FK` (`num_matiere`),
  ADD KEY `seance_enseignant1_FK` (`num_enseignant`);

--
-- Index pour la table `seance_initial`
--
ALTER TABLE `seance_initial`
  ADD PRIMARY KEY (`num_initial`);

--
-- Index pour la table `type_salle`
--
ALTER TABLE `type_salle`
  ADD PRIMARY KEY (`num_type_salle`);

--
-- Index pour la table `ue`
--
ALTER TABLE `ue`
  ADD PRIMARY KEY (`code_ue`),
  ADD KEY `ue_diplome0_FK` (`code_diplome`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`identifiant_user`),
  ADD KEY `utilisateur_profil0_FK` (`num_profil`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `alerte`
--
ALTER TABLE `alerte`
  MODIFY `num_alerte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `enseignant`
--
ALTER TABLE `enseignant`
  MODIFY `num_enseignant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `num_etu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `num_groupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `num_matiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `num_profil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `seance`
--
ALTER TABLE `seance`
  MODIFY `num_seance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT pour la table `seance_initial`
--
ALTER TABLE `seance_initial`
  MODIFY `num_initial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_salle`
--
ALTER TABLE `type_salle`
  MODIFY `num_type_salle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `identifiant_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `alerte`
--
ALTER TABLE `alerte`
  ADD CONSTRAINT `Alerte_seance0_FK` FOREIGN KEY (`num_seance`) REFERENCES `seance` (`num_seance`);

--
-- Contraintes pour la table `enseigner`
--
ALTER TABLE `enseigner`
  ADD CONSTRAINT `enseigner_enseignant0_FK` FOREIGN KEY (`num_enseignant`) REFERENCES `enseignant` (`num_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enseigner_matiere1_FK` FOREIGN KEY (`num_matiere`) REFERENCES `matiere` (`num_matiere`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `former`
--
ALTER TABLE `former`
  ADD CONSTRAINT `former_etudiant0_FK` FOREIGN KEY (`num_etu`) REFERENCES `etudiant` (`num_etu`),
  ADD CONSTRAINT `former_groupe1_FK` FOREIGN KEY (`num_groupe`) REFERENCES `groupe` (`num_groupe`);

--
-- Contraintes pour la table `gerer`
--
ALTER TABLE `gerer`
  ADD CONSTRAINT `gerer_diplome1_FK` FOREIGN KEY (`code_diplome`) REFERENCES `diplome` (`code_diplome`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gerer_utilisateur0_FK` FOREIGN KEY (`identifiant_user`) REFERENCES `utilisateur` (`identifiant_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD CONSTRAINT `groupe_diplome0_FK` FOREIGN KEY (`code_diplome`) REFERENCES `diplome` (`code_diplome`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `intervenir`
--
ALTER TABLE `intervenir`
  ADD CONSTRAINT `intervenir_diplome0_FK` FOREIGN KEY (`code_diplome`) REFERENCES `diplome` (`code_diplome`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `intervenir_enseignant1_FK` FOREIGN KEY (`num_enseignant`) REFERENCES `enseignant` (`num_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD CONSTRAINT `matiere_ue0_FK` FOREIGN KEY (`code_ue`) REFERENCES `ue` (`code_ue`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `originaire`
--
ALTER TABLE `originaire`
  ADD CONSTRAINT `originaire_Alerte8_FK` FOREIGN KEY (`num_alerte`) REFERENCES `alerte` (`num_alerte`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `originaire_enseignant9_FK` FOREIGN KEY (`num_enseignant`) REFERENCES `enseignant` (`num_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `originaire_groupe6_FK` FOREIGN KEY (`num_groupe`) REFERENCES `groupe` (`num_groupe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `originaire_salle5_FK` FOREIGN KEY (`num_salle`) REFERENCES `salle` (`num_salle`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `originaire_seance1_FK` FOREIGN KEY (`num_seance`) REFERENCES `seance` (`num_seance`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `originaire_seance_initial0_FK` FOREIGN KEY (`num_initial`) REFERENCES `seance_initial` (`num_initial`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `salle`
--
ALTER TABLE `salle`
  ADD CONSTRAINT `salle_batiment1_FK` FOREIGN KEY (`code_batiment`) REFERENCES `batiment` (`code_batiment`),
  ADD CONSTRAINT `salle_type_salle0_FK` FOREIGN KEY (`num_type_salle`) REFERENCES `type_salle` (`num_type_salle`);

--
-- Contraintes pour la table `seance`
--
ALTER TABLE `seance`
  ADD CONSTRAINT `seance_enseignant1_FK` FOREIGN KEY (`num_enseignant`) REFERENCES `enseignant` (`num_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seance_matiere1_FK` FOREIGN KEY (`num_matiere`) REFERENCES `matiere` (`num_matiere`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ue`
--
ALTER TABLE `ue`
  ADD CONSTRAINT `ue_diplome0_FK` FOREIGN KEY (`code_diplome`) REFERENCES `diplome` (`code_diplome`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_profil0_FK` FOREIGN KEY (`num_profil`) REFERENCES `profil` (`num_profil`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
