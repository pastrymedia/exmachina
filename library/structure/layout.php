<?php
/**
 * Hybrid Framework
 *
 * WARNING: This file is part of the core Hybrid Framework DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Hybrid\Layout
 * @author  Machina Themes
 * @license GPL-2.0+
 * @link    http://machinathemes.com
 */


/* Add the before content breadcrumbs before the content. */
add_action( hybrid_get_prefix() . '_before_content', 'hybrid_get_breadcrumbs' );

/**
 * Display sidebar
 */
function hybrid_get_breadcrumbs() {

  if ( current_theme_supports( 'breadcrumb-trail' ) ) {

  breadcrumb_trail(
    array(
      'container' => 'nav',
      'separator' => '>',
      'labels'    => array(
        'browse' => __( 'You are here:', 'hybrid-base' )
      )
    )
  );

}

}

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What
 * happens is the theme's background image hides the user-selected background color.  If a user selects a
 * background image, we'll just use the WordPress custom background callback.
 *
 * @since 0.1.0
 * @access public
 * @link http://core.trac.wordpress.org/ticket/16919
 * @return void
 */
function hybrid_custom_background_callback() {

  // $background is the saved custom image or the default image.
  $background = get_background_image();

  // $color is the saved custom color or the default image.
  $color = get_background_color();

  if ( ! $background && ! $color )
    return;

  $style = $color ? "background-color: #$color;" : '';

  if ( $background ) {
    $image = " background-image: url('$background');";

    $repeat = get_theme_mod( 'background_repeat', 'repeat' );
    if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
      $repeat = 'repeat';
    $repeat = " background-repeat: $repeat;";

    $position = get_theme_mod( 'background_position_x', 'left' );
    if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
      $position = 'left';
    $position = " background-position: top $position;";

    $attachment = get_theme_mod( 'background_attachment', 'scroll' );
    if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
      $attachment = 'scroll';
    $attachment = " background-attachment: $attachment;";

    $style .= $image . $repeat . $position . $attachment;
  }

?>
<style type="text/css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php

}

