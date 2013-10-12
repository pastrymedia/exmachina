<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Admin Menu
 *
 * admin-menu.php
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

add_action( 'exmachina_setup', 'exmachina_add_admin_menu' );
/**
 * Add Admin Main Menu
 *
 * Add ExMachina top-level item in admin menu. Calls the `exmachina_admin_menu`
 * hook at the end.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_admin
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/wp_get_current_user
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 *
 * @uses ExMachina_Admin_Theme_Settings Theme Settings class.
 *
 * @since 1.0.0
 * @access public
 *
 * @global object $_exmachina_admin_theme_settings 					Theme settings page object.
 * @global string $_exmachina_admin_theme_settings_pagehook Backwards-compatible pagehook.
 * @return null 																						Returns null if menu is disabled, or disabled for user
 */
function exmachina_add_admin_menu() {

	/* Return early if not admin. */
	if ( ! is_admin() )
		return;

	/* Globalize the $_exmachina_admin_theme_settings variable. */
  global $_exmachina_admin_theme_settings;

  /* Return early if admin menus not supported. */
	if ( ! current_theme_supports( 'exmachina-admin-menu' ) )
		return;

	/* Don't add menu item if disabled for current user. */
	$user = wp_get_current_user();
	if ( ! get_the_author_meta( 'exmachina_admin_menu', $user->ID ) )
		return;

	/* Create a new instance of the ExMachina_Admin_Theme_Settings class. */
  $_exmachina_admin_theme_settings = new ExMachina_Admin_Theme_Settings;

	//* Set the old global pagehook var for backward compatibility (May not need this)
  global $_exmachina_admin_theme_settings_pagehook;
  $_exmachina_admin_theme_settings_pagehook = $_exmachina_admin_theme_settings->pagehook;

  /* Trigger the admin menu action hook. */
	do_action( 'exmachina_admin_menu' );

} // end function exmachina_add_admin_menu()

/*-------------------------------------------------------------------------*/
/* Begin the admin submenus. */
/*-------------------------------------------------------------------------*/

add_action( 'exmachina_admin_menu', 'exmachina_add_admin_submenus' );
/**
 * Add Admin Submenu
 *
 * Add submenu items under ExMachina item in admin menu.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_admin
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/wp_get_current_user
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 *
 * @uses ExMachina_Admin_Design_Settings [description]
 * @uses ExMachina_Admin_Content_Settings [description]
 * @uses ExMachina_Admin_SEO_Settings [description]
 * @uses ExMachina_Admin_Hook_Settings [description]
 * @uses ExMachina_Admin_Import_Export [description]
 *
 * @since 1.0.0
 * @access public
 *
 * @global object $_exmachina_admin_design_settings  				Design settings page object.
 * @global object $_exmachina_admin_content_settings 				Content settings page object.
 * @global object $_exmachina_admin_seo_settings     				SEO settings page object.
 * @global object $_exmachina_admin_hook_settings    				Hook settings page object.
 * @global object $_exmachina_admin_import_export_settings 	Import/Export settings page object.
 *
 * @return null Returns null if admin menu is disabled
 */
