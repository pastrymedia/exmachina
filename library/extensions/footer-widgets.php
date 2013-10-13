<?php
/* Register footer widget areas. */
add_action( 'widgets_init', 'hybrid_register_footer_widget_areas' );

/**
 * Register footer widget areas based on the number of widget areas the user wishes to create with `add_theme_support()`.
 *
 * @since 0.3.4
 *
 * @uses register_sidebar() Register footer widget areas.
 *
 * @return null Return early if there's no theme support.
 */
function hybrid_register_footer_widget_areas() {

	$footer_widgets = get_theme_support( 'footer-widgets' );

	if ( ! $footer_widgets || ! isset( $footer_widgets[0] ) || ! is_numeric( $footer_widgets[0] ) )
		return;

	$footer_widgets = (int) $footer_widgets[0];

	$counter = 1;

	while ( $counter <= $footer_widgets ) {

		/* Set up some default sidebar arguments. */
		$defaults = array(
			'id'            => sprintf( 'footer-%d', $counter ),
			'name'          => sprintf( __( 'Footer %d', 'hybrid-core' ), $counter ),
			'description'   => sprintf( __( 'Footer %d widget area.', 'hybrid-core' ), $counter ),
			'before_widget' => '<section id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-wrap">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h4 class="widget-title widgettitle">',
			'after_title'   => '</h4>'
		);

		register_sidebar( $defaults );

		$counter++;
	}

}


add_action( hybrid_get_prefix() . '_before_footer', 'hybrid_footer_widget_areas' );
/**
 * Echo the markup necessary to facilitate the footer widget areas.
 *
 * Check for a numerical parameter given when adding theme support - if none is found, then the function returns early.
 *
 * The child theme must style the widget areas.
 *
 * Applies the `hybrid_footer_widget_areas` filter.
 *
 * @since 0.3.4
 *
 * @uses hybrid_structural_wrap() Optionally adds wrap with footer-widgets context.
 *
 * @return null Return early if number of widget areas could not be determined, or nothing is added to the first widget area.
 */
function hybrid_footer_widget_areas() {

	$footer_widgets = get_theme_support( 'footer-widgets' );

	if ( ! $footer_widgets || ! isset( $footer_widgets[0] ) || ! is_numeric( $footer_widgets[0] ) )
		return;

	$footer_widgets = (int) $footer_widgets[0];

	//* Check to see if first widget area has widgets. If not, do nothing. No need to check all footer widget areas.
	if ( ! is_active_sidebar( 'footer-1' ) )
		return;

	$inside  = '';
	$output  = '';
 	$counter = 1;

	while ( $counter <= $footer_widgets ) {

		//* Darn you, WordPress! Gotta output buffer.
		ob_start();
		dynamic_sidebar( 'footer-' . $counter );
		$widgets = ob_get_clean();

		$inside .= sprintf( '<div class="footer-widgets-%d widget-area">%s</div>', $counter, $widgets );

		$counter++;

	}

	if ( $inside ) {

		$output .= '<div class="footer-widgets row"><div class="wrap col-'.$footer_widgets.'">';

		$output .= $inside;

		$output .= '</div></div>';

	}

	echo apply_filters( hybrid_get_prefix() . '_footer_widget_areas', $output, $footer_widgets );

}