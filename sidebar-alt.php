<?php
/**
 * ExMachina Framework.
 *
 * WARNING: This file is part of the core ExMachina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package ExMachina\Templates
 * @author  Machina Themes
 * @license GPL-2.0+
 * @link    http://www.machinathemes.com/
 */

//* Output secondary sidebar structure
exmachina_markup( array(
	'html5'   => '<aside %s>',
	'xhtml'   => '<div id="sidebar-alt" class="sidebar widget-area">',
	'context' => 'sidebar-secondary',
) );

do_action( 'exmachina_before_sidebar_alt_widget_area' );
do_action( 'exmachina_sidebar_alt' );
do_action( 'exmachina_after_sidebar_alt_widget_area' );

exmachina_markup( array(
	'html5' => '</aside>', //* end .sidebar-secondary
	'xhtml' => '</div>', //* end #sidebar-alt
) );
