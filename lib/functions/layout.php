<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Layout Functions
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
 * @subpackage  Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

add_action( 'exmachina_init', 'exmachina_create_initial_layouts', 0 );
/**
 * Create Initial Layouts
 *
 * Register ExMachina default layouts. ExMachina comes with six layouts
 * registered by default. These are:
 *
 *  - content-sidebar (default)
 *  - sidebar-content
 *  - content-sidebar-sidebar
 *  - sidebar-sidebar-content
 *  - sidebar-content-sidebar
 *  - full-width-content
 *
 * @todo inline comment
 * @todo docblock comment
 * @todo update layout images
 * @todo compare against hybrid
 * @todo add layout extras
 *
 * @uses exmachina_register_layout() Register a layout in ExMachina.
 * @uses EXMACHINA_ADMIN_IMAGES_URL  URL path to admin images.
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_create_initial_layouts() {

  //* Common path to default layout images
  $url = EXMACHINA_ADMIN_IMAGES_URL . '/layouts/';

  $layouts = apply_filters( 'exmachina_initial_layouts', array(
    'content-sidebar' => array(
      'label'   => __( 'Content-Sidebar', 'exmachina' ),
      'img'     => $url . 'cs.gif',
      'default' => true,
    ),
    'sidebar-content' => array(
      'label' => __( 'Sidebar-Content', 'exmachina' ),
      'img'   => $url . 'sc.gif',
    ),
    'content-sidebar-sidebar' => array(
      'label' => __( 'Content-Sidebar-Sidebar', 'exmachina' ),
      'img'   => $url . 'css.gif',
    ),
    'sidebar-sidebar-content' => array(
      'label' => __( 'Sidebar-Sidebar-Content', 'exmachina' ),
      'img'   => $url . 'ssc.gif',
    ),
    'sidebar-content-sidebar' => array(
      'label' => __( 'Sidebar-Content-Sidebar', 'exmachina' ),
      'img'   => $url . 'scs.gif',
    ),
    'full-width-content' => array(
      'label' => __( 'Full Width Content', 'exmachina' ),
      'img'   => $url . 'c.gif',
    ),
  ), $url );

  foreach ( (array) $layouts as $layout_id => $layout_args )
    exmachina_register_layout( $layout_id, $layout_args );

} // end function exmachina_create_initial_layouts()

/**
 * Register Layout
 *
 * Register new layouts in ExMachina. Modifies the global `$_exmachina_layouts`
 * variable.
 *
 * The support `$args` keys are:
 *
 *  - label (Internationalized name of the layout),
 *  - img   (URL path to layout image),
 *  - type  (Layout type).
 *
 * Although the 'default' key is also supported, the correct way to change the
 * default is via the `exmachina_set_default_layout()` function to ensure only
 * one layout is set as the default at one time.
 *
 * @todo inline comment
 * @todo docblock comment
 * @todo update default images
 *
 * @since 0.5.0
 * @access public
 *
 * @global array  $_exmachina_layouts Holds all layouts data.
 * @param  string $id                 ID of layout.
 * @param  array  $args               Layout data.
 * @return bool|array                 Return false if ID is missing or is already set. Return merged $args otherwise.
 */
function exmachina_register_layout( $id = '', $args = array() ) {
  global $_exmachina_layouts;

  if ( ! is_array( $_exmachina_layouts ) )
    $_exmachina_layouts = array();

  //* Don't allow empty $id, or double registrations
  if ( ! $id || isset( $_exmachina_layouts[$id] ) )
    return false;

  $defaults = array(
    'label' => __( 'No Label Selected', 'exmachina' ),
    'img'   => EXMACHINA_ADMIN_IMAGES_URL . '/layouts/none.gif',
    'type'  => 'site',
  );

  $args = wp_parse_args( $args, $defaults );

  $_exmachina_layouts[$id] = $args;

  return $args;

} // end function exmachina_register_layout()

/**
 * Set Default Layout
 *
 * Allow a user to identify a layout as being the default layout on a new install,
 * as well as serve as the fallback layout.
 *
 * @since 0.5.0
 * @access public
 *
 * @global array  $_exmachina_layouts Holds all layouts data.
 * @param  string $id                 ID of layout to set as default.
 * @return bool|str                   Return false if ID is empty or layout is not registered. Return ID otherwise.
 */
