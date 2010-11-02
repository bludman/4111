<?php
	ini_set('display_errors','On');

	/*** include the init.php file ***/
 	include 'includes/init.php';




	include("includes/header.php");
	$cleanPage=$cleaner->sanitize($_GET['page']);

	echo "<h1>" . $cleanPage . "</h1>";
	$router->renderPage($cleanPage);
	
	include("includes/footer.php"); 

?>




<?php 
/*
require_once "includes/connection.php";
echo "<br />". $db;
*/
?>






