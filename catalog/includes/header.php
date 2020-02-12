<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2020 osCommerce

  Released under the GNU General Public License
*/

  if ($messageStack->size('header') > 0) {
    echo '<div class="grid_24">' . $messageStack->output('header') . '</div>';
  }
?>

<div id="header" class="grid_24">
  <div id="storeLogo"><?php echo '<a href="' . tep_href_link('index.php') . '">' . tep_image('images/store_logo.png', STORE_NAME) . '</a>'; ?></div>

  <div id="headerShortcuts">
<?php
  echo tep_draw_button(HEADER_TITLE_CART_CONTENTS . ($cart->count_contents() > 0 ? ' (' . $cart->count_contents() . ')' : ''), 'cart', tep_href_link('shopping_cart.php')) .
       tep_draw_button(HEADER_TITLE_CHECKOUT, 'triangle-1-e', tep_href_link('checkout_shipping.php', '', 'SSL')) .
       tep_draw_button(HEADER_TITLE_MY_ACCOUNT, 'person', tep_href_link('account.php', '', 'SSL'));

  if (tep_session_is_registered('customer_id')) {
    echo tep_draw_button(HEADER_TITLE_LOGOFF, null, tep_href_link('logoff.php', '', 'SSL'));
  }
?>
  </div>

<script type="text/javascript">
  $("#headerShortcuts").buttonset();
</script>
</div>

<div class="grid_24 ui-widget infoBoxContainer">
  <div class="ui-widget-header infoBoxHeading"><?php echo '&nbsp;&nbsp;' . $breadcrumb->trail(' &raquo; '); ?></div>
</div>

<?php
  if (isset($_GET['error_message']) && tep_not_null($_GET['error_message'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="headerError">
    <td class="headerError"><?php echo htmlspecialchars(stripslashes(urldecode($_GET['error_message']))); ?></td>
  </tr>
</table>
<?php
  }

  if (isset($_GET['info_message']) && tep_not_null($_GET['info_message'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="headerInfo">
    <td class="headerInfo"><?php echo htmlspecialchars(stripslashes(urldecode($_GET['info_message']))); ?></td>
  </tr>
</table>
<?php
  }
?>