function exmachina_add_admin_submenus() {

	/* Return early if not admin. */
	if ( ! is_admin() )
		return;

	/* Globalize the page object variables. */
	global $_exmachina_admin_design_settings, $_exmachina_admin_content_settings, $_exmachina_admin_seo_settings, $_exmachina_admin_hook_settings, $_exmachina_admin_import_export_settings;

	/* Return early if admin menus not supported. */
	if( ! current_theme_supports( 'exmachina-admin-menu' ) )
		return;

	/* Get the current user. */
	$user = wp_get_current_user();

	/* Add the Design Settings submenu item. */
	if ( current_theme_supports( 'exmachina-design-settings-menu' ) && get_the_author_meta( 'exmachina_design_settings_menu', $user->ID ) ) {

		/* Create a new instance of the ExMachina_Admin_Design_Settings class. */
  	$_exmachina_admin_design_settings = new ExMachina_Admin_Design_Settings;

		//* Set the old global pagehook var for backward compatibility (May not need this)
  	global $_exmachina_admin_design_settings_pagehook;
  	$_exmachina_admin_design_settings_pagehook = $_exmachina_admin_design_settings->pagehook;

	} // end if ( current_theme_supports( 'exmachina-design-settings-menu' ) && get_the_author_meta( 'exmachina_design_settings_menu', $user->ID ))

	/* Add the Content Settings submenu item. */
	if ( current_theme_supports( 'exmachina-content-settings-menu' ) && get_the_author_meta( 'exmachina_content_settings_menu', $user->ID ) ) {

		/* Create a new instance of the ExMachina_Admin_Content_Settings class. */
  	$_exmachina_admin_content_settings = new ExMachina_Admin_Content_Settings;

  	//* Set the old global pagehook var for backward compatibility (May not need this)
  	global $_exmachina_admin_content_settings_pagehook;
  	$_exmachina_admin_content_settings_pagehook = $_exmachina_admin_content_settings->pagehook;

	} // end if ( current_theme_supports( 'exmachina-content-settings-menu' ) && get_the_author_meta( 'exmachina_content_settings_menu', $user->ID ))

	/* Add the SEO Settings submenu item. */
	if ( current_theme_supports( 'exmachina-seo-settings-menu' ) && get_the_author_meta( 'exmachina_seo_settings_menu', $user->ID ) ) {

		/* Create a new instance of the ExMachina_Admin_SEO_Settings class. */
  	$_exmachina_admin_seo_settings = new ExMachina_Admin_SEO_Settings;

		//* Set the old global pagehook var for backward compatibility (May not need this)
  	global $_exmachina_admin_seo_settings_pagehook;
  	$_exmachina_admin_seo_settings_pagehook = $_exmachina_admin_seo_settings->pagehook;

	} // end if ( current_theme_supports( 'exmachina-seo-settings-menu' ) && get_the_author_meta( 'exmachina_seo_settings_menu', $user->ID ))

	/* Add the Hook Settings submenu item. */
	if ( current_theme_supports( 'exmachina-hook-settings-menu' ) && get_the_author_meta( 'exmachina_hook_settings_menu', $user->ID ) ) {

		/* Create a new instance of the ExMachina_Admin_Hook_Settings class. */
  	$_exmachina_admin_hook_settings = new ExMachina_Admin_Hook_Settings;

  	//* Set the old global pagehook var for backward compatibility (May not need this)
  	global $_exmachina_admin_hook_settings_pagehook;
  	$_exmachina_admin_hook_settings_pagehook = $_exmachina_admin_hook_settings->pagehook;

	} // end if ( current_theme_supports( 'exmachina-hook-settings-menu' ) && get_the_author_meta( 'exmachina_hook_settings_menu', $user->ID ))

	/* Add the Import/Export submenu item. */
	if ( current_theme_supports( 'exmachina-import-export-menu' ) && get_the_author_meta( 'exmachina_import_export_menu', $user->ID ) ) {

		/* Create a new instance of the ExMachina_Admin_Import_Export class. */
  	$_exmachina_admin_import_export_settings = new ExMachina_Admin_Import_Export;

  } // end if ( current_theme_supports( 'exmachina-import-export-menu' ) && get_the_author_meta( 'exmachina_import_export_menu', $user->ID ))

} // end function exmachina_add_admin_submenus()

/*-------------------------------------------------------------------------*/
/* Begin custom post type menus. */
/*-------------------------------------------------------------------------*/

add_action( 'admin_menu', 'exmachina_add_cpt_archive_page', 5 );
/**
 * Add CPT Archive Menus
 *
 * Add archive settings page to relevant custom post type registrations.
 *
 * An instance of `ExMachina_Admin_CPT_Archive_Settings` is instantiated for each relevant CPT, assigned to an individual
 * global variable.
 *
 * @uses ExMachina_Admin_Archive_Settings     		 CPT Archive Settings page class.
 * @uses exmachina_get_cpt_archive_types()         Get list of custom post types which need an archive settings page.
 * @uses exmachina_has_post_type_archive_support() Check post type has archive support.
 *
 * @since 1.0.0
 * @access public
 */
function exmachina_add_cpt_archive_page() {

	/* Get the custom post archive types. */
	$post_types = exmachina_get_cpt_archive_types();

	foreach( $post_types as $post_type ) {
		if ( exmachina_has_post_type_archive_support( $post_type->name ) ) {

			/* Define the cpt object name. */
			$admin_object_name = '_exmachina_admin_cpt_archives_' . $post_type->name;

			/* Globalize the cpt object variable. */
			global ${$admin_object_name};

			/* Create a new instance of the ExMachina_Admin_Archive_Settings class. */
			${$admin_object_name} = new ExMachina_Admin_Archive_Settings( $post_type );

		} // end if ( exmachina_has_post_type_archive_support( $post_type->name ))
	} // end foreach

} // end function exmachina_add_cpt_archive_page()
