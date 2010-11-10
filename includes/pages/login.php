<h2> This is a LogIn Page </h2>

<?php

  /*
   * ************************************
   * TO DO:
   * Sanatize all variables!
   * *************************************
   */

  if(!isset($_POST['password']) || !isset($_POST['email'])) {
      require("fragments/login_form.php");
    } 
    else {
      
      /*
       * Sanitize
       */
       
      $email = $_POST['email'];
      $password = md5($_POST['password']);
      $conn= getConnection();
      //Query to Find Username/Password in the Database
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
        $err=oci_execute($stid);
         
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
