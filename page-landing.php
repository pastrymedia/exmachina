<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Landing Page Template
 * page-landing.php
 *
 * @todo test that all markup is removed
 * @todo add landing page CSS
 *
 * Template for displaying a landing page.
 * @link http://codex.wordpress.org/Page_Templates
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */

//* Template Name: Landing

/* Add custom landing page body class to the template. */
add_filter( 'body_class', 'add_landing_body_class' );

/**
 * Add Landing Body Class
 *
 * Adds the 'landing-page' body class to the body class array for landing
 * page templates.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array $classes Array of custom body classes.
 * @return array          Returns the modified body class array.
 */
function add_landing_body_class( $classes ) {

  $classes[] = 'landing-page';
  return $classes;

} // end function add_landing_body_class()

/* Force full-width page layout setting. */
add_filter( 'exmachina_pre_get_option_site_layout', '__exmachina_return_full_width_content' );

/* Remove the header, navigation, breadcrumbs, footer, and footer widgets. */
remove_action( 'exmachina_header', 'exmachina_header_markup_open', 5 );
remove_action( 'exmachina_header', 'exmachina_do_header' );
remove_action( 'exmachina_header', 'exmachina_header_markup_close', 15 );
remove_action( 'exmachina_before_header', 'exmachina_do_nav' );
remove_action( 'exmachina_after_header', 'exmachina_do_subnav' );
remove_action( 'exmachina_before_loop', 'exmachina_do_breadcrumbs' );
remove_action( 'exmachina_after', 'exmachina_footer_markup_open', 5 );
remove_action( 'exmachina_after', 'exmachina_do_footer' );
remove_action( 'exmachina_after', 'exmachina_footer_markup_close', 15 );
remove_action( 'exmachina_before_footer', 'exmachina_footer_widget_areas' );

/* Call the main content function. */
exmachina();