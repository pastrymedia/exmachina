<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * 404 (Not Found) display
 * 404.php
 *
 * @todo bring in widget functionality
 *
 * Template file used to render a Server 404 error page.
 * @link http://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */

/* Remove the default loop. */
remove_action( 'exmachina_loop', 'exmachina_do_loop' );

/* Add the custom 404 loop. */
add_action( 'exmachina_loop', 'exmachina_404' );

/**
 * 404 Page Loop
 *
 * Generates the custom error message displayed on the 404 "Not Found" page.
 *
 * @since 0.5.0
 * @access public
 */
function exmachina_404() {

  /* Gets the title and content. */
  $title = esc_attr( exmachina_get_content_option( '404_title' ) );
  $content = exmachina_get_content_option( '404_content' );

  echo '<article class="page type-page status-publish entry" itemscope="" itemtype="http://schema.org/CreativeWork">';

  if( !empty( $title ) ) :
      echo '<header class="entry-header"><h1 class="entry-title" itemprop="headline">' . $title . '</h1></header>';
    else :
      printf( '<h1 class="entry-title">%s</h1>', __( 'Not found, error 404', 'exmachina' ) );
    endif;

  do_action( 'exmachina_404_before_content' );

  echo '<div class="entry-content">';

  if( !empty( $content ) ) :

    echo apply_filters( 'the_content', $content ) ;

  else :

    echo '<p>' . sprintf( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.', 'exmachina' ), home_url() ) . '</p>';

    echo '<p>' . get_search_form() . '</p>';

  endif;

  echo '</div>';

  do_action( 'exmachina_404_after_content' );

  echo '</article>';

} // end function exmachina_404()

exmachina();