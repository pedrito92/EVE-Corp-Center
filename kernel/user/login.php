<?php

use kernel\classes\ECCTemplate;

$template = ECCTemplate::instance();

if(isset($_POST['ECCUserLogin']) && $_POST['ECCUserLogin'] === 'form'){
	$errors = array();
	if(!isset($_POST['ECCUserLogin_email']) || $_POST['ECCUserLogin_email'] == '')
		$errors[] = "Adresse e-mail obligatoire";

	if(!filter_var($_POST['ECCUserLogin_email'], FILTER_VALIDATE_EMAIL))
		$errors[] = "Adresse e-mail invalide";

	if(!isset($_POST['ECCUserLogin_passwd']) || $_POST['ECCUserLogin_passwd'] == '')
		$errors[] = "Mot de passe obligatoire";

	if(count($errors) == 0){

		$user = \kernel\classes\user\ECCUser::fetchByEmail($_POST['ECCUserLogin_email']);
		$test = $user->isPasswdOk(strtoupper($_POST['ECCUserLogin_email']).':'.$_POST['ECCUserLogin_passwd']);

		if($test){
			$_SESSION['isLoginIn'] = true;
			$_SESSION['currentUser'] = $user;
			header("Location: /");
		} else {
			$errors[] = "Aucun utilisateur n'a été trouvé avec cette adresse e-mail et ce mot de passe.";
		}
	}
}

$params = [];
if(isset($_POST['ECCUserLogin_email']))
	$params['ECCUserLogin_email'] = $_POST['ECCUserLogin_email'];

if(isset($errors))
	$params['errors'] = $errors;

$template->display('user/login.html.twig', $params);

?>