<?php
/**
 * Creates a meta box for the theme settings page, which holds textareas for custom scripts within
 * the theme.
 *
 */

/* Create the comments meta box on the 'add_meta_boxes' hook. */
add_action( 'add_meta_boxes', 'exmachina_meta_box_theme_add_comments' );

/* Sanitize the scripts settings before adding them to the database. */
add_filter( 'sanitize_option_' . exmachina_get_prefix() . '_theme_settings', 'exmachina_meta_box_theme_save_comments' );

/* Adds the help tabs to the theme settings page. */
add_action( 'add_help_tabs', 'exmachina_theme_settings_comments_help');

/**
 * Adds the core theme comments meta box to the theme settings page in the admin.
 *
 * @since 0.3.0
 * @return void
 */
function exmachina_meta_box_theme_add_comments() {

	/* Add a custom meta box. */
	add_meta_box( 'exmachina-core-comments', __( 'Comments and Trackbacks', 'exmachina-core' ), 'exmachina_meta_box_theme_display_comments', exmachina_get_settings_page_name(), 'normal', 'high' );

}

/**
 * Callback for Theme Settings Comments meta box.
 */
function exmachina_meta_box_theme_display_comments() {
?>
	<p>
		<?php _e( 'Enable Comments', 'exmachina-core' ); ?>
		<label for="<?php echo exmachina_settings_field_id( 'comments_posts' ); ?>" title="Enable comments on posts"><input type="checkbox" name="<?php echo exmachina_settings_field_name( 'comments_posts' ); ?>" id="<?php echo exmachina_settings_field_id( 'comments_posts' ); ?>" value="1"<?php checked( exmachina_get_setting( 'comments_posts' ) ); ?> />
		<?php _e( 'on posts?', 'exmachina-core' ); ?></label>

		<label for="<?php echo exmachina_settings_field_id( 'comments_pages' ); ?>" title="Enable comments on pages"><input type="checkbox" name="<?php echo exmachina_settings_field_name( 'comments_pages' ); ?>" id="<?php echo exmachina_settings_field_id( 'comments_pages' ); ?>" value="1"<?php checked( exmachina_get_setting( 'comments_pages' ) ); ?> />
		<?php _e( 'on pages?', 'exmachina-core' ); ?></label>
	</p>

	<p>
		<?php _e( 'Enable Trackbacks', 'exmachina-core' ); ?>
		<label for="<?php echo exmachina_settings_field_id( 'trackbacks_posts' ); ?>" title="Enable trackbacks on posts"><input type="checkbox" name="<?php echo exmachina_settings_field_name( 'trackbacks_posts' ); ?>" id="<?php echo exmachina_settings_field_id( 'trackbacks_posts' ); ?>" value="1"<?php checked( exmachina_get_setting( 'trackbacks_posts' ) ); ?> />
		<?php _e( 'on posts?', 'exmachina-core' ); ?></label>

		<label for="<?php echo exmachina_settings_field_id( 'trackbacks_pages' ); ?>" title="Enable trackbacks on pages"><input type="checkbox" name="<?php echo exmachina_settings_field_name( 'trackbacks_pages' ); ?>" id="<?php echo exmachina_settings_field_id( 'trackbacks_pages' ); ?>" value="1"<?php checked( exmachina_get_setting( 'trackbacks_pages' ) ); ?> />
		<?php _e( 'on pages?', 'exmachina-core' ); ?></label>
	</p>

	<p><span class="description"><?php _e( 'Comments and Trackbacks can also be disabled on a per post/page basis when creating/editing posts/pages.', 'exmachina-core' ); ?></span></p>

<?php
}

/**
 * Saves the comments meta box settings by filtering the "sanitize_option_{$prefix}_theme_settings" hook.
 *
 * @since 0.3.0
 * @param array $settings Array of theme settings passed by the Settings API for validation.
 * @return array $settings
 */
function exmachina_meta_box_theme_save_comments( $settings ) {

	if ( !isset( $_POST['reset'] ) ) {
		$settings['comments_posts'] =  absint( $settings['comments_posts'] );
		$settings['trackbacks_posts'] =  absint( $settings['trackbacks_posts'] );
		$settings['comments_pages'] =  absint( $settings['comments_pages'] );
		$settings['trackbacks_pages'] =  absint( $settings['trackbacks_pages'] );
	}

	/* Return the theme settings. */
	return $settings;
}

/**
 * Contextual help content.
 */
function exmachina_theme_settings_comments_help() {

	$screen = get_current_screen();

	$comments_help =
		'<h3>' . __( 'Comments and Trackbacks', 'exmachina-core' ) . '</h3>' .
		'<p>'  . __( 'This allows a site wide decision on whether comments and trackbacks (notifications when someone links to your page) are enabled for posts and pages.', 'exmachina-core' ) . '</p>' .
		'<p>'  . __( 'If you enable comments or trackbacks here, it can be disabled on an individual post or page. If you disable here, they cannot be enabled on an individual post or page.', 'exmachina-core' ) . '</p>';


	$screen->add_help_tab( array(
		'id'      => exmachina_get_settings_page_name() . '-comments',
		'title'   => __( 'Comments and Trackbacks', 'exmachina-core' ),
		'content' => $comments_help,
	) );

}

?>