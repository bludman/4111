<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	ini_set('display_errors','On');

	/*** include the init.php file ***/

 	require_once 'includes/init.php';

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











