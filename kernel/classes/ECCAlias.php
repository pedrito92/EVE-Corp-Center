<?php

namespace kernel\classes;

class ECCAlias {

	/**
	 * @param $requestURI
	 * @return mixed
	 */
	static function getECCObjectId($requestURI){
		$db 		= ECCDB::instance();
		$dbprefix	= $db->getPrefix();

		$db->query('SELECT `ID_object` FROM `'.$dbprefix.'alias` WHERE BINARY `url` = :url');
		$db->bind(':url', $requestURI);

		$row = $db->single();

		if(!$row)
			return false;
		else
			return (int)$row['ID_object'];
	}
} 