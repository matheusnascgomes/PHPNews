<?php namespace PHPNews\Clients;

use PHPNews\Core\Model;
use PHPNews\Core\CoreAddress;
use PHPNews\DB\Sql;
use PHPNews\User\UserHandler;

class SubscribersHandler extends Model{
    
    public function register(){

        $user = new UserHandler;
        $user->setData($this->getValues());
        $userId = $user->register(false);

        $address = new CoreAddress;
        $address->setData($this->getValues());
        $addressId = $address->register();

        (new Sql)->query("INSERT INTO tbl_clients (user_id, doc_cpf, doc_rg, doc_cnh,address_id)
            VALUES (:user_id, :doc_cpf, :doc_rg, :doc_cnh, :address_id)",[
                ':user_id'=>$userId,
                ':doc_cpf'=>$this->getcpf(),
                ':doc_rg'=>$this->getrg(), 
                ':doc_cnh'=>$this->getcnh(),
                ':address_id'=>$addressId,
            ]);

        return $userId;
    }

    public function update(){

        $userId = $this->getUserId();

        $user = new UserHandler;
        $user->setData($this->getValues());
        $user->update($userId);

        $addressId = $this->findAddressId($userId);
        $address = new CoreAddress;
        $address->setData($this->getValues());
        $address->update($addressId);

        (new Sql)->query("UPDATE tbl_clients 
            SET doc_cpf = :doc_cpf, doc_rg = :doc_rg, doc_cnh = :doc_cnh, doc_cnpj = doc_cnpj 
            WHERE user_id = :user_Id", [
                ':user_id'=>$userId,
                ':doc_cpf'=>$this->getcpf(),
                ':doc_rg'=>$this->getrg(),
                ':doc_cnh'=>$this->getcnh(),
                ':doc_cnpj'=>$this->getcnpj()
            ]);
    }

    public function list(){

        $queryResults = (new Sql)->select("SELECT * FROM vw_clients_users",[]);

        foreach($queryResults as &$img){

            $imageAddress = UPLOAD_URL.'clients/'.$img['image'];

            if(is_null($img['image']))
                $imageAddress = $img['image'];

            $img['image'] = $imageAddress;
        }

        return $queryResults;
    }

    public function remove(){

        (new Sql)->query("UPDATE tbl_users SET deleted_at = NOW() WHERE id = :user_id",[
            ':user_id'=>$this->getUserId()
        ]);
    }

    private function findAddressId($driverId){

        $addressId = (new Sql)->select("SELECT address_id FROM tbl_clients WHERE user_id = :driver_id",[
            ':driver_id'=>$driverId
        ]);

        return $addressId[0]['address_id'];
    }

    public function listCarsByClient(){

        $queryResults = (new Sql)->select("
            SELECT cars.*, model.name AS car_model FROM 
            tbl_cars AS cars
            INNER JOIN tbl_car_model AS model ON (model.id = cars.car_model_id)
            WHERE client_id = :client_id",[
            ':client_id'=>$this->getClientId()
        ]);

        if(empty($queryResults))
        throw new \Exception("", 1);

    return $queryResults;

    }

}
