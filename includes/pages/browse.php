<h2>Browse</h2>

<?php
  include_once("includes/helpers/SiteHelper.php");
	$conn= getConnection();
  //$query="SELECT id,name FROM Sites ORDER BY name";
  
  //$query="SELECT id,name FROM Sites ORDER BY name";
  $query="
  SELECT S.id, S.name, B.type as building_type, E.menu, O.type as open_type, M.site_id as mon_id
  FROM  ((((Sites S
    LEFT OUTER JOIN Buildings B
    ON B.site_id = S.id)
      LEFT OUTER JOIN Eateries E
      ON E.site_id = S.id)
        LEFT OUTER JOIN Open_Spaces O
        ON O.site_id = S.id)
          LEFT OUTER JOIN Monuments M
          ON M.site_id = S.id)
  ORDER BY name";
  
	$stid = oci_parse($conn,$query);
	$err=oci_execute($stid);
  $nrows=oci_fetch_all($stid,$sites,0,-1,OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
  $siteHelper = new SiteHelper;
  $siteHelper->showListOfSites($sites,false,true);
	oci_close($conn);
?>
