<?php

use PHPNews\Core\{ ServerResponse, ServerResponseException };
use PHPNews\User\UserHandler;

$app->post('/user/register',function(){

    $user = new UserHandler();

    $_POST['Password']  = password_hash($_POST['Password'], PASSWORD_BCRYPT, [
        'cost' => 12,
    ]);

    $user->setData($_POST);

    try{
        (new ServerResponse(0, "Usuário cadastrado com sucesso", $user->register()))->getServerResponse();

    }catch(\Exception $objEx){
        (new ServerResponseException(1001, 'ERRO: Não foi possível cadastrar o usuário!. Tente novamente mais tarde', $objEx))->getServerResponse();
    }

});

$app->post('/user/signin',function(){

    $user = new UserHandler();

    $user->setData($_POST);

    try{
        (new ServerResponse(0, "Usuário autenticado com sucesso", $user->signIn()))->getServerResponse();

    }catch(\Exception $objEx){
        (new ServerResponseException(1001, 'ERRO:Usuário ou senha inválidos.', $objEx))->getServerResponse();
    }
});




