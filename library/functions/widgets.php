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
 * @since 2.5.0
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
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-archives.php' );

  /* Load the authors widget. */
  if ( in_array( 'authors', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-authors.php' );

  /* Load the bookmarks widget class. */
  if ( get_option( 'link_manager_enabled' ) && in_array( 'bookmarks', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-bookmarks.php' );

  /* Load the calendar widget. */
  if ( in_array( 'calendar', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-calendar.php' );

  /* Load the categories widget. */
  if ( in_array( 'categories', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-categories.php' );

  /* Load the nav menu widget. */
  if ( in_array( 'menu', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-nav-menu.php' );

  /* Load the pages widget. */
  if ( in_array( 'pages', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-pages.php' );

  /* Load the search widget. */
  if ( in_array( 'search', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-search.php' );

  /* Load the tag cloud widget. */
  if ( in_array( 'tags', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-tags.php' );

  /* Load the image stream widget. */
  if ( in_array( 'image-stream', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-image-stream.php' );

  /* Load the newsletter widget. */
  if ( in_array( 'newsletter', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-newsletter.php' );

  /* Load the sub-pages widget. */
  if ( in_array( 'sub-pages', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-list-sub-pages.php' );

  /* Load the most commented widget. */
  if ( in_array( 'most-commented', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-most-commented.php' );

  /* Load the image widget. */
  if ( in_array( 'image', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-image.php' );

  /* Load the gallery posts widget. */
  if ( in_array( 'gallery-posts', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-gallery-posts.php' );

  /* Load the image posts widget. */
  if ( in_array( 'image-posts', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-image-posts.php' );

  /* Load the user profile widget. */
  if ( in_array( 'user-profile', $widgets[0] ) )
    require_once( trailingslashit( EXMACHINA_WIDGETS ) . 'widget-user-profile.php' );

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
 * @since 2.5.0
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
 * @since 2.5.0
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
    register_widget( 'ExMachina_Widget_User_Profile' );

  /* Register the image stream widget. */
  if ( in_array( 'image-stream', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Image_Stream' );

  /* Register the newsletter widget. */
  if ( in_array( 'newsletter', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Newsletter' );

  /* Register the sub-pages widget. */
  if ( in_array( 'sub-pages', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_List_Sub_Pages' );

  /* Register the most commented widget. */
  if ( in_array( 'most-commented', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Most_Commented' );

  /* Register the image widget. */
  if ( in_array( 'image', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Image' );

  /* Register the gallery posts widget. */
  if ( in_array( 'gallery-posts', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Gallery_Posts' );

  /* Load the image posts widget. */
  if ( in_array( 'image-posts', $widgets[0] ) )
    register_widget( 'ExMachina_Widget_Image_Posts' );

} // end function exmachina_register_widgets()


add_action( 'load-themes.php', 'exmachina_remove_default_widgets_from_header' );
/**
 * Temporary function to work around the default widgets that get added to
 * Header when switching themes.
 *
 * The $defaults array contains a list of the IDs of the widgets that are added
 * to the first sidebar in a new default install. If this exactly matches the
 * widgets in Header after switching themes, then they are removed.
 *
 * This works around a perceived WP problem for new installs.
 *
 * If a user amends the list of widgets in the first sidebar before switching to
 * a ExMachina child theme, then this function won't do anything.
 *
 * @since 2.5.0
 *
 * @return null Return early if not just switched to a new theme.
 */
function exmachina_remove_default_widgets_from_header() {

  //* Some tomfoolery for a faux activation hook
  if ( ! isset( $_REQUEST['activated'] ) || 'true' !== $_REQUEST['activated'] )
    return;

  $widgets  = get_option( 'sidebars_widgets' );
  $defaults = array( 0 => 'search-2', 1 => 'recent-posts-2', 2 => 'recent-comments-2', 3 => 'archives-2', 4 => 'categories-2', 5 => 'meta-2', );

  if ( isset( $widgets['header'] ) && $defaults === $widgets['header'] ) {
    $widgets['header'] = array();
    update_option( 'sidebars_widgets', $widgets );
  }

}