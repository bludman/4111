<?php     
   $auth = new Authenticator;
   
    $mrClean = new Cleaner;

    if (isset($_POST['site'])){
      $site_id = $mrClean->sanitize($_POST['site'], Cleaner::NUMBER_CHARS);
    } 
     
   if (!empty($site_id) && $auth->isLoggedIn()){
   
     $email = $auth->getEmail();             
     $date = date('Y/m/d:h:i:sA');
     
     $query = "
        INSERT INTO Visits (user_email, site_id, visited_at)
        VALUES ('" . $email . "','" . $site_id . "', to_date('". $date . "','yyyy/mm/dd:hh:mi:ssam'))
     ";
               
     $conn = getConnection();
     $stid = oci_parse($conn, $query);
     $err = oci_execute($stid);
     
     hasCompletedWalkabout($email, $site_id);
     
     $link = "index.php?page=site&id=" . $site_id;
     echo "
     <p>Succesful Check-In!</p><br />
     ";
     echo '<a href="index.php"> Home</a>
     <a href='.$link.'>Back</a>'; 
  }
  else{
    header('Location: index.php');  
  }
  
  
  function hasCompletedWalkabout($email, $site_id){
        //Get all walkabouts that the user has not completed
        $query = "
          SELECT C.walkabout_name AS Name
          FROM Completes C
          WHERE C.walkabout_name NOT IN (SELECT Co.walkabout_name AS Name
                FROM Completes Co
                WHERE Co.user_email = '". $email ."')
          INTERSECT
          SELECT W.name
          FROM Walkabouts W
          ";
        
        $conn= getConnection();
        $stid = oci_parse($conn, $query);
        $err = oci_execute($stid);
        $nrows = oci_fetch_all($stid,$sites,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
       
        for ($i = 0; $i <$nrows; $i++){
       
          $query2 = "
          SELECT DISTINCT S.name, S.id AS ID
          FROM Sites S
          WHERE S.id NOT IN (SELECT Vi.site_id
                    FROM Visits Vi
                    WHERE Vi.user_email = '". $email ."')
          INTERSECT
          SELECT S.name, C.site_id AS ID
          FROM Comprised_of C, Sites S
          WHERE C.walkabout_name = '". $sites[$i]['NAME'] ."' AND S.id = C.site_id
          ";
          
          $stid2 = oci_parse($conn, $query2);
          $err2 = oci_execute($stid2);
          $row = oci_fetch_array($stid2,OCI_BOTH+OCI_RETURN_NULLS);
          
          if (empty($row)){
              $query3 = "
                INSERT INTO Completes (user_email,walkabout_name)
                VALUES ('". $email ."','". $sites[$i]['NAME'] ."')
              ";
              $stid3 = oci_parse($conn, $query3);
              $err3 = oci_execute($stid3);
              echo "
               <p>You've completed the ". $sites[$i]['NAME'] ." walkabout</p><br />
               ";
          }
        }        
  }  
?>   