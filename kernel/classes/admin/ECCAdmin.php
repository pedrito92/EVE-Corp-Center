<?php

namespace kernel\classes\admin;
use kernel\classes\cms\ECCPage;
use kernel\classes\ECCObject;
use kernel\classes\ECCTemplate;

class ECCAdmin {

	function __construct(){

	}

	function create($parent_object_id){
		echo "Création d'un nouvel object en enfant de l'object ".$parent_object_id.".";
	}

	function edit($object_ID){
		echo "Édition de l'object ".$object_ID.".";

		$ECCObject = new ECCPage($object_ID);

		var_dump($ECCObject);
	}

	function delete($object_ID){
		echo "Suppression de l'object ".$object_ID.".";
	}

	function move($object_ID){
		echo "Déplacement de l'object ".$object_ID.".";
	}

	function dashboard(){
		ECCTemplate::instance('admin')->display('pages/home.html.twig',[]);
	}

	function CMS(){
		ECCTemplate::instance('admin')->display('pages/cms.html.twig',[]);
	}

	function users(){

	}

	function forums(){

	}
	function killboard(){

	}
}