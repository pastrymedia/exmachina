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
			'404_title'   												=> __( 'Not found, error 404', 'exmachina' ),
			'404_content' 												=> '',
			'breadcrumb_home'											=> __( 'Home', 'exmachina' ),
			'breadcrumb_sep'											=> ' / ',
			'breadcrumb_list_sep'									=> ', ',
			'breadcrumb_prefix'										=> '<div class=\'breadcrumb\'>',
			'breadcrumb_suffix'										=> '</div>',
			'breadcrumb_heirarchial_attachments'	=> true,
			'breadcrumb_heirarchial_categories'		=> true,
			'breadcrumb_display'									=> true,
				'breadcrumb_label_prefix'						=> __( 'You are here: ', 'exmachina' ),
				'breadcrumb_author'									=> __( 'Archives for ', 'exmachina' ),
				'breadcrumb_category'								=> __( 'Archives for ', 'exmachina' ),
				'breadcrumb_tag'										=> __( 'Archives for ', 'exmachina' ),
				'breadcrumb_date'										=> __( 'Archives for ', 'exmachina' ),
				'breadcrumb_search'									=> __( 'Search for ', 'exmachina' ),
				'breadcrumb_tax'										=> __( 'Archives for ', 'exmachina' ),
				'breadcrumb_post_type'							=> __( 'Archives for ', 'exmachina' ),
				'breadcrumb_404'										=> __( 'Not found: ', 'exmachina' )
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
					'breadcrumb_home',
					'breadcrumb_sep',
					'breadcrumb_list_sep',
					'breadcrumb_heirarchial_attachments',
					'breadcrumb_heirarchial_categories',
					'breadcrumb_display',
          'breadcrumb_label_prefix',
          'breadcrumb_author',
          'breadcrumb_category',
          'breadcrumb_tag',
          'breadcrumb_date',
          'breadcrumb_search',
          'breadcrumb_tax',
          'breadcrumb_post_type',
          'breadcrumb_404',
				) );
			exmachina_add_option_filter( 'safe_html', $this->settings_field,
				array(
					'404_content',
					'breadcrumb_prefix',
					'breadcrumb_suffix',
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

		add_meta_box('exmachina-content-settings-breadcrumbs', __( 'Breadcrumb Settings', 'exmachina' ), array( $this, 'breadcrumb_box' ), $this->pagehook, 'main' );
		add_meta_box('exmachina-content-settings-404', __( '404 Page', 'exmachina' ), array( $this, 'custom_404_box' ), $this->pagehook, 'main' );


	}

	/**
	 * Callback for Theme Settings Breadcrumb Settings meta box.
	 *
	 * @since 1.3.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function breadcrumb_box() {

		?>

		<legend>Defaults</legend>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>"><?php _e( 'Home Link Text:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_home' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_home' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_sep' ); ?>"><?php _e( 'Trail Seperator:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_sep' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_sep' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_sep' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_list_sep' ); ?>"><?php _e( 'List Seperator:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_list_sep' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_list_sep' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_list_sep' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_prefix' ); ?>"><?php _e( 'Prefix:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_prefix' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_prefix' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_prefix' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_suffix' ); ?>"><?php _e( 'Suffix:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_suffix' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_suffix' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_suffix' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_heirarchial_attachments' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_heirarchial_attachments' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_heirarchial_attachments' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_heirarchial_attachments' ) ); ?> />
			<?php _e( 'Enable Hierarchial Attachments?', 'exmachina' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_heirarchial_categories' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_heirarchial_categories' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_heirarchial_categories' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_heirarchial_categories' ) ); ?> />
			<?php _e( 'Enable Hierarchial Categories?', 'exmachina' ); ?></label>
		</p>

		<legend>Labels</legend>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_label_prefix' ); ?>"><?php _e( 'Prefix:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_label_prefix' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_label_prefix' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_label_prefix' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_author' ); ?>"><?php _e( 'Author:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_author' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_author' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_author' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_category' ); ?>"><?php _e( 'Category:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_category' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_category' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_category' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_tag' ); ?>"><?php _e( 'Tag:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_tag' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_tag' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_tag' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_date' ); ?>"><?php _e( 'Date:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_date' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_date' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_date' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_search' ); ?>"><?php _e( 'Search:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_search' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_search' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_search' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_tax' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_tax' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_tax' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_tax' ) ); ?> />
			<?php _e( 'Taxonomy:', 'exmachina' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_post_type' ); ?>"><?php _e( 'Post Type:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_post_type' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_post_type' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_post_type' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>"><?php _e( '404:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_404' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_404' ) ); ?>" size="50" />
		</p>


		<p><span class="description"><?php printf( __( 'If your custom feed(s) are not handled by Feedburner, we do not recommend that you use the redirect options.', 'exmachina' ) ); ?></span></p>
		<?php

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