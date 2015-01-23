<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 16/01/15
 * Time: 16:53
 */

namespace kernel\classes;


class ECCDebug {

	protected static $instance;

	protected function __construct(){

	}

	function write($logFileName, $logDirName = '', $string){
		$logDirName = 'var/log/'.$logDirName.'/';

		if(!file_exists($logDirName))
			ECCDir::mkdir($logDirName, 0755, true);

		$logFile = @fopen($logDirName.$logFileName, 'a');
		if($logFile){
			$time = new \DateTime();
			$ip = ECCSystem::getClientIP();
			if(!$ip)
				$ip = ECCINI::instance()->getVariable('storage','url');

			$log = '['.$time->format('Y-m-d H:i:s').']['.$ip.'] '.$string.ECCSystem::getLineSeparator();

			@fwrite($logFile, $log);
			@fclose($logFile);

		} else {
			//todo self->printOnScreen();
		}

	}

	public static function instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}

		return self::$instance;
	}
}