<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2020 osCommerce

  Released under the GNU General Public License
*/

  $content = 'configure.php';

  $modules = $OSCOM_PayPal->getModules();
  $modules[] = 'G';

  $default_module = 'G';

  foreach ( $modules as $m ) {
    if ( $OSCOM_PayPal->isInstalled($m) ) {
      $default_module = $m;
      break;
    }
  }

  $current_module = (isset($_GET['module']) && in_array($_GET['module'], $modules)) ? $_GET['module'] : $default_module;

  if ( !defined('OSCOM_APP_PAYPAL_TRANSACTIONS_ORDER_STATUS_ID') ) {
    $check_query = tep_db_query("select orders_status_id from orders_status where orders_status_name = 'PayPal [Transactions]' limit 1");

    if (tep_db_num_rows($check_query) < 1) {
      $status_query = tep_db_query("select max(orders_status_id) as status_id from orders_status");
      $status = tep_db_fetch_array($status_query);

      $status_id = $status['status_id']+1;

      $languages = tep_get_languages();

      foreach ($languages as $lang) {
        tep_db_query("insert into orders_status (orders_status_id, language_id, orders_status_name) values ('" . $status_id . "', '" . $lang['id'] . "', 'PayPal [Transactions]')");
      }

      $flags_query = tep_db_query("describe orders_status public_flag");
      if (tep_db_num_rows($flags_query) == 1) {
        tep_db_query("update orders_status set public_flag = 0 and downloads_flag = 0 where orders_status_id = '" . (int)$status_id . "'");
      }
    } else {
      $check = tep_db_fetch_array($check_query);

      $status_id = $check['orders_status_id'];
    }

    $OSCOM_PayPal->saveParameter('OSCOM_APP_PAYPAL_TRANSACTIONS_ORDER_STATUS_ID', $status_id);
  }

  if ( !defined('OSCOM_APP_PAYPAL_VERIFY_SSL') ) {
    $OSCOM_PayPal->saveParameter('OSCOM_APP_PAYPAL_VERIFY_SSL', '1');
  }

  if ( !defined('OSCOM_APP_PAYPAL_PROXY') ) {
    $OSCOM_PayPal->saveParameter('OSCOM_APP_PAYPAL_PROXY', '');
  }

  if ( !defined('OSCOM_APP_PAYPAL_GATEWAY') ) {
    $OSCOM_PayPal->saveParameter('OSCOM_APP_PAYPAL_GATEWAY', '1');
  }

  if ( !defined('OSCOM_APP_PAYPAL_LOG_TRANSACTIONS') ) {
    $OSCOM_PayPal->saveParameter('OSCOM_APP_PAYPAL_LOG_TRANSACTIONS', '1');
  }
?>
