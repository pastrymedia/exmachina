<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Media Grabber Class
 *
 * media-grabber.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * The Media Grabber class is a script for pulling media either from the post
 * content or attached to the post.
 *
 * @package     ExMachina
 * @subpackage  Classes
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin class
###############################################################################

/**
 * Media Grabber Wrapper
 *
 * Wrapper function for the ExMachina_Media_Grabber class. Returns the HTML
 * output for the found media.
 *
 * @uses ExMachina_Media_Grabber::get_media() [description]
 *
 * @since  2.7.0
 * @access public
 *
 * @param  array  $args Array of media grabber arguments.
 * @return string       Returns the found media.
 */
function exmachina_media_grabber( $args = array() ) {

  $media = new ExMachina_Media_Grabber( $args );

  return $media->get_media();

} // end function exmachina_media_grabber()

/**
 * Media Grabber Class
 *
 * Grabs media elements related to the post.
 *
 * @since 2.7.0
 * @access public
 *
 * @return void
 */
class ExMachina_Media_Grabber {

  /**
   * Media Grabber Public Variables
   *
   * Defines the public variables that will be used throughout the class.
   *
   * @since 2.7.0
   * @access public
   *
   * @var string  $media          The HTML version of the media to return.
   * @var string  $original_media The original media taken from the post content.
   * @var string  $type           The type of media to get. Currently supports 'audio' and 'video'.
   * @var array   $args           Arguments passed into the class and parsed with the defaults.
   * @var string  $content        The content to search for embedded media within.
   */
  public $media = '';
  public $original_media = '';
  public $type = 'video';
  public $args = array();
  public $content = '';

  /**
   * Media Grabber Constructor
   *
   * Constructor method to set up the Media Grabber class. This method adds the
   * embed filters, sets the defaults, sets the object properties, and finds the
   * media related to the post.
   *
   * @link http://codex.wordpress.org/Embeds
   * @link http://codex.wordpress.org/Function_Reference/get_the_ID
   * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
   * @link http://codex.wordpress.org/Function_Reference/get_post_field
   *
   * @uses ExMachina_Media_Grabber::set_media() Finds the media related to the post.
   *
   * @since 2.7.0
   * @access public
   *
   * @global object  $wp_embed      The WP Embed object.
   * @global integer $content_width The content width for media embeds.
   * @param  array   $args          Arguments array.
   * @return void
   */
  public function __construct( $args = array() ) {
    global $wp_embed, $content_width;

    /* Use WP's embed functionality to handle the [embed] shortcode and autoembeds. */
    add_filter( 'exmachina_media_grabber_embed_shortcode_media', array( $wp_embed, 'run_shortcode' ) );
    add_filter( 'exmachina_media_grabber_autoembed_media',       array( $wp_embed, 'autoembed' ) );

    /* Don't return a link if embeds don't work. Need media or nothing at all. */
    add_filter( 'embed_maybe_make_link', '__return_false' );

    /* Set up the default arguments. */
    $defaults = array(
      'post_id'     => get_the_ID(),   // post ID (assumes within The Loop by default)
      'type'        => 'video',        // audio|video
      'before'      => '',             // HTML before the output
      'after'       => '',             // HTML after the output
      'split_media' => false,          // Splits the media from the post content
      'width'       => $content_width, // Custom width. Defaults to the theme's content width.
    );

    /* Set the object properties. */
    $this->args    = apply_filters( 'exmachina_media_grabber_args', wp_parse_args( $args, $defaults ) );
    $this->content = get_post_field( 'post_content', $this->args['post_id'] );
    $this->type    = isset( $this->args['type'] ) && in_array( $this->args['type'], array( 'audio', 'video' ) ) ? $this->args['type'] : 'video';

    /* Find the media related to the post. */
    $this->set_media();

  } // end public function __construct()

  /**
   * Media Grabber Destructor
   *
   * Destructor method. Removes the added filters from the Media Grabber class.
   *
   * @link http://codex.wordpress.org/Function_Reference/remove_filter
   *
   * @since 2.7.0
   * @access public
   *
   * @return void
   */
  public function __destruct() {

    remove_filter( 'embed_maybe_make_link', '__return_false' );

  } // end public function __destruct()

