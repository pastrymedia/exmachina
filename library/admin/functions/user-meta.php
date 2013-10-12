<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * User Meta
 *
 * user-meta.php
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

/* Filters the user contact methods. */
add_filter( 'user_contactmethods', 'exmachina_user_contactmethods' );

/**
 * User Contact Methods
 *
 * Filter the contact methods registered for users. Updates the default contact
 * methods to include Facebook, Twitter, and Google+.
 *
 * @since 1.0.0
 * @access public
 *
 * @param  array $contactmethods Array of contact methods.
 * @return array 								 Array of contact methods.
 */
function exmachina_user_contactmethods( array $contactmethods ) {

	/* Add the new contact method filters. */
	$contactmethods['facebook'] = __( 'Facebook', 'exmachina-core' );
	$contactmethods['twitter'] = __( 'Twitter', 'exmachina-core' );
	$contactmethods['googleplus'] = __( 'Google+', 'exmachina-core' );

	/* Return the user contact methods. */
	return $contactmethods;

} // end function exmachina_user_contactmethods()

/*-------------------------------------------------------------------------*/
/* Begin User profile fields functions. */
/*-------------------------------------------------------------------------*/

/* Add new user profile fields. */
add_action( 'admin_init', 'exmachina_add_user_profile_fields' );

/**
 * User Profile Fields
 *
 * Hook in the additional user profile fields.
 *
 * @since 1.0.0
 * @access public
 */
function exmachina_add_user_profile_fields() {

	/* Adds the User Options fields to the user profile. */
	add_action( 'show_user_profile', 'exmachina_user_options_fields' );
	add_action( 'edit_user_profile', 'exmachina_user_options_fields' );

	/* Adds the Author Archives fields to the user profile. */
	add_action( 'show_user_profile', 'exmachina_user_archive_fields' );
	add_action( 'edit_user_profile', 'exmachina_user_archive_fields' );

	/* Adds the Author SEO fields to the user profile. */
	add_action( 'show_user_profile', 'exmachina_user_seo_fields' );
	add_action( 'edit_user_profile', 'exmachina_user_seo_fields' );

	/* Adds the User Layouts fields to the user profile. */
	add_action( 'show_user_profile', 'exmachina_user_layout_fields' );
	add_action( 'edit_user_profile', 'exmachina_user_layout_fields' );

} // end function exmachina_add_user_profile_fields()

/**
 * User Options Fields
 *
 * Add fields for user permissions to the user edit screen to allow the display
 * of certain theme features and menus.
 *
 * Checkbox settings are:
 *
 * * Enable Theme Settings Menu?
 * * Enable Design Settings Submenu?
 * * Enable Content Settings Submenu?
 * * Enable SEO Settings Submenu?
 * * Enable Hook Settings Submenu?
 * * Enable Import/Export Submenu?
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_User
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 * @link http://codex.wordpress.org/Function_Reference/checked
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 *
 * @since 1.0.0
 * @access public
 *
 * @param  object $user WP_User user object.
 * @return false        Return false if current user can not edit users.
 */
function exmachina_user_options_fields( $user ) {

  /* Return early if the current user cannot edit others. */
	if ( ! current_user_can( 'edit_users', $user->ID ) )
		return false;

	?>
	<h3><?php _e( 'User Permissions', 'exmachina-core' ); ?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" valign="top"><?php _e( 'ExMachina Admin Menus', 'exmachina-core' ); ?></th>
				<td>
					<label for="meta[exmachina_admin_menu]"><input id="meta[exmachina_admin_menu]" name="meta[exmachina_admin_menu]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_admin_menu', $user->ID ) ); ?> />
					<?php _e( 'Enable Theme Settings Menu?', 'exmachina-core' ); ?></label><br />

					<label for="meta[exmachina_design_settings_menu]"><input id="meta[exmachina_design_settings_menu]" name="meta[exmachina_design_settings_menu]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_design_settings_menu', $user->ID ) ); ?> />
					<?php _e( 'Enable Design Settings Submenu?', 'exmachina-core' ); ?></label><br />

					<label for="meta[exmachina_content_settings_menu]"><input id="meta[exmachina_content_settings_menu]" name="meta[exmachina_content_settings_menu]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_content_settings_menu', $user->ID ) ); ?> />
					<?php _e( 'Enable Content Settings Submenu?', 'exmachina-core' ); ?></label><br />

					<label for="meta[exmachina_seo_settings_menu]"><input id="meta[exmachina_seo_settings_menu]" name="meta[exmachina_seo_settings_menu]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_seo_settings_menu', $user->ID ) ); ?> />
					<?php _e( 'Enable SEO Settings Submenu?', 'exmachina-core' ); ?></label><br />

					<label for="meta[exmachina_hook_settings_menu]"><input id="meta[exmachina_hook_settings_menu]" name="meta[exmachina_hook_settings_menu]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_hook_settings_menu', $user->ID ) ); ?> />
					<?php _e( 'Enable Hook Settings Submenu?', 'exmachina-core' ); ?></label><br />

					<label for="meta[exmachina_import_export_menu]"><input id="meta[exmachina_import_export_menu]" name="meta[exmachina_import_export_menu]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_import_export_menu', $user->ID ) ); ?> />
					<?php _e( 'Enable Import/Export Submenu?', 'exmachina-core' ); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

} // end function exmachina_user_options_fields()

