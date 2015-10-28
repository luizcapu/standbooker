<?php

@session_start();

@require_once "../to/Admin.class.php";
@require_once "../util/functionsLib.php";

if (adminLogado()){
	$objAdminLogin = unserialize($_SESSION["objAdminLogin"]);
}else{
	$objAdminLogin = null;
	$_SESSION["msg"]     = "Efetue login para acessar essa funcionalidade.";
	$_SESSION["msgType"] = "ERROR";
	@header("location: ../admin/");
	exit();
}

?>
