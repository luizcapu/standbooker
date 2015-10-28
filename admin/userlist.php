<?php
@session_start();
@require_once "../util/functionsLib.php";
@require_once "../util/ParametrosGerais.class.php";

@require_once "../business/AdminBus.class.php";
@require_once "../to/Admin.class.php";

@require_once "iniciaTemplate.php";

$tpl->addFile("CONTEUDO", "html/userlist.html");

$lst = @AdminBus :: listAll();

if (is_array($lst) && count($lst) > 0){
	$count = 0;	
	foreach($lst as $it){
		
		$count++;		
		
		$tpl->COUNT_REG   = $count;
		$tpl->ID_ADMIN      = codificaString($it->getAdminId());
		$tpl->LOGIN_ADMIN   = $it->getLogin();
		$tpl->NAME_ADMIN    = $it->getName();
		$tpl->EMAIL_ADMIN   = $it->getEmail();
		
		$tpl->parseBlock("BLOCK_IT_CADASTRO", true);	
	}
	
	$tpl->parseBlock("BLOCK_COM_REGISTRO");		
}else{
	$tpl->parseBlock("BLOCK_SEM_REGISTRO");			
}


$tpl->COMPLEMENTO_TITULO_SITE = "All Admin Accounts";

$tpl->show();
?>