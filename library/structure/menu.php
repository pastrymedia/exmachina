<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Menu
 *
 * menu.php
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


 /* Load the primary menu. */
add_action( exmachina_get_prefix() . '_before_header', 'exmachina_get_primary_menu' );

 /* Load the secondary menu. */
add_action( exmachina_get_prefix() . '_after_header', 'exmachina_get_secondary_menu' );

 /* Load the subsibiary menu. */
add_action( exmachina_get_prefix() . '_before_footer', 'exmachina_get_subsidiary_menu' );

/**
 * Loads the menu-primary.php template.
 */
function exmachina_get_primary_menu() {

  //* If menu is assigned to theme location, output
  if ( has_nav_menu( 'primary' ) ) {

  get_template_part( 'partials/menu', 'primary' );

  }
}

/**
 * Loads the menu-secondary.php template.
 */
function exmachina_get_secondary_menu() {

  //* If menu is assigned to theme location, output
  if ( has_nav_menu( 'secondary' ) ) {

  get_template_part( 'partials/menu', 'secondary' );

  }
}

/**
 * Loads the menu-subsidiary.php template.
 */
function exmachina_get_subsidiary_menu() {

  //* If menu is assigned to theme location, output
  if ( has_nav_menu( 'subsidiary' ) ) {

  get_template_part( 'partials/menu', 'subsidiary' );

  }
}