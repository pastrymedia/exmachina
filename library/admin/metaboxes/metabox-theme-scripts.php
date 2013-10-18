<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Theme Header & Footer Scripts Metabox
 *
 * metabox-theme-scripts.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Creates a metabox for the theme settings page, which holds textareas for
 * custom scripts to be added to the header and footer of the theme. To use
 * this feature, the theme must support the 'scripts' argument for the
 * 'exmachina-core-theme-settings' feature.
 *
 * @package     ExMachina
 * @subpackage  Metaboxes
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/* Create the scripts meta box on the 'add_meta_boxes' hook. */
add_action( 'add_meta_boxes', 'exmachina_meta_box_theme_add_scripts' );

/* Sanitize the scripts settings before adding them to the database. */
add_filter( 'sanitize_option_' . exmachina_get_prefix() . '_theme_settings', 'exmachina_meta_box_theme_save_scripts' );

/* Adds the help tabs to the theme settings page. */
add_action( 'add_help_tabs', 'exmachina_theme_settings_scripts_help');

/**
 * Add Header and Footer Scripts Metabox
 *
 * Adds the core "Comments" metabox to the theme settings page.
 *
 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
 *
 * @uses exmachina_meta_box_theme_display_scripts() Theme metabox display callback.
 * @uses exmachina_get_settings_page_name()         The theme settings page name.
 *
 * @since 2.6.0
 * @access public
 *
 * @return void
 */
function exmachina_meta_box_theme_add_scripts() {

  /* Adds the Header and Footer Scripts box for the theme. */
  add_meta_box( 'exmachina-core-scripts', __( 'Header and Footer Scripts', 'exmachina-core' ), 'exmachina_meta_box_theme_display_scripts', exmachina_get_settings_page_name(), 'normal', 'high' );

} // end function exmachina_meta_box_theme_add_scripts()

/**
 * Header and Footer Scripts Theme Metabox Display
 *
 * Creates a metabox that allows users to customize scripts that are run in the
 * header and footer of their site.
 *
 * @uses exmachina_settings_field_id()    Get the settings field ID.
 * @uses exmachina_settings_field_name()  Get the settings field name.
 * @uses exmachina_get_setting()          Get the settings field value.
 *
 * @since 2.6.0
 * @access public
 *
 * @return void
 */
function exmachina_meta_box_theme_display_scripts() {
  ?>

  <!-- Begin Metabox Markup -->

  <p>
    <label for="<?php echo exmachina_settings_field_id( 'header_scripts' ); ?>"><?php printf( __( 'Insert scripts or code before the closing %s tag in the document source', 'exmachina-core' ), '<code>&lt;/head&gt;</code>' ); ?>:</label>
  </p>

  <textarea name="<?php echo exmachina_settings_field_name( 'header_scripts' ) ?>" id="<?php echo exmachina_settings_field_id( 'header_scripts' ); ?>" cols="78" rows="8"><?php echo exmachina_get_setting( 'header_scripts' ); ?></textarea>

  <p>
    <label for="<?php echo exmachina_settings_field_id( 'footer_scripts' ); ?>"><?php printf( __( 'Insert scripts or code before the closing %s tag in the document source', 'exmachina-core' ), '<code>&lt;/body&gt;</code>' ); ?>:</label>
  </p>

  <textarea name="<?php echo exmachina_settings_field_name( 'footer_scripts' ); ?>" id="<?php echo exmachina_settings_field_id( 'footer_scripts' ); ?>" cols="78" rows="8"><?php echo exmachina_get_setting( 'footer_scripts' ) ; ?></textarea>

  <!-- End Metabox Markup -->

<?php
} // end function exmachina_meta_box_theme_display_scripts()

/**
 * Scripts Theme Metabox Save
 *
 * Saves the "Header & Footer Scripts" metabox settings by filtering the
 * "sanitize_option_{$prefix}_theme_settings" hook.
 *
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 * @link http://codex.wordpress.org/Function_Reference/wp_filter_post_kses
 *
 * @since 2.6.0
 * @access public
 *
 * @param  array $settings Array of theme settings passed for validation.
 * @return array $settings
 */
function exmachina_meta_box_theme_save_scripts( $settings ) {

  if ( !isset( $_POST['reset'] ) ) {
    /* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
    if ( isset( $settings['footer_scripts'] ) && !current_user_can( 'unfiltered_html' ) )
      $settings['footer_scripts'] = stripslashes( wp_filter_post_kses( addslashes( $settings['footer_scripts'] ) ) );

    if ( isset( $settings['header_scripts'] ) && !current_user_can( 'unfiltered_html' ) )
      $settings['header_scripts'] = stripslashes( wp_filter_post_kses( addslashes( $settings['header_scripts'] ) ) );

  }

  /* Return the theme settings. */
  return $settings;

} // end function exmachina_meta_box_theme_save_scripts()

/**
 * Scripts Theme Metabox Help
 *
 * Displays the contextual help content associated with the "Header & Footer
 * Scripts" theme metabox.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_current_screen
 * @link http://codex.wordpress.org/Function_Reference/add_help_tab
 *
 * @uses exmachina_get_settings_page_name() Gets the theme settings page name.
 *
 * @since 2.6.0
 * @access public
 *
 * @return void
 */
function exmachina_theme_settings_scripts_help() {

  /* Gets the current screen. */
  $screen = get_current_screen();

  /* Sets up the contextual help content. */
  $scripts_help =
    '<h3>' . __( 'Header and Footer Scripts', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'This provides you with two fields that will output to the head section of your site and just before the closing body tag. These will appear on every page of the site and are a great way to add analytic code, Google Font and other scripts. You cannot use PHP in these fields.', 'exmachina-core' ) . '</p>';

  /* Adds the contextual help tab. */
  $screen->add_help_tab( array(
    'id'      => exmachina_get_settings_page_name() . '-scripts',
    'title'   => __( 'Header and Footer Scripts', 'exmachina-core' ),
    'content' => $scripts_help,
  ) );

} // end function exmachina_theme_settings_scripts_help()