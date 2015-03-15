<?php

namespace kernel\classes;

class ECCObject {

	public $data = null;
	public $attributes = array(
		'name' => null,
		'language' => null,
		'published' => null,
		'modified' => null,
		'creator' => null,
		'status' => null);
	public $ID = null;

	function __construct($params = null){
		if(is_numeric($params))
			$this::fetch($params);

		$this->getData($this->ID);
	}

	function getAttribute($attribute){
		if(array_key_exists($attribute, $this->attributes)){
			return $this->attributes[$attribute];
		}
	}

	function setAttribute($attribute, $value){
		if(array_key_exists($attribute, $this->attributes)){
			$this->attributes[$attribute] = $value;
			return true;
		}
		return false;
	}

	function getData(){

	}

	function store(){
		$db = ECCDB::instance();
		$db->beginTransaction();

		if($this->id === null) {
			$db->query("INSERT INTO `ecc_objects` (`name`, `language`, `published`, `creator`, `status` )
					VALUES (:name, :language, now(), :creator, :status);");

			$db->bind(':language',	$this->attributes['language']);
			$db->bind(':creator',	$this->attributes['creator']);
		} else {
			$db->query("UPDATE `ecc_objects` SET `name` = :name, `modified` = now(), `status` = :status WHERE `ID` = :id;");
			$db->bind(':id', $this->id);
		}
		$db->bind(':name',		$this->attributes['name']);
		$db->bind(':status',	$this->attributes['status']);
		$db->bind(':status',	$this->attributes['status']);

		$db->execute();
		if($this->id === null)
			$this->id = $db->lastInsertId();

		$this->storeData($this->id, $this->data);

		$db->endTransaction();
	}

	function storeData($id, $data) {

	}

	function fetch($ECCObjectId, $showHidden = false){
		$db = ECCDB::instance();

		$sql = 'SELECT * FROM ecc_objects WHERE ID = :id';
		if(!$showHidden)
			$sql .= ' AND status = :status';

		$db->query($sql);
		$db->bind(':id', $ECCObjectId);
		if(!$showHidden)
			$db->bind(':status', 1);

		$row = $db->single();

		if(!$row){
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
			print("<b>Error : not found</b>. The element is not accessible");
			exit;
		} else {
			foreach($row as $key => $attribute){
				if($key == 'ID')
					$this->ID = $attribute;
				else
					$this->setAttribute($key, $attribute);
			}

			/*
			 * SELECT DATA OBJECT
			 */

			return $this;
		}
	}
}