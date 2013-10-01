<?php
/**
 * ExMachina Framework.
 *
 * WARNING: This file is part of the core ExMachina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package ExMachina\Framework
 * @author  Machina Themes
 * @license GPL-2.0+
 * @link    http://www.machinathemes.com/
 */

//* Run the exmachina_pre Hook
do_action( 'exmachina_pre' );

add_action( 'exmachina_init', 'exmachina_i18n' );
/**
 * Load the ExMachina textdomain for internationalization.
 *
 * @since 1.9.0
 *
 * @uses load_theme_textdomain()
 *
 */
function exmachina_i18n() {

	if ( ! defined( 'EXMACHINA_LANGUAGES_DIR' ) )
		define( 'EXMACHINA_LANGUAGES_DIR', get_template_directory() . '/lib/languages' );

	load_theme_textdomain( 'exmachina', EXMACHINA_LANGUAGES_DIR );

}

add_action( 'exmachina_init', 'exmachina_theme_support' );
/**
 * Activates default theme features.
 *
 * @since 1.6.0
 */
function exmachina_theme_support() {

	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'exmachina-inpost-layouts' );
	add_theme_support( 'exmachina-archive-layouts' );
	add_theme_support( 'exmachina-admin-menu' );
	add_theme_support( 'exmachina-seo-settings-menu' );
	add_theme_support( 'exmachina-import-export-menu' );
	add_theme_support( 'exmachina-breadcrumbs' );

	//* Maybe add support for ExMachina menus
	if ( ! current_theme_supports( 'exmachina-menus' ) )
		add_theme_support( 'exmachina-menus', array(
			'primary'   => __( 'Primary Navigation Menu', 'exmachina' ),
			'secondary' => __( 'Secondary Navigation Menu', 'exmachina' ),
		) );

	//* Maybe add support for structural wraps
	if ( ! current_theme_supports( 'exmachina-structural-wraps' ) )
		add_theme_support( 'exmachina-structural-wraps', array( 'header', 'menu-primary', 'menu-secondary', 'footer-widgets', 'footer' ) );

	//* Turn on HTML5, responsive viewport & footer widgets if ExMachina is active
	if ( ! is_child_theme() ) {
		add_theme_support( 'html5' );
		add_theme_support( 'exmachina-responsive-viewport' );
		add_theme_support( 'exmachina-footer-widgets', 3 );
	}

}

add_action( 'exmachina_init', 'exmachina_post_type_support' );
/**
 * Initialize post type support for ExMachina features (Layout selector, SEO).
 *
 * @since 1.8.0
 */
function exmachina_post_type_support() {

	add_post_type_support( 'post', array( 'exmachina-seo', 'exmachina-scripts', 'exmachina-layouts' ) );
	add_post_type_support( 'page', array( 'exmachina-seo', 'exmachina-scripts', 'exmachina-layouts' ) );

}

add_action( 'exmachina_init', 'exmachina_constants' );
/**
 * This function defines the ExMachina theme constants
 *
 * @since 1.6.0
 */
