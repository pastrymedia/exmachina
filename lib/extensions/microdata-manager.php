<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Microdata Manager Extension
 *
 * microdata-manager.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
 *
 * @package     ExMachina
 * @subpackage  Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin extension
###############################################################################

add_action( 'exmachina_setup', 'microdata_manager_post_type_support' );

/**
 * Micodata Post Type Support
 *
 * Add the micodata manager extension to support various post types. Currently,
 * page and post post types are supported.
 *
 * @link http://codex.wordpress.org/Function_Reference/add_post_type_support
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function microdata_manager_post_type_support() {

  /* Add "post" post type support. */
  add_post_type_support( 'post', array( 'microdata-manager' ) );

  /* Add "page" post type support. */
  add_post_type_support( 'page', array( 'microdata-manager' ) );

} // end function microdata_manager_post_type_support()


add_action( 'admin_menu', 'microdata_manager_add_inpost_microdata_box' );

/**
 * Microdata Inpost Metabox
 *
 * Register a new meta box to the post or page edit screen. Allow the user to
 * set Microdata options on a per-post or per-page basis. If the post type does
 * not support microdata-manager, then the Microdata Settings meta box will not
 * be added.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_post_types
 * @link http://codex.wordpress.org/Function_Reference/post_type_supports
 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
 *
 * @uses microdata_manager_inpost_microdata_box() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function microdata_manager_add_inpost_microdata_box() {

  foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {

    if ( post_type_supports( $type, 'microdata-manager' ) )
      add_meta_box( 'microdata_manager_inpost_microdata_box', __( 'Microdata Settings', 'microdata-manager' ), 'microdata_manager_inpost_microdata_box', $type, 'normal', 'high' );

  } // end foreach

} // end function microdata_manager_add_inpost_microdata_box()

/**
 * Microdata Inpost Metabox Callback
 *
 * Callback function to display in-post microdtata settings metabox.
 *
 * @todo maybe update how the form looks
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nonce_field
 * @link http://codex.wordpress.org/Function_Reference/get_post_type
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function microdata_manager_inpost_microdata_box() {

  wp_nonce_field( 'microdata_manager_inpost_microdata_save', 'microdata_manager_inpost_microdata_nonce' );

  $placeholder = 'post' == get_post_type() ? 'http://schema.org/BlogPosting' : 'http://schema.org/CreativeWork'

  ?>

  <p><label for="content_itemtype"><b><?php _e( 'Main Content - itemtype', 'microdata-manager' ); ?></b> <?php _e( '(Used on post only)', 'microdata-manager' ); ?></label></p>
  <p><input class="large-text" type="text" name="microdata_manager[_content_itemtype]" id="content_itemtype" placeholder="http://schema.org/Blog" value="<?php echo esc_attr( exmachina_get_custom_field( '_content_itemtype' ) ); ?>" /></p>

  <p><label for="entry_itemtype"><b><?php _e( 'Entry - itemtype', 'microdata-manager' ); ?></b> <?php _e( '(Used on page and post)', 'microdata-manager' ); ?></label></p>
  <p><input class="large-text" type="text" name="microdata_manager[_entry_itemtype]" id="entry_itemtype" placeholder="<?php echo $placeholder; ?>" value="<?php echo esc_attr( exmachina_get_custom_field( '_entry_itemtype' ) ); ?>" /></p>

  <p><label for="entry_itemprop"><b><?php _e( 'Entry - itemprop', 'microdata-manager' ); ?></b> <?php _e( '(Used on post only)', 'microdata-manager' ); ?></label></p>
  <p><input class="large-text" type="text" name="microdata_manager[_entry_itemprop]" id="entry_itemprop" placeholder="blogPost" value="<?php echo esc_attr( exmachina_get_custom_field( '_entry_itemprop' ) ); ?>" /></p>

  <p><label for="entry_title_itemprop"><b><?php _e( 'Entry Title - itemprop', 'microdata-manager' ); ?></b> <?php _e( '(Used on page and post)', 'microdata-manager' ); ?></label></p>
  <p><input class="large-text" type="text" name="microdata_manager[_entry_title_itemprop]" id="entry_title_itemprop" placeholder="headline" value="<?php echo esc_attr( exmachina_get_custom_field( '_entry_title_itemprop' ) ); ?>" /></p>

  <p><label for="entry_content_itemprop"><b><?php _e( 'Entry Content - itemprop', 'microdata-manager' ); ?></b> <?php _e( '(Used on page and post)', 'microdata-manager' ); ?></label></p>
  <p><input class="large-text" type="text" name="microdata_manager[_entry_content_itemprop]" id="entry_content_itemprop" placeholder="text" value="<?php echo esc_attr( exmachina_get_custom_field( '_entry_content_itemprop' ) ); ?>" /></p>

  <span class="description"><?php _e( 'Enter something to override the default settings displayed within the fields. Visit <a href="http://www.schema.org/" target="_blank">schema.org</a> for details.', 'microdata-manager' ); ?>

  <?php

} // end function microdata_manager_inpost_microdata_box()

add_action( 'save_post', 'microdata_manager_inpost_microdata_save', 1, 2 );
/**
 * Microdata Save
 *
 * Save the schema settings when the post or page is saved.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
 * @link http://codex.wordpress.org/Function_Reference/sanitize_text_field
 *
 * @uses exmachina_save_custom_fields() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  integer  $post_id The post ID.
 * @param  stdClass $post    The post object.
 * @return null              Returns early if microdata isn't set.
 */
