<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * EXTENSION
 *
 * EXTENSIONPHP
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * DESCRIPTION
 *
 * @package     ExMachina
 * @subpackage  Extensions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin extension
###############################################################################

/* Register custom sections, settings, and controls. */
add_action( 'customize_register', 'exmachina_customize_logo_register' );


/**
 * Registers custom sections, settings, and controls for the $wp_customize instance.
 *
 * @since 0.3.2
 * @access private
 * @param object $wp_customize
 */
function exmachina_customize_logo_register( $wp_customize ) {

	/* Add the footer section. */
	$wp_customize->add_section(
		'title_tagline',
		array(
			'title'      => esc_html__( 'Branding', 'exmachina-core' ),
			'priority'   => 1,
			'capability' => 'edit_theme_options'
		)
	);

	/* Add the 'custom_css' setting. */
	$wp_customize->add_setting(
		"custom_logo",
		array(
			'default'              => '',
			'type'                 => 'theme_mod',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'exmachina_customize_sanitize',
			'sanitize_js_callback' => 'exmachina_customize_sanitize',
			//'transport'            => 'postMessage',
		)
	);

	/* Add the textarea control for the 'custom_css' setting. */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'custom_logo',
			array(
				'label'    => esc_html__( 'Logo', 'exmachina-core' ),
				'section'  => 'title_tagline',
				'settings' => "custom_logo",
			)
		)
	);

	/* If viewing the customize preview screen, add a script to show a live preview.
	if ( $wp_customize->is_preview() && !is_admin() ) {
		add_action( 'wp_footer', 'exmachina_customize_logo_preview_script', 22 );
	}
	*/
}

/**
 * Handles changing settings for the live preview of the theme.
 *
 * @since 0.3.2
 * @access private
 */
function exmachina_customize_logo_preview_script() {

	?>
	<script type="text/javascript">
	wp.customize(
		'custom_css',
		function( value ) {
			value.bind(
				function( to ) {
					jQuery( '#custom-colors-css' ).html( to );
				}
			);
		}
	);
	</script>
	<?php
}

?>