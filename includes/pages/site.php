<h2> THis is a site page </h2>
<p>ID: <?php echo $_GET['id']; ?> </p>

<?php

	$conn= getConnection();
	$stid = oci_parse($conn, "SELECT id,name FROM Sites S WHERE S.id=$_GET['id']");
	$err=oci_execute($stid);

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





	oci_close($conn);

?>
