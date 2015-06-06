<?php

namespace kernel\classes\cms;
use kernel\classes\ECCDB;
use kernel\classes\ECCObject;
use kernel\classes\ECCTemplate;

class ECCPage extends ECCObject {

	public $data = [
		'content'			=> null,
		'seo_title'			=> null,
		'seo_description'	=> null,
		'seo_keywords'		=> null,
		'ID_parent'			=> 2
	];

	function exec(){
		$ECCTemplate = ECCTemplate::instance();

		$ECCTemplate->display(strtolower('pages/'.$this->attributes['name']).'.html.twig',
			array('object'		=> (array)$this->attributes,
				'object_id'		=> $this->ID,
				'data'			=> $this->data,
				'current_user'	=> (array)$_SESSION['currentUser']
			)
		);
	}

	function storeData($id, $data){
		/*
		 * INSERT DATA IN THE BASE
		 * AND RETURN TRUE IF INSERT OK
		 */
		$sql_insert = '';
		foreach($data as $attribute){
			$sql_insert .= " AND ".$attribute['name']." = ".$attribute['value']." ";
		}
	}

	function getAllData(){
		$db 		= ECCDB::instance();
		$dbprefix 	= $db->getPrefix();

		$db->query("SELECT `ID`, `content`, `seo_title`, `seo_keywords`, `seo_description` FROM `".$dbprefix."pages` WHERE `ID_object` = :id;");
		$db->bind(':id',$this->ID);
		$row = $db->single();

		$this->data = $row;
	}
}