function exmachina_constants() {

	//* Define Theme Info Constants
	define( 'PARENT_THEME_NAME', 'ExMachina' );
	define( 'PARENT_THEME_VERSION', '2.0.1' );
	define( 'PARENT_THEME_BRANCH', '2.0' );
	define( 'PARENT_DB_VERSION', '2007' );
	define( 'PARENT_THEME_RELEASE_DATE', date_i18n( 'F j, Y', '1377061200' ) );
#	define( 'PARENT_THEME_RELEASE_DATE', 'TBD' );

	//* Define Directory Location Constants
	define( 'PARENT_DIR', get_template_directory() );
	define( 'CHILD_DIR', get_stylesheet_directory() );
	define( 'EXMACHINA_IMAGES_DIR', PARENT_DIR . '/images' );
	define( 'EXMACHINA_LIB_DIR', PARENT_DIR . '/lib' );
	define( 'EXMACHINA_ADMIN_DIR', EXMACHINA_LIB_DIR . '/admin' );
	define( 'EXMACHINA_ADMIN_IMAGES_DIR', EXMACHINA_LIB_DIR . '/admin/images' );
	define( 'EXMACHINA_JS_DIR', EXMACHINA_LIB_DIR . '/js' );
	define( 'EXMACHINA_CSS_DIR', EXMACHINA_LIB_DIR . '/css' );
	define( 'EXMACHINA_CLASSES_DIR', EXMACHINA_LIB_DIR . '/classes' );
	define( 'EXMACHINA_FUNCTIONS_DIR', EXMACHINA_LIB_DIR . '/functions' );
	define( 'EXMACHINA_SHORTCODES_DIR', EXMACHINA_LIB_DIR . '/shortcodes' );
	define( 'EXMACHINA_STRUCTURE_DIR', EXMACHINA_LIB_DIR . '/structure' );
	define( 'EXMACHINA_WIDGETS_DIR', EXMACHINA_LIB_DIR . '/widgets' );

	//* Define URL Location Constants
	define( 'PARENT_URL', get_template_directory_uri() );
	define( 'CHILD_URL', get_stylesheet_directory_uri() );
	define( 'EXMACHINA_IMAGES_URL', PARENT_URL . '/images' );
	define( 'EXMACHINA_LIB_URL', PARENT_URL . '/lib' );
	define( 'EXMACHINA_ADMIN_URL', EXMACHINA_LIB_URL . '/admin' );
	define( 'EXMACHINA_ADMIN_IMAGES_URL', EXMACHINA_LIB_URL . '/admin/images' );
	define( 'EXMACHINA_JS_URL', EXMACHINA_LIB_URL . '/js' );
	define( 'EXMACHINA_CLASSES_URL', EXMACHINA_LIB_URL . '/classes' );
	define( 'EXMACHINA_CSS_URL', EXMACHINA_LIB_URL . '/css' );
	define( 'EXMACHINA_FUNCTIONS_URL', EXMACHINA_LIB_URL . '/functions' );
	define( 'EXMACHINA_SHORTCODES_URL', EXMACHINA_LIB_URL . '/shortcodes' );
	define( 'EXMACHINA_STRUCTURE_URL', EXMACHINA_LIB_URL . '/structure' );
	define( 'EXMACHINA_WIDGETS_URL', EXMACHINA_LIB_URL . '/widgets' );

	//* Define Settings Field Constants (for DB storage)
	define( 'EXMACHINA_SETTINGS_FIELD', apply_filters( 'exmachina_settings_field', 'exmachina-settings' ) );
	define( 'EXMACHINA_SEO_SETTINGS_FIELD', apply_filters( 'exmachina_seo_settings_field', 'exmachina-seo-settings' ) );
	define( 'EXMACHINA_HOOK_SETTINGS_FIELD', apply_filters( 'exmachina_hook_settings_field', 'exmachina-hook-settings' ) );
	define( 'EXMACHINA_CONTENT_SETTINGS_FIELD', apply_filters( 'exmachina_content_settings_field', 'exmachina-content-settings' ) );
	define( 'EXMACHINA_DESIGN_SETTINGS_FIELD', apply_filters( 'exmachina_design_settings_field', 'exmachina-design-settings' ) );
	define( 'EXMACHINA_CPT_ARCHIVE_SETTINGS_FIELD_PREFIX', apply_filters( 'exmachina_cpt_archive_settings_field_prefix', 'exmachina-cpt-archive-settings-' ) );

}


add_action( 'exmachina_init', 'exmachina_load_framework' );
/**
 * Loads all the framework files and features.
 *
 * The exmachina_pre_framework action hook is called before any of the files are
 * required().
 *
 * If a child theme defines EXMACHINA_LOAD_FRAMEWORK as false before requiring
 * this init.php file, then this function will abort before any other framework
 * files are loaded.
 *
 * @since 1.6.0
 */
