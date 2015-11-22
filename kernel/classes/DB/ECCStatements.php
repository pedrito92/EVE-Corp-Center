<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 22/11/15
 * Time: 16:10
 */

namespace kernel\classes\DB;

use kernel\classes\interfaces\iECCResults;

class ECCStatements implements iECCResults
{
    protected $st;

    public function __construct(ECCStatements $st)
    {
        $this->st = $st;
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