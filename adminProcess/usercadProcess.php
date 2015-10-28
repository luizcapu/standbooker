<?php
@header('Content-type: text/html; charset=iso-8859-1');
@session_start();

@require_once "../util/verificaAdmin.php";

@require_once "../to/Admin.class.php";
@require_once "../business/AdminBus.class.php";

if ($_POST){

	$obj = new Admin();
		
	if ((isset($_POST["id"])) && ($_POST["id"] != "")) $obj->setAdminId(decodificaString($_POST["id"]));            
	if ((isset($_POST["iptNome"])) && ($_POST["iptNome"] != "")) $obj->setName($_POST["iptNome"]);            
	if ((isset($_POST["iptEmail"])) && ($_POST["iptEmail"] != "")) $obj->setEmail($_POST["iptEmail"]);            
	if ((isset($_POST["iptLogin"])) && ($_POST["iptLogin"] != "")) $obj->setLogin($_POST["iptLogin"]);            
	if ((isset($_POST["iptNewPass"])) && ($_POST["iptNewPass"] != "")) $obj->setPass($_POST["iptNewPass"]);
	
	if (@AdminBus :: save($obj)){
		$_SESSION["msg"]     = "Account successfully saved.";
		$_SESSION["msgType"] = "SUCESS";
		@header("location: ../admin/userlist.php");
		exit();
	}else{
		if ($_SESSION["msg"]=="")
			$_SESSION["msg"]     = "Got errors processing your request.";
			
		$_SESSION["msgType"] = "ERROR";
		
		@header("location: ../admin/usercad.php");
		exit();
	}
	
}else{
	$_SESSION["msg"]     = "Invalid request.";			
	$_SESSION["msgType"] = "ERROR";	
	@header("location: ../admin/");							
	exit();
}

?>