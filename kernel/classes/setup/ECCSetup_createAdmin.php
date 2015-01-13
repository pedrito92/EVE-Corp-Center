<?php

namespace kernel\classes\setup;

use \PDO;
use \Exception;

class ECCSetup_createAdmin extends ECCSetup {

	function display(){
		$createAdmin = $this->checkAdminAccount();

		require_once('design/setup/createAdmin.html.php');
	}

	private function checkAdminAccount(){
		if(isset($_POST['ECCSetup_createAdmin']) && $_POST['ECCSetup_createAdmin'] == 'true'){
			$errorForm = '';

			if($_POST['ECCSetup_emailAdmin'] == ''){
				$errorForm .= ADMIN_ERROR_EMAIL.'<br>';
			}
			if(!filter_var($_POST['ECCSetup_emailAdmin'], FILTER_VALIDATE_EMAIL)){
				$errorForm .= ADMIN_ERROR_VALIDATION_EMAIL.'<br>';
			}
			if($_POST['ECCSetup_passwdAdmin'] == ''){
				$errorForm .= ADMIN_ERROR_PASS.'<br>';
			}
			if($_POST['ECCSetup_confirmPasswdAdmin'] == ''){
				$errorForm .= ADMIN_ERROR_PASS2.'<br>';
			}
			if($_POST['ECCSetup_passwdAdmin'] != $_POST['ECCSetup_confirmPasswdAdmin']){
				$errorForm .= ADMIN_ERROR_COMPARE.'<br>';
			}

			if($errorForm == ''){
				$createAdminAccount = $this->_createAdminAccount($_POST['ECCSetup_emailAdmin'], $_POST['ECCSetup_passwdAdmin']);
				if($createAdminAccount){
					$this->_createMainSettingsFile();
					unset($_SESSION);
					session_destroy();
					header('Location: /');
				}
			}

			$return = array();
			$return['errorForm'] = $errorForm;
			if(isset($createAdminAccount)){
				$return['createAdminAccount'] = $createAdminAccount;
			} else {
				$return['createAdminAccount'] = false;
			}
			return $return;
		}
	}

	// TODO : Réécrire cette méthode à l'aide de la classe ECCObject
	private function _createAdminAccount($email, $passwd){
		$passwd		= strtoupper($email).':'.$passwd;
		$username	= 'Admin';
		$url		= '/users/'.$username;

		$dbh = new PDO("mysql:host=".$_SESSION['mysql']['host'].";port=".$_SESSION['mysql']['port'].";dbname=".$_SESSION['mysql']['dbname'], $_SESSION["mysql"]["username"], $_SESSION["mysql"]["passwd"]);
		try {
			$dbh->beginTransaction();

			$qry = $dbh->prepare("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."objects` (
									`ID`, `name`, `language`, `published`, `creator`, `status`
								) VALUES (
									4,
									:username,
									'en-US',
									NOW(),
									'EVE Corp Center Installer',
									1
								);");
			$qry->bindParam(':username', $username);
			$qry->execute();

			$qry = $dbh->prepare("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."alias` (
									`ID_object`, `url`
								) VALUES (
									4,
									:url
								);");
			$qry->bindParam(':url', $url);
			$qry->execute();

			$qry = $dbh->prepare("INSERT INTO `".$_SESSION['mysql']['dbname']."`.`".$_SESSION['mysql']['prefix']."users` (
									`ID_object`, `email`, `passwd`
								) VALUES (
									4,
									:email,
									SHA1(:passwd)
								);");
			$qry->bindParam(':email', $email);
			$qry->bindParam(':passwd', $passwd);
			$qry->execute();

			$dbh->commit();
			return true;
		} catch(Exception $e) {
			$dbh->rollBack();
			return $e;
		}
	}

	// TODO : Réécrire cette méthode à l'aide de la class ECCINI
	private function _createMainSettingsFile(){
		$mainSettings = "<?php /*
[DATABASE]
host = ".$_SESSION['mysql']['host']."
port = ".$_SESSION['mysql']['port']."
username = ".$_SESSION['mysql']['username']."
passwd = ".$_SESSION['mysql']['passwd']."
base = ".$_SESSION['mysql']['dbname']."
prefix = ".$_SESSION['mysql']['prefix']."

[STOCKAGE]
path = ".dirname(dirname(dirname(dirname(__FILE__))))."
url = ".$_SERVER["HTTP_HOST"]."

[INFOS]
version = 0.1
";
		$mainSettingsFile = fopen('settings/core.ini.php', 'a');
		fwrite($mainSettingsFile, $mainSettings);
		fclose($mainSettingsFile);
	}
} 