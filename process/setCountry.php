<?php

@header('Content-type: text/html; charset=iso-8859-1');
@session_start();

@require_once "../to/Country.class.php";
@require_once "../business/CountryBus.class.php";
@require_once "../util/functionsLib.php";

if (countrySelected()){
	unset($_SESSION["objCurrentCountry"]);	
}

if ($_POST){
	
	$mapRef = -1;
	if ((isset($_POST["selCountry"])) && ($_POST["selCountry"] != "")) $mapRef = $_POST["selCountry"]; 
	
	$objCountry = CountryBus::getByMapRef($mapRef);
	
	if ($objCountry == null){
		if (!isset($_SESSION["msg"]) || $_SESSION["msg"]=="")
			$_SESSION["msg"]     = "Country not found.";			
		$_SESSION["msgType"] = "ERROR";		
	}else{
		$_SESSION["objCurrentCountry"] = serialize($objCountry);
	}
	
}else{
	$_SESSION["msg"]     = "Invalid request.";			
	$_SESSION["msgType"] = "ERROR";	
}

@header("location: ../view/");
exit();

?>
