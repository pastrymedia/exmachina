<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * ExMachina Engine
 *
 * engine.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * The engine that powers the ExMachina framework. This file controls the load
 * order, theme features, plugins, and extensions. ExMachina is a modular system,
 * which means that features, plugins, and extensions are only loaded if they are
 * specifically included within the theme.
 *
 * @package     ExMachina
 * @version     1.0.0
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Start your engines...
###############################################################################


/**
 * ExMachina Class
 *
 * The ExMachina class launches the framework. This class should be loaded and
 * initialized before anything else within the theme is called.
 *
 * @since 0.8.1
 */
class ExMachina {





  /**
   * Load Core Functions
   *
   * Loads the core framework functions. These files are needed before loading
   * anything else in the framework.
   *
   * @since 0.8.1
   */
  function exmachina_load_core() {

    /* Load the core framework functions. */
    require_once( trailingslashit( EXMACHINA_FRAMEWORK ) . 'core.php' );

    /* Load the core framework. */
    require_once( trailingslashit( EXMACHINA_FRAMEWORK ) . 'framework.php' );

    /* Load the context-based functions. */
    require_once( trailingslashit( EXMACHINA_FRAMEWORK ) . 'context.php' );

    /* Load the core framework internationalization functions. */
    require_once( trailingslashit( EXMACHINA_FRAMEWORK ) . 'i18n.php' );

  } // end function exmachina_load_core()




  /**
   * Framework Theme Support
   *
   * Activates default theme features and removes theme supported features in
   * the case that the user has a plugin installed that handles the functionality.
   *
   * @link http://codex.wordpress.org/Theme_Features
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support
   * @link http://codex.wordpress.org/Function_Reference/remove_theme_support
   * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
   *
   * @since 0.8.1
   */
  function exmachina_theme_support() {

    /* Add semantic markup HTML5 feature. */
    add_theme_support( 'html5' );

    add_theme_support( 'menus' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );




    add_theme_support( 'exmachina-breadcrumbs' );
    add_theme_support( 'exmachina-design-settings' );
    add_theme_support( 'custom-background' );



    add_theme_support( 'microdata-manager' );
    add_theme_support( 'custom-menus' );

  //* Maybe add support for ExMachina menus
  if ( ! current_theme_supports( 'exmachina-menus' ) )
    add_theme_support( 'exmachina-menus', array(
      'primary'   => __( 'Primary Navigation Menu', 'exmachina' ),
      'secondary' => __( 'Secondary Navigation Menu', 'exmachina' ),
    ) );

  //* Maybe add support for structural wraps
  if ( ! current_theme_supports( 'exmachina-structural-wraps' ) )
    add_theme_support( 'exmachina-structural-wraps', array( 'header', 'menu-primary', 'menu-secondary', 'footer-widgets', 'footer' ) );

  //* Turn on HTML5, responsive viewport & footer widgets if ExMachina is active
  if ( ! is_child_theme() ) {
    add_theme_support( 'html5' );
    add_theme_support( 'exmachina-responsive-viewport' );
    add_theme_support( 'exmachina-footer-widgets', 3 );
  }

    /* Remove support for the the Breadcrumb Trail extension if the plugin is installed. */
    //if ( function_exists( 'breadcrumb_trail' ) )
    //  remove_theme_support( 'breadcrumb-trail' );

    /* Remove support for the the Cleaner Gallery extension if the plugin is installed. */
    //if ( function_exists( 'cleaner_gallery' ) )
    //  remove_theme_support( 'cleaner-gallery' );

    /* Remove support for the the Get the Image extension if the plugin is installed. */
    //if ( function_exists( 'get_the_image' ) )
    //  remove_theme_support( 'get-the-image' );

    /* Remove support for the Featured Header extension if the class exists. */
    //if ( class_exists( 'Featured_Header' ) )
    //  remove_theme_support( 'featured-header' );

    /* Remove support for the Random Custom Background extension if the class exists. */
    //if ( class_exists( 'Random_Custom_Background' ) )
    //  remove_theme_support( 'random-custom-background' );

  } // end function exmachina_theme_support()



