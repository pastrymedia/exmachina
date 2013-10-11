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
 * Handles the display and functionality of the content settings page. This provides
 * the needed hooks and meta box calls to create any number of content settings needed.
 * This file is only loaded if the theme supports the 'exmachina-core-content-settings'
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
 * Content Settings Admin Subclass
 *
 * Registers a new admin page, providing content and corresponding menu item for
 * the Content Settings page.
 *
 * @since 1.0.0
 */
class ExMachina_Admin_Content_Settings extends ExMachina_Admin_Metaboxes {

  /**
   * Content Settings Class Constructor
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
   * @uses \ExMachina_Admin_Content_Settings::sanitizer_filters()
   *
   * @todo prefix settings filters.
   * @todo add filters to page/menu titles
   * @todo maybe remove page_ops for defaults
   *
   * @since 1.0.0
   */
  function __construct() {

    /* Get the theme prefix. */
    $prefix = exmachina_get_prefix();

    /* Get theme information. */
    $theme = wp_get_theme( get_template(), get_theme_root( get_template_directory() ) );

    /* Get menu titles. */
    $menu_title = __( 'Content Settings', 'exmachina-core' );
    $page_title = sprintf( esc_html__( '%1s %2s', 'exmachina-core' ), $theme->get( 'Name' ), $menu_title );

    /* Specify the unique page id. */
    $page_id = 'content-settings';

    /* Define page titles and menu position. Can be filtered using 'exmachina_content_settings_menu_ops'. */
    $menu_ops = apply_filters(
      'exmachina_content_settings_menu_ops',
      array(
        'submenu' => array(
          'parent_slug' => 'theme-settings',
          'page_title'  => $page_title,
          'menu_title'  => $menu_title,
          'capability'  => 'edit_theme_options',
        ),
      )
    ); // end $menu_ops

    /* Define page options (notice text and screen icon). Can be filtered using 'exmachina_content_settings_page_ops'. */
    $page_ops = apply_filters(
      'exmachina_content_settings_page_ops',
      array(
        'screen_icon'       => 'options-general',
        'save_button_text'  => __( 'Save Settings', 'exmachina-core' ),
        'reset_button_text' => __( 'Reset Settings', 'exmachina-core' ),
        'saved_notice_text' => __( 'Settings saved.', 'exmachina-core' ),
        'reset_notice_text' => __( 'Settings reset.', 'exmachina-core' ),
        'error_notice_text' => __( 'Error saving settings.', 'exmachina-core' ),
      )
    ); // end $page_ops

    /* Set the unique settings field id. */
    $settings_field = EXMACHINA_CONTENT_SETTINGS_FIELD;

    /* Define the default setting values. Can be filtered using 'exmachina_content_settings_defaults'. */
    $default_settings = apply_filters(
      'exmachina_content_settings_defaults',
      array(
        '404_title'                           => __( 'Not found, error 404', 'exmachina-core' ),
      '404_content'                         => '',
      'breadcrumb_home'                     => __( 'Home', 'exmachina-core' ),
      'breadcrumb_sep'                      => ' / ',
      'breadcrumb_list_sep'                 => ', ',
      'breadcrumb_prefix'                   => '<div class=\'breadcrumb\'>',
      'breadcrumb_suffix'                   => '</div>',
      'breadcrumb_heirarchial_attachments'  => true,
      'breadcrumb_heirarchial_categories'   => true,
      'breadcrumb_display'                  => true,
        'breadcrumb_label_prefix'           => __( 'You are here: ', 'exmachina-core' ),
        'breadcrumb_author'                 => __( 'Archives for ', 'exmachina-core' ),
        'breadcrumb_category'               => __( 'Archives for ', 'exmachina-core' ),
        'breadcrumb_tag'                    => __( 'Archives for ', 'exmachina-core' ),
        'breadcrumb_date'                   => __( 'Archives for ', 'exmachina-core' ),
        'breadcrumb_search'                 => __( 'Search for ', 'exmachina-core' ),
        'breadcrumb_tax'                    => __( 'Archives for ', 'exmachina-core' ),
        'breadcrumb_post_type'              => __( 'Archives for ', 'exmachina-core' ),
        'breadcrumb_404'                    => __( 'Not found: ', 'exmachina-core' ),
      'comment_title_wrap'                  => '<h3>%s</h3>',
      'comments_title'                      => __( 'Comments', 'exmachina-core' ),
      'no_comments_text'                    => '',
      'comments_closed_text'                => '',
      'comments_title_pings'                => __( 'Trackbacks', 'exmachina-core' ),
      'comments_no_pings_text'              => '',
      'comment_list_args_avatar_size'       => 48,
      'comment_author_says_text'            => __( 'says', 'exmachina-core' ),
      'comment_awaiting_moderation'         => __( 'Your comment is awaiting moderation.', 'exmachina-core' ),
      'comment_form_args_fields_aria_display'       => TRUE,
      'comment_form_args_fields_author_display'     => TRUE,
      'comment_form_args_fields_author_label'       => __( 'Name', 'exmachina-core' ),
      'comment_form_args_fields_email_display'      => TRUE,
      'comment_form_args_fields_email_label'        => __( 'Email', 'exmachina-core' ),
      'comment_form_args_fields_url_display'        => TRUE,
      'comment_form_args_fields_url_label'          => __( 'Website', 'exmachina-core' ),
      'comment_form_args_title_reply'               => __( 'Speak Your Mind', 'exmachina-core' ),
      'comment_form_args_comment_notes_before'      => '',
      'comment_form_args_comment_notes_after'       => '',
      'comment_form_args_label_submit'              => __( 'Post Comment', 'exmachina-core' ),
      )
    ); // end $default_settings

    /* Create the admin page. */
    $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

    /* Initialize the sanitization filter. */
    add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );

  } // end function __construct()

  /**
   * Content Settings Sanitizer Filters
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

    /* Apply the safe HTML sanitization filter. */
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

    /* Apply the unfiltered HTML sanitiation filter. */
    exmachina_add_option_filter( 'requires_unfiltered_html', $this->settings_field,
      array(

    ) );



  } // end function sanitizer_filters()

  /**
   * Content Settings Help Tabs
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

    /* Add the 'Sample Help' help content. */
    $sample_help =
      '<h3>' . __( 'Content Settings', 'exmachina-core' ) . '</h3>' .
      '<p>'  . __( 'Help content goes here.' ) . '</p>';

    /* Adds the 'Sample Help' help tab. */
    $screen->add_help_tab( array(
      'id'      => $this->pagehook . '-sample-help',
      'title'   => __( 'Sample Help', 'exmachina-core' ),
      'content' => $sample_help,
    ) );

    /* Adds help sidebar content. */
    //$screen->set_help_sidebar(
    //  $template_help
    //);

    /* Trigger the help content action hook. */
    do_action( 'exmachina_content_settings_help', $this->pagehook );

  } // end function settings_page_help()

  /**
   * Content Settings Load Metaboxes
   *
   * Registers metaboxes for the settings page. Metaboxes are only registered if
   * supported by the theme and the user capabilitiy allows it.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_meta_box
   * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
   * @link http://codex.wordpress.org/Function_Reference/get_theme_support
   *
   * @uses exmachina_get_prefix() Gets the theme prefix.
   * @uses \ExMachina_Admin_Content_Settings::exmachina_metabox_theme_display_save()
   *
   * @todo prefix/add action hooks.
   *
   * @since 1.0.0
   */
  public function settings_page_load_metaboxes() {

    /* Get theme information. */
    $prefix = exmachina_get_prefix();
    $theme = wp_get_theme( get_template() );

    /* !! Begin Normal Priority Metaboxes. !! */

    /* !! Begin Side Priority Metaboxes. !! */

    /* Register the 'Save Settings' metabox to the 'side' priority. */
    add_meta_box( 'exmachina-core-content-settings-save', __( '<i class="uk-icon-save"></i> Save Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_content_display_save' ), $this->pagehook, 'side', 'high' );

    /* Register the 'Breadcrumb Settings' metabox on the 'normal' priority. */
    add_meta_box('exmachina-core-content-settings-breadcrumbs', __( 'Breadcrumb Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_content_display_breadcrumb' ), $this->pagehook, 'normal' );

    /* Register the 'Comment Settings' metabox on the 'normal' priority. */
    add_meta_box('exmachina-core-content-settings-comments', __( 'Comment Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_content_display_comment' ), $this->pagehook, 'normal' );

    /* Register the '404 Page' metabox on the 'normal' priority. */
    add_meta_box('exmachina-core-content-settings-404', __( '404 Page', 'exmachina-core' ), array( $this, 'exmachina_meta_box_content_display_404_box' ), $this->pagehook, 'normal' );

    /* Trigger the content settings metabox action hook. */
    do_action( 'exmachina_content_settings_metaboxes', $this->pagehook );

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
  function exmachina_meta_box_content_display_save() {
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
  } // end function exmachina_meta_box_content_display_save()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Breadcrumb Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Breadcrumb Settings Metabox Display
   *
   * Callback to display the 'Breadcrumb Settings' metabox. Creates a metabox
   * for the theme settings page, which allows customization of the breadcrumb
   * trail strings.
   *
   * Fields:
   * ~~~~~~~
   * 'breadcrumb_home'
   * 'breadcrumb_sep'
   * 'breadcrumb_list_sep'
   * 'breadcrumb_heirarchial_attachments'
   * 'breadcrumb_heirarchial_categories'
   * 'breadcrumb_display'
   * 'breadcrumb_label_prefix'
   * 'breadcrumb_author'
   * 'breadcrumb_category'
   * 'breadcrumb_tag'
   * 'breadcrumb_date'
   * 'breadcrumb_search'
   * 'breadcrumb_tax'
   * 'breadcrumb_post_type'
   * 'breadcrumb_404'
   * 'breadcrumb_prefix'
   * 'breadcrumb_suffix'
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
  function exmachina_meta_box_content_display_breadcrumb() {
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>" class="uk-text-bold"><?php _e( 'Home Link Text:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_home' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_home' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_sep' ); ?>" class="uk-text-bold"><?php _e( 'Trail Seperator:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_sep' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_sep' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_sep' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_list_sep' ); ?>" class="uk-text-bold"><?php _e( 'List Seperator:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_list_sep' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_list_sep' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_list_sep' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_prefix' ); ?>" class="uk-text-bold"><?php _e( 'Prefix:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_prefix' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_prefix' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_prefix' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_suffix' ); ?>" class="uk-text-bold"><?php _e( 'Suffix:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_suffix' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_suffix' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_suffix' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_heirarchial_attachments' ); ?>" class="uk-text-bold"><?php _e( 'Hierarchial Attachments?', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'breadcrumb_heirarchial_attachments' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_heirarchial_attachments' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_heirarchial_attachments' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_heirarchial_attachments' ) ); ?> />
                      <?php _e( 'Enable Hierarchial Attachments?', 'exmachina' ); ?></label>
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_heirarchial_categories' ); ?>" class="uk-text-bold"><?php _e( 'Hierarchial Categories?', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'breadcrumb_heirarchial_categories' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_heirarchial_categories' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_heirarchial_categories' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_heirarchial_categories' ) ); ?> />
                      <?php _e( 'Enable Hierarchial Categories?', 'exmachina' ); ?></label>
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_label_prefix' ); ?>" class="uk-text-bold"><?php _e( 'Prefix:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_label_prefix' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_label_prefix' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_label_prefix' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_author' ); ?>" class="uk-text-bold"><?php _e( 'Author:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_author' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_author' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_author' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_category' ); ?>" class="uk-text-bold"><?php _e( 'Category:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_category' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_category' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_category' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_tag' ); ?>" class="uk-text-bold"><?php _e( 'Tag:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_tag' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_tag' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_tag' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_date' ); ?>" class="uk-text-bold"><?php _e( 'Date:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_date' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_date' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_date' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_search' ); ?>" class="uk-text-bold"><?php _e( 'Search:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_search' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_search' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_search' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_tax' ); ?>" class="uk-text-bold"><?php _e( 'Taxonomy?:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'breadcrumb_tax' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_tax' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_tax' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_tax' ) ); ?> />
                      <?php _e( 'Taxonomy:', 'exmachina' ); ?></label>
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_post_type' ); ?>" class="uk-text-bold"><?php _e( 'Post Type:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_post_type' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_post_type' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_post_type' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>" class="uk-text-bold"><?php _e( '404:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'breadcrumb_404' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'breadcrumb_404' ) ); ?>" size="50" />
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
  } // end function exmachina_meta_box_content_display_breadcrumb()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Comment Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Comment Settings Metabox Display
   *
   * Callback to display the 'Comment Settings' metabox. Creates a metabox
   * for the theme settings page, which allows customization of the comment
   * strings.
   *
   * Fields:
   * ~~~~~~~
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
  function exmachina_meta_box_content_display_comment() {
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
              <label for="<?php echo $this->get_field_id( 'comment_title_wrap' ); ?>" class="uk-text-bold"><?php _e( 'Title Wrap:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comment_title_wrap' ); ?>" id="<?php echo $this->get_field_id( 'comment_title_wrap' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_title_wrap' ) ); ?>" size="50" /><br />
                      <span class="description"><?php _e( 'This is the html tag used around the Comment Title and Pings Title.  Make sure you keep the <tag>%s</tag> format for the wrap to work correctly.', 'exmachina' ); ?></span>
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
              <label for="<?php echo $this->get_field_id( 'comments_title' ); ?>" class="uk-text-bold"><?php _e( 'Comment Title:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comments_title' ); ?>" id="<?php echo $this->get_field_id( 'comments_title' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comments_title' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'no_comments_text' ); ?>" class="uk-text-bold"><?php _e( 'No Comments Text:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'no_comments_text' ); ?>" id="<?php echo $this->get_field_id( 'no_comments_text' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'no_comments_text' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'comments_closed_text' ); ?>" class="uk-text-bold"><?php _e( 'Comments Closed Text:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comments_closed_text' ); ?>" id="<?php echo $this->get_field_id( 'comments_closed_text' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comments_closed_text' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'comments_title_pings' ); ?>" class="uk-text-bold"><?php _e( 'Pings Title:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comments_title_pings' ); ?>" id="<?php echo $this->get_field_id( 'comments_title_pings' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comments_title_pings' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'comment_list_args_avatar_size' ); ?>" class="uk-text-bold"><?php _e( 'Avatar Size:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comment_list_args_avatar_size' ); ?>" id="<?php echo $this->get_field_id( 'comment_list_args_avatar_size' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_list_args_avatar_size' ) ); ?>" size="10" />
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
              <label for="<?php echo $this->get_field_id( 'comment_author_says_text' ); ?>" class="uk-text-bold"><?php _e( 'Author Says Text:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comment_author_says_text' ); ?>" id="<?php echo $this->get_field_id( 'comment_author_says_text' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_author_says_text' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'comment_awaiting_moderation' ); ?>" class="uk-text-bold"><?php _e( 'Comment Awaiting Moderation Text:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comment_awaiting_moderation' ); ?>" id="<?php echo $this->get_field_id( 'comment_awaiting_moderation' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_awaiting_moderation' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'comment_form_args_fields_aria_display' ); ?>" class="uk-text-bold"><?php _e( 'Aria True Attribute?:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'comment_form_args_fields_aria_display' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'comment_form_args_fields_aria_display' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_aria_display' ); ?>" value="1"<?php checked( $this->get_field_value( 'comment_form_args_fields_aria_display' ) ); ?> />
                      <?php _e( 'Enable Aria Require True Attribute?', 'exmachina' ); ?></label><br />
                      <span class="description"><?php _e( 'This is enabled by default and adds an attribute to the required comment fields that adds a layout of accesibility for visually impaired site visitors.  This attribute is not technically valid XHTML but works in all browsers. Unless you need 100% valid markup at the expense of accesability, leave this option enabled.', 'exmachina' ); ?></span>
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
              <label for="<?php echo $this->get_field_id( 'comment_form_args_fields_author_display' ); ?>" class="uk-text-bold"><?php _e( 'Author Field:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'comment_form_args_fields_author_display' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'comment_form_args_fields_author_display' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_author_display' ); ?>" value="1"<?php checked( $this->get_field_value( 'comment_form_args_fields_author_display' ) ); ?> />
                      <?php _e( 'Display Author Field?', 'exmachina' ); ?></label>
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
              <label for="<?php echo $this->get_field_id( 'comment_form_args_fields_author_label' ); ?>" class="uk-text-bold"><?php _e( 'Author Label:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comment_form_args_fields_author_label' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_author_label' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_form_args_fields_author_label' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'comment_form_args_fields_email_display' ); ?>" class="uk-text-bold"><?php _e( 'Email Display:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'comment_form_args_fields_email_display' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'comment_form_args_fields_email_display' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_email_display' ); ?>" value="1"<?php checked( $this->get_field_value( 'comment_form_args_fields_email_display' ) ); ?> />
                      <?php _e( 'Display Email Field?', 'exmachina' ); ?></label>
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
              <label for="<?php echo $this->get_field_id( 'comment_form_args_fields_email_label' ); ?>" class="uk-text-bold"><?php _e( 'Email Label:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comment_form_args_fields_email_label' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_email_label' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_form_args_fields_email_label' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'comment_form_args_fields_url_display' ); ?>" class="uk-text-bold"><?php _e( 'URL Display:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'comment_form_args_fields_url_display' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'comment_form_args_fields_url_display' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_url_display' ); ?>" value="1"<?php checked( $this->get_field_value( 'comment_form_args_fields_url_display' ) ); ?> />
                      <?php _e( 'Display URL Field?', 'exmachina' ); ?></label>
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
              <label for="<?php echo $this->get_field_id( 'comment_form_args_fields_url_label' ); ?>" class="uk-text-bold"><?php _e( 'URL Label:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comment_form_args_fields_url_label' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_fields_url_label' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_form_args_fields_url_label' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'comment_form_args_title_reply' ); ?>" class="uk-text-bold"><?php _e( 'Reply Label:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comment_form_args_title_reply' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_title_reply' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_form_args_title_reply' ) ); ?>" size="50" />
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
              <label for="<?php echo $this->get_field_id( 'comment_form_args_comment_notes_before' ); ?>" class="uk-text-bold"><?php _e( 'Notes Before Comment:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <textarea name="<?php echo $this->get_field_name( 'comment_form_args_comment_notes_before' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_comment_notes_before' ); ?>" rows="3" cols="70"><?php echo esc_textarea( $this->get_field_value( 'comment_form_args_comment_notes_before' ) ); ?></textarea><br />
                      <span class="description"><?php _e( 'The meta description can be used to determine the text used under the title on search engine results pages.', 'exmachina' ); ?></span>
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
              <label for="<?php echo $this->get_field_id( 'comment_form_args_comment_notes_after' ); ?>" class="uk-text-bold"><?php _e( 'Notes After Comment:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <textarea name="<?php echo $this->get_field_name( 'comment_form_args_comment_notes_after' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_comment_notes_after' ); ?>" rows="3" cols="70"><?php echo esc_textarea( $this->get_field_value( 'comment_form_args_comment_notes_after' ) ); ?></textarea><br />
                      <span class="description"><?php _e( 'The meta description can be used to determine the text used under the title on search engine results pages.', 'exmachina' ); ?></span>
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
              <label for="<?php echo $this->get_field_id( 'comment_form_args_label_submit' ); ?>" class="uk-text-bold"><?php _e( 'Submit Button Label:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comment_form_args_label_submit' ); ?>" id="<?php echo $this->get_field_id( 'comment_form_args_label_submit' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comment_form_args_label_submit' ) ); ?>" size="50" />
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
  } // end function exmachina_meta_box_content_display_comment()

  /*-------------------------------------------------------------------------*/
  /* Begin '404 Page' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * 404 Page Settings Metabox Display
   *
   * Callback to display the '404 Page Settings' metabox. Creates a metabox for
   * the theme settings page, which holds a textarea for custom 404 page content.
   *
   * Settings:
   * ~~~~~~~~~
   * '404_title'
   * '404_content'
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
  function exmachina_meta_box_content_display_404_box() {
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

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="<?php echo $this->get_field_id( '404_title' ); ?>"><?php _e( 'Page Title:', 'exmachina-core' ); ?></label>
                    <div class="uk-form-controls">
                      <input type="text" name="<?php echo $this->get_field_name( '404_title' ); ?>" id="<?php echo $this->get_field_id( '404_title' ); ?>" value="<?php echo esc_attr( $this->get_field_value( '404_title' ) ); ?>" size="50" />
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="<?php echo $this->get_field_id( '404_content' ); ?>"><?php _e( 'Page Content:', 'exmachina-core' ); ?></label>
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <?php
                      /* Add a textarea using the wp_editor() function to make it easier on users to add custom content. */
                      wp_editor(
                        $this->get_field_value( '404_content' ), // Editor content.
                        $this->get_field_id( '404_content' ),    // Editor ID.
                        array(
                          'tinymce'       => true, // Don't use TinyMCE in a meta box.
                          'textarea_rows' => 12,     // Set the number of textarea rows.
                          'media_buttons' => true, // Don't display the media button.
                        ) );
                      ?>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><?php _e( 'Shortcodes and some <abbr title="Hypertext Markup Language">HTML</abbr> is allowed.', 'exmachina-core' ); ?></p>
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
  } // end function exmachina_meta_box_content_display_404_box()

} // end class ExMachina_Admin_Content_Settings

add_action( 'exmachina_admin_menu', 'exmachina_add_content_settings_page' );
/**
 * Add Content Settings Page
 *
 * Initializes a new instance of the ExMachina_Admin_Content_Settings and adds
 * the Content Settings Page.
 *
 * @since 1.0.0
 */
function exmachina_add_content_settings_page() {

  /* Globalize the $_exmachina_admin_content_settings variable. */
  global $_exmachina_admin_content_settings;

  /* Create a new instance of the ExMachina_Admin_Content_Settings class. */
  $_exmachina_admin_content_settings = new ExMachina_Admin_Content_Settings;

  //* Set the old global pagehook var for backward compatibility (May not need this)
  global $_exmachina_admin_content_settings_pagehook;
  $_exmachina_admin_content_settings_pagehook = $_exmachina_admin_content_settings->pagehook;


} // end function exmachina_add_content_settings_page()