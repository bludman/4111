<?php
	include_once("includes/helpers/map_helper.php");
	include_once("includes/helpers/menu_helper.php");
  include_once("includes/helpers/SiteHelper.php");
  $siteHelper = new SiteHelper;
	if(!is_numeric($_GET['id']))
      header('Location: index.php'); 

	$conn= getConnection();
	$stid = oci_parse($conn, "SELECT id,name,description,latitude,longitude FROM Sites S WHERE S.id=".$_GET['id']);
	$err=oci_execute($stid);
	$row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
  $siteId=$row['ID'];
  
  /*
   * Sanitize
   */
  
  oci_close($conn);

		echo "<h2><a href=\"index.php?page=site&id=". $row['ID']."\">". 
				($row['NAME'] !== null ? htmlentities($row['NAME'], ENT_QUOTES) : "&nbsp;") . 
				"</a></h2>\n";
        
    $auth = new Authenticator();
    
    if ($auth->isLoggedIn()) {
      echo '
      <form action="index.php?page=visit" method="post">
        <p><input type="hidden" name="site" value="' . $siteId .'" /></p>
        <input type="submit" value="Visit" />
      </form>
      ';
    }
    
    
    
    showSiteMenu($siteId);
		
		$displayMode= isset($_GET['disp']) ? $_GET['disp'] : "description";
    echo "<div class=\"content\">";
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
          echo '<span style="text-align: left;"';
					$siteHelper->showMoreInfo($siteId);
          
          $conn= getConnection();
          $stid = oci_parse($conn, "SELECT D.* FROM Sites S, Departments D WHERE D.headquartered_in=S.id AND S.id=".$_GET['id']);
          $err=oci_execute($stid);
          $nrows = oci_fetch_all($stid,$departments,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
  
          if($nrows>=1)
          {
            echo "<h3>Departments in this building</h3>";
            echo "<ul>";
            foreach($departments as $dept)
            {
              echo "<li><a href=\"http://www.columbia.edu/cu/bulletin/uwb/subj/".$dept['ACRONYM']."\">".$dept['NAME']."</a></li>";
            }
            echo "</ul>";
          }
          echo '</span>';
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
    
   
    echo "</div>";

?>
