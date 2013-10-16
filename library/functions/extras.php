<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Hybrid
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function hybrid_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'hybrid_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function hybrid_body_classes( $classes ) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome;

	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	/* Browser detection. */
	$browsers = array( 'gecko' => $is_gecko, 'opera' => $is_opera, 'lynx' => $is_lynx, 'ns4' => $is_NS4, 'safari' => $is_safari, 'chrome' => $is_chrome, 'msie' => $is_IE );
	foreach ( $browsers as $key => $value ) {
		if ( $value ) {
			$classes[] = $key;
			break;
		}
	}

	/* Hybrid theme widgets detection. */
	foreach ( array( 'primary', 'secondary', 'subsidiary' ) as $sidebar )
		$classes[] = ( is_active_sidebar( $sidebar ) ) ? "{$sidebar}-active" : "{$sidebar}-inactive";

	if ( in_array( 'primary-inactive', $classes ) && in_array( 'secondary-inactive', $classes ) && in_array( 'subsidiary-inactive', $classes ) )
		$classes[] = 'no-widgets';

	/* get all registered sidebars */
	global $wp_registered_sidebars;

	/* if not empty sidebar */
	if ( ! empty( $wp_registered_sidebars ) ){

		/* foreach widget areas */
		foreach ( $wp_registered_sidebars as $sidebar ){

			/* add active/inactive class */
			$classes[] = is_active_sidebar( $sidebar['id'] ) ? "sidebar-{$sidebar['id']}-active" : "sidebar-{$sidebar['id']}-inactive";
		}
	}

	/* get all registered menus */
	$menus = get_registered_nav_menus();

	/* if not empty menus */
	if ( ! empty( $menus ) ){

		/* for each menus */
		foreach ( $menus as $menu_id => $menu ){

			/* add active/inactive class */
			$classes[] = has_nav_menu( $menu_id ) ? "menu-{$menu_id}-active" : "menu-{$menu_id}-inactive";
		}
	}

	/* make it unique */
	$classes = array_unique( $classes );

	/* Return the array of classes. */
	return $classes;
}
add_filter( 'body_class', 'hybrid_body_classes' );

/**
 * Dynamic HTML Class to target context in body class.
 *
 * @todo add html class markup
 * @todo possibly bring back skin markup
 *
 * @since 0.1.0
 */
function hybrid_html_class( $class = '' ){

	global $wp_query;

	/* default var */
	$classes = array();

	/* not singular pages - sometimes i need this */
	if (! is_singular())
		$classes[] = 'not-singular';

	/* theme layout check */
	if ( current_theme_supports( 'theme-layouts' ) ) {

		/* get current layout */
		$layout = theme_layouts_get_layout();

		/* if current theme layout is 2 column */
		if ( 'layout-default' == $layout || 'layout-2c-l' == $layout || 'layout-2c-r' == $layout )
			$classes[] = 'layout-2c';

		/* if current theme layout is 3 column */
		if ( 'layout-3c-l' == $layout || 'layout-3c-r' == $layout || 'layout-3c-c' == $layout )
			$classes[] = 'layout-3c';
	}

	/* user input */
	if ( ! empty( $class ) ) {
		if ( !is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	}
	else {
		$class = array();
	}

	/* enable filter */
	$classes = apply_atomic( 'html_class', $classes, $class ); //shell_html_class

	/* sanitize it */
	$classes = array_map( 'esc_attr', $classes );

	/* make it unique */
	$classes = array_unique( $classes );

	/* Join all the classes into one string. */
	$class = join( ' ', $classes );

	/* Print html class. */
	echo $class;
}

/**
 * Add Theme Settings menu item to Admin Bar.
 */

function hybrid_adminbar() {

	global $wp_admin_bar;

	$wp_admin_bar->add_menu( array(
			'parent' => 'appearance',
			'id' => 'theme-settings',
			'title' => __( 'Theme Settings', 'hybrid-core' ),
			'href' => admin_url( 'themes.php?page=theme-settings' )
		));
}
add_action( 'wp_before_admin_bar_render', 'hybrid_adminbar' );


/**
 * Return a phrase shortened in length to a maximum number of characters.
 *
 * Result will be truncated at the last white space in the original string. In this function the word separator is a
 * single space. Other white space characters (like newlines and tabs) are ignored.
 *
 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
 *
 * @since 1.4.0
 *
 * @param string $text            A string to be shortened.
 * @param integer $max_characters The maximum number of characters to return.
 *
 * @return string Truncated string
 */
function hybrid_truncate_phrase( $text, $max_characters ) {

	$text = trim( $text );

	if ( mb_strlen( $text ) > $max_characters ) {
		//* Truncate $text to $max_characters + 1
		$text = mb_substr( $text, 0, $max_characters + 1 );

		//* Truncate to the last space in the truncated string
		$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
	}

	return $text;
}

/**
 * Return content stripped down and limited content.
 *
 * Strips out tags and shortcodes, limits the output to `$max_char` characters, and appends an ellipsis and more link to the end.
 *
 * @since 0.1.0
 *
 * @param integer $max_characters The maximum number of characters to return.
 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
 *
 * @return string Limited content.
 */
function get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

	$content = get_the_content( '', $stripteaser );

	//* Strip tags and shortcodes so the content truncation count is done correctly
	$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

	//* Remove inline styles / scripts
	$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

	//* Truncate $content to $max_char
	if ($max_characters < strlen( $content )) {
		$content = hybrid_truncate_phrase( $content, $max_characters );
		$no_more = false;
	} else {
		$no_more = true;
	}

	//* More link?
	if ( $more_link_text && !$no_more )  {
		$link   = apply_filters( 'get_the_content_more_link', sprintf( '&#x02026; <a href="%s" class="more-link">%s</a>', get_permalink(), $more_link_text ), $more_link_text );
		$output = sprintf( '<p>%s %s</p>', $content, $link );
	} else {
		$output = sprintf( '<p>%s</p>', $content );
		$link = '';
	}

	return apply_filters( 'get_the_content_limit', $output, $content, $link, $max_characters );

}

