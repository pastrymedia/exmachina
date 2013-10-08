<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Custom Structure
 *
 * custom.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
 *
 * @package     ExMachina
 * @subpackage  Structure
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin structure
###############################################################################

/* Requires the custom.php file. */
add_action( 'after_setup_theme', 'exmachina_design_do_custom_php' );

/* Enquese custom stylesheets. */
add_action( 'wp_enqueue_scripts', 'exmachina_design_add_stylesheets' );

/**
 * Require Custom PHP File
 *
 * Requires the custom.php file, if it exists.
 *
 * @todo shorten function name
 * @todo inline comment function
 *
 * @uses exmachina_design_get_custom_php_path() [description]
 *
 * @since 0.5.0
 * @access private
 *
 * @return void
 */
function exmachina_design_do_custom_php() {

  if ( ! is_admin() && file_exists( exmachina_design_get_custom_php_path() ) )
    require_once( exmachina_design_get_custom_php_path() );

} // end function exmachina_design_do_custom_php()

/**
 * Custom PHP File Path
 *
 * Returns the full path to the custom.php file for editing and inclusion.
 *
 * @todo shorten function name
 *
 * @uses exmachina_design_get_stylesheet_location() [description]
 *
 * @since 0.5.0
 * @access private
 *
 * @return void
 */
function exmachina_design_get_custom_php_path() {

  /* Returns the path to the custom.php file. */
  return exmachina_design_get_stylesheet_location( 'path' ) . 'custom.php';

} // end function exmachina_design_get_custom_php_path()

/**
 * Create Custom PHP File
 *
 * Helper function that will create the custom.php file, if it doesn't already
 * exist.
 *
 * @todo what is the purpose of the opening line???
 * @todo shorten function name
 *
 * @uses exmachina_design_get_custom_php_path() [description]
 *
 * @since 0.5.0
 * @access private
 *
 * @return null Returns early if custom.php file exists.
 */
function exmachina_design_create_custom_php() {

  /* If file already exists, return early. */
  if ( file_exists( exmachina_design_get_custom_php_path() ) )
    return;

  /* Create and write to file. */
  $handle = @fopen( exmachina_design_get_custom_php_path(), 'w' );
  @fwrite( $handle, stripslashes( "<?php\n/** Do not remove this line. Edit functions below. */\n" ) );
  @fclose( $handle );

} // end function exmachina_design_create_custom_php()

/**
 * Edit Custom PHP File
 *
 * Helper function that edit the custom.php file, creating it if it doesn't
 * already exist.
 *
 * @todo shorten function name
 *
 * @uses exmachina_design_get_custom_php_path() [description]
 * @uses exmachina_design_create_custom_php()   [description]
 *
 * @since 0.5.0
 * @access private
 *
 * @param  string $text Content added to custom.php.
 * @return void
 */
function exmachina_desing_edit_custom_php( $text = '' ) {

  /* Create the file if it doesn't exist. */
  if ( ! file_exists( exmachina_design_get_custom_php_path() ) )
    exmachina_design_create_custom_php();

  /* Now that it exists, write text to that file. */
  $handle = @fopen( exmachina_design_get_custom_php_path(), 'w+' );
  @fwrite( $handle, stripslashes( $text ) );
  @fclose( $handle );

} // end function exmachina_design_edit_custom_php()

/*-------------------------------------------------------------------------*/
/* Begin stylesheet functions. */
/*-------------------------------------------------------------------------*/

/**
 * Get Custom Stylesheet Location
 *
 * Gets the correct stylesheet function for the URL or the path. Also, this
 * function takes into account multisite usage and domain mapping.
 *
 * @todo  update upload foler to change with template (i.e. use theme prefix)
 * @todo shorten function name and filter
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_upload_dir
 *
 * @since 0.5.0
 * @access private
 *
 * @param  string $type Either URL or path to define what is returned.
 * @return string       The full path to the custom files.
 */
