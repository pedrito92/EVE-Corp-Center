<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 22/11/15
 * Time: 16:08
 */

namespace kernel\classes\DB;

use kernel\classes\interfaces\iECCDb;
use PDO;

/*
 * Conversion to PDO
 */
class ECCPdo extends PDO implements iECCDb{
    private $prefix;
    private $pdo;

    public function __construct ( $dsn, $username, $passwd, $options, $prefix )
    {
        parent::__construct ( $dsn, $username, $passwd, $options );

        $this->prefix = $prefix;
    }

    /**
     * @return mixed
     */
    public function getPrefix ()
    {
        return $this->prefix;
    }


    public function query ( $statement )
    {
        $this->pdo = new ECCStatement(parent::prepare($statement, array()));
        return $this->pdo;
    }

    public function prepare ( $statement, $driver_options = array () )
    {
        $this->pdo = parent::prepare ( $statement, $driver_options ); // TODO: Change the autogenerated stub
    }

    public function bind($param, $value, $type = null){
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
        $this->pdo->bind($param, $value, $type);
    }

    public function execute(){
        return $this->pdo->execute();
    }

    public function fetch($param){
        return $this->pdo->fetch($param);
    }

    public function fetchAll($param){
        return $this->pdo->fetchAll($param);
    }

    public function rowCount(){
        return $this->pdo->rowCount();
    }

    public function lastInsertId($seqname = null){
        return $this->pdo->lastInsertId($seqname);
    }

    public function beginTransaction ()
    {
        return $this->pdo->beginTransaction();
    }

    public function commit ()
    {
        return $this->pdo->commit();
    }

    public function rollBack ()
    {
        return $this->pdo->rollBack();
    }
}