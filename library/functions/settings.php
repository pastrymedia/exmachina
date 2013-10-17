<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Settings Functions
 *
 * settings.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Functions for dealing with theme settings on both the front end of the site
 * and the admin. This allows us to set some default settings and make it easy
 * for theme developers to quickly grab theme settings from the database. This
 * file is only loaded if the theme adds support for the
 * 'exmachina-core-theme-settings' feature.
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

/**
 * Get Setting
 *
 * Loads the ExMachina theme settings once and allows the input of the specific
 * field the user would like to show. ExMachina theme settings are added with
 * 'autoload' set to 'yes', so the settings are only loaded once on each page
 * load.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/wp_kses_stripslashes
 *
 * @uses exmachina_get_default_theme_settings Gets the default settings.
 * @uses exmachina_get_prefix() 							Gets the prefix of the theme.
 *
 * @since 2.5.0
 * @access public
 *
 * @global object $exmachina 					The global ExMachina object.
 * @param  string $option 						The specific theme setting the user wants.
 * @return mixed  $settings[$option] 	Specific setting asked for.
 */
function exmachina_get_setting( $option = '' ) {
	global $exmachina;

	/* If no specific option was requested, return false. */
	if ( !$option )
		return false;

	/* Get the default settings. */
	$defaults = exmachina_get_default_theme_settings();

	/* If the settings array hasn't been set, call get_option() to get an array of theme settings. */
	if ( !isset( $exmachina->settings ) || !is_array( $exmachina->settings ) )
		$exmachina->settings = get_option( exmachina_get_prefix() . '_theme_settings', $defaults );

	/* If the option isn't set but the default is, set the option to the default. */
	if ( !isset( $exmachina->settings[ $option ] ) && isset( $defaults[ $option ] ) )
		$exmachina->settings[ $option ] = $defaults[ $option ];

	/* If no option is found at this point, return false. */
	if ( !isset( $exmachina->settings[ $option ] ) )
		return false;

	/* If the specific option is an array, return it. */
	if ( is_array( $exmachina->settings[ $option ] ) )
		return $exmachina->settings[ $option ];

	/* Strip slashes from the setting and return. */
	else
		return wp_kses_stripslashes( $exmachina->settings[ $option ] );

} // end function exmachina_get_setting()

/**
 * Get Default Theme Settings
 *
 * Sets up a default array of theme settings for use with the theme. Theme
 * developers should filter the "{$prefix}_default_theme_settings" hook to define
 * any default theme settings. WordPress does not provide a hook for default
 * settings at this time.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/is_child_theme
 *
 * @uses exmachina_get_prefix() Gets the prefix of the theme.
 *
 * @since 2.5.0
 * @access public
 *
 * @return array $settings The default theme settings.
 */
function exmachina_get_default_theme_settings() {

	/* Set up some default variables. */
	$settings = array();
	$prefix = exmachina_get_prefix();

	/* Get theme-supported meta boxes for the settings page. */
	$supports = get_theme_support( 'exmachina-core-theme-settings' );

	$settings = array(
		'comments_pages'            => 0,
		'comments_posts'            => 1,
		'trackbacks_pages'          => 0,
		'trackbacks_posts'          => 1,
		'content_archive'           => 'full',
		'content_archive_limit'		  => 0,
		'content_archive_thumbnail' => 0,
		'content_archive_more'      => '[Read more...]',
		'image_size'                => 'thumbnail',
		'posts_nav'                 => 'numeric',
		'single_nav'                => 0,
		'header_scripts'            => '',
		'footer_scripts'            => '',
	);

	/* If the current theme supports the footer meta box and shortcodes, add default footer settings. */
	if ( is_array( $supports[0] ) && in_array( 'footer', $supports[0] ) && current_theme_supports( 'exmachina-core-shortcodes' ) ) {

		/* If there is a child theme active, add the [child-link] shortcode to the $footer_insert. */
		if ( is_child_theme() )
			$settings['footer_insert'] = '<p class="copyright">' . __( 'Copyright &#169; [the-year] [site-link].', 'exmachina-core' ) . '</p>' . "\n\n" . '<p class="credit">' . __( 'Powered by [wp-link], [theme-link], and [child-link].', 'exmachina-core' ) . '</p>';

		/* If no child theme is active, leave out the [child-link] shortcode. */
		else
			$settings['footer_insert'] = '<p class="copyright">' . __( 'Copyright &#169; [the-year] [site-link].', 'exmachina-core' ) . '</p>' . "\n\n" . '<p class="credit">' . __( 'Powered by [wp-link] and [theme-link].', 'exmachina-core' ) . '</p>';
	}

	/* Return the $settings array and provide a hook for overwriting the default settings. */
	return apply_filters( "{$prefix}_default_theme_settings", $settings );

} // end function exmachina_get_default_theme_settings()