  /**
   * Load Classes
   *
   * Loads all the class files and features. The exmachina_pre_classes
   * action hook is called before any of the files are required.
   *
   * If a parent or child theme defines EXMACHINA_LOAD_CLASSES as false before
   * requiring this engine.php file, then this function will abort before any
   * other files are loaded.
   *
   * @since 0.8.1
   */
  function exmachina_load_classes() {

    /* Triggers the 'exmachina_pre_classes' action hook. */
    do_action( 'exmachina_pre_classes' );

    /* Short circuits the framework if 'EXMACHINA_LOAD_CLASSES' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_CLASSES' ) && EXMACHINA_LOAD_CLASSES === false )
      return;

    /* Load the admin builder class. */
    require_once( trailingslashit( EXMACHINA_CLASSES ) . 'admin.php' );

    /* Load the settings sanitization class. */
    require_once( trailingslashit( EXMACHINA_CLASSES ) . 'sanitization.php' );

    require_if_theme_supports( 'exmachina-breadcrumbs', EXMACHINA_CLASSES . '/breadcrumb.php' );

  } // end function exmachina_load_classes()

  /**
   * Load Framework
   *
   * Loads all the framework files and features. The 'exmachina_pre_framework'
   * action hook is called before any of the files are required. Many of these
   * functions are needed to properly run the framework. Some components are
   * only loaded if the theme supports them.
   *
   * If a parent or child theme defines 'EXMACHINA_LOAD_FRAMEWORK' as false
   * before requring this engine.php file, then this function will abort before
   * any other files are loaded.
   *
   * @since 0.8.1
   */
  function exmachina_load_framework() {

    /* Triggers the 'exmachina_pre_framework' action hook. */
    do_action( 'exmachina_pre_framework' );

    /* Short circuits the framework if 'EXMACHINA_LOAD_FRAMEWORK' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_FRAMEWORK' ) && EXMACHINA_LOAD_FRAMEWORK === false )
      return;

    /* Load the compatibility functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'compat.php' );

    /* Load the general functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'general.php' );

    /* Load the options functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'options.php' );

    /* Load the hooks functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'hooks.php' );

    /* Load the image functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'image.php' );

    /* Load the markup functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'markup.php' );

    /* Load the menu functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'menu.php' );

    /* Load the layout functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'layout.php' );

    /* Load the formatting functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'formatting.php' );

    /* Load the seo functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'seo.php' );

    /* Load the widgetize functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'widgetize.php' );

    /* Load the feed functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'feed.php' );




    /* Load the breadcrumb functionality if breadcrumbs are supported. */
    require_if_theme_supports( 'exmachina-breadcrumbs', trailingslashit( EXMACHINA_FUNCTIONS ) . 'breadcrumb.php' );


  global $_exmachina_formatting_allowedtags;
  $_exmachina_formatting_allowedtags = exmachina_formatting_allowedtags();

    /* Load the comments functions. */
    //require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'comments.php' );

    /* Load media-related functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'media.php' );

    /* Load the metadata functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'meta.php' );

    /* Load the template functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'template.php' );

    /* Load the utility functions. */
    //require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'utility.php' );

    /* Load the theme settings functions if supported. */
    //require_if_theme_supports( 'exmachina-core-theme-settings', trailingslashit( EXMACHINA_FUNCTIONS ) . 'settings.php' );

    /* Load the customizer functions if theme settings are supported. */
    //require_if_theme_supports( 'exmachina-core-theme-settings', trailingslashit( EXMACHINA_FUNCTIONS ) . 'customize.php' );

    /* Load the menus functions if supported. */
    //require_if_theme_supports( 'exmachina-core-menus', trailingslashit( EXMACHINA_FUNCTIONS ) . 'menus.php' );

    /* Load the shortcodes if supported. */
    require_if_theme_supports( 'exmachina-core-shortcodes', trailingslashit( EXMACHINA_FUNCTIONS ) . 'shortcodes.php' );

    /* Load the sidebars if supported. */
    //require_if_theme_supports( 'exmachina-core-sidebars', trailingslashit( EXMACHINA_FUNCTIONS ) . 'sidebars.php' );

    /* Load the widgets if supported. */
    require_if_theme_supports( 'exmachina-core-widgets', trailingslashit( EXMACHINA_FUNCTIONS ) . 'widgets.php' );

    /* Load the template hierarchy if supported. */
    require_if_theme_supports( 'exmachina-core-template-hierarchy', trailingslashit( EXMACHINA_FUNCTIONS ) . 'template-hierarchy.php' );

    /* Load the styles if supported. */
    require_if_theme_supports( 'exmachina-core-styles', trailingslashit( EXMACHINA_FUNCTIONS ) . 'styles.php' );

    /* Load the scripts if supported. */
    require_if_theme_supports( 'exmachina-core-scripts', trailingslashit( EXMACHINA_FUNCTIONS ) . 'scripts.php' );

    /* Load the media grabber script if supported. */
    //require_if_theme_supports( 'exmachina-core-media-grabber', trailingslashit( EXMACHINA_CLASSES ) . 'media-grabber.php' );

    /* Load the post format functionality if post formats are supported. */
    require_if_theme_supports( 'post-formats', trailingslashit( EXMACHINA_FUNCTIONS ) . 'post-formats.php' );

    /* Load the deprecated functions if supported. */
    require_if_theme_supports( 'exmachina-core-deprecated', trailingslashit( EXMACHINA_FUNCTIONS ) . 'deprecated.php' );

  } // end function exmachina_load_framework()

