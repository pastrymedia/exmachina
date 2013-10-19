<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Header
 *
 * header.php
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

add_action( 'wp_head', 'exmachina_conditional_styles' );
/**
 * Insert conditional script / style for the theme used sitewide.
 *
 */
function exmachina_conditional_styles() {

  echo '<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->' . "\n";

}

/* Add respond.js and  html5shiv.js for unsupported browsers. */
add_action( 'wp_head', 'exmachina_respond_html5shiv' );
/**
 * Function for help to unsupported browsers understand mediaqueries and html5.
 * This is added in 'head' using 'wp_head' hook.
 *
 * @link: https://github.com/scottjehl/Respond
 * @link: http://code.google.com/p/html5shiv/
 * @since 0.1.0
 */
function exmachina_respond_html5shiv() {
  ?><!-- Enables media queries and html5 in some unsupported browsers. -->
  <!--[if (lt IE 9) & (!IEMobile)]>
  <script type="text/javascript" src="<?php echo trailingslashit( EXMACHINA_JS ) . 'respond.min.js' ; ?>"></script>
  <script type="text/javascript" src="<?php echo trailingslashit( EXMACHINA_JS ) . 'html5shiv.min.js' ; ?>"></script>
  <![endif]-->
<?php
}


add_action( 'wp_head', 'exmachina_custom_header_scripts' );
/**
 * Echo header scripts in to wp_head().
 */
function exmachina_custom_header_scripts() {

  echo exmachina_get_setting( 'header_scripts' );

}

/* Header actions. */
add_action( exmachina_get_prefix() . '_header', 'exmachina_header_branding' );
/**
 * Dynamic element to wrap the site title and site description.
 */
function exmachina_header_branding() {

  echo '<div class="title-area">';

  /* Get the site title.  If it's not empty, wrap it with the appropriate HTML. */
  if ( $title = get_bloginfo( 'name' ) ) {
    if ( $logo = get_theme_mod( 'custom_logo' ) )
      $title = sprintf( '<h1 class="site-title"><a href="%1$s" title="%2$s" rel="home"><span><img src="%3$s"/></span></a></h1>', home_url(), esc_attr( $title ), $logo );
    else
      $title = sprintf( '<h1 class="site-title"><a href="%1$s" title="%2$s" rel="home"><span>%3$s</span></a></h1>', home_url(), esc_attr( $title ), $title );
  }

  /* Display the site title and apply filters for developers to overwrite. */
  echo apply_atomic( 'site_title', $title );

  /* Get the site description.  If it's not empty, wrap it with the appropriate HTML. */
  if ( $desc = get_bloginfo( 'description' ) )
    $desc = sprintf( '<h2 class="site-description"><span>%1$s</span></h2>', $desc );

  /* Display the site description and apply filters for developers to overwrite. */
  echo apply_atomic( 'site_description', $desc );

  echo '</div>';
}

/**
 * Function for handling what the browser/search engine title should be. Attempts to handle every
 * possible situation WordPress throws at it for the best optimization.
 *
 * @since 0.1.0
 * @access public
 * @global $wp_query
 * @return void
 */
function exmachina_document_title() {
  global $wp_query;

  /* Set up some default variables. */
  $doctitle = '';
  $separator = ':';

  /* If viewing the front page and posts page of the site. */
  if ( is_front_page() && is_home() )
    $doctitle = get_bloginfo( 'name' ) . $separator . ' ' . get_bloginfo( 'description' );

  /* If viewing the posts page or a singular post. */
  elseif ( is_home() || is_singular() ) {

    $doctitle = get_post_meta( get_queried_object_id(), 'Title', true );

    if ( empty( $doctitle ) && is_front_page() )
      $doctitle = get_bloginfo( 'name' ) . $separator . ' ' . get_bloginfo( 'description' );

    elseif ( empty( $doctitle ) )
      $doctitle = single_post_title( '', false );
  }

  /* If viewing any type of archive page. */
  elseif ( is_archive() ) {

    /* If viewing a taxonomy term archive. */
    if ( is_category() || is_tag() || is_tax() ) {
      $doctitle = single_term_title( '', false );
    }

    /* If viewing a post type archive. */
    elseif ( is_post_type_archive() ) {
      $doctitle = post_type_archive_title( '', false );
    }

    /* If viewing an author/user archive. */
    elseif ( is_author() ) {
      $doctitle = get_user_meta( get_query_var( 'author' ), 'Title', true );

      if ( empty( $doctitle ) )
        $doctitle = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
    }

    /* If viewing a date-/time-based archive. */
    elseif ( is_date () ) {
      if ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
        $doctitle = sprintf( __( 'Archive for %s', 'exmachina-core' ), get_the_time( __( 'g:i a', 'exmachina-core' ) ) );

      elseif ( get_query_var( 'minute' ) )
        $doctitle = sprintf( __( 'Archive for minute %s', 'exmachina-core' ), get_the_time( __( 'i', 'exmachina-core' ) ) );

      elseif ( get_query_var( 'hour' ) )
        $doctitle = sprintf( __( 'Archive for %s', 'exmachina-core' ), get_the_time( __( 'g a', 'exmachina-core' ) ) );

      elseif ( is_day() )
        $doctitle = sprintf( __( 'Archive for %s', 'exmachina-core' ), get_the_time( __( 'F jS, Y', 'exmachina-core' ) ) );

      elseif ( get_query_var( 'w' ) )
        $doctitle = sprintf( __( 'Archive for week %s of %s', 'exmachina-core' ), get_the_time( __( 'W', 'exmachina-core' ) ), get_the_time( __( 'Y', 'exmachina-core' ) ) );

      elseif ( is_month() )
        $doctitle = sprintf( __( 'Archive for %s', 'exmachina-core' ), single_month_title( ' ', false) );

      elseif ( is_year() )
        $doctitle = sprintf( __( 'Archive for %s', 'exmachina-core' ), get_the_time( __( 'Y', 'exmachina-core' ) ) );
    }

    /* For any other archives. */
    else {
      $doctitle = __( 'Archives', 'exmachina-core' );
    }
  }

  /* If viewing a search results page. */
  elseif ( is_search() )
    $doctitle = sprintf( __( 'Search results for "%s"', 'exmachina-core' ), esc_attr( get_search_query() ) );

  /* If viewing a 404 not found page. */
  elseif ( is_404() )
    $doctitle = __( '404 Not Found', 'exmachina-core' );

  /* If the current page is a paged page. */
  if ( ( ( $page = $wp_query->get( 'paged' ) ) || ( $page = $wp_query->get( 'page' ) ) ) && $page > 1 )
    $doctitle = sprintf( __( '%1$s Page %2$s', 'exmachina-core' ), $doctitle . $separator, number_format_i18n( $page ) );

  /* Apply the wp_title filters so we're compatible with plugins. */
  $doctitle = apply_filters( 'wp_title', strip_tags( $doctitle ), $separator, '' );

  /* Trim separator + space from beginning and end in case a plugin adds it. */
  $doctitle = trim( $doctitle, "{$separator} " );

  /* Print the title to the screen. */
  echo apply_atomic( 'document_title', esc_attr( $doctitle ) );
}

