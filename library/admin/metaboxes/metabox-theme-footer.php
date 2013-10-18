<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Theme Footer Metabox
 *
 * metabox-theme-footer.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Creates a meta box for the theme settings page, which holds a textarea for
 * custom footer text within the theme. To use this feature, the theme must
 * support the 'footer' argument for the 'exmachina-core-theme-settings'
 * feature.
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

/* Create the footer meta box on the 'add_meta_boxes' hook. */
add_action( 'add_meta_boxes', 'exmachina_meta_box_theme_add_footer' );

/* Sanitize the footer settings before adding them to the database. */
add_filter( 'sanitize_option_' . exmachina_get_prefix() . '_theme_settings', 'exmachina_meta_box_theme_save_footer' );

/**
 * Add Footer Metabox
 *
 * Adds the core "Footer Settings" metabox to the theme settings page.
 *
 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
 *
 * @uses exmachina_meta_box_theme_display_footer() Theme metabox display callback.
 * @uses exmachina_get_settings_page_name()        The theme settings page name.
 *
 * @since 2.6.0
 * @access public
 *
 * @return void
 */
function exmachina_meta_box_theme_add_footer() {

  add_meta_box( 'exmachina-core-footer', __( 'Footer settings', 'exmachina-core' ), 'exmachina_meta_box_theme_display_footer', exmachina_get_settings_page_name(), 'normal', 'high' );

} // end function exmachina_meta_box_theme_add_footer()

/**
 * Footer Settings Theme Metabox Display
 *
 * Creates a meta box that allows users to customize their footer.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_editor
 * @link http://codex.wordpress.org/Function_Reference/esc_textarea
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
function exmachina_meta_box_theme_display_footer() {

  /* Add a textarea using the wp_editor() function to make it easier on users to add custom content. */
  wp_editor(
    esc_textarea( exmachina_get_setting( 'footer_insert' ) ), // Editor content.
    exmachina_settings_field_id( 'footer_insert' ),   // Editor ID.
    array(
      'tinymce' =>    false, // Don't use TinyMCE in a meta box.
      'textarea_name' =>  exmachina_settings_field_name( 'footer_insert' )
    )
  );

  ?>

  <p>
    <span class="description"><?php _e( 'You can add custom <acronym title="Hypertext Markup Language">HTML</acronym> and/or shortcodes, which will be automatically inserted into your theme.', 'exmachina-core' ); ?></span>
  </p>

  <?php
} // end function exmachina_meta_box_theme_display_footer()

/**
 * Footer Settings Theme Metabox Save
 *
 * Saves the "Footer Settings" metabox settings by filtering the
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
function exmachina_meta_box_theme_save_footer( $settings ) {

  /* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
  if ( isset( $settings['footer_insert'] ) && !current_user_can( 'unfiltered_html' ) )
    $settings['footer_insert'] = stripslashes( wp_filter_post_kses( addslashes( $settings['footer_insert'] ) ) );

  /* Return the theme settings. */
  return $settings;

} // end function exmachina_meta_box_theme_save_footer()