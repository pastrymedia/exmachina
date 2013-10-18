<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * List Sub-Pages Widget
 *
 * widget-list-sub-pages.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * DESCRIPTION
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
 * List Sub-Pages Widget Class
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Widget_List_Sub_Pages extends WP_Widget {

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
      'classname' => 'list-sub-pages',
      'description' => __( 'Displays the sub-pages of the current page. Widget only appears if there are sub-pages of the current page.', 'exmachina-core' )
    );

    /* Set up the widget control options. */
    $control_options = array(
      'width' => 250,
      'height' => 350,
      'id_base' => 'list-sub-pages'
    );

    /* Create the widget. */
    $this->WP_Widget( 'list-sub-pages', __( 'List Sub-Pages', 'exmachina-core' ),   $widget_options, $control_options
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

    /* Only display widget if viewing a page. */
    if ( !is_page() )
      return;

    /* Get the queried post object. */
    $post = get_queried_object();

    /* If the post does not have a parent, get the list based off the current post. */
    if ( 0 >= $post->post_parent ) {
      $children = wp_list_pages( array( 'child_of' => get_queried_object_id(), 'echo' => false, 'title_li' => false ) );
    }

    /* Else, check for post ancestors and get the top-level post. */
    elseif ( $post->ancestors ) {
      $ancestors = $post->ancestors;
      $ancestors = end( $ancestors );
      $children = wp_list_pages( array( 'child_of' => $ancestors, 'title_li' => false, 'echo' => false ) );
    }

    /* If no children posts were found, return. */
    if ( empty( $children ) )
      return;

    /* Output the theme's $before_widget wrapper. */
    echo $before_widget;

    /* If a title was input by the user, display it. */
    if ( !empty( $instance['title'] ) )
      echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

    /* Display the sub-pages list. */
    echo '<ul class="xoxo">' . $children . '</ul>';

    /* Output the theme's $after_widget wrapper. */
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

    /* Set the instance to the new instance. */
    $instance = $new_instance;

    /* Strip tags from elements that don't need them. */
    $instance['title'] = strip_tags( $new_instance['title'] );

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

    /* Set up the defaults. */
    $defaults = array(
      'title' => __( 'Sub Pages', 'exmachina-core' )
    );

    $instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <div>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
    </p>
    </div>

    <div style="clear:both;">&nbsp;</div>
    <?php

  } // end function form()

} // end class ExMachina_Widget_List_Sub_Pages