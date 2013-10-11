<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Main Admin Functions
 *
 * admin.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Theme administration functions used with other components of the framework
 * admin. This file is for setting up any basic features and holding additional
 * admin helper functions.
 *
 * @package     ExMachina
 * @subpackage  Admin Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/* Add the admin script setup function to the 'exmachina_setup' hook. */
add_action( 'exmachina_setup', 'exmachina_admin_script_setup' );

/**
 * Admin Setup
 *
 * Sets up the administration functionality for the framework and themes. This
 * files serves as an action hook loader for other functions used in the theme
 * settings and on the backend of the site.
 *
 * @uses exmachina_admin_custom_icons()         Adds custom menu icons.
 * @uses exmachina_admin_load_post_meta_boxes() Loads the post metaboxes.
 * @uses exmachina_admin_vendor_assets()        Loads third-party scripts & styles.
 * @uses exmachina_admin_register_scripts()     Register admin scripts.
 * @uses exmachina_admin_register_styles()      Register admin styles.
 * @uses exmachina_admin_enqueue_styles()       Enqueue admin styles.
 *
 * @since 1.0.0
 * @access public
 *
 * @return void
 */
function exmachina_admin_script_setup() {

  /* Adds custom icons to the admin menu. */
  add_action( 'admin_head', 'exmachina_admin_custom_icons' );

  /* Registers vendor stylesheets and javascripts for the framework. */
  add_action( 'admin_enqueue_scripts', 'exmachina_admin_vendor_assets', 1 );

  /* Registers admin stylesheets and javascripts for the framework. */
  add_action( 'admin_enqueue_scripts', 'exmachina_admin_register_scripts', 1 );
  add_action( 'admin_enqueue_scripts', 'exmachina_admin_register_styles', 1 );

  /* Loads admin stylesheets and javascripts for the framework. */
  add_action( 'admin_enqueue_scripts', 'exmachina_admin_enqueue_scripts' );
  add_action( 'admin_enqueue_scripts', 'exmachina_admin_enqueue_styles' );

} // end function exmachina_admin_setup()

/**
 * Custom Admin Icons
 *
 * Adds custom icons to the top level admin menus. Admin menu icons are located
 * in the 'EXMACHINA_ADMIN_IMAGES' directory under 'icons.'
 *
 * @todo try using a CSS stylesheet instead
 *
 * @link http://randyjensenonline.com/thoughts/wordpress-custom-post-type-fugue-icons/
 *
 * @uses EXMACHINA_ADMIN_IMAGES Admin images directory constant.
 *
 * @since 1.0.0
 * @return void
 */
function exmachina_admin_custom_icons() {
  ?>
    <style type="text/css" media="screen">

        #toplevel_page_theme-settings .wp-menu-image {
          background: url(<?php echo trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'icons/control-power.png'; ?>) no-repeat 6px -17px !important;
        }

        #toplevel_page_theme-settings:hover .wp-menu-image,
        #toplevel_page_theme-settings.current .wp-menu-image,
        #toplevel_page_theme-settings.wp-has-current-submenu .wp-menu-image {
          background-position:6px 7px!important;
        }

        #adminmenu .toplevel_page_theme-settings .wp-menu-image img {
          height: 16px;
          width: 16px;
        }

        .admin-color-mp6 #adminmenu .toplevel_page_theme-settings .wp-menu-image img {
          display: none;
        }

        .admin-color-mp6 #adminmenu .toplevel_page_theme-settings .wp-menu-image:before {
          content: '\f011';
          font-family: "FontAwesome" !important;
          font-size: 20px;
          font-weight: normal;
        }
    </style>
  <?php

} // end function exmachina_admin_custom_icons()

/**
 * Register Vendor Admin Assets
 *
 * Registers external assets, plugins, and packages that were developed outside
 * of the frameword (vendor assets). This function does not load the JavaScript
 * files or CSS Stylesheets, it merely registers them for use within WordPress.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_register_script
 * @link http://codex.wordpress.org/Function_Reference/wp_register_style
 * @link http://codex.wordpress.org/Function_Reference/trailingslashit
 *
 * @uses EXMACHINA_ADMIN_VENDOR [description]
 *
 * @since 1.0.0
 * @access public
 *
 * @return void
 */
