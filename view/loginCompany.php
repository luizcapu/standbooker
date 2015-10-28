<?php

@session_start();
@require_once "../util/functionsLib.php";
@require_once "../util/ParametrosGerais.class.php";

@require_once "iniciaTemplate.php";

@require_once "../to/Location.class.php";
@require_once "../business/LocationBus.class.php";

$tpl->addFile("CONTEUDO", "html/loginCompany.html");
$tpl->addFile("SCRIPT", "html/loginCompanyScript.html");

if ($_GET && isset($_GET["r"]))
	$tpl->LOGIN_REQ_URL = decodificaString($_GET["r"]);


$tpl->COMPLEMENTO_TITULO_SITE = "Company Login";

$tpl->show();
?>
