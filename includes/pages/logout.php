<h2>This is a Logout Page</h2>
<h4>Don't Logout!</h4>

<?php

  $auth = new Authenticator();

    if(!isset($_POST['logout'])) {
      require("fragments/logout_form.php");
    }
  else{
    if($_POST['logout'] == "yes") {
      $token = md5('Eli Rules' . date(DATE_RFC822));
      
      /*
       * Sanitize
       */
      
      $conn = getConnection();
      //Query to Find Username/Password in the Database
      $query = "
        Update Users
        Set token = '" . $token . "'
        WHERE email = '" . $auth->getEmail() . "'";
        
      $stid = oci_parse($conn, $query);
      $err=oci_execute($stid);
      setcookie("sid", "-1");
      header('Location: index.php');
    }
  }
?>