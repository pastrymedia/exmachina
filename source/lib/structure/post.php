<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Post Structure
 *
 * post.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
 *
 * @package     ExMachina
 * @subpackage  Structure
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin structure
###############################################################################

/**
 * Reset Loops
 *
 * Restore all default post loop output by re-hooking all default functions.
 * Useful in the event that you need to unhook something in a particular context,
 * but don't want to restore it for all subsequent loop instances.
 *
 * Calls `exmachina_reset_loops` action after everything has been re-hooked.
 *
 * @todo possibly move function to loops.php (???)
 * @todo add uses docblock
 * @todo inline comment
 *
 * @since 0.5.0
 * @access public
 *
 * @global array $_exmachina_loop_args Associative array for grid loop configuration
 * @return void
 */
function exmachina_reset_loops() {

  //* HTML5 Hooks
  add_action( 'exmachina_entry_header', 'exmachina_do_post_format_image', 4 );
  add_action( 'exmachina_entry_header', 'exmachina_entry_header_markup_open', 5 );
  add_action( 'exmachina_entry_header', 'exmachina_entry_header_markup_close', 15 );
  add_action( 'exmachina_entry_header', 'exmachina_do_post_title' );
  add_action( 'exmachina_entry_header', 'exmachina_post_info', 12 );

  add_action( 'exmachina_entry_content', 'exmachina_do_post_image', 8 );
  add_action( 'exmachina_entry_content', 'exmachina_do_post_content' );
  add_action( 'exmachina_entry_content', 'exmachina_do_post_content_nav', 12 );
  add_action( 'exmachina_entry_content', 'exmachina_do_post_permalink', 14 );

  add_action( 'exmachina_entry_footer', 'exmachina_entry_footer_markup_open', 5 );
  add_action( 'exmachina_entry_footer', 'exmachina_entry_footer_markup_close', 15 );
  add_action( 'exmachina_entry_footer', 'exmachina_post_meta' );

  add_action( 'exmachina_after_entry', 'exmachina_do_author_box_single', 8 );
  add_action( 'exmachina_after_entry', 'exmachina_after_entry_widget_area', 9 );
  add_action( 'exmachina_after_entry', 'exmachina_get_comments_template' );

  //* Other
  add_action( 'exmachina_loop_else', 'exmachina_do_noposts' );
  add_action( 'exmachina_after_endwhile', 'exmachina_posts_nav' );

  //* Reset loop args
  global $_exmachina_loop_args;
  $_exmachina_loop_args = array();

  do_action( 'exmachina_reset_loops' );

} // end function exmachina_reset_loops()

/* Post Class actions. */
add_filter( 'post_class', 'exmachina_entry_post_class' );
add_filter( 'post_class', 'exmachina_custom_post_class', 15 );

/* Entry header actions. */
add_action( 'exmachina_entry_header', 'exmachina_do_post_format_image', 4 );
add_action( 'exmachina_entry_header', 'exmachina_entry_header_markup_open', 5 );
add_action( 'exmachina_entry_header', 'exmachina_entry_header_markup_close', 15 );
add_action( 'exmachina_entry_header', 'exmachina_do_post_title' );

add_filter( 'exmachina_post_info', 'do_shortcode', 20 );
add_action( 'exmachina_entry_header', 'exmachina_post_info', 12 );

/* Entry Content actions. */
add_action( 'exmachina_entry_content', 'exmachina_do_post_image', 8 );
add_action( 'exmachina_entry_content', 'exmachina_do_post_content' );
add_action( 'exmachina_entry_content', 'exmachina_do_post_content_nav', 12 );
add_action( 'exmachina_entry_content', 'exmachina_do_post_permalink', 14 );

add_action( 'exmachina_loop_else', 'exmachina_do_noposts' );

add_action( 'exmachina_entry_footer', 'exmachina_entry_footer_markup_open', 5 );
add_action( 'exmachina_entry_footer', 'exmachina_entry_footer_markup_close', 15 );
add_filter( 'exmachina_post_meta', 'do_shortcode', 20 );
add_action( 'exmachina_entry_footer', 'exmachina_post_meta' );

add_action( 'exmachina_after_entry', 'exmachina_do_author_box_single', 8 );
add_action( 'exmachina_after_entry', 'exmachina_after_entry_widget_area', 9 );

