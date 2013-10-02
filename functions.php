<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * <[TEMPLATE NAME]> WordPress Theme
 * Main Theme Functions
 *
 * @todo create init function
 * @todo create setup function
 * @todo remove create_custom_php dependency
 *
 * functions.php
 * @link http://codex.wordpress.org/Functions_File_Explained
 *
 * The functions file is used to initialize everything in the theme. It controls
 * how the theme is loaded and sets up the supported features, default actions,
 * and default filters. If making customizations, users should create a child
 * theme and make changes to its functions.php file (not this one).
 *
 * @package     <[TEMPLATE NAME]>
 * @subpackage  Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright(c) 2012-2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com/<[theme-name]>
 */
###############################################################################
# begin functions
###############################################################################

require_once( dirname( __FILE__ ) . '/lib/init.php' );

exmachina_design_create_custom_php();
add_theme_support( 'exmachina-custom-header', array( 'width' => exmachina_get_option( 'header_image_width', EXMACHINA_DESIGN_SETTINGS_FIELD ), 'height' => exmachina_get_option( 'header_image_height', EXMACHINA_DESIGN_SETTINGS_FIELD ) ) );