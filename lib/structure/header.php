<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Header Structure
 *
 * header.php
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

/* Adds the doctype markup. */
add_action( 'exmachina_doctype', 'exmachina_do_doctype' );

/* Wraps the wp_title in title HTML tags. */
add_filter( 'wp_title', 'exmachina_doctitle_wrap', 20 );

/* Adds post title filter. */
add_action( 'exmachina_title', 'wp_title' );
add_filter( 'wp_title', 'exmachina_default_title', 10, 3 );

/* Adds doc head control. */
add_action( 'get_header', 'exmachina_doc_head_control' );

/* Adds the meta action hook functions. */
add_action( 'exmachina_meta', 'exmachina_seo_meta_description' );
add_action( 'exmachina_meta', 'exmachina_seo_meta_keywords' );
add_action( 'exmachina_meta', 'exmachina_robots_meta' );
add_action( 'exmachina_meta', 'exmachina_responsive_viewport' );

/* Adds the wp_head action hook functions. */
add_action( 'wp_head', 'exmachina_load_favicon' );
add_action( 'wp_head', 'exmachina_do_meta_pingback' );
add_action( 'wp_head', 'exmachina_canonical', 5 );
add_action( 'wp_head', 'exmachina_rel_author' );

/* Adds header scripts and allows shortcodes. */
add_filter( 'exmachina_header_scripts', 'do_shortcode' );
add_action( 'wp_head', 'exmachina_header_scripts' );

/* Activates the Custom Header feature. */
add_action( 'exmachina_setup', 'exmachina_custom_header' );
add_action( 'wp_head', 'exmachina_custom_header_style' );

/* Adds header markup to header hook. */
add_action( 'exmachina_header', 'exmachina_header_markup_open', 5 );
add_action( 'exmachina_header', 'exmachina_header_markup_close', 15 );
add_action( 'exmachina_header', 'exmachina_do_header' );

add_action( 'exmachina_site_title', 'exmachina_seo_site_title' );
add_action( 'exmachina_site_description', 'exmachina_seo_site_description' );

/**
 * Doctype Markup
 *
 * Echos the doctype and opening markup.
 *
 * @todo split for <head>
 * @todo add meta action hook
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_do_doctype() {
  ?>
    <!DOCTYPE html>
    <html <?php language_attributes( 'html' ); ?>>
    <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <?php
} // end function exmachina_do_doctype()

/**
 * Doctitle Wrap
 *
 * Wraps the page title in a `title` tag element. This function only applies if
 * on the frontend of the site, and not on an admin or feed page.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_feed
 * @link http://codex.wordpress.org/Function_Reference/is_admin
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string $title  Page title.
 * @return string         Plain text or HTML title markup.
 */
function exmachina_doctitle_wrap( $title ) {

  return is_feed() || is_admin() ? $title : sprintf( "<title>%s</title>\n", $title );

} // end function exmachina_doctitle_wrap()

/**
 * Default Post Title
 *
 * Returns the filtered post title. This function does 3 things:
 *  1. Pulls the values for `$sep` and `$seplocation`, uses defaults if necessary.
 *  2. Determines if the site title should be appended.
 *  3. Allows the user to set a custom title on a per-page or per-post basis.
 *
 * @todo add inline comments
 * @todo remove vestigal functions
 * @todo compare hybrid title function
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Query
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/get_bloginfo
 * @link http://codex.wordpress.org/Function_Reference/get_queried_object
 * @link http://codex.wordpress.org/Function_Reference/get_term_by
 * @link http://codex.wordpress.org/Function_Reference/get_query_var
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 *
 * @uses exmachina_get_seo_option() [description]
 * @uses exmachina_get_custom_field() [description]
 * @uses exmachina_has_post_type_archive_support() [description]
 * @uses exmachina_get_cpt_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $wp_query    WP_Query query object.
 * @param  string $title       Existing page title.
 * @param  string $sep         Separator character(s). Default is '-'
 * @param  string $seplocation Separator location. Default is 'right'.
 * @return string              Page title.
 */
