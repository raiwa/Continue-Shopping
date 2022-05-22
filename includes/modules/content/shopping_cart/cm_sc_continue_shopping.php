<?php
/*
  $Id$ cm_sc_continue_shopping.php

  Continue Shopping 1.0.8.7
  by @raiwa
  info@oscaddons.com
  www.oscaddons.com
  
  updated for Phoenix Pro by @ecartz

  Copyright (c) 2021: Rainer Schmied - @raiwa

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

  class cm_sc_continue_shopping extends abstract_executable_module {

    const CURRENT_VERSION = '1.0.8.7';
    const CONFIG_KEY_BASE = 'MODULE_CONTENT_SC_CONTINUE_SHOPPING_';

    public function __construct() {
      parent::__construct(__FILE__);

      $this->description .= '<p>v' . static::CURRENT_VERSION . ' by @raiwa <u><a target="_blank" href="http://www.oscaddons.com">www.oscaddons.com</a></u></p>';

    }

    public function execute() {
      $content_width = (int)MODULE_CONTENT_SC_CONTINUE_SHOPPING_CONTENT_WIDTH;

      $backlink = $this->build_backlink();

      $tpl_data = [ 'group' => $this->group, 'file' => __FILE__ ];
      include 'includes/modules/content/cm_template.php';
    }

    protected function build_backlink() {
      $Linker = &Guarantor::ensure_global('Linker');
      $link = $Linker->build('index.php');
      if ( $_SESSION['cart']->count_contents() > 0 ) {
        $products = $_SESSION['cart']->get_products();

        return $link->set_parameter('cPath', $products[count($products) - 1]->find_path());
      }

      if( isset($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'], 'checkout' ) !== false) ) {
        return $link;
      } elseif ($back = $_SESSION['navigation']->path[count($_SESSION['navigation']->path) - 2] ?? false) {
        return $Linker->build($back['page'], $back['get'] ?? []);
      } else {
        return $link;
      }
    }

    protected function get_parameters() {
      return [
        'MODULE_CONTENT_SC_CONTINUE_SHOPPING_STATUS' => [
          'title' => 'Enable Shopping Cart Continue Shopping Button',
          'value' => 'True',
          'desc' => 'Do you want to enable this module?',
          'set_func' => "Config::select_one(['True', 'False'], ",
        ],
        'MODULE_CONTENT_SC_CONTINUE_SHOPPING_CONTENT_WIDTH' => [
          'title' => 'Content Width',
          'value' => '12',
          'desc' => 'What width container should the content be shown in? (12 = full width, 6 = half width).',
          'set_func' => "Config::select_one(['12', '11', '10', '9', '8', '7', '6', '5', '4', '3', '2', '1'], ",
        ],
        'MODULE_CONTENT_SC_CONTINUE_SHOPPING_SORT_ORDER' => [
          'title' => 'Sort Order',
          'value' => '300',
          'desc' => 'Sort order of display. Lowest is displayed first.',
        ],
      ];
    }

  }

