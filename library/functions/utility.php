<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Utility Functions
 *
 * utility.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Additional helper functions that the framework or themes may use. The functions
 * in this file are functions that don't really have a home within any other parts
 * of the framework.
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

/* Add extra support for post types. */
add_action( 'init', 'exmachina_add_post_type_support' );

/**
 * Add Post Type Support
 *
 * This function is for adding extra support for features not default to the core
 * post types. Excerpts are added to the 'page' post type.  Comments and trackbacks
 * are added for the 'attachment' post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/add_post_type_support
 *
 * @since 2.5.0
 * @access public
 *
 * @return void
 */
function exmachina_add_post_type_support() {

  /* Add support for excerpts to the 'page' post type. */
  add_post_type_support( 'page', array( 'excerpt' ) );

  /* Add thumbnail support for audio and video attachments. */
  add_post_type_support( 'attachment:audio', 'thumbnail' );
  add_post_type_support( 'attachment:video', 'thumbnail' );

} // end function exmachina_add_post_type_support()

/* Add extra file headers for themes. */
add_filter( 'extra_theme_headers', 'exmachina_extra_theme_headers' );

/**
 * Extra Theme Headers
 *
 * Creates custom theme headers. This is the information shown in the header
 * block of a theme's 'style.css' file. Themes are not required to use this
 * information, but the framework does make use of the data for displaying
 * additional information to the theme user.
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $headers Array of extra headers.
 * @return array          Array of custom headers.
 */
function exmachina_extra_theme_headers( $headers ) {

  /* Add support for 'Template Version'. This is for use in child themes to note the version of the parent theme. */
  if ( !in_array( 'Template Version', $headers ) )
    $headers[] = 'Template Version';

  /* Add support for 'License'.  Proposed in the guidelines for the WordPress.org theme review. */
  if ( !in_array( 'License', $headers ) )
    $headers[] = 'License';

  /* Add support for 'License URI'. Proposed in the guidelines for the WordPress.org theme review. */
  if ( !in_array( 'License URI', $headers ) )
    $headers[] = 'License URI';

  /* Add support for 'Support URI'.  This should be a link to the theme's support forums. */
  if ( !in_array( 'Support URI', $headers ) )
    $headers[] = 'Support URI';

  /* Add support for 'Documentation URI'.  This should be a link to the theme's documentation. */
  if ( !in_array( 'Documentation URI', $headers ) )
    $headers[] = 'Documentation URI';

  /* Return the array of custom theme headers. */
  return $headers;

} // end function exmachina_extra_theme_headers()

/**
 * Meta Template
 *
 * Generates the relevant template info. Adds template meta with theme version.
 * Uses the theme name and version from style.css.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 *
 * @uses apply_atomic() Applies the contextual filter hook.
 *
 * @since 2.5.0
 * @access public
 *
 * @return void
 */
function exmachina_meta_template() {

  /* Get the theme template info. */
  $theme = wp_get_theme( get_template() );

  /* Set the meta template markup. */
  $template = '<meta name="template" content="' . esc_attr( $theme->get( 'Name' ) . ' ' . $theme->get( 'Version' ) ) . '" />' . "\n";

  /* Echo with filters. */
  echo apply_atomic( 'meta_template', $template );

} // end function exmachina_meta_template()

/**
 * Site Title Element
 *
 * Dynamic element to wrap the site title in. If it is the front page, wrap it
 * in an <h1> element. On other pages, wrap it in a <div> element.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_front_page
 * @link http://codex.wordpress.org/Function_Reference/get_bloginfo
 * @link http://codex.wordpress.org/Function_Reference/tag_escape
 * @link http://codex.wordpress.org/Function_Reference/home_url
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 *
 * @uses apply_atomic() Applies the contextual filter hook.
 *
 * @since 2.5.0
 * @access public
 *
 * @return void
 */
