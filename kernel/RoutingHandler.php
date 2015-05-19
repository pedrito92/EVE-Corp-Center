<?php

namespace kernel;

use kernel\classes\cms\ECCPage;
use kernel\classes\ECCAlias;
use kernel\classes\ECCSystem;
use kernel\classes\setup\ECCSetup;
use kernel\classes\user\ECCUser;
use kernel\classes\admin\ECCAdmin;

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

		/* TODO : Déplacer ce code dans ECCUser */
		if($this->module == 'kernel\classes\user\ECCUser'){
			ECCUser::routing($this->parsedURI);
		}

		if($this->module == 'kernel\classes\admin\ECCAdmin'){
			ECCAdmin::routing();
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