  /**
   * Load Structure
   *
   * Loads the framework markup structure. The 'exmachina_pre_structure' action
   * hook is called before any of the structure files are required.
   *
   * If a parent or child theme defines 'EXMACHINA_LOAD_STRUCTURE' as false
   * before requring this engine.php file, then this function will abort before
   * any structure files are loaded.
   *
   * @since 0.8.1
   */
  function exmachina_load_structure() {

    /* Triggers the 'exmachina_pre_structure' action hook. */
    do_action( 'exmachina_pre_structure' );

    /* Short circuits the framework if 'EXMACHINA_LOAD_FRAMEWORK' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_FRAMEWORK' ) && EXMACHINA_LOAD_FRAMEWORK === false )
      return;

    /* Short circuits the framework if 'EXMACHINA_LOAD_STRUCTURE' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_STRUCTURE' ) && EXMACHINA_LOAD_STRUCTURE === false )
      return;

    /* Load the archive structure template. */
    require_once( trailingslashit( EXMACHINA_STRUCTURE ) . 'archive.php' );

    /* Load the comments structure template. */
    require_once( trailingslashit( EXMACHINA_STRUCTURE ) . 'comments.php' );

    /* Load the footer structure template. */
    require_once( trailingslashit( EXMACHINA_STRUCTURE ) . 'footer.php' );

    /* Load the header structure template. */
    require_once( trailingslashit( EXMACHINA_STRUCTURE ) . 'header.php' );

    /* Load the layout structure template. */
    require_once( trailingslashit( EXMACHINA_STRUCTURE ) . 'layout.php' );

    /* Load the loops structure template. */
    require_once( trailingslashit( EXMACHINA_STRUCTURE ) . 'loops.php' );

    /* Load the menu structure template. */
    require_once( trailingslashit( EXMACHINA_STRUCTURE ) . 'menu.php' );

    /* Load the post structure template. */
    require_once( trailingslashit( EXMACHINA_STRUCTURE ) . 'post.php' );

    /* Load the search structure template. */
    require_once( trailingslashit( EXMACHINA_STRUCTURE ) . 'search.php' );

    /* Load the sidebar structure template. */
    require_once( trailingslashit( EXMACHINA_STRUCTURE ) . 'sidebar.php' );

  } // end function exmachina_load_structure()

