<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Search Widget
 *
 * widget-search.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * The Search widget replaces the default WordPress Search widget. This version
 * gives total control over the output to the user by allowing the input of
 * various arguments that typically represent a search form. It also gives the
 * user the option of using the theme's search form through the use of the
 * get_search_form() function.
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
 * Search Widget Class
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Widget_Search extends WP_Widget {

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
      'classname'   => 'search',
      'description' => esc_html__( 'An advanced widget that gives you total control over the output of your search form.', 'exmachina-core' )
    );

    /* Set up the widget control options. */
    $control_options = array(
      'width'  => 525,
      'height' => 350
    );

    /* Create the widget. */
    $this->WP_Widget(
      'exmachina-search',               // $this->id_base
      __( 'Search', 'exmachina-core' ), // $this->name
      $widget_options,               // $this->widget_options
      $control_options               // $this->control_options
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

    /* If the user chose to use the theme's search form, load it. */
    if ( !empty( $instance['theme_search'] ) ) {
      get_search_form();
    }

    /* Else, create the form based on the user-selected arguments. */
    else {

      /* Set up some variables for the search form. */
      if ( empty( $instance['search_text'] ) )
        $instance['search_text'] = '';

      $search_text = ( ( is_search() ) ? esc_attr( get_search_query() ) : esc_attr( $instance['search_text'] ) );

      /* Open the form. */
      $search = '<form method="get" class="search-form" id="search-form' . esc_attr( $this->id_base ) . '" action="' . home_url() . '/"><div>';

      /* If a search label was set, add it. */
      if ( !empty( $instance['search_label'] ) )
        $search .= '<label for="search-text' . esc_attr( $this->id_base ) . '">' . $instance['search_label'] . '</label>';

      /* Search form text input. */
      $search .= '<input class="search-text" type="text" name="s" id="search-text' . esc_attr( $this->id_base ) . '" value="' . $search_text . '" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;" />';

      /* Search form submit button. */
      if ( $instance['search_submit'] )
        $search .= '<input class="search-submit button" name="submit" type="submit" id="search-submit' . esc_attr( $this->id_base ). '" value="' . esc_attr( $instance['search_submit'] ) . '" />';

      /* Close the form. */
      $search .= '</div></form>';

      /* Display the form. */
      echo $search;
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

    $instance['title']         = strip_tags( $new_instance['title'] );
    $instance['search_label']  = strip_tags( $new_instance['search_label'] );
    $instance['search_text']   = strip_tags( $new_instance['search_text'] );
    $instance['search_submit'] = strip_tags( $new_instance['search_submit'] );

    $instance['theme_search'] = ( isset( $new_instance['theme_search'] ) ? 1 : 0 );

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
      'title'         => esc_attr__( 'Search', 'exmachina-core' ),
      'theme_search'  => false,
      'search_label'  => '',
      'search_text'   => '',
      'search_submit' => ''
    );

    /* Merge the user-selected arguments with the defaults. */
    $instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <div class="exmachina-widget-controls columns-2">
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'search_label' ); ?>"><?php _e( 'Search Label:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'search_label' ); ?>" name="<?php echo $this->get_field_name( 'search_label' ); ?>" value="<?php echo esc_attr( $instance['search_label'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'search_text' ); ?>"><?php _e( 'Search Text:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'search_text' ); ?>" name="<?php echo $this->get_field_name( 'search_text' ); ?>" value="<?php echo esc_attr( $instance['search_text'] ); ?>" />
    </p>
    </div>

    <div class="exmachina-widget-controls columns-2 column-last">
    <p>
      <label for="<?php echo $this->get_field_id( 'search_submit' ); ?>"><?php _e( 'Search Submit:', 'exmachina-core' ); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'search_submit' ); ?>" name="<?php echo $this->get_field_name( 'search_submit' ); ?>" value="<?php echo esc_attr( $instance['search_submit'] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'theme_search' ); ?>">
      <input class="checkbox" type="checkbox" <?php checked( $instance['theme_search'], true ); ?> id="<?php echo $this->get_field_id( 'theme_search' ); ?>" name="<?php echo $this->get_field_name( 'theme_search' ); ?>" /> <?php _e( 'Use theme\'s <code>searchform.php</code>?', 'exmachina-core' ); ?></label>
    </p>
    </div>
    <div style="clear:both;">&nbsp;</div>
    <?php

  } // end function form()

} // end class ExMachina_Widget_Search