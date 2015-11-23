<?php

namespace kernel\classes;

class ECCDebug {

	/* TODO: transformer la class en observer */

	private $debug;

	public function __construct(){
		$ini = ECCINI::instance('core.ini','settings');
		$this->debug = $ini->getVariable('infos','debug');
	}

	public function getDebug(){
		return $this->debug;
	}

	/*function write($logFileName, $logDirName = '', $string){
		$logDirName = 'var/log/'.$logDirName.'/';

		if(!file_exists($logDirName))
			ECCDir::mkdir($logDirName, 0755, true);

		$logFile = @fopen($logDirName.$logFileName, 'a');
		if($logFile){
			$time = new \DateTime();
			$ip = ECCSystem::getClientIP();
			if(!$ip)
				$ip = ECCINI::instance()->getVariable('storage','url');

			$log = '['.$time->format('Y-m-d H:i:s').'] ['.$ip.'] '.$string.ECCSystem::getLineSeparator();

			@fwrite($logFile, $log);
			@fclose($logFile);

		} else {
		}

	}

	public static function instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}

		return self::$instance;
	}*/
}