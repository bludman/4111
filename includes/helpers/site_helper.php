<?php


function showMoreInfo($siteId)
{
  foreach(determineSubclass($_GET['id']) as $table)
  {
    moreInfo($table);
  }

}

function moreInfo($table)
{
  $con= getConnection();
  echo "<p>table :$table";
  $stid = oci_parse($con, "SELECT * FROM ".$table. " X WHERE X.site_id=".$_GET['id']);
  $err=oci_execute($stid);
  $row = oci_fetch_array($stid,OCI_BOTH+OCI_RETURN_NULLS);
  foreach($row as $field)
  echo "<p>$field";
  oci_close($con);
  
  switch ($table) 
  {
    case "Buildings":
        echo "Building here";
        break;
    case "Eateries":
        echo "Eateries here";
        break;
    case "Open_Spaces":
        echo "Open spaces here";
        break;
    case "Monuments":
      echo "Monuments here";
        break;
  }
}


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