function exmachina_admin_vendor_assets() {

  /* Use the .min version if SCRIPT_DEBUG is turned off. */
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  /* Register the uikit framework CSS and JS. */
  wp_register_script( 'exmachina-uikit-admin-js', esc_url( trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "uikit/js/uikit{$suffix}.js" ), array( 'jquery' ), '1.1.0', true );
  wp_register_style( 'exmachina-uikit-admin-css', trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "uikit/css/uikit.gradient{$suffix}.css", false, '1.1.0', 'screen' );

  /* Register the bootstrap framework CSS and JS. */
  wp_register_script( 'exmachina-bootstrap-admin-js', esc_url( trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "bootstrap/js/bootstrap{$suffix}.js" ), array( 'jquery' ), '3.0.0', true );
  wp_register_style( 'exmachina-bootstrap-admin-css', trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "bootstrap/css/bootstrap{$suffix}.css", false, '3.0.0', 'screen' );

  /* Register the minicolors jQuery plugin CSS and JS. */
  wp_register_script( 'exmachina-minicolors-js', esc_url( trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "minicolors/js/jquery.minicolors{$suffix}.js" ), array( 'jquery' ), '2.1.0', true );
  wp_register_style( 'exmachina-minicolors-css', trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "minicolors/css/jquery.minicolors{$suffix}.css", false, '2.1.0', 'screen' );

  /* Register the select2 jQuery plugin CSS and JS. */
  wp_register_script( 'exmachina-select-js', esc_url( trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "select/js/select{$suffix}.js" ), array( 'jquery' ), '3.4.2', true );
  wp_register_style( 'exmachina-select-css', trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "select/css/select{$suffix}.css", false, '3.4.2', 'screen' );

  /* Register codemirror plugin CSS and JS. */
  wp_register_script( 'exmachina-codemirror-js', esc_url( trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "codemirror/js/codemirror{$suffix}.js" ), array(), '3.1.6', true );
  wp_register_script( 'exmachina-codemirror-mode-js', esc_url( trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "codemirror/js/codemirror.mode{$suffix}.js" ), array( 'jquery' ), '3.1.6', true );
  wp_register_style( 'exmachina-codemirror-css', trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "codemirror/css/codemirror{$suffix}.css", false, '3.1.6', 'screen' );

} // end function exmachina_admin_vendor_assets()

/**
 * Register Admin JavaScripts
 *
 * Registers the framework's core javascript files. The function does not load
 * the JavaScript files, it merely registers them for use within WordPress.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_register_script
 * @link http://codex.wordpress.org/Function_Reference/trailingslashit
 *
 * @uses EXMACHINA_ADMIN_JS [description]
 * @uses EXMACHINA_VERSION [description]
 *
 * @since 1.0.0
 * @access public
 *
 * @return void
 */
function exmachina_admin_register_scripts() {

  /* Use the .min JavaScript if SCRIPT_DEBUG is turned off. */
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  /* Register the admin typography preview JavaScript file. */
  wp_register_script( 'exmachina-core-admin-typography-js', trailingslashit( EXMACHINA_ADMIN_JS ) . "font-preview{$suffix}.js", array( 'jquery' ), EXMACHINA_VERSION, true );

  /* Register the admin setup JavaScript file. */
  wp_register_script( 'exmachina-core-admin-setup-js', trailingslashit( EXMACHINA_ADMIN_JS ) . "setup{$suffix}.js", array( 'jquery' ), EXMACHINA_VERSION, true );

  /* Register the core admin JavaScript file. */
  wp_register_script( 'exmachina-core-admin-js', trailingslashit( EXMACHINA_ADMIN_JS ) . "admin{$suffix}.js", array( 'jquery' ), EXMACHINA_VERSION, false );

} // end function exmachina_admin_register_scripts()

