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
 * Creates new shortcodes for use in any shortcode-ready area. This function uses
 * the add_shortcode() function to register new shortcodes with WordPress.
 *
 * @link http://codex.wordpress.org/Shortcode_API
 * @link http://codex.wordpress.org/Function_Reference/add_shortcode
 *
 * @since 1.0.8
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

} // end function exmachina_add_shortcodes()

/**
 * Shortcode to display the current year.
 *
 * @since 1.0.8
 * @access public
 * @uses date() Gets the current year.
 * @return string
 */
function exmachina_the_year_shortcode() {
  return date( __( 'Y', 'exmachina-core' ) );
}

/**
 * Shortcode to display a link back to the site.
 *
 * @since 1.0.8
 * @access public
 * @uses get_bloginfo() Gets information about the install.
 * @return string
 */
function exmachina_site_link_shortcode() {
  return '<a class="site-link" href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home"><span>' . get_bloginfo( 'name' ) . '</span></a>';
}

/**
 * Shortcode to display a link to WordPress.org.
 *
 * @since 1.0.8
 * @access public
 * @return string
 */
function exmachina_wp_link_shortcode() {
  return '<a class="wp-link" href="http://wordpress.org" title="' . esc_attr__( 'State-of-the-art semantic personal publishing platform', 'exmachina-core' ) . '"><span>' . __( 'WordPress', 'exmachina-core' ) . '</span></a>';
}

/**
 * Shortcode to display a link to the parent theme page.
 *
 * @since 1.0.8
 * @access public
 * @uses get_theme_data() Gets theme (parent theme) information.
 * @return string
 */
function exmachina_theme_link_shortcode() {
  $theme = wp_get_theme( get_template() );
  return '<a class="theme-link" href="' . esc_url( $theme->get( 'ThemeURI' ) ) . '" title="' . sprintf( esc_attr__( '%s WordPress Theme', 'exmachina-core' ), $theme->get( 'Name' ) ) . '"><span>' . esc_attr( $theme->get( 'Name' ) ) . '</span></a>';
}

/**
 * Shortcode to display a link to the child theme's page.
 *
 * @since 1.0.8
 * @access public
 * @uses get_theme_data() Gets theme (child theme) information.
 * @return string
 */
function exmachina_child_link_shortcode() {
  $theme = wp_get_theme();
  return '<a class="child-link" href="' . esc_url( $theme->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $theme->get( 'Name' ) ) . '"><span>' . esc_html( $theme->get( 'Name' ) ) . '</span></a>';
}

/**
 * Shortcode to display a login link or logout link.
 *
 * @since 1.0.8
 * @access public
 * @uses is_user_logged_in() Checks if the current user is logged into the site.
 * @uses wp_logout_url() Creates a logout URL.
 * @uses wp_login_url() Creates a login URL.
 * @return string
 */
function exmachina_loginout_link_shortcode() {
  if ( is_user_logged_in() )
    $out = '<a class="logout-link" href="' . esc_url( wp_logout_url( site_url( $_SERVER['REQUEST_URI'] ) ) ) . '" title="' . esc_attr__( 'Log out', 'exmachina-core' ) . '">' . __( 'Log out', 'exmachina-core' ) . '</a>';
  else
    $out = '<a class="login-link" href="' . esc_url( wp_login_url( site_url( $_SERVER['REQUEST_URI'] ) ) ) . '" title="' . esc_attr__( 'Log in', 'exmachina-core' ) . '">' . __( 'Log in', 'exmachina-core' ) . '</a>';

  return $out;
}

/**
 * Displays query count and load time if the current user can edit themes.
 *
 * @since 1.0.8
 * @access public
 * @uses current_user_can() Checks if the current user can edit themes.
 * @return string
 */
function exmachina_query_counter_shortcode() {
  if ( current_user_can( 'edit_theme_options' ) )
    return sprintf( __( 'This page loaded in %1$s seconds with %2$s database queries.', 'exmachina-core' ), timer_stop( 0, 3 ), get_num_queries() );
  return '';
}

/**
 * Displays a nav menu that has been created from the Menus screen in the admin.
 *
 * @since 1.0.8
 * @access public
 * @uses wp_nav_menu() Displays the nav menu.
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
}

/**
 * Displays the edit link for an individual post.
 *
 * @since 1.0.8
 * @access public
 * @param array $attr
 * @return string
 */