function exmachina_default_title( $title, $sep, $seplocation ) {
  global $wp_query;

  if ( is_feed() )
    return trim( $title );

  $sep = exmachina_get_seo_option( 'doctitle_sep' ) ? exmachina_get_seo_option( 'doctitle_sep' ) : '–';
  $seplocation = exmachina_get_seo_option( 'doctitle_seplocation' ) ? exmachina_get_seo_option( 'doctitle_seplocation' ) : 'right';

  //* If viewing the home page
  if ( is_front_page() ) {
    //* Determine the doctitle
    $title = exmachina_get_seo_option( 'home_doctitle' ) ? exmachina_get_seo_option( 'home_doctitle' ) : get_bloginfo( 'name' );

    //* Append site description, if necessary
    $title = exmachina_get_seo_option( 'append_description_home' ) ? $title . " $sep " . get_bloginfo( 'description' ) : $title;
  }

  //* if viewing a post / page / attachment
  if ( is_singular() ) {
    //* The User Defined Title (ExMachina)
    if ( exmachina_get_custom_field( '_exmachina_title' ) )
      $title = exmachina_get_custom_field( '_exmachina_title' );
    //* All-in-One SEO Pack Title (latest, vestigial)
    elseif ( exmachina_get_custom_field( '_aioseop_title' ) )
      $title = exmachina_get_custom_field( '_aioseop_title' );
    //* Headspace Title (vestigial)
    elseif ( exmachina_get_custom_field( '_headspace_page_title' ) )
      $title = exmachina_get_custom_field( '_headspace_page_title' );
    //* Thesis Title (vestigial)
    elseif ( exmachina_get_custom_field( 'thesis_title' ) )
      $title = exmachina_get_custom_field( 'thesis_title' );
    //* SEO Title Tag (vestigial)
    elseif ( exmachina_get_custom_field( 'title_tag' ) )
      $title = exmachina_get_custom_field( 'title_tag' );
    //* All-in-One SEO Pack Title (old, vestigial)
    elseif ( exmachina_get_custom_field( 'title' ) )
      $title = exmachina_get_custom_field( 'title' );
  }

  if ( is_category() ) {
    //$term = get_term( get_query_var('cat'), 'category' );
    $term  = $wp_query->get_queried_object();
    $title = ! empty( $term->meta['doctitle'] ) ? $term->meta['doctitle'] : $title;
  }

  if ( is_tag() ) {
    //$term = get_term( get_query_var('tag_id'), 'post_tag' );
    $term  = $wp_query->get_queried_object();
    $title = ! empty( $term->meta['doctitle'] ) ? $term->meta['doctitle'] : $title;
  }

  if ( is_tax() ) {
    $term  = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    $title = ! empty( $term->meta['doctitle'] ) ? wp_kses_stripslashes( wp_kses_decode_entities( $term->meta['doctitle'] ) ) : $title;
  }

  if ( is_author() ) {
    $user_title = get_the_author_meta( 'doctitle', (int) get_query_var( 'author' ) );
    $title      = $user_title ? $user_title : $title;
  }

  if ( is_post_type_archive() && exmachina_has_post_type_archive_support() ) {
    $title = exmachina_get_cpt_option( 'doctitle' ) ? exmachina_get_cpt_option( 'doctitle' ) : $title;
  }

  //* If we don't want site name appended, or if we're on the home page
  if ( ! exmachina_get_seo_option( 'append_site_title' ) || is_front_page() )
    return esc_html( trim( $title ) );

  //* Else append the site name
  $title = 'right' === $seplocation ? $title . " $sep " . get_bloginfo( 'name' ) : get_bloginfo( 'name' ) . " $sep " . $title;
  return esc_html( trim( $title ) );

} // end function exmachina_default_title()

/**
 * Document Head Control
 *
 * Removes the unnecessary code that WordPress puts into 'wp_head'.
 *
 * @todo add inline comments to function
 *
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/remove_action
 *
 * @uses exmachina_get_seo_option() [description]
 * @uses exmachina_get_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_doc_head_control() {

  remove_action( 'wp_head', 'wp_generator' );

  if ( ! exmachina_get_seo_option( 'head_adjacent_posts_rel_link' ) )
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

  if ( ! exmachina_get_seo_option( 'head_wlwmanifest_link' ) )
    remove_action( 'wp_head', 'wlwmanifest_link' );

  if ( ! exmachina_get_seo_option( 'head_shortlink' ) )
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

  if ( is_single() && ! exmachina_get_option( 'comments_posts' ) )
    remove_action( 'wp_head', 'feed_links_extra', 3 );

  if ( is_page() && ! exmachina_get_option( 'comments_pages' ) )
    remove_action( 'wp_head', 'feed_links_extra', 3 );

} // end function exmachina_doc_head_control()

/**
 * SEO Meta Description
 *
 * Outputs the meta description based on contextual criteria and will output
 * nothing if site description is not present.
 *
 * @todo inline comment function
 * @todo remove vestigal functions
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Query
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/get_queried_object
 * @link http://codex.wordpress.org/Function_Reference/get_term_by
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 * @link http://codex.wordpress.org/Function_Reference/get_query_var
 *
 * @uses exmachina_get_seo_option() [description]
 * @uses exmachina_get_custom_field() [description]
 * @uses exmachina_has_post_type_archive_support() [description]
 * @uses exmachina_get_cpt_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $wp_query WP_Query query object.
 * @return void
 */
