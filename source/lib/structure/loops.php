<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Loop Structure
 *
 * loops.php
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

add_action( 'exmachina_loop', 'exmachina_do_loop' );

/**
 * Main Loop Function
 *
 * Attach a loop to the `exmachina_loop` output hook for front-end output.
 *
 * @todo eventually remove blog page loop
 * @todo check against hybrid loop
 * @todo check against jumpstart loop
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Function_Reference/is_page_template
 * @link http://codex.wordpress.org/Function_Reference/get_query_var
 * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
 *
 * @uses exmachina_get_option() [description]
 * @uses exmachina_get_custom_field() [description]
 * @uses exmachina_custom_loop() [description]
 * @uses exmachina_standard_loop() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_do_loop() {

  if ( is_page_template( 'page_blog.php' ) ) {
    $include = exmachina_get_option( 'blog_cat' );
    $exclude = exmachina_get_option( 'blog_cat_exclude' ) ? explode( ',', str_replace( ' ', '', exmachina_get_option( 'blog_cat_exclude' ) ) ) : '';
    $paged   = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

    //* Easter Egg
    $query_args = wp_parse_args(
      exmachina_get_custom_field( 'query_args' ),
      array(
        'cat'              => $include,
        'category__not_in' => $exclude,
        'showposts'        => exmachina_get_option( 'blog_cat_num' ),
        'paged'            => $paged,
      )
    );

    exmachina_custom_loop( $query_args );
  } else {
    exmachina_standard_loop();
  }

} // end function exmachina_do_loop()

/**
 * Standard Loop
 *
 * Standard loop, meant to be executed without modification in most circumstances
 * where content needs to be displayed. It outputs basic wrapping HTML, but uses
 * hooks to do most of its content output like title, content, post information
 * and comments.
 *
 * The action hooks called are:
 *
 *  - `exmachina_before_entry`
 *  - `exmachina_entry_header`
 *  - `exmachina_before_entry_content`
 *  - `exmachina_entry_content`
 *  - `exmachina_after_entry_content`
 *  - `exmachina_entry_footer`
 *  - `exmachina_after_endwhile`
 *  - `exmachina_loop_else` (only if no posts were found)
 *
 * @todo check against hybrid loop
 * @todo check against jumpstart loop
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/The_Loop
 * @link http://codex.wordpress.org/Function_Reference/have_posts
 * @link http://codex.wordpress.org/Function_Reference/the_post
 *
 * @uses exmachina_attr() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_standard_loop() {

  if ( have_posts() ) : while ( have_posts() ) : the_post();

      do_action( 'exmachina_before_entry' );

      printf( '<article %s>', exmachina_attr( 'entry' ) );

        do_action( 'exmachina_entry_header' );

        do_action( 'exmachina_before_entry_content' );
        printf( '<div %s>', exmachina_attr( 'entry-content' ) );
          do_action( 'exmachina_entry_content' );
        echo '</div>'; //* end .entry-content
        do_action( 'exmachina_after_entry_content' );

        do_action( 'exmachina_entry_footer' );

      echo '</article>';

      do_action( 'exmachina_after_entry' );

    endwhile; //* end of one post
    do_action( 'exmachina_after_endwhile' );

  else : //* if no posts exist
    do_action( 'exmachina_loop_else' );
  endif; //* end loop

} // end function exmachina_standard_loop()

/**
 * Custom Loop
 *
 * Custom loop, meant to be executed when a custom query is needed. It accepts
 * arguments in query_posts style format to modify the custom `WP_Query` object.
 *
 * It outputs basic wrapping HTML, but uses hooks to do most of its content output
 * like title, content, post information, and comments.
 *
 * The arguments can be passed in via the `exmachina_custom_loop_args` filter.
 *
 * The action hooks called are the same as exmachina_standard_loop().
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/The_Loop
 * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 * @link http://codex.wordpress.org/Function_Reference/wp_reset_query
 *
 * @uses exmachina_standard_loop() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object  $wp_query WP_Query query object.
 * @global integer $more
 * @param  array   $args     Loop arguments.
 * @return void
 */