function exmachina_design_get_stylesheet_location( $type ) {

  /* Sets the uploads directory. */
  $uploads = wp_upload_dir();

  /* Define either path or url based on filetype. */
  $dir = ( 'url' == $type ) ? $uploads['baseurl'] : $uploads['basedir'];

  /* Apply the filter and return the path/url. */
  return apply_filters( 'exmachina_design_get_stylesheet_location', $dir . '/design/' );
} // end function exmachina_design_get_stylesheet_location()

/**
 * Get Stylesheet Name
 *
 * Takes a stylesheet filename prefix, and appends '-X.css' where X is the
 * $blog_id if the $blog_id is greater than 1. Else adds '.css'.
 *
 * @todo not sure this function does what it says
 * @todo see where blog_id is being added.
 * @todo shorten function name
 * @todo shorten filter name
 * @todo change stylesheet name
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string $slug Filename prefix.
 * @return string       Stylesheet name.
 */
function exmachina_design_get_stylesheet_name( $slug = 'stylesheet' ) {

  return apply_filters( 'exmachina_design_get_stylesheet_name', $slug . '.css' );

} // end function exmachina_design_get_stylesheet_name()

/**
 * Get Minified Stylesheet Name
 *
 * Get the name of the generated combined minified stylesheet. Default filename
 * is minified.css, although this is filterable.
 *
 * @todo shorten function name
 * @todo shorten filter name
 * @todo change minified stylesheet name
 *
 * @uses exmachina_design_get_stylesheet_name() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return string Minified stylesheet name.
 */
function exmachina_design_get_minified_stylesheet_name() {

  return apply_filters( 'exmachina_design_get_minified_stylesheet_name', exmachina_design_get_stylesheet_name( 'minified' ) );

} // end function exmachina_design_get_minified_stylesheet_name()

/**
 * Get Settings Stylesheet Name
 *
 * Get the name of the generated settings stylesheet. Default filename is settings.css,
 * although this is filterable via exmachina_design_get_settings_stylesheet_name.
 *
 * @todo shorten function name
 * @todo shorten filter name
 * @todo change settings styleshhet name
 * @todo find out where this function is used
 *
 * @uses exmachina_design_get_stylesheet_name() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return string Settings stylesheet name.
 */
function exmachina_design_get_settings_stylesheet_name() {

  return apply_filters( 'exmachina_design_get_settings_stylesheet_name', exmachina_design_get_stylesheet_name( 'settings' ) );

} // end function exmachina_design_get_settings_stylesheet_name()

/**
 * Get Custom Stylesheet Name
 *
 * Get the name of the custom stylesheet. Default filename is custom.css,
 * although this is filterable via exmachina_design_get_custom_stylesheet_name.
 *
 * @todo shorten function name
 * @todo shorten filter name
 * @todo find where this function is used
 *
 * @uses exmachina_design_get_stylesheet_name() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return string Custom stylesheet name.
 */
function exmachina_design_get_custom_stylesheet_name() {

  return apply_filters( 'exmachina_design_get_custom_stylesheet_name', exmachina_design_get_stylesheet_name( 'custom' ) );

} // end function exmachina_design_get_custom_stylesheet_name()

/**
 * Get Minified Stylesheet Path
 *
 * Gets the file path of the minified stylesheet.
 *
 * @todo shorten function name
 * @todo shorten filter name
 * @todo find where function is used
 *
 * @uses exmachina_design_get_stylesheet_location() [description]
 * @uses exmachina_design_get_minified_stylesheet_name() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return string Minfied stylesheet path.
 */
function exmachina_design_get_minified_stylesheet_path() {

  return apply_filters( 'exmachina_design_get_minified_stylesheet_path', exmachina_design_get_stylesheet_location( 'path' ) . exmachina_design_get_minified_stylesheet_name() );

} // end function exmachina_design_get_minified_stylesheet_path()

/**
 * Get Settings Stylesheet Path
 *
 * Gets the file path of the settings stylesheet.
 *
 * @todo shorten function name
 * @todo shorten filter name
 * @todo find where function is used
 *
 * @uses exmachina_design_get_stylesheet_location() [description]
 * @uses exmachina_design_get_settings_stylesheet_name() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return string Settings stylesheet path.
 */
