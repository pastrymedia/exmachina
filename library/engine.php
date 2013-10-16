<?php
/**
 * ExMachina Core - A WordPress theme development framework.
 *
 * ExMachina Core is a framework for developing WordPress themes.  The framework allows theme developers
 * to quickly build themes without having to handle all of the "logic" behind the theme or having to code
 * complex functionality for features that are often needed in themes.  The framework does these things
 * for developers to allow them to get back to what matters the most:  developing and designing themes.
 * The framework was built to make it easy for developers to include (or not include) specific, pre-coded
 * features.  Themes handle all the markup, style, and scripts while the framework handles the logic.
 *
 * ExMachina Core is a modular system, which means that developers can pick and choose the features they
 * want to include within their themes.  Most files are only loaded if the theme registers support for the
 * feature using the add_theme_support( $feature ) function within their theme.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package   ExMachinaCore
 * @version   1.6.2-alpha
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2008 - 2013, Justin Tadlock
 * @link      http://themeexmachina.com/exmachina-core
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * The ExMachina class launches the framework.  It's the organizational structure behind the entire framework.
 * This class should be loaded and initialized before anything else within the theme is called to properly use
 * the framework.
 *
 * After parent themes call the ExMachina class, they should perform a theme setup function on the
 * 'after_setup_theme' hook with a priority of 10.  Child themes should add their theme setup function on
 * the 'after_setup_theme' hook with a priority of 11.  This allows the class to load theme-supported features
 * at the appropriate time, which is on the 'after_setup_theme' hook with a priority of 12.
 *
 * @since 0.7.0
 */
class ExMachina {

	/**
	 * Constructor method for the ExMachina class.  This method adds other methods of the class to
	 * specific hooks within WordPress.  It controls the load order of the required files for running
	 * the framework.
	 *
	 * @since 1.0.0
	 */
	function __construct() {
		global $exmachina;

		/* Set up an empty class for the global $exmachina object. */
		$exmachina = new stdClass;

		/* Define framework, parent theme, and child theme constants. */
		add_action( 'after_setup_theme', array( &$this, 'constants' ), 1 );

		/* Load the core functions required by the rest of the framework. */
		add_action( 'after_setup_theme', array( &$this, 'core' ), 2 );

		/* Initialize the framework's default actions and filters. */
		add_action( 'after_setup_theme', array( &$this, 'default_filters' ), 3 );

		/* Language functions and translations setup. */
		add_action( 'after_setup_theme', array( &$this, 'i18n' ), 4 );

		/* Handle theme supported features. */
		add_action( 'after_setup_theme', array( &$this, 'theme_support' ), 12 );

		/* Load the framework functions. */
		add_action( 'after_setup_theme', array( &$this, 'functions' ), 13 );

		/* Load the structure functions. */
    add_action( 'after_setup_theme', array( &$this, 'structure' ), 14 );

		/* Load the framework extensions. */
		add_action( 'after_setup_theme', array( &$this, 'extensions' ), 15 );

		/* Load admin files. */
		add_action( 'wp_loaded', array( &$this, 'admin' ) );
	}

