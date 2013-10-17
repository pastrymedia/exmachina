<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Shortcodes
 *
 * shortcodes.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Shortcodes bundled for use with themes. These shortcodes are not meant to be
 * used with the post content editor. Their purpose is to make it easier for users
 * to filter hooks without having to know too much PHP code and to provide access
 * to specific functionality in other (non-post content) shortcode-aware areas.
 *
 * Note that some shortcodes are specific to posts and comments and would be
 * useless outside of the post and comment loops. To use the shortcodes, a theme
 * must register support for 'exmachina-core-shortcodes'.
 *
 * @package     ExMachina
 * @subpackage  Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/* Register shortcodes. */
add_action( 'init', 'exmachina_add_shortcodes' );

/**
 * Add Shortcodes
 *
 * Creates new shortcodes for use in any shortcode-ready area. This function
 * uses the add_shortcode() function to register new shortcodes with WordPress.
 *
 * @link http://codex.wordpress.org/Shortcode_API
 * @link http://codex.wordpress.org/Function_Reference/add_shortcode
 *
 * @since 2.5.0
 * @access public
 *
 * @return void
 */
function exmachina_add_shortcodes() {

	/* Add theme-specific shortcodes. */
	add_shortcode( 'the-year',      'exmachina_the_year_shortcode' );
	add_shortcode( 'site-link',     'exmachina_site_link_shortcode' );
	add_shortcode( 'wp-link',       'exmachina_wp_link_shortcode' );
	add_shortcode( 'theme-link',    'exmachina_theme_link_shortcode' );
	add_shortcode( 'child-link',    'exmachina_child_link_shortcode' );
	add_shortcode( 'loginout-link', 'exmachina_loginout_link_shortcode' );
	add_shortcode( 'query-counter', 'exmachina_query_counter_shortcode' );
	add_shortcode( 'nav-menu',      'exmachina_nav_menu_shortcode' );

	/* Add entry-specific shortcodes. */
	add_shortcode( 'entry-title',         'exmachina_entry_title_shortcode' );
	add_shortcode( 'entry-author',        'exmachina_entry_author_shortcode' );
	add_shortcode( 'entry-terms',         'exmachina_entry_terms_shortcode' );
	add_shortcode( 'entry-comments-link', 'exmachina_entry_comments_link_shortcode' );
	add_shortcode( 'entry-published',     'exmachina_entry_published_shortcode' );
	add_shortcode( 'entry-edit-link',     'exmachina_entry_edit_link_shortcode' );
	add_shortcode( 'entry-shortlink',     'exmachina_entry_shortlink_shortcode' );
	add_shortcode( 'entry-permalink',     'exmachina_entry_permalink_shortcode' );
	add_shortcode( 'post-format-link',    'exmachina_post_format_link_shortcode' );

	/* Add comment-specific shortcodes. */
	add_shortcode( 'comment-published',  'exmachina_comment_published_shortcode' );
	add_shortcode( 'comment-author',     'exmachina_comment_author_shortcode' );
	add_shortcode( 'comment-edit-link',  'exmachina_comment_edit_link_shortcode' );
	add_shortcode( 'comment-reply-link', 'exmachina_comment_reply_link_shortcode' );
	add_shortcode( 'comment-permalink',  'exmachina_comment_permalink_shortcode' );

	/* Add general function shortcodes. */
	add_shortcode( 'entry-mood', 'exmachina_entry_mood_shortcode' );

} // end function exmachina_add_shortcodes()

/*-------------------------------------------------------------------------*/
/* == Theme-specific Shortcodes */
/*-------------------------------------------------------------------------*/

/**
 * Shortcode to display the current year.
 *
 * @since 2.5.0
 * @access public
 *
 * @return string
 */
function exmachina_the_year_shortcode() {

	return date( __( 'Y', 'exmachina-core' ) );

} // end function exmachina_the_year_shortcode()

/**
 * Shortcode to display a link back to the site.
 *
 * @link http://codex.wordpress.org/Function_Reference/home_url
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 * @link http://codex.wordpress.org/Function_Reference/get_bloginfo
 *
 * @since 2.5.0
 * @access public
 *
 * @return string
 */
