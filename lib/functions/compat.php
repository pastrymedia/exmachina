<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Compatibility Functions
 *
 * compat.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * @todo research functions
 * @todo docblock comments
 * @todo move to different file
 *
 * <[DESCRIPTION GOES HERE]>
 * These functions are intended to provide simple compatibilty for those that
 * don't have the mbstring extension enabled. WordPress already provides a
 * proper working definition for mb_substr().
 *
 * @package     ExMachina
 * @subpackage  Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

if ( ! function_exists( 'mb_strpos' ) ) {
  /**
   * [mb_strpos description]
   * @param  [type]  $haystack [description]
   * @param  [type]  $needle   [description]
   * @param  integer $offset   [description]
   * @param  string  $encoding [description]
   * @return [type]            [description]
   */
  function mb_strpos( $haystack, $needle, $offset = 0, $encoding = '' ) {
    return strpos( $haystack, $needle, $offset );
  } // end function mb_strpos()
} // end if ( !function_exists( 'mb_strpos' ))

if ( ! function_exists( 'mb_strrpos' ) ) {
  /**
   * [mb_strrpos description]
   * @param  [type]  $haystack [description]
   * @param  [type]  $needle   [description]
   * @param  integer $offset   [description]
   * @param  string  $encoding [description]
   * @return [type]            [description]
   */
  function mb_strrpos( $haystack, $needle, $offset = 0, $encoding = '' ) {
    return strrpos( $haystack, $needle, $offset );
  } // end function mb_strrpos()
} // end if ( !function_exists( 'mb_strrpos' ))

if ( ! function_exists( 'mb_strlen' ) ) {
  /**
   * [mb_strlen description]
   * @param  [type] $string   [description]
   * @param  string $encoding [description]
   * @return [type]           [description]
   */
  function mb_strlen( $string, $encoding = '' ) {
    return strlen( $string );
  } // end function mb_strlen()
} // end if ( !function_exists( 'mb_strlen' ))

if ( ! function_exists( 'mb_strtolower' ) ) {
  /**
   * [mb_strtolower description]
   * @param  [type] $string   [description]
   * @param  string $encoding [description]
   * @return [type]           [description]
   */
  function mb_strtolower( $string, $encoding = '' ) {
    return strtolower( $string );
  } // end function mb_strtolower()
} // end if ( !function_exists( 'mb_strtolower' ))