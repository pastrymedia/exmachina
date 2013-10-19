<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Post
 *
 * post.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * DESCRIPTION
 *
 * @package     ExMachina
 * @subpackage  Structure
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/* Add the title, byline, and entry meta before and after the entry.*/
add_action( exmachina_get_prefix() . '_before_entry', 'exmachina_entry_header' );
add_action( exmachina_get_prefix() . '_entry', 'exmachina_entry' );
add_action( exmachina_get_prefix() . '_singular_entry', 'exmachina_singular_entry' );
add_action( exmachina_get_prefix() . '_after_entry', 'exmachina_entry_footer' );
add_action( exmachina_get_prefix() . '_singular-page_after_entry', 'exmachina_page_entry_meta' );

add_filter('excerpt_more', 'exmachina_excerpt_more');

/**
 * Display the default entry header.
 */
function exmachina_entry_header() {

  echo '<header class="entry-header">';

  if ( is_home() || is_archive() || is_search() ) {
  ?>
    <h1 class="entry-title" itemprop="headline"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
  <?php
  } else {
  ?>
    <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
  <?php
  }
  if ( 'post' == get_post_type() ) :
    get_template_part( 'partials/entry', 'byline' );
  endif;
  echo '</header><!-- .entry-header -->';

}

/**
 * Display the default entry metadata.
 */
function exmachina_entry() {

  if ( is_home() || is_archive() || is_search() ) {
    if(exmachina_get_setting( 'content_archive_thumbnail' )) {
      get_the_image( array( 'meta_key' => 'Thumbnail', 'default_size' => exmachina_get_setting( 'image_size' ) ) );
    }


    if ( 'excerpts' === exmachina_get_setting( 'content_archive' ) ) {
      if ( exmachina_get_setting( 'content_archive_limit' ) )
        the_content_limit( (int) exmachina_get_setting( 'content_archive_limit' ), exmachina_get_setting( 'content_archive_more' ) );
      else
        the_excerpt();
    }
    else {
      the_content( exmachina_get_setting( 'content_archive_more' ) );
    }
  }

}

/**
 * Display the default singular entry metadata.
 */
function exmachina_singular_entry() {

  the_content();

  wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'exmachina-core' ) . '</span>', 'after' => '</p>' ) );

}

/**
 * Display the default entry footer.
 */
function exmachina_entry_footer() {

  if ( 'post' == get_post_type() ) {
    get_template_part( 'partials/entry', 'footer' );
  }

}

/**
 * Display the default page edit link
 */
function exmachina_page_entry_meta() {

  echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">[entry-edit-link]</div>' );
}


function exmachina_excerpt_more( $more ) {
  return ' ... <a class="more-link" href="'. get_permalink( get_the_ID() ) . '">' . exmachina_get_setting( 'content_archive_more' ) . '</a>';
}

/**
 * Display navigation to next/previous pages when applicable
 */
function exmachina_content_nav( $nav_id ) {
  global $wp_query, $post;

  // Don't print empty markup on single pages if there's nowhere to navigate.
  if ( is_single() ) {
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
      return;
  }

  // Don't print empty markup in archives if there's only one page.
  if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
    return;

  $nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

  ?>
  <nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="navigation row  <?php echo $nav_class; ?>">

  <?php if ( is_single() && !exmachina_get_setting( 'single_nav' ) ) : // navigation links for single posts ?>

    <?php previous_post_link( '<div class="nav-previous alignleft">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'exmachina-core' ) . '</span> %title' ); ?>
    <?php next_post_link( '<div class="nav-next alignright">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'exmachina-core' ) . '</span>' ); ?>

  <?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

    <?php
    if (current_theme_supports( 'loop-pagination' ) && ( 'numeric' == exmachina_get_setting( 'posts_nav' ) ) ) {
      loop_pagination();
    } else {
      if ( get_next_posts_link() ) : ?>
      <div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Previous Page', 'exmachina-core' )); ?></div>
      <?php endif; ?>

      <?php if ( get_previous_posts_link() ) : ?>
      <div class="nav-next alignright"><?php previous_posts_link( __( 'Next Page <span class="meta-nav">&rarr;</span>', 'exmachina-core' )); ?></div>
      <?php endif;
    }
    ?>

  <?php endif; ?>

  </nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
  <?php
}

