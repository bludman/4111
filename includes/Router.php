<?php

class Router{
	var $pages = array();

	function renderPage($page)
	{
		
		if(array_key_exists(trim($page),$this->pages))
		{
			//echo "rendering page $page: ". $this->pages[$page];
			include($this->pages[$page]);
		}
		else
		{
			echo "invalid page";
		}

	}

	function addRouting($pageName,$pagePath)
	{
		$this->pages[$pageName]=$pagePath;
	}


}


?>
