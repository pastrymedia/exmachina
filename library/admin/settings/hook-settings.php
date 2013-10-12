<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Hook Settings
 *
 * hook-settings.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Handles the display and functionality of the hook settings page. This provides
 * the needed hooks and meta box calls to create any number of hook settings needed.
 * This file is only loaded if the theme supports the 'exmachina-core-hook-settings'
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
 * Hook Settings Admin Subclass
 *
 * Registers a new admin page, providing content and corresponding menu item for
 * the Hook Settings page.
 *
 * @since 1.0.0
 */
class ExMachina_Admin_Hook_Settings extends ExMachina_Admin_Metaboxes {

  /**
   * Hook Settings Class Constructor
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
   * @uses \ExMachina_Admin_Hook_Settings::sanitizer_filters()
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
    $menu_title = __( 'Hook Settings', 'exmachina-core' );
    $page_title = sprintf( esc_html__( '%1s %2s', 'exmachina-core' ), $theme->get( 'Name' ), $menu_title );

    /* Specify the unique page id. */
    $page_id = 'hook-settings';

    /* Define page titles and menu position. Can be filtered using 'exmachina_hook_settings_menu_ops'. */
    $menu_ops = apply_filters(
      'exmachina_hook_settings_menu_ops',
      array(
        'submenu' => array(
          'parent_slug' => 'theme-settings',
          'page_title'  => $page_title,
          'menu_title'  => $menu_title,
          'capability'  => 'edit_theme_options',
        ),
      )
    ); // end $menu_ops

    /* Define page options (notice text and screen icon). Can be filtered using 'exmachina_hook_settings_page_ops'. */
    $page_ops = apply_filters(
      'exmachina_hook_settings_page_ops',
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
    $settings_field = EXMACHINA_HOOK_SETTINGS_FIELD;

    /* Define the default setting values. Can be filtered using 'exmachina_hook_settings_defaults'. */
    $default_settings = apply_filters(
      'exmachina_hook_settings_defaults',
      array(

      //* Wordpress Hooks */
      'wp_head' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'wp_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

      //* Internal Hooks */
      'exmachina_pre' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_pre_framework' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_init' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_setup' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

      //* Document Hooks */
      'exmachina_doctype' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_meta' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_before' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

      //* Header hooks */
      'exmachina_before_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_header_right' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_site_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_site_description' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

      //* Content Hooks */
      'exmachina_before_content_sidebar_wrap' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_content_sidebar_wrap' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_before_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

      //* Loop Hooks */
      'exmachina_before_loop' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_loop' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_loop' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_endwhile' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_loop_else' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

      //* Entry Hooks */
      'exmachina_before_entry' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_entry_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_entry_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_entry_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_entry' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

      //* Comment Hooks */
      'exmachina_before_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_list_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_before_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_list_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_before_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_before_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_before_comment_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_comment_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_comment_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

      //* Sidebar Hooks */
      'exmachina_before_sidebar' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_sidebar' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_sidebar' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_before_sidebar_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_sidebar_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_before_sidebar_alt' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_sidebar_alt' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_sidebar_alt' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_before_sidebar_alt_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_sidebar_alt_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_before_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_after_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

      //* Admin Hooks */
      'exmachina_import_export_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_export' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_import' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_theme_settings_metaboxes' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      'exmachina_upgrade' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
      )
    ); // end $default_settings

    /* Create the admin page. */
    $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

  } // end function __construct()

  /**
   * Hook Settings Help Tabs
   *
   * Setup contextual help tabs content. This method adds the appropiate help
   * tabs based on the metaboxes/settings the theme supports.
   *
   * @todo add help content
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
      '<h3>' . __( 'Hook Settings', 'exmachina-core' ) . '</h3>' .
      '<p>'  . __( 'Help content goes here.' ) . '</p>';

    /* Adds the 'Sample Help' help tab. */
    $screen->add_help_tab( array(
      'id'      => $this->pagehook . '-sample-help',
      'title'   => __( 'Sample Help', 'exmachina-core' ),
      'content' => $sample_help,
    ) );

    /* Adds help sidebar content. */
    $screen->set_help_sidebar(
      $template_help
    );

