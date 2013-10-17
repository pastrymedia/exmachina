<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * <[TEMPLATE NAME]> WordPress Theme
 * Main Theme Functions
 *
 * functions.php
 * @link http://codex.wordpress.org/Functions_File_Explained
 *
 * The functions file is used to initialize everything in the theme. It controls
 * how the theme is loaded and sets up the supported features, default actions,
 * and default filters. If making customizations, users should create a child
 * theme and make changes to its functions.php file (not this one).
 *
 * @package     <[TEMPLATE NAME]>
 * @subpackage  Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright(c) 2012-2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com/<[theme-name]>
 */
###############################################################################
# begin functions
###############################################################################

/* Load the core theme framework. */
require ( trailingslashit( get_template_directory() ) . 'library/engine.php' );
new ExMachina();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'omega_theme_setup' );

/**
 * Theme setup function. This function adds support for theme features and defines
 * the default theme actions and filters.
 *
 * @since 1.0.0
 */
function omega_theme_setup() {

  /* Get action/filter hook prefix. */
  $prefix = exmachina_get_prefix();

  /* Add theme support for core framework features. */
  add_theme_support( 'exmachina-core-menus', array( 'primary', 'secondary', 'subsidiary' ) );
  add_theme_support( 'exmachina-core-sidebars', array( 'primary', 'secondary', 'before-content', 'after-content', 'after-singular' ) );
  add_theme_support( 'exmachina-core-scripts', array( 'comment-reply' ) );
  add_theme_support( 'exmachina-core-styles', array( 'parent', 'style' ) );
  add_theme_support( 'exmachina-vendor-assets', array( 'bootstrap' ) );
  add_theme_support( 'exmachina-core-theme-settings', array( 'about', 'comments', 'archives', 'scripts', 'footer' ) );
  add_theme_support( 'exmachina-core-widgets' );
  add_theme_support( 'exmachina-core-shortcodes' );
  add_theme_support( 'exmachina-core-template-hierarchy' );
  add_theme_support( 'exmachina-core-deprecated' );

  /* Enable theme layouts (need to add stylesheet support). */
  add_theme_support(
    'theme-layouts',
    array( '1c', '2c-l', '2c-r' ),
    array( 'default' => '2c-l', 'customizer' => true )
  );

  /* Add support for a custom header image (logo). */
  add_theme_support(
    'custom-header',
    array(
      'width'       => 1080,
      'height'      => 200,
      'flex-height' => true,
      'flex-width'  => false,
      'header-text' => false
    )
  );

  /* Add support for a custom background. */
  add_theme_support(
    'custom-background',
    array(
      'default-color'    => 'f1f1f1',
      'default-image'    => trailingslashit( get_template_directory_uri() ) . 'images/bg.png',
      'wp-head-callback' => 'exmachina_custom_background_callback'
    )
  );

  /* Add theme support for framework extensions. */
  add_theme_support( 'breadcrumb-trail' );
  add_theme_support( 'cleaner-gallery' );
  add_theme_support( 'get-the-image' );
  add_theme_support( 'cleaner-caption' );
  add_theme_support( 'custom-field-series' );
  add_theme_support( 'loop-pagination' );
  add_theme_support( 'entry-views' );
  add_theme_support( 'post-stylesheets' );
  add_theme_support( 'responsive-viewport' );
  add_theme_support( 'structural-wraps' );
  add_theme_support( 'footer-widgets', 3 );
  add_theme_support( 'custom-css' );
  add_theme_support( 'custom-logo' );
  add_theme_support( 'custom-favicon' );
  add_theme_support( 'sliding-panel' );
  add_theme_support( 'template-tags' );
  add_theme_support( 'custom-snippets' );
  add_theme_support( 'cleaner-archives' );
  add_theme_support( 'grid-columns' );
  add_theme_support( 'custom-classes' );
  add_theme_support( 'post-stylesheets' );
  add_theme_support( 'custom-field-series' );

  /* Add theme support for WordPress features. */
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' ) );
  add_editor_style();

  /* Set content width. */
  exmachina_set_content_width( 640 );

} // end function omega_theme_setup()