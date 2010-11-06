<?php
	ini_set('display_errors','On');

	/*** include the init.php file ***/
 	include 'includes/init.php';
	require_once "includes/connection.php";

	include("includes/header.php");
	//$cleanPage=$cleaner->sanitize($_GET['page']);

	//echo "<h1>" . $cleanPage . "</h1>";
	if(isset($_GET['page']))
		$router->renderPage($_GET['page']);
	else
		$router->renderPage('index');
    	
	include("includes/footer.php");

?>