function exmachina_set_default_layout( $id = '' ) {
  global $_exmachina_layouts;

  /* If array doesn't exist, create it. */
  if ( ! is_array( $_exmachina_layouts ) )
    $_exmachina_layouts = array();

  /* Don't allow empty $id, or unregistered layouts. */
  if ( ! $id || ! isset( $_exmachina_layouts[$id] ) )
    return false;

  /* Remove default flag for all other layouts. */
  foreach ( (array) $_exmachina_layouts as $key => $value ) {
    if ( isset( $_exmachina_layouts[$key]['default'] ) )
      unset( $_exmachina_layouts[$key]['default'] );
  } // end foreach

  /* Set the default layout flag. */
  $_exmachina_layouts[$id]['default'] = true;

  /* Return the ID. */
  return $id;

} // end function exmachina_set_default_layout()

/**
 * Unregister Layout
 *
 * Unregister a layout in ExMachina. Modifies the global $_exmachina_layouts
 * variable.
 *
 * @since 0.5.0
 * @access public
 *
 * @global array  $_exmachina_layouts Holds all layout data.
 * @param  string $id                 ID of the layout to unregister.
 * @return boolean                    Returns false if ID is empty, or layout is not registered.
 */
function exmachina_unregister_layout( $id = '' ) {
  global $_exmachina_layouts;

  /* Return early if ID is empty or layout is not registered. */
  if ( ! $id || ! isset( $_exmachina_layouts[$id] ) )
    return false;

  /* Unset the layout. */
  unset( $_exmachina_layouts[$id] );

  /* Return true when complete. */
  return true;

} // end function exmachina_unregister_layout()

/**
 * Get Layouts
 *
 * Return all registered ExMachina layouts.
 *
 * @todo inline comment
 *
 * @since 0.5.0
 * @access public
 *
 * @global array  $_exmachina_layouts Holds all layout data.
 * @param  string $type               Layout type to return. Leave empty to return all types.
 * @return array                      Registered layouts.
 */
function exmachina_get_layouts( $type = '' ) {
  global $_exmachina_layouts;

  //* If no layouts exists, return empty array
  if ( ! is_array( $_exmachina_layouts ) ) {
    $_exmachina_layouts = array();
    return $_exmachina_layouts;
  }

  //* Return all layouts, if no type specified
  if ( '' === $type )
    return $_exmachina_layouts;

  $layouts = array();

  //* Cycle through looking for layouts of $type
  foreach ( (array) $_exmachina_layouts as $id => $data ) {
    if ( $data['type'] === $type )
      $layouts[$id] = $data;
  }

  return $layouts;

} // end function exmachina_get_layouts()

/**
 * Layouts for Customizer
 *
 * Return registered layouts in a format the WordPress Customizer accepts.
 *
 * @uses  exmachina_get_layout() Return all registered ExMachina layouts.
 *
 * @since 0.5.0
 * @access public
 *
 * @global array  $_exmachina_layouts Holds all layout data.
 * @param  string $type               Layout type to return. Leave empty to return all types.
 * @return array                      Registered layouts.
 */
function exmachina_get_layouts_for_customizer( $type = '' ) {

  /* Get the registered layouts. */
  $layouts = exmachina_get_layouts( $type );

  /* Return early is no layouts. */
  if ( empty( $layouts ) )
    return $layouts;

  /* Loop through layouts to retrieve the label. */
  foreach ( (array) $layouts as $id => $data )
    $customizer_layouts[$id] = $data['label'];

  /* Return the simplified array. */
  return $customizer_layouts;

} // end function exmachina_get_layouts_for_customizer()

/**
 * Get Layout
 *
 * Return the data from a single layout, specified by the $id passed to it.
 *
 * @uses exmachina_get_layouts() Return all registered ExMachina layouts.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string     $id ID of the layout to return data for.
 * @return null|array     Returns null if ID is not set, or layout is not registered.
 */
function exmachina_get_layout( $id ) {

  /* Get the registered layouts. */
  $layouts = exmachina_get_layouts();

  /* Return early if ID is not set or layout is not registered. */
  if ( ! $id || ! isset( $layouts[$id] ) )
    return;

  /* Return the layout data array ('label', 'image', 'default') sub-keys.*/
  return $layouts[$id];

} // end function exmachina_get_layout()

/**
 * Get Default Layout
 *
 * Return the layout that is set to default.
 *
 * @since 0.5.0
 * @access public
 *
 * @global array $_exmachina_layouts Holds all layout data.
 * @return string                    Return ID of the layout, or 'nolayout'.
 */
function exmachina_get_default_layout() {
  global $_exmachina_layouts;

  /* Sets default to 'nolayout'. */
  $default = 'nolayout';

  /* Loop through available layouts and set default. */
  foreach ( (array) $_exmachina_layouts as $key => $value ) {
    if ( isset( $value['default'] ) && $value['default'] ) {
      $default = $key;
      break;
    } // end IF statement
  } // end foreach

  /* Return the default layout string. */
  return $default;

} // end function exmachina_get_default_layout()

