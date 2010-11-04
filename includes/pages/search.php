<h2> This is a search page </h2>

<?php
  $conn= getConnection();

  require("fragments/search_form.php");  

  if ($_GET["search_field"]){
    $searchInput = filter_var($_GET["search_field"], FILTER_VALIDATE_REGEXP, 
      array("options"=>array("regexp"=>"/^[\w -]*$/")));
      if (!$searchInput){
        echo "<p>Bad Input Value</p>";
      }
    $stid = oci_parse($conn, 'SELECT id,name FROM Sites');
    $err=oci_execute($stid);
  }
  else{
  
  }  
?>