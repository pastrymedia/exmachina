<?php
/**
 * ExMachina Framework.
 *
 * WARNING: This file is part of the core ExMachina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package ExMachina\Shortcodes
 * @author  Machina Themes
 * @license GPL-2.0+
 * @link    http://www.machinathemes.com/
 */

// Search Shortcode
add_shortcode( '404_search', 'exmachina_404_search_shortcode' );
/**
   * Search Shortcode
   *
   * @since 0.5.0
   */
  function exmachina_404_search_shortcode() {
    return '<div class="exmachina-404-search">' . get_search_form( false ) . '</div>';
  }