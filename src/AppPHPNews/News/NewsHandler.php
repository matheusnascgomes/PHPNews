<?php namespace PHPNews\News;

use PHPNews\Core\Model;
use PHPNews\DB\Sql;

class NewsHandler extends Model{

    public function register(){

        $imageUri = '';

        (new Sql)->query("INSERT INTO news (title, post, image_uri) 
        VALUES (:title, :post, :image_uri)",[
            ':title' => $this->getTitle(),
            ':post' => $this->getPost(),
            ':image_uri' => $imageUri,
        ]);
    }

    public function update(){

        $imageUri = '';

        $this->showLine();

        (new Sql)->query("UPDATE news SET title = :title, post = :post, image_uri = :image_uri
        WHERE id = :id",[
            ':id' => $this->getId(),
            ':title' => $this->getTitle(),
            ':post' => $this->getPost(),
            ':image_uri' => $imageUri,
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
            
        return $results;
    }

    public function showLine(){

        $results = (new Sql)->select("SELECT * FROM news WHERE id = :id", [
            ':id' => $this->getId()
        ]);

        if(empty($results))
            throw new \Exception("", 1);
            
        return $results[0];
    }
}
