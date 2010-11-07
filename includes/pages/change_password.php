<?php

  $auth = new Authenticator();

  if (isset($_POST['old_password'])){
      
    $oldPass = md5($_POST['old_password']);
       
    $conn= getConnection();
      
    $query = "
      SELECT U.password
      FROM Users U
      WHERE U.email = '" . $auth->getEmail() . "'";
        
      $stid = oci_parse($conn, $query);
      $err=oci_execute($stid);
      $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
    
    if ($row[0] != $oldPass){
      echo '<p id="error">Please enter correct password</p>';  
      require("fragments/change_password_form.php");
    }
    else{
      if (!isset($_POST['new_password1']) || !isset($_POST['new_password2'])){
        require("fragments/change_password_form.php");  
      }
      else if($_POST['new_password1'] != $_POST['new_password2']){
        echo "The new passwords do not match";  
        require("fragments/change_password_form.php");
      }
      else{
        $newPass = md5($_POST['new_password1']);
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