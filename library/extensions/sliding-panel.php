<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Sliding Panel
 *
 * EXTENSIONPHP
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * A fully-widgetized and responsive sliding panel for your site.
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

final class Sliding_Panel_Plugin {

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

		/* Register sidebars late so ours come after theme sidebars. */
		add_action( 'widgets_init', array( $this, 'register_sidebars' ), 95 );

		/* Load scripts and styles. */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 5 );

		/* Load the sliding panel sidebar in the footer. */
		add_action( 'wp_footer', array( $this, 'sliding_panel' ), 0 );
	}

	/**
	 * Registers sidebars.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function register_sidebars() {

		register_sidebar(
			array(
				'id'            => 'sliding-panel',
				'name'          => __( 'Sliding Panel', 'exmachina-core' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s widget-%2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>'
			)
		);
	}

	/**
	 * Loads scripts and styles.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function enqueue_scripts() {

		/* Use the .min stylesheet if SCRIPT_DEBUG is turned off. */
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		/* Only load scripts if the sliding panel sidebar is active. */
		if ( is_active_sidebar( 'sliding-panel' ) ) {

			/* Register the sliding panel script. */
			wp_register_script( 'sliding-panel', esc_url( trailingslashit( EXMACHINA_JS ) . "sliding-panel{$suffix}.js" ), array( 'jquery' ), '20130528', true );

			/* Register the sliding panel style. */
			wp_register_style( 'sliding-panel', trailingslashit( EXMACHINA_CSS ) . "sliding-panel{$suffix}.css", false, '20130515', 'screen' );

			/* Get the plugin options. */
			$settings = get_option(
				'plugin_sliding_panel',
				array(
					'label_open'  => __( 'Open',  'exmachina-core' ),
					'label_close' => __( 'Close', 'exmachina-core' )
				)
			);

			/* Localize the text strings to pass to the script. */
			wp_localize_script(
				'sliding-panel',
				'sp_l10n',
				array(
					'open'  => esc_js( $settings['label_open']  ),
					'close' => esc_js( $settings['label_close'] )
				)
			);

			/* Enqueue the sliding panel script. */
			wp_enqueue_script( 'sliding-panel' );

			/* Enqueue the sliding panel stylesheet. */
			wp_enqueue_style( 'sliding-panel' );

		}
	}

	/**
	 * Loads the sliding panel sidebar.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function sliding_panel() {
		?>
		<?php if ( is_active_sidebar( 'sliding-panel' ) ) { ?>

	<aside id="sidebar-sliding-panel" class="sidebar" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

		<div class="sp-wrap">

			<div class="sp-content">

				<div class="sp-content-wrap">
					<?php dynamic_sidebar( 'sliding-panel' ); ?>
				</div><!-- .sp-content-wrap -->

			</div><!-- .sp-content -->

			<div class="sp-toggle">
				<a href="#"></a>
			</div><!-- .sp-toggle -->

		</div><!-- .sp-wrap -->

	</aside><!-- #sliding-panel -->

<?php } ?>
		<?php
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

Sliding_Panel_Plugin::get_instance();




?>