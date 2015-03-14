<?php

namespace kernel;

use kernel\classes\ECCAlias;
use kernel\classes\ECCINI;
use kernel\classes\ECCSystem;
use kernel\classes\ECCObject;
use kernel\classes\setup\ECCSetup;
/*use Pheal\Pheal;
use Pheal\Core\Config;*/
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Extension_Debug;

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



		$object = new ECCObject($ECCObjectId);

		if(is_object($object)){

			$object->exec();

		} else {
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
			var_dump($_POST);
			print("<b>Error : not found</b>. The element is not accessible");
			exit;
		}

		/*Config::getInstance()->cache = new \Pheal\Cache\FileStorage('var/cache/pheal/');
		Config::getInstance()->access = new \Pheal\Access\StaticCheck();

		$pheal = new Pheal();

		$response = $pheal->serverScope->ServerStatus();

		echo sprintf(
			"Hello Visitor! The EVE Online Server is: %s!, current amount of online players: %s",
			$response->serverOpen ? "open" : "closed",
			$response->onlinePlayers
		);

		echo '<br><br>';
		$keyID = 2815094;
		$vCode = "BLHfaEJ6oFt07utSvBfNZG6EpPMHW7VTu3s9CqPZ8JxV9UKR5d0mEnzths7Vhbwp";
		$characterID = 90719345;

		$pheal2 = new Pheal($keyID, $vCode, "char");

		try{
			$response = $pheal2->CharacterSheet(array("characterID" => $characterID));

			echo sprintf(
				"Hello Visitor, Character %s was created at %s is of the %s race and belongs to the corporation %s",
				$response->name,
				$response->DoB,
				$response->race,
				$response->corporationName
			);
		} catch (\Pheal\Exceptions\PhealException $e) {
			echo sprintf(
				"an exception was caught! Type: %s Message: %s",
				get_class($e),
				$e->getMessage()
			);
		}*/

		exit;
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