<?php

namespace kernel\classes;

class ECCDir {

	/**
	 * Create the directory $dirName. If $recursive is true, it will create parent directories
	 * @param $dirName
	 * @param bool $recursive
	 * @return bool
	 */
	static function mkdir($dirName, $perm = false, $recursive = false){
		if(file_exists($dirName)){
			ECCDebug::instance()->write('debug.log', '', 'Can not create directory. Directory "' . $dirName . '" already exists.');
			return false;
		}

		if(!$perm)
			$perm = self::getDirectoryPermission();

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
				ECCDebug::instance()->write('error.log', '', 'Directory "'.$dirName.'" was not created because ECC can not write in "'.ECCINI::instance()->getVariable('storage', 'path').substr($currentPath,1).'".');
				return false;
			}
		}
		$success = @mkdir($dirName, $perm, $recursive);
		if(!$success){
			ECCDebug::instance()->write('error.log', '', 'Directory "'.$dirName.'" was not created.');
		} else {
			ECCDebug::instance()->write('debug.log', '', 'Directory "'.$dirName.'" was created.');

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

	static function isExist($dirName){
		return file_exists($dirName);
	}
}