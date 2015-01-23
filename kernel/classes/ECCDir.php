<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 22/01/15
 * Time: 13:14
 */

namespace kernel\classes;

class ECCDir {

	/**
	 * Create the directory $dirName. If $recursive is true, it will create parent directories
	 * @param $dirName
	 * @param bool $recursive
	 * @return bool
	 */
	static function mkdir($dirName, $perm = false, $recursive = false){
		if(file_exists($dirName))
			return false;

		if(!$perm)
			$perm = self::getDirectoryPermission();
		else
			$perm = octdec($perm);

		$dirName = ECCDir::convertSeparators($dirName, ECCSystem::getFileSeparator());
		$tmpPath = explode(ECCSystem::getFileSeparator(), $dirName);

		$currentPath = '.';

		foreach($tmpPath as $key => $dirInPath){
			if(self::isWritable($currentPath)){
				$currentPath = $currentPath.ECCSystem::getFileSeparator().$dirInPath;
				continue;
			} elseif(!file_exists($currentPath)) {
				break;
			} else {
				//TODO: ECCDebug(error)
				return false;
			}
		}
		$success = @mkdir($dirName, $perm, $recursive);
		if(!$success){
			//TODO: ECCDebug(error)
		} else {
			//TODO: ECCDebug(log)
		}

		return $success;
	}

	/**
	 * Converts any directory separators in $path into the separator type needed by the system
	 * @param $path
	 * @param string $toType
	 * @return mixed
	 */
	static function convertSeparators($path, $toType = ''){
		if($toType == '' || ($toType != '/' && $toType != '\\'))
			$toType = ECCSystem::getFileSeparator();

		return str_replace(array('/', '\\'), $toType, $path);
	}

	/**
	 * Returns the default permissions to use for directories.
	 * @return number
	 */
	static function getDirectoryPermission(){
		return octdec(ECCINI::instance()->getVariable('storage','dirPermissions'));
	}

	/**
	 * Returns if the $dirname exists and is writable
	 * @param $dirName
	 * @return bool
	 */
	static function isWritable($dirName){
		if(ECCSystem::getOSType() != 'win32')
			return is_writable($dirName);

		$tmpFileName = $dirName . ECCSystem::getFileSeparator() . "ECCTestWriteable_" . time(). ".tmp";
		if (!($fp = @fopen($tmpFileName, "w"))) {
			return false;
		}
		fclose( $fp );
		unlink( $tmpFileName );
		return true;
	}
}