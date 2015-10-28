<?php

@session_start();

@require_once "../util/functionsLib.php";

if (@adminLogado()){
	$_SESSION["msg"]     = "You must logout before try to login.";
	$_SESSION["msgType"] = "ERROR";	
	@header("location: ../admin/");
	exit();
}

@session_destroy();
$_SESSION = array();

@session_start();

@require_once "../to/Admin.class.php";
@require_once "../business/AdminBus.class.php";

if ($_POST){
	
	$reqURL = "../admin/";
	if (isset($_POST["reqURL"]) && $_POST["reqURL"]!="")
		$reqURL = decodificaString($_POST["reqURL"]);
	
	$login   = "";
	$senha   = "";
	
	if (isset($_POST["iptLogin"]) && $_POST["iptLogin"]!="") $login = $_POST["iptLogin"]; 
	if (isset($_POST["iptSenha"]) && $_POST["iptSenha"]!="") $senha = $_POST["iptSenha"];
	
	$loginObj = @AdminBus::doLogin($login, $senha);

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
		$_SESSION["objAdminLogin"] = serialize($loginObj);
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
