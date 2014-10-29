<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 10/06/2014
 * Time: 22:37
 */

namespace kernel\controller;

use Pheal\Pheal;
use Pheal\Core\Config;


class ECCContentManagementSystem extends ECCObject {

    function __construct(){

    }


    function home(){

        Config::getInstance()->cache = new \Pheal\Cache\FileStorage('var/cache/pheal/');
        Config::getInstance()->access = new \Pheal\Access\StaticCheck();

        $pheal = new Pheal();
        echo "Page d'accueil";

        $response = $pheal->serverScope->ServerStatus();

        echo sprintf(
            "Hello Visitor! The EVE Online Server is: %s!, current amount of online players: %s",
            $response->serverOpen ? "open" : "closed",
            $response->onlinePlayers
        );


        echo '<br><br><br><br>';

        $keyID = 2815094;
        $vCode = "BLHfaEJ6oFt07utSvBfNZG6EpPMHW7VTu3s9CqPZ8JxV9UKR5d0mEnzths7Vhbwp";
        $characterID = 90719345;

        $pheal2 = new Pheal($keyID, $vCode, "char");

        try{
            $response = $pheal2->CharacterSheet(array("characterID" => $characterID));

            echo sprintf(
                "Hello Visitor, Character %s was created at %s is of the %s race and belongs to the corporation %s",
                $response->name,
                $response->DoB,
                $response->race,
                $response->corporationName
            );
        } catch (\Pheal\Exceptions\PhealException $e) {
            echo sprintf(
                "an exception was caught! Type: %s Message: %s",
                get_class($e),
                $e->getMessage()
            );
        }
    }
} 