<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Comments
 *
 * commnets.php
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


// add disqus compatibility
  if (function_exists('dsq_comments_template')) {
    remove_filter( 'comments_template', 'dsq_comments_template' );
    add_filter( 'comments_template', 'dsq_comments_template', 12 ); // You can use any priority higher than '10'
  }


/* Add classes to the comments pagination. */
  add_filter( 'previous_comments_link_attributes', 'exmachina_previous_comments_link_attributes' );
  add_filter( 'next_comments_link_attributes', 'exmachina_next_comments_link_attributes' );

/**
 * Adds 'class="prev" to the previous comments link.
 *
 * @since 0.1.0
 * @access public
 * @param string $attributes The previous comments link attributes.
 * @return string
 */
function exmachina_previous_comments_link_attributes( $attributes ) {
  return $attributes . ' class="prev"';
}

/**
 * Adds 'class="next" to the next comments link.
 *
 * @since 0.1.0
 * @access public
 * @param string $attributes The next comments link attributes.
 * @return string
 */
function exmachina_next_comments_link_attributes( $attributes ) {
  return $attributes . ' class="next"';
}