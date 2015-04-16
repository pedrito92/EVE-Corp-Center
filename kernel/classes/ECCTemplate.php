<?php

namespace kernel\classes;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Extension_Optimizer;
use Twig_Extension_Debug;

class ECCTemplate {

	protected static $instance;
	protected $twig;
	protected $twigParams = [];
	public $theme;

	protected function __construct(){
		$ini	= ECCINI::instance();
		$cache	= $ini->getVariable('infos','cache');

		if($cache)
			$this->setParams('cache','var/cache/twig');
		if(ECCSystem::getDebug())
			$this->setParams('debug', true);

		$this->getTheme();
		$this->twig	= new Twig_Environment($this->theme, $this->twigParams);

		if(ECCSystem::getDebug())
			$this->twig->addExtension(new \Twig_Extension_Debug());

		$this->twig->addExtension(new Twig_Extension_Optimizer());
	}

	function setParams($key, $value){
		$this->twigParams[$key] = $value;
	}

	function display($template = 'page.html.twig', $params){
		echo $this->twig->render($template, $params);

		/*	array('object'		=> (array)$this->attributes,
				'object_id'		=> $this->ID,
				'data'			=> $this->data,
				'current_user'	=> (array)$_SESSION['currentUser']
			)
)		;*/
	}

	/**
	 * get theme used by ECC, and create the loader for Twig
	 */
	public function getTheme(){
		$ini	= ECCINI::instance('design.ini');
		$path	= $ini->getVariable('theme','path');
		$this->theme = new Twig_Loader_Filesystem('design/'.$path);
	}

	public static function instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}

		return self::$instance;
	}
}