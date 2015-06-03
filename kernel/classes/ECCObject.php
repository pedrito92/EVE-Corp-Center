<?php

namespace kernel\classes;

class ECCObject {

	public $data = null;
	public $attributes = [
		'name' 		        => null,
		'language' 	        => null,
		'published'         => null,
		'modified' 	        => null,
		'creator' 	        => null,
		'status' 	        => null,
        'parentObjectID'    => null,
		'url'		        => null
	];
	public $ID = null;

	function __construct($params = null){
		if(is_numeric($params))
			$this::fetch($params);
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

	function getData($attribute){
        if(array_key_exists($attribute, $this->data)){
            return $this->data[$attribute];
        }
	}

	function setData($data, $value){
		if(array_key_exists($data, $this->data)){
			$this->data[$data] = $value;
			return true;
		}
		return false;
	}

	function store(){
		$db 		= ECCDB::instance();
		$dbprefix 	= $db->getPrefix();

		$db->beginTransaction();

		if($this->ID === null) {
			$db->query("INSERT INTO `".$dbprefix."objects` (`name`, `language`, `published`, `creator`, `status`, `ID_parent_object` )
					VALUES (:name, :language, now(), :creator, :status, :parentObjectID);");

            var_dump($this->attributes);
			$db->bind(':language',	    $this->attributes['language']);
			$db->bind(':creator',	    $this->attributes['creator']);
            $db->bind(':parentObjectID',$this->attributes['parentObjectID']);
        } else {
			$db->query("UPDATE `".$dbprefix."objects` SET `name` = :name, `modified` = now(), `status` = :status WHERE `ID` = :id;");
			$db->bind(':id', $this->id);
		}
		$db->bind(':name',		$this->attributes['name']);
		$db->bind(':status',	$this->attributes['status']);

		$db->execute();
		if($this->ID === null)
			$this->ID = $db->lastInsertId();

		$this->storeData($this->ID, $this->data);

		$db->endTransaction();
	}

	function storeData($id, $data){

	}
	function getAllData(){

	}

	function fetch($ECCObjectID, $showHidden = false){
		$db 		= ECCDB::instance();
		$dbprefix 	= $db->getPrefix();

		$sql = 'SELECT * FROM `'.$dbprefix.'objects` WHERE `ID` = :id';
		if(!$showHidden)
			$sql .= ' AND status = :status';

		$db->query($sql);
		$db->bind(':id', $ECCObjectID);
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

			$this->attributes['url'] = ECCAlias::getAliasbyECCObjectID($this->ID);
			$this->getAllData($this->ID);

			return $this;
		}
	}

    static function fetchObjectsList($parentECCObjectID, $showHidden = false){
        $parentECCObject = new self($parentECCObjectID);
        if($parentECCObject instanceof self){

            $db         = ECCDB::instance();
            $dbprefix 	= $db->getPrefix();

            $sql = 'SELECT * FROM `'.$dbprefix.'objects` WHERE `ID_parent_object` = :id';
            if(!$showHidden)
                $sql .= ' AND status = :status';

            $db->query($sql);
            $db->bind(':id', $parentECCObjectID);
            if(!$showHidden)
                $db->bind(':status', 1);

            $array = $db->execute();

            var_dump($array);

        } else {
            return false;
        }
    }
}