function exmachina_design_get_settings_stylesheet_path() {

  return apply_filters( 'exmachina_design_get_settings_stylesheet_path', exmachina_design_get_stylesheet_location( 'path' ) . exmachina_design_get_settings_stylesheet_name() );

} // end function exmachina_design_get_settings_stylesheet_path()

/**
 * Get Custom Stylesheet Path
 *
 * Gets the file path of the custom stylesheet.
 *
 * @todo shorten function name
 * @todo shorten filter name
 * @todo find where function is used
 *
 * @uses exmachina_design_get_stylesheet_location() [description]
 * @uses exmachina_design_get_custom_stylesheet_name() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return string Custom stylesheet path.
 */
function exmachina_design_get_custom_stylesheet_path() {

  return apply_filters( 'exmachina_design_get_custom_stylesheet_path', exmachina_design_get_stylesheet_location( 'path' ) . exmachina_design_get_custom_stylesheet_name() );

} // end function exmachina_design_get_custom_stylesheet_path()

/**
 * Get Minified Stylesheet Path
 *
 * Gets the URL reference to the minified CSS stylesheet.
 *
 * @todo shorten function name
 * @todo shorten filter name
 * @todo find out where function is used
 *
 * @uses exmachina_design_get_stylesheet_location() [description]
 * @uses exmachina_design_get_minified_stylesheet_name() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return string Minified stylesheet URL.
 */
function exmachina_design_get_minified_stylesheet_url() {

  return apply_filters( 'exmachina_design_get_minified_stylesheet_url', exmachina_design_get_stylesheet_location( 'url' ) . exmachina_design_get_minified_stylesheet_name() );

} // end function exmachina_design_get_minified_stylesheet_url()

/**
 * Get Settings Stylesheet Path
 *
 * Gets the URL reference to the settings CSS stylesheet.
 *
 * @todo shorten function name
 * @todo shorten filter name
 * @todo find out where function is used
 *
 * @uses exmachina_design_get_stylesheet_location() [description]
 * @uses exmachina_design_get_settings_stylesheet_name() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return string Settings stylesheet URL.
 */
function exmachina_design_get_settings_stylesheet_url() {

  return apply_filters( 'exmachina_design_get_settings_stylesheet_url', exmachina_design_get_stylesheet_location( 'url' ) . exmachina_design_get_settings_stylesheet_name() );

} // end function exmachina_design_get_settings_stylesheet_url()

/**
 * Get Custom Stylesheet Path
 *
 * Gets the URL reference to the custom CSS stylesheet.
 *
 * @todo shorten function name
 * @todo shorten filter name
 * @todo find out where function is used
 *
 * @uses exmachina_design_get_stylesheet_location() [description]
 * @uses exmachina_design_get_custom_stylesheet_name() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return string Custom stylesheet URL.
 */
function exmachina_design_get_custom_stylesheet_url() {

  return apply_filters( 'exmachina_design_get_custom_stylesheet_url', exmachina_design_get_stylesheet_location( 'url' ) . exmachina_design_get_custom_stylesheet_name() );

} // end function exmachina_design_get_custom_stylesheet_url()

/**
 * Is Custom Stylesheet Used
 *
 * Checks if custom stylesheet for this site has any content. Returns true if
 * stylesheet has content, false if empty or doesn't exist.
 *
 * @todo shorten function name
 *
 * @uses exmachina_design_get_custom_stylesheet_path() [description]
 *
 * @since 0.5.0
 * @access private
 *
 * @return boolean True if stylesheet has content, false otherwise.
 */
