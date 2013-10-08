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
 * @subpackage  Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

add_filter( 'user_contactmethods', 'exmachina_user_contactmethods' );
/**
 * Filter the contact methods registered for users.
 *
 * Currently just adds a Google+ field.
 *
 * @since 1.9.0
 *
 * @param array $contactmethods Array of contact methods.
 */
function exmachina_user_contactmethods( array $contactmethods ) {

	$contactmethods['facebook'] = __( 'Facebook', 'exmachina' );
	$contactmethods['twitter'] = __( 'Twitter', 'exmachina' );
	$contactmethods['googleplus'] = __( 'Google+', 'exmachina' );

	return $contactmethods;

}

add_action( 'admin_init', 'exmachina_add_user_profile_fields' );
/**
 * Hook in the additional user profile fields.
 *
 * @since 1.9.0
 */
function exmachina_add_user_profile_fields() {

	add_action( 'show_user_profile', 'exmachina_user_options_fields' );
	add_action( 'edit_user_profile', 'exmachina_user_options_fields' );
	add_action( 'show_user_profile', 'exmachina_user_archive_fields' );
	add_action( 'edit_user_profile', 'exmachina_user_archive_fields' );
	add_action( 'show_user_profile', 'exmachina_user_seo_fields' );
	add_action( 'edit_user_profile', 'exmachina_user_seo_fields' );
	add_action( 'show_user_profile', 'exmachina_user_layout_fields' );
	add_action( 'edit_user_profile', 'exmachina_user_layout_fields' );

}

/**
 * Add fields for user permissions for ExMachina features to the user edit screen.
 *
 * Checkbox settings are:
 *
 * * Enable ExMachina Admin Menu?
 * * Enable SEO Settings Submenu?
 * * Enable Import/Export Submenu?
 *
 * @since 1.4.0
 *
 * @param \WP_User $user User object.
 *
 * @return false Return false if current user can not edit users.
 */
function exmachina_user_options_fields( $user ) {

	if ( ! current_user_can( 'edit_users', $user->ID ) )
		return false;

	?>
	<h3><?php _e( 'User Permissions', 'exmachina' ); ?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" valign="top"><?php _e( 'ExMachina Admin Menus', 'exmachina' ); ?></th>
				<td>
					<label for="meta[exmachina_admin_menu]"><input id="meta[exmachina_admin_menu]" name="meta[exmachina_admin_menu]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_admin_menu', $user->ID ) ); ?> />
					<?php _e( 'Enable ExMachina Admin Menu?', 'exmachina' ); ?></label><br />

					<label for="meta[exmachina_seo_settings_menu]"><input id="meta[exmachina_seo_settings_menu]" name="meta[exmachina_seo_settings_menu]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_seo_settings_menu', $user->ID ) ); ?> />
					<?php _e( 'Enable SEO Settings Submenu?', 'exmachina' ); ?></label><br />

					<label for="meta[exmachina_import_export_menu]"><input id="meta[exmachina_import_export_menu]" name="meta[exmachina_import_export_menu]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_import_export_menu', $user->ID ) ); ?> />
					<?php _e( 'Enable Import/Export Submenu?', 'exmachina' ); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

}

/**
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
 * @since 1.6.0
 *
 * @param \WP_User $user User object.
 *
 * @return false Return false if current user can not edit users.
 */
