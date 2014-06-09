<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 24/05/2014
 * Time: 01:13
 */

class forums {

    private $model = null;

    function __construct(){

        $this->model = new _forums();

        require_once('view/header.html.php');
        require_once('view/nav.html.php');

        switch(@$_GET['action']){

            case "creer":
                echo "Création d'élément";
                break;

            default:
                $slug = '';
                $this->listing($slug);
                break;
        }

        require_once('view/footer.html.php');
    }

    function listing($slug){
        $listeForums = $this->model->listeForums($slug);
    }
} 