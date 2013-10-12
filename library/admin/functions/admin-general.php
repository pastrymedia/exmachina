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
 * @since 1.0.0
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
