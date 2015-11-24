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
use kernel\classes\DB\ECCPdo;
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

try{
    if(!ECCINI::exist()) throw new PDOException('ECCIni required');

    $ini = ECCINI::instance();
    $infos = $ini->getSection('database');

    $host 	    = $infos['host'];
    $port	    = $infos['port'];
    $dbname	    = $infos['dbname'];
    $username	= $infos['username'];
    $passwd	    = $infos['passwd'];
    $prefix	    = $infos['prefix'];
    $driver     = $infos['driver'];

    switch($driver){
        case 'pdo':
        default:
            $options = array(
                ECCPdo::ATTR_PERSISTENT    		=> true,
                ECCPdo::ATTR_ERRMODE       		=> ECCPdo::ERRMODE_EXCEPTION,
                ECCPdo::MYSQL_ATTR_INIT_COMMAND	=> "SET NAMES utf8"
            );
            $dsn = 'mysql:host='.$host.';port='.$port.';dbname='.$dbname;
            $dao = new ECCPdo($dsn, $username, $passwd, $options, $prefix );
            break;
    }

}
catch(PDOException $e){
    $this->error = $e->getMessage();

    header("HTTP/1.1 500 Internal Server Error");
    print("<b>Fatal error</b>: The web server did not finish its request<br/>");
    print("La connexion à la base de données à échouée. Si le problème persiste, contactez votre administrateur.");
    exit;
}

session_start();

$routing = new \kernel\RoutingHandler($dao);