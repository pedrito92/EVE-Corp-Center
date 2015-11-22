<?php

namespace kernel\classes;

class ECCAlias {

	/**
	 * @param $requestURI
	 * @return mixed
	 */
	static function getECCObjectId($dao, $requestURI){
		$db 		= new ECCDB($dao);  /*ECCDB::instance();*/
		$dbprefix	= $dao->getPrefix();

		$dao->query('SELECT `ID_object` FROM `'.$dbprefix.'alias` WHERE BINARY `url` = :url');
		$db->bind(':url', $requestURI);

		$row = $db->single();

		if(!$row)
			return false;
		else
			return (int)$row['ID_object'];
	}

	static function getAliasbyECCObjectID($ECCObjectID){
		$db			= ECCDB::instance();
		$dbprefix	= $db->getPrefix();

		$db->query('SELECT `url` FROM `'.$dbprefix.'alias` WHERE `ID_object` = :ECCObjectID');
		$db->bind(':ECCObjectID',$ECCObjectID);

		$row = $db->single();

		if(!$row)
			return false;
		else
			return $row['url'];
	}
} 