<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 29/10/14
 * Time: 23:53
 */

namespace kernel\controller;

class ECCObject {

	public $name = null;
	public $language = null;
	public $published = null;
	public $modified = null;
	public $creator = null;
	public $status = null;
	public $datamap = null;

	function __construct($attributes){
		$this->setName($attributes['name']);
		$this->setLanguage($attributes['language']);
		$this->setPublished($attributes['published']);
		$this->setModified($attributes['modified']);
		$this->setCreator($attributes['creator']);
		$this->setStatus($attributes['status']);
	}

	function setName($name){
		$this->name = $name;
	}

	function getName(){
		return $this->name;
	}

	function setLanguage($language){
		$this->language = $language;
	}

	function getLanguage(){
		return $this->language;
	}

	function setPublished($published){
		$this->published = $published;
	}

	function getPublished(){
		return $this->published;
	}

	function setModified($modified){
		$this->modified = $modified;
	}

	function getModified(){
		return $this->modified;
	}

	function setCreator($creator){
		$this->creator = $creator;
	}

	function getCreator(){
		return $this->creator;
	}

	function setStatus($status){
		$this->status = $status;
	}

	function getStatus(){
		return $this->status;
	}

	function getDatamap(){
		return $this->datamap;
	}

	static function fetch($ECCOBjectId){
		$db = ECCDB::instance();

		$db->query('SELECT * FROM ecc_objects WHERE ID = :id AND status = :status');
		$db->bind(':id', $ECCOBjectId);
		$db->bind(':status', 1);

		$row = $db->single();

		if(!$row){
			header("HTTP/1.1 404 Not found");
			print("<b>Error : not found</b>. The element is not accessible");
			exit;
		} else {
			return new ECCObject($row);
		}
	}
}