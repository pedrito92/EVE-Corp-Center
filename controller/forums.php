<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 24/05/2014
 * Time: 01:13
 */

class forums {

    function __construct(){

        require_once('view/header.html.php');
        require_once('view/nav.html.php');

        switch(@$_GET['action']){

            case "creer":
                echo "Création d'élément";
                break;

            default:
                echo "Listing des catégories et forums";
                break;
        }

        require_once('view/footer.html.php');
    }
} 