add_action( 'exmachina_after_endwhile', 'exmachina_posts_nav' );


/**
 * Entry Post Class
 *
 * Add `entry` post class, remove `hentry` post class.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array $classes Existing post classes.
 * @return array          Amended post classes.
 */
function exmachina_entry_post_class( $classes ) {

  //* Add "entry" to the post class array
  $classes[] = 'entry';

  //* Remove "hentry" from post class array
    $classes = array_diff( $classes, array( 'hentry' ) );

  return $classes;

} // end function exmachina_entry_post_class()


/**
 * Custom Field Post Class
 *
 * Add a custom post class, saved as a custom field.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @uses exmachina_get_custom_field() Get custom field value.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array $classes Existing post classes
 * @return array          Amended post classes
 */
function exmachina_custom_post_class( array $classes ) {

  $new_class = exmachina_get_custom_field( '_exmachina_custom_post_class' );

  if ( $new_class )
    $classes[] = esc_attr( $new_class );

  return $classes;

} // end function exmachina_custom_post_class()



/**
 * Post Format Icon
 *
 * Add a post format icon. Adds an image, corresponding to the post format,
 * before the post title.
 *
 * @todo test image format dir
 * @todo inline comment
 * @todo docblock comment
 * @todo add post format image library (???)
 * @todo check hybrid themes for post format image icon use
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Post
 * @link http://codex.wordpress.org/Post_Formats
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports
 * @link http://codex.wordpress.org/Function_Reference/get_post_format
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 * @link http://codex.wordpress.org/Function_Reference/the_title_attribute
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $post WP_Post object.
 * @return null         Return early if post formats or `exmachina-post-format-images` are not supported
 */
function exmachina_do_post_format_image() {

  //* Do nothing if post formats aren't supported
  if ( ! current_theme_supports( 'post-formats' ) || ! current_theme_supports( 'exmachina-post-format-images' ) )
    return;

  //* Get post format
  $post_format = get_post_format();

  //* If post format is set, look for post format image
  if ( $post_format && file_exists( sprintf( '%s/images/post-formats/%s.png', CHILD_THEME_DIR, $post_format ) ) )
    printf( '<a href="%s" title="%s" rel="bookmark"><img src="%s" class="post-format-image" alt="%s" /></a>', get_permalink(), the_title_attribute( 'echo=0' ), sprintf( '%s/images/post-formats/%s.png', CHILD_THEME_URL, $post_format ), $post_format );

  //* Else, look for the default post format image
  elseif ( file_exists( sprintf( '%s/images/post-formats/default.png', CHILD_THEME_DIR ) ) )
    printf( '<a href="%s" title="%s" rel="bookmark"><img src="%s/images/post-formats/default.png" class="post-format-image" alt="%s" /></a>', get_permalink(), the_title_attribute( 'echo=0' ), CHILD_THEME_URL, 'post' );

} // end function exmachina_do_post_format_image()


/**
 * Entry Header Open Markup
 *
 * Echo the opening structural markup for the entry header.
 *
 * @todo inline comment
 * @todo docblock comments
 *
 * @uses exmachina_attr() Contextual attributes.
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_entry_header_markup_open() {

  printf( '<header %s>', exmachina_attr( 'entry-header' ) );

} // end function exmachina_entry_header_markup_open()


/**
 * Entry Header Close Markup
 *
 * Echo the closing structural markup for the entry header.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_entry_header_markup_close() {

  echo '</header>';

} // end function exmachina_entry_header_markup_close()


/**
 * Post Title Output
 *
 * Echo the title of a post. The `exmachina_post_title_text` filter is applied
 * on the text of the title, while the `exmachina_post_title_output` filter is
 * applied on the echoed markup.
 *
 * @todo inline comment
 * @todo compare on hybrid title function
 *
 * @link http://codex.wordpress.org/Function_Reference/get_the_title
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 * @link http://codex.wordpress.org/Function_Reference/the_title_attribute
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 *
 * @uses exmachina_get_SEO_option() Get SEO setting value.
 * @uses exmachina_markup()         Contextual markup.
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return early if the length of the title string is zero.
 */
