<?php
 
  //Must refactor the shit out of this code. And sanitize! -E
  
  if (isset($_POST['email'])){
    $email = $_POST['email'];
    $conn= getConnection();
    //Query to Find Username/Password in the Database
    $query = "
        SELECT U.email
        FROM Users U
        WHERE U.email = '" . $email . "'";
        
    $stid = oci_parse($conn, $query);
    $err=oci_execute($stid);
    $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
    if (isset($row[0])){
        $newPass = md5(date(DATE_RFC822));
        $md5Pass = md5($newPass);
        $query = "
            UPDATE Users
            SET password = '" . $md5Pass . "'
            WHERE email = '" . $email . "'";
  
        $stid = oci_parse($conn, $query);
        $err = oci_execute($stid);
    
        emailUser($email, $newPass, $email);     
    }
    else{
      echo "Could not find email. Please try again!";
    }
  }  
  else{
    require("fragments/reset_password_form.php");
  }  
  
  function emailUser($email, $newToken, $firstName) {
        
    // subject
    $subject = "Change Password for " . $firstName;
    
    // message
    $body = '
    <html>
    <head>
      <title>Change Password for your CampusWalkabout Account</title>
    </head>
    <body>
      <p>Hi! You have requested a password reset for this account.</p>
      <p>Please return to CampusWalkabout.com and use this password to log in</p>
      <strong>' . $newToken . '</strong>
      <br /><br />
      <p>The CampusWalkabout Team</p>
    </body>
    </html>
    ';
    
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    
    // Additional headers
    $headers .= 'From: CampusWalkabout.com <noreply@campuswalkabout.com>' . "\r\n";   
    
    if (mail($email, $subject, $body, $headers)) {
      echo("<p>Message successfully sent!</p>");
    } 
    else {
      echo("<p>Message delivery failed...</p>");
    } 
  }

?>