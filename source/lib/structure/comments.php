<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Comments Structure
 *
 * comments.php
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

/* Adds the comment template after the post. */
add_action( 'exmachina_after_post', 'exmachina_get_comments_template' );
add_action( 'exmachina_after_entry', 'exmachina_get_comments_template' );

/* Adds the comment and ping structure. */
add_action( 'exmachina_comments', 'exmachina_do_comments' );
add_action( 'exmachina_pings', 'exmachina_do_pings' );

/* Adds the comment and ping list. */
add_action( 'exmachina_list_comments', 'exmachina_default_list_comments' );
add_action( 'exmachina_list_pings', 'exmachina_default_list_pings' );

/* Adds the comment form. */
add_action( 'exmachina_comment_form', 'exmachina_do_comment_form' );
add_filter( 'comment_form_defaults', 'exmachina_comment_form_args' );

/* Filters the comments link. */
add_filter( 'get_comments_link', 'exmachina_comments_link_filter', 10, 2 );

/* Filters the comment args on the front-end. */
add_filter( 'exmachina_title_comments', 'exmachina_custom_title_comments' );
add_filter( 'exmachina_no_comments_text', 'exmachina_custom_no_comments_text' );
add_filter( 'exmachina_comments_closed_text', 'exmachina_custom_comments_closed_text' );
add_filter( 'exmachina_title_pings', 'exmachina_custom_title_pings' );
add_filter( 'exmachina_no_pings_text', 'exmachina_custom_no_pings_text' );
add_filter( 'exmachina_comment_list_args', 'exmachina_custom_comment_list_args' );
add_filter( 'comment_author_says_text', 'exmachina_custom_comment_author_says_text' );
add_filter( 'exmachina_comment_awaiting_moderation', 'exmachina_custom_comment_awaiting_moderation' );
add_filter( 'exmachina_comment_form_args', 'exmachina_custom_comment_form_args' );

// add disqus compatibility
// @todo test against discus
  if (function_exists('dsq_comments_template')) {
    remove_filter( 'comments_template', 'dsq_comments_template' );
    add_filter( 'comments_template', 'dsq_comments_template', 12 ); // You can use any priority higher than '10'
  }

/**
 * Comments Template Output
 *
 * Outputs the comments at the end of entries. Only loads comments if on a post,
 * page, or custom post type that supports comments, and only if comments or
 * trackbacks are enabled.
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Post
 * @link http://codex.wordpress.org/Function_Reference/post_type_supports
 * @link http://codex.wordpress.org/Function_Reference/is_singular
 * @link http://codex.wordpress.org/Function_Reference/comments_template
 *
 * @uses exmachina_get_option() Gets the options db value.
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $post WP_Post object
 * @return null         Return early if comments not supported.
 */
function exmachina_get_comments_template() {
  global $post;

  /* Return early if post type doesn't support comments. */
  if ( ! post_type_supports( $post->post_type, 'comments' ) )
    return;

  /* If a custom post type, return the comments template. */
  if ( is_singular() && ! in_array( $post->post_type, array( 'post', 'page' ) ) )
    comments_template( '', true );

  /* If a post with comments OR trackbacks enabled, return the comments template. */
  elseif ( is_singular( 'post' ) && ( exmachina_get_option( 'trackbacks_posts' ) || exmachina_get_option( 'comments_posts' ) ) )
    comments_template( '', true );

  /* If a page with comments OR trackbacks enabled, return the comments template. */
  elseif ( is_singular( 'page' ) && ( exmachina_get_option( 'trackbacks_pages' ) || exmachina_get_option( 'comments_pages' ) ) )
    comments_template( '', true );
} // end function exmachina_get_comments_template()

