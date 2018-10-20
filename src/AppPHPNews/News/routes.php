<?php

use PHPNews\Core\{ ServerResponse, ServerResponseException };
use PHPNews\News\NewsHandler;

$app->post('/news/register',function(){

    $newsHandler = new NewsHandler;
    $newsHandler->setData($_POST);
    $newsHandler->setFiles($_FILES);

    try{

        (new ServerResponse(0, "Postagem registrada com sucesso", $newsHandler->register()))->getServerResponse();

    }catch(\Exception $objEx){
        (new ServerResponseException(
            1001, 
            'ERRO: Não foi possível registrar a postagem!. Tente novamente mais tarde', 
            $objEx)
        )->getServerResponse();
    }
});

$app->post('/news/update/:id',function($id){

    $newsHandler = new NewsHandler;
    $newsHandler->setId($id);
    $newsHandler->setData($_POST);

    try{
        (new ServerResponse(0, "Postagem alterada com sucesso", $newsHandler->update()))->getServerResponse();

    }catch(\Exception $objEx){
        (new ServerResponseException(1001, 'ERRO: Não foi realizar a alteração pois a postagem não existe!.', $objEx))->getServerResponse();
    }
});

$app->post('/news/delete/:id',function($id){

    $newsHandler = new NewsHandler;
    $newsHandler->setId($id);

    try{
        (new ServerResponse(0, "Postagem removida com sucesso", $newsHandler->delete()))->getServerResponse();
    }catch(\Exception $objEx){
        (new ServerResponseException(1001, 'ERRO: Não foi possível remover a postagem!.', $objEx))->getServerResponse();
    }
});

$app->get('/news',function(){

    try{
        (new ServerResponse(0, "", (new NewsHandler)->rawList()))->getServerResponse();
    }catch(\Exception $objEx){
        (new ServerResponseException(1001, 'ERRO: Não há dados a serem listados.', $objEx))->getServerResponse();
    }
});

$app->get('/news/:id',function($id){

    $newsHandler = new NewsHandler;
    $newsHandler->setId($id);

    try{
        (new ServerResponse(0, "", $newsHandler->showLine()))->getServerResponse();
    }catch(\Exception $objEx){
        (new ServerResponseException(1001, 'ERRO: Não há dados a serem listados.', $objEx))->getServerResponse();
    }
});