function exmachina_site_title() {

  /* If viewing the front page of the site, use an <h1> tag.  Otherwise, use a <div> tag. */
  $tag = ( is_front_page() ) ? 'h1' : 'div';

  /* Get the site title.  If it's not empty, wrap it with the appropriate HTML. */
  if ( $title = get_bloginfo( 'name' ) )
    $title = sprintf( '<%1$s id="site-title"><a href="%2$s" title="%3$s" rel="home"><span>%4$s</span></a></%1$s>', tag_escape( $tag ), home_url(), esc_attr( $title ), $title );

  /* Display the site title and apply filters for developers to overwrite. */
  echo apply_atomic( 'site_title', $title );

} // end function exmachina_site_title()

/**
 * Site Description Element
 *
 * Dynamic element to wrap the site description in. If it is the front page,
 * wrap it in an <h2> element. On other pages, wrap it in a <div> element.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_front_page
 * @link http://codex.wordpress.org/Function_Reference/get_bloginfo
 * @link http://codex.wordpress.org/Function_Reference/tag_escape
 *
 * @uses apply_atomic() Applies the contextual filter hook.
 *
 * @since 2.5.0
 * @access public
 *
 * @return void
 */
function exmachina_site_description() {

  /* If viewing the front page of the site, use an <h2> tag.  Otherwise, use a <div> tag. */
  $tag = ( is_front_page() ) ? 'h2' : 'div';

  /* Get the site description.  If it's not empty, wrap it with the appropriate HTML. */
  if ( $desc = get_bloginfo( 'description' ) )
    $desc = sprintf( '<%1$s id="site-description"><span>%2$s</span></%1$s>', tag_escape( $tag ), $desc );

  /* Display the site description and apply filters for developers to overwrite. */
  echo apply_atomic( 'site_description', $desc );

} // end function exmachina_site_description()

/**
 * Footer Content
 *
 * Standardized function for outputting the footer content.
 *
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 *
 * @uses apply_atomic_shortcode() Applies the contextual shortcode.
 * @uses exmachina_get_option()  Gets the setting from the options db.
 *
 * @since 2.5.0
 * @access public
 *
 * @return void
 */
function exmachina_footer_content() {

  /* Only run the code if the theme supports the ExMachina Core theme settings. */
  if ( current_theme_supports( 'exmachina-core-theme-settings' ) )
    echo apply_atomic_shortcode( 'footer_content', exmachina_get_option( 'footer_insert' ) );

} // end function exmachina_footer_content()

/**
 * Has Post Template
 *
 * Checks if a post of any post type has a custom template. This is the equivalent
 * of WordPress' is_page_template() function with the exception that it works for
 * all post types.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 * @link http://codex.wordpress.org/Function_Reference/get_queried_object
 * @link http://codex.wordpress.org/Function_Reference/get_post_meta
 *
 * @since 2.5.0
 * @access public
 *
 * @param  string $template The name of the template to check for.
 * @return bool             Whether the post has a template.
 */
function exmachina_has_post_template( $template = '' ) {

  /* Assume we're viewing a singular post. */
  if ( is_singular() ) {

    /* Get the queried object. */
    $post = get_queried_object();

    /* Get the post template, which is saved as metadata. */
    $post_template = get_post_meta( get_queried_object_id(), "_wp_{$post->post_type}_template", true );

    /* If a specific template was input, check that the post template matches. */
    if ( !empty( $template) && ( $template == $post_template ) )
      return true;

    /* If no specific template was input, check if the post has a template. */
    elseif ( empty( $template) && !empty( $post_template ) )
      return true;
  }

  /* Return false for everything else. */
  return false;

} // end function exmachina_has_post_template()

/* Filters the title for untitled posts. */
add_filter( 'the_title', 'exmachina_untitled_post' );

/**
 * Untitled Post Filter
 *
 * The WordPress.org theme review requires that a link be provided to the single
 * post page for untitled posts. This is a filter on 'the_title' so that an
 * '(Untitled)' title appears in that scenario, allowing for the normal method
 * to work.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 * @link http://codex.wordpress.org/Function_Reference/in_the_loop
 * @link http://codex.wordpress.org/Function_Reference/is_admin
 *
 * @since 2.5.0
 * @access public
 *
 * @param  string $title The title string.
 * @return string        The title.
 */
