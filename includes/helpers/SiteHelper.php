<?php
require_once('includes/connection.php');

class SiteHelper
{
  
  
  public function showListOfSites($listOfSites)
  {
    include('includes/pages/fragments/sites/list_header.php');
    foreach($listOfSites as $site)
    {
        include('includes/pages/fragments/sites/list_body.php');
    }
    include('includes/pages/fragments/sites/list_footer.php');
  }
  
  

  /**
   * Display more info for a site
   */
  public function showMoreInfo($siteId)
  {
    foreach($this->determineSubclass($siteId) as $table)
    {
      $this->moreInfo($siteId,$table);
    }
  
  }
  
  
  public function isBuilding($siteId)
  {
    $con= getConnection();
    $stid = oci_parse($con, "SELECT site_id FROM Buildings WHERE site_id=".$siteId);
    $err=oci_execute($stid);
    
    $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
    return !empty($row);
  }
  
  public function isEatery($siteId)
  {
    $con= getConnection();
    $stid = oci_parse($con, "SELECT site_id FROM Eateries WHERE site_id=".$siteId);
    $err=oci_execute($stid);
    
    $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
    return !empty($row);
  }
  
  public function showBathroomsForEatery($bathroomSiteId)
  {
    $con= getConnection();
    $stid = oci_parse($con, "SELECT building_site_id FROM Eateries WHERE site_id=".$bathroomSiteId);
    $err=oci_execute($stid);
    
    $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
    $this->showBathrooms($row['BUILDING_SITE_ID']);
  }
  
  
  /**
   * Show the bathrooms in a building
   */
  public function showBathrooms($buildingSiteId)
  {
    $con= getConnection();
    $stid = oci_parse($con, "SELECT WC.floor, WC.male, WC.female FROM Bathrooms WC WHERE building_site_id=".$buildingSiteId);
    $err=oci_execute($stid);
    $nrows = oci_fetch_all($stid,$bathrooms,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
      
    if($nrows<=0)
    {
      echo "No bathrooms in this building";
    }
    else
    {
      echo "<table>\n";
       foreach($bathrooms as $wc)
       {
          echo "<tr><td>Floor ". $wc['FLOOR']."</td><td> ";
          echo ($wc['MALE']=='T' ? "<img src=\"images/icons/man.png\" />" :" ");
          echo ($wc['FEMALE']=='T' ? "<img src=\"images/icons/woman.png\" />" :" ");
          echo "</td></tr>\n" ;
       }
      echo "</table>\n";
    }
    oci_close($con);
  }
  
  
  /**
   * Find the extended info associated with this site and display it using it's display fragment
   */
  private function moreInfo($siteId,$table)
  {
    $fields= array(
      'Buildings'=>'address, type, building_access',
      'Eateries'=>'address, menu',
      'Open_Spaces'=>'type',
      'Monuments'=>'artist,year_created'
    );
    
    $fragments= array(
      'Buildings'=>'includes/pages/fragments/sites/building_info.php',
      'Eateries'=>'includes/pages/fragments/sites/eatery_info.php',
      'Open_Spaces'=>'includes/pages/fragments/sites/open_space_info.php',
      'Monuments'=>'includes/pages/fragments/sites/monument_info.php'
    );
    
    $con= getConnection();
    $stid = oci_parse($con, "SELECT ".$fields[$table]." FROM ".$table. " WHERE site_id=".$siteId);
    $err=oci_execute($stid);
    $moreInfo = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
    include($fragments[$table]);
    oci_close($con);
    
  }
  
  
  /**
   * Find which subtypes of Site a site belongs to
   */
  private function determineSubclass($siteId)
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
}
?>
