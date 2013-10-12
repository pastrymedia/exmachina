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
 * Add Inpost SEO Metabox
 *
 * Register a new meta box to the post or page edit screen, so that the user
 * can set SEO options on a per-post or per-page basis. If the post type does
 * not support exmachina-seo, then the SEO meta box will not be added.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_post_types
 * @link http://codex.wordpress.org/Function_Reference/post_type_supports
 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
 *
 * @uses exmachina_inpost_seo_box() Generates the content in the meta box.
 *
 * @since 1.0.0
 * @access public
 */
function exmachina_add_inpost_seo_box() {

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'exmachina-seo' ) )
			add_meta_box( 'exmachina_inpost_seo_box', __( 'Theme SEO Settings', 'exmachina-core' ), 'exmachina_inpost_seo_box', $type, 'normal', 'high' );
	} // end foreach

} // end function exmachina_add_inpost_seo_box()

/**
 * Inpost SEO Metabox
 *
 * Callback for in-post SEO meta box.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nonce_field
 *
 * @uses exmachina_get_custom_field() Get custom field value.
 * @uses exmachina_code() [description]
 *
 * @since 1.0.0
 * @access public
 */
function exmachina_inpost_seo_box() {

	wp_nonce_field( 'exmachina_inpost_seo_save', 'exmachina_inpost_seo_nonce' );
	?>

	<p><label for="exmachina_title"><b><?php _e( 'Custom Document Title', 'exmachina-core' ); ?></b> <abbr title="&lt;title&gt; Tag">[?]</abbr> <span class="hide-if-no-js"><?php printf( __( 'Characters Used: %s', 'exmachina-core' ), '<span id="exmachina_title_chars">'. mb_strlen( exmachina_get_custom_field( '_exmachina_title' ) ) .'</span>' ); ?></span></label></p>
	<p><input class="large-text" type="text" name="exmachina_seo[_exmachina_title]" id="exmachina_title" value="<?php echo esc_attr( exmachina_get_custom_field( '_exmachina_title' ) ); ?>" /></p>

	<p><label for="exmachina_description"><b><?php _e( 'Custom Post/Page Meta Description', 'exmachina-core' ); ?></b> <abbr title="&lt;meta name=&quot;description&quot; /&gt;">[?]</abbr> <span class="hide-if-no-js"><?php printf( __( 'Characters Used: %s', 'exmachina-core' ), '<span id="exmachina_description_chars">'. mb_strlen( exmachina_get_custom_field( '_exmachina_description' ) ) .'</span>' ); ?></span></label></p>
	<p><textarea class="large-text" name="exmachina_seo[_exmachina_description]" id="exmachina_description" rows="4" cols="4"><?php echo esc_textarea( exmachina_get_custom_field( '_exmachina_description' ) ); ?></textarea></p>

	<p><label for="exmachina_keywords"><b><?php _e( 'Custom Post/Page Meta Keywords, comma separated', 'exmachina-core' ); ?></b> <abbr title="&lt;meta name=&quot;keywords&quot; /&gt;">[?]</abbr></label></p>
	<p><input class="large-text" type="text" name="exmachina_seo[_exmachina_keywords]" id="exmachina_keywords" value="<?php echo esc_attr( exmachina_get_custom_field( '_exmachina_keywords' ) ); ?>" /></p>

	<p><label for="exmachina_canonical"><b><?php _e( 'Custom Canonical URL', 'exmachina-core' ); ?></b> <a href="http://www.mattcutts.com/blog/canonical-link-tag/" target="_blank" title="&lt;link rel=&quot;canonical&quot; /&gt;">[?]</a></label></p>
	<p><input class="large-text" type="text" name="exmachina_seo[_exmachina_canonical_uri]" id="exmachina_canonical" value="<?php echo esc_url( exmachina_get_custom_field( '_exmachina_canonical_uri' ) ); ?>" /></p>

	<p><label for="exmachina_redirect"><b><?php _e( 'Custom Redirect URL', 'exmachina-core' ); ?></b> <a href="http://www.google.com/support/webmasters/bin/answer.py?hl=en&amp;answer=93633" target="_blank" title="301 Redirect">[?]</a></label></p>
	<p><input class="large-text" type="text" name="exmachina_seo[redirect]" id="exmachina_redirect" value="<?php echo esc_url( exmachina_get_custom_field( 'redirect' ) ); ?>" /></p>

	<br />

	<p><b><?php _e( 'Robots Meta Settings', 'exmachina-core' ); ?></b></p>

	<p>
		<label for="exmachina_noindex"><input type="checkbox" name="exmachina_seo[_exmachina_noindex]" id="exmachina_noindex" value="1" <?php checked( exmachina_get_custom_field( '_exmachina_noindex' ) ); ?> />
		<?php printf( __( 'Apply %s to this post/page', 'exmachina-core' ), exmachina_code( 'noindex' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label><br />

		<label for="exmachina_nofollow"><input type="checkbox" name="exmachina_seo[_exmachina_nofollow]" id="exmachina_nofollow" value="1" <?php checked( exmachina_get_custom_field( '_exmachina_nofollow' ) ); ?> />
		<?php printf( __( 'Apply %s to this post/page', 'exmachina-core' ), exmachina_code( 'nofollow' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label><br />

		<label for="exmachina_noarchive"><input type="checkbox" name="exmachina_seo[_exmachina_noarchive]" id="exmachina_noarchive" value="1" <?php checked( exmachina_get_custom_field( '_exmachina_noarchive' ) ); ?> />
		<?php printf( __( 'Apply %s to this post/page', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label>
	</p>
	<?php

} // end function exmachina_inpost_seo_box()

add_action( 'save_post', 'exmachina_inpost_seo_save', 1, 2 );
/**
 * Save Inpost SEO Metabox
 *
 * Save the SEO settings when we save a post or page. Some values get sanitized,
 * the rest are pulled from identically named subkeys in the $_POST['exmachina_seo']
 * array.
 *
 * @uses exmachina_save_custom_fields() Perform checks and saves post meta / custom field data to a post or page.
 *
 * @since 1.0.0
 * @access public
 *
 * @param  integer  $post_id Post ID.
 * @param  stdClass $post    Post object.
 * @return mixed             Returns post id, null, false, or true.
 */
function exmachina_inpost_seo_save( $post_id, $post ) {

	if ( ! isset( $_POST['exmachina_seo'] ) )
		return;

	/* Merge user submitted options with fallback defaults. */
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

	/* Sanitize the title, description, and tags. */
	foreach ( (array) $data as $key => $value ) {
		if ( in_array( $key, array( '_exmachina_title', '_exmachina_description', '_exmachina_keywords' ) ) )
			$data[ $key ] = strip_tags( $value );
	} // end foreach

	/* Save the custom fields. */
	exmachina_save_custom_fields( $data, 'exmachina_inpost_seo_save', 'exmachina_inpost_seo_nonce', $post );

} // end function exmachina_inpost_seo_save()

/*-------------------------------------------------------------------------*/
/* == Inpost Scripts Metaboxes */
/*-------------------------------------------------------------------------*/

add_action( 'admin_menu', 'exmachina_add_inpost_scripts_box' );
/**
 * Add Inpost Scripts Metabox
 *
 * Register a new meta box to the post or page edit screen, so that the user
 * can apply scripts on a per-post or per-page basis.
 *
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 * @link http://codex.wordpress.org/Function_Reference/get_post_types
 * @link http://codex.wordpress.org/Function_Reference/post_type_supports
 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
 *
 * @uses exmachina_inpost_scripts_box() Generates the content in the meta box.
 *
 * @since 1.0.0
 * @access public
 */
function exmachina_add_inpost_scripts_box() {

	/* If user doesn't have unfiltered html capability, don't show this box. */
	if ( ! current_user_can( 'unfiltered_html' ) )
		return;

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'exmachina-scripts' ) )
			add_meta_box( 'exmachina_inpost_scripts_box', __( 'Scripts', 'exmachina-core' ), 'exmachina_inpost_scripts_box', $type, 'normal', 'low' );
	} // end foreach

} // end function exmachina_add_inpost_scripts_box()

/**
 * Inpost Scripts Metabox
 *
 * Callback for in-post Scripts meta box.
 *
 * @uses exmachina_get_custom_field() Get custom field value.
 * @uses exmachina_code() [description]
 *
 * @since 1.0.0
 * @access public
 */
function exmachina_inpost_scripts_box() {

	wp_nonce_field( 'exmachina_inpost_scripts_save', 'exmachina_inpost_scripts_nonce' );
	?>

	<p><label for="exmachina_scripts" class="screen-reader-text"><b><?php _e( 'Page-specific Scripts', 'exmachina-core' ); ?></b></label></p>
	<p><textarea class="large-text" rows="4" cols="4" name="exmachina_seo[_exmachina_scripts]" id="exmachina_scripts"><?php echo esc_textarea( exmachina_get_custom_field( '_exmachina_scripts' ) ); ?></textarea></p>
	<p><?php printf( __( 'Suitable for custom tracking, conversion or other page-specific script. Must include %s tags.', 'exmachina-core' ), exmachina_code( 'script' ) ); ?></p>
	<?php

} // end function exmachina_inpost_scripts_box()

add_action( 'save_post', 'exmachina_inpost_scripts_save', 1, 2 );
/**
 * Save Inpost Scripts Box
 *
 * Save the Scripts settings when we save a post or page.
 *
 * @uses exmachina_save_custom_fields() Perform checks and saves post meta / custom field data to a post or page.
 *
 * @since 1.0.0
 * @access public
 *
 * @param  integer  $post_id Post ID.
 * @param  stdClass $post    Post object.
 * @return null 						 Returns null if no value POSTed.
 */
function exmachina_inpost_scripts_save( $post_id, $post ) {

	if ( ! isset( $_POST['exmachina_seo'] ) )
		return;

	 /* If user doesn't have unfiltered html capability, don't try to save. */
	if ( ! current_user_can( 'unfiltered_html' ) )
		return;

	/* Merge user submitted options with fallback defaults. */
	$data = wp_parse_args( $_POST['exmachina_seo'], array(
		'_exmachina_scripts' => '',
	) );

	exmachina_save_custom_fields( $data, 'exmachina_inpost_scripts_save', 'exmachina_inpost_scripts_nonce', $post );

} // end function exmachina_inpost_scripts_save()

/*-------------------------------------------------------------------------*/
/* == Inpost Layout Metaboxes */
/*-------------------------------------------------------------------------*/

add_action( 'admin_menu', 'exmachina_add_inpost_layout_box' );
/**
 * Add Inpost Layout Metabox
 *
 * Register a new meta box to the post or page edit screen, so that the user
 * can set layout options on a per-post or per-page basis.
 *
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/get_post_types
 * @link http://codex.wordpress.org/Function_Reference/post_type_supports
 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
 *
 * @uses exmachina_inpost_layout_box() Generates the content in the boxes
 *
 * @since 1.0.0
 * @access public
 *
 * @return null Returns null if ExMachina layouts are not supported
 */
function exmachina_add_inpost_layout_box() {

	if ( ! current_theme_supports( 'exmachina-inpost-layouts' ) )
		return;

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'exmachina-layouts' ) )
			add_meta_box( 'exmachina_inpost_layout_box', __( 'Layout Settings', 'exmachina-core' ), 'exmachina_inpost_layout_box', $type, 'normal', 'high' );
	} // end foreach

} // end function exmachina_add_inpost_layout_box()

