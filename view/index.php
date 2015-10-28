<?php

@session_start();
@require_once "../util/functionsLib.php";
@require_once "../util/ParametrosGerais.class.php";

@require_once "iniciaTemplate.php";

@require_once "../to/Location.class.php";
@require_once "../business/LocationBus.class.php";

$tpl->addFile("CONTEUDO", "html/index.html");
$tpl->addFile("SCRIPT", "html/indexScript.html");

$tpl->MAP_REF = strtolower($objSelectedCountry->getName());

$tpl->REGIONS_WITH_EVENTS = "";
$lstLocations = @LocationBus::listHavingEventsByCountry($objSelectedCountry->getCountryId());

if (is_array($lstLocations) && count($lstLocations) > 0){
	$comma = "";
	foreach($lstLocations as $l){
		$tpl->REGIONS_WITH_EVENTS .= $comma . "'". $l->getMapRef() . "'";
		if ($comma==""){
			$comma = ",";
		}
	}
}

$tpl->COMPLEMENTO_TITULO_SITE = "Select a location in ". $objSelectedCountry->getName() . " map to see events";

$tpl->show();
?>
