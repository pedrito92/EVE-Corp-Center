<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 15/11/15
 * Time: 18:11
 */

namespace kernel\classes\interfaces;


interface iECCDb {

    public function query($query);

    public function prepare($query);

    public function getPrefix();

    public function bind($param, $value, $type);

    public function execute();

    public function fetch($fetch);

    public function fetchAll($fetch);

    public function rowCount();

    public function lastInsertId($seqname = null);

    public function beginTransaction();

    public function commit();

    public function rollBack();
}