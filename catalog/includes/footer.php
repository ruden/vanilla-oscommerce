<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require(DIR_WS_INCLUDES . 'counter.php');
?>

<div class="grid_24">&nbsp;</div>

<div class="grid_24 footer">
  <?php echo $oscTemplate->getBlocks('footer'); ?>
</div>

<script type="text/javascript">
$('.productListTable tr:nth-child(even)').addClass('alt');
</script>
