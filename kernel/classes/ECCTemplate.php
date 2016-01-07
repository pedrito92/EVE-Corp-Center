<?php

namespace kernel\classes;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Extension_Optimizer;
use Twig_Extension_Debug;
use Twig_SimpleFilter;

class ECCTemplate {

	/** @var Twig_Loader_Filesystem $theme */
	public $theme;
	protected $twig;
	protected $twigParams = [];

	protected static $instance;


	protected function __construct($themeDir = null){
		$ini		= ECCINI::instance();
		$cache		= $ini->getVariable('infos','cache');
		$ECCDebug	= new ECCDebug();

		if($cache)
			$this->setParams('cache','var/cache/twig');
		if($ECCDebug->getDebug())
			$this->setParams('debug', true);

		$this->setTheme($themeDir);
		$this->twig	= new Twig_Environment($this->theme, $this->twigParams);

		if($ECCDebug->getDebug())
			$this->twig->addExtension(new \Twig_Extension_Debug());

		$this->twig->addExtension(new Twig_Extension_Optimizer());

		$this->ECCOperators();
	}

	function setParams($key, $value){
		$this->twigParams[$key] = $value;
	}

	/**
	 * Appel les operateurs custom d'ECC.
	 * TODO : Probablement à transformer en extension Twig
	 */
	function ECCOperators(){
		$designPath = new Twig_SimpleFilter('designPath', function($string){
			return '/'.$this->theme->getPaths()[0].'/'.$string;
		});
		$this->twig->addFilter($designPath);
	}

	function display($template = 'page.html.twig', $params = array()){

		try{
			echo $this->twig->render($template, $params);
		}catch (\Exception $e){
			/*$debug = ECCDebug::instance();
			$debug->write('error.log', '', '[ECCTemplate] '.$e->getMessage());*/
			$this->loadDefaultTheme();
			echo $this->twig->render($template, $params);
		}

		/*	array('object'		=> (array)$this->attributes,
				'object_id'		=> $this->ID,
				'data'			=> $this->data,
				'current_user'	=> (array)$_SESSION['currentUser']
			)
)		;*/
	}

	public function setTheme($themeDir = null){
		if(is_null($themeDir))
			$path = ECCINI::instance('design.ini')->getVariable('theme','path');
		else
			$path = $themeDir;

		$this->getTheme($path);
	}

	/**
	 * get theme used by ECC, and create the loader for Twig
	 */
	public function getTheme($path){
		if(file_exists('design/'.$path))
			$this->theme = new Twig_Loader_Filesystem('design/'.$path);
		else
			$this->loadDefaultTheme();
	}

	private function loadDefaultTheme(){
		$this->theme	= new Twig_Loader_Filesystem('design/default');
		$this->twig		= new Twig_Environment($this->theme, $this->twigParams);
		$ECCDebug		= new ECCDebug();

		if($ECCDebug->getDebug())
			$this->twig->addExtension(new \Twig_Extension_Debug());

		$this->twig->addExtension(new Twig_Extension_Optimizer());
	}

	public static function instance($themeDir = null){
		if(!self::$instance instanceof self){
			self::$instance = new self($themeDir);
		}

		return self::$instance;
	}
}