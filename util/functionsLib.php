<?php
	
	function validEmail($psEmail){

		return preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $psEmail);
		
	}	
	
	function validLoginString($psLogin){
		return (preg_match('/^[a-z\d_]{5,20}$/i', $psLogin));
	}
	
	function curl_get($url, array $get = NULL, array $options = array()){   
    	$defaults = array(
        	CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get),
        	CURLOPT_HEADER => 0,
        	CURLOPT_RETURNTRANSFER => TRUE,
        	CURLOPT_TIMEOUT => 4
	    );
   
    	$ch = curl_init();
    	curl_setopt_array($ch, ($options + $defaults));
    	if( ! $result = curl_exec($ch))
	    {
    	    trigger_error(curl_error($ch));
    	}
    	curl_close($ch);
    	return $result;
	} 
	
	function getBoolImg($bValue){
	
		if (isTrue($bValue))
			return "<img src=\"../img/check.gif\" />";
		else
			return "<img src=\"../img/cancel.gif\" />";
	}
	
	function boolToInt($bValue){
		if (isTrue($bValue))
			return 1;
		else
			return 0;		
	}
	
	function formataMoedaBD($aValue){		
		
		if (strpos($aValue, ",")===false) return $aValue;
		
		$result = str_replace(".", "", $aValue);
		$result = str_replace(",", ".", $result);
		
		return $result;		
	}
	
	function formataMoedaView($aValue){				
		return number_format($aValue, 2, ",", ".");
	}
	
	function printProcessando(){
		echo '<html style="margin:0px; padding:0px;">';
		echo '<body style="margin:0px; padding:0px;">';
		echo '<div style="text-align:center; font: normal 12px Arial, Verdana, \'Lucida Grande\', Georgia, Sans-Serif; width:300px; margin:0 auto; color:#2888BA; background-color:#EBF0F3; font-weight:bold; padding:10px; top:0px; position:block;">';
		echo 'Processando...';
	}
	
	function redirPage($urlDestino){
		echo "<script type='text/javascript'>";
		echo " window.location='$urlDestino';";
		echo "</script>";		
	}
		
	function verificaEmpresa(){

		@require_once "../util/ParametrosGerais.class.php";
		
		if (usuarioLogado()){
			
			$objUsuLoginTmp = unserialize($_SESSION["objUsuarioLogin"]);
			return ($objUsuLoginTmp->getTipoUsuario() == ParametrosGerais :: tipoUsuarioEmpresa);
			
		}else{
			return false;
		}
	}

	function verificaProfissional(){

		@require_once "../util/ParametrosGerais.class.php";
		
		if (usuarioLogado()){
			
			$objUsuLoginTmp = unserialize($_SESSION["objUsuarioLogin"]);
			return (($objUsuLoginTmp->getTipoUsuario() == ParametrosGerais :: tipoUsuarioProfissional) || ($objUsuLoginTmp->getTipoUsuario() == ParametrosGerais :: tipoUsuarioEmpresa));
			
		}else{
			return false;
		}
	}
	
	function formatarDDDTelefone($ddd, $telefone){
		$sResult = "";
		
		$ddd = trim($ddd);
		$telefone = trim($telefone);
		
		if ($telefone == "") return "";
		
		if ($ddd != "") $sResult = "($ddd) ";
		
		if (strlen($telefone)==8) $telefone = substr($telefone, 0, 4)."-".substr($telefone, 4, 4);
		
		$sResult .= $telefone; 
		
		return $sResult;
	}
	
	function formatarDataView($data){
	  if ($data!="") $data=substr($data, 8, 2)."/".substr($data, 5, 2)."/".substr($data, 0, 4);
	  return $data;
	}

	function formataDataGravacao($data){
	  if ($data!="") $data=substr($data, 6, 4)."-".substr($data, 3, 2)."-".substr($data, 0, 2);
	  return $data;
	}

	function adminLogado(){
		return ((isset ($_SESSION["objAdminLogin"])) && ($_SESSION["objAdminLogin"] != ""));
	}

	function countrySelected(){
		return ((isset ($_SESSION["objCurrentCountry"])) && ($_SESSION["objCurrentCountry"] != ""));
	}

	function getSelectedCountry(){
		return (countrySelected()) ? unserialize($_SESSION["objCurrentCountry"]) : null;
	}
	
	function loggedAsCompany(){
		return ((isset ($_SESSION["objCompanyLogin"])) && ($_SESSION["objCompanyLogin"] != ""));
	}

	function loggedAsAttendee(){
		return ((isset ($_SESSION["objAttendeeLogin"])) && ($_SESSION["objAttendeeLogin"] != ""));
	}
	
	function usuarioLogadoAdmin(){
		return ((isset ($_SESSION["usuarioAdmin"])) && ($_SESSION["usuarioAdmin"] != ""));
	}

	function boolToString($bValue, $pt = ""){
		if (isTrue($bValue)){
			if ($pt=="") return "true";
			else return "Yes";
		}
		else{
			if ($pt=="") return "false";
			else return "No";
		}
	}

	function stringToBool($str){
		if (gettype($str)=="string"){
			$str = strtolower($str);
		}
		$arFalse = array("false","f","0","");
		$arTrue = array("true","t","1");
		if (in_array($str, $arFalse)) {
			return false;
		}
		if (in_array($str, $arTrue)) {
			return true;
		}
	}

	function isEmpty($par) {
        if ((string)$par==null || (string)$par=="" || (string)$par=="null") {
			return true;
		} else {
			return false;
		}
	}
	
	function printBool($par){
		if (isTrue($par)) echo "Yes";
		else echo "No";
	}
	
	function geraCodigoAleatorio($tamanho) {
		$codigo = "";
		$letra = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Z', 'W', 'Y',
						'0', '1', '2', '3', '4', '5', '6', '7',  '8', '9');

		while ($tamanho > 0) {

			if(rand(0, 1) == 1){
				if(rand(0, 1) == 1){
					$codigo .= $letra[rand(0, 31)];
				} else{
					$codigo .= strtolower($letra[rand(0, 31)]);
				}
			} else{
				$codigo .= rand(0, 9);
			}
			$tamanho--;
		}
		return $codigo;
	}
	
	function codificaString($string){
		$tipo = rand(0, 2);
		$codAleatorioInicial = geraCodigoAleatorio(10);
		$codAleatorioFinal   = geraCodigoAleatorio(10);
		
		switch($tipo){
			case 0 : // codifica no comeco
					return base64_encode($tipo.$codAleatorioInicial.$codAleatorioFinal.$string);
					break;			
			case 1 : // codifica no meio
					return base64_encode($tipo.$codAleatorioInicial.$string.$codAleatorioFinal);
					break;			
			case 2 : // codifica no fim
					return base64_encode($tipo.$string.$codAleatorioInicial.$codAleatorioFinal);
					break;			
		}						
	}

	function decodificaString($string){
		$decode = base64_decode($string);
		
		$tipo   = substr($decode, 0, 1);
		$strLen = strlen($decode) - 1;

		switch($tipo){
			case 0:
					return substr($decode, 21, $strLen-20);
					break;
			case 1:
					return substr($decode, 11, $strLen-20);
					break;
			case 2:
					return substr($decode, 1, $strLen-20);
					break;
		}				
	}
	
	function isTrue($valor){

	  if ((strtolower($valor) == "t") || (strtolower($valor) == "true") || ($valor === true)){
	    return true;
	  }else{
	    return false;
	  }

	}

	function getPageName($pageName){
		if ($pageName=="")
			return basename($_SERVER['REQUEST_URI']);
		else
			return basename($pageName);
	}

	function getMsg($codigo){
		$qPO = 1; //quantidade de par�metros obrigat�rios da fun��o
		$janela = getPageName();

		global $ar_mensagem;
		$mensagem = "";
		$ar_token_msg = split  ("\[[A-Za-z0-9]+\]",$ar_mensagem[$janela][$codigo]);
		$count = func_num_args(); //quantidade de par�metros recebidos

		if ($count>$qPO and count($ar_token_msg) >1){
			for ($i = $qPO; $i < $count; $i++) {
				$ar_params[$i-$qPO] = func_get_arg($i);
			}
			$i=0;
			foreach ( $ar_token_msg as $key => $value ) {
				//verifica se existe a chave no array antes de tentar obter o parametro
				$mensagem.= array_key_exists($i, $ar_params) ? $value.$ar_params[$i++] : $value;
			}
			return $mensagem;
		}else{
		  return $ar_mensagem[$janela][$codigo];
		}
	}


	function removerDiretorio($filepath)
	{
		if (is_dir($filepath) && !is_link($filepath))
	    {
	        if ($dh = opendir($filepath))
	        {
	            while (($sf = readdir($dh)) !== false)
	            {
	                if ($sf == '.' || $sf == '..')
	                {
	                    continue;
	                }
	                if (!removerDiretorio($filepath.'/'.$sf))
	                {
	                    throw new Exception($filepath.'/'.$sf.' could not be deleted.');
	                }
	            }
	            closedir($dh);
	        }
	        return rmdir($filepath);
	    }
	    return unlink($filepath);
	}

	function salvarArquivoComNomeUnico($nomeOriginal, $tmpFileName, $localDesejado, $nomePrefixo, $saveAsThumbNail=false, $tpRetorno = "C") {
		if (!file_exists($tmpFileName)) {
			return false;
		}
		if (!is_dir($localDesejado)) {
			return false;
		}
		if (!is_string($nomePrefixo)) {
			return false;
		}
		if (!is_bool($saveAsThumbNail)) {
			return false;
		}
		if (!$saveAsThumbNail && (!is_string($nomeOriginal) || $nomeOriginal == "")) {
			return false;
		}

        if ($saveAsThumbNail) {
        	$extensao = "jpg";
        } else {
	        $arrayArquivoOriginal = explode('.', $nomeOriginal);
	        $extensao = array_pop($arrayArquivoOriginal);
        }

        if ($extensao == "") {
        	return false;
        }

        do {

            $caminhoCompletoTmp = tempnam($localDesejado, $nomePrefixo);

            $nomeTmp = basename($caminhoCompletoTmp);

	        unlink($caminhoCompletoTmp);

            $arrayArquivoTmp = explode('.', $nomeTmp);

            $novoNome = $arrayArquivoTmp[0] . '.' . $extensao;

            $novoCaminhoCompleto = $localDesejado . "/" . $novoNome;

        } while (file_exists($novoCaminhoCompleto));

        if (!move_uploaded_file($tmpFileName, $novoCaminhoCompleto)) {
        	return false;
        }

        if ($saveAsThumbNail) {
        	require_once "phpThumb_1.7.7/phpthumb.class.php";

            list ($source_w, $source_h) = GetImageSize($novoCaminhoCompleto);
            $max_w = 150;
            $max_h = 150;
            list ($newW, $newH) = phpthumb_functions :: ProportionalResize($source_w, $source_h, $max_w, $max_h);

            $phpThumb = new phpThumb();
            $phpThumb->setSourceFilename($novoCaminhoCompleto);
            $phpThumb->setParameter('w', $newW);
            $phpThumb->setParameter('h', $newH);
            $phpThumb->setParameter('config_output_format', 'jpeg');
            if (!$phpThumb->GenerateThumbnail()) {
            	return false;
            }
            $output_size_x = ImageSX($phpThumb->gdimg_output);
            $output_size_y = ImageSY($phpThumb->gdimg_output);
            if (!$phpThumb->RenderToFile($novoCaminhoCompleto)) {
            	return false;
            }
        }
		
		$tpRetorno = trim($tpRetorno);		
        	
		if ($tpRetorno=="C" || $tpRetorno=="")
        	return $novoCaminhoCompleto;
        	
		if ($tpRetorno=="A")
        	return $novoNome;        	
	}

	function salvarComoThumbnailComNomeUnico($tmpFileName, $localDesejado, $nomePrefixo) {
		return salvarArquivoComNomeUnico("", $tmpFileName, $localDesejado, $nomePrefixo, true);
	}

	function contemArquivos($diretorio) {
		$arrayArquivosDir = scandir($diretorio);

        if (count($arrayArquivosDir) > 2) {
        	return true;
        } else {
        	return false;
        }
	}
	
    function limparNomeArquivo($string) {

        $string = strtolower($string);

        $string = eregi_replace('[a�����]', 'a', $string);
        $string = eregi_replace('[e����]', 'e', $string);
        $string = eregi_replace('[i����]', 'i', $string);
        $string = eregi_replace('[o�����]', 'o', $string);
        $string = eregi_replace('[u����]', 'u', $string);

        $string = eregi_replace('[�]', 'c', $string);
        $string = eregi_replace('[�]', 'n', $string);

        $string = eregi_replace('( )', '_', $string);

        $string = eregi_replace('--', '_', $string);

        return $string;

    }
     
    function gerarLinkThumbnail($arquivo, $width, $height){
    		
    }
       
    function getDiaDaSemana($data, $tpRetorno = "") {
		
		list($dia, $mes, $ano) = split("/", $data);
		
		$iDiaSemana = date("N", mktime(0,0,0,$mes,$dia,$ano) );
		
		if ($tpRetorno != "") return $iDiaSemana;
		
		switch($iDiaSemana){
			case 0 :
					return "Sunday";
					break;
			case 1 :
					return "Monday";
					break;
			case 2 :
					return "Thursday";
					break;
			case 3 :
					return "Wednesday";
					break;
			case 4 :
					return "Thuesday";
					break;
			case 5 :
					return "Friday";
					break;
			case 6 :
					return "Saturday";
					break;
			case 7 :
					return "Sunday";
					break;
		}

    }

    function getDiaDaSemanaOrdinal($diaSemana) {
		
		switch($diaSemana){
			case 0 :
					return "Sun";
					break;
			case 6 :
					return "Sat";
					break;
			case 7 :
					return "Sun";
					break;
			default :
					return ($diaSemana+1)."";
					break;
		}

    }
	
	function getNomeMes($mes){
		switch ($mes) {
			case 1:
					return "January";
					break;
			case 2:
					return "February";
					break;
			case 3:
					return "March";
					break;
			case 4:
					return "April";
					break;
			case 5:
					return "May";
					break;
			case 6:
					return "June";
					break;
			case 7:
					return "July";
					break;
			case 8:
					return "August";
					break;
			case 9:
					return "Sptember";
					break;
			case 10:
					return "October";
					break;
			case 11:
					return "November";
					break;
			case 12:
					return "December";
					break;
		}
	}
	
	function getDataInicioSemana($dtBase, $incSemana = 0){
		
		@require_once "calcDataHora.class.php";
		
		$dtSemana = new calcDataHora($dtBase);
		
		if ($incSemana > 0){
			$dtSemana->somaDia($incSemana * 7);
		}
		
		$diaSemanaDataBase = getDiaDaSemana($dtBase, "n");
		//$incSeg = 1 - $diaSemanaDataBase;
		$incSeg = -1 * $diaSemanaDataBase;
		
		$dtSemana->somaDia($incSeg);
		
		return $dtSemana->getData();		
				
	}
	
	function getDataFinalMesAno($mes, $ano){
		
		@require_once "calcDataHora.class.php";
		
		if (strlen($mes)==1) $mes = "0".$mes;
		
		$dtBase = new calcDataHora("01/".$mes."/".$ano);
		$dtBase->somaMes(1);
		$dtBase->somaDia(-1);
		
		return $dtBase->getData();		
				
	}
	
