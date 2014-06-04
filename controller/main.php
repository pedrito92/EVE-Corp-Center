<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 22/05/2014
 * Time: 22:56
 */

class main {
    function __construct(){

        $domain = '';
        $action = '';

        if(isset($_GET['domain'])){
            $domain = $_GET['domain'];
        }
        if(isset($_GET['action'])){
            $action = $_GET['action'];
        }

        if(!file_exists("./settings/core.ini.php") && $domain != "setup") {
            header("Location: ".$_SERVER['PHP_SELF']."?domain=setup");
        }


        switch( @$domain ){

            case "setup";
                new setup();
                break;

            case "forums":
                $forums = new forums();
                break;

            case "user":
                $user = new user();
                break;

            default:
                $cms = new cms();
                break;
        }
    }
}