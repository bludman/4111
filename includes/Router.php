<?php

class Router{
	var $pages = array("benb"=>"Tt");

	function renderPage($page)
	{

		if(array_key_exists($page,$this->pages))
			echo "rendering page $page: $this->pages[$page]";
		else
			echo "invalid page";
	}

	function addRouting($pageName,$pagePath)
	{
	print_r(array_keys($this->pages));
		$this->pages["$pageName"]=$pagePath;
print_r(array_keys($this->pages));
	}


}


?>
