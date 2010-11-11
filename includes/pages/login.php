<h2> This is a LogIn Page </h2>

<?php

  $mrClean = new Cleaner;

  if (isset($_POST['password']) && isset($_POST['email'])){
    $pass = $mrClean->sanitize($_POST['password'], Cleaner::PASS_CHARS);
    $email = $mrClean->sanitizeEmail($_POST['email']);
  }

  if(empty($pass) || empty($email)) {
      require("fragments/login_form.php");
    } 
    else {    
      $password = md5($pass);
      $conn= getConnection();
      //Query to Find Username/Password in the Database
      //The assumption if it finds a row it exists
      $query = "
        SELECT U.email, U.password
        FROM Users U
        WHERE U.email = '" . $email . "'
        AND U.password = '" . $password . "'";
        
      $stid = oci_parse($conn, $query);
      $err=oci_execute($stid);
      $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
      
      //If the row isn't empty then create a Session ID
      if (!empty($row)){
        $token = md5($email . date(DATE_RFC822));
        $query = "
          UPDATE Users
          SET token = '" . $token . "'
          WHERE email = '" . $email . "'";
        
        $stid = oci_parse($conn, $query);
        $err = oci_execute($stid);
         
        //Set both Cookies 
        setcookie("sid", $token);
        setcookie("email", $email);
        
        //Redirect
        header('Location: index.php');        
      }
      else{
        echo "<p>Invalid Username / Password </p>";
        require("fragments/login_form.php");
      } 
    }   
?>
