<?php
if (version_compare(PHP_VERSION, '5.2') < 0){
    print("<h1>Unsupported PHP version " . PHP_VERSION . "</h1>");
    print("<p>EVE Corp Center does not run with PHP version lower than 5.2.</p>".
        "<p>For more information about supported software please visit ".
        "<a href=\"http://www.evecorpcenter.com\" >EVE Corp Center Website</a></p>");
    exit;
}

if(!ini_get("date.timezone")) {
    date_default_timezone_set("UTC");
}
//ini_set( "display_errors", 0);

require_once('autoload.php');
session_start();

kernel\RoutingHandler::init();

$uri = kernel\RoutingHandler::instance();
$uri->routing();