<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Sidebar Template
 * sidebar.php
 *
 * The sidebar widget area template.
 * @link http://codex.wordpress.org/Customizing_Your_Sidebar
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */

/* Output primary sidebar structure. */
exmachina_markup( array(
  'html'   => '<aside %s>',
  'context' => 'sidebar-primary',
) );

do_action( 'exmachina_before_sidebar_widget_area' );
do_action( 'exmachina_sidebar' );
do_action( 'exmachina_after_sidebar_widget_area' );

exmachina_markup( array(
  'html' => '</aside>', //* end .sidebar-primary
) );
