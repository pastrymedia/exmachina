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

/* Add the admin setup function to the 'admin_menu' hook. */
add_action( 'admin_menu', 'exmachina_admin_setup' );

/* Add additional contact methods. */
add_filter( 'user_contactmethods', 'exmachina_contact_methods' );

/**
 * Admin Setup
 *
 * Sets up the administration functionality for the framework and themes. This
 * files serves as an action hook loader for other functions used in the theme
 * settings and on the backend of the site.
 *
 * @uses exmachina_admin_load_post_meta_boxes() Loads the post metaboxes.
 * @uses exmachina_admin_register_styles()      Register admin styles.
 * @uses exmachina_admin_enqueue_styles()       Enqueue admin styles.
 *
 * @since 2.6.0
 * @access public
 *
 * @return void
 */
function exmachina_admin_setup() {

  /* Adds custom icons to the admin menu. */
  add_action( 'admin_head', 'exmachina_admin_custom_icons' );

  /* Registers admin javascripts and stylesheets for the framework. */
  add_action( 'admin_enqueue_scripts', 'exmachina_admin_vendor_assets', 1 );
  add_action( 'admin_enqueue_scripts', 'exmachina_admin_register_scripts', 1 );
  add_action( 'admin_enqueue_scripts', 'exmachina_admin_register_styles', 1 );

  /* Loads admin stylesheets for the framework. */
  add_action( 'admin_enqueue_scripts', 'exmachina_admin_enqueue_styles' );

  /* Load the post meta boxes on the new post and edit post screens. */
  add_action( 'load-post.php', 'exmachina_admin_load_post_meta_boxes' );
  add_action( 'load-post-new.php', 'exmachina_admin_load_post_meta_boxes' );

} // end function exmachina_admin_setup()

/*-------------------------------------------------------------------------*/
/* == Admin Menu Functions */
/*-------------------------------------------------------------------------*/

/**
 * Custom Admin Icons
 *
 * Adds custom icons to the top level admin menus. Admin menu icons are located
 * in the 'EXMACHINA_ADMIN_IMAGES' directory under 'icons.'
 *
 * @link http://randyjensenonline.com/thoughts/wordpress-custom-post-type-fugue-icons/
 *
 * @since 2.6.0
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


/*-------------------------------------------------------------------------*/
/* == Admin Assets Functions */
/*-------------------------------------------------------------------------*/

/**
 * Register Vendor Admin Assets
 *
 * Registers external assets, plugins, and packages that were developed outside
 * of the frameword (vendor assets). This function does not load the JavaScript
 * files or CSS Stylesheets, it merely registers them for use within WordPress.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_register_script
 * @link http://codex.wordpress.org/Function_Reference/wp_register_style
 *
 * @since 2.6.0
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
 * Register Admin JavaScript
 *
 * Registers the framework's core javascript files. The function does not load
 * the JavaScript files, it merely registers them for use within WordPress.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_register_script
 *
 * @since 2.6.0
 * @access public
 *
 * @return void
 */
function exmachina_admin_register_scripts() {

  /* Use the .min javascript if SCRIPT_DEBUG is turned off. */
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  /* Register the core admin JavaScript file. */
  wp_register_script( 'exmachina-core-admin-js', esc_url( trailingslashit( EXMACHINA_ADMIN_JS ) . "admin{$suffix}.js" ), array( 'jquery' ), EXMACHINA_VERSION, false );

} // end function exmachina_admin_register_scripts()

/**
 * Register Admin CSS Stylesheets
 *
 * Registers the framework's core stylesheet files. The function does not load
 * the stylesheets, it merely registers them for use within WordPress.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_register_style
 *
 * @since 2.6.0
 * @access public
 *
 * @return void
 */
function exmachina_admin_register_styles() {

  /* Use the .min stylesheet if SCRIPT_DEBUG is turned off. */
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  /* Register the core admin CSS stylesheet file. */
  wp_register_style( 'exmachina-core-admin-css', trailingslashit( EXMACHINA_ADMIN_CSS ) . "admin{$suffix}.css", false, EXMACHINA_VERSION, 'screen' );

} // end function exmachina_admin_register_styles()

/**
 * Enqueue Admin CSS Stylesheets
 *
 * Loads the admin CSS stylesheets for admin-related features.
 *
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 * @since 2.6.0
 * @access public
 *
 * @return void
 */
function exmachina_admin_enqueue_styles( $hook_suffix ) {

  /* Load admin styles if on the widgets screen and the current theme supports 'exmachina-core-widgets'. */
  if ( current_theme_supports( 'exmachina-core-widgets' ) && 'widgets.php' == $hook_suffix )
    wp_enqueue_style( 'exmachina-core-admin-css' );

} // end function exmachina_admin_enqueue_styles()

