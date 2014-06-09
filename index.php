<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 22/05/2014
 * Time: 22:46
 */

function autoloader($class) {

    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);


    if(file_exists('controller/'.$path.'.php')) {
        $path = 'controller/'.$path;
    } elseif(file_exists('model/'.$path.'.php')) {
        $path = 'model/'.$path;
    } else {
        $path = 'libs/'.$path;
    }

    require_once($path . '.php');
}

spl_autoload_register('autoloader');

$main = new main();