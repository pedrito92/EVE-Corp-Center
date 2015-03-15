<?php

namespace kernel\classes\setup;

use kernel\classes\ECCDir;
use \PDO;
use \Exception;

class ECCSetup_setupCore extends ECCSetup {

	// TODO : Réécrire cette méthode pour créer les répertoires etc. à l'aide d'ECCObject
	private function _setupDatabase(){
		$dbh = new PDO("mysql:host=".$_SESSION['mysql']['host'].";port=".$_SESSION['mysql']['port'].";dbname=".$_SESSION['mysql']['dbname'], $_SESSION["mysql"]["username"], $_SESSION["mysql"]["passwd"]);
		try {
			$dbh->beginTransaction();
			
			$dbh->exec("CREATE TABLE `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."objects` (
							`ID` INT(11) NOT NULL AUTO_INCREMENT,
							`name` VARCHAR(255) NULL DEFAULT NULL,
							`language` VARCHAR(7) NULL DEFAULT NULL,
							`published` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
							`modified` DATETIME NULL DEFAULT NULL,
							`creator` VARCHAR(255) NULL DEFAULT NULL,
							`status` VARCHAR(45) NULL DEFAULT '1',
							`ID_module` INT(11) NULL DEFAULT NULL,
							PRIMARY KEY (`ID`))
						ENGINE = InnoDB
						DEFAULT CHARACTER SET = utf8
						COLLATE = utf8_general_ci;");
			
			$dbh->exec("CREATE TABLE `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."apikeys` (
							`ID_apikey` INT(11) NOT NULL AUTO_INCREMENT,
							`ID_user` INT(11) NOT NULL,
							`key_apikey` VARCHAR(255) NOT NULL,
							`name_apikey` VARCHAR(255) NOT NULL,
							PRIMARY KEY (`ID_apikey`))
						ENGINE = InnoDB
						DEFAULT CHARACTER SET = utf8
						COLLATE = utf8_general_ci;");
			
			$dbh->exec("CREATE TABLE `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."forums` (
							`ID_forums` INT(11) NOT NULL AUTO_INCREMENT,
  							`name_forums` VARCHAR(200) NOT NULL,
  							PRIMARY KEY (`ID_forums`))
						ENGINE = InnoDB
						DEFAULT CHARACTER SET = utf8
						COLLATE = utf8_general_ci;");
			
			$dbh->exec("CREATE TABLE `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."pages` (
							`ID` INT(11) NOT NULL AUTO_INCREMENT,
							`ID_object` INT(11) NOT NULL,
							`content` LONGTEXT NULL DEFAULT NULL,
							`seo_title` VARCHAR(90) NULL DEFAULT NULL,
							`seo_keywords` VARCHAR(255) NULL DEFAULT NULL,
							`seo_description` TINYTEXT NULL DEFAULT NULL,
							`ID_parent` INT(11) NULL DEFAULT NULL,
							PRIMARY KEY (`ID`))
						ENGINE = InnoDB
						DEFAULT CHARACTER SET = utf8
						COLLATE = utf8_general_ci;");
			
			$dbh->exec("CREATE TABLE `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."users` (
							`ID` INT(11) NOT NULL AUTO_INCREMENT,
							`ID_object` INT(11) NOT NULL,
							`email` VARCHAR(255) NOT NULL,
							`passwd` VARCHAR(255) NOT NULL,
							PRIMARY KEY (`ID`),
							UNIQUE INDEX `UNIQUE` (`email` ASC ),
							UNIQUE INDEX `ID_object_UNIQUE` (`ID_object` ASC))
						ENGINE = InnoDB
						AUTO_INCREMENT = 3
						DEFAULT CHARACTER SET = utf8
						COLLATE = utf8_general_ci;");
			
			$dbh->exec("CREATE TABLE `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."modules` (
							`ID` INT(11) NOT NULL AUTO_INCREMENT,
							`name` VARCHAR(255) NULL DEFAULT NULL,
							PRIMARY KEY (`ID`),
							UNIQUE INDEX `UNIQUE` (`name` ASC))
						ENGINE = InnoDB
						DEFAULT CHARACTER SET = utf8
						COLLATE = utf8_general_ci;");

			$dbh->exec("CREATE TABLE `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."alias` (
							`ID` INT(11) NOT NULL AUTO_INCREMENT,
							`ID_object` INT(11) NOT NULL,
							`url` VARCHAR(255) NULL DEFAULT NULL,
							PRIMARY KEY (`ID`, `ID_object`))
						ENGINE = InnoDB
						DEFAULT CHARACTER SET = utf8
						COLLATE = utf8_general_ci;");
			
			$dbh->exec("CREATE TABLE `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."roles` (
							`ID` INT(11) NOT NULL AUTO_INCREMENT,
							`ID_object` INT(11) NOT NULL,
				  			`name` VARCHAR(45) NOT NULL,
				  			PRIMARY KEY (`ID`),
				  			UNIQUE INDEX `UNIQUE` (`name` ASC),
				  			UNIQUE INDEX `ID_object_UNIQUE` (`ID_object` ASC))
						ENGINE = InnoDB
						DEFAULT CHARACTER SET = utf8
						COLLATE = utf8_general_ci;");

			$dbh->exec("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."objects` (
							`ID`, `name`, `language`, `published`, `creator`, `status`
						) VALUES (
							1,
							'EVE Corp Center',
							'en-US',
							NOW(),
							'EVE Corp Center Installer',
							1
						);");

			$dbh->exec("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."modules` (
							`ID`, `name`
						) VALUES (
							1,
							'Page'
						);");

			$dbh->exec("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."modules` (
							`ID`, `name`
						) VALUES (
							2,
							'Forum'
						);");

			$dbh->exec("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."modules` (
							`ID`, `name`
						) VALUES (
							3,
							'Post'
						);");

			$dbh->exec("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."modules` (
							`ID`, `name`
						) VALUES (
							4,
							'User'
						);");

			$dbh->exec("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."modules` (
							`ID`, `name`
						) VALUES (
							5,
							'Killboard'
						);");

			$dbh->exec("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."objects` (
							`ID`, `name`, `language`, `published`, `creator`, `status`, `ID_module`
						) VALUES (
							2,
							'Home',
							'en-US',
							NOW(),
							'EVE Corp Center Installer',
							1,
							1
						);");
			$dbh->exec("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."pages` (
							`ID`, `ID_object`, `ID_parent`
						) VALUES (
							1,
							2,
							1
						);");

			$dbh->exec("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."alias` (
							`ID_object`, `url`
						) VALUES (
							2,
							'/'
						);");

			$dbh->exec("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."objects` (
							`ID`, `name`, `language`, `published`, `creator`, `status`
						) VALUES (
							3,
							'Users',
							'en-US',
							NOW(),
							'EVE Corp Center Installer',
							1
						);");

			$dbh->commit();
		} catch(Exception $e) {
			$dbh->rollBack();
		}
	}

	private function _setupFiles(){
		ECCDir::mkdir('var/log',0755, true);
		ECCDir::mkdir('settings',0755);
		ECCDir::mkdir('var/cache/pheal',0755, true);
		ECCDir::mkdir('var/cache/twig',0755, true);
	}

	function display(){
		$this->_setupDatabase();
		$this->_setupFiles();

		require_once('design/setup/setupDatabase.html.php');
	}
} 