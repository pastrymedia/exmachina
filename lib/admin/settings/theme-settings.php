<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Theme Settings
 *
 * theme-settings.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
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

/**
 * Registers a new admin page, providing content and corresponding menu item for the Theme Settings page.
 *
 * Although this class was added in 1.8.0, some of the methods were originally* standalone functions added in previous
 * versions of ExMachina.
 *
 * @package ExMachina\Admin
 *
 * @since 1.8.0
 */
class ExMachina_Admin_Theme_Settings extends ExMachina_Admin_Metaboxes {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * @since 1.8.0
	 *
	 * @uses EXMACHINA_SETTINGS_FIELD       Settings field key.
	 * @uses PARENT_DB_VERSION            ExMachina database version.
	 * @uses PARENT_THEME_VERSION         ExMachina Framework version.
	 * @uses exmachina_get_default_layout() Get default layout.
	 * @uses \ExMachina_Admin::create()     Create an admin menu item and settings page.
	 */
	function __construct() {

		$page_id = 'theme-settings';

		$menu_ops = apply_filters(
			'exmachina_theme_settings_menu_ops',
			array(
				'main_menu' => array(
					'sep' => array(
						'sep_position'   => '58.995',
						'sep_capability' => 'edit_theme_options',
					),
					'page_title' => 'Theme Settings',
					'menu_title' => 'ExMachina',
					'capability' => 'edit_theme_options',
					'icon_url'   => 'div',
					'position'   => '58.996',
				),
				'first_submenu' => array( //* Do not use without 'main_menu'
					'page_title' => __( 'Theme Settings', 'exmachina' ),
					'menu_title' => __( 'Theme Settings', 'exmachina' ),
					'capability' => 'edit_theme_options',
				),
			)
		);

		$page_ops = apply_filters(
			'exmachina_theme_settings_page_ops',
			array(
				'screen_icon'       => 'options-general',
				'save_button_text'  => __( 'Save Settings', 'exmachina' ),
				'reset_button_text' => __( 'Reset Settings', 'exmachina' ),
				'saved_notice_text' => __( 'Settings saved.', 'exmachina' ),
				'reset_notice_text' => __( 'Settings reset.', 'exmachina' ),
				'error_notice_text' => __( 'Error saving settings.', 'exmachina' ),
			)
		);

		$settings_field = EXMACHINA_SETTINGS_FIELD;

		$default_settings = apply_filters(
			'exmachina_theme_settings_defaults',
			array(
				'blog_title'                => 'text',
				'style_selection'           => '',
				'site_layout'               => exmachina_get_default_layout(),
				'nav_extras'                => '',
				'nav_extras_twitter_id'     => '',
				'nav_extras_twitter_text'   => __( 'Follow me on Twitter', 'exmachina' ),
				'feed_uri'                  => '',
				'redirect_feed'             => 0,
				'comments_feed_uri'         => '',
				'redirect_comments_feed'    => 0,
				'comments_pages'            => 0,
				'comments_posts'            => 1,
				'trackbacks_pages'          => 0,
				'trackbacks_posts'          => 1,
				'breadcrumb_home'           => 0,
				'breadcrumb_front_page'     => 0,
				'breadcrumb_posts_page'     => 0,
				'breadcrumb_single'         => 0,
				'breadcrumb_page'           => 0,
				'breadcrumb_archive'        => 0,
				'breadcrumb_404'            => 0,
				'breadcrumb_attachment'		=> 0,
				'content_archive'           => 'full',
				'content_archive_thumbnail' => 0,
				'image_size'                => '',
				'posts_nav'                 => 'prev-next',
				'post_info'                 => '[post_date] ' . __( 'by', 'exmachina' ) . ' [post_author_posts_link] [post_comments] [post_edit]',
				'post_meta'                 => '[post_categories] [post_tags]',
				'blog_cat'                  => '',
				'blog_cat_exclude'          => '',
				'blog_cat_num'              => 10,
				'header_scripts'            => '',
				'footer_scripts'            => '',
				'footer_insert' 						=> 'Copyright &copy; ' . date( 'Y' ) . ' All Rights Reserved',
				'theme_version'             => PARENT_THEME_VERSION,
				'db_version'                => PARENT_DB_VERSION,
			)
		);

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );

	}

	/**
	 * Register each of the settings with a sanitization filter type.
	 *
	 * @since 1.7.0
	 *
	 * @uses exmachina_add_option_filter() Assign filter to array of settings.
	 *
	 * @see \ExMachina_Settings_Sanitizer::add_filter() Add sanitization filters to options.
	 */
	public function sanitizer_filters() {

		// No filter: image_size

		exmachina_add_option_filter(
			'one_zero',
			$this->settings_field,
			array(
				'breadcrumb_front_page',
				'breadcrumb_home',
				'breadcrumb_single',
				'breadcrumb_page',
				'breadcrumb_posts_page',
				'breadcrumb_archive',
				'breadcrumb_404',
				'breadcrumb_attachment',
				'comments_posts',
				'comments_pages',
				'content_archive_thumbnail',
				'redirect_feed',
				'redirect_comments_feed',
				'trackbacks_posts',
				'trackbacks_pages',
			)
		);

		exmachina_add_option_filter(
			'no_html',
			$this->settings_field,
			array(
				'blog_cat_exclude',
				'blog_title',
				'content_archive',
				'nav_extras',
				'nav_extras_twitter_id',
				'posts_nav',
				'site_layout',
				'style_selection',
				'theme_version',
			)
		);

		exmachina_add_option_filter(
			'absint',
			$this->settings_field,
			array(
				'blog_cat',
				'blog_cat_num',
				'content_archive_limit',
				'db_version',
			)
		);

		exmachina_add_option_filter(
			'safe_html',
			$this->settings_field,
			array(
				'nav_extras_twitter_text',
				'footer_insert',
			)
		);

		exmachina_add_option_filter(
			'requires_unfiltered_html',
			$this->settings_field,
			array(
				'header_scripts',
				'footer_scripts',
			)
		);

		exmachina_add_option_filter(
			'url',
			$this->settings_field,
			array(
				'feed_uri',
				'comments_feed_uri',
			)
		);

	}

	/**
	 * Contextual help content.
	 *
	 * @since 2.0.0
	 */
	public function settings_page_help() {

		$screen = get_current_screen();

		$theme_settings_help =
			'<h3>' . __( 'Theme Settings', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'Your Theme Settings provides control over how the theme works. You will be able to control a lot of common and even advanced features from this menu. Some child themes may add additional menu items to this list, including the ability to select different color schemes or set theme specific features such as a slider. Each of the boxes can be collapsed by clicking the box header and expanded by doing the same. They can also be dragged into any order you desire or even hidden by clicking on "Screen Options" in the top right of the screen and "unchecking" the boxes you do not want to see. Below you\'ll find the items common to every child theme...', 'exmachina' ) . '</p>';

		$feeds_help =
			'<h3>' . __( 'Custom Feeds', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'If you use Feedburner to handle your rss feed(s) you can use this function to set your site\'s native feed to redirect to your Feedburner feed.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'By filling in the feed links calling for the main site feed, it will display as a link to Feedburner.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'By checking the "Redirect Feed" box, all traffic to default feed links will be redirected to the Feedburner link instead.', 'exmachina' ) . '</p>';

		$layout_help =
			'<h3>' . __( 'Default Layout', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'This lets you select the default layout for your entire site. On most of the child themes you\'ll see these options:', 'exmachina' ) . '</p>' .
			'<ul>' .
				'<li>' . __( 'Content Sidebar', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Sidebar Content', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Sidebar Content Sidebar', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Content Sidebar Sidebar', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Sidebar Sidebar Content', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Full Width Content', 'exmachina' ) . '</li>' .
			'</ul>' .
			'<p>'  . __( 'These options can be extended or limited by the child theme. Additionally, many of the child themes do not allow different layouts on the home page as they have been designed for a specific home page layout.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'This layout can also be overridden in the post/page/term layout options on each post/page/term.', 'exmachina' ) . '</p>';

		$header_help =
			'<h3>' . __( 'Header', 'exmachina') . '</h3>' .
			'<p>'  . __( 'The <strong>Dynamic text</strong> option will use the Site Title and Site Description from your site\'s settings in your header.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'The <strong>Image logo</strong> option will use a logo image file in the header instead of the site\'s title and description. This setting adds a .header-image class to your site, allowing you to specify the header image in your child theme\'s style.css. By default, the logo can be saved as logo.png and saved to the images folder of your child theme.', 'exmachina' ) . '</p>';

		$navigation_help =
			'<h3>' . __( 'Navigation', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'The Primary Navigation Extras typically display on the right side of your Primary Navigation menu.', 'exmachina' ) . '</p>' .
			'<ul>' .
				'<li>' . __( 'Today\'s date displays the current date', 'exmachina' ) . '</li>' .
				'<li>' . __( 'RSS feed link displays a link to the RSS feed for your site that a reader can use to subscribe to your site using the feedreader of their choice.', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Search form displays a small search form utilizing the WordPress search functionality.', 'exmachina' ) . '</li>' .
				'<li>' . __( 'Twitter link displays a link to your Twitter profile, as indicated in Twitter ID setting. Enter only your user name in this setting.', 'exmachina' ) . '</li>' .
			'</ul>' .
			'<p>'  . __( 'These options can be extended or limited by the child theme.', 'exmachina' ) . '</p>';

		$breadcrumbs_help =
			'<h3>' . __( 'Breadcrumbs', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'This box lets you define where the "Breadcrumbs" display. The Breadcrumb is the navigation tool that displays where a visitor is on the site at any given moment.', 'exmachina' ) . '</p>';

		$comments_help =
			'<h3>' . __( 'Comments and Trackbacks', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'This allows a site wide decision on whether comments and trackbacks (notifications when someone links to your page) are enabled for posts and pages.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'If you enable comments or trackbacks here, it can be disabled on an individual post or page. If you disable here, they cannot be enabled on an individual post or page.', 'exmachina' ) . '</p>';

		$archives_help =
			'<h3>' . __( 'Content Archives', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'In the ExMachina Theme Settings you may change the site wide Content Archives options to control what displays in the site\'s Archives.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'Archives include any pages using the blog template, category pages, tag pages, date archive, author archives, and the latest posts if there is no custom home page.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'The first option allows you to display the post content or the post excerpt. The Display post content setting will display the entire post including HTML code up to the <!--more--> tag if used (this is HTML for the comment tag that is not displayed in the browser).', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'It may also be coupled with the second field "Limit content to [___] characters" to limit the content to a specific number of letters or spaces. This will strip any HTML, but allows for more precise and easily changed lengths than the excerpt.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'The Display post excerpt setting will display the first 55 words of the post after also stripping any included HTML or the manual/custom excerpt added in the post edit screen.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'The \'Include post image?\' setting allows you to show a thumbnail of the first attached image or currently set featured image.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'This option should not be used with the post content unless the content is limited to avoid duplicate images.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'The \'Image Size\' list is populated by the available image sizes defined in the theme.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'Post Navigation Technique allows you to select one of three navigation methods.', 'exmachina' ) . '</p>';

		$blog_help =
			'<h3>' . __( 'Blog Page', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'This works with the Blog Template, which is a page template that shows your latest posts. It\'s what people see when they land on your homepage.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'In the General Settings you can select a specific category to display from the drop down menu, and exclude categories by ID, or even select how many posts you\'d like to display on this page.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'There are some special features of the Blog Template that allow you to specify which category to show on each page using the template, which is helpful if you have a "News" category (or something else) that you want to display separately.', 'exmachina' ) . '</p>' .
			'<p>'  . sprintf( __( 'You can find more on this feature in the <a href="%s" target="_blank">How to Add a Post Category Page tutorial.</a>', 'exmachina' ), 'http://www.machinathemes.com/tutorials/exmachina/add-post-category-page' ) . '</p>';

		$scripts_help =
			'<h3>' . __( 'Header and Footer Scripts', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'This provides you with two fields that will output to the <head></head> of your site and just before the </body>. These will appear on every page of the site and are a great way to add analytic code and other scripts. You cannot use PHP in these fields. If you need to use PHP then you should look into the ExMachina Simple Hooks plugin.', 'exmachina' ) . '</p>';

		$home_help =
			'<h3>' . __( 'How Home Pages Work', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'Most ExMachina child themes include a custom home page.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'To use this type of home page, make sure your latest posts are set to show on the front page. You can setup a page with the Blog page template to show a blog style list of your latest posts on another page.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'This home page is typically setup via widgets in the sidebars for the home page. This can be accessed via the Widgets menu item under Appearance.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'Child themes that include this type of home page typically include additional theme-specific tutorials which can be accessed via a sticky post at the top of that child theme support forum.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'If your theme uses a custom home page and you want to show the latest posts in a blog format, do not use the blog template. Instead, you need to rename the home.php file to home-old.php instead.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'Another common home page is the "blog" type home page, which is common to most of the free child themes. This shows your latest posts and requires no additional setup.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'The third type of home page is the new dynamic home page. This is common on the newest child themes. It will show your latest posts in a blog type listing unless you put widgets into the home page sidebars.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'This setup is preferred because it makes it easier to show a blog on the front page (no need to rename the home.php file) and does not have the confusion of no content on the home page when the theme is initially installed.', 'exmachina' ) . '</p>';

		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-theme-settings',
			'title'   => __( 'Theme Settings', 'exmachina' ),
			'content' => $theme_settings_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-feeds',
			'title'   => __( 'Custom Feeds', 'exmachina' ),
			'content' => $feeds_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-layout',
			'title'   => __( 'Default Layout', 'exmachina' ),
			'content' => $layout_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-header',
			'title'   => __( 'Header' , 'exmachina' ),
			'content' => $header_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-navigation',
			'title'   => __( 'Navigation' , 'exmachina' ),
			'content' => $navigation_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-breadcrumbs',
			'title'   => __( 'Breadcrumbs', 'exmachina' ),
			'content' => $breadcrumbs_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-comments',
			'title'   => __( 'Comments and Trackbacks', 'exmachina' ),
			'content' => $comments_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-archives',
			'title'   => __( 'Content Archives', 'exmachina' ),
			'content' => $archives_help,
		) );
	$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-blog',
			'title'   => __( 'Blog Page', 'exmachina' ),
			'content' => $blog_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-scripts',
			'title'   => __( 'Header and Footer Scripts', 'exmachina' ),
			'content' => $scripts_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-home',
			'title'   => __( 'Home Pages', 'exmachina' ),
			'content' => $home_help,
		) );

		//* Add help sidebar
		$screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'exmachina' ) . '</strong></p>' .
			'<p><a href="http://machinathemes.com/help/" target="_blank" title="' . __( 'Get Support', 'exmachina' ) . '">' . __( 'Get Support', 'exmachina' ) . '</a></p>' .
			'<p><a href="http://machinathemes.com/snippets/" target="_blank" title="' . __( 'ExMachina Snippets', 'exmachina' ) . '">' . __( 'ExMachina Snippets', 'exmachina' ) . '</a></p>' .
			'<p><a href="http://machinathemes.com/tutorials/" target="_blank" title="' . __( 'ExMachina Tutorials', 'exmachina' ) . '">' . __( 'ExMachina Tutorials', 'exmachina' ) . '</a></p>'
		);

	}

	/**
 	 * Register meta boxes on the Theme Settings page.
 	 *
 	 * Some of the meta box additions are dependent on certain theme support or user capabilities.
 	 *
 	 * The 'exmachina_theme_settings_metaboxes' action hook is called at the end of this function.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @see \ExMachina_Admin_Settings::style_box()         Callback for Color Style box (if supported).
 	 * @see \ExMachina_Admin_Settings::feeds_box()         Callback for Custom Feeds box.
 	 * @see \ExMachina_Admin_Settings::layout_box()        Callback for Default Layout box.
 	 * @see \ExMachina_Admin_Settings::header_box()        Callback for Header box (if no custom header support).
	 * @see \ExMachina_Admin_Settings::nav_box()           Callback for Navigation box.
 	 * @see \ExMachina_Admin_Settings::breadcrumb_box()    Callback for Breadcrumbs box.
 	 * @see \ExMachina_Admin_Settings::comments_box()      Callback for Comments and Trackbacks box.
 	 * @see \ExMachina_Admin_Settings::post_archives_box() Callback for Content Archives box.
 	 * @see \ExMachina_Admin_Settings::blogpage_box()      Callback for Blog Page box.
 	 * @see \ExMachina_Admin_Settings::scripts_box()       Callback for Header and Footer Scripts box (if user has
 	 *                                                   unfiltered_html capability).
 	 */
	function settings_page_load_metaboxes() {

		add_action( 'exmachina_admin_before_metaboxes', array( $this, 'hidden_fields' ) );

		if ( current_theme_supports( 'exmachina-style-selector' ) )
			add_meta_box( 'exmachina-theme-settings-style-selector', __( 'Color Style', 'exmachina' ), array( $this, 'style_box' ), $this->pagehook, 'normal' );

		add_meta_box( 'exmachina-theme-settings-feeds', __( 'Custom Feeds', 'exmachina' ), array( $this, 'feeds_box' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-theme-settings-post-edit', __( 'Post Edits', 'exmachina' ), array( $this, 'post_edit_box' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-theme-settings-layout', __( 'Default Layout', 'exmachina' ), array( $this, 'layout_box' ), $this->pagehook, 'normal' );

		if ( ! current_theme_supports( 'exmachina-custom-header' ) && ! current_theme_supports( 'custom-header' ) )
			add_meta_box( 'exmachina-theme-settings-header', __( 'Header', 'exmachina' ), array( $this, 'header_box' ), $this->pagehook, 'normal' );

		if ( current_theme_supports( 'exmachina-core-menus' ) )
			add_meta_box( 'exmachina-theme-settings-nav', __( 'Navigation', 'exmachina' ), array( $this, 'nav_box' ), $this->pagehook, 'normal' );

		if ( current_theme_supports( 'exmachina-breadcrumbs' ) )
			add_meta_box( 'exmachina-theme-settings-breadcrumb', __( 'Breadcrumbs', 'exmachina' ), array( $this, 'breadcrumb_box' ), $this->pagehook, 'normal' );

		add_meta_box( 'exmachina-theme-settings-comments', __( 'Comments and Trackbacks', 'exmachina' ), array( $this, 'comments_box' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-theme-settings-posts', __( 'Content Archives', 'exmachina' ), array( $this, 'post_archives_box' ), $this->pagehook, 'normal' );
		add_meta_box( 'exmachina-theme-settings-blogpage', __( 'Blog Page Template', 'exmachina' ), array( $this, 'blogpage_box' ), $this->pagehook, 'normal' );

		if ( current_user_can( 'unfiltered_html' ) )
			add_meta_box( 'exmachina-theme-settings-scripts', __( 'Header and Footer Scripts', 'exmachina' ), array( $this, 'scripts_box' ), $this->pagehook, 'normal' );

		add_meta_box('exmachina-theme-settings-footer', 'Footer Settings', array( $this, 'footer_box' ), $this->pagehook, 'normal' );

		do_action( 'exmachina_theme_settings_metaboxes', $this->pagehook );

	}

	/**
	 * Echo hidden form fields before the metaboxes.
	 *
	 * @since 1.8.0
	 *
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @param string $pagehook Page hook.
	 *
	 * @return null Return early if not on the right page.
	 */
	function hidden_fields( $pagehook ) {

		if ( $pagehook !== $this->pagehook )
			return;

		printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'theme_version' ), esc_attr( $this->get_field_value( 'theme_version' ) ) );
		printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'db_version' ), esc_attr( $this->get_field_value( 'db_version' ) ) );

	}

	/**
	 * Callback for Theme Settings Color Style meta box.
	 *
	 * The style selector can be enabled and populated by adding an associated array of style => title when initiating
	 * support for exmachina-style-selector in the child theme functions.php file.
	 *
	 * ~~~
	 * $color_styles = array(
	 *     'childtheme-red'   => __( 'Red', 'childthemedomain' ),
	 *     'childtheme-green' => __( 'Green', 'childthemedomain' ),
	 *     'childtheme-blue'  => __( 'Blue', 'childthemedomain' ),
	 * );
	 * add_theme_support( 'exmachina-style-selector', $color_styles );
	 * ~~~
	 *
	 * When selected, the style will be added as a body class which can be used within style.css to target elements
	 * when using a specific style.
	 *
	 * ~~~
	 * h1 { background: #000; }
	 * .childtheme-red h1 { background: #f00; }
	 * ~~~
	 *
	 * @since 1.8.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function style_box() {

		$current = $this->get_field_value( 'style_selection' );
		$styles  = get_theme_support( 'exmachina-style-selector' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'style_selection' ); ?>"><?php _e( 'Color Style:', 'exmachina' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'style_selection' ); ?>" id="<?php echo $this->get_field_id( 'style_selection' ); ?>">
				<option value=""><?php _e( 'Default', 'exmachina' ); ?></option>
				<?php
				if ( ! empty( $styles ) ) {
					$styles = array_shift( $styles );
					foreach ( (array) $styles as $style => $title ) {
						?><option value="<?php echo esc_attr( $style ); ?>"<?php selected( $current, $style ); ?>><?php echo esc_html( $title ); ?></option><?php
					}
				}
				?>
			</select>
		</p>

		<p><span class="description"><?php _e( 'Please select the color style from the drop down list and save your settings.', 'exmachina' ); ?></span></p>
		<?php

	}

	/**
	 * Callback for Theme Settings Default Layout meta box.
	 *
	 * A version of a site layout setting has been in ExMachina since at least 0.2.0, but it was moved to its own meta box
	 * in 1.7.0.
	 *
	 * @since 1.7.0
	 *
	 * @uses exmachina_layout_selector()         Outputs form elements for layout selector.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function layout_box() {

		?>
		<p class="exmachina-layout-selector">
		<?php
		exmachina_layout_selector( array( 'name' => $this->get_field_name( 'site_layout' ), 'selected' => $this->get_field_value( 'site_layout' ), 'type' => 'site' ) );
		?>
		</p>

		<br class="clear" />
		<?php

	}

	/**
	 * Callback for Theme Settings Header meta box.
	 *
	 * @since 1.7.0
	 *
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function header_box() {
		?>

		<p><?php _e( 'Use for site title/logo:', 'exmachina' ); ?>
			<select name="<?php echo $this->get_field_name( 'blog_title' ); ?>">
				<option value="text"<?php selected( $this->get_field_value( 'blog_title' ), 'text' ); ?>><?php _e( 'Dynamic text', 'exmachina' ); ?></option>
				<option value="image"<?php selected( $this->get_field_value( 'blog_title' ), 'image' ); ?>><?php _e( 'Image logo', 'exmachina' ); ?></option>
			</select>
		</p>

		<?php

	}

	/**
	 * Callback for Theme Settings Navigation Settings meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses exmachina_nav_menu_supported()      Determine if a child theme supports a particular ExMachina nav menu.
	 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function nav_box() {

		if ( exmachina_nav_menu_supported( 'primary' ) ) : ?>

		<h4><?php _e( 'Primary Navigation Extras', 'exmachina' ); ?></h4>

		<?php if ( ! has_nav_menu( 'primary' ) ) : ?>

		<p><span class="description"><?php printf( __( 'In order to view the Primary navigation menu settings, you must build a <a href="%s">custom menu</a>, then assign it to the Primary Menu Location.', 'exmachina' ), admin_url( 'nav-menus.php' ) ); ?></span></p>

		<?php else : ?>

		<div id="exmachina_nav_extras_settings">
			<p>
				<label for="<?php echo $this->get_field_id( 'nav_extras' ); ?>"><?php _e( 'Display the following:', 'exmachina' ); ?></label>
				<select name="<?php echo $this->get_field_name( 'nav_extras' ); ?>" id="<?php echo $this->get_field_id( 'nav_extras' ); ?>">
					<option value=""><?php _e( 'None', 'exmachina' ) ?></option>
					<option value="date"<?php selected( $this->get_field_value( 'nav_extras' ), 'date' ); ?>><?php _e( 'Today\'s date', 'exmachina' ); ?></option>
					<option value="rss"<?php selected( $this->get_field_value( 'nav_extras' ), 'rss' ); ?>><?php _e( 'RSS feed links', 'exmachina' ); ?></option>
					<option value="search"<?php selected( $this->get_field_value( 'nav_extras' ), 'search' ); ?>><?php _e( 'Search form', 'exmachina' ); ?></option>
					<option value="twitter"<?php selected( $this->get_field_value( 'nav_extras' ), 'twitter' ); ?>><?php _e( 'Twitter link', 'exmachina' ); ?></option>
				</select>
			</p>
			<div id="exmachina_nav_extras_twitter">
				<p>
					<label for="<?php echo $this->get_field_id( 'nav_extras_twitter_id' ); ?>"><?php _e( 'Enter Twitter ID:', 'exmachina' ); ?></label>
					<input type="text" name="<?php echo $this->get_field_name( 'nav_extras_twitter_id' ); ?>" id="<?php echo $this->get_field_id( 'nav_extras_twitter_id' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'nav_extras_twitter_id' ) ); ?>" size="27" />
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'nav_extras_twitter_text' ); ?>"><?php _e( 'Twitter Link Text:', 'exmachina' ); ?></label>
					<input type="text" name="<?php echo $this->get_field_name( 'nav_extras_twitter_text' ); ?>" id="<?php echo $this->get_field_id( 'nav_extras_twitter_text' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'nav_extras_twitter_text' ) ); ?>" size="27" />
				</p>
			</div>
		</div>
		<?php
		endif;
		endif;
	}

	/**
	 * Callback for Theme Settings Custom Feeds meta box.
	 *
	 * @since 1.3.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function feeds_box() {

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'feed_uri' ); ?>"><?php _e( 'Enter your custom feed URL:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'feed_uri' ); ?>" id="<?php echo $this->get_field_id( 'feed_uri' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'feed_uri' ) ); ?>" size="50" />

			<label for="<?php echo $this->get_field_id( 'redirect_feed' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'redirect_feed' ); ?>" id="<?php echo $this->get_field_id( 'redirect_feed' ); ?>" value="1"<?php checked( $this->get_field_value( 'redirect_feed' ) ); ?> />
			<?php _e( 'Redirect Feed?', 'exmachina' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comments_feed_uri' ); ?>"><?php _e( 'Enter your custom comments feed URL:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comments_feed_uri' ); ?>" id="<?php echo $this->get_field_id( 'comments_feed_uri' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comments_feed_uri' ) ); ?>" size="50" />

			<label for="<?php echo $this->get_field_id( 'redirect_comments_feed' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'redirect_comments_feed' ); ?>" id="<?php echo $this->get_field_id( 'redirect_comments_feed' ); ?>" value="1"<?php checked( $this->get_field_value( 'redirect_comments__feed' ) ); ?> />
			<?php _e( 'Redirect Feed?', 'exmachina' ); ?></label>
		</p>

		<p><span class="description"><?php printf( __( 'If your custom feed(s) are not handled by Feedburner, we do not recommend that you use the redirect options.', 'exmachina' ) ); ?></span></p>
		<?php

	}

	/**
	 * Callback for Theme Settings Post Edit meta box.
	 *
	 * @since 1.3.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function post_edit_box() {

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_info' ); ?>"><?php _e( 'Post Info:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'post_info' ); ?>" id="<?php echo $this->get_field_id( 'post_info' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'post_info' ) ); ?>" size="50" />

		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_meta' ); ?>"><?php _e( 'Post Meta:', 'exmachina' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'post_meta' ); ?>" id="<?php echo $this->get_field_id( 'post_meta' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'post_meta' ) ); ?>" size="50" />

		</p>

		<p><span class="description"><?php printf( __( 'If your custom feed(s) are not handled by Feedburner, we do not recommend that you use the redirect options.', 'exmachina' ) ); ?></span></p>
		<?php

	}

	/**
	 * Callback for Theme Settings Comments meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function comments_box() {

		?>
		<p>
			<?php _e( 'Enable Comments', 'exmachina' ); ?>
			<label for="<?php echo $this->get_field_id( 'comments_posts' ); ?>" title="Enable comments on posts"><input type="checkbox" name="<?php echo $this->get_field_name( 'comments_posts' ); ?>" id="<?php echo $this->get_field_id( 'comments_posts' ); ?>" value="1"<?php checked( $this->get_field_value( 'comments_posts' ) ); ?> />
			<?php _e( 'on posts?', 'exmachina' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'comments_pages' ); ?>" title="Enable comments on pages"><input type="checkbox" name="<?php echo $this->get_field_name( 'comments_pages' ); ?>" id="<?php echo $this->get_field_id( 'comments_pages' ); ?>" value="1"<?php checked( $this->get_field_value( 'comments_pages' ) ); ?> />
			<?php _e( 'on pages?', 'exmachina' ); ?></label>
		</p>

		<p>
			<?php _e( 'Enable Trackbacks', 'exmachina' ); ?>
			<label for="<?php echo $this->get_field_id( 'trackbacks_posts' ); ?>" title="Enable trackbacks on posts"><input type="checkbox" name="<?php echo $this->get_field_name( 'trackbacks_posts' ); ?>" id="<?php echo $this->get_field_id( 'trackbacks_posts' ); ?>" value="1"<?php checked( $this->get_field_value( 'trackbacks_posts' ) ); ?> />
			<?php _e( 'on posts?', 'exmachina' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'trackbacks_pages' ); ?>" title="Enable trackbacks on pages"><input type="checkbox" name="<?php echo $this->get_field_name( 'trackbacks_pages' ); ?>" id="<?php echo $this->get_field_id( 'trackbacks_pages' ); ?>" value="1"<?php checked( $this->get_field_value( 'trackbacks_pages' ) ); ?> />
			<?php _e( 'on pages?', 'exmachina' ); ?></label>
		</p>

		<p><span class="description"><?php _e( 'Comments and Trackbacks can also be disabled on a per post/page basis when creating/editing posts/pages.', 'exmachina' ); ?></span></p>
		<?php

	}

	/**
	 * Callback for Theme Settings Custom Feeds meta box.
	 *
	 * @since 1.3.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function breadcrumb_box() {

		?>
		<h4><?php _e( 'Enable on:', 'exmachina' ); ?></h4>
		<p>
			<?php if ( 'page' === get_option( 'show_on_front' ) ) : ?>
				<label for="<?php echo $this->get_field_id( 'breadcrumb_front_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_front_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_front_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_front_page' ) ); ?> />
				<?php _e( 'Front Page', 'exmachina' ); ?></label>

				<label for="<?php echo $this->get_field_id( 'breadcrumb_posts_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_posts_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_posts_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_posts_page' ) ); ?> />
				<?php _e( 'Posts Page', 'exmachina' ); ?></label>
			<?php else : ?>
				<label for="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_home' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_home' ) ); ?> />
				<?php _e( 'Homepage', 'exmachina' ); ?></label>
			<?php endif; ?>

			<label for="<?php echo $this->get_field_id( 'breadcrumb_single' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_single' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_single' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_single' ) ); ?> />
			<?php _e( 'Posts', 'exmachina' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'breadcrumb_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_page' ) ); ?> />
			<?php _e( 'Pages', 'exmachina' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'breadcrumb_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_archive' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_archive' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_archive' ) ); ?> />
			<?php _e( 'Archives', 'exmachina' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_404' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_404' ) ); ?> />
			<?php _e( '404 Page', 'exmachina' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'breadcrumb_attachment' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_attachment' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_attachment' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_attachment' ) ); ?> />
			<?php _e( 'Attachment Page', 'exmachina' ); ?></label>
		</p>

		<p><span class="description"><?php _e( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance. You can enable/disable them on certain areas of your site.', 'exmachina' ); ?></span></p>
		<?php

	}

	/**
	 * Callback for Theme Settings Post Archives meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses exmachina_get_images_sizes()        Retrieve list of registered image sizes.
	 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function post_archives_box() {

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'content_archive' ); ?>"><?php _e( 'Select one of the following:', 'exmachina' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'content_archive' ); ?>" id="<?php echo $this->get_field_id( 'content_archive' ); ?>">
			<?php
			$archive_display = apply_filters(
				'exmachina_archive_display_options',
				array(
					'full'     => __( 'Display post content', 'exmachina' ),
					'excerpts' => __( 'Display post excerpts', 'exmachina' ),
				)
			);
			foreach ( (array) $archive_display as $value => $name )
				echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->get_field_value( 'content_archive' ), esc_attr( $value ), false ) . '>' . esc_html( $name ) . '</option>' . "\n";
			?>
			</select>
		</p>

		<div id="exmachina_content_limit_setting">
			<p>
				<label for="<?php echo $this->get_field_id( 'content_archive_limit' ); ?>"><?php _e( 'Limit content to', 'exmachina' ); ?>
				<input type="text" name="<?php echo $this->get_field_name( 'content_archive_limit' ); ?>" id="<?php echo $this->get_field_id( 'content_archive_limit' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'content_archive_limit' ) ); ?>" size="3" />
				<?php _e( 'characters', 'exmachina' ); ?></label>
			</p>

			<p><span class="description"><?php _e( 'Using this option will limit the text and strip all formatting from the text displayed. To use this option, choose "Display post content" in the select box above.', 'exmachina' ); ?></span></p>
		</div>

		<p>
			<label for="<?php echo $this->get_field_id( 'content_archive_thumbnail' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'content_archive_thumbnail' ); ?>" id="<?php echo $this->get_field_id( 'content_archive_thumbnail' ); ?>" value="1"<?php checked( $this->get_field_value( 'content_archive_thumbnail' ) ); ?> />
			<?php _e( 'Include the Featured Image?', 'exmachina' ); ?></label>
		</p>

		<p id="exmachina_image_size">
			<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image Size:', 'exmachina' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'image_size' ); ?>" id="<?php echo $this->get_field_id( 'image_size' ); ?>">
			<?php
			$sizes = exmachina_get_image_sizes();
			foreach ( (array) $sizes as $name => $size )
				echo '<option value="' . esc_attr( $name ) . '"' . selected( $this->get_field_value( 'image_size' ), $name, FALSE ) . '>' . esc_html( $name ) . ' (' . absint( $size['width'] ) . ' &#x000D7; ' . absint( $size['height'] ) . ')</option>' . "\n";
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts_nav' ); ?>"><?php _e( 'Select Post Navigation Technique:', 'exmachina' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'posts_nav' ); ?>" id="<?php echo $this->get_field_id( 'posts_nav' ); ?>">
				<option value="prev-next"<?php selected( 'prev-next', $this->get_field_value( 'posts_nav' ) ); ?>><?php _e( 'Previous / Next', 'exmachina' ); ?></option>
				<option value="numeric"<?php selected( 'numeric', $this->get_field_value( 'posts_nav' ) ); ?>><?php _e( 'Numeric', 'exmachina' ); ?></option>
			</select>
		</p>

		<p><span class="description"><?php _e( 'These options will affect any blog listings page, including archive, author, blog, category, search, and tag pages.', 'exmachina' ); ?></span></p>
		<?php

	}

	/**
	 * Callback for Theme Settings Blog page template meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function blogpage_box() {

		?>
		<p><span class="description"><?php _e( 'These settings apply to any page given the "Blog" page template, not the homepage or post archive pages.', 'exmachina' ); ?></span></p>

		<hr class="div" />

		<p>
			<label for="<?php echo $this->get_field_id( 'blog_cat' ); ?>"><?php _e( 'Display which category:', 'exmachina' ); ?></label>
			<?php wp_dropdown_categories( array( 'selected' => $this->get_field_value( 'blog_cat' ), 'name' => $this->get_field_name( 'blog_cat' ), 'orderby' => 'Name', 'hierarchical' => 1, 'show_option_all' => __( 'All Categories', 'exmachina' ), 'hide_empty' => '0' ) ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'blog_cat_exclude' ); ?>"><?php _e( 'Exclude the following Category IDs:', 'exmachina' ); ?><br />
				<input type="text" name="<?php echo $this->get_field_name( 'blog_cat_exclude' ); ?>" id="<?php echo $this->get_field_id( 'blog_cat_exclude' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'blog_cat_exclude' ) ); ?>" size="40" />
				<br /><small><strong><?php _e( 'Comma separated - 1,2,3 for example', 'exmachina' ); ?></strong></small>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'blog_cat_num' ); ?>"><?php _e( 'Number of Posts to Show:', 'exmachina' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'blog_cat_num' ); ?>" id="<?php echo $this->get_field_id( 'blog_cat_num' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'blog_cat_num' ) ); ?>" size="2" />
		</p>
		<?php

	}

	/**
	 * Callback for Theme Settings Header / Footer Scripts meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
	 * @uses \ExMachina_Admin::get_field_name()  Construct field name.
	 * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \ExMachina_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function scripts_box() {

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'header_scripts' ); ?>"><?php printf( __( 'Enter scripts or code you would like output to %s:', 'exmachina' ), exmachina_code( 'wp_head()' ) ); ?></label>
		</p>

		<textarea name="<?php echo $this->get_field_name( 'header_scripts' ); ?>" id="<?php echo $this->get_field_id( 'header_scripts' ); ?>" cols="78" rows="8"><?php echo esc_textarea( $this->get_field_value( 'header_scripts' ) ); ?></textarea>

		<p><span class="description"><?php printf( __( 'The %1$s hook executes immediately before the closing %2$s tag in the document source.', 'exmachina' ), exmachina_code( 'wp_head()' ), exmachina_code( '</head>' ) ); ?></span></p>

		<hr class="div" />

		<p>
			<label for="<?php echo $this->get_field_id( 'footer_scripts' ); ?>"><?php printf( __( 'Enter scripts or code you would like output to %s:', 'exmachina' ), exmachina_code( 'wp_footer()' ) ); ?></label>
		</p>

		<textarea name="<?php echo $this->get_field_name( 'footer_scripts' ); ?>" id="<?php echo $this->get_field_id( 'footer_scripts' ); ?>" cols="78" rows="8"><?php echo esc_textarea( $this->get_field_value( 'footer_scripts' ) ); ?></textarea>

		<p><span class="description"><?php printf( __( 'The %1$s hook executes immediately before the closing %2$s tag in the document source.', 'exmachina' ), exmachina_code( 'wp_footer()' ), exmachina_code( '</body>' ) ); ?></span></p>
		<?php

	}

	/**
	 * Footer Metabox
	 * @since 1.0.0
	 */
	function footer_box() {

	echo '<p><strong>Footer:</strong></p>';
	wp_editor( $this->get_field_value( 'footer_insert' ), $this->get_field_id( 'footer_insert' ), array( 'textarea_rows' => 5 ) );

	}


}
