<h2> THis is a browse page </h2>

<?php
  include_once("includes/helpers/SiteHelper.php");
	$conn= getConnection();
	$stid = oci_parse($conn, 'SELECT id,name FROM Sites ORDER BY name');
	$err=oci_execute($stid);


  $nrows=oci_fetch_all($stid,$sites,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
  $siteHelper = new SiteHelper;
  $siteHelper->showListOfSites($sites);
  
/*
	echo "<table border='1'>\n";
	while ($row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS)) 
	{
		echo "<tr>\n";
		 echo "    <td>" .
				"<a href=\"index.php?page=site&id=". $row['ID']."\">". 
				($row['NAME'] !== null ? htmlentities($row['NAME'], ENT_QUOTES) : "&nbsp;") . 
				"</a></td>\n";
	
		 echo "</tr>\n";
	}
	echo "</table>\n";
*/





	oci_close($conn);
?>
