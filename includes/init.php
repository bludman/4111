<?php


/*
Load Classes
*/
require_once("Cleaner.php");
require_once("Router.php");
require_once("Authenticator.php");



$cleaner = new Cleaner;
$router = new Router;
$auth = new Authenticator;

/**
Load Configuration
*/

require_once("config.php");

?>
