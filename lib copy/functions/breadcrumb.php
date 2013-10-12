<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Breadcrumb Functions
 *
 * breadcrumb.php
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
 * Breadcrumb Helper
 *
 * Helper function for the ExMachina Breadcrumb Class.
 *
 * @todo inline comment
 * @todo compare against hybrid
 * @todo maybe move to extensions
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $_exmachina_breadcrumb ExMachina_Breadcrumb.
 * @param  array  $args                  Breadcrumb arguments.
 * @return void
 */
function exmachina_breadcrumb( $args = array() ) {
  global $_exmachina_breadcrumb;

  /* If breadcrumb global doesn't exist, instatiate the class. */
  if ( ! $_exmachina_breadcrumb )
    $_exmachina_breadcrumb = new ExMachina_Breadcrumb;

  $_exmachina_breadcrumb->output( $args );

} // end function exmachina_breadcrumb()

add_action( 'exmachina_before_loop', 'exmachina_do_breadcrumbs' );
/**
 * Display Breadcrumbs above the Loop. Concedes priority to popular breadcrumb
 * plugins.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/get_option
 *
 * @uses exmachina_get_option() [description]
 * @uses exmachina_breadcrumb() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return null if a popular breadcrumb plugin is active
 */
function exmachina_do_breadcrumbs() {

  if (
    ( ( 'posts' === get_option( 'show_on_front' ) && is_home() ) && ! exmachina_get_option( 'breadcrumb_home' ) ) ||
    ( ( 'page' === get_option( 'show_on_front' ) && is_front_page() ) && ! exmachina_get_option( 'breadcrumb_front_page' ) ) ||
    ( ( 'page' === get_option( 'show_on_front' ) && is_home() ) && ! exmachina_get_option( 'breadcrumb_posts_page' ) ) ||
    ( is_single() && ! exmachina_get_option( 'breadcrumb_single' ) ) ||
    ( is_page() && ! exmachina_get_option( 'breadcrumb_page' ) ) ||
    ( ( is_archive() || is_search() ) && ! exmachina_get_option( 'breadcrumb_archive' ) ) ||
    ( is_404() && ! exmachina_get_option( 'breadcrumb_404' ) ) ||
    ( is_attachment() && ! exmachina_get_option( 'breadcrumb_attachment' ) )
  )
    return;

  if ( function_exists( 'bcn_display' ) ) {
    echo '<div class="breadcrumb" itemprop="breadcrumb">';
    bcn_display();
    echo '</div>';
  }
  elseif ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<div class="breadcrumb">', '</div>' );
  }
  elseif ( function_exists( 'breadcrumbs' ) ) {
    breadcrumbs();
  }
  elseif ( function_exists( 'crumbs' ) ) {
    crumbs();
  }
  else {
    exmachina_breadcrumb();
  }

} // end function exmachina_do_breadcrumbs()

add_filter( 'exmachina_breadcrumb_args', 'exmachina_custom_breadcrumb_args' );
/**
 * Custom Breadcrumb Arguments
 *
 * Changes the breadcrumb arguments based on what is defined in the the Content
 * Settings.
 *
 * @todo audit breadcrumb arguments
 * @todo maybe rewrite as an array
 *
 * @uses exmachina_get_content_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array $args Breadcrumb arguments.
 * @return array       Modified breadcrumb arguments.
 */
function exmachina_custom_breadcrumb_args( $args ) {

  /* Update the breadcrumb arguments based on the content options. */
  $args['home']                    = exmachina_get_content_option('breadcrumb_home');
  $args['sep']                     = exmachina_get_content_option('breadcrumb_sep');
  $args['list_sep']                = exmachina_get_content_option('breadcrumb_list_sep');
  $args['prefix']                  = exmachina_get_content_option('breadcrumb_prefix');
  $args['suffix']                  = exmachina_get_content_option('breadcrumb_suffix');
  $args['heirarchial_attachments'] = exmachina_get_content_option('breadcrumb_heirarchial_attachments');
  $args['heirarchial_categories']  = exmachina_get_content_option('breadcrumb_heirarchial_categories');
  $args['display']                 = exmachina_get_content_option('breadcrumb_display');
  $args['labels']['prefix']        = exmachina_get_content_option('breadcrumb_label_prefix');
  $args['labels']['author']        = exmachina_get_content_option('breadcrumb_author');
  $args['labels']['category']      = exmachina_get_content_option('breadcrumb_category');
  $args['labels']['tag']           = exmachina_get_content_option('breadcrumb_tag');
  $args['labels']['date']          = exmachina_get_content_option('breadcrumb_date');
  $args['labels']['search']        = exmachina_get_content_option('breadcrumb_search');
  $args['labels']['tax']           = exmachina_get_content_option('breadcrumb_tax');
  $args['labels']['404']           = exmachina_get_content_option('breadcrumb_404');

  /* Return the modified breadcrumb arguments. */
  return $args;

} // end function exmachina_custom_breadcrumb_args()