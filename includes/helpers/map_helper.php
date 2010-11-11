<?php

function outputMapImage($lat,$long)
{
?>
	<img width="300" height="300" style="border:1px solid #888888;" src="http://maps.google.com/maps/api/staticmap?center=<?php echo $lat.",".$long?>&amp;size=300x300&amp;maptype=roadmap&amp;markers=color:red|<?php echo $lat.",".$long?>&amp;zoom=17&amp;sensor=false&amp;" />
<?php
}

?>
