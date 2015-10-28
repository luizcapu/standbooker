<?php

@require_once "../dao/CompanyDao.class.php";
@require_once "../util/DBConnection.class.php";

class CompanyBus {

    function __construct() {
    }
    
    public static function doLogin($email, $senha){
    	
    	$loginObj = @CompanyBus::getByEmail($email);
    	
    	if ($loginObj==null)
    		return null;
		
    	if (@CompanyBus::checkCurrentPass($loginObj->getCompanyId(), $senha)){
    		$loginObj->setPass("");
			return $loginObj;    		
    	}else{
    		return null;    		
    	}    	
    }
    
    public static function listAll(){
    	$conn = new DBConnection();
    	$dao  = new CompanyDao();    	
    	$ret  = $dao->listAll($conn);
    	$conn->close();
    	
    	return $ret;    	    	    	    	
    }
    
    public static function save($obj, $logoFile=null){
    	$conn = new DBConnection();
    	$dao  = new CompanyDao();
    	
    	if (!$conn->beginTransaction()){
    		$conn->close();
    		return false;
    	}
    	
    	if ($dao->save($obj, $conn)) {
    		if ($logoFile != null){
    			$uploadDir = "../company_logos/".$obj->getCompanyId();
    			// TODO hardcoded JPG format
    			$fileName  = "logo.jpg";
    			$pathFoto  = $uploadDir."/".$fileName;
    		
    			if (!is_dir($uploadDir)){
    				if (!mkdir("$uploadDir", 0777)) return false;
    			}
    		
    			if (is_dir($uploadDir)){
    		
    				if (!@move_uploaded_file($logoFile, $pathFoto)){
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
    
    public static function getByEmail($login){
    	$conn = new DBConnection();
    	$dao  = new CompanyDao();    	
    	$id   = $dao->getIdByEmail($login, $conn);
    	$conn->close();

    	if ($id<=0)
    		return null;
    	
    	return @CompanyBus::getById($id);    	    	
    }
    
    public static function getById($id){
    	$conn = new DBConnection();
    	$dao  = new CompanyDao();    	
    	$ret  = $dao->getById($id, $conn);
    	$conn->close();

    	return $ret;
    }
    
    public static function deleteById($id){
    	$conn = new DBConnection();
    	$dao  = new CompanyDao();    	
    	$ret  = $dao->deleteById($id, $conn);
    	$conn->close();

    	return $ret;
    }
    
    public static function checkCurrentPass($idCompany, $pass){
    	$conn = new DBConnection();
    	$dao  = new CompanyDao();    	
    	$ret = $dao->checkCurrentPass($idCompany, $pass, $conn);
    	$conn->close();
    	
    	return $ret;    	
    }
        
    public static function changePass($idCompany, $actualPass, $newPass, $passConfirm){
		
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
    	$dao  = new CompanyDao();
    	
    	if (!$dao->checkCurrentPass($idCompany, $actualPass, $conn)){
    		$_SESSION["msg"] = "Wrong current pass.";
    		$conn->close();
    		return false;
    	}
    	
    	$ret  = $dao->changePass($idCompany, $newPass, $conn);
    	$conn->close();
    	
    	return $ret;    	
    }
}
?>