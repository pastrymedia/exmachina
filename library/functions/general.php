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
 * @access public
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
 * @access public
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
 * @todo inline comment
 * @todo docblock comment
 * @todo organize markup
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

/*-------------------------------------------------------------------------*/
/* == Formatting Functions */
/*-------------------------------------------------------------------------*/

/**
 * Truncate Phrase
 *
 * Return a phrase shortened in length to a maximum number of characters. Result
 * will be truncated at the last white space in the original string. In this
 * function the word separator is a single space. Other white space characters
 * (like newlines and tabs) are ignored.
 *
 * If the first `$max_characters` of the string does not contain a space character,
 * an empty string will be returned.
 *
 * @todo inline comment
 * @todo compare against omega
 *
 * @since 0.5.0
 * @access public
 *
 * @param string $text            A string to be shortened.
 * @param integer $max_characters The maximum number of characters to return.
 * @return string Truncated string
 */
function exmachina_truncate_phrase( $text, $max_characters ) {

  $text = trim( $text );

  if ( mb_strlen( $text ) > $max_characters ) {
    //* Truncate $text to $max_characters + 1
    $text = mb_substr( $text, 0, $max_characters + 1 );

    //* Truncate to the last space in the truncated string
    $text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
  }

  return $text;
} // end function exmachina_truncate_phrase()

/**
 * Get the Content Limit
 *
 * Return content stripped down and limited content. Strips out tags and
 * shortcodes, limits the output to `$max_char` characters, and appends an
 * ellipsis and more link to the end.
 *
 * @todo inline comment
 * @todo compare against omega
 *
 * @link http://codex.wordpress.org/Function_Reference/get_the_content
 * @link http://codex.wordpress.org/Function_Reference/strip_shortcodes
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 *
 * @uses exmachina_truncate_phrase() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param integer $max_characters The maximum number of characters to return.
 * @param string  $more_link_text Optional. Text of the more link.
 * @param bool    $stripteaser    Optional. Strip teaser content before the more text.
 * @return string Limited content.
 */
function get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

  $content = get_the_content( '', $stripteaser );

  //* Strip tags and shortcodes so the content truncation count is done correctly
  $content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

  //* Remove inline styles / scripts
  $content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

  //* Truncate $content to $max_char
  $content = exmachina_truncate_phrase( $content, $max_characters );

  //* More link?
  if ( $more_link_text ) {
    $link   = apply_filters( 'get_the_content_more_link', sprintf( '&#x02026; <a href="%s" class="more-link">%s</a>', get_permalink(), $more_link_text ), $more_link_text );
    $output = sprintf( '<p>%s %s</p>', $content, $link );
  } else {
    $output = sprintf( '<p>%s</p>', $content );
    $link = '';
  }

  return apply_filters( 'get_the_content_limit', $output, $content, $link, $max_characters );

} // end function get_the_content_limit()

/**
 * The Content Limit
 *
 * Echo the limited content.
 *
 * @todo inline comment
 * @todo compare against omega
 *
 * @uses get_the_content_limit() Return content stripped down and limited content.
 *
 * @since 0.5.0
 * @access public
 *
 * @param integer $max_characters The maximum number of characters to return.
 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
 */
function the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

  $content = get_the_content_limit( $max_characters, $more_link_text, $stripteaser );
  echo apply_filters( 'the_content_limit', $content );

} // end function the_content_limit()

/**
 * No Follow Links
 *
 * Add `rel="nofollow"` attribute and value to links within string passed in.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_rel_nofollow
 *
 * @uses exmachina_strip_attr() Remove any existing rel attribute from links.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string $text HTML markup.
 * @return string       Amendment HTML markup.
 */
function exmachina_rel_nofollow( $text ) {

  $text = exmachina_strip_attr( $text, 'a', 'rel' );
  return stripslashes( wp_rel_nofollow( $text ) );

} // end function exmachina_rel_nofollow()

