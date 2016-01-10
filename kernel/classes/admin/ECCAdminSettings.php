<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 10/01/2016
 * Time: 15:54
 */

namespace kernel\classes\admin;

use kernel\classes\ECCDebug;
use kernel\classes\ECCINI;
use kernel\classes\ECCSystem;


class ECCAdminSettings extends ECCAdmin {

    public function index(){
        $ECCDebug = new ECCDebug();
        echo '<a href="/admin/settings/clearcache">Clear cache</a><br>';
        echo '<a href="/admin/settings/testIni">testIni</a><br>';

        if($ECCDebug->getDebug())
            echo '<a href="/admin/settings/toggleDebug">Disable debug</a><br>';
        else
            echo '<a href="/admin/settings/toggleDebug">Enable debug</a><br>';
    }

    public function toggleDebug(){
        $ECCINI     = ECCINI::instance();
        $ECCDebug   = new ECCDebug();
        if($ECCDebug->getDebug()) {
            /*
             * Set debug off with ECCINI write method
             */
        } else {
            /*
             * Set debug on with ECCINI write method
             */
        }

        ECCSystem::redirectToURI('/admin/settings/');
    }

    public function clearcache() {
        ECCSystem::deleteDir('var/cache/twig');
        ECCSystem::redirectToURI('/admin/settings/');
    }

    public function testIni(){
        $ini = ECCINI::instance('core-save.ini','settings');
        $ini->setVariable('test', 'key', 'value');
        $ini->setVariable('infos', 'debug', 0);
        $ini->setVariable('database', 'driver', 'mysql');
        $ini->saveFile();

        echo 'saved';
    }
}