  /**
   * Get Media
   *
   * Basic method for return the media found.
   *
   * @since 2.7.0
   * @access public
   *
   * @return string
   */
  public function get_media() {

    return apply_filters( 'exmachina_media_grabber_media', $this->media, $this );

  } // end public function get_media()

  /**
   * Set Media
   *
   * Tries several methods to find media related to the post. Returns the found
   * media.
   *
   * @link http://codex.wordpress.org/Function_Reference/get_option
   *
   * @uses ExMachina_Media_Grabber::do_shortcode_media() [description]
   * @uses ExMachina_Media_Grabber::do_autoembed_media() [description]
   * @uses ExMachina_Media_Grabber::do_embedded_media() [description]
   * @uses ExMachina_Media_Grabber::do_attached_media() [description]
   * @uses ExMachina_Media_Grabber::split_media() [description]
   * @uses ExMachina_Media_Grabber::filter_dimensions() [description]
   *
   * @since  2.7.0
   * @access public
   *
   * @return void
   */
  public function set_media() {

    /* Find media in the post content based on WordPress' media-related shortcodes. */
    $this->do_shortcode_media();

    /* If no media is found and autoembeds are enabled, check for autoembeds. */
    if ( empty( $this->media ) && get_option( 'embed_autourls' ) )
      $this->do_autoembed_media();

    /* If no media is found, check for media HTML within the post content. */
    if ( empty( $this->media ) )
      $this->do_embedded_media();

    /* If no media is found, check for media attached to the post. */
    if ( empty( $this->media ) )
      $this->do_attached_media();

    /* If media is found, let's run a few things. */
    if ( !empty( $this->media ) ) {

      /* Add the before HTML. */
      if ( isset( $this->args['before'] ) )
        $this->media = $this->args['before'] . $this->media;

      /* Add the after HTML. */
      if ( isset( $this->args['after'] ) )
        $this->media .= $this->args['after'];

      /* Split the media from the content. */
      if ( true === $this->args['split_media'] && !empty( $this->original_media ) )
        add_filter( 'the_content', array( $this, 'split_media' ), 5 );

      /* Filter the media dimensions. */
      $this->media = $this->filter_dimensions( $this->media );
    }

  } // end public function set_media()

  /**
   * Do Shortcode Media
   *
   * figures out the shortcode used in the content. Once it's found, the appropriate
   * method for the shortcode is executed.
   *
   * @link http://codex.wordpress.org/Function_Reference/get_shortcode_regex
   *
   * @uses ExMachina_Media_Grabber::do_embed_shortcode_media() [description]
   * @uses ExMachina_Media_Grabber::do_audio_shortcode_media() [description]
   * @uses ExMachina_Media_Grabber::do_video_shortcode_media() [description]
   * @uses ExMachina_Media_Grabber::do_autoembed_media() [description]
   * @uses ExMachina_Media_Grabber::do_embedded_media() [description]
   * @uses ExMachina_Media_Grabber::do_attached_media() [description]
   *
   * @since 2.7.0
   * @access public
   *
   * @return void
   */
  public function do_shortcode_media() {

    /* Finds matches for shortcodes in the content. */
    preg_match_all( '/' . get_shortcode_regex() . '/s', $this->content, $matches, PREG_SET_ORDER );

    /* If matches are found, loop through them and check if they match one of WP's media shortcodes. */
    if ( !empty( $matches ) ) {

      foreach ( $matches as $shortcode ) {

        /* Call the method related to the specific shortcode found and break out of the loop. */
        if ( in_array( $shortcode[2], array( 'embed', $this->type ) ) ) {
          call_user_func( array( $this, "do_{$shortcode[2]}_shortcode_media" ), $shortcode );
          break;
        }
      }
    }

  } // end public function do_shortcode_media()

