<h2> This is a search page </h2>

<?php
  include_once("includes/helpers/SiteHelper.php");
  $conn= getConnection(); 
  
  if (isset($_GET["search_field"])){
    
    /*
     * Sanitize
     */
    
    $searchInput = filter_var($_GET['search_field'], FILTER_VALIDATE_REGEXP, 
      array('options'=>array('regexp'=>'/^[\w -]*$/')));
    if (!$searchInput){
      echo "<p class=\"error\">Bad Input Value</p>";
      require("fragments/search_form.php");
    }
    else{
      $select = " SELECT S.id, S.name";
      $from = "FROM Sites S";
      $where = "WHERE S.name LIKE '%" . $_GET["search_field"] ."%'";
      $firstValue = false;
      for ($i = 1; $i <= 4; $i++){
        if (isset($_GET['type'.$i])){
          //Set SELECT, FROM, WHERE
           $from = $from . ", " . $_GET['type'.$i] . " X" . $i;
           if (!$firstValue){
                $where = $where . " AND (S.id=X" . $i . ".site_id";
                $firstValue = true;
           }
           else{
              $where = $where . " OR S.id=X" . $i . ".site_id"; 
           }
        } 
      }
      if ($firstValue){
         $where = $where . ")";
      }
      $myQuery = $select . ' ' . $from . ' ' . $where;
      $stid = oci_parse($conn, $myQuery);
      $err=oci_execute($stid);
      $nrows=oci_fetch_all($stid,$sites,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
      $siteHelper = new SiteHelper;
      $siteHelper->showListOfSites($sites);

    }
  }
  else {
    require("fragments/search_form.php");
  }
  oci_close($conn);
?>