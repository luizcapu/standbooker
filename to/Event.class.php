<?php

@require_once "../to/Location.class.php";

class Event {

    private $eventId;
    private $objLocation;
    private $name;
    private $startDate;
    private $endDate;
    private $address;
    private $details;
    
    function __construct() {
    	$this->objLocation = new Location();
    }

    public function setEventId($value){
    	$this->eventId = $value;
    }

    public function getEventId(){
    	return $this->eventId;
    }

    public function setObjLocation($value){
    	$this->objLocation = $value;
    }
    
    public function getObjLocation(){
    	return $this->objLocation;
    }
    
    public function setName($value){
    	$this->name = $value;
    }

    public function getName(){
    	return $this->name;
    }

    public function setStartDate($value){
    	$this->startDate = $value;
    }

    public function getStartDate(){
    	return $this->startDate;
    }
    
    public function setEndDate($value){
    	$this->endDate = $value;
    }
    
    public function getEndDate(){
    	return $this->endDate;
    }

    public function setAddress($value){
    	$this->address = $value;
    }
    
    public function getAddress(){
    	return $this->address;
    }

    public function setDetails($value){
    	$this->details = $value;
    }
    
    public function getDetails(){
    	return $this->details;
    }
    
}
?>
