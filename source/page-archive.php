<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Archive Page Template
 * page-archive.php
 *
 * @todo bring back actual markup
 *
 * Template for displaying the archive page loop.
 * @link http://codex.wordpress.org/Page_Templates
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */

//* Template Name: Archive

/* Remove the standard post content output. */
remove_action( 'exmachina_entry_content', 'exmachina_do_post_content' );

/* Add the  custom archive content output. */
add_action( 'exmachina_entry_content', 'exmachina_page_archive_content' );

/**
 * Archive Page Template Content
 *
 * Outputs the sitemap-esque archive content display that includes all pages,
 * categories, authors, monthly archives, and recent posts.
 *
 * @since 0.5.0
 * @access public
 */
function exmachina_page_archive_content() {
  ?>
  <h4><?php _e( 'Pages:', 'exmachina' ); ?></h4>
  <ul>
    <?php wp_list_pages( 'title_li=' ); ?>
  </ul>

  <h4><?php _e( 'Categories:', 'exmachina' ); ?></h4>
  <ul>
    <?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
  </ul>

  <h4><?php _e( 'Authors:', 'exmachina' ); ?></h4>
  <ul>
    <?php wp_list_authors( 'exclude_admin=0&optioncount=1' ); ?>
  </ul>

  <h4><?php _e( 'Monthly:', 'exmachina' ); ?></h4>
  <ul>
    <?php wp_get_archives( 'type=monthly' ); ?>
  </ul>

  <h4><?php _e( 'Recent Posts:', 'exmachina' ); ?></h4>
  <ul>
    <?php wp_get_archives( 'type=postbypost&limit=100' ); ?>
  </ul>
  <?php
} // end function exmachina_page_archive_content()

exmachina();