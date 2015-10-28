<?php

@session_start();
@require_once "../util/functionsLib.php";
@require_once "../util/ParametrosGerais.class.php";

@require_once "iniciaTemplate.php";

$tpl->addFile("CONTEUDO", "html/index.html");

$tpl->COMPLEMENTO_TITULO_SITE = "Home";

$tpl->show();
?>