/**
 * Enqueue Admin JavaScripts
 *
 * Loads the admin JavaScripts for admin-related features.
 *
 * @todo test that JS loads
 * @todo uncomment post screen JS
 * @todo maybe split js better
 * @todo replace load_admin_js function in other files
 * @todo filter loacalization screens
 * @todo revampe toggles
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Post
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @link http://codex.wordpress.org/Function_Reference/post_type_supports
 * @link http://codex.wordpress.org/Function_Reference/wp_localize_script
 *
 * @uses exmachina_is_menu_page() Checks admin menu page hook.
 * @uses exmachina_seo_disabled() Detects if SEO functionality is active.
 *
 * @since 1.0.0
 * @access public
 *
 * @global object $post        WP_Post post object.
 * @param  string $hook_suffix Page hook suffix.
 * @return void
 */
function exmachina_admin_enqueue_scripts( $hook_suffix ) {
  global $post;

  /* Enqueue the admin JavaScripts on the admin menu screens. */
  if ( exmachina_is_menu_page( 'theme-settings' ) || exmachina_is_menu_page( 'seo-settings' ) || exmachina_is_menu_page( 'design-settings' ) || exmachina_is_menu_page( 'import-export' ) ) {

    /* Enqueue uikit JavaScript if on an admin settings screen. */
    wp_enqueue_script( 'exmachina-uikit-admin-js' );

    /* Enqueue minicolors JavaScript if on an admin settings screen. */
    wp_enqueue_script( 'exmachina-minicolors-js' );

    /* Enqueue codemirror JavaScript if on an admin settings screen. */
    wp_enqueue_script( 'exmachina-codemirror-js' );
    wp_enqueue_script( 'exmachina-codemirror-mode-js' );

    /* Enqueue select2 JavaScript if on an admin settings screen. */
    wp_enqueue_script( 'exmachina-select-js' );

    /* Enqueue bootstrap JavaScript if on an admin settings screen. */
    wp_enqueue_script( 'exmachina-bootstrap-admin-js' );

    /* Enqueue typography JavaScript if on an admin settings screen. */
    wp_enqueue_script( 'exmachina-core-admin-typography-js' );

    /* Enqueue admin setup JavaScript if on an admin settings screen. */
    wp_enqueue_script( 'exmachina-core-admin-setup-js' );

    /* Enqueue admin JavaScript if on an admin settings screen. */
    wp_enqueue_script( 'exmachina-core-admin-js' );

  } // end if ( exmachina_is_menu_page('theme-settings') || exmachina_is_menu_page('seo-settings') || exmachina_is_menu_page('design-settings'))

  /* Enqueue the admin JavaScripts on the edit post pages. */
  //if ( in_array( $hook_suffix, array( 'post-new.php', 'post.php' ) ) ) {
  //  if ( ! exmachina_seo_disabled() && post_type_supports( $post->post_type, 'exmachina-seo' ) )
  //    wp_enqueue_script( 'exmachina-core-admin-js' );
  //} // end if (in_array($hook_suffix, array('post-new.php', 'post.php')))

  /* Set the localization strings. */
  $strings = array(
    'categoryChecklistToggle' => __( 'Select / Deselect All', 'exmachina-core' ),
    'saveAlert'               => __('The changes you made will be lost if you navigate away from this page.', 'exmachina-core'),
    'confirmReset'            => __( 'Are you sure you want to reset?', 'exmachina-core' ),
  );

  /* Localize the string. */
  wp_localize_script( 'exmachina-core-admin-js', 'exmachinaL10n', $strings );

  /* Create toggles selectors. */
  $toggles = array(
    /* Checkboxes - when checked, show extra settings. */
    'content_archive_thumbnail' => array( '#exmachina-settings\\[content_archive_thumbnail\\]', '#exmachina_image_size', '_checked' ),
    /* Checkboxed - when unchecked, show extra settings. */
    'semantic_headings'         => array( '#exmachina-seo-settings\\[semantic_headings\\]', '#exmachina_seo_h1_wrap', '_unchecked' ),
    /* Select toggles. */
    'nav_extras'                => array( '#exmachina-settings\\[nav_extras\\]', '#exmachina_nav_extras_twitter', 'twitter' ),
    'content_archive'           => array( '#exmachina-settings\\[content_archive\\]', '#exmachina_content_limit_setting', 'full' ),
  );

  /* Localize toggles. */
  wp_localize_script( 'exmachina-core-admin-js', 'exmachina_toggles', apply_filters( 'exmachina_toggles', $toggles ) );

} // end function exmachina_admin_enqueue_scripts()

