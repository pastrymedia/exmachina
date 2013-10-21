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

/* Add custom image sizes. */
add_action( 'init', 'exmachina_add_custom_image_sizes' );

/**
 * Image Size Name Chooser
 *
 * Adds theme/plugin custom images sizes added with add_image_size() to the
 * image uploader/editor. This allows users to insert these images within
 * their post content editor.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
 *
 * @since 2.5.0
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


/**
 * Add Custom Image Sizes
 *
 * Adds custom image sizes to be used in post and page templates.
 *
 * @link http://codex.wordpress.org/Function_Reference/add_image_size
 *
 * @since  2.5.0
 * @access public
 *
 * @return void
 */
function exmachina_add_custom_image_sizes() {

	/* Adds the magazine slider image size. */
	add_image_size( 'magazine-slider', 960, 400, true );

} // end function exmachina_add_custom_image_sizes()

/*-------------------------------------------------------------------------*/
/* == Attachment Functions */
/*-------------------------------------------------------------------------*/

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
 * @since 2.5.0
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
 * @since 2.5.0
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
 * @since 2.5.0
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
 * @since 2.5.0
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
 * @since 2.5.0
 * @access public
 *
 * @param  string $mime Attachment mime type.
 * @param  string $file Attachment file URL.
 * @return string       The video attachment markup.
 */
function exmachina_video_attachment( $mime = false, $file = false ) {

  return do_shortcode( '[video src="' . esc_url( $file ) . '"]' );

} // end function exmachina_video_attachment()

/*-------------------------------------------------------------------------*/
/* == Image-related Functions */
/*-------------------------------------------------------------------------*/

