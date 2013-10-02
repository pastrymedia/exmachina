<?php
/**
 * This file controls the creation and inclusion of the custom.php file.
 *
 * @since 1.5.0
 */

/**
 * Return the full path to the custom.php file for editing and inclusion.
 *
 * @uses exmachina_design_get_stylesheet_location()
 *
 * @since 1.5.0
 *
 */
function exmachina_design_get_custom_php_path() {

	return exmachina_design_get_stylesheet_location( 'path' ) . 'custom.php';

}

/**
 * Helper function that will create custom.php file, if it does not already exist.
 *
 * @uses exmachina_design_get_custom_php_path()
 *
 * @since 1.5.0
 *
 */
function exmachina_design_create_custom_php() {

	if ( file_exists( exmachina_design_get_custom_php_path() ) )
		return;

	$handle = @fopen( exmachina_design_get_custom_php_path(), 'w' );
	@fwrite( $handle, stripslashes( "<?php\n/** Do not remove this line. Edit functions below. */\n" ) );
	@fclose( $handle );

}

/**
 * Helper function that will create custom.php file, if it does not already exist.
 *
 * @uses exmachina_design_get_custom_php_path()
 *
 * @since 1.5.0
 *
 */
function exmachina_design_edit_custom_php( $text = '' ) {

	/** Create file, if it doesn't exist */
	if ( ! file_exists( exmachina_design_get_custom_php_path() ) )
		exmachina_design_create_custom_php();

	/** Now that it exists, write text to that file */
	$handle = @fopen( exmachina_design_get_custom_php_path(), 'w+' );
	@fwrite( $handle, stripslashes( $text ) );
	@fclose( $handle );

}

add_action( 'after_setup_theme', 'exmachina_design_do_custom_php' );
/**
 * PHP require the custom.php file, if it exists.
 *
 * @uses exmachina_design_get_custom_php_path()
 *
 * @since 1.5.0
 *
 */
function exmachina_design_do_custom_php() {

	if ( ! is_admin() && file_exists( exmachina_design_get_custom_php_path() ) )
		require_once( exmachina_design_get_custom_php_path() );

}