<h2> THis is a browse page </h2>

<?php
  include_once("includes/helpers/SiteHelper.php");
	$conn= getConnection();
	$stid = oci_parse($conn, 'SELECT id,name FROM Sites ORDER BY name');
	$err=oci_execute($stid);
  $nrows=oci_fetch_all($stid,$sites,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
  $siteHelper = new SiteHelper;
  $siteHelper->showListOfSites($sites);
	oci_close($conn);
?>
