<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * JavaScript Functions
 *
 * load-scripts.php
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

add_action( 'wp_enqueue_scripts', 'exmachina_register_scripts' );
/**
 * Register the scripts that ExMachina will use.
 *
 * @since 0.5.0
 *
 * @uses EXMACHINA_JS
 * @uses PARENT_THEME_VERSION
 */
function exmachina_register_scripts() {

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

} // end function exmachina_register_scripts()

add_action( 'wp_enqueue_scripts', 'exmachina_load_scripts' );
/**
 * Enqueue the scripts used on the front-end of the site.
 *
 *
 * @since 0.5.0
 *
 * @uses exmachina_html5()      Check for HTML5 support.
 * @uses exmachina_get_option() Get theme setting value.
 */
function exmachina_load_scripts() {

	//* If a single post or page, threaded comments are enabled, and comments are open
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() )
		wp_enqueue_script( 'comment-reply' );

} // end function exmachina_load_scripts()

add_action( 'wp_head', 'exmachina_html5_ie_fix' );
/**
 * Load the html5 shiv for IE8 and below. Can't enqueue with IE conditionals.
 *
 * @since 0.5.0
 *
 * @uses exmachina_html5() Check for HTML5 support.
 *
 * @return Return early if HTML5 not supported.
 *
 */
function exmachina_html5_ie_fix() {

	if ( ! exmachina_html5() )
		return;

	echo '<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->' . "\n";

} // end function exmachina_html5_ie_fix()

add_action( 'admin_enqueue_scripts', 'exmachina_load_admin_scripts' );
/**
 * Conditionally enqueue the scripts used in the admin.
 *
 * Includes Thickbox, theme preview and a ExMachina script (actually enqueued in exmachina_load_admin_js()).
 *
 * @since 0.5.0
 *
 * @uses exmachina_load_admin_js() Enqueues the custom script and localizations used in the admin.
 * @uses exmachina_is_menu_page()  Check that we're targeting a specific ExMachina admin page.
 * @uses exmachina_update_check()  Ping http://api.exmachinatheme.com/ asking if a new version of this theme is available.
 * @uses exmachina_seo_disabled()  Detect whether or not ExMachina SEO has been disabled.
 *
 * @global WP_Post $post Post object.
 *
 * @param string $hook_suffix Admin page identifier.
 */
function exmachina_load_admin_scripts( $hook_suffix ) {

	//* If we're on a ExMachina admin screen
	if ( exmachina_is_menu_page( 'exmachina' ) || exmachina_is_menu_page( 'seo-settings' ) || exmachina_is_menu_page( 'design-settings' ) )
		exmachina_load_admin_js();

	global $post;

	//* If we're viewing an edit post page, make sure we need ExMachina SEO JS
	if ( in_array( $hook_suffix, array( 'post-new.php', 'post.php' ) ) ) {
		if ( ! exmachina_seo_disabled() && post_type_supports( $post->post_type, 'exmachina-seo' ) )
			exmachina_load_admin_js();
	}

} // end function exmachina_load_admin_scripts()

/**
 * Enqueues the custom script used in the admin, and localizes several strings or values used in the scripts.
 *
 * Applies the `exmachina_toggles` filter to toggleable admin settings, so plugin developers can add their own without
 * having to recreate the whole setup.
 *
 * @since 0.5.0
 *
 * @uses EXMACHINA_JS
 * @uses PARENT_THEME_VERSION
 */
function exmachina_load_admin_js() {

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'exmachina_admin_js', EXMACHINA_JS . "/admin$suffix.js", array( 'jquery' ), PARENT_THEME_VERSION, true );

	$strings = array(
		'categoryChecklistToggle' => __( 'Select / Deselect All', 'exmachina' ),
		'saveAlert'               => __('The changes you made will be lost if you navigate away from this page.', 'exmachina'),
		'confirmReset'            => __( 'Are you sure you want to reset?', 'exmachina' ),
	);

	wp_localize_script( 'exmachina_admin_js', 'exmachinaL10n', $strings );

	$toggles = array(
		// Checkboxes - when checked, show extra settings
		'content_archive_thumbnail' => array( '#exmachina-settings\\[content_archive_thumbnail\\]', '#exmachina_image_size', '_checked' ),
		// Checkboxed - when unchecked, show extra settings
		'semantic_headings'         => array( '#exmachina-seo-settings\\[semantic_headings\\]', '#exmachina_seo_h1_wrap', '_unchecked' ),
		// Select toggles
		'nav_extras'                => array( '#exmachina-settings\\[nav_extras\\]', '#exmachina_nav_extras_twitter', 'twitter' ),
		'content_archive'           => array( '#exmachina-settings\\[content_archive\\]', '#exmachina_content_limit_setting', 'full' ),

	);

	wp_localize_script( 'exmachina_admin_js', 'exmachina_toggles', apply_filters( 'exmachina_toggles', $toggles ) );

} // end function exmachina_load_admin_js()
