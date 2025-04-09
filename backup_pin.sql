/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: pin
-- ------------------------------------------------------
-- Server version	11.7.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `Annotation`
--

DROP TABLE IF EXISTS `Annotation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Annotation` (
  `Id_Annotation` int(11) NOT NULL,
  `Image_idee` int(11) NOT NULL,
  `Titre` varchar(100) DEFAULT NULL,
  `Id_Utilisateur` int(11) NOT NULL,
  `Description` text DEFAULT NULL,
  `Position_X` int(11) DEFAULT NULL,
  `Position_Y` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_Annotation`),
  KEY `Image_idee` (`Image_idee`),
  KEY `Id_Utilisateur` (`Id_Utilisateur`),
  CONSTRAINT `Annotation_ibfk_1` FOREIGN KEY (`Image_idee`) REFERENCES `Image` (`Id_Image`),
  CONSTRAINT `Annotation_ibfk_2` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `Utilisateurs` (`Id_Utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Annotation`
--

LOCK TABLES `Annotation` WRITE;
/*!40000 ALTER TABLE `Annotation` DISABLE KEYS */;
/*!40000 ALTER TABLE `Annotation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Commentaire`
--

DROP TABLE IF EXISTS `Commentaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Commentaire` (
  `Id_Commentaire` int(11) NOT NULL,
  `Image_liee` int(11) NOT NULL,
  `Id_Utilisateur` int(11) NOT NULL,
  `Commentaire` text DEFAULT NULL,
  `Epingle` tinyint(1) DEFAULT 0,
  `Date` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id_Commentaire`),
  KEY `Image_liee` (`Image_liee`),
  KEY `Id_Utilisateur` (`Id_Utilisateur`),
  CONSTRAINT `Commentaire_ibfk_1` FOREIGN KEY (`Image_liee`) REFERENCES `Image` (`Id_Image`),
  CONSTRAINT `Commentaire_ibfk_2` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `Utilisateurs` (`Id_Utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Commentaire`
--

LOCK TABLES `Commentaire` WRITE;
/*!40000 ALTER TABLE `Commentaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `Commentaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Image`
--

DROP TABLE IF EXISTS `Image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Image` (
  `Id_Image` int(11) NOT NULL,
  `Source` text NOT NULL,
  `Titre` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Categories` text DEFAULT NULL,
  `Tags` text DEFAULT NULL,
  `Id_Auteur` int(11) NOT NULL,
  `Visibilite` varchar(20) DEFAULT NULL,
  `Date_de_depot` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id_Image`),
  KEY `Id_Auteur` (`Id_Auteur`),
  CONSTRAINT `Image_ibfk_1` FOREIGN KEY (`Id_Auteur`) REFERENCES `Utilisateurs` (`Id_Utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Image`
--

LOCK TABLES `Image` WRITE;
/*!40000 ALTER TABLE `Image` DISABLE KEYS */;
/*!40000 ALTER TABLE `Image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Utilisateurs`
--

DROP TABLE IF EXISTS `Utilisateurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Utilisateurs` (
  `Id_Utilisateur` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Bio` text DEFAULT NULL,
  `Source_photo_profil` text DEFAULT NULL,
  PRIMARY KEY (`Id_Utilisateur`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Utilisateurs`
--

LOCK TABLES `Utilisateurs` WRITE;
/*!40000 ALTER TABLE `Utilisateurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `Utilisateurs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-04-09 16:04:51 --
