<?php
/**
 * Creates a meta box for the theme settings page, which holds textareas for custom scripts within
 * the theme.
 *
 */

/* Create the scripts meta box on the 'add_meta_boxes' hook. */
add_action( 'add_meta_boxes', 'exmachina_meta_box_theme_add_scripts' );

/* Sanitize the scripts settings before adding them to the database. */
add_filter( 'sanitize_option_' . exmachina_get_prefix() . '_theme_settings', 'exmachina_meta_box_theme_save_scripts' );

/* Adds the help tabs to the theme settings page. */
add_action( 'add_help_tabs', 'exmachina_theme_settings_scripts_help');

/**
 * Adds the core theme scripts meta box to the theme settings page in the admin.
 *
 * @since 0.3.0
 * @return void
 */
function exmachina_meta_box_theme_add_scripts() {

	add_meta_box( 'exmachina-core-scripts', __( 'Header and Footer Scripts', 'exmachina-core' ), 'exmachina_meta_box_theme_display_scripts', exmachina_get_settings_page_name(), 'normal', 'high' );

}

/**
 * Creates a meta box that allows users to customize their scripts.
 */
function exmachina_meta_box_theme_display_scripts() {
?>
	<p>
		<label for="<?php echo exmachina_settings_field_id( 'header_scripts' ); ?>"><?php printf( __( 'Insert scripts or code before the closing %s tag in the document source', 'exmachina-core' ), '<code>&lt;/head&gt;</code>' ); ?>:</label>
	</p>

	<textarea name="<?php echo exmachina_settings_field_name( 'header_scripts' ) ?>" id="<?php echo exmachina_settings_field_id( 'header_scripts' ); ?>" cols="78" rows="8"><?php echo exmachina_get_setting( 'header_scripts' ); ?></textarea>


	<p>
		<label for="<?php echo exmachina_settings_field_id( 'footer_scripts' ); ?>"><?php printf( __( 'Insert scripts or code before the closing %s tag in the document source', 'exmachina-core' ), '<code>&lt;/body&gt;</code>' ); ?>:</label>
	</p>

	<textarea name="<?php echo exmachina_settings_field_name( 'footer_scripts' ); ?>" id="<?php echo exmachina_settings_field_id( 'footer_scripts' ); ?>" cols="78" rows="8"><?php echo exmachina_get_setting( 'footer_scripts' ) ; ?></textarea>


<?php }

/**
 * Saves the scripts meta box settings by filtering the "sanitize_option_{$prefix}_theme_settings" hook.
 *
 * @since 0.3.0
 * @param array $settings Array of theme settings passed by the Settings API for validation.
 * @return array $settings
 */
function exmachina_meta_box_theme_save_scripts( $settings ) {

	if ( !isset( $_POST['reset'] ) ) {
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( isset( $settings['footer_scripts'] ) && !current_user_can( 'unfiltered_html' ) )
			$settings['footer_scripts'] = stripslashes( wp_filter_post_kses( addslashes( $settings['footer_scripts'] ) ) );

		if ( isset( $settings['header_scripts'] ) && !current_user_can( 'unfiltered_html' ) )
			$settings['header_scripts'] = stripslashes( wp_filter_post_kses( addslashes( $settings['header_scripts'] ) ) );

	}

	/* Return the theme settings. */
	return $settings;
}

/**
 * Contextual help content.
 */
function exmachina_theme_settings_scripts_help() {

	$screen = get_current_screen();

	$scripts_help =
		'<h3>' . __( 'Header and Footer Scripts', 'exmachina-core' ) . '</h3>' .
		'<p>'  . __( 'This provides you with two fields that will output to the head section of your site and just before the closing body tag. These will appear on every page of the site and are a great way to add analytic code, Google Font and other scripts. You cannot use PHP in these fields.', 'exmachina-core' ) . '</p>';

	$screen->add_help_tab( array(
		'id'      => exmachina_get_settings_page_name() . '-scripts',
		'title'   => __( 'Header and Footer Scripts', 'exmachina-core' ),
		'content' => $scripts_help,
	) );

}

?>