function exmachina_site_link_shortcode() {

	return '<a class="site-link" href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home"><span>' . get_bloginfo( 'name' ) . '</span></a>';

} // end function exmachina_site_link_shortcode()

/**
 * Shortcode to display a link to WordPress.org.
 *
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 *
 * @since 2.5.0
 * @access public
 * @return string
 */
function exmachina_wp_link_shortcode() {

	return '<a class="wp-link" href="http://wordpress.org" title="' . esc_attr__( 'State-of-the-art semantic personal publishing platform', 'exmachina-core' ) . '"><span>' . __( 'WordPress', 'exmachina-core' ) . '</span></a>';

} // end function exmachina_wp_link_shortcode()

/**
 * Shortcode to display a link to the parent theme page.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
 * @link http://codex.wordpress.org/Function_Reference/get_template
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 *
 * @since 2.5.0
 * @access public
 *
 * @return string
 */
function exmachina_theme_link_shortcode() {

	/* Get the template theme data. */
	$theme = wp_get_theme( get_template() );
	return '<a class="theme-link" href="' . esc_url( $theme->get( 'ThemeURI' ) ) . '" title="' . sprintf( esc_attr__( '%s WordPress Theme', 'exmachina-core' ), $theme->get( 'Name' ) ) . '"><span>' . esc_attr( $theme->get( 'Name' ) ) . '</span></a>';

} // end function exmachina_theme_link_shortcode()

/**
 * Shortcode to display a link to the child theme's page.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 * @link http://codex.wordpress.org/Function_Reference/esc_html
 *
 * @since 2.5.0
 * @access public
 *
 * @return string
 */
function exmachina_child_link_shortcode() {

	/* Get the theme data. */
	$theme = wp_get_theme();
	return '<a class="child-link" href="' . esc_url( $theme->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $theme->get( 'Name' ) ) . '"><span>' . esc_html( $theme->get( 'Name' ) ) . '</span></a>';
} // end function exmachina_child_link_shortcode()

/**
 * Shortcode to display a login link or logout link.
 *
 * @link http://codex.wordpress.org/Function_Reference/is_user_logged_in
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/wp_logout_url
 * @link http://codex.wordpress.org/Function_Reference/site_url
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 * @link http://codex.wordpress.org/Function_Reference/wp_login_url
 *
 * @since 2.5.0
 * @access public
 *
 * @return string
 */
function exmachina_loginout_link_shortcode() {

	if ( is_user_logged_in() )
		$out = '<a class="logout-link" href="' . esc_url( wp_logout_url( site_url( $_SERVER['REQUEST_URI'] ) ) ) . '" title="' . esc_attr__( 'Log out', 'exmachina-core' ) . '">' . __( 'Log out', 'exmachina-core' ) . '</a>';
	else
		$out = '<a class="login-link" href="' . esc_url( wp_login_url( site_url( $_SERVER['REQUEST_URI'] ) ) ) . '" title="' . esc_attr__( 'Log in', 'exmachina-core' ) . '">' . __( 'Log in', 'exmachina-core' ) . '</a>';

	return $out;

} // end function exmachina_loginout_link_shortcode()

/**
 * Displays query count and load time if the current user can edit themes.
 *
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 * @link http://codex.wordpress.org/Function_Reference/timer_stop
 * @link http://codex.wordpress.org/Function_Reference/get_num_queries
 *
 * @since 2.5.0
 * @access public
 *
 * @return string
 */
function exmachina_query_counter_shortcode() {

	if ( current_user_can( 'edit_theme_options' ) )
		return sprintf( __( 'This page loaded in %1$s seconds with %2$s database queries.', 'exmachina-core' ), timer_stop( 0, 3 ), get_num_queries() );
	return '';

} // end function exmachina_query_counter_shortcode()

/**
 * Displays a nav menu that has been created from the Menus screen in the admin.
 *
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_nav_menu_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'menu'            => '',
			'container'       => 'div',
			'container_id'    => '',
			'container_class' => 'nav-menu',
			'menu_id'         => '',
			'menu_class'      => '',
			'link_before'     => '',
			'link_after'      => '',
			'before'          => '',
			'after'           => '',
			'fallback_cb'     => 'wp_page_menu',
			'walker'          => ''
		),
		$attr,
		'nav-menu'
	);
	$attr['echo'] = false;

	return wp_nav_menu( $attr );

} // end function exmachina_nav_menu_shortcode()

/*-------------------------------------------------------------------------*/
/* == Entry-specific Shortcodes */
/*-------------------------------------------------------------------------*/

