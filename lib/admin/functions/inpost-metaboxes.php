<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * InPost Metaboxes
 *
 * inpost-metaboxes.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
 *
 * @package     ExMachina
 * @subpackage  Admin Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

add_action( 'admin_menu', 'exmachina_add_inpost_seo_box' );
/**
 * Register a new meta box to the post or page edit screen, so that the user can set SEO options on a per-post or
 * per-page basis.
 *
 * If the post type does not support exmachina-seo, then the SEO meta box will not be added.
 *
 * @since 0.1.3
 *
 * @see exmachina_inpost_seo_box() Generates the content in the meta box.
 */
function exmachina_add_inpost_seo_box() {

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'exmachina-seo' ) )
			add_meta_box( 'exmachina_inpost_seo_box', __( 'Theme SEO Settings', 'exmachina' ), 'exmachina_inpost_seo_box', $type, 'normal', 'high' );
	}

} // end function exmachina_add_inpost_seo_box()

/**
 * Callback for in-post SEO meta box.
 *
 * @since 0.1.3
 *
 * @uses exmachina_get_custom_field() Get custom field value.
 */
function exmachina_inpost_seo_box() {

	wp_nonce_field( 'exmachina_inpost_seo_save', 'exmachina_inpost_seo_nonce' );
	?>

	<p><label for="exmachina_title"><b><?php _e( 'Custom Document Title', 'exmachina' ); ?></b> <abbr title="&lt;title&gt; Tag">[?]</abbr> <span class="hide-if-no-js"><?php printf( __( 'Characters Used: %s', 'exmachina' ), '<span id="exmachina_title_chars">'. mb_strlen( exmachina_get_custom_field( '_exmachina_title' ) ) .'</span>' ); ?></span></label></p>
	<p><input class="large-text" type="text" name="exmachina_seo[_exmachina_title]" id="exmachina_title" value="<?php echo esc_attr( exmachina_get_custom_field( '_exmachina_title' ) ); ?>" /></p>

	<p><label for="exmachina_description"><b><?php _e( 'Custom Post/Page Meta Description', 'exmachina' ); ?></b> <abbr title="&lt;meta name=&quot;description&quot; /&gt;">[?]</abbr> <span class="hide-if-no-js"><?php printf( __( 'Characters Used: %s', 'exmachina' ), '<span id="exmachina_description_chars">'. mb_strlen( exmachina_get_custom_field( '_exmachina_description' ) ) .'</span>' ); ?></span></label></p>
	<p><textarea class="large-text" name="exmachina_seo[_exmachina_description]" id="exmachina_description" rows="4" cols="4"><?php echo esc_textarea( exmachina_get_custom_field( '_exmachina_description' ) ); ?></textarea></p>

	<p><label for="exmachina_keywords"><b><?php _e( 'Custom Post/Page Meta Keywords, comma separated', 'exmachina' ); ?></b> <abbr title="&lt;meta name=&quot;keywords&quot; /&gt;">[?]</abbr></label></p>
	<p><input class="large-text" type="text" name="exmachina_seo[_exmachina_keywords]" id="exmachina_keywords" value="<?php echo esc_attr( exmachina_get_custom_field( '_exmachina_keywords' ) ); ?>" /></p>

	<p><label for="exmachina_canonical"><b><?php _e( 'Custom Canonical URL', 'exmachina' ); ?></b> <a href="http://www.mattcutts.com/blog/canonical-link-tag/" target="_blank" title="&lt;link rel=&quot;canonical&quot; /&gt;">[?]</a></label></p>
	<p><input class="large-text" type="text" name="exmachina_seo[_exmachina_canonical_uri]" id="exmachina_canonical" value="<?php echo esc_url( exmachina_get_custom_field( '_exmachina_canonical_uri' ) ); ?>" /></p>

	<p><label for="exmachina_redirect"><b><?php _e( 'Custom Redirect URL', 'exmachina' ); ?></b> <a href="http://www.google.com/support/webmasters/bin/answer.py?hl=en&amp;answer=93633" target="_blank" title="301 Redirect">[?]</a></label></p>
	<p><input class="large-text" type="text" name="exmachina_seo[redirect]" id="exmachina_redirect" value="<?php echo esc_url( exmachina_get_custom_field( 'redirect' ) ); ?>" /></p>

	<br />

	<p><b><?php _e( 'Robots Meta Settings', 'exmachina' ); ?></b></p>

	<p>
		<label for="exmachina_noindex"><input type="checkbox" name="exmachina_seo[_exmachina_noindex]" id="exmachina_noindex" value="1" <?php checked( exmachina_get_custom_field( '_exmachina_noindex' ) ); ?> />
		<?php printf( __( 'Apply %s to this post/page', 'exmachina' ), exmachina_code( 'noindex' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label><br />

		<label for="exmachina_nofollow"><input type="checkbox" name="exmachina_seo[_exmachina_nofollow]" id="exmachina_nofollow" value="1" <?php checked( exmachina_get_custom_field( '_exmachina_nofollow' ) ); ?> />
		<?php printf( __( 'Apply %s to this post/page', 'exmachina' ), exmachina_code( 'nofollow' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label><br />

		<label for="exmachina_noarchive"><input type="checkbox" name="exmachina_seo[_exmachina_noarchive]" id="exmachina_noarchive" value="1" <?php checked( exmachina_get_custom_field( '_exmachina_noarchive' ) ); ?> />
		<?php printf( __( 'Apply %s to this post/page', 'exmachina' ), exmachina_code( 'noarchive' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label>
	</p>
	<?php

} // end function exmachina_inpost_seo_box()

add_action( 'save_post', 'exmachina_inpost_seo_save', 1, 2 );
/**
 * Save the SEO settings when we save a post or page.
 *
 * Some values get sanitized, the rest are pulled from identically named subkeys in the $_POST['exmachina_seo'] array.
 *
 * @since 0.1.3
 *
 * @uses exmachina_save_custom_fields() Perform checks and saves post meta / custom field data to a post or page.
 *
 * @param integer  $post_id Post ID.
 * @param stdClass $post    Post object.
 *
 * @return mixed Returns post id if permissions incorrect, null if doing autosave, ajax or future post, false if update
 *               or delete failed, and true on success.
 */
function exmachina_inpost_seo_save( $post_id, $post ) {

	if ( ! isset( $_POST['exmachina_seo'] ) )
		return;

	//* Merge user submitted options with fallback defaults
	$data = wp_parse_args( $_POST['exmachina_seo'], array(
		'_exmachina_title'         => '',
		'_exmachina_description'   => '',
		'_exmachina_keywords'      => '',
		'_exmachina_canonical_uri' => '',
		'redirect'               => '',
		'_exmachina_noindex'       => 0,
		'_exmachina_nofollow'      => 0,
		'_exmachina_noarchive'     => 0,
	) );

	//* Sanitize the title, description, and tags
	foreach ( (array) $data as $key => $value ) {
		if ( in_array( $key, array( '_exmachina_title', '_exmachina_description', '_exmachina_keywords' ) ) )
			$data[ $key ] = strip_tags( $value );
	}

	exmachina_save_custom_fields( $data, 'exmachina_inpost_seo_save', 'exmachina_inpost_seo_nonce', $post );

} // end function exmachina_inpost_seo_save()

add_action( 'admin_menu', 'exmachina_add_inpost_scripts_box' );
/**
 * Register a new meta box to the post or page edit screen, so that the user can apply scripts on a per-post or
 * per-page basis.
 *
 * The scripts field was previously part of the SEO meta box, and was therefore hidden when an SEO plugin was active.
 *
 * @since 2.0.0
 *
 * @see exmachina_inpost_scripts_box() Generates the content in the meta box.
 */
function exmachina_add_inpost_scripts_box() {

	//* If user doesn't have unfiltered html capability, don't show this box
	if ( ! current_user_can( 'unfiltered_html' ) )
		return;

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'exmachina-scripts' ) )
			add_meta_box( 'exmachina_inpost_scripts_box', __( 'Scripts', 'exmachina' ), 'exmachina_inpost_scripts_box', $type, 'normal', 'low' );
	}

} // end function exmachina_add_inpost_scripts_box()

/**
 * Callback for in-post Scripts meta box.
 *
 * @since 2.0.0
 *
 * @uses exmachina_get_custom_field() Get custom field value.
 */
function exmachina_inpost_scripts_box() {

	wp_nonce_field( 'exmachina_inpost_scripts_save', 'exmachina_inpost_scripts_nonce' );
	?>

	<p><label for="exmachina_scripts" class="screen-reader-text"><b><?php _e( 'Page-specific Scripts', 'exmachina' ); ?></b></label></p>
	<p><textarea class="large-text" rows="4" cols="4" name="exmachina_seo[_exmachina_scripts]" id="exmachina_scripts"><?php echo esc_textarea( exmachina_get_custom_field( '_exmachina_scripts' ) ); ?></textarea></p>
	<p><?php printf( __( 'Suitable for custom tracking, conversion or other page-specific script. Must include %s tags.', 'exmachina' ), exmachina_code( 'script' ) ); ?></p>
	<?php

} // end function exmachina_inpost_scripts_box()

add_action( 'save_post', 'exmachina_inpost_scripts_save', 1, 2 );
/**
 * Save the Scripts settings when we save a post or page.
 *
 * @since 2.0.0
 *
 * @uses exmachina_save_custom_fields() Perform checks and saves post meta / custom field data to a post or page.
 *
 * @param integer  $post_id Post ID.
 * @param stdClass $post    Post object.
 *
 * @return null Returns null if no value POSTed.
 */
function exmachina_inpost_scripts_save( $post_id, $post ) {

	if ( ! isset( $_POST['exmachina_seo'] ) )
		return;

	 //* If user doesn't have unfiltered html capability, don't try to save
	if ( ! current_user_can( 'unfiltered_html' ) )
		return;

	//* Merge user submitted options with fallback defaults
	$data = wp_parse_args( $_POST['exmachina_seo'], array(
		'_exmachina_scripts' => '',
	) );

	exmachina_save_custom_fields( $data, 'exmachina_inpost_scripts_save', 'exmachina_inpost_scripts_nonce', $post );

} // end function exmachina_inpost_scripts_save()

add_action( 'admin_menu', 'exmachina_add_inpost_layout_box' );
/**
 * Register a new meta box to the post or page edit screen, so that the user can set layout options on a per-post or
 * per-page basis.
 *
 * @since 0.2.2
 *
 * @see exmachina_inpost_layout_box() Generates the content in the boxes
 *
 * @return null Returns null if ExMachina layouts are not supported
 */
function exmachina_add_inpost_layout_box() {

	if ( ! current_theme_supports( 'exmachina-inpost-layouts' ) )
		return;

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'exmachina-layouts' ) )
			add_meta_box( 'exmachina_inpost_layout_box', __( 'Layout Settings', 'exmachina' ), 'exmachina_inpost_layout_box', $type, 'normal', 'high' );
	}

} // end function exmachina_add_inpost_layout_box()

