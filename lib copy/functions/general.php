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
 * Enable the author box for ALL users.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 *
 * @param array $args Optional. Arguments for enabling author box. Default is empty array.
 */
function exmachina_enable_author_box( $args = array() ) {

  $args = wp_parse_args( $args, array( 'type' => 'single' ) );

  if ( 'single' === $args['type'] )
    add_filter( 'get_the_author_exmachina_author_box_single', '__return_true' );
  elseif ( 'archive' === $args['type'] )
    add_filter( 'get_the_author_exmachina_author_box_archive', '__return_true' );

} // end function exmachina_enable_author_box()

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
 * @since 0.5.0
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

add_action( 'template_redirect', 'exmachina_custom_field_redirect' );
/**
 * Redirect singular page to an alternate URL.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 */
function exmachina_custom_field_redirect() {

  if ( ! is_singular() )
    return;

  if ( $url = exmachina_get_custom_field( 'redirect' ) ) {

    wp_redirect( esc_url_raw( $url ), 301 );
    exit;

  }

} // end function exmachina_custom_field_redirect()

/**
 * Get Theme Support Arguments
 *
 * Return a specific value from the associative array passed as the second argument
 * to `add_theme_support()`.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 *
 * @param string $feature The theme feature.
 * @param string $arg     The theme feature argument.
 * @param string $default Fallback if value is blank or doesn't exist.
 *
 * @return mixed Return $default if theme doesn't support $feature, or $arg key doesn't exist.
 */
function exmachina_get_theme_support_arg( $feature, $arg, $default = '' ) {

  $support = get_theme_support( $feature );

  if ( ! $support || ! isset( $support[0] ) || ! array_key_exists( $arg, (array) $support[0] ) )
    return $default;

  return $support[0][ $arg ];

} // end function exmachina_get_theme_support_arg()

/**
 * Detect Plugin
 *
 * Detect active plugin by constant, class or function existence.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 *
 * @param array $plugins Array of array for constants, classes and / or functions to check for plugin existence.
 * @return boolean True if plugin exists or false if plugin constant, class or function not detected.
 */
function exmachina_detect_plugin( array $plugins ) {

  //* Check for classes
  if ( isset( $plugins['classes'] ) ) {
    foreach ( $plugins['classes'] as $name ) {
      if ( class_exists( $name ) )
        return true;
    }
  }

  //* Check for functions
  if ( isset( $plugins['functions'] ) ) {
    foreach ( $plugins['functions'] as $name ) {
      if ( function_exists( $name ) )
        return true;
    }
  }

  //* Check for constants
  if ( isset( $plugins['constants'] ) ) {
    foreach ( $plugins['constants'] as $name ) {
      if ( defined( $name ) )
        return true;
    }
  }

  //* No class, function or constant found to exist
  return false;

} // end function exmachina_detect_plugin()

/**
 * Menu Page Check
 *
 * Check to see that the theme is targetting a specific admin page.
 *
 * @since 0.5.0
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
 * Customizer Conditional
 *
 * Check whether we are currently viewing the site via the WordPress Customizer.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 * @access public
 *
 * @global $wp_customize Customizer.
 * @return boolean Return true if viewing page via Customizer, false otherwise.
 */
function exmachina_is_customizer() {

  global $wp_customize;

  if ( isset( $wp_customize ) )
    return true;

  return false;

} // end function exmachina_is_customizer()

/**
 * Get Global Post Type Name
 *
 * Get the `post_type` from the global `$post` if supplied value is empty.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 * @access public
 *
 * @global WP_Post $post Post object.
 * @param  string $post_type_name Post type name.
 * @return string
 */
function exmachina_get_global_post_type_name( $post_type_name = '' ) {

  if ( ! $post_type_name ) {
    global $post;
    $post_type_name = $post->post_type;
  }
  return $post_type_name;

} // end function exmachina_get_global_post_type_name()

