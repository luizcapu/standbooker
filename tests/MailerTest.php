<?php

@require_once "../util/Mailer.class.php";

class MailerTest extends PHPUnit_Framework_TestCase {
	
	public function testSendMail(){
		$ret = Mailer::sendEmail("luizcapu@gmail.com", "Test", "StandBooker Mailer Test Case 1");
		$this->assertEquals($ret, true);
	}
	
}

?>