<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 07/01/2016
 * Time: 01:58
 */

namespace kernel\classes\user;

use kernel\classes\ECCTemplate;

class ECCUser {
	public function __construct($dao) {

	}

	public function login(){
		$ECCTemplate = ECCTemplate::instance('admin');
		$ECCTemplate->display('user/login.html.twig',[
			'current_user'	=> []
		]);
	}
}