<?php namespace PHPNews\Core;

class ImageHandler{

    const TYPE_NEWS = 'news';

    public function upload($imgInfo, $typeEntity){

        $tmpName = $this->getCustomTmpName($imgInfo['tmp_name']);
        $typeDirName = $this->getTypeEntityDir($typeEntity);

        $dirName = UPLOAD_SRC.$typeDirName;

        if(!is_dir($dirName)) 
            mkdir(UPLOAD_SRC.$typeDirName);

        $strExtensao = $this->extractsExtension($imgInfo['name']);

        $strNewFile = $tmpName.'.'.$strExtensao;

        $intMaxSize = 5/*MB*/;
        if(($imgInfo['size'] == 0) || ($imgInfo['size'] > $intMaxSize *1024*1024))
            (new ServerResponseException(1001, "ERRO: O arquivo excede o tamanho de {$intMaxSize}MB", new \Exception('Img size: '. $imgInfo['size'])))->getServerResponse();

        if(!in_array($imgInfo['type'], ['image/gif', 'image/jpeg', 'image/jpg', 'image/png']))
            (new ServerResponseException(1001, 'ERRO: O arquivo enviado não é uma imagem', new \Exception('Img type: '. $imgInfo['type'])))->getServerResponse();

        if(!move_uploaded_file($imgInfo['tmp_name'], $dirName.'/'.$strNewFile))
            (new ServerResponseException(1001, 'ERRO: não foi possível efetuar o cadastrado, pois a imagem não pôde ser carregada no servidor. Tente novamente mais tarde', $objEx))->getServerResponse();

        return $strNewFile;
    }

    public function extractsExtension($strName){
        $strImageExploded = explode('.', $strName);
        $strExtensao = end($strImageExploded);
        return $strExtensao;
    }

    public function extractsImageNameFromDir($strName){
        $strImageExploded = explode('/', $strName);
        $strImageName = end($strImageExploded);
        return $strImageName;
    }

    public function getCustomTmpName($defaultTmpName){
        return $this->extractsImageNameFromDir($defaultTmpName) . '_' . time();
    }

    public function renameImageOnServer($oldName, $newName, $typeEntity){

        $typeDirName = $this->getTypeEntityDir($typeEntity);

        $dirName = UPLOAD_SRC.$typeDirName;

        $oldName = $dirName.$oldName;
        $newName = $dirName.$newName .'.' . $this->extractsExtension($oldName);

        if(is_file($oldName))
            rename($oldName, $newName);

        return $this->extractsImageNameFromDir($newName);
    }


    private function getTypeEntityDir($typeEntity){

        $dirName = '';

        switch ($typeEntity) {

            case self::TYPE_NEWS:
                $dirName = self::TYPE_NEWS . '/';
                break;
            default:
                throw new Exception("Um tipo de entidade deve ser informado", 1);                
                break; 

        }

        return $dirName;
    }
}