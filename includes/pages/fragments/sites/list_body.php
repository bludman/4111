<tr>
  <td>
      <a href="index.php?page=site&id=<?php echo $site['ID'];?>">
      <?php echo ($site['NAME'] != null ? htmlentities($site['NAME'], ENT_QUOTES) : "Unknown Site Name"); ?> 
      </a>
  </td>
  <td>
    <?php 
    
    $category='default';
    $icon= array(
      'Building'=>'academic.png',
      'default'=>'question.png'
    );
    ?>
    <img src="<?php echo 'images/icons/'.$icon[$category];?>" alt="This is an icon"/>
  </td>
</tr>