/**
 * Displays a post's title with a link to the post.
 *
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 * @link http://codex.wordpress.org/Function_Reference/tag_escape
 * @link http://codex.wordpress.org/Function_Reference/sanitize_html_class
 * @link http://codex.wordpress.org/Function_Reference/get_post_type
 * @link http://codex.wordpress.org/Function_Reference/the_title
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_entry_title_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'permalink' => true,
			'tag'       => is_singular() ? 'h1' : 'h2'
		),
		$attr,
		'entry-title'
	);

	$tag = tag_escape( $attr['tag'] );
	$class = sanitize_html_class( get_post_type() ) . '-title entry-title';

	if ( false == (bool)$attr['permalink'] )
		$title = the_title( "<{$tag} class='{$class}'>", "</{$tag}>", false );
	else
		$title = the_title( "<{$tag} class='{$class}'><a href='" . get_permalink() . "'>", "</a></{$tag}>", false );

	return $title;

} // end function exmachina_entry_title_shortcode()

/**
 * Displays an individual post's author with a link to his or her archive.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_post_type
 * @link http://codex.wordpress.org/Function_Reference/post_type_supports
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/get_author_posts_url
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_entry_author_shortcode( $attr ) {

	$post_type = get_post_type();

	if ( post_type_supports( $post_type, 'author' ) ) {

		$attr = shortcode_atts(
			array(
				'before' => '',
				'after'  => ''
			),
			$attr,
			'entry-author'
		);

		$author = '<span class="entry-author author vcard" itemtype="http://schema.org/Person" itemscope="itemscope" itemprop="author"><a class="entry-author-link url fn n" rel="author" itemprop="url" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . '"><span itemprop="name" class="entry-author-name">' . get_the_author_meta( 'display_name' ) . '</span></a></span>';

		return $attr['before'] . $author . $attr['after'];
	}

	return '';

} // end function exmachina_entry_author_shortcode()

/**
 * Displays a list of terms for a specific taxonomy.
 *
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/get_the_ID
 * @link http://codex.wordpress.org/Function_Reference/get_the_term_list
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_entry_terms_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'id'        => get_the_ID(),
			'taxonomy'  => 'post_tag',
			'separator' => ', ',
			'before'    => '',
			'after'     => ''
		),
		$attr,
		'entry-terms'
	);

	$attr['before'] = ( empty( $attr['before'] ) ? '<span class="' . $attr['taxonomy'] . '">' : '<span class="' . $attr['taxonomy'] . '"><span class="before">' . $attr['before'] . '</span>' );
	$attr['after'] = ( empty( $attr['after'] ) ? '</span>' : '<span class="after">' . $attr['after'] . '</span></span>' );

	return get_the_term_list( $attr['id'], $attr['taxonomy'], $attr['before'], $attr['separator'], $attr['after'] );

} // end function exmachina_entry_terms_shortcode()

/**
 * Displays a post's number of comments wrapped in a link to the comments area.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_comments_number
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/comments_open
 * @link http://codex.wordpress.org/Function_Reference/pings_open
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 * @link http://codex.wordpress.org/Function_Reference/number_format_i18n
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 * @link http://codex.wordpress.org/Function_Reference/the_title_attribute
 * @link http://codex.wordpress.org/Function_Reference/number_format_i18n
 * @link http://codex.wordpress.org/Function_Reference/get_comments_link
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_entry_comments_link_shortcode( $attr ) {

	$comments_link = '';
	$number = doubleval( get_comments_number() );

	$attr = shortcode_atts(
		array(
			'zero'      => __( 'Leave a response', 'exmachina-core' ),
			'one'       => __( '%1$s Response', 'exmachina-core' ),
			'more'      => __( '%1$s Responses', 'exmachina-core' ),
			'css_class' => 'comments-link',
			'none'      => '',
			'before'    => '',
			'after'     => ''
		),
		$attr,
		'entry-comments-link'
	);

	if ( 0 == $number && !comments_open() && !pings_open() ) {
		if ( $attr['none'] )
			$comments_link = '<span class="' . esc_attr( $attr['css_class'] ) . '">' . sprintf( $attr['none'], number_format_i18n( $number ) ) . '</span>';
	}
	elseif ( 0 == $number )
		$comments_link = '<a class="' . esc_attr( $attr['css_class'] ) . '" href="' . get_permalink() . '#respond" title="' . sprintf( esc_attr__( 'Comment on %1$s', 'exmachina-core' ), the_title_attribute( 'echo=0' ) ) . '">' . sprintf( $attr['zero'], number_format_i18n( $number ) ) . '</a>';
	elseif ( 1 == $number )
		$comments_link = '<a class="' . esc_attr( $attr['css_class'] ) . '" href="' . get_comments_link() . '" title="' . sprintf( esc_attr__( 'Comment on %1$s', 'exmachina-core' ), the_title_attribute( 'echo=0' ) ) . '">' . sprintf( $attr['one'], number_format_i18n( $number ) ) . '</a>';
	elseif ( 1 < $number )
		$comments_link = '<a class="' . esc_attr( $attr['css_class'] ) . '" href="' . get_comments_link() . '" title="' . sprintf( esc_attr__( 'Comment on %1$s', 'exmachina-core' ), the_title_attribute( 'echo=0' ) ) . '">' . sprintf( $attr['more'], number_format_i18n( $number ) ) . '</a>';

	if ( $comments_link )
		$comments_link = $attr['before'] . $comments_link . $attr['after'];

	return $comments_link;

} // end function exmachina_entry_comments_link_shortcode()

/**
 * Displays the published date of an individual post.
 *
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/human_time_diff
 * @link http://codex.wordpress.org/Function_Reference/get_the_time
 * @link http://codex.wordpress.org/Function_Reference/current_time
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 * @link http://codex.wordpress.org/Function_Reference/get_the_title
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_entry_published_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'before' => '',
			'after' => '',
			'format' => get_option( 'date_format' ),
			'human_time' => ''
		),
		$attr,
		'entry-published'
	);

	/* If $human_time is passed in, allow for '%s ago' where '%s' is the return value of human_time_diff(). */
	if ( !empty( $attr['human_time'] ) )
		$time = sprintf( $attr['human_time'], human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );

	/* Else, just grab the time based on the format. */
	else
		$time = get_the_time( $attr['format'] );

	$published = '<time class="published" datetime="' . get_the_time( 'c' ) . '" title="' . get_the_time( esc_attr__( 'l, F jS, Y, g:i a', 'exmachina-core' ) ) . '" itemprop="datePublished">' . $time . '</time>';

	if (get_the_title()=='' && !is_singular()) {
		$published = '<a href="'. get_permalink() . '">' . $published . '</a>';
	}

	return $attr['before'] . $published . $attr['after'];

} // end function exmachina_entry_published_shortcode()

