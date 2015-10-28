<?php

@require_once "../dao/LocationDao.class.php";
@require_once "../util/DBConnection.class.php";

class LocationBus {

    function __construct() {
    }
    
    public static function listByCountryId($countryId){
    	$conn = new DBConnection();
    	$dao  = new LocationDao();    	
    	$ret  = $dao->listByCountryId($countryId, $conn);
    	$conn->close();
    	
    	return $ret;    	    	    	    	
    }

    public static function getByMapRef($mapRef){
    	$conn = new DBConnection();
    	$dao  = new LocationDao();
    	$ret  = $dao->getByMapRef($mapRef, $conn);
    	$conn->close();
    	 
    	return $ret;
    }
    
    public static function listHavingEventsByCountry($countryId){
    	$conn = new DBConnection();
    	$dao  = new LocationDao();
    	$ret  = $dao->listHavingEventsByCountry($countryId, $conn);
    	$conn->close();
    
    	return $ret;
    }
    
}
?>