function exmachina_design_is_custom_stylesheet_used() {

  /* If the custom stylesheet exists. */
  if ( file_exists( exmachina_design_get_custom_stylesheet_path() ) ) {

    /* Get the stylesheet file contents. */
    $css = file_get_contents( exmachina_design_get_custom_stylesheet_path() );

    /* If stylesheet contents are greater than 1 character. */
    if ( strlen($css) > 1 ) {
      // 1, not 0, as to create custom stylsheet, we have enter at least 1
      // (space) character, else get a PHP Notice if WP_DEBUG is true.
      return true;
    } // end if ( strlen($css) > 1 )

  } // if (file_exists(exmachina_design_get_custom_stylesheet_path()))

  /* Otherwise, return false. */
  return false;
} // end function exmachina_design_is_custom_stylesheet_used()

/**
 * Custom Stylesheet Theme Editor Querystring
 *
 * Get the custom stylesheet querystring for the theme editor link.
 *
 * @todo shorten function name
 * @todo use variables to shorten function (half done)
 * @todo see where function is used
 *
 * @link http://codex.wordpress.org/Editing_Files
 * @link http://codex.wordpress.org/Function_Reference/get_current_theme
 *
 * @uses exmachina_design_get_custom_stylesheet_path() [description]
 * @uses exmachina_design_get_stylesheet_location() [description]
 *
 * @since 0.5.0
 * @access private
 *
 * @global string $theme  Current theme name.
 * @return string         Theme editor query string.
 */
function exmachina_design_get_custom_stylesheet_editor_querystring() {
  global $theme;

  $path = exmachina_design_get_custom_stylesheet_path();
  $location = exmachina_design_get_stylesheet_location( 'path' );

  /* If $theme is empty, get the current theme. */
  if ( empty( $theme ) )
    $theme = get_current_theme();

  return 'file=' . _get_template_edit_filename( exmachina_design_get_custom_stylesheet_path(), dirname( exmachina_design_get_stylesheet_location( 'path' ) ) ) . '&amp;theme=' . urlencode( $theme ) . '&amp;dir=style';

} // end function exmachina_design_get_custom_stylesheet_editor_querystring()

/**
 * Enqueues Custom Stylesheets
 *
 * Conditionally enqueues custom stylesheets for use within WordPress.
 *
 * @todo shorten function name
 * @todo change stylesheet names
 * @todo replace child theme name condition
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * @link http://codex.wordpress.org/Function_Reference/sanitize_title_with_dashes
 * @link http://codex.wordpress.org/Function_Reference/wp_dequeue_style
 *
 * @uses exmachina_design_css_is_minified() [description]
 * @uses exmachina_design_get_settings_stylesheet_path() [description]
 * @uses exmachina_design_get_settings_stylesheet_url() [description]
 * @uses exmachina_design_is_custom_stylesheet_used() [description]
 * @uses exmachina_design_css_is_minified() [description]
 * @uses exmachina_design_get_minified_stylesheet_path() [description]
 * @uses exmachina_design_get_minified_stylesheet_url() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_design_add_stylesheets() {

  /* If debugging (not minified), then add settings stylesheet and custom stylesheet (leaving style.css in place). */
  if ( ! exmachina_design_css_is_minified() && file_exists( exmachina_design_get_settings_stylesheet_path() ) ) {

    /* Enqueues the settings stylesheet. */
    wp_enqueue_style( 'exmachina_design_settings_stylesheet', exmachina_design_get_settings_stylesheet_url(), false, filemtime( exmachina_design_get_settings_stylesheet_path() ) );

    /* If custom stylesheet is used. */
    if ( exmachina_design_is_custom_stylesheet_used() ) {

      /* Enqueue the custom stylesheet. */
      wp_enqueue_style( 'exmachina_design_custom_stylesheet', exmachina_design_get_custom_stylesheet_url(), false, filemtime( exmachina_design_get_custom_stylesheet_path() ) );
    } // end IF statement

  } // end IF statement

  /* Otherwise, if minified, then add reference to minified stylesheet, and remove style.css reference. */
  elseif ( exmachina_design_css_is_minified() && file_exists( exmachina_design_get_minified_stylesheet_path() ) ) {

    /* Sets the child theme name if defined */
    $handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

    /* Dequeue the stylesheet. */
    wp_dequeue_style( $handle );

    /* Enqueue the minified stylesheet. */
    wp_enqueue_style( 'exmachina_design_minified_stylesheet', exmachina_design_get_minified_stylesheet_url(), false, filemtime( exmachina_design_get_minified_stylesheet_path() ) );

  } // end IF statement

} // end function exmachina_design_add_stylesheets()

