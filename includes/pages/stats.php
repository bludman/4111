<?php 
  require('includes/init.php');
  if(!$auth->isLoggedIn())
    die("No user logged in"); 
    //TODO: Redirect to login
?>


<h2>Stats for <?php echo $auth->getFirstName(); ?></h2>

<?php
	$conn= getConnection();
	$stid = oci_parse($conn, "SELECT COUNT(*) as c FROM Visits WHERE user_email='".$auth->getEmail()."'");
	$err=oci_execute($stid);
  $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);

	echo "Total number of visits: ".$row['C'];
 
  
  $tables= array("Buildings","Eateries","Open_Spaces","Monuments");
  
  foreach($tables as $table)
  {
    $stid = oci_parse($conn, "SELECT COUNT(*) as c FROM Visits V, ".$table." X WHERE V.site_id=X.site_id AND user_email='".$auth->getEmail()."'");
    $err=oci_execute($stid);
    $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
    echo "<p>Total number of $table visits: ".$row['C']."</p>";
  }
  
	oci_close($conn);
?>
