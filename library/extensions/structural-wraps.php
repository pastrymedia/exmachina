<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * EXTENSION
 *
 * EXTENSIONPHP
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * DESCRIPTION
 *
 * @package     ExMachina
 * @subpackage  Extensions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin extension
###############################################################################


function exmachina_wrap_open() {
  echo '<div class="wrap">';
}

function exmachina_wrap_close() {
  echo '</div><!-- .wrap -->';
}

add_action( exmachina_get_prefix() . '_header', 'exmachina_wrap_open', 7 );
add_action( exmachina_get_prefix() . '_header', 'exmachina_wrap_close' );

add_action( exmachina_get_prefix() . '_before_main', 'exmachina_wrap_open', 7 );
add_action( exmachina_get_prefix() . '_after_main', 'exmachina_wrap_close' );

add_action( exmachina_get_prefix() . '_before_primary_menu', 'exmachina_wrap_open', 7 );
add_action( exmachina_get_prefix() . '_after_primary_menu', 'exmachina_wrap_close' );

add_action( exmachina_get_prefix() . '_footer', 'exmachina_wrap_open', 7 );
add_action( exmachina_get_prefix() . '_footer', 'exmachina_wrap_close' );

?>