<?php

class Admin {

    private $adminId;
    private $login;
    private $name;
    private $email;
    private $pass;

    function __construct() {
    }

    public function setAdminId($value){
    	$this->adminId = $value;
    }

    public function getAdminId(){
    	return $this->adminId;
    }

    public function setLogin($value){
    	$this->login = $value;
    }

    public function getLogin(){
    	return $this->login;
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

    public function setPass($value){
    	$this->pass = $value;
    }

    public function getPass(){
    	return $this->pass;
    }
}
?>
