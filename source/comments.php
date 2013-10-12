<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Comments Template
 * comments.php
 *
 * @todo bring in actual markup
 *
 * Template for displaying comments
 * @link http://codex.wordpress.org/Theme_Development#Comments_.28comments.php.29
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' === basename( $_SERVER['SCRIPT_FILENAME'] ) )
  die ( 'Please do not load this page directly. Thanks!' );

if ( post_password_required() ) {
  printf( '<p class="alert">%s</p>', __( 'This post is password protected. Enter the password to view comments.', 'exmachina' ) );
  return;
}

do_action( 'exmachina_before_comments' );
do_action( 'exmachina_comments' );
do_action( 'exmachina_after_comments' );

do_action( 'exmachina_before_pings' );
do_action( 'exmachina_pings' );
do_action( 'exmachina_after_pings' );

do_action( 'exmachina_before_comment_form' );
do_action( 'exmachina_comment_form' );
do_action( 'exmachina_after_comment_form' );