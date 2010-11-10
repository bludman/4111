<h2> THis is a browse page </h2>

<?php
  include_once("includes/helpers/SiteHelper.php");
	$conn= getConnection();
	$stid = oci_parse($conn, 'SELECT name FROM Walkabouts ORDER BY name');
	$err=oci_execute($stid);
  $nrows=oci_fetch_all($stid,$walkabouts,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
  $siteHelper = new SiteHelper;
  
  foreach($walkabouts as $walkabout)
  {
    $stid = oci_parse($conn, "SELECT S.id,S.name FROM comprised_of W, Sites S WHERE S.id= W.site_id AND W.walkabout_name='".$walkabout['NAME']."' ORDER BY name");
    $err=oci_execute($stid);
    $nrows=oci_fetch_all($stid,$sites,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
    echo "<h3>". $walkabout['NAME']."</h3>";
    $siteHelper->showListOfSites($sites);
  }
  
  
	oci_close($conn);
?>
