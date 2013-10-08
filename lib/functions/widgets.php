<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Widget Loader
 *
 * widgets.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Sets up the core framework's widgets and unregisters some of the default
 * WordPress widgets if the theme supports this feature.  The framework's
 * widgets are meant to extend the default WordPress widgets by giving users
 * highly-customizable widget settings. A theme must register support for the
 * 'exmachina-core-widgets' feature to use the framework widgets.
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

/* Load the custom widgets. */
add_action( 'widgets_init', 'exmachina_load_widgets' );

/* Unregister default WP widgets. */
add_action( 'widgets_init', 'exmachina_unregister_widgets' );

/* Register the custom ExMachina widgets. */
add_action( 'widgets_init', 'exmachina_register_widgets' );

/**
 * Load Custom Widgets
 *
 * Includes the custom widget class files if supported by the theme.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/get_option
 *
 * @since 0.6.0
 * @access public
 *
 * @return void
 */
function exmachina_load_widgets() {

  /* Get theme-supported widgets. */
  $widgets = get_theme_support( 'exmachina-core-widgets' );

  /* If there is no array of widget IDs, return. */
  if ( !is_array( $widgets[0] ) )
    return;

  /* Load the archives widget. */
  if ( in_array( 'archives', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'archives-widget.php' );

  /* Load the authors widget. */
  if ( in_array( 'authors', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'authors-widget.php' );

  /* Load the bookmarks widget class. */
  if ( get_option( 'link_manager_enabled' ) && in_array( 'bookmarks', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'bookmarks-widget.php' );

  /* Load the calendar widget. */
  if ( in_array( 'calendar', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'calendar-widget.php' );

  /* Load the categories widget. */
  if ( in_array( 'categories', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'categories-widget.php' );

  /* Load the featured page widget. */
  if ( in_array( 'featured-page', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'featured-page-widget.php' );

  /* Load the featured post widget. */
  if ( in_array( 'featured-post', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'featured-post-widget.php' );

  /* Load the nav menu widget. */
  if ( in_array( 'menu', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'menu-widget.php' );

  /* Load the pages widget. */
  if ( in_array( 'pages', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'pages-widget.php' );

  /* Load the search widget. */
  if ( in_array( 'search', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'search-widget.php' );

  /* Load the tag cloud widget. */
  if ( in_array( 'tags', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'tags-widget.php' );

  /* Load the user profile widget. */
  if ( in_array( 'user-profile', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'user-profile-widget.php' );

} // end function exmachina_load_widgets()

/**
 * Unregister Default WordPress Widgets
 *
 * Unregister default WordPress widgets that are replaced by the framework's
 * widgets. Widgets that aren't replaced by the framework widgets are not
 * unregistered.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/unregister_widget
 *
 * @since 1.0.9
 * @access public
 *
 * @return void
 */
function exmachina_unregister_widgets() {

  /* Get theme-supported widgets. */
  $widgets = get_theme_support( 'exmachina-core-widgets' );

  /* If there is no array of widget IDs, return. */
  if ( !is_array( $widgets[0] ) )
    return;

  /* Unregister the default WP archives widget. */
  if ( in_array( 'archives', $widgets[0] ) )
    unregister_widget( 'WP_Widget_Archives' );

  /* Unregister the default WP calendar widget. */
  if ( in_array( 'calendar', $widgets[0] ) )
    unregister_widget( 'WP_Widget_Calendar' );

  /* Unregister the default WP categories widget. */
  if ( in_array( 'categories', $widgets[0] ) )
    unregister_widget( 'WP_Widget_Categories' );

  /* Unregister the default WP bookmarks widget. */
  if ( in_array( 'bookmarks', $widgets[0] ) )
    unregister_widget( 'WP_Widget_Links' );

  /* Unregister the default WP nav menu widget. */
  if ( in_array( 'menu', $widgets[0] ) )
    unregister_widget( 'WP_Widget_Nav_Menu' );

  /* Unregister the default WP pages widget. */
  if ( in_array( 'pages', $widgets[0] ) )
    unregister_widget( 'WP_Widget_Pages' );

  /* Unregister the default WP search widget. */
  if ( in_array( 'search', $widgets[0] ) )
    unregister_widget( 'WP_Widget_Search' );

  /* Unregister the default WP tag cloud widget. */
  if ( in_array( 'tags', $widgets[0] ) )
    unregister_widget( 'WP_Widget_Tag_Cloud' );

} // end function exmachina_unregister_widgets()

/**
 * Register Custom Widgets
 *
 * Registers the core frameworks widgets. These widgets typically overwrite the
 * equivalent default WordPress widget by extending the available options of the
 * widget. Widgets are only registered if the theme specifically supports them.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/register_widget
 * @link http://codex.wordpress.org/Function_Reference/get_option
 *
 * @since 1.0.9
 * @access public
 *
 * @return void
 */
function exmachina_register_widgets() {

  /* Get theme-supported widgets. */
  $widgets = get_theme_support( 'exmachina-core-widgets' );

  /* If there is no array of widget IDs, return. */
  if ( !is_array( $widgets[0] ) )
    return;

  /* Register the archives widget. */
  if ( in_array( 'archives', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Archives' );

  /* Register the authors widget. */
  if ( in_array( 'authors', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Authors' );

  /* Register the bookmarks widget. */
  if ( get_option( 'link_manager_enabled' ) && in_array( 'bookmarks', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Bookmarks' );

  /* Register the calendar widget. */
  if ( in_array( 'calendar', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Calendar' );

  /* Register the categories widget. */
  if ( in_array( 'categories', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Categories' );

  /* Register the featured page widget. */
  if ( in_array( 'featured-page', $widgets[0] ) )
    register_widget( 'ExMachina_Featured_Page' );

  /* Register the featured post widget. */
  if ( in_array( 'featured-post', $widgets[0] ) )
    register_widget( 'ExMachina_Featured_Post' );

  /* Register the nav menu widget. */
  if ( in_array( 'menu', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Nav_Menu' );

  /* Register the pages widget. */
  if ( in_array( 'pages', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Pages' );

  /* Register the search widget. */
  if ( in_array( 'search', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Search' );

  /* Register the tags widget. */
  if ( in_array( 'tags', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Tags' );

  /* Register the user profile widget. */
  if ( in_array( 'user-profile', $widgets[0] ) )
    register_widget( 'ExMachina_User_Profile_Widget' );

} // end function exmachina_register_widgets()


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