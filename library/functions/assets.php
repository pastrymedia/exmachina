<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Asset Loader Functions
 *
 * assets.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Functions for handling JavaScripts and Stylesheets within the framework. Themes
 * can add support for the 'exmachina-core-scripts', 'exmachina-core-styles',
 * or 'exmachina-core-vendor' to allow the framework to handle the loading of
 * JavaScripts and/or Stylesheets into the theme header or footer at the
 * appropiate time.
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

/* Register core scripts. */
add_action( 'wp_enqueue_scripts', 'exmachina_register_scripts', 1 );

/* Load core scripts. */
add_action( 'wp_enqueue_scripts', 'exmachina_enqueue_scripts' );

/* Register core styles. */
add_action( 'wp_enqueue_scripts', 'exmachina_register_styles', 1 );

/* Load core styles. */
add_action( 'wp_enqueue_scripts', 'exmachina_enqueue_styles', 5 );

/* Deregister stylesheets. */
add_action( 'wp_enqueue_scripts', 'exmachina_deregister_styles' );

/* Load the development stylsheet in script debug mode. */
add_filter( 'stylesheet_uri', 'exmachina_min_stylesheet_uri', 10, 2 );

/* Load third-party vendor assets. */
add_action( 'wp_enqueue_scripts', 'exmachina_enqueue_vendor', 2 );


/*-------------------------------------------------------------------------*/
/* == Javascript Functions */
/*-------------------------------------------------------------------------*/

/**
 * Register JavaScripts
 *
 * Registers JavaScript files for the framework. This function merely registers
 * scripts with WordPress using the wp_register_script() function. It does not
 * load any script files on the site. If a theme wants to register its own
 * custom scripts, it should do so on the 'wp_enqueue_scripts' hook.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_register_script
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 *
 * @uses apply_atomic() Gets the contextual filter hook.
 *
 * @since 2.4.0
 * @access private
 *
 * @return void
 */
function exmachina_register_scripts() {

  /* Get the supported JavaScript. */
  $supports = get_theme_support( 'exmachina-core-scripts' );

  /* Use the .min script if SCRIPT_DEBUG is turned off. */
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  /* Register the 'drop-downs' script if the current theme supports 'drop-downs'. */
  if ( isset( $supports[0] ) && in_array( 'drop-downs', $supports[0] ) )
    wp_register_script( 'drop-downs', esc_url( apply_atomic( 'drop_downs_script', trailingslashit( EXMACHINA_JS ) . "drop-downs{$suffix}.js" ) ), array( 'jquery' ), EXMACHINA_VERSION, true );

  /* Register the 'fitvids' script if the current theme supports 'fitvids'. */
  if ( isset( $supports[0] ) && in_array( 'fitvids', $supports[0] ) )
    wp_register_script( 'fitvids', esc_url( trailingslashit( EXMACHINA_JS ) . "fitvids{$suffix}.js" ), array( 'jquery' ), EXMACHINA_VERSION, true );

  /* Register the 'iOS orientation change fix' script if the current theme supports 'ios-fix'. */
  if ( isset( $supports[0] ) && in_array( 'ios-fix', $supports[0] ) )
    wp_register_script( 'ios-fix', esc_url( trailingslashit( EXMACHINA_JS ) . "ios-fix{$suffix}.js" ), array( 'jquery' ), EXMACHINA_VERSION, true );

  /* Register the 'masonry' script if the current theme supports 'masonry'. */
  if ( isset( $supports[0] ) && in_array( 'masonry', $supports[0] ) )
    wp_register_script( 'masonry', esc_url( trailingslashit( EXMACHINA_JS ) . "masonry{$suffix}.js" ), array( 'jquery' ), EXMACHINA_VERSION, true );

  /* Register the 'mobile-toggle' script if the current theme supports 'mobile-toggle'. */
  if ( isset( $supports[0] ) && in_array( 'mobile-toggle', $supports[0] ) )
    wp_register_script( 'mobile-toggle', esc_url( trailingslashit( EXMACHINA_JS ) . "mobile-toggle{$suffix}.js" ), array( 'jquery' ), EXMACHINA_VERSION, true );

  /* Register the 'roundabout' script if the current theme supports 'roundabout'. */
  if ( isset( $supports[0] ) && in_array( 'roundabout', $supports[0] ) )
    wp_register_script( 'roundabout', esc_url( trailingslashit( EXMACHINA_JS ) . "roundabout{$suffix}.js" ), array( 'jquery' ), EXMACHINA_VERSION, true );

  /* Register the 'main' script if the current theme supports 'main'. */
  if ( isset( $supports[0] ) && in_array( 'main', $supports[0] ) )
    wp_register_script( 'main', esc_url( apply_atomic( 'main_script', trailingslashit( EXMACHINA_JS ) . "main{$suffix}.js" ) ), array( 'jquery' ), EXMACHINA_VERSION, true );

  /* Register the 'plugins' script if the current theme supports 'plugins'. */
  if ( isset( $supports[0] ) && in_array( 'plugins', $supports[0] ) )
    wp_register_script( 'plugins', esc_url( apply_atomic( 'plugins_script', trailingslashit( EXMACHINA_JS ) . "plugins{$suffix}.js" ) ), array( 'jquery' ), EXMACHINA_VERSION, true );

} // end function exmachina_register_scripts()

