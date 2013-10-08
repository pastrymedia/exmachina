<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Footer Structure
 *
 * footer.php
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

/* Adds the footer widget areas to the before footer hook. */
add_action( 'exmachina_before_footer', 'exmachina_footer_widget_areas' );

/* Adds footer markup to the footer hook. */
add_action( 'exmachina_footer', 'exmachina_footer_markup_open', 5 );
add_action( 'exmachina_footer', 'exmachina_footer_markup_close', 15 );

/* Adds footer markup to footer hook and allows shortcodes. */
add_filter( 'exmachina_footer_output', 'do_shortcode', 20 );
add_action( 'exmachina_footer', 'exmachina_do_footer' );

/* Adds footer scripts to wp_footer and allows shortcodes. */
add_filter( 'exmachina_footer_scripts', 'do_shortcode' );
add_action( 'wp_footer', 'exmachina_footer_scripts' );

/**
 * Footer Widget Areas
 *
 * Echos the markup to display footer widget areas. Checks that a numerical param
 * is added for theme to support to display the correct markup. Applies the
 * 'exmachina_footer_widget_areas' filter.
 *
 * @todo remove xhtml ref
 * @todo inline comment function
 *
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/is_active_sidebar
 * @link http://codex.wordpress.org/Function_Reference/dynamic_sidebar
 *
 * @uses exmachina_markup() [description]
 * @uses exmachina_structural_wrap() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Returns early if widget number not defined or footer widgets empty.
 */
function exmachina_footer_widget_areas() {

  $footer_widgets = get_theme_support( 'exmachina-footer-widgets' );

  if ( ! $footer_widgets || ! isset( $footer_widgets[0] ) || ! is_numeric( $footer_widgets[0] ) )
    return;

  $footer_widgets = (int) $footer_widgets[0];

  //* Check to see if first widget area has widgets. If not, do nothing. No need to check all footer widget areas.
  if ( ! is_active_sidebar( 'footer-1' ) )
    return;

  $inside  = '';
  $output  = '';
  $counter = 1;

  while ( $counter <= $footer_widgets ) {

    //* Darn you, WordPress! Gotta output buffer.
    ob_start();
    dynamic_sidebar( 'footer-' . $counter );
    $widgets = ob_get_clean();

    $inside .= sprintf( '<div class="footer-widgets-%d widget-area">%s</div>', $counter, $widgets );

    $counter++;

  }

  if ( $inside ) {

    $output .= exmachina_markup( array(
      'html5'   => '<div %s>',
      'xhtml'   => '<div id="footer-widgets" class="footer-widgets">',
      'context' => 'footer-widgets',
    ) );

    $output .= exmachina_structural_wrap( 'footer-widgets', 'open', 0 );

    $output .= $inside;

    $output .= exmachina_structural_wrap( 'footer-widgets', 'close', 0 );

    $output .= '</div>';

  }

  echo apply_filters( 'exmachina_footer_widget_areas', $output, $footer_widgets );

} // end function exmachina_footer_widget_areas()

/**
 * Footer Markup Open
 *
 * Echoes the opening footer tag and optionally opens the structural wrap.
 *
 * @todo remove xhtml markup option
 *
 * @uses exmachina_structural_wrap() [description]
 * @uses exmachina_markup() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_footer_markup_open() {

  exmachina_markup( array(
    'html5'   => '<footer %s>',
    'xhtml'   => '<div id="footer" class="footer">',
    'context' => 'site-footer',
  ) );
  exmachina_structural_wrap( 'footer', 'open' );

} // end function exmachina_footer_markup_open()

/**
 * Footer Markup Close
 *
 * Echos the closing footer tag and optionally closes the structual wrap.
 *
 * @todo remove xhtml markup option
 *
 * @uses exmachina_structural_wrap() [description]
 * @uses exmachina_markup() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_footer_markup_close() {

  exmachina_structural_wrap( 'footer', 'close' );
  exmachina_markup( array(
    'html5'   => '</footer>',
    'xhtml'   => '</div>',
  ) );

} // end function exmachina_footer_markup_close()

/**
 * Footer Main Output
 *
 * Echos the contents of the footer taken from the 'footer_insert' theme option.
 * Executes any shortcodes that might be present and applies the footer content
 * filters.
 *
 * @todo maybe add conditional so output doesn't generate if empty
 * @todo create default footer function based n hybrid
 * @todo split out paragraph tags
 *
 * @uses exmachina_get_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_do_footer() {

  /* Gets the footer text from the theme options db. */
  $footer_text = wpautop( exmachina_get_option( 'footer_insert' ) );

  /* Applies the filter to the text strings. */
  $footer_text = apply_filters( 'exmachina_footer_text', $footer_text );

  /* Wraps the output in <p> tags. */
  $output = '<p>' . $footer_text . '</p>';

  /* Applies the output filter and echoes the output. */
  echo apply_filters( 'exmachina_footer_output', $output, $footer_text );

} // end function exmachina_do_footer()

/**
 * Footer Scripts
 *
 * Echoes the footer scripts that are defines on the theme settings page. Applies
 * the 'exmachina_footer_scripts' filter to the value returned.
 *
 * @uses exmachina_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_footer_scripts() {

  /* Echo the footer scripts option. */
  echo apply_filters( 'exmachina_footer_scripts', exmachina_option( 'footer_scripts' ) );

} // end function exmachina_footer_scripts()