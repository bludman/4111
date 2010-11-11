<?php

class Cleaner{
  
  const PASS_CHARS = "/^[\w -!@#\$%\^&\*\(\)]*$/";
  const WORD_CHARS = "/^[\w -]*$/";
  const NUMBER_CHARS = "/^[0-9]*$/";
  
  /*
   * sanitize by passing a word to sanitize and choosing one of the constant filters
   */
  function sanitize($input, $string){
    if (isset($input)){
      $input = filter_var($input, FILTER_VALIDATE_REGEXP, 
        array('options'=>array('regexp'=>$string)));
      if (isset($input)){
        return $input;
      }
      else{
        return NULL;
      }
    }
    else{
      return NULL; 
    }
  }
  
  /*
   * Other Option is to sanitize by email
   */
  function sanitizeEmail($email){
    if (isset($email)){
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return false;
      }
      else {
        return $email;
      }
    }
    else{
      return NULL;
    }
  }
  
}

?>
