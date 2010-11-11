<?php

  $query = "
    SELECT * FROM (
      SELECT S.name AS Name, COUNT(V.site_id) AS Visits, E.Menu, E.site_id
      FROM Visits V, Sites S, Eateries E
      WHERE V.site_id = S.id AND E.site_id = S.id AND S.id IN (SELECT E.site_id FROM Eateries E)
      GROUP BY V.site_id, S.name, E.Menu, E.site_id
      ORDER BY Visits DESC)
    WHERE ROWNUM <= 3
  ";
  
  $conn= getConnection();
  $stid = oci_parse($conn, $query);
  $err = oci_execute($stid);
  oci_fetch_all($stid,$sites,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
 
  $rowToShow = rand(0,2);
  
  echo '
    <p id="recommend_link">Hungry? Try 
    <a href="index.php?page=site&id='. $sites[$rowToShow]["SITE_ID"] .'">'. $sites[$rowToShow]["NAME"] .'</a>
    <a href="'. $sites[$rowToShow]["MENU"] .'">Menu</a></p>
  ';

?>