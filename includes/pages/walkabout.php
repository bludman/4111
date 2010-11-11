<h2><a href="index.php?page=walkabout">Walkabouts</a></h2>

<?php
  include_once("includes/helpers/SiteHelper.php");
  
	$conn= getConnection();
	$siteHelper = new SiteHelper;
  
  
  if(isset($_GET['walkabout']))
  {
      $auth= new Authenticator;
          
          
      /* If user is logged in, collect data to see which of the sites in the walkabout he has visited*/
      if($auth->isLoggedIn())
      {
         $query="
          SELECT * 
          FROM Visits V
          RIGHT OUTER JOIN (
          SELECT S.id,S.name 
          FROM comprised_of W, Sites S 
          WHERE S.id= W.site_id AND W.walkabout_name='".$_GET['walkabout']."' 
          ORDER BY name) P 
          ON P.id=V.site_id AND V.user_email='".$auth->getEmail() ."'";
      }
      /* If the user is not logged in, just show the list of sites  */
      else
      {
        $query="SELECT S.id,S.name FROM comprised_of W, Sites S WHERE S.id= W.site_id AND W.walkabout_name='".$_GET['walkabout']."' ORDER BY name";
      }
        
      $stid = oci_parse($conn,$query);
      $err=oci_execute($stid);
      $nrows=oci_fetch_all($stid,$sites,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
      if($nrows>=1)
      {
        echo "<h3>". $_GET['walkabout']."</h3>";
        $siteHelper->showListOfSites($sites);
      }
      else
      {
        echo "<p>No Matching Walkabout</p>";
      }
          
  }
  else
  {
    $stid = oci_parse($conn, 'SELECT name FROM Walkabouts ORDER BY name');
    $err=oci_execute($stid);
    $nrows=oci_fetch_all($stid,$walkabouts,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);

      
    echo "<ul class=\"menu\">";
    foreach($walkabouts as $walkabout)
    {
      
      echo "<li><a href=\"index.php?page=walkabout&walkabout=". $walkabout['NAME']."\">".$walkabout['NAME']."</li>";
    }
    echo "</ul>";
  }
  
	oci_close($conn);
	
?>
