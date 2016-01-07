<?php

namespace kernel;

use kernel\classes\admin\ECCAdmin;
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
		$this->parseURI();
		$this->ECCModule = $this->getECCModule();
	}

	public function routing($dao){
		if($this->ECCModule == 'kernel\classes\admin\ECCAdmin'){
			if(!isset($this->parsedURI[1])) {
				$object = new ECCAdmin($dao);
				$object->dashboard();
			} elseif($this->parsedURI[1] == 'administration') {
				/*
				 * Administration section
				 *
				 * Dedicated to settings, configuration, management...
				 */
			} elseif($this->parsedURI[1] == 'edit') {
				/*
				 * ECCObject edition
				 */
			} elseif($this->parsedURI[1] == 'delete') {
				/*
				 * Delete an ECCObject
				 */
			} elseif($this->parsedURI[1] == 'new'){
				/*
				 * Create new ECCObject
				 */
			} else {
				$frontRequestURI		= $this->requestURIWithOffset(2);
				$frontECCModule			= $this->getECCModule(2);

				$ECCObjectID	= ECCAlias::getECCObjectId($dao, $frontRequestURI);
				$object			= new ECCAdmin($dao, new ECCObject($dao, new $frontECCModule($dao), $ECCObjectID));
				$object->viewECCObject();
			}
		} elseif($this->ECCModule == 'kernel\classes\setup\ECCSetup') {

		} else {
			$ECCObjectID = ECCAlias::getECCObjectId($dao, $this->requestURI);

			if(!$ECCObjectID)
				ECCSystem::error(404);

			$object = new ECCObject($dao, new $this->ECCModule($dao), $ECCObjectID);
			$object->exec();
		}
	}


	private function getECCModule($offset = 0){
		if(isset($this->parsedURI[$offset]) && $this->parsedURI[$offset] != ''){
			switch($this->parsedURI[$offset]){
				case "setup":
					$ECCModule = "kernel\classes\setup\ECCSetup";
					break;

				case "admin":
					$ECCModule = "kernel\classes\admin\ECCAdmin";
					break;

				default:
					$ECCModule = "kernel\classes\CMS\ECCPage";
			}
		} else {
			$ECCModule = "kernel\classes\CMS\ECCPage";
		}

		return $ECCModule;
	}

	private function requestURIWithOffset($offset){
		$requestURI = '';
		foreach($this->parsedURI as $key => $parse){
			if($key >= $offset) {
				$requestURI .= '/'.$parse;
			}
		}
		if($requestURI == '')
			$requestURI = '/';

		return $requestURI;
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