/**
 * Strip Attributes
 *
 * Remove attributes from a HTML element. This function accepts a string of
 * HTML, parses it for any elements in the `$elements` array, then parses each
 * element for any attributes in the `$attributes` array, and strips the
 * attribute and its value(s).
 *
 * ~~~
 * // Strip class attribute from an anchor
 * exmachina_strip_attr(
 *     '<a class="my-class" href="http://google.com/">Google</a>',
 *     'a',
 *     'class'
 * );
 * // Strips class and id attributes from div and span elements
 * exmachina_strip_attr(
 *     '<div class="my-class" id="the-div"><span class="my-class" id="the-span"></span></div>',
 *     array( 'div', 'span' ),
 *     array( 'class', 'id' )
 * );
 * ~~~
 *
 * @todo inline comment
 * @todo cleanup docblock
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string       $text       A string of HTML formatted code.
 * @param  array|string $elements   Elements that $attributes should be stripped from.
 * @param  array|string $attributes Attributes that should be stripped from $elements.
 * @param  boolean      $two_passes Whether the function should allow two passes.
 * @return string                   HTML markup with attributes stripped.
 */
function exmachina_strip_attr( $text, $elements, $attributes, $two_passes = true ) {

  //* Cache elements pattern
  $elements_pattern = implode( '|', (array) $elements );

  //* Build patterns
  $patterns = array();
  foreach ( (array) $attributes as $attribute ) {
    //* Opening tags
    $patterns[] = sprintf( '~(<(?:%s)[^>]*)\s+%s=[\\\'"][^\\\'"]+[\\\'"]([^>]*[^>]*>)~', $elements_pattern, $attribute );

    //* Self closing tags
    $patterns[] = sprintf( '~(<(?:%s)[^>]*)\s+%s=[\\\'"][^\\\'"]+[\\\'"]([^>]*[^/]+/>)~', $elements_pattern, $attribute );
  }

  //* First pass
  $text = preg_replace( $patterns, '$1$2', $text );

  if ( $two_passes ) //* Second pass
    $text = preg_replace( $patterns, '$1$2', $text );

  return $text;

} // end function exmachina_strip_attr()

/**
 * Sanitize HTML Classes
 *
 * Sanitize multiple HTML classes in one pass. Accepts either an array of
 * `$classes`, or a space separated string of classes and sanitizes them using
 * the `sanitize_html_class()` WordPress function.
 *
 * @todo inline comment
 *
 * @since 0.5.0
 * @access public
 *
 * @param  $classes       array|string Classes to be sanitized.
 * @param  $return_format string       Optional. The return format, 'input', 'string', or 'array'. Default is 'input'.
 * @return array|string Sanitized classes.
 */
function exmachina_sanitize_html_classes( $classes, $return_format = 'input' ) {

  if ( 'input' === $return_format ) {
    $return_format = is_array( $classes ) ? 'array' : 'string';
  }

  $classes = is_array( $classes ) ? $classes : explode( ' ', $classes );

  $sanitized_classes = array_map( 'sanitize_html_class', $classes );

  if ( 'array' === $return_format )
    return $sanitized_classes;
  else
    return implode( ' ', $sanitized_classes );

} // end function exmachina_sanitize_html_classes()

/**
 * Allowed Tags Formatting
 *
 * Return an array of allowed tags for output formatting. Mainly used by
 * `wp_kses()` for sanitizing output.
 *
 * @todo inline comment
 *
 * @since 0.5.0
 * @access public
 *
 * @return array Allowed tags.
 */
function exmachina_formatting_allowedtags() {

  return apply_filters(
    'exmachina_formatting_allowedtags',
    array(
      'a'          => array( 'href' => array(), 'title' => array(), ),
      'b'          => array(),
      'blockquote' => array(),
      'br'         => array(),
      'div'        => array( 'align' => array(), 'class' => array(), 'style' => array(), ),
      'em'         => array(),
      'i'          => array(),
      'p'          => array( 'align' => array(), 'class' => array(), 'style' => array(), ),
      'span'       => array( 'align' => array(), 'class' => array(), 'style' => array(), ),
      'strong'     => array(),

      //* <img src="" class="" alt="" title="" width="" height="" />
      //'img'        => array( 'src' => array(), 'class' => array(), 'alt' => array(), 'width' => array(), 'height' => array(), 'style' => array() ),
    )
  );

} // end function exmachina_formatting_allowedtags()

