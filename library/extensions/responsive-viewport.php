<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * EXTENSION
 *
 * EXTENSIONPHP
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * DESCRIPTION
 *
 * @package     ExMachina
 * @subpackage  Extensions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin extension
###############################################################################


/* add meta viewport for responsive layout */
function exmachina_responsive_viewport () {
	echo '<meta name="viewport" content="width=device-width">';
}

add_action('wp_head', 'exmachina_responsive_viewport', 1 );

/* Wrap embeds with some custom HTML to handle responsive layout. */
  add_filter( 'embed_handler_html', 'exmachina_embed_responsive_html' );
  add_filter( 'embed_oembed_html',  'exmachina_embed_responsive_html' );

/**
 * Wraps embeds with <div class="embed-wrap"> to help in making videos responsive.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function exmachina_embed_responsive_html( $html ) {

  if ( in_the_loop() && has_post_format( 'video' ) && preg_match( '/(<embed|object|iframe)/', $html ) )
    $html = '<div class="embed-wrap">' . $html . '</div>';

  return $html;
}

?>