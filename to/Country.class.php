<?php

class Country {

    private $countryId;
    private $name;
    private $mapRef;

    function __construct() {
    }

    public function setCountryId($value){
    	$this->countryId = $value;
    }

    public function getCountryId(){
    	return $this->countryId;
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