  /**
   * Do Embed Shortcode Media
   *
   * Handles the HTML when the [embed] shortcode is used.
   *
   * @since 2.7.0
   * @access public
   *
   * @param  array $shortcode [description]
   * @return void
   */
  public function do_embed_shortcode_media( $shortcode ) {

    $this->original_media = array_shift( $shortcode );

    $this->media = apply_filters(
      'exmachina_media_grabber_embed_shortcode_media',
      $this->original_media
    );

  } // end public function do_embed_shortcode_media()

  /**
   * Do Audio Shortcode
   *
   * Handles the HTML when the [audio] shortcode is used.
   *
   * @link http://codex.wordpress.org/Function_Reference/do_shortcode
   *
   * @since 2.7.0
   * @access public
   *
   * @param  array $shortcode [description]
   * @return void
   */
  public function do_audio_shortcode_media( $shortcode ) {

    $this->original_media = array_shift( $shortcode );

    $this->media = do_shortcode( $this->original_media );

  } // end public function do_audio_shortcode_media()

  /**
   * Do Video Shortcode
   *
   * Handles the HTML when the [video] shortcode is used.
   *
   * @link http://codex.wordpress.org/Function_Reference/do_shortcode
   *
   * @uses ExMachina_Media_Grabber::filter_dimensions() [description]
   *
   * @since 2.7.0
   * @access public
   *
   * @param  array $shortcode [description]
   * @return void
   */
  public function do_video_shortcode_media( $shortcode ) {

    $this->original_media = array_shift( $shortcode );

    /* Need to filter dimensions here to overwrite WP's <div> surrounding the [video] shortcode. */
    $this->media = do_shortcode( $this->filter_dimensions( $this->original_media ) );

  } // end public function do_video_shortcode_media()

  /**
   * Do Autoembed Media
   *
   * Uses WordPress' autoembed feature to automatically to handle media that's
   * just input as a URL.
   *
   * @since 2.7.0
   * @access public
   *
   * @return void
   */
  public function do_autoembed_media() {

    preg_match_all( '|^\s*(https?://[^\s"]+)\s*$|im', $this->content, $matches, PREG_SET_ORDER );

    /* If URL matches are found, loop through them to see if we can get an embed. */
    if ( is_array( $matches ) ) {

      foreach ( $matches as $value ) {

        /* Let WP work its magic with the 'autoembed' method. */
        $embed = trim( apply_filters( 'exmachina_media_grabber_autoembed_media', $value[0] ) );

        if ( !empty( $embed ) ) {
          $this->original_media = $value[0];
          $this->media = $embed;
          break;
        }
      }
    }

  } // end public function do_autoembed_media()

  /**
   * Do Embedded Media
   *
   * Grabs media embbeded into the content within <iframe>, <object>, <embed>,
   * and other HTML methods for embedding media.
   *
   * @since 2.7.0
   * @access public
   *
   * @return void
   */
  public function do_embedded_media() {

    $embedded_media = get_media_embedded_in_content( $this->content );

    if ( !empty( $embedded_media ) )
      $this->media = $this->original_media = array_shift( $embedded_media );

  } // end public function do_embedded_media()

  /**
   * Do Attached Media
   *
   * Gets media attached to the post. Then, uses the WordPress [audio] or [video]
   * shortcode to handle the HTML output of the media.
   *
   * @link http://codex.wordpress.org/Function_Reference/get_attached_media
   * @link http://codex.wordpress.org/Function_Reference/wp_get_attachment_url
   * @link http://codex.wordpress.org/Function_Reference/do_shortcode
   *
   * @since 2.7.0
   * @access public
   *
   * @return void
   */
  public function do_attached_media() {

    /* Gets media attached to the post by mime type. */
    $attached_media = get_attached_media( $this->type, $this->args['post_id'] );

    /* If media is found. */
    if ( !empty( $attached_media ) ) {

      /* Get the first attachment/post object found for the post. */
      $post = array_shift( $attached_media );

      /* Gets the URI for the attachment (the media file). */
      $url = wp_get_attachment_url( $post->ID );

      /* Run the media as a shortcode using WordPress' built-in [audio] and [video] shortcodes. */
      $this->media = do_shortcode( "[{$this->type} src='{$url}']" );
    }

  } // end public function do_attached_media()

