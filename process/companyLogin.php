<?php

@session_start();

@require_once "../util/functionsLib.php";

if (loggedAsAttendee()){
	unset($_SESSION["objAttendeeLogin"]);
}

if (loggedAsCompany()){
	unset($_SESSION["objCompanyLogin"]);
}

@require_once "../to/Company.class.php";
@require_once "../business/CompanyBus.class.php";

if ($_POST){
	
	$reqURL = "../view/";
	if (isset($_POST["reqURL"]) && $_POST["reqURL"]!="")
		$reqURL = $_POST["reqURL"];
	
	$login   = "";
	$senha   = "";
	
	if (isset($_POST["iptEmailLogin"]) && $_POST["iptEmailLogin"]!="") $login = $_POST["iptEmailLogin"]; 
	if (isset($_POST["iptPassLogin"]) && $_POST["iptPassLogin"]!="") $senha = $_POST["iptPassLogin"];
	
	$loginObj = @CompanyBus::doLogin($login, $senha);

	if ($loginObj==null){
		
		$msg = isset($_SESSION["msg"]) ? $_SESSION["msg"] : null; 
		
		@session_start();
		@session_destroy();
		$_SESSION = array();
		
		@session_start();
		
		if ($msg==null)
			$_SESSION["msg"] = "Invalid user/pass";
		else
			$_SESSION["msg"] = $msg;
		
		$_SESSION["msgType"] = "ERROR";
	}else{
		$_SESSION["objCompanyLogin"] = serialize($loginObj);
	}
	
	@header("location: $reqURL");
	exit();	
}else{
	$_SESSION["msg"]     = "Invalid request.";
	$_SESSION["msgType"] = "ERROR";
	@header("location: ../admin/");
	exit();	
}
?>
