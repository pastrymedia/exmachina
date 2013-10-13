<?php
/*
 * Plugin Name: Custom Favicon
 * Description: Simply add favicon to your ExMachina Powered site and the WordPress admin
 * Version: 1.0
 * Author: MachinaThemes
 * Author URI: http://machinathemes.com
 *
 * @package ExMachina
 * @subpackage Functions
 * @copyright Copyright (c) 2013, machinathemes.com
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Hybrid Favicon Class
 *
 * @since 1.0
 */

class Hybrid_Favicon {

	/**
	 * Initializes the plugin by setting filters, and administration functions.
	 */
	function __construct() {

		// Adding Plugin Menu
		add_action( 'admin_menu', array( &$this, 'hybrid_favicon_menu' ) );

		// Add Favicon to wp front
		add_action( 'wp_head', array( &$this, 'hybrid_favicon_display' ) );

		// Add Favicon to wp admin
		add_action( 'admin_head', array( &$this, 'hybrid_favicon_display' ) );
		add_action( 'login_head', array( &$this, 'hybrid_favicon_display' ) );

	} // end constructor


	function hybrid_favicon_menu()
	{
		global $theme_settings_page;

		/* Get the theme prefix. */
		$prefix = hybrid_get_prefix();

		/* Create a settings meta box only on the theme settings page. */
		add_action( 'load-appearance_page_theme-settings', array( &$this, 'hybrid_favicon_theme_settings') );

		/* Sanitize the scripts settings before adding them to the database. */
		add_filter( "sanitize_option_{$prefix}_theme_settings", array( &$this, 'hybrid_favicon_theme_validate') );

		// Enqueue styles and script
    	add_action( 'admin_enqueue_scripts', array( &$this, 'hybrid_favicon_assets' ) );

		/* Adds my_help_tab when my_admin_page loads */
	    add_action('load-'.$theme_settings_page, array( &$this, 'hybrid_favicon_help') );

	}	//hybrid_favicon_menu


	/**
	 * Add hybrid favicon meta box to the theme settings page in the admin.
	 *
	 * @since 1.0
	 * @return void
	 */
	function hybrid_favicon_theme_settings() {

		add_meta_box( 'hybrid-theme-favicon', __( 'Favicon', 'hybrid-core' ), array( &$this, 'hybrid_favicon_meta_box'), 'appearance_page_theme-settings', 'normal', 'high' );

	}

	/**
	 * Callback for Theme Settings Post Archives meta box.
	 */
	function hybrid_favicon_meta_box() {
	?>
		<p>
			<label for="<?php echo hybrid_settings_field_id( 'favicon_url' ); ?>"><?php _e( 'Favicon URL:', 'hybrid-core' ); ?></label>
			<input type="text" name="<?php echo hybrid_settings_field_name( 'favicon_url' ); ?>" id="<?php echo hybrid_settings_field_id( 'favicon_url' ); ?>" value="<?php echo esc_attr( hybrid_get_setting( 'favicon_url' ) ); ?>" size="50" />
			<input type='button' id='<?php echo hybrid_settings_field_id( 'favicon_url' ); ?>_button' class='button button-upload' value='Upload'/>
	        <?php
	        if (hybrid_get_setting( 'favicon_url' )) {
	        ?>
	        <img style='max-height: 25px;vertical-align: middle;' src='<?php echo esc_attr( hybrid_get_setting( 'favicon_url' ) ); ?>' class='preview-upload' />
			<?php
		    }
		    ?>
		</p>
	<?php }


	/**
	 * Saves the scripts meta box settings by filtering the "sanitize_option_{$prefix}_theme_settings" hook.
	 *
	 * @since 1.0
	 * @param array $settings Array of theme settings passed by the Settings API for validation.
	 * @return array $settings
	 */
	function hybrid_favicon_theme_validate( $settings ) {

		/* Return the theme settings. */
		return $settings;
	}

	/**
	 * Contextual help content.
	 */
	function hybrid_favicon_help() {

		$screen = get_current_screen();

		$favicon_help =
			'<h3>' . __( 'Favicon', 'hybrid-core' ) . '</h3>' .
			'<p>'  . __( 'Add a Favicon to your site and the WordPress admin. Put favicon URL into the textbox or Click the Upload button and upload favicon file', 'hybrid-core' ) . '</p>' .

		$screen->add_help_tab( array(
			'id'      => hybrid_get_settings_page_name() . '-archives',
			'title'   => __( 'Custom Favicon', 'hybrid-core' ),
			'content' => $favicon_help,
		) );

	}


	/* Enqueue scripts (and related stylesheets) */
	function hybrid_favicon_assets($hook_suffix) {
	    global $theme_settings_page;

		if ( $theme_settings_page == $hook_suffix ) {

			wp_enqueue_media();

	  }
	}


	/* Load Favicon to website frontend */
	function hybrid_favicon_display() {

		if( "" != hybrid_get_setting( 'favicon_url' ) ) {
	        echo '<link rel="shortcut icon" href="'.  esc_attr( hybrid_get_setting( 'favicon_url' ) )  .'"/>'."\n";
	    }
	}


} // End Class


// Initiation call of plugin
$hybrid_fav = new Hybrid_Favicon();

?>