function exmachina_untitled_post( $title ) {

  /* If the title is empty, set to '(Untitled)'. */
  if ( empty( $title ) && !is_singular() && in_the_loop() && !is_admin() )
    $title = __( '(Untitled)', 'exmachina-core' );

  /* Return the title. */
  return $title;

} // end function exmachina_untitled_post()

/**
 * Theme File Version
 *
 * Get the version of theme file using theme version.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
 * @link http://codex.wordpress.org/Function_Reference/get_template
 * @link http://codex.wordpress.org/Function_Reference/trailingslashit
 * @link http://codex.wordpress.org/Function_Reference/get_stylesheet_directory
 *
 * @since 2.5.0
 * @access public
 *
 * @param  string $file The file to version check.
 * @return string       Returns the theme file version.
 */
function exmachina_theme_file_version( $file ) {

  /* Get the theme template. */
  $theme = wp_get_theme( get_template() );

  /* Check theme version from provided file. */
  if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $file )){
    $theme = wp_get_theme();
  }

  /* Return the theme file version. */
  return $theme->get( 'Version' );

} // end function exmachina_theme_file_version()

/**
 * Locate Theme File
 *
 * Retrieves the file with the highest priority that exists. The function
 * searches both the stylesheet and template directories. This function is
 * similar to the locate_template() function in WordPress but returns the file
 * name with the URI path instead of the directory path.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_child_theme
 * @link http://codex.wordpress.org/Function_Reference/get_stylesheet_directory
 * @link http://codex.wordpress.org/Function_Reference/get_stylesheet_directory_uri
 * @link http://codex.wordpress.org/Function_Reference/get_template_directory
 * @link http://codex.wordpress.org/Function_Reference/get_template_directory_uri
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array  $file_name The files to search for.
 * @return string            The located file.
 */
function exmachina_locate_theme_file( $file_name ) {

  $located = '';

  /* Loops through each of the given file names. */
  foreach ( (array) $file_names as $file ) {

    /* If the file exists in the stylesheet (child theme) directory. */
    if ( is_child_theme() && file_exists( trailingslashit( get_stylesheet_directory() ) . $file ) ) {
      $located = trailingslashit( get_stylesheet_directory_uri() ) . $file;
      break;
    }

    /* If the file exists in the template (parent theme) directory. */
    elseif ( file_exists( trailingslashit( get_template_directory() ) . $file ) ) {
      $located = trailingslashit( get_template_directory_uri() ) . $file;
      break;
    }
  }

  return $located;

} // end function exmachina_locate_theme_file()

/**
 * Post Has Content
 *
 * Checks if a post has any content. Useful if you need to check if the user has
 * written any content before performing any actions.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_post
 *
 * @since 2.5.0
 * @access public
 *
 * @param  integer $id The ID of the post.
 * @return boolean
 */
function exmachina_post_has_content( $id = 0 ) {

  /* Get the post via post ID. */
  $post = get_post( $id );

  /* Returns true if post content is empty, false if not. */
  return !empty( $post->post_content ) ? true : false;

} // end function exmachina_post_has_content()

/**
 * Audio Attachment Check
 *
 * Checks if the current post has a mime type of 'audio'.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_the_ID
 * @link http://codex.wordpress.org/Function_Reference/get_post_mime_type
 *
 * @since 2.5.0
 * @access public
 *
 * @param  integer $post_id The ID of the post.
 * @return boolean
 */
function exmachina_attachment_is_audio( $post_id = 0 ) {

  $post_id = empty( $post_id ) ? get_the_ID() : $post_id;

  $mime = get_post_mime_type( $post_id );
  $mime_type = explode( '/', $mime );

  return 'audio' == array_shift( $mime_type ) ? true : false;

} // end function exmachina_attachment_is_audio()

