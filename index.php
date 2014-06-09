<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 22/05/2014
 * Time: 22:46
 */

function autoloader($classname) {



    if( substr( $classname , 0 , 1 ) == "_" ){
        require_once( 'model/'.$classname.".php" );
    } elseif($classname == "Pheal"){
        require_once('libs/Pheal/Pheal.php');
    } else {
        require_once( 'controller/'.$classname.".php" );
    }
}
spl_autoload_register('autoloader');

$main = new main();