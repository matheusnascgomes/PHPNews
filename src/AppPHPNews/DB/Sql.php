<?php namespace PHPNews\DB;

class Sql {

	const HOSTNAME = DB_HOST;
	const USERNAME = DB_USER;
	const PASSWORD = DB_PASS;
	const DBNAME   = DB_NAME;

	private $conn;

	public function __construct(){

		$this->conn = new \PDO(
			"mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME, 
			Sql::USERNAME,
			Sql::PASSWORD
		);

		$this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->conn->exec("SET CHARACTER SET utf8");
		$this->conn->exec("SET time_zone = 'America/Recife'");
	}

	private function setParams($statement, $parameters = array()){

		foreach ($parameters as $key => $value) {
			$this->bindParam($statement, $key, $value);
		}

	}

	private function bindParam($statement, $key, $value){
		$statement->bindParam($key, $value);
	}

	public function query($rawQuery, $params = array()){

		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
        $stmt->execute();        
	}

	public function select($rawQuery, $params = array()):array{

		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}


	public function getLastId(){
		return $this->conn->lastInsertId(); 
	}

}

 ?>