/**
 * Formatting Kses Wrapper
 *
 * Wrapper for `wp_kses()` that can be used as a filter function.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_kses
 *
 * @uses exmachina_formatting_allowedtags() List of allowed HTML elements.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string $string Content to filter through kses.
 * @return string
 */
function exmachina_formatting_kses( $string ) {

  return wp_kses( $string, exmachina_formatting_allowedtags() );

} // end function exmachina_formatting_kses()

/**
 * Human Time Difference
 *
 * Calculate the time difference - a replacement for `human_time_diff()` until
 * it is improved. Based on BuddyPress function `bp_core_time_since()`, which in
 * turn is based on functions created by Dunstan Orchard - http://1976design.com
 *
 * This function will return an text representation of the time elapsed since a
 * given date, giving the two largest units e.g.:
 *
 *  - 2 hours and 50 minutes
 *  - 4 days
 *  - 4 weeks and 6 days
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @link http://codex.wordpress.org/Function_Reference/absint
 * @link http://codex.wordpress.org/Function_Reference/translate_nooped_plural
 *
 * @since 0.5.0
 * @access public
 *
 * @param  $older_date int Unix timestamp of date you want to calculate the time since for`
 * @param  $newer_date int Optional. Unix timestamp of date to compare older date to. Default false (current time)`
 * @return str The time difference
 */
function exmachina_human_time_diff( $older_date, $newer_date = false ) {

  //* If no newer date is given, assume now
  $newer_date = $newer_date ? $newer_date : time();

  //* Difference in seconds
  $since = absint( $newer_date - $older_date );

  if ( ! $since )
    return '0 ' . _x( 'seconds', 'time difference', 'exmachina' );

  //* Hold units of time in seconds, and their pluralised strings (not translated yet)
  $units = array(
    array( 31536000, _nx_noop( '%s year', '%s years', 'time difference' ) ),  // 60 * 60 * 24 * 365
    array( 2592000, _nx_noop( '%s month', '%s months', 'time difference' ) ), // 60 * 60 * 24 * 30
    array( 604800, _nx_noop( '%s week', '%s weeks', 'time difference' ) ),    // 60 * 60 * 24 * 7
    array( 86400, _nx_noop( '%s day', '%s days', 'time difference' ) ),       // 60 * 60 * 24
    array( 3600, _nx_noop( '%s hour', '%s hours', 'time difference' ) ),      // 60 * 60
    array( 60, _nx_noop( '%s minute', '%s minutes', 'time difference' ) ),
    array( 1, _nx_noop( '%s second', '%s seconds', 'time difference' ) ),
  );

  //* Step one: the first unit
  for ( $i = 0, $j = count( $units ); $i < $j; $i++ ) {
    $seconds = $units[$i][0];

    //* Finding the biggest chunk (if the chunk fits, break)
    if ( ( $count = floor( $since / $seconds ) ) !== 0 )
      break;
  }

  //* Translate unit string, and add to the output
  $output = sprintf( translate_nooped_plural( $units[$i][1], $count, 'exmachina' ), $count );

  //* Note the next unit
  $ii = $i + 1;

  //* Step two: the second unit
  if ( $ii < $j ) {
    $seconds2 = $units[$ii][0];

    //* Check if this second unit has a value > 0
    if ( ( $count2 = floor( ( $since - ( $seconds * $count ) ) / $seconds2 ) ) !== 0 )
      //* Add translated separator string, and translated unit string
      $output .= sprintf( ' %s ' . translate_nooped_plural( $units[$ii][1], $count2, 'exmachina' ), _x( 'and', 'separator in time difference', 'exmachina' ), $count2 );
  }

  return $output;

} // end function exmachina_human_time_diff()

/**
 * Code Markup
 *
 * Mark up content with code tags. Escapes all HTML, so `<` gets changed to
 * `&lt;` and displays correctly. Used almost exclusively within labels and
 * text in user interfaces.
 *
 * @since 1.0.0
 * @access public
 *
 * @param  string $content Content to be wrapped in code tags.
 * @return string          Content wrapped in code tags.
 */
function exmachina_code( $content ) {

  /* Returns code markup. */
  return '<code>' . esc_html( $content ) . '</code>';

} // end function exmachina_code()

/*-------------------------------------------------------------------------*/
/* == Author Box Functions */
/*-------------------------------------------------------------------------*/