function exmachina_seo_meta_description() {
  global $wp_query;

  $description = '';

  //* If we're on the home page
  if ( is_front_page() )
    $description = exmachina_get_seo_option( 'home_description' ) ? exmachina_get_seo_option( 'home_description' ) : get_bloginfo( 'description' );

  //* If we're on a single post / page / attachment
  if ( is_singular() ) {
    //* Description is set via custom field
    if ( exmachina_get_custom_field( '_exmachina_description' ) )
      $description = exmachina_get_custom_field( '_exmachina_description' );
    //* All-in-One SEO Pack (latest, vestigial)
    elseif ( exmachina_get_custom_field( '_aioseop_description' ) )
      $description = exmachina_get_custom_field( '_aioseop_description' );
    //* Headspace2 (vestigial)
    elseif ( exmachina_get_custom_field( '_headspace_description' ) )
      $description = exmachina_get_custom_field( '_headspace_description' );
    //* Thesis (vestigial)
    elseif ( exmachina_get_custom_field( 'thesis_description' ) )
      $description = exmachina_get_custom_field( 'thesis_description' );
    //* All-in-One SEO Pack (old, vestigial)
    elseif ( exmachina_get_custom_field( 'description' ) )
      $description = exmachina_get_custom_field( 'description' );
  }

  if ( is_category() ) {
    //$term = get_term( get_query_var('cat'), 'category' );
    $term = $wp_query->get_queried_object();
    $description = ! empty( $term->meta['description'] ) ? $term->meta['description'] : '';
  }

  if ( is_tag() ) {
    //$term = get_term( get_query_var('tag_id'), 'post_tag' );
    $term = $wp_query->get_queried_object();
    $description = ! empty( $term->meta['description'] ) ? $term->meta['description'] : '';
  }

  if ( is_tax() ) {
    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    $description = ! empty( $term->meta['description'] ) ? wp_kses_stripslashes( wp_kses_decode_entities( $term->meta['description'] ) ) : '';
  }

  if ( is_author() ) {
    $user_description = get_the_author_meta( 'meta_description', (int) get_query_var( 'author' ) );
    $description = $user_description ? $user_description : '';
  }

  if ( is_post_type_archive() && exmachina_has_post_type_archive_support() ) {
    $description = exmachina_get_cpt_option( 'description' ) ? exmachina_get_cpt_option( 'description' ) : '';
  }

  //* Add the description if one exists
  if ( $description )
    echo '<meta name="description" content="' . esc_attr( $description ) . '" />' . "\n";

} // end function exmachina_seo_meta_description()

/**
 * SEO Meta Keywords
 *
 * Outputs the meta keywords based on contextual criteria and will output nothing
 * if keywords aren't present.
 *
 * @todo inline comment function
 * @todo remove vestigal functions
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Query
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/get_queried_object
 * @link http://codex.wordpress.org/Function_Reference/get_term_by
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 * @link http://codex.wordpress.org/Function_Reference/get_query_var
 *
 * @uses exmachina_get_seo_option() [description]
 * @uses exmachina_get_custom_field() [description]
 * @uses exmachina_has_post_type_archive() [description]
 * @uses exmachina_get_cpt_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $wp_query WP_Query query object.
 * @return void
 */
function exmachina_seo_meta_keywords() {
  global $wp_query;

  $keywords = '';

  //* If we're on the home page
  if ( is_front_page() )
    $keywords = exmachina_get_seo_option( 'home_keywords' );

  //* If we're on a single post, page or attachment
  if ( is_singular() ) {
    //* Keywords are set via custom field
    if ( exmachina_get_custom_field( '_exmachina_keywords' ) )
      $keywords = exmachina_get_custom_field( '_exmachina_keywords' );
    //* All-in-One SEO Pack (latest, vestigial)
    elseif ( exmachina_get_custom_field( '_aioseop_keywords' ) )
      $keywords = exmachina_get_custom_field( '_aioseop_keywords' );
    //* Thesis (vestigial)
    elseif ( exmachina_get_custom_field( 'thesis_keywords' ) )
      $keywords = exmachina_get_custom_field( 'thesis_keywords' );
    //* All-in-One SEO Pack (old, vestigial)
    elseif ( exmachina_get_custom_field( 'keywords' ) )
      $keywords = exmachina_get_custom_field( 'keywords' );
  }

  if ( is_category() ) {
    $term     = $wp_query->get_queried_object();
    $keywords = ! empty( $term->meta['keywords'] ) ? $term->meta['keywords'] : '';
  }

  if ( is_tag() ) {
    $term     = $wp_query->get_queried_object();
    $keywords = ! empty( $term->meta['keywords'] ) ? $term->meta['keywords'] : '';
  }

  if ( is_tax() ) {
    $term     = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    $keywords = ! empty( $term->meta['keywords'] ) ? wp_kses_stripslashes( wp_kses_decode_entities( $term->meta['keywords'] ) ) : '';
  }

  if ( is_author() ) {
    $user_keywords = get_the_author_meta( 'meta_keywords', (int) get_query_var( 'author' ) );
    $keywords = $user_keywords ? $user_keywords : '';
  }

  if ( is_post_type_archive() && exmachina_has_post_type_archive_support() ) {
    $keywords = exmachina_get_cpt_option( 'keywords' ) ? exmachina_get_cpt_option( 'keywords' ) : '';
  }

  //* Add the keywords if they exist
  if ( $keywords )
    echo '<meta name="keywords" content="' . esc_attr( $keywords ) . '" />' . "\n";

} // end function exmachina_seo_meta_keywords()