/**
 * Site Layout
 *
 * Return the site layout for different contexts. Checks both the custom field
 * and the theme option to find the user-selected site layout, and returns it.
 *
 * Applies `exmachina_site_layout` filter early to allow shortcutting of function.
 *
 * @todo inline comment
 * @todo docblock comment
 * @todo add layout extras options
 * @todo compare against hybrid
 * @todo compare against startbox
 * @todo add customizer to mix
 *
 * @uses exmachina_get_custom_field()              Get per-post layout value.
 * @uses exmachina_get_option()                    Get theme setting layout value.
 * @uses exmachina_get_default_layout()            Get default from registered layouts.
 * @uses exmachina_has_post_type_archive_support() Check if a post type supports an archive setting page.
 *
 * @since 0.5.0
 * @access public
 *
 * @global object  $wp_query  WP_Query query object.
 * @param  boolean $use_cache Conditional to use cache or get fresh.
 * @return string             Key of layout.
 */
function exmachina_site_layout( $use_cache = true ) {

  //* Allow child theme to short-circuit this function
  $pre = apply_filters( 'exmachina_site_layout', null );
  if ( null !== $pre )
    return $pre;

  //* If we're supposed to use the cache, setup cache. Use if value exists.
  if ( $use_cache ) {

    //* Setup cache
    static $layout_cache = '';

    //* If cache is populated, return value
    if ( '' !== $layout_cache )
      return esc_attr( $layout_cache );

  }

  global $wp_query;

  //* If viewing a singular page or post
  if ( is_singular() ) {
    $custom_field = exmachina_get_custom_field( '_exmachina_layout' );
    $site_layout  = $custom_field ? $custom_field : exmachina_get_option( 'site_layout' );
  }

  //* If viewing a taxonomy archive
  elseif ( is_category() || is_tag() || is_tax() ) {
    $term = $wp_query->get_queried_object();

    $site_layout = $term && isset( $term->meta['layout'] ) && $term->meta['layout'] ? $term->meta['layout'] : exmachina_get_option( 'site_layout' );
  }

  //* If viewing a supported post type
  elseif ( is_post_type_archive() && exmachina_has_post_type_archive_support() ) {
    $site_layout = exmachina_get_cpt_option( 'layout' ) ? exmachina_get_cpt_option( 'layout' ) : exmachina_get_option( 'site_layout' );
  }

  //* If viewing an author archive
  elseif ( is_author() ) {
    $site_layout = get_the_author_meta( 'layout', (int) get_query_var( 'author' ) ) ? get_the_author_meta( 'layout', (int) get_query_var( 'author' ) ) : exmachina_get_option( 'site_layout' );
  }

  //* Else pull the theme option
  else {
    $site_layout = exmachina_get_option( 'site_layout' );
  }

  //* Use default layout as a fallback, if necessary
  if ( ! exmachina_get_layout( $site_layout ) )
    $site_layout = exmachina_get_default_layout();

  //* Push layout into cache, if caching turned on
  if ( $use_cache )
    $layout_cache = $site_layout;

  //* Return site layout
  return esc_attr( $site_layout );

} // end function exmachina_site_layout()

/**
 * Layout Selector
 *
 * Output the form elements necessary to select a layout. You must manually wrap
 * this in an HTML element with the class of `exmachina-layout-selector` in order
 * for the CSS and JavaScript to apply properly.
 *
 * Supported `$args` keys are:
 *  - name     (default is ''),
 *  - selected (default is ''),
 *  - echo     (default is true).
 *
 * The ExMachina admin script is enqueued to ensure the layout selector behaviour
 * (amending label class to add border on selected layout) works.
 *
 * @todo inline comment
 * @todo docblock comment
 * @todo compare against other layout functions
 *
 * @uses exmachina_get_layouts()   Get all registered layouts.
 * @uses exmachina_load_admin_js() Enqueue the custom script and localizations used in the admin.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array $args Optional. Function arguments. Default is empty array.
 * @return string      HTML markup of labels, images and radio inputs for layout selector.
 */
function exmachina_layout_selector( $args = array() ) {

  //* Enqueue the Javascript
  exmachina_load_admin_js();

  //* Merge defaults with user args
  $args = wp_parse_args(
    $args,
    array(
      'name'     => '',
      'selected' => '',
      'type'     => '',
      'echo'     => true,
    )
  );

  $output = '';

  foreach ( exmachina_get_layouts( $args['type'] ) as $id => $data ) {
    $class = $id == $args['selected'] ? ' selected' : '';

    $output .= sprintf(
      '<label title="%1$s" class="box%2$s"><img src="%3$s" alt="%1$s" /><br /> <input type="radio" name="%4$s" id="%5$s" value="%5$s" %6$s /></label>',
            esc_attr( $data['label'] ),
      esc_attr( $class ),
      esc_url( $data['img'] ),
      esc_attr( $args['name'] ),
      esc_attr( $id ),
      checked( $id, $args['selected'], false )
    );
  }

  //* Echo or return output
  if ( $args['echo'] )
    echo $output;
  else
    return $output;

} // end function exmachina_layout_selector()

