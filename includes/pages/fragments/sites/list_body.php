<tr>
  <td>
      <a href="index.php?page=site&id=<?php echo $site['ID'];?>">
      <?php echo ($site['NAME'] != null ? htmlentities($site['NAME'], ENT_QUOTES) : "Unknown Site Name"); ?> 
      </a>
  </td>
  <td class="icons">
    <?php 
    
    $category='default';
    $icon= array(
      'Building'=>'building.png',
      'Eatery'=>'eatery.png',
      'Monument'=>'monument.png',
      'Open_Area'=>'open_area.png',
      'default'=>'question.png'
    );
    ?>
    <img src="<?php echo 'images/icons/'.$icon[$category];?>" alt="This is an icon"/>
  </td>
</tr>
