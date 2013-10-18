<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * EXTENSION
 *
 * EXTENSIONPHP
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * This plugin was created so that users could create custom backgrounds for individual posts.  It ties
 * into the Wordpress 'custom-background' theme feature.  Therefore, it will only work with themes that
 * add support for 'custom-background' via 'functions.php.
 *
 * @package     ExMachina
 * @subpackage  Extensions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin extension
###############################################################################


final class CBE_Custom_Backgrounds {

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

		/* Add post type support. */
		add_action( 'init', array( $this, 'post_type_support' ) );

		/* Register activation hook. */
		add_action( 'init', array( $this, 'activation' ) );

	}

	/**
	 * Adds post type support for the 'custom-background' feature.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function post_type_support() {
		add_post_type_support( 'post', 'custom-background' );
		add_post_type_support( 'page', 'custom-background' );
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

		wp_register_script( 'custom-background-extended', esc_url( trailingslashit( EXMACHINA_JS ) . "custom-backgrounds{$suffix}.js" ), array( 'wp-color-picker', 'media-views' ), '20130528', true );

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
			$role->add_cap( 'cbe_edit_background' );
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
 * Handles the front end display of custom backgrounds.  This class will check if a post has a custom
 * background assigned to it and filter the custom background theme mods if so on singular post views.
 * It also rolls its own handling of the 'wp_head' callback but only if the current theme isn't
 * handling this with its own callback.
 *
 * @package   CustomBackgroundExtended
 * @since     0.1.0
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2013, Justin Tadlock
 * @link      http://themeexmachina.com/plugins/custom-background-extended
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

final class CBE_Custom_Backgrounds_Filter {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * The background color property.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    string
	 */
	public $color = '';

	/**
	 * The background image property.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    string
	 */
	public $image = '';

	/**
	 * The background repeat property.  Allowed: 'no-repeat', 'repeat', 'repeat-x', 'repeat-y'.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    string
	 */
	public $repeat = 'repeat';

	/**
	 * The vertical value of the background position property.  Allowed: 'top', 'bottom', 'center'.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    string
	 */
	public $position_y = 'top';

	/**
	 * The horizontal value of the background position property.  Allowed: 'left', 'right', 'center'.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    string
	 */
	public $position_x = 'left';

	/**
	 * The background attachment property.  Allowed: 'scroll', 'fixed'.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    string
	 */
	public $attachment = 'scroll';

	/**
	 * Plugin setup.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Run a check for 'custom-background' support late. Themes should've already registered support. */
		add_action( 'after_setup_theme', array( $this, 'add_theme_support' ), 95 );
	}

	/**
	 * Checks if the current theme supports the 'custom-background' feature. If not, we won't do anything.
	 * If the theme does support it, we'll add a custom background callback on 'wp_head' if the theme
	 * hasn't defined a custom callback.  This will allow us to add a few extra options for users.
	 *
	 * @since  0.1.0
	 * @access publc
	 * @return void
	 */
	public function add_theme_support() {

		/* If the current theme doesn't support custom backgrounds, bail. */
		if ( !current_theme_supports( 'custom-background' ) )
			return;

		/* Run on 'template_redirect' to make sure conditional tags are set. */
		add_action( 'template_redirect', array( $this, 'setup_background' ) );

		/* Get the callback for printing styles on 'wp_head'. */
		$wp_head_callback = get_theme_support( 'custom-background', 'wp-head-callback' );

		/* If the theme hasn't set up a custom callback, let's roll our own with a few extra options. */
		if ( empty( $wp_head_callback ) || '_custom_background_cb' === $wp_head_callback )
			add_theme_support( 'custom-background', array( 'wp-head-callback' => array( $this, 'custom_background_callback' ) ) );
	}

	/**
	 * Sets up the custom background stuff once so that we're not running through the functionality
	 * multiple  times on a page load.  If not viewing a single post or if the post type doesn't support
	 * 'custom-background', we won't do anything.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function setup_background() {

		/* If this isn't a singular view, bail. */
		if ( !is_singular() )
			return;

		/* Get the post variables. */
		$post    = get_queried_object();
		$post_id = get_queried_object_id();

		/* If the post type doesn't support 'custom-background', bail. */
		if ( !post_type_supports( $post->post_type, 'custom-background' ) )
			return;

		/* Get the background color. */
		$this->color = get_post_meta( $post_id, '_custom_background_color', true );

		/* Get the background image attachment ID. */
		$attachment_id = get_post_meta( $post_id, '_custom_background_image_id', true );

		/* If an attachment ID was found, get the image source. */
		if ( !empty( $attachment_id ) ) {

			$image = wp_get_attachment_image_src( $attachment_id, 'full' );

			$this->image = !empty( $image ) && isset( $image[0] ) ? esc_url( $image[0] ) : '';
		}

		/* Filter the background color and image theme mods. */
		add_filter( 'theme_mod_background_color', array( $this, 'background_color' ), 25 );
		add_filter( 'theme_mod_background_image', array( $this, 'background_image' ), 25 );

		/* If an image was found, filter image-related theme mods. */
		if ( !empty( $this->image ) ) {

			$this->repeat     = get_post_meta( $post_id, '_custom_background_repeat',     true );
			$this->position_x = get_post_meta( $post_id, '_custom_background_position_x', true );
			$this->position_y = get_post_meta( $post_id, '_custom_background_position_y', true );
			$this->attachment = get_post_meta( $post_id, '_custom_background_attachment', true );

			add_filter( 'theme_mod_background_repeat',     array( $this, 'background_repeat'     ), 25 );
			add_filter( 'theme_mod_background_position_x', array( $this, 'background_position_x' ), 25 );
			add_filter( 'theme_mod_background_position_y', array( $this, 'background_position_y' ), 25 );
			add_filter( 'theme_mod_background_attachment', array( $this, 'background_attachment' ), 25 );
		}
	}

	/**
	 * Sets the background color.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $color The background color property.
	 * @return string
	 */
	public function background_color( $color ) {
		return !empty( $this->color ) ? preg_replace( '/[^0-9a-fA-F]/', '', $this->color ) : $color;
	}

	/**
	 * Sets the background image.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $image The background image property.
	 * @return string
	 */
	public function background_image( $image ) {

		/* Return the image if it has been set. */
		if ( !empty( $this->image ) )
			$image = $this->image;

		/* If no image is set but a color is, disable the WP image. */
		elseif ( !empty( $this->color ) )
			$image = '';

		return $image;
	}

	/**
	 * Sets the background repeat property.  Only exectued if using a background image.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $repeat The background repeat property.
	 * @return string
	 */
	public function background_repeat( $repeat ) {
		return !empty( $this->repeat ) ? $this->repeat : $repeat;
	}

	/**
	 * Sets the background horizontal position.  Only exectued if using a background image.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $position_x The background horizontal position.
	 * @return string
	 */
	public function background_position_x( $position_x ) {
		return !empty( $this->position_x ) ? $this->position_x : $position_x;
	}

	/**
	 * Sets the background vertical position.  This isn't technically supported in WordPress (as
	 * of 3.6).  This method is only executed if using a background image and the
	 * custom_background_callback() method is executed.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $position_y The background vertical position.
	 * @return string
	 */
	public function background_position_y( $position_y ) {
		return !empty( $this->position_y ) ? $this->position_y : $position_y;
	}

	/**
	 * Sets the background attachment property.  Only exectued if using a background image.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $url The background attachment property.
	 * @return string
	 */
	public function background_attachment( $attachment ) {
		return !empty( $this->attachment ) ? $this->attachment : $attachment;
	}

	/**
	 * Outputs the custom background style in the header.  This function is only executed if the value
	 * of the 'wp-head-callback' for the 'custom-background' feature is set to '__return_false'.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function custom_background_callback() {

		/* Get the background image. */
		$image = set_url_scheme( get_background_image() );

		/* Get the background color. */
		$color = get_background_color();

		/* If there is no image or color, bail. */
		if ( empty( $image ) && empty( $color ) )
			return;

		/* Set the background color. */
		$style = $color ? "background-color: #{$color};" : '';

		/* If there's a background image, add it. */
		if ( $image ) {

			/* Background image. */
			$style .= " background-image: url('{$image}');";

			/* Background repeat. */
			$repeat = get_theme_mod( 'background_repeat', 'repeat' );
			$repeat = in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) ? $repeat : 'repeat';

			$style .= " background-repeat: {$repeat};";

			/* Background position. */
			$position_y = get_theme_mod( 'background_position_y', 'top' );
			$position_y = in_array( $position_y, array( 'top', 'center', 'bottom' ) ) ? $position_y : 'top';

			$position_x = get_theme_mod( 'background_position_x', 'left' );
			$position_x = in_array( $position_x, array( 'center', 'right', 'left' ) ) ? $position_x : 'left';

			$style .= " background-position: {$position_y} {$position_x};";

			/* Background attachment. */
			$attachment = get_theme_mod( 'background_attachment', 'scroll' );
			$attachment = in_array( $attachment, array( 'fixed', 'scroll' ) ) ? $attachment : 'scroll';

			$style .= " background-attachment: {$attachment};";

			/* Backgroud clip. */
			//$clip = get_theme_mod( 'background_clip', 'border-box' );
			//$clip = in_array( $clip, array( 'border-box', 'padding-box', 'content-box' ) ) ? $clip : 'border-box';

			//$style .= " background-clip: {$clip};";

			/* Backgroud origin. */
			//$origin = get_theme_mod( 'background_origin', 'padding-box' );
			//$origin = in_array( $origin, array( 'padding-box', 'border-box', 'content-box' ) ) ? $origin : 'padding-box';

			//$style .= " background-origin: {$origin};";

			/* Background size. */
			//$size = get_theme_mod( 'background_size', 'auto' );
			//$size = in_array( $size, array( 'auto', 'contain', 'cover' ) ) ? $size : preg_replace( "/[^0-9a-zA-Z%\s]/", '', $size );

			//$style .= " background-size: {$size};";
		}

		/* Output the custom background style. */
		echo "\n" . '<style type="text/css" id="custom-background-css">body.custom-background{ ' . trim( $style ) . ' }</style>' . "\n";
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
 * The admin class for the plugin.  This sets up a "Custom Background" meta box on the edit post screen in the
 * admin.  It loads the WordPress color picker, media views, and a custom JS file for allowing the user to
 * select options that will overwrite the custom background on the front end for the singular view of the post.
 *
 * @package   CustomBackgroundExtended
 * @since     0.1.0
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2013, Justin Tadlock
 * @link      http://themeexmachina.com/plugins/custom-background-extended
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

