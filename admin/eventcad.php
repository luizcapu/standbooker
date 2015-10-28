<?php

@session_start();
//@require_once "../business/EventBus.class.php";
//@require_once "../to/Event.class.php";

@require_once "../business/CountryBus.class.php";
@require_once "../to/Country.class.php";

@require_once "iniciaTemplate.php";

$tpl->addFile("CONTEUDO", "html/eventcad.html");
$tpl->addFile("SCRIPT", "html/eventcadScript.html");

$id = 0;
$objCad = null;

if (isset($_SESSION["objCadEvent"])) {
	
	$objCad = unserialize($_SESSION["objCadEvent"]);
	unset($_SESSION["objCadEvent"]);
	
}else{
	if ($_GET && isset($_GET["id"]) && is_numeric(decodificaString($_GET["id"]))){
		$id = decodificaString($_GET["id"]);
		
		$objCad = @EventBus :: getById($id);	
	}	
}


//if ($objCad==null) $objCad = new Event();

//$tpl->ID_EVENT     = codificaString($objCad->getEventId());

$lstCountries = @CountryBus::listAll();

if (is_array($lstCountries) && count($lstCountries) > 0){
	foreach($lstCountries as $c){
	
		$tpl->UI_COUNTRY_ID    = $c->getCountryId();
		$tpl->UI_COUNTRY_NAME  = $c->getName();
	
		$tpl->parseBlock("BLOCK_COUNTRY_OPT", true);
	}
}

if ($objCad != null && $objCad->getEventId() > 0){
	/*
	$tpl->UI_LOGIN = $objCad->getLogin();
	$tpl->UI_EMAIL = $objCad->getEmail();
	$tpl->UI_NOME  = $objCad->getName();
	*/

	$tpl->ACAO_CAD = "Edit";
	$tpl->parseBlock("BLOCK_UNIMPLEMENTED");
}else{
	
	$tpl->ACAO_CAD = "Add new";
	$tpl->parseBlock("BLOCK_FORM_EVENT");
}

$tpl->COMPLEMENTO_TITULO_SITE = $tpl->ACAO_CAD." event";

$tpl->show();
?>