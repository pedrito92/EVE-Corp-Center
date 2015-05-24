<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 20/05/15
 * Time: 23:12
 */

namespace kernel\classes\user;


use kernel\classes\ECCDB;

class ECCUserToken {
    private $token;

    /**
     * @return mixed
     */
    private function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    private function setToken($token)
    {
        $this->token = $token;
    }

    function generate($id, $email){
        $this->setToken(sha1($email . ':' . time()));
        $this->save($id);
        return $this->getToken();
    }

    private function save($id){
        $db = ECCDB::instance();
        $dbprefix 	= $db->getPrefix();

        $db->query("INSERT INTO `".$dbprefix."tokens`(`ID_object`, `token`)
                    VALUES (:idObject, :token)
                    ON DUPLICATE KEY UPDATE `token` = :token;");
        $db->bind(":idObject", $id);
        $db->bind(":token", $this->getToken());
        $db->execute();
    }

    function verify($token){
        $db = ECCDB::instance();
        $dbprefix = $db->getPrefix();

        $db->query("SELECT `ID_object`, `token` FROM `".$dbprefix."tokens`
                    WHERE `token` = :token;");
        $db->bind(":token", $token);
        $row = $db->single();

        return $db->rowCount() > 0 ? $row: false;
    }

    function delete($ID_object){
        $db = ECCDB::instance();
        $dbprefix = $db->getPrefix();

        $db->query("DELETE FROM `".$dbprefix."tokens` WHERE `ID_object` = :idObject;");
        $db->bind(":idObject", $ID_object);
        return $db->execute();
    }
}