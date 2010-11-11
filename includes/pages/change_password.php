<?php

  $auth = new Authenticator();
  $mrClean = new Cleaner();
  
  if (isset($_POST['old_password'])){
    $oldPass = $mrClean->sanitize($_POST['old_password'], Cleaner::PASS_CHARS);
  }
  
  if (isset($oldPass)){
          
    $oldPass = md5($oldPass);
       
    $conn= getConnection();
      
    $query = "
      SELECT U.password
      FROM Users U
      WHERE U.email = '" . $auth->getEmail() . "'";
        
      $stid = oci_parse($conn, $query);
      $err=oci_execute($stid);
      $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
    
    if ($row['PASSWORD'] != $oldPass){
      echo '<p id="error">Please enter correct password</p>';  
      require("fragments/change_password_form.php");
    }
    else{
      if (isset($_POST['new_password1']) && isset($_POST['new_password2'])){
        $newPass1 = $mrClean->sanitize($_POST['new_password1'], Cleaner::PASS_CHARS);
        $newPass2 = $mrClean->sanitize($_POST['new_password2'], Cleaner::PASS_CHARS);  
      }
      if (!isset($newPass1) || !isset($newPass2)){
        require("fragments/change_password_form.php");  
      }
      else if($newPass1 != $newPass2){
        echo "The new passwords do not match";  
        require("fragments/change_password_form.php");
      }
      else{
        $newPass = md5($newPass1);
         $query = "
          UPDATE Users
          SET password = '" . $newPass . "'
          WHERE email = '" . $auth->getEmail() . "'";

        $stid = oci_parse($conn, $query);
        $err = oci_execute($stid);

        echo "<p>Password is Changed Succesfully</p>";  
      }
    }     
  }
  else{
    echo "<h2>This is a Change Password Page!</h2>";
    require("fragments/change_password_form.php");
  }


?>