<?php

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