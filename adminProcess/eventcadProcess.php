<?php

@header('Content-type: text/html; charset=iso-8859-1');
@session_start();

@require_once "../util/verificaAdmin.php";

@require_once "../to/Event.class.php";
@require_once "../business/EventBus.class.php";

if ($_POST){

	$objEvent = new Event();	
	if ((isset($_POST["iptName"])) && ($_POST["iptName"] != "")) $objEvent->setName($_POST["iptName"]); 
	if ((isset($_POST["selLocation"])) && ($_POST["selLocation"] != "")) $objEvent->getObjLocation()->setLocationId($_POST["selLocation"]);
	if ((isset($_POST["iptAddress"])) && ($_POST["iptAddress"] != "")) $objEvent->setAddress($_POST["iptAddress"]);
	if ((isset($_POST["iptFrom"])) && ($_POST["iptFrom"] != "")) $objEvent->setStartDate($_POST["iptFrom"]);
	if ((isset($_POST["iptTo"])) && ($_POST["iptTo"] != "")) $objEvent->setEndDate($_POST["iptTo"]);
	if ((isset($_POST["txtDetails"]))) $objEvent->setDetails($_POST["txtDetails"]);
	
	if (@EventBus :: save($objEvent, $_POST["iptStandPerCorridor"], $_POST["iptNoCorridors"], $_POST["iptStandPrice"])){
		$_SESSION["msg"]     = "Event succesfully saved.";
		$_SESSION["msgType"] = "SUCESS";
		@header("location: ../admin/eventlist.php");
		exit();
	}else{
		if (!isset($_SESSION["msg"]) || $_SESSION["msg"]=="")
			$_SESSION["msg"]     = "Got errors processing your request.";
			
		$_SESSION["msgType"] = "ERROR";

		@header("location: ../admin/eventcad.php");							
		exit();
	}
	
}else{
	$_SESSION["msg"]     = "Invalid request.";			
	$_SESSION["msgType"] = "ERROR";	
	@header("location: ../admin/");							
	exit();
}

?>