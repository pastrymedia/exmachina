<?php
/**
 * This file handles the creation of the Hooks admin menu.
 */


/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Content Settings page.
 *
 * @since 1.8.0
 */
class ExMachina_Admin_Content_Settings extends ExMachina_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * @since 1.8.0
	 *
	 * @uses EXMACHINA_HOOK_SETTINGS_FIELD settings field key
	 *
	 */
	function __construct() {

		$page_id = 'content-settings';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'exmachina',
				'page_title'  => __( 'Content Settings', 'exmachina' ),
				'menu_title'  => __( 'Content Settings', 'exmachina' )
			)
		);

		$page_ops = array(
			'screen_icon' => 'plugins',
		);

		$settings_field = EXMACHINA_CONTENT_SETTINGS_FIELD;

		$default_settings = array(
			'404_title'   => __( 'Not found, error 404', 'exmachina' ),
			'404_content' => '',
		);

		//* Create the page */
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		// Initialize the Sanitization Filter
		add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );

	}

	/**
		 * Set up Sanitization Filters
		 * @since 1.0.0
		 *
		 * See /lib/classes/sanitization.php for all available filters.
		 */
		function sanitization_filters() {

			exmachina_add_option_filter( 'no_html', $this->settings_field,
				array(
					'404_title',
				) );
			exmachina_add_option_filter( 'safe_html', $this->settings_field,
				array(
					'404_content',
				) );
		}

	/**
	 * Load the necessary scripts for this admin page.
	 *
	 * @since 1.8.0
	 *
	 */
	function scripts() {

		//* Load parent scripts as well as ExMachina admin scripts */
		parent::scripts();
		exmachina_load_admin_js();

	}

	/**
 	 * Register meta boxes on the Hooks Settings page.
 	 *
 	 * @since 1.8.0
 	 *
 	 */
	function metaboxes() {

		add_meta_box('exmachina-content-settings-404', __( '404 Page', 'exmachina' ), array( $this, 'custom_404_box' ), $this->pagehook, 'main' );

	}

	/**
		 * 404 Metabox
		 * @since 1.0.0
		 */
		function custom_404_box() {

		echo '<p>' . __( 'Page Title', 'exmachina' ) . '<br />
		<input type="text" name="' . $this->get_field_name( '404_title' ) . '" id="' . $this->get_field_id( '404_title' ) . '" value="' .  esc_attr( $this->get_field_value( '404_title' ) ) . '" size="27" /></p>';


		echo '<p>' . __( 'Page Content', 'exmachina' ) . '</p>';
		wp_editor( exmachina_get_content_option( '404_content', 'exmachina' ), $this->get_field_id( '404_content' ) );
		}

}

add_action( 'exmachina_admin_menu', 'exmachina_add_content_settings_menu' );
/**
 * Instantiate the class to create the menu.
 *
 * @since 1.8.0
 */
function exmachina_add_content_settings_menu() {

	global $exmachina_admin_content_settings;

	$exmachina_admin_content_settings = new ExMachina_Admin_Content_Settings;

}