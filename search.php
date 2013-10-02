<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Search Result display
 * search.php
 *
 * @todo bring in actual markup
 *
 * Template file used to render a Search Results Index page
 * @link http://codex.wordpress.org/Creating_a_Search_Page
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */

/* Add the search title before the loop. */
add_action( 'exmachina_before_loop', 'exmachina_do_search_title' );

/**
 * Do Search Title
 *
 * Echo the search title with the search term and added before the search results.
 * The output can be filtered via 'exmachina_search_title_output' and the title
 * itself can be filtered via 'exmachina_search_title_text'.
 *
 * @since 0.5.0
 * @access public
 */
function exmachina_do_search_title() {

  /* Set the search title variable. */
  $title = sprintf( '<div class="archive-description"><h1 class="archive-title">%s %s</h1></div>', apply_filters( 'exmachina_search_title_text', __( 'Search Results for:', 'exmachina' ) ), get_search_query() );

  /* Apply the filters and echo. */
  echo apply_filters( 'exmachina_search_title_output', $title ) . "\n";

} // end function exmachina_do_search_title()

exmachina();