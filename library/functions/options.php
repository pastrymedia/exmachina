<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Options Functions
 *
 * options.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
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

/**
 * Get Option
 *
 * Returns an option from the options table and caches the result. Applies the
 * 'exmachina_pre_get_option_$key' filter to allow child themes to short-circuit
 * the function and 'exmachina_options' filter to override a specific option.
 *
 * Values pulled from the database are cached on each request, so a second request
 * for the same value won't cause a second DB interaction.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/stripslashes_deep
 * @link http://codex.wordpress.org/Function_Reference/wp_kses_decode_entities
 *
 * @since 1.0.0
 *
 * @param  string  $key       The option name.
 * @param  string  $setting   Optional. The settings field name.
 * @param  boolean $use_cache Optional. Whether to use the cache value.
 * @return mixed              The value of $key in the database.
 */
function exmachina_get_option( $key, $setting = null, $use_cache = true ) {


  /* Defines the default settings field so it doesn't need to be repeated. */
  $setting = $setting ? $setting : EXMACHINA_SETTINGS_FIELD;

  /* Bypasses the cache if needed. */
  if ( ! $use_cache ) {
    $options = get_option( $setting );

    if ( ! is_array( $options ) || ! array_key_exists( $key, $options ) )
      return '';

    return is_array( $options[$key] ) ? stripslashes_deep( $options[$key] ) : stripslashes( wp_kses_decode_entities( $options[$key] ) );
  } // end if (!$use_cache)

  /* Setup the caches. */
  static $settings_cache = array();
  static $options_cache  = array();

  /* Allow child themes to short-circuit this function. */
  $pre = apply_filters( 'exmachina_pre_get_option_' . $key, null, $setting );
  if ( null !== $pre )
    return $pre;

  /* Check the options cache. */
  if ( isset( $options_cache[$setting][$key] ) )
    /* Option has been cached. */
    return $options_cache[$setting][$key];

  /* Check the settings cache. */
  if ( isset( $settings_cache[$setting] ) )
    /* Setting has been cached. */
    $options = apply_filters( 'exmachina_options', $settings_cache[$setting], $setting );
  else
    /* Set value and cache setting. */
    $options = $settings_cache[$setting] = apply_filters( 'exmachina_options', get_option( $setting ), $setting );

  /* Check for non-existent option. */
  if ( ! is_array( $options ) || ! array_key_exists( $key, (array) $options ) )
    /* Cache non-existent option. */
    $options_cache[$setting][$key] = '';
  else
    /* Option has not been previously been cached, so cache now. */
    $options_cache[$setting][$key] = is_array( $options[$key] ) ? stripslashes_deep( $options[$key] ) : stripslashes( wp_kses_decode_entities( $options[$key] ) );

  /* Return the $options_cache. */
  return $options_cache[$setting][$key];

} // end function exmachina_get_option()

/**
 * Echo Option
 *
 * Echoes out options from the options table.
 *
 * @uses exmachina_get_option() Returns option from the database and cache result.
 *
 * @since 1.0.0
 *
 * @param  string  $key       The option name.
 * @param  string  $setting   Optional. The settings field name.
 * @param  boolean $use_cache Optional. Whether to use the cache value.
 */
function exmachina_option( $key, $setting = null, $use_cache = true ) {

  /* Echo out the option value from exmachina_get_option(). */
  echo exmachina_get_option( $key, $setting, $use_cache );

} // end function exmachina_option()