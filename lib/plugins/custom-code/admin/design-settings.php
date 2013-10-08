<?php
/**
 * This file controls all parts of the Design Theme Settings.
 *
 * @author StudioPress
 */

/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Design Settings page.
 *
 * @since 1.5.0
 */
class ExMachina_Admin_Design_Settings extends ExMachina_Admin_Metaboxes {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * @since 1.5.0
	 *
	 * @uses EXMACHINA_DESIGN_SETTINGS_FIELD settings field key
	 *
	 */
	function __construct() {

		$page_id = 'design-settings';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'theme-settings',
				'page_title'  => __( 'Design Settings', 'exmachina' ),
				'menu_title'  => __( 'Design Settings', 'exmachina' ),
			),
		);

		$page_ops = array(
			'screen_icon' => 'themes',
		);

		$settings_field = EXMACHINA_DESIGN_SETTINGS_FIELD;

		$default_settings = apply_filters( 'exmachina_design_settings_defaults', array(

			##################### theme data
			'theme_version' => '1.5.0',
			'db_version'    => '1500',

			##################### globals
			'body_font_color' => '',
			'body_font_family' => "",
			'body_font_size' => '',
			'body_line_height' => '',

			##################### global links
			'body_link_color' => '',
			'body_link_decoration' => '',
			'body_link_hover' => '',
			'body_link_hover_decoration' => '',

			##################### wrap
			'wrap_background_color' => '',
			'wrap_background_color_select' => 'hex',
			'wrap_margin_top' => "10",
			'wrap_margin_bottom' => "10",
			'wrap_padding' => "10",
			'wrap_border' => "5",
			'wrap_border_color' => '#ededed',
			'wrap_border_style' => 'solid',
			'wrap_corner_radius' => "5",
			'wrap_background_shadow' => "none",

			##################### header
			'header_image_height' => '150',
			'header_image_width' => '940',
			'header_title_area_width' => '450',
			'header_widget_area_width' => '480',
			'header_background_color' => '#ffffff',
			'header_background_color_select' => 'hex',

			##################### header title
			'header_top_padding' => "30",
			'header_left_padding' => "20",
			'header_title_font_color' => '#222222',
			'header_title_font_family' => "",
			'header_title_font_size' => '36',
			'header_title_line_height' => '42',

			##################### header tagline
			'header_tagline_top_padding' => "0",
			'header_tagline_left_padding' => "20",
			'header_tagline_font_color' => '#999999',
			'header_tagline_font_family' => "",
			'header_tagline_font_size' => '15',
			'header_tagline_font_style' => 'normal',

			##################### primary nav
			'primary_nav_background_color' => '#f5f5f5',
			'primary_nav_background_color_select' => 'hex',
			'primary_nav_border' => "1",
			'primary_nav_border_color' => '#dddddd',
			'primary_nav_border_style' => 'solid',
			'primary_nav_inner_border' => "1",
			'primary_nav_inner_border_color' => '#ffffff',
			'primary_nav_inner_border_style' => 'solid',
			'primary_nav_font_family' => "",
			'primary_nav_font_size' => '13',
			'primary_nav_text_transform' => 'uppercase',
			'primary_nav_link_color' => '#666666',
			'primary_nav_link_background' => '#f5f5f5',
			'primary_nav_link_background_select' => 'hex',
			'primary_nav_link_decoration' => 'none',
			'primary_nav_link_hover' => '#ffffff',
			'primary_nav_link_hover_background' => '#444444',
			'primary_nav_link_hover_background_select' => 'hex',
			'primary_nav_link_hover_decoration' => 'none',

			##################### secondary nav
			'secondary_nav_background_color' => '#f5f5f5',
			'secondary_nav_background_color_select' => 'hex',
			'secondary_nav_border' => "1",
			'secondary_nav_border_color' => '#dddddd',
			'secondary_nav_border_style' => 'solid',
			'secondary_nav_inner_border' => "1",
			'secondary_nav_inner_border_color' => '#ffffff',
			'secondary_nav_inner_border_style' => 'solid',
			'secondary_nav_font_family' => "",
			'secondary_nav_font_size' => '13',
			'secondary_nav_text_transform' => 'uppercase',
			'secondary_nav_link_color' => '#666666',
			'secondary_nav_link_background' => '#f5f5f5',
			'secondary_nav_link_decoration' => 'none',
			'secondary_nav_link_background_select' => 'hex',
			'secondary_nav_link_hover' => '#ffffff',
			'secondary_nav_link_hover_background' => '#444444',
			'secondary_nav_link_hover_background_select' => 'hex',
			'secondary_nav_link_hover_decoration' => 'none',

			##################### breadcrumb navigation
			'breadcrumb_font_color' => '#222222',
			'breadcrumb_border' => "1",
			'breadcrumb_border_color' => '#aaaaaa',
			'breadcrumb_border_style' => 'dotted',
			'breadcrumb_font_size' => '13',
			'breadcrumb_text_transform' => 'none',

			##################### post info
			'post_info_background_color' => '#f5f5f5',
			'post_info_background_color_select' => 'hex',
			'post_info_font_color' => '#666666',
			'post_info_font_size' => '13',
			'post_info_text_transform' => 'none',

			##################### post meta
			'post_meta_background_color' => '#f5f5f5',
			'post_meta_background_color_select' => 'hex',
			'post_meta_font_color' => '#666666',
			'post_meta_font_size' => '13',
			'post_meta_text_transform' => 'none',

			##################### blockquotes
			'blockquotes_background_color' => '#f5f5f5',
			'blockquotes_background_color_select' => 'hex',
			'blockquotes_font_color' => '#555555',
			'blockquotes_font_family' => "",
			'blockquotes_font_size' => '16',
			'blockquotes_font_style' => 'normal',
			'blockquotes_border' => "1",
			'blockquotes_border_color' => '#dddddd',
			'blockquotes_border_style' => 'solid',

			##################### notice box
			'notice_background_color' => '#f5f8fa',
			'notice_background_color_select' => 'hex',
			'notice_font_color' => '#555555',
			'notice_font_family' => "",
			'notice_font_size' => '16',
			'notice_font_style' => 'normal',
			'notice_border' => "1",
			'notice_border_color' => '#d7e8f0',
			'notice_border_style' => 'solid',

			##################### headlines
			'headline_font_family' => "Arial, Helvetica, sans-serif",
			'h1_font_size' => '30',
			'h2_font_size' => '30',
			'h3_font_size' => '24',
			'h4_font_size' => '20',
			'h5_font_size' => '18',
			'h6_font_size' => '16',
			'h1_font_color' => '#222222',
			'h2_font_color' => '#222222',
			'h3_font_color' => '#222222',
			'h4_font_color' => '#222222',
			'h5_font_color' => '#222222',
			'h6_font_color' => '#222222',
			'headline_font_style' => 'normal',
			'headline_font_weight' => 'bold',
			'headline_text_transform' => 'none',

			##################### headline links
			'h2_link_color' => '#222222',
			'h2_link_decoration' => 'none',
			'h2_link_hover' => '#c61a1a',
			'h2_link_hover_decoration' => 'none',

			##################### sidebar widget headlines
			'sidebar_headline_border' => "1",
			'sidebar_headline_border_color' => '#aaaaaa',
			'sidebar_headline_border_style' => 'dotted',
			'sidebar_headline_font_color' => '#222222',
			'sidebar_headline_font_family' => "Arial, Helvetica, sans-serif",
			'sidebar_headline_font_size' => '16',
			'sidebar_headline_font_style' => 'normal',
			'sidebar_headline_font_weight' => 'bold',
			'sidebar_headline_text_transform' => 'none',

			##################### sidebar
			'sidebar_font_color' => '#222222',
			'sidebar_font_family' => "",
			'sidebar_font_size' => '14',

			##################### footer widget area
			'footer_background_color' => '#f5f5f5',
			'footer_background_color_select' => 'hex',
			'footer_border' => "1",
			'footer_border_color' => '#dddddd',
			'footer_border_style' => 'solid',

			##################### footer widget headlines
			'footer_headline_border' => "1",
			'footer_headline_border_color' => '#aaaaaa',
			'footer_headline_border_style' => 'dotted',
			'footer_headline_font_color' => '#222222',
			'footer_headline_font_family' =>  "Arial, Helvetica, sans-serif",
			'footer_headline_font_size' => '16',
			'footer_headline_font_style' => 'normal',
			'footer_headline_font_weight' => 'bold',
			'footer_headline_text_transform' => 'none',

			##################### footer widget links
			'footer_widget_link_color' => '#222222',
			'footer_widget_link_decoration' => 'none',
			'footer_widget_link_hover' => '#222222',
			'footer_widget_link_hover_decoration' => 'underline',

			##################### footer
			'footer_font_color' => '#222222',
			'footer_font_size' => '14',
			'footer_font_weight' => 'normal',
			'footer_text_transform' => 'none',

			##################### footer links
			'footer_link_color' => '#222222',
			'footer_link_decoration' => 'none',
			'footer_link_hover' => '#222222',
			'footer_link_hover_decoration' => 'underline',

			##################### input box
			'input_background_color' => '#f5f5f5',
			'input_background_color_select' => 'hex',
	  		'input_font_color' => '#666666',
			'input_font_family' => "",
			'input_font_style' => 'normal',
			'input_border' => "1",
			'input_border_color' => '#dddddd',
			'input_border_style' => 'solid',

			##################### buttons
			'button_background_color' => '#444444',
			'button_background_color_select' => 'hex',
			'button_background_hover_color' => '#222222',
			'button_background_hover_color_select' => 'hex',
			'button_font_color' => '#ffffff',
			'button_font_family' => "",
			'button_font_size' => '13',
			'button_text_transform' => 'uppercase',

			##################### install flag (do not edit)
			'installed' => 'true',

			##################### general settings
			'minify_css' => 'true'

		) );

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		/** Add custom styles for this page */
		add_action( 'admin_print_styles', array( $this, 'styles' ) );

	}

	/**
	 * Validate submitted setting values and replace with defaults.
	 *
	 * Checks if the value is empty, is an invalid color hex code or is a value
	 * requiring a numerical answer but submitted value contained anything other
	 * than 0-9.
	 * @param array $newvalue Values submitted from the design settings page.
	 * @param array $oldvalue Unused
	 * @return array
	 * @since 1.5.0
	 */
	function save( $newvalue, $oldvalue ) {

		$defaults = $this->default_settings;

	    foreach ( $newvalue as $key => $value ) {

			/** No empty values allowed */
			if ( '' == $value ) {
				$newvalue[$key] = $defaults[$key];
			}
			/** Colors must be valid */
			elseif ( preg_match( '/_color$/', $key ) && 0 == preg_match( '/^#(([a-fA-F0-9]{3}$)|([a-fA-F0-9]{6}$))/', $value ) ) {
				$newvalue[$key] = $defaults[$key];
			}
			/** Body line height must be numeric */
			elseif ( 'body_line_height' == $key ) {
				$newvalue[$key] = is_numeric( $value ) ? $newvalue[$key] : $defaults[$key];
			}
			/** Certain fields must have digit values */
			elseif ( $this->strpos_array( $key, array( '_size', '_height', '_margin', '_padding', '_radius', '_width' ) ) && ! ctype_digit( $value ) ) {
				$newvalue[$key] = $defaults[$key];
			}
			/** Border sizes must be digits */
			elseif ( preg_match( '/_border$/', $key ) && ! ctype_digit( $value ) ) {
				$newvalue[$key] = $defaults[$key];
			}

	    }

	    return $newvalue;

	}

	/**
	 * Add necessary scripts from parent::scripts() as well as a few custom scripts of our own.
	 *
	 * @since 1.5.0
	 *
	 */
	function settings_page_enqueue_scripts() {

		parent::settings_page_enqueue_scripts();

		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_script( 'exmachina-design-admin', EXMACHINA_JS_URL .'/admin-design.js', array( 'farbtastic' ), PARENT_THEME_VERSION, true );
		wp_localize_script( 'exmachina-design-admin', 'exmachina', array(
			'pageHook'      => $this->pagehook,
			'firstTime'     => ! is_array( get_user_option( 'closedpostboxes_' . $this->pagehook ) ),
			'toggleAll'     => __( 'Toggle All', 'exmachina' ),
			'warnUnsaved'   => __( 'The changes you made will be lost if you navigate away from this page.', 'exmachina' ),
			'warnReset'     => __( 'Are you sure you want to reset?', 'exmachina' )
		) );

	}

	/**
	 * Add necessary custom styles for this page.
	 *
	 * @since 1.5.0
	 *
	 */
	function styles() {

		wp_enqueue_style( 'farbtastic' );

	}

	/**
	 * Add notices to the top of the page when certain actions take place.
	 *
	 * Add default notices via parent::notices() as well as a few custom ones.
	 *
	 * @since 1.5.0
	 *
	 */
	function notices() {

		/** Check to verify we're on the right page */
		if ( ! exmachina_is_menu_page( $this->page_id ) )
			return;

		/** ExMachina_Admin notices */
		parent::notices();

	}

	/**
 	 * Register meta boxes on the Design Settings page.
 	 *
 	 * @since 1.5.0
 	 *
 	 */
	function settings_page_load_metaboxes() {

		/** Hidden form fields */
		add_action( 'exmachina_admin_before_metaboxes', array( $this, 'hidden_fields' ) );

		add_meta_box( 'exmachina-design-settings-global', __( 'Global Styles', 'exmachina' ), array( $this, 'global_styles' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-global-links', __( 'Global Links', 'exmachina' ), array( $this, 'global_links' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-wrap', __( 'Wrap (content area)', 'exmachina' ), array( $this, 'wrap' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-header', __( 'Header', 'exmachina' ), array( $this, 'header' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-header-title', __( 'Header Title', 'exmachina' ), array( $this, 'header_title' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-header-tagline', __( 'Header Tagline', 'exmachina' ), array( $this, 'header_tagline' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-primary-nav', __( 'Primary Navigation', 'exmachina' ), array( $this, 'primary_nav' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-secondary-nav', __( 'Secondary Navigation', 'exmachina' ), array( $this, 'secondary_nav' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-breadcrumb', __( 'Breadcrumb Navigation', 'exmachina' ), array( $this, 'breadcrumb' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-post-info', __( 'Post Info (before post)', 'exmachina' ), array( $this, 'post_info' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-post-meta', __( 'Post Meta (after post)', 'exmachina' ), array( $this, 'post_meta' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-blockquotes', __( 'Blockquotes', 'exmachina' ), array( $this, 'blockquotes' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-notice', __( 'Notice Box', 'exmachina' ), array( $this, 'notice_box' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-headline', __( 'Headlines', 'exmachina' ), array( $this, 'headline' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-headline-links', __( 'Post Title Links', 'exmachina' ), array( $this, 'headline_links' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-sidebar-headline', __( 'Sidebar Widget Headline', 'exmachina' ), array( $this, 'sidebar_headline' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-sidebar-text', __( 'Sidebar Text', 'exmachina' ), array( $this, 'sidebar_text' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-footer-widget', __( 'Footer Widget Area', 'exmachina' ), array( $this, 'footer_widget' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-footer-headline', __( 'Footer Widget Headline', 'exmachina' ), array( $this, 'footer_headline' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-footer-widget-links', __( 'Footer Widget Links', 'exmachina' ), array( $this, 'footer_widget_links' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-footer', __( 'Footer', 'exmachina' ), array( $this, 'footer' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-input', __( 'Input Boxes', 'exmachina' ), array( $this, 'input_box' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-buttons', __( 'Submit Buttons', 'exmachina' ), array( $this, 'buttons' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-design-settings-general', __( 'General Settings', 'exmachina' ), array( $this, 'general' ), $this->pagehook, 'normal' );

	}

	/**
	 * Outputs hidden form fields before the metaboxes.
	 *
	 * @since 1.5.0
	 *
	 * @param string $pagehook
	 * @return null
	 */
	function hidden_fields( $pagehook ) {

		if ( $pagehook != $this->pagehook )
			return;

		printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'theme_version' ), esc_attr( $this->get_field_value( 'theme_version' ) ) );
		printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'db_version' ), esc_attr( $this->get_field_value( 'db_version' ) ) );

	}

	/**
	 * Add settings to the Global Styles box. Does exmachina_design_settings_global action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function global_styles() {
	    exmachina_admin_setting_line( sprintf( __( 'Start by customizing your <a href="%s">background</a>.', 'exmachina' ), admin_url( 'themes.php?page=custom-background' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'body_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'body_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'body_font_size', __( 'Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_text_setting( 'body_line_height', __( 'Line Height', 'exmachina' ), 6 ) );
	    do_action( 'exmachina_design_settings_global' );
	    exmachina_admin_setting_line( exmachina_design_add_note(__( 'All fonts listed are considered web-safe', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_note(__( 'Suggested line height is 1.6. Adjust in increments of 0.1 to increase/decrease space between lines of text.', 'exmachina' ) ) );
	}

	/**
	 * Add settings to the Global Links box. Does exmachina_design_settings_global_links action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function global_links() {
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'body_link_color', __( 'Link Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'body_link_decoration', __( 'Link Decoration', 'exmachina' ), 'decoration' ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'body_link_hover', __( 'Link Hover Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'body_link_hover_decoration', __( 'Link Hover Decoration', 'exmachina' ), 'decoration' ) );
	    do_action( 'exmachina_design_settings_global_links' );
	}

	/**
	 * Add settings to the Wrap box. Does exmachina_design_settings_wrap action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function wrap() {
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'wrap_background_color', __( 'Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'wrap_margin_top', __( 'Top Margin', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'wrap_margin_bottom', __( 'Bottom Margin', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'wrap_padding', __( 'Padding', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'wrap_border', __( 'Border', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'wrap_corner_radius', __( 'Rounded Corner Radius', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_text_setting( 'wrap_background_shadow', __( 'Background Shadow', 'exmachina' ) ) );
	    do_action( 'exmachina_design_settings_wrap' );
	    exmachina_admin_setting_line( exmachina_design_add_note( __( 'Sample for background shadow:', 'exmachina' ) . ' <code>0 1px 3px #333333</code>' ) );
	}

	/**
	 * Add settings to the Header box. Does exmachina_design_settings_header action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function header() {
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'header_image_height', __( 'Header Height', 'exmachina' ), 2) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'header_image_width', __( 'Header Width', 'exmachina' ), 2) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'header_title_area_width', __( 'Header Title Area Width', 'exmachina' ), 2) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'header_widget_area_width', __( 'Header Widget Area Width', 'exmachina' ), 2) );
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'header_background_color', __( 'Background', 'exmachina' ) ) );
	    do_action( 'exmachina_design_settings_header' );
	    exmachina_admin_setting_line( exmachina_design_add_note( sprintf ( __( 'Save your settings before customizing your <a href="%s">header</a>.', 'exmachina' ), admin_url( 'themes.php?page=custom-header' ) ) ) );
	}

	/**
	 * Add settings to the Header Title box. Does exmachina_design_settings_header_title action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function header_title() {
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'header_top_padding', __( 'Top Padding', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'header_left_padding', __( 'Left Padding', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'header_title_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'header_title_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'header_title_font_size', __( 'Font Size', 'exmachina' ) ) );
	    do_action( 'exmachina_design_settings_header_title' );
	}

	/**
	 * Add settings to the Header Tagline box. Does exmachina_design_settings_tagline action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function header_tagline() {
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'header_tagline_top_padding', __( 'Top Padding', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'header_tagline_left_padding', __( 'Left Padding', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'header_tagline_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'header_tagline_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'header_tagline_font_size', __( 'Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'header_tagline_font_style', __( 'Font', 'exmachina' ), 'style' ) );
	    do_action( 'exmachina_design_settings_tagline' );
	}

	/**
	 * Add settings to the Primary Navigation box. Does exmachina_design_settings_primary_nav action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function primary_nav() {
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'primary_nav_background_color', __( 'Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'primary_nav_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'primary_nav_font_size', __( 'Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'primary_nav_text_transform', __( 'Text Transform', 'exmachina' ), 'transform' ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'primary_nav_border', __( 'Border', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'primary_nav_inner_border', __( 'Inner Border', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'primary_nav_link_color', __( 'Link Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'primary_nav_link_background', __( 'Link Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'primary_nav_link_decoration', __( 'Link Decoration', 'exmachina' ), 'decoration' ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'primary_nav_link_hover', __( 'Current/Link Hover', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'primary_nav_link_hover_background', __( 'Current/Link Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'primary_nav_link_hover_decoration', __( 'Link Hover Decoration', 'exmachina' ), 'decoration' ) );
	    do_action( 'exmachina_design_settings_primary_nav' );
	}

	/**
	 * Add settings to the Secondary Navigation box. Does exmachina_design_settings_secondary_nav action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function secondary_nav() {
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'secondary_nav_background_color', __( 'Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'secondary_nav_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'secondary_nav_font_size', __( 'Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'secondary_nav_text_transform', __( 'Text Transform', 'exmachina' ), 'transform' ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'secondary_nav_border', __( 'Border', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'secondary_nav_inner_border', __( 'Inner Border', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'secondary_nav_link_color', __( 'Link Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'secondary_nav_link_background', __( 'Link Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'secondary_nav_link_decoration', __( 'Link Decoration', 'exmachina' ), 'decoration' ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'secondary_nav_link_hover', __( 'Current/Link Hover', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'secondary_nav_link_hover_background', __( 'Current/Link Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'secondary_nav_link_hover_decoration', __( 'Link Hover Decoration', 'exmachina' ), 'decoration' ) );
	    do_action( 'exmachina_design_settings_secondary_nav' );
	}

	/**
	 * Add settings to the Breadcrumb Navigation box. Does exmachina_design_settings_breadcrumb action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function breadcrumb() {
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'breadcrumb_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'breadcrumb_font_size', __( 'Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'breadcrumb_text_transform', __( 'Text Transform', 'exmachina' ), 'transform' ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'breadcrumb_border', __( 'Bottom Border', 'exmachina' ) ) );
	    do_action( 'exmachina_design_settings_breadcrumb' );
	}

	/**
	 * Add settings to the Post Info box. Does exmachina_design_settings_post_info action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function post_info() {
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'post_info_background_color', __( 'Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'post_info_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'post_info_font_size', __( 'Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'post_info_text_transform', __( 'Text Transform', 'exmachina' ), 'transform' ) );
	    do_action( 'exmachina_design_settings_post_info' );
	}

	/**
	 * Add settings to the Post Meta box. Does exmachina_design_settings_post_meta action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function post_meta() {
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'post_meta_background_color', __( 'Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'post_meta_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'post_meta_font_size', __( 'Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'post_meta_text_transform', __( 'Text Transform', 'exmachina' ), 'transform' ) );
	    do_action( 'exmachina_design_settings_post_meta' );
	}

	/**
	 * Add settings to the Blockquotes box. Does exmachina_design_settings_blockquotes action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function blockquotes() {
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'blockquotes_background_color', __( 'Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'blockquotes_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'blockquotes_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'blockquotes_font_size', __( 'Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'blockquotes_font_style', __( 'Font Style', 'exmachina' ), 'style' ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'blockquotes_border', __( 'Border', 'exmachina' ) ) );
	    do_action( 'exmachina_design_settings_blockquotes' );
	}

	/**
	 * Add settings to the Notice box. Does exmachina_design_settings_notices_box action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function notice_box() {
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'notice_background_color', __( 'Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'notice_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'notice_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'notice_font_size', __( 'Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'notice_font_style', __( 'Font Style', 'exmachina' ), 'style' ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'notice_border', __( 'Border', 'exmachina' ) ) );
	    do_action( 'exmachina_design_settings_notice_box' );
	}

	/**
	 * Add settings to the Headlines box. Does exmachina_design_settings_headline action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function headline() {
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'headline_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'headline_font_style', __( 'Font Style', 'exmachina' ), 'style' ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'headline_font_weight', __( 'Font Weight', 'exmachina' ), 'weight' ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'headline_text_transform', __( 'Text Transform', 'exmachina' ), 'transform' ) );
	    exmachina_admin_setting_line( array(exmachina_design_add_size_setting( 'h1_font_size', __( 'H1 Font Size', 'exmachina' ) ), exmachina_design_add_color_setting( 'h1_font_color', __( 'Color', 'exmachina' ) ) ) );
	    exmachina_admin_setting_line( array(exmachina_design_add_size_setting( 'h2_font_size', __( 'H2 Font Size', 'exmachina' ) ), exmachina_design_add_color_setting( 'h2_font_color', __( 'Color', 'exmachina' ) ) ) );
	    exmachina_admin_setting_line( array(exmachina_design_add_size_setting( 'h3_font_size', __( 'H3 Font Size', 'exmachina' ) ), exmachina_design_add_color_setting( 'h3_font_color', __( 'Color', 'exmachina' ) ) ) );
	    exmachina_admin_setting_line( array(exmachina_design_add_size_setting( 'h4_font_size', __( 'H4 Font Size', 'exmachina' ) ), exmachina_design_add_color_setting( 'h4_font_color', __( 'Color', 'exmachina' ) ) ) );
	    exmachina_admin_setting_line( array(exmachina_design_add_size_setting( 'h5_font_size', __( 'H5 Font Size', 'exmachina' ) ), exmachina_design_add_color_setting( 'h5_font_color', __( 'Color', 'exmachina' ) ) ) );
	    exmachina_admin_setting_line( array(exmachina_design_add_size_setting( 'h6_font_size', __( 'H6 Font Size', 'exmachina' ) ), exmachina_design_add_color_setting( 'h6_font_color', __( 'Color', 'exmachina' ) ) ) );
	    do_action( 'exmachina_design_settings_headline' );
	}

	/**
	 * Add settings to the Headline Links box. Does exmachina_design_settings_headline_links action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function headline_links() {
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'h2_link_color', __( 'H2 Link Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'h2_link_decoration', __( 'H2 Link Decoration', 'exmachina' ), 'decoration' ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'h2_link_hover', __( 'H2 Link Hover', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'h2_link_hover_decoration', __( 'H2 Link Hover Decoration', 'exmachina' ), 'decoration' ) );
	    do_action( 'exmachina_design_settings_headline_links' );
	}

	/**
	 * Add settings to the Sidebar Tex box. Does exmachina_design_sidebar_text action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function sidebar_text() {
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'sidebar_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'sidebar_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'sidebar_font_size', __( 'Font Size', 'exmachina' ) ) );
	    do_action( 'exmachina_design_sidebar_text' );
	}

	/**
	 * Add settings to the Sidebar Widget Headline box. Does exmachina_design_settings_sidebar_headline action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function sidebar_headline() {
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'sidebar_headline_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'sidebar_headline_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'sidebar_headline_font_size', __( 'H4 Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'sidebar_headline_font_style', __( 'Font Style', 'exmachina' ), 'style' ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'sidebar_headline_font_weight', __( 'Font Weight', 'exmachina' ), 'weight' ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'sidebar_headline_text_transform', __( 'Text Transform', 'exmachina' ), 'transform' ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'sidebar_headline_border', __( 'Bottom Border', 'exmachina' ) ) );
	    do_action( 'exmachina_design_settings_sidebar_headline' );
	}

	/**
	 * Add settings to the Footer Widget Area box. Does exmachina_design_settings_footer_widget action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function footer_widget() {
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'footer_background_color', __( 'Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'footer_border', __( 'Border', 'exmachina' ) ) );
	    do_action( 'exmachina_design_settings_footer_widget' );
	}

	/**
	 * Add settings to the Footer Widget Headline box. Does exmachina_design_settings_footer_headline action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function footer_headline() {
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'footer_headline_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'footer_headline_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'footer_headline_font_size', __( 'H4 Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'footer_headline_font_style', __( 'Font Style', 'exmachina' ), 'style' ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'footer_headline_font_weight', __( 'Font Weight', 'exmachina' ), 'weight' ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'footer_headline_text_transform', __( 'Text Transform', 'exmachina' ), 'transform' ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'footer_headline_border', __( 'Bottom Border', 'exmachina' ) ) );
	    do_action( 'exmachina_design_settings_footer_headline' );
	}

	/**
	 * Add settings to the Footer Widget Links box. Does exmachina_design_settings_footer_widget_links action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function footer_widget_links() {
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'footer_widget_link_color', __( 'Link Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'footer_widget_link_decoration', __( 'Link Decoration', 'exmachina' ), 'decoration' ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'footer_widget_link_hover', __( 'Link Hover Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'footer_widget_link_hover_decoration', __( 'Link Hover Decoration', 'exmachina' ), 'decoration' ) );
	    do_action( 'exmachina_design_settings_footer_widget_links' );
	}

	/**
	 * Add settings to the Footer box. Does exmachina_design_settings_footer action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function footer() {
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'footer_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'footer_font_size', __( 'Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'footer_font_weight', __( 'Font Weight', 'exmachina' ), 'weight' ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'footer_text_transform', __( 'Text Transform', 'exmachina' ), 'transform' ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'footer_link_color', __( 'Link Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'footer_link_decoration', __( 'Link Decoration', 'exmachina' ), 'decoration' ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'footer_link_hover', __( 'Link Hover Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'footer_link_hover_decoration', __( 'Link Hover Decoration', 'exmachina' ), 'decoration' ) );
		do_action( 'exmachina_design_settings_footer' );
	}

	/**
	 * Add settings to the Input box. Does exmachina_design_settings_input_box action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function input_box() {
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'input_background_color', __( 'Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'input_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'input_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'input_font_style', __( 'Font Style', 'exmachina' ), 'style' ) );
	    exmachina_admin_setting_line( exmachina_design_add_border_setting( 'input_border', __( 'Border', 'exmachina' ) ) );
	    do_action( 'exmachina_design_settings_input_box' );
	}

	/**
	 * Add settings to the Submit Buttons box. Does exmachina_design_settings_buttons action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function buttons() {
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'button_background_color', __( 'Background', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_background_color_setting( 'button_background_hover_color', __( 'Background Hover', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_color_setting( 'button_font_color', __( 'Font Color', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'button_font_family', __( 'Font', 'exmachina' ), 'family' ) );
	    exmachina_admin_setting_line( exmachina_design_add_size_setting( 'button_font_size', __( 'Font Size', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_select_setting( 'button_text_transform', __( 'Text Transform', 'exmachina' ), 'transform' ) );
	    do_action( 'exmachina_design_settings_buttons' );
	}

	/**
	 * Add settings to the General Settings box. Does exmachina_design_settings_general action hook.
	 *
	 * @author StudioPress
	 * @since 1.5.0
	 */
	function general() {
	    global $theme, $blog_id;
	    exmachina_admin_setting_line( exmachina_design_add_checkbox_setting( 'minify_css', __( 'Minify CSS?', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_note(__( 'Check this box for a live site, uncheck for testing.', 'exmachina' ) ) );
	    exmachina_admin_setting_line( exmachina_design_add_note( sprintf( __( 'Use the Editor to <a href="%s">add/edit custom CSS and functions</a>.', 'exmachina' ), menu_page_url( 'exmachina-design-custom', false ) ) ) );
	    #echo '<hr class="div" />';
	    #exmachina_admin_setting_line( '<a class="button" href="' . wp_nonce_url( admin_url( 'admin.php?page=design-settings&amp;design=export' ), 'exmachina-design-export' ) . '">'.__( 'Export Design Settings', 'exmachina' ) . '</a>' );
	    #exmachina_admin_setting_line( '</form><form method="post" enctype="multipart/form-data" action="">' . wp_nonce_field( 'exmachina-design-import', '_wpnonce-exmachina-design-import' ) . exmachina_add_admin_label( 'import-file', __( 'Import Design Settings File', 'exmachina' ) ) . '<br /><input type="hidden" name="design-settings" value="import" /><input type="file" class="text_input" name="file" id="import-file" /><input class="button" type="submit" value="' . esc_attr__( 'Upload', 'exmachina' ) . '" /></form>' );
	    do_action( 'exmachina_design_settings_general' );
	}

	/**
	 * Helper function for strpos() to accept an array of needles.
	 *
	 */
	function strpos_array( $haystack = '', $needles = array() ) {

		$pos = false;

		foreach ( (array) $needles as $needle ) {
			if ( $pos = strpos( $haystack, $needle ) ) {
				return $pos;
			}
		}

	}

}

add_action( 'exmachina_admin_menu', 'exmachina_design_design_settings_menu' );
/**
 * Instantiate the class to create the menu.
 *
 * @author StudioPress
 * @since 1.5.0
 */
function exmachina_design_design_settings_menu() {

	global $_exmachina_design_admin_design_settings;

	/** Don't add submenu items if admin menu is disabled */
	if( ! current_theme_supports( 'exmachina-design-settings' ) )
		return;

	$_exmachina_design_admin_design_settings = new ExMachina_Admin_Design_Settings;

}