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
	}

	/**
	 * Returns the client IP
	 * @return string
	 */
	public static function getClientIP(){
		return self::instance()->params['_SERVER']['REMOTE_ADDR'];
	}

	/**
	 * @param $code
	 * TODO: Réécrire pour générer les erreurs HTTP
	 */
	public static function error($code){
		if($code == '')
			$code = 500;

		$ECCSystem = new self;
		switch($code){
			case 404:
				// TODO : générer une erreur dans error.log
				header($ECCSystem->params['_SERVER']["SERVER_PROTOCOL"]." 404 Not Found");
				print("<b>Error 404 : not found.</b><br>The element is not accessible");
				exit;

			case 500:
				header($ECCSystem->params['_SERVER']["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
				print("<b>Error 500 : Internal Server Error.</b><br>The element is not accessible");
				exit;
		}
	}
}
