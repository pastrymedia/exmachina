<?php
/*
Template Name: Landing
*/

// Add custom body class to the head
add_filter( 'body_class', 'add_body_class' );

function add_body_class( $classes ) {
   $classes[] = 'landing-page';
   return $classes;
}

// Force full-width page layout setting
add_filter( 'exmachina_pre_get_option_site_layout', '__exmachina_return_full_width_content' );

// Remove header, navigation, breadcrumbs, footer, footer widgets
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

exmachina();