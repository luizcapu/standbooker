<?php

@require_once "../dao/StandDao.class.php";
@require_once "../util/DBConnection.class.php";

class StandBus {

    function __construct() {
    }

    public static function save($objStand){
    	
    	if ($objStand->getStandId() == null || $objStand->getStandId() == 0){
    		$conn = new DBConnection();
    		$dao  = new StandDao();
    		$ret = $dao->save($objStand, $conn);
    		$conn->close();    		
    	}else{
    		$_SESSION["msg"] = "Stand update is not implemented.";
    		return false;
    	}
    	
    	return true;
    }
	
    public static function getById($standId){
    	$conn = new DBConnection();
    	$dao  = new StandDao();
    	$ret  = $dao->getById($standId, $conn);
    	$conn->close();
    	 
    	return $ret;    	
    }
    
    public static function listByEventId($eventId){
    	$conn = new DBConnection();
    	$dao  = new StandDao();    	
    	$ret  = $dao->listByEventId($eventId, $conn);
    	$conn->close();
    	
    	return $ret;    	    	    	    	
    }

    public static function countRemainingByEventId($eventId){
    	$conn = new DBConnection();
    	$dao  = new StandDao();
    	$ret  = $dao->countRemainingByEventId($eventId, $conn);
    	$conn->close();
    	 
    	return $ret;
    }
    
    public static function setOwner($standId, $objCompany, $mktFile){
    	
    	$conn = new DBConnection();
    	$dao  = new StandDao();
    	 
    	if (!$conn->beginTransaction()){
    		$conn->close();
    		return false;
    	}
    	 
    	if ($dao->setOwner($standId, $objCompany->getCompanyId(), $conn)) {
    		if ($mktFile != null){
    			$uploadDir = "../stand_mkt/".$standId;
    			// TODO hardcoded PDF format
    			$fileName  = "mkt.pdf";
    			$pathMktFile  = $uploadDir."/".$fileName;
    	
    			if (!is_dir($uploadDir)){
    				if (!mkdir("$uploadDir", 0777)) return false;
    			}
    	
    			if (is_dir($uploadDir)){
    	
    				if (!@move_uploaded_file($mktFile, $pathMktFile)){
    					$conn->rollBack();
    					$conn->close();
    					return false;
    				}
    	
    			}else{
    				$conn->rollBack();
    				$conn->close();
    				return false;
    			}
    		}
    		 
    		if (!$conn->commitTransaction()){
    			$conn->rollBack();
    			$conn->close();
    			return false;
    		}
    	
    		return true;
    	} else {
    		$conn->rollBack();
    		$conn->close();
    		return false;
    	}    	 
    	
    }
    
}
?>