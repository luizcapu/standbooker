<?php

@require_once "../business/CountryBus.class.php";

if (!isset($tpl)){
	@require_once "iniciaTemplate.php";	
}

$tpl->addFile("CONTEUDO", "html/selectCountry.html");
$tpl->addFile("SCRIPT", "html/selectCountryScript.html");

$lstCountries = @CountryBus::listHavingEvents();

if (is_array($lstCountries) && count($lstCountries) > 0){
	
	$comma = "";
	foreach ($lstCountries as $c){
		$tpl->REGIONS_WITH_EVENTS .= $comma . "'". $c->getMapRef() . "'";
		if ($comma==""){
			$comma = ",";
		}
	}
	
	$tpl->parseBlock("BLOCK_AVAILABLE");
	$tpl->COMPLEMENTO_TITULO_SITE = "Let's Start ? Please, select a country to navigate";
}else{
	
	$tpl->parseBlock("BLOCK_NO_EVENTS");
	$tpl->COMPLEMENTO_TITULO_SITE = "Sorry :( There are not future events available.";
}


$tpl->show();
?>