<?php
if (version_compare(PHP_VERSION, '5.4') < 0){
    print("<h1>Unsupported PHP version " . PHP_VERSION . "</h1>");
    print("<p>EVE Corp Center does not run with PHP version lower than 5.4.</p>".
        "<p>For more information about supported software please visit ".
        "<a href=\"http://www.evecorpcenter.com\" >EVE Corp Center Website</a></p>");
    exit;
}

if(!ini_get("date.timezone")) {
    date_default_timezone_set("UTC");
}

require_once('autoload.php');
use kernel\classes\ECCDebug;
use kernel\classes\ECCINI;

$ECCDebug = new ECCDebug();

if(ECCINI::exist()){
	if(!$ECCDebug->getDebug()){
		ini_set( "display_errors", 0);
	}
} else {
	ini_set( "display_errors", 0);
}

session_start();

$routing = new \kernel\RoutingHandler();