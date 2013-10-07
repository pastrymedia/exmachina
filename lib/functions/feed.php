<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Feed Functions
 *
 * feed.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
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

add_filter( 'feed_link', 'exmachina_feed_links_filter', 10, 2 );
/**
 * Feed Links Filter
 *
 * Filter the feed URI if the user has input a custom feed URI.
 *
 * Applied in the `get_feed_link()` WordPress function.
 *
 * @todo inline comment
 *
 * @uses exmachina_get_option() Get theme setting value.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string $output From the get_feed_link() WordPress function.
 * @param  string $feed   Optional. Defaults to default feed.
 * @return string          Amended feed URL.
 */
function exmachina_feed_links_filter( $output, $feed ) {

  $feed_uri = exmachina_get_option( 'feed_uri' );
  $comments_feed_uri = exmachina_get_option( 'comments_feed_uri' );

  if ( $feed_uri && ! mb_strpos( $output, 'comments' ) && in_array( $feed, array( '', 'rss2', 'rss', 'rdf', 'atom' ) ) ) {
    $output = esc_url( $feed_uri );
  }

  if ( $comments_feed_uri && mb_strpos( $output, 'comments' ) ) {
    $output = esc_url( $comments_feed_uri );
  }

  return $output;

} // end function exmachina_feed_links_filter()

add_action( 'template_redirect', 'exmachina_feed_redirect' );
/**
 * Feed Redirect
 *
 * Redirect the browser to the custom feed URI. Exits PHP after redirect.
 *
 * @todo inline comment
 * @todo add other redirects (???)
 *
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/is_feed
 * @link http://codex.wordpress.org/Function_Reference/wp_redirect
 *
 * @uses exmachina_get_option() Get theme setting value.
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return early on failure. Exits on success.
 */
function exmachina_feed_redirect() {

  if ( ! is_feed() || preg_match( '/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT'] ) )
    return;

  //* Don't redirect if viewing archive, search, or post comments feed
  if ( is_archive() || is_search() || is_singular() )
    return;

  $feed_uri = exmachina_get_option( 'feed_uri' );
  $comments_feed_uri = exmachina_get_option( 'comments_feed_uri' );

  if ( $feed_uri && ! is_comment_feed() && exmachina_get_option( 'redirect_feed' ) ) {
    wp_redirect( $feed_uri, 302 );
    exit;
  }

  if ( $comments_feed_uri && is_comment_feed() && exmachina_get_option( 'redirect_comments_feed' ) ) {
    wp_redirect( $comments_feed_uri, 302 );
    exit;
  }

} // end function exmachina_feed_redirect()