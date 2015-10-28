<?php

@require_once "../dao/EventDao.class.php";
@require_once "../dao/StandDao.class.php";
@require_once "../util/DBConnection.class.php";
@require_once "../util/Mailer.class.php";
@require_once "../to/Stand.class.php";

class EventBus {

    function __construct() {
    }

    public static function save($objEvent, $standsPerCorridor, $numOfCorridors, $defaultStandPrice){
    	
    	if ($objEvent->getEventId() == null || $objEvent->getEventId() == 0){
    		$conn = new DBConnection();
			
    		if (!$conn->beginTransaction()){
    			$conn->close();
    			return false;
    		}
    		
    		$dao  = new EventDao();
    		$standDao = new StandDao();
    		
    		if (!$dao->save($objEvent, $conn)){
    			$conn->rollBack();
    			$conn->close();
    			return false;    			
    		}
    		
    		
    		$objStand = new Stand();
    		$objStand->setEventId($objEvent->getEventId());
    		$objStand->setPrice($defaultStandPrice);
    		$objStand->setStandNumber(0);
    		
    		for ($corridor=1; $corridor <= $numOfCorridors; $corridor++){
    			$objStand->setCorridor($corridor);
    			
    			for ($n=1; $n <= $standsPerCorridor; $n++){
    				$objStand->setStandId(null);
    				$objStand->setStandNumber( $objStand->getStandNumber() + 1);
    				
    				if (!$standDao->save($objStand, $conn)){
    					$conn->rollBack();
    					$conn->close();
    					return false;    						
    				}
    			}
    		}
    		
    		if (!$conn->commitTransaction()){
    			$conn->rollBack();
    			$conn->close();
    			return false;
    		}
    		
    		$conn->close();    		
    	}else{
    		$_SESSION["msg"] = "Event update is not implemented.";
    		return false;
    	}
    	
    	return true;
    }

    public static function getById($eventId){
    	$conn = new DBConnection();
    	$dao  = new EventDao();
    	$ret  = $dao->getById($eventId, $conn);
    	$conn->close();
    	 
    	return $ret;
    }
    
    public static function listAll(){
    	$conn = new DBConnection();
    	$dao  = new EventDao();
    	$ret  = $dao->listAll($conn);
    	$conn->close();
    	 
    	return $ret;
    }
    
    public static function listByLocationId($locationId, $futures=false){
    	$conn = new DBConnection();
    	$dao  = new EventDao();    	
    	$ret  = $dao->listByLocationId($locationId, $futures, $conn);
    	$conn->close();
    	
    	return $ret;    	    	    	    	
    }
    
}
?>