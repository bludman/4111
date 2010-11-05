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
      echo($myQuery); 
      $stid = oci_parse($conn, $myQuery);
      $err=oci_execute($stid);
      
      echo "<table border='1'>\n";
      while ($row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS)) {
        echo "<tr>\n";
        echo "    <td>" .
            "<a href=\"index.php?page=site&id=". $row['ID']."\">". 
            ($row['NAME'] !== null ? htmlentities($row['NAME'], ENT_QUOTES) : "&nbsp;") . 
            "</a></td>\n";
      
        echo "</tr>\n";
      }
      echo "</table>\n"; 
    }
  }
  else {
    require("fragments/search_form.php");
  }
  oci_close($conn);
?>