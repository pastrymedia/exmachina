<?php
/**
 * Hybrid Framework
 *
 * WARNING: This file is part of the core Hybrid Framework DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Hybrid\Menus
 * @author  Machina Themes
 * @license GPL-2.0+
 * @link    http://machinathemes.com
 */


 /* Load the primary menu. */
add_action( hybrid_get_prefix() . '_before_header', 'hybrid_get_primary_menu' );

/**
 * Loads the menu-primary.php template.
 */
function hybrid_get_primary_menu() {
  get_template_part( 'partials/menu', 'primary' );
}