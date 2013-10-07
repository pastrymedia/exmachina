<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * User Profile Widget
 *
 * user-profile-widget.php
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
 * ExMachina User Profile Widget Class
 *
 * @link http://codex.wordpress.org/Widgets_API
 *
 * @since 0.5.0
 */
class ExMachina_User_Profile_Widget extends WP_Widget {

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
      'title'          => '',
      'alignment'      => 'left',
      'user'           => '',
      'size'           => '45',
      'author_info'    => '',
      'bio_text'       => '',
      'page'           => '',
      'page_link_text' => __( 'Read More', 'exmachina' ) . '&#x02026;',
      'posts_link'     => '',
    );

    /* Setup widget classname and description. */
    $widget_ops = array(
      'classname'   => 'user-profile',
      'description' => __( 'Displays user profile block with Gravatar', 'exmachina' ),
    );

    /* Set the control options. */
    $control_ops = array(
      'id_base' => 'user-profile',
      'width'   => 200,
      'height'  => 250,
    );

    /* Initialize the widget. */
    parent::__construct( 'user-profile', __( 'ExMachina - User Profile', 'exmachina' ), $widget_ops, $control_ops );

  } // end function __construct()

  /**
   * Widget API
   *
   * Outputs the content of the widget.
   *
   * @todo inline comment
   *
   * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
   * @link http://codex.wordpress.org/Function_Reference/get_avatar
   * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
   * @link http://codex.wordpress.org/Function_Reference/get_page_link
   * @link http://codex.wordpress.org/Function_Reference/wpautop
   * @link http://codex.wordpress.org/Function_Reference/get_author_posts_url
   *
   * @since 0.5.0
   * @access public
   *
   * @param  array  $args     The array of form elements
   * @param  array  $instance The current instance of the widget
   */
  function widget( $args, $instance ) {

    extract( $args );

    //* Merge with defaults
    $instance = wp_parse_args( (array) $instance, $this->defaults );

    echo $before_widget;

      if ( ! empty( $instance['title'] ) )
        echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

      $text = '';

      if ( ! empty( $instance['alignment'] ) )
        $text .= '<span class="align' . esc_attr( $instance['alignment'] ) . '">';

      $text .= get_avatar( $instance['user'], $instance['size'] );

      if( ! empty( $instance['alignment'] ) )
        $text .= '</span>';

      if ( 'text' === $instance['author_info'] )
        $text .= $instance['bio_text']; //* We run KSES on update
      else
        $text .= get_the_author_meta( 'description', $instance['user'] );

      $text .= $instance['page'] ? sprintf( ' <a class="pagelink" href="%s">%s</a>', get_page_link( $instance['page'] ), $instance['page_link_text'] ) : '';

      //* Echo $text
      echo wpautop( $text );

      //* If posts link option checked, add posts link to output
      if ( $instance['posts_link'] )
        printf( '<div class="posts_link posts-link"><a href="%s">%s</a></div>', get_author_posts_url( $instance['user'] ), __( 'View My Blog Posts', 'exmachina' ) );

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

    $new_instance['title']          = strip_tags( $new_instance['title'] );
    $new_instance['bio_text']       = current_user_can( 'unfiltered_html' ) ? $new_instance['bio_text'] : exmachina_formatting_kses( $new_instance['bio_text'] );
    $new_instance['page_link_text'] = strip_tags( $new_instance['page_link_text'] );

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
      <label for="<?php echo $this->get_field_name( 'user' ); ?>"><?php _e( 'Select a user. The email address for this account will be used to pull the Gravatar image.', 'exmachina' ); ?></label><br />
      <?php wp_dropdown_users( array( 'who' => 'authors', 'name' => $this->get_field_name( 'user' ), 'selected' => $instance['user'] ) ); ?>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Gravatar Size', 'exmachina' ); ?>:</label>
      <select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
        <?php
        $sizes = array( __( 'Small', 'exmachina' ) => 45, __( 'Medium', 'exmachina' ) => 65, __( 'Large', 'exmachina' ) => 85, __( 'Extra Large', 'exmachina' ) => 125 );
        $sizes = apply_filters( 'exmachina_gravatar_sizes', $sizes );
        foreach ( (array) $sizes as $label => $size ) { ?>
          <option value="<?php echo absint( $size ); ?>" <?php selected( $size, $instance['size'] ); ?>><?php printf( '%s (%spx)', $label, $size ); ?></option>
        <?php } ?>
      </select>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'alignment' ); ?>"><?php _e( 'Gravatar Alignment', 'exmachina' ); ?>:</label>
      <select id="<?php echo $this->get_field_id( 'alignment' ); ?>" name="<?php echo $this->get_field_name( 'alignment' ); ?>">
        <option value="">- <?php _e( 'None', 'exmachina' ); ?> -</option>
        <option value="left" <?php selected( 'left', $instance['alignment'] ); ?>><?php _e( 'Left', 'exmachina' ); ?></option>
        <option value="right" <?php selected( 'right', $instance['alignment'] ); ?>><?php _e( 'Right', 'exmachina' ); ?></option>
      </select>
    </p>

    <fieldset>
      <legend><?php _e( 'Select which text you would like to use as the author description', 'exmachina' ); ?></legend>
      <p>
        <input type="radio" name="<?php echo $this->get_field_name( 'author_info' ); ?>" id="<?php echo $this->get_field_id( 'author_info' ); ?>_val1" value="bio" <?php checked( $instance['author_info'], 'bio' ); ?>/>
        <label for="<?php echo $this->get_field_id( 'author_info' ); ?>_val1"><?php _e( 'Author Bio', 'exmachina' ); ?></label><br />
        <input type="radio" name="<?php echo $this->get_field_name( 'author_info' ); ?>" id="<?php echo $this->get_field_id( 'author_info' ); ?>_val2" value="text" <?php checked( $instance['author_info'], 'text' ); ?>/>
        <label for="<?php echo $this->get_field_id( 'author_info' ); ?>_val2"><?php _e( 'Custom Text (below)', 'exmachina' ); ?></label><br />
        <label for="<?php echo $this->get_field_id( 'bio_text' ); ?>" class="screen-reader-text"><?php _e( 'Custom Text Content', 'exmachina' ); ?></label>
        <textarea id="<?php echo $this->get_field_id( 'bio_text' ); ?>" name="<?php echo $this->get_field_name( 'bio_text' ); ?>" class="widefat" rows="6" cols="4"><?php echo htmlspecialchars( $instance['bio_text'] ); ?></textarea>
      </p>
    </fieldset>

    <p>
      <label for="<?php echo $this->get_field_name( 'page' ); ?>"><?php _e( 'Choose your extended "About Me" page from the list below. This will be the page linked to at the end of the about me section.', 'exmachina' ); ?></label><br />
      <?php wp_dropdown_pages( array( 'name' => $this->get_field_name( 'page' ), 'show_option_none' => __( 'None', 'exmachina' ), 'selected' => $instance['page'] ) ); ?>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'page_link_text' ); ?>"><?php _e( 'Extended page link text', 'exmachina' ); ?>:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'page_link_text' ); ?>" name="<?php echo $this->get_field_name( 'page_link_text' ); ?>" value="<?php echo esc_attr( $instance['page_link_text'] ); ?>" class="widefat" />
    </p>

    <p>
      <input id="<?php echo $this->get_field_id( 'posts_link' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'posts_link' ); ?>" value="1" <?php checked( $instance['posts_link'] ); ?>/>
      <label for="<?php echo $this->get_field_id( 'posts_link' ); ?>"><?php _e( 'Show Author Archive Link?', 'exmachina' ); ?></label>
    </p>
    <?php

  } // end  function form()

} // end class ExMachina_User_Profile_Widget