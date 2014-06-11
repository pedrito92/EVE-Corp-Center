<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 25/05/2014
 * Time: 19:16
 */

namespace kernel\Model;

class setup {

    private $dbh = null;

    function __construct() {

    }

    /**
     * @param $dsn
     * @param $user
     * @param $password
     *
     * Test les paramètres précisés pour vérifier si la base de données est prête à
     * recevoir les tables.
     *
     * @return string
     */
    function _checkDatabase($host, $port, $dbname, $user, $password){
        try {
            $dbh = new PDO("mysql:host=".$host.";port=".$port.";dbname=".$dbname, $user, $password);
            return "ok";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Installation des bases de données.
     *
     * @return string
     */
    function _setupDatabase(){
        try {

            $this->dbh = new PDO("mysql:host=".$_SESSION['mysql']['host'].";port=".$_SESSION['mysql']['port'].";dbname=".$_SESSION['mysql']['name'], $_SESSION["mysql"]["user"], $_SESSION["mysql"]["pass"]);
            $this->dbh->exec( "CREATE TABLE `ecc_apikeys` (
                            `ID_user` int(11) NOT NULL,
                            `ID_key` int(11) NOT NULL,
                            `key_apikey` varchar(255) NOT NULL,
                            `name_apikey` varchar(255) NOT NULL,
                            PRIMARY KEY (`ID_user`,`ID_key`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
            );
            $this->dbh->exec( "CREATE TABLE `ecc_forums` (
                            `ID_forums` int(11) NOT NULL AUTO_INCREMENT,
                            `name_forums` varchar(200) NOT NULL,
                            PRIMARY KEY (`ID_forums`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;"
            );
            $this->dbh->exec( "CREATE TABLE `ecc_pages` (
                            `ID_page` int(11) NOT NULL AUTO_INCREMENT,
                            `name_page` varchar(200) NOT NULL,
                            `slug_page` varchar(200) NOT NULL,
                            PRIMARY KEY (`ID_page`),
                            UNIQUE KEY `alias_page` (`slug_page`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;"
            );
            $this->dbh->exec( "CREATE TABLE `ecc_users` (
                            `ID_user` int(11) NOT NULL AUTO_INCREMENT,
                            `email_user` varchar(255) NOT NULL,
                            `pass_user` varchar(255) NOT NULL,
                            `pseudo_user` varchar(255) NOT NULL,
                            PRIMARY KEY (`ID_user`),
                            UNIQUE KEY `email_user` (`email_user`,`pseudo_user`)
                        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;"
            );

        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $email
     * @param $mdp
     * @return mixed
     *
     * Création d'un premier compte administrateur à partir des informations rentrées à la dernière étape,
     * et création du fichier de configuration.
     */
    function _createAdmin($email, $mdp){
        try {
            $this->dbh = new PDO("mysql:host=".$_SESSION['mysql']['host'].";port=".$_SESSION['mysql']['port'].";dbname=".$_SESSION['mysql']['name'], $_SESSION["mysql"]["user"], $_SESSION["mysql"]["pass"]);
            $insert = $this->dbh->exec( "INSERT INTO `ecc_users` (`email_user`,`pass_user`)
                                VALUES ( '".$email."', SHA1('".strtoupper($email).":".$mdp."'));"
            );

            mkdir('./settings/', 0755);
            mkdir('./var/cache/pheal/', 0755, true);
            mkdir('./var/logs/', 0755, true);
            $mainConf = fopen("./settings/core.ini.php", "a");
            fwrite($mainConf, "<?php /*\n");
            fwrite($mainConf, "[DATABASE]\n");
            fwrite($mainConf, "host     = ".$_SESSION['mysql']['host']."\n");
            fwrite($mainConf, "port     = ".$_SESSION['mysql']['port']."\n");
            fwrite($mainConf, "user     = ".$_SESSION['mysql']['user']."\n");
            fwrite($mainConf, "pass     = ".$_SESSION['mysql']['pass']."\n");
            fwrite($mainConf, "base     = ".$_SESSION['mysql']['name']."\n");
            fwrite($mainConf, "\n");
            fwrite($mainConf, "[STOCKAGE]\n");
            fwrite($mainConf, "path     = ".dirname(dirname(__FILE__))."\n");
            fwrite($mainConf, "url      = ".$_SERVER["HTTP_HOST"]."\n");
            fwrite($mainConf, "\n");
            fwrite($mainConf, "[INFOS]\n");
            fwrite($mainConf, "version      = 0.0.1\n");
            fclose($mainConf);

        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }
} 