/**
 * Comments Markup Structure
 *
 * Echoes out the default comment structure. The actual comment list markup is
 * hooked onto the 'exmachina_list_comments' action hook.
 *
 * @todo simplify markup
 * @todo remove xhtml markup
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Query
 * @link http://codex.wordpress.org/Class_Reference/WP_Post
 * @link http://codex.wordpress.org/Function_Reference/is_page
 * @link http://codex.wordpress.org/Function_Reference/is_single
 * @link http://codex.wordpress.org/Function_Reference/have_comments
 * @link http://codex.wordpress.org/Template_Tags/previous_comments_link
 * @link https://codex.wordpress.org/Function_Reference/next_comments_link
 *
 * @uses exmachina_get_option() [description]
 * @uses exmachina_markup() [description]
 * @uses exmachina_attr() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $post     WP_Post object.
 * @global object $wp_query WP_Query object.
 * @return null             Return early if comments are not enabled.
 */
function exmachina_do_comments() {
  global $post, $wp_query;

  /* Abort early if comments are off for this post type. */
  if ( ( is_page() && ! exmachina_get_option( 'comments_pages' ) ) || ( is_single() && ! exmachina_get_option( 'comments_posts' ) ) )
    return;

  /* If the displayed post type post type has comments. */
  if ( have_comments() && ! empty( $wp_query->comments_by_type['comment'] ) ) {

    exmachina_markup( array(
      'html'   => '<div %s>',
      'context' => 'entry-comments',
    ) );

    echo apply_filters( 'exmachina_title_comments', __( '<h3>Comments</h3>', 'exmachina' ) );
    echo '<ol class="comment-list">';
      do_action( 'exmachina_list_comments' );
    echo '</ol>';

    /* Comment Navigation. */
    $prev_link = get_previous_comments_link( apply_filters( 'exmachina_prev_comments_link_text', '' ) );
    $next_link = get_next_comments_link( apply_filters( 'exmachina_next_comments_link_text', '' ) );

    if ( $prev_link || $next_link ) {

      exmachina_markup( array(
        'html'   => '<div %s>',
        'context' => 'comments-pagination',
      ) );

      printf( '<div class="pagination-previous alignleft">%s</div>', $prev_link );
      printf( '<div class="pagination-next alignright">%s</div>', $next_link );

      echo '</div>';

    } // end if ($prev_link || $next_link)

    echo '</div>';

  } // end if (have_comments() && ! empty($wp_query->comments_by_type['comment']))

  /* No comments so far. */
  elseif ( 'open' === $post->comment_status && $no_comments_text = apply_filters( 'exmachina_no_comments_text', '' ) ) {
    echo sprintf( '<div %s>', exmachina_attr( 'entry-comments' ) ) . $no_comments_text . '</div>';
  }

  elseif ( $comments_closed_text = apply_filters( 'exmachina_comments_closed_text', '' ) ) {
    echo sprintf( '<div %s>', exmachina_attr( 'entry-comments' ) ) . $comments_closed_text . '</div>';
  }

} // end function exmachina_do_comments()

/**
 * Trackbacks Markup Structure
 *
 * Echoes out the default trackbacks structure. The actual trackbacks list markup
 * is hooked onto the 'exmachina_list_pings' action hook.
 *
 * @todo simplify markup
 * @todo remove xhtml markup
 * @todo comment function code
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Query
 * @link http://codex.wordpress.org/Function_Reference/is_page
 * @link http://codex.wordpress.org/Function_Reference/is_single
 * @link http://codex.wordpress.org/Function_Reference/have_comments
 *
 * @uses exmachina_get_option() [description]
 * @uses exmachina_markup() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @global object $wp_query WP_Query object.
 * @return null             Return early if trackbacks are not enabled.
 */