/**
 * Video Attachment Check
 *
 * Checks if the current post has a mime type of 'video'.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_the_ID
 * @link http://codex.wordpress.org/Function_Reference/get_post_mime_type
 *
 * @since 2.5.0
 * @access public
 *
 * @param  integer $post_id The ID of the post.
 * @return boolean
 */
function exmachina_attachment_is_video( $post_id = 0 ) {

  $post_id = empty( $post_id ) ? get_the_ID() : $post_id;

  $mime = get_post_mime_type( $post_id );
  $mime_type = explode( '/', $mime );

  return 'video' == array_shift( $mime_type ) ? true : false;

} // end function exmachina_attachment_is_video()

/**
 * Categorized Blog Check
 *
 * Returns true if a blog has more than one category.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_transient
 * @link http://codex.wordpress.org/Function_Reference/get_categories
 * @link http://codex.wordpress.org/Function_Reference/set_transient
 *
 * @since 2.5.0
 * @access public
 *
 * @return boolean
 */
function exmachina_categorized_blog() {

  if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
    // Create an array of all the categories that are attached to posts
    $all_the_cool_cats = get_categories( array(
      'hide_empty' => 1,
    ) );

    // Count the number of categories that are attached to the posts
    $all_the_cool_cats = count( $all_the_cool_cats );

    set_transient( 'all_the_cool_cats', $all_the_cool_cats );
  }

  if ( '1' != $all_the_cool_cats ) {
    // This blog has more than 1 category so exmachina_categorized_blog should return true
    return true;
  } else {
    // This blog has only 1 category so exmachina_categorized_blog should return false
    return false;
  }

} // end function exmachina_categorized_blog()

add_action( 'edit_category', 'exmachina_category_transient_flush' );
add_action( 'save_post',     'exmachina_category_transient_flush' );

/**
 * Category Transient Flush
 *
 * Flush out the transients used in exmachina_categorized_blog().
 *
 * @link http://codex.wordpress.org/Function_Reference/delete_transient
 *
 * @since 2.5.0
 * @access public
 *
 * @return void
 */
function exmachina_category_transient_flush() {

  /* Delete the transient. */
  delete_transient( 'all_the_cool_cats' );

} // end function exmachina_category_transient_flush()

/* Add custom menu args. */
add_filter( 'wp_page_menu_args', 'exmachina_custom_page_menu_args' );

/**
 * Custom Page Menu Arguments
 *
 * Filters the wp_nav_menu() fallback to show a link to the homepage.
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $args The menu arguments.
 * @return array       The menu arguments.
 */
function exmachina_custom_page_menu_args( $args ) {

  /* Set the 'show_home' $args to true. */
  $args['show_home'] = true;

  /* Return the $args. */
  return $args;

} // end function exmachina_custom_page_menu_args()

/* Add custom body classes. */
add_filter( 'body_class', 'exmachina_custom_body_classes' );

/**
 * Custom Body Classes
 *
 * Adds custom classes to the array of body classes.
 *
 * @todo add codex links
 *
 * @link http://codex.wordpress.org/Function_Reference/is_multi_author
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $classes Array of body classes.
 * @return array          Custom body class array.
 */
