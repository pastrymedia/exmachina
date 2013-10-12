<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Theme Settings
 *
 * theme-settings.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Handles the display and functionality of the theme settings page. This provides
 * the needed hooks and meta box calls to create any number of theme settings needed.
 * This file is only loaded if the theme supports the 'exmachina-core-theme-settings'
 * feature.
 *
 * @package     ExMachina
 * @subpackage  Admin Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/**
 * Theme Settings Admin Subclass
 *
 * Registers a new admin page, providing content and corresponding menu item for
 * the Theme Settings page.
 *
 * @since 0.2.0
 */
class ExMachina_Admin_Archive_Settings extends ExMachina_Admin_Metaboxes {

  /**
   * Theme Settings Class Constructor
   *
   * Creates an admin menu item and settings page.
   *
   * @since 0.2.0
   */
  function __construct() {

    /* Get theme information. */
    $theme = wp_get_theme( get_template(), get_theme_root( get_template_directory() ) );

    /* Get menu titles. */
    $menu_title = __( 'Theme Settings', 'exmachina-core' );
    $page_title = sprintf( esc_html__( '%1s %2s', 'exmachina-core' ), $theme->get( 'Name' ), $menu_title );

    /* Specify the unique page id. */
    $page_id = 'theme-settings';

    /* Define page titles and menu position. Can be filtered using 'exmachina_theme_settings_menu_ops'. */
    $menu_ops = apply_filters(
      'exmachina_theme_settings_menu_ops',
      array(
        'main_menu' => array(
          'sep' => array(
            'sep_position'   => '58.995',
            'sep_capability' => 'edit_theme_options',
          ),
          'page_title' => $page_title,
          'menu_title' => $theme->get( 'Name' ),
          'capability' => 'edit_theme_options',
          'icon_url'   => 'div',
          'position'   => '58.996',
        ),
        'first_submenu' => array( //* Do not use without 'main_menu'
          'page_title' => $page_title,
          'menu_title' => $menu_title,
          'capability' => 'edit_theme_options',
        ),
        'theme_submenu' => array( //* Do not use without 'main_menu'
          'page_title' => $page_title,
          'menu_title' => $menu_title,
          'capability' => 'edit_theme_options',
        ),
      )
    );

    /* Define page options (notice text and screen icon). Can be filtered using 'exmachina_theme_settings_page_ops'. */
    $page_ops = apply_filters(
      'exmachina_theme_settings_page_ops',
      array(
        'screen_icon'       => 'options-general',
        'save_button_text'  => __( 'Save Settings', 'exmachina-core' ),
        'reset_button_text' => __( 'Reset Settings', 'exmachina-core' ),
        'saved_notice_text' => __( 'Settings saved.', 'exmachina-core' ),
        'reset_notice_text' => __( 'Settings reset.', 'exmachina-core' ),
        'error_notice_text' => __( 'Error saving settings.', 'exmachina-core' ),
      )
    );

    /* Set the unique settings field id. */
    $settings_field = EXMACHINA_SETTINGS_FIELD;

    /* Define the default setting values. Can be filtered using 'exmachina_theme_settings_defaults'. */
    $default_settings = apply_filters(
      'exmachina_theme_settings_defaults',
      array(
        'theme_version' => EXMACHINA_VERSION,
        'db_version'    => EXMACHINA_DB_VERSION,
        'test_setting'   => __( 'This is the test setting default.', 'exmachina-core' ),
      )
    );

    /* Create the admin page. */
    $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

    /* Initialize the sanitization filter. */
    add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );

  } // end function __construct()

  /**
   * Theme Settings Sanitizer Filters
   *
   * Register each of the settings with a sanitization filter type.
   *
   * @uses exmachina_add_option_filter() Assign a sanitization filter to an array of settings.
   *
   * @since 0.1.0
   */
  public function sanitizer_filters() {

    exmachina_add_option_filter( 'safe_html', $this->settings_field,
      array(
        'test_setting',
    ) );

  } // end function sanitizer_filters()

  /**
   * Theme Settings Help Tabs
   *
   * Setup contextual help tabs content.
   *
   * @todo  create help sidebar variables (possibly using the CSS technique)
   *
   * @since 0.1.0
   */
  public function settings_page_help() {

    $screen = get_current_screen();

    /* Add the 'Sample Help' help content. */
    $sample_help =
      '<h3>' . __( 'Theme Settings', 'exmachina' ) . '</h3>' .
      '<p>'  . __( 'Help content goes here.' ) . '</p>';

    /* Adds the 'Sample Help' help tab. */
    $screen->add_help_tab( array(
      'id'      => $this->pagehook . '-sample-help',
      'title'   => __( 'Sample Help', 'exmachina' ),
      'content' => $sample_help,
    ) );

    /* Adds help sidebar content. */
    $screen->set_help_sidebar(
      '<p><strong>' . __( 'For more information:', 'exmachina' ) . '</strong></p>' .
      '<p><a href="http://my.machinathemes.com/help/" target="_blank" title="' . __( 'Get Support', 'exmachina' ) . '">' . __( 'Get Support', 'exmachina' ) . '</a></p>' .
      '<p><a href="http://my.machinathemes.com/snippets/" target="_blank" title="' . __( 'ExMachina Snippets', 'exmachina' ) . '">' . __( 'ExMachina Snippets', 'exmachina' ) . '</a></p>' .
      '<p><a href="http://my.machinathemes.com/tutorials/" target="_blank" title="' . __( 'ExMachina Tutorials', 'exmachina' ) . '">' . __( 'ExMachina Tutorials', 'exmachina' ) . '</a></p>'
    );

    /* Trigger the help content action hook. */
    do_action( 'exmachina_theme_settings_help', $this->pagehook );

  } // end function settings_page_help()

  /**
   * Theme Settings Load Metaboxes
   *
   * Registers metaboxes for the Theme Settings page. Metaboxes are only
   * registered if supported by the theme and the user capabilitiy allows it.
   *
   * Additional metaboxes may be added using the 'exmachina_theme_settings_metaboxes'
   * action hook
   *
   * @since 0.1.0
   */
  public function settings_page_load_metaboxes() {

    /* Get theme information. */
    $prefix = exmachina_get_prefix();
    $theme = wp_get_theme( get_template() );

    /* Adds hidden fields before the theme settings metabox display. */
    add_action( $this->pagehook . '_admin_before_metaboxes', array( $this, 'hidden_fields' ) );

    /* !! Begin Normal Priority Metaboxes. !! */

    /* Register the 'Favicon' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-theme-settings-favicon', __( 'Favicon Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_favicon' ), $this->pagehook, 'normal', 'default' );

    /* Register the 'Layout' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-theme-settings-layout', __( 'Layout Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_layout' ), $this->pagehook, 'normal', 'default' );

    /* Register the 'Feeds' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-theme-settings-feeds', __( 'Feed Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_feeds' ), $this->pagehook, 'normal', 'default' );

    /* Register the 'Breadcrumb' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-theme-settings-breadcrumb', __( 'Breadcrumb Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_breadcrumb' ), $this->pagehook, 'normal', 'default' );

     /* Register the 'Image' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-theme-settings-image', __( 'Image Settings', 'exmachina' ), array( $this, 'exmachina_meta_box_theme_display_image' ), $this->pagehook, 'normal', 'default' );

    /* Register the 'Comments' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-theme-settings-comments', __( 'Comment <span class="amp">&amp;</span> Trackback Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_comment' ), $this->pagehook, 'normal', 'default' );

    /* Register the 'Content' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-theme-settings-archives', __( 'Content Archives', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_archives' ), $this->pagehook, 'normal', 'default' );

    /* Register the 'Footer' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-theme-settings-footer', __( 'Footer Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_footer' ), $this->pagehook, 'normal', 'default' );

    /* Register the 'Scripts' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-theme-settings-scripts', __( 'Header <span class="amp">&amp;</span> Footer Scripts', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_scripts' ), $this->pagehook, 'normal', 'default' );

    /* Register the 'Header' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-theme-settings-header', __( 'Header Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_header' ), $this->pagehook, 'normal', 'default' );

    /* Register the 'Navigation' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-theme-settings-navigation', __( 'Navigation Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_navigation' ), $this->pagehook, 'normal', 'default' );

    /* !! Begin Side Priority Metaboxes. !! */

    /* Register the 'Save Settings' metabox to the 'side' priority. */
    add_meta_box( 'exmachina-core-theme-settings-save', __( 'Save Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_save' ), $this->pagehook, 'side', 'high' );

    /* Adds the About box for the parent theme. */
    add_meta_box( 'exmachina-core-theme-settings-about-theme', sprintf( __( 'About %s', 'exmachina-core' ), $theme->get( 'Name' ) ), array( $this, 'exmachina_meta_box_theme_display_about' ), $this->pagehook, 'side', 'high' );

    /* If the user is using a child theme, add an About box for it. */
    if ( is_child_theme() ) {
        $child = wp_get_theme();
        add_meta_box( 'exmachina-core-theme-settings-about-child', sprintf( __( 'About %s', 'exmachina-core' ), $child->get( 'Name' ) ), array( $this, 'exmachina_meta_box_theme_display_about' ), $this->pagehook, 'side', 'high' );
    }

    /* Register the 'Update' metabox to the 'side' priority. */
    add_meta_box( 'exmachina-core-theme-settings-update', __( 'Theme Updates', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_update' ), $this->pagehook, 'side', 'default' );

    /* Register the 'Need Help' metabox to the 'side' priority. */
    add_meta_box( 'exmachina-core-theme-settings-help', __( 'Need Help?', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_help' ), $this->pagehook, 'side', 'default' );

    /* !! Begin CONTENT SETTINGS Metaboxes. !! */

    /* Register the 'Page Settings' metabox to the 'normal' priority. */
    add_meta_box('exmachina-core-content-settings-page', __( 'Page Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_content_display_page' ), $this->pagehook, 'normal', 'default');

    /* Register the 'Post Settings' metabox to the 'normal' priority. */
    add_meta_box('exmachina-core-content-settings-post', __( 'Post Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_content_display_post' ), $this->pagehook, 'normal', 'default');

    /* Register the 'Content Archives' metabox to the 'normal' priority. */
    add_meta_box('exmachina-core-content-settings-content-archives', __( 'Content Archives', 'exmachina-core' ), array( $this, 'exmachina_meta_box_content_display_archives' ), $this->pagehook, 'normal', 'default');

    /* !! Begin DESIGN SETTINGS Metaboxes. !! */

    /* Register the 'Color Settings' metabox to the 'normal' priority. */
    add_meta_box('exmachina-core-design-settings-color', __( 'Color Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_design_display_color' ), $this->pagehook, 'normal', 'default');

    /* Register the 'Code Settings' metabox to the 'normal' priority. */
    add_meta_box('exmachina-core-design-settings-code', __( 'Code Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_design_display_code' ), $this->pagehook, 'normal', 'default');

    /* Register the 'Style Settings' metabox to the 'normal' priority. */
    add_meta_box('exmachina-core-design-settings-style', __( 'Color Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_design_display_style' ), $this->pagehook, 'normal', 'default');


    /* Trigger the theme settings metabox action hook. */
    do_action( 'exmachina_theme_settings_metaboxes', $this->pagehook );

  } // end function settings_page_load_metaboxes()

  /**
   * Theme Settings Hidden Fields
   *
   * Echo hidden form fields before the metaboxes.
   *
   * @since 0.1.0
   *
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @param  string $pagehook Current page hook.
   * @return null             Returns early if not set to the correct admin page.
   */
  function hidden_fields( $pagehook ) {

    if ( $pagehook !== $this->pagehook )
      return;

    printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'theme_version' ), esc_attr( $this->get_field_value( 'theme_version' ) ) );
    printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'db_version' ), esc_attr( $this->get_field_value( 'db_version' ) ) );

  } // end function hidden_fields()

  /**
   * Favicon Settings Metabox Display
   *
   * Callback to display the 'Favicon Settings' metabox.
   *
   * @since 0.2.7
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   */
  function exmachina_meta_box_theme_display_favicon() {
    ?>
    <table class="uk-table postbox-table">
      <thead><tr>
                    <td class="div info header" colspan="2">
                    A favicon generally appears at the top of the web browser next to the title or URL of your website for your online visitors.
                    </td>
                </tr></thead>
            <tbody>

                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Standard Favicon (16x16):</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <input type="url" class="uk-width-7-10">
                            <button class="uk-button" type="button">Upload</button>
                            <p class="uk-form-help-block">Insert the URL to the .ico file or PNG image you'd like to use as your website's favicon.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php
  }

  /**
     * Layout Settings Metabox Display
     *
     * Callback to display the 'Layout Settings' metabox.
     *
     * @since 0.2.7
     *
     * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
     * @uses \ExMachina_Admin::get_field_name()  Construct field name.
     * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
     */
    function exmachina_meta_box_theme_display_layout() {
        ?>
       <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <thead>
                <tr>
                    <td class="div info header" colspan="2">
                    A favicon generally appears at the top of the web browser next to the title or URL of your website for your online visitors.
                    </td>
                </tr>
                </thead>
                <tbody>
                <tr>

                    <td colspan="2">
                        <fieldset class="uk-form">
                            <div class="layout-container uk-grid uk-grid-preserve">
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">

                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img02.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img layout-img-selected" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img03.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img04.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img05.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img06.png' ); ?>">
                                </label>


                            </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->
        <?php
    }

  /**
     * Feed Settings Metabox Display
     *
     * Callback to display the 'Feeds Settings' metabox.
     *
     * @since 0.2.7
     *
     * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
     * @uses \ExMachina_Admin::get_field_name()  Construct field name.
     * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
     */
    function exmachina_meta_box_theme_display_feeds() {
        ?>

        <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <thead>
                <tr>
                    <td class="div info header" colspan="2">
                    <?php printf( __( 'If your custom feed(s) are not handled by Feedburner, we do not recommend that you use the redirect options.', 'exmachina-core' ) ); ?>
                    </td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label for="<?php echo $this->get_field_id( 'feed_uri' ); ?>" class="uk-text-bold"><?php _e( 'Custom Feed URL:', 'exmachina-core' ); ?></label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <input type="url" class="uk-width-7-10" name="<?php echo $this->get_field_name( 'feed_uri' ); ?>" id="<?php echo $this->get_field_id( 'feed_uri' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'feed_uri' ) ); ?>" >
                            <label for="<?php echo $this->get_field_id( 'redirect_feed' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'redirect_feed' ); ?>" id="<?php echo $this->get_field_id( 'redirect_feed' ); ?>" value="1"<?php checked( $this->get_field_value( 'redirect_feed' ) ); ?> />
                    <?php _e( 'Redirect Feed?', 'exmachina-core' ); ?></label>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label for="<?php echo $this->get_field_id( 'comments_feed_uri' ); ?>" class="uk-text-bold"><?php _e( 'Custom Comments Feed URL:', 'exmachina-core' ); ?></label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <input type="url" class="uk-width-7-10" name="<?php echo $this->get_field_name( 'comments_feed_uri' ); ?>" id="<?php echo $this->get_field_id( 'comments_feed_uri' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comments_feed_uri' ) ); ?>">
                            <label for="<?php echo $this->get_field_id( 'redirect_comments_feed' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'redirect_comments_feed' ); ?>" id="<?php echo $this->get_field_id( 'redirect_comments_feed' ); ?>" value="1"<?php checked( $this->get_field_value( 'redirect_comments__feed' ) ); ?> />
                    <?php _e( 'Redirect Feed?', 'exmachina-core' ); ?></label>
                        </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->


        <?php
    }

  /**
     * Breadcrumb Settings Metabox Display
     *
     * Callback to display the 'Breadcrumb Settings' metabox.
     *
     * @since 0.2.7
     *
     * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
     * @uses \ExMachina_Admin::get_field_name()  Construct field name.
     * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
     */
    function exmachina_meta_box_theme_display_breadcrumb() {
        ?>
        <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <thead>
                <tr>
                    <td class="div info header" colspan="2">

                    <?php _e( 'Breadcrumbs are an easy way to show your visitors where they are on your site. You may also override these settings on a individual post/page basis.', 'exmachina-core' ); ?>
                    </td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold"><?php _e( 'Show Breadcrumbs On:', 'exmachina-core' ); ?></label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <ul class="checkbox-list horizontal">
                            <?php if ( 'page' == get_option( 'show_on_front' ) ) : ?>
                        <li><label for="<?php echo $this->get_field_id( 'breadcrumb_front_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_front_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_front_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_front_page' ) ); ?> />
                        <?php _e( 'Front Page', 'exmachina' ); ?></label></li>

                        <li><label for="<?php echo $this->get_field_id( 'breadcrumb_posts_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_posts_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_posts_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_posts_page' ) ); ?> />
                        <?php _e( 'Posts Page', 'exmachina' ); ?></label></li>
                    <?php else : ?>
                        <li><label for="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_home' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_home' ) ); ?> />
                        <?php _e( 'Homepage', 'exmachina' ); ?></label></li>
                    <?php endif; ?>

                    <li><label for="<?php echo $this->get_field_id( 'breadcrumb_single' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_single' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_single' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_single' ) ); ?> />
                    <?php _e( 'Posts', 'exmachina' ); ?></label></li>

                    <li><label for="<?php echo $this->get_field_id( 'breadcrumb_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_page' ) ); ?> />
                    <?php _e( 'Pages', 'exmachina' ); ?></label></li>

                    <li><label for="<?php echo $this->get_field_id( 'breadcrumb_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_archive' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_archive' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_archive' ) ); ?> />
                    <?php _e( 'Archives', 'exmachina' ); ?></label></li>

                    <li><label for="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_404' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_404' ) ); ?> />
                    <?php _e( '404 Page', 'exmachina' ); ?></label></li>

                    <li><label for="<?php echo $this->get_field_id( 'breadcrumb_attachment' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_attachment' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_attachment' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_attachment' ) ); ?> />
                    <?php _e( 'Attachment Page', 'exmachina' ); ?></label></li>
                        </ul>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->


        <?php
    }


  /**
     * Image Settings Metabox Display
     *
     * Callback to display the 'Image Settings' metabox.
     *
     * @since 0.2.7
     *
     * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
     * @uses \ExMachina_Admin::get_field_name()  Construct field name.
     * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
     */
    function exmachina_meta_box_theme_display_image() {

      ?>
      <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <thead>
                <tr>
                    <td class="div success header" colspan="2">
                    If your custom feed(s) are not handled by Feedburner, we do not recommend that you use the redirect options.
                    </td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Featured Image:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="checkbox-list horizontal">
                                <li><label><input type="checkbox" id="" class="">Include Post Thumbnails?</label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Featured Image:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="checkbox-list horizontal">
                                <li><label><input type="checkbox" id="" class="">Include Post Thumbnails in RSS feed?</label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Featured Image:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="checkbox-list horizontal">
                                <li><label><input type="checkbox" id="" class="">Include Post Thumbnails in RSS feed?</label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Featured Image:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="checkbox-list horizontal">
                                <li><label><input type="checkbox" id="" class="">Use any attached image if no Featured Image specified?</label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Default Thumbnail*:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <input type="url" class="uk-width-7-10">
                            <button class="uk-button" type="button">Upload</button>
                            <p class="uk-form-help-block">Insert the URL to the .ico file or PNG image you'd like to use as your website's favicon.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Default Image Size*:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <select>
                                <option>Thumbnail (150 x 150)</option>
                                <option>Medium (300 x 300)</option>
                                <option>Full-Width</option>
                            </select>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->
      <?php
    }

  /**
     * Comment Settings Metabox Display
     *
     * Callback to display the 'Comment Settings' metabox.
     *
     * @since 0.2.7
     *
     * @todo  Add fancy ampersand
     *
     * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
     * @uses \ExMachina_Admin::get_field_name()  Construct field name.
     * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
     */
    function exmachina_meta_box_theme_display_comment() {
        ?>

        <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <thead>
                <tr>
                    <td class="div error header" colspan="2">
                    <?php _e( 'Comments and Trackbacks can also be disabled on a per post/page basis when creating/editing posts/pages.', 'exmachina-core' ); ?>
                    </td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold"><?php _e( 'Enable Comments:', 'exmachina-core' ); ?></label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <ul class="checkbox-list horizontal">
                            <li><label for="<?php echo $this->get_field_id( 'comments_posts' ); ?>" title="Enable comments on posts"><input type="checkbox" name="<?php echo $this->get_field_name( 'comments_posts' ); ?>" id="<?php echo $this->get_field_id( 'comments_posts' ); ?>" value="1"<?php checked( $this->get_field_value( 'comments_posts' ) ); ?> /><?php _e( 'on Posts?', 'exmachina-core' ); ?></label></li>
                            <li><label for="<?php echo $this->get_field_id( 'comments_pages' ); ?>" title="Enable comments on pages"><input type="checkbox" name="<?php echo $this->get_field_name( 'comments_pages' ); ?>" id="<?php echo $this->get_field_id( 'comments_pages' ); ?>" value="1"<?php checked( $this->get_field_value( 'comments_pages' ) ); ?> /><?php _e( 'on Pages?', 'exmachina-core' ); ?></label></li>
                        </ul>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold"><?php _e( 'Enable Trackbacks:', 'exmachina-core' ); ?></label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <ul class="checkbox-list horizontal">
                            <li><label for="<?php echo $this->get_field_id( 'trackbacks_posts' ); ?>" title="Enable trackbacks on posts"><input type="checkbox" name="<?php echo $this->get_field_name( 'trackbacks_posts' ); ?>" id="<?php echo $this->get_field_id( 'trackbacks_posts' ); ?>" value="1"<?php checked( $this->get_field_value( 'trackbacks_posts' ) ); ?> /><?php _e( 'on Posts?', 'exmachina-core' ); ?></label></li>
                            <li><label for="<?php echo $this->get_field_id( 'trackbacks_pages' ); ?>" title="Enable trackbacks on pages"><input type="checkbox" name="<?php echo $this->get_field_name( 'trackbacks_pages' ); ?>" id="<?php echo $this->get_field_id( 'trackbacks_pages' ); ?>" value="1"<?php checked( $this->get_field_value( 'trackbacks_pages' ) ); ?> /><?php _e( 'on Pages?', 'exmachina-core' ); ?></label></li>
                        </ul>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->


        <?php
    }

  /**
   * Archives Settings Metabox Display
   *
   * Callback to display the 'Archives Settings' metabox.
   *
   * @since 0.2.7
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   */
  function exmachina_meta_box_theme_display_archives() {
    ?>
    <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <tbody>
                <tr>
                    <td class="div alert header" colspan="2">
                    Breadcrumbs are an easy way to show your visitors where they are on your site. You may also override these settings on a individual post/page basis.
                    </td>
                </tr>
                <tr>
                    <td class="layout-selector" colspan="2">
                        <fieldset class="uk-form">
                            <div class="layout-container uk-grid uk-grid-preserve">
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img02.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img layout-img-selected" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img03.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img04.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img05.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img06.png' ); ?>">
                                </label>
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Post Content in Archives:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <select>
                                <option>Display Post Content</option>
                                <option>Display Post Excerpt</option>
                            </select>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Limit Characters*:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <label>Limit content to</label>
                            <input type="number" class="uk-form-width-mini uk-form-small">
                            <label>characters.</label>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Featured Image:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="checkbox-list horizontal">
                                <li><label><input type="checkbox" id="" class="">Include Featured Image?</label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Image Size*:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <select>
                                <option>Thumbnail (150 x 150)</option>
                                <option>Medium (300 x 300)</option>
                                <option>Full-Width</option>
                            </select>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Post Navigation:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <select>
                                <option>Older/Newer</option>
                                <option>Previous/Next</option>
                                <option>Pagination</option>
                            </select>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->
    <?php
  }

  /**
     * Footer Settings Metabox Display
     *
     * Callback to display the 'Footer Settings' metabox. Creates a meta box
     * that allows users to customize their footer.
     *
     * @since 0.2.7
     *
     * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
     * @uses \ExMachina_Admin::get_field_name()  Construct field name.
     * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
     */
    function exmachina_meta_box_theme_display_footer() {
        ?>

         <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <tbody>
                <tr>
                    <td class="div info header" colspan="2">
                    Breadcrumbs are an easy way to show your visitors where they are on your site. You may also override these settings on a individual post/page basis.
                    </td>
                </tr>
                <tr>
                    <td class="layout-selector" colspan="2">
                        <fieldset class="uk-form">
                            <div class="layout-container uk-grid uk-grid-preserve">
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img02.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img layout-img-selected" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img03.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img04.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img05.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img06.png' ); ?>">
                                </label>
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset class="uk-form">
                            <label class="uk-text-bold uk-margin">Custom Footer Text:</label>
                            <?php
            /* Add a textarea using the wp_editor() function to make it easier on users to add custom content. */
            wp_editor(
                esc_textarea( $this->get_field_value( 'footer_insert' ) ),  // Editor content.
                $this->get_field_id( 'footer_insert' ),        // Editor ID.
                array(
                    'tinymce' =>        false, // Don't use TinyMCE in a meta box.
                    'textarea_name' =>  $this->get_field_name( 'footer_insert' ),
                )
            );
            ?>
                            <p class="uk-form-help-block"><?php _e( 'Shortcodes and some <acronym title="Hypertext Markup Language">HTML</acronym> is allowed.', 'exmachina-core' ); ?></p>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->



        <?php
    }

  /**
     * Scripts Settings Metabox Display
     *
     * Callback to display the 'Script Settings' metabox.
     *
     * @since 0.2.7
     *
     * @todo maybe add codemirror style switcher.
     *
     * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
     * @uses \ExMachina_Admin::get_field_name()  Construct field name.
     * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
     */
    function exmachina_meta_box_theme_display_scripts() {
        ?>

        <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <tbody>
                <tr>
                    <td class="div info header" colspan="2">
                    A favicon generally appears at the top of the web browser next to the title or URL of your website for your online visitors.
                    </td>
                </tr>
                 <!-- Begin header scripts -->
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label for="<?php echo $this->get_field_id( 'header_scripts' ); ?>" class="uk-text-bold">Header Scripts:</label>
                        <p class="description">Enter scripts or code you would like output to <code>wp_head()</code>.</p>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <textarea class="input-block-level exmachina-code-area" name="<?php echo $this->get_field_name( 'header_scripts' ); ?>" id="<?php echo $this->get_field_id( 'header_scripts' ); ?>" rows="8"><?php echo esc_textarea( $this->get_field_value( 'header_scripts' ) ); ?></textarea>
                            <p class="uk-form-help-block">The <code>wp_head()</code> hook executes immediately before the closing <code>head</code> tag in the document source.</p>
                            <link rel="stylesheet" href="<?php echo EXMACHINA_ADMIN_VENDOR . '/codemirror/theme/monokai.css'; ?>">
                    <script>
                        jQuery(document).ready(function($){
                            var editor_header_scripts = CodeMirror.fromTextArea(document.getElementById('<?= $this->get_field_id( 'header_scripts' );?>'), {
                                lineNumbers: true,
                                tabmode: 'indent',
                                mode: 'htmlmixed',
                                theme: 'monokai'
                            });
                        });
                    </script>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <!-- Begin footer scripts -->
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label for="<?php echo $this->get_field_id( 'footer_scripts' ); ?>" class="uk-text-bold">Footer Scripts:</label>
                        <p class="description">Enter scripts or code you would like output to <code>wp_footer()</code>.</p>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <textarea class="input-block-level exmachina-code-area" rows="8" name="<?php echo $this->get_field_name( 'footer_scripts' ); ?>" id="<?php echo $this->get_field_id( 'footer_scripts' ); ?>"><?php echo esc_textarea( $this->get_field_value( 'footer_scripts' ) ); ?></textarea>
                            <p class="uk-form-help-block">The <code>wp_footer()</code> hook executes immediately before the closing <code>body</code> tag in the document source.</p>
                            <link rel="stylesheet" href="<?php echo EXMACHINA_ADMIN_VENDOR . '/codemirror/theme/monokai.css'; ?>">
                    <script>
                        jQuery(document).ready(function($){
                            var editor_footer_scripts = CodeMirror.fromTextArea(document.getElementById('<?= $this->get_field_id( 'footer_scripts' );?>'), {
                                lineNumbers: true,
                                tabmode: 'indent',
                                mode: 'htmlmixed',
                                theme: 'monokai'
                            });
                        });
                    </script>
                        </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->


        <?php
    }

   /**
     * Header Settings Metabox Display
     *
     * Callback to display the 'Header Settings' metabox.
     *
     * @since 0.2.7
     *
     * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
     * @uses \ExMachina_Admin::get_field_name()  Construct field name.
     * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
     */
    function exmachina_meta_box_theme_display_header() {}





    /**
     * Navigation Settings Metabox Display
     *
     * Callback to display the 'Navigation Settings' metabox.
     *
     * @since 0.2.7
     *
     * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
     * @uses \ExMachina_Admin::get_field_name()  Construct field name.
     * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
     */
    function exmachina_meta_box_theme_display_navigation() {}

  /**
   * Save Settings Metabox Display
   *
   * Callback to display the 'Save Settings' metabox.
   *
   * @since 0.2.7
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   */
  function exmachina_meta_box_theme_display_save() {
    ?>
      <div class="basic-wrap">
      <div class="field">
        <?php submit_button( $this->page_ops['save_button_text'], 'primary button-hero update-button uk-button-expand', 'submit', false, array( 'id' => '' ) ); ?>
      </div><!-- .field -->
      </div><!-- .basic-wrap -->
    <?php
  } // end function exmachina_meta_box_theme_display_save()

  /**
     * About Theme Metabox Display
     *
     * Callback to display the 'About Theme' metabox. Creates an information
     * meta box with no settings about the theme. The meta box will display
     * information about both the parent theme and child theme. If a child theme
     * is active, this function will be called a second time.
     *
     * @since 0.2.7
     * @uses exmachina_get_prefix()
     * @param object $object Variable passed through the do_meta_boxes() call.
     * @param array $box Specific information about the meta box being loaded.
     * @return void
     */
    function exmachina_meta_box_theme_display_about( $object, $box ) {

        /* Get theme information. */
        $prefix = exmachina_get_prefix();

        /* Grab theme information for the parent/child theme. */
        $theme = ( 'exmachina-about-child' == $box['id'] ) ? wp_get_theme() : wp_get_theme( get_template() );

        ?>
        <div class="basic-wrap">
        <div class="field">
            <img class="uk-align-center uk-thumbnail uk-thumbnail-medium" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/screenshot.png' ); ?>" alt="<?php echo esc_attr( $theme->get( 'Name' ) ); ?>">

            <dl class="uk-description-list uk-description-list-horizontal">
            <dt class="uk-text-bold"><?php _e( 'Theme:', 'exmachina-core' ); ?></dt>
            <dd><a href="<?php echo esc_url( $theme->get( 'ThemeURI' ) ); ?>" title="<?php echo esc_attr( $theme->get( 'Name' ) ); ?>"><?php echo $theme->get( 'Name' ); ?></a></dd>
            <dt class="uk-text-bold"><?php _e( 'Author:', 'exmachina-core' ); ?></dt>
            <dd><a href="<?php echo esc_url( $theme->get( 'AuthorURI' ) ); ?>" title="<?php echo esc_attr( $theme->get( 'Author' ) ); ?>"><?php echo $theme->get( 'Author' ); ?></a></dd>
        </dl>
        <dl class="uk-description-list">
            <dt class="uk-text-bold"><?php _e( 'Description:', 'exmachina-core' ); ?></dt>
            <dd><?php echo $theme->get( 'Description' ); ?></dd>
        </dl>

        </div><!-- .field -->
        </div>
        <?php
    }

  /**
     * Update Metabox Display
     *
     * Callback to display the 'Update' metabox.
     *
     * @since 0.2.7
     *
     * @todo add JS to enable fade in e-mail box.
     *
     * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
     * @uses \ExMachina_Admin::get_field_name()  Construct field name.
     * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
     */
    function exmachina_meta_box_theme_display_update() {

      /* Get theme data. */
    $theme  = wp_get_theme();
        ?>
        <div class="basic-wrap">
        <div class="field">

          <fieldset class="uk-form">
            <dl class="uk-description-list uk-description-list-horizontal">
                <dt class="uk-text-bold"><?php _e( 'Version:', 'exmachina-core' ); ?></dt>
                <dd><?php echo EXMACHINA_VERSION; ?></dd>
                <dt class="uk-text-bold"><?php _e( 'Release Date:', 'exmachina-core' ); ?></dt>
                <dd><?php echo EXMACHINA_RELEASE_DATE; ?></dd>
            </dl>

            <ul class="checkbox-list vertical bl">
                <li><label for="<?php echo $this->get_field_id( 'update' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'update' ); ?>" id="<?php echo $this->get_field_id( 'update' ); ?>" value="1"<?php checked( $this->get_field_value( 'update' ) ) . disabled( is_super_admin(), 0 ); ?> /><?php _e( 'Enable Automatic Updates', 'exmachina-core' ); ?></label></li>
                <li><label for="<?php echo $this->get_field_id( 'update_email' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'update_email' ); ?>" id="<?php echo $this->get_field_id( 'update_email' ); ?>" value="1"<?php checked( $this->get_field_value( 'update_email' ) ) . disabled( is_super_admin(), 0 ); ?> /><?php _e( 'Notify when updates are available', 'exmachina-core' ); ?></label></li>
            </ul>
            <br>
            <input class="input-block-level" type="email" name="<?php echo $this->get_field_name( 'update_email_address' ); ?>" id="<?php echo $this->get_field_id( 'update_email_address' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'update_email_address' ) ); ?>" placeholder="Enter your e-mail address" <?php disabled( 0, is_super_admin() ); ?> />
            <p class="uk-form-help-block"><?php echo sprintf( __( 'If you provide an email address above, you will be notified via email when a new version of %s is available.', 'exmachina-core' ), $theme->get( 'Name' ) ); ?></p>
        </fieldset>




        </div><!-- .field -->
        </div>
        <?php
    }

     /**
     * Need Help Metabox Display
     *
     * Callback to display the 'Need Help' metabox.
     *
     * @since 0.2.7
     *
     * @todo  variable the support url
     *
     * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
     * @uses \ExMachina_Admin::get_field_name()  Construct field name.
     * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
     */
    function exmachina_meta_box_theme_display_help() {

        /* Get theme information. */
        $theme = wp_get_theme();

        ?>
        <div class="basic-wrap">
        <div class="field">
            <p class="help-block">
                <?php _e( 'Struggling with some of the theme options or settings? Click on the "Help" tab above.', 'exmachina-core' ); ?>
            </p>

            <p class="help-block">
                <?php echo sprintf( __( 'You can also visit the %s <a href="%s" target="_blank">support forum</a>', 'exmachina-core' ), $theme->{'Name'}, 'http://www.machinathemes.com/support/' ); ?>
            </p>
        </div><!-- .field -->
        </div>
        <?php
    }

  /**
   * Page Settings Metabox Display
   *
   * Callback to display the 'Save Settings' metabox.
   *
   * @since 0.2.7
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   */
  function exmachina_meta_box_content_display_page() {
    ?>
    <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <tbody>
                <tr>
                    <td class="div info header" colspan="2">
                    Breadcrumbs are an easy way to show your visitors where they are on your site. You may also override these settings on a individual post/page basis.
                    </td>
                </tr>
                <tr>
                    <td class="layout-selector" colspan="2">
                        <fieldset class="uk-form">
                            <div class="layout-container uk-grid uk-grid-preserve">
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img02.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img layout-img-selected" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img03.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img04.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img05.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img06.png' ); ?>">
                                </label>
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Show Page Titles:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="radio-list horizontal">
                                <li><label><input type="radio" id="" class="">Yes</label></li>
                                <li><label><input type="radio" id="" class="">No</label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Featured Image:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="checkbox-list horizontal">
                                <li><label><input type="checkbox" id="" class="">Include Featured Image?</label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Image Size*:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <select>
                                <option>Thumbnail (150 x 150)</option>
                                <option>Medium (300 x 300)</option>
                                <option>Full-Width</option>
                            </select>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->
    <?php
  }

  /**
   * Post Settings Metabox Display
   *
   * Callback to display the 'Save Settings' metabox.
   *
   * @since 0.2.7
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   */
  function exmachina_meta_box_content_display_post() {
    ?>
    <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <tbody>
                <tr>
                    <td class="div info header" colspan="2">
                    Breadcrumbs are an easy way to show your visitors where they are on your site. You may also override these settings on a individual post/page basis.
                    </td>
                </tr>
                <tr>
                    <td class="layout-selector" colspan="2">
                        <fieldset class="uk-form">
                            <div class="layout-container uk-grid uk-grid-preserve">
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img02.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img layout-img-selected" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img03.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img04.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img05.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img06.png' ); ?>">
                                </label>
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Show Post Header Meta:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="radio-list horizontal">
                                <li><label><input type="radio" id="" class="">Yes</label></li>
                                <li><label><input type="radio" id="" class="">No</label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Post Header Meta*:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <input type="url" class="uk-width-1-1">
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Show Post Footer Meta:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="radio-list horizontal">
                                <li><label><input type="radio" id="" class="">Yes</label></li>
                                <li><label><input type="radio" id="" class="">No</label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Post Footer Meta*:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <input type="url" class="uk-width-1-1">
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Featured Image:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="checkbox-list horizontal">
                                <li><label><input type="checkbox" id="" class="">Include Featured Image?</label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Image Size*:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <select>
                                <option>Thumbnail (150 x 150)</option>
                                <option>Medium (300 x 300)</option>
                                <option>Full-Width</option>
                            </select>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Single Post Navigation:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <select>
                                <option>Disabled</option>
                                <option>Show Above Posts</option>
                                <option>Show Below Posts</option>
                                <option>Show Above + Below Posts</option>
                            </select>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->
    <?php
  }

