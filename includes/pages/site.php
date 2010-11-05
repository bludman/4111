<?php
	include("includes/helpers/map_helper.php");
	include("includes/helpers/menu_helper.php");
	if(!is_numeric($_GET['id']))
		die("shit, injection alert"); //TODO: 404

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
			case "info":
					$con= getConnection();
					foreach(determineSubclass($_GET['id']) as $table)
					{
									echo "<p>table :$table";
								$stid = oci_parse($con, "SELECT * FROM ".$table. " X WHERE X.site_id=".$_GET['id']);
								$err=oci_execute($stid);
								$row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
								foreach($row as $field)
									echo "<p>$field";
							

					}
					oci_close($con);
					break;
		}

		
		

		
		



	oci_close($conn);

?>


<?php

/**
 * Find which subtypes of Site a site belongs to
 */
function determineSubclass($siteId)
{
	$con= getConnection();
	$tables= array("Buildings","Eateries","Open_Spaces","Monuments");
	$foundOn = array();

	foreach($tables as $table)
	{
		$stid = oci_parse($con, "SELECT S.id FROM Sites S, ".$table." X WHERE X.site_id= S.id AND S.id=".$_GET['id']);
		$err=oci_execute($stid);
		$row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
		if(!empty($row))
			array_push($foundOn , $table);
	}
	
	oci_close($con);

	return $foundOn;

}

?>