  /**
   * Split Media
   *
   * Removes the found media from the content. The purpose of this is so that
   * themes can retrieve the media from the content and display it elsewhere on
   * the page based on its design.
   *
   * @link http://codex.wordpress.org/Function_Reference/remove_filter
   *
   * @since 2.7.0
   * @access public
   *
   * @param  string $content [description]
   * @return string
   */
  public function split_media( $content ) {

    remove_filter( 'the_content', array( $this, 'split_media' ), 5 );

    return str_replace( $this->original_media, '', $content );

  } // end public function split_media()

  /**
   * Filter Dimensions
   *
   * Method for filtering the media's 'width' and 'height' attributes so that
   * the theme can handle the dimensions how it sees fit.
   *
   * @link http://codex.wordpress.org/Function_Reference/wp_kses_hair
   * @link http://codex.wordpress.org/Function_Reference/wp_expand_dimensions
   *
   * @uses ExMachina_Media_Grabber::spotify_dimensions() [description]
   *
   * @since 2.7.0
   * @access public
   *
   * @param  string $html [description]
   * @return string       [description]
   */
  public function filter_dimensions( $html ) {

    /* Find the attributes of the media. */
    $atts = wp_kses_hair( $html, array( 'http', 'https' ) );

    /* Loop through the media attributes and add them in key/value pairs. */
    foreach ( $atts as $att )
      $media_atts[ $att['name'] ] = $att['value'];

    /* If no dimensions are found, just return the HTML. */
    if ( empty( $media_atts ) || !isset( $media_atts['width'] ) || !isset( $media_atts['height'] ) )
      return $html;

    /* Set the max width. */
    $max_width = $this->args['width'];

    /* Set the max height based on the max width and original width/height ratio. */
    $max_height = round( $max_width / ( $media_atts['width'] / $media_atts['height'] ) );

    /* Fix for Spotify embeds. */
    if ( !empty( $media_atts['src'] ) && preg_match( '#https?://(embed)\.spotify\.com/.*#i', $media_atts['src'], $matches ) )
      list( $max_width, $max_height ) = $this->spotify_dimensions( $media_atts );

    /* Calculate new media dimensions. */
    $dimensions = wp_expand_dimensions(
      $media_atts['width'],
      $media_atts['height'],
      $max_width,
      $max_height
    );

    /* Allow devs to filter the final width and height of the media. */
    list( $width, $height ) = apply_filters(
      'exmachina_media_grabber_dimensions',
      $dimensions,                       // width/height array
      $media_atts,                       // media HTML attributes
      $this                              // media grabber object
    );

    /* Set up the patterns for the 'width' and 'height' attributes. */
    $patterns = array(
      '/(width=[\'"]).+?([\'"])/i',
      '/(height=[\'"]).+?([\'"])/i',
      '/(<div.+?style=[\'"].*?width:.+?).+?(px;.+?[\'"].*?>)/i'
    );

    /* Set up the replacements for the 'width' and 'height' attributes. */
    $replacements = array(
      '${1}' . $width . '${2}',
      '${1}' . $height . '${2}',
      '${1}' . $width . '${2}'
    );

    /* Filter the dimensions and return the media HTML. */
    return preg_replace( $patterns, $replacements, $html );

  } // end public function filter_dimensions()

  /**
   * Spotify Dimensions
   *
   * Fix for Spotify embeds because they're the only embeddable service that
   * doesn't work that well with custom-sized embeds.  So, we need to adjust
   * this the best we can. Right now, the only embed size that works for
   * full-width embeds is the "compact" player (height of 80).
   *
   * @since 2.7.0
   * @access public
   *
   * @param  array $media_atts [description]
   * @return array             [description]
   */
  public function spotify_dimensions( $media_atts ) {

    $max_width  = $media_atts['width'];
    $max_height = $media_atts['height'];

    if ( 80 == $media_atts['height'] )
      $max_width  = $this->args['width'];

    return array( $max_width, $max_height );

  } // end public function spotify_dimensions()

} // end class ExMachina_Media_Grabber

