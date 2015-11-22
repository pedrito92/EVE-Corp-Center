<?php

namespace kernel\classes;

use Exception;
use kernel\classes\interfaces\iECCDb;
use kernel\classes\interfaces\iECCResults;
use kernel\classes\DB\ECCPdo;
use \PDO;
use \PDOException;


/*
 * Request interpreter
 */
class ECCDB {
    
    protected $dao;

    // On souhaite un objet instanciant une classe qui implémente iECCDb.
    public function __construct(iECCDb $dao)
    {
        $this->dao = $dao;
    }
    
    public function query($query){
       $dbh = $this->dao->query($query);

        if (!$dbh instanceof iECCResults)
        {
            throw new Exception('Le résultat d\'une requête doit être un objet implémentant iECCResults');
        }
    }

    function bind($param, $value, $type = null){
        $this->dao->bind($param, $value, $type);
    }

    function single(){
        $this->execute();
        return $this->dao->fetch(PDO::FETCH_ASSOC);
    }

    function execute(){
        return $this->dao->execute();
    }

    function resultset(){
        $this->dao->execute();
        return $this->dao->fetchAll(PDO::FETCH_ASSOC);
    }

    function rowCount(){
        return $this->dao->rowCount();
    }

    function lastInsertId(){
        return $this->dao->lastInsertId();
    }

	function beginTransaction(){
		return $this->dao->beginTransaction();
	}

	function endTransaction(){
		return $this->dao->commit();
	}

	function cancelTransaction(){
		return $this->dao->rollBack();
	}

	function debugDumpParams(){
		return $this->dao->debugDumpParams();
	}
}