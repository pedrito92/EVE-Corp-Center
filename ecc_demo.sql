# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Hôte: localhost (MySQL 5.6.21)
# Base de données: ecc_demo
# Temps de génération: 2015-03-14 22:19:30 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table ecc_alias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ecc_alias`;

CREATE TABLE `ecc_alias` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_object` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`,`ID_object`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ecc_apikeys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ecc_apikeys`;

CREATE TABLE `ecc_apikeys` (
  `ID_apikey` int(11) NOT NULL AUTO_INCREMENT,
  `ID_user` int(11) NOT NULL,
  `key_apikey` varchar(255) NOT NULL,
  `name_apikey` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_apikey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ecc_forums
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ecc_forums`;

CREATE TABLE `ecc_forums` (
  `ID_forums` int(11) NOT NULL AUTO_INCREMENT,
  `name_forums` varchar(200) NOT NULL,
  PRIMARY KEY (`ID_forums`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ecc_objects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ecc_objects`;

CREATE TABLE `ecc_objects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `language` varchar(7) DEFAULT NULL,
  `published` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL,
  `creator` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ecc_pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ecc_pages`;

CREATE TABLE `ecc_pages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_object` int(11) NOT NULL,
  `content` longtext,
  `seo_title` varchar(90) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` tinytext,
  `ID_parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ecc_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ecc_roles`;

CREATE TABLE `ecc_roles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_object` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNIQUE` (`name`),
  UNIQUE KEY `ID_object_UNIQUE` (`ID_object`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ecc_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ecc_users`;

CREATE TABLE `ecc_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_object` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNIQUE` (`email`),
  UNIQUE KEY `ID_object_UNIQUE` (`ID_object`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
