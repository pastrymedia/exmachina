<?php

/* add meta viewport for responsive layout */
function hybrid_responsive_viewport () {
	echo '<meta name="viewport" content="width=device-width">';
}

add_action('wp_head', 'hybrid_responsive_viewport', 1 );
?>