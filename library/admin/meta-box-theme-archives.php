<?php
/**
 * Creates a meta box for the theme settings page, which holds textareas for custom scripts within
 * the theme.
 *
 */


/* Create the archives meta box on the 'add_meta_boxes' hook. */
add_action( 'add_meta_boxes', 'hybrid_meta_box_theme_add_archives' );

/* Sanitize the archives settings before adding them to the database. */
add_filter( 'sanitize_option_' . hybrid_get_prefix() . '_theme_settings', 'hybrid_meta_box_theme_save_archives' );

/* Adds the help tabs to the theme settings page. */
add_action( 'add_help_tabs', 'hybrid_theme_settings_archives_help');

/**
 * Adds Content Archives meta box to the theme settings page in the admin.
 *
 * @since 0.3.0
 * @return void
 */
function hybrid_meta_box_theme_add_archives() {

	add_meta_box( 'hybrid-core-archives', __( 'Content Archives', 'hybrid-core' ), 'hybrid_meta_box_theme_display_archives', hybrid_get_settings_page_name(), 'normal', 'high' );

}

/**
 * Callback for Theme Settings Post Archives meta box.
 */
function hybrid_meta_box_theme_display_archives() {
?>
	<p class="collapsed">
		<label for="<?php echo hybrid_settings_field_id( 'content_archive' ); ?>"><?php _e( 'Select one of the following:', 'hybrid-core' ); ?></label>
		<select name="<?php echo hybrid_settings_field_name( 'content_archive' ); ?>" id="<?php echo hybrid_settings_field_id( 'content_archive' ); ?>">
		<?php
		$archive_display = apply_filters(
			'hybrid_archive_display_options',
			array(
				'full'     => __( 'Display full post', 'hybrid-core' ),
				'excerpts' => __( 'Display post excerpts', 'hybrid-core' ),
			)
		);
		foreach ( (array) $archive_display as $value => $name )
			echo '<option value="' . esc_attr( $value ) . '"' . selected( hybrid_get_setting( 'content_archive' ), esc_attr( $value ), false ) . '>' . esc_html( $name ) . '</option>' . "\n";
		?>
		</select>
	</p>

	<div id="hybrid_content_limit_setting" <?php if ( 'full' == hybrid_get_setting( 'content_archive' )) echo 'class="hidden"';?>>
		<p>
			<label for="<?php echo hybrid_settings_field_id( 'content_archive_limit' ); ?>"><?php _e( 'Limit content to', 'hybrid-core' ); ?>
			<input type="text" name="<?php echo hybrid_settings_field_name( 'content_archive_limit' ); ?>" id="<?php echo hybrid_settings_field_id( 'content_archive_limit' ); ?>" value="<?php echo esc_attr( hybrid_get_setting( 'content_archive_limit' ) ); ?>" size="3" />
			<?php _e( 'characters', 'hybrid-core' ); ?></label>
		</p>

		<p><span class="description"><?php _e( 'Select "Display post excerpts" will limit the text and strip all formatting from the text displayed. Set 0 characters will display the first 55 words (default)', 'hybrid-core' ); ?></span></p>
	</div>

	<p>
		<?php _e( 'More Text (if applicable):', 'hybrid-core' ); ?> <input type="text" name="<?php echo hybrid_settings_field_name( 'content_archive_more' ); ?>" id="<?php echo hybrid_settings_field_id( 'content_archive_more' ); ?>" value="<?php echo esc_attr( hybrid_get_setting( 'content_archive_more' ) ); ?>" size="25" />
	</p>

	<p class="collapsed">
		<label for="<?php echo hybrid_settings_field_id( 'content_archive_thumbnail' ); ?>"><input type="checkbox" name="<?php echo hybrid_settings_field_name( 'content_archive_thumbnail' ); ?>" id="<?php echo hybrid_settings_field_id( 'content_archive_thumbnail' ); ?>" value="1" <?php checked( hybrid_get_setting( 'content_archive_thumbnail' ) ); ?> />
		<?php _e( 'Include the Featured Image?', 'hybrid-core' ); ?></label>
	</p>

	<p id="hybrid_image_size" <?php if (!hybrid_get_setting( 'content_archive_thumbnail' )) echo 'class="hidden"';?>>
		<label for="<?php echo hybrid_settings_field_id( 'image_size' ); ?>"><?php _e( 'Image Size:', 'hybrid-core' ); ?></label>
		<select name="<?php echo hybrid_settings_field_name( 'image_size' ); ?>" id="<?php echo hybrid_settings_field_id( 'image_size' ); ?>">
		<?php
		$sizes = hybrid_get_image_sizes();
		foreach ( (array) $sizes as $name => $size )
			echo '<option value="' . esc_attr( $name ) . '"' . selected( hybrid_get_setting( 'image_size' ), $name, FALSE ) . '>' . esc_html( $name ) . ' (' . absint( $size['width'] ) . ' &#x000D7; ' . absint( $size['height'] ) . ')</option>' . "\n";
		?>
		</select>
	</p>
	<p>
		<label for="<?php echo hybrid_settings_field_id( 'posts_nav' ); ?>"><?php _e( 'Select Post Navigation Format:', 'hybrid-core' ); ?></label>
		<select name="<?php echo hybrid_settings_field_name( 'posts_nav' ); ?>" id="<?php echo hybrid_settings_field_id( 'posts_nav' ); ?>">
			<option value="prev-next"<?php selected( 'prev-next', hybrid_get_setting( 'posts_nav' ) ); ?>><?php _e( 'Previous / Next', 'hybrid-core' ); ?></option>
			<option value="numeric"<?php selected( 'numeric', hybrid_get_setting( 'posts_nav' ) ); ?>><?php _e( 'Numeric', 'hybrid-core' ); ?></option>
		</select>
	</p>
	<p><span class="description"><?php _e( 'These options will affect any blog listings page, including archive, author, blog, category, search, and tag pages.', 'hybrid-core' ); ?></span></p>
	<p>
		<label for="<?php echo hybrid_settings_field_id( 'single_nav' ); ?>"><input type="checkbox" name="<?php echo hybrid_settings_field_name( 'single_nav' ); ?>" id="<?php echo hybrid_settings_field_id( 'single_nav' ); ?>" value="1" <?php checked( hybrid_get_setting( 'single_nav' ) ); ?> />
		<?php _e( 'Disable single post navigation link?', 'hybrid-core' ); ?></label>
	</p>

<?php }


