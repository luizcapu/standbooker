<?php
@session_start();

@require_once "../util/Template.class.php";
@require_once "../util/functionsLib.php";
@require_once "../util/calcDataHora.class.php";
@require_once "../util/ParametrosGerais.class.php";
@require_once "../to/Country.class.php";
@require_once "../to/Company.class.php";
//@require_once "../to/Attendee.class.php";

$tpl = new Template("html/template.html");

//-- INICIO EXIBE MENSAGEM DO SISTEMA --//
if (isset($_SESSION["msg"]) && ($_SESSION["msg"]!="")){

	$tpl->MENSAGEM_SISTEMA = $_SESSION["msg"];
	
	if ($_SESSION["msgType"] == "ERROR") $tpl->MSG_COLOR = "ab0f14";
	else $tpl->MSG_COLOR = "1E90FF";
	
	$tpl->parseBlock("BLOCK_SHOW_SYSTEM_MESSAGE");

	$_SESSION["msg"] = "";
} 	
//-- FIM EXIBE MENSAGEM DO SISTEMA --//

@require_once "../to/Admin.class.php";
@require_once "../util/functionsLib.php";

$pageName   = getPageName($_SERVER["REQUEST_URI"]);
$scriptName = getPageName($_SERVER["SCRIPT_NAME"]);

$tpl->JQ_VERSION = "-1.11.3.min";
if ($scriptName == "loginCompany.php") {
	$tpl->JQ_VERSION = "";
}

$objSelectedCountry = getSelectedCountry();

if (loggedAsCompany() || loggedAsAttendee()){
	if (loggedAsCompany()) {
		$objLogin = unserialize($_SESSION["objCompanyLogin"]);
	} else {
		$objLogin = unserialize($_SESSION["objAttendeeLogin"]);		
	}
	
	$tpl->USER_INFO_LOGIN = (loggedAsCompany()) ? "Logged as Company" : "Logged as Attendee";
	$tpl->USER_INFO_NOME = $objLogin->getName();
	$tpl->USER_INFO_EMAIL = $objLogin->getEmail();
	$tpl->parseBlock("BLOCK_LOGGED_IN");
} else {
	$tpl->USER_INFO_LOGIN = "Log in";
	$tpl->parseBlock("BLOCK_NOT_LOGGED_IN");
}

$tpl->parseBlock("BLOCK_SCRIPT_MENUS");
$tpl->parseBlock("BLOCK_MENU_PRINCIPAL");

if (!countrySelected()){
	@require_once "../view/selectCountry.php";
	exit();
}

?>