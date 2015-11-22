<?php

namespace kernel\classes;

use Exception;
use kernel\classes\interfaces\iECCDb;
use kernel\classes\interfaces\iECCResults;
use \PDO;
use \PDOException;


class ECCDB {

	protected static $instance;

	private $host;
	private $port;
	private $dbname;
	private $username;
	private $passwd;
	private $prefix;

	private $dbh;
	private $error;
	private $stmt;

    protected $dao;

    // On souhaite un objet instanciant une classe qui implémente iDB.
    public function __construct(iECCDb $dao)
    {
        $this->dao = $dao;
    }

    public function get($id)
    {
        $q = $this->dao->query('SELECT id, auteur, titre, contenu FROM news WHERE id = '.(int)$id);

        // On vérifie que le résultat implémente bien iResult.
        if (!$q instanceof iECCResults)
        {
            throw new Exception('Le résultat d\'une requête doit être un objet implémentant iResult');
        }

        return $q->fetchAssoc();
    }

    public function query($query){
       $this->dbh = $this->dao->query($query);

        if (!$this->dbh instanceof iECCResults)
        {
            throw new Exception('Le résultat d\'une requête doit être un objet implémentant iECCResults');
        }
    }

    public function bind($param, $value, $type = null){
        $this->dao->bind($param, $value, $type);
    }


/*	protected function __construct(){
		$ini = ECCINI::instance();

		$infos = $ini->getSection('database');

		$this->host 	= $infos['host'];
		$this->port		= $infos['port'];
		$this->dbname	= $infos['dbname'];
		$this->username	= $infos['username'];
		$this->passwd	= $infos['passwd'];
		$this->prefix	= $infos['prefix'];

		$dsn = 'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname;

		$options = array(
			PDO::ATTR_PERSISTENT    		=> true,
			PDO::ATTR_ERRMODE       		=> PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_INIT_COMMAND	=> "SET NAMES utf8"
		);
		try{
			$this->dbh = new PDO($dsn, $this->username, $this->passwd, $options);
		}
		catch(PDOException $e){
			$this->error = $e->getMessage();

			header("HTTP/1.1 500 Internal Server Error");
			print("<b>Fatal error</b>: The web server did not finish its request<br/>");
			print("La connexion à la base de données à échouée. Si le problème persiste, contactez votre administrateur.");
			exit;
		}
	}*/

	/*public static function instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}
		
		return self::$instance;
	}*/

/*	public function getPrefix(){
		return $this->prefix;
	}*/

//	function query($query){
//		$this->stmt = $this->dbh->prepare($query);
//	}

//	function bind($param, $value, $type = null){
//		if (is_null($type)) {
//			switch (true) {
//				case is_int($value):
//					$type = PDO::PARAM_INT;
//					break;
//				case is_bool($value):
//					$type = PDO::PARAM_BOOL;
//					break;
//				case is_null($value):
//					$type = PDO::PARAM_NULL;
//					break;
//				default:
//					$type = PDO::PARAM_STR;
//			}
//		}
//		$this->stmt->bindValue($param, $value, $type);
//	}

	function execute(){
		return $this->stmt->execute();
	}

	function resultset(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	function single(){
		$this->dao->execute();
		return $this->dao->fetch(PDO::FETCH_ASSOC);
	}

	function rowCount(){
		return $this->stmt->rowCount();
	}

	function lastInsertId(){
		return $this->dbh->lastInsertId();
	}

	function beginTransaction(){
		return $this->dbh->beginTransaction();
	}

	function endTransaction(){
		return $this->dbh->commit();
	}

	function cancelTransaction(){
		return $this->dbh->rollBack();
	}

	function debugDumpParams(){
		return $this->stmt->debugDumpParams();
	}
}