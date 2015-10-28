<?php

@session_start();

@require_once "../util/functionsLib.php";

if ($_POST && isset($_POST["sid"]) && loggedAsCompany()){
	
	@require_once "../to/Stand.class.php";
	@require_once "../business/StandBus.class.php";
	
	$redir = (isset($_POST["eid"])) ? "../view/stands.php?eid=".$_POST["eid"] : "../view/";
	
	$mktFile = null;
	if (isset($_FILES["iptMkt"]) && $_FILES["iptMkt"] != "") $mktFile = $_FILES["iptMkt"]["tmp_name"];
	
	if (@StandBus::setOwner($_POST["sid"], unserialize($_SESSION["objCompanyLogin"]), $mktFile)){
		$_SESSION["msg"] = "Congratulations ! You succesfully reserved the stand.";
		$_SESSION["msgType"] = "SUCESS";
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
