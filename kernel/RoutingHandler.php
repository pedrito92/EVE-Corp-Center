<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 10/06/2014
 * Time: 22:23
 */

namespace kernel;

use kernel\classes\ECCAlias;
use kernel\classes\ECCObject;
use kernel\classes\setup\ECCSetup;

class RoutingHandler {

	public $server;
	public $requestURI;
	public $parsedURI;
	protected static $instance = null;

    private function __construct(){
		$this->server = $_SERVER;
    }

	public static function init(){
		$instance	= self::instance();
		$server		= $instance->server;
		$requestURI	= $server['REQUEST_URI'];

		$instance->requestURI = $requestURI;
	}

    public function routing(){
        if(!file_exists("./settings/core.ini.php") && $this->requestURI != '/setup') {
			header('Location: /setup');
			exit;
        }
		$this->parseURI();

		if(isset($this->parsedURI[0]) && $this->parsedURI[0] == 'setup') {
			ECCSetup::loadStep();
			exit;
		}

		$ECCObjectId = ECCAlias::getECCObjectId($this->requestURI);
		$object = ECCObject::fetch($ECCObjectId);

		echo '<pre>';
		var_dump($object);

		exit;


		$controller = new ECCObject();

		if(strstr($domain, 'setup') == 'setup') {
			$method = $this->parsedURI[1];
			$controller->$method();
		} else {
			$controller->checkAlias($this->requestURI, $this->parsedURI);
		}
    }

	private function parseURI(){
		$parsedURI = array();

		$tmpParsedURI = explode('/', $this->requestURI);
		foreach($tmpParsedURI as $parse){
			if($parse != ''){
				$parsedURI[] = $parse;
			}
		}
		$this->parsedURI = $parsedURI;
	}

	private function getParsedURI(){
		if(empty($this->parsedURI)){
			$this->parseURI();
		}
		return $this->parsedURI;
	}


	public static function instance(){

		if(!self::$instance instanceof self){
			self::$instance = new self;
		}

		return self::$instance;
	}
} 