/**
 * Enqueue JavaScripts
 *
 * Tells WordPress to load the scripts needed for the framework using the
 * wp_enqueue_script() function.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 * @link http://codex.wordpress.org/Function_Reference/comments_open
 *
 * @since 2.4.0
 * @access private
 *
 * @return void
 */
function exmachina_enqueue_scripts() {

  /* Get the supported JavaScript. */
  $supports = get_theme_support( 'exmachina-core-scripts' );

  /* Load the comment reply script on singular posts with open comments if threaded comments are supported. */
  if ( is_singular() && get_option( 'thread_comments' ) && comments_open() )
    wp_enqueue_script( 'comment-reply' );

  /* Load the 'drop-downs' script if the current theme supports 'drop-downs'. */
  if ( isset( $supports[0] ) && in_array( 'drop-downs', $supports[0] ) )
    wp_enqueue_script( 'drop-downs' );

  /* Load the 'fitvids' script if the current theme supports 'fitvids'. */
  if ( !is_admin() && isset( $supports[0] ) && in_array( 'fitvids', $supports[0] ) )
    wp_enqueue_script( 'fitvids' );

  /* Load the 'ios-fix' script if the current theme supports 'ios-fix'. */
  if ( isset( $supports[0] ) && in_array( 'ios-fix', $supports[0] ) )
    wp_enqueue_script( 'ios-fix' );

  /* Load the 'masonry' script if the current theme supports 'masonry'. */
  if ( isset( $supports[0] ) && in_array( 'masonry', $supports[0] ) )
    wp_enqueue_script( 'masonry' );

  /* Load the 'mobile-toggle' script if the current theme supports 'mobile-toggle'. */
  if ( isset( $supports[0] ) && in_array( 'mobile-toggle', $supports[0] ) )
    wp_enqueue_script( 'mobile-toggle' );

  /* Load the 'roundabout' script if the current theme supports 'roundabout'. */
  if ( isset( $supports[0] ) && in_array( 'roundabout', $supports[0] ) )
    wp_enqueue_script( 'roundabout' );

  /* Load the 'main' script if the current theme supports 'main'. */
  if ( isset( $supports[0] ) && in_array( 'main', $supports[0] ) )
    wp_enqueue_script( 'main' );

  /* Load the 'plugins' script if the current theme supports 'plugins'. */
  if ( isset( $supports[0] ) && in_array( 'plugins', $supports[0] ) )
    wp_enqueue_script( 'plugins' );

} // end function exmachina_enqueue_scripts()

/*-------------------------------------------------------------------------*/
/* == Stylesheet Functions */
/*-------------------------------------------------------------------------*/

/**
 * Register Stylesheets
 *
 * Registers stylesheets for the framework. This function merely registers styles
 * with WordPress using the wp_register_style() function. It does not load any
 * stylesheets on the site. If a theme wants to register its own custom styles,
 * it should do so on the 'wp_enqueue_scripts' hook.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
 * @link http://codex.wordpress.org/Function_Reference/wp_register_style
 * @link http://codex.wordpress.org/Function_Reference/sanitize_key
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 *
 * @uses exmachina_get_styles() Get available styles array.
 *
 * @since 2.4.0
 * @access private
 *
 * @return void
 */
function exmachina_register_styles() {

  /* Get framework styles. */
  $styles = exmachina_get_styles();

  /* Use the .min stylesheet if SCRIPT_DEBUG is turned off. */
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  /* Loop through each style and register it. */
  foreach ( $styles as $style => $args ) {

    $defaults = array(
      'handle'  => $style,
      'src'     => trailingslashit( EXMACHINA_CSS ) . "{$style}{$suffix}.css",
      'deps'    => null,
      'version' => false,
      'media'   => 'all'
    );

    $args = wp_parse_args( $args, $defaults );

    wp_register_style(
      sanitize_key( $args['handle'] ),
      esc_url( $args['src'] ),
      is_array( $args['deps'] ) ? $args['deps'] : null,
      preg_replace( '/[^a-z0-9_\-.]/', '', strtolower( $args['version'] ) ),
      esc_attr( $args['media'] )
    );
  }
} // end function exmachina_register_styles()

