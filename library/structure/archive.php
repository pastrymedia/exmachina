<?php
/**
 * ExMachina Framework
 *
 * WARNING: This file is part of the core ExMachina Framework DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package ExMachina\Archives
 * @author  Machina Themes
 * @license GPL-2.0+
 * @link    http://machinathemes.com
 */


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