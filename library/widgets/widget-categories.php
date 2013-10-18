<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Categories Widget
 *
 * widget-categories.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * The Categories widget replaces the default WordPress Categories widget. This
 * version gives total control over the output to the user by allowing the input
 * of all the arguments typically seen in the wp_list_categories() function.
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
 * Categories Widget Class
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Widget_Categories extends WP_Widget {

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
      'classname'   => 'categories',
      'description' => esc_html__( 'An advanced widget that gives you total control over the output of your category links.', 'exmachina-core' )
    );

    /* Set up the widget control options. */
    $control_options = array(
      'width'  => 800,
      'height' => 350
    );

    /* Create the widget. */
    $this->WP_Widget(
      'exmachina-categories',               // $this->id_base
      __( 'Categories', 'exmachina-core' ), // $this->name
      $widget_options,                   // $this->widget_options
      $control_options                   // $this->control_options
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

    /* Set the $args for wp_list_categories() to the $instance array. */
    $args = $instance;

    /* Set the $title_li and $echo arguments to false. */
    $args['title_li'] = false;
    $args['echo'] = false;

    /* Output the theme's widget wrapper. */
    echo $before_widget;

    /* If a title was input by the user, display it. */
    if ( !empty( $instance['title'] ) )
      echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

    /* Get the categories list. */
    $categories = str_replace( array( "\r", "\n", "\t" ), '', wp_list_categories( $args ) );

    /* If 'list' is the user-selected style, wrap the categories in an unordered list. */
    if ( 'list' == $args['style'] )
      $categories = '<ul class="xoxo categories">' . $categories . '</ul><!-- .xoxo .categories -->';

    /* Output the categories list. */
    echo $categories;

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

    /* Set the instance to the new instance. */
    $instance = $new_instance;

    /* If new taxonomy is chosen, reset includes and excludes. */
    if ( $instance['taxonomy'] !== $old_instance['taxonomy'] && '' !== $old_instance['taxonomy'] ) {
      $instance['include'] = array();
      $instance['exclude'] = array();
    }

    $instance['taxonomy'] = $new_instance['taxonomy'];

    $instance['feed_image'] = esc_url( $new_instance['feed_image'] );

    $instance['title']            = strip_tags( $new_instance['title'] );
    $instance['depth']            = strip_tags( $new_instance['depth'] );
    $instance['number']           = strip_tags( $new_instance['number'] );
    $instance['child_of']         = strip_tags( $new_instance['child_of'] );
    $instance['current_category'] = strip_tags( $new_instance['current_category'] );
    $instance['feed']             = strip_tags( $new_instance['feed'] );
    $instance['search']           = strip_tags( $new_instance['search'] );

    $instance['include']      = preg_replace( '/[^0-9,]/', '', $new_instance['include'] );
    $instance['exclude']      = preg_replace( '/[^0-9,]/', '', $new_instance['exclude'] );
    $instance['exclude_tree'] = preg_replace( '/[^0-9,]/', '', $new_instance['exclude_tree'] );

    $instance['hierarchical']       = ( isset( $new_instance['hierarchical'] ) ? 1 : 0 );
    $instance['use_desc_for_title'] = ( isset( $new_instance['use_desc_for_title'] ) ? 1 : 0 );
    $instance['show_count']         = ( isset( $new_instance['show_count'] ) ? 1 : 0 );
    $instance['hide_empty']         = ( isset( $new_instance['hide_empty'] ) ? 1 : 0 );

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
      'title'              => esc_attr__( 'Categories', 'exmachina-core' ),
      'taxonomy'           => 'category',
      'style'              => 'list',
      'include'            => '',
      'exclude'            => '',
      'exclude_tree'       => '',
      'child_of'           => '',
      'current_category'   => '',
      'search'             => '',
      'hierarchical'       => true,
      'hide_empty'         => true,
      'order'              => 'ASC',
      'orderby'            => 'name',
      'depth'              => 0,
      'number'             => '',
      'feed'               => '',
      'feed_type'          => '',
      'feed_image'         => '',
      'use_desc_for_title' => false,
      'show_count'         => false,
    );

    /* Merge the user-selected arguments with the defaults. */
    $instance = wp_parse_args( (array) $instance, $defaults );

    /* <select> element options. */
    $taxonomies = get_taxonomies( array( 'show_tagcloud' => true ), 'objects' );
    $terms = get_terms( $instance['taxonomy'] );

    $style = array(
      'list' => esc_attr__( 'List', 'exmachina-core' ),
      'none' => esc_attr__( 'None', 'exmachina-core' )
    );

    $order = array(
      'ASC'  => esc_attr__( 'Ascending', 'exmachina-core' ),
      'DESC' => esc_attr__( 'Descending', 'exmachina-core' )
    );

    $orderby = array(
      'count'      => esc_attr__( 'Count', 'exmachina-core' ),
      'ID'         => esc_attr__( 'ID', 'exmachina-core' ),
      'name'       => esc_attr__( 'Name', 'exmachina-core' ),
      'slug'       => esc_attr__( 'Slug', 'exmachina-core' ),
      'term_group' => esc_attr__( 'Term Group', 'exmachina-core' )
    );

    $feed_type = array(
      ''     => '',
      'atom' => esc_attr__( 'Atom', 'exmachina-core' ),
      'rdf'  => esc_attr__( 'RDF', 'exmachina-core' ),
      'rss'  => esc_attr__( 'RSS', 'exmachina-core' ),
      'rss2' => esc_attr__( 'RSS 2.0', 'exmachina-core' )
    );

    ?>

    <div class="exmachina-widget-controls columns-3">
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><code>taxonomy</code></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>">
        <?php foreach ( $taxonomies as $taxonomy ) { ?>
          <option value="<?php echo esc_attr( $taxonomy->name ); ?>" <?php selected( $instance['taxonomy'], $taxonomy->name ); ?>><?php echo esc_html( $taxonomy->labels->singular_name ); ?></option>
        <?php } ?>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'style' ); ?>"><code>style</code></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
        <?php foreach ( $style as $option_value => $option_label ) { ?>
          <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['style'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
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
    <p>
      <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><code>orderby</code></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
        <?php foreach ( $orderby as $option_value => $option_label ) { ?>
          <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['orderby'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
        <?php } ?>
      </select>
    </p>
    </div>

    <div class="exmachina-widget-controls columns-3">
    <p>
      <label for="<?php echo $this->get_field_id( 'depth' ); ?>"><code>depth</code></label>
      <input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'depth' ); ?>" name="<?php echo $this->get_field_name( 'depth' ); ?>" value="<?php echo esc_attr( $instance['depth'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'number' ); ?>"><code>number</code></label>
      <input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo esc_attr( $instance['number'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'include' ); ?>"><code>include</code></label>
      <input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'include' ); ?>" name="<?php echo $this->get_field_name( 'include' ); ?>" value="<?php echo esc_attr( $instance['include'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><code>exclude</code></label>
      <input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" value="<?php echo esc_attr( $instance['exclude'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'exclude_tree' ); ?>"><code>exclude_tree</code></label>
      <input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'exclude_tree' ); ?>" name="<?php echo $this->get_field_name( 'exclude_tree' ); ?>" value="<?php echo esc_attr( $instance['exclude_tree'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'child_of' ); ?>"><code>child_of</code></label>
      <input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'child_of' ); ?>" name="<?php echo $this->get_field_name( 'child_of' ); ?>" value="<?php echo esc_attr( $instance['child_of'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'current_category' ); ?>"><code>current_category</code></label>
      <input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'current_category' ); ?>" name="<?php echo $this->get_field_name( 'current_category' ); ?>" value="<?php echo esc_attr( $instance['current_category'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'search' ); ?>"><code>search</code></label>
      <input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'search' ); ?>" name="<?php echo $this->get_field_name( 'search' ); ?>" value="<?php echo esc_attr( $instance['search'] ); ?>" />
    </p>
    </div>

    <div class="exmachina-widget-controls columns-3 column-last">
    <p>
      <label for="<?php echo $this->get_field_id( 'feed' ); ?>"><code>feed</code></label>
      <input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'feed' ); ?>" name="<?php echo $this->get_field_name( 'feed' ); ?>" value="<?php echo esc_attr( $instance['feed'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'feed_type' ); ?>"><code>feed_type</code></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'feed_type' ); ?>" name="<?php echo $this->get_field_name( 'feed_type' ); ?>">
        <?php foreach ( $feed_type as $option_value => $option_label ) { ?>
          <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['feed_type'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
        <?php } ?>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'feed_image' ); ?>"><code>feed_image</code></label>
      <input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'feed_image' ); ?>" name="<?php echo $this->get_field_name( 'feed_image' ); ?>" value="<?php echo esc_attr( $instance['feed_image'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'hierarchical' ); ?>">
      <input class="checkbox" type="checkbox" <?php checked( $instance['hierarchical'], true ); ?> id="<?php echo $this->get_field_id( 'hierarchical' ); ?>" name="<?php echo $this->get_field_name( 'hierarchical' ); ?>" /> <?php _e( 'Hierarchical?', 'exmachina-core' ); ?> <code>hierarchical</code></label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'use_desc_for_title' ); ?>">
      <input class="checkbox" type="checkbox" <?php checked( $instance['use_desc_for_title'], true ); ?> id="<?php echo $this->get_field_id( 'use_desc_for_title' ); ?>" name="<?php echo $this->get_field_name( 'use_desc_for_title' ); ?>" /> <?php _e( 'Use description?', 'exmachina-core' ); ?> <code>use_desc_for_title</code></label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'show_count' ); ?>">
      <input class="checkbox" type="checkbox" <?php checked( $instance['show_count'], true ); ?> id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" /> <?php _e( 'Show count?', 'exmachina-core' ); ?> <code>show_count</code></label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'hide_empty' ); ?>">
      <input class="checkbox" type="checkbox" <?php checked( $instance['hide_empty'], true ); ?> id="<?php echo $this->get_field_id( 'hide_empty' ); ?>" name="<?php echo $this->get_field_name( 'hide_empty' ); ?>" /> <?php _e( 'Hide empty?', 'exmachina-core' ); ?> <code>hide_empty</code></label>
    </p>
    </div>
    <div style="clear:both;">&nbsp;</div>
    <?php

  } // end function form()

} // end class ExMachina_Widget_Categories