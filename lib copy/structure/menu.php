<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Menu Structure
 *
 * menu.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * @todo maybe add https://github.com/GaryJones/genesis-header-nav
 * @todo add nav extras to secondary menu
 * @todo add menu reordering function
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

/* Register the custom menus. */
add_action( 'after_setup_theme', 'exmachina_register_nav_menus' );

/* Hook the menus to front-end output. */
add_action( 'exmachina_after_header', 'exmachina_do_nav' );
add_action( 'exmachina_after_header', 'exmachina_do_subnav' );

/* Filter the nav menu items. */
add_filter( 'wp_nav_menu_items', 'exmachina_nav_right', 10, 2 );

/**
 * Register Nav Menus
 *
 * Register the custom menu locations, if theme has support for them. Does the
 * `exmachina_register_nav_menus` action.
 *
 * @todo compare against hybrid menu function
 * @todo maybe move this function elsewhere (???)
 * @todo can function be registered on different hook
 *
 * @link http://codex.wordpress.org/Navigation_Menus
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/register_nav_menu
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Returns early if no menus are supported.
 */
function exmachina_register_nav_menus() {

  /* Return early if no menus are supported. */
  if ( ! current_theme_supports( 'exmachina-menus' ) )
    return;

  /* Get the theme supported menus. */
  $menus = get_theme_support( 'exmachina-menus' );

  /* Loop through and register the menus. */
  foreach ( (array) $menus[0] as $id => $name ) {
    register_nav_menu( $id, $name );
  }

  do_action( 'exmachina_register_nav_menus' );

} // end function exmachina_register_nav_menus()

/**
 * Primary Navigation Menu
 *
 * Echo the "Primary Navigation" menu. The preferred option for creating menus
 * is the Custom Menus feature in WordPress.
 *
 * Either output can be filtered via `exmachina_do_nav`.
 *
 * @todo test against hybrid menu function
 * @todo remove xhtml markup
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Navigation_Menus
 * @link http://codex.wordpress.org/Function_Reference/has_nav_menu
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 *
 * @uses exmachina_nav_menu_supported() [description]
 * @uses exmachina_markup() [description]
 * @uses exmachina_structural_wrap() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_do_nav() {

  //* Do nothing if menu not supported
  if ( ! exmachina_nav_menu_supported( 'primary' ) )
    return;

  //* If menu is assigned to theme location, output
  if ( has_nav_menu( 'primary' ) ) {

    $class = 'menu exmachina-nav-menu menu-primary';

    $args = array(
      'theme_location' => 'primary',
      'container'      => '',
      'menu_class'     => $class,
      'echo'           => 0,
    );

    $nav = wp_nav_menu( $args );

    //* Do nothing if there is nothing to show
    if ( ! $nav )
      return;

    $nav_markup_open = exmachina_markup( array(
      'html5'   => '<nav %s>',
      'xhtml'   => '<div id="nav">',
      'context' => 'nav-primary',
      'echo'    => false,
    ) );
    $nav_markup_open .= exmachina_structural_wrap( 'menu-primary', 'open', 0 );

    $nav_markup_close  = exmachina_structural_wrap( 'menu-primary', 'close', 0 );
    $nav_markup_close .= '</nav>';

    $nav_output = $nav_markup_open . $nav . $nav_markup_close;

    echo apply_filters( 'exmachina_do_nav', $nav_output, $nav, $args );

  }

} // end function exmachina_do_nav()

/**
 * Secondary Navigation Menu
 *
 * Echo the "Secondary Navigation" menu. The preferred option for creating menus
 * is the Custom Menus feature in WordPress.
 *
 * Either output can be filtered via `exmachina_do_subnav`.
 *
 * @todo test against hybrid menu function
 * @todo remove xhtml markup
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Navigation_Menus
 * @link http://codex.wordpress.org/Function_Reference/has_nav_menu
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 *
 * @uses exmachina_nav_menu_supported() [description]
 * @uses exmachina_markup() [description]
 * @uses exmachina_structural_wrap() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_do_subnav() {

  //* Do nothing if menu not supported
  if ( ! exmachina_nav_menu_supported( 'secondary' ) )
    return;

  //* If menu is assigned to theme location, output
  if ( has_nav_menu( 'secondary' ) ) {

    $class = 'menu exmachina-nav-menu menu-secondary';

    $args = array(
      'theme_location' => 'secondary',
      'container'      => '',
      'menu_class'     => $class,
      'echo'           => 0,
    );

    $subnav = wp_nav_menu( $args );

    //* Do nothing if there is nothing to show
    if ( ! $subnav )
      return;

    $subnav_markup_open = exmachina_markup( array(
      'html5'   => '<nav %s>',
      'xhtml'   => '<div id="subnav">',
      'context' => 'nav-secondary',
      'echo'    => false,
    ) );
    $subnav_markup_open .= exmachina_structural_wrap( 'menu-secondary', 'open', 0 );

    $subnav_markup_close  = exmachina_structural_wrap( 'menu-secondary', 'close', 0 );
    $subnav_markup_close .= '</nav>';

    $subnav_output = $subnav_markup_open . $subnav . $subnav_markup_close;

    echo apply_filters( 'exmachina_do_subnav', $subnav_output, $subnav, $args );

  }

} // end function exmachina_do_subnav()

/**
 * Primary Menu Extras
 *
 * Filter the Primary Navigation menu items, appending either RSS links, search
 * form, twitter link, or today's date.
 *
 * @todo inline comment
 * @todo get additional extras
 * @todo research plugins for functionality
 * @todo research output buffering
 *
 * @link http://codex.wordpress.org/Navigation_Menus
 * @link http://codex.wordpress.org/Function_Reference/get_bloginfo
 * @link http://codex.wordpress.org/Function_Reference/get_search_form
 * @link http://codex.wordpress.org/Function_Reference/date_i18n
 * @link http://codex.wordpress.org/Function_Reference/get_option
 *
 * @uses exmachina_get_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string   $menu HTML string of list items.
 * @param  stdClass $args Menu arguments.
 * @return string         Amended HTML list of string items.
 */
function exmachina_nav_right( $menu, stdClass $args ) {

  if ( ! exmachina_get_option( 'nav_extras' ) || 'primary' !== $args->theme_location )
    return $menu;

  switch ( exmachina_get_option( 'nav_extras' ) ) {
    case 'rss':
      $rss   = '<a rel="nofollow" href="' . get_bloginfo( 'rss2_url' ) . '">' . __( 'Posts', 'exmachina' ) . '</a>';
      $rss  .= '<a rel="nofollow" href="' . get_bloginfo( 'comments_rss2_url' ) . '">' . __( 'Comments', 'exmachina' ) . '</a>';
      $menu .= '<li class="right rss">' . $rss . '</li>';
      break;
    case 'search':
      // I hate output buffering, but I have no choice
      ob_start();
      get_search_form();
      $search = ob_get_clean();
      $menu  .= '<li class="right search">' . $search . '</li>';
      break;
    case 'twitter':
      $menu .= sprintf( '<li class="right twitter"><a href="%s">%s</a></li>', esc_url( 'http://twitter.com/' . exmachina_get_option( 'nav_extras_twitter_id' ) ), esc_html( exmachina_get_option( 'nav_extras_twitter_text' ) ) );
      break;
    case 'date':
      $menu .= '<li class="right date">' . date_i18n( get_option( 'date_format' ) ) . '</li>';
      break;
  }

  return $menu;

} // end function exmachina_nav_right()