/**
 * Displays the edit link for an individual post.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_post_type_object
 * @link http://codex.wordpress.org/Function_Reference/get_post_type
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 * @link http://codex.wordpress.org/Function_Reference/get_the_ID
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/get_edit_post_link
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_entry_edit_link_shortcode( $attr ) {

	$post_type = get_post_type_object( get_post_type() );

	if ( !current_user_can( $post_type->cap->edit_post, get_the_ID() ) )
		return '';

	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr, 'entry-edit-link' );

	return $attr['before'] . '<span class="edit"><a class="post-edit-link" href="' . esc_url( get_edit_post_link( get_the_ID() ) ) . '" title="' . sprintf( esc_attr__( 'Edit %1$s', 'exmachina-core' ), $post_type->labels->singular_name ) . '">' . __( 'Edit', 'exmachina-core' ) . '</a></span>' . $attr['after'];

} // end function exmachina_entry_edit_link_shortcode()

/**
 * Displays the shortlink of an individual entry.
 *
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/the_title_attribute
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/wp_get_shortlink
 * @link http://codex.wordpress.org/Function_Reference/get_the_ID
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_entry_shortlink_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'text' => __( 'Shortlink', 'exmachina-core' ),
			'title' => the_title_attribute( array( 'echo' => false ) ),
			'before' => '',
			'after' => ''
		),
		$attr,
		'entry-shortlink'
	);

	$shortlink = esc_url( wp_get_shortlink( get_the_ID() ) );

	return "{$attr['before']}<a class='shortlink' href='{$shortlink}' title='" . esc_attr( $attr['title'] ) . "' rel='shortlink'>{$attr['text']}</a>{$attr['after']}";

} // end function exmachina_entry_shortlink_shortcode()

/**
 * Returns the output of the [entry-permalink] shortcode, which is a link back
 * to the post permalink page.
 *
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr 	The shortcode arguments.
 * @return string 			A permalink back to the post.
 */
