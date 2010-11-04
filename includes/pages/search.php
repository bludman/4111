<h2> This is a search page </h2>

<?php
  $conn= getConnection(); 
  
  if (isset($_GET["search_field"])){
    $searchInput = filter_var($_GET['search_field'], FILTER_VALIDATE_REGEXP, 
      array('options'=>array('regexp'=>'/^[\w -]*$/')));
    if (!$searchInput){
      echo "<p class=\"error\">Bad Input Value</p>";
      require("fragments/search_form.php");
    }
    for ($i = 1; $i <= 4; $i++){
      if (isset($_GET['type'.$i])){
        echo ($_GET['type'.$i]."<br>"); 
      } 
    }
    $stid = oci_parse($conn, 'SELECT id,name FROM Sites');
    $err=oci_execute($stid);
  }
  else{
    require("fragments/search_form.php");
  }
?>