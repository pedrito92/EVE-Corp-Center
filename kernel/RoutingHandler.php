<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 10/06/2014
 * Time: 22:23
 */

namespace kernel;


class RoutingHandler {

    public $getParams;

    public function __construct(){
        $this->getParams = $_GET;
        $this->dispatcher();
    }

    public function dispatcher(){
        if(!file_exists("./settings/core.ini.php") && (!isset($this->getParams['domain']) || $this->getParams['domain'] != 'setup')) {
            header('Location: /?domain=setup&action=home');
        }

        if(empty($this->getParams)){
            $this->getParams['domain'] = 'site';
            $this->getParams['action'] = 'home';
        }

        if(!isset($domain)){
            $domain = $this->getParams['domain'];
        }
        if(!isset($action)){
            $action = $this->getParams['action'];
        }

        if(!empty($domain) && !empty($action)){
            $domain = "kernel\controller\\".$domain;

            $controller = new $domain;
            $controller->$action();
        }
    }
} 