<?php
/**
 * Plugin Name: My Snippets
 * Description: Add custom widget content on a per-post basis from the edit post screen.
 * Version: 0.2.0
 * Author: Machina Themes
 * Author URI: http://machinathemes.com
 *
 * The My Snippets plugin creates a meta box on the edit post screen in the WordPress admin
 * that allows users to add custom metadata to the post. This metadata is then displayed for
 * the singular view of the post on the frontend of the site by using the My Snippets widget.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package   MySnippets
 * @version   0.2.0
 * @since     0.1.0
 * @author    Machina Themes
 * @copyright Copyright (c) 2009 - 2013, Machina Themes
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Sets up the plugin.
 *
 * @since 0.2.0
 */
final class My_Snippets_Plugin {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Stores the directory path for this plugin.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var    string
	 */
	private $directory_path;

	/**
	 * Stores the directory URI for this plugin.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var    string
	 */
	private $directory_uri;

	/**
	 * Plugin setup.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Register widgets. */
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}

	/**
	 * Registers widgets.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function register_widgets() {
		register_widget( 'My_Snippets_Widget_Snippet' );
	}

	/**
	 * Returns the instance.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

/**
 * Creates a custom meta box for the plugin.
 *
 * @package   MySnippets
 * @author    Machina Themes
 * @copyright Copyright (c) 2009 - 2013, Machina Themes
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
final class My_Snippets_Meta_Boxes {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Sets up the needed actions for adding and saving the meta boxes.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' )        );
		add_action( 'save_post',      array( $this, 'save_post'      ), 10, 2 );
	}

	/**
	 * Adds the meta box.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function add_meta_boxes( $post_type ) {

		$post_type_object = get_post_type_object( $post_type );

		if ( 'page' !== $post_type && false === $post_type_object->publicly_queryable )
			return;

		add_meta_box(
			'my-snippets',
			__( 'My Snippets', 'my-snippets' ),
			array( $this, 'snippet_meta_box' ),
			$post_type,
			'normal',
			'low'
		);
	}

	/**
	 * Displays the "my snippets" meta box.
	 *
	 * @since  0.2.0
	 * @access public
	 * @param  object  $object  Current post object.
	 * @param  array   $box
	 * @return void
	 */
	public function snippet_meta_box( $post, $box ) {

		wp_nonce_field( plugin_basename( __FILE__ ), 'my_snippets_meta_nonce' );

		$snippet_title   = get_post_meta( $post->ID, 'Snippet Title', true );
		$snippet_content = get_post_meta( $post->ID, 'Snippet', true ); ?>

		<p>
			<label for="snippet-title"><?php _e( 'Snippet Title', 'my-snippets' ); ?></label>
			<input class="widefat" type="text" name="snippet-title" id="snippet-title" value="<?php echo esc_attr( $snippet_title ); ?>" />
		</p>

		<p>
			<label for="snippet"><?php _e( 'Snippet Content', 'my-snippets'); ?></label>
			<textarea class="widefat" name="snippet-content" id="snippet-content" cols="60" rows="4"><?php echo esc_textarea( $snippet_content ); ?></textarea>
			<span class="description"><?php _e( 'Add text, <abbr title="Hypertext Markup Language">HTML</abbr>, and/or shortcodes.', 'my-snippets' ); ?></span>
		</p><?php
	}

	/**
	 * Saves the custom post meta for the meta boxes.
	 *
	 * @since  0.2.0
	 * @access public
	 * @param  int     $post_id
	 * @param  object  $post
	 * @return void
	 */
	public function save_post( $post_id, $post ) {

		/* Verify the nonce. */
		if ( !isset( $_POST['my_snippets_meta_nonce'] ) || !wp_verify_nonce( $_POST['my_snippets_meta_nonce'], plugin_basename( __FILE__ ) ) )
			return;

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
			return $post_id;

		/* Don't save if the post is only a revision. */
		if ( 'revision' == $post->post_type )
			return;

		$meta = array(
			'Snippet Title' => strip_tags( $_POST['snippet-title'] )
		);

		if ( current_user_can('unfiltered_html') )
			$meta['Snippet'] =  $_POST['snippet-content'];
		else
			$meta['Snippet'] = stripslashes( wp_filter_post_kses( addslashes( $_POST['snippet-content'] ) ) );

		foreach ( $meta as $meta_key => $new_meta_value ) {

			/* Get the meta value of the custom field key. */
			$meta_value = get_post_meta( $post_id, $meta_key, true );

			/* If a new meta value was added and there was no previous value, add it. */
			if ( $new_meta_value && '' == $meta_value )
				add_post_meta( $post_id, $meta_key, $new_meta_value, true );

			/* If the new meta value does not match the old value, update it. */
			elseif ( $new_meta_value && $new_meta_value != $meta_value )
				update_post_meta( $post_id, $meta_key, $new_meta_value );

			/* If there is no new meta value but an old value exists, delete it. */
			elseif ( '' == $new_meta_value && $meta_value )
				delete_post_meta( $post_id, $meta_key, $meta_value );
		}
	}

	/**
	 * Returns the instance.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

/**
 * My Snippets Widget Class
 *
 * The My Snippets Widget displays custom post metadata that is input on singular posts (pages,
 * other post types, etc.). The widget only displays if metadata is available.  Otherwise, it displays
 * nothing.  The Default Title field only displays in the instance that no My Snippets Title is entered.
 *
 * @package   MySnippets
 * @author    Machina Themes
 * @copyright Copyright (c) 2009 - 2013, Machina Themes
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class My_Snippets_Widget_Snippet extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname'   => 'snippet',
			'description' => esc_html__( 'Displays custom post snippets on a post-by-post basis.', 'my-snippets' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width'  => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'snippet',                          // $this->id_base
			__( 'My Snippets', 'my-snippets' ), // $this->name
			$widget_options,                    // $this->widget_options
			$control_options                    // $this->control_options
		);

		/* Apply filters to the snippet content. */
		add_filter( 'my_snippets_content', 'wptexturize' );
		add_filter( 'my_snippets_content', 'convert_smilies' );
		add_filter( 'my_snippets_content', 'convert_chars' );
		add_filter( 'my_snippets_content', 'wpautop' );
		add_filter( 'my_snippets_content', 'shortcode_unautop' );
		add_filter( 'my_snippets_content', 'do_shortcode' );
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function widget( $sidebar, $instance ) {
		extract( $sidebar );

		/* If not viewing a single post, bail. */
		if ( !is_singular() )
			return;

		/* Get the current post ID. */
		$post_id = get_queried_object_id();

		/* Get the snippet content and title. */
		$snippet_content = get_post_meta( $post_id, 'Snippet',       true );
		$snippet_title   = get_post_meta( $post_id, 'Snippet Title', true );

		/* If there's no snippet content, bail. */
		if ( empty( $snippet_content ) )
			return false;

		/* If there's a custom snippet title, use it. Otherwise, default to the widget title. */
		$instance['title'] = !empty( $snippet_title ) ? $snippet_title : $instance['title'];

		/* Output the theme's widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		/* Output the snippet. */
		printf(
			'<div class="snippet-content">%s</div>',
			apply_filters( 'my_snippets_content', $snippet_content )
		);

		/* Close the theme's widget wrapper. */
		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array  $new_instance
	 * @param  array  $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => __('Snippet', 'my-snippets')
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div class="exmachina-widget-controls columns-1">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Default Title:', 'my-snippets'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		</div>
	<?php
	}
}

My_Snippets_Plugin::get_instance();
My_Snippets_Meta_Boxes::get_instance();

?>