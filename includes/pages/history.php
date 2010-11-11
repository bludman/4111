<?php 
  require('includes/init.php');
  if(!$auth->isLoggedIn())
    header('Location: index.php?page=login'); 
?>


<h2>Stats for <?php echo $auth->getFirstName(); ?></h2>

<?php
  $conn= getConnection();
  $stid = oci_parse($conn, "SELECT S.name,V.site_id, to_char(V.visited_at, 'Dy DD-Mon-YYYY') as d, to_char(V.visited_at, 'HH24:MI:SS') as t FROM Visits V, Sites S WHERE S.id=V.site_id AND user_email='".$auth->getEmail()."' ORDER BY V.visited_at DESC");
  $err=oci_execute($stid);

  echo "<table border='1'>\n";
  while ($row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS)) 
  {
    echo "<tr>\n";
     echo "    <td>" .
        "<a href=\"index.php?page=site&id=". $row['SITE_ID']."\">". 
        ($row['NAME'] !== null ? htmlentities($row['NAME'], ENT_QUOTES) : "&nbsp;") .
        "</a><br /><span class=\"date\"> on ". $row['D']." at ".$row['T']." </span></td>\n";
  
     echo "</tr>\n";
  }
  echo "</table>\n";

  oci_close($conn);
?>
