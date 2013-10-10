<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * General Functions
 *
 * general.php
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

/**
 * Admin Redirect
 *
 * Redirect the user to an admin page and add query args to the URL string for
 * alerts, etc.
 *
 * @link http://codex.wordpress.org/Function_Reference/menu_page_url
 * @link http://codex.wordpress.org/Function_Reference/add_query_arg
 * @link http://codex.wordpress.org/Function_Reference/wp_redirect
 *
 * @since 1.0.0
 *
 * @param  string $page       Menu slug.
 * @param  array  $query_args Optional. Associative array of query string arguments.
 * @return null               Return early if not on a page.
 */
function exmachina_admin_redirect( $page, array $query_args = array() ) {

  /* If not a page, return. */
  if ( ! $page )
    return;

  /* Define the menu page url. */
  $url = html_entity_decode( menu_page_url( $page, 0 ) );

  /* Loop through and unset the $query_args. */
  foreach ( (array) $query_args as $key => $value ) {
    if ( empty( $key ) && empty( $value ) ) {
      unset( $query_args[$key] );
    } // end if (empty($key) && empty($value))
  } // end foreach ((array) $query_args as $key => $value)

  /* Add the $query_args to the url. */
  $url = add_query_arg( $query_args, $url );

  /* Redirect to the admin page. */
  wp_redirect( esc_url_raw( $url ) );

} // end function exmachina_admin_redirect()


/**
 * Menu Page Check
 *
 * Check to see that the theme is targetting a specific admin page.
 *
 * @since 1.0.0
 *
 * @global string   $page_hook  Page hook of the current page.
 * @param  string   $pagehook   Page hook string to check.
 * @return boolean              Returns true if the global $page_hook matches the given $pagehook.
 */
function exmachina_is_menu_page( $pagehook = '' ) {

  /* Globalize the $page_hook variable. */
  global $page_hook;

  /* Return true if on the define $pagehook. */
  if ( isset( $page_hook ) && $page_hook === $pagehook )
    return true;

  /* May be too early for $page_hook. */
  if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] === $pagehook )
    return true;

  /* Otherwise, return false. */
  return false;

} // end function exmachina_is_menu_page()

/**
 * Get Help Sidebar
 *
 * Adds a help tab to the theme settings screen if the theme has provided a
 * 'Documentation URI' and/or 'Support URI'. Theme developers can add custom help
 * tabs using get_current_screen()->add_help_tab().
 *
 * @todo move this function
 *
 * @since 1.0.0
 * @access public
 *
 * @return void
 */
function exmachina_get_help_sidebar() {

  /* Get the parent theme data. */
  $theme = wp_get_theme( get_template() );
  $theme_uri = $theme->get( 'ThemeURI' );
  $author_uri = $theme->get( 'AuthorURI' );
  $doc_uri = $theme->get( 'Documentation URI' );
  $support_uri = $theme->get( 'Support URI' );

  /* If the theme has provided a theme or author URI, add them to the help text. */
  if ( !empty( $theme_uri ) || !empty( $author_uri ) ) {

    /* Open an unordered list for the help text. */
    $help = '<p><strong>' . sprintf( esc_html__( '%1s %2s:', 'exmachina-core' ), __( 'About', 'exmachina-core' ), $theme->get( 'Name' ) ) . '</strong></p>';
    //$help = '<p><strong>' . __( 'For more information:', 'exmachina-core' ) . '</strong></p>';
    $help .= '<ul>';

    /* Add the Documentation URI. */
    if ( !empty( $theme_uri ) )
      $help .= '<li><a href="' . esc_url( $theme_uri ) . '" target="_blank" title="' . __( 'Theme Homepage', 'exmachina-core' ) . '">' . __( 'Theme Homepage', 'exmachina-core' ) . '</a></li>';

    /* Add the Support URI. */
    if ( !empty( $author_uri ) )
      $help .= '<li><a href="' . esc_url( $author_uri ) . '" target="_blank" title="' . __( 'Author Homepage', 'exmachina-core' ) . '">' . __( 'Author Homepage', 'exmachina-core' ) . '</a></li>';

    /* Close the unordered list for the help text. */
    $help .= '</ul>';

  }


  /* If the theme has provided a documentation or support URI, add them to the help text. */
  if ( !empty( $doc_uri ) || !empty( $support_uri ) ) {

    /* Open an unordered list for the help text. */
    $help .= '<p><strong>' . __( 'For more information:', 'exmachina-core' ) . '</strong></p>';
    $help .= '<ul>';

    /* Add the Documentation URI. */
    if ( !empty( $doc_uri ) )
      $help .= '<li><a href="' . esc_url( $doc_uri ) . '" target="_blank" title="' . __( 'Documentation', 'exmachina-core' ) . '">' . __( 'Documentation', 'exmachina-core' ) . '</a></li>';

    /* Add the Support URI. */
    if ( !empty( $support_uri ) )
      $help .= '<li><a href="' . esc_url( $support_uri ) . '" target="_blank" title="' . __( 'Support', 'exmachina-core' ) . '">' . __( 'Support', 'exmachina-core' ) . '</a></li>';

    /* Close the unordered list for the help text. */
    $help .= '</ul>';

  }

  /* Return the help content. */
  return $help;

} // end function exmachina_get_help_sidebar()

/**
 * Code Markup
 *
 * Mark up content with code tags. Escapes all HTML, so `<` gets changed to
 * `&lt;` and displays correctly. Used almost exclusively within labels and
 * text in user interfaces added by ExMachina.
 *
 * @todo inline comment
 * @todo docblock comment
 * @todo move this function
 *
 * @since 1.0.0
 * @access public
 *
 * @param  string $content Content to be wrapped in code tags.
 * @return string          Content wrapped in code tags.
 */
function exmachina_code( $content ) {

  return '<code>' . esc_html( $content ) . '</code>';

} // end function exmachina_code()