/**
 * Inpost Layout Metabox
 *
 * Callback for in-post layout meta box.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nonce_field
 * @link http://codex.wordpress.org/Function_Reference/checked
 * @link http://codex.wordpress.org/Function_Reference/menu_page_url
 *
 * @uses exmachina_get_custom_field() Get custom field value.
 * @uses exmachina_layout_selector()  Layout selector.
 *
 * @since 1.0.0
 * @access public
 */
function exmachina_inpost_layout_box() {

	wp_nonce_field( 'exmachina_inpost_layout_save', 'exmachina_inpost_layout_nonce' );

	$layout = exmachina_get_custom_field( '_exmachina_layout' );

	?>
	<div class="exmachina-layout-selector">
		<p><input type="radio" name="exmachina_layout[_exmachina_layout]" class="default-layout" id="default-layout" value="" <?php checked( $layout, '' ); ?> /> <label class="default" for="default-layout"><?php printf( __( 'Default Layout set in <a href="%s">Theme Settings</a>', 'exmachina-core' ), menu_page_url( 'exmachina-core', 0 ) ); ?></label></p>

		<p><?php exmachina_layout_selector( array( 'name' => 'exmachina_layout[_exmachina_layout]', 'selected' => $layout, 'type' => 'site' ) ); ?></p>
	</div>

	<br class="clear" />

	<p><label for="exmachina_custom_body_class"><b><?php _e( 'Custom Body Class', 'exmachina-core' ); ?></b></label></p>
	<p><input class="large-text" type="text" name="exmachina_layout[_exmachina_custom_body_class]" id="exmachina_custom_body_class" value="<?php echo esc_attr( exmachina_get_custom_field( '_exmachina_custom_body_class' ) ); ?>" /></p>

	<p><label for="exmachina_custom_post_class"><b><?php _e( 'Custom Post Class', 'exmachina-core' ); ?></b></label></p>
	<p><input class="large-text" type="text" name="exmachina_layout[_exmachina_custom_post_class]" id="exmachina_custom_post_class" value="<?php echo esc_attr( exmachina_get_custom_field( '_exmachina_custom_post_class' ) ); ?>" /></p>
	<?php

} // end function exmachina_inpost_layout_box()