/**
 * Enqueue Stylesheets
 *
 * Tells WordPress to load the styles needed for the framework using the
 * wp_enqueue_style() function.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_theme_support
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 * @uses exmachina_get_styles() Get available styles array.
 *
 * @since 2.4.0
 * @access private
 *
 * @return void
 */
function exmachina_enqueue_styles() {

  /* Get the theme-supported stylesheets. */
  $supports = get_theme_support( 'exmachina-core-styles' );

  /* If the theme doesn't add support for any styles, return. */
  if ( !is_array( $supports[0] ) )
    return;

  /* Get framework styles. */
  $styles = exmachina_get_styles();

  /* Loop through each of the core framework styles and enqueue them if supported. */
  foreach ( $supports[0] as $style ) {

    if ( isset( $styles[$style] ) )
      wp_enqueue_style( $style );
  }
} // end function exmachina_enqueue_styles()

/**
 * Get Styles
 *
 * Returns an array of the core framework's available styles for use in themes.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_child_theme
 * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
 * @link http://codex.wordpress.org/Function_Reference/get_template
 * @link http://codex.wordpress.org/Function_Reference/get_stylesheet_uri
 *
 * @uses exmachina_get_prefix() Gets the theme prefix.
 *
 * @since 2.4.0
 * @access private
 *
 * @return array $styles The available framework styles.
 */
function exmachina_get_styles() {

  /* Use the .min stylesheet if SCRIPT_DEBUG is turned off. */
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  /* Default styles available. */
  $styles = array(
    'base'       => array( 'version' => '20130523' ),
    'drop-downs' => array( 'version' => '20110919' ),
    'gallery'    => array( 'version' => '20130526' ),
    'media'      => array( 'version' => '20130526' ),
    'normalize'  => array( 'version' => '20130523' ),
    'print'      => array( 'version' => '20130523' ),
    'reset'      => array( 'version' => '20130523' ),
    'typography' => array( 'version' => '20130523' ),
  );

  /* If a child theme is active, add the parent theme's style. */
  if ( is_child_theme() ) {
    $parent = wp_get_theme( get_template() );

    /* Get the parent theme stylesheet. */
    $src = trailingslashit( THEME_URI ) . "style.css";

    /* If a '.min' version of the parent theme stylesheet exists, use it. */
    if ( !empty( $suffix ) && file_exists( trailingslashit( THEME_DIR ) . "style{$suffix}.css" ) )
      $src = trailingslashit( THEME_URI ) . "style{$suffix}.css";

    $styles['parent'] = array( 'src' => $src, 'version' => $parent->get( 'Version' ) );
  }

  /* Add the active theme style. */
  $styles['style'] = array( 'src' => get_stylesheet_uri(), 'version' => wp_get_theme()->get( 'Version' ) );

  /* Return the array of styles. */
  return apply_filters( exmachina_get_prefix() . '_styles', $styles );
} // end function exmachina_get_styles()

/**
 * Deregister Styles
 *
 * Removes the WordPress mediaelement styles on the front end if the theme
 * supports the custom media element feature.
 *
 * @since 2.4.0
 * @access private
 *
 * @return void
 */
function exmachina_deregister_styles() {

  /* Get theme-supported meta boxes for the settings page. */
  $styles = get_theme_support( 'exmachina-core-styles' );

  /* If there is no array of styles, return. */
  if ( !is_array( $styles[0] ) )
    return;

  /* If media element style suported, deregister default. */
  if ( in_array( 'media', $styles[0] ) ) {

    wp_deregister_style( 'mediaelement' );
    wp_deregister_style( 'wp-mediaelement' );

  }
} // end function exmachina_deregister_styles()

/**
 * Main Stylesheet
 *
 * Filters the 'stylesheet_uri' to allow theme developers to offer a minimized
 * version of their main 'style.css' file. It will detect if a 'style.min.css'
 * file is available and use it if SCRIPT_DEBUG is disabled.
 *
 * @since 2.4.0
 * @access public
 *
 * @param  string $stylesheet_uri     The URI of the active theme's stylesheet.
 * @param  string $stylesheet_dir_uri The directory URI of the active theme's stylesheet.
 * @return string                     The main stylesheet URI.
 */