function exmachina_do_post_title() {

  $title = apply_filters( 'exmachina_post_title_text', get_the_title() );

  if ( 0 === mb_strlen( $title ) )
    return;

  //* Link it, if necessary
  if ( ! is_singular() && apply_filters( 'exmachina_link_post_title', true ) )
    $title = sprintf( '<a href="%s" title="%s" rel="bookmark">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $title );

  //* Wrap in H1 on singular pages
  $wrap = is_singular() ? 'h1' : 'h2';

  //* Also, if HTML5 with semantic headings, wrap in H1
  $wrap = exmachina_get_seo_option( 'semantic_headings' ) ? 'h1' : $wrap;

  //* Build the output
  $output = exmachina_markup( array(
    'html'   => "<{$wrap} %s>",
    'context' => 'entry-title',
    'echo'    => false,
  ) );

  $output .= "{$title}</{$wrap}>";

  echo apply_filters( 'exmachina_post_title_output', "$output \n" );

} // end function exmachina_do_post_title()


/**
 * Post Info Output
 *
 * Echo the post info (byline) under the post title. Doesn't do post info on
 * pages. The post info makes use of several shortcodes by default, and the
 * whole output is filtered via `exmachina_post_info` before echoing.
 *
 * @todo remove xhtml markup
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Post
 * @link http://codex.wordpress.org/Function_Reference/get_post_type
 *
 * @uses exmachina_get_option() [description]
 * @uses exmachina_markup() Contextual markup.
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $post WP_Post post object.
 * @return null         Return early if on a page.
 */
function exmachina_post_info() {

  global $post;

  if ( 'page' === get_post_type( $post->ID ) )
    return;

  $post_info = apply_filters( 'exmachina_post_info', exmachina_get_option( 'post_info' ) );

  exmachina_markup( array(
    'html' => sprintf( '<p class="entry-meta">%s</p>', $post_info ),
  ) );

} // end function exmachina_post_info()


/**
 * Post Image Output
 *
 * Echo the post image on archive pages. If this an archive page and the option
 * is set to show thumbnail, then it gets the image size as per the theme
 * setting, wraps it in the post permalink and echoes it.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 * @link http://codex.wordpress.org/Function_Reference/the_title_attribute
 *
 * @uses exmachina_get_option() Get theme setting value.
 * @uses exmachina_get_image()  Return an image pulled from the media library.
 * @uses exmachina_parse_attr() Return contextual attributes.
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_do_post_image() {

  if ( ! is_singular() && exmachina_get_option( 'content_archive_thumbnail' ) ) {
    $img = exmachina_get_image( array(
      'format'  => 'html',
      'size'    => exmachina_get_option( 'image_size' ),
      'context' => 'archive',
      'attr'    => exmachina_parse_attr( 'entry-image' ),
    ) );

    if ( ! empty( $img ) )
      printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
  }

} // end function exmachina_do_post_image()


/**
 * Post Content Output
 *
 * Echo the post content. On single posts or pages it echoes the full content,
 * and optionally the trackback string if enabled. On single pages, also adds
 * the edit link after the content. Elsewhere it displays either the excerpt,
 * limited content, or full content.
 *
 * Applies the `exmachina_edit_post_link` filter.
 *
 * @todo inline comment
 * @todo compare against omega
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Post
 * @link http://codex.wordpress.org/Conditional_Tags
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/post_type_supports
 * @link http://codex.wordpress.org/Function_Reference/trackback_rdf
 * @link http://codex.wordpress.org/Function_Reference/edit_post_link
 * @link http://codex.wordpress.org/Function_Reference/the_excerpt
 * @link http://codex.wordpress.org/Function_Reference/the_content
 *
 * @uses exmachina_get_option() Get theme setting value.
 * @uses the_content_limit()    Limited content.
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $post WP_Post post object.
 * @return void
 */
function exmachina_do_post_content() {
  global $post;

  if ( is_singular() ) {
    the_content();

    if ( is_single() && 'open' === get_option( 'default_ping_status' ) && post_type_supports( $post->post_type, 'trackbacks' ) ) {
      echo '<!--';
      trackback_rdf();
      echo '-->' . "\n";
    }

    if ( is_page() && apply_filters( 'exmachina_edit_post_link', true ) )
      edit_post_link( __( '(Edit)', 'exmachina' ), '', '' );
  }
  elseif ( 'excerpts' === exmachina_get_option( 'content_archive' ) ) {
    the_excerpt();
  }
  else {
    if ( exmachina_get_option( 'content_archive_limit' ) )
      the_content_limit( (int) exmachina_get_option( 'content_archive_limit' ), __( '[Read more...]', 'exmachina' ) );
    else
      the_content( __( '[Read more...]', 'exmachina' ) );
  }

} // end function exmachina_do_post_content()


/**
 * Post Content Navigation
 *
 * Display page links for paginated posts (i.e. includes the <!--nextpage-->
 * Quicktag one or more times).
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_link_pages
 *
 * @uses exmachina_markup() Contextual markup.
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_do_post_content_nav() {

  wp_link_pages( array(
    'before' => exmachina_markup( array(
        'html'   => '<div %s>',
        'context' => 'entry-pagination',
        'echo'    => false,
      ) ) . __( 'Pages:', 'exmachina' ),
    'after'  => '</div>',
  ) );

} // end function exmachina_do_post_content_nav()


/**
 * Post Permalink
 *
 * Show permalink if no title. If the entry has no title, this is a way to display
 * a link to the full post.
 *
 * Applies the `exmachina_post_permalink` filter.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 * @link http://codex.wordpress.org/Function_Reference/get_the_title
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Returns early if singular or post has title.
 */
function exmachina_do_post_permalink() {

  //* Don't show on singular views, or if the entry has a title
  if ( is_singular() || get_the_title() )
    return;

  $permalink = get_permalink();

  echo apply_filters( 'exmachina_post_permalink', sprintf( '<p class="entry-permalink"><a href="%s" title="%s" rel="bookmark">%s</a></p>', esc_url( $permalink ), __( 'Permalink', 'exmachina' ), esc_html( $permalink ) ) );

} // end function exmachina_do_post_permalink()


/**
 * No Posts Output
 *
 * Echo filterable content when there are no posts to show. The applied filter
 * is `exmachina_noposts_text`.
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_do_noposts() {

  /* Print the no posts markup. */
  printf( '<div class="entry"><p>%s</p></div>', apply_filters( 'exmachina_noposts_text', __( 'Sorry, no content matched your criteria.', 'exmachina' ) ) );

} // end function exmachina_do_noposts()


