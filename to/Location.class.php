<?php

@require_once "../to/Country.class.php";

class Location {

    private $locationId;
    private $objCountry;
    private $name;
    private $mapRef;

    function __construct() {
    	$this->objCountry = new Country();
    }

    public function setLocationId($value){
    	$this->locationId = $value;
    }

    public function getLocationId(){
    	return $this->locationId;
    }

    public function getObjCountry(){
    	return $this->objCountry;
    }
    
    public function setName($value){
    	$this->name = $value;
    }

    public function getName(){
    	return $this->name;
    }

    public function setMapRef($value){
    	$this->mapRef = $value;
    }

    public function getMapRef(){
    	return $this->mapRef;
    }
}
?>
