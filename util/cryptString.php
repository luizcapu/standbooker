<?php

@header("Content-Type: text/html; charset=ISO-8859-1",true);
@require_once "../util/functionsLib.php";

$aValue = codificaString($_POST["aValue"]);

echo $aValue;
?>
