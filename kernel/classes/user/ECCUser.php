<?php

namespace kernel\classes\user;

use kernel\classes\ECCDB;
use kernel\classes\ECCObject;

class ECCUser extends ECCObject {

	function getData(){
		$db = ECCDB::instance();
		$db->query("SELECT `ID`, `email` FROM `ecc_users` WHERE `ID_object` = :id;");
		$db->bind(':id',$this->ID);
		$row = $db->single();

		$this->data = $row;
	}

	function isPasswdOk($passwd){
		$db = ECCDB::instance();
		$db->query("SELECT `passwd` FROM `ecc_users` WHERE `ID` = :id;");
		$db->bind(':id',$this->data['ID']);
		$row = $db->single();

		if(sha1($passwd) == $row['passwd'])
			return true;

		return false;
	}

	public static function fetchByEmail($email){
		if($email != '' && filter_var($email, FILTER_VALIDATE_EMAIL)){
			$db = ECCDB::instance();
			$db->query("SELECT `ID`, `ID_object`, `email`, `passwd` FROM `ecc_users` WHERE `email` = :email;");
			$db->bind(':email', $email);
			$row = $db->single();

			$user = new ECCUser($row['ID_object']);

			return $user;
		}
	}
}