/**
   * Content Archive Settings Metabox Display
   *
   * Callback to display the 'Save Settings' metabox.
   *
   * @since 0.2.7
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   */
  function exmachina_meta_box_content_display_archives() {
    ?>
    <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <tbody>
                <tr>
                    <td class="div info header" colspan="2">
                    Breadcrumbs are an easy way to show your visitors where they are on your site. You may also override these settings on a individual post/page basis.
                    </td>
                </tr>
                <tr>
                    <td class="layout-selector" colspan="2">
                        <fieldset class="uk-form">
                            <div class="layout-container uk-grid uk-grid-preserve">
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img layout-img-selected" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                                </label>
                                <label class="layout-label uk-width-1-6">
                                    <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                                    <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                                </label>
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Post Layout:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <select>
                                <option>Post List</option>
                                <option>Post Grid</option>
                            </select>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Grid Options*:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="input-list vertical">
                                <li><label>Features on First Page<input type="number" class="uk-form-width-mini uk-form-small"></label></li>
                                <li><label>Teasers on First Page<input type="number" class="uk-form-width-mini uk-form-small"></label></li>
                                <li><label>Features on Subsequent Pages<input type="number" class="uk-form-width-mini uk-form-small"></label></li>
                                <li><label>Teasers on Subsequent Pages<input type="number" class="uk-form-width-mini uk-form-small"></label></li>
                                <li><label>Teaser Columns (2-6)<input type="number" class="uk-form-width-mini uk-form-small"></label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Post Content in Archives:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <select>
                                <option>Display Post Content</option>
                                <option>Display Post Excerpt</option>
                            </select>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Limit Characters*:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <label>Limit content to</label>
                            <input type="number" class="uk-form-width-mini uk-form-small">
                            <label>characters.</label>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Read More Text:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <input type="url" class="uk-width-1-1">
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Featured Image:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <ul class="checkbox-list horizontal">
                                <li><label><input type="checkbox" id="" class="">Include Featured Image?</label></li>
                            </ul>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Image Size*:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <select>
                                <option>Thumbnail (150 x 150)</option>
                                <option>Medium (300 x 300)</option>
                                <option>Full-Width</option>
                            </select>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Post Navigation:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <select>
                                <option>Older/Newer</option>
                                <option>Previous/Next</option>
                                <option>Pagination</option>
                            </select>
                            <p class="uk-form-help-block">Shortcodes and some HTML is allowed.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->
    <?php
  }

