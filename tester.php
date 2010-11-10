<form action="tester.php" method="get">
  <p>Sanitize <input type="text" name="sample" /></p>
  <input type="submit" value="Test" />
</form>


<?php

  require('includes/Cleaner.php');
   
  $mrClean = new Cleaner();

  if (isset($_GET['sample'])){
    $mrClean->sanitizePassword($_GET['sample']);      
  }
  else{
    echo "Input Test Value<br />";
  }
?>