<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Content Settings
 *
 * content-settings.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
 *
 * @package     ExMachina
 * @subpackage  Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Content Settings page.
 *
 * @since 1.8.0
 */
class ExMachina_Admin_Content_Settings extends ExMachina_Admin_Metaboxes {

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
				'breadcrumb_404'										=> __( 'Not found: ', 'exmachina' ),
			'comment_title_wrap'                  => '<h3>%s</h3>',
      'comments_title'				            	=> __( 'Comments', 'exmachina' ),
			'no_comments_text'				          	=> '',
			'comments_closed_text'								=> '',
			'comments_title_pings'								=> __( 'Trackbacks', 'exmachina' ),
			'comments_no_pings_text'							=> '',
      'comment_list_args_avatar_size'       => 48,
      'comment_author_says_text'            => __( 'says', 'exmachina' ),
			'comment_awaiting_moderation'			  	=> __( 'Your comment is awaiting moderation.', 'exmachina' ),
      'comment_form_args_fields_aria_display'     	=> TRUE,
      'comment_form_args_fields_author_display'    	=> TRUE,
      'comment_form_args_fields_author_label'				=> __( 'Name', 'exmachina' ),
      'comment_form_args_fields_email_display'			=> TRUE,
      'comment_form_args_fields_email_label'				=> __( 'Email', 'exmachina' ),
      'comment_form_args_fields_url_display'				=> TRUE,
      'comment_form_args_fields_url_label'					=> __( 'Website', 'exmachina' ),
      'comment_form_args_title_reply'             	=> __( 'Speak Your Mind', 'exmachina' ),
      'comment_form_args_comment_notes_before'			=> '',
      'comment_form_args_comment_notes_after'				=> '',
      'comment_form_args_label_submit'            	=> __( 'Post Comment', 'exmachina' ),
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
					'comments_title',
					'comments_title_pings',
					'comment_list_args_avatar_size',
					'comment_form_args_fields_aria_display',
					'comment_form_args_fields_author_display',
					'comment_form_args_fields_email_display',
					'comment_form_args_fields_url_display',
					'comment_form_args_label_submit',
				) );
			exmachina_add_option_filter( 'safe_html', $this->settings_field,
				array(
					'404_content',
					'breadcrumb_prefix',
					'breadcrumb_suffix',
					'comment_title_wrap',
					'no_comments_text',
					'comments_closed_text',
					'comments_no_pings_text',
					'comment_author_says_text',
					'comment_awaiting_moderation',
					'comment_form_args_fields_author_label',
					'comment_form_args_fields_email_label',
					'comment_form_args_fields_url_label',
					'comment_form_args_title_reply',
					'comment_form_args_comment_notes_before',
					'comment_form_args_comment_notes_after',
				) );
		}

	/**
	 * Load the necessary scripts for this admin page.
	 *
	 * @since 1.8.0
	 *
	 */
	function settings_page_enqueue_scripts() {

		//* Load parent scripts as well as ExMachina admin scripts */
		parent::settings_page_enqueue_scripts();
		exmachina_load_admin_js();

	}

	/**
 	 * Register meta boxes on the Hooks Settings page.
 	 *
 	 * @since 1.8.0
 	 *
 	 */
	function settings_page_load_metaboxes() {

		add_meta_box('exmachina-content-settings-breadcrumbs', __( 'Breadcrumb Settings', 'exmachina' ), array( $this, 'breadcrumb_box' ), $this->pagehook, 'normal' );
		add_meta_box('exmachina-content-settings-comments', __( 'Comment Settings', 'exmachina' ), array( $this, 'comment_box' ), $this->pagehook, 'normal' );
		add_meta_box('exmachina-content-settings-404', __( '404 Page', 'exmachina' ), array( $this, 'custom_404_box' ), $this->pagehook, 'normal' );


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
	 * Callback for Theme Settings Comment Settings meta box.
	 *
	 * @since 1.3.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function comment_box() {

		?>

		<legend>Defaults</legend>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_title_wrap' ); ?>"><?php _e( 'Title Wrap:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comment_title_wrap' ); ?>" id="<?php echo $this->get_field_id( 'comment_title_wrap' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_title_wrap' ) ); ?>" size="50" /><br />
			<span class="description"><?php _e( 'This is the html tag used around the Comment Title and Pings Title.  Make sure you keep the <tag>%s</tag> format for the wrap to work correctly.', 'exmachina' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comments_title' ); ?>"><?php _e( 'Comment Title:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comments_title' ); ?>" id="<?php echo $this->get_field_id( 'comments_title' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comments_title' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'no_comments_text' ); ?>"><?php _e( 'No Comments Text:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'no_comments_text' ); ?>" id="<?php echo $this->get_field_id( 'no_comments_text' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'no_comments_text' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comments_closed_text' ); ?>"><?php _e( 'Comments Closed Text:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comments_closed_text' ); ?>" id="<?php echo $this->get_field_id( 'comments_closed_text' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comments_closed_text' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comments_title_pings' ); ?>"><?php _e( 'Pings Title:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comments_title_pings' ); ?>" id="<?php echo $this->get_field_id( 'comments_title_pings' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comments_title_pings' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_list_args_avatar_size' ); ?>"><?php _e( 'Avatar Size:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comment_list_args_avatar_size' ); ?>" id="<?php echo $this->get_field_id( 'comment_list_args_avatar_size' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_list_args_avatar_size' ) ); ?>" size="10" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_author_says_text' ); ?>"><?php _e( 'Author Says Text:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comment_author_says_text' ); ?>" id="<?php echo $this->get_field_id( 'comment_author_says_text' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_author_says_text' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_awaiting_moderation' ); ?>"><?php _e( 'Comment Awaiting Moderation Text:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comment_awaiting_moderation' ); ?>" id="<?php echo $this->get_field_id( 'comment_awaiting_moderation' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_awaiting_moderation' ) ); ?>" size="50" />
		</p>

		<legend>Form Fields</legend>


		<!-- Check boxes -->
		<p>
			<label for="<?php echo $this->get_field_id( 'comment_form_args_fields_aria_display' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'comment_form_args_fields_aria_display' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_aria_display' ); ?>" value="1"<?php checked( $this->get_field_value( 'comment_form_args_fields_aria_display' ) ); ?> />
			<?php _e( 'Enable Aria Require True Attribute?', 'exmachina' ); ?></label><br />
			<span class="description"><?php _e( 'This is enabled by default and adds an attribute to the required comment fields that adds a layout of accesibility for visually impaired site visitors.  This attribute is not technically valid XHTML but works in all browsers. Unless you need 100% valid markup at the expense of accesability, leave this option enabled.', 'exmachina' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_form_args_fields_author_display' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'comment_form_args_fields_author_display' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_author_display' ); ?>" value="1"<?php checked( $this->get_field_value( 'comment_form_args_fields_author_display' ) ); ?> />
			<?php _e( 'Display Author Field?', 'exmachina' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_form_args_fields_author_label' ); ?>"><?php _e( 'Author Label:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comment_form_args_fields_author_label' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_author_label' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_form_args_fields_author_label' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_form_args_fields_email_display' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'comment_form_args_fields_email_display' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_email_display' ); ?>" value="1"<?php checked( $this->get_field_value( 'comment_form_args_fields_email_display' ) ); ?> />
			<?php _e( 'Display Email Field?', 'exmachina' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_form_args_fields_email_label' ); ?>"><?php _e( 'Email Label:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comment_form_args_fields_email_label' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_email_label' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_form_args_fields_email_label' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_form_args_fields_url_display' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'comment_form_args_fields_url_display' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_url_display' ); ?>" value="1"<?php checked( $this->get_field_value( 'comment_form_args_fields_url_display' ) ); ?> />
			<?php _e( 'Display URL Field?', 'exmachina' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_form_args_fields_url_label' ); ?>"><?php _e( 'URL Label:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comment_form_args_fields_url_label' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_url_label' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_form_args_fields_url_label' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_form_args_title_reply' ); ?>"><?php _e( 'Reply Label:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comment_form_args_title_reply' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_title_reply' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_form_args_title_reply' ) ); ?>" size="50" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_form_args_comment_notes_before' ); ?>"><?php _e( 'Notes Before Comment:', 'exmachina' ); ?></label><br />
			<textarea name="<?php echo $this->get_field_name( 'comment_form_args_comment_notes_before' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_comment_notes_before' ); ?>" rows="3" cols="70"><?php echo esc_textarea( $this->get_field_value( 'comment_form_args_comment_notes_before' ) ); ?></textarea><br />
			<span class="description"><?php _e( 'The meta description can be used to determine the text used under the title on search engine results pages.', 'exmachina' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_form_args_comment_notes_after' ); ?>"><?php _e( 'Notes After Comment:', 'exmachina' ); ?></label><br />
			<textarea name="<?php echo $this->get_field_name( 'comment_form_args_comment_notes_after' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_comment_notes_after' ); ?>" rows="3" cols="70"><?php echo esc_textarea( $this->get_field_value( 'comment_form_args_comment_notes_after' ) ); ?></textarea><br />
			<span class="description"><?php _e( 'The meta description can be used to determine the text used under the title on search engine results pages.', 'exmachina' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comment_form_args_label_submit' ); ?>"><?php _e( 'Submit Button Label:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comment_form_args_label_submit' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_label_submit' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_form_args_label_submit' ) ); ?>" size="50" />
		</p>


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