function exmachina_custom_loop( $args = array() ) {
  global $wp_query, $more;

  $defaults = array(); //* For forward compatibility
  $args     = apply_filters( 'exmachina_custom_loop_args', wp_parse_args( $args, $defaults ), $args, $defaults );

  $wp_query = new WP_Query( $args );

  //* Only set $more to 0 if we're on an archive
  $more = is_singular() ? $more : 0;

  exmachina_standard_loop();

  //* Restore original query
  wp_reset_query();

} // end function exmachina_custom_loop()

/**
 * Grid Loop
 *
 * A specific implementation of a custom loop. Outputs markup compatible with a
 * Feature + Grid style layout. All normal loop hooks present, except for
 * `exmachina_post_content`.
 *
 * The arguments can be filtered by the `exmachina_grid_loop_args` filter.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/The_Loop
 * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/get_query_var
 *
 * @uses exmachina_standard_loop() [description]
 * @uses exmachina_reset_loops() [description]
 * @uses exmachina_grid_loop_post_class() [description]
 * @uses exmachina_grid_loop_content() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global array  $_exmachina_loop_args Associative array for grid loop configuration.
 * @param  array  $args                 Associative array for grid loop configuration.
 * @return void
 */
function exmachina_grid_loop( $args = array() ) {

  //* Global vars
  global $_exmachina_loop_args;

  //* Parse args
  $args = apply_filters(
    'exmachina_grid_loop_args',
    wp_parse_args(
      $args,
      array(
        'features'        => 2,
        'features_on_all'   => false,
        'feature_image_size'  => 0,
        'feature_image_class' => 'alignleft',
        'feature_content_limit' => 0,
        'grid_image_size'   => 'thumbnail',
        'grid_image_class'    => 'alignleft',
        'grid_content_limit'  => 0,
        'more'          => __( 'Read more', 'exmachina' ) . '&#x02026;',
      )
    )
  );

  //* If user chose more features than posts per page, adjust features
  if ( get_option( 'posts_per_page' ) < $args['features'] ) {
    $args['features'] = get_option( 'posts_per_page' );
  }

  //* What page are we on?
  $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

  //* Potentially remove features on page 2+
  if ( ! $args['features_on_all'] && $paged > 1 )
    $args['features'] = 0;

  //* Set global loop args
  $_exmachina_loop_args = $args;

  //* Remove some unnecessary stuff from the grid loop
  remove_action( 'exmachina_entry_header',  'exmachina_do_post_format_image', 4 );
  remove_action( 'exmachina_entry_content', 'exmachina_do_post_image', 8 );
  remove_action( 'exmachina_entry_content', 'exmachina_do_post_content' );
  remove_action( 'exmachina_entry_content', 'exmachina_do_post_content_nav', 12 );
  remove_action( 'exmachina_entry_content', 'exmachina_do_post_permalink', 14 );

  //* Custom loop output
  add_filter( 'post_class', 'exmachina_grid_loop_post_class' );
  add_action( 'exmachina_entry_content', 'exmachina_grid_loop_content' );

  //* The loop
  exmachina_standard_loop();

  //* Reset loops
  exmachina_reset_loops();
  remove_filter( 'post_class', 'exmachina_grid_loop_post_class' );
  remove_action( 'exmachina_entry_content', 'exmachina_grid_loop_content' );

} // end function exmachina_grid_loop()

/**
 * Grid Loop Post Class
 *
 * Filter the post classes to output custom classes for the feature and grid
 * layout. Based on the grid loop args and the loop counter.
 *
 * Applies the `exmachina_grid_loop_post_class` filter.
 *
 * @todo inline comment
 *
 * @since 0.5.0
 * @access public
 *
 * @global array  $_exmachina_loop_args Associative array for grid loop config.
 * @global object $wp_query             WP_Query query object.
 * @param  array  $classes              Existing post classes.
 * @return array                        Amended post classes.
 */
