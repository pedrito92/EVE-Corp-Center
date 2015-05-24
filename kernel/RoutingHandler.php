<?php

namespace kernel;

use kernel\classes\cms\ECCPage;
use kernel\classes\ECCAlias;
use kernel\classes\ECCSystem;
use kernel\classes\setup\ECCSetup;

class RoutingHandler {

	public $server;
	public $requestURI;
	public $parsedURI;
	public $module;
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
		$this->getModule();

		if($this->module == 'kernel\classes\setup\ECCSetup'){
			ECCSetup::loadStep();
			exit;
		}

		if($this->module == 'kernel\classes\user\ECCUser'){
			if(isset($this->parsedURI['1'])){
				$method	= $this->parsedURI['1'];
				$class	= $this->module;

				if(method_exists($class, $method)){
                    if(isset($this->parsedURI['2']) && $method == "passwordReset")
					    $class::$method($this->parsedURI['2']);
                    else
                        $class::$method();
					exit();
				}
			}

			ECCSystem::error(404);
			exit;
		}

		if($this->module == 'kernel\classes\admin\ECCAdmin'){
			if(!isset($this->parsedURI['1']))
				$method = 'dashboard';
			else
				$method	= $this->parsedURI['1'];
			$class	= $this->module;

			if(method_exists($class, $method)){
				$ECCAdmin = new $class;
				if(isset($this->parsedURI['2']))
					$ECCAdmin->$method((int)$this->parsedURI['2']);
				else
					$ECCAdmin->$method();
				exit();
			}
			ECCSystem::error(404);
			exit;
		}

		$ECCObjectId = ECCAlias::getECCObjectId($this->requestURI);

		if(!$ECCObjectId)
			ECCSystem::error(404);

		$object = new $this->module($ECCObjectId);
		if($object instanceof ECCPage)
			$object->exec();

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
    }

	private function getModule(){
		if(isset($this->parsedURI[0]) && $this->parsedURI[0] != '')
			switch($this->parsedURI[0]){
				case "setup":
					$this->module = "kernel\classes\setup\ECCSetup";
					break;

				case "forums":
					$this->module = "kernel\classes\forum\ECCForum";
					break;

				case "killboard":
					$this->module = "kernel\classes\killboard\ECCKillboard";
					break;

				case "user":
					$this->module = "kernel\classes\user\ECCUser";
					break;

				case "admin":
					$this->module = "kernel\classes\admin\ECCAdmin";
					break;

				default:
					$this->module = "kernel\classes\cms\ECCPage";
			}
		else
			$this->module = "kernel\classes\cms\ECCPage";
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