function exmachina_min_stylesheet_uri( $stylesheet_uri, $stylesheet_dir_uri ) {

  /* Use the .min stylesheet if SCRIPT_DEBUG is turned off. */
  if ( !defined( 'SCRIPT_DEBUG' ) || false === SCRIPT_DEBUG ) {
    $suffix = '.min';

    /* Remove the stylesheet directory URI from the file name. */
    $stylesheet = str_replace( trailingslashit( $stylesheet_dir_uri ), '', $stylesheet_uri );

    /* Change the stylesheet name to 'style.min.css'. */
    $stylesheet = str_replace( '.css', "{$suffix}.css", $stylesheet );

    /* If the stylesheet exists in the stylesheet directory, set the stylesheet URI to the dev stylesheet. */
    if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $stylesheet ) )
      $stylesheet_uri = trailingslashit( $stylesheet_dir_uri ) . $stylesheet;
  }

  /* Return the theme stylesheet. */
  return $stylesheet_uri;
} // end function exmachina_min_stylesheet_uri()

/*-------------------------------------------------------------------------*/
/* == Vendor Asset Functions */
/*-------------------------------------------------------------------------*/

function exmachina_enqueue_vendor() {

  /* Get supported vendor assets. */
  $supports = get_theme_support( 'exmachina-vendor-assets' );

  /* Use the .min script if SCRIPT_DEBUG is turned off. */
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  /* Register the bootstrap assets if the current theme supports 'bootstrap'. */
  if ( isset( $supports[0] ) && in_array( 'bootstrap', $supports[0] ) ) {
    wp_enqueue_script( 'bootstrap', esc_url( trailingslashit( EXMACHINA_VENDOR ) . "bootstrap/js/bootstrap{$suffix}.js" ), array( 'jquery' ), '3.0.0', true );
    wp_enqueue_style( 'bootstrap', trailingslashit( EXMACHINA_VENDOR ) . "bootstrap/css/bootstrap{$suffix}.css", false, '3.0.0', 'screen' );
  }

  /* Register the flexslider assets if the current theme supports 'flexslider'. */
  if ( isset( $supports[0] ) && in_array( 'flexslider', $supports[0] ) ) {
    wp_enqueue_script( 'flexslider', esc_url( trailingslashit( EXMACHINA_VENDOR ) . "flexslider/js/jquery.flexslider{$suffix}.js" ), array( 'jquery' ), '2.2.0', true );
    wp_enqueue_style( 'flexslider', trailingslashit( EXMACHINA_VENDOR ) . "flexslider/css/flexslider{$suffix}.css", false, '2.2.0', 'screen' );
  }

  /* Register the font awesome assets if the current theme supports 'font-awesome'. */
  if ( isset( $supports[0] ) && in_array( 'font-awesome', $supports[0] ) ) {
    wp_enqueue_style( 'font-awesome', trailingslashit( EXMACHINA_VENDOR ) . "font-awesome/css/font-awesome{$suffix}.css", false, '3.2.1', 'screen' );
  }

  /* Register the Owl Carousel assets if the current theme supports 'owl-carousel'. */
  if ( isset( $supports[0] ) && in_array( 'owl-carousel', $supports[0] ) ) {
    wp_enqueue_script( 'owl-carousel', esc_url( trailingslashit( EXMACHINA_VENDOR ) . "owl-carousel/js/owl.carousel{$suffix}.js" ), array( 'jquery' ), '1.2.6', true );
    wp_enqueue_style( 'owl-carousel', trailingslashit( EXMACHINA_VENDOR ) . "owl-carousel/css/owl.carousel{$suffix}.css", false, '1.2.6', 'screen' );
    wp_enqueue_style( 'owl-carousel-theme', trailingslashit( EXMACHINA_VENDOR ) . "owl-carousel/css/owl.theme{$suffix}.css", false, '1.2.6', 'screen' );
  }

  /* Register the PrettyPhoto assets if the current theme supports 'prettyphoto'. */
  if ( isset( $supports[0] ) && in_array( 'prettyphoto', $supports[0] ) ) {
    wp_enqueue_script( 'prettyphoto', esc_url( trailingslashit( EXMACHINA_VENDOR ) . "prettyphoto/js/jquery.prettyPhoto{$suffix}.js" ), array( 'jquery' ), '3.1.5', true );
    wp_enqueue_style( 'prettyphoto', trailingslashit( EXMACHINA_VENDOR ) . "prettyphoto/css/prettyphoto{$suffix}.css", false, '3.1.5', 'screen' );
  }

  /* Register the Sementic UI assets if the current theme supports 'semantic'. */
  if ( isset( $supports[0] ) && in_array( 'semantic', $supports[0] ) ) {
    wp_enqueue_script( 'semantic', esc_url( trailingslashit( EXMACHINA_VENDOR ) . "semantic/js/semantic{$suffix}.js" ), array( 'jquery' ), '1.0.0', true );
    wp_enqueue_style( 'semantic', trailingslashit( EXMACHINA_VENDOR ) . "semantic/css/semantic{$suffix}.css", false, '1.0.0', 'screen' );
  }
} // end exmachina_enqueue_vendor()

