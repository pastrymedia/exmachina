<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Archives
 *
 * archive.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * DESCRIPTION
 *
 * @package     ExMachina
 * @subpackage  Structure
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################


/* Filters the image/gallery post format archive galleries. */
  add_filter( exmachina_get_prefix() . '_post_format_archive_gallery_columns', 'exmachina_archive_gallery_columns' );
/**
 * Sets the number of columns to show on image and gallery post format archives pages based on the
 * layout that is currently being used.
 *
 * @since 0.1.0
 * @access public
 * @param int $columns Number of gallery columns to display.
 * @return int $columns
 */
function exmachina_archive_gallery_columns( $columns ) {

  /* Only run the code if the theme supports the 'theme-layouts' feature. */
  if ( current_theme_supports( 'theme-layouts' ) ) {

    /* Get the current theme layout. */
    $layout = theme_layouts_get_layout();

    if ( 'layout-1c' == $layout )
      $columns = 4;

    elseif ( in_array( $layout, array( 'layout-3c-l', 'layout-3c-r', 'layout-3c-c' ) ) )
      $columns = 2;
  }

  return $columns;
}