<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Markup Functions
 *
 * markup.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * @todo cleanup this file
 *
 * <[DESCRIPTION GOES HERE]>
 *
 * @package     ExMachina
 * @subpackage  Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/**
 * Output markup conditionally.
 *
 * Supported keys for `$args` are:
 *
 *  - `html5` (`sprintf()` pattern markup),
 *  - `xhtml` (XHTML markup),
 *  - `context` (name of context),
 *  - `echo` (default is true).
 *
 * If the child theme supports HTML5, then this function will output the `html5` value, with a call to `exmachina_attr()`
 * with the same context added in. Otherwise, it will output the `xhtml` value.
 *
 * Applies a `exmachina_markup_{context}` filter early to allow shortcutting the function.
 *
 * Applies a `exmachina_markup_{context}_output` filter at the end.
 *
 * @since 0.5.0
 *
 * @uses exmachina_attr()  Contextual attributes.
 *
 * @param array $args Array of arguments.
 *
 * @return string Markup.
 */
function exmachina_markup( $args = array() ) {

  $defaults = array(
    'html'   => '',
    'context' => '',
    'echo'    => true,
  );

  $args = wp_parse_args( $args, $defaults );

  //* Short circuit filter
  $pre = apply_filters( 'exmachina_markup_' . $args['context'], false, $args );
  if ( false !== $pre )
    return $pre;

  if ( ! $args['html'] )
    return '';


  $tag = $args['context'] ? sprintf( $args['html'], exmachina_attr( $args['context'] ) ) : $args['html'];


  //* Contextual filter
  $tag = $args['context'] ? apply_filters( 'exmachina_markup_' . $args['context'] . '_output', $tag, $args ) : $tag;

  if ( $args['echo'] )
    echo $tag;
  else
    return $tag;

}

/**
 * Merge array of attributes with defaults, and apply contextual filter on array.
 *
 * The contextual filter is of the form `exmachina_attr_{context}`.
 *
 * @since 0.5.0
 *
 * @param  string $context    The context, to build filter name.
 * @param  array  $attributes Optional. Extra attributes to merge with defaults.
 *
 * @return array Merged and filtered attributes.
 */
function exmachina_parse_attr( $context, $attributes = array() ) {

    $defaults = array(
        'class' => sanitize_html_class( $context ),
    );

    $attributes = wp_parse_args( $attributes, $defaults );

    //* Contextual filter
    return apply_filters( 'exmachina_attr_' . $context, $attributes, $context );

}

/**
 * Build list of attributes into a string and apply contextual filter on string.
 *
 * The contextual filter is of the form `exmachina_attr_{context}_output`.
 *
 * @since 0.5.0
 *
 * @uses exmachina_parse_attr() Merge array of attributes with defaults, and apply contextual filter on array.
 *
 * @param  string $context    The context, to build filter name.
 * @param  array  $attributes Optional. Extra attributes to merge with defaults.
 *
 * @return string String of HTML attributes and values.
 */
function exmachina_attr( $context, $attributes = array() ) {

    $attributes = exmachina_parse_attr( $context, $attributes );

    $output = '';

    //* Cycle through attributes, build tag attribute string
    foreach ( $attributes as $key => $value ) {
        if ( ! $value )
            continue;
        $output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
    }

    $output = apply_filters( 'exmachina_attr_' . $context . '_output', $output, $attributes, $context );

    return trim( $output );

}

