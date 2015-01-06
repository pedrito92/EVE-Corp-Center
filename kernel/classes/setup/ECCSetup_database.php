<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 29/12/14
 * Time: 19:25
 */

namespace kernel\classes\setup;

use \PDO;
use \PDOException;

class ECCSetup_database extends ECCSetup {

	function __construct(){
		if(file_exists('settings/core.ini.php')){
			header('Location: /');
		}
		$this->selectLanguage();
		$this->displayLanguage();
		require_once('design/setup/header.html.php');
		$this->display();
	}

	private function selectLanguage(){
		if(isset($_POST['ECCSetup_language']) && $_POST['ECCSetup_language'] != '') {
			$_SESSION['language'] = $_POST['ECCSetup_language'];
		}
	}

	private function placeholderForm(){
		$placeholderForm = array(
			'server'		=> 'localhost',
			'port'			=> 3306,
			'username'		=> '',
			'passwd'		=> '',
			'dbname'		=> '',
			'prefix'		=> 'ecc_'
		);

		return $placeholderForm;
	}

	private function checkForm(){
		if(isset($_POST['ECCSetup_checkdatabase']) && $_POST['ECCSetup_checkdatabase'] == 'true') {

			$errorForm = '';

			if($_POST['ECCSetup_database_server'] == ''){
				$errorForm .= MYSQL_ERROR_HOST.'<br>';
			}
			if($_POST['ECCSetup_database_port'] == ''){
				$errorForm .= MYSQL_ERROR_PORT.'<br>';
			}
			if($_POST['ECCSetup_database_username'] == ''){
				$errorForm .= MYSQL_ERROR_USER.'<br>';
			}
			if($_POST['ECCSetup_database_dbname'] == ''){
				$errorForm .= MYSQL_ERROR_NAME.'<br>';
			}

			if($errorForm == '') {
				$PDOreturn = $this->_testConnection($_POST['ECCSetup_database_server'], $_POST['ECCSetup_database_port'],$_POST['ECCSetup_database_dbname'], $_POST['ECCSetup_database_username'], $_POST['ECCSetup_database_passwd'] );

				if($PDOreturn) {
					$_SESSION["mysql"]["host"]      = $_POST['ECCSetup_database_server'];
					$_SESSION["mysql"]["port"]      = $_POST['ECCSetup_database_port'];
					$_SESSION["mysql"]["username"]  = $_POST['ECCSetup_database_username'];
					$_SESSION["mysql"]["passwd"]    = $_POST['ECCSetup_database_passwd'];
					$_SESSION["mysql"]["dbname"]	= $_POST['ECCSetup_database_dbname'];
					$_SESSION["mysql"]["prefix"]	= $_POST['ECCSetup_database_prefix'];
				}
			}

			$placeholderForm["server"]      = $_POST['ECCSetup_database_server'];
			$placeholderForm["port"]        = $_POST['ECCSetup_database_port'];
			$placeholderForm["username"]    = $_POST['ECCSetup_database_username'];
			$placeholderForm["passwd"]      = $_POST['ECCSetup_database_passwd'];
			$placeholderForm["dbname"]		= $_POST['ECCSetup_database_dbname'];
			$placeholderForm["prefix"]		= $_POST['ECCSetup_database_prefix'];

			$return = array();
			$return['errorForm'] = $errorForm;
			if(isset($PDOreturn)){
				$return['PDOreturn'] = $PDOreturn;
				if($PDOreturn){
					$return['placeholderForm']['server']	= $_POST['ECCSetup_database_server'];
					$return['placeholderForm']['port']		= $_POST['ECCSetup_database_port'];
					$return['placeholderForm']['username']	= $_POST['ECCSetup_database_username'];
					$return['placeholderForm']['passwd']	= $_POST['ECCSetup_database_passwd'];
					$return['placeholderForm']['dbname']	= $_POST['ECCSetup_database_dbname'];
					$return['placeholderForm']['prefix']	= $_POST['ECCSetup_database_prefix'];
				}
			} else {
				$return['PDOreturn'] = false;
			}
			return $return;
		}
	}

	private function _testConnection($host, $port, $dbname, $username, $passwd){
		try {
			$dbh = new PDO("mysql:host=".$host.";port=".$port.";dbname=".$dbname, $username, $passwd);
			return true;
		} catch (PDOException $e){
			return $e->getMessage();
		}
	}

	function display(){
		$placeholderForm = $this->placeholderForm();
		$testConnection = $this->checkForm();

		require_once('design/setup/database.html.php');
	}
} 