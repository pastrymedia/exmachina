<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Admin Menu
 *
 * menu.php
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

add_action( 'after_setup_theme', 'exmachina_add_admin_menu' );
/**
 * Add ExMachina top-level item in admin menu.
 *
 * Calls the `exmachina_admin_menu hook` at the end - all submenu items should be attached to that hook to ensure
 * correct ordering.
 *
 * @since 0.2.0
 *
 * @global \ExMachina_Admin_Settings _exmachina_admin_settings          Theme Settings page object.
 * @global string                  _exmachina_theme_settings_pagehook Old backwards-compatible pagehook.
 *
 * @return null Returns null if ExMachina menu is disabled, or disabled for current user
 */
function exmachina_add_admin_menu() {

	if ( ! is_admin() )
		return;

	global $_exmachina_admin_settings;

	if ( ! current_theme_supports( 'exmachina-admin-menu' ) )
		return;

	//* Don't add menu item if disabled for current user
	$user = wp_get_current_user();
	if ( ! get_the_author_meta( 'exmachina_admin_menu', $user->ID ) )
		return;

	$_exmachina_admin_settings = new ExMachina_Admin_Theme_Settings;

	//* Set the old global pagehook var for backward compatibility
	global $_exmachina_theme_settings_pagehook;
	$_exmachina_theme_settings_pagehook = $_exmachina_admin_settings->pagehook;

	do_action( 'exmachina_admin_menu' );

}

add_action( 'exmachina_admin_menu', 'exmachina_add_admin_submenus' );
/**
 * Add submenu items under ExMachina item in admin menu.
 *
 * @since 0.2.0
 *
 * @see ExMachina_Admin_SEO_Settings SEO Settings class
 * @see ExMachina_Admin_Import_export Import / Export class
 * @see ExMachina_Admin_Readme Readme class
 *
 * @global string $_exmachina_admin_seo_settings
 * @global string $_exmachina_admin_import_export
 * @global string $_exmachina_admin_readme
 *
 * @return null Returns null if ExMachina menu is disabled
 */
function exmachina_add_admin_submenus() {

	//* Do nothing, if not viewing the admin
	if ( ! is_admin() )
		return;

	global $_exmachina_admin_seo_settings, $_exmachina_admin_import_export, $_exmachina_admin_readme;

	//* Don't add submenu items if ExMachina menu is disabled
	if( ! current_theme_supports( 'exmachina-admin-menu' ) )
		return;

	$user = wp_get_current_user();

	//* Add "SEO Settings" submenu item
	if ( current_theme_supports( 'exmachina-seo-settings-menu' ) && get_the_author_meta( 'exmachina_seo_settings_menu', $user->ID ) ) {
		$_exmachina_admin_seo_settings = new ExMachina_Admin_SEO_Settings;

		//* set the old global pagehook var for backward compatibility
		global $_exmachina_seo_settings_pagehook;
		$_exmachina_seo_settings_pagehook = $_exmachina_admin_seo_settings->pagehook;
	}

	//* Add "Import/Export" submenu item
	if ( current_theme_supports( 'exmachina-import-export-menu' ) && get_the_author_meta( 'exmachina_import_export_menu', $user->ID ) )
		$_exmachina_admin_import_export = new ExMachina_Admin_Import_Export;

}

add_action( 'admin_menu', 'exmachina_add_cpt_archive_page', 5 );
/**
 * Add archive settings page to relevant custom post type registrations.
 *
 * An instance of `ExMachina_Admin_CPT_Archive_Settings` is instantiated for each relevant CPT, assigned to an individual
 * global variable.
 *
 * @since 2.0.0
 *
 * @uses \ExMachina_Admin_CPT_Archive_Settings     CPT Archive Settings page class.
 * @uses exmachina_get_cpt_archive_types()         Get list of custom post types which need an archive settings page.
 * @uses exmachina_has_post_type_archive_support() Check post type has archive support.
 */
function exmachina_add_cpt_archive_page() {
	$post_types = exmachina_get_cpt_archive_types();

	foreach( $post_types as $post_type ) {
		if ( exmachina_has_post_type_archive_support( $post_type->name ) ) {
			$admin_object_name = '_exmachina_admin_cpt_archives_' . $post_type->name;
			global ${$admin_object_name};
			${$admin_object_name} = new ExMachina_Admin_CPT_Archive_Settings( $post_type );
		}
	}
}