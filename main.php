<ul class="menu">
   <li><a href="index.php?page=browse">Browse</a></li>
  <?php
  $auth = new Authenticator;
  if ($auth->isLoggedIn()){
    echo '
      <li><a href="index.php?page=history">History</a></li>
      <li><a href="index.php?page=scrapbook">Scrap Book</a></li>
      <li><a href="index.php?page=change_password">Settings</a></li>
      <li><a href="index.php?page=stats">Stats</a></li> 
    ';
  }
  else{
    echo '
      <li><a href="index.php?page=login">Login</a></li>
    ';
  }
	?>
	 <li><a href="index.php?page=search">Search</a></li>
   <li><a href="index.php?page=walkabout">Walkabouts</a></li>
</ul>
