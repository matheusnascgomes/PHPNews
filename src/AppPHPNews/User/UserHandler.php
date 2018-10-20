<?php namespace PHPNews\User;

use PHPNews\Core\Model;
use PHPNews\DB\Sql;

class UserHandler extends Model{

    public function register(){

        $objSql = new Sql();
            
        $results = $objSql->query("INSERT INTO users (email, password, name)
            VALUES (:email, :password, :name)",[
            ':email' => $this->getEmail(),
            ':password' => $this->getPassword(),
            ':name'=>$this->getName()            
        ]);
    }

    public function signIn(){

        $results = (new Sql)->select("SELECT * FROM users WHERE email  = :email",[
            ':email'=>$this->getEmail()
        ]);
               
        $storedPassword = $results[0]['password'];
        $postedPassword = $this->getPassword();

        if(!empty($results) && password_verify($postedPassword, $storedPassword))
            return $this->fetchUserInfo($results[0]['id']);
        else
            throw new \Exception("", 1);
    }

    private function fetchUserInfo($userId){

        $results = (new Sql)->select("SELECT email, name FROM users WHERE id = :id",[
            ':id'=>$userId
        ]);
        
        return $results;
    }
}
