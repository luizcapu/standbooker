<?php

@session_start();

if ($_GET && isset($_GET["sid"])){	
	@require_once "../util/functionsLib.php";	
	@require_once "../util/ParametrosGerais.class.php";
	
	@require_once "../to/Stand.class.php";
	@require_once "../business/StandBus.class.php";
	@require_once "../to/Event.class.php";
	@require_once "../business/EventBus.class.php";
	
	$stand = @StandBus::getById($_GET["sid"]);

	if ($stand == null){
		$_SESSION["msg"] = "Stand not found";
		$_SESSION["msgType"] = "ERROR";
		@header("location: ../view/");
		exit();
	} else {		
		
		if (!loggedAsCompany()){
			$redir = codificaString("../view/standBook.php?sid=" . $_GET["sid"]);
			@header("location: ../view/loginCompany.php?r=$redir");
			exit();
		} else {
			@require_once "iniciaTemplate.php";
			
			$event = @EventBus::getById($stand->getEventId());
			$tpl->addFile("CONTEUDO", "html/standBook.html");
			
			$tpl->START_DATE = $event->getStartDate();
			$tpl->END_DATE = $event->getEndDate();
			$tpl->ADDRESS = $event->getAddress();
			$tpl->LOCATION_NAME = $event->getObjLocation()->getName();
			$tpl->COUNTRY_NAME = $event->getObjLocation()->getObjCountry()->getName();
			
			$tpl->STAND_NUMBER = $stand->getStandNumber();
			$tpl->CORRIDOR_NUMBER = $stand->getCorridor();
			$tpl->PRICE = $stand->getPrice();
			$tpl->STAND_ID = $stand->getStandId();
			$tpl->EVENT_ID = codificaString($event->getEventId());
				
			$tpl->BOOKER_NAME = $objLogin->getName();
			
			$tpl->COMPLEMENTO_TITULO_SITE = "Stand Book - " . $event->getName();
			
			
			$tpl->show();				
		}		
	}
	
} else {
	$_SESSION["msg"] = "Invalid request";
	$_SESSION["msgType"] = "ERROR";
	@header("location: ../view/");
	exit();
}

?>