<?php

namespace kernel\classes;

use \LogicException;
use \InvalidArgumentException;

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
			// ERROR
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
			// ERROR
		}
		// ERROR?
		return false;
	}

	function getSection($sectionName){
		if($this->hasSection($sectionName)){
			return $this->sectionsValues[strtoupper($sectionName)];
		}
		// ERROR
		return false;
	}

	function getVariable($sectionName, $variableName){
		if($this->hasVariable($sectionName, $variableName)){
			return $this->sectionsValues[strtoupper($sectionName)][$variableName];
		}
		// ERROR
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

	/*function parse($file){
		if ($file !== null) {
			$this->setFile($file);
		}
		if (empty($this->file)) {
			throw new LogicException("Need a file to parse.");
		}
		$simpleParsed = parse_ini_file('settings.'.$this->file, $this->process_sections);
		return $simpleParsed;
	}

	function setFile($file){
		if (!file_exists($file) || !is_readable($file)) {
			throw new InvalidArgumentException("The file '{$file}' cannot be opened.");
		}
		$this->file = $file;
		return $this;
	}/*

	static function getSectionOfFile($file, $sectionName){
		$settings = $this->parse($file);

		$returnSection = array();
		foreach($settings as $section){
			if($section == uppercase($sectionName)){
				$returnSection = $section;
			}
		}

		return $returnSection;
	}*/
} 