function exmachina_entry_edit_link_shortcode( $attr ) {

  $post_type = get_post_type_object( get_post_type() );

  if ( !current_user_can( $post_type->cap->edit_post, get_the_ID() ) )
    return '';

  $attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr, 'entry-edit-link' );

  return $attr['before'] . '<span class="edit"><a class="post-edit-link" href="' . esc_url( get_edit_post_link( get_the_ID() ) ) . '" title="' . sprintf( esc_attr__( 'Edit %1$s', 'exmachina-core' ), $post_type->labels->singular_name ) . '">' . __( 'Edit', 'exmachina-core' ) . '</a></span>' . $attr['after'];
}

/**
 * Displays the published date of an individual post.
 *
 * @since 1.0.8
 * @access public
 * @param array $attr
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

  $published = '<time class="published" datetime="'. get_the_time( 'c' ) .'" title="' . get_the_time( esc_attr__( 'l, F jS, Y, g:i a', 'exmachina-core' ) ) . '" itemprop="datePublished">' . get_the_time( $attr['format'] ) . '</time>';

  if (get_the_title()=='' && !is_singular()) {
    $published = '<a href="'. get_permalink() . '">' . $published . '</a>';
  }

  return $attr['before'] . $published . $attr['after'];
}

/**
 * Displays a post's number of comments wrapped in a link to the comments area.
 *
 * @since 1.0.8
 * @access public
 * @param array $attr
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
}

/**
 * Displays an individual post's author with a link to his or her archive.
 *
 * @since 1.0.8
 * @access public
 * @param array $attr
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

    $author = '<span class="entry-author" itemtype="http://schema.org/Person" itemscope="itemscope" itemprop="author"><a class="entry-author-link" rel="author" itemprop="url" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . '"><span itemprop="name" class="entry-author-name">' . get_the_author_meta( 'display_name' ) . '</span></a></span>';

    return $attr['before'] . $author . $attr['after'];
  }

  return '';
}

/**
 * Displays a list of terms for a specific taxonomy.
 *
 * @since 1.0.8
 * @access public
 * @param array $attr
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
}

/**
 * Displays a post's title with a link to the post.
 *
 * @since 1.0.8
 * @access public
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
}

/**
 * Displays the shortlink of an individual entry.
 *
 * @since 1.0.8
 * @access public
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
}

/**
 * Returns the output of the [entry-permalink] shortcode, which is a link back to the post permalink page.
 *
 * @since 1.0.8.
 * @param array $attr The shortcode arguments.
 * @return string A permalink back to the post.
 */
function exmachina_entry_permalink_shortcode( $attr ) {

  $attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr, 'entry-permalink' );

  return $attr['before'] . '<a href="' . esc_url( get_permalink() ) . '" class="permalink">' . __( 'Permalink', 'exmachina-core' ) . '</a>' . $attr['after'];
}

/**
 * Returns the output of the [post-format-link] shortcode.  This shortcode is for use when a theme uses the
 * post formats feature.
 *
 * @since 1.0.8.
 * @param array $attr The shortcode arguments.
 * @return string A link to the post format archive.
 */
function exmachina_post_format_link_shortcode( $attr ) {

  $attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr, 'post-format-link' );
  $format = get_post_format();
  $url = ( empty( $format ) ? get_permalink() : get_post_format_link( $format ) );

  return $attr['before'] . '<a href="' . esc_url( $url ) . '" class="post-format-link">' . get_post_format_string( $format ) . '</a>' . $attr['after'];
}

/**
 * Displays the published date and time of an individual comment.
 *
 * @since 1.0.8
 * @access public
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
}

/**
 * Displays the comment author of an individual comment.
 *
 * @since 1.0.8
 * @access public
 * @global $comment The current comment's DB object.
 * @return string
 */