/**
 * Color Settings Metabox Display
 *
 * Callback to display the 'Save Settings' metabox.
 *
 * @since 0.2.7
 *
 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
 */
function exmachina_meta_box_design_display_color() {
  ?>
  <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <tbody>
                <tr>
                    <td class="div info header" colspan="2">
                    A favicon generally appears at the top of the web browser next to the title or URL of your website for your online visitors.
                    </td>
                </tr>
                <tr>

                    <td colspan="2">
                        <fieldset class="uk-form">
                            <div class="color-container uk-grid uk-grid-preserve">
                                <label class="color-label uk-width-1-6">
                                    <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                                    <img class="color-img uk-thumbnail" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color01.png' ); ?>">
                                </label>
                                <label class="color-label uk-width-1-6">
                                    <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                                    <img class="color-img uk-thumbnail" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color02.png' ); ?>">
                                </label>
                                <label class="color-label uk-width-1-6">
                                    <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                                    <img class="color-img uk-thumbnail color-img-selected" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color03.png' ); ?>">
                                </label>
                                <label class="color-label uk-width-1-6">
                                    <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                                    <img class="color-img uk-thumbnail" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color04.png' ); ?>">
                                </label>
                                <label class="color-label uk-width-1-6">
                                    <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                                    <img class="color-img uk-thumbnail" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color05.png' ); ?>">
                                </label>
                                <label class="color-label uk-width-1-6">
                                    <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                                    <img class="color-img uk-thumbnail" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color06.png' ); ?>">
                                </label>


                            </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->
  <?php
}

