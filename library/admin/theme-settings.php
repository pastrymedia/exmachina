<?php
/**
 * Handles the display and functionality of the theme settings page. This provides the needed hooks and
 * meta box calls for developers to create any number of theme settings needed. This file is only loaded if
 * the theme supports the 'exmachina-core-theme-settings' feature.
 *
 * Provides the ability for developers to add custom meta boxes to the theme settings page by using the
 * add_meta_box() function.  Developers should register their meta boxes on the 'add_meta_boxes' hook
 * and register the meta box for 'appearance_page_theme-settings'.  To validate/sanitize data from
 * custom settings, devs should use the 'sanitize_option_{$prefix}_theme_settings' filter hook.
 *
 * @package    ExMachinaCore
 * @subpackage Admin
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2008 - 2013, Justin Tadlock
 * @link       http://themeexmachina.com/exmachina-core
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Hook the settings page function to 'admin_menu'. */
add_action( 'admin_menu', 'exmachina_settings_page_init' );

/**
 * Initializes all the theme settings page functionality. This function is used to create the theme settings
 * page, then use that as a launchpad for specific actions that need to be tied to the settings page.
 *
 * @since 0.7.0
 * @global string $exmachina The global theme object.
 * @return void
 */
function exmachina_settings_page_init() {
	global $exmachina;

	/* Get theme information. */
	$theme = wp_get_theme( get_template() );
	$prefix = exmachina_get_prefix();

	/* Register theme settings. */
	register_setting(
		"{$prefix}_theme_settings",		// Options group.
		"{$prefix}_theme_settings",		// Database option.
		'exmachina_save_theme_settings'	// Validation callback function.
	);

	/* Create the theme settings page. */
	$exmachina->settings_page = add_theme_page(
		sprintf( esc_html__( '%s Theme Settings', 'exmachina-core' ), $theme->get( 'Name' ) ),	// Settings page name.
		esc_html__( 'Theme Settings', 'exmachina-core' ),				// Menu item name.
		exmachina_settings_page_capability(),					// Required capability.
		'theme-settings',							// Screen name.
		'exmachina_settings_page'						// Callback function.
	);

	/* Check if the settings page is being shown before running any functions for it. */
	if ( !empty( $exmachina->settings_page ) ) {

		/* Filter the settings page capability so that it recognizes the 'edit_theme_options' cap. */
		add_filter( "option_page_capability_{$prefix}_theme_settings", 'exmachina_settings_page_capability' );

		/* Sanitize the scripts settings before adding them to the database. */
		add_filter( "sanitize_option_{$prefix}_theme_settings", 'exmachina_theme_validate_settings' );

		/* Load the theme settings meta boxes. */
		add_action( "load-{$exmachina->settings_page}", 'exmachina_load_settings_page_meta_boxes' );

		/* Create a hook for adding meta boxes. */
		add_action( "load-{$exmachina->settings_page}", 'exmachina_settings_page_add_meta_boxes' );

		/* Add help tabs to the theme settings page. */
		add_action( "load-{$exmachina->settings_page}", 'exmachina_settings_page_help' );
		add_action( "load-{$exmachina->settings_page}", 'exmachina_theme_settings_help' );

		/* Load the JavaScript and stylesheets needed for the theme settings screen. */
		add_action( 'admin_enqueue_scripts', 'exmachina_settings_page_enqueue_scripts' );
		add_action( 'admin_enqueue_scripts', 'exmachina_settings_page_enqueue_styles' );
		add_action( "admin_footer-{$exmachina->settings_page}", 'exmachina_settings_page_load_scripts' );
	}
}

/**
 * Returns the required capability for viewing and saving theme settings.
 *
 * @since 1.2.0
 * @return string
 */
function exmachina_settings_page_capability() {
	return apply_filters( exmachina_get_prefix() . '_settings_capability', 'edit_theme_options' );
}

