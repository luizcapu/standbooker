<?php
@session_start();

@require_once "../util/functionsLib.php";
@require_once "../to/Usuario.class.php";

if (usuarioLogado()){
	$objUsuarioLogin = unserialize($_SESSION["objUsuarioLogin"]);
}else{
	$objUsuarioLogin = null;
	$_SESSION["msg"]     = "Efetue o login para acessar essa funcionalidade.";
	$_SESSION["msgType"] = "ERROR";
	
	if (isset($paginaAtual) && $paginaAtual != ""){
		@header("location: ../view/index.php?redir=".codificaString($paginaAtual));		
	}else{
		@header("location: ../view/");				
	}
	
	exit();
}

?>
