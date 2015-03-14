<?php

namespace kernel\classes\cms;
use kernel\classes\ECCObject;
use kernel\classes\ECCINI;
use kernel\classes\ECCSystem;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Extension_Optimizer;

class ECCPage extends ECCObject {

	static public function definition(){
		$definition = array(
			'fields' => array(
				'ID' => array(
					'name' => 'ID',
					'type' => 'integer',
					'default'	=> 0,
					'required'	=> true
				),
				'name' => array(
					'name' => 'name',
					'type' => 'string',
					'default'	=> '',
					'required'	=> true
				),
				'language' => array(
					'name' => 'language',
					'type' => 'integer',
					'default'	=> 0,
					'required'	=> true
				),
				'published' => array(
					'name' => 'published',
					'type' => 'integer',
					'default'	=> 0,
					'required'	=> true
				),
				'modified' => array(
					'name' => 'published',
					'type' => 'integer',
					'default'	=> 0,
					'required'	=> true
				),
				'creator' => array(
					'name' => 'creator',
					'type' => 'integer',
					'default'	=> 0,
					'required'	=> true
				),
				'status' => array(
					'name' => 'status',
					'type' => 'integer',
					'default'	=> 1,
					'required'	=> true
				)
			),
			'key'				=> 'ID',
			'customAttributes'	=> array(
				'data'	=> 'getData'
			),
			'increment_key'		=> 'ID',
			'sort_by'			=> array('ID' => 'asc'),
			'table_name'		=> 'ecc_objects'
		);

		return $definition;
	}

	public function __construct(){

	}

	static function fetch($id){

	}

	function exec(){
		echo "coucou";
		$loader = new Twig_Loader_Filesystem('design/default');
		$twigParams = array();

		$ini = ECCINI::instance();
		$cacheState = $ini->getVariable('infos', 'cache');

		if(ECCSystem::getDebug())
			$twigParams['debug'] = true;
		if($cacheState)
			$twigParams['cache'] = 'var/cache/twig';

		$twig = new Twig_Environment($loader, $twigParams);
		$twig->addExtension(new Twig_Extension_Debug());
		$twig->addExtension(new Twig_Extension_Optimizer());
		echo $twig->render('home.html.twig', array('object' => $this));

		echo 'test';
	}

	function storeData($id, $data){
		/*
		 * INSERT DATA"MAP" IN THE BASE
		 * AND RETURN TRUE IF INSERT OK
		 */
		$sql_insert = '';
		foreach($data as $attribute){
			$sql_insert .= " AND ".$attribute['name']." = ".$attribute['value']." ";
		}
	}
}