/**
 * Saves the scripts meta box settings by filtering the "sanitize_option_{$prefix}_theme_settings" hook.
 *
 * @since 0.3.0
 * @param array $settings Array of theme settings passed by the Settings API for validation.
 * @return array $settings
 */
function hybrid_meta_box_theme_save_archives( $settings ) {

	if ( !isset( $_POST['reset'] ) ) {
		$settings['content_archive_limit'] =  absint( $settings['content_archive_limit'] );
		$settings['content_archive_thumbnail'] =  absint( $settings['content_archive_thumbnail'] );
	}

	/* Return the theme settings. */
	return $settings;
}

/**
 * Contextual help content.
 */
function hybrid_theme_settings_archives_help() {

	$screen = get_current_screen();

	$archives_help =
		'<h3>' . __( 'Content Archives', 'hybrid-core' ) . '</h3>' .
		'<p>'  . __( 'You may change the site wide Content Archives options to control what displays in the site\'s Archives.', 'hybrid-core' ) . '</p>' .
		'<p>'  . __( 'Archives include any pages using the blog template, category pages, tag pages, date archive, author archives, and the latest posts if there is no custom home page.', 'hybrid-core' ) . '</p>' .
		'<p>'  . __( 'The first option allows you to display the full post or the post excerpt. The Display full post setting will display the entire post including HTML code up to the <!--more--> tag if used (this is HTML for the comment tag that is not displayed in the browser).', 'hybrid-core' ) . '</p>' .
		'<p>'  . __( 'The Display post excerpt setting will display the first 55 words of the post after also stripping any included HTML or the manual/custom excerpt added in the post edit screen.', 'hybrid-core' ) . '</p>' .
		'<p>'  . __( 'It may also be coupled with the second field "Limit content to [___] characters" to limit the content to a specific number of letters or spaces.', 'hybrid-core' ) . '</p>' .
		'<p>'  . __( 'The \'Include post image?\' setting allows you to show a thumbnail of the first attached image or currently set featured image.', 'hybrid-core' ) . '</p>' .
		'<p>'  . __( 'This option should not be used with the post content unless the content is limited to avoid duplicate images.', 'hybrid-core' ) . '</p>' .
		'<p>'  . __( 'The \'Image Size\' list is populated by the available image sizes defined in the theme.', 'hybrid-core' ) . '</p>' .
		'<p>'  . __( 'Post Navigation format allows you to select one of two navigation methods.', 'hybrid-core' ) . '</p>';
		'<p>'  . __( 'There is also a checkbox to disable previous & next navigation links on single post', 'hybrid-core' ) . '</p>';

	$screen->add_help_tab( array(
		'id'      => hybrid_get_settings_page_name() . '-archives',
		'title'   => __( 'Content Archives', 'hybrid-core' ),
		'content' => $archives_help,
	) );

}

?>