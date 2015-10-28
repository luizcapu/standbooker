<?php

@session_start();

if ($_POST){
	
	@require_once "../to/Company.class.php";
	@require_once "../business/CompanyBus.class.php";
	
	$redir = "../view/";
	if (isset($_POST["reqURL"]) && $_POST["reqURL"] != "") $redir = $_POST["reqURL"]; 
	
	$company = new Company();

	if (isset($_POST["iptName"]) && $_POST["iptName"] != "") $company->setName($_POST["iptName"]);
	if (isset($_POST["iptEmail"]) && $_POST["iptEmail"] != "") $company->setEmail($_POST["iptEmail"]);
	if (isset($_POST["iptAdmin"]) && $_POST["iptAdmin"] != "") $company->setAdminName($_POST["iptAdmin"]);
	if (isset($_POST["iptPhone"]) && $_POST["iptPhone"] != "") $company->setPhone($_POST["iptPhone"]);
	if (isset($_POST["iptPass"]) && $_POST["iptPass"] != "") $company->setPass($_POST["iptPass"]);
	
	$logoFile = null;
	if (isset($_FILES["iptLogo"]) && $_FILES["iptLogo"] != "") $logoFile = $_FILES["iptLogo"]["tmp_name"];
	
	if (CompanyBus::save($company, $logoFile)){
		$_SESSION["msg"] = "Welcome to StandBooker !";
		$_SESSION["msgType"] = "SUCESS";
		
		$company->setPass("");
		$_SESSION["objCompanyLogin"] = serialize($company);
	} else {
		$_SESSION["msg"] = "Got errors creating your account. Please, try again.";
		$_SESSION["msgType"] = "ERROR";
	}
	
	@header("location: $redir");
	exit();
} else {
	$_SESSION["msg"] = "Invalid request";
	$_SESSION["msgType"] = "ERROR";
	@header("location: ../view/");
	exit();
}

?>