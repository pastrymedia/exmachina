<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * <FUCTION NAME>
 *
 * <FILENAME.PHP>
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <DESCRIPTION GOES HERE>
 *
 * @package     ExMachina
 * @subpackage  Admin Options
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/**
 * Metabox Template Class
 *
 * <Metabox Template Class Description Goes Here>
 *
 * @since 0.4.6
 */
class ExMachina_Theme_Help_Metabox extends ExMachina_Admin_Theme_Settings {

  /**
   * Metabox Constructor
   *
   * Constructor method. Defines the metabox arguments and triggers the init()
   * method.
   *
   * @since 0.2.0
   */
  function __construct() {

    /* Set the page id & settings field. */
    $this->page_id = 'theme-settings';
    $this->settings_field = EXMACHINA_SETTINGS_FIELD;

    /* Define the metabox_ops to build the metabox and the help content. */
    $this->metabox_ops = array(
      'id' => 'exmachina-core-theme-settings-help',
      'title' => __( 'Need Help', 'exmachina-core' ),
      'icon' => 'question-sign',
      'context' => 'side',
      'priority' => 'default',
    );

    /* Define the settings defaults. */
    $this->defaults = array();

    /* Define the sanitization filters. */
    $this->sanitize = array(
      'one_zero'   => array(),
      'absint'   => array(),
      'url'   => array(),
      'no_html'   => array(),
      'safe_html' => array(),
      'requires_unfiltered_html'   => array(),
    );

    /* Define the help content. */
    $this->help_content =
    '<h3>' . __( 'My Theme Settings', 'exmachina' ) . '</h3>' .
    '<p>'  . __( 'Help content goes here.' ) . '</p>';

    /* Trigger the action hooks. */
    $this->init();

  } // end function __construct()

  /**
   * Init Actions
   *
   * Triggers the required metabox actions and filters. This method sets the
   * options defaults, runs the sanitization filters, generates the help tab
   * content, and registers the metabox.
   *
   * @since 0.4.6
   */
  function init() {

    /* Define the action hook based on the page hook. */
    $this->action_hook = str_replace('-', '_', $this->page_id);

    /* Add the settings defaults. */
    add_filter( 'exmachina_' . $this->action_hook . '_defaults', array( $this, 'setting_defaults' ) );

    /* Trigger the settings sanitizer. */
    add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitization' ) );

    /* Add contextual help to the 'exmachina_theme_settings_help' hook. */
    add_action( 'exmachina_' . $this->action_hook . '_help', array( $this, 'help_tabs' ) );

    /* Create the demo meta box on the 'exmachina_theme_settings_metaboxes' hook. */
    add_action( 'exmachina_' . $this->action_hook . '_metaboxes', array( $this, 'register_metabox' ) );

  } // end function init()

  /**
   * Help Tab Content
   *
   * Generates the help tab content via the exmachina_$actionhook_help hook.
   *
   * @since 0.4.6
   */
  function help_tabs() {

    /* Get the current screen. */
    $screen = get_current_screen();

    /* Set the help tab. */
    $screen->add_help_tab( array(
      'id'      => $this->metabox_ops['id'] . '-help',
      'title'   => $this->metabox_ops['title'],
      'content' => $this->help_content,
    ) );

  } // end function help_tabs()

  /**
   * Defaults Filter
   *
   * Applies the settings defaults to the default settings filter.
   *
   * @since 0.4.6
   *
   * @param  array $defaults Settings defaults array.
   * @return array           Settings defaults array.
   */
  function setting_defaults( $defaults ) {

    /* Get the defaults array. */
    $defaults = $this->defaults;

    /* Return the defaults. */
    return $defaults;

  } // end function setting_defaults()

  /**
   * Sanitization Filter
   *
   * Loops through the settings values and applies the appropiate sanitiation
   * filter.
   *
   * @uses exmachina_add_option_filter() Adds filter to settings option.
   *
   * @since 0.4.6
   */
  function sanitization() {

    /* Cycles through sanitize array and applies the filter. */
    foreach( $this->sanitize as $key => $values )
      exmachina_add_option_filter( $key, $this->settings_field, $values );

  } // end function sanitization()

  /**
   * Register Metabox
   *
   * Registers the metabox. Arguments are defined in the __construct method.
   *
   * @since 0.4.6
   */
  function register_metabox() {

    /* Set the metabox icon if defined. */
    $icon  = isset($this->metabox_ops['icon']) ?  '<i class="uk-icon-' . $this->metabox_ops['icon'] . '"></i> ' : '';

    /* Check that the metabox_ops are valid. */
    $this->metabox_ops['context']  = isset($this->metabox_ops['context']) ?  $this->metabox_ops['context'] : 'normal';
    $this->metabox_ops['priority'] = isset($this->metabox_ops['priority']) ?  $this->metabox_ops['priority'] : 'default';

    /* Create the metabox. */
    add_meta_box( $this->metabox_ops['id'], $icon . $this->metabox_ops['title'], array( $this, 'display_metabox' ), $this->pagehook, $this->metabox_ops['context'], $this->metabox_ops['priority'] );

  } // end function register_metabox()

  /**
   * Display Metabox
   *
   * Generates the metabox markup HTML and display.
   *
   * @uses exmachina_get_field_name()   Gets the field name.
   * @uses exmachina_get_field_id()     Gets the field ID.
   * @uses exmachina_get_field_value()  Gets the field value.
   *
   * @since 0.4.6
   */
  function display_metabox() {

    /* Get theme information. */
    $theme = wp_get_theme();

    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <p class="help-block"><?php _e( 'Struggling with some of the theme options or settings? Click on the "Help" tab above.', 'exmachina-core' ); ?></p>
                      <p class="help-block"><?php echo sprintf( __( 'You can also visit the %s <a href="%s" target="_blank">support forum</a>', 'exmachina-core' ), $theme->{'Name'}, 'http://www.machinathemes.com/support/' ); ?></p>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function display_metabox()

} // end class ExMachina_Theme_Help_Metabox

new ExMachina_Theme_Help_Metabox;

