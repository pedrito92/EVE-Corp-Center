<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 29/12/14
 * Time: 19:25
 */

namespace kernel\classes\setup;


class ECCSetup_welcome extends ECCSetup {

	private function hashLanguage(){
		$hLanguage = array(
			'en' => 'English',
			'es' => 'Español',
			'fr' => 'Français',
		);
		return $hLanguage;
	}

	function display(){
		$hLanguage = $this->hashLanguage();
		require_once('design/setup/intro.html.php');
	}
} 