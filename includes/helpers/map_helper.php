<?php

function outputMapImage($lat,$long)
{
?>
	<div>
	<img width="300" height="100" style="border:1px solid #888888;" src="http://maps.google.com/maps/api/staticmap?center=<?php echo $lat.",".$long?>&amp;size=300x100&amp;maptype=roadmap&amp;markers=color:red|<?php echo $lat.",".$long?>&amp;zoom=15&amp;sensor=false&amp;" />
	</div>
<?php
}

?>