function exmachina_user_archive_fields( $user ) {

	if ( ! current_user_can( 'edit_users', $user->ID ) )
		return false;

	?>
	<h3><?php _e( 'Author Archive Settings', 'exmachina' ); ?></h3>
	<p><span class="description"><?php _e( 'These settings apply to this author\'s archive pages.', 'exmachina' ); ?></span></p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" valign="top"><label for="headline"><?php _e( 'Custom Archive Headline', 'exmachina' ); ?></label></th>
				<td>
					<input name="meta[headline]" id="headline" type="text" value="<?php echo esc_attr( get_the_author_meta( 'headline', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"><?php printf( __( 'Will display in the %s tag at the top of the first page', 'exmachina' ), exmachina_code( '<h1>' ) ); ?></span>
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top"><label for="intro_text"><?php _e( 'Custom Description Text', 'exmachina' ); ?></label></th>
				<td>
					<textarea name="meta[intro_text]" id="intro_text" rows="5" cols="30"><?php echo esc_textarea( get_the_author_meta( 'intro_text', $user->ID ) ); ?></textarea><br />
					<span class="description"><?php _e( 'This text will be the first paragraph, and display on the first page', 'exmachina' ); ?></span>
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top"><?php _e( 'Author Box', 'exmachina' ); ?></th>
				<td>
					<label for="meta[exmachina_author_box_single]"><input id="meta[exmachina_author_box_single]" name="meta[exmachina_author_box_single]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_author_box_single', $user->ID ) ); ?> />
					<?php _e( 'Enable Author Box on this User\'s Posts?', 'exmachina' ); ?></label><br />

					<label for="meta[exmachina_author_box_archive]"><input id="meta[exmachina_author_box_archive]" name="meta[exmachina_author_box_archive]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'exmachina_author_box_archive', $user->ID ) ); ?> />
					<?php _e( 'Enable Author Box on this User\'s Archives?', 'exmachina' ); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

}

/**
 * Add fields for author archive SEO to the user edit screen.
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
 * @since 1.4.0
 *
 * @param \WP_User $user User object.
 *
 * @return false Return false if current user can not edit users.
 */
function exmachina_user_seo_fields( $user ) {

	if ( ! current_user_can( 'edit_users', $user->ID ) )
		return false;

	?>
	<h3><?php _e( 'Theme SEO Settings', 'exmachina' ); ?></h3>
	<p><span class="description"><?php _e( 'These settings apply to this author\'s archive pages.', 'exmachina' ); ?></span></p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" valign="top"><label for="doctitle"><?php _e( 'Custom Document Title', 'exmachina' ); ?></label></th>
				<td>
					<input name="meta[doctitle]" id="doctitle" type="text" value="<?php echo esc_attr( get_the_author_meta( 'doctitle', $user->ID ) ); ?>" class="regular-text" />
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top"><label for="meta-description"><?php _e( 'Meta Description', 'exmachina' ); ?></label></th>
				<td>
					<textarea name="meta[meta_description]" id="meta-description" rows="5" cols="30"><?php echo esc_textarea( get_the_author_meta( 'meta_description', $user->ID ) ); ?></textarea>
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top"><label for="meta-keywords"><?php _e( 'Meta Keywords', 'exmachina' ); ?></label></th>
				<td>
					<input name="meta[meta_keywords]" id="meta-keywords" type="text" value="<?php echo esc_attr( get_the_author_meta( 'meta_keywords', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"><?php _e( 'Comma separated list', 'exmachina' ); ?></span>
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top"><?php _e( 'Robots Meta', 'exmachina' ); ?></th>
				<td>
					<label for="meta[noindex]"><input id="meta[noindex]" name="meta[noindex]" id="noindex" type="checkbox" value="1" <?php checked( get_the_author_meta( 'noindex', $user->ID ) ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'exmachina' ), exmachina_code( 'noindex' ) ); ?></label><br />

					<label for="meta[nofollow]"><input id="meta[nofollow]" name="meta[nofollow]" id="nofollow" type="checkbox" value="1" <?php checked( get_the_author_meta( 'nofollow', $user->ID ) ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'exmachina' ), exmachina_code( 'nofollow' ) ); ?></label><br />

					<label for="meta[noarchive]"><input id="meta[noarchive]" name="meta[noarchive]" id="noarchive" type="checkbox" value="1" <?php checked( get_the_author_meta( 'noarchive', $user->ID ) ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'exmachina' ), exmachina_code( 'noarchive' ) ); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

}

/**
 * Add author archive layout selector to the user edit screen.
 *
 * @since 1.4.0
 *
 * @uses exmachina_layout_selector() Layout selector.
 *
 * @param \WP_User $user User object.
 *
 * @return false Return false if current user can not edit users.
 */
