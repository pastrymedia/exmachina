<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Media Functions
 *
 * media.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Functions for handling media (i.e., attachments & images) within themes.
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

/* Add all image sizes to the image editor to insert into post. */
add_filter( 'image_size_names_choose', 'exmachina_image_size_names_choose' );

/**
 * Image Size Name Chooser
 *
 * Adds theme/plugin custom images sizes added with add_image_size() to the
 * image uploader/editor. This allows users to insert these images within
 * their post content editor.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
 *
 * @since 1.0.6
 * @access public
 *
 * @param  array $sizes Selectable image sizes.
 * @return array        Array of image sizes.
 */
function exmachina_image_size_names_choose( $sizes ) {

  /* Get all intermediate image sizes. */
  $intermediate_sizes = get_intermediate_image_sizes();
  $add_sizes = array();

  /* Loop through each of the intermediate sizes, adding them to the $add_sizes array. */
  foreach ( $intermediate_sizes as $size )
    $add_sizes[$size] = $size;

  /* Merge the original array, keeping it intact, with the new array of image sizes. */
  $sizes = array_merge( $add_sizes, $sizes );

  /* Return the new sizes plus the old sizes back. */
  return $sizes;

} // end function exmachina_image_size_names_choose()

/* === Attachments === */

/**
 * Attachment Loader
 *
 * Loads the correct function for handling attachments. Checks the attachment
 * mime type to call correct function. Image attachments are not loaded with
 * this function. The functionality for them should be handled by the theme's
 * attachment or image attachment file.
 *
 * Ideally, all attachments would be appropriately handled within their templates.
 * However, this could lead to messy template files.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_get_attachment_url
 * @link http://codex.wordpress.org/Function_Reference/get_post_mime_type
 *
 * @uses apply_atomic() Applies the contextual filter hook.
 *
 * @since 1.0.6
 * @access public
 *
 * @return void
 */
function exmachina_attachment() {
  $file = wp_get_attachment_url();
  $mime = get_post_mime_type();
  $mime_type = explode( '/', $mime );

  /* Loop through each mime type. If a function exists for it, call it. Allow users to filter the display. */
  foreach ( $mime_type as $type ) {
    if ( function_exists( "exmachina_{$type}_attachment" ) )
      $attachment = call_user_func( "exmachina_{$type}_attachment", $mime, $file );

    $attachment = apply_atomic( "{$type}_attachment", $attachment );
  }

  echo apply_atomic( 'attachment', $attachment );

} // end function exmachina_attachment()

/**
 * Application Attachments
 *
 * Handles application attachments on their attachment pages. Uses the <object>
 * tag to embed media on those pages.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_embed_defaults
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 *
 * @since 1.0.6
 * @access public
 *
 * @param  string $mime Attachment mime type.
 * @param  string $file Attachment file URL.
 * @return string       The application attachment markup.
 */
function exmachina_application_attachment( $mime = '', $file = '' ) {

  $embed_defaults = wp_embed_defaults();
  $application = '<object class="text" type="' . esc_attr( $mime ) . '" data="' . esc_url( $file ) . '" width="' . esc_attr( $embed_defaults['width'] ) . '" height="' . esc_attr( $embed_defaults['height'] ) . '">';
  $application .= '<param name="src" value="' . esc_url( $file ) . '" />';
  $application .= '</object>';

  return $application;

} // end function exmachina_application_attachment()

/**
 * Text Attachments
 *
 * Handles text attachments on their attachment pages. Uses the <object> element
 * to embed media in the pages.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_embed_defaults
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 *
 * @since 1.0.6
 * @access public
 *
 * @param  string $mime Attachment mime type.
 * @param  string $file Attachment file URL.
 * @return string       The text attachment markup.
 */
function exmachina_text_attachment( $mime = '', $file = '' ) {

  $embed_defaults = wp_embed_defaults();
  $text = '<object class="text" type="' . esc_attr( $mime ) . '" data="' . esc_url( $file ) . '" width="' . esc_attr( $embed_defaults['width'] ) . '" height="' . esc_attr( $embed_defaults['height'] ) . '">';
  $text .= '<param name="src" value="' . esc_url( $file ) . '" />';
  $text .= '</object>';

  return $text;

} // end function exmachina_text_attachment()

/**
 * Audio Attachments
 *
 * Handles audio attachments on their attachment pages. Puts audio/mpeg and
 * audio/wma files into an <object> element.
 *
 * @link http://codex.wordpress.org/Function_Reference/do_shortcode
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 *
 * @todo Test out and support more audio types.
 *
 * @since 1.0.6
 * @access public
 *
 * @param  string $mime Attachment mime type.
 * @param  string $file Attachment file URL.
 * @return string       The audio attachment markup.
 */
function exmachina_audio_attachment( $mime = '', $file = '' ) {

  return do_shortcode( '[audio src="' . esc_url( $file ) . '"]' );

} // end function exmachina_audio_attachment()

/**
 * Video Attachments
 *
 * Handles video attachments on attachment pages. Add other video types to the
 * <object> element.
 *
 * @link http://codex.wordpress.org/Function_Reference/do_shortcode
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 *
 * @since 1.0.6
 * @access public
 *
 * @param  string $mime Attachment mime type.
 * @param  string $file Attachment file URL.
 * @return string       The video attachment markup.
 */
function exmachina_video_attachment( $mime = false, $file = false ) {

  return do_shortcode( '[video src="' . esc_url( $file ) . '"]' );

} // end function exmachina_video_attachment()