/**
 * Enable Author Box
 *
 * Enable the author box for all users.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
 * @link http://codex.wordpress.org/Function_Reference/add_filter
 *
 * @since 1.0.0
 * @access public
 *
 * @param array $args Optional. Args for enabling author box. Default is empty array.
 */
function exmachina_enable_author_box( $args = array() ) {

  /* Parse the author box arguments. */
  $args = wp_parse_args( $args, array( 'type' => 'single' ) );

  /* If single, return true on 'get_the_author_exmachina_author_box_single'. */
  if ( 'single' === $args['type'] )
    add_filter( 'get_the_author_exmachina_author_box_single', '__return_true' );

  /* If archive, return true on 'get_the_author_exmachina_author_box_archive'. */
  elseif ( 'archive' === $args['type'] )
    add_filter( 'get_the_author_exmachina_author_box_archive', '__return_true' );

} // end function exmachina_enable_author_box()

/*-------------------------------------------------------------------------*/
/* == Redirect Functions */
/*-------------------------------------------------------------------------*/

/* Adds the custom field redirect to the template_redirect hook. */
add_action( 'template_redirect', 'exmachina_custom_field_redirect' );

/**
 * Custom Field Redirect
 *
 * Redirects based on a single post/page custom field. To use this function,
 * set a custom field key to "redirect" and provide a URL in the custom field
 * value. This function will perform a 301 redirect to the provided URL.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 * @link http://codex.wordpress.org/Function_Reference/wp_redirect
 * @link http://codex.wordpress.org/Function_Reference/esc_url_raw
 *
 * @uses exmachina_get_custom_field() [description]
 *
 * @since 1.0.0
 * @access public
 *
 * @return null Returns early is not singular.
 */
function exmachina_custom_field_redirect() {

  /* Return early if not on singular post/page. */
  if ( ! is_singular() )
    return;

  /* If custom field key 'redirect' exists. */
  if ( $url = exmachina_get_custom_field( 'redirect' ) ) {

    /* 301 redirect to the provided URL. */
    wp_redirect( esc_url_raw( $url ), 301 );
    exit;

  } // end IF statement

} // end function exmachina_custom_field_redirect()

/*-------------------------------------------------------------------------*/
/* == Plugin Functions */
/*-------------------------------------------------------------------------*/

/**
 * Detect Plugin
 *
 * Detect active plugin by constant, class or function existence. This
 * function is useful for checking if functionality is being replaced by a
 * plugin and for name space collisions.
 *
 * @since 1.0.0
 * @access public
 *
 * @param  array $plugins Array of constants, classes and / or functions to check.
 * @return boolean        True if plugin exists.
 */
function exmachina_detect_plugin( array $plugins ) {

  /* Check for classes. */
  if ( isset( $plugins['classes'] ) ) {
    foreach ( $plugins['classes'] as $name ) {
      if ( class_exists( $name ) )
        return true;
    } // end foreach loop
  } // end IF statement

  /* Check for functions. */
  if ( isset( $plugins['functions'] ) ) {
    foreach ( $plugins['functions'] as $name ) {
      if ( function_exists( $name ) )
        return true;
    } // end foreach loop
  } // end IF statement

  //* Check for constants. */
  if ( isset( $plugins['constants'] ) ) {
    foreach ( $plugins['constants'] as $name ) {
      if ( defined( $name ) )
        return true;
    } // end foreach loop
  } // end IF statement

  /* No class, function or constant found to exist. */
  return false;

} // end function exmachina_detect_plugin()

/**
 * Plugin Install Link
 *
 * Build links to install plugins. Checks against the network admin (for multisite
 * installations), and builds the appropiate thickbox plugin install link.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_main_site
 * @link http://codex.wordpress.org/Function_Reference/network_admin_url
 * @link http://codex.wordpress.org/Function_Reference/admin_url
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 * @link http://codex.wordpress.org/Function_Reference/esc_html
 *
 * @since 1.0.0
 * @access public
 *
 * @param  string $plugin_slug Plugin slug.
 * @param  string $text        Plugin name.
 * @return string              HTML markup for links.
 */
