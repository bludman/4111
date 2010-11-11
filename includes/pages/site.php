<?php
	include_once("includes/helpers/map_helper.php");
	include_once("includes/helpers/menu_helper.php");
  include_once("includes/helpers/SiteHelper.php");
  $siteHelper = new SiteHelper;
	if(!is_numeric($_GET['id']))
		die("shit, injection alert"); //TODO: 404

	$conn= getConnection();
	$stid = oci_parse($conn, "SELECT id,name,description,latitude,longitude FROM Sites S WHERE S.id=".$_GET['id']);
	$err=oci_execute($stid);
	$row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
  $siteId=$row['ID'];
  
  /*
   * Sanitize
   */
  
	showSiteMenu($siteId);
  oci_close($conn);

		echo "<h2><a href=\"index.php?page=site&id=". $row['ID']."\">". 
				($row['NAME'] !== null ? htmlentities($row['NAME'], ENT_QUOTES) : "&nbsp;") . 
				"</a></h2>\n";
        
        showSiteMenu($siteId);
		
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
					$siteHelper->showMoreInfo($siteId);
					break;
      case "bathrooms":
        if($siteHelper->isBuilding($siteId)){
          $siteHelper->showBathrooms($siteId);
        }
        else if($siteHelper->isEatery($siteId))
        {
          $siteHelper->showBathroomsForEatery($siteId);
        }
          
          break;
		}
    
    $auth = new Authenticator();
    
		if ($auth->isLoggedIn()) {
		  echo '
		  <form action="index.php?page=visit" method="post">
        <p><input type="hidden" name="site" value="' . $siteId .'" /></p>
        <input type="submit" value="Visit" />
      </form>
		  ';
		}
    
    
		

		
		





?>
