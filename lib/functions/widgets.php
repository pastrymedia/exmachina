<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Widget Loader Functions
 *
 * widgets.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
 *
 * @package     ExMachina
 * @subpackage  Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

//* Include widget class files
require_once( EXMACHINA_WIDGETS . '/user-profile-widget.php' );
require_once( EXMACHINA_WIDGETS . '/featured-post-widget.php' );
require_once( EXMACHINA_WIDGETS . '/featured-page-widget.php' );

add_action( 'widgets_init', 'exmachina_load_widgets' );
/**
 * Register widgets for use in the ExMachina theme.
 *
 * @since 0.5.0
 */
function exmachina_load_widgets() {

  register_widget( 'ExMachina_Featured_Page' );
  register_widget( 'ExMachina_Featured_Post' );
  register_widget( 'ExMachina_User_Profile_Widget' );

}

add_action( 'load-themes.php', 'exmachina_remove_default_widgets_from_header_right' );
/**
 * Temporary function to work around the default widgets that get added to
 * Header Right when switching themes.
 *
 * The $defaults array contains a list of the IDs of the widgets that are added
 * to the first sidebar in a new default install. If this exactly matches the
 * widgets in Header Right after switching themes, then they are removed.
 *
 * This works around a perceived WP problem for new installs.
 *
 * If a user amends the list of widgets in the first sidebar before switching to
 * a ExMachina child theme, then this function won't do anything.
 *
 * @since 0.5.0
 *
 * @return null Return early if not just switched to a new theme.
 */
function exmachina_remove_default_widgets_from_header_right() {

  //* Some tomfoolery for a faux activation hook
  if ( ! isset( $_REQUEST['activated'] ) || 'true' !== $_REQUEST['activated'] )
    return;

  $widgets  = get_option( 'sidebars_widgets' );
  $defaults = array( 0 => 'search-2', 1 => 'recent-posts-2', 2 => 'recent-comments-2', 3 => 'archives-2', 4 => 'categories-2', 5 => 'meta-2', );

  if ( isset( $widgets['header-right'] ) && $defaults === $widgets['header-right'] ) {
    $widgets['header-right'] = array();
    update_option( 'sidebars_widgets', $widgets );
  }

}