/**
 * Returns the theme settings page name/hook as a string.
 *
 * @since 1.2.0
 * @return string
 */
function exmachina_get_settings_page_name() {
	global $exmachina;

	return ( isset( $exmachina->settings_page ) ? $exmachina->settings_page : 'appearance_page_theme-settings' );
}

/**
 * Provides a hook for adding meta boxes as seen on the post screen in the WordPress admin.  This addition
 * is needed because normal plugin/theme pages don't have this hook by default.  The other goal of this
 * function is to provide a way for themes to load and execute meta box code only on the theme settings
 * page in the admin.  This way, they're not needlessly loading extra files.
 *
 * @since 1.2.0
 * @return void
 */
function exmachina_settings_page_add_meta_boxes() {

	do_action( 'add_meta_boxes', exmachina_get_settings_page_name() );
}

/**
 * Loads the meta boxes packaged with the framework on the theme settings page.  These meta boxes are
 * merely loaded with this function.  Meta boxes are only loaded if the feature is supported by the theme.
 *
 * @since 1.2.0
 * @return void
 */
function exmachina_load_settings_page_meta_boxes() {

	/* Get theme-supported meta boxes for the settings page. */
	$supports = get_theme_support( 'exmachina-core-theme-settings' );

	/* If there are any supported meta boxes, load them. */
	if ( is_array( $supports[0] ) ) {

		/* Load the 'About' meta box if it is supported. */
		if ( in_array( 'about', $supports[0] ) )
			require_once( trailingslashit( EXMACHINA_ADMIN ) . 'meta-box-theme-about.php' );

		/* Load the 'Comments Settings' meta box if it is supported. */
		if ( in_array( 'comments', $supports[0] ) )
			require_once( trailingslashit( EXMACHINA_ADMIN ) . 'meta-box-theme-comments.php' );

		/* Load the 'Content Archives' meta box if it is supported. */
		if ( in_array( 'archives', $supports[0] ) )
			require_once( trailingslashit( EXMACHINA_ADMIN ) . 'meta-box-theme-archives.php' );

		/* Load the 'Header & Footer Scripts' meta box if it is supported. */
		if ( in_array( 'scripts', $supports[0] ) )
			require_once( trailingslashit( EXMACHINA_ADMIN ) . 'meta-box-theme-scripts.php' );

		/* Load the 'Footer' meta box if it is supported. */
		if ( in_array( 'footer', $supports[0] ) )
			require_once( trailingslashit( EXMACHINA_ADMIN ) . 'meta-box-theme-footer.php' );
	}
}

/**
 * Validation/Sanitization callback function for theme settings.  This just returns the data passed to it.  Theme
 * developers should validate/sanitize their theme settings on the "sanitize_option_{$prefix}_theme_settings"
 * hook.  This function merely exists for backwards compatibility.
 *
 * @since 0.7.0
 * @param array $settings An array of the theme settings passed by the Settings API for validation.
 * @return array $settings The array of theme settings.
 */
function exmachina_save_theme_settings( $settings ) {

	/* @deprecated 1.0.0. Developers should filter "sanitize_option_{$prefix}_theme_settings" instead. */
	return apply_filters( exmachina_get_prefix() . '_validate_theme_settings', $settings );
}

/**
 * Saves the scripts meta box settings by filtering the "sanitize_option_{$prefix}_theme_settings" hook.
 *
 * @since 0.3.0
 * @param array $settings Array of theme settings passed by the Settings API for validation.
 * @return array $settings
 */
function exmachina_theme_validate_settings( $settings ) {

	if ( isset( $_POST['reset'] ) ) {
		$settings = exmachina_get_default_theme_settings();
		add_settings_error( exmachina_get_settings_page_name() . '-notices', 'restore_defaults', __( 'Default setting restored.', 'exmachina-core' ), 'updated fade' );
	}

	/* Return the theme settings. */
	return $settings;
}

