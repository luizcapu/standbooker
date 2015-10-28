<?php
require_once "PreparedStatement.class.php";

class DBConnection {

	public $conn;

	public function __construct() {
		$this->conn = $this->getConnection();
	}

	private function getConnection() {
        $host = "127.0.0.1";
		$port = "5432";
		$db   = "booker";
		$user = "booker";
        $pass = "booker123";
        
		return pg_pconnect("host=$host port=$port dbname=$db user=$user password=$pass");
	}

	public function beginTransaction() {
		if ($this->execQuery("BEGIN TRANSACTION;")){
			return true;
		}else{
			$_SESSION["msg"]     = "Could not connect to database.";
			$_SESSION["msgType"] = "ERROR";
			return false;			
		}
	}

	public function commitTransaction() {
		if ($this->execQuery("COMMIT;")){
			return true;			
		}else{
			$_SESSION["msg"]     = "Could not commit transaction.";
			$_SESSION["msgType"] = "ERROR";
			return false;			
		}
	}

	public function rollBack() {
		if ($this->execQuery("ROLLBACK;")){
			return true;			
		}else{
			$_SESSION["msg"]     = "Could not rollback transaction.";
			$_SESSION["msgType"] = "ERROR";
			return false;			
		}
	}

	public function execQuery($sql) {
		return @pg_query($this->conn, $sql);
	}

	public function close() {
		pg_close($this->conn);
	}
    
    public function getStmt($sql){
        return new PreparedStatement($this, $sql);
    }
    
}
?>
