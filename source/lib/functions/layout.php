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
