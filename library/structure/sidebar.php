<?php
/**
 * Hybrid Framework
 *
 * WARNING: This file is part of the core Hybrid Framework DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Hybrid\Sidebars
 * @author  Machina Themes
 * @license GPL-2.0+
 * @link    http://machinathemes.com
 */


/* Add the primary sidebars after the main content. */
add_action( hybrid_get_prefix() . '_after_main', 'hybrid_get_primary_sidebar' );

/* Add the secondary sidebars after the main content. */
add_action( hybrid_get_prefix() . '_after_main', 'hybrid_get_secondary_sidebar' );

/* Add the before content sidebars before the content. */
add_action( hybrid_get_prefix() . '_before_content', 'hybrid_get_before_content_sidebar' );

/* Add the after content sidebars after the content. */
add_action( hybrid_get_prefix() . '_after_content', 'hybrid_get_after_content_sidebar' );

/* Add the after singular sidebars after the entry. */
add_action( hybrid_get_prefix() . '_after_entry', 'hybrid_get_after_singular_sidebar' );

/* Filter the sidebar widgets. */
add_filter( 'sidebars_widgets', 'hybrid_disable_sidebars' );
add_action( 'template_redirect', 'hybrid_one_column' );

/**
 * Display sidebar
 */
function hybrid_get_primary_sidebar() {
  //get_sidebar();
  get_template_part( 'partials/sidebar', 'primary' );
  //get_sidebar( 'primary' );
}

/**
 * Display sidebar
 */
function hybrid_get_secondary_sidebar() {
  //get_sidebar();
  get_template_part( 'partials/sidebar', 'secondary' );
  //get_sidebar( 'secondary' );
}

/**
 * Display sidebar
 */
function hybrid_get_before_content_sidebar() {
  //get_sidebar();
  get_template_part( 'partials/sidebar', 'before-content' );
  //get_sidebar( 'before-content' );
}

/**
 * Display sidebar
 */
function hybrid_get_after_content_sidebar() {
  //get_sidebar();
  get_template_part( 'partials/sidebar', 'after-content' );
  //get_sidebar( 'before-content' );
}

/**
 * Display sidebar
 */
function hybrid_get_after_singular_sidebar() {
  //get_sidebar();

  if ( is_single() ) {
    get_template_part( 'partials/sidebar', 'after-singular' );
  }
  //get_sidebar( 'before-content' );
}

/**
 * Disables sidebars if viewing a one-column page.
 */

function hybrid_disable_sidebars( $sidebars_widgets ) {
  global $wp_customize;

  $customize = ( is_object( $wp_customize ) && $wp_customize->is_preview() ) ? true : false;

  if ( !is_admin() && !$customize && '1c' == get_theme_mod( 'theme_layout' ) )
    $sidebars_widgets['primary'] = false;

  return $sidebars_widgets;
}

/**
 * Function for deciding which pages should have a one-column layout.
 */
function hybrid_one_column() {

  if ( !is_active_sidebar( 'primary' ) )
    add_filter( 'theme_mod_theme_layout', 'hybrid_theme_layout_one_column' );

  elseif ( is_attachment() && wp_attachment_is_image() && 'default' == get_post_layout( get_queried_object_id() ) )
    add_filter( 'theme_mod_theme_layout', 'hybrid_theme_layout_one_column' );

}


/**
 * Filters 'get_theme_layout' by returning 'layout-1c'.
 */
function hybrid_theme_layout_one_column( $layout ) {
  return '1c';
}