  /**
   * Load Extensions
   *
   * Loads the framework extensions. The 'exmachina_pre_extensions' action hook
   * is called before any of the extension files are required.
   *
   * Extensions are projects that are included within the framework but are not
   * neccessarily a part of it. They are external projects developed outside of
   * the framework. Themes must use 'add_theme_support( $extension )' to use a
   * specific extenstion within the theme.
   *
   * If a parent or child theme defines 'EXMACHINA_LOAD_EXTENSIONS' as false
   * before requring this engine.php file, then this function will abort before
   * any extension files are loaded.
   *
   * @since 0.8.1
   */
  function exmachina_load_extensions() {

    /* Triggers the 'exmachina_pre_extensions' action hook. */
    do_action( 'exmachina_pre_extensions' );

    /* Short circuits the framework if 'EXMACHINA_LOAD_FRAMEWORK' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_FRAMEWORK' ) && EXMACHINA_LOAD_FRAMEWORK === false )
      return;

    /* Short circuits the framework if 'EXMACHINA_LOAD_EXTENSIONS' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_EXTENSIONS' ) && EXMACHINA_LOAD_EXTENSIONS === false )
      return;

    require_once( EXMACHINA_PLUGINS . '/custom-sidebars/plugin.php' );

    /* Load the Microdata extension if supported. */
    require_if_theme_supports( 'microdata-manager', trailingslashit( EXMACHINA_EXTENSIONS ) . 'microdata-manager.php' );

    /* Load the Custom Menu extension if supported. */
    require_if_theme_supports( 'custom-menus', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-menus.php' );

    /* Load the Breadcrumb Trail extension if supported. */
    //require_if_theme_supports( 'breadcrumb-trail', trailingslashit( EXMACHINA_EXTENSIONS ) . 'breadcrumb-trail.php' );

    /* Load the Cleaner Gallery extension if supported. */
    //require_if_theme_supports( 'cleaner-gallery', trailingslashit( EXMACHINA_EXTENSIONS ) . 'cleaner-gallery.php' );

    /* Load the Get the Image extension if supported. */
    //require_if_theme_supports( 'get-the-image', trailingslashit( EXMACHINA_EXTENSIONS ) . 'get-the-image.php' );

    /* Load the Cleaner Caption extension if supported. */
    //require_if_theme_supports( 'cleaner-caption', trailingslashit( EXMACHINA_EXTENSIONS ) . 'cleaner-caption.php' );

    /* Load the Custom Field Series extension if supported. */
    //require_if_theme_supports( 'custom-field-series', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-field-series.php' );

    /* Load the Loop Pagination extension if supported. */
    //require_if_theme_supports( 'loop-pagination', trailingslashit( EXMACHINA_EXTENSIONS ) . 'loop-pagination.php' );

    /* Load the Entry Views extension if supported. */
    //require_if_theme_supports( 'entry-views', trailingslashit( EXMACHINA_EXTENSIONS ) . 'entry-views.php' );

    /* Load the Theme Layouts extension if supported. */
    //require_if_theme_supports( 'theme-layouts', trailingslashit( EXMACHINA_EXTENSIONS ) . 'theme-layouts.php' );

    /* Load the Post Stylesheets extension if supported. */
    //require_if_theme_supports( 'post-stylesheets', trailingslashit( EXMACHINA_EXTENSIONS ) . 'post-stylesheets.php' );

    /* Load the Featured Header extension if supported. */
    //require_if_theme_supports( 'featured-header', trailingslashit( EXMACHINA_EXTENSIONS ) . 'featured-header.php' );

    /* Load the Random Custom Background extension if supported. */
    //require_if_theme_supports( 'random-custom-background', trailingslashit( EXMACHINA_EXTENSIONS ) . 'random-custom-background.php' );

    /* Load the Color Palette extension if supported. */
    //require_if_theme_supports( 'color-palette', trailingslashit( EXMACHINA_EXTENSIONS ) . 'color-palette.php' );

    /* Load the Theme Fonts extension if supported. */
    //require_if_theme_supports( 'theme-fonts', trailingslashit( EXMACHINA_EXTENSIONS ) . 'theme-fonts.php' );

    /* Load the Footer Widgets extension if supported. */
    //require_if_theme_supports( 'footer-widgets', trailingslashit( EXMACHINA_EXTENSIONS ) . 'footer-widgets.php' );


    /* Load the Custom CSS extension if supported. */
    //require_if_theme_supports( 'custom-css', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-css.php' );

    /* Load the Custom Logo extension if supported. */
    //require_if_theme_supports( 'custom-logo', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-logo.php' );

  } // end function exmachina_load_extensions()

  /**
   * Load Admin
   *
   * Loads all the admin files for the framework. The 'exmachina_pre_admin' action
   * hook is called before any of the files are required.
   *
   * If a parent or child theme defines 'EXMACHINA_LOAD_ADMIN' as false before
   * requiring this engine.php file, then this function will abort before any
   * other admin files are loaded.
   *
   * @since 0.1.2
   */
  function exmachina_load_admin() {

    /* Triggers the 'exmachina_pre_admin' action hook. */
    do_action( 'exmachina_pre_admin' );

    /* Short circuits the framework if 'EXMACHINA_LOAD_FRAMEWORK' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_FRAMEWORK' ) && EXMACHINA_LOAD_FRAMEWORK === false )
      return;

    /* Short circuits the framework if 'EXMACHINA_LOAD_ADMIN' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_ADMIN' ) && EXMACHINA_LOAD_ADMIN === false )
      return;

    /* Check if in the WordPress admin. */
    if ( is_admin() ) {

      /* Load the main admin file. */
      require_once( trailingslashit( EXMACHINA_ADMIN_FUNCTIONS ) . 'admin.php' );
      require_once( trailingslashit( EXMACHINA_ADMIN_FUNCTIONS ) . 'menu.php' );
      require_once( trailingslashit( EXMACHINA_ADMIN_FUNCTIONS ) . 'inpost-metaboxes.php' );

      /* Load the theme settings feature if supported. */
      require_if_theme_supports( 'exmachina-core-theme-settings', trailingslashit( EXMACHINA_ADMIN_SETTINGS ) . 'theme-settings.php' );

      /* Load the hook settings feature if supported. */
      require_if_theme_supports( 'exmachina-core-content-settings', trailingslashit( EXMACHINA_ADMIN_SETTINGS ) . 'content-settings.php' );

      /* Load the hook settings feature if supported. */
      require_if_theme_supports( 'exmachina-core-hook-settings', trailingslashit( EXMACHINA_ADMIN_SETTINGS ) . 'hook-settings.php' );

      /* Load the theme settings feature if supported. */
      require_if_theme_supports( 'exmachina-core-seo-settings', trailingslashit( EXMACHINA_ADMIN_SETTINGS ) . 'seo-settings.php' );

      /* Load the theme settings feature if supported. */
      require_if_theme_supports( 'exmachina-core-import-export-settings', trailingslashit( EXMACHINA_ADMIN_SETTINGS ) . 'import-export.php' );

      /* Load the theme settings feature if supported. */
      require_if_theme_supports( 'exmachina-cpt-archive-settings', trailingslashit( EXMACHINA_ADMIN_SETTINGS ) . 'cpt-archive-settings.php' );

    } // end if (is_admin())

    require_once( trailingslashit( EXMACHINA_ADMIN_FUNCTIONS ) . 'term-meta.php' );
    require_once( trailingslashit( EXMACHINA_ADMIN_FUNCTIONS ) . 'user-meta.php' );

  } // end function exmachina_load_admin()

  /*****************************************************************************\
  === USED FUNCTIONS ===
  \*****************************************************************************/



} // end class ExMachina