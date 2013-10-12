<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Featured Page Widget
 *
 * featured-page-widget.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
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
 * ExMachina Featured Page Widget Class
 *
 * @link http://codex.wordpress.org/Widgets_API
 *
 * @since 0.5.0
 */
class ExMachina_Featured_Page extends WP_Widget {

  /**
   * Widget Defaults
   *
   * Holds widget settings defaults, populated in constructor.
   *
   * @since 0.5.0
   * @var array
   */
  protected $defaults;

  /**
   * Widget Constructor
   *
   * Specifies the classname and description, set the default widget options,
   * and instantiates the widget.
   *
   * @since 0.5.0
   */
  function __construct() {

    /* Setup the widget defaults. */
    $this->defaults = array(
      'title'           => '',
      'page_id'         => '',
      'show_image'      => 0,
      'image_alignment' => '',
      'image_size'      => '',
      'show_title'      => 0,
      'show_content'    => 0,
      'content_limit'   => '',
      'more_text'       => '',
    );

    /* Setup widget classname and description. */
    $widget_ops = array(
      'classname'   => 'featured-content featuredpage',
      'description' => __( 'Displays featured page with thumbnails', 'exmachina' ),
    );

    /* Set the control options. */
    $control_ops = array(
      'id_base' => 'featured-page',
      'width'   => 200,
      'height'  => 250,
    );

    /* Initialize the widget. */
    parent::__construct( 'featured-page', __( 'ExMachina - Featured Page', 'exmachina' ), $widget_ops, $control_ops );

  } // end function __construct()

