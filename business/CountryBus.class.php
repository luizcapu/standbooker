<?php

@require_once "../dao/CountryDao.class.php";
@require_once "../util/DBConnection.class.php";

class CountryBus {

    function __construct() {
    }
    
    public static function listAll(){
    	$conn = new DBConnection();
    	$dao  = new CountryDao();    	
    	$ret  = $dao->listAll($conn);
    	$conn->close();
    	
    	return $ret;    	    	    	    	
    }

    public static function getById($id){
    	$conn = new DBConnection();
    	$dao  = new CountryDao();
    	$ret  = $dao->getById($id, $conn);
    	$conn->close();
    	 
    	return $ret;
    }
    
    public static function getByMapRef($mapRef){
    	$conn = new DBConnection();
    	$dao  = new CountryDao();
    	$ret  = $dao->getByMapRef($mapRef, $conn);
    	$conn->close();
    	
    	return $ret;    	
    }

    public static function listHavingEvents(){
    	$conn = new DBConnection();
    	$dao  = new CountryDao();
    	$ret  = $dao->listHavingEvents($conn);
    	$conn->close();
    
    	return $ret;
    }
    
}
?>