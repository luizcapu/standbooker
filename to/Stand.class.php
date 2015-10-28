<?php

@require_once "../to/Company.class.php";

class Stand {

    private $standId;
	private $eventId;
    private $objOwner;
    private $standNumber;
    private $corridor;
    private $price;
    
    function __construct() {
    	$this->objOwner = new Company();
    }

    public function setStandId($value){
    	$this->standId = $value;
    }

    public function getStandId(){
    	return $this->standId;
    }
    
    public function setEventId($value){
    	$this->eventId = $value;
    }

    public function getEventId(){
    	return $this->eventId;
    }

    public function setObjOwner($value){
    	$this->objOwner = $value;
    }
    
    public function getObjOwner(){
    	return $this->objOwner;
    }
    
    public function setStandNumber($value){
    	$this->standNumber = $value;
    }

    public function getStandNumber(){
    	return $this->standNumber;
    }

    public function setCorridor($value){
    	$this->corridor = $value;
    }

    public function getCorridor(){
    	return $this->corridor;
    }
    
    public function setPrice($value){
    	$this->price = $value;
    }
    
    public function getPrice(){
    	return $this->price;
    }
    
}
?>
