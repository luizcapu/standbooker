<?php

require_once "functionsLib.php";

class PreparedStatement {

    private $sql;
    private $tipos;
    private $valores;
    private $conn;
    private $existeStmt;

    function __construct($conn, $sql) {
        $this->conn = $conn;
        $this->sql = $sql;
        $this->tipos = array();
        $this->valores = array();
        $this->existeStmt = false;
    }

    function execStmt() {
        if (count($this->valores) > 0) { 
            if (!$this->existeStmt) {
                ksort($this->tipos);    
                $tipos = implode(",", $this->tipos);
                $sql = "PREPARE stmt ($tipos) AS " . $this->sql . ";";
                $this->conn->execQuery($sql);
                $this->existeStmt = true;
            }
            ksort($this->valores);
            $valores = implode(",", $this->valores);
            $sql = "EXECUTE stmt ($valores);";
            return $this->conn->execQuery($sql);
        } else {
            return $this->conn->execQuery($this->sql);
        }
    }

    function setString($pos, $value){

        if (isEmpty($value)) {
    		$this->valores[$pos] = "null";
    	} else {
        	if (get_magic_quotes_gpc()){
	            $value = stripslashes($value);
        	}
        	$value = pg_escape_string($value);
        	$value = "'$value'";
    	    $value = (string) $value;
	        $this->valores[$pos] = $value;
    	}
        $this->tipos[$pos] = "text"; 
    }
    
    function setInt($pos, $value){
        if (isEmpty($value)) {
    		$this->valores[$pos] = "null";
    	} else {
    		$this->valores[$pos] = (int) $value;
    	}
        $this->tipos[$pos] = "int";
    }
    
    function setBoolean($pos, $value){
        $this->valores[$pos] = boolToString((bool) $value);
        $this->tipos[$pos] = "boolean";
    }
    
    function setIfInt($pos, $value){
    	if (isEmpty($value)) {
    		$this->valores[$pos] = "null";
    	} else {
    		$this->valores[$pos] = (int) $value;
    	}
        $this->tipos[$pos] = "int";
    }
    
    function setFloat($pos, $value){
    	if (isEmpty($value)) {
    		$this->valores[$pos] = "null";
    	} else {
    		$this->valores[$pos] = (float) $value;
    	}
        
        $this->tipos[$pos] = "float";
    }

    function close(){
        if (count($this->valores) > 0)
            $this->conn->execQuery("DEALLOCATE stmt;");
    }
}
?>