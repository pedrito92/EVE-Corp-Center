<?php

namespace kernel\classes;

use kernel\RoutingHandler;

class ECCSystem {

	public $params;
	public $debug;

	/**
	 * Initialize the object
	 */
	public function __construct(){
		$this->params = array(
			'_SERVER' => $_SERVER
		);

		$ini = ECCINI::instance('core.ini','settings');
		$this->debug = $ini->getVariable('infos','debug');
	}

	/**
	 * Returns the client IP
	 * @return string
	 */
	public static function getClientIP(){
		return self::instance()->params['_SERVER']['REMOTE_ADDR'];
	}

	/**
	 * Returns the debug state
	 * @return bool
	 */
	public static function getDebug(){
		return self::instance()->debug;
	}

	/**
	 * @param $code
	 * TODO: Réécrire pour générer les erreurs HTTP
	 */
	public static function error($code){
		switch($code){
			case 404:
				ECCDebug::instance()->write('error.log', '', '[RoutingHandler] "'.RoutingHandler::instance()->requestURI.'" was not found or is not accessible.');
				header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
				print("<b>Error 404 : not found.</b><br>The element is not accessible");
				exit;
		}
	}
}