/**
 * Robots Meta
 *
 * Output the `index`, `follow`, `noodp`, `noydir`, `noarchive` robots meta
 * code in the document `head`.
 *
 * @todo inline comment function
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Query
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/get_queried_object
 * @link http://codex.wordpress.org/Function_Reference/get_query_var
 * @link http://codex.wordpress.org/Function_Reference/get_queried_object
 * @link http://codex.wordpress.org/Function_Reference/get_term_by
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 *
 * @uses exmachina_get_seo_option() [description]
 * @uses exmachina_has_post_type_support() [description]
 * @uses exmachina_get_cpt_option() [description]
 * @uses exmachina_get_custom_field() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $wp_query WP_Query query object.
 * @return void
 */
function exmachina_robots_meta() {
  global $wp_query;

  //* If the blog is private, then following logic is unnecessary as WP will insert noindex and nofollow
  if ( ! get_option( 'blog_public' ) )
    return;

  //* Defaults
  $meta = array(
    'noindex'   => '',
    'nofollow'  => '',
    'noarchive' => exmachina_get_seo_option( 'noarchive' ) ? 'noarchive' : '',
    'noodp'     => exmachina_get_seo_option( 'noodp' ) ? 'noodp' : '',
    'noydir'    => exmachina_get_seo_option( 'noydir' ) ? 'noydir' : '',
  );

  //* Check home page SEO settings, set noindex, nofollow and noarchive
  if ( is_front_page() ) {
    $meta['noindex']   = exmachina_get_seo_option( 'home_noindex' ) ? 'noindex' : $meta['noindex'];
    $meta['nofollow']  = exmachina_get_seo_option( 'home_nofollow' ) ? 'nofollow' : $meta['nofollow'];
    $meta['noarchive'] = exmachina_get_seo_option( 'home_noarchive' ) ? 'noarchive' : $meta['noarchive'];
  }

  if ( is_category() ) {
    $term = $wp_query->get_queried_object();

    $meta['noindex']   = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
    $meta['nofollow']  = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
    $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

    $meta['noindex']   = exmachina_get_seo_option( 'noindex_cat_archive' ) ? 'noindex' : $meta['noindex'];
    $meta['noarchive'] = exmachina_get_seo_option( 'noarchive_cat_archive' ) ? 'noarchive' : $meta['noarchive'];

    //* noindex paged archives, if canonical archives is off
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $meta['noindex'] = $paged > 1 && ! exmachina_get_seo_option( 'canonical_archives' ) ? 'noindex' : $meta['noindex'];
  }

  if ( is_tag() ) {
    $term = $wp_query->get_queried_object();

    $meta['noindex']   = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
    $meta['nofollow']  = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
    $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

    $meta['noindex']   = exmachina_get_seo_option( 'noindex_tag_archive' ) ? 'noindex' : $meta['noindex'];
    $meta['noarchive'] = exmachina_get_seo_option( 'noarchive_tag_archive' ) ? 'noarchive' : $meta['noarchive'];

    //* noindex paged archives, if canonical archives is off
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $meta['noindex'] = $paged > 1 && ! exmachina_get_seo_option( 'canonical_archives' ) ? 'noindex' : $meta['noindex'];
  }

  if ( is_tax() ) {
    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

    $meta['noindex']   = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
    $meta['nofollow']  = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
    $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

    //* noindex paged archives, if canonical archives is off
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $meta['noindex'] = $paged > 1 && ! exmachina_get_seo_option( 'canonical_archives' ) ? 'noindex' : $meta['noindex'];
  }

  if ( is_post_type_archive() && exmachina_has_post_type_archive_support() ) {
    $meta['noindex']   = exmachina_get_cpt_option( 'noindex' ) ? 'noindex' : $meta['noindex'];
    $meta['nofollow']  = exmachina_get_cpt_option( 'nofollow' ) ? 'nofollow' : $meta['nofollow'];
    $meta['noarchive'] = exmachina_get_cpt_option( 'noarchive' ) ? 'noarchive' : $meta['noarchive'];

    //* noindex paged archives, if canonical archives is off
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $meta['noindex'] = $paged > 1 && ! exmachina_get_seo_option( 'canonical_archives' ) ? 'noindex' : $meta['noindex'];
  }

  if ( is_author() ) {
    $meta['noindex']   = get_the_author_meta( 'noindex', (int) get_query_var( 'author' ) ) ? 'noindex' : $meta['noindex'];
    $meta['nofollow']  = get_the_author_meta( 'nofollow', (int) get_query_var( 'author' ) ) ? 'nofollow' : $meta['nofollow'];
    $meta['noarchive'] = get_the_author_meta( 'noarchive', (int) get_query_var( 'author' ) ) ? 'noarchive' : $meta['noarchive'];

    $meta['noindex']   = exmachina_get_seo_option( 'noindex_author_archive' ) ? 'noindex' : $meta['noindex'];
    $meta['noarchive'] = exmachina_get_seo_option( 'noarchive_author_archive' ) ? 'noarchive' : $meta['noarchive'];

    //* noindex paged archives, if canonical archives is off
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $meta['noindex'] = $paged > 1 && ! exmachina_get_seo_option( 'canonical_archives' ) ? 'noindex' : $meta['noindex'];
  }

  if ( is_date() ) {
    $meta['noindex']   = exmachina_get_seo_option( 'noindex_date_archive' ) ? 'noindex' : $meta['noindex'];
    $meta['noarchive'] = exmachina_get_seo_option( 'noarchive_date_archive' ) ? 'noarchive' : $meta['noarchive'];
  }

  if ( is_search() ) {
    $meta['noindex']   = exmachina_get_seo_option( 'noindex_search_archive' ) ? 'noindex' : $meta['noindex'];
    $meta['noarchive'] = exmachina_get_seo_option( 'noarchive_search_archive' ) ? 'noarchive' : $meta['noarchive'];
  }

  if ( is_singular() ) {
    $meta['noindex']   = exmachina_get_custom_field( '_exmachina_noindex' ) ? 'noindex' : $meta['noindex'];
    $meta['nofollow']  = exmachina_get_custom_field( '_exmachina_nofollow' ) ? 'nofollow' : $meta['nofollow'];
    $meta['noarchive'] = exmachina_get_custom_field( '_exmachina_noarchive' ) ? 'noarchive' : $meta['noarchive'];
  }

  //* Strip empty array items
  $meta = array_filter( $meta );

  //* Add meta if any exist
  if ( $meta )
    printf( '<meta name="robots" content="%s" />' . "\n", implode( ',', $meta ) );

} // end function exmachina_robots_meta()

