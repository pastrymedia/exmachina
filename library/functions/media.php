<?php
/**
 * Functions for handling media (i.e., attachments) within themes.  Most functions are for handling
 * the display of appropriate HTML elements on attachment pages.
 *
 * @package HybridCore
 * @subpackage Functions
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2008 - 2013, Justin Tadlock
 * @link http://themehybrid.com/hybrid-core
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Add all image sizes to the image editor to insert into post. */
add_filter( 'image_size_names_choose', 'hybrid_image_size_names_choose' );

/**
 * Adds theme/plugin custom images sizes added with add_image_size() to the image uploader/editor.  This
 * allows users to insert these images within their post content editor.
 *
 * @since 1.3.0
 * @access private
 * @param array $sizes Selectable image sizes.
 * @return array $sizes
 */
function hybrid_image_size_names_choose( $sizes ) {

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
}

/**
 * Loads the correct function for handling attachments.  Checks the attachment mime type to call
 * correct function. Image attachments are not loaded with this function.  The functionality for them
 * should be handled by the theme's attachment or image attachment file.
 *
 * Ideally, all attachments would be appropriately handled within their templates. However, this could
 * lead to messy template files.
 *
 * @since 0.5.0
 * @access public
 * @uses get_post_mime_type() Gets the mime type of the attachment.
 * @uses wp_get_attachment_url() Gets the URL of the attachment file.
 * @return void
 */
function hybrid_attachment() {
	$file = wp_get_attachment_url();
	$mime = get_post_mime_type();
	$mime_type = explode( '/', $mime );

	/* Loop through each mime type. If a function exists for it, call it. Allow users to filter the display. */
	foreach ( $mime_type as $type ) {
		if ( function_exists( "hybrid_{$type}_attachment" ) )
			$attachment = call_user_func( "hybrid_{$type}_attachment", $mime, $file );

		$attachment = apply_atomic( "{$type}_attachment", $attachment );
	}

	echo apply_atomic( 'attachment', $attachment );
}

/**
 * Handles application attachments on their attachment pages.  Uses the <object> tag to embed media
 * on those pages.
 *
 * @since 0.3.0
 * @access public
 * @param string $mime attachment mime type
 * @param string $file attachment file URL
 * @return string
 */
function hybrid_application_attachment( $mime = '', $file = '' ) {
	$embed_defaults = wp_embed_defaults();
	$application = '<object class="text" type="' . esc_attr( $mime ) . '" data="' . esc_url( $file ) . '" width="' . esc_attr( $embed_defaults['width'] ) . '" height="' . esc_attr( $embed_defaults['height'] ) . '">';
	$application .= '<param name="src" value="' . esc_url( $file ) . '" />';
	$application .= '</object>';

	return $application;
}

/**
 * Handles text attachments on their attachment pages.  Uses the <object> element to embed media
 * in the pages.
 *
 * @since 0.3.0
 * @access public
 * @param string $mime attachment mime type
 * @param string $file attachment file URL
 * @return string
 */
function hybrid_text_attachment( $mime = '', $file = '' ) {
	$embed_defaults = wp_embed_defaults();
	$text = '<object class="text" type="' . esc_attr( $mime ) . '" data="' . esc_url( $file ) . '" width="' . esc_attr( $embed_defaults['width'] ) . '" height="' . esc_attr( $embed_defaults['height'] ) . '">';
	$text .= '<param name="src" value="' . esc_url( $file ) . '" />';
	$text .= '</object>';

	return $text;
}

/**
 * Handles audio attachments on their attachment pages.  Puts audio/mpeg and audio/wma files into
 * an <object> element.
 *
 * @todo Test out and support more audio types.
 *
 * @since 0.2.2
 * @access public
 * @param string $mime attachment mime type
 * @param string $file attachment file URL
 * @return string
 */
function hybrid_audio_attachment( $mime = '', $file = '' ) {
	return do_shortcode( '[audio src="' . esc_url( $file ) . '"]' );
}

/**
 * Handles video attachments on attachment pages.  Add other video types to the <object> element.
 *
 * @since 0.2.2
 * @access public
 * @param string $mime attachment mime type
 * @param string $file attachment file URL
 * @return string
 */
function hybrid_video_attachment( $mime = false, $file = false ) {
	return do_shortcode( '[video src="' . esc_url( $file ) . '"]' );
}

/* Register and load scripts. */
add_action( 'wp_enqueue_scripts', 'unique_enqueue_scripts' );

/* Register and load styles. */
add_action( 'wp_enqueue_scripts', 'unique_enqueue_styles', 4 );

/* Add custom image sizes. */
add_action( 'init', 'unique_add_image_sizes' );

