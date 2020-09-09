<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2020 osCommerce

  Released under the GNU General Public License
*/

class fm_copyright {
  public $code;
  public $group;
  public $title;
  public $description;
  public $sort_order;
  public $enabled = false;

  public function __construct() {
    $this->code = get_class($this);
    $this->group = basename(dirname(__FILE__));

    $this->title = MODULE_FOOTER_COPYRIGHT_TITLE;
    $this->description = MODULE_FOOTER_COPYRIGHT_DESCRIPTION;

    if ($this->check()) {
      $this->sort_order = MODULE_FOOTER_COPYRIGHT_SORT_ORDER;
      $this->enabled = (MODULE_FOOTER_COPYRIGHT_STATUS == 'True');
    }
  }

  public function execute() {
    global $oscTemplate;

    ob_start();
    include('includes/modules/' . $this->group . '/templates/copyright.php');

    $oscTemplate->addBlock(ob_get_clean(), 'footer_bottom');
  }

  public function isEnabled() {
    return $this->enabled;
  }

  public function check() {
    return defined('MODULE_FOOTER_COPYRIGHT_STATUS');
  }

  public function install() {
    tep_db_query("INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Module', 'MODULE_FOOTER_COPYRIGHT_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
    tep_db_query("INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Sort Order', 'MODULE_FOOTER_COPYRIGHT_SORT_ORDER', '30', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
  }

  public function remove() {
    tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
  }

  public function keys() {
    return array('MODULE_FOOTER_COPYRIGHT_STATUS', 'MODULE_FOOTER_COPYRIGHT_CONTENT_PLACEMENT', 'MODULE_FOOTER_COPYRIGHT_SORT_ORDER');
  }
}