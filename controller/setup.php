<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 22/05/2014
 * Time: 22:56
 */

class setup {

    function __construct() {
        if(!file_exists("./settings/main.conf.php")) {

            session_start();
            //require_once('loc/setup_fr.loc.php');
            //$aLangs = array("en" => "English", "fr" => "Français");
            include_once('view/setup/header.html.php');

            switch(@$_GET['action']){
                case "database":
                    require_once('view/setup/database.html.php');
                    break;

                default:
                    require_once('loc/setup_en.loc.php');
                    require_once('view/setup/intro.html.php');
                    break;
            }

            include_once('view/setup/footer.html.php');

        } else {
            die();
        }
    }

    function step02() {

    }
}

//$mainConf = fopen("./settings/main.conf.php", "w");
//fwrite($mainConf, "coucou coucou");
//fclose($mainConf);