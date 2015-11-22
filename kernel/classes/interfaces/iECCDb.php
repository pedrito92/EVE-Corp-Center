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
}