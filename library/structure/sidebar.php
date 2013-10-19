<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Sidebar
 *
 * sidebar.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * DESCRIPTION
 *
 * @package     ExMachina
 * @subpackage  Structure
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################


/* Add the primary sidebars after the main content. */
add_action( exmachina_get_prefix() . '_after_main', 'exmachina_get_primary_sidebar' );

/* Add the secondary sidebars after the main content. */
add_action( exmachina_get_prefix() . '_after_main', 'exmachina_get_secondary_sidebar' );

/* Add the before content sidebars before the content. */
add_action( exmachina_get_prefix() . '_before_content', 'exmachina_get_before_content_sidebar' );

/* Add the after content sidebars after the content. */
add_action( exmachina_get_prefix() . '_after_content', 'exmachina_get_after_content_sidebar' );

/* Add the after singular sidebars after the entry. */
add_action( exmachina_get_prefix() . '_after_entry', 'exmachina_get_after_singular_sidebar' );

/* Filter the sidebar widgets. */
add_filter( 'sidebars_widgets', 'exmachina_disable_sidebars' );
add_action( 'template_redirect', 'exmachina_one_column' );

/**
 * Display sidebar
 */
function exmachina_get_primary_sidebar() {
  //get_sidebar();
  get_template_part( 'partials/sidebar', 'primary' );
  //get_sidebar( 'primary' );
}

/**
 * Display sidebar
 */
function exmachina_get_secondary_sidebar() {
  //get_sidebar();
  get_template_part( 'partials/sidebar', 'secondary' );
  //get_sidebar( 'secondary' );
}

/**
 * Display sidebar
 */
function exmachina_get_before_content_sidebar() {
  //get_sidebar();
  get_template_part( 'partials/sidebar', 'before-content' );
  //get_sidebar( 'before-content' );
}

/**
 * Display sidebar
 */
function exmachina_get_after_content_sidebar() {
  //get_sidebar();
  get_template_part( 'partials/sidebar', 'after-content' );
  //get_sidebar( 'before-content' );
}

/**
 * Display sidebar
 */
function exmachina_get_after_singular_sidebar() {
  //get_sidebar();

  if ( is_single() ) {
    get_template_part( 'partials/sidebar', 'after-singular' );
  }
  //get_sidebar( 'before-content' );
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 * @since 0.1.0
 * @access public
 * @param array $sidebars_widgets A multidimensional array of sidebars and widgets.
 * @return array $sidebars_widgets
 */
function exmachina_disable_sidebars( $sidebars_widgets ) {
  global $wp_customize;

  $customize = ( is_object( $wp_customize ) && $wp_customize->is_preview() ) ? true : false;

  if ( current_theme_supports( 'theme-layouts' ) && !is_admin() && !$customize ) {
    if ( '1c' == get_theme_mod( 'theme_layout' ) ) {
      $sidebars_widgets['primary'] = false;
      $sidebars_widgets['secondary'] = false;
    }
  }

  return $sidebars_widgets;
}

/**
 * Function for deciding which pages should have a one-column layout.
 */
function exmachina_one_column() {

  if ( !is_active_sidebar( 'primary' ) && !is_active_sidebar( 'secondary' ) )
    add_filter( 'theme_mod_theme_layout', 'exmachina_theme_layout_one_column' );

  elseif ( is_attachment() && wp_attachment_is_image() && 'default' == get_post_layout( get_queried_object_id() ) )
    add_filter( 'theme_mod_theme_layout', 'exmachina_theme_layout_one_column' );

  elseif ( is_page_template( 'page/page-template-magazine.php' ) )
    add_filter( 'theme_mod_theme_layout', 'exmachina_theme_layout_one_column' );
}


/**
 * Filters 'get_theme_layout' by returning 'layout-1c'.
 */
function exmachina_theme_layout_one_column( $layout ) {
  return '1c';
}

/* Disables widget areas. */
  add_filter( 'sidebars_widgets', 'exmachina_theme_remove_sidebars' );

/**
 * Removes all widget areas on the No Widgets page/post template.  No widget templates should come in
 * the form of $post_type-no-widgets.php.  This function also provides backwards compatibility with the old
 * no-widgets.php template.
 *
 * @since 0.9.0
 */
function exmachina_theme_remove_sidebars( $sidebars_widgets ) {

  if ( is_singular() ) {
    $post = get_queried_object();

    if ( exmachina_has_post_template( 'no-widgets.php' ) || exmachina_has_post_template( "{$post->post_type}-no-widgets.php" ) )
      $sidebars_widgets = array( false );
  }

  return $sidebars_widgets;
}

