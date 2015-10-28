<?php

if ($_POST && isset($_POST["iptTblContent"])){
	
	$fileName = "";
	if (isset($_POST["iptTblTitle"])) $fileName = $_POST["iptTblTitle"];
	
	if ($fileName == "" && isset($_POST["iptTblID"])) $fileName = $_POST["iptTblID"];
	
	if ($fileName == "") $fileName = "excel_export";
	
	$fileName = str_replace(" ", "-", $fileName);
	
	@header("Content-type: application/vnd.ms-excel; name='excel'");
	@header("Content-Disposition: filename=$fileName.xls");
	@header("Pragma: no-cache");
	@header("Expires: 0&#8243;");

	//$out = str_replace('\"', '"', $_POST["iptTblContent"]);
	//$out = str_replace("../", "http://".$_SERVER["SERVER_NAME"]."/sevenlab/", $out);
	$out = $_POST["iptTblContent"];
	$out = str_replace("<br>", "", $out);
	$out = str_replace("<br/>", "", $out);
	$out = str_replace("<br />", "", $out);
	echo $out;
}

?>