/**
 * Get CPT Archive Types
 *
 * Get list of custom post type objects which need an archive settings page.
 *
 * Archive settings pages are added for CPTs that:
 *
 * - are public,
 * - are set to show the UI,
 * - are set to show in the admin menu,
 * - have an archive enabled,
 * - not one of the built-in types,
 * - support "exmachina-cpt-archive-settings".
 *
 * This last item means that if you're using an archive template and don't want ExMachina interfering with it with these
 * archive settings, then don't add the support. This support check is handled in
 * {@link exmachina_has_post_type_archive_support()}.
 *
 * Applies the `exmachina_cpt_archives_args` filter, to change the conditions for which post types are deemed valid.
 *
 * The results are held in a static variable, since they won't change over the course of a request.
 *
 * @todo inline comment
 * @todo inline docblock
 *
 * @since 0.5.0
 * @access public
 *
 * @return array
 */
function exmachina_get_cpt_archive_types() {

  static $exmachina_cpt_archive_types;
  if ( $exmachina_cpt_archive_types )
    return $exmachina_cpt_archive_types;

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

  $exmachina_cpt_archive_types = get_post_types( $args, 'objects' );

  return $exmachina_cpt_archive_types;

} // end function exmachina_get_cpt_archive_types()

/**
 * CPT Archives Types Names
 *
 * Get list of custom post type names which need an archive settings page.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @uses exmachina_get_cpt_archive_types() Get list of custom post type objects which need an archive settings page.
 *
 * @since 0.5.0
 * @access public
 *
 * @return array Custom post type names.
 */
function exmachina_get_cpt_archive_types_names() {

  $post_type_names = array();
  foreach ( exmachina_get_cpt_archive_types() as $post_type )
    $post_type_names[] = $post_type->name;

  return $post_type_names;

} // end function exmachina_get_cpt_archive_types_names()

/**
 * Has Post Type Archive Support
 *
 * Check if a post type supports an archive setting page.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @uses exmachina_get_global_post_type_name()   Get the `post_type` from the global `$post` if supplied value is empty.
 * @uses exmachina_get_cpt_archive_types_names() Get list of custom post type names which need an archive settings page.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string $post_type_name Post type name.
 * @return bool                   True if custom post type name has support, false otherwise.
 */
function exmachina_has_post_type_archive_support( $post_type_name = '' ) {

  $post_type_name = exmachina_get_global_post_type_name( $post_type_name );

  return in_array( $post_type_name, exmachina_get_cpt_archive_types_names() ) &&
    post_type_supports( $post_type_name, 'exmachina-cpt-archives-settings' );

} // end function exmachina_has_post_type_archive_support()

/**
 * HTML5 Conditional
 *
 * Determine if HTML5 is activated by the child theme.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 * @access public
 *
 * @return bool True if current theme supports exmachina-html5, false otherwise.
 */
function exmachina_html5() {

  return current_theme_supports( 'html5' );

} // end function exmachina_html5()

/**
 * Plugin Install Link
 *
 * Build links to install plugins.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string $plugin_slug Plugin slug.
 * @param  string $text        Plugin name.
 * @return string              HTML markup for links.
 */
function exmachina_plugin_install_link( $plugin_slug = '', $text = '' ) {

  if ( is_main_site() ) {
    $url = network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_slug . '&TB_iframe=true&width=600&height=550' );
  }
  else {
    $url = admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_slug . '&TB_iframe=true&width=600&height=550' );
  }

  $title_text = sprintf( __( 'Install %s', 'exmachina' ), $text );

  return sprintf( '<a href="%s" class="thickbox" title="%s">%s</a>', esc_url( $url ), esc_attr( $title_text ), esc_html( $text ) );

} // end function exmachina_plugin_install_link()

// Don't update theme
add_filter( 'http_request_args', 'exmachina_dont_update_theme', 5, 2 );
/**
 * Don't Update Theme
 *
 * If there is a theme in the repo with the same name, this prevents WP from
 * prompting an update.
 *
 * @todo inline comment
 *
 * @since 0.5.0
 * @access private
 *
 * @param  array  $r   Request arguments
 * @param  string $url Request url
 * @return array       Request arguments
 */

function exmachina_dont_update_theme( $r, $url ) {
  if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
    return $r; // Not a theme update request. Bail immediately.
  $themes = unserialize( $r['body']['themes'] );
  unset( $themes[ get_option( 'template' ) ] );
  unset( $themes[ get_option( 'stylesheet' ) ] );
  $r['body']['themes'] = serialize( $themes );
  return $r;
} // end function exmachina_dont_update_theme()