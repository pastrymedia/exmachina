<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Theme About Metabox
 *
 * metabox-theme-about.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Creates a meta box for the theme settings page, which displays information
 * about the theme. If a child theme is in use, an additional meta box will be
 * added with its information. To use this feature, the theme must support the
 * 'about' argument for 'exmachina-core-theme-settings' feature.
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

/* Create the about theme meta box on the 'add_meta_boxes' hook. */
add_action( 'add_meta_boxes', 'exmachina_meta_box_theme_add_about' );

/**
 * Add About Theme Metabox
 *
 * Adds the core about theme meta box to the theme settings page.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
 * @link http://codex.wordpress.org/Function_Reference/get_template
 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
 *
 * @uses exmachina_get_prefix()                   Gets the theme prefix.
 * @uses exmachina_meta_box_theme_display_about() About theme metabox display.
 * @uses exmachina_get_settings_page_name()       The theme settings page name.
 *
 * @since 2.6.0
 * @access public
 *
 * @return void
 */
function exmachina_meta_box_theme_add_about() {

  /* Get theme information. */
  $prefix = exmachina_get_prefix();
  $theme = wp_get_theme( get_template() );

  /* Adds the About box for the parent theme. */
  add_meta_box( 'exmachina-core-about-theme', sprintf( __( 'About %s', 'exmachina-core' ), $theme->get( 'Name' ) ), 'exmachina_meta_box_theme_display_about', exmachina_get_settings_page_name(), 'side', 'high' );

  /* If the user is using a child theme, add an About box for it. */
  if ( is_child_theme() ) {
    $child = wp_get_theme();
    add_meta_box( 'exmachina-core-about-child', sprintf( __( 'About %s', 'exmachina-core' ), $child->get( 'Name' ) ), 'exmachina_meta_box_theme_display_about', exmachina_get_settings_page_name(), 'side', 'high' );
  }

} // end function exmachina_meta_box_theme_add_about()

/**
 * About Theme Metabox Display
 *
 * Creates an information meta box with no settings about the theme. The meta
 * box will display information about both the parent theme and child theme. If
 * a child theme is active, this function will be called a second time.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
 * @link http://codex.wordpress.org/Function_Reference/get_template
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 *
 * @uses exmachina_get_prefix() Gets the theme prefix.
 *
 * @since 2.6.0
 * @access public
 *
 * @param  object $object Variable passed through the do_meta_boxes() call.
 * @param  array  $box    Specific information about the meta box being loaded.
 * @return void
 */
function exmachina_meta_box_theme_display_about( $object, $box ) {

  /* Get theme information. */
  $prefix = exmachina_get_prefix();

  /* Grab theme information for the parent/child theme. */
  $theme = ( 'exmachina-core-about-child' == $box['id'] ) ? wp_get_theme() : wp_get_theme( get_template() );
  ?>

  <!-- Begin Metabox Markup -->

  <table class="form-table">
    <tr>
      <th>
        <?php _e( 'Theme:', 'exmachina-core' ); ?>
      </th>
      <td>
        <a href="<?php echo esc_url( $theme->get( 'ThemeURI' ) ); ?>" title="<?php echo esc_attr( $theme->get( 'Name' ) ); ?>"><?php echo $theme->get( 'Name' ); ?></a>
      </td>
    </tr>
    <tr>
      <th>
        <?php _e( 'Version:', 'exmachina-core' ); ?>
      </th>
      <td>
        <?php echo $theme->get( 'Version' ); ?>
      </td>
    </tr>
    <tr>
      <th>
        <?php _e( 'Author:', 'exmachina-core' ); ?>
      </th>
      <td>
        <a href="<?php echo esc_url( $theme->get( 'AuthorURI' ) ); ?>" title="<?php echo esc_attr( $theme->get( 'Author' ) ); ?>"><?php echo $theme->get( 'Author' ); ?></a>
      </td>
    </tr>
    <tr>
      <th>
        <?php _e( 'Description:', 'exmachina-core' ); ?>
      </th>
      <td>
        <?php echo $theme->get( 'Description' ); ?>
      </td>
    </tr>
  </table><!-- .form-table -->

  <!-- End Metabox Markup -->

  <?php
} // end function exmachina_meta_box_theme_display_about()