/**
 * User Archive Fields
 *
 * Add fields for author archives contents to the user edit screen.
 *
 * Input / Textarea fields are:
 *
 * * Custom Archive Headline
 * * Custom Description Text
 *
 * Checkbox fields are:
 *
 * * Enable Author Box on this User's Posts?
 * * Enable Author Box on this User's Archives?
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_User
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 * @link http://codex.wordpress.org/Function_Reference/checked
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 *
 * @since 1.0.0
 * @access public
 *
 * @param  object $user WP_User user object.
 * @return false        Return false if current user can not edit users.
 */
function exmachina_user_archive_fields( $user ) {

  /* Return early if the current user cannot edit others. */
	if ( ! current_user_can( 'edit_users', $user->ID ) )
		return false;

	?>
	<h3><?php _e( 'Author Archive Settings', 'exmachina-core' ); ?></h3>
	<p><span class="description"><?php _e( 'These settings apply to this author\'s archive pages.', 'exmachina-core' ); ?></span></p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" valign="top"><label for="headline"><?php _e( 'Custom Archive Headline', 'exmachina-core' ); ?></label></th>
				<td>
					<input name="meta[headline]" id="headline" type="text" value="<?php echo esc_attr( get_the_author_meta( 'headline', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"><?php printf( __( 'Will display in the %s tag at the top of the first page', 'exmachina-core' ), exmachina_code( '<h1>' ) ); ?></span>
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top"><label for="intro_text"><?php _e( 'Custom Description Text', 'exmachina-core' ); ?></label></th>
				<td>
					<textarea name="meta[intro_text]" id="intro_text" rows="5" cols="30"><?php echo esc_textarea( get_the_author_meta( 'intro_text', $user->ID ) ); ?></textarea><br />
					<span class="description"><?php _e( 'This text will be the first paragraph, and display on the first page', 'exmachina-core' ); ?></span>
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top"><?php _e( 'Author Box', 'exmachina-core' ); ?></th>
				<td>
					<label for="meta[exmachina_author_box_single]"><input id="meta[exmachina_author_box_single]" name="meta[exmachina_author_box_single]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_author_box_single', $user->ID ) ); ?> />
					<?php _e( 'Enable Author Box on this User\'s Posts?', 'exmachina-core' ); ?></label><br />

					<label for="meta[exmachina_author_box_archive]"><input id="meta[exmachina_author_box_archive]" name="meta[exmachina_author_box_archive]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_author_box_archive', $user->ID ) ); ?> />
					<?php _e( 'Enable Author Box on this User\'s Archives?', 'exmachina-core' ); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

} // end function exmachina_user_archive_fields()

/**
 * User SEO Fields
 *
 * Adds fields to adjust the SEO settings on an individual author's archive page.
 *
 * Input / Textarea fields are:
 *
 * * Custom Document Title
 * * Meta Description
 * * Meta Keywords
 *
 * Checkbox fields are:
 *
 * * Apply noindex to this archive?
 * * Apply nofollow to this archive?
 * * Apply noarchive to this archive?
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_User
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 * @link http://codex.wordpress.org/Function_Reference/checked
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 *
 * @uses exmachina_code() [description]
 *
 * @since 1.0.0
 * @access public
 *
 * @param  object $user WP_User user object.
 * @return false        Return false if current user can not edit users.
 */
