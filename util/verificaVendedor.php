<?php
@session_start();

@require_once "../to/CodigoPromocional.class.php";
@require_once "../util/functionsLib.php";

if (vendedorLogado()){
	$objCPLogin = unserialize($_SESSION["objCPLogin"]);
}else{
	$objCPLogin = null;
	$_SESSION["msg"]     = "Efetue login para acessar essa funcionalidade.";
	$_SESSION["msgType"] = "ERROR";
	@header("location: ../vendedores/");
	exit();
}

?>