/**
 * Echo the limited content.
 *
 * @since 0.1.0
 *
 * @uses get_the_content_limit() Return content stripped down and limited content.
 *
 * @param integer $max_characters The maximum number of characters to return.
 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
 */
function the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

	$content = get_the_content_limit( $max_characters, $more_link_text, $stripteaser );
	echo apply_filters( 'the_content_limit', $content );

}


/* Additional css classes for widgets */
	add_filter( 'dynamic_sidebar_params', 'hybrid_widget_classes' );
/**
 * Additional widget classes with number of each widget position and first/last widget class.
 * This is a modified code from Sukelius Magazine Theme.
 *
 * @link http://themehybrid.com/themes/sukelius-magazine
 * @since 0.1.0
 */
function hybrid_widget_classes( $params ) {

	/* Global a counter array */
	global $hybrid_widget_num;

	/* Get the id for the current sidebar we're processing */
	$this_id = $params[0]['id'];

	/* Get registered widgets */
	$arr_registered_widgets = wp_get_sidebars_widgets();

	/* If the counter array doesn't exist, create it */
	if ( !$hybrid_widget_num ) {
		$hybrid_widget_num = array();
	}

	/* if current sidebar has no widget, return. */
	if ( !isset( $arr_registered_widgets[$this_id] ) || !is_array( $arr_registered_widgets[$this_id] ) ) {
		return $params;
	}

	/* See if the counter array has an entry for this sidebar */
	if ( isset( $hybrid_widget_num[$this_id] ) ) {
		$hybrid_widget_num[$this_id] ++;
	}
	/* If not, create it starting with 1 */
	else {
		$hybrid_widget_num[$this_id] = 1;
	}

	/* Add a widget number class for additional styling options */
	$class = 'class="widget widget-' . $hybrid_widget_num[$this_id] . ' ';

	/* in first widget, add 'widget-first' class */
	if ( $hybrid_widget_num[$this_id] == 1 ) {
		$class .= 'widget-first ';
	}
	/* in last widget, add 'widget-last' class */
	elseif( $hybrid_widget_num[$this_id] == count( $arr_registered_widgets[$this_id] ) ) {
		$class .= 'widget-last ';
	}

	/* str replace before_widget param with new class */
	$params[0]['before_widget'] = str_replace( 'class="widget ', $class, $params[0]['before_widget'] );

	return $params;
}

/* Hybrid Core Context */
	add_filter( 'hybrid_context', 'shell_hybrid_context' );
/**
 * Add Current Post template, Post Format, and Attachment Mime Type to Hybrid Core Context
 *
 * @todo integrate into main context function
 * @todo add canvas page template context
 * @since 0.1.0
 */
function shell_hybrid_context( $context ){

	/* Singular post (post_type) classes. */
	if ( is_singular() ) {

		/* Get the queried post object. */
		$post = get_queried_object();

		/* Checks for custom template. */
		$template = str_replace( array ( "{$post->post_type}-template-", "{$post->post_type}-" ), '', basename( get_post_meta( get_queried_object_id(), "_wp_{$post->post_type}_template", true ), '.php' ) );
		if ( !empty( $template ) )
			$context[] = "{$post->post_type}-template-{$template}";

		/* Post format. */
		if ( current_theme_supports( 'post-formats' ) && post_type_supports( $post->post_type, 'post-formats' ) ) {
			$post_format = get_post_format( get_queried_object_id() );
			$context[] = ( ( empty( $post_format ) || is_wp_error( $post_format ) ) ? "{$post->post_type}-format-standard" : "{$post->post_type}-format-{$post_format}" );
		}

		/* Attachment mime types. */
		if ( is_attachment() ) {
			foreach ( explode( '/', get_post_mime_type() ) as $type )
				$context[] = "attachment-{$type}";
		}
	}

	/* make it unique */
	$context = array_unique( $context );

	return $context;
}

/* Post format singular template */
	add_filter( 'single_template', 'shell_post_format_singular_template', 11 );

/**
 * Add Singular Post Format Template
 *
 * @link http://themehybrid.com/support/topic/add-post-format-singular-template-in-template-hierarchy#post-75579
 * @since 0.1.0
 */
function shell_post_format_singular_template( $template ){

	/* get queried object */
	$post = get_queried_object();

	/* check supported post type */
	if ( post_type_supports( $post->post_type, 'post-formats' ) ) {

		/* get post format of current object */
		$format = get_post_format( get_queried_object_id() );

		/* template */
		$templates = array(
			"{$post->post_type}-{$post->post_name}.php",
			"{$post->post_type}-{$post->ID}.php",
			"{$post->post_type}-format-{$format}.php"
		);

		/* locate template */
		$has_template = locate_template( $templates );

		if ( $has_template )
			$template = $has_template;
	}

	return $template;
}