<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 22/05/2014
 * Time: 22:56
 */

$domain = '';
$action = '';

if(isset($_GET['domain'])){
    $domain = $_GET['domain'];
}
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

class main {
    function __construct(){

        switch( @$domain ){

            case "forums":
                $forums = new forums();
                break;

            default:
                $cms = new cms();
                break;
        }
    }
}