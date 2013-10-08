<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Custom Menus Extension
 *
 * custom-menus.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * The custom menus extension allows users to select a custom menu to use for the
 * secondary menu position on individual posts/pages.
 *
 * @package     ExMachina
 * @subpackage  Extensions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin extension
###############################################################################

/**
 * Custom Menus Class
 *
 * Builds the custom menus extension.
 *
 * @since 0.5.0
 */
class ExMachina_Custom_Menus {

  /**
   * Custom Menu Variables
   *
   * Sets the variables for use within the custom menu class.
   *
   * @todo rename var values
   *
   * @since 0.5.0
   * @access public
   *
   * @var string $handle     Edit screen metabox handle.
   * @var string $nonce_key  Custom menu form nonce key.
   * @var string $field_name Custom menu field name.
   * @var string $menu       Custom menu to replace.
   * @var string $taxonomies Taxonomies with custom menu support.
   */
  var $handle = 'gsm-post-metabox';
  var $nonce_key = 'gsm-post-metabox-nonce';
  var $field_name = '_gsm_menu';
  var $menu = null;
  var $taxonomies=null;

  /**
   * Custom Menu Constructor
   *
   * Initializes the custom menu extension class.
   *
   * @since 0.5.0
   * @access public
   */
  function __construct() {

    /* Hook the init() method into the init hook. */
    add_action( 'init', array( $this, 'init' ), 99 );

  } // end function __construct()

  /**
   * Custom Menu Init
   *
   * Launches all the hooks into WordPress to run the custom menu extension.
   *
   * @todo maybe remove first get_option check
   *
   * @link http://codex.wordpress.org/Function_Reference/get_taxonomies
   *
   * @uses exmachina_get_option() [description]
   * @uses admin_menu() [description]
   * @uses save_post() [description]
   * @uses wp_head() [description]
   * @uses term_edit() [description]
   *
   * @since 0.5.0
   * @access public
   *
   * @return null Returns early if exmachina_get_option() doesn't exist.
   */
  function init() {

    /* Return early if exmachina_get_option() doesn't exist. */
    if ( ! function_exists( 'exmachina_get_option' ) )
      return;

    /* Add the class actions the the appropiate hooks. */
    add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    add_action( 'save_post',  array( $this, 'save_post' ), 10, 2 );
    add_action( 'wp_head',    array( $this, 'wp_head' ) );

    /* Generate a list of public taxonomies. */
    $_taxonomies = get_taxonomies( array( 'show_ui' => true, 'public' => true ) );

    /* Make the taxonomy list filterable. */
    $this->taxonomies = apply_filters( 'exmachina_custom_menus_taxonomies', array_keys( $_taxonomies ) );

    /* Return if taxonomy list is empty. */
    if ( empty( $this->taxonomies ) || ! is_array( $this->taxonomies ) )
      return;

    /* Add term edit metabox foreach taxonomy in array. */
    foreach( $this->taxonomies as $tax )
      add_action( "{$tax}_edit_form", array( $this, 'term_edit' ), 9, 2 );

  } // end function init()

  /**
   * Admin Menu
   *
   * Sets up the metabox to display on the edit screens of the appropiate post
   * types.
   *
   * @link http://codex.wordpress.org/Function_Reference/get_post_types
   * @link http://codex.wordpress.org/Function_Reference/post_type_supports
   * @link http://codex.wordpress.org/Function_Reference/add_meta_box
   *
   * @uses metabox() [description]
   *
   * @since 0.5.0
   * @access public
   *
   * @return void
   */
  function admin_menu() {

    /* Foreach public post type. */
    foreach( (array) get_post_types( array( 'public' => true ) ) as $type ) {

      /* Add the metabox if the post type supports it. */
      if( $type == 'post' || $type == 'page' || post_type_supports( $type, 'exmachina-custom-menus' ) )
        add_meta_box( $this->handle, __( 'Secondary Navigation', 'exmachina' ), array( $this, 'metabox' ), $type, 'side', 'low' );

    } // end foreach

  } // end function admin_menu()

  /**
   * Pose Edit Metabox
   *
   * Serves as a callback on admin_menu(). Generates the metabox markup on the
   * edit screens.
   *
   * @todo maybe remove CSS width
   *
   * @uses print_menu_select() [description]
   * @uses exmachina_get_custom_field() [description]
   *
   * @since 0.5.0
   * @access public
   *
   * @return void
   */
  function metabox() {
    ?>

    <p>
      <?php $this->print_menu_select( $this->field_name, exmachina_get_custom_field( $this->field_name ), 'width: 99%;' ); ?>
    </p>

    <?php
  } // end function metabox()

  /**
   * Term Edit Metabox
   *
   * Generates the metabox markup on the term edit screens.
   *
   * @todo docblock comment
   *
   * @uses print_menu_select() [description]
   *
   * @since 0.5.0
   * @access public
   *
   * @param  [type] $tag      [description]
   * @param  [type] $taxonomy [description]
   * @return [type]           [description]
   */
  function term_edit( $tag, $taxonomy ) {

    /* Merge Defaults to prevent notices. */
    $tag->meta = wp_parse_args( $tag->meta, array( $this->field_name => '' ) );
    ?>

    <h3><?php _e( 'Secondary Navigation', 'exmachina' ); ?></h3>

    <table class="form-table">
      <tr class="form-field">
        <th scope="row" valign="top">
          <?php
          $this->print_menu_select( "exmachina-meta[{$this->field_name}]", $tag->meta[$this->field_name], '', 'padding-right: 10px;', '</th><td>' ); ?>
        </td>
      </tr>
    </table>

    <?php
  } // end function term_edit()

