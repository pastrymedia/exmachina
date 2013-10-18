<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Customize Control Class
 *
 * customize-control.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * The customize control class extends the WP_Customize_Control class. This class
 * allows additional settings types within the WordPress theme customizer.
 *
 * @package     ExMachina
 * @subpackage  Classes
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin class
###############################################################################

/**
 * Textarea Customize Control
 *
 * Allows textarea settings fields within the WordPress customizer.
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Customize_Control_Textarea extends WP_Customize_Control {

  /**
   * The type of customize control being rendered.
   *
   * @since 2.7.0
   * @access public
   *
   * @var string
   */
  public $type = 'textarea';

  /**
   * Render Content
   *
   * Displays the textarea on the customize screen.
   *
   * @link http://codex.wordpress.org/Function_Reference/esc_html
   * @link http://codex.wordpress.org/Function_Reference/esc_textarea
   *
   * @since 2.7.0
   * @access public
   *
   * @return void
   */
  public function render_content() {
    ?>

    <!-- Begin Markup -->

    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
      <div class="customize-control-content">
        <textarea class="widefat" cols="45" rows="5" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
      </div><!-- .customize-control-content -->
    </label>

    <!-- End Markup -->
  <?php
  } // end function render_content()

} // end class ExMachina_Customize_Control_Textarea