function validarCPF($cpf){	
	// Verifiva se o n�mero digitado cont�m todos os digitos
    $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
	
	// Verifica se nenhuma das sequ�ncias abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
	{
	return false;
    }
	else
	{   // Calcula os n�meros para verificar se o CPF � verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}

// VERFICA CNPJ
   function validaCNPJ($cnpj) {
   
      if (strlen($cnpj) <> 14)
         return false;

      $soma = 0;
      
      $soma += ($cnpj[0] * 5);
      $soma += ($cnpj[1] * 4);
      $soma += ($cnpj[2] * 3);
      $soma += ($cnpj[3] * 2);
      $soma += ($cnpj[4] * 9);
      $soma += ($cnpj[5] * 8);
      $soma += ($cnpj[6] * 7);
      $soma += ($cnpj[7] * 6);
      $soma += ($cnpj[8] * 5);
      $soma += ($cnpj[9] * 4);
      $soma += ($cnpj[10] * 3);
      $soma += ($cnpj[11] * 2);

      $d1 = $soma % 11;
      $d1 = $d1 < 2 ? 0 : 11 - $d1;

      $soma = 0;
      $soma += ($cnpj[0] * 6);
      $soma += ($cnpj[1] * 5);
      $soma += ($cnpj[2] * 4);
      $soma += ($cnpj[3] * 3);
      $soma += ($cnpj[4] * 2);
      $soma += ($cnpj[5] * 9);
      $soma += ($cnpj[6] * 8);
      $soma += ($cnpj[7] * 7);
      $soma += ($cnpj[8] * 6);
      $soma += ($cnpj[9] * 5);
      $soma += ($cnpj[10] * 4);
      $soma += ($cnpj[11] * 3);
      $soma += ($cnpj[12] * 2);
      
      
      $d2 = $soma % 11;
      $d2 = $d2 < 2 ? 0 : 11 - $d2;
      
      if ($cnpj[12] == $d1 && $cnpj[13] == $d2) {
         return true;
      }
      else {
         return false;
      }
   } 
?>
