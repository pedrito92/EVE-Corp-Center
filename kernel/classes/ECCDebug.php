<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 16/01/15
 * Time: 16:53
 */

namespace kernel\classes;


class ECCDebug {

	protected static $instance;

	protected function __construct(){

	}

	public static function instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}

		return self::$instance;
	}
}