/**
 * Entry Footer Open Markup
 *
 * Echo the opening structural markup for the entry footer.
 *
 * @todo inline comment
 *
 * @uses exmachina_attr() Contextual attributes.
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_entry_footer_markup_open() {

  if ( 'post' === get_post_type() )
    printf( '<footer %s>', exmachina_attr( 'entry-footer' ) );

} // end function exmachina_entry_footer_markup_open()


/**
 * Entry Footer Close Markup
 *
 * Echo the closing structural markup for the entry footer.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_post_type
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_entry_footer_markup_close() {

  /* Close the footer tag if it's a post. */
  if ( 'post' === get_post_type() )
    echo '</footer>';

} // end function exmachina_entry_footer_markup_close()


/**
 * Post Meta Output
 *
 * Echo the post meta after the post content. Doesn't do post meta on pages.
 * The post info makes use of a couple of shortcodes by default, and the whole
 * output is filtered via `exmachina_post_meta` before echoing.
 *
 * @todo inline comment
 * @todo remove xhtml markup
 *
 * @uses exmachina_get_option() [description]
 * @uses exmachina_markup() Contextual markup.
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $post WP_Post post object.
 * @return null         Return early if on a page
 */
function exmachina_post_meta() {

  global $post;

  if ( 'page' === get_post_type( $post->ID ) )
    return;

  $post_meta = apply_filters( 'exmachina_post_meta', exmachina_get_option( 'post_meta' ) );

  exmachina_markup( array(
    'html' => sprintf( '<p class="entry-meta">%s</p>', $post_meta ),
  ) );

} // end function exmachina_post_meta()


/**
 * Single Author Box Output
 *
 * Conditionally add the author box after single posts or pages.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Function_Reference/is_single
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 *
 * @uses exmachina_author_box() Echo the author box.
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return early if not a single post or page.
 */
function exmachina_do_author_box_single() {

  if ( ! is_single() )
    return;

  if ( get_the_author_meta( 'exmachina_author_box_single', get_the_author_meta( 'ID' ) ) )
    exmachina_author_box( 'single' );

} // end function exmachina_do_author_box_single()