/**
 * Prepare Settings Stylesheet
 *
 * Loops through the mapping to prepare CSS output.
 *
 * @todo find where function is used
 * @todo cleanup function code
 *
 * @uses exmachina_get_admin_design_mapping() [description]
 * @uses exmachina_get_fresh_design_option() [description]
 * @uses exmachina_design_calculate_nav_width() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return string Beautified CSS
 */
function exmachina_design_prepare_settings_stylesheet() {

  $mapping = exmachina_get_admin_design_mapping();

  $output = '';
  foreach ( $mapping as $selector => $declaration ) {
    if ( 'custom_css' != $selector && 'minify_css' != $selector) {
      $output .= $selector . ' {'."\n";
      foreach ( $declaration as $property => $value ) {
        if ( strpos( $property, '_select' ) ) {
           if ( exmachina_get_fresh_design_option( $value ) == 'hex' ) {
            continue;
           } else {
            $property = substr( $property, 0, strlen( $property )-7 );
           }
        }

        $output .= "\t" . $property . ':';

        if ( is_array( $value ) ) {
          foreach ( $value as $composite_value ) {
            $output .= ' ';
            $val = $composite_value[0];
            $type = $composite_value[1];
            if ( 'fixed_string' == $type ) {
              $output .= $val;
            } elseif ( 'string' == $type ) {
              $output .=  exmachina_get_fresh_design_option( $val );
            } else {
              $cache_val = exmachina_get_fresh_design_option( $val );
              $output .= $cache_val;
              $output .= ( (int) $cache_val > 0 ) ? $type : null;
            }
          }
        } elseif ( '#nav_width_calc' == $value ) {
          $output .= exmachina_design_calculate_nav_width( 'primary' );
        } elseif ( '#nav_ul_width_calc' == $value) {
          $output .= exmachina_design_calculate_nav_width( 'primary', true );
        } elseif ( '#subnav_width_calc' == $value) {
          $output .= exmachina_design_calculate_nav_width( 'secondary' );
        } elseif ( '#subnav_ul_width_calc' == $value) {
          $output .= exmachina_design_calculate_nav_width( 'secondary', true );
        } else {
          $output .= ' ' . exmachina_get_fresh_design_option( $value );
        }
        $output .= ';' . "\n";
        }
        $output .= '}' . "\n";

    } elseif ( 'custom_css' == $selector ) {
      $output .= exmachina_get_fresh_design_option( $declaration );
    }
  }
  return apply_filters( 'exmachina_design_prepare_stylesheet', $output );
} // end function exmachina_design_prepare_settings_stylesheet()

/**
 * Calculate Nav Width
 *
 * Calculates the width of the primary or secondary nav elements, or the child
 * UL elements, based on the border settings choices.
 *
 * @todo shorten function name
 * @todo cleanup function
 * @todo add docblock params
 *
 * @uses exmachina_get_fresh_design_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string  $nav [description]
 * @param  boolean $ul  [description]
 * @return string       Navigation width.
 */
function exmachina_design_calculate_nav_width( $nav, $ul = false ) {

  $border = exmachina_get_fresh_design_option( $nav . '_nav_border' );
  $border_style = exmachina_get_fresh_design_option( $nav . '_nav_border_style' );

  if ( 'none' == $border_style )
    $border = 0;
    $width = 940 - 2 * $border;

  if ( $ul ) {
    $border = exmachina_get_fresh_design_option( $nav . '_nav_inner_border' );
    $border_style = exmachina_get_fresh_design_option( $nav . '_nav_inner_border_style' );

    if ( 'none' == $border_style )
        $border = 0;

    $width = $width - 2 * $border;
  }

  return ' ' . $width .'px';
} // end function exmachina_design_calculate_nav_width()