add_filter( 'exmachina_attr_body', 'exmachina_attributes_body' );
/**
 * Add attributes for body element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_body( $attributes ) {

  $attributes['class']     = join( ' ', get_body_class() );
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/WebPage';

  return $attributes;

}

add_filter( 'exmachina_attr_site-header', 'exmachina_attributes_header' );
/**
 * Add attributes for site header element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_header( $attributes ) {

  $attributes['role']      = 'banner';
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/WPHeader';

  return $attributes;

}

add_filter( 'exmachina_attr_site-title', 'exmachina_attributes_site_title' );
/**
 * Add attributes for site title element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_site_title( $attributes ) {

  $attributes['itemprop'] = 'headline';

  return $attributes;

}

add_filter( 'exmachina_attr_site-description', 'exmachina_attributes_site_description' );
/**
 * Add attributes for site description element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_site_description( $attributes ) {

  $attributes['itemprop'] = 'description';

  return $attributes;

}

add_filter( 'exmachina_attr_header-widget-area', 'exmachina_attributes_header_widget_area' );
/**
 * Add attributes for header widget area element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_header_widget_area( $attributes ) {

  $attributes['class'] = 'widget-area header-widget-area';

  return $attributes;

}

add_filter( 'exmachina_attr_nav-primary', 'exmachina_attributes_nav' );
add_filter( 'exmachina_attr_nav-secondary', 'exmachina_attributes_nav' );
add_filter( 'exmachina_attr_nav-header', 'exmachina_attributes_nav' );
/**
 * Add typical attributes for navigation elements.
 *
 * Used for primary navigation, secondary navigation, and custom menu widgets in the header right widget area.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_nav( $attributes ) {

  $attributes['role']      = 'navigation';
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/SiteNavigationElement';

  return $attributes;

}

add_filter( 'exmachina_attr_structural-wrap', 'exmachina_attributes_structural_wrap' );
/**
 * Add attributes for structural wrap element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_structural_wrap( $attributes ) {

  $attributes['class'] = 'wrap';

  return $attributes;

}

add_filter( 'exmachina_attr_content', 'exmachina_attributes_content' );
/**
 * Add attributes for main content element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_content( $attributes ) {

  $attributes['role']     = 'main';
  $attributes['itemprop'] = 'mainContentOfPage';

  //* Blog microdata
  if ( is_singular( 'post' ) || is_archive() || is_home() || is_page_template( 'page_blog.php' ) ) {
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype']  = 'http://schema.org/Blog';
  }

  //* Search results pages
  if ( is_search() ) {
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'http://schema.org/SearchResultsPage';
  }

  return $attributes;

}

add_filter( 'exmachina_attr_entry', 'exmachina_attributes_entry' );
/**
 * Add attributes for entry element.
 *
 * @since 0.5.0
 *
 * @global WP_Post $post Post object.
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_entry( $attributes ) {

  global $post;

  $attributes['class']     = join( ' ', get_post_class() );
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/CreativeWork';

  //* Blog posts microdata
  if ( 'post' === $post->post_type ) {

    $attributes['itemtype']  = 'http://schema.org/BlogPosting';

    //* If main query,
    if ( is_main_query() )
      $attributes['itemprop']  = 'blogPost';

  }

  return $attributes;

}

add_filter( 'exmachina_attr_entry-image', 'exmachina_attributes_entry_image' );
/**
 * Add attributes for entry image element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_entry_image( $attributes ) {

  $attributes['class']    = 'alignleft post-image entry-image';
  $attributes['itemprop'] = 'image';

  return $attributes;

}

add_filter( 'exmachina_attr_entry-image-widget', 'exmachina_attributes_entry_image_widget' );
/**
 * Add attributes for entry image element shown in a widget.
 *
 * @since 0.5.0
 *
 * @global WP_Post $post Post object.
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_entry_image_widget( $attributes ) {

  global $post;

  $attributes['class']    = 'entry-image attachment-' . $post->post_type;
  $attributes['itemprop'] = 'image';

  return $attributes;

}

add_filter( 'exmachina_attr_entry-image-grid-loop', 'exmachina_attributes_entry_image_grid_loop' );
/**
 * Add attributes for entry image element shown in a grid loop.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_entry_image_grid_loop( $attributes ) {

  $attributes['itemprop'] = 'image';

  return $attributes;

}

add_filter( 'exmachina_attr_entry-author', 'exmachina_attributes_entry_author' );
/**
 * Add attributes for author element for an entry.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_entry_author( $attributes ) {

  $attributes['itemprop']  = 'author';
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/Person';

  return $attributes;

}

add_filter( 'exmachina_attr_entry-author-link', 'exmachina_attributes_entry_author_link' );
/**
 * Add attributes for entry author link element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_entry_author_link( $attributes ) {

  $attributes['itemprop'] = 'url';
  $attributes['rel']      = 'author';

  return $attributes;

}

add_filter( 'exmachina_attr_entry-author-name', 'exmachina_attributes_entry_author_name' );
/**
 * Add attributes for entry author name element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_entry_author_name( $attributes ) {

  $attributes['itemprop'] = 'name';

  return $attributes;

}

add_filter( 'exmachina_attr_entry-time', 'exmachina_attributes_entry_time' );
/**
 * Add attributes for time element for an entry.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_entry_time( $attributes ) {

  $attributes['itemprop'] = 'datePublished';
  $attributes['datetime'] = get_the_time( 'c' );

  return $attributes;

}

add_filter( 'exmachina_attr_entry-title', 'exmachina_attributes_entry_title' );
/**
 * Add attributes for entry title element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_entry_title( $attributes ) {

  $attributes['itemprop'] = 'headline';

  return $attributes;

}

add_filter( 'exmachina_attr_entry-content', 'exmachina_attributes_entry_content' );
/**
 * Add attributes for entry content element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_entry_content( $attributes ) {

  $attributes['itemprop'] = 'text';

  return $attributes;

}

add_filter( 'exmachina_attr_archive-pagination', 'exmachina_attributes_pagination' );
add_filter( 'exmachina_attr_entry-pagination', 'exmachina_attributes_pagination' );
add_filter( 'exmachina_attr_adjacent-entry-pagination', 'exmachina_attributes_pagination' );
add_filter( 'exmachina_attr_comments-pagination', 'exmachina_attributes_pagination' );
/**
 * Add attributes for pagination.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_pagination( $attributes ) {

  $attributes['class'] .= ' pagination';

  return $attributes;

}

add_filter( 'exmachina_attr_entry-comments', 'exmachina_attributes_entry_comments' );
/**
 * Add attributes for entry comments element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_entry_comments( $attributes ) {

  $attributes['id'] = 'comments';

  return $attributes;

}

add_filter( 'exmachina_attr_comment', 'exmachina_attributes_comment' );
/**
 * Add attributes for single comment element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_comment( $attributes ) {

  $attributes['class']     = '';
  $attributes['itemprop']  = 'comment';
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/UserComments';

  return $attributes;

}

add_filter( 'exmachina_attr_comment-author', 'exmachina_attributes_comment_author' );
/**
 * Add attributes for comment author element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_comment_author( $attributes ) {

  $attributes['itemprop']  = 'creator';
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/Person';

  return $attributes;

}

add_filter( 'exmachina_attr_author-box', 'exmachina_attributes_author_box' );
/**
 * Add attributes for author box element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_author_box( $attributes ) {

  $attributes['itemprop']  = 'author';
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/Person';

  return $attributes;

}

add_filter( 'exmachina_attr_sidebar-primary', 'exmachina_attributes_sidebar_primary' );
/**
 * Add attributes for primary sidebar element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_sidebar_primary( $attributes ) {

  $attributes['class']     = 'sidebar sidebar-primary widget-area';
  $attributes['role']      = 'complementary';
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/WPSideBar';

  return $attributes;

}

add_filter( 'exmachina_attr_sidebar-secondary', 'exmachina_attributes_sidebar_secondary' );
/**
 * Add attributes for secondary sidebar element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_sidebar_secondary( $attributes ) {

  $attributes['class']     = 'sidebar sidebar-secondary widget-area';
  $attributes['role']      = 'complementary';
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/WPSideBar';

  return $attributes;

}

add_filter( 'exmachina_attr_site-footer', 'exmachina_attributes_site_footer' );
/**
 * Add attributes for site footer element.
 *
 * @since 0.5.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function exmachina_attributes_site_footer( $attributes ) {

  $attributes['role']      = 'contentinfo';
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/WPFooter';

  return $attributes;

}
