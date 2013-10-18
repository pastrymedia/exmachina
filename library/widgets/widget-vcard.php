<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * vCard Widget
 *
 * widget-vcard.php
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
 * vCard Widget Class
 *
 * DESCRIPTION
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Widget_vCard extends WP_Widget {

  /**
   * Private Fields Array
   *
   * @var array
   */
  private $fields = array(
    'title'          => 'Title (optional)',
    'street_address' => 'Street Address',
    'locality'       => 'City/Locality',
    'region'         => 'State/Region',
    'postal_code'    => 'Zipcode/Postal Code',
    'tel'            => 'Telephone',
    'email'          => 'Email'
  );

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
    $widget_ops = array(
      'classname' => 'widget_vcard',
      'description' => __( 'Use this widget to add a vCard', 'exmachina-core' ));

    /* Create the widget. */
    $this->WP_Widget(
      'widget_vcard',             // $this->id_base
      __( 'vCard', 'exmachina-core' ),  // $this->name
      $widget_ops                       // $this->widget_options
    );

    $this->alt_option_name = 'widget_vcard';

    /* Flish the widget cache. */
    add_action('save_post', array( &$this, 'flush_widget_cache' ));
    add_action('deleted_post', array( &$this, 'flush_widget_cache' ));
    add_action('switch_theme', array( &$this, 'flush_widget_cache' ));

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
  function widget( $args, $instance ) {

    $cache = wp_cache_get('widget_vcard', 'widget');

    if (!is_array($cache)) {
      $cache = array();
    }

    if (!isset($args['widget_id'])) {
      $args['widget_id'] = null;
    }

    if (isset($cache[$args['widget_id']])) {
      echo $cache[$args['widget_id']];
      return;
    }

    ob_start();
    extract($args, EXTR_SKIP);

    $title = apply_filters('widget_title', empty($instance['title']) ? __('vCard', 'exmachina-core') : $instance['title'], $instance, $this->id_base);

    foreach($this->fields as $name => $label) {
      if (!isset($instance[$name])) { $instance[$name] = ''; }
    }

    echo $before_widget;

    if ($title) {
      echo $before_title, $title, $after_title;
    }
    ?>

    <p class="vcard">
      <a class="fn org url" href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a><br>
      <span class="adr">
        <span class="street-address"><?php echo $instance['street_address']; ?></span><br>
        <span class="locality"><?php echo $instance['locality']; ?></span>,
        <span class="region"><?php echo $instance['region']; ?></span>
        <span class="postal-code"><?php echo $instance['postal_code']; ?></span><br>
      </span>
      <span class="tel"><span class="value"><?php echo $instance['tel']; ?></span></span><br>
      <a class="email" href="mailto:<?php echo $instance['email']; ?>"><?php echo $instance['email']; ?></a>
    </p>

    <?php
    echo $after_widget;

    $cache[$args['widget_id']] = ob_get_flush();
    wp_cache_set('widget_vcard', $cache, 'widget');

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

    $instance = array_map('strip_tags', $new_instance);

    $this->flush_widget_cache();

    $alloptions = wp_cache_get('alloptions', 'options');

    if (isset($alloptions['widget_vcard'])) {
      delete_option('widget_vcard');
    }

    return $instance;

  } // end function update()

  /**
   * Flush Widget Cache
   *
   * Deletes the widget cached values.
   *
   * @since 2.7.0
   * @access public
   *
   * @return void
   */
  function flush_widget_cache() {

    wp_cache_delete('widget_vcard', 'widget');

  } // end function flush_widget_cache()

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

    foreach($this->fields as $name => $label) {
      ${$name} = isset($instance[$name]) ? esc_attr($instance[$name]) : '';
      ?>
        <p>
          <label for="<?php echo esc_attr($this->get_field_id($name)); ?>"><?php _e("{$label}:", 'exmachina-core'); ?></label>
          <input class="widefat" id="<?php echo esc_attr($this->get_field_id($name)); ?>" name="<?php echo esc_attr($this->get_field_name($name)); ?>" type="text" value="<?php echo ${$name}; ?>">
        </p>
      <?php
    }

  } // end function form()

} // end class ExMachina_Widget_vCard