/**
 * Responsive Viewport
 *
 * Optionally outputs the responsive CSS viewport tag. To add the responsive
 * meta tag, themes must register support for 'exmachina-responsive-viewport'.
 *
 * @todo check hybrid addition of responsive viewport.
 * @todo maybe change theme support to simply 'exmachina-responsive'
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return early if responsive theme support is not added.
 */
function exmachina_responsive_viewport() {

  /* Return early if theme doesn't support a responsive viewport. */
  if ( ! current_theme_supports( 'exmachina-responsive-viewport' ) )
    return;

  /* Echo the responsive viewport meta tag. */
  echo '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";

} // end function exmachina_responsive_viewport()

/**
 * Load Favicon
 *
 * Echos the favicon link if one is found. Falls back to the main theme favicon.
 * The Favicon URL is filtered via the `exmachina_favicon_url` before being
 * output.
 *
 * @todo update file path constants
 * @todo add option to include uploaded favicon
 * @todo inline comment function
 * @todo research use of retina favicons
 * @todo research favicon plugin functionality
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_load_favicon() {

  //* Allow child theme to short-circuit this function
  $pre = apply_filters( 'exmachina_pre_load_favicon', false );

  if ( $pre !== false )
    $favicon = $pre;
  elseif ( file_exists( CHILD_THEME_DIR . '/images/favicon.ico' ) )
    $favicon = CHILD_URL . '/images/favicon.ico';
  elseif ( file_exists( CHILD_THEME_DIR . '/images/favicon.gif' ) )
    $favicon = CHILD_URL . '/images/favicon.gif';
  elseif ( file_exists( CHILD_THEME_DIR . '/images/favicon.png' ) )
    $favicon = CHILD_URL . '/images/favicon.png';
  elseif ( file_exists( CHILD_THEME_DIR . '/images/favicon.jpg' ) )
    $favicon = CHILD_URL . '/images/favicon.jpg';
  else
    $favicon = PARENT_URL . '/images/favicon.ico';

  $favicon = apply_filters( 'exmachina_favicon_url', $favicon );

  if ( $favicon )
    echo '<link rel="Shortcut Icon" href="' . esc_url( $favicon ) . '" type="image/x-icon" />' . "\n";

} // end function exmachina_load_favicon()

/**
 * Pingback Meta Tag
 *
 * Adds the pingback meta tag to the head so that other sites can know how to
 * send a pingback to our site.
 *
 * @todo research pingback options via plugins
 *
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/get_bloginfo
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_do_meta_pingback() {

  /* If ping status is open. */
  if ( 'open' === get_option( 'default_ping_status' ) )
    /* Echo the pingback URL. */
    echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />' . "\n";

} // end function exmachina_do_meta_pingback()

/**
 * Canonical Link
 *
 * Echos the custom canonical link tag. It removes the default WordPress
 * canonical tag and uses this custom one that is more effective and gives
 * more flexibility.
 *
 * @todo add conditional tags codex link
 * @todo inline comment function'
 * @todo research canonical tag plugins
 * @todo maybe remove canonical remove function and add it outside the function
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Query
 * @link http://codex.wordpress.org/Function_Reference/remove_action
 * @link http://codex.wordpress.org/Function_Reference/get_queried_object_id
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 * @link http://codex.wordpress.org/Function_Reference/get_term_link
 * @link http://codex.wordpress.org/Function_Reference/get_author_posts_url
 *
 * @uses exmachina_get_custom_field() [description]
 * @uses exmachina_get_seo_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $wp_query WP_Query query object.
 * @return null             Returns null if query object cannot be determined.
 */
