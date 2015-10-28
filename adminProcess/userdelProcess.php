<?php
@header('Content-type: text/html; charset=iso-8859-1');
@session_start();

@require_once "../util/verificaAdmin.php";

@require_once "../to/Admin.class.php";
@require_once "../business/AdminBus.class.php";

if ($_POST){
	
	$id = "";
	if ((isset($_POST["id"])) && ($_POST["id"] != "")) $id = decodificaString($_POST["id"]);            
	
	if 	($id!="" &&
		@AdminBus :: deleteById($id)){
		$_SESSION["msg"]     = "Record was deleted.";
		$_SESSION["msgType"] = "SUCESS";
	}else{
		if ($_SESSION["msg"]=="")
			$_SESSION["msg"]     = "Got errors processing your request.";
			
		$_SESSION["msgType"] = "ERROR";		
	}
	
	@header("location: ../admin/userlist.php");
	exit();
		
}else{
	$_SESSION["msg"]     = "Invalid request.";			
	$_SESSION["msgType"] = "ERROR";	
	@header("location: ../admin/");							
	exit();
}

?>