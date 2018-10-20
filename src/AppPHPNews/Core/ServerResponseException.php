<?php namespace PHPNews\Core;
class ServerResponseException{

    public function __construct($intErrorCode, $strErrorMessage, \Exception $objEx = null){
        $arrDados = [];
        if(!is_null($objEx)){
            $arrDados = [
                'intExceptionCode' => $objEx->getCode(),
                'strExceptionMessage' => $objEx->getMessage()
            ];
        }
        $this->objServerResponse = new ServerResponse($intErrorCode, $strErrorMessage, $arrDados);
    }

    public function getServerResponse(){
        $this->objServerResponse->getServerResponse();
    }
}