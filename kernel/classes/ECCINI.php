<?php

namespace kernel\classes;

class ECCINI {

	private $fileName;
	private $dirName;
	private $sections;
	private $sectionsValues;

	private static $instance = array();


	private function __construct($fileName, $dirName){
		if($fileName == ''){
			$fileName = 'core.ini';
		}
		if($dirName == ''){
			$dirName = 'settings';
		}

		$this->fileName = $fileName;
		$this->dirName	= $dirName;

		if(!$this->exist($this->fileName, $this->dirName)){
			return false;
		}

		$this->parseFile();
	}

	private function parseFile(){

		$contents = parse_ini_file($this->getFile(true).'.php', true);
		if($contents === false){
			ECCDebug::instance()->write('error.log', '', 'Can not read the settings file "'.$this->getFile(true).'".');
			return false;
		}

		$sections = array();
		foreach($contents as $key => $block){
			$sections[] = $key;
		}

		$this->sections			= $sections;
		$this->sectionsValues	= $contents;
	}

	private function getFile($fullPath = false){
		if($fullPath){
			$file = $this->dirName.'/'.$this->fileName;
		} else {
			$file = $this->fileName;
		}
		return $file;
	}

	private function hasSection($sectionName){
		foreach($this->sections as $section){
			if($section == strtoupper($sectionName)){
				return true;
			}
		}
		return false;
	}
	private function hasVariable($sectionName, $sectionVariable){
		if($this->hasSection($sectionName)){
			foreach($this->sectionsValues[strtoupper($sectionName)] as $key => $section){
				if($key == $sectionVariable){
					return true;
				}
			}
			ECCDebug::instance()->write('error.log', '', '"'.$sectionVariable.'" was not found in "'.$this->fileName.'" settings file.');
		}
		return false;
	}

	function getSection($sectionName){
		if($this->hasSection($sectionName)){
			return $this->sectionsValues[strtoupper($sectionName)];
		}
		ECCDebug::instance()->write('error.log', '', '"'.$sectionName.'" was not found in "'.$this->fileName.'" settings file.');
		return false;
	}

	function getVariable($sectionName, $variableName){
		if($this->hasVariable($sectionName, $variableName)){
			return $this->sectionsValues[strtoupper($sectionName)][$variableName];
		}
		return false;
	}

	static public function instance($fileName = 'core.ini', $dirName = 'settings'){
		$key = "$fileName-$dirName";

		if(!isset(self::$instance[$key])){
			self::$instance[$key] = new self($fileName, $dirName);
		}
		return self::$instance[$key];
	}

	static function exist($fileName = 'core.ini', $dirName = 'settings'){
		if($fileName == ''){
			$fileName = 'core.ini';
		}
		if($dirName == ''){
			$dirName = 'settings';
		}
		if(file_exists($dirName.'/'.$fileName.'.php')){
			return true;
		}
		return false;
	}
} 