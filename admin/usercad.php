<?php

@session_start();
@require_once "../business/AdminBus.class.php";
@require_once "../to/Admin.class.php";

@require_once "iniciaTemplate.php";

$tpl->addFile("CONTEUDO", "html/usercad.html");
$tpl->addFile("SCRIPT", "html/usercadScript.html");

$id = 0;
$objCad = null;

if (isset($_SESSION["objCadAdmin"])) {
	
	$objCad = unserialize($_SESSION["objCadAdmin"]);
	unset($_SESSION["objCadAdmin"]);
	
}else{
	if ($_GET && isset($_GET["id"]) && is_numeric(decodificaString($_GET["id"]))){
		$id = decodificaString($_GET["id"]);
		
		$objCad = @AdminBus :: getById($id);	
	}	
}


if ($objCad==null) $objCad = new Admin();

$tpl->ID_ADMIN     = codificaString($objCad->getAdminId());

if ($objCad->getAdminId() > 0){
	
	$tpl->UI_LOGIN = $objCad->getLogin();
	$tpl->UI_EMAIL = $objCad->getEmail();
	$tpl->UI_NOME  = $objCad->getName();

	$tpl->ACAO_CAD = "Edit";
}else{
	
	$tpl->parseBlock("BLOCK_PASS_RULES");
	$tpl->parseBlock("BLOCK_PASS_MSGS");
	$tpl->parseBlock("BLOCK_NEW_USER_PASS");
		
	$tpl->ACAO_CAD = "Add new";
}

$tpl->COMPLEMENTO_TITULO_SITE = $tpl->ACAO_CAD." account";

$tpl->show();
?>