function exmachina_user_layout_fields( $user ) {

	if ( ! current_user_can( 'edit_users', $user->ID ) )
		return false;

	$layout = get_the_author_meta( 'layout', $user->ID );
	$layout = $layout ? $layout : '';

	?>
	<h3><?php _e( 'Layout Settings', 'exmachina' ); ?></h3>
	<p><span class="description"><?php _e( 'These settings apply to this author\'s archive pages.', 'exmachina' ); ?></span></p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" valign="top"><?php _e( 'Choose Layout', 'exmachina' ); ?></th>
				<td>
					<div class="exmachina-layout-selector">
						<p>
							<input type="radio" name="meta[layout]" id="default-layout" value="" <?php checked( $layout, '' ); ?> />
							<label class="default" for="default-layout"><?php printf( __( 'Default Layout set in <a href="%s">Theme Settings</a>', 'exmachina' ), menu_page_url( 'exmachina', 0 ) ); ?></label>
						</p>

						<p><?php exmachina_layout_selector( array( 'name' => 'meta[layout]', 'selected' => $layout, 'type' => 'site' ) ); ?></p>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

}

add_action( 'personal_options_update',  'exmachina_user_meta_save' );
add_action( 'edit_user_profile_update', 'exmachina_user_meta_save' );
/**
 * Update user meta when user edit page is saved.
 *
 * @since 1.4.0
 *
 * @param integer $user_id User ID
 *
 * @return null Returns null if current user can not edit users, or no meta fields submitted.
 */
function exmachina_user_meta_save( $user_id ) {

	if ( ! current_user_can( 'edit_users', $user_id ) )
		return;

	if ( ! isset( $_POST['meta'] ) || ! is_array( $_POST['meta'] ) )
		return;

	$meta = wp_parse_args(
		$_POST['meta'],
		array(
			'exmachina_admin_menu'         => '',
			'exmachina_seo_settings_menu'  => '',
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

	$meta['headline']   = strip_tags( $meta['headline'] );
	$meta['intro_text'] = current_user_can( 'unfiltered_html' ) ? $meta['intro_text'] : exmachina_formatting_kses( $meta['intro_text'] );

	foreach ( $meta as $key => $value )
		update_user_meta( $user_id, $key, $value );

}

add_filter( 'get_the_author_exmachina_admin_menu',         'exmachina_user_meta_default_on', 10, 2 );
add_filter( 'get_the_author_exmachina_seo_settings_menu',  'exmachina_user_meta_default_on', 10, 2 );
add_filter( 'get_the_author_exmachina_import_export_menu', 'exmachina_user_meta_default_on', 10, 2 );
/**
 * Check to see if user data has actually been saved, or if defaults need to be forced.
 *
 * This filter is useful for user options that need to be "on" by default, but keeps us from having to push defaults
 * into the database, which would be a very expensive task.
 *
 * @since 1.4.0
 *
 * @global bool|object authordata User object if successful, false if not.
 *
 * @param string|boolean $value   The submitted value.
 * @param integer        $user_id User ID.
 *
 * @return string|integer Submitted value, or 1.
 */
function exmachina_user_meta_default_on( $value, $user_id ) {

	//* Get the name of the field by removing the prefix from the active filter
	$field = str_replace( 'get_the_author_', '', current_filter() );

	//* If a real value exists, simply return it
	if ( $value )
		return $value;

	//* Setup user data
	if ( ! $user_id )
		global $authordata;
	else
		$authordata = get_userdata( $user_id );

	//* Just in case
	$user_field = "user_$field";
	if ( isset( $authordata->$user_field ) )
		return $authordata->user_field;

	//* If an empty or false value exists, return it
	if ( isset( $authordata->$field ) )
		return $value;

	//* If all that fails, default to true
	return 1;

}

add_filter( 'get_the_author_exmachina_author_box_single', 'exmachina_author_box_single_default_on', 10, 2 );
/**
 * Conditionally force a default 1 value for each users' author box setting.
 *
 * @since 1.4.0
 *
 * @uses exmachina_get_option()           Get ExMachina setting.
 * @uses exmachina_user_meta_default_on() Get enforced conditional.
 *
 * @param string  $value   Submitted value.
 * @param integer $user_id User ID.
 *
 * @return string Result.
 */
function exmachina_author_box_single_default_on( $value, $user_id ) {

	if ( exmachina_get_option( 'author_box_single' ) )
		return exmachina_user_meta_default_on( $value, $user_id );
	else
		return $value;

}