final class CBE_Custom_Backgrounds_Admin {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Whether the theme has a custom backround callback for 'wp_head' output.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    bool
	 */
	public $theme_has_callback = false;

	/**
	 * Plugin setup.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Custom meta for plugin on the plugins admin screen. */
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );

		/* If the current user can't edit custom backgrounds, bail early. */
		if ( !current_user_can( 'cbe_edit_background' ) && !current_user_can( 'edit_theme_options' ) )
			return;

		/* Only load on the edit post screen. */
		add_action( 'load-post.php',     array( $this, 'load_post' ) );
		add_action( 'load-post-new.php', array( $this, 'load_post' ) );
	}

	/**
	 * Add actions for the edit post screen.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function load_post() {
		$screen = get_current_screen();

		/* If the current theme doesn't support custom backgrounds, bail. */
		if ( !current_theme_supports( 'custom-background' ) || !post_type_supports( $screen->post_type, 'custom-background' ) )
			return;

		/* Get the 'wp_head' callback. */
		$wp_head_callback = get_theme_support( 'custom-background', 'wp-head-callback' );

		/* Checks if the theme has set up a custom callback. */
		$this->theme_has_callback = empty( $wp_head_callback ) || '_custom_background_cb' === $wp_head_callback ? false : true;

		/* Load scripts and styles. */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Add meta boxes. */
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		/* Save metadata. */
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
	}

	/**
	 * Loads scripts/styles for the color picker and image uploader.
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

		wp_localize_script(
			'custom-background-extended',
			'cbe_custom_backgrounds',
			array(
				'title'  => __( 'Set Background Image', 'custom-background-extended' ),
				'button' => __( 'Set background image', 'custom-background-extended' )
			)
		);

		wp_enqueue_script( 'custom-background-extended' );
		wp_enqueue_style(  'wp-color-picker'            );
	}

	/**
	 * Add custom meta boxes.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string  $post_type
	 * @return void
	 */
	function add_meta_boxes( $post_type ) {

		add_meta_box(
			'cbe-custom-background-extended',
			__( 'Custom Background', 'custom-background-extended' ),
			array( $this, 'do_meta_box' ),
			$post_type,
			'side',
			'core'
		);
	}

	/**
	 * Display the custom background meta box.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  object  $post
	 * @return void
	 */
	function do_meta_box( $post ) {

		/* Get the background color. */
		$color = trim( get_post_meta( $post->ID, '_custom_background_color', true ), '#' );

		/* Get the background image attachment ID. */
		$attachment_id = get_post_meta( $post->ID, '_custom_background_image_id', true );

		/* If an attachment ID was found, get the image source. */
		if ( !empty( $attachment_id ) )
			$image = wp_get_attachment_image_src( absint( $attachment_id ), 'post-thumbnail' );

		/* Get the image URL. */
		$url = !empty( $image ) && isset( $image[0] ) ? $image[0] : '';

		/* Get the background image settings. */
		$repeat     = get_post_meta( $post->ID, '_custom_background_repeat',     true );
		$position_x = get_post_meta( $post->ID, '_custom_background_position_x', true );
		$position_y = get_post_meta( $post->ID, '_custom_background_position_y', true );
		$attachment = get_post_meta( $post->ID, '_custom_background_attachment', true );

		/* Get theme mods. */
		$mod_repeat     = get_theme_mod( 'background_repeat',     'repeat' );
		$mod_position_x = get_theme_mod( 'background_position_x', 'left'   );
		$mod_position_y = get_theme_mod( 'background_position_y', 'top'    );
		$mod_attachment = get_theme_mod( 'background_attachment', 'scroll' );

		/**
		 * Make sure values are set for the image options.  This should always be set so that we can
		 * be sure that the user's background image overwrites the default/WP custom background settings.
		 * With one theme, this doesn't matter, but we need to make sure that the background stays
		 * consistent between different themes and different WP custom background settings.  The data
		 * will only be stored if the user selects a background image.
		 */
		$repeat     = !empty( $repeat )     ? $repeat     : $mod_repeat;
		$position_x = !empty( $position_x ) ? $position_x : $mod_position_x;
		$position_y = !empty( $position_y ) ? $position_y : $mod_position_y;
		$attachment = !empty( $attachment ) ? $attachment : $mod_attachment;

		/* Set up an array of allowed values for the repeat option. */
		$repeat_options = array(
			'no-repeat' => __( 'No Repeat',           'custom-background-extended' ),
			'repeat'    => __( 'Repeat',              'custom-background-extended' ),
			'repeat-x'  => __( 'Repeat Horizontally', 'custom-background-extended' ),
			'repeat-y'  => __( 'Repeat Vertically',   'custom-background-extended' ),
		);

		/* Set up an array of allowed values for the position-x option. */
		$position_x_options = array(
			'left'   => __( 'Left',   'custom-background-extended' ),
			'right'  => __( 'Right',  'custom-background-extended' ),
			'center' => __( 'Center', 'custom-background-extended' ),
		);

		/* Set up an array of allowed values for the position-x option. */
		$position_y_options = array(
			'top'    => __( 'Top',    'custom-background-extended' ),
			'bottom' => __( 'Bottom', 'custom-background-extended' ),
			'center' => __( 'Center', 'custom-background-extended' ),
		);

		/* Set up an array of allowed values for the attachment option. */
		$attachment_options = array(
			'scroll' => __( 'Scroll', 'custom-background-extended' ),
			'fixed'  => __( 'Fixed',  'custom-background-extended' ),
		); ?>

		<!-- Begin hidden fields. -->
		<?php wp_nonce_field( plugin_basename( __FILE__ ), 'cbe_meta_nonce' ); ?>
		<input type="hidden" name="cbe-background-image" id="cbe-background-image" value="<?php echo esc_attr( $attachment_id ); ?>" />
		<!-- End hidden fields. -->

		<!-- Begin background color. -->
		<p>
			<label for="cbe-background-color"><?php _e( 'Color', 'custom-background-extended' ); ?></label>
			<input type="text" name="cbe-background-color" id="cbe-backround-color" class="cbe-wp-color-picker" value="#<?php echo esc_attr( $color ); ?>" />
		</p>
		<!-- End background color. -->

		<!-- Begin background image. -->
		<p>
			<a href="#" class="cbe-add-media cbe-add-media-img"><img class="cbe-background-image-url" src="<?php echo esc_url( $url ); ?>" style="max-width: 100%; max-height: 200px; display: block;" /></a>
			<a href="#" class="cbe-add-media cbe-add-media-text"><?php _e( 'Set background image', 'custom-background-extended' ); ?></a>
			<a href="#" class="cbe-remove-media"><?php _e( 'Remove background image', 'custom-background-extended' ); ?></a>
		</p>
		<!-- End background image. -->

		<!-- Begin background image options -->
		<div class="cbe-background-image-options">

			<p>
				<label for="cbe-background-repeat"><?php _e( 'Repeat', 'custom-background-extended' ); ?></label>
				<select class="widefat" name="cbe-background-repeat" id="cbe-background-repeat">
				<?php foreach( $repeat_options as $option => $label ) { ?>
					<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $repeat, $option ); ?> /><?php echo esc_html( $label ); ?></option>
				<?php } ?>
				</select>
			</p>

			<p>
				<label for="cbe-background-position-x"><?php _e( 'Horizontal Position', 'custom-background-extended' ); ?></label>
				<select class="widefat" name="cbe-background-position-x" id="cbe-background-position-x">
				<?php foreach( $position_x_options as $option => $label ) { ?>
					<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $position_x, $option ); ?> /><?php echo esc_html( $label ); ?></option>
				<?php } ?>
				</select>
			</p>

			<?php if ( !$this->theme_has_callback ) { ?>
			<p>
				<label for="cbe-background-position-y"><?php _e( 'Vertical Position', 'custom-background-extended' ); ?></label>
				<select class="widefat" name="cbe-background-position-y" id="cbe-background-position-y">
				<?php foreach( $position_y_options as $option => $label ) { ?>
					<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $position_y, $option ); ?> /><?php echo esc_html( $label ); ?></option>
				<?php } ?>
				</select>
			</p>
			<?php } ?>

			<p>
				<label for="cbe-background-attachment"><?php _e( 'Attachment', 'custom-background-extended' ); ?></label>
				<select class="widefat" name="cbe-background-attachment" id="cbe-background-attachment">
				<?php foreach( $attachment_options as $option => $label ) { ?>
					<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $attachment, $option ); ?> /><?php echo esc_html( $label ); ?></option>
				<?php } ?>
				</select>
			</p>

		</div>
		<!-- End background image options. -->

	<?php }

	/**
	 * Saves the data from the custom backgrounds meta box.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  int    $post_id
	 * @param  object $post
	 * @return void
	 */
	function save_post( $post_id, $post ) {

		/* Verify the nonce. */
		if ( !isset( $_POST['cbe_meta_nonce'] ) || !wp_verify_nonce( $_POST['cbe_meta_nonce'], plugin_basename( __FILE__ ) ) )
			return;

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
			return $post_id;

		/* Don't save if the post is only a revision. */
		if ( 'revision' == $post->post_type )
			return;

		/* Sanitize color. */
		$color = preg_replace( '/[^0-9a-fA-F]/', '', $_POST['cbe-background-color'] );

		/* Make sure the background image attachment ID is an absolute integer. */
		$image_id = absint( $_POST['cbe-background-image'] );

		/* If there's not an image ID, set background image options to an empty string. */
		if ( 0 >= $image_id ) {

			$repeat = $position_x = $position_y = $attachment = '';

		/* If there is an image ID, validate the background image options. */
		} else {

			/* Add the image to the pool of uploaded background images for this theme. */
			if ( !empty( $image_id ) ) {

				$is_custom_header = get_post_meta( $image_id, '_wp_attachment_is_custom_background', true );

				if ( $is_custom_header !== get_stylesheet() )
					update_post_meta( $image_id, '_wp_attachment_is_custom_background', get_stylesheet() );
			}


			/* White-listed values. */
			$allowed_repeat     = array( 'no-repeat', 'repeat', 'repeat-x', 'repeat-y' );
			$allowed_position_x = array( 'left', 'right', 'center' );
			$allowed_position_y = array( 'top', 'bottom', 'center' );
			$allowed_attachment = array( 'scroll', 'fixed' );

			/* Make sure the values have been white-listed. Otherwise, set an empty string. */
			$repeat     = in_array( $_POST['cbe-background-repeat'],     $allowed_repeat )     ? $_POST['cbe-background-repeat']     : '';
			$position_x = in_array( $_POST['cbe-background-position-x'], $allowed_position_x ) ? $_POST['cbe-background-position-x'] : '';
			$position_y = in_array( $_POST['cbe-background-position-y'], $allowed_position_y ) ? $_POST['cbe-background-position-y'] : '';
			$attachment = in_array( $_POST['cbe-background-attachment'], $allowed_attachment ) ? $_POST['cbe-background-attachment'] : '';
		}

		/* Set up an array of meta keys and values. */
		$meta = array(
			'_custom_background_color'      => $color,
			'_custom_background_image_id'   => $image_id,
			'_custom_background_repeat'     => $repeat,
			'_custom_background_position_x' => $position_x,
			'_custom_background_position_y' => $position_y,
			'_custom_background_attachment' => $attachment,
		);

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

		if ( preg_match( '/custom-background-extended\.php/i', $file ) ) {
			$meta[] = '<a href="http://themeexmachina.com/support">' . __( 'Plugin support', 'custom-background-extended' ) . '</a>';
			$meta[] = '<a href="http://wordpress.org/plugins/custom-background-extended">' . __( 'Rate plugin', 'custom-background-extended' ) . '</a>';
			$meta[] = '<a href="http://themeexmachina.com/donate">' . __( 'Donate', 'custom-background-extended' ) . '</a>';
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

CBE_Custom_Backgrounds::get_instance();

CBE_Custom_Backgrounds_Filter::get_instance();

CBE_Custom_Backgrounds_Admin::get_instance();





?>