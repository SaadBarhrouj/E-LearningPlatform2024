-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: May 05, 2024 at 12:03 AM
-- Server version: 8.2.0
-- PHP Version: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: platform
--

-- --------------------------------------------------------

--
-- Table structure for table admin
--

DROP TABLE IF EXISTS admin;
CREATE TABLE IF NOT EXISTS admin (
  id int NOT NULL AUTO_INCREMENT,
  nom varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  prenom varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  mail varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  password varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  image varchar(255) DEFAULT NULL,
  role varchar(255) DEFAULT 'administrateur',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table chapitre
--

DROP TABLE IF EXISTS chapitre;
CREATE TABLE IF NOT EXISTS chapitre (
  IdChap int NOT NULL AUTO_INCREMENT,
  IdModule int DEFAULT NULL,
  contenu varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `accessible` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (IdChap),
  KEY IdModule (IdModule)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table courssuivis
--

DROP TABLE IF EXISTS courssuivis;
CREATE TABLE IF NOT EXISTS courssuivis (
  id int NOT NULL AUTO_INCREMENT,
  idEtudiant int DEFAULT NULL,
  idCours int DEFAULT NULL,
  PRIMARY KEY (id),
  KEY idEtudiant (idEtudiant),
  KEY idCours (idCours)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table message
--

DROP TABLE IF EXISTS message;
CREATE TABLE IF NOT EXISTS message (
  id int NOT NULL AUTO_INCREMENT,
  idCours int DEFAULT NULL,
  idExpediteur int NOT NULL,
  idRecepteur int DEFAULT NULL,
  contenu text COLLATE utf8mb4_general_ci NOT NULL,
  date_envoi timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  est_annonce int DEFAULT NULL,
  est_lu int DEFAULT 0,
  PRIMARY KEY (id),
  KEY idCours (idCours),
  KEY idExpediteur (idExpediteur),
  KEY idRecepteur (idRecepteur)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table module
--

DROP TABLE IF EXISTS module;
CREATE TABLE IF NOT EXISTS module (
  id int NOT NULL AUTO_INCREMENT,
  titre varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  presentation varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  mots_cles varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  Code_Cours varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  cible varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  prerequis varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  est_progressif tinyint(1) DEFAULT NULL,
  proprietaire int DEFAULT NULL,
  PRIMARY KEY (id),
  KEY proprietaire (proprietaire),
  KEY idx_id (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table utilisateurs
--

DROP TABLE IF EXISTS utilisateurs;
CREATE TABLE IF NOT EXISTS utilisateurs (
  id int NOT NULL AUTO_INCREMENT,
  nom varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  prenom varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  mail varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  password varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  image varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  role enum('etudiant','professeur') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table chapitre
--
ALTER TABLE chapitre
  ADD CONSTRAINT FK_chapitre_IdModule FOREIGN KEY (IdModule) REFERENCES module (id) ON DELETE CASCADE;

--
-- Constraints for table courssuivis
--
ALTER TABLE courssuivis
  ADD CONSTRAINT FK_courssuivis_idCours FOREIGN KEY (idCours) REFERENCES module (id) ON DELETE CASCADE,
  ADD CONSTRAINT FK_courssuivis_idEtudiant FOREIGN KEY (idEtudiant) REFERENCES utilisateurs (id) ON DELETE CASCADE;

--
-- Constraints for table message
--
ALTER TABLE message
  ADD CONSTRAINT FK_message_idCours FOREIGN KEY (idCours) REFERENCES module (id) ON DELETE CASCADE,
  ADD CONSTRAINT FK_message_idExpediteur FOREIGN KEY (idExpediteur) REFERENCES utilisateurs (id) ON DELETE CASCADE,
  ADD CONSTRAINT FK_message_idRecepteur FOREIGN KEY (idRecepteur) REFERENCES utilisateurs (id) ON DELETE CASCADE;

--
-- Constraints for table module
--
ALTER TABLE module
  ADD CONSTRAINT FK_module_proprietaire FOREIGN KEY (proprietaire) REFERENCES utilisateurs (id) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;