function exmachina_canonical() {

  //* Remove the WordPress canonical
  remove_action( 'wp_head', 'rel_canonical' );

  global $wp_query;

  $canonical = '';

  if ( is_front_page() )
    $canonical = trailingslashit( home_url() );

  if ( is_singular() ) {
    if ( ! $id = $wp_query->get_queried_object_id() )
      return;

    $cf = exmachina_get_custom_field( '_exmachina_canonical_uri' );

    $canonical = $cf ? $cf : get_permalink( $id );
  }

  if ( is_category() || is_tag() || is_tax() ) {
    if ( ! $id = $wp_query->get_queried_object_id() )
      return;

    $taxonomy = $wp_query->queried_object->taxonomy;

    $canonical = exmachina_get_seo_option( 'canonical_archives' ) ? get_term_link( (int) $id, $taxonomy ) : 0;
  }

  if ( is_author() ) {
    if ( ! $id = $wp_query->get_queried_object_id() )
      return;

    $canonical = exmachina_get_seo_option( 'canonical_archives' ) ? get_author_posts_url( $id ) : 0;
  }

  if ( $canonical )
    printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( apply_filters( 'exmachina_canonical', $canonical ) ) );
} // end function exmachina_canonical()

/**
 * Authorship Link Tag
 *
 * Echos a custom rel="author" link tag. If the appropiate information has been
 * entered, either for the homepage author, or for an individual post/page author,
 * echo a custom rel="author" link.
 *
 * @todo add inline comments
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Post
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/get_user_option
 * @link http://codex.wordpress.org/Function_Reference/get_query_var
 *
 * @uses exmachina_get_seo_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $post WP_Post post object.
 * @return null         Return on failure.
 */
function exmachina_rel_author() {

  if ( is_front_page() && $gplus_url = get_user_option( 'googleplus', exmachina_get_seo_option( 'home_author' ) ) ) {
    printf( '<link rel="author" href="%s" />' . "\n", esc_url( $gplus_url ) );
    return;
  }

  global $post;

  if ( is_singular() && isset( $post->post_author ) && $gplus_url = get_user_option( 'googleplus', $post->post_author ) ) {
    printf( '<link rel="author" href="%s" />' . "\n", esc_url( $gplus_url ) );
    return;
  }

  if ( is_author() && get_query_var( 'author' ) && $gplus_url = get_user_option( 'googleplus', get_query_var( 'author' ) ) ) {
    printf( '<link rel="author" href="%s" />' . "\n", esc_url( $gplus_url ) );
    return;
  }

} // end function exmachina_rel_author()

/**
 * Header Scripts Output
 *
 * Echos the header scripts in to wp_head(). This function allows shortcodes.
 * Applies the 'exmachina_header_scripts' filter on values stored in the options
 * table 'header_scripts' setting and echoes scripts added from a post's custom
 * field.
 *
 * @uses exmachina_get_option() [description]
 * @uses exmachina_custom_field() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_header_scripts() {

  /* Echos the value of the header_scripts setting. */
  echo apply_filters( 'exmachina_header_scripts', exmachina_get_option( 'header_scripts' ) );

  /* If singular, echo scripts from the custom field. */
  if ( is_singular() )
    exmachina_custom_field( '_exmachina_scripts' );

} // end function exmachina_header_scripts()

/**
 * Custom Header Feature
 *
 * Activate the custom header feature. It gets arguments passed through theme
 * support and defines the constants. Applies `exmachina_custom_header_defaults`
 * filter.
 *
 * @todo investigate into the custom header function
 *
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
 * @link http://codex.wordpress.org/Function_Reference/get_stylesheet_directory_uri
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return early if theme doesn't support custom header.
 */
function exmachina_custom_header() {

  /* Gets the custom header theme support. */
  $custom_header = get_theme_support( 'exmachina-custom-header' );
  $wp_custom_header = get_theme_support( 'custom-header' );

  /* If no custom header is active (ExMachina or WP), return. */
  if ( ! $custom_header && ! $wp_custom_header )
    return;

  /* Blog title option is obsolete when custom header is active. */
  add_filter( 'exmachina_pre_get_option_blog_title', '__return_empty_array' );

  /* If WP custom header is active, return. */
  if ( $wp_custom_header )
    return;

  /* Cast custom header variables array. */
  $custom_header = isset( $custom_header[0] ) && is_array( $custom_header[0] ) ? $custom_header[0] : array();

  /* Merge defaults with passed arguments. */
  $args = wp_parse_args(
    $custom_header,
    apply_filters(
      'exmachina_custom_header_defaults',
      array(
      'width'                 => 960,
      'height'                => 80,
      'textcolor'             => '333333',
      'no_header_text'        => false,
      'header_image'          => '%s/images/header.png',
      'header_callback'       => '',
      'admin_header_callback' => '',
      )
    )
  );

  /* Push arguments to theme support array. */
  add_theme_support( 'custom-header', array(
    'default-image'       => sprintf( $args['header_image'], get_stylesheet_directory_uri() ),
    'header-text'         => $args['no_header_text'] ? false : true,
    'default-text-color'  => $args['textcolor'],
    'width'               => $args['width'],
    'height'              => $args['height'],
    'random-default'      => false,
    'header-selector'     => '.site-header',
    'wp-head-callback'    => $args['header_callback'],
    'admin-head-callback' => $args['admin_header_callback'],
  ) );

} // end function exmachina_custom_header()