/**
 * Loads additional stylesheets.
 *
 * @since  0.2.0
 * @access public
 * @return void
 */
function unique_enqueue_styles() {

	if ( is_page_template( 'page/page-template-magazine.php' ) )
		wp_enqueue_style( 'flexslider', hybrid_locate_theme_file( 'css/flexslider.css' ), array( '25px' ) );
}

/**
 * Registers and loads the theme's scripts.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function unique_enqueue_scripts() {

	/* Enqueue the 'flexslider' script. */
	if ( is_page_template( 'page/page-template-magazine.php' ) )
		wp_enqueue_script( 'flexslider', hybrid_locate_theme_file( 'js/flexslider/flexslider.min.js' ), array( 'jquery' ), '20120713', true );

	/* Enqueue the Unique theme script. */
	wp_enqueue_script( 'unique-theme', hybrid_locate_theme_file( 'js/unique.js' ), array( 'jquery' ), '20130326', true );
}

/**
 * Adds custom image sizes for featured images.  The 'feature' image size is used for sticky posts.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function unique_add_image_sizes() {
	add_image_size( 'unique-slider', 960, 400, true );
}

/**
 * Returns a set of image attachment links based on size.
 *
 * @since  0.1.0
 * @access public
 * @return string Links to various image sizes for the image attachment.
 */
function unique_get_image_size_links() {

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
}

/**
 * Displays an attachment image's metadata and exif data while viewing a singular attachment page.
 *
 * Note: This function will most likely be restructured completely in the future.  The eventual plan is to
 * separate each of the elements into an attachment API that can be used across multiple themes.  Keep
 * this in mind if you plan on using the current filter hooks in this function.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function hybrid_image_info() {

	/* Set up some default variables and get the image metadata. */
	$meta = wp_get_attachment_metadata( get_the_ID() );
	$items = array();
	$list = '';

	/* Add the width/height to the $items array. */
	$items['dimensions'] = sprintf( __( '<span class="prep">Dimensions:</span> %s', 'unique' ), '<span class="image-data"><a href="' . esc_url( wp_get_attachment_url() ) . '">' . sprintf( __( '%1$s &#215; %2$s pixels', 'unique' ), $meta['width'], $meta['height'] ) . '</a></span>' );

	/* If a timestamp exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['created_timestamp'] ) )
		$items['created_timestamp'] = sprintf( __( '<span class="prep">Date:</span> %s', 'unique' ), '<span class="image-data">' . date( get_option( 'date_format' ), $meta['image_meta']['created_timestamp'] ) . '</span>' );

	/* If a camera exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['camera'] ) )
		$items['camera'] = sprintf( __( '<span class="prep">Camera:</span> %s', 'unique' ), '<span class="image-data">' . $meta['image_meta']['camera'] . '</span>' );

	/* If an aperture exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['aperture'] ) )
		$items['aperture'] = sprintf( __( '<span class="prep">Aperture:</span> %s', 'unique' ), '<span class="image-data">' . sprintf( __( 'f/%s', 'unique' ), $meta['image_meta']['aperture'] ) . '</span>' );

	/* If a focal length is set, add it to the $items array. */
	if ( !empty( $meta['image_meta']['focal_length'] ) )
		$items['focal_length'] = sprintf( __( '<span class="prep">Focal Length:</span> %s', 'unique' ), '<span class="image-data">' . sprintf( __( '%s mm', 'unique' ), $meta['image_meta']['focal_length'] ) . '</span>' );

	/* If an ISO is set, add it to the $items array. */
	if ( !empty( $meta['image_meta']['iso'] ) )
		$items['iso'] = sprintf( __( '<span class="prep">ISO:</span> %s', 'unique' ), '<span class="image-data">' . $meta['image_meta']['iso'] . '</span>' );

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

		$items['shutter_speed'] = sprintf( __( '<span class="prep">Shutter Speed:</span> %s', 'unique' ), '<span class="image-data">' . sprintf( __( '%s sec', 'unique' ), $shutter_speed ) . '</span>' );
	}

	/* Allow devs to overwrite the array of items. */
	$items = apply_atomic( 'image_info_items', $items );

	/* Loop through the items, wrapping each in an <li> element. */
	foreach ( $items as $item )
		$list .= "<li>{$item}</li>";

	/* Format the HTML output of the function. */
	$output = '<div class="image-info"><h3>' . __( 'Image Info', 'unique' ) . '</h3><ul>' . $list . '</ul></div>';

	/* Display the image info and allow devs to overwrite the final output. */
	echo apply_atomic( 'image_info', $output );
}

?>