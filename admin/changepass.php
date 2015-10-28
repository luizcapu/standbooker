<?php

@session_start();

@require_once "iniciaTemplate.php";

$tpl->addFile("CONTEUDO", "html/changepass.html");
$tpl->addFile("SCRIPT", "html/changepassScript.html");

$tpl->COMPLEMENTO_TITULO_SITE = "Change Password";

$tpl->show();
?>