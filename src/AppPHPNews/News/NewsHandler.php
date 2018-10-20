<?php namespace PHPNews\News;

use PHPNews\DB\Sql;
use PHPNews\Core\Model;
use PHPNews\Core\ImageHandler;

class NewsHandler extends Model{

    public function register(){

        $imageHandler = new ImageHandler;
        $strFile = $imageHandler->upload($this->getFiles()['Image'], 'news');

        $objSql = new Sql;

        $objSql->query("INSERT INTO news (title, post) 
        VALUES (:title, :post)",[
            ':title' => $this->getTitle(),
            ':post' => $this->getPost()
        ]);

        $newsId = $objSql->getLastId();

        $newName = $imageHandler->renameImageOnServer($strFile, $newsId, 'news');
        $this->storesNewImageName($newsId, $newName);
    }

    public function update(){

        $this->showLine();

        (new Sql)->query("UPDATE news SET title = :title, post = :post
        WHERE id = :id",[
            ':id' => $this->getId(),
            ':title' => $this->getTitle(),
            ':post' => $this->getPost()
        ]);
    }

    public function delete(){

        $this->showLine();

        (new Sql)->query("DELETE FROM news WHERE id = :id",[
            ':id' => $this->getId()
        ]);
    }

    public function rawList(){

        $results = (new Sql)->select("SELECT * FROM news");

        if(empty($results))
            throw new \Exception("", 1);

        foreach($results as &$img)
            $img['image_uri'] = UPLOAD_URL.'news/'.$img['image_uri'];
            
        return $results;
    }

    public function showLine(){

        $results = (new Sql)->select("SELECT * FROM news WHERE id = :id", [
            ':id' => $this->getId()
        ]);

        if(empty($results))
            throw new \Exception("", 1);

        foreach($results as &$img)
            $img['image_uri'] = UPLOAD_URL.'news/'.$img['image_uri'];
            
        return $results[0];
    }

    public function storesNewImageName($id, $newImageName){

        (new Sql)->query("UPDATE news SET image_uri = :image_uri WHERE id = :id",[
            ':id'=>$id,
            ':image_uri'=>$newImageName,
        ]);
    }
}
