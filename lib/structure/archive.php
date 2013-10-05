<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Archive Structure
 *
 * archive.php
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

add_filter( 'exmachina_term_intro_text_output', 'wpautop' );
add_action( 'exmachina_before_loop', 'exmachina_do_taxonomy_title_description', 15 );
/**
 * Taxonomy Title Description
 *
 * Adds a custom headline and/or description to the category/tag/taxonomy archive
 * pages. If the page is not a category, tag or taxonomy term archive, or we're
 * not on the first page, or there's no term, or no term meta set, then nothing
 * extra is displayed. If there's a title to display, it is marked up as a level
 * 1 heading. If there's a description to display, it runs through `wpautop()`
 * before being added to a div.
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $wp_query The WP_Query query object.
 * @return null             Return early if not on an archive page.
 */
function exmachina_do_taxonomy_title_description() {
  global $wp_query;

  if ( ! is_category() && ! is_tag() && ! is_tax() )
    return;

  if ( get_query_var( 'paged' ) >= 2 )
    return;

  $term = is_tax() ? get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : $wp_query->get_queried_object();

  if ( ! $term || ! isset( $term->meta ) )
    return;

  $headline = $intro_text = '';

  if ( $term->meta['headline'] )
    $headline = sprintf( '<h1 class="archive-title">%s</h1>', strip_tags( $term->meta['headline'] ) );
  if ( $term->meta['intro_text'] )
    $intro_text = apply_filters( 'exmachina_term_intro_text_output', $term->meta['intro_text'] );

  if ( $headline || $intro_text )
    printf( '<div class="archive-description taxonomy-description">%s</div>', $headline . $intro_text );
} // end function exmachina_do_taxonomy_title_description()

add_filter( 'exmachina_author_intro_text_output', 'wpautop' );
add_action( 'exmachina_before_loop', 'exmachina_do_author_title_description', 15 );
/**
 * Author Title Description
 *
 * Add custom headline and description to author archive pages. If we're not on
 * an author archive page, or not on page 1, then nothing extra is displayed. If
 * there's a custom headline to display, it is marked up as a level 1 heading. If
 * there's a description (intro text) to display, it is run through `wpautop()`
 * before being added to a div.
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return early if not author archive or not page one.
 */
function exmachina_do_author_title_description() {

  if ( ! is_author() )
    return;

  if ( get_query_var( 'paged' ) >= 2 )
    return;

  $headline   = get_the_author_meta( 'headline', (int) get_query_var( 'author' ) );
  $intro_text = get_the_author_meta( 'intro_text', (int) get_query_var( 'author' ) );

  $headline   = $headline ? sprintf( '<h1 class="archive-title">%s</h1>', strip_tags( $headline ) ) : '';
  $intro_text = $intro_text ? apply_filters( 'exmachina_author_intro_text_output', $intro_text ) : '';

  if ( $headline || $intro_text )
    printf( '<div class="archive-description author-description">%s</div>', $headline . $intro_text );
} // end function do_author_title_description()

add_action( 'exmachina_before_loop', 'exmachina_do_author_box_archive', 15 );
/**
 * Author Box Archive
 *
 * Add author box to the top of author archive. If the headline and description
 * are set to display the author box appears underneath them.
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return early if not author archive or not page one.
 */
function exmachina_do_author_box_archive() {

  if ( ! is_author() || get_query_var( 'paged' ) >= 2 )
    return;

  if ( get_the_author_meta( 'exmachina_author_box_archive', get_query_var( 'author' ) ) )
    exmachina_author_box( 'archive' );

} // end function exmachina_do_author_box_archive()

add_filter( 'exmachina_cpt_archive_intro_text_output', 'wpautop' );
add_action( 'exmachina_before_loop', 'exmachina_do_cpt_archive_title_description' );
/**
 * Custom Post Type Archive Title Description
 *
 * Add custom headline and description to relevant custom post type archive
 * pages. If we're not on a post type archive page, or not on page 1, then
 * nothing extra is displayed. If there's a custom headline to display, it is
 * marked up as a level 1 heading. If there's a description (intro text) to
 * display, it is run through wpautop() before being added to a div.
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return early if not on relevant post type archive.
 */
function exmachina_do_cpt_archive_title_description() {

  if ( ! is_post_type_archive() || ! exmachina_has_post_type_archive_support() )
    return;

  if ( get_query_var( 'paged' ) >= 2 )
    return;

  $headline   = exmachina_get_cpt_option( 'headline' );
  $intro_text = exmachina_get_cpt_option( 'intro_text' );

  $headline   = $headline ? sprintf( '<h1 class="archive-title">%s</h1>', $headline ) : '';
  $intro_text = $intro_text ? apply_filters( 'exmachina_cpt_archive_intro_text_output', $intro_text ) : '';

  if ( $headline || $intro_text )
    printf( '<div class="archive-description cpt-archive-description">%s</div>', $headline . $intro_text );
} // end function exmachina_do_cpt_archive_title_description()

