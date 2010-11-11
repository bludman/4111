<?php 
  require('includes/init.php');
  if(!$auth->isLoggedIn())
    die("No user logged in"); 
    //TODO: Redirect to login
?>


<h2>Stats for <?php echo $auth->getFirstName(); ?></h2>
<h3>Visit Breakdown by Site Type</h3>
<?php
	$conn= getConnection();
	$stid = oci_parse($conn, "SELECT COUNT(*) as c FROM Visits WHERE user_email='".$auth->getEmail()."'");
	$err=oci_execute($stid);
  $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
  $totalVisits=$row['C'];

	
 
  
  $tables= array("Buildings","Eateries","Open_Spaces","Monuments");
  
  foreach($tables as $table)
  {
    $stid = oci_parse($conn, "SELECT COUNT(*) as c FROM Visits V, ".$table." X WHERE V.site_id=X.site_id AND user_email='".$auth->getEmail()."'");
    $err=oci_execute($stid);
    $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
    echo "<p>Total number of $table visits: ".$row['C']."</p>";
  }
  
  echo "Total number of visits: ".$totalVisits;
?>




<h3>Completed Walkabouts</h3>
<ol>
<?php
  $stid = oci_parse($conn, "SELECT walkabout_name FROM Completes WHERE user_email='".$auth->getEmail()."'");
  $err=oci_execute($stid);
  $nrows = oci_fetch_all($stid,$completedWalkabouts,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
  
  
  foreach($completedWalkabouts as $walkabout)
  {
    echo "<li><a href=\"index.php?page=walkabout&walkabout=".$walkabout['WALKABOUT_NAME']."\">".$walkabout['WALKABOUT_NAME']."</a></li>";
  }
  oci_close($conn);
?>
</ol>