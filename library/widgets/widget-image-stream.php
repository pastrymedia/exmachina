<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Image Stream Widget
 *
 * widget-image-stream.php
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
 * Image Stream Widget Class
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Widget_Image_Stream extends WP_Widget {

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
      'classname' => 'image-stream',
      'description' => __( 'Displays image thumbnails in a gallery-like format.', 'exmachina-core' )
    );

    /* Set up the widget control options. */
    $control_options = array(
      'width' => 200,
      'height' => 350,
      'id_base' => 'image-stream'
    );

    /* Create the widget. */
    $this->WP_Widget( 'image-stream', __( 'Image Stream', 'exmachina-core' ), $widget_options, $control_options );

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

    /* Output the theme's $before_widget wrapper. */
    echo $before_widget;

    /* If a title was input by the user, display it. */
    if ( !empty( $instance['title'] ) )
      echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

    $loop = new WP_Query(
      array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'post_status' => 'inherit',
        'posts_per_page' => intval( $instance['posts_per_page'] ),
        'orderby' => 'parent'
      )
    );

    if ( $loop->have_posts() ) {

      /* Set up some default variables to use in the gallery. */
      $gallery_columns = 3;
      $gallery_iterator = 0;

      echo '<div class="gallery">';

      while ( $loop->have_posts() ) {

        $loop->the_post();

        if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns == 0 ) echo '<div class="gallery-row gallery-clear">';  ?>

            <div class="gallery-item col-<?php echo esc_attr( $gallery_columns ); ?>">
              <div class="gallery-icon">
                <?php get_the_image( array( 'size' => 'thumbnail', 'meta_key' => false, 'default_image' => trailingslashit( EXMACHINA_IMAGES ) . 'thumbnail-default.png' ) ); ?>
              </div>
            </div>

        <?php if ( $gallery_columns > 0 && ++$gallery_iterator % $gallery_columns == 0 ) echo '</div>';
      }

      if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns !== 0 ) echo '</div>';

      echo '</div>';
    }

    else {
      echo '<p>' . __( 'There are currently no images found.', 'exmachina-core' ) . '</p>';
    }

    wp_reset_query();

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

    $instance = $new_instance;

    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['posts_per_page'] = intval( $new_instance['posts_per_page'] );

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
      'title' => esc_attr__( 'Image Stream', 'exmachina-core' ),
      'posts_per_page' => 6,
    );

    /* Merge the user-selected arguments with the defaults. */
    $instance = wp_parse_args( (array) $instance, $defaults );

    ?>

    <div class="exmachina-widget-controls columns-1">
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Limit:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo esc_attr( $instance['posts_per_page'] ); ?>" />
    </p>
    </div>
    <div style="clear:both;">&nbsp;</div>
    <?php

  } // end function form()

} // end class ExMachina_Widget_Image_Stream