	/**
	 * Defines the constant paths for use within the core framework, parent theme, and child theme.
	 * Constants prefixed with 'EXMACHINA_' are for use only within the core framework and don't
	 * reference other areas of the parent or child theme.
	 *
	 * @since 0.7.0
	 */
	function constants() {

		/* Sets the framework version number. */
		define( 'EXMACHINA_VERSION', '1.6.2' );

		/* Sets the path to the parent theme directory. */
		define( 'THEME_DIR', get_template_directory() );

		/* Sets the path to the parent theme directory URI. */
		define( 'THEME_URI', get_template_directory_uri() );

		/* Sets the path to the child theme directory. */
		define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

		/* Sets the path to the child theme directory URI. */
		define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

		/* Sets the path to the core framework directory. */
		define( 'EXMACHINA_DIR', trailingslashit( THEME_DIR ) . basename( dirname( __FILE__ ) ) );

		/* Sets the path to the core framework directory URI. */
		define( 'EXMACHINA_URI', trailingslashit( THEME_URI ) . basename( dirname( __FILE__ ) ) );

		/* Sets the path to the core framework admin directory. */
		define( 'EXMACHINA_ADMIN', trailingslashit( EXMACHINA_DIR ) . 'admin' );

		/* Sets the path to the core framework classes directory. */
		define( 'EXMACHINA_CLASSES', trailingslashit( EXMACHINA_DIR ) . 'classes' );

		/* Sets the path to the core framework extensions directory. */
		define( 'EXMACHINA_EXTENSIONS', trailingslashit( EXMACHINA_DIR ) . 'extensions' );

		/* Sets the path to the core framework framework directory. */
		define( 'EXMACHINA_FRAMEWORK', trailingslashit( EXMACHINA_DIR ) . 'framework' );

		/* Sets the path to the core framework functions directory. */
		define( 'EXMACHINA_FUNCTIONS', trailingslashit( EXMACHINA_DIR ) . 'functions' );

		/* Sets the path to the core framework structure directory. */
		define( 'EXMACHINA_STRUCTURE', trailingslashit( EXMACHINA_DIR ) . 'structure' );

		/* Sets the path to the core framework widgets directory. */
		define( 'EXMACHINA_WIDGETS', trailingslashit( EXMACHINA_DIR ) . 'widgets' );

		/* Sets the path to the core framework languages directory. */
		define( 'EXMACHINA_LANGUAGES', trailingslashit( EXMACHINA_DIR ) . 'languages' );

		/* Sets the path to the core framework images directory URI. */
		define( 'EXMACHINA_IMAGES', trailingslashit( EXMACHINA_URI ) . 'images' );

		/* Sets the path to the core framework CSS directory URI. */
		define( 'EXMACHINA_CSS', trailingslashit( EXMACHINA_URI ) . 'css' );

		/* Sets the path to the core framework JavaScript directory URI. */
		define( 'EXMACHINA_JS', trailingslashit( EXMACHINA_URI ) . 'js' );
	}

	/**
	 * Loads the core framework functions.  These files are needed before loading anything else in the
	 * framework because they have required functions for use.
	 *
	 * @since 1.0.0
	 */
	function core() {

		/* Load the core framework functions. */
		require_once( trailingslashit( EXMACHINA_FRAMEWORK ) . 'core.php' );

		/* Load the context-based functions. */
		require_once( trailingslashit( EXMACHINA_FRAMEWORK ) . 'context.php' );

		/* Load the core framework internationalization functions. */
		require_once( trailingslashit( EXMACHINA_FRAMEWORK ) . 'i18n.php' );
	}

	/**
	 * Loads both the parent and child theme translation files.  If a locale-based functions file exists
	 * in either the parent or child theme (child overrides parent), it will also be loaded.  All translation
	 * and locale functions files are expected to be within the theme's '/languages' folder, but the
	 * framework will fall back on the theme root folder if necessary.  Translation files are expected
	 * to be prefixed with the template or stylesheet path (example: 'templatename-en_US.mo').
	 *
	 * @since 1.2.0
	 */
	function i18n() {
		global $exmachina;

		/* Get parent and child theme textdomains. */
		$parent_textdomain = exmachina_get_parent_textdomain();
		$child_textdomain = exmachina_get_child_textdomain();

		/* Load the framework textdomain. */
		$exmachina->textdomain_loaded['exmachina-core'] = exmachina_load_framework_textdomain( 'exmachina-core' );

		/* Load theme textdomain. */
		$exmachina->textdomain_loaded[$parent_textdomain] = load_theme_textdomain( $parent_textdomain );

		/* Load child theme textdomain. */
		$exmachina->textdomain_loaded[$child_textdomain] = is_child_theme() ? load_child_theme_textdomain( $child_textdomain ) : false;

		/* Get the user's locale. */
		$locale = get_locale();

		/* Locate a locale-specific functions file. */
		$locale_functions = locate_template( array( "languages/{$locale}.php", "{$locale}.php" ) );

		/* If the locale file exists and is readable, load it. */
		if ( !empty( $locale_functions ) && is_readable( $locale_functions ) )
			require_once( $locale_functions );
	}

