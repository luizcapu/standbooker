<?php

@session_start();

@require_once "../util/functionsLib.php";

if (loggedAsAttendee()){
	unset($_SESSION["objAttendeeLogin"]);
}

if (loggedAsCompany()){
	unset($_SESSION["objCompanyLogin"]);
}

@header("location: ../view/");
?>