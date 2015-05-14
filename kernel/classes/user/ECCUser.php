<?php

namespace kernel\classes\user;

use kernel\classes\ECCDB;
use kernel\classes\ECCDebug;
use kernel\classes\ECCINI;
use kernel\classes\ECCObject;
use kernel\classes\ECCTemplate;

class ECCUser extends ECCObject {

    public $data = [
        "email" => null,
        "password" => null
    ];

	function getAllData(){
		$db = ECCDB::instance();
		$db->query("SELECT `ID`, `email` FROM `ecc_users` WHERE `ID_object` = :id;");
		$db->bind(':id',$this->ID);
		$row = $db->single();

		$this->data = $row;
	}

    function generatePassword($email,$pwd){
        return sha1(strtoupper($email).':'.$pwd);
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

            if($db->rowCount() == 1)
                return new ECCUser($row['ID_object']);
            else
                return false;
		}
        return false;
	}

    static function login(){
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

                $user = ECCUser::fetchByEmail($_POST['ECCUserLogin_email']);
                $test = $user->isPasswdOk($user->generatePassword($_POST['ECCUserLogin_email'],$_POST['ECCUserLogin_passwd']));

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
    }

    static function logout(){
        $_SESSION['isLoginIn']		= false;
        $_SESSION['currentUser']	= false;
        unset($_SESSION);
        session_destroy();

        header("Location: /");
    }

    static function register(){
        $template = ECCTemplate::instance();

        if(isset($_POST['ECCUserRegister']) && $_POST['ECCUserRegister'] === 'form'){
            $errors = array();
            if(!isset($_POST['ECCUserRegister_email']) || $_POST['ECCUserRegister_email'] == '')
                $errors[] = "Adresse e-mail obligatoire";

            if(!filter_var($_POST['ECCUserRegister_email'], FILTER_VALIDATE_EMAIL))
                $errors[] = "Adresse e-mail invalide";

            if(!isset($_POST['ECCUserRegister_passwd']) || $_POST['ECCUserRegister_passwd'] == '')
                $errors[] = "Mot de passe obligatoire";

            if($_POST['ECCUserRegister_passwd'] != $_POST['ECCUserRegister_repasswd'])
                $errors[] = "Les mots de passe doivent être identiques";

            $userExist = ECCUser::fetchByEmail($_POST['ECCUserRegister_email']);
            if($userExist instanceof ECCUser){
                $errors[] = "Un compte utilise déjà ce mail";
            }

            if(count($errors) == 0){
                $userParams[] =
                $userRegister = new ECCUser();

                $userRegister->setAttribute('name', $_POST['ECCUserRegister_name']);
                $userRegister->setAttribute('language', 'en-US');
                $userRegister->setAttribute('status', 1);
                $userRegister->setAttribute('creator', $_POST['ECCUserRegister_name']);

                $userRegister->setData('email', $_POST['ECCUserRegister_email']);
                $userRegister->setData('password', $userRegister->generatePassword($_POST['ECCUserLogin_email'],$_POST['ECCUserLogin_passwd']));

                $userRegister->store();

                $userRegister->logRegister();
//                $userRegister->sendEmail();

                header("Location: /");
            }
        }

        $params = [];
        $template->display('user/register.html.twig', $params);
    }

    function storeData($id, $data){
        $db = ECCDB::instance();

        $db->query("INSERT INTO `ecc_users`(`ID_object`, `email`, `passwd`)
                    VALUES (:idObject, :email, :pwd);");
        $db->bind(":idObject", $id);
        $db->bind(":email", $data["email"]);
        $db->bind(":pwd", $data["password"]);
        $db->execute();

    }

    function logRegister(){
        $debug = ECCDebug::instance();
        $debug->write('infos.log','', '[ECCUser] New user registered : '.$this->getAttribute("name").' ('.$this->ID.')');
    }

    function sendEmail(){

        //TODO Vérifier l'envoie d'email
        $subject = "Validation de votre inscription à ECC";
        $to = $this->data["email"];


        $url = ECCINI::instance();
        $url = $url->getVariable('storage', 'url');
        $url = $url."/user/validateRegister?".md5('ECCVALIDATE:'.$to);

        $message = "Pour valider votre inscription à ECC, cliquer sur le lien suivant: <a href='".$url."'>".$url."</a>";

        $headers = 'From: admin@ecc.com' . "\r\n" .
            'Reply-To: admin@ecc.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }
}