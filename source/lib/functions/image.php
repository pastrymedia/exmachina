<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Image Functions
 *
 * image.php
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
 * Get Image ID
 *
 * Pull an attachment ID from a post, if one exists.
 *
 * @todo compare against omega/beta function
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Post
 * @link http://codex.wordpress.org/Function_Reference/get_children
 *
 * @since 0.5.0
 * @access public
 *
 * @global object   $post  WP_Post post object.
 * @param  integer  $index Optional. Index image of post. Default is 0.
 * @return int|bool        Returns image ID, or false.
 */
function exmachina_get_image_id( $index = 0 ) {
  global $post;

  /* Get the image IDs from post children. */
  $image_ids = array_keys(
    get_children(
      array(
        'post_parent'    => $post->ID,
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
      )
    )
  );

  /* Return image IDs if they exist. */
  if ( isset( $image_ids[$index] ) )
    return $image_ids[$index];

  /* Otherwise, false. */
  return false;

} // end function exmachina_get_image_id()

/**
 * Get Image
 *
 * Returns an image pulled from the media gallery.
 *
 * Supported $args keys are:
 * - format   - string, default is 'html'
 * - size     - string, default is 'full'
 * - num      - integer, default is 0
 * - attr     - string, default is ''
 * - fallback - mixed, default is 'first-attached'
 *
 * @todo add prefixed filter
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
 * @link http://codex.wordpress.org/Function_Reference/has_post_thumbnail
 * @link http://codex.wordpress.org/Function_Reference/get_post_thumbnail_id
 * @link http://codex.wordpress.org/Function_Reference/wp_get_attachment_image
 * @link http://codex.wordpress.org/Function_Reference/wp_get_attachment_image_src
 * @link http://codex.wordpress.org/Function_Reference/home_url
 *
 * @uses exmachina_get_prefix()   Gets the theme prefix.
 * @uses exmachina_get_image_id() Gets the image ID from the post.
 *
 * @since 1.0.6
 * @access public
 *
 * @global object $post The WP_Post post object.
 * @param  array  $args Optional. Image query arguments.
 * @return string       Returns img element HTML.
 */
function exmachina_get_image( $args = array() ) {
  global $post;

  $defaults = apply_filters( 'exmachina_get_image_default_args', array(
    'format'   => 'html',
    'size'     => 'full',
    'num'      => 0,
    'attr'     => '',
    'fallback' => 'first-attached',
    'context'  => '',
  ) );

  $args = wp_parse_args( $args, $defaults );

  //* Allow child theme to short-circuit this function
  $pre = apply_filters( 'exmachina_pre_get_image', false, $args, $post );
  if ( false !== $pre )
    return $pre;

  //* Check for post image (native WP)
  if ( has_post_thumbnail() && ( 0 === $args['num'] ) ) {
    $id = get_post_thumbnail_id();
    $html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
    list( $url ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
  }
  //* Else if first-attached, pull the first (default) image attachment
  elseif ( 'first-attached' === $args['fallback'] ) {
    $id = exmachina_get_image_id( $args['num'] );
    $html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
    list( $url ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
  }
  //* Else if fallback array exists
  elseif ( is_array( $args['fallback'] ) ) {
    $id   = 0;
    $html = $args['fallback']['html'];
    $url  = $args['fallback']['url'];
  }
  //* Else, return false (no image)
  else {
    return false;
  }

  //* Source path, relative to the root
  $src = str_replace( home_url(), '', $url );

  //* Determine output
  if ( 'html' === mb_strtolower( $args['format'] ) )
    $output = $html;
  elseif ( 'url' === mb_strtolower( $args['format'] ) )
    $output = $url;
  else
    $output = $src;

  // Return false if $url is blank
  if ( empty( $url ) ) $output = false;

  //* Return false if $src is invalid (file doesn't exist)
//  if ( ! file_exists( ABSPATH . $src ) )
//    $output = false;

  //* Return data, filtered
  return apply_filters( 'exmachina_get_image', $output, $args, $id, $html, $url, $src );

} // end function exmachina_get_image()

/**
 * Echo Image
 *
 * Echoes an image pulled from media gallery.
 *
 * Supported $args keys are:
 * - format - string, default is 'html', may be 'url'
 * - size   - string, default is 'full'
 * - num    - integer, default is 0
 * - attr   - string, default is ''
 *
 * @uses exmachina_get_image() Gets the image from the media gallery.
 *
 * @since 1.0.6
 * @access public
 *
 * @param  array  $args Optional. Image query arguments.
 * @return string       Returns the image HTML or URL.
 */
function exmachina_image( $args = array() ) {

  $image = exmachina_get_image( $args );

  if ( $image )
    echo $image;
  else
    return false;

} // end function exmachina_image()

/**
 * Get Additional Image Sizes
 *
 * Returns registered image sizes. Returns a two-dimensional array of just the
 * additionally registered image sizes, with width, height and crop sub-keys.
 *
 * @since 1.0.6
 * @access public
 *
 * @global array $_wp_additional_image_sizes Additionally registered image sizes.
 * @return array                             Returns array of image sizes.
 */
function exmachina_get_additional_image_sizes() {
  global $_wp_additional_image_sizes;

  if ( $_wp_additional_image_sizes )
    return $_wp_additional_image_sizes;

  return array();

} // end function exmachina_get_additional_image_sizes()

/**
 * Get Image Sizes
 *
 * Returns all registered image sizes arrays, including the standard sizes.
 * Returns a two-dimensional array of standard and additionally registered
 * image sizes, with width, height and crop sub-keys.
 *
 * Here, the standard sizes have their sub-keys populated by pulling from the
 * options saved in the database.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_option
 *
 * @uses exmachina_get_additional_image_sizes() Gets image size array.
 *
 * @since 1.0.6
 * @access public
 *
 * @return array Returns array of image sizes.
 */
function exmachina_get_image_sizes() {

  $builtin_sizes = array(
    'large'   => array(
      'width'  => get_option( 'large_size_w' ),
      'height' => get_option( 'large_size_h' ),
    ),
    'medium'  => array(
      'width'  => get_option( 'medium_size_w' ),
      'height' => get_option( 'medium_size_h' ),
    ),
    'thumbnail' => array(
      'width'  => get_option( 'thumbnail_size_w' ),
      'height' => get_option( 'thumbnail_size_h' ),
      'crop'   => get_option( 'thumbnail_crop' ),
    ),
  );

  $additional_sizes = exmachina_get_additional_image_sizes();

  return array_merge( $builtin_sizes, $additional_sizes );

} // end function exmachina_get_image_sizes()