add_action( 'save_post', 'exmachina_inpost_layout_save', 1, 2 );
/**
 * Save Inpost Layout Metabox
 *
 * Save the layout options when we save a post or page. Since there's no sanitizing
 * of data, the values are pulled from identically named keys in $_POST.
 *
 * @uses exmachina_save_custom_fields() Perform checks and saves post meta / custom field data to a post or page.
 *
 * @since 1.0.0
 * @access public
 *
 * @param integer  $post_id Post ID.
 * @param stdClass $post    Post object.
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

/*-------------------------------------------------------------------------*/
/* == Inpost Post Template Metaboxes */
/*-------------------------------------------------------------------------*/

/* Add the post template meta box on the 'add_meta_boxes' hook. */
add_action( 'add_meta_boxes', 'exmachina_meta_box_post_add_template', 10, 2 );
add_action( 'add_meta_boxes', 'exmachina_meta_box_post_remove_template', 10, 2 );

/**
 * Add Inpost Post Template Metabox
 *
 * Adds the post template meta box for all public post types, excluding the 'page'
 * post type since WordPress core already handles page templates.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_post_type_object
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
 *
 * @uses exmachina_get_post_templates() [description]
 * @uses exmachina_meta_box_post_display_template() [description]
 *
 * @since 1.0.0
 * @return void
 *
 * @param string $post_type Post type name.
 * @param object $post      Post object
 */
