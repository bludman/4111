<?php

class Authenticator{

  var $userEmail;
  
  function __construct(){
   
     require_once "includes/connection.php";
   
     if(isset($_COOKIE['sid'])) {
          $cookieSid = $_COOKIE['sid'];
          $email = $_COOKIE['email'];
          
     $query = "
        SELECT U.token
        FROM Users U
        WHERE U.email = '" . $email . "'";
       
      $conn = getConnection();
      $stid = oci_parse($conn, $query);
      $err=oci_execute($stid);
      $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
      
      if ($row[0] == $cookieSid){
        $this->userEmail = $_COOKIE['email'];  
      }
      else{
        $this->userEmail = NULL;
      }
    }
    else{
      $this->userEmail = NULL;  
    }
  }
  
  function isLoggedIn() {
    if ($this->userEmail == NULL){
      return false;
    }
    else{
      return true;
    }   
  }
  
  function getEmail(){
    return $this->userEmail;
  }
  
  /*
   * @Assumption: Not to be called before isLoggedIn()
   */
  function getFirstName(){
    if ($this->isLoggedIn()){
     $query = "
        SELECT U.first_name
        FROM Users U
        WHERE U.email = '" . $this->getEmail() . "'";
       
      $conn = getConnection();
      $stid = oci_parse($conn, $query);
      $err=oci_execute($stid);
      $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
      return $row[0];
    }
    else{
      return NULL;
    }
  
  }
  
  
}      
        



?>