function exmachina_custom_body_classes( $classes ) {
  global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome;

  /* Adds a 'group-blog' class to multi-author blogs. */
  if ( is_multi_author() ) {
    $classes[] = 'group-blog';
  }

  /* Browser detection. */
  $browsers = array( 'gecko' => $is_gecko, 'opera' => $is_opera, 'lynx' => $is_lynx, 'ns4' => $is_NS4, 'safari' => $is_safari, 'chrome' => $is_chrome, 'msie' => $is_IE );
  foreach ( $browsers as $key => $value ) {
    if ( $value ) {
      $classes[] = $key;
      break;
    }
  }

  /* Theme widgets detection. */
  foreach ( array( 'primary', 'secondary', 'subsidiary' ) as $sidebar )
    $classes[] = ( is_active_sidebar( $sidebar ) ) ? "{$sidebar}-active" : "{$sidebar}-inactive";

  if ( in_array( 'primary-inactive', $classes ) && in_array( 'secondary-inactive', $classes ) && in_array( 'subsidiary-inactive', $classes ) )
    $classes[] = 'no-widgets';

  /* Get all registered sidebars */
  global $wp_registered_sidebars;

  /* if not empty sidebar */
  if ( ! empty( $wp_registered_sidebars ) ){

    /* foreach widget areas */
    foreach ( $wp_registered_sidebars as $sidebar ){

      /* add active/inactive class */
      $classes[] = is_active_sidebar( $sidebar['id'] ) ? "sidebar-{$sidebar['id']}-active" : "sidebar-{$sidebar['id']}-inactive";
    }
  }

  /* Get all registered menus */
  $menus = get_registered_nav_menus();

  /* if not empty menus */
  if ( ! empty( $menus ) ){

    /* for each menus */
    foreach ( $menus as $menu_id => $menu ){

      /* add active/inactive class */
      $classes[] = has_nav_menu( $menu_id ) ? "menu-{$menu_id}-active" : "menu-{$menu_id}-inactive";
    }
  }

  /* Remove any duplicates. */
  $classes = array_unique( $classes );

  /* Return the custom class array. */
  return $classes;

} // end function exmachina_custom_body_classes()

/**
 * Custom HTML Classes
 *
 * Adds custom classes to the array of html tag classes.
 *
 * @todo add codex links
 * @todo cleanup function
 * @todo possibly bring back skin markup
 * @todo add html class in templates
 *
 * @since 2.5.0
 * @access public
 *
 * @param  string $class [description]
 * @return [type]        [description]
 */
function exmachina_html_class( $class = '' ) {
  global $wp_query;

  /* default var */
  $classes = array();

  /* not singular pages - sometimes i need this */
  if (! is_singular())
    $classes[] = 'not-singular';

  /* theme layout check */
  if ( current_theme_supports( 'theme-layouts' ) ) {

    /* get current layout */
    $layout = theme_layouts_get_layout();

    /* if current theme layout is 2 column */
    if ( 'layout-default' == $layout || 'layout-2c-l' == $layout || 'layout-2c-r' == $layout )
      $classes[] = 'layout-2c';

    /* if current theme layout is 3 column */
    if ( 'layout-3c-l' == $layout || 'layout-3c-r' == $layout || 'layout-3c-c' == $layout )
      $classes[] = 'layout-3c';
  }

  /* user input */
  if ( ! empty( $class ) ) {
    if ( !is_array( $class ) )
      $class = preg_split( '#\s+#', $class );
    $classes = array_merge( $classes, $class );
  }
  else {
    $class = array();
  }

  /* enable filter */
  $classes = apply_atomic( 'html_class', $classes, $class ); //shell_html_class

  /* sanitize it */
  $classes = array_map( 'esc_attr', $classes );

  /* make it unique */
  $classes = array_unique( $classes );

  /* Join all the classes into one string. */
  $class = join( ' ', $classes );

  /* Print html class. */
  echo $class;
} // end function exmachina_html_class()

/* Render a custom admn bar. */
add_action( 'wp_before_admin_bar_render', 'exmachina_adminbar' );

/**
 * Custom Admin Bar
 *
 * Adds the theme settings menu item to the WordPress admin bar.
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Admin_Bar
 * @link http://codex.wordpress.org/Function_Reference/add_menu
 * @link http://codex.wordpress.org/Function_Reference/admin_url
 *
 * @since 2.5.0
 * @access public
 *
 * @global object $wp_admin_bar  The admin bar object.
 * @return void
 */
function exmachina_adminbar() {
  global $wp_admin_bar;

  $wp_admin_bar->add_menu( array(
      'parent' => 'appearance',
      'id' => 'theme-settings',
      'title' => __( 'Theme Settings', 'exmachina-core' ),
      'href' => admin_url( 'themes.php?page=theme-settings' )
    ));

} // end function exmachina_adminbar()

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
 * @since 2.5.0
 * @access public
 *
 * @param string $text            A string to be shortened.
 * @param integer $max_characters The maximum number of characters to return.
 * @return string                 Truncated string
 */
