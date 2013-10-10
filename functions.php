<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * <[TEMPLATE NAME]> WordPress Theme
 * Main Theme Functions
 *
 * functions.php
 * @link http://codex.wordpress.org/Functions_File_Explained
 *
 * The functions file is used to initialize everything in the theme. It controls
 * how the theme is loaded and sets up the supported features, default actions,
 * and default filters. If making customizations, users should create a child
 * theme and make changes to its functions.php file (not this one).
 *
 * @package     <[TEMPLATE NAME]>
 * @subpackage  Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright(c) 2012-2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com/<[theme-name]>
 */
###############################################################################
# begin functions
###############################################################################

/* Load the core theme framework. */
require ( trailingslashit( get_template_directory() ) . 'library/engine.php' );
new ExMachina();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'optimus_theme_setup' );

/**
 * Theme Setup Function
 *
 * This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 1.0.0
 * @access public
 * @return void
 */
function optimus_theme_setup() {

  /* Get action/filter hook prefix. */
  $prefix = exmachina_get_prefix();

  /* Add theme support for core framework features. */
  add_theme_support( 'exmachina-core-theme-settings', array( 'updates', 'style', 'feeds', 'menus', 'edits', 'blogpage', 'brand', 'breadcrumbs', 'layout', 'archives', 'comments', 'scripts', 'footer', 'about', 'help' ) );

} // end function optimus_theme_setup()