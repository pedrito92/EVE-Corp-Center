<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 22/11/15
 * Time: 16:10
 */

namespace kernel\classes\DB;

use kernel\classes\interfaces\iECCResults;
use PDOStatement;

class ECCStatement implements iECCResults
{
    protected $st;

    public function __construct(PDOStatement $st)
    {
        $this->st = $st;
    }

    public function execute(){
        return $this->st->execute();
    }

    public function bind($param, $value, $type){
        return $this->st->bindValue($param, $value, $type);
    }

    public function fetch()
    {
        return $this->st->fetch(ECCPdo::FETCH_ASSOC);
    }

    public function fetchAll()
    {
        return $this->st->fetchAll(ECCPdo::FETCH_ASSOC);
    }
}