function exmachina_comment_author_shortcode( $attr ) {
  global $comment;

  $attr = shortcode_atts(
    array(
      'before' => '',
      'after' => '',
      'tag' => 'span' // @deprecated 1.2.0 Back-compatibility. Please don't use this argument.
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
}

/**
 * Displays the permalink to an individual comment.
 *
 * @since 1.0.8
 * @access public
 * @return string
 */
function exmachina_comment_permalink_shortcode( $attr ) {
  global $comment;

  $attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr, 'comment-permalink' );
  $link = '<a class="permalink" href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '" title="' . sprintf( esc_attr__( 'Permalink to comment %1$s', 'exmachina-core' ), $comment->comment_ID ) . '">' . __( 'Permalink', 'exmachina-core' ) . '</a>';
  return $attr['before'] . $link . $attr['after'];
}

/**
 * Displays a comment's edit link to users that have the capability to edit the comment.
 *
 * @since 1.0.8
 * @access public
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
}

/**
 * Displays a reply link for the 'comment' comment_type if threaded comments are enabled.
 *
 * @since 1.0.8
 * @access public
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
}

/** === GENERAL SHORTCODES === */

// Search Shortcode
add_shortcode( '404_search', 'exmachina_404_search_shortcode' );
/**
   * Search Shortcode
   *
   * @since 0.5.0
   */
  function exmachina_404_search_shortcode() {
    return '<div class="exmachina-404-search">' . get_search_form( false ) . '</div>';
  }

/* ===POST SHORTCODES=== */

add_shortcode( 'post_date', 'exmachina_post_date_shortcode' );
/**
 * Produces the date of post publication.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   format (date format, default is value in date_format option field),
 *   label (text following 'before' output, but before date).
 *
 * Output passes through 'exmachina_post_date_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_post_date_shortcode( $atts ) {

  $defaults = array(
    'after'  => '',
    'before' => '',
    'format' => get_option( 'date_format' ),
    'label'  => '',
  );

  $atts = shortcode_atts( $defaults, $atts, 'post_date' );

  $display = ( 'relative' === $atts['format'] ) ? exmachina_human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'exmachina' ) : get_the_time( $atts['format'] );


    $output = sprintf( '<time %s>', exmachina_attr( 'entry-time' ) ) . $atts['before'] . $atts['label'] . $display . $atts['after'] . '</time>';


  return apply_filters( 'exmachina_post_date_shortcode', $output, $atts );

}

add_shortcode( 'post_time', 'exmachina_post_time_shortcode' );
/**
 * Produces the time of post publication.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   format (date format, default is value in date_format option field),
 *   label (text following 'before' output, but before date).
 *
 * Output passes through 'exmachina_post_time_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_post_time_shortcode( $atts ) {

  $defaults = array(
    'after'  => '',
    'before' => '',
    'format' => get_option( 'time_format' ),
    'label'  => '',
  );

  $atts = shortcode_atts( $defaults, $atts, 'post_time' );


    $output = sprintf( '<time %s>', exmachina_attr( 'entry-time' ) ) . $atts['before'] . $atts['label'] . get_the_time( $atts['format'] ) . $atts['after'] . '</time>';


  return apply_filters( 'exmachina_post_time_shortcode', $output, $atts );

}

add_shortcode( 'post_author', 'exmachina_post_author_shortcode' );
/**
 * Produces the author of the post (unlinked display name).
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 * Output passes through 'exmachina_post_author_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_post_author_shortcode( $atts ) {

  $defaults = array(
    'after'  => '',
    'before' => '',
  );

  $atts = shortcode_atts( $defaults, $atts, 'post_author' );

  $author = get_the_author();

    $output  = sprintf( '<span %s>', exmachina_attr( 'entry-author' ) );
    $output .= $atts['before'];
    $output .= sprintf( '<span %s>', exmachina_attr( 'entry-author-name' ) ) . esc_html( $author ) . '</span>';
    $output .= $atts['after'];
    $output .= '</span>';


  return apply_filters( 'exmachina_post_author_shortcode', $output, $atts );

}

add_shortcode( 'post_author_link', 'exmachina_post_author_link_shortcode' );
/**
 * Produces the author of the post (link to author URL).
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 * Output passes through 'exmachina_post_author_link_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_post_author_link_shortcode( $atts ) {

  $defaults = array(
    'after'    => '',
    'before'   => '',
  );

  $atts = shortcode_atts( $defaults, $atts, 'post_author_link' );

  $url = get_the_author_meta( 'url' );

  //* If no url, use post author shortcode function.
  if ( ! $url )
    return exmachina_post_author_shortcode( $atts );

  $author = get_the_author();


    $output  = sprintf( '<span %s>', exmachina_attr( 'entry-author' ) );
    $output .= $atts['before'];
    $output .= sprintf( '<a href="%s" %s>', $url, exmachina_attr( 'entry-author-link' ) );
    $output .= sprintf( '<span %s>', exmachina_attr( 'entry-author-name' ) );
    $output .= esc_html( $author );
    $output .= '</span></a>' . $atts['after'] . '</span>';


  return apply_filters( 'exmachina_post_author_link_shortcode', $output, $atts );

}

add_shortcode( 'post_author_posts_link', 'exmachina_post_author_posts_link_shortcode' );
/**
 * Produces the author of the post (link to author archive).
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 * Output passes through 'exmachina_post_author_posts_link_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_post_author_posts_link_shortcode( $atts ) {

  $defaults = array(
    'after'  => '',
    'before' => '',
  );

  $atts = shortcode_atts( $defaults, $atts, 'post_author_posts_link' );

  $author = get_the_author();
  $url    = get_author_posts_url( get_the_author_meta( 'ID' ) );


    $output  = sprintf( '<span %s>', exmachina_attr( 'entry-author' ) );
    $output .= $atts['before'];
    $output .= sprintf( '<a href="%s" %s>', $url, exmachina_attr( 'entry-author-link' ) );
    $output .= sprintf( '<span %s>', exmachina_attr( 'entry-author-name' ) );
    $output .= esc_html( $author );
    $output .= '</span></a>' . $atts['after'] . '</span>';


  return apply_filters( 'exmachina_post_author_posts_link_shortcode', $output, $atts );

}

add_shortcode( 'post_comments', 'exmachina_post_comments_shortcode' );
/**
 * Produces the link to the current post comments.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   hide_if_off (hide link if comments are off, default is 'enabled' (true)),
 *   more (text when there is more than 1 comment, use % character as placeholder
 *     for actual number, default is '% Comments')
 *   one (text when there is exactly one comment, default is '1 Comment'),
 *   zero (text when there are no comments, default is 'Leave a Comment').
 *
 * Output passes through 'exmachina_post_comments_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_post_comments_shortcode( $atts ) {

  $defaults = array(
    'after'       => '',
    'before'      => '',
    'hide_if_off' => 'enabled',
    'more'        => __( '% Comments', 'exmachina' ),
    'one'         => __( '1 Comment', 'exmachina' ),
    'zero'        => __( 'Leave a Comment', 'exmachina' ),
  );
  $atts = shortcode_atts( $defaults, $atts, 'post_comments' );

  if ( ( ! exmachina_get_option( 'comments_posts' ) || ! comments_open() ) && 'enabled' === $atts['hide_if_off'] )
    return;

  // Darn you, WordPress!
  ob_start();
  comments_number( $atts['zero'], $atts['one'], $atts['more'] );
  $comments = ob_get_clean();

  $comments = sprintf( '<a href="%s">%s</a>', get_comments_link(), $comments );

  $output = exmachina_markup( array(
    'html' => '<span class="entry-comments-link">' . $atts['before'] . $comments . $atts['after'] . '</span>',
    'echo'  => false,
  ) );

  return apply_filters( 'exmachina_post_comments_shortcode', $output, $atts );

}

add_shortcode( 'post_tags', 'exmachina_post_tags_shortcode' );
/**
 * Produces the tag links list.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: '),
 *   sep (separator string between tags, default is ', ').
 *
 * Output passes through 'exmachina_post_tags_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_post_tags_shortcode( $atts ) {

  $defaults = array(
    'after'  => '',
    'before' => __( 'Tagged With: ', 'exmachina' ),
    'sep'    => ', ',
  );
  $atts = shortcode_atts( $defaults, $atts, 'post_tags' );

  $tags = get_the_tag_list( $atts['before'], trim( $atts['sep'] ) . ' ', $atts['after'] );

  //* Do nothing if no tags
  if ( ! $tags )
    return;


    $output = sprintf( '<span %s>', exmachina_attr( 'entry-tags' ) ) . $tags . '</span>';


  return apply_filters( 'exmachina_post_tags_shortcode', $output, $atts );

}

add_shortcode( 'post_categories', 'exmachina_post_categories_shortcode' );
/**
 * Produces the category links list.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: '),
 *   sep (separator string between tags, default is ', ').
 *
 * Output passes through 'exmachina_post_categories_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_post_categories_shortcode( $atts ) {

  $defaults = array(
    'sep'    => ', ',
    'before' => __( 'Filed Under: ', 'exmachina' ),
    'after'  => '',
  );

  $atts = shortcode_atts( $defaults, $atts, 'post_categories' );

  $cats = get_the_category_list( trim( $atts['sep'] ) . ' ' );


    $output = sprintf( '<span %s>', exmachina_attr( 'entry-categories' ) ) . $atts['before'] . $cats . $atts['after'] . '</span>';

  return apply_filters( 'exmachina_post_categories_shortcode', $output, $atts );

}

add_shortcode( 'post_terms', 'exmachina_post_terms_shortcode' );
/**
 * Produces the linked post taxonomy terms list.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: '),
 *   sep (separator string between tags, default is ', '),
 *    taxonomy (name of the taxonomy, default is 'category').
 *
 * Output passes through 'exmachina_post_terms_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @global stdClass $post Post object
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string|boolean Shortcode output or false on failure to retrieve terms
 */
function exmachina_post_terms_shortcode( $atts ) {

  global $post;

  $defaults = array(
      'after'    => '',
      'before'   => __( 'Filed Under: ', 'exmachina' ),
      'sep'      => ', ',
      'taxonomy' => 'category',
  );

  $atts = shortcode_atts( $defaults, $atts, 'post_terms' );

  $terms = get_the_term_list( $post->ID, $atts['taxonomy'], $atts['before'], trim( $atts['sep'] ) . ' ', $atts['after'] );

  if ( is_wp_error( $terms ) )
      return;

  if ( empty( $terms ) )
      return;


    $output = sprintf( '<span %s>', exmachina_attr( 'entry-terms' ) ) . $terms . '</span>';

  return apply_filters( 'exmachina_post_terms_shortcode', $output, $terms, $atts );

}

add_shortcode( 'post_edit', 'exmachina_post_edit_shortcode' );
/**
 * Produces the edit post link for logged in users.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: '),
 *   link (link text, default is '(Edit)').
 *
 * Output passes through 'exmachina_post_edit_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_post_edit_shortcode( $atts ) {

  if ( ! apply_filters( 'exmachina_edit_post_link', true ) )
    return;

  $defaults = array(
    'after'  => '',
    'before' => '',
    'link'   => __( '(Edit)', 'exmachina' ),
  );

  $atts = shortcode_atts( $defaults, $atts, 'post_edit' );

  //* Darn you, WordPress!
  ob_start();
  edit_post_link( $atts['link'], $atts['before'], $atts['after'] );
  $edit = ob_get_clean();

  $output = $edit;

  return apply_filters( 'exmachina_post_edit_shortcode', $output, $atts );

}

/* === FOOTER SHORTCODES === */

add_shortcode( 'footer_backtotop', 'exmachina_footer_backtotop_shortcode' );
/**
 * Produces the "Return to Top" link.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   href (link url, default is fragment identifier '#wrap'),
 *   nofollow (boolean for whether to make the link include the rel="nofollow"
 *     attribute. Default is true),
 *   text (Link text, default is 'Return to top of page').
 *
 * Output passes through 'exmachina_footer_backtotop_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_footer_backtotop_shortcode( $atts ) {

  $defaults = array(
    'after'    => '',
    'before'   => '',
    'href'     => '#wrap',
    'nofollow' => true,
    'text'     => __( 'Return to top of page', 'exmachina' ),
  );
  $atts = shortcode_atts( $defaults, $atts, 'footer_backtotop' );

  $nofollow = $atts['nofollow'] ? 'rel="nofollow"' : '';

  $output = sprintf( '%s<a href="%s" %s>%s</a>%s', $atts['before'], esc_url( $atts['href'] ), $nofollow, $atts['text'], $atts['after'] );

  return apply_filters( 'exmachina_footer_backtotop_shortcode', $output, $atts );

}

add_shortcode( 'footer_copyright', 'exmachina_footer_copyright_shortcode' );
/**
 * Adds the visual copyright notice.
 *
 * Supported shortcode attributes are:
 *   after (output after notice, default is empty string),
 *   before (output before notice, default is empty string),
 *   copyright (copyright notice, default is copyright character like (c) ),
 *   first(year copyright first applies, default is empty string).
 *
 * If the 'first' attribute is not empty, and not equal to the current year, then
 * output will be formatted as first-current year (e.g. 1998-2020).
 * Otherwise, output is just given as the current year.
 *
 * Output passes through 'exmachina_footer_copyright_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_footer_copyright_shortcode( $atts ) {

  $defaults = array(
    'after'     => '',
    'before'    => '',
    'copyright' => '&#x000A9;',
    'first'     => '',
  );
  $atts = shortcode_atts( $defaults, $atts, 'footer_copyright' );

  $output = $atts['before'] . $atts['copyright'] . ' ';

  if ( '' != $atts['first'] && date( 'Y' ) != $atts['first'] )
    $output .= $atts['first'] . '&#x02013;';

  $output .= date( 'Y' ) . $atts['after'];

  return apply_filters( 'exmachina_footer_copyright_shortcode', $output, $atts );

}

add_shortcode( 'footer_childtheme_link', 'exmachina_footer_childtheme_link_shortcode' );
/**
 * Adds the link to the child theme, if the details are defined.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is a string with a middot character).
 *
 * Output passes through 'exmachina_footer_childtheme_link_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string|null Returns early on failure, otherwise returns shortcode output
 */
function exmachina_footer_childtheme_link_shortcode( $atts ) {

  if ( ! is_child_theme() || ! defined( 'CHILD_THEME_NAME' ) || ! defined( 'CHILD_THEME_URL' ) )
    return;

  $defaults = array(
    'after'  => '',
    'before' => '&#x000B7;',
  );
  $atts = shortcode_atts( $defaults, $atts, 'footer_childtheme_link' );

  $output = sprintf( '%s<a href="%s" title="%s">%s</a>%s', $atts['before'], esc_url( CHILD_THEME_URL ), esc_attr( CHILD_THEME_NAME ), esc_html( CHILD_THEME_NAME ), $atts['after'] );

  return apply_filters( 'exmachina_footer_childtheme_link_shortcode', $output, $atts );

}

add_shortcode( 'footer_exmachina_link', 'exmachina_footer_exmachina_link_shortcode' );
/**
 * Adds link to the ExMachina page on the Machina Themes website.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 * Output passes through 'exmachina_footer_exmachina_link_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_footer_exmachina_link_shortcode( $atts ) {

  $defaults = array(
    'after'  => '',
    'before' => '',
    'url'    => 'http://machinathemes.com/themes/exmachina',
  );
  $atts = shortcode_atts( $defaults, $atts, 'footer_exmachina_link' );

  $output = $atts['before'] . '<a href="' . esc_url( $atts['url'] ) . '" title="ExMachina Framework">ExMachina Framework</a>' . $atts['after'];

  return apply_filters( 'exmachina_footer_exmachina_link_shortcode', $output, $atts );

}

add_shortcode( 'footer_machinathemes_link', 'exmachina_footer_machinathemes_link_shortcode' );
/**
 * Adds link to the Machina Themes home page.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'by ').
 *
 * Output passes through 'exmachina_footer_machinathemes_link_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_footer_machinathemes_link_shortcode( $atts ) {

  $defaults = array(
    'after'  => '',
    'before' => __( 'by', 'exmachina' ),
  );
  $atts = shortcode_atts( $defaults, $atts, 'footer_machinathemes_link' );

  $output = $atts['before'] . ' <a href="http://www.machinathemes.com/">Machina Themes</a>' . $atts['after'];

  return apply_filters( 'exmachina_footer_machinathemes_link_shortcode', $output, $atts );

}

add_shortcode( 'footer_wordpress_link', 'exmachina_footer_wordpress_link_shortcode' );
/**
 * Adds link to WordPress - http://wordpress.org/ .
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 * Output passes through 'exmachina_footer_wordpress_link_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_footer_wordpress_link_shortcode( $atts ) {

  $defaults = array(
    'after'  => '',
    'before' => '',
  );
  $atts = shortcode_atts( $defaults, $atts, 'footer_wordpress_link' );

  $output = sprintf( '%s<a href="%s" title="%s">%s</a>%s', $atts['before'], 'http://wordpress.org/', 'WordPress', 'WordPress', $atts['after'] );

  return apply_filters( 'exmachina_footer_wordpress_link_shortcode', $output, $atts );

}

add_shortcode( 'footer_loginout', 'exmachina_footer_loginout_shortcode' );
/**
 * Adds admin login / logout link.
 *
 * Support shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   redirect (path to redirect to on login, default is empty string).
 *
 * Output passes through 'exmachina_footer_loginout_shortcode' filter before returning.
 *
 * @since 0.5.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function exmachina_footer_loginout_shortcode( $atts ) {

  $defaults = array(
    'after'    => '',
    'before'   => '',
    'redirect' => '',
  );
  $atts = shortcode_atts( $defaults, $atts, 'footer_loginout' );

  if ( ! is_user_logged_in() )
    $link = '<a href="' . esc_url( wp_login_url( $atts['redirect'] ) ) . '">' . __( 'Log in', 'exmachina' ) . '</a>';
  else
    $link = '<a href="' . esc_url( wp_logout_url( $atts['redirect'] ) ) . '">' . __( 'Log out', 'exmachina' ) . '</a>';

  $output = $atts['before'] . apply_filters( 'loginout', $link ) . $atts['after'];

  return apply_filters( 'exmachina_footer_loginout_shortcode', $output, $atts );

}