/**
 * Register Admin CSS Stylesheets
 *
 * Registers the framework's core stylesheet files. The function does not load
 * the stylesheets, it merely registers them for use within WordPress.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_register_style
 * @link http://codex.wordpress.org/Function_Reference/trailingslashit
 *
 * @uses EXMACHINA_ADMIN_CSS [description]
 * @uses EXMACHINA_VERSION [description]
 *
 * @since 1.0.0
 * @access public
 *
 * @return void
 */
function exmachina_admin_register_styles() {

  /* Use the .min stylesheet if SCRIPT_DEBUG is turned off. */
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  /* Register the admin normalize CSS stylesheet file. */
  wp_register_style( 'exmachina-core-admin-reset-css', trailingslashit( EXMACHINA_ADMIN_CSS ) . "reset{$suffix}.css", false, EXMACHINA_VERSION, 'screen' );

  /* Register the admin editor CSS stylesheet file. */
  wp_register_style( 'exmachina-core-admin-editor-css', trailingslashit( EXMACHINA_ADMIN_CSS ) . "editor{$suffix}.css", false, EXMACHINA_VERSION, 'screen' );

  /* Register the admin widgets CSS stylesheet file. */
  wp_register_style( 'exmachina-core-admin-widgets-css', trailingslashit( EXMACHINA_ADMIN_CSS ) . "widgets{$suffix}.css", false, EXMACHINA_VERSION, 'screen' );

  /* Register the admin colorpicker CSS stylesheet file. */
  wp_register_style( 'exmachina-core-admin-minicolors-css', trailingslashit( EXMACHINA_ADMIN_CSS ) . "minicolors{$suffix}.css", false, EXMACHINA_VERSION, 'screen' );

  /* Register the core admin CSS stylesheet file. */
  wp_register_style( 'exmachina-core-admin-css', trailingslashit( EXMACHINA_ADMIN_CSS ) . "admin{$suffix}.css", false, EXMACHINA_VERSION, 'screen' );

} // end function exmachina_admin_register_styles()

/**
 * Enqueue Admin CSS Stylesheets
 *
 * Loads the admin CSS stylesheets for admin-related features.
 *
 * @todo add more loaders
 *
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 * @since 1.0.0
 * @access public
 *
 * @param  string $hook_suffix Page hook suffix.
 * @return void
 */
function exmachina_admin_enqueue_styles( $hook_suffix ) {

  /* Enqueue the admin stylesheets on the admin menu screens. */
  if ( exmachina_is_menu_page( 'theme-settings' ) || exmachina_is_menu_page( 'seo-settings' ) || exmachina_is_menu_page( 'design-settings' ) || exmachina_is_menu_page( 'import-export' ) ) {

    /* Enqueue normalize stylesheet if on an admin settings screen. */
    wp_enqueue_style( 'exmachina-core-admin-reset-css' );

    /* Enqueue uikit stylesheet if on an admin settings screen. */
    wp_enqueue_style( 'exmachina-uikit-admin-css' );

    /* Enqueue minicolors stylesheet if on an admin settings screen. */
    wp_enqueue_style( 'exmachina-minicolors-css' );

    /* Enqueue codemirror stylesheet if on an admin settings screen. */
    wp_enqueue_style( 'exmachina-codemirror-css' );

    /* Enqueue select2 stylesheet if on an admin settings screen. */
    wp_enqueue_style( 'exmachina-select-css' );

    /* Enqueue minicolors stylesheet if on an admin settings screen. */
    wp_enqueue_style( 'exmachina-core-admin-minicolors-css' );

    /* Enqueue admin stylesheet if on an admin settings screen. */
    wp_enqueue_style( 'exmachina-core-admin-css' );

  } // end if (exmachina_is_menu_page('theme-settings') || exmachina_is_menu_page('seo-settings') || exmachina_is_menu_page('design-settings'))

  /* Load admin styles if on the widgets screen and the current theme supports 'exmachina-core-widgets'. */
  if ( current_theme_supports( 'exmachina-core-widgets' ) && 'widgets.php' == $hook_suffix )
    wp_enqueue_style( 'exmachina-core-admin-widgets-css' );

} // end function exmachina_admin_enqueue_styles()