function exmachina_user_seo_fields( $user ) {

  /* Return early if the current user cannot edit others. */
	if ( ! current_user_can( 'edit_users', $user->ID ) )
		return false;

	?>
	<h3><?php _e( 'Theme SEO Settings', 'exmachina-core' ); ?></h3>
	<p><span class="description"><?php _e( 'These settings apply to this author\'s archive pages.', 'exmachina-core' ); ?></span></p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" valign="top"><label for="doctitle"><?php _e( 'Custom Document Title', 'exmachina-core' ); ?></label></th>
				<td>
					<input name="meta[doctitle]" id="doctitle" type="text" value="<?php echo esc_attr( get_the_author_meta( 'doctitle', $user->ID ) ); ?>" class="regular-text" />
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top"><label for="meta-description"><?php _e( 'Meta Description', 'exmachina-core' ); ?></label></th>
				<td>
					<textarea name="meta[meta_description]" id="meta-description" rows="5" cols="30"><?php echo esc_textarea( get_the_author_meta( 'meta_description', $user->ID ) ); ?></textarea>
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top"><label for="meta-keywords"><?php _e( 'Meta Keywords', 'exmachina-core' ); ?></label></th>
				<td>
					<input name="meta[meta_keywords]" id="meta-keywords" type="text" value="<?php echo esc_attr( get_the_author_meta( 'meta_keywords', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"><?php _e( 'Comma separated list', 'exmachina-core' ); ?></span>
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top"><?php _e( 'Robots Meta', 'exmachina-core' ); ?></th>
				<td>
					<label for="meta[noindex]"><input id="meta[noindex]" name="meta[noindex]" id="noindex" type="checkbox" value="1" <?php checked( get_the_author_meta( 'noindex', $user->ID ) ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'exmachina-core' ), exmachina_code( 'noindex' ) ); ?></label><br />

					<label for="meta[nofollow]"><input id="meta[nofollow]" name="meta[nofollow]" id="nofollow" type="checkbox" value="1" <?php checked( get_the_author_meta( 'nofollow', $user->ID ) ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'exmachina-core' ), exmachina_code( 'nofollow' ) ); ?></label><br />

					<label for="meta[noarchive]"><input id="meta[noarchive]" name="meta[noarchive]" id="noarchive" type="checkbox" value="1" <?php checked( get_the_author_meta( 'noarchive', $user->ID ) ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

} // end function exmachina_user_seo_fields()

/**
 * User Layout Fields
 *
 * Adds fields to adjust the column layout on an individual author's archive
 * page.
 *
 * @todo update layout selector markup to work within user settings
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_User
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 * @link http://codex.wordpress.org/Function_Reference/checked
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 * @link http://codex.wordpress.org/Function_Reference/menu_page_url
 *
 * @since 1.0.0
 * @access public
 *
 * @uses exmachina_layout_selector() Layout selector.
 *
 * @param  object $user WP_User user object.
 * @return false        Return false if current user can not edit users.
 */
function exmachina_user_layout_fields( $user ) {

  /* Return early if the current user cannot edit others. */
	if ( ! current_user_can( 'edit_users', $user->ID ) )
		return false;

	$layout = get_the_author_meta( 'layout', $user->ID );
	$layout = $layout ? $layout : '';

	?>
	<h3><?php _e( 'Layout Settings', 'exmachina-core' ); ?></h3>
	<p><span class="description"><?php _e( 'These settings apply to this author\'s archive pages.', 'exmachina-core' ); ?></span></p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" valign="top"><?php _e( 'Choose Layout', 'exmachina-core' ); ?></th>
				<td>
					<div class="exmachina-layout-selector">
						<p>
							<input type="radio" name="meta[layout]" id="default-layout" value="" <?php checked( $layout, '' ); ?> />
							<label class="default" for="default-layout"><?php printf( __( 'Default Layout set in <a href="%s">Theme Settings</a>', 'exmachina-core' ), menu_page_url( 'exmachina-core', 0 ) ); ?></label>
						</p>

						<p><?php exmachina_layout_selector( array( 'name' => 'meta[layout]', 'selected' => $layout, 'type' => 'site' ) ); ?></p>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

} // end function exmachina_user_layout_fields()

/*-------------------------------------------------------------------------*/
/* Begin User profile save functions. */
/*-------------------------------------------------------------------------*/

add_action( 'personal_options_update',  'exmachina_user_meta_save' );
add_action( 'edit_user_profile_update', 'exmachina_user_meta_save' );
/**
 * Save User Meta
 *
 * Update user meta when user edit page is saved.
 *
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
 * @link http://codex.wordpress.org/Function_Reference/update_user_meta
 *
 * @uses exmachina_formatting_kses() [description]
 *
 * @since 1.0.0
 * @access public
 *
 * @param integer $user_id  User ID
 * @return null             Returns null if user can not edit users, or no meta fields submitted.
 */
