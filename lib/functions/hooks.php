<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Hooks Functions
 *
 * hooks.php
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

add_action( 'init', 'exmachina_execute_hooks', 20 );

/**
 * Execute Hooks
 *
 * Loops through all the hooks and attempts to execute code in the proper
 * location.
 *
 * @uses exmachina_get_hook_option() [description]
 * @uses exmachina_execute_hook() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_execute_hooks() {

  /* Get the hook settings from the hook settings field. */
  $hooks = get_option( EXMACHINA_HOOK_SETTINGS_FIELD );

  foreach ( (array) $hooks as $hook => $array ) {

    /* Add new content to hook. */
    if ( exmachina_get_hook_option( $hook, 'content' ) ) {

      /* Adds the execute hook function. */
      add_action( $hook, 'exmachina_execute_hook' );

    } // end IF statemnt

    /* Remove content from hooks. */
    if ( isset( $array['unhook'] ) ) {

      foreach( (array) $array['unhook'] as $function ) {

        /* Removes the action. */
        remove_action( $hook, $function );

      } // end foreach statement
    } // end IF statement

  } // end foreach statement
} // end function exmachina_execute_hooks()

/**
 * Execute Hook
 *
 * Executes any code meant to be hooked. It checks if shortcodes or PHP should
 * be executed as well.
 *
 * @todo compare against hybrid hooks
 * @todo compare against startbox hooks
 *
 * @link http://codex.wordpress.org/Function_Reference/current_filter
 * @link http://codex.wordpress.org/Function_Reference/do_shortcode
 *
 * @uses exmachina_get_hook_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Returns early if hook of content is not defined.
 */
function exmachina_execute_hook() {

  /* Define the hook and content variables. */
  $hook = current_filter();
  $content = exmachina_get_hook_option( $hook, 'content' );

  /* Return early if hook or content not set. */
  if( ! $hook || ! $content )
    return;

  /* Define if shortcodes or PHP are required. */
  $shortcodes = exmachina_get_hook_option( $hook, 'shortcodes' );
  $php = exmachina_get_hook_option( $hook, 'php' );

  /* Do shortcodes if required. */
  $value = $shortcodes ? do_shortcode( $content ) : $content;

  /* Execute PHP if required. */
  if ( $php )
    eval( "?>$value<?php " );
  else
    echo $value;

} // end function exmachina_execute_hook()

/**
 * Get Hook Option
 *
 * Pull a hook option from the database and return a value.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/wp_kses_stripslashes
 * @link http://codex.wordpress.org/Function_Reference/wp_kses_decode_entities
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string  $hook  Hook name.
 * @param  string  $field Hook field value.
 * @param  boolean $all   Return all the options.
 * @return string         Hook value.
 */
function exmachina_get_hook_option( $hook = null, $field = null, $all = false ) {

  /* Set a static array. */
  static $options = array();

  /* Get options from the hook settings field. */
  $options = $options ? $options : get_option( EXMACHINA_HOOK_SETTINGS_FIELD );

  /* If $all is true, return all the options. */
  if ( $all )
    return $options;

  /* If the hook doesn't exist, return empty. */
  if ( ! array_key_exists( $hook, (array) $options ) )
        return '';

  /* If hook field is empty, return empty. */
  $option = isset( $options[$hook][$field] ) ? $options[$hook][$field] : '';

  /* Sanitize and return. */
  return wp_kses_stripslashes( wp_kses_decode_entities( $option ) );

} // end function exmachina_get_hook_option()

/**
 * Hook Option
 *
 * Echos a hook option from the database.
 *
 * @uses exmachina_get_hook_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  string $hook  Hook name.
 * @param  string $field Hook field value.
 * @return string        Hook value.
 */
function exmachina_hook_option( $hook = null, $field = null ) {

  echo exmachina_get_hook_option( $hook, $field );

} // end function exmachina_hook_option()

/**
 * Generate Hooks Form
 *
 * Generates the HTML code used by the metaboxes on the Hook Settings menu
 * pages.
 *
 * @todo compare against hybrid hooks
 * @todo compare against startbox hooks
 *
 * @uses exmachina_get_hook_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $args Hook function arguments.
 * @return void
 */
function exmachina_hooks_form_generate( $args = array() ) {
  ?>

  <h4><code><?php echo $args['hook']; ?></code> <?php _e( 'Hook', 'exmachina' ); ?></h4>
  <p><span class="description"><?php echo $args['desc']; ?></span></p>

  <?php
    if ( isset( $args['unhook'] ) ) {
      foreach ( (array) $args['unhook'] as $function ) {
  ?>
      <input type="checkbox" name="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]" id="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]" value="<?php echo $function; ?>" <?php if ( in_array( $function, (array) exmachina_get_hook_option( $args['hook'], 'unhook' ) ) ) echo 'checked'; ?> /> <label for="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]"><?php printf( __( 'Unhook <code>%s()</code> function from this hook?', 'exmachina' ), $function ); ?></label><br />
  <?php
      } // end foreach
    } // end IF statement
  ?>

  <p><textarea name="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][content]" cols="70" rows="5"><?php echo htmlentities( exmachina_get_hook_option( $args['hook'], 'content' ), ENT_QUOTES, 'UTF-8' ); ?></textarea></p>

  <p>
    <input type="checkbox" name="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]" id="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]" value="1" <?php checked( 1, exmachina_get_hook_option( $args['hook'], 'shortcodes' ) ); ?> /> <label for="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]"><?php _e( 'Execute Shortcodes on this hook?', 'exmachina' ); ?></label><br />
    <input type="checkbox" name="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]" id="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]" value="1" <?php checked( 1, exmachina_get_hook_option( $args['hook'], 'php' ) ); ?> /> <label for="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]"><?php _e( 'Execute PHP on this hook?', 'exmachina' ); ?></label>
  </p>

  <hr class="div" />

  <?php
} // end function exmachina_hooks_form_generate()
