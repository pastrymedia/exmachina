<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Custom Post Type Archive Settings
 *
 * archive-settings.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Handles the display and functionality of the archive settings page. This provides
 * the needed hooks and meta box calls to create any number of archive settings needed.
 * This file is only loaded if the theme supports the 'exmachina-core-archive-settings'
 * feature.
 *
 * @package     ExMachina
 * @subpackage  Admin Settings
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/**
 * Archive Settings Admin Subclass
 *
 * Registers a new admin page, providing content and corresponding menu item for
 * the Archive Settings page.
 *
 * @since 1.0.0
 */
class ExMachina_Admin_Archive_Settings extends ExMachina_Admin_Metaboxes {

  /**
   * Post type object.
   *
   * @var \stdClass
   */
  protected $post_type;

  /**
   * Archive Settings Class Constructor
   *
   * Creates an admin menu item and settings page. This constructor method defines
   * the page id, page title, menu position, default settings, and sanitization
   * hooks.
   *
   * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
   * @link http://codex.wordpress.org/Function_Reference/get_template
   * @link http://codex.wordpress.org/Function_Reference/get_theme_root
   * @link http://codex.wordpress.org/Function_Reference/get_template_directory
   *
   * @uses exmachina_get_prefix()
   * @uses \ExMachina_Admin::create()
   * @uses \ExMachina_Admin_Archive_Settings::sanitizer_filters()
   *
   * @todo prefix settings filters.
   * @todo add filters to page/menu titles
   * @todo maybe remove page_ops for defaults
   *
   * @since 1.0.0
   *
   * @param \stdClass $post_type Post Type object.
   */
  public function __construct( stdClass $post_type ) {

    /* Get the theme prefix. */
    $prefix = exmachina_get_prefix();

    /* Get the post type. */
    $this->post_type = $post_type;

    /* Specify the unique page id. */
    $page_id = 'exmachina-cpt-archive-' . $this->post_type->name;

    /* Define page titles and menu position. Can be filtered using 'exmachina_archive_settings_menu_ops'. */
    $menu_ops = apply_filters(
      'exmachina_archive_settings_menu_ops',
      array(
        'submenu' => array(
          'parent_slug' => 'edit.php?post_type=' . $this->post_type->name,
          'page_title'  => apply_filters( 'exmachina_cpt_archive_settings_page_label', __( 'Archive Settings', 'exmachina-core' ) ),
          'menu_title'  => apply_filters( 'exmachina_cpt_archive_settings_menu_label', __( 'Archive Settings', 'exmachina-core' ) ),
          'capability'  => 'edit_theme_options',
        ),
      )
    ); // end $menu_ops

    //* Handle non-top-level CPT menu items
    if ( is_string( $this->post_type->show_in_menu ) ) {
      $menu_ops['submenu']['parent_slug'] = $this->post_type->show_in_menu;
      $menu_ops['submenu']['menu_title']  = apply_filters( 'exmachina_cpt_archive_settings_label', $this->post_type->labels->name . ' ' . __( 'Archive', 'exmachina-core' ) );
      $menu_ops['submenu']['menu_position']  = $this->post_type->menu_position;
    } // end IF statement

    /* Define page options (notice text and screen icon). */
    $page_ops = array(); // end $page_ops

    /* Set the unique settings field id. */
    $settings_field = EXMACHINA_CPT_ARCHIVE_SETTINGS_FIELD_PREFIX . $this->post_type->name;

    /* Define the default setting values. Can be filtered using 'exmachina_archive_settings_defaults'. */
    $default_settings = apply_filters(
      'exmachina_archive_settings_defaults',
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
    ); // end $default_settings

    /* Create the admin page. */
    $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

    /* Initialize the sanitization filter. */
    add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );

  } // end function __construct()

  /**
   * Archive Settings Sanitizer Filters
   *
   * Register each of the settings with a sanitization filter type. This method
   * takes each defined setting and runs it through the appropiate type in the
   * sanitization class.
   *
   * @uses exmachina_add_option_filter() Assign a sanitization filter.
   *
   * @since 1.0.0
   */
  public function sanitizer_filters() {

    /* Apply the truthy/falsy sanitization filter. */
    exmachina_add_option_filter( 'one_zero', $this->settings_field,
      array(
        'noindex',
        'nofollow',
        'noarchive',
    ) );

    /* Apply the positive integer sanitization filter. */
    exmachina_add_option_filter( 'absint', $this->settings_field,
      array(

    ) );

    /* Apply the URL sanitization filter. */
    exmachina_add_option_filter( 'url', $this->settings_field,
      array(

    ) );

    /* Apply the no HTML sanitization filter. */
    exmachina_add_option_filter( 'no_html', $this->settings_field,
      array(
        'headline',
        'doctitle',
        'description',
        'keywords',
        'body_class',
    ) );

    /* Apply the safe HTML sanitization filter. */
    exmachina_add_option_filter( 'safe_html', $this->settings_field,
      array(
        'intro_text',
    ) );

    /* Apply the unfiltered HTML sanitiation filter. */
    exmachina_add_option_filter( 'requires_unfiltered_html', $this->settings_field,
      array(

    ) );

  } // end function sanitizer_filters()

  /**
   * Archive Settings Help Tabs
   *
   * Setup contextual help tabs content. This method adds the appropiate help
   * tabs based on the metaboxes/settings the theme supports.
   *
   * @link  http://codex.wordpress.org/Class_Reference/WP_Screen
   * @link  http://codex.wordpress.org/Function_Reference/get_current_screen
   * @link  http://codex.wordpress.org/Class_Reference/WP_Screen/add_help_tab
   * @link  http://codex.wordpress.org/Class_Reference/WP_Screen/set_help_sidebar
   *
   * @uses exmachina_get_help_sidebar() Gets the help sidebar content.
   *
   * @since 1.0.0
   */
  public function settings_page_help() {

    /* Get the current screen. */
    $screen = get_current_screen();

    /* Get the sidebar content. */
    $template_help = exmachina_get_help_sidebar();

    /* Add the 'Archive Settings' help content. */
    $archive_help =
      '<h3>' . __( 'Archive Settings', 'exmachina-core' ) . '</h3>' .
      '<p>' . __( 'The Archive Headline sets the title seen on the archive page', 'exmachina-core' ) . '</p>' .
      '<p>' . __( 'The Archive Intro Text sets the text before the archive entries to introduce the content to the viewer.', 'exmachina-core' ) . '</p>';

    /* Adds the 'Archive Settings' help tab. */
    $screen->add_help_tab(
      array(
        'id'      => $this->pagehook . '-archive',
        'title'   => __( 'Archive Settings', 'exmachina-core' ),
        'content' => $archive_help,
      )
    );

    /* Add the 'SEO Settings' help content. */
    $seo_help =
      '<h3>' . __( 'SEO Settings', 'exmachina-core' ) . '</h3>' .
      '<p>' . __( 'The Custom Document Title sets the page title as seen in browsers and search engines. ', 'exmachina-core' ) . '</p>' .
      '<p>' . __( 'The Meta description and keywords fill in the meta tags for the archive page. The Meta description is the short text blurb that appear in search engine results.', 'exmachina-core' ) . '</p>' .
      '<p>' . __( 'Most search engines do not use Keywords at this time or give them very little consideration; however, it\'s worth using in case keywords are given greater consideration in the future and also to help guide your content. If the content doesn’t match with your targeted key words, then you may need to consider your content more carefully.', 'exmachina-core' ) . '</p>' .
      '<p>' . __( 'The Robots Meta Tags tell search engines how to handle the archive page. Noindex means not to index the page at all, and it will not appear in search results. Nofollow means do not follow any links from this page and noarchive tells them not to make an archive copy of the page.', 'exmachina-core' ) . '</p>';

    /* Adds the 'SEO Settings' help tab. */
    $screen->add_help_tab(
      array(
        'id'      => $this->pagehook . '-seo',
        'title'   => __( 'SEO Settings', 'exmachina-core' ),
        'content' => $seo_help,
      )
    );

    /* Add the 'Layout Settings' help content. */
    $layout_help =
      '<h3>' . __( 'Layout Settings', 'exmachina-core' ) . '</h3>' .
      '<p>'  . __( 'This lets you select the layout for the archive page. On most of the child themes you\'ll see these options:', 'exmachina-core' ) . '</p>' .
      '<ul>' .
        '<li>' . __( 'Content Sidebar', 'exmachina-core' ) . '</li>' .
        '<li>' . __( 'Sidebar Content', 'exmachina-core' ) . '</li>' .
        '<li>' . __( 'Sidebar Content Sidebar', 'exmachina-core' ) . '</li>' .
        '<li>' . __( 'Content Sidebar Sidebar', 'exmachina-core' ) . '</li>' .
        '<li>' . __( 'Sidebar Sidebar Content', 'exmachina-core' ) . '</li>' .
        '<li>' . __( 'Full Width Content', 'exmachina-core' ) . '</li>' .
      '</ul>' .
      '<p>'  . __( 'These options can be extended or limited by the child theme.', 'exmachina-core' ) . '</p>' .
      '<p>'  . __( 'The Custom Body Class adds a class to the body tag in the HTML to allow CSS modification exclusively for this post type\'s archive page.', 'exmachina-core' ) . '</p>';

    /* Adds the 'Layout Settings' help tab. */
    $screen->add_help_tab(
      array(
        'id'      => $this->pagehook . '-layout',
        'title'   => __( 'Layout Settings', 'exmachina-core' ),
        'content' => $layout_help,
      )
    );

    /* Adds help sidebar content. */
    $screen->set_help_sidebar(
      $template_help
    );

    /* Trigger the help content action hook. */
    do_action( 'exmachina_archive_settings_help', $this->pagehook );

  } // end function settings_page_help()

  /**
   * Archive Settings Load Metaboxes
   *
   * Registers metaboxes for the settings page. Metaboxes are only registered if
   * supported by the theme and the user capabilitiy allows it.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_meta_box
   * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
   * @link http://codex.wordpress.org/Function_Reference/get_theme_support
   *
   * @uses exmachina_get_prefix() Gets the theme prefix.
   * @uses \ExMachina_Admin_Archive_Settings::exmachina_metabox_theme_display_save()
   *
   * @todo prefix/add action hooks.
   *
   * @since 1.0.0
   */
  public function settings_page_load_metaboxes() {

    /* Get theme information. */
    $prefix = exmachina_get_prefix();
    $theme = wp_get_theme( get_template() );

    /* Register the 'Save Settings' metabox to the 'side' priority. */
    add_meta_box( 'exmachina-core-archive-settings-save', __( '<i class="uk-icon-save"></i> Save Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_archive_display_save' ), $this->pagehook, 'side', 'high' );

    /* Register the 'Archive Settings' metabox to the 'side' priority. */
    add_meta_box( 'exmachina-cpt-archives-settings', __( '<i class="uk-icon-archive"></i> Archive Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_archive_display_archive_box' ), $this->pagehook, 'normal' );

    /* Register the 'SEO Settings' metabox to the 'side' priority. */
    add_meta_box( 'exmachina-cpt-archives-seo-settings', __( '<i class="uk-icon-cog"></i> SEO Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_archive_display_seo_box' ), $this->pagehook, 'normal' );

    /* Register the 'Layout Settings' metabox to the 'side' priority. */
    add_meta_box( 'exmachina-cpt-archives-layout-settings', __( '<i class="uk-icon-cog"></i> Layout Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_archive_display_layout_box' ), $this->pagehook, 'normal' );

    /* Trigger the archive settings metabox action hook. */
    do_action( 'exmachina_archives_settings_metaboxes', $this->pagehook );

  } // end function settings_page_load_metaboxes()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Save Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Save Settings Metabox Display
   *
   * Callback to display the 'Save Settings' metabox.
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_meta_box_archive_display_save() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <?php submit_button( $this->page_ops['save_button_text'], 'primary button-hero update-button uk-button-expand', 'submit', false, array( 'id' => '' ) ); ?>
                      <?php submit_button( $this->page_ops['reset_button_text'], 'secondary reset-button uk-button-expand uk-text-bold exmachina-js-confirm-reset', $this->get_field_name( 'reset' ), false, array( 'id' => '' ) ); ?>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_meta_box_archive_display_save()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Archive Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Archive Settings Metabox Display
   *
   * Callback to display the 'Archive Settings' metabox. Creates a metabox for
   * the theme settings page, which holds a textarea for custom post type archive
   * message.
   *
   * Settings:
   * ~~~~~~~~~
   * 'headline'
   * 'intro_text'
   *
   * To use this feature, the theme must support the 'footer' argument
   * for the 'exmachina-core-theme-settings' feature.
   *
   * @todo Add header info content
   * @todo Add default footer insert content function
   *
   * @link http://codex.wordpress.org/Function_Reference/wp_editor
   * @link http://codex.wordpress.org/Function_Reference/esc_textarea
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_meta_box_archive_display_archive_box() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1 uk-form-stacked">

                  <legend><?php printf( __( 'View the <a href="%s">%s archive</a>.', 'exmachina-core' ), get_post_type_archive_link( $this->post_type->name ), $this->post_type->name ); ?></legend>

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="<?php echo $this->get_field_id( 'headline' ); ?>"><?php _e( 'Archive Headline', 'exmachina-core' ); ?></label>
                    <div class="uk-form-controls">
                      <input class="large-text uk-form-width-large" type="text" name="<?php echo $this->get_field_name( 'headline' ); ?>" id="<?php echo $this->get_field_id( 'headline' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'headline' ) ); ?>" />
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->
                  <p class="uk-text-muted"><?php _e( 'Leave empty if you do not want to display a headline.', 'exmachina-core' ); ?></p>

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="<?php echo $this->get_field_id( 'intro_text' ); ?>"><?php _e( 'Archive Intro Text', 'exmachina-core' ); ?></label>
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <textarea class="input-block-level vertical-resize widefat" name="<?php echo $this->get_field_name( 'intro_text' ); ?>" id="<?php echo $this->get_field_id( 'intro_text' ); ?>" cols="30" rows="5"><?php echo esc_textarea( $this->get_field_value( 'intro_text' ) ); ?></textarea>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><?php _e( 'Leave empty if you do not want to display any intro text.', 'exmachina-core' ); ?></p>

                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_meta_box_archive_display_archive_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'SEO Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * SEO Settings Metabox Display
   *
   * Callback to display the 'SEO Settings' metabox. Creates a metabox
   * for the theme settings page, which allows customization of the archive
   * SEO settings.
   *
   * Fields:
   * ~~~~~~~
   * 'doctitle'
   * 'doctitle'
   * 'keywords'
   * 'noindex'
   * 'nofollow'
   * 'noarchive'
   *
   * To use this feature, the theme must support the 'edits' argument for
   * the 'exmachina-core-theme-settings' feature.
   *
   * @todo docblock comment
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_meta_box_archive_display_seo_box() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'doctitle' ); ?>" class="uk-text-bold"><?php _e( 'Custom Document Title:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" class="large-text" name="<?php echo $this->get_field_name( 'doctitle' ); ?>" id="<?php echo $this->get_field_id( 'doctitle' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'doctitle' ) ); ?>" size="50" />
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'description' ); ?>" class="uk-text-bold"><?php _e( 'Meta Description:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" class="large-text" name="<?php echo $this->get_field_name( 'description' ); ?>" id="<?php echo $this->get_field_id( 'description' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'description' ) ); ?>" size="50" />
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'keywords' ); ?>" class="uk-text-bold"><?php _e( 'Meta Keywords:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" class="large-text" name="<?php echo $this->get_field_name( 'keywords' ); ?>" id="<?php echo $this->get_field_id( 'keywords' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'keywords' ) ); ?>" size="50" />
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="description"><?php _e( 'Comma separated list', 'exmachina-core' ); ?></p>
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label class="uk-text-bold"><?php _e( 'Robots Meta Tags', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <ul class="checkbox-list vertical">

                        <li><label for="<?php echo $this->get_field_id( 'noindex' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex' ); ?>" id="<?php echo $this->get_field_id( 'noindex' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex' ) ); ?> />
                        <?php printf( __( 'Apply %s to this archive', 'exmachina-core' ), exmachina_code( 'noindex' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label></li>

                        <li><label for="<?php echo $this->get_field_id( 'nofollow' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'nofollow' ); ?>" id="<?php echo $this->get_field_id( 'nofollow' ); ?>" value="1" <?php checked( $this->get_field_value( 'nofollow' ) ); ?> />
                        <?php printf( __( 'Apply %s to this archive', 'exmachina-core' ), exmachina_code( 'nofollow' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label></li>

                        <li><label for="<?php echo $this->get_field_id( 'noarchive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive' ) ); ?> />
                        <?php printf( __( 'Apply %s to this archive', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?> <a href="http://yoast.com/articles/robots-meta-tags/" target="_blank">[?]</a></label></li>

                      </ul>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>


        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_meta_box_archive_display_seo_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Layout Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Layout Settings Metabox Display
   *
   * Callback to display the 'Layout Settings' metabox. Creates a metabox
   * for the theme settings page, which allows customization of the default
   * layout.
   *
   * Fields:
   * ~~~~~~~
   * 'layout'
   * 'body_class'
   *
   * To use this feature, the theme must support the 'layout' argument for
   * the 'exmachina-core-theme-settings' feature.
   *
   * @todo docblock comment
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_meta_box_archive_display_layout_box() {

    $layout = $this->get_field_value( 'layout' );

    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="radio-selector" colspan="2">
              <div class="fieldset-wrap uk-margin uk-grid">
                <fieldset class="uk-form uk-width-1-1">
                  <div class="exmachina-layout-selector radio-container uk-grid uk-grid-preserve">
                    <p><input type="radio" class="default-layout" name="<?php echo $this->get_field_name( 'layout' ); ?>" id="default-layout" value="" <?php checked( $layout, '' ); ?> /> <label class="default" for="default-layout"><?php printf( __( 'Default Layout set in <a href="%s">Theme Settings</a>', 'exmachina-core' ), menu_page_url( 'exmachina-core', 0 ) ); ?></label></p>
                    <p><?php exmachina_layout_selector( array( 'name' => $this->get_field_name( 'layout' ), 'selected' => $layout, 'type' => 'site' ) ); ?></p>
                  </div><!-- .radio-container -->
                </fieldset>
              </div><!-- .fieldset-wrap -->
            </td><!-- .radio-selector -->
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'body_class' ); ?>" class="uk-text-bold"><?php _e( 'Custom Body Class:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" class="large-text" name="<?php echo $this->get_field_name( 'body_class' ); ?>" id="<?php echo $this->get_field_id( 'body_class' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'body_class' ) ); ?>" size="50" />
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_meta_box_archive_display_layout_box()

} // end class ExMachina_Admin_Archive_Settings

add_action( 'exmachina_admin_menu', 'exmachina_add_archive_settings_page' );
/**
 * Add Archive Settings Page
 *
 * Initializes a new instance of the ExMachina_Admin_Archive_Settings and adds
 * the Archive Settings Page.
 *
 * @since 1.0.0
 */
function exmachina_add_archive_settings_page() {

  /* Globalize the $_exmachina_admin_archive_settings variable. */
  global $_exmachina_admin_archive_settings;

  /* Create a new instance of the ExMachina_Admin_Archive_Settings class. */
  $_exmachina_admin_archive_settings = new ExMachina_Admin_Archive_Settings;

  //* Set the old global pagehook var for backward compatibility (May not need this)
  global $_exmachina_admin_archive_settings_pagehook;
  $_exmachina_admin_archive_settings_pagehook = $_exmachina_admin_archive_settings->pagehook;


} // end function exmachina_add_archive_settings_page()