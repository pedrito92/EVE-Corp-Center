<?php

namespace kernel;

use kernel\classes\ECCAlias;
use kernel\classes\ECCSystem;
use kernel\classes\ECCObject;

class RoutingHandler {

	private $requestURI;
	private $parsedURI;
	private $ECCModule;

	function __construct(){
		$ECCSystem = new ECCSystem;
		$this->requestURI = $ECCSystem->params['_SERVER']['REQUEST_URI'];
		$ECCObjectID = ECCAlias::getECCObjectId($this->requestURI);

		if(!$ECCObjectID)
			ECCSystem::error(404);

		$this->parseURI();
		$this->setECCModule();

		$object = new ECCObject(new $this->ECCModule(), $ECCObjectID);
		$object->exec();
	}

	private function setECCModule(){
		if(isset($this->parsedURI[0]) && $this->parsedURI[0] != ''){
			switch($this->parsedURI[0]){
				case "setup":
					$this->ECCModule = "kernel\classes\setup\ECCSetup";
					break;

				default:
					$this->ECCModule = "kernel\classes\CMS\ECCPage";
			}
		} else {
			$this->ECCModule = "kernel\classes\CMS\ECCPage";
		}
	}

	private function parseURI(){
		$parsedURI = [];

		$tmpParsedURI = explode('/', $this->requestURI);
		foreach($tmpParsedURI as $parse){
			if($parse != ''){
				$parsedURI[] = $parse;
			}
		}
		$this->parsedURI = $parsedURI;
	}
} 
