<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2020 osCommerce

  Released under the GNU General Public License
*/

  class bm_best_sellers {
    public $code = 'bm_best_sellers';
    public $group = 'boxes';
    public $title;
    public $description;
    public $sort_order;
    public $enabled = false;

    public function __construct() {
      $this->title = MODULE_BOXES_BEST_SELLERS_TITLE;
      $this->description = MODULE_BOXES_BEST_SELLERS_DESCRIPTION;

      if ($this->check()) {
        $this->sort_order = MODULE_BOXES_BEST_SELLERS_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_BEST_SELLERS_STATUS == 'True');

        $this->group = ((MODULE_BOXES_BEST_SELLERS_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    public function execute() {
      global $current_category_id, $languages_id, $oscTemplate;

      if (!isset($_GET['products_id'])) {
        if (isset($current_category_id) && ($current_category_id > 0)) {
          $best_sellers_query = tep_db_query("select distinct p.products_id, pd.products_name from products p, products_description pd, products_to_categories p2c, categories c where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and '" . (int)$current_category_id . "' in (c.categories_id, c.parent_id) order by p.products_ordered desc, pd.products_name limit " . (int)MODULE_BOXES_BEST_SELLERS_MAX_DISPLAY_PRODUCTS);
        } else {
          $best_sellers_query = tep_db_query("select distinct p.products_id, pd.products_name from products p, products_description pd where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_ordered desc, pd.products_name limit " . (int)MODULE_BOXES_BEST_SELLERS_MAX_DISPLAY_PRODUCTS);
        }

        if (tep_db_num_rows($best_sellers_query) >= MODULE_BOXES_BEST_SELLERS_MIN_DISPLAY_PRODUCTS) {
          $best_sellers_array = array();
          while ($best_sellers = tep_db_fetch_array($best_sellers_query)) {
            $best_sellers_array[] = $best_sellers;
          }

          ob_start();
          include('includes/modules/boxes/templates/best_sellers.php');

          $oscTemplate->addBlock(ob_get_clean(), $this->group);
        }
      }
    }

    public function isEnabled() {
      global $PHP_SELF;

      if (in_array($PHP_SELF, explode(';', MODULE_BOXES_BEST_SELLERS_PAGES))) {
        return $this->enabled;
      }

      return false;
    }

    public function check() {
      return defined('MODULE_BOXES_BEST_SELLERS_STATUS');
    }

    public function install() {
      tep_db_query("INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Best Sellers Module', 'MODULE_BOXES_BEST_SELLERS_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Max number products to display', 'MODULE_BOXES_BEST_SELLERS_MAX_DISPLAY_PRODUCTS', '10', 'Maximum number of best sellers products to display in page.', '6', '0', now())");
      tep_db_query("INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Min number products to display', 'MODULE_BOXES_BEST_SELLERS_MIN_DISPLAY_PRODUCTS', '1', 'Minimum number of best sellers products to display in page.', '6', '0', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Show box on pages', 'MODULE_BOXES_BEST_SELLERS_PAGES', '" . implode(';', tep_set_default_pages()) . "', 'The pages on which box is shown.', '6', '0', 'tep_cfg_show_pages', 'tep_cfg_edit_pages(', now())");
      tep_db_query("INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Content Placement', 'MODULE_BOXES_BEST_SELLERS_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', '6', '0', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Sort Order', 'MODULE_BOXES_BEST_SELLERS_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    public function remove() {
      tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    public function keys() {
      return array('MODULE_BOXES_BEST_SELLERS_STATUS', 'MODULE_BOXES_BEST_SELLERS_MAX_DISPLAY_PRODUCTS', 'MODULE_BOXES_BEST_SELLERS_MIN_DISPLAY_PRODUCTS', 'MODULE_BOXES_BEST_SELLERS_PAGES', 'MODULE_BOXES_BEST_SELLERS_CONTENT_PLACEMENT', 'MODULE_BOXES_BEST_SELLERS_SORT_ORDER');
    }
  }