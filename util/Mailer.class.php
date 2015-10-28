<?php
@require_once "../util/AdminMailer.class.php";

class Mailer {

    function __contruct() {
    }
    
    public static function sendEmail($destinatario, $assunto, $mensagem, $responderPara = "", $adminMailer = null){
		
		$bNewMailer = ($adminMailer == null);
		
		if ($bNewMailer) $adminMailer = new AdminMailer();

		$ret = $adminMailer->sendEmail($destinatario, $assunto, $mensagem, $responderPara);
		
		if ($bNewMailer) $adminMailer->SmtpClose();
		
		return $ret;
    }
    
    public static function sendBatchEmail($lstEmails = null){
		
		if ($lstEmails == null)
			$lstEmails = Mailer :: getSessionLstEmails();
		
		if (!is_array($lstEmails) || count($lstEmails) == 0) return true;
		
		$adminMailer = new AdminMailer();
		
		foreach($lstEmails as $itemEnvio){
			
			$destinatario = $itemEnvio["destinatario"];
			$assunto      = $itemEnvio["assunto"];
			$mensagem     = $itemEnvio["mensagem"];
			
			$adminMailer->sendEmail($destinatario, $assunto, $mensagem, "");
		}
		
		$adminMailer->SmtpClose();
		
		return true;
    }

	public static function getSessionLstEmails(){
		@session_start();
		
		$lstEmails = array();
		
		if (isset($_SESSION["lstEmailsEnviar"]) && $_SESSION["lstEmailsEnviar"] != "")
			$lstEmails = unserialize($_SESSION["lstEmailsEnviar"]);
		
		unset($_SESSION["lstEmailsEnviar"]);
		
		return $lstEmails;
	}

	public static function eraseSessionLstEmails(){
		@session_start();
		
		unset($_SESSION["lstEmailsEnviar"]);
		
		return true;
	}
 	
 	public static function adicionarItemEmailSessao($destinatario, $assunto, $mensagem){ 		
 		
 		@session_start();
 		
 		$itemEmail = array();
 		$itemEmail["destinatario"] = $destinatario;
 		$itemEmail["assunto"]      = $assunto;
 		$itemEmail["mensagem"]     = $mensagem;
 		
 		$lstEmails   = Mailer :: getSessionLstEmails();
 		$lstEmails[] = $itemEmail;	
 		
 		$_SESSION["lstEmailsEnviar"] = serialize($lstEmails);
 	}	
 	   
}

?>