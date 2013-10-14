<?php
/**
 * Plugin Name: Custom Header Extended
 * Plugin URI: http://themehybrid.com/plugins/custom-header-extended
 * Description: Allows users to create <a href="http://codex.wordpress.org/Custom_Headers">custom headers</a> for individual posts, which are displayed on the single post page.  It works alongside any theme that supports the WordPress <code>custom-header</code> feature.
 * Version: 0.1.0
 * Author: Machina Themes
 * Author URI: http://machinathemes.com
 *
 * This plugin was created so that users could create custom headers for individual posts.  It ties
 * into the Wordpress 'custom-header' theme feature.  Therefore, it will only work with themes that
 * add support for 'custom-header' via 'functions.php.
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
 * @package  CustomHeadersExtended
 * @version   0.1.0
 * @since     0.1.0
 * @author    Machina Themes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

final class CHE_Custom_Headers {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Stores the directory path for this plugin.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    string
	 */
	private $directory_path;

	/**
	 * Stores the directory URI for this plugin.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    string
	 */
	private $directory_uri;

	/**
	 * Plugin setup.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Register scripts and styles. */
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_register_scripts' ), 5 );

		/* Register activation hook. */
		add_action( 'init', array( $this, 'activation' ) );

		/* Add post type support. */
		add_action( 'init', array( $this, 'post_type_support' ) );

	}

	/**
	 * Adds post type support for the 'custom-header' feature.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function post_type_support() {
		add_post_type_support( 'post', 'custom-header' );
		add_post_type_support( 'page', 'custom-header' );
	}

	/**
	 * Registers scripts and styles for use in the WordPress admin (does not load theme).
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function admin_register_scripts() {

		/* Use the .min javascript if SCRIPT_DEBUG is turned off. */
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_register_script( 'custom-header-extended', esc_url( trailingslashit( HYBRID_JS ) . "custom-headers{$suffix}.js" ), array( 'wp-color-picker', 'media-views' ), '20130528', true );

	}

	/**
	 * Method that runs only when the plugin is activated.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public static function activation() {

		/* Get the administrator role. */
		$role = get_role( 'administrator' );

		/* If the administrator role exists, add required capabilities for the plugin. */
		if ( !empty( $role ) )
			$role->add_cap( 'che_edit_header' );
	}

	/**
	 * Returns the instance.
	 *
	 * @since  0.1.0
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
 * Handles the front end display of custom headers.  This class will check if a post has a custom
 * header assigned to it and filter the custom header theme mods if so on singular post views. The
 * class also handles the creation of a custom header image size if the current theme doesn't allow
 * for both a flexible width and height header image.
 *
 * @package  CustomHeadersExtended
 * @since     0.1.0
 * @author    Machina Themes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

final class CHE_Custom_Headers_Filter {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Name of the custom header image size added via add_image_size().
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    string
	 */
	private $size = 'che_header_image';

	/**
	 * Width of the custom header image size.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    int
	 */
	public $width = 0;

	/**
	 * Height of the custom header image size.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    int
	 */
	public $height = 0;

	/**
	 * Whether to hard crop the custom header image size.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    bool
	 */
	public $crop = true;

	/**
	 * The 'width' argument set by the theme.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    int
	 */
	protected $theme_width = 0;

	/**
	 * The 'height' argument set by the theme.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    int
	 */
	protected $theme_height = 0;

	/**
	 * The 'flex-width' argument set by the theme.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    bool
	 */
	protected $flex_width = false;

	/**
	 * The 'flex-height' argument set by the theme.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    bool
	 */
	protected $flex_height = false;

	/**
	 * The ID of the header image attachment.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    int
	 */
	protected $attachment_id = 0;

	/**
	 * The URL of the header image.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $url = '';

	/**
	 * Sets up the custom headers support on the front end.  This method is just going to add an action
	 * to the `after_setup_theme` hook with a priority of `95`.  This allows us to hook in after themes
	 * have had a chance to set up support for the "custom-header" WordPress theme feature.  If themes
	 * are doing this any later than this, they probably shouldn't be.  If they're doing so for some
	 * valid reason, it's probably a custom implementation that we don't want to touch.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'add_theme_support' ), 95 );
	}

	/**
	 * Checks if the current theme supports the 'custom-header' feature. If not, we won't do anything.
	 * If the theme does support it, we'll add a custom header callback on 'wp_head' if the theme
	 * hasn't defined a custom callback.  This will allow us to add a few extra options for users.
	 *
	 * @since  0.1.0
	 * @access publc
	 * @return void
	 */
	public function add_theme_support() {

		/* If the current theme doesn't support custom headers, bail. */
		if ( !current_theme_supports( 'custom-header' ) )
			return;

		/* Adds an image size. */
		add_action( 'init', array( $this, 'add_image_size' ) );

		/* Only filter the header image on the front end. */
		if ( !is_admin() ) {

			/* Filter the header image. */
			add_filter( 'theme_mod_header_image', array( $this, 'header_image' ), 25 );

			/* Filter the header image data. */
			add_filter( 'theme_mod_header_image_data', array( $this, 'header_image_data' ), 25 );

			/* Filter the header text color. */
			if ( current_theme_supports( 'custom-header', 'header-text' ) )
				add_filter( 'theme_mod_header_textcolor', array( $this, 'header_textcolor' ), 25 );
		}
	}

	/**
	 * Adds a custom header image size for the heaader image.  The only situation in which a custom size
	 * is not created is when the theme supports both 'flex-width' and 'flex-height' header images.  In
	 * that case, the $size property is set to the WordPress 'full' image size.
	 *
	 * The image size created is based off the 'width', 'height', 'flex-width', and 'flex-height' arguments
	 * set by the theme when adding support for 'custom-header'.  If 'flex-width' or 'flex-height' is set
	 * to TRUE, then the image size values for width and height will be set to `9999`.  Otherwise, the
	 * width and height are set to the corresponding theme's 'width' and 'height' arguments.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function add_image_size() {

		/* Get the theme's 'custom-header' arguments needed. */
		$this->theme_width  = get_theme_support( 'custom-header', 'width'       );
		$this->theme_height = get_theme_support( 'custom-header', 'height'      );
		$this->flex_width   = get_theme_support( 'custom-header', 'flex-width'  );
		$this->flex_height  = get_theme_support( 'custom-header', 'flex-height' );

		/*
		 * Set the $crop property based off the $flex_width and $flex_height properties.  If either of
		 * of the properties are TRUE, we'll do a "soft" crop.  Otherwise, we'll use a "hard" crop.
		 */
		$this->crop = $this->flex_width || $this->flex_height ? false : true;

		/* If the theme has set a width/height, use them.  Otherwise set them to "9999". */
		$this->width  = 0 < $this->theme_width  ? absint( $this->theme_width )  : 9999;
		$this->height = 0 < $this->theme_height ? absint( $this->theme_height ) : 9999;

		/* === Set the image size. */

		/*
		 * Allow devs/users to hook in to overwrite the available object properties before an image
		 * size is added.  This will allow them to further define how their header image size is
		 * handled.  Really, the only things worth changing are the $width, $height, and/or $crop
		 * properties.  This script defines these based on the theme, but it's not as flexible as
		 * possible because WordPress really needs to allow for options like 'min-height', 'min-width',
		 * 'max-height', and 'max-width' to really make for the most accurate cropping.
		 */
		do_action( 'che_pre_add_image_size', $this );

		/*
		 * If the theme allows both flexible width and height, don't add an image size. Just use the
		 * default WordPress "full" size.
		 */
		if ( $this->flex_width && $this->flex_height )
			$this->size = 'full';

		/*
		 * If $flex_width is supported but not $flex_height, soft crop an image wih the set height and
		 * a width of "9999" to handle any width.
		 */
		elseif ( $this->flex_width && !$this->flex_height )
			add_image_size( $this->size, 9999, $this->height, $this->crop );

		/*
		 * If $flex_height is supported but not $flex_width, soft crop an image wih the set width and
		 * a height of "9999" to handle any height.
		 */
		elseif ( !$this->flex_width && $this->flex_height )
			add_image_size( $this->size, $this->width, 9999, $this->crop );

		/*
		 * If neither $flex_width nor $flex_width is supported, hard crop an image with the set width
		 * and height.
		 */
		else
			add_image_size( $this->size, $this->width, $this->height, $this->crop );
	}

	/**
	 * Filters the 'theme_mod_header_image' hook.  Checks if there's a featured image with the
	 * correct dimensions to replace the header image on single posts.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string  $url  The URL of the header image.
	 * @return string
	 */
	public function header_image( $url ) {

		/* If we're not viewing a singular post, return the URL. */
		if ( !is_singular() )
			return $url;

		/* Get the queried post data. */
		$post    = get_queried_object();
		$post_id = get_queried_object_id();

		/* If the post type doesn't support 'custom-header', return the URL. */
		if ( !post_type_supports( $post->post_type, 'custom-header' ) )
			return $url;

		/* This filter makes sure the theme's $content_width doesn't mess up our header image size. */
		add_filter( 'editor_max_image_size', array( $this, 'editor_max_image_size' ), 10, 2 );

		/* Get the header image attachment ID. */
		$this->attachment_id = get_post_meta( $post_id, '_custom_header_image_id', true );

		/* If an attachment ID was found, proceed to setting up the the header image. */
		if ( !empty( $this->attachment_id ) ) {

			/* Get the attachment image data. */
			$image = wp_get_attachment_image_src( $this->attachment_id, $this->size );

			/* If no image data was found, return the original URL. */
			if ( empty( $image ) )
				return $url;

			/* If the theme supports both a flexible width and height, just set the image data. */
			if ( $this->flex_width && $this->flex_height ) {

				$this->url    = esc_url( $image[0] );
				$this->width  = absint(  $image[1] );
				$this->height = absint(  $image[2] );
			}

			/* If the theme supports a flexible width but not height, make sure the height is correct. */
			elseif ( $this->flex_width && !$this->flex_height ) {

				if ( $image[2] == $this->height ) {
					$this->url    = esc_url( $image[0] );
					$this->width  = absint(  $image[1] );
					$this->height = absint(  $image[2] );
				}
			}

			/* If the theme supports a flexible height but not width, make sure the width is correct. */
			elseif ( !$this->flex_width && $this->flex_height ) {

				if ( $image[1] == $this->width ) {
					$this->url    = esc_url( $image[0] );
					$this->width  = absint(  $image[1] );
					$this->height = absint(  $image[2] );
				}
			}

			/* If the theme doesn't support flexible width and height, make sure the width and height are correct. */
			elseif ( !$this->flex_width && !$this->flex_height ) {

				if ( $image[1] == $this->width && $image[2] == $this->height  ) {
					$this->url    = esc_url( $image[0] );
					$this->width  = absint(  $image[1] );
					$this->height = absint(  $image[2] );
				}
			}
		}

		/* Remove the filter that constrains image sizes. */
		remove_filter( 'editor_max_image_size', array( $this, 'editor_max_image_size' ) );

		/* Return the custom URL if we have one. Else, return the original URL. */
		return !empty( $this->url ) ? esc_url( $this->url ) : $url;
	}

	/**
	 * Filters the 'editor_max_image_size' hook so that the header image isn't contrained by the theme's
	 * $content_width variable.  This will cause the image width, which can be wider than the content
	 * width to be the incorrect size.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array   $width_height  Array of the width/height to contrain the image size to.
	 * @param  string  $size          The name of the image size.
	 * @return array
	 */
	public function editor_max_image_size( $width_height, $size ) {

		/* Only modify if the size matches or custom size. */
		return $this->size === $size ? array( 0, 0 ) : $width_height;
	}

	/**
	 * Filters the 'theme_mod_header_image_data' hook.  This is used to set the header image data for
	 * the custom header image being used.  Most importantly, it overwrites the `width` and `height`
	 * attributes so themes that use this will have the correct width and height.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array  $data  Header image data.
	 * @return array
	 */
	public function header_image_data( $data ) {

		/* Only set the data if viewing a single post and if we have a header image URL. */
		if ( !is_singular() || !empty( $this->url ) ) {

			$new_data['attachment_id'] = $this->attachment_id;
			$new_data['url']           = $this->url;
			$new_data['thumbnail_url'] = $this->url;
			$new_data['width']         = !$this->flex_width  ? $this->theme_width  : $this->width;
			$new_data['height']        = !$this->flex_height ? $this->theme_height : $this->height;

			/*
			 * WordPress seems to be inconsistent with whether this is an array or object. If the
			 * user has saved header options, it seems to be an object. Else, it's an array.
			 */
			$data = is_object( $data ) ? (object) $new_data : $new_data;
		}

		return $data;
	}

	/**
	 * Filters the 'theme_mod_header_textcolor' hook.  This is a bit tricky since WP actually puts two
	 * options (whether to display header text and the text color itself) under the same
	 * 'header_textcolor' theme mod.  To deal with this, the plugin has two separate post meta keys.
	 * The first deals with showing the header text (default, show, hide).  The second allows the
	 * user to select a custom color.
	 *
	 * Note that a 'blank' text color means to hide the header text.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array  $data  Header image data.
	 * @return array
	 */
	public function header_textcolor( $textcolor ) {

		/* If we're not viewing a singular post, return the URL. */
		if ( !is_singular() )
			return $textcolor;

		/* Get the queried post data. */
		$post    = get_queried_object();
		$post_id = get_queried_object_id();

		/* If the post type doesn't support 'custom-header', return the URL. */
		if ( !post_type_supports( $post->post_type, 'custom-header' ) )
			return $textcolor;

		/* Get the header text metadata for this post. */
		$has_color    = get_post_meta( $post_id, '_custom_header_text_color', true   );
		$display_text = get_post_meta( $post_id, '_custom_header_text_display', true );

		/* If the user has selected to explicitly show the display text. */
		if ( 'show' === $display_text && $has_color )
			$textcolor = $has_color;

		/* If the user has selected to explicitly hide the display text. */
		else if ( 'hide' === $display_text )
			$textcolor = 'blank';

		/* If the user chose the default display option and we're able to overwrite the color. */
		else if ( empty( $display_text ) && 'blank' !== $textcolor && $has_color )
			$textcolor = $has_color;

		/* Return the text color. */
		return $textcolor;
	}

	/**
	 * Returns the instance.
	 *
	 * @since  0.1.0
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
 * The admin class for the plugin.  This sets up a "Custom Header" meta box on the edit post screen in
 * the admin.  It loads the WordPress media views script and a custom JS file for allowing the user to
 * select a custom header image that will overwrite the header on the front end for the singular view
 * of the post.
 *
 * @package  CustomHeadersExtended
 * @since     0.1.0
 * @author    Machina Themes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

final class CHE_Custom_Headers_Admin {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Minimum width allowed for the image.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    int
	 */
	public $min_width = 0;

	/**
	 * Minimum height allowed for the image.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    int
	 */
	public $min_height = 0;

	/**
	 * Maximum width allowed for the image.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    int
	 */
	public $max_width = 9999;

	/**
	 * Maximum height allowed for the image.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    int
	 */
	public $max_height = 9999;

	/**
	 * Array of error strings for display when the image size isn't correct.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    array
	 */
	public $error_strings = array();

	/**
	 * Adds our classes actions on the edit post screen only.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Custom meta for plugin on the plugins admin screen. */
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );

		/* If the current user can't edit custom backgrounds, bail early. */
		if ( !current_user_can( 'che_edit_header' ) && !current_user_can( 'edit_theme_options' ) )
			return;

		/* Only load on the edit post screen. */
		add_action( 'load-post.php',     array( $this, 'load_post' ) );
		add_action( 'load-post-new.php', array( $this, 'load_post' ) );
	}

	/**
	 * Sets up actions to run on specific hooks on the edit post screen if both the theme and current
	 * post type supports the 'custom-header' feature.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function load_post() {

		$screen = get_current_screen();

		/* If the current theme doesn't support custom headers, bail. */
		if ( !current_theme_supports( 'custom-header' ) || !post_type_supports( $screen->post_type, 'custom-header' ) )
			return;

		/* Get the theme's 'custom-header' arguments needed. */
		$flex_width   = get_theme_support( 'custom-header', 'flex-width'  );
		$flex_height  = get_theme_support( 'custom-header', 'flex-height' );
		$theme_width  = get_theme_support( 'custom-header', 'width'       );
		$theme_height = get_theme_support( 'custom-header', 'width'       );

		/* Set up min/max width/height properties for error checking. */
		$this->min_width  = $flex_width  ? 0    : $theme_width;
		$this->min_height = $flex_height ? 0    : $theme_height;
		$this->max_width  = $flex_width  ? 9999 : $theme_width;
		$this->max_height = $flex_height ? 9999 : $theme_height;

		/* Set up error strings. */
		$this->error_strings = array(
			'min_width_height_error' => __( 'Your image width and height are too small.', 'custom-headers-extended' ),
			'max_width_height_error' => __( 'Your image width and height are too large.', 'custom-headers-extended' ),
			'min_width_error'        => __( 'Your image width is too small.',             'custom-headers-extended' ),
			'min_height_error'       => __( 'Your image height is too small.',            'custom-headers-extended' ),
			'max_width_error'        => __( 'Your image width is too large.',             'custom-headers-extended' ),
			'max_height_error'       => __( 'Your image height is too large.',            'custom-headers-extended' ),
		);

		/* Load scripts and styles. */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Add meta boxes. */
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		/* Save metadata. */
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
	}

	/**
	 * Loads scripts/styles for the image uploader.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string  $hook_suffix  The current admin screen.
	 * @return void
	 */
	public function enqueue_scripts( $hook_suffix ) {

		/* Make sure we're on the edit post screen before loading media. */
		if ( !in_array( $hook_suffix, array( 'post-new.php', 'post.php' ) ) )
			return;

		/* Set up variables to pass to the custom headers script. */
		$localize_script = array(
			'title'        => __( 'Set Header Image', 'custom-headers-extended' ),
			'button'       => __( 'Set header image', 'custom-headers-extended' ),
			'min_width'    => $this->min_width,
			'min_height'   => $this->min_height,
			'max_width'    => $this->max_width,
			'max_height'   => $this->max_height
		);

		/* Merge with error strings and escape for use in JS. */
		$localize_script = array_map( 'esc_js', array_merge( $localize_script, $this->error_strings ) );

		/* Pass custom variables to the script. */
		wp_localize_script( 'custom-header-extended', 'che_custom_headers', $localize_script );

		/* Load the needed scripts and styles. */
		wp_enqueue_script( 'custom-header-extended' );
		wp_enqueue_style(  'wp-color-picker'        );
	}

	/**
	 * Creates the custom header meta box.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string  $post_type
	 * @return void
	 */
	function add_meta_boxes( $post_type ) {

		add_meta_box(
			'che-custom-headers',
			__( 'Custom Header', 'custom-headers-extended' ),
			array( $this, 'do_meta_box' ),
			$post_type,
			'side',
			'core'
		);
	}

	/**
	 * Display the custom header meta box.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  object  $post
	 * @return void
	 */
	function do_meta_box( $post ) {

		/* This filter makes sure the theme's $content_width doesn't mess up our header image size. */
		add_filter( 'editor_max_image_size', array( $this, 'editor_max_image_size' ), 10, 2 );

		/* Get the header image attachment ID. */
		$attachment_id = get_post_meta( $post->ID, '_custom_header_image_id', true );

		/* If an attachment ID was found, get the image source. */
		if ( !empty( $attachment_id ) )
			$image = wp_get_attachment_image_src( absint( $attachment_id ), 'che_header_image' );

		/* Get the image URL. */
		$url = !empty( $image ) && isset( $image[0] ) ? $image[0] : ''; ?>

		<!-- Begin hidden fields. -->
		<?php wp_nonce_field( plugin_basename( __FILE__ ), 'che_meta_nonce' ); ?>
		<input type="hidden" name="che-header-image" id="che-header-image" value="<?php echo esc_attr( $attachment_id ); ?>" />
		<!-- End hidden fields. -->

		<!-- Begin header image. -->
		<p>
			<a href="#" class="che-add-media che-add-media-img"><img class="che-header-image-url" src="<?php echo esc_url( $url ); ?>" style="max-width: 100%; max-height: 200px; height: auto; display: block;" /></a>
			<a href="#" class="che-add-media che-add-media-text"><?php _e( 'Set header image', 'custom-headers-extended' ); ?></a>
			<a href="#" class="che-remove-media"><?php _e( 'Remove header image', 'custom-headers-extended' ); ?></a>
		</p>
		<!-- End header image. -->

		<div class="che-errors"><p>
		<?php
			if ( !empty( $image ) ) {

				if ( $image[1] < $this->min_width && $image[2] < $this->min_height )
					echo $this->error_strings['min_width_height_error'];

				elseif ( $image[1] > $this->max_width && $image[2] > $this->max_height )
					echo $this->error_strings['max_width_height_error'];

				elseif ( $image[1] < $this->min_width )
					echo $this->error_strings['min_width_error'];

				elseif ( $image[2] < $this->min_height )
					echo $this->error_strings['min_height_error'];

				elseif ( $image[1] > $this->max_width )
					echo $this->error_strings['max_width_error'];

				elseif ( $image[2] > $this->max_height )
					echo $this->error_strings['max_height_error'];
			}
		?>
		</p></div>

		<?php if ( current_theme_supports( 'custom-header', 'header-text' ) ) {

			/* Get the header text display option. */
			$display_text = get_post_meta( $post->ID, '_custom_header_text_display', true );

			/* Get the header text color. */
			$text_color = get_post_meta( $post->ID, '_custom_header_text_color', true );

			$color = 'blank' === $text_color ? '' : $text_color; ?>

			<!-- Begin header text color. -->
			<p>
				<label for="che-header-text-show"><?php _e( 'Show header text with your image.', 'custom-headers-extended' ); ?>
				<select name="che-header-text-show" id="che-header-text-show">
					<option value="<?php echo display_header_text() ? 'default-show' : 'default-hide'; ?>" <?php selected( empty( $display_text ), true ); ?>><?php _e( 'Default', 'custom-headers-extended' ); ?></option>
					<option value="show" <?php selected( $display_text, 'show' ); ?>><?php _e( 'Show header text', 'custom-headers-extended' ); ?></option>
					<option value="hide" <?php selected( $display_text, 'hide' ); ?>><?php _e( 'Hide header text', 'custom-headers-extended' ); ?></option>
				</select>
			</p>

			<p class="che-header-text-color-section">
				<label for="che-header-text-color"><?php _e( 'Color', 'custom-backgrounds' ); ?></label>
				<input type="text" name="che-header-text-color" id="che-header-text-color" class="che-wp-color-picker" value="#<?php echo esc_attr( $color ); ?>" />
			</p>
			<!-- End header text color. -->

		<?php }

		/* Remove the filter that constrains image sizes. */
		remove_filter( 'editor_max_image_size', array( $this, 'editor_max_image_size' ) );
	}

	/**
	 * Filters the 'editor_max_image_size' hook so that the header image isn't contrained by the theme's
	 * $content_width variable.  This will cause the image width, which can be wider than the content
	 * width to be the incorrect size.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array   $width_height  Array of the width/height to contrain the image size to.
	 * @param  string  $size          The name of the image size.
	 * @return array
	 */
	public function editor_max_image_size( $width_height, $size ) {

		/* Only modify if the size matches or custom size. */
		return 'che_header_image' === $size ? array( 0, 0 ) : $width_height;
	}

	/**
	 * Saves the data from the custom headers meta box.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  int     $post_id
	 * @param  object  $post
	 * @return void
	 */
	function save_post( $post_id, $post ) {

		/* Verify the nonce. */
		if ( !isset( $_POST['che_meta_nonce'] ) || !wp_verify_nonce( $_POST['che_meta_nonce'], plugin_basename( __FILE__ ) ) )
			return;

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) || 'revision' == $post->post_type )
			return;

		/* Get the attachment ID. */
		$image_id = absint( $_POST['che-header-image'] );

		/* Set up an array of meta keys and values. */
		$meta = array(
			'_custom_header_image_id' => $image_id,
		);

		/* Add the image to the pool of uploaded header images for this theme. */
		if ( 0 < $image_id ) {

			$is_custom_header = get_post_meta( $image_id, '_wp_attachment_is_custom_header', true );

			if ( $is_custom_header !== get_stylesheet() )
				update_post_meta( $image_id, '_wp_attachment_is_custom_header', get_stylesheet() );
		}

		/* Only run if the current theme allows for header text. */
		if ( current_theme_supports( 'custom-header', 'header-text' ) ) {

			/* Determine the display header text meta value. */
			if ( in_array( $_POST['che-header-text-show'], array( 'show', 'hide' ) ) )
				$display_header_text = $_POST['che-header-text-show'];
			else
				$display_header_text = '';

			/* Determine the header text color meta value. */
			if ( 'hide' === $display_header_text )
				$color = 'blank';
			else
				$color = preg_replace( '/[^0-9a-fA-F]/', '', $_POST['che-header-text-color'] );

			/* Add the meta key/value pairs to the meta array. */
			$meta['_custom_header_text_display'] = $display_header_text;
			$meta['_custom_header_text_color']   = $color;
		}

		/* Loop through the meta array and add, update, or delete the post metadata. */
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
	 * Adds support, rating, and donation links to the plugin row meta on the plugins admin screen.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array  $meta
	 * @param  string $file
	 * @return array
	 */
	public function plugin_row_meta( $meta, $file ) {

		if ( preg_match( '/custom-header-extended\.php/i', $file ) ) {
			$meta[] = '<a href="http://themehybrid.com/support">' . __( 'Plugin support', 'custom-header-extended' ) . '</a>';
			$meta[] = '<a href="http://wordpress.org/plugins/custom-header-extended">' . __( 'Rate plugin', 'custom-header-extended' ) . '</a>';
			$meta[] = '<a href="http://themehybrid.com/donate">' . __( 'Donate', 'custom-header-extended' ) . '</a>';
		}

		return $meta;
	}

	/**
	 * Returns the instance.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

CHE_Custom_Headers_Admin::get_instance();

CHE_Custom_Headers_Filter::get_instance();

CHE_Custom_Headers::get_instance();

?>