<h2>This is a Register Page</h2>


<?php

  if (!isset($_POST['email']) || !isset($_POST['password'])){
    require('fragments/register_form.php');  
  }
  else{
    $first = NULL;
    $last = NULL;
    if (isset($_POST['first_name'])){
      $first = $_POST['first_name'];
    }
    if (isset($_POST['last_name'])){
      $last = $_POST['last_name'];
    }
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    /*
     * Sanitize
     */
    
    $token = md5($email . date(DATE_RFC822));
    setcookie("sid", $token);
    setcookie("email", $email); 
    
    $query = "
        INSERT INTO Users
        VALUES ('" . $email . "', '" . $password . "', '" . $first . "', '" . $last . "', '" . $token . "')";
                
    $conn = getConnection();
    $stid = oci_parse($conn, $query);
    $err = oci_execute($stid);
    
    header('Location: index.php'); 
  }
  
  
  
?>