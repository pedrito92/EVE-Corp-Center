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
    } else {
        require_once( 'controller/'.$classname.".php" );
    }
}
spl_autoload_register('autoloader');


if(!file_exists("./settings/main.conf.php")) {
    $setup = new setup();
} else {
    $main = new main();
}