<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * CSS Stylesheet Functions
 *
 * load-styles.php
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

add_action( 'exmachina_meta', 'exmachina_load_stylesheet' );
/**
 * Load Main CSS Stylesheet
 *
 * Echo reference to the style sheet. If a child theme is active, it loads the
 * child theme's stylesheet, otherwise, it loads the ExMachina style sheet.
 *
 * @uses exmachina_enqueue_main_stylesheet() Enqueue main style sheet.
 *
 * @since 0.5.0
 * @access public
 */
function exmachina_load_stylesheet() {

	add_action( 'wp_enqueue_scripts', 'exmachina_enqueue_main_stylesheet', 5 );

} // end function exmachina_load_stylesheet()

/**
 * Enqueue Main CSS Stylesheet
 *
 * Enqueue main style sheet. Properly enqueue the main style sheet.
 *
 * @todo test parent/child constants
 *
 * @link http://codex.wordpress.org/Function_Reference/sanitize_title_with_dashes
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * @link http://codex.wordpress.org/Function_Reference/get_stylesheet_uri
 *
 * @since 0.5.0
 * @access public
 */
function exmachina_enqueue_main_stylesheet() {

	$version = defined( 'CHILD_THEME_VERSION' ) && CHILD_THEME_VERSION ? CHILD_THEME_VERSION : PARENT_THEME_VERSION;
	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	wp_enqueue_style( $handle, get_stylesheet_uri(), false, $version );

} // end function exmachina_enqueue_main_stylesheet()

add_action( 'admin_print_styles', 'exmachina_load_admin_styles' );
/**
 * Load Admin CSS Stylesheet
 *
 * Enqueue ExMachina admin styles.
 *
 * @todo rename style
 * @todo compare against hybrid
 * @todo change action hook
 *
 * @since 0.5.0
 * @access public
 *
 * @uses EXMACHINA_CSS
 * @uses PARENT_THEME_VERSION
 */
function exmachina_load_admin_styles() {

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'exmachina_admin_css', EXMACHINA_CSS . "/admin$suffix.css", array(), PARENT_THEME_VERSION );

} // end function exmachina_load_admin_styles()