function exmachina_grid_loop_post_class( array $classes ) {
  global $_exmachina_loop_args, $wp_query;

  $grid_classes = array();

  if ( $_exmachina_loop_args['features'] && $wp_query->current_post < $_exmachina_loop_args['features'] ) {
    $grid_classes[] = 'exmachina-feature';
    $grid_classes[] = sprintf( 'exmachina-feature-%s', $wp_query->current_post + 1 );
    $grid_classes[] = $wp_query->current_post&1 ? 'exmachina-feature-even' : 'exmachina-feature-odd';
  }
  elseif ( $_exmachina_loop_args['features']&1 ) {
    $grid_classes[] = 'exmachina-grid';
    $grid_classes[] = sprintf( 'exmachina-grid-%s', $wp_query->current_post - $_exmachina_loop_args['features'] + 1 );
    $grid_classes[] = $wp_query->current_post&1 ? 'exmachina-grid-odd' : 'exmachina-grid-even';
  }
  else {
    $grid_classes[] = 'exmachina-grid';
    $grid_classes[] = sprintf( 'exmachina-grid-%s', $wp_query->current_post - $_exmachina_loop_args['features'] + 1 );
    $grid_classes[] = $wp_query->current_post&1 ? 'exmachina-grid-even' : 'exmachina-grid-odd';
  }

  return array_merge( $classes, apply_filters( 'exmachina_grid_loop_post_class', $grid_classes ) );

} // end function exmachina_grid_loop_post_class()

/**
 * Grid Loop Post Content
 *
 * Output specially formatted content, based on the grid loop args.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Function_Reference/get_post_class
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 * @link http://codex.wordpress.org/Function_Reference/the_title_attribute
 * @link http://codex.wordpress.org/Function_Reference/the_excerpt
 *
 * @uses exmachina_get_image() [description]
 * @uses exmachina_parse_attr() [description]
 * @uses the_content_limit() [description]
 * @uses the_content() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global array $_exmachina_loop_args Associative array for grid loop configuration.
 * @return void
 */
function exmachina_grid_loop_content() {
  global $_exmachina_loop_args;

  if ( in_array( 'exmachina-feature', get_post_class() ) ) {

    if ( $_exmachina_loop_args['feature_image_size'] ) {

      $image = exmachina_get_image( array(
        'size'    => $_exmachina_loop_args['feature_image_size'],
        'context' => 'grid-loop-featured',
        'attr'    => exmachina_parse_attr( 'entry-image-grid-loop', array( 'class' => $_exmachina_loop_args['feature_image_class'] ) ),
      ) );

      printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $image );

    }

    if ( $_exmachina_loop_args['feature_content_limit'] )
      the_content_limit( (int) $_exmachina_loop_args['feature_content_limit'], esc_html( $_exmachina_loop_args['more'] ) );
    else
      the_content( esc_html( $_exmachina_loop_args['more'] ) );

  }

  else {

    if ( $_exmachina_loop_args['grid_image_size'] ) {

      $image = exmachina_get_image( array(
        'size'    => $_exmachina_loop_args['grid_image_size'],
        'context' => 'grid-loop',
        'attr'    => exmachina_parse_attr( 'entry-image-grid-loop', array( 'class' => $_exmachina_loop_args['grid_image_class'] ) ),
      ) );

      printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $image );

    }

    if ( $_exmachina_loop_args['grid_content_limit'] ) {
      the_content_limit( (int) $_exmachina_loop_args['grid_content_limit'], esc_html( $_exmachina_loop_args['more'] ) );
    } else {
      the_excerpt();
      printf( '<a href="%s" class="more-link">%s</a>', get_permalink(), esc_html( $_exmachina_loop_args['more'] ) );
    }

  }

} // end function exmachina_grid_loop_content()

add_action( 'exmachina_after_entry', 'exmachina_add_id_to_global_exclude' );
/**
 * Global ID Exclude
 *
 * Modify the global $_exmachina_displayed_ids each time a loop iterates.
 *
 * Keep track of what posts have been shown on any given page by adding each ID
 * to a global array, which can be used any time by other loops to prevent posts
 * from being displayed twice on a page.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Function_Reference/get_the_ID
 *
 * @since 0.5.0
 * @access public
 *
 * @global array $_exmachina_displayed_ids Array of displayed post IDs.
 * @return void
 */
function exmachina_add_id_to_global_exclude() {
  global $_exmachina_displayed_ids;

  $_exmachina_displayed_ids[] = get_the_ID();

} // end function exmachina_add_id_to_global_exclude()