	/**
	 * Removes theme supported features from themes in the case that a user has a plugin installed
	 * that handles the functionality.
	 *
	 * @since 1.3.0
	 */
	function theme_support() {

		/* Remove support for the core SEO component if the WP SEO plugin is installed. */
		if ( defined( 'WPSEO_VERSION' ) )
			remove_theme_support( 'exmachina-core-seo' );

		/* Remove support for the the Breadcrumb Trail extension if the plugin is installed. */
		if ( function_exists( 'breadcrumb_trail' ) )
			remove_theme_support( 'breadcrumb-trail' );

		/* Remove support for the the Cleaner Gallery extension if the plugin is installed. */
		if ( function_exists( 'cleaner_gallery' ) )
			remove_theme_support( 'cleaner-gallery' );

		/* Remove support for the the Get the Image extension if the plugin is installed. */
		if ( function_exists( 'get_the_image' ) )
			remove_theme_support( 'get-the-image' );

		/* Remove support for the Featured Header extension if the class exists. */
		if ( class_exists( 'Featured_Header' ) )
			remove_theme_support( 'featured-header' );

		/* Remove support for the Random Custom Background extension if the class exists. */
		if ( class_exists( 'Random_Custom_Background' ) )
			remove_theme_support( 'random-custom-background' );
	}

	/**
	 * Loads the framework functions.  Many of these functions are needed to properly run the
	 * framework.  Some components are only loaded if the theme supports them.
	 *
	 * @since 0.7.0
	 */
	function functions() {

		/* Load the comments functions. */
		require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'comments.php' );

