<?php

@require_once "../util/verificaLogado.php";
@require_once "../util/ParametrosGerais.class.php";

if ($objUsuarioLogin->getTipoUsuario() != ParametrosGerais :: tipoUsuarioEmpresa){
	$_SESSION["msg"]     = "Funcionalidade n�o dispon�vel para o seu tipo de usu�rio.";
	$_SESSION["msgType"] = "ERROR";
	@header("location: ../system/");
	exit();	
}else{
/*
	$hoje = new calcDataHora();

	$diasDif = $hoje->difDataHora($hoje->getData()." ".$hoje->getHora(), $objUsuarioLogin->getDtExpiracao()." ".$hoje->getHora(), "d");

	if ($diasDif < 0){
		$_SESSION["msg"]     = "O per�odo de validade de sua conta no Agenda Segura expirou.<br/>N�o perca tempo !! Renove agora mesmo sua assinatura clicando <a href='renovar.php'>aqui</a>.";
		$_SESSION["msgType"] = "ERROR";
		@header("location: ../system/");
		exit();			
	}
*/
}

?>