function exmachina_do_pings() {
  global $wp_query;

  /* Abort if trackbacks are off for this post type. */
  if ( ( is_page() && ! exmachina_get_option( 'trackbacks_pages' ) ) || ( is_single() && ! exmachina_get_option( 'trackbacks_posts' ) ) )
    return;

  /* If have pings. */
  if ( have_comments() && !empty( $wp_query->comments_by_type['pings'] ) ) {

    exmachina_markup( array(
      'html'   => '<div %s>',
      'context' => 'entry-pings',
    ) );

    echo apply_filters( 'exmachina_title_pings', __( '<h3>Trackbacks</h3>', 'exmachina' ) );
    echo '<ol class="ping-list">';
      do_action( 'exmachina_list_pings' );
    echo '</ol>';

    echo '</div>';

  } else {

    echo apply_filters( 'exmachina_no_pings_text', '' );

  }
} // end function exmachina_do_pings()

/**
 * Comment List Output
 *
 * Outputs the list of comments and applies the 'exmachina_comment_list_args'
 * filter.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_list_comments
 *
 * @uses exmachina_comment_callback() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_default_list_comments() {

  /* Sets the default args array. */
  $defaults = array(
    'type'        => 'comment',
    'avatar_size' => 48,
    'format'      => 'html5', //* Not necessary, but a good example
    'callback'    => 'exmachina_comment_callback',
  );

  /* Apply the args filter. */
  $args = apply_filters( 'exmachina_comment_list_args', $defaults );

  /* List the comments. */
  wp_list_comments( $args );
} // end function exmachina_default_list_comments()

/**
 * Trackbacks List Output
 *
 * Outputs the list of trackbacks and applies the 'exmachina_ping_list_args'
 * filter.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_list_comments
 *
 * @since 0.5.0
 * @access public
 *
 * @return void
 */
function exmachina_default_list_pings() {

  /* Apply the args filter. */
  $args = apply_filters( 'exmachina_ping_list_args', array(
    'type' => 'pings',
  ) );

  /* List the comments. */
  wp_list_comments( $args );
} // end function exmachina_default_list_pings()

/**
 * Comment Callback
 *
 * Comment callback for exmachina_default_list_comments() to display the comment
 * text, avatar, link, reply, and markup.
 *
 * @todo compare against hybrid comment functionality
 * @todo do a better job seperating HTML from PHP
 *
 * @link http://codex.wordpress.org/Class_Reference/WP_Comment_Query
 * @link http://codex.wordpress.org/Function_Reference/comment_class
 * @link http://codex.wordpress.org/Function_Reference/comment_ID
 * @link http://codex.wordpress.org/Function_Reference/get_avatar
 * @link http://codex.wordpress.org/Function_Reference/get_comment_author
 * @link http://codex.wordpress.org/Function_Reference/get_comment_author_url
 * @link http://codex.wordpress.org/Function_Reference/get_comment_link
 * @link http://codex.wordpress.org/Function_Reference/get_comment_date
 * @link http://codex.wordpress.org/Function_Reference/get_comment_time
 * @link http://codex.wordpress.org/Function_Reference/edit_comment_link
 * @link http://codex.wordpress.org/Function_Reference/comment_text
 * @link http://codex.wordpress.org/Function_Reference/comment_reply_link
 *
 * @uses exmachina_attr() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @param  stdClass  $comment WP_Comment_Query comment object.
 * @param  array     $args    Comment args.
 * @param  integer   $depth   Depth of current comment.
 * @return void
 */