		/* Load the extras functions. */
		require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'extras.php' );

		/* Load image-related functions. */
		require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'image.php' );

		/* Load media-related functions. */
		require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'media.php' );

		/* Load the metadata functions. */
		require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'meta.php' );

		/* Load the template functions. */
		require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'template.php' );

		/* Load the template tags functions. */
		require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'template-tags.php' );

		/* Load the utility functions. */
		require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'utility.php' );

		/* Load the wish-list functions. */
		require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'wish-list.php' );

		/* Load the theme settings functions if supported. */
		require_if_theme_supports( 'exmachina-core-theme-settings', trailingslashit( EXMACHINA_FUNCTIONS ) . 'settings.php' );

		/* Load the customizer functions if theme settings are supported. */
		require_if_theme_supports( 'exmachina-core-theme-settings', trailingslashit( EXMACHINA_FUNCTIONS ) . 'customize.php' );

		/* Load the menus functions if supported. */
		require_if_theme_supports( 'exmachina-core-menus', trailingslashit( EXMACHINA_FUNCTIONS ) . 'menus.php' );

		/* Load the core SEO component if supported. */
		require_if_theme_supports( 'exmachina-core-seo', trailingslashit( EXMACHINA_FUNCTIONS ) . 'core-seo.php' );

		/* Load the shortcodes if supported. */
		require_if_theme_supports( 'exmachina-core-shortcodes', trailingslashit( EXMACHINA_FUNCTIONS ) . 'shortcodes.php' );

		/* Load the sidebars if supported. */
		require_if_theme_supports( 'exmachina-core-sidebars', trailingslashit( EXMACHINA_FUNCTIONS ) . 'sidebars.php' );

		/* Load the widgets if supported. */
		require_if_theme_supports( 'exmachina-core-widgets', trailingslashit( EXMACHINA_FUNCTIONS ) . 'widgets.php' );

		/* Load the template hierarchy if supported. */
		require_if_theme_supports( 'exmachina-core-template-hierarchy', trailingslashit( EXMACHINA_FUNCTIONS ) . 'template-hierarchy.php' );

		/* Load the styles if supported. */
		require_if_theme_supports( 'exmachina-core-styles', trailingslashit( EXMACHINA_FUNCTIONS ) . 'styles.php' );

		/* Load the scripts if supported. */
		require_if_theme_supports( 'exmachina-core-scripts', trailingslashit( EXMACHINA_FUNCTIONS ) . 'scripts.php' );

		/* Load the media grabber script if supported. */
		require_if_theme_supports( 'exmachina-core-media-grabber', trailingslashit( EXMACHINA_CLASSES ) . 'media-grabber.php' );

		/* Load the post format functionality if post formats are supported. */
		require_if_theme_supports( 'post-formats', trailingslashit( EXMACHINA_FUNCTIONS ) . 'post-formats.php' );

		/* Load the deprecated functions if supported. */
		require_if_theme_supports( 'exmachina-core-deprecated', trailingslashit( EXMACHINA_FUNCTIONS ) . 'deprecated.php' );
	}

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
  function structure() {

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
	 * Load extensions (external projects).  Extensions are projects that are included within the
	 * framework but are not a part of it.  They are external projects developed outside of the
	 * framework.  Themes must use add_theme_support( $extension ) to use a specific extension
	 * within the theme.  This should be declared on 'after_setup_theme' no later than a priority of 11.
	 *
	 * @since 0.7.0
	 */
	function extensions() {

		/* Load the Breadcrumb Trail extension if supported. */
		require_if_theme_supports( 'breadcrumb-trail', trailingslashit( EXMACHINA_EXTENSIONS ) . 'breadcrumb-trail.php' );

		/* Load the Cleaner Gallery extension if supported. */
		require_if_theme_supports( 'cleaner-gallery', trailingslashit( EXMACHINA_EXTENSIONS ) . 'cleaner-gallery.php' );

		/* Load the Get the Image extension if supported. */
		require_if_theme_supports( 'get-the-image', trailingslashit( EXMACHINA_EXTENSIONS ) . 'get-the-image.php' );

		/* Load the Cleaner Caption extension if supported. */
		require_if_theme_supports( 'cleaner-caption', trailingslashit( EXMACHINA_EXTENSIONS ) . 'cleaner-caption.php' );

		/* Load the Custom Field Series extension if supported. */
		require_if_theme_supports( 'custom-field-series', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-field-series.php' );

		/* Load the Loop Pagination extension if supported. */
		require_if_theme_supports( 'loop-pagination', trailingslashit( EXMACHINA_EXTENSIONS ) . 'loop-pagination.php' );

		/* Load the Entry Views extension if supported. */
		require_if_theme_supports( 'entry-views', trailingslashit( EXMACHINA_EXTENSIONS ) . 'entry-views.php' );

		/* Load the Theme Layouts extension if supported. */
		require_if_theme_supports( 'theme-layouts', trailingslashit( EXMACHINA_EXTENSIONS ) . 'theme-layouts.php' );

		/* Load the Post Stylesheets extension if supported. */
		require_if_theme_supports( 'post-stylesheets', trailingslashit( EXMACHINA_EXTENSIONS ) . 'post-stylesheets.php' );

		/* Load the Featured Header extension if supported. */
		require_if_theme_supports( 'featured-header', trailingslashit( EXMACHINA_EXTENSIONS ) . 'featured-header.php' );

		/* Load the Random Custom Background extension if supported. */
		require_if_theme_supports( 'random-custom-background', trailingslashit( EXMACHINA_EXTENSIONS ) . 'random-custom-background.php' );

		/* Load the Color Palette extension if supported. */
		require_if_theme_supports( 'color-palette', trailingslashit( EXMACHINA_EXTENSIONS ) . 'color-palette.php' );

		/* Load the Theme Fonts extension if supported. */
		require_if_theme_supports( 'theme-fonts', trailingslashit( EXMACHINA_EXTENSIONS ) . 'theme-fonts.php' );

		/* Load the Responsive Viewport extension if supported. */
		require_if_theme_supports( 'responsive-viewport', trailingslashit( EXMACHINA_EXTENSIONS ) . 'responsive-viewport.php' );

		/* Load the Structural Wraps extension if supported. */
		require_if_theme_supports( 'structural-wraps', trailingslashit( EXMACHINA_EXTENSIONS ) . 'structural-wraps.php' );

		/* Load the Footer Widgets extension if supported. */
		require_if_theme_supports( 'footer-widgets', trailingslashit( EXMACHINA_EXTENSIONS ) . 'footer-widgets.php' );

		/* Load the Custom CSS extension if supported. */
    require_if_theme_supports( 'custom-css', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-css.php' );

    /* Load the Custom Logo extension if supported. */
    require_if_theme_supports( 'custom-logo', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-logo.php' );

    /* Load the Custom Favicon extension if supported. */
    require_if_theme_supports( 'custom-favicon', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-favicon.php' );

    /* Load the Sliding Panel extension if supported. */
    require_if_theme_supports( 'sliding-panel', trailingslashit( EXMACHINA_EXTENSIONS ) . 'sliding-panel.php' );

    /* Load the Template Tags Shortcodes extension if supported. */
    require_if_theme_supports( 'template-tags', trailingslashit( EXMACHINA_EXTENSIONS ) . 'template-tag-shortcodes.php' );

    /* Load the Custom Snippets extension if supported. */
    require_if_theme_supports( 'custom-snippets', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-snippets.php' );

    /* Load the Cleaner Archives extension if supported. */
    require_if_theme_supports( 'cleaner-archives', trailingslashit( EXMACHINA_EXTENSIONS ) . 'cleaner-archives.php' );

    /* Load the Grid Columns extension if supported. */
    require_if_theme_supports( 'grid-columns', trailingslashit( EXMACHINA_EXTENSIONS ) . 'grid-columns.php' );

    /* Load the Custom Header Extended extension if supported. */
    require_if_theme_supports( 'custom-header-extended', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-header-extended.php' );

    /* Load the Custom Background Extended extension if supported. */
    require_if_theme_supports( 'custom-background-extended', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-background-extended.php' );

    /* Load the Custom Classes extension if supported. */
    require_if_theme_supports( 'custom-classes', trailingslashit( EXMACHINA_EXTENSIONS ) . 'custom-classes.php' );
	}

	/**
	 * Load admin files for the framework.
	 *
	 * @since 0.7.0
	 */
	function admin() {

		/* Check if in the WordPress admin. */
		if ( is_admin() ) {

			/* Load the main admin file. */
			require_once( trailingslashit( EXMACHINA_ADMIN ) . 'admin.php' );

			/* Load the theme settings feature if supported. */
			require_if_theme_supports( 'exmachina-core-theme-settings', trailingslashit( EXMACHINA_ADMIN ) . 'theme-settings.php' );
		}
	}

	/**
	 * Adds the default framework actions and filters.
	 *
	 * @since 1.0.0
	 */
	function default_filters() {

		/* Remove bbPress theme compatibility if current theme supports bbPress. */
		if ( current_theme_supports( 'bbpress' ) )
			remove_action( 'bbp_init', 'bbp_setup_theme_compat', 8 );

		/* Move the WordPress generator to a better priority. */
		remove_action( 'wp_head', 'wp_generator' );
		add_action( 'wp_head', 'wp_generator', 1 );

		/* Add the theme info to the header (lets theme developers give better support). */
		add_action( 'wp_head', 'exmachina_meta_template', 1 );

		/* Make text widgets and term descriptions shortcode aware. */
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'term_description', 'do_shortcode' );
	}
}

?>