function exmachina_truncate_phrase( $text, $max_characters ) {

  $text = trim( $text );

  if ( mb_strlen( $text ) > $max_characters ) {

    /* Truncate $text to $max_characters + 1. */
    $text = mb_substr( $text, 0, $max_characters + 1 );

    /* Truncate to the last space in the truncated string. */
    $text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
  }

  /* Return the truncated string. */
  return $text;

} // end function exmachina_truncate_phrase()

/**
 * Get the Content Limit
 *
 * Return content stripped down and limited content. Strips out tags and
 * shortcodes, limits the output to `$max_char` characters, and appends an
 * ellipsis and more link to the end.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_the_content
 * @link http://codex.wordpress.org/Function_Reference/strip_shortcodes
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 *
 * @uses exmachina_truncate_phrase() [description]
 *
 * @since 2.5.0
 * @access public
 *
 * @param integer $max_characters The maximum number of characters to return.
 * @param string  $more_link_text Optional. Text of the more link.
 * @param bool    $stripteaser    Optional. Strip teaser content before the more text.
 * @return string Limited content.
 */
function get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

  $content = get_the_content( '', $stripteaser );

  /* Strip tags and shortcodes so the content truncation count is done correctly. */
  $content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

  /* Remove inline styles / scripts. */
  $content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

  /* Truncate $content to $max_char. */
  if ($max_characters < strlen( $content )) {
    $content = exmachina_truncate_phrase( $content, $max_characters );
    $no_more = false;
  } else {
    $no_more = true;
  }

  /* Possibly setup more link. */
  if ( $more_link_text && !$no_more )  {
    $link   = apply_filters( 'get_the_content_more_link', sprintf( '&#x02026; <a href="%s" class="more-link">%s</a>', get_permalink(), $more_link_text ), $more_link_text );
    $output = sprintf( '<p>%s %s</p>', $content, $link );
  } else {
    $output = sprintf( '<p>%s</p>', $content );
    $link = '';
  }

  /* Filter and return the content limit. */
  return apply_filters( 'get_the_content_limit', $output, $content, $link, $max_characters );

} // end function get_the_content_limit()

/**
 * The Content Limit
 *
 * Echo the limited content.
 *
 * @uses get_the_content_limit() Return content stripped down and limited content.
 *
 * @since 2.5.0
 * @access public
 *
 * @param integer $max_characters The maximum number of characters to return.
 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
 */
function the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

  /* Get the content from the content limit. */
  $content = get_the_content_limit( $max_characters, $more_link_text, $stripteaser );

  /* Echo the content. */
  echo apply_filters( 'the_content_limit', $content );

} // end function the_content_limit()


/**
 * Get Help Sidebar
 *
 * Adds a help tab to the theme settings screen if the theme has provided a
 * 'Documentation URI' and/or 'Support URI'. Theme developers can add custom help
 * tabs using get_current_screen()->add_help_tab().
 *
 * @since 2.5.0
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
/* ==Formatting Functions */
/*-------------------------------------------------------------------------*/


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
 * @since 2.5.0
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
 * @since 2.5.0
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
 * @since 2.5.0
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
 * @since 2.5.0
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
 * @since 2.5.0
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
 * @since 2.5.0
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
 * text in user interfaces added by ExMachina.
 *
 * @link http://codex.wordpress.org/Function_Reference/esc_html
 *
 * @since 2.5.0
 * @access public
 *
 * @param  string $content Content to be wrapped in code tags.
 * @return string          Content wrapped in code tags.
 */
function exmachina_code( $content ) {

  /* Return the code with markup. */
  return '<code>' . esc_html( $content ) . '</code>';

} // end function exmachina_code()


/*-------------------------------------------------------------------------*/
/* Extras Functions */
/*-------------------------------------------------------------------------*/