/**
 * Get Image ID
 *
 * Pull an attachment ID from a post, if one exists.
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Post
 * @link http://codex.wordpress.org/Function_Reference/get_children
 *
 * @since 2.5.0
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
 * @since 2.5.0
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

  /* Allow child theme to short-circuit this function. */
  $pre = apply_filters( 'exmachina_pre_get_image', false, $args, $post );
  if ( false !== $pre )
    return $pre;

  /* Check for post image (native WP). */
  if ( has_post_thumbnail() && ( 0 === $args['num'] ) ) {
    $id = get_post_thumbnail_id();
    $html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
    list( $url ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
  }
  /* Else if first-attached, pull the first (default) image attachment. */
  elseif ( 'first-attached' === $args['fallback'] ) {
    $id = exmachina_get_image_id( $args['num'] );
    $html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
    list( $url ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
  }
  /* Else if fallback array exists. */
  elseif ( is_array( $args['fallback'] ) ) {
    $id   = 0;
    $html = $args['fallback']['html'];
    $url  = $args['fallback']['url'];
  }
  /* Else, return false (no image). */
  else {
    return false;
  }

  /* Source path, relative to the root. */
  $src = str_replace( home_url(), '', $url );

  /* Determine output. */
  if ( 'html' === mb_strtolower( $args['format'] ) )
    $output = $html;
  elseif ( 'url' === mb_strtolower( $args['format'] ) )
    $output = $url;
  else
    $output = $src;

  /* Return false if $url is blank. */
  if ( empty( $url ) ) $output = false;

  //* Return false if $src is invalid (file doesn't exist)
  // if ( ! file_exists( ABSPATH . $src ) )
  //  $output = false;

  /* Return the filtered data. */
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
 * @since 2.5.0
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
 * @since 2.5.0
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
 * @since 2.5.0
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


/*-------------------------------------------------------------------------*/
/* == Image Meta Functions */
/*-------------------------------------------------------------------------*/

/**
 * Get Image Size Links
 *
 * Returns a set of image attachment links based on size.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_attachment_is_image
 * @link http://codex.wordpress.org/Function_Reference/get_the_ID
 * @link http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
 * @link http://codex.wordpress.org/Function_Reference/wp_get_attachment_image_src
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 *
 * @since  2.5.0
 * @access public
 *
 * @return string Links to various image sizes for the image attachment.
 */
function exmachina_get_image_size_links() {

	/* If not viewing an image attachment page, return. */
	if ( !wp_attachment_is_image( get_the_ID() ) )
		return;

	/* Set up an empty array for the links. */
	$links = array();

	/* Get the intermediate image sizes and add the full size to the array. */
	$sizes = get_intermediate_image_sizes();
	$sizes[] = 'full';

	/* Loop through each of the image sizes. */
	foreach ( $sizes as $size ) {

		/* Get the image source, width, height, and whether it's intermediate. */
		$image = wp_get_attachment_image_src( get_the_ID(), $size );

		/* Add the link to the array if there's an image and if $is_intermediate (4th array value) is true or full size. */
		if ( !empty( $image ) && ( true === $image[3] || 'full' == $size ) )
			$links[] = "<a class='image-size-link' href='" . esc_url( $image[0] ) . "'>{$image[1]} &times; {$image[2]}</a>";
	}

	/* Join the links in a string and return. */
	return join( ' <span class="sep">/</span> ', $links );

} // end function exmachina_get_image_size_links()

/**
 * Get Image Info
 *
 * Displays an attachment image's metadata and exif data while viewing a singular
 * attachment page.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_get_attachment_metadata
 * @link http://codex.wordpress.org/Function_Reference/get_the_ID
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/wp_get_attachment_url
 * @link http://codex.wordpress.org/Function_Reference/get_option
 *
 * @uses apply_atomic() Applies an atomic filter.
 *
 * @since  2.5.0
 * @access public
 *
 * @return void
 */
function exmachina_image_info() {

	/* Set up some default variables and get the image metadata. */
	$meta = wp_get_attachment_metadata( get_the_ID() );
	$items = array();
	$list = '';

	/* Add the width/height to the $items array. */
	$items['dimensions'] = sprintf( __( '<span class="prep">Dimensions:</span> %s', 'exmachina-core' ), '<span class="image-data"><a href="' . esc_url( wp_get_attachment_url() ) . '">' . sprintf( __( '%1$s &#215; %2$s pixels', 'exmachina-core' ), $meta['width'], $meta['height'] ) . '</a></span>' );

	/* If a timestamp exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['created_timestamp'] ) )
		$items['created_timestamp'] = sprintf( __( '<span class="prep">Date:</span> %s', 'exmachina-core' ), '<span class="image-data">' . date( get_option( 'date_format' ), $meta['image_meta']['created_timestamp'] ) . '</span>' );

	/* If a camera exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['camera'] ) )
		$items['camera'] = sprintf( __( '<span class="prep">Camera:</span> %s', 'exmachina-core' ), '<span class="image-data">' . $meta['image_meta']['camera'] . '</span>' );

	/* If an aperture exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['aperture'] ) )
		$items['aperture'] = sprintf( __( '<span class="prep">Aperture:</span> %s', 'exmachina-core' ), '<span class="image-data">' . sprintf( __( 'f/%s', 'exmachina-core' ), $meta['image_meta']['aperture'] ) . '</span>' );

	/* If a focal length is set, add it to the $items array. */
	if ( !empty( $meta['image_meta']['focal_length'] ) )
		$items['focal_length'] = sprintf( __( '<span class="prep">Focal Length:</span> %s', 'exmachina-core' ), '<span class="image-data">' . sprintf( __( '%s mm', 'exmachina-core' ), $meta['image_meta']['focal_length'] ) . '</span>' );

	/* If an ISO is set, add it to the $items array. */
	if ( !empty( $meta['image_meta']['iso'] ) )
		$items['iso'] = sprintf( __( '<span class="prep">ISO:</span> %s', 'exmachina-core' ), '<span class="image-data">' . $meta['image_meta']['iso'] . '</span>' );

	/* If a shutter speed is given, format the float into a fraction and add it to the $items array. */
	if ( !empty( $meta['image_meta']['shutter_speed'] ) ) {

		if ( ( 1 / $meta['image_meta']['shutter_speed'] ) > 1 ) {
			$shutter_speed = '1/';

			if ( number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 1 ) ==  number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 0 ) )
				$shutter_speed .= number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 0, '.', '' );
			else
				$shutter_speed .= number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 1, '.', '' );
		} else {
			$shutter_speed = $meta['image_meta']['shutter_speed'];
		}

		$items['shutter_speed'] = sprintf( __( '<span class="prep">Shutter Speed:</span> %s', 'exmachina-core' ), '<span class="image-data">' . sprintf( __( '%s sec', 'exmachina-core' ), $shutter_speed ) . '</span>' );
	}

	/* Allow devs to overwrite the array of items. */
	$items = apply_atomic( 'image_info_items', $items );

	/* Loop through the items, wrapping each in an <li> element. */
	foreach ( $items as $item )
		$list .= "<li>{$item}</li>";

	/* Format the HTML output of the function. */
	$output = '<div class="image-info"><h3>' . __( 'Image Info', 'exmachina-core' ) . '</h3><ul>' . $list . '</ul></div>';

	/* Display the image info and allow devs to overwrite the final output. */
	echo apply_atomic( 'image_info', $output );

} // end function exmachina_image_info()
