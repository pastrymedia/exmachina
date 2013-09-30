<?php
/**
 * ExMachina Framework.
 *
 * WARNING: This file is part of the core ExMachina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package ExMachina\Widgets
 * @author  Machina Themes
 * @license GPL-2.0+
 * @link    http://www.machinathemes.com/
 */

//* Include widget class files
require_once( EXMACHINA_WIDGETS_DIR . '/user-profile-widget.php' );
require_once( EXMACHINA_WIDGETS_DIR . '/featured-post-widget.php' );
require_once( EXMACHINA_WIDGETS_DIR . '/featured-page-widget.php' );

add_action( 'widgets_init', 'exmachina_load_widgets' );
/**
 * Register widgets for use in the ExMachina theme.
 *
 * @since 1.7.0
 */
function exmachina_load_widgets() {

	register_widget( 'ExMachina_Featured_Page' );
	register_widget( 'ExMachina_Featured_Post' );
	register_widget( 'ExMachina_User_Profile_Widget' );

}

add_action( 'load-themes.php', 'exmachina_remove_default_widgets_from_header_right' );
/**
 * Temporary function to work around the default widgets that get added to
 * Header Right when switching themes.
 *
 * The $defaults array contains a list of the IDs of the widgets that are added
 * to the first sidebar in a new default install. If this exactly matches the
 * widgets in Header Right after switching themes, then they are removed.
 *
 * This works around a perceived WP problem for new installs.
 *
 * If a user amends the list of widgets in the first sidebar before switching to
 * a ExMachina child theme, then this function won't do anything.
 *
 * @since 1.8.0
 *
 * @return null Return early if not just switched to a new theme.
 */
function exmachina_remove_default_widgets_from_header_right() {

	//* Some tomfoolery for a faux activation hook
	if ( ! isset( $_REQUEST['activated'] ) || 'true' !== $_REQUEST['activated'] )
		return;

	$widgets  = get_option( 'sidebars_widgets' );
	$defaults = array( 0 => 'search-2', 1 => 'recent-posts-2', 2 => 'recent-comments-2', 3 => 'archives-2', 4 => 'categories-2', 5 => 'meta-2', );

	if ( isset( $widgets['header-right'] ) && $defaults === $widgets['header-right'] ) {
		$widgets['header-right'] = array();
		update_option( 'sidebars_widgets', $widgets );
	}

}