function exmachina_entry_permalink_shortcode( $attr ) {

	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr, 'entry-permalink' );

	return $attr['before'] . '<a href="' . esc_url( get_permalink() ) . '" class="permalink">' . __( 'Permalink', 'exmachina-core' ) . '</a>' . $attr['after'];

} // end function exmachina_entry_permalink_shortcode()

/**
 * Returns the output of the [post-format-link] shortcode. This shortcode is for
 * use when a theme uses the post formats feature.
 *
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/get_post_format
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 * @link http://codex.wordpress.org/Function_Reference/get_post_format_link
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/get_post_format_string
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr 	The shortcode arguments.
 * @return string 			A link to the post format archive.
 */
function exmachina_post_format_link_shortcode( $attr ) {

	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr, 'post-format-link' );
	$format = get_post_format();
	$url = ( empty( $format ) ? get_permalink() : get_post_format_link( $format ) );

	return $attr['before'] . '<a href="' . esc_url( $url ) . '" class="post-format-link">' . get_post_format_string( $format ) . '</a>' . $attr['after'];

} // end function exmachina_post_format_link_shortcode()

/*-------------------------------------------------------------------------*/
/* == Comment-specific Shortcodes */
/*-------------------------------------------------------------------------*/

/**
 * Displays the published date and time of an individual comment.
 *
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/get_comment_time
 * @link http://codex.wordpress.org/Function_Reference/get_comment_date
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 * @link http://codex.wordpress.org/Function_Reference/human_time_diff
 * @link http://codex.wordpress.org/Function_Reference/current_time
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_comment_published_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'human_time' => '',
			'before'     => '',
			'after'      => '',
		),
		$attr,
		'comment-published'
	);

	/* If $human_time is passed in, allow for '%s ago' where '%s' is the return value of human_time_diff(). */
	if ( !empty( $attr['human_time'] ) )
		$published = '<time class="published" datetime="' . get_comment_time( 'Y-m-d\TH:i:sP' ) . '" title="' . get_comment_date( esc_attr__( 'l, F jS, Y, g:i a', 'exmachina-core' ) ) . '">' . sprintf( $attr['human_time'], human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ) . '</time>';

	/* Else, just return the default. */
	else
		$published = '<span class="published">' . sprintf( __( '%1$s at %2$s', 'exmachina-core' ), '<time class="comment-date" datetime="' . get_comment_time( 'Y-m-d\TH:i:sP' ) . '" title="' . get_comment_date( esc_attr__( 'l, F jS, Y, g:i a', 'exmachina-core' ) ) . '">' . get_comment_date() . '</time>', '<time class="comment-time" title="' . get_comment_date( esc_attr__( 'l, F jS, Y, g:i a', 'exmachina-core' ) ) . '">' . get_comment_time() . '</time>' ) . '</span>';

	return $attr['before'] . $published . $attr['after'];

} // end function exmachina_comment_published_shortcode()

/**
 * Displays the comment author of an individual comment.
 *
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/esc_html
 * @link http://codex.wordpress.org/Function_Reference/get_comment_author
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/get_comment_author_url
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 * @link http://codex.wordpress.org/Function_Reference/tag_escape
 *
 * @since 2.5.0
 * @access public
 *
 * @global $comment 		The current comment's DB object.
 * @param  array $attr 	The shortcode arguments.
 * @return string
 */