    /* Trigger the help content action hook. */
    do_action( 'exmachina_hook_settings_help', $this->pagehook );

  } // end function settings_page_help()

  /**
   * Hook Settings Load Metaboxes
   *
   * Registers metaboxes for the settings page. Metaboxes are only registered if
   * supported by the theme and the user capabilitiy allows it.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_meta_box
   * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
   * @link http://codex.wordpress.org/Function_Reference/get_theme_support
   *
   * @uses exmachina_get_prefix() Gets the theme prefix.
   * @uses \ExMachina_Admin_Hook_Settings::exmachina_metabox_theme_display_save()
   *
   * @todo prefix/add action hooks.
   * @todo add appropiate icons
   * @todo split metaboxes
   * @todo add header info
   *
   * @since 1.0.0
   */
  public function settings_page_load_metaboxes() {

    /* Get theme information. */
    $prefix = exmachina_get_prefix();
    $theme = wp_get_theme( get_template() );

    /* Register the 'Save Settings' metabox to the 'side' priority. */
    add_meta_box( 'exmachina-core-hook-settings-save', __( '<i class="uk-icon-save"></i> Save Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_save' ), $this->pagehook, 'side', 'high' );

    /* Register the 'WordPress Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-wp-hooks', __( '<i class="uk-icon-anchor"></i> WordPress Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_wp_hooks_box' ), $this->pagehook, 'normal' );

    /* Register the 'Document Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-document-hooks', __( '<i class="uk-icon-anchor"></i> Document Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_document_hooks_box' ), $this->pagehook, 'normal' );

    /* Register the 'Header Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-header-hooks', __( '<i class="uk-icon-anchor"></i> Header Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_header_hooks_box' ), $this->pagehook, 'normal' );

    /* Register the 'Content Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-content-hooks', __( '<i class="uk-icon-anchor"></i> Content Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_content_hooks_box' ), $this->pagehook, 'normal' );

    /* Register the 'Loop Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-loop-hooks', __( '<i class="uk-icon-anchor"></i> Loop Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_loop_hooks_box' ), $this->pagehook, 'normal' );

    /* Register the 'Entry Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-entry-hooks', __( '<i class="uk-icon-anchor"></i> Entry Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_entry_hooks_box' ), $this->pagehook, 'normal' );

    /* Register the 'Comment List Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-comment-list-hooks', __( '<i class="uk-icon-anchor"></i> Comment List Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_comment_list_hooks_box' ), $this->pagehook, 'normal' );

    /* Register the 'Ping List Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-ping-list-hooks', __( '<i class="uk-icon-anchor"></i> Ping List Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_ping_list_hooks_box' ), $this->pagehook, 'normal' );

    /* Register the 'Single Comment Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-comment-hooks', __( '<i class="uk-icon-anchor"></i> Single Comment Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_comment_hooks_box' ), $this->pagehook, 'normal' );

    /* Register the 'Comment Form Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-comment-form-hooks', __( '<i class="uk-icon-anchor"></i> Comment Form Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_comment_form_hooks_box' ), $this->pagehook, 'normal' );

    /* Register the 'Sidebar Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-sidebar-hooks', __( '<i class="uk-icon-anchor"></i> Sidebar Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_sidebar_hooks_box' ), $this->pagehook, 'normal' );

    /* Register the 'Footer Hooks' metabox to the 'normal' priority. */
    add_meta_box( 'exmachina-core-hook-settings-footer-hooks', __( '<i class="uk-icon-anchor"></i> Footer Hooks', 'exmachina-core' ), array( $this, 'exmachina_meta_box_hook_display_footer_hooks_box' ), $this->pagehook, 'normal' );

    /* Trigger the hook settings metabox action hook. */
    do_action( 'exmachina_hook_settings_metaboxes', $this->pagehook );

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
  function exmachina_meta_box_hook_display_save() {
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
  } // end function exmachina_meta_box_hook_display_save()

  /*-------------------------------------------------------------------------*/
  /* Begin 'WordPress Hooks' metabox display. */
  /*-------------------------------------------------------------------------*/

  function exmachina_meta_box_hook_display_wp_hooks_box() {
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
          <?php

            /* Add wp_head() hook form. */
            exmachina_hooks_form_generate( array(
              'hook' => 'wp_head',
              'desc' => __( 'This hook executes immediately before the closing <code>&lt;/head&gt;</code> tag.', 'exmachina-core' )
            ) );

            /* Add wp_footer() hook form. */
            exmachina_hooks_form_generate( array(
              'hook' => 'wp_footer',
              'desc' => __( 'This hook executes immediately before the closing <code>&lt;/body&gt;</code> tag.', 'exmachina-core' )
            ) );

          ?>

          <tr>
            <td class="save-cell">
              <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
            </td>
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_meta_box_hook_display_wp_hooks()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Document Hooks' metabox display. */
  /*-------------------------------------------------------------------------*/

  function exmachina_meta_box_hook_display_document_hooks_box() {
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
          <?php

            exmachina_hooks_form_generate( array(
              'hook' => 'exmachina_title',
              'desc' => __( 'This hook executes between the main document <code>&lt;title&gt;&lt;/title&gt;</code> tags.', 'exmachina-core' )
            ) );

            exmachina_hooks_form_generate( array(
              'hook' => 'exmachina_meta',
              'desc' => __( 'This hook executes in the document <code>&lt;head&gt;</code>.<br /> It is commonly used to output <code>META</code> information about the document.', 'exmachina-core' ),
              'unhook' => array( 'exmachina_load_favicon' )
            ) );

            exmachina_hooks_form_generate( array(
              'hook' => 'exmachina_before',
              'desc' => __( 'This hook executes immediately after the opening <code>&lt;body&gt;</code> tag.', 'exmachina-core' )
            ) );

            exmachina_hooks_form_generate( array(
              'hook' => 'exmachina_after',
              'desc' => __( 'This hook executes immediately before the closing <code>&lt;/body&gt;</code> tag.', 'exmachina-core' )
            ) );

          ?>

          <tr>
            <td class="save-cell">
              <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
            </td>
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_meta_box_hook_display_document_hooks_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Header Hooks' metabox display. */
  /*-------------------------------------------------------------------------*/

  function exmachina_meta_box_hook_display_header_hooks_box() {
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
          <?php

            exmachina_hooks_form_generate( array(
              'hook' => 'exmachina_before_header',
              'desc' => __( 'This hook executes immediately before the header (outside the <code>#header</code> div).', 'exmachina-core' )
            ) );

            exmachina_hooks_form_generate( array(
              'hook' => 'exmachina_header',
              'desc' => __( 'This hook outputs the default header (the <code>#header</code> div)', 'exmachina-core' ),
              'unhook' => array( 'exmachina_do_header' )
            ) );

            exmachina_hooks_form_generate( array(
              'hook' => 'exmachina_after_header',
              'desc' => __( 'This hook executes immediately after the header (outside the <code>#header</code> div).', 'exmachina-core' )
            ) );

          ?>
          <tr>
            <td class="save-cell">
              <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
            </td>
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
  <?php
  } // end function exmachina_meta_box_hook_display_header_hooks_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Content Hooks' metabox display. */
  /*-------------------------------------------------------------------------*/

  function exmachina_meta_box_hook_display_content_hooks_box() {
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
        <?php

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_content_sidebar_wrap',
            'desc' => __( 'This hook executes immediately before the div block that wraps the content and the primary sidebar (outside the <code>#content-sidebar-wrap</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_content_sidebar_wrap',
            'desc' => __( 'This hook executes immediately after the div block that wraps the content and the primary sidebar (outside the <code>#content-sidebar-wrap</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_content',
            'desc' => __( 'This hook executes immediately before the content column (outside the <code>#content</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_content',
            'desc' => __( 'This hook executes immediately after the content column (outside the <code>#content</code> div).', 'exmachina-core' )
          ) );

        ?>
        <tr>
          <td class="save-cell">
            <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
          </td>
        </tr>
      </tbody>
      <!-- End Table Body -->
    </table>
  </div><!-- .postbox-inner-wrap -->
  <!-- End Markup -->
  <?php

  } // end function exmachina_meta_box_hook_display_content_hooks_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Loop Hooks' metabox display. */
  /*-------------------------------------------------------------------------*/

  function exmachina_meta_box_hook_display_loop_hooks_box() {
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
        <?php

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_loop',
            'desc' => __( 'This hook executes immediately before all loop blocks.<br /> Therefore, this hook falls outside the loop, and cannot execute functions that require loop template tags or variables.', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_loop',
            'desc' => __( 'This hook executes both default and custom loops.', 'exmachina-core' ),
            'unhook' => array( 'exmachina_do_loop' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_loop',
            'desc' => __( 'This hook executes immediately after all loop blocks.<br /> Therefore, this hook falls outside the loop, and cannot execute functions that require loop template tags or variables.', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_endwhile',
            'desc' => __( 'This hook executes after the <code>endwhile;</code> statement.', 'exmachina-core' ),
            'unhook' => array( 'exmachina_posts_nav' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_loop_else',
            'desc' => __( 'This hook executes after the <code>else :</code> statement in all loop blocks. The content attached to this hook will only display if there are no posts available when a loop is executed.', 'exmachina-core' ),
            'unhook' => array( 'exmachina_do_noposts' )
          ) );

         ?>
        <tr>
          <td class="save-cell">
            <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
          </td>
        </tr>

      </tbody>
      <!-- End Table Body -->
    </table>
  </div><!-- .postbox-inner-wrap -->
  <!-- End Markup -->
  <?php
  } // end function exmachina_meta_box_hook_display_loop_hooks_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Entry Hooks' metabox display. */
  /*-------------------------------------------------------------------------*/

  function exmachina_meta_box_hook_display_entry_hooks_box() {
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
        <?php

          exmachina_hooks_form_generate(array(
            'hook' => 'exmachina_before_entry',
            'desc' => __( 'This hook executes before each entry in all loop blocks (outside the entry markup element).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate(array(
            'hook' => 'exmachina_entry_header',
            'desc' => __( 'This hook executes before the entry content. By default, it outputs the entry title and meta information.', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate(array(
            'hook' => 'exmachina_entry_content',
            'desc' => __( 'This hook, by default, outputs the entry content.', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate(array(
            'hook' => 'exmachina_entry_footer',
            'desc' => __( 'This hook executes after the entry content. By Default, it outputs entry meta information.', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate(array(
            'hook' => 'exmachina_after_entry',
            'desc' => __( 'This hook executes after each entry in all loop blocks (outside the entry markup element).', 'exmachina-core' )
          ) );

          ?>
          <tr>
            <td class="save-cell">
              <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
            </td>
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_meta_box_hook_display_entry_hooks_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Comment List Hooks' metabox display. */
  /*-------------------------------------------------------------------------*/


  function exmachina_meta_box_hook_display_comment_list_hooks_box() {

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
        <?php

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_comments',
            'desc' => __( 'This hook executes immediately before the comments block (outside the <code>#comments</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_comments',
            'desc' => __( 'This hook outputs the comments block, including the <code>#comments</code> div.', 'exmachina-core' ),
            'unhook' => array( 'exmachina_do_comments' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_list_comments',
            'desc' => __( 'This hook executes inside the comments block, inside the <code>.comment-list</code> OL. By default, it outputs a list of comments associated with a post via the <code>exmachina_default_list_comments()</code> function.', 'exmachina-core' ),
            'unhook' => array( 'exmachina_default_list_comments' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_comments',
            'desc' => __( 'This hook executes immediately after the comments block (outside the <code>#comments</code> div).', 'exmachina-core' )
          ) );

          ?>
        <tr>
          <td class="save-cell">
            <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
          </td>
        </tr>
        </tbody>
      <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_meta_box_hook_display_comment_list_hooks_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Ping List Hooks' metabox display. */
  /*-------------------------------------------------------------------------*/

  function exmachina_meta_box_hook_display_ping_list_hooks_box() {

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
        <?php

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_pings',
            'desc' => __( 'This hook executes immediately before the pings block (outside the <code>#pings</code> div).', 'exmachina-core' ),
            'unhook' => array( 'exmachina_do_pings' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_pings',
            'desc' => __( 'This hook outputs the pings block, including the <code>#pings</code> div.', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_list_pings',
            'desc' => __( 'This hook executes inside the pings block, inside the <code>.ping-list</code> OL. By default, it outputs a list of pings associated with a post via the <code>exmachina_default_list_pings()</code> function.', 'exmachina-core' ),
            'unhook' => array( 'exmachina_default_list_pings' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_pings',
            'desc' => __( 'This hook executes immediately after the pings block (outside the <code>#pings</code> div).', 'exmachina-core' )
          ) );

           ?>
          <tr>
            <td class="save-cell">
              <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
            </td>
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php

  } // end function exmachina_meta_box_hook_display_ping_list_hooks_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Single Comment Hooks' metabox display. */
  /*-------------------------------------------------------------------------*/

  function exmachina_meta_box_hook_display_comment_hooks_box() {

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
        <?php

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_comment',
            'desc' => __( 'This hook executes immediately before each individual comment (inside the <code>.comment</code> list item).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_comment',
            'desc' => __( 'This hook executes immediately after each individual comment (inside the <code>.comment</code> list item).', 'exmachina-core' )
          ) );

          ?>
          <tr>
            <td class="save-cell">
              <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
            </td>
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php

  } // end function exmachina_meta_box_hook_display_comment_hooks_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Comment Form' metabox display. */
  /*-------------------------------------------------------------------------*/

  function exmachina_meta_box_hook_display_comment_form_hooks_box() {

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
        <?php

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_comment_form',
            'desc' => __( 'This hook executes immediately before the comment form, outside the <code>#respond</code> div.', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_comment_form',
            'desc' => __( 'This hook outputs the entire comment form, including the <code>#respond</code> div.', 'exmachina-core' ),
            'unhook' => array( 'exmachina_do_comment_form' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_comment_form',
            'desc' => __( 'This hook executes immediately after the comment form, outside the <code>#respond</code> div.', 'exmachina-core' )
          ) );

          ?>
          <tr>
            <td class="save-cell">
              <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
            </td>
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php

  } // end function exmachina_meta_box_hook_display_comment_form_hooks_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Sidebar Hooks' metabox display. */
  /*-------------------------------------------------------------------------*/

  function exmachina_meta_box_hook_display_sidebar_hooks_box() {

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
        <?php

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_sidebar',
            'desc' => __( 'This hook executes immediately before the primary sidebar column (outside the <code>#sidebar</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_sidebar',
            'desc' => __( 'This hook outputs the content of the primary sidebar, including the widget area output.', 'exmachina-core' ),
            'unhook' => array( 'exmachina_do_sidebar' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_sidebar',
            'desc' => __( 'This hook executes immediately after the primary sidebar column (outside the <code>#sidebar</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_sidebar_widget_area',
            'desc' => __( 'This hook executes immediately before the primary sidebar widget area (inside the <code>#sidebar</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_sidebar_widget_area',
            'desc' => __( 'This hook executes immediately after the primary sidebar widget area (inside the <code>#sidebar</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_sidebar_alt',
            'desc' => __( 'This hook executes immediately before the alternate sidebar column (outside the <code>#sidebar-alt</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_sidebar_alt',
            'desc' => __( 'This hook outputs the content of the secondary sidebar, including the widget area output.', 'exmachina-core' ),
            'unhook' => array( 'exmachina_do_sidebar_alt' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_sidebar_alt',
            'desc' => __( 'This hook executes immediately after the alternate sidebar column (outside the <code>#sidebar-alt</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_sidebar_alt_widget_area',
            'desc' => __( 'This hook executes immediately before the alternate sidebar widget area (inside the <code>#sidebar-alt</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_sidebar_alt_widget_area',
            'desc' => __( 'This hook executes immediately after the alternate sidebar widget area (inside the <code>#sidebar-alt</code> div).', 'exmachina-core' )
          ) );

          ?>
          <tr>
            <td class="save-cell">
              <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
            </td>
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php

  } // end function exmachina_meta_box_hook_display_sidebar_hooks_box()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Footer Hooks' metabox display. */
  /*-------------------------------------------------------------------------*/

  function exmachina_meta_box_hook_display_footer_hooks_box() {

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
        <?php

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_before_footer',
            'desc' => __( 'This hook executes immediately before the footer (outside the <code>#footer</code> div).', 'exmachina-core' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_footer',
            'desc' => __( 'This hook, by default, outputs the content of the footer (inside the <code>#footer</code> div).', 'exmachina-core' ),
            'unhook' => array( 'exmachina_do_footer' )
          ) );

          exmachina_hooks_form_generate( array(
            'hook' => 'exmachina_after_footer',
            'desc' => __( 'This hook executes immediately after the footer (outside the <code>#footer</code> div).', 'exmachina-core' )
          ) );

           ?>
          <tr>
            <td class="save-cell">
              <?php submit_button( __( 'Save Changes', 'exmachina-core' ), 'primary' ); ?>
            </td>
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_meta_box_hook_display_footer_hooks_box()

} // end class ExMachina_Admin_Hook_Settings
