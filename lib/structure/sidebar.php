<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Sidebar Structure
 *
 * sidebar.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
 *
 * @package     ExMachina
 * @subpackage  Structure
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin structure
###############################################################################

add_action( 'exmachina_sidebar', 'exmachina_do_sidebar' );

add_action( 'exmachina_sidebar_alt', 'exmachina_do_sidebar_alt' );

/**
 * Primary Sidebar Default Output
 *
 * Echo primary sidebar default content. Only shows if sidebar is empty, and
 * current user has the ability to edit theme options (manage widgets).
 *
 * @link http://codex.wordpress.org/Function_Reference/dynamic_sidebar
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 *
 * @uses exmachina_default_widget_area_content() Template for default widget are content.
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_do_sidebar() {

  /* If primary sidebar is empty and user can edit theme options. */
  if ( ! dynamic_sidebar( 'sidebar' ) && current_user_can( 'edit_theme_options' )  ) {

    /* Display default widget message. */
    exmachina_default_widget_area_content( __( 'Primary Sidebar Widget Area', 'exmachina' ) );

  } // end IF statement

} // end function exmachina_do_sidebar()


/**
 * Alternate Sidebar Default Output
 *
 * Echo alternate sidebar default content. Only shows if sidebar is empty, and
 * current user has the ability to edit theme options (manage widgets).
 *
 * @link http://codex.wordpress.org/Function_Reference/dynamic_sidebar
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 *
 * @uses exmachina_default_widget_area_content() Template for default widget are content.
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_do_sidebar_alt() {

  /* If secondary sidebar is empty and user can edit theme options. */
  if ( ! dynamic_sidebar( 'sidebar-alt' ) && current_user_can( 'edit_theme_options' ) ) {

    /* Display default widget message. */
    exmachina_default_widget_area_content( __( 'Secondary Sidebar Widget Area', 'exmachina' ) );

  } // end IF statement

} // end function exmachina_do_sidebar_alt()

/**
 * Default Widget Area Content
 *
 * Template for default widget area content.
 *
 * @todo inline comment
 * @todo docblock comment
 * @todo add for additional widget areas
 *
 * @link http://codex.wordpress.org/Function_Reference/esc_html
 * @link http://codex.wordpress.org/Function_Reference/admin_url
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string $name Name of the widget area.
 * @return void
 */
function exmachina_default_widget_area_content( $name ) {

  echo '<section class="widget widget_text">';
  echo '<div class="widget-wrap">';

    printf( '<h4 class="widgettitle">%s</h4>', esc_html( $name ) );
    echo '<div class="textwidget"><p>';

      printf( __( 'This is the %s. You can add content to this area by visiting your <a href="%s">Widgets Panel</a> and adding new widgets to this area.', 'exmachina' ), $name, admin_url( 'widgets.php' ) );

    echo '</p></div>';

  echo '</div>';
  echo '</section>';

} // end function exmachina_default_widget_area_content()