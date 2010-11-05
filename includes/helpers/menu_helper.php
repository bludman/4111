<?php

function showSiteMap($siteId)
{
?>
	<ul class="menu">
		<li><a href="index.php?page=site&id=<?php echo $siteId;?>">Description</a></li>
		<li><a href="index.php?page=site&id=<?php echo $siteId;?>&disp=map">Map</a></li>
		<li><a href="index.php?page=site&id=<?php echo $siteId;?>&disp=other">More Info</a></li>
		<li><a href="index.php?page=site&id=<?php echo $siteId;?>&disp=bathrooms">Bathrooms</a></li>
		<li><a href="index.php?page=site&id=<?php echo $siteId;?>&disp=other">Other</a></li>
		<li><a href="index.php?page=site&id=<?php echo $siteId;?>">Stats</a></li>
	</ul>
<?php
}

?>
