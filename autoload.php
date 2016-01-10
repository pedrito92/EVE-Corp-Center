<?php

require_once('lib/autoload.php');

function autoloader($class) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    if(file_exists($path.".php")){
        require_once($path.'.php');
    } elseif(file_exists('lib/'.$path.'.php')){
        require_once('lib/'.$path.'.php');
    }
}

spl_autoload_register('autoloader');