function exmachina_meta_box_post_add_template( $post_type, $post ) {

	/* Get the post templates. */
	$templates = exmachina_get_post_templates( $post_type );

	/* If no post templates were found for this post type, don't add the meta box. */
	if ( empty( $templates ) )
		return;

	$post_type_object = get_post_type_object( $post_type );

	/* Only add meta box if current user can edit, add, or delete meta for the post. */
	if ( current_theme_supports( 'exmachina-core-template-hierarchy' ) && ( true === $post_type_object->public ) && ( current_user_can( 'edit_post_meta', $post->ID ) || current_user_can( 'add_post_meta', $post->ID ) || current_user_can( 'delete_post_meta', $post->ID ) ) )
		add_meta_box( 'exmachina-core-post-template', __( 'Template', 'exmachina-core' ), 'exmachina_meta_box_post_display_template', $post_type, 'side', 'default' );

} // end function exmachina_meta_box_post_add_template()

/**
 * Remove Inpost Post Template Metabox
 *
 * Remove the meta box from some post types.
 *
 * @link http://codex.wordpress.org/Function_Reference/remove_meta_box
 * @link http://codex.wordpress.org/Function_Reference/bbp_get_topic_post_type
 * @link http://codex.wordpress.org/Function_Reference/bbp_get_reply_post_type
 *
 * @since 1.0.0
 * @access public
 *
 * @param string $post_type The post type of the current post being edited.
 * @param object $post The current post being edited.
 * @return void
 */
