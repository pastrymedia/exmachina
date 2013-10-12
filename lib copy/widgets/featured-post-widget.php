<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Featured Post Widget
 *
 * featured-post-widget.php
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
 * ExMachina Featured Post Widget Class
 *
 * @link http://codex.wordpress.org/Widgets_API
 *
 * @since 0.5.0
 */
class ExMachina_Featured_Post extends WP_Widget {

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
      'title'                   => '',
      'posts_cat'               => '',
      'posts_num'               => 1,
      'posts_offset'            => 0,
      'orderby'                 => '',
      'order'                   => '',
      'exclude_displayed'       => 0,
      'show_image'              => 0,
      'image_alignment'         => '',
      'image_size'              => '',
      'show_gravatar'           => 0,
      'gravatar_alignment'      => '',
      'gravatar_size'           => '',
      'show_title'              => 0,
      'show_byline'             => 0,
      'post_info'               => '[post_date] ' . __( 'By', 'exmachina' ) . ' [post_author_posts_link] [post_comments]',
      'show_content'            => 'excerpt',
      'content_limit'           => '',
      'more_text'               => __( '[Read More...]', 'exmachina' ),
      'extra_num'               => '',
      'extra_title'             => '',
      'more_from_category'      => '',
      'more_from_category_text' => __( 'More Posts from this Category', 'exmachina' ),
    );

    /* Setup widget classname and description. */
    $widget_ops = array(
      'classname'   => 'featured-content featuredpost',
      'description' => __( 'Displays featured posts with thumbnails', 'exmachina' ),
    );

    /* Set the control options. */
    $control_ops = array(
      'id_base' => 'featured-post',
      'width'   => 505,
      'height'  => 350,
    );

    /* Initialize the widget. */
    parent::__construct( 'featured-post', __( 'ExMachina - Featured Posts', 'exmachina' ), $widget_ops, $control_ops );

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
   * @link http://codex.wordpress.org/Function_Reference/get_the_ID
   * @link http://codex.wordpress.org/Function_Reference/get_post_class
   * @link http://codex.wordpress.org/Function_Reference/get_permalink
   * @link http://codex.wordpress.org/Function_Reference/the_title_attribute
   * @link http://codex.wordpress.org/Function_Reference/esc_attr
   * @link http://codex.wordpress.org/Function_Reference/get_avatar
   * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
   * @link http://codex.wordpress.org/Function_Reference/do_shortcode
   * @link http://codex.wordpress.org/Function_Reference/get_the_title
   * @link http://codex.wordpress.org/Function_Reference/the_content
   * @link http://codex.wordpress.org/Function_Reference/wp_reset_query
   * @link http://codex.wordpress.org/Function_Reference/get_category_link
   * @link http://codex.wordpress.org/Function_Reference/get_cat_name
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
    global $wp_query, $_exmachina_displayed_ids;

    extract( $args );

    //* Merge with defaults
    $instance = wp_parse_args( (array) $instance, $this->defaults );

    echo $before_widget;

    //* Set up the author bio
    if ( ! empty( $instance['title'] ) )
      echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

    $query_args = array(
      'post_type' => 'post',
      'cat'       => $instance['posts_cat'],
      'showposts' => $instance['posts_num'],
      'offset'    => $instance['posts_offset'],
      'orderby'   => $instance['orderby'],
      'order'     => $instance['order'],
    );

    //* Exclude displayed IDs from this loop?
    if ( $instance['exclude_displayed'] )
      $query_args['post__not_in'] = (array) $_exmachina_displayed_ids;

    $wp_query = new WP_Query( $query_args );

    if ( have_posts() ) : while ( have_posts() ) : the_post();

      $_exmachina_displayed_ids[] = get_the_ID();

      exmachina_markup( array(
        'html5'   => '<article %s>',
        'xhtml'   => sprintf( '<div class="%s">', implode( ' ', get_post_class() ) ),
        'context' => 'entry',
      ) );

      $image = exmachina_get_image( array(
        'format'  => 'html',
        'size'    => $instance['image_size'],
        'context' => 'featured-post-widget',
        'attr'    => exmachina_parse_attr( 'entry-image-widget' ),
      ) );

      if ( $instance['show_image'] && $image )
        printf( '<a href="%s" title="%s" class="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), esc_attr( $instance['image_alignment'] ), $image );

      if ( ! empty( $instance['show_gravatar'] ) ) {
        echo '<span class="' . esc_attr( $instance['gravatar_alignment'] ) . '">';
        echo get_avatar( get_the_author_meta( 'ID' ), $instance['gravatar_size'] );
        echo '</span>';
      }

      if ( $instance['show_title'] )
        echo exmachina_html5() ? '<header class="entry-header">' : '';

        if ( ! empty( $instance['show_title'] ) ) {

          if ( exmachina_html5() )
            printf( '<h2 class="entry-title"><a href="%s" title="%s">%s</a></h2>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );
          else
            printf( '<h2><a href="%s" title="%s">%s</a></h2>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );

        }

        if ( ! empty( $instance['show_byline'] ) && ! empty( $instance['post_info'] ) )
          printf( exmachina_html5() ? '<p class="entry-meta">%s</p>' : '<p class="byline post-info">%s</p>', do_shortcode( $instance['post_info'] ) );

      if ( $instance['show_title'] )
        echo exmachina_html5() ? '</header>' : '';

      if ( ! empty( $instance['show_content'] ) ) {

        echo exmachina_html5() ? '<div class="entry-content">' : '';

        if ( 'excerpt' == $instance['show_content'] ) {
          the_excerpt();
        }
        elseif ( 'content-limit' == $instance['show_content'] ) {
          the_content_limit( (int) $instance['content_limit'], esc_html( $instance['more_text'] ) );
        }
        else {

          global $more;

          $orig_more = $more;
          $more = 0;

          the_content( esc_html( $instance['more_text'] ) );

          $more = $orig_more;

        }

        echo exmachina_html5() ? '</div>' : '';

      }

      exmachina_markup( array(
        'html5' => '</article>',
        'xhtml' => '</div>',
      ) );

    endwhile; endif;

    //* Restore original query
    wp_reset_query();

    //* The EXTRA Posts (list)
    if ( ! empty( $instance['extra_num'] ) ) {
      if ( ! empty( $instance['extra_title'] ) )
        echo $before_title . esc_html( $instance['extra_title'] ) . $after_title;

      $offset = intval( $instance['posts_num'] ) + intval( $instance['posts_offset'] );

      $query_args = array(
        'cat'       => $instance['posts_cat'],
        'showposts' => $instance['extra_num'],
        'offset'    => $offset,
      );

      $wp_query = new WP_Query( $query_args );

      $listitems = '';

      if ( have_posts() ) {
        while ( have_posts() ) {
          the_post();
          $_exmachina_displayed_ids[] = get_the_ID();
          $listitems .= sprintf( '<li><a href="%s" title="%s">%s</a></li>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );
        }

        if ( mb_strlen( $listitems ) > 0 )
          printf( '<ul>%s</ul>', $listitems );
      }

      //* Restore original query
      wp_reset_query();
    }

    if ( ! empty( $instance['more_from_category'] ) && ! empty( $instance['posts_cat'] ) )
      printf(
        '<p class="more-from-category"><a href="%1$s" title="%2$s">%3$s</a></p>',
        esc_url( get_category_link( $instance['posts_cat'] ) ),
        esc_attr( get_cat_name( $instance['posts_cat'] ) ),
        esc_html( $instance['more_from_category_text'] )
      );

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
    $new_instance['post_info'] = wp_kses_post( $new_instance['post_info'] );

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

    <div class="exmachina-widget-column">

      <div class="exmachina-widget-column-box exmachina-widget-column-box-top">

        <p>
          <label for="<?php echo $this->get_field_id( 'posts_cat' ); ?>"><?php _e( 'Category', 'exmachina' ); ?>:</label>
          <?php
          $categories_args = array(
            'name'            => $this->get_field_name( 'posts_cat' ),
            'selected'        => $instance['posts_cat'],
            'orderby'         => 'Name',
            'hierarchical'    => 1,
            'show_option_all' => __( 'All Categories', 'exmachina' ),
            'hide_empty'      => '0',
          );
          wp_dropdown_categories( $categories_args ); ?>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'posts_num' ); ?>"><?php _e( 'Number of Posts to Show', 'exmachina' ); ?>:</label>
          <input type="text" id="<?php echo $this->get_field_id( 'posts_num' ); ?>" name="<?php echo $this->get_field_name( 'posts_num' ); ?>" value="<?php echo esc_attr( $instance['posts_num'] ); ?>" size="2" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'posts_offset' ); ?>"><?php _e( 'Number of Posts to Offset', 'exmachina' ); ?>:</label>
          <input type="text" id="<?php echo $this->get_field_id( 'posts_offset' ); ?>" name="<?php echo $this->get_field_name( 'posts_offset' ); ?>" value="<?php echo esc_attr( $instance['posts_offset'] ); ?>" size="2" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By', 'exmachina' ); ?>:</label>
          <select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
            <option value="date" <?php selected( 'date', $instance['orderby'] ); ?>><?php _e( 'Date', 'exmachina' ); ?></option>
            <option value="title" <?php selected( 'title', $instance['orderby'] ); ?>><?php _e( 'Title', 'exmachina' ); ?></option>
            <option value="parent" <?php selected( 'parent', $instance['orderby'] ); ?>><?php _e( 'Parent', 'exmachina' ); ?></option>
            <option value="ID" <?php selected( 'ID', $instance['orderby'] ); ?>><?php _e( 'ID', 'exmachina' ); ?></option>
            <option value="comment_count" <?php selected( 'comment_count', $instance['orderby'] ); ?>><?php _e( 'Comment Count', 'exmachina' ); ?></option>
            <option value="rand" <?php selected( 'rand', $instance['orderby'] ); ?>><?php _e( 'Random', 'exmachina' ); ?></option>
          </select>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Sort Order', 'exmachina' ); ?>:</label>
          <select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
            <option value="DESC" <?php selected( 'DESC', $instance['order'] ); ?>><?php _e( 'Descending (3, 2, 1)', 'exmachina' ); ?></option>
            <option value="ASC" <?php selected( 'ASC', $instance['order'] ); ?>><?php _e( 'Ascending (1, 2, 3)', 'exmachina' ); ?></option>
          </select>
        </p>

        <p>
          <input id="<?php echo $this->get_field_id( 'exclude_displayed' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'exclude_displayed' ); ?>" value="1" <?php checked( $instance['exclude_displayed'] ); ?>/>
          <label for="<?php echo $this->get_field_id( 'exclude_displayed' ); ?>"><?php _e( 'Exclude Previously Displayed Posts?', 'exmachina' ); ?></label>
        </p>

      </div>

      <div class="exmachina-widget-column-box">

        <p>
          <input id="<?php echo $this->get_field_id( 'show_gravatar' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_gravatar' ); ?>" value="1" <?php checked( $instance['show_gravatar'] ); ?>/>
          <label for="<?php echo $this->get_field_id( 'show_gravatar' ); ?>"><?php _e( 'Show Author Gravatar', 'exmachina' ); ?></label>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'gravatar_size' ); ?>"><?php _e( 'Gravatar Size', 'exmachina' ); ?>:</label>
          <select id="<?php echo $this->get_field_id( 'gravatar_size' ); ?>" name="<?php echo $this->get_field_name( 'gravatar_size' ); ?>">
            <option value="45" <?php selected( 45, $instance['gravatar_size'] ); ?>><?php _e( 'Small (45px)', 'exmachina' ); ?></option>
            <option value="65" <?php selected( 65, $instance['gravatar_size'] ); ?>><?php _e( 'Medium (65px)', 'exmachina' ); ?></option>
            <option value="85" <?php selected( 85, $instance['gravatar_size'] ); ?>><?php _e( 'Large (85px)', 'exmachina' ); ?></option>
            <option value="125" <?php selected( 105, $instance['gravatar_size'] ); ?>><?php _e( 'Extra Large (125px)', 'exmachina' ); ?></option>
          </select>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'gravatar_alignment' ); ?>"><?php _e( 'Gravatar Alignment', 'exmachina' ); ?>:</label>
          <select id="<?php echo $this->get_field_id( 'gravatar_alignment' ); ?>" name="<?php echo $this->get_field_name( 'gravatar_alignment' ); ?>">
            <option value="alignnone">- <?php _e( 'None', 'exmachina' ); ?> -</option>
            <option value="alignleft" <?php selected( 'alignleft', $instance['gravatar_alignment'] ); ?>><?php _e( 'Left', 'exmachina' ); ?></option>
            <option value="alignright" <?php selected( 'alignright', $instance['gravatar_alignment'] ); ?>><?php _e( 'Right', 'exmachina' ); ?></option>
          </select>
        </p>

      </div>

      <div class="exmachina-widget-column-box">

        <p>
          <input id="<?php echo $this->get_field_id( 'show_image' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_image' ); ?>" value="1" <?php checked( $instance['show_image'] ); ?>/>
          <label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Show Featured Image', 'exmachina' ); ?></label>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image Size', 'exmachina' ); ?>:</label>
          <select id="<?php echo $this->get_field_id( 'image_size' ); ?>" class="exmachina-image-size-selector" name="<?php echo $this->get_field_name( 'image_size' ); ?>">
            <option value="thumbnail">thumbnail (<?php echo get_option( 'thumbnail_size_w' ); ?>x<?php echo get_option( 'thumbnail_size_h' ); ?>)</option>
            <?php
            $sizes = exmachina_get_additional_image_sizes();
            foreach( (array) $sizes as $name => $size )
              echo '<option value="'.esc_attr( $name ).'" '.selected( $name, $instance['image_size'], FALSE ).'>'.esc_html( $name ).' ( '.$size['width'].'x'.$size['height'].' )</option>';
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

      </div>

    </div>

    <div class="exmachina-widget-column exmachina-widget-column-right">

      <div class="exmachina-widget-column-box exmachina-widget-column-box-top">

        <p>
          <input id="<?php echo $this->get_field_id( 'show_title' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_title' ); ?>" value="1" <?php checked( $instance['show_title'] ); ?>/>
          <label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Post Title', 'exmachina' ); ?></label>
        </p>

        <p>
          <input id="<?php echo $this->get_field_id( 'show_byline' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_byline' ); ?>" value="1" <?php checked( $instance['show_byline'] ); ?>/>
          <label for="<?php echo $this->get_field_id( 'show_byline' ); ?>"><?php _e( 'Show Post Info', 'exmachina' ); ?></label>
          <input type="text" id="<?php echo $this->get_field_id( 'post_info' ); ?>" name="<?php echo $this->get_field_name( 'post_info' ); ?>" value="<?php echo esc_attr( $instance['post_info'] ); ?>" class="widefat" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'show_content' ); ?>"><?php _e( 'Content Type', 'exmachina' ); ?>:</label>
          <select id="<?php echo $this->get_field_id( 'show_content' ); ?>" name="<?php echo $this->get_field_name( 'show_content' ); ?>">
            <option value="content" <?php selected( 'content', $instance['show_content'] ); ?>><?php _e( 'Show Content', 'exmachina' ); ?></option>
            <option value="excerpt" <?php selected( 'excerpt', $instance['show_content'] ); ?>><?php _e( 'Show Excerpt', 'exmachina' ); ?></option>
            <option value="content-limit" <?php selected( 'content-limit', $instance['show_content'] ); ?>><?php _e( 'Show Content Limit', 'exmachina' ); ?></option>
            <option value="" <?php selected( '', $instance['show_content'] ); ?>><?php _e( 'No Content', 'exmachina' ); ?></option>
          </select>
          <br />
          <label for="<?php echo $this->get_field_id( 'content_limit' ); ?>"><?php _e( 'Limit content to', 'exmachina' ); ?>
            <input type="text" id="<?php echo $this->get_field_id( 'image_alignment' ); ?>" name="<?php echo $this->get_field_name( 'content_limit' ); ?>" value="<?php echo esc_attr( intval( $instance['content_limit'] ) ); ?>" size="3" />
            <?php _e( 'characters', 'exmachina' ); ?>
          </label>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'more_text' ); ?>"><?php _e( 'More Text (if applicable)', 'exmachina' ); ?>:</label>
          <input type="text" id="<?php echo $this->get_field_id( 'more_text' ); ?>" name="<?php echo $this->get_field_name( 'more_text' ); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>" />
        </p>

      </div>

      <div class="exmachina-widget-column-box">

        <p><?php _e( 'To display an unordered list of more posts from this category, please fill out the information below', 'exmachina' ); ?>:</p>

        <p>
          <label for="<?php echo $this->get_field_id( 'extra_title' ); ?>"><?php _e( 'Title', 'exmachina' ); ?>:</label>
          <input type="text" id="<?php echo $this->get_field_id( 'extra_title' ); ?>" name="<?php echo $this->get_field_name( 'extra_title' ); ?>" value="<?php echo esc_attr( $instance['extra_title'] ); ?>" class="widefat" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'extra_num' ); ?>"><?php _e( 'Number of Posts to Show', 'exmachina' ); ?>:</label>
          <input type="text" id="<?php echo $this->get_field_id( 'extra_num' ); ?>" name="<?php echo $this->get_field_name( 'extra_num' ); ?>" value="<?php echo esc_attr( $instance['extra_num'] ); ?>" size="2" />
        </p>

      </div>

      <div class="exmachina-widget-column-box">

        <p>
          <input id="<?php echo $this->get_field_id( 'more_from_category' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'more_from_category' ); ?>" value="1" <?php checked( $instance['more_from_category'] ); ?>/>
          <label for="<?php echo $this->get_field_id( 'more_from_category' ); ?>"><?php _e( 'Show Category Archive Link', 'exmachina' ); ?></label>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'more_from_category_text' ); ?>"><?php _e( 'Link Text', 'exmachina' ); ?>:</label>
          <input type="text" id="<?php echo $this->get_field_id( 'more_from_category_text' ); ?>" name="<?php echo $this->get_field_name( 'more_from_category_text' ); ?>" value="<?php echo esc_attr( $instance['more_from_category_text'] ); ?>" class="widefat" />
        </p>

      </div>

    </div>
    <?php

  } // end function form()
} // end class ExMachina_Featured_Post