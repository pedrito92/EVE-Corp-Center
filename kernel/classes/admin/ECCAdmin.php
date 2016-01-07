<?php

namespace kernel\classes\admin;
use kernel\classes\ECCObject;
use kernel\classes\ECCTemplate;

class ECCAdmin {
	private $data = [];
	private $ECCObject = null;

	function __construct($dao, ECCObject $ECCObject = null) {
		$this->ECCObject = $ECCObject;
	}

	public function getData(){
		return $this->data;
	}

	function setData(){

	}

	public function dashboard(){
		$ECCTemplate = ECCTemplate::instance('admin');
		$ECCTemplate->display('pages/home.html.twig',[
			'current_user'	=> [],
			'disk'			=> $this->checkDF()
		]);
	}

	public function viewECCObject(){
		$ECCTemplate = ECCTemplate::instance('admin');
		$ECCTemplate->display(strtolower('pages/cms.html.twig'),[
			'object'	=> (array)$this->ECCObject,
			'object_id'	=> $this->ECCObject->ECCObjectID,
			'data'		=> $this->ECCObject->ECCModule->data,
			'current_user'	=> []
		]);
	}

	private function checkDF(){
		$ds = disk_total_space("/");
		$df = disk_free_space("/");
		$du = $ds - $df;

		$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
		$base = 1024;
		$class = min((int)log($du , $base) , count($si_prefix) - 1);
		$dru = sprintf('%1.2f' , $du / pow($base,$class))  . $si_prefix[$class];
		$drs = sprintf('%1.2f' , $ds / pow($base,$class))  . $si_prefix[$class];
		$drf = sprintf('%1.2f' , $df / pow($base,$class))  . $si_prefix[$class];

		$dp = $du*100/$ds;

		return [
			'ds'	=> $drs,
			'dru'	=> $dru,
			'df'	=> $drf,
			'dp'	=> $dp
		];
	}
}