<h2>Walkabouts</h2>

<?php
  include_once("includes/helpers/SiteHelper.php");
	$conn= getConnection();
	$stid = oci_parse($conn, 'SELECT name FROM Walkabouts ORDER BY name');
	$err=oci_execute($stid);
  $nrows=oci_fetch_all($stid,$walkabouts,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
  $siteHelper = new SiteHelper;
  
  
  if(isset($_GET['walkabout']) && isset($_GET['n']) && is_numeric($_GET['n']))
  {
    $stid = oci_parse($conn, "SELECT S.id,S.name FROM comprised_of W, Sites S WHERE S.id= W.site_id AND W.walkabout_name='".$_GET['walkabout']."' ORDER BY name");
    $err=oci_execute($stid);
    $nrows=oci_fetch_all($stid,$sites,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
    
    
    $siteIndex=$_GET['n']; //index of this site in walkabout list 
    $nextSiteIndex=$siteIndex+1;
    $prevSiteIndex=$siteIndex-1;
    
    if(0<=$siteIndex && $siteIndex<count($sites))
    { 
      echo "<p>Site ".$siteIndex." is ".$sites[$siteIndex]['NAME']."</p>";
      
      if(0<=$nextSiteIndex && $nextSiteIndex<count($sites))  
        echo "<p>Next site is ".($nextSiteIndex)." ".$sites[$nextSiteIndex]['NAME']."</p>";
      
      if(0<=$prevSiteIndex && $prevSiteIndex<count($sites))  
        echo "<p>Prev site is ".$sites[$prevSiteIndex]['NAME']."</p>";
     
      
     $_GET['id']=$sites[$siteIndex]['ID'];
      include('site.php');
     
      
    }
    else
    {
      echo "<p>Invalid Site</p>";
    }
   
  }
  else
  {
    foreach($walkabouts as $walkabout)
    {
      $stid = oci_parse($conn, "SELECT S.id,S.name FROM comprised_of W, Sites S WHERE S.id= W.site_id AND W.walkabout_name='".$walkabout['NAME']."' ORDER BY name");
      $err=oci_execute($stid);
      $nrows=oci_fetch_all($stid,$sites,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
      echo "<h3>". $walkabout['NAME']."</h3>";
      $siteHelper->showListOfSites($sites);
    }
  }
  
	oci_close($conn);
	
?>