/* Additional css classes for widgets */
  add_filter( 'dynamic_sidebar_params', 'exmachina_widget_classes' );
/**
 * Additional widget classes with number of each widget position and first/last widget class.
 * This is a modified code from Sukelius Magazine Theme.
 *
 * @link http://themeexmachina.com/themes/sukelius-magazine
 * @since 0.1.0
 */
function exmachina_widget_classes( $params ) {

  /* Global a counter array */
  global $exmachina_widget_num;

  /* Get the id for the current sidebar we're processing */
  $this_id = $params[0]['id'];

  /* Get registered widgets */
  $arr_registered_widgets = wp_get_sidebars_widgets();

  /* If the counter array doesn't exist, create it */
  if ( !$exmachina_widget_num ) {
    $exmachina_widget_num = array();
  }

  /* if current sidebar has no widget, return. */
  if ( !isset( $arr_registered_widgets[$this_id] ) || !is_array( $arr_registered_widgets[$this_id] ) ) {
    return $params;
  }

  /* See if the counter array has an entry for this sidebar */
  if ( isset( $exmachina_widget_num[$this_id] ) ) {
    $exmachina_widget_num[$this_id] ++;
  }
  /* If not, create it starting with 1 */
  else {
    $exmachina_widget_num[$this_id] = 1;
  }

  /* Add a widget number class for additional styling options */
  $class = 'class="widget widget-' . $exmachina_widget_num[$this_id] . ' ';

  /* in first widget, add 'widget-first' class */
  if ( $exmachina_widget_num[$this_id] == 1 ) {
    $class .= 'widget-first ';
  }
  /* in last widget, add 'widget-last' class */
  elseif( $exmachina_widget_num[$this_id] == count( $arr_registered_widgets[$this_id] ) ) {
    $class .= 'widget-last ';
  }

  /* str replace before_widget param with new class */
  $params[0]['before_widget'] = str_replace( 'class="widget ', $class, $params[0]['before_widget'] );

  return $params;
}

/* ExMachina Core Context */
  add_filter( 'exmachina_context', 'shell_exmachina_context' );
/**
 * Add Current Post template, Post Format, and Attachment Mime Type to ExMachina Core Context
 *
 * @todo integrate into main context function
 * @todo add canvas page template context
 * @since 0.1.0
 */
function shell_exmachina_context( $context ){

  /* Singular post (post_type) classes. */
  if ( is_singular() ) {

    /* Get the queried post object. */
    $post = get_queried_object();

    /* Checks for custom template. */
    $template = str_replace( array ( "{$post->post_type}-template-", "{$post->post_type}-" ), '', basename( get_post_meta( get_queried_object_id(), "_wp_{$post->post_type}_template", true ), '.php' ) );
    if ( !empty( $template ) )
      $context[] = "{$post->post_type}-template-{$template}";

    /* Post format. */
    if ( current_theme_supports( 'post-formats' ) && post_type_supports( $post->post_type, 'post-formats' ) ) {
      $post_format = get_post_format( get_queried_object_id() );
      $context[] = ( ( empty( $post_format ) || is_wp_error( $post_format ) ) ? "{$post->post_type}-format-standard" : "{$post->post_type}-format-{$post_format}" );
    }

    /* Attachment mime types. */
    if ( is_attachment() ) {
      foreach ( explode( '/', get_post_mime_type() ) as $type )
        $context[] = "attachment-{$type}";
    }
  }

  /* make it unique */
  $context = array_unique( $context );

  return $context;
}

/* Post format singular template */
  add_filter( 'single_template', 'shell_post_format_singular_template', 11 );

/**
 * Add Singular Post Format Template
 *
 * @link http://themeexmachina.com/support/topic/add-post-format-singular-template-in-template-hierarchy#post-75579
 * @since 0.1.0
 */
