<?php
@header('Content-Type: text/html; charset=ISO-8859-1');

@require_once("../util/verificaLogado.php");

@require_once("../util/functionsLib.php");
@require_once("../util/ExcelStruct.class.php");
@require_once("../util/excelwriter.inc.php");

$fileName = "../expFiles/".base64_encode($objUsuarioLogin->getEmail()).".xls";

if (!isset($_SESSION["objExcelExp"]) || $_SESSION["objExcelExp"]==""){
	echo "Erro ao salvar o arquivo. Tente novamente...";	
	exit();	
}

$objExcelStruct = unserialize($_SESSION["objExcelExp"]);
unset($_SESSION["objExcelExp"]);

if ((file_exists($fileName)) && (!unlink($fileName))){
	echo "Erro ao salvar o arquivo. Tente novamente...";	
	exit();
}

$cols = $objExcelStruct->getCols();
$data = $objExcelStruct->getData();

$excel = new ExcelWriter($fileName);
	
if($excel==false){
	echo $excel->error;
	exit();	
}	

// escreve titulo da planilha
if ($objExcelStruct->getTitle()!=""){
	$title = array();
	$title[] = $objExcelStruct->getTitle(); 
	$excel->writeLine($title, true);	
}

// escreve colunas do titulo
$excel->writeLine($cols, true);

foreach($data as $row){
	$excel->writeLine($row);
}

$excel->close();

if (file_exists($fileName)){
	header("Content-type: application/xls");
	header("Content-disposition: attachment; filename=".basename($fileName));
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($fileName));
	@readfile($fileName);
}else{
	echo "Erro ao salvar o arquivo. Tente novamente...";	
	exit();
}

?>

<html>
	<head>
		<title>Exportação para Excel</title>
	</head>
	<body onLoad="window.close();">
	</body>
</html>