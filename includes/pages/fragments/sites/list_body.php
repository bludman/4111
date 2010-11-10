<tr>
  <td>
      <a href="index.php?page=site&id=<?php echo $site['ID'];?>">
      <?php echo ($site['NAME'] != null ? htmlentities($site['NAME'], ENT_QUOTES) : "Unknown Site Name"); ?> 
      </a>
  </td>
  <td>
  Category information here
  </td>
</tr>
