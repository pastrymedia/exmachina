<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * SEO Functions
 *
 * seo.php
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
 * Disable SEO
 *
 * Disable the ExMachina SEO features.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 *
 * @see exmachina_default_title()
 * @see exmachina_doc_head_control()
 * @see exmachina_seo_meta_description()
 * @see exmachina_seo_meta_keywords()
 * @see exmachina_robots_meta()
 * @see exmachina_canonical()
 * @see exmachina_add_inpost_seo_box()
 * @see exmachina_add_inpost_seo_save()
 * @see exmachina_add_taxonomy_seo_options()
 * @see exmachina_user_seo_fields()
 *
 * @uses EXMACHINA_SEO_SETTINGS_FIELD
 */
function exmachina_disable_seo() {

  remove_filter( 'wp_title', 'exmachina_default_title', 10, 3 );
  remove_action( 'get_header', 'exmachina_doc_head_control' );
  remove_action( 'exmachina_meta','exmachina_seo_meta_description' );
  remove_action( 'exmachina_meta','exmachina_seo_meta_keywords' );
  remove_action( 'exmachina_meta','exmachina_robots_meta' );
  remove_action( 'wp_head','exmachina_canonical', 5 );
  remove_action( 'wp_head', 'exmachina_rel_author' );

  remove_action( 'admin_menu', 'exmachina_add_inpost_seo_box' );
  remove_action( 'save_post', 'exmachina_inpost_seo_save', 1, 2 );

  remove_action( 'admin_init', 'exmachina_add_taxonomy_seo_options' );

  remove_action( 'show_user_profile', 'exmachina_user_seo_fields' );
  remove_action( 'edit_user_profile', 'exmachina_user_seo_fields' );
  remove_filter( 'user_contactmethods', 'exmachina_user_contactmethods' );

  remove_theme_support( 'exmachina-seo-settings-menu' );
  add_filter( 'pre_option_' . EXMACHINA_SEO_SETTINGS_FIELD, '__return_empty_array' );

  define( 'EXMACHINA_SEO_DISABLED', true );

} // end function exmachina_disable_seo()

/**
 * SEO Disabled
 *
 * Detect whether or not ExMachina SEO has been disabled.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 * @access public
 *
 * @return bool True if SEO is disabled, false otherwise.
 */
function exmachina_seo_disabled() {

  if ( defined( 'EXMACHINA_SEO_DISABLED' ) && EXMACHINA_SEO_DISABLED )
    return true;

  return false;

} // end function exmachina_seo_disabled()

add_action( 'after_setup_theme', 'exmachina_seo_compatibility_check', 5 );
/**
 * SEO Compatibility Check
 *
 * Check for the existence of popular SEO plugins and disable the ExMachina SEO
 * features if one or more of the plugins is active. Runs before the menu is built,
 * so we can disable SEO Settings menu, if necessary.
 *
 * @todo inline comment
 * @todo cleanup function
 *
 * @since 0.5.0
 * @access public
 *
 * @see exmachina_default_title()
 *
 * @uses exmachina_detect_seo_plugins() Detect certain SEO plugins.
 * @uses exmachina_disable_seo()        Disable all aspects of ExMachina SEO features.
 */
function exmachina_seo_compatibility_check() {

  if ( exmachina_detect_seo_plugins() )
    exmachina_disable_seo();

  //* Disable ExMachina <title> generation if SEO Title Tag is active
  if ( function_exists( 'seo_title_tag' ) ) {
    remove_filter( 'wp_title', 'exmachina_default_title', 10, 3 );
    remove_action( 'exmachina_title', 'wp_title' );
    add_action( 'exmachina_title', 'seo_title_tag' );
  }

} // end function exmachina_seo_compatibility_check()

/**
 * Detect SEO Plugins
 *
 * Detect some SEO Plugin that add constants, classes or functions. Applies
 * `exmachina_detect_seo_plugins` filter to allow third party manpulation of
 * SEO plugin list.
 *
 * @todo inline comment
 *
 * @uses exmachina_detect_plugin() Detect active plugin by constant, class or function.
 *
 * @since 0.5.0
 * @access public
 *
 * @return boolean True if plugin exists.
 */
function exmachina_detect_seo_plugins() {

  return exmachina_detect_plugin(
    // Use this filter to adjust plugin tests.
    apply_filters(
      'exmachina_detect_seo_plugins',
      //* Add to this array to add new plugin checks.
      array(

        // Classes to detect.
        'classes' => array(
          'All_in_One_SEO_Pack',
          'All_in_One_SEO_Pack_p',
          'HeadSpace_Plugin',
          'Platinum_SEO_Pack',
          'wpSEO',
          'SEO_Ultimate',
        ),

        // Functions to detect.
        'functions' => array(),

        // Constants to detect.
        'constants' => array( 'WPSEO_VERSION', ),
      )
    )
  );

} // end function exmachina_detect_seo_plugins()