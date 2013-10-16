<?php
/**
 * @package Images
 * @license GPL-2.0+
 */

/**
 * Pulls an attachment ID from a post, if one exists.
 *
 * @since 0.1.0
 *
 * @global WP_Post $post Post object.
 *
 * @param integer $index Optional. Index of which image to return from a post. Default is 0
 * @return integer|boolean Returns image ID, or false if image with given index does not exist
 */
function exmachina_get_image_id( $index = 0 ) {

	global $post;

	$image_ids = array_keys(
		get_children(
			array(
				'post_parent'    => $post->ID,
				'post_type'	     => 'attachment',
				'post_mime_type' => 'image',
				'orderby'        => 'menu_order',
				'order'	         => 'ASC',
			)
		)
	);

	if ( isset( $image_ids[$index] ) )
		return $image_ids[$index];

	return false;

}

/**
 * Returns an image pulled from the media gallery.
 *
 * Supported $args keys are:
 * - format   - string, default is 'html'
 * - size     - string, default is 'full'
 * - num      - integer, default is 0
 * - attr     - string, default is ''
 * - fallback - mixed, default is 'first-attached'
 *
 * @since 0.1.0
 *
 * @uses exmachina_get_image_id()
 *
 * @global WP_Post $post Post object.
 * @param array|string $args Optional. Image query arguments. Default is empty array
 * @return string|boolean Returns img element HTML, URL of image, or false
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
	elseif ( 'first-attached' == $args['fallback'] ) {
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
	if ( 'html' === strtolower( $args['format'] ) )
		$output = $html;
	elseif ( 'url' === strtolower( $args['format'] ) )
		$output = $url;
	else
		$output = $src;

	// Return FALSE if $url is blank
	if ( empty( $url ) ) $output = false;

	//* Return FALSE if $src is invalid (file doesn't exist)
//	if ( ! file_exists( ABSPATH . $src ) )
//		$output = false;

	//* Return data, filtered
	return apply_filters( 'exmachina_get_image', $output, $args, $id, $html, $url, $src );
}

/**
 * Echoes an image pulled from media gallery.
 *
 * Supported $args keys are:
 * - format - string, default is 'html', may be 'url'
 * - size   - string, default is 'full'
 * - num    - integer, default is 0
 * - attr   - string, default is ''
 *
 * @since 0.1.0
 *
 * @uses exmachina_get_image()
 *
 * @param array|string $args Optional. Image query arguments. Default is empty array
 * @return false Returns false if URL is empty
 */
function exmachina_image( $args = array() ) {

	$image = exmachina_get_image( $args );

	if ( $image )
		echo $image;
	else
		return false;

}

/**
 * Returns registered image sizes.
 *
 * Returns a two-dimensional array of just the additionally registered image
 * sizes, with width, height and crop sub-keys.
 *
 * @since 0.1.7
 *
 * @global array $_wp_additional_image_sizes Additionally registered image sizes
 * @return array Two-dimensional, with width, height and crop sub-keys
 */
function exmachina_get_additional_image_sizes() {

	global $_wp_additional_image_sizes;

	if ( $_wp_additional_image_sizes )
		return $_wp_additional_image_sizes;

	return array();

}

/**
 * Returns all registered image sizes arrays, including the standard sizes.
 *
 * Returns a two-dimensional array of standard and additionally registered image
 * sizes, with width, height and crop sub-keys.
 *
 * Here, the standard sizes have their sub-keys populated by pulling from the
 * options saved in the database.
 *
 * @since 1.0.2
 *
 * @uses exmachina_get_additional_image_sizes()
 *
 * @return array Two-dimensional, with width, height and crop sub-keys
 */
function exmachina_get_image_sizes() {

	$builtin_sizes = array(
		'large'		=> array(
			'width'  => get_option( 'large_size_w' ),
			'height' => get_option( 'large_size_h' ),
		),
		'medium'	=> array(
			'width'  => get_option( 'medium_size_w' ),
			'height' => get_option( 'medium_size_h' ),
		),
		'thumbnail'	=> array(
			'width'  => get_option( 'thumbnail_size_w' ),
			'height' => get_option( 'thumbnail_size_h' ),
			'crop'   => get_option( 'thumbnail_crop' ),
		),
	);

	$additional_sizes = exmachina_get_additional_image_sizes();

	return array_merge( $builtin_sizes, $additional_sizes );

}