  /**
   * Print Menu Select
   *
   * Support function for the metaboxes. Outputs the dropdown of available
   * custom menus.
   *
   * @todo inline comment
   * @todo docblock comment
   *
   * @since 0.5.0
   * @access public
   *
   * @param  [type] $field_name   [description]
   * @param  [type] $selected     [description]
   * @param  string $select_style [description]
   * @param  string $option_style [description]
   * @param  string $after_label  [description]
   * @return [type]               [description]
   */
  function print_menu_select( $field_name, $selected, $select_style = '', $option_style = '', $after_label = '' ) {

    if ( $select_style )
      $select_style = sprintf(' style="%s"', esc_attr( $select_style ) );

    if ( $option_style )
      $option_style = sprintf(' style="%s"', esc_attr( $option_style ) );

    ?>
    <label for="<?php echo $field_name; ?>"><span><?php _e( 'Secondary Navigation', 'exmachina' ); ?><span></label>

    <?php echo $after_label; ?>

    <select name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>"<?php echo $select_style; ?>>
      <option value=""<?php echo $option_style; ?>><?php _e( 'ExMachina Default', 'exmachina-simple-menus' ); ?></option>
      <?php
      $menus = wp_get_nav_menus( array( 'orderby' => 'name') );
      foreach ( $menus as $menu )
        printf( '<option value="%d" %s>%s</option>', $menu->term_id, selected( $menu->term_id, $selected, false ), esc_html( $menu->name ) );
      ?>
    </select>

    <?php
  } // end function print_menu_select()

  /**
   * Save Post
   *
   * Handles the post save and stores the menu selection into the post meta.
   *
   * @todo inline comment
   * @todo docblock comment
   *
   * @since 0.5.0
   * @access public
   *
   * @param  [type] $post_id [description]
   * @param  [type] $post    [description]
   * @return [type]          [description]
   */
  function save_post( $post_id, $post ) {

    //  don't try to save the data under autosave, ajax, or future post.
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( defined('DOING_AJAX') && DOING_AJAX ) return;
    if ( defined('DOING_CRON') && DOING_CRON ) return;
    if ( $post->post_type == 'revision' ) return;

    $perm = 'edit_' . ( 'page' == $post->post_type ? 'page' : 'post' ) . 's';
    if ( ! current_user_can( $perm, $post_id ) )
      return;

    if ( empty( $_POST[$this->field_name] ) )
      delete_post_meta( $post_id, $this->field_name );
    else
      update_post_meta( $post_id, $this->field_name, $_POST[$this->field_name] );

  } // end function save_post()

  /**
   * Custom Subnav
   *
   * Executes at the wp_head to determine if the custom meta query uses a
   * custom subnav.
   *
   * @todo inline comment
   * @todo docblock comment
   * @todo rename function
   *
   * @since 0.5.0
   * @access public
   *
   * @return [type] [description]
   */
  function wp_head() {

    add_filter( 'theme_mod_nav_menu_locations', array( $this, 'theme_mod' ) );

    if ( is_singular() ) {

      $obj = get_queried_object();
      $this->menu = get_post_meta( $obj->ID, $this->field_name, true );
      return;

    }

    $term = false;

    if ( is_category() && in_array( 'category', $this->taxonomies ) ) {

      $term = get_term( get_query_var( 'cat' ), 'category' );

    } elseif ( is_tag() && in_array( 'post_tag', $this->taxonomies ) ) {

      $term = get_term( get_query_var( 'tag_id' ), 'post_tag' );

    } elseif( is_tax() ) {

      foreach( $this->taxonomies as $tax ) {

        if( $tax == 'post_tag' || $tax == 'category' )
          continue;

        if( is_tax( $tax ) ) {

          $obj = get_queried_object();
          $term = get_term( $obj->term_id, $tax );
          break;

        }
      }
    }

    if ( $term && isset( $term->meta[$this->field_name] ) )
      $this->menu = $term->meta[$this->field_name];

  } // end function wp_head()

  /**
   * Menu Theme Mod
   *
   * Replace the menu selected in the WordPress menu settings with the custom
   * menu selected.
   *
   * @todo inline comment
   * @todo docblock comment
   *
   * @since 0.5.0
   * @access public
   *
   * @param  [type] $mods [description]
   * @return [type]       [description]
   */
  function theme_mod( $mods ) {

    if ( $this->menu )
      $mods['secondary'] = (int)$this->menu;

    return $mods;

  } // end function theme_mod()

} // end class ExMachina_Custom_Menus

/**
 * Initialize Custom Menus
 *
 * Initializes a new instance of the custom menus extension.
 *
 * @todo wrap in function
 * @var ExMachina_Custom_Menus
 */
$gsm_simple_menu = new ExMachina_Custom_Menus();