  /**
   * Widget API
   *
   * Outputs the content of the widget.
   *
   * @todo remvoe html5 dependency
   * @todo update exmachina markup
   * @todo inline comment
   *
   * @link http://codex.wordpress.org/Class_Reference/WP_Query
   * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
   * @link http://codex.wordpress.org/Function_Reference/have_posts
   * @link http://codex.wordpress.org/Function_Reference/the_post
   * @link http://codex.wordpress.org/Function_Reference/get_post_class
   * @link http://codex.wordpress.org/Function_Reference/get_permalink
   * @link http://codex.wordpress.org/Function_Reference/the_title_attribute
   * @link http://codex.wordpress.org/Function_Reference/esc_attr
   * @link http://codex.wordpress.org/Function_Reference/get_the_title
   * @link http://codex.wordpress.org/Function_Reference/the_content
   * @link http://codex.wordpress.org/Function_Reference/wp_reset_query
   *
   * @uses exmachina_markup() [description]
   * @uses exmachina_get_image() [description]
   * @uses exmachina_parse_attr() [description]
   * @uses the_content_limit() [description]
   *
   * @since 0.5.0
   * @access public
   *
   * @global object $wp_query WP_Query query object
   * @param  array  $args     The array of form elements
   * @param  array  $instance The current instance of the widget
   */
  function widget( $args, $instance ) {
    global $wp_query;

    extract( $args );

    //* Merge with defaults
    $instance = wp_parse_args( (array) $instance, $this->defaults );

    echo $before_widget;

    //* Set up the author bio
    if ( ! empty( $instance['title'] ) )
      echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

    $wp_query = new WP_Query( array( 'page_id' => $instance['page_id'] ) );

    if ( have_posts() ) : while ( have_posts() ) : the_post();

      exmachina_markup( array(
        'html5'   => '<article %s>',
        'xhtml'   => sprintf( '<div class="%s">', implode( ' ', get_post_class() ) ),
        'context' => 'entry',
      ) );

      $image = exmachina_get_image( array(
        'format'  => 'html',
        'size'    => $instance['image_size'],
        'context' => 'featured-page-widget',
        'attr'    => exmachina_parse_attr( 'entry-image-widget' ),
      ) );

      if ( $instance['show_image'] && $image )
        printf( '<a href="%s" title="%s" class="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), esc_attr( $instance['image_alignment'] ), $image );

      if ( ! empty( $instance['show_title'] ) ) {

        if ( exmachina_html5() )
          printf( '<header class="entry-header"><h2 class="entry-title"><a href="%s" title="%s">%s</a></h2></header>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );
        else
          printf( '<h2><a href="%s" title="%s">%s</a></h2>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );

      }

      if ( ! empty( $instance['show_content'] ) ) {

        echo exmachina_html5() ? '<div class="entry-content">' : '';

        if ( empty( $instance['content_limit'] ) ) {

          global $more;
          $more = 0;

          the_content( $instance['more_text'] );

        } else {
          the_content_limit( (int) $instance['content_limit'], esc_html( $instance['more_text'] ) );
        }

        echo exmachina_html5() ? '</div>' : '';

      }

      exmachina_markup( array(
        'html5' => '</article>',
        'xhtml' => '</div>',
      ) );

      endwhile;
    endif;

    //* Restore original query
    wp_reset_query();

    echo $after_widget;

  } // end function widget()

  /**
   * Widget Update
   *
   * Processes the widget's options to be saved.
   *
   * @since 0.5.0
   * @access public
   *
   * @param  array $new_instance The new instance of values to be generated via the update.
   * @param  array $old_instance The previous instance of values before the update.
   * @return array               Settings to save.
   */
  function update( $new_instance, $old_instance ) {

    $new_instance['title']     = strip_tags( $new_instance['title'] );
    $new_instance['more_text'] = strip_tags( $new_instance['more_text'] );

    /* Return the new instance. */
    return $new_instance;

  } // end function update()

  /**
   * Widget Form
   *
   * Generates the administration form for the widget.
   *
   * @todo inline comment
   * @todo docblock comments
   *
   * @since 0.5.0
   * @access public
   *
   * @param  array $instance The array of keys and values for the widget.
   */
  function form( $instance ) {

    //* Merge with defaults
    $instance = wp_parse_args( (array) $instance, $this->defaults );

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'exmachina' ); ?>:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php _e( 'Page', 'exmachina' ); ?>:</label>
      <?php wp_dropdown_pages( array( 'name' => $this->get_field_name( 'page_id' ), 'selected' => $instance['page_id'] ) ); ?>
    </p>

    <hr class="div" />

    <p>
      <input id="<?php echo $this->get_field_id( 'show_image' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_image' ); ?>" value="1"<?php checked( $instance['show_image'] ); ?> />
      <label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Show Featured Image', 'exmachina' ); ?></label>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image Size', 'exmachina' ); ?>:</label>
      <select id="<?php echo $this->get_field_id( 'image_size' ); ?>" class="exmachina-image-size-selector" name="<?php echo $this->get_field_name( 'image_size' ); ?>">
        <option value="thumbnail">thumbnail (<?php echo absint( get_option( 'thumbnail_size_w' ) ); ?>x<?php echo absint( get_option( 'thumbnail_size_h' ) ); ?>)</option>
        <?php
        $sizes = exmachina_get_additional_image_sizes();
        foreach ( (array) $sizes as $name => $size )
          echo '<option value="' . esc_attr( $name ) . '" ' . selected( $name, $instance['image_size'], FALSE ) . '>' . esc_html( $name ) . ' (' . absint( $size['width'] ) . 'x' . absint( $size['height'] ) . ')</option>';
        ?>
      </select>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'image_alignment' ); ?>"><?php _e( 'Image Alignment', 'exmachina' ); ?>:</label>
      <select id="<?php echo $this->get_field_id( 'image_alignment' ); ?>" name="<?php echo $this->get_field_name( 'image_alignment' ); ?>">
        <option value="alignnone">- <?php _e( 'None', 'exmachina' ); ?> -</option>
        <option value="alignleft" <?php selected( 'alignleft', $instance['image_alignment'] ); ?>><?php _e( 'Left', 'exmachina' ); ?></option>
        <option value="alignright" <?php selected( 'alignright', $instance['image_alignment'] ); ?>><?php _e( 'Right', 'exmachina' ); ?></option>
      </select>
    </p>

    <hr class="div" />

    <p>
      <input id="<?php echo $this->get_field_id( 'show_title' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_title' ); ?>" value="1"<?php checked( $instance['show_title'] ); ?> />
      <label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Page Title', 'exmachina' ); ?></label>
    </p>

    <p>
      <input id="<?php echo $this->get_field_id( 'show_content' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_content' ); ?>" value="1"<?php checked( $instance['show_content'] ); ?> />
      <label for="<?php echo $this->get_field_id( 'show_content' ); ?>"><?php _e( 'Show Page Content', 'exmachina' ); ?></label>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'content_limit' ); ?>"><?php _e( 'Content Character Limit', 'exmachina' ); ?>:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'content_limit' ); ?>" name="<?php echo $this->get_field_name( 'content_limit' ); ?>" value="<?php echo esc_attr( $instance['content_limit'] ); ?>" size="3" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'more_text' ); ?>"><?php _e( 'More Text', 'exmachina' ); ?>:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'more_text' ); ?>" name="<?php echo $this->get_field_name( 'more_text' ); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>" />
    </p>
    <?php

  } // end function form()
} // end class ExMachina_Featured_Page