function exmachina_meta_box_post_remove_template( $post_type, $post ) {

	/* Removes meta box from pages since this is a built-in WordPress feature. */
	if ( 'page' == $post_type )
		remove_meta_box( 'exmachina-core-post-template', 'page', 'side' );

	/* Removes meta box from the bbPress 'topic' post type. */
	elseif ( function_exists( 'bbp_get_topic_post_type' ) && bbp_get_topic_post_type() == $post_type )
		remove_meta_box( 'exmachina-core-post-template', bbp_get_topic_post_type(), 'side' );

	/* Removes meta box from the bbPress 'reply' post type. */
	elseif ( function_exists( 'bbp_get_reply_post_type' ) && bbp_get_reply_post_type() == $post_type )
		remove_meta_box( 'exmachina-core-post-template', bbp_get_reply_post_type(), 'side' );

} // end function exmachina_meta_box_post_remove_template()

/**
 * Inpost Post Template Metabox
 *
 * Displays the post template meta box.
 *
 * @todo nonce field???
 *
 * @since 1.0.0
 * @return void
 */
function exmachina_meta_box_post_display_template( $object, $box ) {

	/* Get the post type object. */
	$post_type_object = get_post_type_object( $object->post_type );

	/* Get a list of available custom templates for the post type. */
	$templates = exmachina_get_post_templates( $object->post_type );

	wp_nonce_field( basename( __FILE__ ), 'exmachina-core-post-meta-box-template' ); ?>

	<p>
		<?php if ( 0 != count( $templates ) ) { ?>
			<select name="exmachina-post-template" id="exmachina-post-template" class="widefat">
				<option value=""></option>
				<?php foreach ( $templates as $label => $template ) { ?>
					<option value="<?php echo esc_attr( $template ); ?>" <?php selected( esc_attr( get_post_meta( $object->ID, "_wp_{$post_type_object->name}_template", true ) ), esc_attr( $template ) ); ?>><?php echo esc_html( $label ); ?></option>
				<?php } ?>
			</select>
		<?php } ?>
	</p>
<?php

} // end function exmachina_meta_box_post_display_template

/* Save the post template meta box data on the 'save_post' hook. */
add_action( 'save_post', 'exmachina_meta_box_post_save_template', 10, 2 );
add_action( 'add_attachment', 'exmachina_meta_box_post_save_template' );
add_action( 'edit_attachment', 'exmachina_meta_box_post_save_template' );

/**
 * Saves the post template meta box settings as post metadata.
 *
 * @since 1.0.0
 * @param int $post_id The ID of the current post being saved.
 * @param int $post The post object currently being saved.
 * @return void|int
 */
function exmachina_meta_box_post_save_template( $post_id, $post = '' ) {

	/* Fix for attachment save issue in WordPress 3.5. @link http://core.trac.wordpress.org/ticket/21963 */
	if ( !is_object( $post ) )
		$post = get_post();

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['exmachina-core-post-meta-box-template'] ) || !wp_verify_nonce( $_POST['exmachina-core-post-meta-box-template'], basename( __FILE__ ) ) )
		return $post_id;

	/* Return here if the template is not set. There's a chance it won't be if the post type doesn't have any templates. */
	if ( !isset( $_POST['exmachina-post-template'] ) )
		return $post_id;

	/* Get the posted meta value. */
	$new_meta_value = $_POST['exmachina-post-template'];

	/* Set the $meta_key variable based off the post type name. */
	$meta_key = "_wp_{$post->post_type}_template";

	/* Get the meta value of the meta key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If there is no new meta value but an old value exists, delete it. */
	if ( current_user_can( 'delete_post_meta', $post_id ) && '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );

	/* If a new meta value was added and there was no previous value, add it. */
	elseif ( current_user_can( 'add_post_meta', $post_id, $meta_key ) && $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( current_user_can( 'edit_post_meta', $post_id ) && $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

} // end function exmachina_meta_box_post_save_template()

