<?php
@session_start();

@require_once "../util/functionsLib.php";
@require_once "../util/ParametrosGerais.class.php";

@require_once "../business/EventBus.class.php";
@require_once "../to/Event.class.php";

@require_once "iniciaTemplate.php";

$tpl->addFile("CONTEUDO", "html/eventlist.html");

$lst = @EventBus :: listAll();

if (is_array($lst) && count($lst) > 0){
	$count = 0;	
	foreach($lst as $it){
		
		$count++;		
		
		$tpl->UI_START_DATE   = $it->getStartDate();
		$tpl->UI_END_DATE    = $it->getEndDate();
		$tpl->UI_EVENT_NAME   = $it->getName();
		$tpl->UI_LOCATION   = $it->getObjLocation()->getName();
		$tpl->UI_COUNTRY   = $it->getObjLocation()->getObjCountry()->getName();
		
		$tpl->parseBlock("BLOCK_IT_CADASTRO", true);	
	}
	
	$tpl->parseBlock("BLOCK_COM_REGISTRO");		
}else{
	$tpl->parseBlock("BLOCK_SEM_REGISTRO");			
}


$tpl->COMPLEMENTO_TITULO_SITE = "All Events";

$tpl->show();
?>