<?php
/*
Plugin Name: ExMachina Simple Sidebars
Plugin URI: http://www.studiopress.com/plugins/simple-sidebars
Description: ExMachina Simple Sidebars allows you to easily create and use new sidebar widget areas.
Author: Nathan Rice
Author URI: http://www.nathanrice.net/

Text Domain: ss
Domain Path: /languages/

Version: 2.0.1

License: GNU General Public License v2.0 (or later)
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

/** Define our constants */
define( 'SS_SETTINGS_FIELD', 'ss-settings' );
define( 'SS_PLUGIN_DIR', dirname( __FILE__ ) );



add_action( 'exmachina_setup', 'ss_exmachina_init', 12 );
/**
 * Plugin initialization.
 *
 * Initialize the plugin, set the constants, hook callbacks to actions, and include the plugin library.
 *
 * @since 0.9.0
 */
function ss_exmachina_init() {

	//* required hooks
	add_action( 'get_header', 'ss_sidebars_init' );
	add_action( 'widgets_init', 'ss_register_sidebars' );

	//* The rest is admin stuff, so load only if we're in the admin area
	if ( ! is_admin() )
		return;

	//* Include admin files
	require_once( SS_PLUGIN_DIR . '/includes/admin.php' );
	require_once( SS_PLUGIN_DIR . '/includes/inpost.php' );
	require_once( SS_PLUGIN_DIR . '/includes/term.php' );

	//* let the child theme hook the exmachina_simple_sidebars_taxonomies filter before hooking term edit
	add_action( 'init', 'ss_term_edit_init' );

}
/**
 * Register widget areas.
 *
 * This function registers the created sidebars as widget areas
 *
 * @since 0.9.0
 */
function ss_register_sidebars() {

	$_sidebars = stripslashes_deep( get_option( SS_SETTINGS_FIELD ) );

	//* If no sidebars have been created, do nothing
	if ( ! $_sidebars )
		return;

	//* Cycle through created sidebars, register them as widget areas
	foreach ( (array) $_sidebars as $id => $info ) {

		exmachina_register_sidebar( array(
			'name'        => esc_html( $info['name'] ),
			'id'          => $id,
			'description' => esc_html( $info['description'] ),
			'editable'    => 1,
		) );

	}

}

/**
 * Use custom sidebars.
 *
 * Remove the default sidebars, run some conditional logic,
 * use alternate sidebars if necessary, else fallback on default sidebars.
 *
 * @since 0.9.0
 */
function ss_sidebars_init() {

	remove_action( 'exmachina_sidebar', 'exmachina_do_sidebar' );
	remove_action( 'exmachina_sidebar_alt', 'exmachina_do_sidebar_alt' );
	add_action( 'exmachina_sidebar', 'ss_do_sidebar' );
	add_action( 'exmachina_sidebar_alt', 'ss_do_sidebar_alt' );

}

/**
 * Display primary sidebar.
 *
 * Display custom sidebar if one exists, else display default primary sidebar.
 *
 * @since 0.9.0
 */
function ss_do_sidebar() {

	if ( ! ss_do_one_sidebar( '_ss_sidebar' ) )
		exmachina_do_sidebar();

}

/**
 * Display secondary sidebar.
 *
 * Display custom sidebar if one exists, else display default secondary sidebar.
 *
 * @since 0.9.0
 */
function ss_do_sidebar_alt() {

	if ( ! ss_do_one_sidebar( '_ss_sidebar_alt' ) )
		exmachina_do_sidebar_alt();

}

/**
 * Sidebar widget area output.
 *
 * Helper function to show widgets in a particular sidebar.
 *
 * @param string $sidebar_key sidebar id you wish to output.
 *
 * @since 0.9.0
 *
 */
function ss_do_one_sidebar( $sidebar_key = '_ss_sidebar' ) {

	static $taxonomies = null;

	if ( is_singular() && $sidebar_key = exmachina_get_custom_field( $sidebar_key ) ) {
		if ( dynamic_sidebar( $sidebar_key ) ) return true;
	}

	if ( is_category() ) {
		$term = get_term( get_query_var( 'cat' ), 'category' );
		if ( isset( $term->meta[$sidebar_key] ) && dynamic_sidebar( $term->meta[$sidebar_key] ) ) return true;
	}

	if ( is_tag() ) {
		$term = get_term( get_query_var( 'tag_id' ), 'post_tag' );
		if ( isset( $term->meta[$sidebar_key] ) && dynamic_sidebar( $term->meta[$sidebar_key] ) ) return true;
	}

	if ( is_tax() ) {
		if ( null === $taxonomies )
			$taxonomies = ss_get_taxonomies();

		foreach ( $taxonomies as $tax ) {
			if ( 'post_tag' == $tax || 'category' == $tax )
				continue;

			if ( is_tax( $tax ) ) {
				$obj = get_queried_object();
				$term = get_term( $obj->term_id, $tax );
				if ( isset( $term->meta[$sidebar_key] ) && dynamic_sidebar( $term->meta[$sidebar_key] ) ) return true;
				break;
			}
		}
	}

	return false;

}

/**
 * Return taxonomy ids.
 *
 * Helper function to return the array keys from a taxonomy query.
 *
 * @since 0.9.0
 */
function ss_get_taxonomies() {

	$taxonomies = get_taxonomies( array( 'show_ui' => true, 'public' => true ) );
	return apply_filters( 'exmachina_simple_sidebars_taxonomies', array_keys( $taxonomies ) );

}

/**
 * Does this ExMachina install have the 3 column layouts deactivated?
 *
 * This function checks to see if the ExMachina install still has active 3 column layouts. Since
 * child themes and plugins can deregister layouts, we need to know if they have deregistered the 3 column layouts.
 *
 * @since 0.9.2
 */
function ss_has_3_column_layouts() {

	$_layouts = (array) exmachina_get_layouts();
	$_layouts = array_keys( $_layouts );
	$_3_column = array_intersect( $_layouts, array( 'content-sidebar-sidebar', 'sidebar-content-sidebar', 'sidebar-sidebar-content' ) );

	return ! empty( $_3_column );

}