function exmachina_user_meta_save( $user_id ) {

  /* Return early if the current user cannot edit others. */
	if ( ! current_user_can( 'edit_users', $user_id ) )
		return;

  /* Return early if no user meta value needs to be saved. */
	if ( ! isset( $_POST['meta'] ) || ! is_array( $_POST['meta'] ) )
		return;

  /* Sets the default user meta fields. */
	$meta = wp_parse_args(
		$_POST['meta'],
		array(
			'exmachina_admin_menu'         => '',
			'exmachina_design_settings_menu'  => '',
			'exmachina_content_settings_menu'  => '',
			'exmachina_seo_settings_menu'  => '',
			'exmachina_hook_settings_menu'  => '',
			'exmachina_import_export_menu' => '',
			'exmachina_author_box_single'  => '',
			'exmachina_author_box_archive' => '',
			'headline'                   => '',
			'intro_text'                 => '',
			'doctitle'                   => '',
			'meta_description'           => '',
			'meta_keywords'              => '',
			'noindex'                    => '',
			'nofollow'                   => '',
			'noarchive'                  => '',
			'layout'                     => '',
		)
	);

  /* Sanitize the 'headline' & 'intro_text' meta. */
	$meta['headline']   = strip_tags( $meta['headline'] );
	$meta['intro_text'] = current_user_can( 'unfiltered_html' ) ? $meta['intro_text'] : exmachina_formatting_kses( $meta['intro_text'] );

  /* Loop through the meta and update. */
	foreach ( $meta as $key => $value )
		update_user_meta( $user_id, $key, $value );

} // end function exmachina_user_meta_save()

/*-------------------------------------------------------------------------*/
/* Begin User meta defaults functions. */
/*-------------------------------------------------------------------------*/

add_filter( 'get_the_author_exmachina_admin_menu',         'exmachina_user_meta_default_on', 10, 2 );
add_filter( 'get_the_author_exmachina_design_settings_menu',  'exmachina_user_meta_default_on', 10, 2 );
add_filter( 'get_the_author_exmachina_content_settings_menu',  'exmachina_user_meta_default_on', 10, 2 );
add_filter( 'get_the_author_exmachina_seo_settings_menu',  'exmachina_user_meta_default_on', 10, 2 );
add_filter( 'get_the_author_exmachina_hook_settings_menu',  'exmachina_user_meta_default_on', 10, 2 );
add_filter( 'get_the_author_exmachina_import_export_menu', 'exmachina_user_meta_default_on', 10, 2 );
/**
 * Force User Meta Defaults
 *
 * Check to see if user data has actually been saved, or if defaults need to be
 * forced. This filter is useful for user options that need to be "on" by default,
 * but keeps us from having to push defaults into the database, which would be a
 * very expensive task.
 *
 * @link http://codex.wordpress.org/Function_Reference/current_filter
 * @link http://codex.wordpress.org/Function_Reference/get_userdata
 *
 * @since 1.0.0
 * @access public
 *
 * @global bool|object    $authordata User object if successful, false if not.
 * @param  string|boolean $value      The submitted value.
 * @param  integer        $user_id    User ID.
 * @return string|integer             Submitted value, or 1.
 */
function exmachina_user_meta_default_on( $value, $user_id ) {

	/* Get the name of the field by removing the prefix from the active filter. */
	$field = str_replace( 'get_the_author_', '', current_filter() );

	/* If a real value exists, simply return it. */
	if ( $value )
		return $value;

	/* Setup user data. */
	if ( ! $user_id )
		global $authordata;
	else
		$authordata = get_userdata( $user_id );

	/* Just in case. */
	$user_field = "user_$field";
	if ( isset( $authordata->$user_field ) )
		return $authordata->user_field;

	/* If an empty or false value exists, return it. */
	if ( isset( $authordata->$field ) )
		return $value;

	/* If all that fails, default to true. */
	return 1;

} // end function exmachina_user_meta_default_on()

add_filter( 'get_the_author_exmachina_author_box_single', 'exmachina_author_box_single_default_on', 10, 2 );
/**
 * Force User Meta Author Box Defaults
 *
 * Conditionally force a default 1 value for each users' author box setting.
 *
 * @uses exmachina_get_option()           Get ExMachina setting.
 * @uses exmachina_user_meta_default_on() Get enforced conditional.
 *
 * @since 1.0.0
 *
 * @param string  $value   Submitted value.
 * @param integer $user_id User ID.
 * @return string Result.
 */
function exmachina_author_box_single_default_on( $value, $user_id ) {

	if ( exmachina_get_option( 'author_box_single' ) )
		return exmachina_user_meta_default_on( $value, $user_id );
	else
		return $value;

} // end function exmachina_author_box_single_default_on()
