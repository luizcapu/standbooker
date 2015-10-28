<?php
@require_once "../util/phpmailer/class.phpmailer.php";

class AdminMailer extends PHPMailer {

    function __construct($keepAlive = true) {
		$this->IsSMTP();                                // send via SMTP
		$this->SMTPDebug = 0;
		$this->language = "Portuguese";
		$this->ContentType = "text/html";               // e-mail com conte�do HTML
		$this->Host     = "smtp.gmail.com";   // SMTP servers
		$this->Port     = 465; // SMTP Port
		$this->SMTPAuth = true;                         // turn on SMTP authentication
		$this->SMTPSecure = "ssl";
		$this->Username = "standbooker@gmail.com";  // SMTP username
		$this->Password = "stbooker2015";              // SMTP password
		
		$this->Mailer = "smtp";

		$this->SMTPKeepAlive = $keepAlive;
		
    }
    
    public function sendEmail($destinatario, $assunto, $mensagem, $responderPara = "") {

		$this->ClearReplyTos();
		$this->ClearAddresses();
		$this->ClearCCs();
		$this->ClearBCCs();

		if ($responderPara!="")
			$this->AddReplyTo($responderPara);

		$this->From     = "standbooker@gmail.com";
		$this->FromName = "StandBooker";

		$this->Subject  =  $assunto;
				
		$this->AddAddress($destinatario,$destinatario);
		
		$mensagem .="<br/><br/><br/>"; 
		$mensagem .="Regards,"; 
		$mensagem .="<br/>"; 
		$mensagem .="StandBooker Team"; 
		$mensagem .="<br/>"; 
		$mensagem .="<a href=\"http://www.standbooker.com.br\">www.standbooker.com.br</a>"; 
		$mensagem .="<br/><br/>"; 
		$mensagem .="<span style='font-size:11px; font-weight:bold;'>* Please, do not reply this e-mail.</span>"; 
		
		
		@require_once "../util/Template.class.php";
		$tpl = new Template("../mail/modelo.html");
		
		//$tpl->TITULO_MENSAGEM = $assunto;
		$tpl->CORPO_MENSAGEM  = $mensagem;
		$tpl->ANO_EMAIL = date("Y");
		
//		$this->Body = $mensagem;
		$this->Body = $tpl->getContent();
		
    	if($this->Send()){
			return true;
		}else{
			return false;
		}
		
    }
    
}
?>