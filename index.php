<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 22/05/2014
 * Time: 22:46
 */

require_once('autoload.php');
session_start();
$app = new kernel\RoutingHandler();