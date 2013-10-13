<?php

function hybrid_wrap_open() {
  echo '<div class="wrap">';
}

function hybrid_wrap_close() {
  echo '</div><!-- .wrap -->';
}

add_action( hybrid_get_prefix() . '_header', 'hybrid_wrap_open', 7 );
add_action( hybrid_get_prefix() . '_header', 'hybrid_wrap_close' );

add_action( hybrid_get_prefix() . '_before_main', 'hybrid_wrap_open', 7 );
add_action( hybrid_get_prefix() . '_after_main', 'hybrid_wrap_close' );

add_action( hybrid_get_prefix() . '_before_primary_menu', 'hybrid_wrap_open', 7 );
add_action( hybrid_get_prefix() . '_after_primary_menu', 'hybrid_wrap_close' );

add_action( hybrid_get_prefix() . '_footer', 'hybrid_wrap_open', 7 );
add_action( hybrid_get_prefix() . '_footer', 'hybrid_wrap_close' );

?>