/**
 * Code Settings Metabox Display
 *
 * Callback to display the 'Save Settings' metabox.
 *
 * @since 0.2.7
 *
 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
 */
function exmachina_meta_box_design_display_code() {
  ?>
  <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <tbody>
                <tr>
                    <td class="div info header" colspan="2">
                    A favicon generally appears at the top of the web browser next to the title or URL of your website for your online visitors.
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <fieldset class="uk-form">
                        <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                            <textarea class="input-block-level" rows="8"></textarea>
                            <p class="uk-form-help-block">The <code>wp_footer()</code> hook executes immediately before the closing <code>body</code> tag in the document source.</p>
                        </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->
  <?php
}

/**
 * Style Settings Metabox Display
 *
 * Callback to display the 'Save Settings' metabox.
 *
 * @since 0.2.7
 *
 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
 */
function exmachina_meta_box_design_display_style() {
  ?>
  <!-- Begin Markup -->
        <table class="uk-table postbox-table">
            <tbody>
                <tr>
                    <td class="div info header" colspan="2">
                    If your custom feed(s) are not handled by Feedburner, we do not recommend that you use the redirect options.
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-3-10 postbox-label">
                        <label class="uk-text-bold">Global Type:</label>
                    </td>
                    <td class="uk-width-7-10">
                        <fieldset class="uk-form">
                            <div class="uk-form-controls uk-form-controls-text uk-form-controls-condensed">
                                <div class="section section-typography">

                                    <div class="controls">
                                        <select class="woo-typography woo-typography-size woo-typography-size-px" id="woo_font_body_size_px" style="display:none">
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                        </select>

                                        <select class="woo-typography woo-typography-size woo-typography-size-em" id="woo_font_body_size_em" name="woo_font_body_size">
                                            <option value="2.1">2.1</option>
                                            <option value="2.2">2.2</option>
                                            <option value="2.3">2.3</option>
                                            <option value="2.4">2.4</option>
                                            <option value="2.5">2.5</option>
                                            <option value="2.6">2.6</option>
                                            <option value="2.7">2.7</option>
                                            <option value="2.8">2.8</option>
                                            <option value="2.9">2.9</option>
                                        </select>

                                        <select class="woo-typography woo-typography-unit" name="woo_font_body_unit" id="woo_font_body_unit">
                                            <option value="px">px</option>
                                            <option value="em" selected="selected">em</option>
                                        </select>

                                        <select class="woo-typography woo-typography-face" name="woo_font_body_face" id="woo_font_body_face">
                                            <option selected="selected" value="Arial, sans-serif">Arial</option>
                                            <option value="Verdana, Geneva, sans-serif">Verdana</option>
                                            <option value="Georgia, serif">Georgia</option>
                                            <option value="Tahoma, Geneva, Verdana, sans-serif">Tahoma</option>
                                            <option value="Geneva, Tahoma, Verdana, sans-serif">Geneva*</option>
                                            <option value="Impact, Charcoal, sans-serif">Impact</option>
                                            <option value="">-- Google Fonts --</option>
                                            <option value="Architects Daughter">Architects Daughter</option>
                                            <option value="Arimo">Arimo</option>
                                            <option value="Cabin">Cabin</option>
                                            <option value="Chivo">Chivo</option>
                                            <option value="Lato">Lato</option>
                                            <option value="Lobster">Lobster</option>
                                            <option value="Lobster Two">Lobster Two</option>
                                            <option value="Oswald">Oswald</option>
                                            <option value="Rock Salt">Rock Salt</option>
                                            <option value="Yanone Kaffeesatz">Yanone Kaffeesatz</option>
                                        </select>

                                        <select class="woo-typography woo-typography-style" name="woo_font_body_style" id="woo_font_body_style">
                                            <option selected="selected" value="300">Thin</option>
                                            <option value="300 italic">Thin/Italic</option>
                                            <option value="normal">Normal</option>
                                            <option value="italic">Italic</option>
                                            <option value="bold">Bold</option>
                                            <option value="bold italic">Bold/Italic</option>
                                        </select>

                                        <div id="woo_font_body_color_picker" class="colorSelector">
                                            <div style="background-color: rgb(62, 62, 62);"></div>
                                        </div>
                                        <input class="woo-color woo-typography woo-typography-color" name="woo_font_body_color" id="woo_font_body_color" value="#3E3E3E" type="text">
                                        <br>
                                    </div>
                                    <div class="explain"></div>
                                    <div class="clear"> </div>

                                </div><!-- .section-typography -->
                            </div>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Markup -->
  <?php
}


} // end class ExMachina_Admin_Theme_Settings

add_action( 'exmachina_setup', 'exmachina_add_theme_settings_page' );
/**
 * Add Theme Settings Page
 *
 * Initializes a new instance of the ExMachina_Admin_Theme_Settings and adds
 * the Theme Settings Page.
 *
 * @since 0.1.0
 */
function exmachina_add_theme_settings_page() {

  /* Globalize the $_exmachina_admin_theme_settings variable. */
  global $_exmachina_admin_theme_settings;

  /* Create a new instance of the ExMachina_Admin_Theme_Settings class. */
  $_exmachina_admin_theme_settings = new ExMachina_Admin_Theme_Settings;

  //* Set the old global pagehook var for backward compatibility (May not need this)
  global $_exmachina_admin_theme_settings_pagehook;
  $_exmachina_admin_theme_settings_pagehook = $_exmachina_admin_theme_settings->pagehook;

  do_action( 'exmachina_admin_menu' );

} // end function exmachina_add_theme_settings_page()