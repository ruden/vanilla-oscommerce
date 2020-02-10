<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2020 osCommerce

  Released under the GNU General Public License
*/

  class fm_banners {
    public $code;
    public $group;
    public $title;
    public $description;
    public $sort_order;
    public $enabled = false;

    public function __construct() {
      $this->code = get_class($this);
      $this->group = basename(dirname(__FILE__));

      $this->title = MODULE_FOOTER_BANNERS_TITLE;
      $this->description = MODULE_FOOTER_BANNERS_DESCRIPTION;

      if ($this->check()) {
        $this->sort_order = MODULE_FOOTER_BANNERS_SORT_ORDER;
        $this->enabled = (MODULE_FOOTER_BANNERS_STATUS == 'True');
      }
    }

    public function execute() {
      global $oscTemplate;

      if ($banner = tep_banner_exists('dynamic', 'footer')) {
        ob_start();
        include(DIR_WS_MODULES . $this->group . '/templates/banners.php');

        $oscTemplate->addBlock(ob_get_clean(), $this->group);
      }
    }

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return defined('MODULE_FOOTER_BANNERS_STATUS');
    }

    public function install() {
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Module', 'MODULE_FOOTER_BANNERS_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_FOOTER_BANNERS_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    public function remove() {
      tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    public function keys() {
      return array('MODULE_FOOTER_BANNERS_STATUS', 'MODULE_FOOTER_BANNERS_SORT_ORDER');
    }
  }