/**
 * Make Stylesheet Path Writiable
 *
 * Try and make stylesheet directory writable. May not work if safe-mode or
 * other server configurations are enabled.
 *
 * @todo shorten function name
 * @todo inline comment function
 * @todo find where function is used
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_mkdir_p
 *
 * @uses exmachina_design_get_stylesheet_location() [description]
 *
 * @since 0.5.0
 * @access private
 *
 * @return boolean True if writable, false if not.
 */
function exmachina_design_make_stylesheet_path_writable() {

  $stylesheet_path = exmachina_design_get_stylesheet_location( 'path' );

  if ( ! is_dir( $stylesheet_path ) )
    wp_mkdir_p( $stylesheet_path );

  if ( ! is_writable( $stylesheet_path ) )
    @chmod( $stylesheet_path, 0777 );

  if ( ! is_writable( $stylesheet_path ) )
    return false;

  return true;
} // end function exmachina_design_make_stylesheet_path_writable()

/**
 * Create Settings Stylesheet
 *
 * Uses the mapping output to write the beautified CSS to a file.
 *
 * @todo shorten function name
 * @todo inline comment function code
 *
 * @uses exmachina_design_make_stylesheet_path_writable() [description]
 * @uses exmachina_design_prepare_settings_stylesheet() [description]
 * @uses exmachina_design_get_settings_stylesheet_path() [description]
 *
 * @since 0.5.0
 * @access private
 *
 * @return void
 */
function exmachina_design_create_settings_stylesheet() {

  exmachina_design_make_stylesheet_path_writable();

  $css = '/* ' . __( 'This file is auto-generated from the settings page. Any direct edits here will be lost if the settings page is saved', 'exmachina' ) . ' */'."\n";
  $css .= exmachina_design_prepare_settings_stylesheet();
  $handle = @fopen( exmachina_design_get_settings_stylesheet_path(), 'w' );
  @fwrite( $handle, $css );
  @fclose( $handle );

} // end function exmachina_design_create_settings_stylesheet()

/**
 * Create Custom Stylesheet
 *
 * Tries to create the custom stylesheet in the right place.
 *
 * @todo move $css variable out
 * @todo inline comment code
 * @todo find out where function is used
 *
 * @uses exmachina_design_make_stylesheet_path_writable() [description]
 * @uses exmachina_design_get_custom_stylesheet_path() [description]
 *
 * @since 0.5.0
 * @access private
 *
 * @param  string $css Optional. String to populate custom stylesheet.
 * @return void
 */
function exmachina_design_create_custom_stylesheet( $css = "/** Do not remove this line. Edit CSS below. */\n" ) {

  exmachina_design_make_stylesheet_path_writable();

  if ( ! file_exists( exmachina_design_get_custom_stylesheet_path() ) ) {
    $handle = @fopen( exmachina_design_get_custom_stylesheet_path(), 'w+' );
    @fwrite( $handle, $css );
    @fclose( $handle );
    @chmod( exmachina_design_get_custom_stylesheet_path(), 0666 );
  }
} // end function exmachina_design_create_custom_stylesheet()

add_action( 'update_option_' . EXMACHINA_DESIGN_SETTINGS_FIELD, 'exmachina_design_create_stylesheets' );
/**
 * Create Stylesheets
 *
 * Merges style.css, settings stylesheet and custom.css, then minifies it into
 * one minified.css file. Also creates individual beautified settings stylesheet
 * so they are in sync, and attempts to create custom stylesheet if it doesn't
 * exist.
 *
 * @todo shorten function name
 * @todo add inline comments to functions
 *
 * @uses exmachina_design_make_stylesheet_path_writable() [description]
 * @uses exmachina_design_prepare_settings_stylesheet() [description]
 * @uses exmachina_design_is_custom_stylesheet_used() [description]
 * @uses exmachina_design_get_custom_stylesheet_path() [description]
 * @uses exmachina_design_minify_css() [description]
 * @uses exmachina_design_get_minified_stylesheet_path() [description]
 * @uses exmachina_design_create_settings_stylesheet() [description]
 * @uses exmachina_design_create_custom_stylesheet() [description]
 *
 * @since 0.5.0
 * @access private
 *
 * @return void
 */