/**
 * Custom Header Style
 *
 * Custom header callback. This function outputs special CSS to the document head,
 * modifying the look of the header based on user input.
 *
 * @link http://codex.wordpress.org/Designing_Headers
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/get_header_image
 * @link http://codex.wordpress.org/Function_Reference/get_header_textcolor
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return early if Custom Header is not supported.
 */
function exmachina_custom_header_style() {

  /* Do nothing if custom header not supported. */
  if ( ! current_theme_supports( 'custom-header' ) )
    return;

  /* Do nothing if user specifies their own callback. */
  if ( get_theme_support( 'custom-header', 'wp-head-callback' ) )
    return;

  /* Sets an empty output variable. */
  $output = '';

  /* Sets the header image and header color. */
  $header_image = get_header_image();
  $text_color   = get_header_textcolor();

  /* If no options set, do nothing. */
  if ( empty( $header_image ) && ! display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) )
    return;

  /* Sets the CSS selectors. */
  $header_selector = get_theme_support( 'custom-header', 'header-selector' );
  $title_selector  = '.custom-header .site-title';
  $desc_selector   = '.custom-header .site-description';

  /* Header selector fallback. */
  if ( ! $header_selector )
    $header_selector = '.custom-header .site-header';

  /* Header image CSS, if exists. */
  if ( $header_image )
    $output .= sprintf( '%s { background: url(%s) no-repeat !important; }', $header_selector, esc_url( $header_image ) );

  /* Header text color CSS, if showing text. */
  if ( display_header_text() && $text_color !== get_theme_support( 'custom-header', 'default-text-color' ) )
    $output .= sprintf( '%2$s a, %2$s a:hover, %3$s { color: #%1$s !important; }', esc_html( $text_color ), esc_html( $title_selector ), esc_html( $desc_selector ) );

  if ( $output )
    printf( '<style type="text/css">%s</style>' . "\n", $output );

} // end function exmachina_custom_header_style()

/**
 * Header Markup Open
 *
 * Echo the opening structural markup for the header.
 *
 * @todo remove xhtml markup option
 *
 * @uses exmachina_markup() [description]
 * @uses exmachina_structural_wrap() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_header_markup_open() {

  exmachina_markup( array(
    'html'   => '<header %s>',
    'context' => 'site-header',
  ) );

  exmachina_structural_wrap( 'header' );

} // end function exmachina_header_markup_open()

/**
 * Header Markup Close
 *
 * Echo the closing structural markup for the header.
 *
 * @todo remove xhtml markup option
 *
 * @uses exmachina_markup() [description]
 * @uses exmachina_structural_wrap() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_header_markup_close() {

  exmachina_structural_wrap( 'header', 'close' );

  exmachina_markup( array(
    'html' => '</header>',
  ) );

} // end function exmachina_header_markup_close()

/**
 * Header Main Output
 *
 * Echo the default header, including the title, description, title-area, and
 * header-widget-area.
 *
 * @todo remove xhtml markup option
 * @todo inline comment function
 *
 * @link http://codex.wordpress.org/Function_Reference/is_active_sidebar
 * @link http://codex.wordpress.org/Function_Reference/has_action
 * @link http://codex.wordpress.org/Function_Reference/dynamic_sidebar
 *
 * @uses exmachina_markup() [description]
 * @uses exmachina_header_menu_args() [description]
 * @uses exmachina_header_menu_wrap() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global array $wp_registered_sidebars Holds all of the registered sidebars.
 * @return void
 */
function exmachina_do_header() {
  global $wp_registered_sidebars;

  exmachina_markup( array(
    'html'   => '<div %s>',
    'context' => 'title-area',
  ) );

  do_action( 'exmachina_site_title' );
  do_action( 'exmachina_site_description' );

  echo '</div>';

  if ( ( isset( $wp_registered_sidebars['header-right'] ) && is_active_sidebar( 'header-right' ) ) || has_action( 'exmachina_header_right' ) ) {

    exmachina_markup( array(
      'html'   => '<aside %s>',
      'context' => 'header-widget-area',
    ) );

      do_action( 'exmachina_header_right' );

      add_filter( 'wp_nav_menu_args', 'exmachina_header_menu_args' );
      add_filter( 'wp_nav_menu', 'exmachina_header_menu_wrap' );

      dynamic_sidebar( 'header-right' );

      remove_filter( 'wp_nav_menu_args', 'exmachina_header_menu_args' );
      remove_filter( 'wp_nav_menu', 'exmachina_header_menu_wrap' );

    exmachina_markup( array(
      'html' => '</aside>',
    ) );

  } // end IF statement

} // end function exmachina_do_header()

