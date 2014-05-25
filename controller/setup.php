<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 22/05/2014
 * Time: 22:56
 */

class setup {

    private $model = null;

    function __construct() {
        if(!file_exists("./settings/main.conf.php")) {

            session_start();
            $this->model = new _setup();

            include_once('view/setup/header.html.php');

            switch(@$_GET['action']){
                case "database":
                    $this->database();
                    break;

                case "setupDatabase":
                    $this->setupDatabase();
                    break;


                case "createAdmin":
                    $this->createAdmin();
                    break;

                default:
                    $this->intro();
                    break;
            }

            include_once('view/setup/footer.html.php');

        } else {
            die();
        }
    }

    /**
     * Vérifie la valeur de langue dans la session, et appelle le template associé.
     * Si le fichier n'existe pas, charge alors la langue par défaut (en)
     */
    function language(){
        if(file_exists('loc/setup_'.$_SESSION['language'].'.loc.php')) {
            require_once('loc/setup_'.$_SESSION['language'].'.loc.php');
        } else {
            require_once('loc/setup_en.loc.php');
        }
    }

    /**
     * Première étape de l'installation
     * Permet à l'utilisateur de choisir sa langue et de ce fait la langue par défaut du système
     */
    function intro() {
        $aLangs = array("en" => "English", "fr" => "Français");
        require_once('loc/setup_en.loc.php');
        require_once('view/setup/intro.html.php');
    }

    function database() {
        $this->language();

        if(isset($_POST['aLang']) && $_POST['aLang'] != '') {
            $_SESSION['language'] = $_POST['aLang'];
        }

        $form = array(
            "serveur"       => "localhost",
            "port"          => 3306,
            "utilisateur"   => "",
            "mdp"           => "",
            "nomBase"       => ""
        );

        if(isset($_POST['checkDatabase']) && $_POST['checkDatabase'] == 'check') {

            $erreur = "";

            if($_POST['dbServeur'] == ''){
                $erreur .= "Veuillez spécifier le serveur<br>";
            }
            if($_POST['dbPort'] == ''){
                $erreur .= "Veuillez préciser le port.<br>";
            }
            if($_POST['dbUtilisateur'] == ''){
                $erreur .= "Veuillez préciser l'utilisateur.<br>";
            }
            if($_POST['dbNom'] == ''){
                $erreur .= "Veuillez préciser le nom de la base de données.<br>";
            }

            if($erreur == '') {

                $erreurPDO = $this->model->_checkDatabase($_POST['dbServeur'], $_POST['dbPort'],$_POST['dbNom'], $_POST['dbUtilisateur'], $_POST['dbMdp'] );

                if($erreurPDO == "ok") {
                    $_SESSION["mysql"]["host"]           = $_POST['dbServeur'];
                    $_SESSION["mysql"]["port"]           = $_POST['dbPort'];
                    $_SESSION["mysql"]["user"]           = $_POST['dbUtilisateur'];
                    $_SESSION["mysql"]["pass"]           = $_POST['dbMdp'];
                    $_SESSION["mysql"]["name"]           = $_POST['dbNom'];
                }
            }

            $form["serveur"]        = $_POST['dbServeur'];
            $form["port"]           = $_POST['dbPort'];
            $form["utilisateur"]    = $_POST['dbUtilisateur'];
            $form["mdp"]            = $_POST['dbMdp'];
            $form["nomBase"]        = $_POST['dbNom'];
        }

        require_once('view/setup/database.html.php');
    }

    function setupDatabase() {
        $setupDatabase = $this->model->_setupDatabase();
        require_once('view/setup/setupDatabase.html.php');
    }

    function createAdmin(){
        $this->language();

        if(!isset($_POST['insertion'])){
            require_once('view/setup/createAdmin.html.php');
        } else {
            $erreur = "";

            if($_POST['adminEmail'] == ''){
                $erreur .= "Veuillez renseigner votre adresse e-mail<br>";
            }
            if($_POST['adminMdp'] == ''){
                $erreur .= "Veuillez renseigner votre mot de passe.<br>";
            }
            if($_POST['adminMdp2'] == ''){
                $erreur .= "Veuillez confirmer votre mot de passe.<br>";
            }
            if($_POST['adminMdp'] != $_POST['adminMdp2']){
                $erreur .= "Les mots de passes saisies sont différents.<br>";
            }

            if($erreur == '') {
                $createAdmin = $this->model->_createAdmin($_POST['adminEmail'], $_POST['adminMdp']);
                require_once('view/setup/finish.html.php');
            }
        }
    }
}