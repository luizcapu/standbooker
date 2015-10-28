<?php

@header('Content-type: text/html; charset=iso-8859-1');
@session_start();

@require_once "../util/verificaAdmin.php";

@require_once "../to/Admin.class.php";
@require_once "../business/AdminBus.class.php";

if ($_POST){

	$actual  = "";
	$new     = "";
	$confirm = "";
	
	if ((isset($_POST["iptActual"])) && ($_POST["iptActual"] != ""))           $actual = $_POST["iptActual"]; 
	if ((isset($_POST["iptNewPass"])) && ($_POST["iptNewPass"] != ""))         $new = $_POST["iptNewPass"];
	if ((isset($_POST["iptConfirmPass"])) && ($_POST["iptConfirmPass"] != "")) $confirm = $_POST["iptConfirmPass"];

	if (@AdminBus :: changePass($objAdminLogin->getAdminId(), $actual, $new, $confirm)){
		$_SESSION["msg"]     = "Password succesfully changed.";
		$_SESSION["msgType"] = "SUCESS";
		@header("location: ../admin/changepass.php");
		exit();
	}else{
		if ($_SESSION["msg"]=="")
			$_SESSION["msg"]     = "Got errors processing your request.";
			
		$_SESSION["msgType"] = "ERROR";
		
		@header("location: ../admin/changepass.php");							
		exit();
	}
	
}else{
	$_SESSION["msg"]     = "Invalid request.";			
	$_SESSION["msgType"] = "ERROR";	
	@header("location: ../admin/");							
	exit();
}

?>