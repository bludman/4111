<?php

function showSiteMenu($siteId)
{
?>
	<ul class="menu">
		<li><a href="index.php?page=site&id=<?php echo $siteId;?>">Description</a></li>
		<li><a href="index.php?page=site&id=<?php echo $siteId;?>&disp=map">Map</a></li>
		<li><a href="index.php?page=site&id=<?php echo $siteId;?>&disp=info">More Info</a></li>
		<li><a href="index.php?page=site&id=<?php echo $siteId;?>&disp=bathrooms">Bathrooms</a></li>
	</ul>
<?php
}

?>