/**
 * Site Title
 *
 * Echo the site title into the header. Depending on the SEO option set by the
 * user, this will either be wrapped in an `h1` or `p` element. Applies the
 * `exmachina_seo_title` filter before echoing.
 *
 * @todo compare with hybrid site title function
 * @todo remove html5 conditional
 *
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/get_bloginfo
 *
 * @uses exmachina_get_seo_option() [description]
 * @uses exmachina_attr() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_seo_site_title() {

  /* Set what goes inside the wrapping tags. */
  $inside = sprintf( '<a href="%s" title="%s">%s</a>', trailingslashit( home_url() ), esc_attr( get_bloginfo( 'name' ) ), get_bloginfo( 'name' ) );

  /* Determine which wrapping tags to use. */
  $wrap = is_home() && 'title' === exmachina_get_seo_option( 'home_h1_on' ) ? 'h1' : 'p';

  /* A little fallback, in case an SEO plugin is active. */
  $wrap = is_home() && ! exmachina_get_seo_option( 'home_h1_on' ) ? 'h1' : $wrap;

  /* And finally, $wrap in h1 if semantic headings enabled. */
  $wrap = exmachina_html5() && exmachina_get_seo_option( 'semantic_headings' ) ? 'h1' : $wrap;

  /* Build the title. */
  $title  = exmachina_html5() ? sprintf( "<{$wrap} %s>", exmachina_attr( 'site-title' ) ) : sprintf( '<%s id="title">%s</%s>', $wrap, $inside, $wrap );
  $title .= exmachina_html5() ? "{$inside}</{$wrap}>" : '';

  //* Echo (filtered)
  echo apply_filters( 'exmachina_seo_title', $title, $inside, $wrap );

} // end function exmachina_seo_site_title()

/**
 * Site Description
 *
 * Echo the site description into the header. Depending on the SEO option set
 * by the user, this will either be wrapped in an `h1` or `p` element. Applies
 * the `exmachina_seo_description` filter before echoing.
 *
 * @todo compare with hybrid site description function
 * @todo remove html5 conditional
 *
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/get_bloginfo
 *
 * @uses exmachina_get_seo_option() [description]
 * @uses exmachina_attr() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_seo_site_description() {

  /* Set what goes inside the wrapping tags. */
  $inside = esc_html( get_bloginfo( 'description' ) );

  /* Determine which wrapping tags to use. */
  $wrap = is_home() && 'description' === exmachina_get_seo_option( 'home_h1_on' ) ? 'h1' : 'p';

  /* And finally, $wrap in h2 if semantic headings enabled. */
  $wrap = exmachina_html5() && exmachina_get_seo_option( 'semantic_headings' ) ? 'h2' : $wrap;

  /* Build the description. */
  $description  = exmachina_html5() ? sprintf( "<{$wrap} %s>", exmachina_attr( 'site-description' ) ) : sprintf( '<%s id="description">%s</%s>', $wrap, $inside, $wrap );
  $description .= exmachina_html5() ? "{$inside}</{$wrap}>" : '';

  /* Output (filtered). */
  $output = $inside ? apply_filters( 'exmachina_seo_description', $description, $inside, $wrap ) : '';

  echo $output;

} // end function exmachina_seo_site_description()

/**
 * Header Menu Arguments
 *
 * Sets a common class, `.exmachina-nav-menu`, for the custom menu widget if
 * used in the header right sidebar.
 *
 * @todo maybe add accessibility classes(???)
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array $args Header menu args.
 * @return array       Modified header menu args.
 */
function exmachina_header_menu_args( $args ) {

  /* Sets the container and appends the menu class. */
  $args['container']   = '';
  $args['menu_class'] .= ' exmachina-nav-menu';

  /* Return the args. */
  return $args;

} // end function exmachina_header_menu_args()

/**
 * Header Menu Wrap
 *
 * Wrap the header navigation menu in its own nav tags with markup API.
 *
 * @todo remove html5 conditional
 * @todo maybe this function can be removed entirely(???)
 *
 * @uses exmachina_attr() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string $menu Menu output.
 * @return string       Modified menu output.
 */
function exmachina_header_menu_wrap( $menu ) {

  if ( ! exmachina_html5() )
    return $menu;

  /* Return the menu markup. */
  return sprintf( '<nav %s>', exmachina_attr( 'nav-header' ) ) . $menu . '</nav>';

} // end function exmachina_header_menu_wrap()

/**
 * Contextual Document Title
 *
 * Function for handling what the browser/search engine title should be.
 * Attempts to handle every possible situation WordPress throws at it for
 * the best optimization.
 *
 * @link http://codex.wordpress.org/Conditional_Tags
 *
 * @uses apply_atomic() Applies contextual atomic filters.
 *
 * @todo Check against other document_title functions
 *
 * @since 0.1.0
 * @access public
 *
 * @global object $wp_query The current page query object.
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

} // end function exmachina_document_title()

add_action( 'wp_head', 'exmachina_html5_ie_fix' );
/**
 * Load the html5 shiv for IE8 and below. Can't enqueue with IE conditionals.
 *
 * @todo move to proper order
 * @todo conditional so if google fails, local loads?
 *
 * @since 0.5.0
 *
 * @uses exmachina_html5() Check for HTML5 support.
 *
 * @return Return early if HTML5 not supported.
 *
 */
function exmachina_html5_ie_fix() {

  if ( ! exmachina_html5() )
    return;

  echo '<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->' . "\n";

} // end function exmachina_html5_ie_fix()

/* Header actions. */
//add_action( exmachina_get_prefix() . '_header', 'exmachina_header_branding' );
/**
 * Dynamic element to wrap the site title and site description.
 *
 * @todo work against original header
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
