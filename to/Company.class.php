<?php

class Company {

    private $companyId;
    private $name;
    private $email;
    private $phone;
    private $adminName;
    private $pass;
    
    function __construct() {
    }

    public function setCompanyId($value){
    	$this->companyId = $value;
    }

    public function getCompanyId(){
    	return $this->companyId;
    }

    public function setName($value){
    	$this->name = $value;
    }

    public function getName(){
    	return $this->name;
    }

    public function setEmail($value){
    	$this->email = $value;
    }

    public function getEmail(){
    	return $this->email;
    }
    
    public function setPhone($value){
    	$this->phone = $value;
    }
    
    public function getPhone(){
    	return $this->phone;
    }

    public function setAdminName($value){
    	$this->adminName = $value;
    }
    
    public function getAdminName(){
    	return $this->adminName;
    }
    
    public function setPass($value){
    	$this->pass = $value;
    }
    
    public function getPass(){
    	return $this->pass;
    }
    
}
?>