/**
 * Displays the theme settings page and calls do_meta_boxes() to allow additional settings
 * meta boxes to be added to the page.
 *
 * @since 0.7.0
 * @return void
 */
function exmachina_settings_page() {

	/* Get the theme information. */
	$prefix = exmachina_get_prefix();
	$theme = wp_get_theme( get_template() );

	do_action( "{$prefix}_before_settings_page" ); ?>

	<div class="wrap">

		<?php screen_icon(); ?>
		<h2>
			<?php printf( __( '%s Theme Settings', 'exmachina-core' ), $theme->get( 'Name' ) ); ?>
			<a href="<?php echo admin_url( 'customize.php' ); ?>" class="add-new-h2"><?php esc_html_e( 'Customize', 'exmachina-core' ); ?></a>
			<?php do_action( "{$prefix}_child_theme" ); // hence add ?>
		</h2>
		<?php settings_errors(); ?>

		<?php do_action( "{$prefix}_open_settings_page" ); ?>

		<div class="exmachina-core-settings-wrap">

			<form method="post" action="options.php">

				<?php settings_fields( "{$prefix}_theme_settings" ); ?>
				<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
				<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>

				<div id="poststuff">

					<div id="post-body" class="metabox-holder columns-2">

						<div id="postbox-container-1" class="postbox-container side">
							<?php do_meta_boxes( exmachina_get_settings_page_name(), 'side', null ); ?>
						</div><!-- #postbox-container-1 -->

						<div id="postbox-container-2" class="postbox-container normal advanced">
							<?php do_meta_boxes( exmachina_get_settings_page_name(), 'normal', null ); ?>
							<?php do_meta_boxes( exmachina_get_settings_page_name(), 'advanced', null ); ?>
						</div><!-- #postbox-container-2 -->

					</div><!-- #post-body -->

					<br class="clear">

				</div><!-- #poststuff -->

				<?php submit_button( esc_attr__( 'Update Settings', 'exmachina-core' ), 'primary', 'submit', false ); // hence updated ?>
				<input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restore Defaults', 'exmachina-core' ); ?>" onclick="return confirm( '<?php print esc_js( __( 'Click OK to reset. Any theme settings will be lost!', 'exmachina-core' ) ); ?>' );" />

			</form>

		</div><!-- .exmachina-core-settings-wrap -->

		<?php do_action( "{$prefix}_close_settings_page" ); ?>

	</div><!-- .wrap --><?php

	do_action( "{$prefix}_after_settings_page" );
}

/**
 * Creates a settings field id attribute for use on the theme settings page.  This is a helper function for use
 * with the WordPress settings API.
 *
 * @since 1.0.0
 * @return string
 */
function exmachina_settings_field_id( $setting ) {
	return exmachina_get_prefix() . '_theme_settings-' . sanitize_html_class( $setting );
}

/**
 * Creates a settings field name attribute for use on the theme settings page.  This is a helper function for
 * use with the WordPress settings API.
 *
 * @since 1.0.0
 * @return string
 */
function exmachina_settings_field_name( $setting ) {
	return exmachina_get_prefix() . "_theme_settings[{$setting}]";
}

/**
 * Adds a help tab to the theme settings screen if the theme has provided a 'Documentation URI' and/or
 * 'Support URI'.  Theme developers can add custom help tabs using get_current_screen()->add_help_tab().
 *
 * @since 1.3.0
 * @return void
 */
