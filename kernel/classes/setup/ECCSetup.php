<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 29/12/14
 * Time: 18:38
 */

namespace kernel\classes\setup;

use kernel\classes\ECCINI;

class ECCSetup {

	protected $dbh = null;

	static function loadStep(){

		if(!ECCINI::exist()){

			if(!isset($_POST['ECCSetup_step']) || $_POST['ECCSetup_step'] == ''){
				new ECCSetup_welcome;
			} else {
				$step = $_POST['ECCSetup_step'];
				$stepController = '\kernel\classes\setup\ECCSetup_'.$step;
				new $stepController;
			}
		} else {
			header("Location: /");
		}
	}

	function __construct(){
		if(file_exists('settings/core.ini.php')){
			header('Location: /');
		}
		$this->displayLanguage();
		require_once('design/setup/header.html.php');
		$this->display();
	}

	/**
	 * TODO : Au premier écran, prendre la langue du navigateur si possible plutôt que d'afficher systématiquement en anglais
	 */
	function displayLanguage(){
		if(isset($_SESSION['language']) && file_exists('loc/setup/'.$_SESSION['language'].'.loc.php')) {
			require_once('loc/setup/'.$_SESSION['language'].'.loc.php');
		} else {
			require_once('loc/setup/en.loc.php');
		}
	}

	function display(){
		if(!isset($_POST['ECCSetup_step']) || $_POST['ECCSetup_step'] == ''){
			require_once('design/setup/'.$_POST['ECCSetup_step'].'.html.php');
		}
	}

	function __destruct(){
		require_once('design/setup/footer.html.php');
	}

} 