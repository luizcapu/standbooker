<?php
@session_start();

@require_once "../util/Template.class.php";
@require_once "../util/functionsLib.php";
@require_once "../util/calcDataHora.class.php";
@require_once "../util/ParametrosGerais.class.php";

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

if (adminLogado()){
	$objAdminLogin = unserialize($_SESSION["objAdminLogin"]);

	$tpl->USER_INFO_LOGIN = $objAdminLogin->getLogin(); 
	$tpl->USER_INFO_NOME  = $objAdminLogin->getName();
	$tpl->USER_INFO_EMAIL = $objAdminLogin->getEmail();
	$tpl->USER_INFO_ID    = codificaString($objAdminLogin->getAdminId());
	
	$tpl->parseBlock("BLOCK_SCRIPT_MENUS");
	
	if ($scriptName!="index.php")
		$tpl->parseBlock("BLOCK_METRO_MENU");
		
	$tpl->parseBlock("BLOCK_MENU_PRINCIPAL");
	
	
}else{
	$tpl->COMPLEMENTO_TITULO_SITE = "Login";
		
	$tpl->addFile("CONTEUDO", "html/login.html");
	$tpl->addFile("SCRIPT", "html/loginScript.html");
	
	$tpl->LOGIN_REQ_URL = codificaString($_SERVER["REQUEST_URI"]);
	
	$tpl->show();
	exit();
}
?>