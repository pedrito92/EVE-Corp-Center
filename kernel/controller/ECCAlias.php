<?php

namespace kernel\controller;

class ECCAlias {

	/**
	 * @param $requestURI
	 * @return mixed
	 */
	static function getECCObjectId($requestURI){
		$db = ECCDB::instance();

		$db->query('SELECT ID_object FROM ecc_alias WHERE url = :url');
		$db->bind(':url', $requestURI);

		$row = $db->single();

		return $row['ID_object'];
	}
} 