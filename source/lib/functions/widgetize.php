<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Widgetize Functions
 *
 * widgetize.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * @todo compare against hybrid
 * @todo compare against omega/beta
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
 * Expedites the widget area registration process by taking common things, before / after_widget, before / after_title,
 * and doing them automatically.
 *
 * See the WP function `register_sidebar()` for the list of supports $args keys.
 *
 * A typical usage is:
 *
 * ~~~
 * exmachina_register_sidebar(
 *     array(
 *         'id'          => 'my-sidebar',
 *         'name'        => __( 'My Sidebar', 'my-theme-text-domain' ),
 *         'description' => __( 'A description of the intended purpose or location', 'my-theme-text-domain' ),
 *     )
 * );
 * ~~~
 *
 * @since 0.5.0
 *
 * @uses exmachina_markup() Contextual markup.
 *
 * @param string|array $args Name, ID, description and other widget area arguments.
 *
 * @return string The sidebar ID that was added.
 */
function exmachina_register_sidebar( $args ) {

  $defaults = (array) apply_filters(
    'exmachina_register_sidebar_defaults',
    array(
      'before_widget' => exmachina_markup( array(
        'html' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
        'echo'  => false,
      ) ),
      'after_widget'  => exmachina_markup( array(
        'html' => '</div></section>' . "\n",
        'echo'  => false
      ) ),
      'before_title'  => '<h4 class="widget-title widgettitle">',
      'after_title'   => "</h4>\n",
    ),
    $args
  );

  $args = wp_parse_args( $args, $defaults );

  return register_sidebar( $args );

} // end function exmachina_register_sidebar()

add_action( 'exmachina_setup', '_exmachina_builtin_sidebar_params' );
/**
 * Alters the widget area params array for HTML5 compatibility.
 *
 * @since 0.5.0
 *
 * @global $wp_registered_sidebars
 */
function _exmachina_builtin_sidebar_params() {

  global $wp_registered_sidebars;

  foreach ( $wp_registered_sidebars as $id => $params ) {

    if ( ! isset( $params['_exmachina_builtin'] ) )
      continue;

    $wp_registered_sidebars[ $id ]['before_widget'] = '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">';
    $wp_registered_sidebars[ $id ]['after_widget']  = '</div></section>';

  }

} // end function _exmachina_builtin_sidebar_params()

add_action( 'exmachina_setup', 'exmachina_register_default_widget_areas' );
/**
 * Register the default ExMachina widget areas.
 *
 * @since 0.5.0
 *
 * @uses exmachina_register_sidebar() Register widget areas.
 */
function exmachina_register_default_widget_areas() {

  exmachina_register_sidebar(
    array(
      'id'               => 'header-right',
      'name'             => is_rtl() ? __( 'Header Left', 'exmachina' ) : __( 'Header Right', 'exmachina' ),
      'description'      => __( 'This is the widget area in the header.', 'exmachina' ),
      '_exmachina_builtin' => true,
    )
  );

  exmachina_register_sidebar(
    array(
      'id'               => 'sidebar',
      'name'             => __( 'Primary Sidebar', 'exmachina' ),
      'description'      => __( 'This is the primary sidebar if you are using a two or three column site layout option.', 'exmachina' ),
      '_exmachina_builtin' => true,
    )
  );

  exmachina_register_sidebar(
    array(
      'id'               => 'sidebar-alt',
      'name'             => __( 'Secondary Sidebar', 'exmachina' ),
      'description'      => __( 'This is the secondary sidebar if you are using a three column site layout option.', 'exmachina' ),
      '_exmachina_builtin' => true,
    )
  );

  exmachina_register_sidebar(
    array(
      'id'               => 'after-post',
      'name'             => __( 'After Post', 'exmachina' ),
      'description'      => __( 'This is the after post section.', 'exmachina' ),
      '_exmachina_builtin' => true,
    )
  );

} // end function exmachina_register_default_widget_areas()

add_action( 'exmachina_setup', 'exmachina_register_footer_widget_areas' );
/**
 * Register footer widget areas based on the number of widget areas the user wishes to create with `add_theme_support()`.
 *
 * @since 0.5.0
 *
 * @uses exmachina_register_sidebar() Register footer widget areas.
 *
 * @return null Return early if there's no theme support.
 */
function exmachina_register_footer_widget_areas() {

  $footer_widgets = get_theme_support( 'exmachina-footer-widgets' );

  if ( ! $footer_widgets || ! isset( $footer_widgets[0] ) || ! is_numeric( $footer_widgets[0] ) )
    return;

  $footer_widgets = (int) $footer_widgets[0];

  $counter = 1;

  while ( $counter <= $footer_widgets ) {
    exmachina_register_sidebar(
      array(
        'id'               => sprintf( 'footer-%d', $counter ),
        'name'             => sprintf( __( 'Footer %d', 'exmachina' ), $counter ),
        'description'      => sprintf( __( 'Footer %d widget area.', 'exmachina' ), $counter ),
        '_exmachina_builtin' => true,
      )
    );

    $counter++;
  }

} // end function exmachina_register_footer_widget_areas()

/**
 * Conditionally display a sidebar, wrapped in a div by default.
 *
 * The $args array accepts the following keys:
 *
 *  - `before` (markup to be displayed before the widget area output),
 *  - `after` (markup to be displayed after the widget area output),
 *  - `default` (fallback text if the sidebar is not found, or has no widgets, default is an empty string),
 *  - `show_inactive` (flag to show inactive sidebars, default is false),
 *  - `before_sidebar_hook` (hook that fires before the widget area output),
 *  - `after_sidebar_hook` (hook that fires after the widget area output).
 *
 * Return false early if the sidebar is not active and the `show_inactive` argument is false.
 *
 * @since 0.5.0
 *
 * @param string $id   Sidebar ID, as per when it was registered
 * @param array  $args Arguments.
 *
 * @return boolean False if $args['show_inactive'] set to false and sidebar is not currently being used. True otherwise.
 */
function exmachina_widget_area( $id, $args = array() ) {

  if ( ! $id )
    return false;

  $args = wp_parse_args(
    $args,
    array(
      'before'              => '<aside class="widget-area">',
      'after'               => '</aside>',
      'default'             => '',
      'show_inactive'       => 0,
      'before_sidebar_hook' => 'exmachina_before_' . $id . '_widget_area',
      'after_sidebar_hook'  => 'exmachina_after_' . $id . '_widget_area',
    )
  );

  if ( ! is_active_sidebar( $id ) && ! $args['show_inactive'] )
    return false;

  //* Opening markup
  echo $args['before'];

  //* Before hook
  if ( $args['before_sidebar_hook'] )
      do_action( $args['before_sidebar_hook'] );

  if ( ! dynamic_sidebar( $id ) )
    echo $args['default'];

  //* After hook
  if( $args['after_sidebar_hook'] )
      do_action( $args['after_sidebar_hook'] );

  //* Closing markup
  echo $args['after'];

  return true;

} // end function exmachina_widget_area()