function exmachina_comment_author_shortcode( $attr ) {
	global $comment;

	$attr = shortcode_atts(
		array(
			'before' => '',
			'after' => '',
			'tag' => 'span'
		),
		$attr,
		'comment-author'
	);

	$author = esc_html( get_comment_author( $comment->comment_ID ) );
	$url = esc_url( get_comment_author_url( $comment->comment_ID ) );

	/* Display link and cite if URL is set. Also, properly cites trackbacks/pingbacks. */
	if ( $url )
		$output = '<cite class="fn" title="' . $url . '"><a href="' . $url . '" title="' . esc_attr( $author ) . '" class="url" rel="external nofollow">' . $author . '</a></cite>';
	else
		$output = '<cite class="fn">' . $author . '</cite>';

	$output = '<' . tag_escape( $attr['tag'] ) . ' class="comment-author vcard">' . $attr['before'] . apply_filters( 'get_comment_author_link', $output ) . $attr['after'] . '</' . tag_escape( $attr['tag'] ) . '><!-- .comment-author .vcard -->';

	return $output;
} // end function exmachina_comment_author_shortcode()

/**
 * Displays a comment's edit link to users that have the capability to edit the
 * comment.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_edit_comment_link
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_comment_edit_link_shortcode( $attr ) {
	global $comment;

	$edit_link = get_edit_comment_link( $comment->comment_ID );

	if ( !$edit_link )
		return '';

	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr, 'comment-edit-link' );

	$link = '<a class="comment-edit-link" href="' . esc_url( $edit_link ) . '" title="' . sprintf( esc_attr__( 'Edit %1$s', 'exmachina-core' ), $comment->comment_type ) . '"><span class="edit">' . __( 'Edit', 'exmachina-core' ) . '</span></a>';
	$link = apply_filters( 'edit_comment_link', $link, $comment->comment_ID );

	return $attr['before'] . $link . $attr['after'];

} // end function exmachina_comment_edit_link_shortcode()

/**
 * Displays a reply link for the 'comment' comment_type if threaded comments are
 * enabled.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/get_comment_type
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/get_comment_reply_link
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_comment_reply_link_shortcode( $attr ) {

	if ( !get_option( 'thread_comments' ) || 'comment' !== get_comment_type() )
		return '';

	$defaults = array(
		'reply_text' => __( 'Reply', 'exmachina-core' ),
		'login_text' => __( 'Log in to reply.', 'exmachina-core' ),
		'depth' => intval( $GLOBALS['comment_depth'] ),
		'max_depth' => get_option( 'thread_comments_depth' ),
		'before' => '',
		'after' => ''
	);
	$attr = shortcode_atts( $defaults, $attr, 'comment-reply-link' );

	return get_comment_reply_link( $attr );

} // end function exmachina_comment_reply_link_shortcode()

/**
 * Displays the permalink to an individual comment.
 *
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/esc_url
 * @link http://codex.wordpress.org/Function_Reference/get_comment_link
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 *
 * @since 2.5.0
 * @access public
 *
 * @param  array $attr The shortcode arguments.
 * @return string
 */
function exmachina_comment_permalink_shortcode( $attr ) {
	global $comment;

	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr, 'comment-permalink' );
	$link = '<a class="permalink" href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '" title="' . sprintf( esc_attr__( 'Permalink to comment %1$s', 'exmachina-core' ), $comment->comment_ID ) . '">' . __( 'Permalink', 'exmachina-core' ) . '</a>';
	return $attr['before'] . $link . $attr['after'];

} // end function exmachina_comment_permalink_shortcode()


/*-------------------------------------------------------------------------*/
/* == General Function Shortcodes */
/*-------------------------------------------------------------------------*/


/**
 * Returns the mood for the current post. The mood is set by the 'mood' custom
 * field.
 *
 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
 * @link http://codex.wordpress.org/Function_Reference/get_post_meta
 * @link http://codex.wordpress.org/Function_Reference/get_the_ID
 * @link http://codex.wordpress.org/Function_Reference/convert_smilies
 *
 * @since 2.5.0
 * @access public
 *
 * @param array $attr The shortcode arguments.
 * @return string
 */
function exmachina_entry_mood_shortcode( $attr ) {

	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr );

	$mood = get_post_meta( get_the_ID(), 'mood', true );

	if ( !empty( $mood ) )
		$mood = $attr['before'] . convert_smilies( $mood ) . $attr['after'];

	return $mood;

} // end function exmachina_entry_mood_shortcode()

?>