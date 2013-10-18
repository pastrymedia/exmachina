<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Calendar Widget
 *
 * widget-calendar.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * The calendar widget was created to give users the ability to show a post
 * calendar for their blog using all the available options given in the
 * get_calendar() function. It replaces the default WordPress calendar widget.
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
 * Calendar Widget Class
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Widget_Calendar extends WP_Widget {

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
      'classname'   => 'calendar',
      'description' => esc_html__( 'An advanced widget that gives you total control over the output of your calendar.', 'exmachina-core' )
    );

    /* Set up the widget control options. */
    $control_options = array(
      'width'  => 200,
      'height' => 350
    );

    /* Create the widget. */
    $this->WP_Widget(
      'exmachina-calendar',               // $this->id_base
      __( 'Calendar', 'exmachina-core' ), // $this->name
      $widget_options,                 // $this->widget_options
      $control_options                 // $this->control_options
    );

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

    /* Get the $initial argument. */
    $initial = !empty( $instance['initial'] ) ? true : false;

    /* Output the theme's widget wrapper. */
    echo $before_widget;

    /* If a title was input by the user, display it. */
    if ( !empty( $instance['title'] ) )
      echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

    /* Display the calendar. */
    echo '<div class="calendar-wrap">';
      echo str_replace( array( "\r", "\n", "\t" ), '', get_calendar( $initial, false ) );
    echo '</div><!-- .calendar-wrap -->';

    /* Close the theme's widget wrapper. */
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

    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['initial'] = ( isset( $new_instance['initial'] ) ? 1 : 0 );

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

    /* Set up the default form values. */
    $defaults = array(
      'title'   => esc_attr__( 'Calendar', 'exmachina-core' ),
      'initial' => false
    );

    /* Merge the user-selected arguments with the defaults. */
    $instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <div class="exmachina-widget-controls columns-1">
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>
    <p>
      <input class="checkbox" type="checkbox" <?php checked( $instance['initial'], true ); ?> id="<?php echo $this->get_field_id( 'initial' ); ?>" name="<?php echo $this->get_field_name( 'initial' ); ?>" />
      <label for="<?php echo $this->get_field_id( 'initial' ); ?>"><?php _e( 'One-letter abbreviation?', 'exmachina-core' ); ?> <code>initial</code></label>
    </p>
    </div>
    <?php

  } // end function form()

} // end class ExMachina_Widget_Calendar