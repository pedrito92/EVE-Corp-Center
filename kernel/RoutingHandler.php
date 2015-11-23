<?php

namespace kernel;

use kernel\classes\DB\ECCPdo;
use kernel\classes\ECCAlias;
use kernel\classes\ECCINI;
use kernel\classes\ECCSystem;
use kernel\classes\ECCObject;
use PDOException;

class RoutingHandler {

	private $requestURI;
	private $parsedURI;
	private $ECCModule;

	function __construct(){
		$ECCSystem = new ECCSystem;


        try{
            $ini = ECCINI::instance();
            $infos = $ini->getSection('database');

            $host 	    = $infos['host'];
            $port	    = $infos['port'];
            $dbname	    = $infos['dbname'];
            $username	= $infos['username'];
            $passwd	    = $infos['passwd'];
            $prefix	    = $infos['prefix'];
            $driver     = $infos['driver'];

            switch($driver){
                case 'pdo':
                default:
                    $options = array(
                        ECCPdo::ATTR_PERSISTENT    		=> true,
                        ECCPdo::ATTR_ERRMODE       		=> ECCPdo::ERRMODE_EXCEPTION,
                        ECCPdo::MYSQL_ATTR_INIT_COMMAND	=> "SET NAMES utf8"
                    );
                    $dsn = 'mysql:host='.$host.';port='.$port.';dbname='.$dbname;
                    $dao = new ECCPdo($dsn, $username, $passwd, $options, $prefix );
                    break;
            }

        }
        catch(PDOException $e){
            $this->error = $e->getMessage();

            header("HTTP/1.1 500 Internal Server Error");
            print("<b>Fatal error</b>: The web server did not finish its request<br/>");
            print("La connexion à la base de données à échouée. Si le problème persiste, contactez votre administrateur.");
            exit;
        }

		$this->requestURI = $ECCSystem->params['_SERVER']['REQUEST_URI'];
		$ECCObjectID = ECCAlias::getECCObjectId($dao, $this->requestURI);

		if(!$ECCObjectID)
			ECCSystem::error(404);

		$this->parseURI();
		$this->setECCModule();

        // $dao à déplacer au ajouter dans le constructeur du module. à voir, j'ai pas trop regarder comment fonctionne ECCObject encore
		$object = new ECCObject($dao, new $this->ECCModule(/* $dao */), $ECCObjectID);
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
