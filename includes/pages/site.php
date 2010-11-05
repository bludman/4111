<?php
	include("includes/helpers/map_helper.php");
	include("includes/helpers/menu_helper.php");
	$conn= getConnection();
	$stid = oci_parse($conn, "SELECT id,name,description,latitude,longitude FROM Sites S WHERE S.id=".$_GET['id']);
	$err=oci_execute($stid);
	$row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
	showSiteMap($row['ID']);

		echo "<h2><a href=\"index.php?page=site&id=". $row['ID']."\">". 
				($row['NAME'] !== null ? htmlentities($row['NAME'], ENT_QUOTES) : "&nbsp;") . 
				"</a></h2>\n";
		
		$displayMode= isset($_GET['disp']) ? $_GET['disp'] : "description";
		switch ($displayMode) 
		{
			default:
			case "description":
					echo "<div id=\"site_description\">";
					echo "<p>".($row['NAME'] !== null ? htmlentities($row['DESCRIPTION'], ENT_QUOTES) : "&nbsp;")."</p>\n";
					echo "</div>";
					break;
			case "map":
					outputMapImage($row['LATITUDE'],$row['LONGITUDE']);
					break;
			case "image":
					echo "image here";
					break;
		}
		

		
		



	oci_close($conn);

?>
