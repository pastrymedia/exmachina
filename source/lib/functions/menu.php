<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Menu Functions
 *
 * menu.php
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

/**
 * Nav Menu Supported
 *
 * Determine if a child theme supports a particular nav menu.
 *
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string $menu Name of the menu to check support for.
 * @return boolean      True if menu supported, false otherwise.
 */
function exmachina_nav_menu_supported( $menu ) {

  /* Return early if no nav menus are supported. */
  if ( ! current_theme_supports( 'exmachina-menus' ) )
    return false;

  /* Get the theme supported menu(s). */
  $menus = get_theme_support( 'exmachina-menus' );

  /* Return true if the theme is supported. */
  if ( array_key_exists( $menu, (array) $menus[0] ) )
    return true;

  /* Otherwise, false. */
  return false;

} // end function exmachina_nav_menu_supported()

/**
 * Echo or return a pages or categories menu.
 *
 * Now only used for backwards-compatibility (exmachina_vestige).
 *
 * The array of menu arguments (and their defaults) are:
 *
 *  - theme_location => ''
 *  - type           => 'pages'
 *  - sort_column    => 'menu_order, post_title'
 *  - menu_id        => false
 *  - menu_class     => 'nav'
 *  - echo           => true
 *  - link_before    => ''
 *  - link_after     => ''
 *
 * Themes can short-circuit the function early by filtering on `exmachina_pre_nav` or on the string of list items via
 * `exmachina_nav_items`. They can also filter the complete menu markup via `exmachina_nav`. The `$args` (merged with
 * defaults) are available for all filters.
 *
 * @todo Delete this function (????)
 *
 * @since 0.5.0
 *
 * @uses exmachina_get_seo_option() Get SEO setting value.
 * @uses exmachina_rel_nofollow()   Add `rel="nofollow"` attribute and value to all links.
 *
 * @see exmachina_do_nav()
 * @see exmachina_do_subnav()
 *
 * @param array $args Menu arguments.
 *
 * @return string HTML for menu, unless `exmachina_pre_nav` returns something truthy.
 */
function exmachina_nav( $args = array() ) {

  if ( isset( $args['context'] ) )
    _deprecated_argument( __FUNCTION__, '1.2', __( 'The argument, "context", has been replaced with "theme_location" in the $args array.', 'exmachina' ) );

  //* Default arguments
  $defaults = array(
    'theme_location' => '',
    'type'           => 'pages',
    'sort_column'    => 'menu_order, post_title',
    'menu_id'        => false,
    'menu_class'     => 'nav',
    'echo'           => true,
    'link_before'    => '',
    'link_after'     => '',
  );

  $defaults = apply_filters( 'exmachina_nav_default_args', $defaults );
  $args     = wp_parse_args( $args, $defaults );

  //* Allow child theme to short-circuit this function
  $pre = apply_filters( 'exmachina_pre_nav', false, $args );
  if ( $pre )
    return $pre;

  $menu = '';

  $list_args = $args;

  //* Show Home in the menu (mostly copied from WP source)
  if ( isset( $args['show_home'] ) && ! empty( $args['show_home'] ) ) {
    if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
      $text = apply_filters( 'exmachina_nav_home_text', __( 'Home', 'exmachina' ), $args );
    else
      $text = $args['show_home'];

    $class = '';

    if ( is_front_page() && ! is_paged() )
      $class = 'class="home current_page_item"';
    else
      $class = 'class="home"';

    $home = '<li ' . $class . '><a href="' . trailingslashit( home_url() ) . '" title="' . esc_attr( $text ) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';

    $menu .= exmachina_get_seo_option( 'nofollow_home_link' ) ? exmachina_rel_nofollow( $home ) : $home;

    //* If the front page is a page, add it to the exclude list
    if ( 'page' === get_option( 'show_on_front' ) && 'pages' === $args['type'] ) {
      $list_args['exclude'] .= $list_args['exclude'] ? ',' : '';

      $list_args['exclude'] .= get_option( 'page_on_front' );
    }
  }

  $list_args['echo']     = false;
  $list_args['title_li'] = '';

  //* Add menu items
  if ( 'pages' === $args['type'] )
    $menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages( $list_args ) );
  elseif ( 'categories' === $args['type'] )
    $menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_categories( $list_args ) );

  //* Apply filters to the nav items
  $menu = apply_filters( 'exmachina_nav_items', $menu, $args );

  $menu_class = ( $args['menu_class'] ) ? ' class="' . esc_attr( $args['menu_class'] ) . '"' : '';
  $menu_id    = ( $args['menu_id'] ) ? ' id="' . esc_attr( $args['menu_id'] ) . '"' : '';

  if ( $menu )
    $menu = '<ul' . $menu_id . $menu_class . '>' . $menu . '</ul>';

  //* Apply filters to the final nav output
  $menu = apply_filters( 'exmachina_nav', $menu, $args );

  if ( $args['echo'] )
    echo $menu;
  else
    return $menu;

} // end function exmachina_nav()
