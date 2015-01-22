<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 22/01/15
 * Time: 13:18
 */

namespace kernel\classes;


class ECCSystem {

	public $params;

	public $OS;
	public $OSType;
	public $fileSystemType;
	public $fileSeparator;
	public $lineSeparator;

	static public $instance;

	/**
	 * Initialize the object
	 */
	protected function __construct(){
		$this->params = array(
			'PHP_OS' => PHP_OS,
			'DIRECTORY_SEPARATOR' => DIRECTORY_SEPARATOR,
			'PATH_SEPARATOR' => PATH_SEPARATOR
		);

		if ( $this->params['PHP_OS'] === 'WINNT' ){
			$this->OSType = "win32";
			$this->OS = "windows";
			$this->fileSystemType = "win32";
			$this->lineSeparator = "\r\n";
		} else {
			$this->OSType = 'unix';
			if ($this->params['PHP_OS'] === 'Linux') {
				$this->OS = 'linux';
			} else if ($this->params['PHP_OS'] === 'FreeBSD') {
				$this->OS = 'freebsd';
			} else if ($this->params['PHP_OS'] === 'Darwin') {
				$this->OS = 'darwin';
			} else {
				$this->OS = false;
			}
			$this->fileSystemType = "unix";
			$this->lineSeparator = "\n";
		}
		$this->fileSeparator = $this->params['DIRECTORY_SEPARATOR'];
	}

	/**
	 * Returns the OS name (windows, linux, freebsd, darwin) or false if undetermined
	 * @return string|bool
	 */
	public static function getOS(){
		return self::instance()->OS;
	}

	/**
	 * Returns the OS type (win32 or unix)
	 * @return string
	 */
	public static function getOSType(){
		return self::instance()->OSType;
	}

	/**
	 * Returns the filesystem type (win32 or unix)
	 * @return string
	 */
	public static function getFileSystemType(){
		return self::instance()->fileSystemType;
	}

	public static function getFileSeparator(){
		return self::instance()->fileSeparator;
	}

	/**
	 * Returns the line separator on the current system
	 * @return string
	 */
	public static function getLineSeparator(){
		return self::instance()->lineSeparator;
	}

	/**
	 * Returns the instance of the ECCSystem class
	 * @return ECCSystem
	 */
	public static function instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}

		return self::$instance;
	}
}