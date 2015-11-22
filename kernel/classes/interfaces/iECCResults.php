<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 15/11/15
 * Time: 18:12
 */

namespace kernel\classes\interfaces;


interface iECCResults {

    public function fetch();

    public function fetchAll();

    public function bind($param, $value, $type);

    public function execute();
}