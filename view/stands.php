<?php

@session_start();

if ($_GET && isset($_GET["eid"])){	
	@require_once "../util/functionsLib.php";	
	@require_once "../util/ParametrosGerais.class.php";
	
	@require_once "../to/Stand.class.php";
	@require_once "../business/StandBus.class.php";
	@require_once "../to/Event.class.php";
	@require_once "../business/EventBus.class.php";
	
	$eid = decodificaString($_GET["eid"]);
	$event = EventBus::getById($eid);

	if ($event == null){
		$_SESSION["msg"] = "Event not found";
		$_SESSION["msgType"] = "ERROR";
		@header("location: ../view/");
		exit();
	} else {		
		@require_once "iniciaTemplate.php";
		
		$tpl->addFile("CONTEUDO", "html/stands.html");
		$tpl->addFile("SCRIPT", "html/standsScript.html");
		
		$tpl->START_DATE = $event->getStartDate();
		$tpl->END_DATE = $event->getEndDate();
		$tpl->ADDRESS = $event->getAddress();
		$tpl->LOCATION_NAME = $event->getObjLocation()->getName();
		$tpl->COUNTRY_NAME = $event->getObjLocation()->getObjCountry()->getName();
		
		$stands = StandBus::listByEventId($event->getEventId());
		
		$corridor = -1;
		$corridor_no = 0;
		if (is_array($stands) && count($stands) > 0){
			foreach ($stands as $s) {
				
				if ($corridor != $s->getCorridor()){
					if ($corridor != -1){

						if ($corridor % 2 != 0){
							$corridor_no++;
							$tpl->CORRIDOR_NUMBER = $corridor_no;
							$tpl->parseBlock("BLOCK_CORRIDOR_NUMBER", true);
						}
						
						
						$tpl->parseBlock("BLOCK_CORRIDOR", true);						
					}
					
					$corridor = $s->getCorridor();					
				}
				
				if ($s->getObjOwner()->getCompanyId() == null || $s->getObjOwner()->getCompanyId() < 0) {
					$tpl->STAND_CSS = "background-color: #dfffcc;";
					$tpl->PRICE = $s->getPrice();
					$tpl->STAND_ID = $s->getStandId();
					$tpl->parseBlock("BLOCK_AVAILABLE", true);
				} else {
					$tpl->STAND_CSS = "background: url('../company_logos/".$s->getObjOwner()->getCompanyId()."/logo.jpg'); background-size:100%;";
					
					$mktFile = "../stand_mkt/".$s->getStandId()."/mkt.pdf";
					if (file_exists($mktFile)){
						$tpl->MKT_LINK = $mktFile;
						$tpl->parseBlock("BLOCK_MKT_LINK");
					}
				}
				
				$tpl->parseBlock("BLOCK_STAND", true);
			}
			
			if ($corridor % 2 != 0){
				$corridor_no++;
				$tpl->CORRIDOR_NUMBER = $corridor_no;
				$tpl->parseBlock("BLOCK_CORRIDOR_NUMBER", true);
			}
				
			$tpl->parseBlock("BLOCK_CORRIDOR", true);
		}
		
		$tpl->COMPLEMENTO_TITULO_SITE = "Stands - " . $event->getName();
		
		$tpl->show();
	}
	
} else {
	$_SESSION["msg"] = "Invalid request";
	$_SESSION["msgType"] = "ERROR";
	@header("location: ../view/");
	exit();
}

?>