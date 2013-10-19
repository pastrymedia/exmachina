<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Footer
 *
 * footer.php
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

add_action( 'wp_footer', 'exmachina_custom_footer_scripts' );

/**
 * Echo the footer scripts, defined in Theme Settings.
 */
function exmachina_custom_footer_scripts() {

  echo exmachina_get_setting( 'footer_scripts' );

}


/* footer insert to the footer. */
add_action( exmachina_get_prefix() . '_footer', 'exmachina_footer_insert' );

function exmachina_footer_insert() {
  ?>
    <div class="footer-content footer-insert">
      <?php exmachina_footer_content(); ?>
    </div>
  <?php
}