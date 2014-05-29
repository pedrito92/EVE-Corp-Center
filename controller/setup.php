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
        $aLangs = array("en" => "English", "es" => "Español", "fr" => "Français");
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
                $erreur .= MYSQL_ERROR_HOST."<br>";
            }
            if($_POST['dbPort'] == ''){
                $erreur .= MYSQL_ERROR_PORT."<br>";
            }
            if($_POST['dbUtilisateur'] == ''){
                $erreur .= MYSQL_ERROR_USER."<br>";
            }
            if($_POST['dbNom'] == ''){
                $erreur .= MYSQL_ERROR_NAME."<br>";
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
        $this->language();

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
                $erreur .= ADMIN_ERROR_EMAIL."<br>";
            }
            if($_POST['adminMdp'] == ''){
                $erreur .= ADMIN_ERROR_PASS."<br>";
            }
            if($_POST['adminMdp2'] == ''){
                $erreur .= ADMIN_ERROR_PASS2."<br>";
            }
            if($_POST['adminMdp'] != $_POST['adminMdp2']){
                $erreur .= ADMIN_ERROR_COMPARE."<br>";
            }

            if($erreur == '') {
                $createAdmin = $this->model->_createAdmin($_POST['adminEmail'], $_POST['adminMdp']);
                require_once('view/setup/finish.html.php');
            } else {
                require_once('view/setup/createAdmin.html.php');
            }
        }
    }
}