function exmachina_settings_page_help() {

	/* Get the parent theme data. */
	$theme = wp_get_theme( get_template() );
	$doc_uri = $theme->get( 'Documentation URI' );
	$support_uri = $theme->get( 'Support URI' );

	/* If the theme has provided a documentation or support URI, add them to the help text. */
	if ( !empty( $doc_uri ) || !empty( $support_uri ) ) {

		/* Open an unordered list for the help text. */
		$help = '<ul>';

		/* Add the Documentation URI. */
		if ( !empty( $doc_uri ) )
			$help .= '<li><a href="' . esc_url( $doc_uri ) . '">' . __( 'Documentation', 'exmachina-core' ) . '</a></li>';

		/* Add the Support URI. */
		if ( !empty( $support_uri ) )
			$help .= '<li><a href="' . esc_url( $support_uri ) . '">' . __( 'Support', 'exmachina-core' ) . '</a></li>';

		/* Close the unordered list for the help text. */
		$help .= '</ul>';

		/* Add a help tab with links for documentation and support. */
		get_current_screen()->add_help_tab(
			array(
				'id' => 'default',
				'title' => esc_attr( $theme->get( 'Name' ) ),
				'content' => $help
			)
		);
	}
}

/**
 * Contextual help content.
 */
function exmachina_theme_settings_help() {

	$screen = get_current_screen();

	$theme_settings_help =
		'<h3>' . __( 'Theme Settings', 'exmachina-core' ) . '</h3>' .
		'<p>'  . __( 'Your Theme Settings provides control over how the theme works. You will be able to control a lot of common and even advanced features from this menu. Some child themes may add additional menu items to this list. Each of the boxes can be collapsed by clicking the box header and expanded by doing the same. They can also be dragged into any order you desire or even hidden by clicking on "Screen Options" in the top right of the screen and "unchecking" the boxes you do not want to see.', 'exmachina-core' ) . '</p>';

	$customize_help =
		'<h3>' . __( 'Customize', 'exmachina-core' ) . '</h3>' .
		'<p>'  . __( 'The theme customizer is available for a real time editing environment where theme options can be tried before being applied to the live site. Click \'Customize\' button below to personalize your theme', 'exmachina-core' ) . '</p>';

	$screen->add_help_tab( array(
		'id'      => exmachina_get_settings_page_name() . '-theme-settings',
		'title'   => __( 'Theme Settings', 'exmachina-core' ),
		'content' => $theme_settings_help,
	) );
	$screen->add_help_tab( array(
		'id'      => exmachina_get_settings_page_name() . '-customize',
		'title'   => __( 'Customize', 'exmachina-core' ),
		'content' => $customize_help,
	) );

	//* Add help sidebar
	$screen->set_help_sidebar(
		'<p><strong>' . __( 'For more information:', 'exmachina-core' ) . '</strong></p>' .
		'<p><a href="http://machinathemes.com/contact" target="_blank" title="' . __( 'Get Support', 'exmachina-core' ) . '">' . __( 'Get Support', 'exmachina-core' ) . '</a></p>'
	);

	do_action( 'add_help_tabs', exmachina_get_settings_page_name() );

}

/**
 * Loads the required stylesheets for displaying the theme settings page in the WordPress admin.
 *
 * @since 1.2.0
 * @return void
 */
function exmachina_settings_page_enqueue_styles( $hook_suffix ) {

	/* Load admin stylesheet if on the theme settings screen. */
	if ( $hook_suffix == exmachina_get_settings_page_name() )
		wp_enqueue_style( 'exmachina-core-admin' );
}

/**
 * Loads the JavaScript files required for managing the meta boxes on the theme settings
 * page, which allows users to arrange the boxes to their liking.
 *
 * @since 1.2.0
 * @param string $hook_suffix The current page being viewed.
 * @return void
 */
function exmachina_settings_page_enqueue_scripts( $hook_suffix ) {

	if ( $hook_suffix == exmachina_get_settings_page_name() ){
		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'postbox' );
		wp_enqueue_script( 'exmachina-core-admin' );
		wp_enqueue_script( 'exmachina-core-favicon' );

	}
}

/**
 * Loads the JavaScript required for toggling the meta boxes on the theme settings page.
 *
 * @since 0.7.0
 * @return void
 */
function exmachina_settings_page_load_scripts() { ?>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			postboxes.add_postbox_toggles( '<?php echo exmachina_get_settings_page_name(); ?>' );
		});
		//]]>
	</script><?php
}

?>