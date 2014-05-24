<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 24/05/2014
 * Time: 02:08
 */

class cms {

    function __construct(){

        switch( @$action ){
            default:
                $this->home();
                break;
        }
    }

    function home(){
        echo "Page d'accueil";
    }
} 