/**
 * Callback for in-post layout meta box.
 *
 * @since 0.2.2
 *
 * @uses exmachina_get_custom_field() Get custom field value.
 * @uses exmachina_layout_selector()  Layout selector.
 */
function exmachina_inpost_layout_box() {

	wp_nonce_field( 'exmachina_inpost_layout_save', 'exmachina_inpost_layout_nonce' );

	$layout = exmachina_get_custom_field( '_exmachina_layout' );

	?>
	<div class="exmachina-layout-selector">
		<p><input type="radio" name="exmachina_layout[_exmachina_layout]" class="default-layout" id="default-layout" value="" <?php checked( $layout, '' ); ?> /> <label class="default" for="default-layout"><?php printf( __( 'Default Layout set in <a href="%s">Theme Settings</a>', 'exmachina' ), menu_page_url( 'exmachina', 0 ) ); ?></label></p>

		<p><?php exmachina_layout_selector( array( 'name' => 'exmachina_layout[_exmachina_layout]', 'selected' => $layout, 'type' => 'site' ) ); ?></p>
	</div>

	<br class="clear" />

	<p><label for="exmachina_custom_body_class"><b><?php _e( 'Custom Body Class', 'exmachina' ); ?></b></label></p>
	<p><input class="large-text" type="text" name="exmachina_layout[_exmachina_custom_body_class]" id="exmachina_custom_body_class" value="<?php echo esc_attr( exmachina_get_custom_field( '_exmachina_custom_body_class' ) ); ?>" /></p>

	<p><label for="exmachina_custom_post_class"><b><?php _e( 'Custom Post Class', 'exmachina' ); ?></b></label></p>
	<p><input class="large-text" type="text" name="exmachina_layout[_exmachina_custom_post_class]" id="exmachina_custom_post_class" value="<?php echo esc_attr( exmachina_get_custom_field( '_exmachina_custom_post_class' ) ); ?>" /></p>
	<?php

} // end function exmachina_inpost_layout_box()

add_action( 'save_post', 'exmachina_inpost_layout_save', 1, 2 );
/**
 * Save the layout options when we save a post or page.
 *
 * Since there's no sanitizing of data, the values are pulled from identically named keys in $_POST.
 *
 * @since 0.2.2
 *
 * @uses exmachina_save_custom_fields() Perform checks and saves post meta / custom field data to a post or page.
 *
 * @param integer  $post_id Post ID.
 * @param stdClass $post    Post object.
 *
 * @return mixed Returns post id if permissions incorrect, null if doing autosave, ajax or future post, false if update
 *               or delete failed, and true on success.
 *
 */
function exmachina_inpost_layout_save( $post_id, $post ) {

	if ( ! isset( $_POST['exmachina_layout'] ) )
		return;

	$data = wp_parse_args( $_POST['exmachina_layout'], array(
		'_exmachina_layout'            => '',
		'_exmachina_custom_body_class' => '',
		'_exmachina_post_class'        => '',
	) );

	$data = array_map( 'exmachina_sanitize_html_classes', $data );

	exmachina_save_custom_fields( $data, 'exmachina_inpost_layout_save', 'exmachina_inpost_layout_nonce', $post );

} // end function exmachina_inpost_layout_save()
