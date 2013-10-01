<?php
/**
 * ExMachina Framework.
 *
 * WARNING: This file is part of the core ExMachina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package ExMachina\Footer
 * @author  Machina Themes
 * @license GPL-2.0+
 * @link    http://www.machinathemes.com/
 */

add_action( 'exmachina_before_footer', 'exmachina_footer_widget_areas' );
/**
 * Echo the markup necessary to facilitate the footer widget areas.
 *
 * Check for a numerical parameter given when adding theme support - if none is found, then the function returns early.
 *
 * The child theme must style the widget areas.
 *
 * Applies the `exmachina_footer_widget_areas` filter.
 *
 * @since 1.6.0
 *
 * @uses exmachina_structural_wrap() Optionally adds wrap with footer-widgets context.
 *
 * @return null Return early if number of widget areas could not be determined, or nothing is added to the first widget area.
 */
function exmachina_footer_widget_areas() {

	$footer_widgets = get_theme_support( 'exmachina-footer-widgets' );

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

		$output .= exmachina_markup( array(
			'html5'   => '<div %s>',
			'xhtml'   => '<div id="footer-widgets" class="footer-widgets">',
			'context' => 'footer-widgets',
		) );

		$output .= exmachina_structural_wrap( 'footer-widgets', 'open', 0 );

		$output .= $inside;

		$output .= exmachina_structural_wrap( 'footer-widgets', 'close', 0 );

		$output .= '</div>';

	}

	echo apply_filters( 'exmachina_footer_widget_areas', $output, $footer_widgets );

}

add_action( 'exmachina_footer', 'exmachina_footer_markup_open', 5 );
/**
 * Echo the opening div tag for the footer.
 *
 * Also optionally adds wrapping div opening tag.
 *
 * @since 1.2.0
 *
 * @uses exmachina_structural_wrap() Maybe add opening .wrap div tag with footer context.
 * @uses exmachina_markup()          Apply contextual markup.
 */
function exmachina_footer_markup_open() {

	exmachina_markup( array(
		'html5'   => '<footer %s>',
		'xhtml'   => '<div id="footer" class="footer">',
		'context' => 'site-footer',
	) );
	exmachina_structural_wrap( 'footer', 'open' );

}

add_action( 'exmachina_footer', 'exmachina_footer_markup_close', 15 );
/**
 * Echo the closing div tag for the footer.
 *
 * Also optionally adds wrapping div closing tag.
 *
 * @since 1.2.0
 *
 * @uses exmachina_structural_wrap() Maybe add closing .wrap div tag with footer context.
 * @uses exmachina_markup()          Apply contextual markup.
 */
function exmachina_footer_markup_close() {

	exmachina_structural_wrap( 'footer', 'close' );
	exmachina_markup( array(
		'html5'   => '</footer>',
		'xhtml'   => '</div>',
	) );

}

add_filter( 'exmachina_footer_output', 'do_shortcode', 20 );
add_action( 'exmachina_footer', 'exmachina_do_footer' );
/**
 * Echo the contents of the footer.
 *
 * Execute any shortcodes that might be present.
 *
 * Applies `exmachina_footer_backtotop_text`, `exmachina_footer_creds_text` and `exmachina_footer_output` filters.
 *
 * For HTML5 themes, only the credits text is used (back-to-top link is dropped).
 *
 * @since 1.0.1
 *
 * @uses exmachina_html5() Check for HTML5 support.
 *
 */
function exmachina_do_footer() {

	//* Build the text strings. Includes shortcodes
	$creds_text     = wpautop( exmachina_get_option( 'footer_insert' ) );

	//* Filter the text strings
	$creds_text     = apply_filters( 'exmachina_footer_creds_text', $creds_text );

	$output = '<p>' . $creds_text . '</p>';

	echo apply_filters( 'exmachina_footer_output', $output, $creds_text );

}

add_filter( 'exmachina_footer_scripts', 'do_shortcode' );
add_action( 'wp_footer', 'exmachina_footer_scripts' );
/**
 * Echo the footer scripts, defined in Theme Settings.
 *
 * Applies the `exmachina_footer_scripts` filter to the value returns from the footer_scripts option.
 *
 * @since 1.1.0
 *
 * @uses exmachina_option() Get theme setting value.
 */
function exmachina_footer_scripts() {

	echo apply_filters( 'exmachina_footer_scripts', exmachina_option( 'footer_scripts' ) );

}