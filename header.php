<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Header Template
 * header.php
 *
 * @todo bring in actual markup
 * @todo check against structural wrap
 * @todo replace html5 tag with just html
 *
 * Template file used to display the theme header
 * @link http://codex.wordpress.org/Designing_Headers
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */

do_action( 'exmachina_doctype' );
do_action( 'exmachina_title' );
do_action( 'exmachina_meta' );

wp_head(); //* we need this for plugins
?>
</head>
<?php
exmachina_markup( array(
  'html'   => '<body %s>',
  'context' => 'body',
) );
do_action( 'exmachina_before' );

exmachina_markup( array(
  'html'   => '<div %s>',
  'context' => 'site-container',
) );

do_action( 'exmachina_before_header' );
do_action( 'exmachina_header' );
do_action( 'exmachina_after_header' );

exmachina_markup( array(
  'html'   => '<div %s>',
  'context' => 'site-inner',
) );
exmachina_structural_wrap( 'site-inner' );