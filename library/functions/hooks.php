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
 * @uses EXMACHINA_HOOK_SETTINGS_FIELD  The hook settings field constant.
 * @uses exmachina_get_hook_option()    Gets the hook value from the db.
 * @uses exmachina_execute_hook()       Execute the hook code.
 *
 * @since 1.0.0
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
 * @link http://codex.wordpress.org/Function_Reference/current_filter
 * @link http://codex.wordpress.org/Function_Reference/do_shortcode
 *
 * @uses exmachina_get_hook_option() Gets the hook value from the db.
 *
 * @since 1.0.0
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
 * @uses EXMACHINA_HOOK_SETTINGS_FIELD The hook settings field constant.
 *
 * @since 1.0.0
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
 * @since 1.0.0
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
 * @uses EXMACHINA_HOOK_SETTINGS_FIELD  The hook settings field constant.
 * @uses exmachina_get_hook_option()    Gets the hook value from the db.
 *
 * @since 1.0.0
 * @access public
 *
 * @param  array  $args Hook function arguments.
 * @return void
 */
function exmachina_hooks_form_generate( $args = array() ) {
  ?>
  <tr>
    <td class="uk-width-1-1 postbox-fieldset no-border">
      <div class="fieldset-wrap uk-margin uk-grid">
        <!-- Begin Fieldset -->
        <fieldset class="uk-form uk-width-1-1">
          <legend><?php echo $args['hook']; ?> <?php _e( 'Hook', 'exmachina-core' ); ?></legend>
          <p class="uk-margin-top-remove"><?php echo $args['desc']; ?></p>

          <?php
            if ( isset( $args['unhook'] ) ) {
              echo '<ul class="checkbox-list vertical">';
              foreach ( (array) $args['unhook'] as $function ) {
          ?>
            <li>
              <input type="checkbox" name="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]" id="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]" value="<?php echo $function; ?>" <?php if ( in_array( $function, (array) exmachina_get_hook_option( $args['hook'], 'unhook' ) ) ) echo 'checked'; ?> />
              <label for="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]"><?php printf( __( 'Unhook <code>%s()</code> function from this hook?', 'exmachina-core' ), $function ); ?></label>
            </li>
          <?php
              } // end foreach
              echo '</ul>';
            } // end IF statement
          ?>
          <div class="uk-form-row">
            <div class="uk-form-controls">
              <!-- Begin Form Inputs -->
              <textarea name="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][content]" id="<?php echo $args['hook']; ?>" class="input-block-level vertical-resize code exmachina-code-area" cols="78" rows="8"><?php echo htmlentities( exmachina_get_hook_option( $args['hook'], 'content' ), ENT_QUOTES, 'UTF-8' ); ?></textarea>
              <link rel="stylesheet" href="<?php echo EXMACHINA_ADMIN_VENDOR . '/codemirror/css/theme/monokai.min.css'; ?>">
              <script>
                jQuery(document).ready(function($){
                    var editor_header_scripts = CodeMirror.fromTextArea(document.getElementById('<?php echo $args["hook"]; ?>'), {
                        lineNumbers: true,
                        tabmode: 'indent',
                        mode: 'htmlmixed',
                        theme: 'monokai'
                    });
                });
              </script>
              <!-- End Form Inputs -->
            </div><!-- .uk-form-controls -->
          </div><!-- .uk-form-row -->

          <p>
            <input type="checkbox" name="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]" id="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]" value="1" <?php checked( 1, exmachina_get_hook_option( $args['hook'], 'shortcodes' ) ); ?> /> <label for="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]"><?php _e( 'Execute Shortcodes on this hook?', 'exmachina-core' ); ?></label><br />
            <input type="checkbox" name="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]" id="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]" value="1" <?php checked( 1, exmachina_get_hook_option( $args['hook'], 'php' ) ); ?> /> <label for="<?php echo EXMACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]"><?php _e( 'Execute PHP on this hook?', 'exmachina-core' ); ?></label>
          </p>
        </fieldset>
        <!-- End Fieldset -->
      </div><!-- .fieldset-wrap -->
    </td><!-- .postbox-fieldset -->
  </tr>
  <?php
} // end function exmachina_hooks_form_generate()
