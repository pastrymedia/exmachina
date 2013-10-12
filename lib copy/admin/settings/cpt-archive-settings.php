<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * CPT Archive Settings
 *
 * cpt-archive-settings.php
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
 * Register a new admin page, providing content and corresponding menu item for the CPT Archive Settings page.
 *
 * @package ExMachina\Admin
 */
class ExMachina_Admin_CPT_Archive_Settings extends ExMachina_Admin_Metaboxes {

	/**
	 * Post type object.
	 *
	 * @var \stdClass
	 */
	protected $post_type;

	/**
	 * Create an archive settings admin menu item and settings page for relevant custom post types.
	 *
	 * @since 2.0.0
	 *
	 * @uses EXMACHINA_CPT_ARCHIVE_SETTINGS_FIELD_PREFIX Settings field key prefix.
	 * @uses \ExMachina_Admin::create()                  Create admin menu and settings page.
	 *
	 * @param \stdClass $post_type Post Type object.
	 */
	public function __construct( stdClass $post_type ) {
		$this->post_type = $post_type;

		$page_id = 'exmachina-cpt-archive-' . $this->post_type->name;

		$menu_ops = array(
			'submenu' => array (
				'parent_slug' => 'edit.php?post_type=' . $this->post_type->name,
				'page_title'  => apply_filters( 'exmachina_cpt_archive_settings_page_label', __( 'Archive Settings', 'exmachina' ) ),
				'menu_title'  => apply_filters( 'exmachina_cpt_archive_settings_menu_label', __( 'Archive Settings', 'exmachina' ) ),
				'capability'  => 'edit_theme_options',
			)
		);

		//* Handle non-top-level CPT menu items
		if ( is_string( $this->post_type->show_in_menu ) ) {
			$menu_ops['submenu']['parent_slug'] = $this->post_type->show_in_menu;
			$menu_ops['submenu']['menu_title']  = apply_filters( 'exmachina_cpt_archive_settings_label', $this->post_type->labels->name . ' ' . __( 'Archive', 'exmachina' ) );
			$menu_ops['submenu']['menu_position']  = $this->post_type->menu_position;
		}

		$page_ops = array(); //* use defaults

		$settings_field = EXMACHINA_CPT_ARCHIVE_SETTINGS_FIELD_PREFIX . $this->post_type->name;

		$default_settings = apply_filters(
			'exmachina_cpt_archive_settings_defaults',
			array(
				'headline'    => '',
				'intro_text'  => '',
				'doctitle'    => '',
				'description' => '',
				'keywords'    => '',
				'layout'      => '',
				'body_class'  => '',
				'noindex'     => 0,
				'nofollow'    => 0,
				'noarchive'   => 0,
			)
		);

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );
	}

	/**
	 * Register each of the settings with a sanitization filter type.
	 *
	 * @since 2.0.0
	 *
	 * @uses exmachina_add_option_filter() Assign filter to array of settings.
	 *
	 * @see \ExMachina_Settings_Sanitizer::add_filter()
	 */
	public function sanitizer_filters() {

		exmachina_add_option_filter(
			'no_html',
			$this->settings_field,
			array(
				'headline',
				'doctitle',
				'description',
				'keywords',
				'body_class',
			)
		);
		exmachina_add_option_filter(
			'safe_html',
			$this->settings_field,
			array(
				'intro_text',
			)
		);
		exmachina_add_option_filter(
			'one_zero',
			$this->settings_field,
			array(
				'noindex',
				'nofollow',
				'noarchive',
			)
		);
	}

	/**
 	 * Register meta boxes on the CPT Archive pages.
 	 *
 	 * Some of the meta box additions are dependent on certain theme support or user capabilities.
 	 *
 	 * The 'exmachina_cpt_archives_settings_metaboxes' action hook is called at the end of this function.
 	 *
 	 * @since 2.0.0
 	 *
 	 * @see \ExMachina_Admin_CPT_Archives_Settings::archive_box() Callback for Archive box.
 	 * @see \ExMachina_Admin_CPT_Archives_Settings::seo_box()     Callback for SEO box.
 	 * @see \ExMachina_Admin_CPT_Archives_Settings::layout_box()  Callback for Layout box.
	 */
	public function settings_page_load_metaboxes() {
		add_meta_box( 'exmachina-cpt-archives-settings', __( 'Archive Settings', 'exmachina' ), array( $this, 'archive_box' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-cpt-archives-seo-settings', __( 'SEO Settings', 'exmachina' ), array( $this, 'seo_box' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-cpt-archives-layout-settings', __( 'Layout Settings', 'exmachina' ), array( $this, 'layout_box' ), $this->pagehook, 'normal' );

		do_action( 'exmachina_cpt_archives_settings_metaboxes', $this->pagehook );
	}

	/**
	 * Callback for Archive Settings meta box.
	 *
	 * @since 2.0.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct full field id.
	 * @uses \ExMachina_Admin::get_field_name()  Construct full field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes.
	 */
	public function archive_box() {
		?>
		<p><?php printf( __( 'View the <a href="%s">%s archive</a>.', 'exmachina' ), get_post_type_archive_link( $this->post_type->name ), $this->post_type->name ); ?></p>

		<p><label for="<?php echo $this->get_field_id( 'headline' ); ?>"><b><?php _e( 'Archive Headline', 'exmachina' ); ?></b></label></p>
		<p><input class="large-text" type="text" name="<?php echo $this->get_field_name( 'headline' ); ?>" id="<?php echo $this->get_field_id( 'headline' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'headline' ) ); ?>" /></p>
		<p class="description"><?php _e( 'Leave empty if you do not want to display a headline.', 'exmachina' ); ?></p>

		<p><label for="<?php echo $this->get_field_id( 'intro_text' ); ?>"><b><?php _e( 'Archive Intro Text', 'exmachina' ); ?></b></label></p>
		<p><textarea class="widefat" rows="5" cols="30" name="<?php echo $this->get_field_name( 'intro_text' ); ?>" id="<?php echo $this->get_field_id( 'intro_text' ); ?>"><?php echo esc_textarea( $this->get_field_value( 'intro_text' ) ); ?></textarea></p>
		<p class="description"><?php _e( 'Leave empty if you do not want to display any intro text.', 'exmachina' ); ?></p>
		<?php
	}

	/**
	 * Callback for SEO Settings meta box.
	 *
	 * @since 2.0.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct full field id.
	 * @uses \ExMachina_Admin::get_field_name()  Construct full field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes.
	 */
	public function seo_box() {
		?>
		<p><label for="<?php echo $this->get_field_id( 'doctitle' ); ?>"><b><?php _e( 'Custom Document Title', 'exmachina' ); ?></b></label></p>
		<p><input class="large-text" type="text" name="<?php echo $this->get_field_name( 'doctitle' ); ?>" id="<?php echo $this->get_field_id( 'doctitle' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'doctitle' ) ); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'doctitle' ); ?>"><b><?php _e( 'Meta Description', 'exmachina' ); ?></b></label></p>
		<p><input class="large-text" type="text" name="<?php echo $this->get_field_name( 'description' ); ?>" id="<?php echo $this->get_field_id( 'description' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'description' ) ); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'doctitle' ); ?>"><b><?php _e( 'Meta Keywords', 'exmachina' ); ?></b></label></p>
		<p><input class="large-text" type="text" name="<?php echo $this->get_field_name( 'keywords' ); ?>" id="<?php echo $this->get_field_id( 'keywords' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'keywords' ) ); ?>" /></p>
		<p class="description"><?php _e( 'Comma separated list', 'exmachina' ); ?></p>

		<h4><?php _e( 'Robots Meta Tags:', 'exmachina' ); ?></h4>
		<p>
			<label for="<?php echo $this->get_field_id( 'noindex' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex' ); ?>" id="<?php echo $this->get_field_id( 'noindex' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex' ) ); ?> />
			<?php printf( __( 'Apply %s to this archive', 'exmachina' ), exmachina_code( 'noindex' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label><br />

			<label for="<?php echo $this->get_field_id( 'nofollow' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'nofollow' ); ?>" id="<?php echo $this->get_field_id( 'nofollow' ); ?>" value="1" <?php checked( $this->get_field_value( 'nofollow' ) ); ?> />
			<?php printf( __( 'Apply %s to this archive', 'exmachina' ), exmachina_code( 'nofollow' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label><br />

			<label for="<?php echo $this->get_field_id( 'noarchive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive' ) ); ?> />
			<?php printf( __( 'Apply %s to this archive', 'exmachina' ), exmachina_code( 'noarchive' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label>
		</p>
		<?php
	}

	/**
	 * Callback for Layout Settings meta box.
	 *
	 * @since 2.0.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct full field id.
	 * @uses \ExMachina_Admin::get_field_name()  Construct full field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 * @uses exmachina_layout_selector()         Display layout selector.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes.
	 */
	public function layout_box() {
		$layout = $this->get_field_value( 'layout' );

		?>
		<div class="exmachina-layout-selector">
			<p><input type="radio" class="default-layout" name="<?php echo $this->get_field_name( 'layout' ); ?>" id="default-layout" value="" <?php checked( $layout, '' ); ?> /> <label class="default" for="default-layout"><?php printf( __( 'Default Layout set in <a href="%s">Theme Settings</a>', 'exmachina' ), menu_page_url( 'exmachina', 0 ) ); ?></label></p>

			<p><?php exmachina_layout_selector( array( 'name' => $this->get_field_name( 'layout' ), 'selected' => $layout, 'type' => 'site' ) ); ?></p>
		</div>

		<br class="clear" />

		<p><label for="<?php echo $this->get_field_id( 'body_class' ); ?>"><b><?php _e( 'Custom Body Class', 'exmachina' ); ?></b></label></p>
		<p><input class="large-text" type="text" name="<?php echo $this->get_field_name( 'body_class' ); ?>" id="<?php echo $this->get_field_id( 'body_class' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'body_class' ) ); ?>" /></p>
		<?php
	}

	/**
	 * Add contextual help content for the archive settings page.
	 *
	 * @since 2.0.0
	 *
	 * @todo Populate this contextual help method.
	 */
	public function settings_page_help() {
		$screen = get_current_screen();
		$archive_help =
			'<h3>' . __( 'Archive Settings', 'exmachina' ) . '</h3>' .
			'<p>' . __( 'The Archive Headline sets the title seen on the archive page', 'exmachina' ) . '</p>' .
			'<p>' . __( 'The Archive Intro Text sets the text before the archive entries to introduce the content to the viewer.', 'exmachina' ) . '</p>';

		$screen->add_help_tab(
			array(
				'id'      => $this->pagehook . '-archive',
				'title'   => __( 'Archive Settings', 'exmachina' ),
				'content' => $archive_help,
			)
		);

		$seo_help =
			'<h3>' . __( 'SEO Settings', 'exmachina' ) . '</h3>' .
			'<p>' . __( 'The Custom Document Title sets the page title as seen in browsers and search engines. ', 'exmachina' ) . '</p>' .
			'<p>' . __( 'The Meta description and keywords fill in the meta tags for the archive page. The Meta description is the short text blurb that appear in search engine results.
 ', 'exmachina' ) . '</p>' .
			'<p>' . __( 'Most search engines do not use Keywords at this time or give them very little consideration; however, it\'s worth using in case keywords are given greater consideration in the future and also to help guide your content. If the content doesn’t match with your targeted key words, then you may need to consider your content more carefully.', 'exmachina' ) . '</p>' .
			'<p>' . __( 'The Robots Meta Tags tell search engines how to handle the archive page. Noindex means not to index the page at all, and it will not appear in search results. Nofollow means do not follow any links from this page and noarchive tells them not to make an archive copy of the page.', 'exmachina' ) . '</p>';

		$screen->add_help_tab(
			array(
				'id'      => $this->pagehook . '-seo',
				'title'   => __( 'SEO Settings', 'exmachina' ),
				'content' => $seo_help,
			)
		);

		$layout_help =
			'<h3>' . __( 'Layout Settings', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'This lets you select the layout for the archive page. On most of the child themes you\'ll see these options:', 'exmachina' ) . '</p>' .
			'<ul>' .
				'<li>' . __( 'Content Sidebar', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Sidebar Content', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Sidebar Content Sidebar', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Content Sidebar Sidebar', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Sidebar Sidebar Content', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Full Width Content', 'exmachina' ) . '</li>' .
			'</ul>' .
			'<p>'  . __( 'These options can be extended or limited by the child theme.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'The Custom Body Class adds a class to the body tag in the HTML to allow CSS modification exclusively for this post type\'s archive page.', 'exmachina' ) . '</p>';

		$screen->add_help_tab(
			array(
				'id'      => $this->pagehook . '-layout',
				'title'   => __( 'Layout Settings', 'exmachina' ),
				'content' => $layout_help,
			)
		);
	}
}
