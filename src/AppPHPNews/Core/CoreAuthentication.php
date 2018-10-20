<?php namespace PHPNews\Core;

use PHPNews\Core\Model;
use PHPNews\DB\Sql;

class CoreAuthentication extends Model{

    const DISABLED = 0;
    const ACTIVE = 1;

    public function register(){

        $objSql = new Sql();

        $queryResults = $objSql->query("INSERT INTO tbl_authentication (user_id, login, password, auth_token, active)
        VALUES (:user_id, :login, :password, :auth_token, :active)", [
            ':user_id'=>$this->getuserId(),
            ':login'=>$this->getlogin(),
            ':password'=>$this->getpassword(),
            ':auth_token'=>$this->getauthToken(),
            ':active'=>self::ACTIVE
        ]);
    }

}