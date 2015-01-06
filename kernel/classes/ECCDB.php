<?php
/**
 * CUSTOM CLASS
 */

namespace kernel\classes;

use \PDO;

//TODO : Récupération des infos dans le fichier settings/core.ini.php à l'aide de la classe ECCINI

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = 'root';
const DB_NAME = 'ecc_demo';

class ECCDB {

	protected static $instance;

	private $host      = DB_HOST;
	private $user      = DB_USER;
	private $pass      = DB_PASS;
	private $dbname    = DB_NAME;
	private $dbh;
	private $error;
	private $stmt;

	protected function __construct(){
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

		$options = array(
			PDO::ATTR_PERSISTENT    		=> true,
			PDO::ATTR_ERRMODE       		=> PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_INIT_COMMAND	=> "SET NAMES utf8"
		);
		try{
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		}
		catch(PDOException $e){
			$this->error = $e->getMessage();

			header("HTTP/1.1 500 Internal Server Error");
			print("<b>Fatal error</b>: The web server did not finish its request<br/>");
			print("La connexion à la base de données à échouée. Si le problème persiste, contactez votre administrateur.");
			exit;
		}
	}

	public static function instance(){
		if(!self::$instance instanceof self){
			self::$instance = new self;
		}
		
		return self::$instance;
	}

	function query($query){
		$this->stmt = $this->dbh->prepare($query);
	}

	function bind($param, $value, $type = null){
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}

	function execute(){
		return $this->stmt->execute();
	}

	function resultset(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
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