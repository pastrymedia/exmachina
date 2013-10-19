<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Gallery Post Format Widget
 *
 * widget-gallery-posts.php
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
 * Gallery Post Format Widget Class
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Widget_Gallery_Posts extends WP_Widget {

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
      'classname' => 'exmachina-gallery-posts',
      'description' => esc_html__( 'Displays posts from the "gallery" post format.', 'exmachina-core' )
    );

    /* Set up the widget control options. */
    $control_options = array(
      'width' => 200,
      'height' => 350
    );

    /* Create the widget. */
    $this->WP_Widget(
      'exmachina-gallery-posts',    // $this->id_base
      __( 'Galleries', 'exmachina-core' ),    // $this->name
      $widget_options,      // $this->widget_options
      $control_options      // $this->control_options
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

    /* Output the theme's $before_widget wrapper. */
    echo $before_widget;

    /* If a title was input by the user, display it. */
    if ( !empty( $instance['title'] ) )
      echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

    $loop = new WP_Query(
      array(
        'posts_per_page' => $instance['posts_per_page'],
        'tax_query' => array(
          array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => array( 'post-format-gallery' )
          )
        )
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
                <?php get_the_image( array( 'image_scan' => true, 'size' => 'thumbnail', 'meta_key' => false, 'default_image' => trailingslashit( EXMACHINA_IMAGES ) . 'thumbnail-default.png' ) ); ?>
              </div>
            </div>

      <?php if ( $gallery_columns > 0 && ++$gallery_iterator % $gallery_columns == 0 ) echo '</div>';

      }

      if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns !== 0 ) echo '</div>';

      echo '</div>';
    }

    wp_reset_query();

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

    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );

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
      'title' => esc_attr__( 'Galleries', 'exmachina-core' ),
      'posts_per_page' => 9,
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
      <input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo esc_attr( $instance['posts_per_page'] ); ?>" />
    </p>
    </div>
    <div style="clear:both;">&nbsp;</div>
    <?php

  } // end function form()

} // end class ExMachina_Widget_Gallery_Posts