function exmachina_plugin_install_link( $plugin_slug = '', $text = '' ) {

  /* Builds plugin install link for multisite installations. */
  if ( is_main_site() ) {
    $url = network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_slug . '&TB_iframe=true&width=600&height=550' );
  }
  /* Builds regular install link. */
  else {
    $url = admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_slug . '&TB_iframe=true&width=600&height=550' );
  }

  /* Builds the install link title text. */
  $title_text = sprintf( __( 'Install %s', 'exmachina-core' ), $text );

  /* Returns the link string. */
  return sprintf( '<a href="%s" class="thickbox" title="%s">%s</a>', esc_url( $url ), esc_attr( $title_text ), esc_html( $text ) );

} // end function exmachina_plugin_install_link()

/*-------------------------------------------------------------------------*/
/* == Theme Support Functions */
/*-------------------------------------------------------------------------*/

/**
 * Get Theme Support Arguments
 *
 * Return a specific value from the associative array passed as the second argument
 * to `add_theme_support()`.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 *
 * @since 1.0.0
 * @access public
 *
 * @param string $feature The theme feature.
 * @param string $arg     The theme feature argument.
 * @param string $default Fallback if value is blank or doesn't exist.
 *
 * @return mixed Return $default if theme doesn't support $feature, or $arg key doesn't exist.
 */
function exmachina_get_theme_support_arg( $feature, $arg, $default = '' ) {

  /* Get the theme-supported feature. */
  $support = get_theme_support( $feature );

  /* Returns $default if doesn't exist. */
  if ( ! $support || ! isset( $support[0] ) || ! array_key_exists( $arg, (array) $support[0] ) )
    return $default;

  /* Otherwise, returns the argument. */
  return $support[0][ $arg ];

} // end function exmachina_get_theme_support_arg()

/*-------------------------------------------------------------------------*/
/* == Custom Post Type Functions */
/*-------------------------------------------------------------------------*/

/**
 * Get Global Post Type Name
 *
 * Get the `post_type` from the global `$post` if supplied value is empty.
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Post
 *
 * @since 1.0.0
 * @access public
 *
 * @global object $post           WP_Post post object.
 * @param  string $post_type_name Post type name.
 * @return string
 */
function exmachina_get_global_post_type_name( $post_type_name = '' ) {

  /* If isn't post type name, fetch it from the post. */
  if ( ! $post_type_name ) {

    /* Get the post object. */
    global $post;

    /* Set the post type name. */
    $post_type_name = $post->post_type;

  } // end IF statement

  /* Return the post type name. */
  return $post_type_name;

} // end function exmachina_get_global_post_type_name()

/**
 * Get CPT Archive Types
 *
 * Get list of custom post type objects which need an archive settings page.
 * Archive settings pages are added for CPTs that are:
 *
 * - are public,
 * - are set to show the UI,
 * - are set to show in the admin menu,
 * - have an archive enabled,
 * - not one of the built-in types,
 * - support "exmachina-cpt-archive-settings".
 *
 * This last item means that if you're using an archive template and don't want
 * ExMachina interfering with it with these archive settings, then don't add the
 * support. This support check is handled in exmachina_has_post_type_archive_support().
 *
 * Applies the `exmachina_cpt_archives_args` filter, to change the conditions for
 * which post types are deemed valid.
 *
 * The results are held in a static variable, since they won't change over the
 * course of a request.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_post_types
 *
 * @since 1.0.0
 * @access public
 *
 * @return array
 */
function exmachina_get_cpt_archive_types() {

  /* Set the statice variable. */
  static $exmachina_cpt_archive_types;

  /* If the variable is already set, return. */
  if ( $exmachina_cpt_archive_types )
    return $exmachina_cpt_archive_types;

  /* Set the post tye args array. Filterable via 'exmachina_cpt_archives_args'. */
  $args = apply_filters(
    'exmachina_cpt_archives_args',
    array(
      'public'       => true,
      'show_ui'      => true,
      'show_in_menu' => true,
      'has_archive'  => true,
      '_builtin'     => false,
    )
  );

  /* Get the post type objects with matching arguments. */
  $exmachina_cpt_archive_types = get_post_types( $args, 'objects' );

  /* Return the custom post type array. */
  return $exmachina_cpt_archive_types;

} // end function exmachina_get_cpt_archive_types()

