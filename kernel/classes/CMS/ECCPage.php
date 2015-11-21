<?php

namespace kernel\classes\CMS;
use kernel\classes\ECCModule;

class ECCPage implements ECCModule {

	private $data = [
			'id'		=> 2,
			'title'		=> 'Mon super titre',
			'slug'		=> 'mon-super-titre',
			'content'	=> 'lorem ipsum dolor sit amet consectetur gna gna grzjigjre i zejf izjiejz oezjfjzeiof'
	];


	public function getData(){
		return $this->data;
	}

	function setData(){

	}
}