function microdata_manager_inpost_microdata_save( $post_id, $post ) {

  if ( ! isset( $_POST['microdata_manager'] ) )
    return;

  // Merge user submitted options with fallback defaults
  $defaults = array(
    '_content_itemtype'       => '',
    '_entry_itemtype'         => '',
    '_entry_itemprop'         => '',
    '_entry_title_itemprop'   => '',
    '_entry_content_itemprop' => '',
  );

  $data = wp_parse_args( $_POST['microdata_manager'], $defaults );
  $clean_data = array();

  foreach ( (array) $data as $key => $value ) {
    if ( in_array( $key, array_keys( $defaults ) ) )
      $clean_data[ $key ] = sanitize_text_field( $value );
  }

  exmachina_save_custom_fields( $clean_data, 'microdata_manager_inpost_microdata_save', 'microdata_manager_inpost_microdata_nonce', $post );

} // end function microdata_manager_inpost_microdata_save()


add_filter( 'exmachina_attr_content', 'microdata_manager_attributes_content' );

/**
 * Microdata Content Attributes
 *
 * Add attributes for the main content element.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 *
 * @uses exmachina_get_custom_field() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array $attributes Element attributes.
 * @return array             Amended element attributes.
 */
function microdata_manager_attributes_content( $attributes ) {

  $attributes['role']     = 'main';
  $attributes['itemprop'] = 'mainContentOfPage';
  $c_it_microdata = esc_attr( exmachina_get_custom_field( '_content_itemtype' ) );

  // Blog microdata
  if ( is_singular( 'post' ) || is_archive() || is_home() || is_page_template( 'page_blog.php' ) ) {
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype']  = 'http://schema.org/Blog';
  }

  if ( is_singular( 'post' ) && $c_it_microdata || is_archive() && $c_it_microdata || is_home() && $c_it_microdata || is_page_template( 'page_blog.php' ) && $c_it_microdata ) {
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype']  = $c_it_microdata;
  }

  // Search results pages
  if ( is_search() ) {
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'http://schema.org/SearchResultsPage';
  }

  return $attributes;

} // end function microdata_manager_attributes_content()


add_filter( 'exmachina_attr_entry', 'microdata_manager_attributes_entry' );

/**
 * Microdata Entry Attributes
 *
 * Add attributes for the entry element.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Post
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/get_post_class
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 *
 * @uses exmachina_get_custom_field() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $post       WP_Post post object.
 * @param  array  $attributes Element attributes.
 * @return array              Amended element attributes.
 */
function microdata_manager_attributes_entry( $attributes ) {
  global $post;

  $attributes['class']     = join( ' ', get_post_class() );
  $attributes['itemscope'] = 'itemscope';
  $attributes['itemtype']  = 'http://schema.org/CreativeWork';
  $e_it_microdata = esc_attr( exmachina_get_custom_field( '_entry_itemtype' ) );
  $e_ip_microdata = esc_attr( exmachina_get_custom_field( '_entry_itemprop' ) );
  $mytypes = 'test';

  if ( 'post' == $post->post_type ) {
    $attributes['itemtype']  = 'http://schema.org/BlogPosting';

    if ( is_main_query() )
      $attributes['itemprop']  = 'blogPost';

    if ( is_main_query() && $e_ip_microdata )
      $attributes['itemprop']  = $e_ip_microdata;

  } if ( 'post' == $post->post_type && $e_it_microdata ) {
    $attributes['itemtype']  = $e_it_microdata;

  } if ( is_page() && $e_it_microdata ) {
    $attributes['itemtype']  = $e_it_microdata;

  } if ( $mytypes == $post->post_type && $e_it_microdata ) {
    $attributes['itemtype']  = $e_it_microdata;

  }

  return $attributes;

} // end function microdata_manager_attributes_entry()

add_filter( 'exmachina_attr_entry-title', 'microdata_manager_attributes_entry_title' );

/**
 * Microdata Entry Title Attributes
 *
 * Add attributes for the entry title element.
 *
 * @todo inline comment
 *
 * @uses exmachina_get_custom_field() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array $attributes Element attributes.
 * @return array             Amended element attributes.
 */
function microdata_manager_attributes_entry_title( $attributes ) {

  $et_ip_microdata = esc_attr( exmachina_get_custom_field( '_entry_title_itemprop' ) );

  if ( $et_ip_microdata ) {
    $attributes['itemprop'] = $et_ip_microdata;

  } else {
    $attributes['itemprop'] = 'headline';

  }

  return $attributes;

} // end function microdata_manager_attributes_entry_title()

add_filter( 'exmachina_attr_entry-content', 'microdata_manager_attributes_entry_content' );
/**
 * Microdata Entry Content Attributes
 *
 * Add attributes for the entry content element.
 *
 * @todo inline comment
 *
 * @uses exmachina_get_custom_field() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $post       WP_Post post object.
 * @param  array  $attributes Element attributes.
 * @return array              Amended element attributes.
 */
function microdata_manager_attributes_entry_content( $attributes ) {
  global $post;

  $ec_ip_microdata = esc_attr( exmachina_get_custom_field( '_entry_content_itemprop' ) );

  if ( $ec_ip_microdata ) {
    $attributes['itemprop'] = $ec_ip_microdata;

  } else {
    $attributes['itemprop'] = 'text';

  }

  return $attributes;

} // end function microdata_manager_attributes_entry_content()


