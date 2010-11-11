<h2>This is a Register Page</h2>

<?php

  $mrClean = new Cleaner;

  if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['first_name']) && isset($_POST['last_name'])){
    $pass = $mrClean->sanitize($_POST['password'], Cleaner::PASS_CHARS);
    $first = $mrClean->sanitize($_POST['first_name'], Cleaner::WORD_CHARS);
    $last = $mrClean->sanitize($_POST['last_name'], Cleaner::WORD_CHARS);
    $email = $mrClean->sanitizeEmail($_POST['email']);
  }

  if (empty($email) || empty($pass)){
    require('fragments/register_form.php');  
  }
  else{
    if (empty($first)){
      $first = NULL;
    }
    if (empty($last)){
      $last = NULL;
    }
    $password = md5($pass);
    
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