/*-------------------------------------------------------------------------*/
/* == Post Meta Functions */
/*-------------------------------------------------------------------------*/

/**
 * Load Post Metaboxes
 *
 * Loads the core post meta box files on the 'load-post.php' action hook. Each
 * meta box file is only loaded if the theme declares support for the feature.
 *
 * @link http://codex.wordpress.org/Function_Reference/require_if_theme_supports
 *
 * @since 2.6.0
 * @access public
 *
 * @return void
 */
function exmachina_admin_load_post_meta_boxes() {

  /* Load the post template meta box. */
  require_if_theme_supports( 'exmachina-core-template-hierarchy', trailingslashit( EXMACHINA_ADMIN_METABOXES ) . 'metabox-post-template.php' );

} // end function exmachina_admin_load_post_meta_boxes()

/*-------------------------------------------------------------------------*/
/* == User Meta Functions */
/*-------------------------------------------------------------------------*/

/**
 * User Contact Methods
 *
 * Adds new contact methods to the user profile screen for more modern social
 * media sites.
 *
 * @since 2.6.0
 * @access public
 *
 * @param  array $meta Array of original contact methods.
 * @return array       Array with new contact methods.
 */
function exmachina_contact_methods( $meta ) {

  /* Twitter contact method. */
  $meta['twitter'] = __( 'Twitter Username', 'exmachina-core' );

  /* Google+ contact method. */
  $meta['google_plus'] = __( 'Google+ URL', 'exmachina-core' );

  /* Facebook contact method. */
  $meta['facebook'] = __( 'Facebook URL', 'exmachina-core' );

  /* Return the array of contact methods. */
  return $meta;

} // end function exmachina_contact_methods()

/*-------------------------------------------------------------------------*/
/* == Post Template Functions */
/*-------------------------------------------------------------------------*/

/**
 * Get Post Templates
 *
 * Function for getting an array of available custom templates with a specific
 * header. Ideally, this function would be used to grab custom singular post
 * (any post type) templates. It is a recreation of the WordPress page templates
 * function because it doesn't allow for other types of templates.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_post_type_object
 * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
 * @link http://codex.wordpress.org/Function_Reference/get_template
 * @link http://codex.wordpress.org/Function_Reference/is_child_theme
 *
 * @since 2.6.0
 * @access public
 *
 * @global object $exmachina      The global ExMachina object.
 * @param  string $post_type      The name of the post type to get templates for.
 * @return array  $post_templates The array of templates.
 */
function exmachina_get_post_templates( $post_type = 'post' ) {
  global $exmachina;

  /* If templates have already been called, just return them. */
  if ( !empty( $exmachina->post_templates ) && isset( $exmachina->post_templates[ $post_type ] ) )
    return $exmachina->post_templates[ $post_type ];

  /* Else, set up an empty array to house the templates. */
  else
    $exmachina->post_templates = array();

  /* Set up an empty post templates array. */
  $post_templates = array();

  /* Get the post type object. */
  $post_type_object = get_post_type_object( $post_type );

  /* Get the theme (parent theme if using a child theme) object. */
  $theme = wp_get_theme( get_template() );

  /* Get the theme PHP files one level deep. */
  $files = (array) $theme->get_files( 'php', 1 );

  /* If a child theme is active, get its files and merge with the parent theme files. */
  if ( is_child_theme() ) {
    $child = wp_get_theme();
    $child_files = (array) $child->get_files( 'php', 1 );
    $files = array_merge( $files, $child_files );
  }

  /* Loop through each of the PHP files and check if they are post templates. */
  foreach ( $files as $file => $path ) {

    /* Get file data based on the post type singular name (e.g., "Post Template", "Book Template", etc.). */
    $headers = get_file_data(
      $path,
      array(
        "{$post_type_object->name} Template" => "{$post_type_object->name} Template",
      )
    );

    /* Continue loop if the header is empty. */
    if ( empty( $headers["{$post_type_object->name} Template"] ) )
      continue;

    /* Add the PHP filename and template name to the array. */
    $post_templates[ $file ] = $headers["{$post_type_object->name} Template"];
  }

  /* Add the templates to the global $exmachina object. */
  $exmachina->post_templates[ $post_type ] = array_flip( $post_templates );

  /* Return array of post templates. */
  return $exmachina->post_templates[ $post_type ];

} // end function exmachina_get_post_templates()