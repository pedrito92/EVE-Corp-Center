<?php

namespace kernel\classes\admin;
use kernel\classes\ECCTemplate;

class ECCAdmin {

	function __construct(){

	}

	function create($parent_object_id){
		echo "Création d'un nouvel object en enfant de l'object ".$parent_object_id.".";
	}

	function edit($object_ID){
		echo "Édition de l'object ".$object_ID.".";
	}

	function delete($object_ID){
		echo "Suppression de l'object ".$object_ID.".";
	}

	function move($object_id){
		echo "Déplacement de l'object ".$object_ID.".";
	}

	function dashboard(){
		ECCTemplate::instance('admin')->display('pages/home.html.twig',[]);
	}
}