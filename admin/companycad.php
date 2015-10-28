<?php

@session_start();
@require_once "../util/functionsLib.php";
@require_once "../util/ParametrosGerais.class.php";

@require_once "iniciaTemplate.php";

$tpl->addFile("CONTEUDO", "html/companycad.html");

$tpl->COMPLEMENTO_TITULO_SITE = "Add/Edit Company (TODO)";

$tpl->show();
?>