function shell_post_format_singular_template( $template ){

  /* get queried object */
  $post = get_queried_object();

  /* check supported post type */
  if ( post_type_supports( $post->post_type, 'post-formats' ) ) {

    /* get post format of current object */
    $format = get_post_format( get_queried_object_id() );

    /* template */
    $templates = array(
      "{$post->post_type}-{$post->post_name}.php",
      "{$post->post_type}-{$post->ID}.php",
      "{$post->post_type}-format-{$format}.php"
    );

    /* locate template */
    $has_template = locate_template( $templates );

    if ( $has_template )
      $template = $has_template;
  }

  return $template;
}

/*-------------------------------------------------------------------------*/
/* === Compatibility Functions === */
/* These functions are intended to provide simple compatibilty for those that
/* don't have the mbstring extension enabled. WordPress already provides a
/* proper working definition for mb_substr().
/*-------------------------------------------------------------------------*/

if ( ! function_exists( 'mb_strpos' ) ) {
  /**
   * [mb_strpos description]
   * @param  [type]  $haystack [description]
   * @param  [type]  $needle   [description]
   * @param  integer $offset   [description]
   * @param  string  $encoding [description]
   * @return [type]            [description]
   */
  function mb_strpos( $haystack, $needle, $offset = 0, $encoding = '' ) {
    return strpos( $haystack, $needle, $offset );
  } // end function mb_strpos()
} // end if ( !function_exists( 'mb_strpos' ))

if ( ! function_exists( 'mb_strrpos' ) ) {
  /**
   * [mb_strrpos description]
   * @param  [type]  $haystack [description]
   * @param  [type]  $needle   [description]
   * @param  integer $offset   [description]
   * @param  string  $encoding [description]
   * @return [type]            [description]
   */
  function mb_strrpos( $haystack, $needle, $offset = 0, $encoding = '' ) {
    return strrpos( $haystack, $needle, $offset );
  } // end function mb_strrpos()
} // end if ( !function_exists( 'mb_strrpos' ))

if ( ! function_exists( 'mb_strlen' ) ) {
  /**
   * [mb_strlen description]
   * @param  [type] $string   [description]
   * @param  string $encoding [description]
   * @return [type]           [description]
   */
  function mb_strlen( $string, $encoding = '' ) {
    return strlen( $string );
  } // end function mb_strlen()
} // end if ( !function_exists( 'mb_strlen' ))

if ( ! function_exists( 'mb_strtolower' ) ) {
  /**
   * [mb_strtolower description]
   * @param  [type] $string   [description]
   * @param  string $encoding [description]
   * @return [type]           [description]
   */
  function mb_strtolower( $string, $encoding = '' ) {
    return strtolower( $string );
  } // end function mb_strtolower()
} // end if ( !function_exists( 'mb_strtolower' ))


/*-------------------------------------------------------------------------*/
/* === Admin Functions === */
/*-------------------------------------------------------------------------*/

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
 * @since 2.5.0
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

/*-------------------------------------------------------------------------*/
/* === Theme Update Functions === */
/*-------------------------------------------------------------------------*/

/* Don't update theme fromt the WordPress repo. */
add_filter( 'http_request_args', 'exmachina_dont_update_theme', 5, 2 );

/**
 * Don't Update Theme
 *
 * If there is a theme in the repo with the same name, this prevents WP from
 * prompting an update.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_option
 *
 * @since 2.5.0
 * @access private
 *
 * @param  array  $req Request arguments
 * @param  string $url Request url
 * @return array       Request arguments
 */

function exmachina_dont_update_theme( $req, $url ) {

  if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
    return $req; // Not a theme update request. Bail immediately.

  /* Unserialize the request arguments. */
  $themes = unserialize( $req['body']['themes'] );

  /* Gets the template and stylesheet option and unset. */
  unset( $themes[ get_option( 'template' ) ] );
  unset( $themes[ get_option( 'stylesheet' ) ] );

  /* Reserialize the request arguments. */
  $req['body']['themes'] = serialize( $themes );

  /* Return the request args. */
  return $req;

} // end function exmachina_dont_update_theme()
