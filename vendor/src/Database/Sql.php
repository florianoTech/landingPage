<?php 
namespace LandingPage\Database;

/**
 * Class used to manage database
 *
 * @author Daniel Floriano	 
 */
class Sql {

	const HOSTNAME = "xxxxxx";
	const USERNAME = "xxxxxx";
	const PASSWORD = "xxxxxx";
	const DBNAME = "xxxxxx";

	private $conn;

	public function __construct() {
		$this->conn = new \PDO("mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME, Sql::USERNAME,Sql::PASSWORD);
	}
	
   /** 
    * Function used to define parameters in a query SQL
	*
    * @access public 
    * @param PDOStatement $statement	
    * @param array $parameters
    * @return void
    */ 
	private function setParams($statement, $parameters = []) {
		foreach ($parameters as $key => $value)
			$this->bindParam($statement, $key, $value);
	}
	
   /** 
    * Function used to define parameters in a query SQL
	*
    * @access public 
    * @param PDOStatement $statement	
    * @param string $key
	* @param string $value
    * @return void
    */ 	
	private function bindParam($statement, $key, $value) {
		$statement->bindParam($key, $value);
	}
	
   /** 
    * Function used to execute a query SQL (Except SELECT)
	*
    * @access public 
    * @param string $rawQuery	
    * @param array $params
    * @return void
    */ 
	public function query($rawQuery, $params = []) {
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
		return $stmt->execute();
	}
	
   /** 
    * Function used to execute a SELECT SQL command
	*
    * @access public 
    * @param string $rawQuery	
    * @param array $params
    * @return array
    */ 
	public function select($rawQuery, $params = []):array {
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
		$stmt->execute(); 
		
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}
?>