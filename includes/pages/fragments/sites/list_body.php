<tr>
  <td>
      <a href="index.php?page=site&id=<?php echo $site['ID'];?>">
      <?php echo ($site['NAME'] != null ? htmlentities($site['NAME'], ENT_QUOTES) : "Unknown Site Name"); ?> 
      </a>
  </td>
  <?php 
    $auth= new Authenticator;
    if($showVisited &&  $auth->isLoggedIn()):
  ?>
    <td>
    <?php 
    if(isset($site['VISITED_AT']))
    { 
      //echo "<td>";
      //$site['VISITED_AT']." " .$site['USER_EMAIL'].
      echo "<img src=\"images/icons/checkmark.png\" alt=\"This is an icon\"/>";
      //echo "</td>";
    } 
    ?>
    </td>
  <?php
    endif;
  if($showCategory):
  
  ?>
  <td class="icons">
    <?php 
    
     $category='default';
    
    /*
     * Each site type should only have a single subtype.
     * This could theoretically be changed in the future, 
     * in which case this implementation will need to change. 
     */
    
    if(isset($site['BUILDING_TYPE']))
       $category='Building';
    else if(isset($site['MENU']))
       $category='Eatery';
    else if(isset($site['OPEN_TYPE']))
       $category='Open_Area';
    else if(isset($site['MON_ID']))
       $category='Monument';
    
    
   
    $icon= array(
      'Building'=>'building.png',
      'Eatery'=>'eatery.png',
      'Monument'=>'monument.png',
      'Open_Area'=>'open_area.png',
      'default'=>'question.png'
    );
    ?>
    <img src="<?php echo 'images/icons/'.$icon[$category];?>" alt="Category Icon"/>
    
  </td>
  <?php endif; ?>
  
  
</tr>
