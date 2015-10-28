<?php

class ExcelStruct {
	
	private $title;
	private $cols;
	private $data;
	
    function __construct() {
    	$this->cols = array();
    	$this->data = array();
    }
    
    public function setCols($value){
    	$this->cols = $value;
    }

    public function getCols(){
    	return $this->cols;
    }
    
    public function setData($value){
    	$this->data = $value;
    }

    public function getData(){
    	return $this->data;
    }
    
    public function setTitle($value){
    	$this->title = $value;
    }

    public function getTitle(){
    	return $this->title;
    }
    
}
?>