/**
 * Author Box Output
 *
 * Echo the the author box and its contents. The title is filterable via
 * `exmachina_author_box_title`, and the gravatar size is filterable via
 * `exmachina_author_box_gravatar_size`.
 *
 * The final output is filterable via `exmachina_author_box`, which passes many
 * variables through.
 *
 * @todo inline comment
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_User
 * @link http://codex.wordpress.org/Function_Reference/get_userdata
 * @link http://codex.wordpress.org/Function_Reference/get_query_var
 * @link http://codex.wordpress.org/Function_Reference/get_avatar
 * @link http://codex.wordpress.org/Function_Reference/get_the_author_meta
 * @link http://codex.wordpress.org/Function_Reference/get_the_author
 *
 * @uses exmachina_attr()  Contextual attributes.
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $authordata WP_User author object.
 * @param  string $context    Optional. Allows different contextual author box markup. Default is empty string.
 * @param  bool   $echo       Optional. If true, the author box will echo. If false, it will be returned.
 * @return string             HTML for author box.
 */
function exmachina_author_box( $context = '', $echo = true ) {
  global $authordata;

  $authordata    = is_object( $authordata ) ? $authordata : get_userdata( get_query_var( 'author' ) );
  $gravatar_size = apply_filters( 'exmachina_author_box_gravatar_size', 70, $context );
  $gravatar      = get_avatar( get_the_author_meta( 'email' ), $gravatar_size );
  $description   = wpautop( get_the_author_meta( 'description' ) );

  //* The author box markup, contextual

    $title = apply_filters( 'exmachina_author_box_title', sprintf( '%s <span itemprop="name">%s</span>', __( 'About', 'exmachina' ), get_the_author() ), $context );

    $pattern  = sprintf( '<section %s>', exmachina_attr( 'author-box' ) );
    $pattern .= '%s<h1 class="author-box-title">%s</h1>';
    $pattern .= '<div class="author-box-content" itemprop="description">%s</div>';
    $pattern .= '</section>';




  $output = apply_filters( 'exmachina_author_box', sprintf( $pattern, $gravatar, $title, $description ), $context, $pattern, $gravatar, $title, $description );

  if ( $echo )
    echo $output;
  else
    return $output;

} // end function exmachina_author_box()


/**
 * After Post Widget Area
 *
 * Output widget area after the post content.
 *
 * @todo inline comment
 * @todo docblock comment
 * @todo check against hybrid singular
 *
 * @uses exmachina_widget_area()
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Returns early if not a singular post page
 */
function exmachina_after_entry_widget_area() {

  if ( ! is_singular( 'post' ) )
    return;

  exmachina_widget_area( 'after-post' );

} // end function exmachina_after_entry_widget_area()


/**
 * Post Navigation Output
 *
 * Conditionally echo archive pagination in a format dependent on chosen
 * setting. This is shown at the end of archives to get to another page of entries.
 *
 * @todo inline comment
 * @todo check against loop pagination
 *
 * @uses exmachina_get_option()            Get theme setting value.
 * @uses exmachina_numeric_posts_nav()     Numbered links.
 * @uses exmachina_prev_next_posts_nav()   Prev and Next links.
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_posts_nav() {

  if ( 'numeric' === exmachina_get_option( 'posts_nav' ) )
    exmachina_numeric_posts_nav();
  else
    exmachina_prev_next_posts_nav();

} // end function exmachina_posts_nav()

/**
 * Previous/Next Post Nav Format
 *
 * Echo archive pagination in Previous Posts / Next Posts format. Applies
 * `exmachina_prev_link_text` and `exmachina_next_link_text` filters.
 *
 * @todo inline comment
 * @todo docblock comment
 * @todo remove xhtml markup
 * @todo add codex links
 *
 * @link http://codex.wordpress.org/Function_Reference/get_previous_posts_link
 * @link http://codex.wordpress.org/Function_Reference/get_next_posts_link
 *
 * @uses exmachina_markup() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_prev_next_posts_nav() {

  $prev_link = get_previous_posts_link( apply_filters( 'exmachina_prev_link_text', '&#x000AB;' . __( 'Previous Page', 'exmachina' ) ) );
  $next_link = get_next_posts_link( apply_filters( 'exmachina_next_link_text', __( 'Next Page', 'exmachina' ) . '&#x000BB;' ) );

  $prev = $prev_link ? '<div class="pagination-previous alignleft">' . $prev_link . '</div>' : '';
  $next = $next_link ? '<div class="pagination-next alignright">' . $next_link . '</div>' : '';

  $nav = exmachina_markup( array(
    'html'   => '<div %s>',
    'context' => 'archive-pagination',
    'echo'    => false,
  ) );

  $nav .= $prev;
  $nav .= $next;
  $nav .= '</div>';

  if ( $prev || $next )
    echo $nav;
} // end function exmachina_prev_next_posts_nav()

/**
 * Numeric Posts Nav Output
 *
 * Echo archive pagination in page numbers format. Applies the `exmachina_prev_link_text`
 * and `exmachina_next_link_text` filters.
 *
 * The links, if needed, are ordered as:
 *
 *  * previous page arrow,
 *  * first page,
 *  * up to two pages before current page,
 *  * current page,
 *  * up to two pages after the current page,
 *  * last page,
 *  * next page arrow.
 *
 * @todo inline comment
 * @todo docblock comment
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Query
 *
 * @uses exmachina_markup() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $wp_query WP_Query query object.
 * @return null             Return early if on a single post or page, or only one page present.
 */
