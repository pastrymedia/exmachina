<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Archives Widget
 *
 * widget-archives.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * The Archives widget replaces the default WordPress Archives widget. This version
 * gives total control over the output to the user by allowing the input of all the
 * arguments typically seen in the wp_get_archives() function.
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
 * Archives Widget Class
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Widget_Archives extends WP_Widget {

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
      'classname'   => 'archives',
      'description' => esc_html__( 'An advanced widget that gives you total control over the output of your archives.', 'exmachina-core' )
    );

    /* Set up the widget control options. */
    $control_options = array(
      'width'  => 525,
      'height' => 350
    );

    /* Create the widget. */
    $this->WP_Widget(
      'exmachina-archives',               // $this->id_base
      __( 'Archives', 'exmachina-core' ), // $this->name
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
   * @param  array $sidebar   The array of form elements
   * @param  array $instance  The current instance of the widget
   * @return void
   */
  function widget( $sidebar, $instance ) {
    extract( $sidebar );

    /* Set the $args for wp_get_archives() to the $instance array. */
    $args = $instance;

    /* Overwrite the $echo argument and set it to false. */
    $args['echo'] = false;

    /* Output the theme's $before_widget wrapper. */
    echo $before_widget;

    /* If a title was input by the user, display it. */
    if ( !empty( $instance['title'] ) )
      echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

    /* Get the archives list. */
    $archives = str_replace( array( "\r", "\n", "\t" ), '', wp_get_archives( $args ) );

    /* If the archives should be shown in a <select> drop-down. */
    if ( 'option' == $args['format'] ) {

      /* Create a title for the drop-down based on the archive type. */
      if ( 'yearly' == $args['type'] )
        $option_title = esc_html__( 'Select Year', 'exmachina-core' );

      elseif ( 'monthly' == $args['type'] )
        $option_title = esc_html__( 'Select Month', 'exmachina-core' );

      elseif ( 'weekly' == $args['type'] )
        $option_title = esc_html__( 'Select Week', 'exmachina-core' );

      elseif ( 'daily' == $args['type'] )
        $option_title = esc_html__( 'Select Day', 'exmachina-core' );

      elseif ( 'postbypost' == $args['type'] || 'alpha' == $args['type'] )
        $option_title = esc_html__( 'Select Post', 'exmachina-core' );

      /* Output the <select> element and each <option>. */
      echo '<p><select name="archive-dropdown" onchange=\'document.location.href=this.options[this.selectedIndex].value;\'>';
        echo '<option value="">' . $option_title . '</option>';
        echo $archives;
      echo '</select></p>';
    }

    /* If the format should be an unordered list. */
    elseif ( 'html' == $args['format'] ) {
      echo '<ul class="xoxo archives">' . $archives . '</ul><!-- .xoxo .archives -->';
    }

    /* All other formats. */
    else {
      echo $archives;
    }

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

    $instance = $new_instance;

    $instance['title']  = strip_tags( $new_instance['title'] );
    $instance['before'] = strip_tags( $new_instance['before'] );
    $instance['after']  = strip_tags( $new_instance['after'] );
    $instance['limit']  = strip_tags( $new_instance['limit'] );

    $instance['show_post_count'] = ( isset( $new_instance['show_post_count'] ) ? 1 : 0 );

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
      'title'           => esc_attr__( 'Archives', 'exmachina-core' ),
      'limit'           => 10,
      'type'            => 'monthly',
      'order'           => 'DESC',
      'format'          => 'html',
      'before'          => '',
      'after'           => '',
      'show_post_count' => false
    );

    /* Merge the user-selected arguments with the defaults. */
    $instance = wp_parse_args( (array) $instance, $defaults );

    /* Create an array of archive types. */
    $type = array(
      'alpha'      => esc_attr__( 'Alphabetical', 'exmachina-core' ),
      'daily'      => esc_attr__( 'Daily', 'exmachina-core' ),
      'monthly'    => esc_attr__( 'Monthly', 'exmachina-core' ),
      'postbypost' => esc_attr__( 'Post By Post', 'exmachina-core' ),
      'weekly'     => esc_attr__( 'Weekly', 'exmachina-core' ),
      'yearly'     => esc_attr__( 'Yearly', 'exmachina-core' )
    );

    /* Create an array of order options. */
    $order = array(
      'ASC'  => esc_attr__( 'Ascending', 'exmachina-core' ),
      'DESC' => esc_attr__( 'Descending', 'exmachina-core' )
    );

    /* Create an array of archive formats. */
    $format = array(
      'custom' => esc_attr__( 'Custom', 'exmachina-core' ),
      'html'   => esc_attr__( 'HTML', 'exmachina-core' ),
      'option' => esc_attr__( 'Option', 'exmachina-core' )
    );
    ?>

    <div class="exmachina-widget-controls columns-2">
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><code>limit</code></label>
      <input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo esc_attr( $instance['limit'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'type' ); ?>"><code>type</code></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>">
        <?php foreach ( $type as $option_value => $option_label ) { ?>
          <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['type'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
        <?php } ?>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'order' ); ?>"><code>order</code></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
        <?php foreach ( $order as $option_value => $option_label ) { ?>
          <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['order'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
        <?php } ?>
      </select>
    </p>
    </div>

    <div class="exmachina-widget-controls columns-2 column-last">
    <p>
      <label for="<?php echo $this->get_field_id( 'format' ); ?>"><code>format</code></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'format' ); ?>" name="<?php echo $this->get_field_name( 'format' ); ?>">
        <?php foreach ( $format as $option_value => $option_label ) { ?>
          <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['format'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
        <?php } ?>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'before' ); ?>"><code>before</code></label>
      <input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'before' ); ?>" name="<?php echo $this->get_field_name( 'before' ); ?>" value="<?php echo esc_attr( $instance['before'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'after' ); ?>"><code>after</code></label>
      <input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'after' ); ?>" name="<?php echo $this->get_field_name( 'after' ); ?>" value="<?php echo esc_attr( $instance['after'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'show_post_count' ); ?>">
      <input class="checkbox" type="checkbox" <?php checked( $instance['show_post_count'], true ); ?> id="<?php echo $this->get_field_id( 'show_post_count' ); ?>" name="<?php echo $this->get_field_name( 'show_post_count' ); ?>" /> <?php _e( 'Show post count?', 'exmachina-core' ); ?> <code>show_post_count</code></label>
    </p>
    </div>
    <div style="clear:both;">&nbsp;</div>
    <?php

  } // end function form()

} // end class ExMachina_Widget_Archives