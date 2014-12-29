<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 10/06/2014
 * Time: 22:23
 */

namespace kernel;


use kernel\controller\ECCAlias;
use kernel\controller\ECCObject;

class RoutingHandler {

	/**
	 * Contient toutes les données de $_SERVER
	 *
	 * @var array
	 */
	public $server;

	/**
	 * Contient l'URI demandé par l'utilisateur
	 *
	 * @var string
	 */
	public $requestURI;

	/**
	 * Contient l'URI demandée par l'utilisateur
	 *
	 * @var array
	 */
	public $parsedURI;

	/**
	 * Instance du RoutingHandler
	 *
	 * @var RoutingHandler|null
	 */
	protected static $instance = null;

	/**
	 * Initialise l'objet
	 */
    private function __construct(){
		$this->server = $_SERVER;
    }

	/**
	 * Initialise a proprement dit le RoutingHandler
	 */
	public static function init(){
		$instance	= self::instance();
		$server		= $instance->server;
		$requestURI	= $server['REQUEST_URI'];

		$instance->requestURI = $requestURI;
	}

	/**
	 * Invoque le controller relatif à l'URI
	 */
    public function dispatcher(){
		$this->parseURI();

        if(!file_exists("./settings/core.ini.php") && (!isset($this->parsedURI[0]) || $this->parsedURI[0] != 'setup')) {
            header('Location: /setup/home');
        }

		if(isset($this->parsedURI[0])){
			switch($this->parsedURI[0]){
				case 'admin':

					break;
				case 'forums':
					$domain = 'ECCForums';
					break;
				case 'killboard':
					$domain = 'ECCKillBoard';
					break;
				case 'setup':
					$domain = 'setup';
					break;
				default:
					$domain = 'ECCContentManagementSystem';
			}
		} else {
			$domain = 'ECCContentManagementSystem';
		}

		//$domain = "kernel\controller\\".$domain;

		//$controller = new $domain;

		$ECCObjectId = ECCAlias::getECCObjectId($this->requestURI);
		$object = ECCObject::fetch($ECCObjectId);

		echo '<pre>';
		var_dump($object);

		exit;


		$controller = new \kernel\controller\ECCObject();

		if(strstr($domain, 'setup') == 'setup') {
			$method = $this->parsedURI[1];
			$controller->$method();
		} else {
			$controller->checkAlias($this->requestURI, $this->parsedURI);
		}
    }

	/**
	 * Transforme l'URI demandé en array
	 */
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

	/**
	 * Retourne l'URI demandée sous forme de tableau
	 * @return array
	 */
	private function getParsedURI(){
		if(empty($this->parsedURI)){
			$this->parseURI();
		}
		return $this->parsedURI;
	}

	/**
	 *
	 * @return RoutingHandler|null
	 */
	public static function instance(){

		if(!self::$instance instanceof RoutingHandler){
			self::$instance = new RoutingHandler();
		}

		return self::$instance;
	}

	/*public static function setInstance( RoutingHandler $instance = null){
		self::$instance = $instance;
	}*/
} 