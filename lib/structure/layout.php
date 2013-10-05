<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Layout Structure
 *
 * layout.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
 *
 * @package     ExMachina
 * @subpackage  Structure
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin structure
###############################################################################

/* Filter the content width. */
add_filter( 'content_width', 'exmachina_content_width', 10, 3 );

/* Filter the body class. */
add_filter( 'body_class', 'exmachina_custom_body_class', 15 );
add_filter( 'body_class', 'exmachina_header_body_classes' );
add_filter( 'body_class', 'exmachina_layout_body_classes' );
add_filter( 'body_class', 'exmachina_style_selector_body_classes' );
add_filter( 'body_class', 'exmachina_cpt_archive_body_class', 15 );

/* Add the sidebar layouts. */
add_action( 'exmachina_after_content', 'exmachina_get_sidebar' );
add_action( 'exmachina_after_content_sidebar_wrap', 'exmachina_get_sidebar_alt' );


/**
 * Content Width Filter
 *
 * Filter the content width based on the user selected layout.
 *
 * @todo find where this function is used
 * @todo compare with hybrid width functions
 * @todo maybe remove function
 * @todo inline comment
 *
 * @uses exmachina_site_layout() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  integer $default Default width.
 * @param  integer $small   Small width.
 * @param  integer $large   Large width.
 * @return integer          Content width.
 */
function exmachina_content_width( $default, $small, $large ) {

  switch ( exmachina_site_layout( 0 ) ) {
    case 'full-width-content':
      $width = $large;
      break;
    case 'content-sidebar-sidebar':
    case 'sidebar-content-sidebar':
    case 'sidebar-sidebar-content':
      $width = $small;
      break;
    default:
      $width = $default;
  }

  return $width;

} // end function exmachina_content_width()

/**
 * Custom Body Class
 *
 * Add custom field body class(es) to the body classes. It accepts values from
 * a per-post or per-page custom field, and only outputs when viewing a singular
 * page.
 *
 * @todo test against hybrid body class
 *
 * @uses exmachina_get_custom_field() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $classes Existing body classes.
 * @return array           Amended body classes.
 */
function exmachina_custom_body_class( array $classes ) {

  /* Gets a body class if set in a custom field. */
  $new_class = is_singular() ? exmachina_get_custom_field( '_exmachina_custom_body_class' ) : null;

  /* Add the new class to the array. */
  if ( $new_class )
    $classes[] = esc_attr( $new_class );

  /* Return the body class array. */
  return $classes;

} // end function exmachina_custom_body_class()

/**
 * Header Body Class
 *
 * Add header-* classes to the body class. We can use pseudo-variables in our
 * CSS file, which helps us achieve multiple header layouts with minimal code.
 *
 * @link http://codex.wordpress.org/Designing_Headers
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/get_header_textcolor
 * @link http://codex.wordpress.org/Function_Reference/get_header_image
 * @link http://codex.wordpress.org/Function_Reference/is_active_sidebar
 * @link http://codex.wordpress.org/Function_Reference/has_action
 *
 * @uses exmachina_get_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $classes Existing body classes.
 * @return array           Amended body classes.
 */
function exmachina_header_body_classes( array $classes ) {

  /* If theme supports custom headers, adds the 'custom-header' body class. */
  if ( current_theme_supports( 'custom-header' ) ) {
    if ( get_theme_support( 'custom-header', 'default-text-color' ) !== get_header_textcolor() || get_theme_support( 'custom-header', 'default-image' ) !== get_header_image() )
      $classes[] = 'custom-header';
  } // end IF statement

  /* If theme supports header images, adds the 'header-image' body class. */
  if ( 'image' === exmachina_get_option( 'blog_title' ) || ( get_header_image() && ! display_header_text() ) )
    $classes[] = 'header-image';

  /* If header-right sidebar is inactive, adds the 'header-full-width' body class. */
  if ( ! is_active_sidebar( 'header-right' ) && ! has_action( 'exmachina_header_right' ) )
    $classes[] = 'header-full-width';

  /* Return the body class array. */
  return $classes;

} // end function exmachina_header_body_classes()

/**
 * Layout Body Class
 *
 * Add site layout classes to the body classes. We can use pseudo-variables in
 * our CSS file, which helps us achieve multiple site layouts with minimal code.
 *
 * @uses exmachina_site_layout() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $classes Existing body classes.
 * @return array           Amended body classes.
 */
function exmachina_layout_body_classes( array $classes ) {

  /* Get the site layout. */
  $site_layout = exmachina_site_layout();

  /* Adds the site layout to the body class array. */
  if ( $site_layout )
    $classes[] = $site_layout;

  /* Return the body class array. */
  return $classes;

} // end function exmachina_layout_body_classes()

/**
 * Style Selector Body Class
 *
 * Add style selector classes to the body classes. Enables style selector support
 * in child themes, which helps us achieve multiple site styles with minimal code.
 *
 * @uses exmachina_get_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $classes Existing body classes.
 * @return array           Amended body classes.
 */
function exmachina_style_selector_body_classes( array $classes ) {

  /* Get the style section value. */
  $current = exmachina_get_option( 'style_selection' );

  /* Adds the selected style to the body class array. */
  if ( $current )
    $classes[] = esc_attr( sanitize_html_class( $current ) );

  /* Return the body class array. */
  return $classes;

} // end function exmachina_style_selector_body_classes()

/**
 * CPT Archive Body Class
 *
 * Adds a custom class to the custom post type archive body classes. It accepts
 * a value from the archive settings page.
 *
 * @uses exmachina_has_post_type_archive_support() [description]
 * @uses exmachina_get_cpt_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $classes Existing body classes.
 * @return array           Amended body classes.
 */
function exmachina_cpt_archive_body_class( array $classes ) {

  /* Return early if not on a custom post type archive page. */
  if ( ! is_post_type_archive() || ! exmachina_has_post_type_archive_support() )
    return $classes;

  /* Get the custom post type body class option. */
  $new_class = exmachina_get_cpt_option( 'body_class' );

  /* Adds the body class option to the body class array. */
  if ( $new_class )
    $classes[] = esc_attr( sanitize_html_class( $new_class ) );

  /* Return the body class array. */
  return $classes;

} // end function exmachina_cpt_archive_body_class()

/**
 * Get Sidebar
 *
 * Output the sidebar.php file if layout allows for it.
 *
 * @todo change name to sidebar primary
 * @todo check against hybrid sidebar markup
 *
 * @uses exmachina_site_layout() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_get_sidebar() {

  $site_layout = exmachina_site_layout();

  /* Don't load sidebar on pages that don't need it. */
  if ( 'full-width-content' === $site_layout )
    return;

  get_sidebar();

} // end function exmachina_get_sidebar()

/**
 * Get Alt Sidebar
 *
 * Output the sidebar_alt.php file if layout allows for it.
 *
 * @todo change name to sidebar secondary
 * @todo check against hybrid sidebar markup
 *
 * @uses exmachina_site_layout() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_get_sidebar_alt() {

  $site_layout = exmachina_site_layout();

  /* Don't load sidebar-alt on pages that don't need it. */
  if ( in_array( $site_layout, array( 'content-sidebar', 'sidebar-content', 'full-width-content' ) ) )
    return;

  get_sidebar( 'alt' );

} // end function exmachina_get_sidebar_alt()