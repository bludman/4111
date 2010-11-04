<?php

	$conn= getConnection();
	$stid = oci_parse($conn, "SELECT id,name,description,latitude,longitude FROM Sites S WHERE S.id=".$_GET['id']);
	$err=oci_execute($stid);
?>
	<ul>
		<li><a href="index.php?page=login">Description</a></li>
		<li><a href="index.php?page=search">Map</a></li>
		<li><a href="index.php?page=browse">Other</a></li>
		<li><a href="index.php?page=stats">Stats</a></li>
	</ul>

<?php	while ($row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS)) 
	{
		echo "<h2><a href=\"index.php?page=site&id=". $row['ID']."\">". 
				($row['NAME'] !== null ? htmlentities($row['NAME'], ENT_QUOTES) : "&nbsp;") . 
				"</a></h2>\n";

		echo "<p>".($row['NAME'] !== null ? htmlentities($row['DESCRIPTION'], ENT_QUOTES) : "&nbsp;")."</p>\n";
	

?>
	<div><img width="280" height="100" style="border:1px solid #888888;" src="http://maps.google.com/maps/api/staticmap?center=<?php echo $row['LATITUDE'].",".$row['LONGITUDE']?>&amp;size=280x100&amp;maptype=roadmap&amp;markers=color:red|<?php echo $row['LATITUDE'].",".$row['LONGITUDE']?>&amp;zoom=15&amp;sensor=false&amp;" /></div>
    <br />
<?php
}




	oci_close($conn);

?>
