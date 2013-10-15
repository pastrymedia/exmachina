<?php

/* add meta viewport for responsive layout */
function hybrid_responsive_viewport () {
	echo '<meta name="viewport" content="width=device-width">';
}

add_action('wp_head', 'hybrid_responsive_viewport', 1 );

/* Wrap embeds with some custom HTML to handle responsive layout. */
  add_filter( 'embed_handler_html', 'hybrid_embed_responsive_html' );
  add_filter( 'embed_oembed_html',  'hybrid_embed_responsive_html' );

/**
 * Wraps embeds with <div class="embed-wrap"> to help in making videos responsive.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function hybrid_embed_responsive_html( $html ) {

  if ( in_the_loop() && has_post_format( 'video' ) && preg_match( '/(<embed|object|iframe)/', $html ) )
    $html = '<div class="embed-wrap">' . $html . '</div>';

  return $html;
}

?>