/**
 * CPT Archives Types Names
 *
 * Get list of custom post type names which need an archive settings page.
 *
 * @uses exmachina_get_cpt_archive_types() Array of custom post types which
 *                                         need archive pages.
 *
 * @since 1.0.0
 * @access public
 *
 * @return array Custom post type names.
 */
function exmachina_get_cpt_archive_types_names() {

  /* Set the post types names array. */
  $post_type_names = array();

  /* Loop the custom post types that need archive pages. */
  foreach ( exmachina_get_cpt_archive_types() as $post_type )
    $post_type_names[] = $post_type->name;

  /* Return the array of post types. */
  return $post_type_names;

} // end function exmachina_get_cpt_archive_types_names()

/**
 * Has Post Type Archive Support
 *
 * Check if a post type supports an archive setting page.
 *
 * @link http://codex.wordpress.org/Function_Reference/post_type_supports
 *
 * @uses exmachina_get_global_post_type_name()   Get the `post_type` from the global `$post` if supplied value is empty.
 * @uses exmachina_get_cpt_archive_types_names() Get list of custom post type names which need an archive settings page.
 *
 * @since 1.0.0
 * @access public
 *
 * @param  string $post_type_name Post type name.
 * @return bool                   True if custom post type name has support, false otherwise.
 */
function exmachina_has_post_type_archive_support( $post_type_name = '' ) {

  /* Get the post types which can use archive support. */
  $post_type_name = exmachina_get_global_post_type_name( $post_type_name );

  /* Return true if the post type can use archive support, and if theme support allows it. */
  return in_array( $post_type_name, exmachina_get_cpt_archive_types_names() ) &&
    post_type_supports( $post_type_name, 'exmachina-cpt-archives-settings' );

} // end function exmachina_has_post_type_archive_support()

/*-------------------------------------------------------------------------*/
/* == Conditional Functions */
/*-------------------------------------------------------------------------*/

/**
 * HTML5 Conditional
 *
 * Determine if HTML5 is activated by the child theme.
 *
 * @link https://codex.wordpress.org/Semantic_Markup
 * @link https://codex.wordpress.org/current_theme_supports
 *
 * @since 1.0.0
 * @access public
 *
 * @return bool True if HTML5, false otherwise.
 */
function exmachina_html5() {

  return current_theme_supports( 'html5' );

} // end function exmachina_html5()

/**
 * Customizer Conditional
 *
 * Check whether we are currently viewing the site via the WordPress Customizer.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @link https://codex.wordpress.org/Theme_Customization_API
 *
 * @since 1.0.0
 * @access public
 *
 * @global object  $wp_customize Customizer API object.
 * @return boolean               Return true if on Customizer, false otherwise.
 */
function exmachina_is_customizer() {
  global $wp_customize;

  /* if $wp_customize is set, return true. */
  if ( isset( $wp_customize ) )
    return true;

  /* Otherwise, false. */
  return false;

} // end function exmachina_is_customizer()

/*-------------------------------------------------------------------------*/
/* == Theme Update Functions */
/*-------------------------------------------------------------------------*/

/* Adds the don't update theme to the http_request_args hook. */
add_filter( 'http_request_args', 'exmachina_dont_update_theme', 5, 2 );
/**
 * Don't Update Theme
 *
 * If there is a theme in the WordPress repo with the same name, this prevents
 * WordPress from prompting an update.
 *
 * @since 1.0.0
 * @access private
 *
 * @param  array  $r   Request arguments
 * @param  string $url Request url
 * @return array       Request arguments
 */

function exmachina_dont_update_theme( $r, $url ) {

  /* If not a theme update request, bail immediately. */
  if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
    return $r;

  /* Unserialize the update request. */
  $themes = unserialize( $r['body']['themes'] );

  /* Remove as a template (parent theme) update. */
  unset( $themes[ get_option( 'template' ) ] );

  /* Remove as a stylesheet (child theme) update. */
  unset( $themes[ get_option( 'stylesheet' ) ] );

  /* Re-serialize the update request. */
  $r['body']['themes'] = serialize( $themes );

  /* Return the request args. */
  return $r;
} // end function exmachina_dont_update_theme()
