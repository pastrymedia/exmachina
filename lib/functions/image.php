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
 * Return an image pulled from the media gallery.
 *
 * Supported $args keys are:
 *
 *  - format   - string, default is 'html'
 *  - size     - string, default is 'full'
 *  - num      - integer, default is 0
 *  - attr     - string, default is ''
 *  - fallback - mixed, default is 'first-attached'
 *
 * Applies `exmachina_get_image_default_args`, `exmachina_pre_get_image` and `exmachina_get_image` filters.
 *
 * @todo inline comment
 * @todo docblock comment
 * @todo compare against omega/beta
 *
 * @uses exmachina_get_image_id() Pull an attachment ID from a post, if one exists.
 *
 * @since 0.5.0
 * @access public
 *
 * @global object       $post WP_Post post object.
 * @param  array|string $args Optional. Image query arguments. Default is empty array.
 * @return string|bool        Return image element HTML, URL of image, or false.
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
 * Echo an image pulled from the media gallery.
 *
 * Supported $args keys are:
 *
 *  - format - string, default is 'html', may be 'url'
 *  - size   - string, default is 'full'
 *  - num    - integer, default is 0
 *  - attr   - string, default is ''
 *
 * @since 0.1.0
 *
 * @uses exmachina_get_image() Return an image pulled from the media gallery.
 *
 * @param array|string $args Optional. Image query arguments. Default is empty array.
 *
 * @return false Returns false if URL is empty.
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
 * Return registered image sizes. Return a two-dimensional array of just the
 * additionally registered image sizes, with width, height and crop sub-keys.
 *
 * @todo compare against omega/beta
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 * @access public
 *
 * @global array $_wp_additional_image_sizes  Additionally registered image sizes.
 * @return array                              Two-dimensional, with width, height and crop sub-keys.
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
 * Return all registered image sizes arrays, including the standard sizes. Return
 * a two-dimensional array of standard and additionally registered image sizes,
 * with width, height and crop sub-keys. Here, the standard sizes have their
 * sub-keys populated by pulling from the options saved in the database.
 *
 * @todo compare against omega/beta
 * @todo inline comment
 * @todo docblock comment
 *
 * @uses exmachina_get_additional_image_sizes() Return registered image sizes.
 *
 * @since 0.5.0
 * @access public
 *
 * @return array Two-dimensional, with width, height and crop sub-keys.
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