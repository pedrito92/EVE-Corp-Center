<?php

if(isset($_POST['ECCUserLogin']) && $_POST['ECCUserLogin'] === 'form'){
	$error = array();
	if(!isset($_POST['ECCUserLogin_email']) || $_POST['ECCUserLogin_email'] == '')
		$error[] = "Adresse e-mail obligatoire";

	if(!filter_var($_POST['ECCUserLogin_email'], FILTER_VALIDATE_EMAIL))
		$error[] = "Adresse e-mail invalide";

	if(!isset($_POST['ECCUserLogin_passwd']) || $_POST['ECCUserLogin_passwd'] == '')
		$error[] = "Mot de passe obligatoire";

	if(count($error) == 0){

		$user = \kernel\classes\user\ECCUser::fetchByEmail($_POST['ECCUserLogin_email']);
		$test = $user->isPasswdOk(strtoupper($_POST['ECCUserLogin_email']).':'.$_POST['ECCUserLogin_passwd']);

		if($test){
			$_SESSION['isLoginIn'] = true;
			$_SESSION['currentUser'] = $user;
			header("Location: /");
		} else {
			$error[] = "Aucun utilisateur n'a été trouvé avec cette adresse e-mail et ce mot de passe.";
		}
	}
}

if(isset($error) && $error != ''){
	echo '<ul>';
	foreach($error as $row){
		echo '<li>'.$row.'</li>';
	}
	echo '</ul>';
}
?>

<form action="/user/login" method="post">
	<input type="hidden" name="ECCUserLogin" value="form">
	<input type="text" name="ECCUserLogin_email" value="<?php if(isset($_POST['ECCUserLogin_email'])){ echo $_POST['ECCUserLogin_email']; } ?>" placeholder="E-mail">
	<input type="password" name="ECCUserLogin_passwd" value="" placeholder="Password">
	<input type="submit" value="ok">
</form>