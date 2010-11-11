<?php

/*
 * Just a Test Unit
 * DOES NOT SHIP!
 */

?>

<form action="tester.php" method="get">
  <p>Sanitize <input type="text" name="sample" /></p>
  <input type="submit" value="Test" />
</form>

<?php

  require('includes/Cleaner.php');
   
  $mrClean = new Cleaner();

  if (isset($_GET['sample'])){
    $mrClean->sanitize($_GET['sample'], Cleaner::NUMBER_CHARS);      
  }
  else{
    echo "Input Test Value<br />";
  }
?>