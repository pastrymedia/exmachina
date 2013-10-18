<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Newsletter Widget
 *
 * widget-newsletter.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Newsletter widget. Provies a subscribe form for integration with
 * Google/Feedburner.
 *
 * @package     ExMachina
 * @subpackage  Widgets
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin widget
###############################################################################

/**
 * Newsletter Widget Class
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Widget_Newsletter extends WP_Widget {

  /**
   * Widget Constructor
   *
   * Specifies the widget's unique name, ID, classname, description, and other
   * options.
   *
   * @since 2.7.0
   * @access public
   *
   * @return void
   */
  function __construct() {

    /* Set up the widget options. */
    $widget_options = array(
      'classname' => 'newsletter',
      'description' => __( 'Displays a subscription form for your Google/Feedburner account.', 'exmachina-core' )
    );

    /* Set up the widget control options. */
    $control_options = array(
      'width' => 200,
      'height' => 350,
      'id_base' => 'newsletter'
    );

    /* Create the widget. */
    $this->WP_Widget( 'newsletter', __( 'Newsletter', 'exmachina-core' ), $widget_options, $control_options );

  } // end function __construct()

  /**
   * Widget API
   *
   * Outputs the widget based on the arguments input through the widget controls.
   *
   * @since 2.7.0
   * @access public
   *
   * @param  array $args      The array of form elements
   * @param  array $instance  The current instance of the widget
   * @return void
   */
  function widget( $sidebar, $instance ) {
    extract( $sidebar );

    echo $before_widget;

    if ( $instance['title'] )
      echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title; ?>

    <div class="newsletter-wrap">
    <form action="http://feedburner.google.com/fb/a/mailverify" method="post">
    <p>
      <input class="newsletter-text" type="text" name="email" value="<?php echo esc_attr( $instance['input_text'] ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
      <input class="newsletter-submit" type="submit" value="<?php echo esc_attr( $instance['submit_text'] ); ?>" />
      <input type="hidden" value="<?php echo esc_attr( $instance['id'] ); ?>" name="uri" />
      <input type="hidden" name="loc" value="en_US" />
    </p>
    </form>
    </div><?php

    echo $after_widget;

  } // end function widget()

  /**
   * Update Widget
   *
   * Updates the widget control options for the particular instance of the widget.
   *
   * @since 2.7.0
   * @access public
   *
   * @param  array $new_instance The new instance of values to be generated via the update.
   * @param  array $old_instance The previous instance of values before the update.
   * @return array               The instance values.
   */
  function update( $new_instance, $old_instance ) {

    $instance = $old_instance;

    $instance = $new_instance;

    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['id'] = strip_tags( $new_instance['id'] );
    $instance['input_text'] = strip_tags( $new_instance['input_text'] );
    $instance['submit_text'] = strip_tags( $new_instance['submit_text'] );

    return $instance;

  } // end function update()

  /**
   * Widget Form
   *
   * Generates the administration form for the widget.
   *
   * @since 2.7.0
   * @access public
   *
   * @param  array $instance The array of keys and values for the widget.
   * @return void
   */
  function form( $instance ) {

    //Defaults
    $defaults = array(
      'title' => __( 'Newsletter', 'exmachina-core' ),
      'input_text' => __( 'you@site.com', 'exmachina-core' ),
      'submit_text' => __( 'Subscribe', 'exmachina-core' ),
      'id' => ''
    );
    $instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <div class="exmachina-widget-controls columns-1">
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Google/Feedburner ID:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo esc_attr( $instance['id'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'input_text' ); ?>"><?php _e( 'Input Text:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'input_text' ); ?>" name="<?php echo $this->get_field_name( 'input_text' ); ?>" value="<?php echo esc_attr( $instance['input_text'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'submit_text' ); ?>"><?php _e( 'Submit Text:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'submit_text' ); ?>" name="<?php echo $this->get_field_name( 'submit_text' ); ?>" value="<?php echo esc_attr( $instance['submit_text'] ); ?>" />
    </p>
    </div>
    <div style="clear:both;">&nbsp;</div>
    <?php

  } // end function form()

} // end class ExMachina_Widget_Newsletter