<?php

@session_start();
@session_destroy();
$_SESSION = array();

@session_start();

@header("location: ../admin/");
?>
