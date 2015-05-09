<?php

namespace kernel\classes\cms;
use kernel\classes\ECCDB;
use kernel\classes\ECCObject;
use kernel\classes\ECCINI;
use kernel\classes\ECCSystem;
use kernel\classes\ECCTemplate;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Extension_Optimizer;

class ECCPage extends ECCObject {

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

	function getData(){
		$db = ECCDB::instance();
		$db->query("SELECT `content`, `seo_title`, `seo_keywords`, `seo_description`, `ID_parent` FROM `ecc_pages` WHERE `ID_object` = :id;");
		$db->bind(':id',$this->ID);
		$row = $db->single();

		$this->data = $row;
	}
}