<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Theme Comments Metabox
 *
 * metabox-theme-comments.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Creates a meta box for the theme settings page, which customizes how comments
 * and trackbacks are displayed within the theme. To use this feature, the theme
 * must support the 'comments' argument for the 'exmachina-core-theme-settings'
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

/* Create the comments meta box on the 'add_meta_boxes' hook. */
add_action( 'add_meta_boxes', 'exmachina_meta_box_theme_add_comments' );

/* Sanitize the scripts settings before adding them to the database. */
add_filter( 'sanitize_option_' . exmachina_get_prefix() . '_theme_settings', 'exmachina_meta_box_theme_save_comments' );

/* Adds the help tabs to the theme settings page. */
add_action( 'add_help_tabs', 'exmachina_theme_settings_comments_help');

/**
 * Add Comments Metabox
 *
 * Adds the core "Comments" metabox to the theme settings page.
 *
 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
 *
 * @uses exmachina_meta_box_theme_display_comments()  Theme metabox display callback.
 * @uses exmachina_get_settings_page_name()           The theme settings page name.
 *
 * @since 2.6.0
 * @access public
 *
 * @return void
 */
function exmachina_meta_box_theme_add_comments() {

  /* Adds the Comments box for the theme. */
  add_meta_box( 'exmachina-core-comments', __( 'Comments and Trackbacks', 'exmachina-core' ), 'exmachina_meta_box_theme_display_comments', exmachina_get_settings_page_name(), 'normal', 'high' );

} // end exmachina_meta_box_theme_add_comments()

/**
 * Comments and Trackbacks Theme Metabox Display
 *
 * Creates a metabox that allows users to customize whether comments or trackbacks
 * are displayed on the posts or pages.
 *
 * @link http://codex.wordpress.org/Function_Reference/checked
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
function exmachina_meta_box_theme_display_comments() {
  ?>

  <!-- Begin Metabox Markup -->

  <p>
    <?php _e( 'Enable Comments', 'exmachina-core' ); ?>
    <label for="<?php echo exmachina_settings_field_id( 'comments_posts' ); ?>" title="Enable comments on posts"><input type="checkbox" name="<?php echo exmachina_settings_field_name( 'comments_posts' ); ?>" id="<?php echo exmachina_settings_field_id( 'comments_posts' ); ?>" value="1"<?php checked( exmachina_get_setting( 'comments_posts' ) ); ?> />
    <?php _e( 'on posts?', 'exmachina-core' ); ?></label>

    <label for="<?php echo exmachina_settings_field_id( 'comments_pages' ); ?>" title="Enable comments on pages"><input type="checkbox" name="<?php echo exmachina_settings_field_name( 'comments_pages' ); ?>" id="<?php echo exmachina_settings_field_id( 'comments_pages' ); ?>" value="1"<?php checked( exmachina_get_setting( 'comments_pages' ) ); ?> />
    <?php _e( 'on pages?', 'exmachina-core' ); ?></label>
  </p>

  <p>
    <?php _e( 'Enable Trackbacks', 'exmachina-core' ); ?>
    <label for="<?php echo exmachina_settings_field_id( 'trackbacks_posts' ); ?>" title="Enable trackbacks on posts"><input type="checkbox" name="<?php echo exmachina_settings_field_name( 'trackbacks_posts' ); ?>" id="<?php echo exmachina_settings_field_id( 'trackbacks_posts' ); ?>" value="1"<?php checked( exmachina_get_setting( 'trackbacks_posts' ) ); ?> />
    <?php _e( 'on posts?', 'exmachina-core' ); ?></label>

    <label for="<?php echo exmachina_settings_field_id( 'trackbacks_pages' ); ?>" title="Enable trackbacks on pages"><input type="checkbox" name="<?php echo exmachina_settings_field_name( 'trackbacks_pages' ); ?>" id="<?php echo exmachina_settings_field_id( 'trackbacks_pages' ); ?>" value="1"<?php checked( exmachina_get_setting( 'trackbacks_pages' ) ); ?> />
    <?php _e( 'on pages?', 'exmachina-core' ); ?></label>
  </p>

  <p><span class="description"><?php _e( 'Comments and Trackbacks can also be disabled on a per post/page basis when creating/editing posts/pages.', 'exmachina-core' ); ?></span></p>

  <!-- End Metabox Markup -->

  <?php
} // end function exmachina_meta_box_theme_display_comments()

/**
 * Comments Theme Metabox Save
 *
 * Saves the "Comments & Trackbacks" metabox settings by filtering the
 * "sanitize_option_{$prefix}_theme_settings" hook.
 *
 * @link http://codex.wordpress.org/Function_Reference/absint
 *
 * @since 2.6.0
 * @access public
 *
 * @param  array $settings Array of theme settings passed for validation.
 * @return array $settings
 */
function exmachina_meta_box_theme_save_comments( $settings ) {

  if ( !isset( $_POST['reset'] ) ) {
    $settings['comments_posts'] =  absint( $settings['comments_posts'] );
    $settings['trackbacks_posts'] =  absint( $settings['trackbacks_posts'] );
    $settings['comments_pages'] =  absint( $settings['comments_pages'] );
    $settings['trackbacks_pages'] =  absint( $settings['trackbacks_pages'] );
  }

  /* Return the theme settings. */
  return $settings;

} // end function exmachina_meta_box_theme_save_comments()

/**
 * Comments Theme Metabox Help
 *
 * Displays the contextual help content associated with the "Comment & Trackbacks"
 * theme metabox.
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
function exmachina_theme_settings_comments_help() {

  /* Gets the current screen. */
  $screen = get_current_screen();

  /* Sets up the contextual help content. */
  $comments_help =
    '<h3>' . __( 'Comments and Trackbacks', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'This allows a site wide decision on whether comments and trackbacks (notifications when someone links to your page) are enabled for posts and pages.', 'exmachina-core' ) . '</p>' .
    '<p>'  . __( 'If you enable comments or trackbacks here, it can be disabled on an individual post or page. If you disable here, they cannot be enabled on an individual post or page.', 'exmachina-core' ) . '</p>';

  /* Adds the contextual help tab. */
  $screen->add_help_tab( array(
    'id'      => exmachina_get_settings_page_name() . '-comments',
    'title'   => __( 'Comments and Trackbacks', 'exmachina-core' ),
    'content' => $comments_help,
  ) );

} // end function exmachina_theme_settings_comments_help()