function exmachina_comment_callback( $comment, array $args, $depth ) {

  $GLOBALS['comment'] = $comment; ?>

  <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
  <article <?php echo exmachina_attr( 'comment' ); ?>>

    <?php do_action( 'exmachina_before_comment' ); ?>

    <header class="comment-header">
      <p <?php echo exmachina_attr( 'comment-author' ); ?>>
        <?php
        echo get_avatar( $comment, $args['avatar_size'] );

        $author = get_comment_author();
        $url    = get_comment_author_url();

        if ( ! empty( $url ) && 'http://' !== $url ) {
          $author = sprintf( '<a href="%s" rel="external nofollow" itemprop="url">%s</a>', esc_url( $url ), $author );
        }

        printf( '<span itemprop="name">%s</span> <span class="says">%s</span>', $author, apply_filters( 'comment_author_says_text', __( 'says', 'exmachina' ) ) );
        ?>
      </p>

      <p class="comment-meta">
        <?php
        $pattern = '<time itemprop="commentTime" datetime="%s"><a href="%s" itemprop="url">%s %s %s</a></time>';
        printf( $pattern, esc_attr( get_comment_time( 'c' ) ), esc_url( get_comment_link( $comment->comment_ID ) ), esc_html( get_comment_date() ), __( 'at', 'exmachina' ), esc_html( get_comment_time() ) );

        edit_comment_link( __( '(Edit)', 'exmachina' ), ' ' );
        ?>
      </p>
    </header>

    <div class="comment-content" itemprop="commentText">
      <?php if ( ! $comment->comment_approved ) : ?>
        <p class="alert"><?php echo apply_filters( 'exmachina_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'exmachina' ) ); ?></p>
      <?php endif; ?>

      <?php comment_text(); ?>
    </div>

    <?php
    comment_reply_link( array_merge( $args, array(
      'depth'  => $depth,
      'before' => '<div class="comment-reply">',
      'after'  => '</div>',
    ) ) );
    ?>

    <?php do_action( 'exmachina_after_comment' ); ?>

  </article>
  <?php
  //* No ending </li> tag because of comment threading
} // end function exmachina_comment_callback()

/**
 * Comment Form Display
 *
 * Optionally show the comment form. Currently calls the HTML5 version of the
 * form from WordPress.
 *
 * @todo check against hybrid functionality
 *
 * @link http://codex.wordpress.org/Function_Reference/is_page
 * @link http://codex.wordpress.org/Function_Reference/is_single
 * @link http://codex.wordpress.org/Function_Reference/comment_form
 *
 * @uses exmachina_get_option() [description]
 *
 * @since 0.5.0
 * @access public
 *
 * @return null Return early if comments are closed.
 */
function exmachina_do_comment_form() {

  /* Abort if the comments are closed on the post type. */
  if ( ( is_page() && ! exmachina_get_option( 'comments_pages' ) ) || ( is_single() && ! exmachina_get_option( 'comments_posts' ) ) )
    return;

  /* Display the HTML5 comment form. */
  comment_form( array( 'format' => 'html5' ) );

} // end function exmachina_do_comment_form()

/**
 * Comment Form Arguments Filter
 *
 * Filter the default comment form arguments used by 'comment_form()'. Applies
 * the 'exmachina_comment_form_args' filter.
 *
 * @todo possibly remvoe this function (or update to make relevent)
 * @todo cleanup filter/inline comment
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_get_current_commenter
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/wp_parse_args
 * @link http://codex.wordpress.org/Function_Reference/get_the_ID
 *
 * @since 0.5.0
 * @access public
 *
 * @global string $user_identity Display the name of the user.
 * @param  array  $defaults      Comment form defaults.
 * @return array                 Filterable array.
 */
function exmachina_comment_form_args( array $defaults ) {

  //* Use WordPress default HTML5 comment form if themes supports HTML5
    return $defaults;

  global $user_identity;

  $commenter = wp_get_current_commenter();
  $req       = get_option( 'require_name_email' );
  $aria_req  = ( $req ? ' aria-required="true"' : '' );

  $author = '<p class="comment-form-author">' .
            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' .
            '<label for="author">' . __( 'Name', 'exmachina' ) . '</label> ' .
            ( $req ? '<span class="required">*</span>' : '' ) .
            '</p>';

  $email = '<p class="comment-form-email">' .
           '<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' .
           '<label for="email">' . __( 'Email', 'exmachina' ) . '</label> ' .
           ( $req ? '<span class="required">*</span>' : '' ) .
           '</p>';

  $url = '<p class="comment-form-url">' .
         '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' .
         '<label for="url">' . __( 'Website', 'exmachina' ) . '</label>' .
         '</p>';

  $comment_field = '<p class="comment-form-comment">' .
                   '<textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' .
                   '</p>';

  $args = array(
    'comment_field'        => $comment_field,
    'title_reply'          => __( 'Speak Your Mind', 'exmachina' ),
    'comment_notes_before' => '',
    'comment_notes_after'  => '',
    'fields'               => array(
      'author' => $author,
      'email'  => $email,
      'url'    => $url,
    ),
  );

  //* Merge $args with $defaults
  $args = wp_parse_args( $args, $defaults );

  //* Return filterable array of $args, along with other optional variables
  return apply_filters( 'exmachina_comment_form_args', $args, $user_identity, get_the_ID(), $commenter, $req, $aria_req );

} // end function exmachina_comment_form_args()

/**
 * Comments Link Filter
 *
 * Filter the comments link. If post has comments, link to #comments div. If no,
 * link to #respond div.
 *
 * @todo add docblock params
 * @todo add inline commenting
 *
 * @link http://codex.wordpress.org/Template_Tags/get_comments_number
 * @link http://codex.wordpress.org/Function_Reference/get_permalink
 *
 * @since 0.5.0
 * @access public
 *
 * @param  [type] $link    [description]
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function exmachina_comments_link_filter( $link, $post_id ) {

  if ( 0 == get_comments_number() )
    return get_permalink( $post_id ) . '#respond';

  return $link;

} // end function exmachina_comments_link_filter()

/*-------------------------------------------------------------------------*/
/* Begin custom comment form filters. */
/*-------------------------------------------------------------------------*/

/**
 * Custom Comment Title
 *
 * Filters Comment Title to title from content settings.
 *
 * @uses exmachina_get_content_option() Gets the setting from the content db.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $args Comment arguments.
 * @return string       Comments title.
 */
function exmachina_custom_title_comments( $args ) {

  if( exmachina_get_content_option('comment_title_wrap') )
    return str_replace( '%s', esc_attr( exmachina_get_content_option('comments_title') ), exmachina_get_content_option('comment_title_wrap') );
  else
    return exmachina_get_content_option('comments_title');

} // end function exmachina_custom_title_comments()

/**
 * Custom No Comments Text
 *
 * Filters No Comment Text to text from content settings.
 *
 * @uses exmachina_get_content_option() Gets the setting from the content db.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $args Comment arguments.
 * @return string       No comments text.
 */
function exmachina_custom_no_comments_text( $args ) {

  return exmachina_get_content_option('no_comments_text');

} // end function exmachina_custom_no_comments_text()

/**
 * Custom Closed Text
 *
 * Filters Comments Closed Text to text from content settings.
 *
 * @uses exmachina_get_content_option() Gets the setting from the content db.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $args Comment arguments.
 * @return string       Comments closed text.
 */
function exmachina_custom_comments_closed_text( $args ) {

  return exmachina_get_content_option('comments_closed_text');

} // end function exmachina_custom_comments_closed_text()

/**
 * Custom Trackbacks Title
 *
 * Filters Ping Title to title from content settings.
 *
 * @uses exmachina_get_content_option() Gets the setting from the content db.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $args Comment arguments.
 * @return string       Custom title.
 */
function exmachina_custom_title_pings( $args ) {

  if( exmachina_get_content_option('comment_title_wrap') )
    return str_replace( '%s', esc_attr( exmachina_get_content_option('comments_title_pings') ), exmachina_get_content_option('comment_title_wrap') );
  else
    return exmachina_get_content_option('comments_title_pings');

} // end function exmachina_custom_title_pings()

/**
 * Custom No Trackbacks Text
 *
 * Filters No Pings Text to text from content settings.
 *
 * @uses exmachina_get_content_option() Gets the setting from the content db.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $args Comment arguments.
 * @return string       No pings text.
 */
function exmachina_custom_no_pings_text( $args ) {

  return exmachina_get_content_option('comments_no_pings_text');

} // end function exmachina_custom_no_pings_text()

/**
 * Custom Comment List Args
 *
 * Filters Comment List Arguments to arguments from content settings. Currently
 * only modifies the avatar size.
 *
 * @uses exmachina_get_content_option() Gets the setting from the content db.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $args Comment arguments.
 * @return array        Custom comment arguments.
 */
function exmachina_custom_comment_list_args( $args ) {

  $args['avatar_size'] = intval( exmachina_get_content_option('comment_list_args_avatar_size') );

  return $args;

} // end function exmachina_custom_comment_list_args()

/**
 * Custom Comment Author Says Text
 *
 * Filters Comment Author Says Text to text from content settings.
 *
 * @uses exmachina_get_content_option() Gets the setting from the content db.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $args Comment arguments.
 * @return string       Author says text.
 */
function exmachina_custom_comment_author_says_text( $args ) {

  return exmachina_get_content_option('comment_author_says_text');

} // end function exmachina_custom_comment_author_says_text()

/**
 * Custom Awaiting Moderation Text
 *
 * Filters Comment Awaiting Moderation Text to text from content settings.
 *
 * @uses exmachina_get_content_option() Gets the setting from the content db.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $args Comment arguments.
 * @return string       Awaiting moderation text.
 */
function exmachina_custom_comment_awaiting_moderation( $args ) {

  return exmachina_get_content_option('comment_awaiting_moderation');

} // end function exmachina_custom_comment_awaiting_moderation()

/**
 * Custom Comment Form Args
 *
 * Filters Comment Form Arguments to args from content settings.
 *
 * @todo may need to be modified or removed
 * @todo cleanup functions
 *
 * @uses exmachina_get_content_option() Gets the setting from the content db.
 *
 * @since 0.5.0
 * @access public
 *
 * @param  array  $args Comment arguments.
 * @return array        Comment form arguments.
 */
function exmachina_custom_comment_form_args( $args ) {

  $commenter = wp_get_current_commenter();
  $req = get_option( 'require_name_email' );
  $aria_req = ( $req && exmachina_get_content_option('comment_form_args_fields_aria_display') ? ' aria-required="true"' : '' );

  $args = array(
    'fields' => array(
      'author' => '<p class="comment-form-author">' .
            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' .
            '<label for="author">' . esc_attr( exmachina_get_content_option('comment_form_args_fields_author_label') ) . '</label> ' .
            ( $req ? '<span class="required">*</span>' : '' ) .
            '</p><!-- #form-section-author .form-section -->',

      'email' =>  '<p class="comment-form-email">' .
            '<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' .
            '<label for="email">' . esc_attr( exmachina_get_content_option('comment_form_args_fields_email_label') ) . '</label> ' .
            ( $req ? '<span class="required">*</span>' : '' ) .
            '</p><!-- #form-section-email .form-section -->',

      'url' =>    '<p class="comment-form-url">' .
              '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' .
              '<label for="url">' . esc_attr( exmachina_get_content_option('comment_form_args_fields_url_label') ) . '</label>' .
              '</p><!-- #form-section-url .form-section -->'
    ),

    'comment_field' =>  '<p class="comment-form-comment">' .
              '<textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' .
              '</p><!-- #form-section-comment .form-section -->',

    'title_reply' => exmachina_get_content_option('comment_form_args_title_reply'),
    'comment_notes_before' => exmachina_get_content_option('comment_form_args_comment_notes_before'),
    'comment_notes_after' => exmachina_get_content_option('comment_form_args_comment_notes_after'),
                'label_submit' => esc_attr( exmachina_get_content_option('comment_form_args_label_submit') )
  );

        $args['fields']['author'] = exmachina_get_content_option('comment_form_args_fields_author_display') ? $args['fields']['author'] : '';
        $args['fields']['email'] = exmachina_get_content_option('comment_form_args_fields_email_display') ? $args['fields']['email'] : '';
        $args['fields']['url'] = exmachina_get_content_option('comment_form_args_fields_url_display') ? $args['fields']['url'] : '';

        return $args;

} // end function exmachina_custom_comment_form_args()


