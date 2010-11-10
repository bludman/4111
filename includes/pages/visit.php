<?php     
   $auth = new Authenticator;  
     
   if (isset($_POST['site']) && $auth->isLoggedIn()){
   
     $email = $auth->getEmail();  
     $site_id = $_POST['site'];   
     
     /*
      * Sanitize
      */
        
     $date = date('Y/m/d:h:i:sA');
     
     $query = "
        INSERT INTO Visits (user_email, site_id, visited_at)
        VALUES ('" . $email . "','" . $site_id . "', to_date('". $date . "','yyyy/mm/dd:hh:mi:ssam'))
     ";
               
     $conn = getConnection();
     $stid = oci_parse($conn, $query);
     $err = oci_execute($stid);
     
     $link = "index.php?page=site&id=" . $site_id;
     echo "
     <p>Succesful Check-In!</p><br />
     ";
     echo '<a href="index.php"> Home</a>
     <a href='.$link.'>Back</a>'; 
  }   
?>   