function exmachina_load_framework() {

	//* Run the exmachina_pre_framework Hook
	do_action( 'exmachina_pre_framework' );

	//* Short circuit, if necessary
	if ( defined( 'EXMACHINA_LOAD_FRAMEWORK' ) && EXMACHINA_LOAD_FRAMEWORK === false )
		return;

	//* Load Framework
	require_once( EXMACHINA_LIB_DIR . '/framework.php' );

	//* Load Classes
	require_once( EXMACHINA_CLASSES_DIR . '/admin.php' );
	require_if_theme_supports( 'exmachina-breadcrumbs', EXMACHINA_CLASSES_DIR . '/breadcrumb.php' );
	require_once( EXMACHINA_CLASSES_DIR . '/sanitization.php' );

	//* Load Functions
	require_once( EXMACHINA_FUNCTIONS_DIR . '/compat.php' );
	require_once( EXMACHINA_FUNCTIONS_DIR . '/general.php' );
	require_once( EXMACHINA_FUNCTIONS_DIR . '/options.php' );
	require_once( EXMACHINA_FUNCTIONS_DIR . '/hooks.php' );
	require_once( EXMACHINA_FUNCTIONS_DIR . '/image.php' );
	require_once( EXMACHINA_FUNCTIONS_DIR . '/markup.php' );
	require_if_theme_supports( 'exmachina-breadcrumbs', EXMACHINA_FUNCTIONS_DIR . '/breadcrumb.php' );
	require_once( EXMACHINA_FUNCTIONS_DIR . '/menu.php' );
	require_once( EXMACHINA_FUNCTIONS_DIR . '/layout.php' );
	require_once( EXMACHINA_FUNCTIONS_DIR . '/formatting.php' );
	require_once( EXMACHINA_FUNCTIONS_DIR . '/seo.php' );
	require_once( EXMACHINA_FUNCTIONS_DIR . '/widgetize.php' );
	require_once( EXMACHINA_FUNCTIONS_DIR . '/feed.php' );
	if ( apply_filters( 'exmachina_load_deprecated', true ) )
		require_once( EXMACHINA_FUNCTIONS_DIR . '/deprecated.php' );

	//* Load Shortcodes
	require_once( EXMACHINA_SHORTCODES_DIR . '/post.php' );
	require_once( EXMACHINA_SHORTCODES_DIR . '/footer.php' );
	require_once( EXMACHINA_SHORTCODES_DIR . '/general.php' );

	//* Load Structure
	require_once( EXMACHINA_STRUCTURE_DIR . '/header.php' );
	require_once( EXMACHINA_STRUCTURE_DIR . '/footer.php' );
	require_once( EXMACHINA_STRUCTURE_DIR . '/menu.php' );
	require_once( EXMACHINA_STRUCTURE_DIR . '/layout.php' );
	require_once( EXMACHINA_STRUCTURE_DIR . '/post.php' );
	require_once( EXMACHINA_STRUCTURE_DIR . '/loops.php' );
	require_once( EXMACHINA_STRUCTURE_DIR . '/comments.php' );
	require_once( EXMACHINA_STRUCTURE_DIR . '/sidebar.php' );
	require_once( EXMACHINA_STRUCTURE_DIR . '/archive.php' );
	require_once( EXMACHINA_STRUCTURE_DIR . '/search.php' );

	//* Load Admin
	if ( is_admin() ) :
	require_once( EXMACHINA_ADMIN_DIR . '/menu.php' );
	require_once( EXMACHINA_ADMIN_DIR . '/theme-settings.php' );
	require_once( EXMACHINA_ADMIN_DIR . '/hook-settings.php' );
	require_once( EXMACHINA_ADMIN_DIR . '/content-settings.php' );
	require_once( EXMACHINA_ADMIN_DIR . '/seo-settings.php' );
	require_once( EXMACHINA_ADMIN_DIR . '/cpt-archive-settings.php' );
	require_once( EXMACHINA_ADMIN_DIR . '/import-export.php' );
	require_once( EXMACHINA_ADMIN_DIR . '/inpost-metaboxes.php' );
	endif;
	require_once( EXMACHINA_ADMIN_DIR . '/term-meta.php' );
	require_once( EXMACHINA_ADMIN_DIR . '/user-meta.php' );

	//* Load Javascript
	require_once( EXMACHINA_JS_DIR . '/load-scripts.php' );

	//* Load CSS
	require_once( EXMACHINA_CSS_DIR . '/load-styles.php' );

	//* Load Widgets
	require_once( EXMACHINA_WIDGETS_DIR . '/widgets.php' );

	global $_exmachina_formatting_allowedtags;
	$_exmachina_formatting_allowedtags = exmachina_formatting_allowedtags();

}

//* Run the exmachina_init hook
do_action( 'exmachina_init' );

//* Run the exmachina_setup hook
do_action( 'exmachina_setup' );
