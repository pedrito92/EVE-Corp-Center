<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 24/05/2014
 * Time: 02:08
 */

use Pheal\Pheal;

class cms {

    function __construct(){

        switch( @$action ){
            default:
                $this->home();
                break;
        }
    }

    function home(){
        $pheal = new Pheal();
        echo "Page d'accueil";

        $response = $pheal->serverScope->ServerStatus();

        echo sprintf(
            "Hello Visitor! The EVE Online Server is: %s!, current amount of online players: %s",
            $response->serverOpen ? "open" : "closed",
            $response->onlinePlayers
        );
    }
} 