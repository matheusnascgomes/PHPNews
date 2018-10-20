<?php

use PHPNews\Core\{ ServerResponse, ServerResponseException };
use PHPNews\Core\ImageHandler;
use PHPNews\Clients\ClientsHandler;
use PHPNews\User\UserHandler;

$app->post('/client/register', function(){

    $client = new ClientsHandler;
    $client->setData($_POST);

    $imageHandler = new ImageHandler;
    
    try{

        if(!empty($_FILES)){

            $tempName = $imageHandler->getCustomTmpName($_FILES['image']['tmp_name']);
 
            $strFile = $imageHandler->upload($tempName, $_FILES['image'], 'clients');

            $clientId = $client->register();

            $newName = $imageHandler->renameImageOnServer($strFile, $clientId, 'clients');

            (new UserHandler)->storesNewImageName($clientId, $newName);

        }else{
            $clientId = $client->register();
        }     
        

        (new ServerResponse(0, "Cliente cadastrado com sucesso"))->getServerResponse();

    }catch(\Exception $objEx){
        (new ServerResponseException(1001, 'ERRO: Não foi possível cadastrar o motorista!. Tente novamente mais tarde', $objEx))->getServerResponse();
    }
});

$app->post('/client/update/:id', function($id){

    $client = new ClientsHandler;
    $client->setData($_POST);
    $client->setUserId($id);

    try{
        (new ServerResponse(0, "Cliente Aterado com sucesso", $client->update()))->getServerResponse();

    }catch(\Exception $objEx){
        (new ServerResponseException(1001, 'Não foi possível alterar o motorista', $objEx))->getServerResponse();
    }

});

$app->get('/clients', function(){

    $client = new ClientsHandler;

    try{
        (new ServerResponse(0, "", $client->list()))->getServerResponse();

    }catch(\Exception $objEx){
        (new ServerResponseException(1001, 'Não foi possível exibir os motoristas', $objEx))->getServerResponse();
    }

});

$app->get('/client/cars/:clientId', function($clientId){

    $client = new ClientsHandler;
    $client->setClientId($clientId);

    try{
        (new ServerResponse(0, "", $client->listCarsByClient()))->getServerResponse();

    }catch(\Exception $objEx){
        (new ServerResponseException(1001, 'Não foi possível exibir os motoristas', $objEx))->getServerResponse();
    }

});

$app->post('/client/remove/:id', function($id){
    
    $client = new ClientsHandler;
    $client->setUserId($id);

    try{
        (new ServerResponse(0, "Cliente removido com sucesso", $client->remove()))->getServerResponse();

    }catch(\Exception $objEx){
        (new ServerResponseException(1001, 'ERRO: Não foi possível remover o motorista!. Tente novamente mais tarde', $objEx))->getServerResponse();
    }
});

