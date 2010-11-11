<?php
  $ran = rand(0,1);
  
  $auth = new Authenticator;
    
  if ($ran == 0){
    recommendLocation($auth);
  }
  else{
    recommendEatery();
  }
    
  function recommendLocation($auth){
    $query = "
    SELECT * 
    FROM (SELECT S.name AS Name, S.id AS ID
      FROM Sites S, Buildings B, (SELECT *
            FROM (SELECT B.Type AS Type, COUNT(B.Type) AS CNT
              FROM Buildings B, Visits V
              WHERE B.site_id = V.site_id";
              if ($auth->isLoggedIn()){
               $query = $query . " AND V.user_email='". $auth->getEmail() ."'"; 
              }
              $query = $query . " 
              GROUP BY B.Type
              ORDER BY CNT DESC)
            WHERE ROWNUM <= 1) T
      WHERE S.id = B.site_id AND B.type = T.Type)
    WHERE ROWNUM <= 5
    ";
  
  $conn= getConnection();
  $stid = oci_parse($conn, $query);
  $err = oci_execute($stid);
  oci_fetch_all($stid,$sites,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
 
  $rowToShow = rand(0,4);
  
  echo '
    <p id="recommend_link" style="text-align: center;">You might like to visit 
    <a href="index.php?page=site&id='. $sites[$rowToShow]["ID"] .'">'. $sites[$rowToShow]["NAME"] .'</a>
  ';
  }
  
  function recommendEatery(){
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
    <p id="recommend_link" style="text-align: center;">Hungry? Try 
    <a href="index.php?page=site&id='. $sites[$rowToShow]["SITE_ID"] .'">'. $sites[$rowToShow]["NAME"] .'</a>
    [<a href="'. $sites[$rowToShow]["MENU"] .'" target="_blank">View Menu</a>]</p>
  ';
  }

?>