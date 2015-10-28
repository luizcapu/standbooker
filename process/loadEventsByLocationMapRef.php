<?php 

@header('Content-type: text/html; charset=iso-8859-1');

@session_start();

if ($_POST){

	@require_once "../util/Template.class.php";
	@require_once "../util/functionsLib.php";
	@require_once "../util/calcDataHora.class.php";
	@require_once "../util/ParametrosGerais.class.php";
	@require_once "../business/LocationBus.class.php";
	@require_once "../to/Location.class.php";
	@require_once "../business/EventBus.class.php";
	@require_once "../to/Event.class.php";
	@require_once "../business/StandBus.class.php";
	
	$tpl = new Template("../view/html/events.html");
	
	$objLocation = isset ($_POST["mapRef"]) ? LocationBus::getByMapRef($_POST["mapRef"]) : null;	
	if ($objLocation == null){
		$tpl->parseBlock("BLOCK_NO_EVENTS");	
	} else {
		$events = EventBus::listByLocationId($objLocation->getLocationId(), true);
		
		if (is_array($events) && count($events) > 0){
			
			$tpl->LOCATION_NAME = $objLocation->getName();
			
			foreach ($events as $e){
				
				$tpl->EVENT_NAME = $e->getName();
				$tpl->START_DATE = $e->getStartDate();
				$tpl->END_DATE = $e->getEndDate();
				$tpl->ADDRESS = $e->getAddress();
				$tpl->DETAILS = nl2br($e->getDetails());
				$tpl->EVENT_ID = codificaString($e->getEventId());
				
				if (StandBus::countRemainingByEventId($e->getEventId()) > 0) {
					$tpl->parseBlock("BLOCK_BOOK_BUTTON");
				}
				
				$tpl->parseBlock("BLOCK_EVENT", true);
			}
		
			$tpl->parseBlock("BLOCK_EVENTS");
		}else {
			$tpl->parseBlock("BLOCK_NO_EVENTS");
		}
	}
	
	
	$tpl->show();
	
} else {
	echo "Invalid request";
}


?>