/**
 * Structural Wrap
 *
 * Potentially echo or return a structural wrap div. A check is made to see if
 * the `$context` is in the `exmachina-structural-wraps` theme support data. If
 * so, then the `$output` may be echoed or returned.
 *
 * @todo inline comment
 * @todo cleanup function (???)
 *
 * @uses exmachina_attr() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string  $context The location ID.
 * @param  string  $output  Optional. The markup to include. Can also be 'open'
 *                          (default) or 'closed' to use pre-determined markup for consistency.
 * @param  boolean $echo    Optional. Whether to echo or return. Default is true (echo).
 * @return string           Wrap HTML.
 */
function exmachina_structural_wrap( $context = '', $output = 'open', $echo = true ) {

  $wraps = get_theme_support( 'exmachina-structural-wraps' );

  //* If theme doesn't support structural wraps, bail.
  if ( ! $wraps )
    return;

  //* Map of old $contexts to new $contexts
  $map = array(
    'nav'    => 'menu-primary',
    'subnav' => 'menu-secondary',
    'inner'  => 'site-inner',
  );

  //* Make the swap, if necessary
  if ( $swap = array_search( $context, $map ) ) {
    if ( in_array( $swap, $wraps[0] ) )
      $wraps[0] = str_replace( $swap, $map[ $swap ], $wraps[0] );
  }

  if ( ! in_array( $context, (array) $wraps[0] ) )
    return '';

  //* Save original output param
  $original_output = $output;

  switch ( $output ) {
    case 'open':
      $output = sprintf( '<div %s>', exmachina_attr( 'structural-wrap' ) );
      break;
    case 'close':
      $output = '</div>';
      break;
  }

  apply_filters( 'exmachina_structural_wrap-' . $context, $output, $original_output );

  if ( $echo )
    echo $output;
  else
    return $output;

} // end function exmachina_structural_wrap()

/**
 * Return Content-Sidebar
 *
 * Return layout key 'content-sidebar'. Used as shortcut second parameter
 * for `add_filter()`.
 *
 * @since 0.5.0
 * @access public
 *
 * @return string 'content-sidebar'
 */
function __exmachina_return_content_sidebar() {

  return 'content-sidebar';

} // end function __exmachina_return_content_sidebar()

/**
 * Return Sidebar-Content
 *
 * Return layout key 'sidebar-content'. Used as shortcut second parameter
 * for `add_filter()`.
 *
 * @since 0.5.0
 * @access public
 *
 * @return string 'sidebar-content'
 */
function __exmachina_return_sidebar_content() {

  return 'sidebar-content';

} // end function __exmachina_return_sidebar_content()

/**
 * Return Content-Sidebar-Sidebar
 *
 * Return layout key 'content-sidebar-sidebar'. Used as shortcut second parameter
 * for `add_filter()`.
 *
 * @since 0.5.0
 * @access public
 *
 * @return string 'content-sidebar-sidebar'
 */
function __exmachina_return_content_sidebar_sidebar() {

  return 'content-sidebar-sidebar';

} // end function __exmachina_return_content_sidebar_sidebar()

/**
 * Return Sidebar-Sidebar-Content
 *
 * Return layout key 'sidebar-sidebar-content'. Used as shortcut second parameter
 * for `add_filter()`.
 *
 * @since 0.5.0
 * @access public
 *
 * @return string 'sidebar-sidebar-content'
 */
function __exmachina_return_sidebar_sidebar_content() {

  return 'sidebar-sidebar-content';

} // end function __exmachina_return_sidebar_sidebar_content()

/**
 * Return Sidebar-Content-Sidebar
 *
 * Return layout key 'sidebar-content-sidebar'. Used as shortcut second parameter
 * for `add_filter()`.
 *
 * @since 0.5.0
 * @access public
 *
 * @return string 'sidebar-content-sidebar'
 */
function __exmachina_return_sidebar_content_sidebar() {

  return 'sidebar-content-sidebar';

} // end function __exmachina_return_sidebar_content_sidebar()

/**
 * Return Full Width Content
 *
 * Return layout key 'full-width-content'. Used as shortcut second parameter
 * for `add_filter()`.
 *
 * @since 0.5.0
 * @access public
 *
 * @return string 'full-width-content'
 */
function __exmachina_return_full_width_content() {

  return 'full-width-content';

} // end function __exmachina_return_full_width_content()
