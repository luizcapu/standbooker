<?php

@require_once "../dao/AdminDao.class.php";
@require_once "../util/DBConnection.class.php";

class AdminBus {

    function __construct() {
    }
    
    public static function doLogin($login, $senha){
    	
    	$loginObj = @AdminBus::getByLogin($login);
    	
    	if ($loginObj==null)
    		return null;
		
    	if (@AdminBus::checkCurrentPass($loginObj->getAdminId(), $senha)){
    		$loginObj->setPass("");
			return $loginObj;    		
    	}else{
    		return null;    		
    	}    	
    }
    
    public static function listAll(){
    	$conn = new DBConnection();
    	$dao  = new AdminDao();    	
    	$ret  = $dao->listAll($conn);
    	$conn->close();
    	
    	return $ret;    	    	    	    	
    }
    
    public static function save($obj){
    	$conn = new DBConnection();
    	$dao  = new AdminDao();    	
    	$ret  = $dao->save($obj, $conn);
    	$conn->close();
    	
    	return $ret;    	    	    	
    }
    
    public static function getByLogin($login){
    	$conn = new DBConnection();
    	$dao  = new AdminDao();    	
    	$id   = $dao->getIdByLogin($login, $conn);
    	$conn->close();

    	if ($id<=0)
    		return null;
    	
    	return @AdminBus::getById($id);    	    	
    }
    
    public static function getById($id){
    	$conn = new DBConnection();
    	$dao  = new AdminDao();    	
    	$ret  = $dao->getById($id, $conn);
    	$conn->close();

    	return $ret;
    }
    
    public static function deleteById($id){
    	$conn = new DBConnection();
    	$dao  = new AdminDao();    	
    	$ret  = $dao->deleteById($id, $conn);
    	$conn->close();

    	return $ret;
    }
    
    public static function checkCurrentPass($idAdmin, $pass){
    	$conn = new DBConnection();
    	$dao  = new AdminDao();    	
    	$ret = $dao->checkCurrentPass($idAdmin, $pass, $conn);
    	$conn->close();
    	
    	return $ret;    	
    }
        
    public static function changePass($idAdmin, $actualPass, $newPass, $passConfirm){
		
		$actualPass=trim($actualPass);
		$newPass=trim($newPass);
		$passConfirm=trim($passConfirm);
		    	
    	if ($actualPass=="" || $newPass=="" || $passConfirm==""){
    		$_SESSION["msg"] = "Fields current pass, new pass and pass confirmation are required.";
    		return false;    		
    	}
		    
    	if ($newPass!=$passConfirm){
    		$_SESSION["msg"] = "New pass do not match with pass confirmation.";
    		return false;    		
    	}
    	
    	$conn = new DBConnection();
    	$dao  = new AdminDao();
    	
    	if (!$dao->checkCurrentPass($idAdmin, $actualPass, $conn)){
    		$_SESSION["msg"] = "Wrong current pass.";
    		$conn->close();
    		return false;
    	}
    	
    	$ret  = $dao->changePass($idAdmin, $newPass, $conn);
    	$conn->close();
    	
    	return $ret;    	
    }
}
?>