<?php

class Cleaner{
   
  function sanitizeEmail($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      return false;
      }
    else {
      return $email;
      }
    }
  
  function sanitizePassword($pass) {
    $pass = filter_var($pass, FILTER_VALIDATE_REGEXP, 
      array('options'=>array('regexp'=>'/^[\w -!@#\$%\^&\*\(\)]*$/')));
    if (isset($pass)){
      echo $pass;
      return $pass;
    }
    else{
      return NULL;
    }
  }
  
  function sanitizeWord($word){
    $word = filter_var($word, FILTER_VALIDATE_REGEXP, 
      array('options'=>array('regexp'=>'/^[\w -]*$/')));
    if (isset($word)){
      echo $word;
      return $word;
    }
    else{
      return NULL;
    }
  }
}

?>
