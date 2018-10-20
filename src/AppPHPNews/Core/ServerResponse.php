<?php namespace PHPNews\Core;
class ServerResponse{

    private $intError;
    private $strMessage;
    private $arrPayload;

    public function __construct($intError, $strMessage, $arrPayload = []){
        $this->intError = $intError;
        $this->strMessage = $strMessage;
        $this->arrPayload = $arrPayload;
    }

    public function getServerResponse(){
        die(json_encode((object) [
            'intError' => $this->intError,
            'strMessage' => $this->strMessage,
            'arrPayload' => $this->arrPayload,
        ]));
    }
}