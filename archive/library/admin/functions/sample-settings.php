<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Sample Settings
 *
 * sample-settings.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * This is just a temporary file we are using to build out a test set of theme
 * settings.
 *
 * @package     ExMachina
 * @subpackage  Admin Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/**
 * Sample Settings Admin Subclass
 *
 * Registers a new admin page, prividng content and corresponding menu item for
 * the Sample Settings page.
 *
 * @since 0.4.5
 */
class ExMachina_Admin_Sample_Settings extends ExMachina_Admin_Metaboxes {

  /**
   * Sample Settings Class Constructor
   *
   * Creates an admin menu item and settings page.
   *
   * @since 0.4.5
   */
  function __construct() {

    /* Specify the unique page id. */
    $page_id = 'sample-settings';

    /* Define page titles and menu position. */
    $menu_ops = array(
      'submenu' => array(
        'parent_slug' => 'theme-settings',
        'page_title'  => 'Sample Settings',
        'menu_title'  => 'Sample Settings',
      )
    );

    /* Define page options (notice text and screen icon). */
    $page_ops = array();

    /* Set the unique settings field id. Get from exmachina_get_option( 'option_name', 'sample-settings' ) */
    $settings_field = 'sample-settings';

    /* Define the default setting values. */
    $default_settings = array(
      'footer-left'   => 'Copyright &copy; ' . date( 'Y' ) . ' All Rights Reserved',
      'footer-right'  => 'Site by <a href="http://www.billerickson.net">Bill Erickson</a>',
    );

    /* Create the admin page. */
    $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

    /* Initialize the sanitization filter. */
    add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );

  } // end function __construct()

  /**
   * Sample Settings Sanitizer Filters
   *
   * Register each of the settings with a sanitization filter type.
   *
   * @uses exmachina_add_option_filter() Assign a sanitization filter to an array of settings.
   *
   * @since 0.4.5
   */
  public function sanitizer_filters() {} // end function sanitizer_filters()

  /**
   * Sample Settings Load Metaboxes
   *
   * Registers metaboxes for the Sample Settings page. Metaboxes are only
   * registered if supported by the theme and the user capabilitiy allows it.
   *
   * Additional metaboxes may be added using the 'exmachina_sample_settings_metaboxes'
   * action hook
   *
   * @since 0.1.0
   */
  public function settings_page_load_metaboxes() {

    /* Basic Metabox Markup */
    add_meta_box( 'sample-basic', __( 'Basic Form', 'exmachina-core' ), array( $this, 'metabox_sample_display_basic' ), $this->pagehook, 'normal', 'default' );
    add_meta_box( 'table-basic', __( 'Table Form', 'exmachina-core' ), array( $this, 'metabox_table_display_basic' ), $this->pagehook, 'normal', 'default' );

    /* Layout Modifiers */
    add_meta_box( 'sample-stacked', __( 'Form Stacked', 'exmachina-core' ), array( $this, 'metabox_sample_display_stacked' ), $this->pagehook, 'normal', 'default' );
    add_meta_box( 'sample-horizontal', __( 'Form Horizontal', 'exmachina-core' ), array( $this, 'metabox_sample_display_horizontal' ), $this->pagehook, 'normal', 'default' );
    add_meta_box( 'sample-grid', __( 'Form Grid', 'exmachina-core' ), array( $this, 'metabox_sample_display_grid' ), $this->pagehook, 'normal', 'default' );

    add_meta_box( 'table-stacked', __( 'Table Stacked', 'exmachina-core' ), array( $this, 'metabox_table_display_stacked' ), $this->pagehook, 'normal', 'default' );
    add_meta_box( 'table-horizontal', __( 'Table Horizontal', 'exmachina-core' ), array( $this, 'metabox_table_display_horizontal' ), $this->pagehook, 'normal', 'default' );
    add_meta_box( 'table-grid', __( 'Table Grid', 'exmachina-core' ), array( $this, 'metabox_table_display_grid' ), $this->pagehook, 'normal', 'default' );

    /* Typography Setup */
    add_meta_box( 'table-typography', __( 'Table Typography', 'exmachina-core' ), array( $this, 'metabox_table_display_typography' ), $this->pagehook, 'normal', 'default' );

    /* Code Editing Setup */
    add_meta_box( 'table-editor', __( 'Table Code Editor', 'exmachina-core' ), array( $this, 'metabox_table_display_editor' ), $this->pagehook, 'normal', 'default' );

    /* Layout Setup */
    add_meta_box( 'table-layout', __( 'Table Layout Selector', 'exmachina-core' ), array( $this, 'metabox_table_display_layout' ), $this->pagehook, 'normal', 'default' );

    /* SIDE METABOXES GO BELOW */
    //add_meta_box( 'side-basic', __( 'Side Basic Form', 'exmachina-core' ), array( $this, 'metabox_side_display_basic' ), $this->pagehook, 'side', 'default' );

  } // end function settings_page_load_metaboxes()

  /****************************************************************************
  BEGIN THE NORMAL METABOXES
  ****************************************************************************/

  /**
   * Basic Metabox Form
   *
   * @since 0.4.5
   * @access public
   * @return void
   */
  function metabox_sample_display_basic() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <legend>Basic Inputs</legend>
                  <p class="uk-margin-top-remove">To apply this component, add the <code>.uk-form</code> class to a form element. All form control elements are placed side by side within the next row.</p>
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="" id="" value="" class="" size="" placeholder="Text Input" tabindex="" style="">
                      <input type="password"  name="" id="" value="" class="" size="" placeholder="Password Input"  tabindex="" style="">
                      <select name="" id="" class="">
                        <option label="" value="">Option 01</option>
                        <option label="" value="">Option 02</option>
                      </select>
                      <button type="submit" name="" id="" value="" class="uk-button" >Button</button>
                      <label for=""><input type="checkbox" name="" id="" value="" class="" size="" tabindex="" style=""> Checkbox</label>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><span class="uk-badge">NOTE</span> In this example we used a button from the <a href="#">Button component</a>.</p>
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
  } // end function metabox_sample_display_basic()

  /****************************************************************************
  BEGIN THE BASIC TABLE METABOX FORM
  ****************************************************************************/

  /**
   * Basic Table Metabox Form
   *
   * @since 0.4.5
   * @access public
   * @return void
   */
  function metabox_table_display_basic() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header success" colspan="2">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-2-10 postbox-label">
              <label class="uk-text-bold">This is a Label
              <span class="uk-text-danger uk-text-small small-caps">(Required)</span>
              <span class="uk-text-muted" data-uk-tooltip title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."><sup><i class="uk-icon-question-sign"></i></sup></span>
              </label>
              <p class="uk-margin-top-remove uk-text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </td>
            <td class="uk-width-8-10 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <legend>Basic Inputs</legend>
                  <p class="uk-margin-top-remove">To apply this component, add the <code>.uk-form</code> class to a form element. All form control elements are placed side by side within the next row.</p>
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="" id="" value="" class="" size="" placeholder="Text Input" tabindex="" style="">
                      <input type="password"  name="" id="" value="" class="" size="" placeholder="Password Input"  tabindex="" style="">
                      <select name="" id="" class="">
                        <option label="" value="">Option 01</option>
                        <option label="" value="">Option 02</option>
                      </select>
                      <button type="submit" name="" id="" value="" class="uk-button" >Button</button>
                      <label for=""><input type="checkbox" name="" id="" value="" class="" size="" tabindex="" style=""> Checkbox</label>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><span class="uk-badge">NOTE</span> In this example we used a button from the <a href="#">Button component</a>.</p>
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
  } // end function metabox_table_display_basic()


  /****************************************************************************
  LAYOUT MODIFIERS
  ****************************************************************************/

  /**
   * Form Stacked
   *
   * @since 0.4.5
   * @access public
   * @return void
   */
  function metabox_sample_display_stacked() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1 uk-form-stacked">
                  <legend>Form Stacked</legend>

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-s-it">Text input</label>
                    <div class="uk-form-controls">
                      <input type="text" id="form-s-it" placeholder="Text input"> <span class="uk-form-help-inline uk-text-muted">Add the class <code>.uk-form-help-inline</code> for inline help text.</span>
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-s-ip">Password input</label>
                    <div class="uk-form-controls">
                      <input type="password" id="form-s-ip" placeholder="Password input">
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-s-s">Select field</label>
                    <div class="uk-form-controls">
                      <select id="form-s-s">
                        <option>Option 01</option>
                        <option>Option 02</option>
                      </select>
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-s-t">Textarea</label>
                    <div class="uk-form-controls">
                      <textarea id="form-s-t" cols="30" rows="5" placeholder="Textarea text"></textarea>
                      <p class="uk-form-help-block uk-text-muted">Add the class <code>.uk-form-help-block</code> for help text in block elements.</p>
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <span class="uk-form-label">Radio input</span>
                    <div class="uk-form-controls">
                      <input type="radio" id="form-s-r" name="radio"> <label for="form-s-r">Radio input</label><br>
                      <input type="radio" id="form-s-r1" name="radio"> <label for="form-s-r1">1</label>
                      <label><input type="radio" name="radio"> 2</label>
                      <label><input type="radio" name="radio"> 3</label>
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <span class="uk-form-label">Checkbox input</span>
                    <div class="uk-form-controls">
                      <input type="checkbox" id="form-s-c"> <label for="form-s-c">Checkbox input</label><br>
                      <input type="checkbox" id="form-s-c1"> <label for="form-s-c1">1</label>
                      <label><input type="checkbox"> 2</label>
                      <label><input type="checkbox"> 3</label>
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <span class="uk-form-label">Mixed controls</span>
                    <div class="uk-form-controls">
                      <p class="uk-form-controls-condensed">
                        <input type="checkbox" id="form-s-mix1"> <label for="form-s-mix1">Checkbox input</label>
                        <input type="number" id="form-s-mix2" min="0" max="10" value="5" class="uk-form-width-mini uk-form-small"> <label for="form-s-mix2">Number input</label>
                        <select id="form-s-mix3" class="uk-form-small">
                          <option selected="selected">Option 01</option>
                          <option>Option 02</option>
                        </select>
                        <label for="form-s-mix3">Select field</label>
                      </p><!-- .uk-form-controls-condensed -->
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
  } // end function metabox_sample_display_stacked()

  /****************************************************************************
  BEGIN THE HORIZONTAL FORM
  ****************************************************************************/

  /**
   * Form Horizontal
   *
   * @since 0.4.5
   * @access public
   * @return void
   */
  function metabox_sample_display_horizontal() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1 uk-form-horizontal">
                  <legend>Form horizontal</legend>

                  <!-- Text Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">Text input</label>
                    <div class="uk-form-controls">
                      <input type="text" id="form-h-it" placeholder="Text input"> <span class="uk-form-help-inline uk-text-muted">Add the class <code>.uk-form-help-inline</code> for inline help text.</span>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Password Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ip">Password input</label>
                    <div class="uk-form-controls">
                      <input type="password" id="form-h-ip" placeholder="Password input">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Email Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ie">Email input</label>
                    <div class="uk-form-controls">
                      <input type="email" id="form-h-ie" placeholder="name@domain.com">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Search Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-is">Search input</label>
                    <div class="uk-form-controls">
                      <input type="search" id="form-h-is" placeholder="Search...">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Tel Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ite">Tel input</label>
                    <div class="uk-form-controls">
                      <input type="tel" id="form-h-ite" placeholder="+49 555 123456">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- URL Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-iu">URL input</label>
                    <div class="uk-form-controls">
                      <input type="url" id="form-h-iu" placeholder="http://">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- File Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-if">File input</label>
                    <div class="uk-form-controls">
                      <input type="file" id="form-h-if">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Select Field -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-s">Select field</label>
                    <div class="uk-form-controls">
                      <select id="form-h-s">
                        <option>Option 01</option>
                        <option>Option 02</option>
                      </select>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Multiple Field -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-sm">Multiple field</label>
                    <div class="uk-form-controls">
                      <select id="form-h-sm" multiple="multiple">
                        <option>Option 01</option>
                        <option>Option 02</option>
                        <option>Option 03</option>
                        <option>Option 04</option>
                      </select>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Pretty Select Field -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-s">Pretty select</label>
                    <div class="uk-form-controls">
                      <select id="" class="pretty-select" placeholder="Select a person...">
                        <option value="">Select a person...</option>
                        <option value="4">Thomas Edison</option>
                        <option value="1">Nikola</option>
                        <option value="3">Nikola Tesla</option>
                      </select>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Pretty Select Multiple Field -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-s">Pretty multiple</label>
                    <div class="uk-form-controls">
                      <select id="" class="pretty-select" multiple="multiple" placeholder="Select a person...">
                        <option value="">Select a person...</option>
                        <option value="4">Thomas Edison</option>
                        <option value="1">Nikola</option>
                        <option value="3">Nikola Tesla</option>
                      </select>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Textarea Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-t">Textarea</label>
                    <div class="uk-form-controls">
                      <textarea id="form-h-t" cols="30" rows="5" placeholder="Textarea text"></textarea>
                      <p class="uk-form-help-block uk-text-muted">Add the class <code>.uk-form-help-block</code> for help text in block elements.</p>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Radio Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Radio input</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <input type="radio" id="form-h-r" name="radio"> <label for="form-h-r">Radio input</label><br>
                      <input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">1</label>
                      <label><input type="radio" name="radio"> 2</label>
                      <label><input type="radio" name="radio"> 3</label>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Radio Vertical Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Radio vertical</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="radio-list vertical">
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 1</label></li>
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 2</label></li>
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 3</label></li>
                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Radio Horizontal Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Radio horizontal</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="radio-list horizontal">
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 1</label></li>
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 2</label></li>
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 3</label></li>
                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Checkbox Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Checkbox input</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <input type="checkbox" id="form-h-c"> <label for="form-h-c">Checkbox input</label><br>
                      <input type="checkbox" id="form-h-c1"> <label for="form-h-c1">1</label>
                      <label><input type="checkbox"> 2</label>
                      <label><input type="checkbox"> 3</label>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Checkbox Vertical Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Checkbox vertical</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="checkbox-list vertical">
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 1</label></li>
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 2</label></li>
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 3</label></li>
                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Checkbox Horizontal Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Checkbox horizontal</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="checkbox-list horizontal">
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 1</label></li>
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 2</label></li>
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 3</label></li>
                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Switch Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Switch toggles</span>
                    <div class="uk-form-controls uk-form-controls-text">

                      <label class="switch">
                        <input type="checkbox" class="switch-input">
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                      </label>

                      <label class="switch">
                        <input type="checkbox" class="switch-input" checked>
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                      </label>

                      <label class="switch switch-green">
                        <input type="checkbox" class="switch-input" checked>
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                      </label>

                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Switch Vertical -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Switch vertical</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="switch-list vertical">
                        <li>
                          <label class="switch">
                            <input type="checkbox" class="switch-input">
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                        <li>
                          <label class="switch">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                        <li>
                          <label class="switch switch-green">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Switch Horizontal -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Switch vertical</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="switch-list horizontal">
                        <li>
                          <label class="switch">
                            <input type="checkbox" class="switch-input">
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                        <li>
                          <label class="switch">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                        <li>
                          <label class="switch switch-green">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Mixed Controls -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Mixed controls</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <p class="uk-form-controls-condensed">
                        <input type="checkbox" id="form-h-mix1"> <label for="form-h-mix1">Checkbox input</label>
                        <input type="number" id="form-h-mix2" min="0" max="10" value="5" class="uk-form-width-mini uk-form-small"> <label for="form-h-mix2">Number input</label>
                        <select id="form-h-mix3" class="uk-form-small">
                          <option selected="selected">Option 01</option>
                          <option>Option 02</option>
                        </select>
                        <label for="form-h-mix3">Select field</label>
                      </p><!-- .uk-form-controls-condensed -->
                      <p class="uk-form-controls-condensed">
                        <input type="checkbox" id="form-h-mix1"> <label for="form-h-mix1">Checkbox input</label>
                        <input type="number" id="form-h-mix2" min="0" max="10" value="5" class="uk-form-width-mini uk-form-small"> <label for="form-h-mix2">Number input</label>
                        <select id="form-h-mix3" class="uk-form-small">
                          <option selected="selected">Option 01</option>
                          <option>Option 02</option>
                        </select>
                        <label for="form-h-mix3">Select field</label>
                      </p><!-- .uk-form-controls-condensed -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Color Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ic">Color input</label>
                    <div class="uk-form-controls">
                      <input type="color" id="form-h-ic" placeholder="#000000">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- MiniColor Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ic">Minicolor</label>
                    <div class="uk-form-controls">
                      <input class="colourpicker minicolors-input" id="" name="" type="text" rel="color" value="#333333" size="7" maxlength="7">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- WordPress Colorpicker Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ic">WP Colorpicker</label>
                    <div class="uk-form-controls">
                      <input type="text" value="#eeeeee" class="wp-color-picker-field" data-default-color="#ffffff" />
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Number Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-in">Number input</label>
                    <div class="uk-form-controls">
                      <input type="number" id="form-h-in" min="0" max="10" value="5">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Range Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ir">Range input</label>
                    <div class="uk-form-controls">
                      <input type="range" id="form-h-ir" value="10">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Date Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-id">Date input</label>
                    <div class="uk-form-controls">
                      <input type="date" id="form-h-id" placeholder="1970-01-01">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Month Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-im">Month input</label>
                    <div class="uk-form-controls">
                      <input type="month" id="form-h-im" placeholder="1970-01">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Week Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-iw">Week input</label>
                    <div class="uk-form-controls">
                      <input type="week" id="form-h-iw" placeholder="1970-W01">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Time Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-iti">Time input</label>
                    <div class="uk-form-controls">
                      <input type="time" id="form-h-iti" placeholder="00:00:00">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Datetime Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-idt">Datetime input</label>
                    <div class="uk-form-controls">
                      <input type="datetime" id="form-h-idt" placeholder="1970-01-01T00:00:00Z">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Datetime Local Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-idtl">Datetime-local input</label>
                    <div class="uk-form-controls">
                      <input type="datetime-local" id="form-h-idtl" placeholder="1970-01-01T00:00">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Disabled Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">Disabled input</label>
                    <div class="uk-form-controls">
                      <input type="text" id="form-h-itd" placeholder="Text input" disabled>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Required Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">Required input</label>
                    <div class="uk-form-controls">
                      <input type="text" id="form-h-itr" placeholder="Text input" required>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Input Buttons -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Input buttons</span>
                    <div class="uk-form-controls">
                      <input type="reset" value="Reset" class="uk-button">
                      <input type="button" value="Button" class="uk-button">
                      <input type="submit" value="Submit" class="uk-button">
                      <input type="submit" value="Disabled" class="uk-button" disabled>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Buttons -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Buttons</span>
                    <div class="uk-form-controls">
                      <button type="reset" class="uk-button">Reset</button>
                      <button type="button" class="uk-button">Button</button>
                      <button type="submit" class="uk-button">Submit</button>
                      <button type="submit" class="uk-button" disabled>Disabled</button>
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
  } // end function metabox_sample_display_horizontal()

  /****************************************************************************
  BEGIN THE GRID FORM
  ****************************************************************************/

  /**
   * Form Grid
   *
   * @since 0.4.5
   * @access public
   * @return void
   */
  function metabox_sample_display_grid() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <legend>Form grid</legend>

                  <div class="uk-grid uk-grid-preserve uk-margin" data-uk-grid-margin>
                    <div class="uk-width-1-1"><input type="text" placeholder="100" class="uk-width-1-1"></div>
                    <!-- Halves -->
                    <div class="uk-width-1-2"><input type="text" placeholder="50" class="uk-width-1-1"></div>
                    <div class="uk-width-1-2"><input type="text" placeholder="50" class="uk-width-1-1"></div>
                    <!-- Thirds -->
                    <div class="uk-width-1-3"><input type="text" placeholder="33" class="uk-width-1-1"></div>
                    <div class="uk-width-1-3"><input type="text" placeholder="33" class="uk-width-1-1"></div>
                    <div class="uk-width-1-3"><input type="text" placeholder="33" class="uk-width-1-1"></div>
                    <!-- Fourths -->
                    <div class="uk-width-1-4"><input type="text" placeholder="25" class="uk-width-1-1"></div>
                    <div class="uk-width-1-4"><input type="text" placeholder="25" class="uk-width-1-1"></div>
                    <div class="uk-width-1-4"><input type="text" placeholder="25" class="uk-width-1-1"></div>
                    <div class="uk-width-1-4"><input type="text" placeholder="25" class="uk-width-1-1"></div>
                    <!-- Fifths -->
                    <div class="uk-width-1-5"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <div class="uk-width-1-5"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <div class="uk-width-1-5"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <div class="uk-width-1-5"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <div class="uk-width-1-5"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <!-- Sixths -->
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <!-- Tenths -->
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                  </div><!-- .uk-grid -->

                  <hr class="uk-grid-divider">

                  <div class="uk-grid uk-grid-preserve uk-margin" data-uk-grid-margin>
                    <!-- Row #1 -->
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-9-10"><input type="text" placeholder="90" class="uk-width-1-1"></div>
                    <!-- Row #2 -->
                    <div class="uk-width-2-10"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <div class="uk-width-8-10"><input type="text" placeholder="80" class="uk-width-1-1"></div>
                    <!-- Row #3 -->
                    <div class="uk-width-3-10"><input type="text" placeholder="30" class="uk-width-1-1"></div>
                    <div class="uk-width-7-10"><input type="text" placeholder="70" class="uk-width-1-1"></div>
                    <!-- Row #4 -->
                    <div class="uk-width-4-10"><input type="text" placeholder="40" class="uk-width-1-1"></div>
                    <div class="uk-width-6-10"><input type="text" placeholder="60" class="uk-width-1-1"></div>
                    <!-- Row #5 -->
                    <div class="uk-width-5-10"><input type="text" placeholder="50" class="uk-width-1-1"></div>
                    <div class="uk-width-5-10"><input type="text" placeholder="50" class="uk-width-1-1"></div>
                    <!-- Row #6 -->
                    <div class="uk-width-6-10"><input type="text" placeholder="60" class="uk-width-1-1"></div>
                    <div class="uk-width-4-10"><input type="text" placeholder="40" class="uk-width-1-1"></div>
                    <!-- Row #7 -->
                    <div class="uk-width-7-10"><input type="text" placeholder="70" class="uk-width-1-1"></div>
                    <div class="uk-width-3-10"><input type="text" placeholder="30" class="uk-width-1-1"></div>
                    <!-- Row #8 -->
                    <div class="uk-width-8-10"><input type="text" placeholder="80" class="uk-width-1-1"></div>
                    <div class="uk-width-2-10"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <!-- Row #9 -->
                    <div class="uk-width-9-10"><input type="text" placeholder="90" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                  </div><!-- .uk-grid -->

                  <hr class="uk-grid-divider">

                  <div class="uk-grid uk-grid-preserve" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                      <label class="uk-form-label" for="form-g-a">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-a" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                    <div class="uk-width-medium-1-2">
                      <label class="uk-form-label" for="form-g-a">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-a" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                    <div class="uk-width-medium-1-2">
                      <label class="uk-form-label" for="form-g-b">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-b" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                    <div class="uk-width-medium-1-3">
                      <label class="uk-form-label" for="form-g-a">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-a" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                    <div class="uk-width-medium-1-3">
                      <label class="uk-form-label" for="form-g-a">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-a" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                    <div class="uk-width-medium-1-3">
                      <label class="uk-form-label" for="form-g-a">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-a" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                  </div><!-- .uk-grid -->

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
  } // end function metabox_sample_display_grid()


  /****************************************************************************
  BEGIN THE TABLE STACKED
  ****************************************************************************/

  /**
   * Table Stacked
   *
   * @since 0.4.5
   * @access public
   * @return void
   */
  function metabox_table_display_stacked() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header success" colspan="2">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-2-10 postbox-label">
              <label class="uk-text-bold">This is a Label
              <span class="uk-text-danger uk-text-small small-caps">(Required)</span>
              <span class="uk-text-muted" data-uk-tooltip title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."><sup><i class="uk-icon-question-sign"></i></sup></span>
              </label>
              <p class="uk-margin-top-remove uk-text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </td>
            <td class="uk-width-8-10 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1 uk-form-stacked">
                  <legend>Form Stacked</legend>

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-s-it">Text input</label>
                    <div class="uk-form-controls">
                      <input type="text" id="form-s-it" placeholder="Text input"> <span class="uk-form-help-inline uk-text-muted">Add the class <code>.uk-form-help-inline</code> for inline help text.</span>
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-s-ip">Password input</label>
                    <div class="uk-form-controls">
                      <input type="password" id="form-s-ip" placeholder="Password input">
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-s-s">Select field</label>
                    <div class="uk-form-controls">
                      <select id="form-s-s">
                        <option>Option 01</option>
                        <option>Option 02</option>
                      </select>
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-s-t">Textarea</label>
                    <div class="uk-form-controls">
                      <textarea id="form-s-t" cols="30" rows="5" placeholder="Textarea text"></textarea>
                      <p class="uk-form-help-block uk-text-muted">Add the class <code>.uk-form-help-block</code> for help text in block elements.</p>
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <span class="uk-form-label">Radio input</span>
                    <div class="uk-form-controls">
                      <input type="radio" id="form-s-r" name="radio"> <label for="form-s-r">Radio input</label><br>
                      <input type="radio" id="form-s-r1" name="radio"> <label for="form-s-r1">1</label>
                      <label><input type="radio" name="radio"> 2</label>
                      <label><input type="radio" name="radio"> 3</label>
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <span class="uk-form-label">Checkbox input</span>
                    <div class="uk-form-controls">
                      <input type="checkbox" id="form-s-c"> <label for="form-s-c">Checkbox input</label><br>
                      <input type="checkbox" id="form-s-c1"> <label for="form-s-c1">1</label>
                      <label><input type="checkbox"> 2</label>
                      <label><input type="checkbox"> 3</label>
                    </div><!-- .uk-form-controls -->
                  </div><!-- uk-form-row -->

                  <div class="uk-form-row">
                    <span class="uk-form-label">Mixed controls</span>
                    <div class="uk-form-controls">
                      <p class="uk-form-controls-condensed">
                        <input type="checkbox" id="form-s-mix1"> <label for="form-s-mix1">Checkbox input</label>
                        <input type="number" id="form-s-mix2" min="0" max="10" value="5" class="uk-form-width-mini uk-form-small"> <label for="form-s-mix2">Number input</label>
                        <select id="form-s-mix3" class="uk-form-small">
                          <option selected="selected">Option 01</option>
                          <option>Option 02</option>
                        </select>
                        <label for="form-s-mix3">Select field</label>
                      </p><!-- .uk-form-controls-condensed -->
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
  } // end function metabox_table_display_stacked()

  /****************************************************************************
  BEGIN THE TABLE HORIZONTAL
  ****************************************************************************/

  /**
   * Table Horizontal
   *
   * @since 0.4.5
   * @access public
   * @return void
   */
  function metabox_table_display_horizontal() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header success" colspan="2">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-2-10 postbox-label">
              <label class="uk-text-bold">This is a Label
              <span class="uk-text-danger uk-text-small small-caps">(Required)</span>
              <span class="uk-text-muted" data-uk-tooltip title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."><sup><i class="uk-icon-question-sign"></i></sup></span>
              </label>
              <p class="uk-margin-top-remove uk-text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </td>
            <td class="uk-width-8-10 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1 uk-form-horizontal">
                  <legend>Form horizontal</legend>

                  <!-- Text Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">Text input</label>
                    <div class="uk-form-controls">
                      <input type="text" id="form-h-it" placeholder="Text input"> <span class="uk-form-help-inline uk-text-muted">Add the class <code>.uk-form-help-inline</code> for inline help text.</span>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Password Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ip">Password input</label>
                    <div class="uk-form-controls">
                      <input type="password" id="form-h-ip" placeholder="Password input">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Email Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ie">Email input</label>
                    <div class="uk-form-controls">
                      <input type="email" id="form-h-ie" placeholder="name@domain.com">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Search Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-is">Search input</label>
                    <div class="uk-form-controls">
                      <input type="search" id="form-h-is" placeholder="Search...">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Tel Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ite">Tel input</label>
                    <div class="uk-form-controls">
                      <input type="tel" id="form-h-ite" placeholder="+49 555 123456">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- URL Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-iu">URL input</label>
                    <div class="uk-form-controls">
                      <input type="url" id="form-h-iu" placeholder="http://">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- File Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-if">File input</label>
                    <div class="uk-form-controls">
                      <input type="file" id="form-h-if">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Select Field -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-s">Select field</label>
                    <div class="uk-form-controls">
                      <select id="form-h-s">
                        <option>Option 01</option>
                        <option>Option 02</option>
                      </select>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Multiple Field -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-sm">Multiple field</label>
                    <div class="uk-form-controls">
                      <select id="form-h-sm" multiple="multiple">
                        <option>Option 01</option>
                        <option>Option 02</option>
                        <option>Option 03</option>
                        <option>Option 04</option>
                      </select>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Pretty Select Field -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-s">Pretty select</label>
                    <div class="uk-form-controls">
                      <select id="" class="pretty-select" placeholder="Select a person...">
                        <option value="">Select a person...</option>
                        <option value="4">Thomas Edison</option>
                        <option value="1">Nikola</option>
                        <option value="3">Nikola Tesla</option>
                      </select>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Pretty Select Multiple Field -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-s">Pretty multiple</label>
                    <div class="uk-form-controls">
                      <select id="" class="pretty-select" multiple="multiple" placeholder="Select a person...">
                        <option value="">Select a person...</option>
                        <option value="4">Thomas Edison</option>
                        <option value="1">Nikola</option>
                        <option value="3">Nikola Tesla</option>
                      </select>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Textarea Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-t">Textarea</label>
                    <div class="uk-form-controls">
                      <textarea id="form-h-t" cols="30" rows="5" placeholder="Textarea text"></textarea>
                      <p class="uk-form-help-block uk-text-muted">Add the class <code>.uk-form-help-block</code> for help text in block elements.</p>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Radio Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Radio input</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <input type="radio" id="form-h-r" name="radio"> <label for="form-h-r">Radio input</label><br>
                      <input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">1</label>
                      <label><input type="radio" name="radio"> 2</label>
                      <label><input type="radio" name="radio"> 3</label>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Radio Vertical Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Radio vertical</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="radio-list vertical">
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 1</label></li>
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 2</label></li>
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 3</label></li>
                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Radio Horizontal Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Radio horizontal</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="radio-list horizontal">
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 1</label></li>
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 2</label></li>
                        <li><input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">Option 3</label></li>
                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Checkbox Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Checkbox input</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <input type="checkbox" id="form-h-c"> <label for="form-h-c">Checkbox input</label><br>
                      <input type="checkbox" id="form-h-c1"> <label for="form-h-c1">1</label>
                      <label><input type="checkbox"> 2</label>
                      <label><input type="checkbox"> 3</label>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Checkbox Vertical Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Checkbox vertical</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="checkbox-list vertical">
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 1</label></li>
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 2</label></li>
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 3</label></li>
                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Checkbox Horizontal Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Checkbox horizontal</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="checkbox-list horizontal">
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 1</label></li>
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 2</label></li>
                        <li><input type="checkbox" id="form-h-r1" name=""> <label for="form-h-r1">Option 3</label></li>
                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Switch Input -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Switch toggles</span>
                    <div class="uk-form-controls uk-form-controls-text">

                      <label class="switch">
                        <input type="checkbox" class="switch-input">
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                      </label>

                      <label class="switch">
                        <input type="checkbox" class="switch-input" checked>
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                      </label>

                      <label class="switch switch-green">
                        <input type="checkbox" class="switch-input" checked>
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                      </label>

                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Switch Vertical -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Switch vertical</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="switch-list vertical">
                        <li>
                          <label class="switch">
                            <input type="checkbox" class="switch-input">
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                        <li>
                          <label class="switch">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                        <li>
                          <label class="switch switch-green">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Switch Horizontal -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Switch vertical</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <ul class="switch-list horizontal">
                        <li>
                          <label class="switch">
                            <input type="checkbox" class="switch-input">
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                        <li>
                          <label class="switch">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                        <li>
                          <label class="switch switch-green">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>
                        </li>

                      </ul>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Mixed Controls -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Mixed controls</span>
                    <div class="uk-form-controls uk-form-controls-text">
                      <p class="uk-form-controls-condensed">
                        <input type="checkbox" id="form-h-mix1"> <label for="form-h-mix1">Checkbox input</label>
                        <input type="number" id="form-h-mix2" min="0" max="10" value="5" class="uk-form-width-mini uk-form-small"> <label for="form-h-mix2">Number input</label>
                        <select id="form-h-mix3" class="uk-form-small">
                          <option selected="selected">Option 01</option>
                          <option>Option 02</option>
                        </select>
                        <label for="form-h-mix3">Select field</label>
                      </p><!-- .uk-form-controls-condensed -->
                      <p class="uk-form-controls-condensed">
                        <input type="checkbox" id="form-h-mix1"> <label for="form-h-mix1">Checkbox input</label>
                        <input type="number" id="form-h-mix2" min="0" max="10" value="5" class="uk-form-width-mini uk-form-small"> <label for="form-h-mix2">Number input</label>
                        <select id="form-h-mix3" class="uk-form-small">
                          <option selected="selected">Option 01</option>
                          <option>Option 02</option>
                        </select>
                        <label for="form-h-mix3">Select field</label>
                      </p><!-- .uk-form-controls-condensed -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Color Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ic">Color input</label>
                    <div class="uk-form-controls">
                      <input type="color" id="form-h-ic" placeholder="#000000">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- MiniColor Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ic">Minicolor</label>
                    <div class="uk-form-controls">
                      <input class="colourpicker minicolors-input" id="" name="" type="text" rel="color" value="#333333" size="7" maxlength="7">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- WordPress Colorpicker Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ic">WP Colorpicker</label>
                    <div class="uk-form-controls">
                      <input type="text" value="#eeeeee" class="wp-color-picker-field" data-default-color="#ffffff" />
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Number Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-in">Number input</label>
                    <div class="uk-form-controls">
                      <input type="number" id="form-h-in" min="0" max="10" value="5">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Range Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-ir">Range input</label>
                    <div class="uk-form-controls">
                      <input type="range" id="form-h-ir" value="10">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Date Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-id">Date input</label>
                    <div class="uk-form-controls">
                      <input type="date" id="form-h-id" placeholder="1970-01-01">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Month Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-im">Month input</label>
                    <div class="uk-form-controls">
                      <input type="month" id="form-h-im" placeholder="1970-01">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Week Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-iw">Week input</label>
                    <div class="uk-form-controls">
                      <input type="week" id="form-h-iw" placeholder="1970-W01">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Time Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-iti">Time input</label>
                    <div class="uk-form-controls">
                      <input type="time" id="form-h-iti" placeholder="00:00:00">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Datetime Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-idt">Datetime input</label>
                    <div class="uk-form-controls">
                      <input type="datetime" id="form-h-idt" placeholder="1970-01-01T00:00:00Z">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Datetime Local Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-idtl">Datetime-local input</label>
                    <div class="uk-form-controls">
                      <input type="datetime-local" id="form-h-idtl" placeholder="1970-01-01T00:00">
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Disabled Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">Disabled input</label>
                    <div class="uk-form-controls">
                      <input type="text" id="form-h-itd" placeholder="Text input" disabled>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Required Input -->
                  <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">Required input</label>
                    <div class="uk-form-controls">
                      <input type="text" id="form-h-itr" placeholder="Text input" required>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Input Buttons -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Input buttons</span>
                    <div class="uk-form-controls">
                      <input type="reset" value="Reset" class="uk-button">
                      <input type="button" value="Button" class="uk-button">
                      <input type="submit" value="Submit" class="uk-button">
                      <input type="submit" value="Disabled" class="uk-button" disabled>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->

                  <!-- Buttons -->
                  <div class="uk-form-row">
                    <span class="uk-form-label">Buttons</span>
                    <div class="uk-form-controls">
                      <button type="reset" class="uk-button">Reset</button>
                      <button type="button" class="uk-button">Button</button>
                      <button type="submit" class="uk-button">Submit</button>
                      <button type="submit" class="uk-button" disabled>Disabled</button>
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
  } // end function metabox_table_display_horizontal()

  /****************************************************************************
  BEGIN THE TABLE GRID
  ****************************************************************************/

  /**
   * Table Grid
   *
   * @since 0.4.5
   * @access public
   * @return void
   */
  function metabox_table_display_grid() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header success" colspan="2">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-2-10 postbox-label">
              <label class="uk-text-bold">This is a Label
              <span class="uk-text-danger uk-text-small small-caps">(Required)</span>
              <span class="uk-text-muted" data-uk-tooltip title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."><sup><i class="uk-icon-question-sign"></i></sup></span>
              </label>
              <p class="uk-margin-top-remove uk-text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </td>
            <td class="uk-width-8-10 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <legend>Form grid</legend>

                  <div class="uk-grid uk-grid-preserve uk-margin" data-uk-grid-margin>
                    <div class="uk-width-1-1"><input type="text" placeholder="100" class="uk-width-1-1"></div>
                    <!-- Halves -->
                    <div class="uk-width-1-2"><input type="text" placeholder="50" class="uk-width-1-1"></div>
                    <div class="uk-width-1-2"><input type="text" placeholder="50" class="uk-width-1-1"></div>
                    <!-- Thirds -->
                    <div class="uk-width-1-3"><input type="text" placeholder="33" class="uk-width-1-1"></div>
                    <div class="uk-width-1-3"><input type="text" placeholder="33" class="uk-width-1-1"></div>
                    <div class="uk-width-1-3"><input type="text" placeholder="33" class="uk-width-1-1"></div>
                    <!-- Fourths -->
                    <div class="uk-width-1-4"><input type="text" placeholder="25" class="uk-width-1-1"></div>
                    <div class="uk-width-1-4"><input type="text" placeholder="25" class="uk-width-1-1"></div>
                    <div class="uk-width-1-4"><input type="text" placeholder="25" class="uk-width-1-1"></div>
                    <div class="uk-width-1-4"><input type="text" placeholder="25" class="uk-width-1-1"></div>
                    <!-- Fifths -->
                    <div class="uk-width-1-5"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <div class="uk-width-1-5"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <div class="uk-width-1-5"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <div class="uk-width-1-5"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <div class="uk-width-1-5"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <!-- Sixths -->
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <div class="uk-width-1-6"><input type="text" placeholder="16" class="uk-width-1-1"></div>
                    <!-- Tenths -->
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                  </div><!-- .uk-grid -->

                  <hr class="uk-grid-divider">

                  <div class="uk-grid uk-grid-preserve uk-margin" data-uk-grid-margin>
                    <!-- Row #1 -->
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                    <div class="uk-width-9-10"><input type="text" placeholder="90" class="uk-width-1-1"></div>
                    <!-- Row #2 -->
                    <div class="uk-width-2-10"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <div class="uk-width-8-10"><input type="text" placeholder="80" class="uk-width-1-1"></div>
                    <!-- Row #3 -->
                    <div class="uk-width-3-10"><input type="text" placeholder="30" class="uk-width-1-1"></div>
                    <div class="uk-width-7-10"><input type="text" placeholder="70" class="uk-width-1-1"></div>
                    <!-- Row #4 -->
                    <div class="uk-width-4-10"><input type="text" placeholder="40" class="uk-width-1-1"></div>
                    <div class="uk-width-6-10"><input type="text" placeholder="60" class="uk-width-1-1"></div>
                    <!-- Row #5 -->
                    <div class="uk-width-5-10"><input type="text" placeholder="50" class="uk-width-1-1"></div>
                    <div class="uk-width-5-10"><input type="text" placeholder="50" class="uk-width-1-1"></div>
                    <!-- Row #6 -->
                    <div class="uk-width-6-10"><input type="text" placeholder="60" class="uk-width-1-1"></div>
                    <div class="uk-width-4-10"><input type="text" placeholder="40" class="uk-width-1-1"></div>
                    <!-- Row #7 -->
                    <div class="uk-width-7-10"><input type="text" placeholder="70" class="uk-width-1-1"></div>
                    <div class="uk-width-3-10"><input type="text" placeholder="30" class="uk-width-1-1"></div>
                    <!-- Row #8 -->
                    <div class="uk-width-8-10"><input type="text" placeholder="80" class="uk-width-1-1"></div>
                    <div class="uk-width-2-10"><input type="text" placeholder="20" class="uk-width-1-1"></div>
                    <!-- Row #9 -->
                    <div class="uk-width-9-10"><input type="text" placeholder="90" class="uk-width-1-1"></div>
                    <div class="uk-width-1-10"><input type="text" placeholder="10" class="uk-width-1-1"></div>
                  </div><!-- .uk-grid -->

                  <hr class="uk-grid-divider">

                  <div class="uk-grid uk-grid-preserve" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                      <label class="uk-form-label" for="form-g-a">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-a" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                    <div class="uk-width-medium-1-2">
                      <label class="uk-form-label" for="form-g-a">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-a" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                    <div class="uk-width-medium-1-2">
                      <label class="uk-form-label" for="form-g-b">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-b" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                    <div class="uk-width-medium-1-3">
                      <label class="uk-form-label" for="form-g-a">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-a" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                    <div class="uk-width-medium-1-3">
                      <label class="uk-form-label" for="form-g-a">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-a" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                    <div class="uk-width-medium-1-3">
                      <label class="uk-form-label" for="form-g-a">Label</label>
                      <div class="uk-form-controls"><input type="text" id="form-g-a" placeholder="50" class="uk-width-1-1"></div>
                    </div>
                  </div><!-- .uk-grid -->

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
  } // end function metabox_table_display_grid()

  /****************************************************************************
  BEGIN THE TABLE TYPOGRAPHY METABOX
  ****************************************************************************/

  /**
   * Table Typography Metabox
   *
   * @since 0.4.5
   * @access public
   * @return void
   */
  function metabox_table_display_typography() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header alert" colspan="2">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-2-10 postbox-label">
              <label class="uk-text-bold">This is a Label
              <span class="uk-text-danger uk-text-small small-caps">(Required)</span>
              <span class="uk-text-muted" data-uk-tooltip title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."><sup><i class="uk-icon-question-sign"></i></sup></span>
              </label>
              <p class="uk-margin-top-remove uk-text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </td>
            <td class="uk-width-8-10 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <legend>Typography</legend>
                  <p class="uk-margin-top-remove">To apply this component, add the <code>.uk-form</code> class to a form element. All form control elements are placed side by side within the next row.</p>
                  <div class="uk-form-row">
                    <div class="uk-form-controls uk-form-controls-text">
                      <div class="section section-typography">
                      <!-- Begin Typography Controls -->
                        <div class="uk-panel uk-panel-box uk-form-controls-condensed typography-controls controls">
                          <!-- Size Select px -->
                          <select class="uk-form-width-mini typography-size typography-size-px" id="" style="display:none">
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                              <option value="13">13</option>
                              <option value="14">14</option>
                              <option value="15">15</option>
                              <option value="16">16</option>
                              <option value="17">17</option>
                              <option value="18">18</option>
                              <option value="19">19</option>
                              <option value="20">20</option>
                          </select>
                          <!-- Size Select em -->
                          <select class="uk-form-width-mini typography-size typography-size-em" id="" name="">
                              <option value="2.1">2.1</option>
                              <option value="2.2">2.2</option>
                              <option value="2.3">2.3</option>
                              <option value="2.4">2.4</option>
                              <option value="2.5">2.5</option>
                              <option value="2.6">2.6</option>
                              <option value="2.7">2.7</option>
                              <option value="2.8">2.8</option>
                              <option value="2.9">2.9</option>
                          </select>
                          <!-- Unit Select -->
                          <select class="uk-form-width-mini typography-unit" name="" id="">
                              <option value="px">px</option>
                              <option value="em" selected="selected">em</option>
                          </select>
                          <!-- Font Face Select -->
                          <select class="uk-form-width-medium typography-face" name="" id="">
                            <optgroup label="System Fonts">
                              <option selected="selected" value="Arial, sans-serif">Arial</option>
                              <option value="Verdana, Geneva, sans-serif">Verdana</option>
                              <option value="Georgia, serif">Georgia</option>
                              <option value="Tahoma, Geneva, Verdana, sans-serif">Tahoma</option>
                              <option value="Geneva, Tahoma, Verdana, sans-serif">Geneva*</option>
                              <option value="Impact, Charcoal, sans-serif">Impact</option>
                            </optgroup>
                            <optgroup label="Google Fonts">
                              <option value="Architects Daughter">Architects Daughter</option>
                              <option value="Arimo">Arimo</option>
                              <option value="Cabin">Cabin</option>
                              <option value="Chivo">Chivo</option>
                              <option value="Lato">Lato</option>
                              <option value="Lobster">Lobster</option>
                              <option value="Lobster Two">Lobster Two</option>
                              <option value="Oswald">Oswald</option>
                              <option value="Rock Salt">Rock Salt</option>
                              <option value="Yanone Kaffeesatz">Yanone Kaffeesatz</option>
                            </optgroup>
                          </select>
                          <!-- Font Style Select -->
                          <select class="uk-form-width-small typography-style" name="" id="">
                              <option selected="selected" value="300">Thin</option>
                              <option value="300 italic">Thin/Italic</option>
                              <option value="normal">Normal</option>
                              <option value="italic">Italic</option>
                              <option value="bold">Bold</option>
                              <option value="bold italic">Bold/Italic</option>
                          </select>
                          <!-- Font Color Select -->
                          <div id="font_body_color_picker" class="color-selector">
                              <div style="background-color: rgb(62, 62, 62);"></div>
                          </div>
                          <input class="colourpicker minicolors-input typography-color pick-color" id="font_body_color" name="" type="text" rel="color" value="#333333" size="7" maxlength="7">

                          <!-- Preview Button -->
                          <a href="#" class="uk-button typography-preview-button"><i class="uk-icon-search"></i></a>

                        </div><!-- .typography-controls -->
                        <!-- End Typography Controls -->

                        <!-- Begin Font Preview -->
                        <div class="explain"></div>
                        <div class="clear"> </div>
                        <!-- End Font Preview -->

                      </div><!-- .section-typography -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><span class="uk-badge">NOTE</span> In this example we used a button from the <a href="#">Button component</a>.</p>
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
  } // end function metabox_table_display_typography()


  /****************************************************************************
  BEGIN THE TABLE EDITOR METABOX FORM
  ****************************************************************************/

  /**
   * Table Code Editor
   *
   * @since 0.4.5
   * @access public
   * @return void
   */
  function metabox_table_display_editor() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header error" colspan="2">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-2-10 postbox-label">
              <label class="uk-text-bold">This is a Label
              <span class="uk-text-danger uk-text-small small-caps">(Required)</span>
              <span class="uk-text-muted" data-uk-tooltip title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."><sup><i class="uk-icon-question-sign"></i></sup></span>
              </label>
              <p class="uk-margin-top-remove uk-text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </td>
            <td class="uk-width-8-10 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <legend>Textarea Editor</legend>
                  <p class="uk-margin-top-remove">To apply this component, add the <code>.uk-form</code> class to a form element. All form control elements are placed side by side within the next row.</p>
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <textarea class="input-block-level vertical-resize code" rows="8"></textarea>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><span class="uk-badge">NOTE</span> In this example we used a button from the <a href="#">Button component</a>.</p>
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
          <tr>
            <td class="uk-width-2-10 postbox-label">
              <label class="uk-text-bold">This is a Label
              <span class="uk-text-danger uk-text-small small-caps">(Required)</span>
              <span class="uk-text-muted" data-uk-tooltip title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."><sup><i class="uk-icon-question-sign"></i></sup></span>
              </label>
              <p class="uk-margin-top-remove uk-text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </td>
            <td class="uk-width-8-10 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <legend>CodeMirror Editor</legend>
                  <p class="uk-margin-top-remove">To apply this component, add the <code>.uk-form</code> class to a form element. All form control elements are placed side by side within the next row.</p>
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <textarea class="input-block-level vertical-resize code exmachina-code-area" rows="8" id="<?php echo $this->get_field_id( 'header_scripts' ); ?>"></textarea>
                      <link rel="stylesheet" href="<?php echo EXMACHINA_ADMIN_VENDOR . '/codemirror/css/theme/monokai.min.css'; ?>">
                      <script>
                        jQuery(document).ready(function($){
                            var editor_header_scripts = CodeMirror.fromTextArea(document.getElementById('<?= $this->get_field_id( 'header_scripts' );?>'), {
                                lineNumbers: true,
                                tabmode: 'indent',
                                mode: 'htmlmixed',
                                theme: 'monokai'
                            });
                        });
                      </script>
                      <!-- End Form Inputs -->
                      <p class="uk-form-controls-condensed">
                        <select id="form-h-mix3" class="uk-form-small">
                          <option selected="selected">Option 01</option>
                          <option>Option 02</option>
                        </select>
                        <label for="form-h-mix3">Select field</label>
                      </p><!-- .uk-form-controls-condensed -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><span class="uk-badge">NOTE</span> In this example we used a button from the <a href="#">Button component</a>.</p>
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
  } // end function metabox_table_display_editor()

  /****************************************************************************
  BEGIN THE TABLE LAYOUT METABOX FORM
  ****************************************************************************/

  /**
   * Table Layout Editor
   *
   * @since 0.4.5
   * @access public
   * @return void
   */
  function metabox_table_display_layout() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header error" colspan="2">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="radio-selector" colspan="2">
              <div class="fieldset-wrap uk-margin uk-grid">
                <fieldset class="uk-form uk-width-1-1">
                  <div class="radio-container uk-grid uk-grid-preserve">
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                    </label>
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img02.png' ); ?>">
                    </label>
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img layout-img-selected" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img03.png' ); ?>">
                    </label>
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img04.png' ); ?>">
                    </label>
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img05.png' ); ?>">
                    </label>
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img06.png' ); ?>">
                    </label>
                  </div><!-- .radio-container -->
                </fieldset>
              </div><!-- .fieldset-wrap -->
            </td><!-- .radio-selector -->
          </tr>
          <tr>
            <td class="radio-selector" colspan="2">
              <div class="fieldset-wrap uk-margin uk-grid">
                <fieldset class="uk-form uk-width-1-1">
                  <div class="radio-container uk-grid uk-grid-preserve">
                    <label class="color-label uk-width-1-6">
                      <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                      <img class="color-img uk-thumbnail" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color01.png' ); ?>">
                    </label>
                    <label class="color-label uk-width-1-6">
                      <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                      <img class="color-img uk-thumbnail" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color02.png' ); ?>">
                    </label>
                    <label class="color-label uk-width-1-6">
                      <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                      <img class="color-img uk-thumbnail color-img-selected" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color03.png' ); ?>">
                    </label>
                    <label class="color-label uk-width-1-6">
                      <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                      <img class="color-img uk-thumbnail" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color04.png' ); ?>">
                    </label>
                    <label class="color-label uk-width-1-6">
                      <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                      <img class="color-img uk-thumbnail" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color05.png' ); ?>">
                    </label>
                    <label class="color-label uk-width-1-6">
                      <input type="radio" class="color-radio" id="" name="" value="1" onclick="">
                      <img class="color-img uk-thumbnail" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/color06.png' ); ?>">
                    </label>
                  </div><!-- .radio-container -->
                </fieldset>
              </div><!-- .fieldset-wrap -->
            </td><!-- .radio-selector -->
          </tr>
          <tr>
            <td class="uk-width-2-10 postbox-label">
              <label class="uk-text-bold">This is a Label
              <span class="uk-text-danger uk-text-small small-caps">(Required)</span>
              <span class="uk-text-muted" data-uk-tooltip title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."><sup><i class="uk-icon-question-sign"></i></sup></span>
              </label>
              <p class="uk-margin-top-remove uk-text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </td>
            <td class="uk-width-8-10 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <legend>Basic Inputs</legend>
                  <p class="uk-margin-top-remove">To apply this component, add the <code>.uk-form</code> class to a form element. All form control elements are placed side by side within the next row.</p>
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="" id="" value="" class="" size="" placeholder="Text Input" tabindex="" style="">
                      <input type="password"  name="" id="" value="" class="" size="" placeholder="Password Input"  tabindex="" style="">
                      <select name="" id="" class="">
                        <option label="" value="">Option 01</option>
                        <option label="" value="">Option 02</option>
                      </select>
                      <button type="submit" name="" id="" value="" class="uk-button" >Button</button>
                      <label for=""><input type="checkbox" name="" id="" value="" class="" size="" tabindex="" style=""> Checkbox</label>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><span class="uk-badge">NOTE</span> In this example we used a button from the <a href="#">Button component</a>.</p>
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
  } // end function metabox_table_display_layout()



} // end class ExMachina_Admin_Sample_Settings

add_action( 'exmachina_admin_menu', 'exmachina_add_sample_settings_page' );
/**
 * Add Sample Settings Page
 *
 * Initializes a new instance of the ExMachina_Admin_Sample_Settings and adds
 * the Sample Settings Page.
 *
 * @since 0.4.5
 */
function exmachina_add_sample_settings_page() {

  /* Globalize the $_exmachina_admin_sample_settings variable. */
  global $_exmachina_admin_sample_settings;

  /* Create a new instance of the ExMachina_Admin_Sample_Settings class. */
  $_exmachina_admin_sample_settings = new ExMachina_Admin_Sample_Settings;

} // end function exmachina_add_sample_settings_page()