function exmachina_numeric_posts_nav() {

  if( is_singular() )
    return;

  global $wp_query;

  //* Stop execution if there's only 1 page
  if( $wp_query->max_num_pages <= 1 )
    return;

  $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
  $max   = intval( $wp_query->max_num_pages );

  //* Add current page to the array
  if ( $paged >= 1 )
    $links[] = $paged;

  //* Add the pages around the current page to the array
  if ( $paged >= 3 ) {
    $links[] = $paged - 1;
    $links[] = $paged - 2;
  }

  if ( ( $paged + 2 ) <= $max ) {
    $links[] = $paged + 2;
    $links[] = $paged + 1;
  }

  exmachina_markup( array(
    'html'   => '<div %s>',
    'context' => 'archive-pagination',
  ) );

  echo '<ul>';

  //* Previous Post Link
  if ( get_previous_posts_link() )
    printf( '<li class="pagination-previous">%s</li>' . "\n", get_previous_posts_link( apply_filters( 'exmachina_prev_link_text', '&#x000AB;' . __( 'Previous Page', 'exmachina' ) ) ) );

  //* Link to first page, plus ellipses if necessary
  if ( ! in_array( 1, $links ) ) {

    $class = 1 == $paged ? ' class="active"' : '';

    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

    if ( ! in_array( 2, $links ) )
      echo '<li class="pagination-omission">&#x02026;</li>';

  }

  //* Link to current page, plus 2 pages in either direction if necessary
  sort( $links );
  foreach ( (array) $links as $link ) {
    $class = $paged == $link ? ' class="active"' : '';
    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
  }

  //* Link to last page, plus ellipses if necessary
  if ( ! in_array( $max, $links ) ) {

    if ( ! in_array( $max - 1, $links ) )
      echo '<li class="pagination-omission">&#x02026;</li>' . "\n";

    $class = $paged == $max ? ' class="active"' : '';
    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );

  }

  //* Next Post Link
  if ( get_next_posts_link() )
    printf( '<li class="pagination-next">%s</li>' . "\n", get_next_posts_link( apply_filters( 'exmachina_next_link_text', __( 'Next Page', 'exmachina' ) . '&#x000BB;' ) ) );

  echo '</ul></div>' . "\n";

} // end function exmachina_numeric_posts_nav()

/**
 * Single Post Nav Output
 *
 * Display links to previous and next post, from a single post.
 *
 * @todo inline comment
 * @todo remove xhtml markup
 *
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 * @link http://codex.wordpress.org/Function_Reference/previous_posts_link
 * @link http://codex.wordpress.org/Function_Reference/next_posts_link
 *
 * @uses exmachina_markup() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return early if not a post.
 */
function exmachina_prev_next_post_nav() {

  if ( ! is_singular( 'post' ) )
    return;

  exmachina_markup( array(
    'html'   => '<div %s>',
    'context' => 'adjacent-entry-pagination',
  ) );

  echo '<div class="pagination-previous alignleft">';
  previous_post_link();
  echo '</div>';

  echo '<div class="pagination-next alignright">';
  next_post_link();
  echo '</div>';

  echo '</div>';

} // end function exmachina_prev_next_post_nav()