function exmachina_design_create_stylesheets() {

  exmachina_design_make_stylesheet_path_writable();

  $css_prefix = '/* ' . __( 'This file is auto-generated from the style.css, the settings page and custom.css. Any direct edits here will be lost if the settings page is saved', 'exmachina' ) .' */'."\n";
  $css = file_get_contents( CHILD_THEME_DIR . '/style.css' );
  $css .= exmachina_design_prepare_settings_stylesheet();
//    if ( file_exists(exmachina_design_get_custom_stylesheet_path() ) ) {
  if ( exmachina_design_is_custom_stylesheet_used() ) {
      $css .= file_get_contents( exmachina_design_get_custom_stylesheet_path() );
  }

  $css = $css_prefix . exmachina_design_minify_css( $css );

  $handle = @fopen( exmachina_design_get_minified_stylesheet_path(), 'w' );
  @fwrite( $handle, $css );
  @fclose( $handle );

  exmachina_design_create_settings_stylesheet();
  exmachina_design_create_custom_stylesheet();
} // end function exmachina_design_create_stylesheets()

add_action( 'admin_init', 'exmachina_design_do_create_stylesheets' );
/**
 * Create All Styelsheets
 *
 * Attempts to create all atylesheets when the theme is activated.
 *
 * @todo shorten function name
 * @todo inline comment function
 *
 * @link http://codex.wordpress.org/Global_Variables
 * @link http://codex.wordpress.org/Function_Reference/is_admin
 *
 * @uses exmachina_design_get_custom_stylesheet_name() [description]
 * @uses exmachina_design_create_stylesheets() [description]
 *
 * @since 0.5.0
 * @access private
 *
 * @global string $pagenow Current page string.
 * @return void
 */
function exmachina_design_do_create_stylesheets() {
  global $pagenow;
  if ( is_admin() && (
    // Theme activation
    ( isset( $_GET['activated'] ) && $pagenow == "themes.php" ) ||
    // When custom stylesheet is updated via Theme Editor
    ( isset( $_GET['a'] ) && $pagenow == "theme-editor.php" && isset( $_GET['file'] ) && strstr( $_GET['file'], exmachina_design_get_custom_stylesheet_name() ) )
  ) ) {
    exmachina_design_create_stylesheets();
  }

} // end function exmachina_design_do_create_stylesheets()

/**
 * Minify CSS
 *
 * A quick and dirty way to mostly minify CSS.
 *
 * @todo shorten function name
 * @todo inline comment function
 *
 * @since 0.5.0
 * @access private
 *
 * @param  string $css CSS string to minify.
 * @return string      Minified CSS string.
 */
function exmachina_design_minify_css( $css ) {

  // Normalize whitespace
  $css = preg_replace( '/\s+/', ' ', $css);
  // Remove comment blocks, everything between /* and */, unless
  // preserved with /*! ... */
  $css = preg_replace( '/\/\*[^\!](.*?)\*\//', '', $css);
  // Remove space after , : ; { }
  $css = preg_replace( '/(,|:|;|\{|}) /', '$1', $css);
  // Remove space before , ; { }
  $css = preg_replace( '/ (,|;|\{|})/', '$1', $css);
  // Strips leading 0 on decimal values (converts 0.5px into .5px)
  $css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css);
  // Strips units if value is 0 (converts 0px to 0)
  $css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css);
  // Converts all zeros value into short-hand
  $css = preg_replace( '/0 0 0 0/', '0', $css);
  // Ensures image path is correct, if we're serving .css file from subfolder
  $css = preg_replace( '/url\(([\'"]?)images\//', 'url(${1}' . CHILD_URL . '/images/', $css);

  return apply_filters( 'exmachina_design_minify_css', $css );

} // end function exmachina_design_minify_css()
