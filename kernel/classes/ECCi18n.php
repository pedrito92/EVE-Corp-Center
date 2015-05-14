<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 14/05/15
 * Time: 19:26
 */

namespace kernel\classes;


class ECCi18n {
	private $dirName;
	private $i18n;

	private static $instance = [];

	private function __construct($dirName){
		if($dirName == '')
			$dirName = 'loc';

		$this->dirName = $dirName;

		$this->i18n = new \i18n();

		$ini = ECCINI::instance();
		$cache = $ini->getVariable('infos','cache');


		$this->i18n->setCachePath('./var/cache/i18n');

		// TODO : sélectionner en fonction de la langue de l'installation
		$this->i18n->setFallbackLang('en');
		$this->i18n->setSectionSeperator('_');
		$this->i18n->setFilePath('./'.$dirName.'/{LANGUAGE}.ini.php');
	}

	public function init(){
		$this->i18n->init();
	}

	static public function instance($dirName = 'loc'){
		if(!isset(self::$instance[$dirName]))
			self::$instance[$dirName] = new self($dirName);

		return self::$instance[$dirName];
	}
}