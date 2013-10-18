<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Authors Widget
 *
 * widget-authors.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * The authors widget was created to give users the ability to list the authors
 * of their blog because there was no equivalent WordPress widget that offered
 * the functionality. This widget allows full control over its output by giving
 * access to the parameters of wp_list_authors().
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
 * Authors Widget Class
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Widget_Authors extends WP_Widget {

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
      'classname'   => 'authors',
      'description' => esc_html__( 'An advanced widget that gives you total control over the output of your author lists.', 'exmachina-core' )
    );

    /* Set up the widget control options. */
    $control_options = array(
      'width'  => 525,
      'height' => 350
    );

    /* Create the widget. */
    $this->WP_Widget(
      'exmachina-authors',               // $this->id_base
      __( 'Authors', 'exmachina-core' ), // $this->name
      $widget_options,                // $this->widget_options
      $control_options                // $this->control_options
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

    /* Set the $args for wp_list_authors() to the $instance array. */
    $args = $instance;

    /* Overwrite the $echo argument and set it to false. */
    $args['echo'] = false;

    /* Output the theme's $before_widget wrapper. */
    echo $before_widget;

    /* If a title was input by the user, display it. */
    if ( !empty( $instance['title'] ) )
      echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

    /* Get the authors list. */
    $authors = str_replace( array( "\r", "\n", "\t" ), '', wp_list_authors( $args ) );

    /* If 'list' is the style and the output should be HTML, wrap the authors in a <ul>. */
    if ( 'list' == $args['style'] && $args['html'] )
      $authors = '<ul class="xoxo authors">' . $authors . '</ul><!-- .xoxo .authors -->';

    /* If 'none' is the style and the output should be HTML, wrap the authors in a <p>. */
    elseif ( 'none' == $args['style'] && $args['html'] )
      $authors = '<p class="authors">' . $authors . '</p><!-- .authors -->';

    /* Display the authors list. */
    echo $authors;

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

    $instance = $old_instance;

    $instance = $new_instance;

    $instance['title']   = strip_tags( $new_instance['title'] );
    $instance['feed']    = strip_tags( $new_instance['feed'] );
    $instance['order']   = strip_tags( $new_instance['order'] );
    $instance['orderby'] = strip_tags( $new_instance['orderby'] );
    $instance['number']  = strip_tags( $new_instance['number'] );

    $instance['html']          = ( isset( $new_instance['html'] ) ? 1 : 0 );
    $instance['optioncount']   = ( isset( $new_instance['optioncount'] ) ? 1 : 0 );
    $instance['exclude_admin'] = ( isset( $new_instance['exclude_admin'] ) ? 1 : 0 );
    $instance['show_fullname'] = ( isset( $new_instance['show_fullname'] ) ? 1 : 0 );
    $instance['hide_empty']    = ( isset( $new_instance['hide_empty'] ) ? 1 : 0 );

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
      'title'         => esc_attr__( 'Authors', 'exmachina-core' ),
      'order'         => 'ASC',
      'orderby'       => 'display_name',
      'number'        => '',
      'optioncount'   => false,
      'exclude_admin' => false,
      'show_fullname' => true,
      'hide_empty'    => true,
      'style'         => 'list',
      'html'          => true,
      'feed'          => '',
      'feed_image'    => ''
    );

    /* Merge the user-selected arguments with the defaults. */
    $instance = wp_parse_args( (array) $instance, $defaults );

    $order = array(
      'ASC'  => esc_attr__( 'Ascending', 'exmachina-core' ),
      'DESC' => esc_attr__( 'Descending', 'exmachina-core' )
    );

    $orderby = array(
      'display_name' => esc_attr__( 'Display Name', 'exmachina-core' ),
      'email'        => esc_attr__( 'Email', 'exmachina-core' ),
      'ID'           => esc_attr__( 'ID', 'exmachina-core' ),
      'nicename'     => esc_attr__( 'Nice Name', 'exmachina-core' ),
      'post_count'   => esc_attr__( 'Post Count', 'exmachina-core' ),
      'registered'   => esc_attr__( 'Registered', 'exmachina-core' ),
      'url'          => esc_attr__( 'URL', 'exmachina-core' ),
      'user_login'   => esc_attr__( 'Login', 'exmachina-core' )
    );

    ?>

    <div class="exmachina-widget-controls columns-2">
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'order' ); ?>"><code>order</code></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
        <?php foreach ( $order as $option_value => $option_label ) { ?>
          <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['order'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
        <?php } ?>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><code>orderby</code></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
        <?php foreach ( $orderby as $option_value => $option_label ) { ?>
          <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['orderby'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
        <?php } ?>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'number' ); ?>"><code>number</code></label>
      <input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo esc_attr( $instance['number'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'style' ); ?>"><code>style</code></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
        <?php foreach ( array( 'list' => esc_attr__( 'List', 'exmachina-core'), 'none' => esc_attr__( 'None', 'exmachina-core' ) ) as $option_value => $option_label ) { ?>
          <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['style'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
        <?php } ?>
      </select>
    </p>
    </div>

    <div class="exmachina-widget-controls columns-2 column-last">
    <p>
      <label for="<?php echo $this->get_field_id( 'feed' ); ?>"><code>feed</code></label>
      <input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'feed' ); ?>" name="<?php echo $this->get_field_name( 'feed' ); ?>" value="<?php echo esc_attr( $instance['feed'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'feed_image' ); ?>"><code>feed_image</code></label>
      <input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'feed_image' ); ?>" name="<?php echo $this->get_field_name( 'feed_image' ); ?>" value="<?php echo esc_attr( $instance['feed_image'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'html' ); ?>">
      <input class="checkbox" type="checkbox" <?php checked( $instance['html'], true ); ?> id="<?php echo $this->get_field_id( 'html' ); ?>" name="<?php echo $this->get_field_name( 'html' ); ?>" /> <?php _e( '<acronym title="Hypertext Markup Language">HTML</acronym>?', 'exmachina-core' ); ?> <code>html</code></label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'optioncount' ); ?>">
      <input class="checkbox" type="checkbox" <?php checked( $instance['optioncount'], true ); ?> id="<?php echo $this->get_field_id( 'optioncount' ); ?>" name="<?php echo $this->get_field_name( 'optioncount' ); ?>" /> <?php _e( 'Show post count?', 'exmachina-core' ); ?> <code>optioncount</code></label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'exclude_admin' ); ?>">
      <input class="checkbox" type="checkbox" <?php checked( $instance['exclude_admin'], true ); ?> id="<?php echo $this->get_field_id( 'exclude_admin' ); ?>" name="<?php echo $this->get_field_name( 'exclude_admin' ); ?>" /> <?php _e( 'Exclude admin?', 'exmachina-core' ); ?> <code>exclude_admin</code></label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'show_fullname' ); ?>">
      <input class="checkbox" type="checkbox" <?php checked( $instance['show_fullname'], true ); ?> id="<?php echo $this->get_field_id( 'show_fullname' ); ?>" name="<?php echo $this->get_field_name( 'show_fullname' ); ?>" /> <?php _e( 'Show full name?', 'exmachina-core' ); ?> <code>show_fullname</code></label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'hide_empty' ); ?>">
      <input class="checkbox" type="checkbox" <?php checked( $instance['hide_empty'], true ); ?> id="<?php echo $this->get_field_id( 'hide_empty' ); ?>" name="<?php echo $this->get_field_name( 'hide_empty' ); ?>" /> <?php _e( 'Hide empty?', 'exmachina-core' ); ?> <code>hide_empty</code></label>
    </p>
    </div>
    <div style="clear:both;">&nbsp;</div>
    <?php
  } // end function form()

} // end class ExMachina_Widget_Authors