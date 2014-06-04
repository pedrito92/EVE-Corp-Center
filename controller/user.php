<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 23/05/2014
 * Time: 23:57
 */

class user {

    function __construct(){
        include_once('view/setup/header.html.php');

        switch(@$_GET['action']){
            case "registration":
                $this->registration();
                break;

            case "login":
                $this->login();
                break;


            case "logout":
                $this->logout();
                break;

            default:
                break;
        }

        include_once('view/setup/footer.html.php');
    }

    function registration(){

    }

    function login(){

    }

    function logout(){

    }
} 