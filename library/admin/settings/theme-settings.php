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
 * Handles the display and functionality of the theme settings page. This provides
 * the needed hooks and meta box calls to create any number of theme settings needed.
 * This file is only loaded if the theme supports the 'exmachina-core-theme-settings'
 * feature.
 *
 * @package     ExMachina
 * @subpackage  Admin Settings
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/**
 * Theme Settings Admin Subclass
 *
 * Registers a new admin page, providing content and corresponding menu item for
 * the Theme Settings page.
 *
 * @since 1.0.0
 */
class ExMachina_Admin_Theme_Settings extends ExMachina_Admin_Metaboxes {

  /**
   * Theme Settings Class Constructor
   *
   * Creates an admin menu item and settings page. This constructor method defines
   * the page id, page title, menu position, default settings, and sanitization
   * hooks.
   *
   * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
   * @link http://codex.wordpress.org/Function_Reference/get_template
   * @link http://codex.wordpress.org/Function_Reference/get_theme_root
   * @link http://codex.wordpress.org/Function_Reference/get_template_directory
   *
   * @uses exmachina_get_prefix()
   * @uses \ExMachina_Admin::create()
   * @uses \ExMachina_Admin_Theme_Settings::sanitizer_filters()
   *
   * @todo prefix settings filters.
   * @todo add filters to page/menu titles
   * @todo maybe remove page_ops for defaults
   * @todo create default footer insert function
   * @todo add layout default
   *
   * @since 1.0.0
   */
  function __construct() {

    /* Get the theme prefix. */
    $prefix = exmachina_get_prefix();

    /* Get theme information. */
    $theme = wp_get_theme( get_template(), get_theme_root( get_template_directory() ) );

    /* Get menu titles. */
    $menu_title = __( 'Theme Settings', 'exmachina-core' );
    $page_title = sprintf( esc_html__( '%1s %2s', 'exmachina-core' ), $theme->get( 'Name' ), $menu_title );

    /* Specify the unique page id. */
    $page_id = 'theme-settings';

    /* Define page titles and menu position. Can be filtered using 'exmachina_theme_settings_menu_ops'. */
    $menu_ops = apply_filters(
      'exmachina_theme_settings_menu_ops',
      array(
        'main_menu' => array(
          'sep' => array(
            'sep_position'   => '58.995',
            'sep_capability' => 'edit_theme_options',
          ),
          'page_title' => $page_title,
          'menu_title' => $theme->get( 'Name' ),
          'capability' => 'edit_theme_options',
          'icon_url'   => 'div',
          'position'   => '58.996',
        ),
        'first_submenu' => array( //* Do not use without 'main_menu'
          'page_title' => $page_title,
          'menu_title' => $menu_title,
          'capability' => 'edit_theme_options',
        ),
        'theme_submenu' => array( //* Do not use without 'main_menu'
          'page_title' => $page_title,
          'menu_title' => $menu_title,
          'capability' => 'edit_theme_options',
        ),
      )
    ); // end $menu_ops

    /* Define page options (notice text and screen icon). Can be filtered using 'exmachina_theme_settings_page_ops'. */
    $page_ops = apply_filters(
      'exmachina_theme_settings_page_ops',
      array(
        'screen_icon'       => 'options-general',
        'save_button_text'  => __( 'Save Settings', 'exmachina-core' ),
        'reset_button_text' => __( 'Reset Settings', 'exmachina-core' ),
        'saved_notice_text' => __( 'Settings saved.', 'exmachina-core' ),
        'reset_notice_text' => __( 'Settings reset.', 'exmachina-core' ),
        'error_notice_text' => __( 'Error saving settings.', 'exmachina-core' ),
      )
    ); // end $page_ops

    /* Set the unique settings field id. */
    $settings_field = EXMACHINA_SETTINGS_FIELD;

    /* Define the default setting values. Can be filtered using 'exmachina_theme_settings_defaults'. */
    $default_settings = apply_filters(
      'exmachina_theme_settings_defaults',
      array(
        'theme_version' => EXMACHINA_VERSION,
        'db_version'    => EXMACHINA_DB_VERSION,
        'release_date'              => EXMACHINA_RELEASE_DATE,
        'license_key'               => '',
        'update'                    => 1,
        'update_email'              => 0,
        'update_email_address'      => '',
        'blog_title'                => 'text',
        'style_selection'           => '',
        'feed_uri'                  => '',
        'redirect_feed'             => 0,
        'comments_feed_uri'         => '',
        'redirect_comments_feed'    => 0,
        'breadcrumb_home'           => 0,
        'breadcrumb_front_page'     => 0,
        'breadcrumb_posts_page'     => 0,
        'breadcrumb_single'         => 0,
        'breadcrumb_page'           => 0,
        'breadcrumb_archive'        => 0,
        'breadcrumb_404'            => 0,
        'breadcrumb_attachment'     => 0,
        'site_layout'               => '', //exmachina_get_default_layout(),
        'nav_extras'                => '',
        'nav_extras_twitter_id'     => '',
        'nav_extras_twitter_text'   => __( 'Follow me on Twitter', 'exmachina' ),
        'post_info'                 => '[post_date] ' . __( 'by', 'exmachina' ) . ' [post_author_posts_link] [post_comments] [post_edit]',
        'post_meta'                 => '[post_categories] [post_tags]',
        'comments_pages'            => 0,
        'comments_posts'            => 1,
        'trackbacks_pages'          => 0,
        'trackbacks_posts'          => 1,
        'content_archive'           => 'full',
        'content_archive_limit'     => 0,
        'content_archive_thumbnail' => 0,
        'content_archive_more'      => '[Read more...]',
        'image_size'                => '',
        'posts_nav'                 => 'prev-next',
        'single_nav'                => 0,
        'blog_cat'                  => '',
        'blog_cat_exclude'          => '',
        'blog_cat_num'              => 10,
        'header_scripts'            => '',
        'footer_scripts'            => '',
        'footer_insert'             => 'Copyright &copy; ' . date( 'Y' ) . ' All Rights Reserved',
      )
    ); // end $default_settings

    /* Create the admin page. */
    $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

    /* Initialize the sanitization filter. */
    add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );

  } // end function __construct()

  /**
   * Theme Settings Sanitizer Filters
   *
   * Register each of the settings with a sanitization filter type. This method
   * takes each defined setting and runs it through the appropiate type in the
   * sanitization class.
   *
   * @uses exmachina_add_option_filter() Assign a sanitization filter.
   *
   * @since 1.0.0
   */
  public function sanitizer_filters() {

    /* Apply the truthy/falsy sanitization filter. */
    exmachina_add_option_filter( 'one_zero', $this->settings_field,
      array(
        'update',
        'update_email',
        'redirect_feed',
        'redirect_comments_feed',
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
        'trackbacks_posts',
        'trackbacks_pages',
        'content_archive_thumbnail',
        'single_nav',
    ) );

    /* Apply the positive integer sanitization filter. */
    exmachina_add_option_filter( 'absint', $this->settings_field,
      array(
        'db_version',
        'content_archive_limit',
        'blog_cat',
        'blog_cat_num',
    ) );

    /* Apply the URL sanitization filter. */
    exmachina_add_option_filter( 'url', $this->settings_field,
      array(
        'feed_uri',
        'comments_feed_uri',
    ) );

    /* Apply the no HTML sanitization filter. */
    exmachina_add_option_filter( 'no_html', $this->settings_field,
      array(
        'theme_version',
        'license_key',
        'release_date',
        'update_email_address',
        'blog_title',
        'style_selection',
        'site_layout',
        'nav_extras',
        'nav_extras_twitter_id',
        'content_archive',
        'posts_nav',
        'image_size',
        'blog_cat_exclude',
    ) );

    /* Apply the safe HTML sanitization filter. */
    exmachina_add_option_filter( 'safe_html', $this->settings_field,
      array(
        'footer_insert',
        'post_info',
        'post_meta',
        'nav_extras_twitter_text',
        'content_archive_more',
    ) );

    /* Apply the unfiltered HTML sanitiation filter. */
    exmachina_add_option_filter( 'requires_unfiltered_html', $this->settings_field,
      array(
        'header_scripts',
        'footer_scripts',
    ) );



  } // end function sanitizer_filters()

  /**
   * Theme Settings Help Tabs
   *
   * Setup contextual help tabs content. This method adds the appropiate help
   * tabs based on the metaboxes/settings the theme supports.
   *
   * @todo add actual footer help tab content.
   *
   * @link  http://codex.wordpress.org/Class_Reference/WP_Screen
   * @link  http://codex.wordpress.org/Function_Reference/get_current_screen
   * @link  http://codex.wordpress.org/Class_Reference/WP_Screen/add_help_tab
   * @link  http://codex.wordpress.org/Class_Reference/WP_Screen/set_help_sidebar
   *
   * @uses exmachina_get_help_sidebar() Gets the help sidebar content.
   *
   * @since 1.0.0
   */
  public function settings_page_help() {

    /* Get the current screen. */
    $screen = get_current_screen();

    /* Get the sidebar content. */
    $template_help = exmachina_get_help_sidebar();

    /* Get theme-supported meta boxes for the settings page. */
    $supports = get_theme_support( 'exmachina-core-theme-settings' );

    /* Add the 'Theme Settings' help content. */
    $theme_settings_help =
    '<h3>' . __( 'Theme Settings', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'Your Theme Settings provides control over how the theme works. You will be able to control a lot of common and even advanced features from this menu. Each of the boxes can be collapsed by clicking the box header and expanded by doing the same. They can also be dragged into any order you desire or even hidden by clicking on "Screen Options" in the top right of the screen and "unchecking" the boxes you do not want to see.', 'exmachina-core' ) . '</p>';

    /* Adds the 'Theme Settings' help tab. */
    $screen->add_help_tab( array(
    'id'      => $this->pagehook . '-theme-settings',
    'title'   => __( 'Theme Settings', 'exmachina-core' ),
    'content' => $theme_settings_help,
    ) );

    /* Adds the 'Customize' help content. */
    $customize_help =
    '<h3>' . __( 'Customize', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'The theme customizer is available for a real time editing environment where theme options can be tried before being applied to the live site. Click \'Customize\' button below to personalize your theme', 'exmachina-core' ) . '</p>';

    /* Adds the 'Customize' help tab. */
    $screen->add_help_tab( array(
    'id'      => $this->pagehook . '-customize',
    'title'   => __( 'Customize', 'exmachina-core' ),
    'content' => $customize_help,
    ) );

    /* Adds the 'Theme Updates' help content. */
    $updates_help =
    '<h3>' . __( 'Theme Updates', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'The information box allows you to see the current ExMachina theme information and display if desired.', 'exmachina-core' ) . '</p>' .
    '<p>'  . __( 'Normally, this should be unchecked. You can also set to enable automatic updates.', 'exmachina-core' ) . '</p>' .
    '<p>'  . __( 'This does not mean the updates happen automatically without your permission; it will just notify you that an update is available. You must select it to perform the update.', 'exmachina-core' ) . '</p>' .
    '<p>'  . __( 'If you provide an email address and select to notify that email address when the update is available, your site will email you when the update can be performed. No, updates only affect files being updated.', 'exmachina-core' ) . '</p>';

    /* Add the 'Branding Settings' help content. */
    $brand_help =
    '<h3>' . __( 'Branding Settings', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'Help content goes here.' ) . '</p>';

    $header_help =
    '<h3>' . __( 'Header', 'exmachina-core') . '</h3>' .
    '<p>'  . __( 'The <strong>Dynamic text</strong> option will use the Site Title and Site Description from your site\'s settings in your header.', 'exmachina-core' ) . '</p>' .
    '<p>'  . __( 'The <strong>Image logo</strong> option will use a logo image file in the header instead of the site\'s title and description. This setting adds a .header-image class to your site, allowing you to specify the header image in your child theme\'s style.css. By default, the logo can be saved as logo.png and saved to the images folder of your child theme.', 'exmachina-core' ) . '</p>';

    /* Adds the 'Feed Settings' help content. */
    $feeds_help =
    '<h3>' . __( 'Custom Feeds', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'If you use Feedburner to handle your rss feed(s) you can use this function to set your site\'s native feed to redirect to your Feedburner feed.', 'exmachina-core' ) . '</p>' .
    '<p>'  . __( 'By filling in the feed links calling for the main site feed, it will display as a link to Feedburner.', 'exmachina-core' ) . '</p>' .
    '<p>'  . __( 'By checking the "Redirect Feed" box, all traffic to default feed links will be redirected to the Feedburner link instead.', 'exmachina-core' ) . '</p>';

    $breadcrumbs_help =
    '<h3>' . __( 'Breadcrumbs', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'This box lets you define where the "Breadcrumbs" display. The Breadcrumb is the navigation tool that displays where a visitor is on the site at any given moment.', 'exmachina-core' ) . '</p>';

    /* Adds the 'Layout Settings' help content. */
    $layout_help =
    '<h3>' . __( 'Default Layout', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'This lets you select the default layout for your entire site. On most of the child themes you\'ll see these options:', 'exmachina-core' ) . '</p>' .
    '<ul>' .
      '<li>' . __( 'Content Sidebar', 'exmachina-core' ) . '</li>' .
      '<li>' . __( 'Sidebar Content', 'exmachina-core' ) . '</li>' .
      '<li>' . __( 'Sidebar Content Sidebar', 'exmachina-core' ) . '</li>' .
      '<li>' . __( 'Content Sidebar Sidebar', 'exmachina-core' ) . '</li>' .
      '<li>' . __( 'Sidebar Sidebar Content', 'exmachina-core' ) . '</li>' .
      '<li>' . __( 'Full Width Content', 'exmachina-core' ) . '</li>' .
    '</ul>' .
    '<p>'  . __( 'These options can be extended or limited by the child theme. Additionally, many of the child themes do not allow different layouts on the home page as they have been designed for a specific home page layout.', 'exmachina' ) . '</p>' .
    '<p>'  . __( 'This layout can also be overridden in the post/page/term layout options on each post/page/term.', 'exmachina' ) . '</p>';

    $navigation_help =
      '<h3>' . __( 'Navigation', 'exmachina-core' ) . '</h3>' .
      '<p>'  . __( 'The Primary Navigation Extras typically display on the right side of your Primary Navigation menu.', 'exmachina-core' ) . '</p>' .
      '<ul>' .
        '<li>' . __( 'Today\'s date displays the current date', 'exmachina-core' ) . '</li>' .
        '<li>' . __( 'RSS feed link displays a link to the RSS feed for your site that a reader can use to subscribe to your site using the feedreader of their choice.', 'exmachina-core' ) . '</li>' .
        '<li>' . __( 'Search form displays a small search form utilizing the WordPress search functionality.', 'exmachina-core' ) . '</li>' .
        '<li>' . __( 'Twitter link displays a link to your Twitter profile, as indicated in Twitter ID setting. Enter only your user name in this setting.', 'exmachina-core' ) . '</li>' .
      '</ul>' .
      '<p>'  . __( 'These options can be extended or limited by the child theme.', 'exmachina-core' ) . '</p>';

    $comments_help =
    '<h3>' . __( 'Comments <span class="amp">&amp;</span> Trackbacks', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'This allows a site wide decision on whether comments and trackbacks (notifications when someone links to your page) are enabled for posts and pages.', 'exmachina-core' ) . '</p>' .
    '<p>'  . __( 'If you enable comments or trackbacks here, it can be disabled on an individual post or page. If you disable here, they cannot be enabled on an individual post or page.', 'exmachina-core' ) . '</p>';

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

    /* Adds the 'Header & Footer Scripts' help content. */
    $scripts_help =
    '<h3>' . __( 'Header <span class="amp">&amp;</span> Footer Scripts', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'This provides you with two fields that will output to the head section of your site and just before the closing body tag. These will appear on every page of the site and are a great way to add analytic code, Google Font and other scripts. You cannot use PHP in these fields.', 'exmachina-core' ) . '</p>';

    /* Adds the 'Footer Settings' help content. */
    $footer_help =
    '<h3>' . __( 'Footer Settings', 'exmachina-core' ) . '</h3>' .
    '<p>'  . __( 'Help content goes here', 'exmachina-core' ) . '</p>';

    /* Load the help tabs that are supported by the theme. */
    if ( is_array( $supports[0] ) ) {

      /* Load the 'Updates' help tab if supported. */
      if ( in_array( 'updates', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-updates',
          'title'   => __( 'Theme Updates', 'exmachina-core' ),
          'content' => $updates_help,
        ) );

      /* Load the 'Branding' help tab if supported. */
      if ( in_array( 'brand', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-branding',
          'title'   => __( 'Branding', 'exmachina-core' ),
          'content' => $brand_help,
        ) );

      /* Load the 'Header' help tab if supported. */
      if ( in_array( 'header', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-header',
          'title'   => __( 'Header' , 'exmachina-core' ),
          'content' => $header_help,
        ) );

      /* Load the 'Feed Settings' help tab if supported. */
      if ( in_array( 'feeds', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-feeds',
          'title'   => __( 'Custom Feeds', 'exmachina-core' ),
          'content' => $feeds_help,
        ) );

      /* Load the 'Breadcrumbs' help tab if supported. */
      if ( in_array( 'breadcrumbs', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-breadcrumbs',
          'title'   => __( 'Breadcrumbs', 'exmachina-core' ),
          'content' => $breadcrumbs_help,
        ) );

      /* Load the 'Layout' help tab if supported. */
      if ( in_array( 'layout', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-layout',
          'title'   => __( 'Default Layout', 'exmachina-core' ),
          'content' => $layout_help,
        ) );

      /* Load the 'Menus' help tab if supported. */
      if ( in_array( 'menus', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-navigation',
          'title'   => __( 'Navigation' , 'exmachina-core' ),
          'content' => $navigation_help,
        ) );

      /* Load the 'Comments' help tab if supported. */
      if ( in_array( 'comments', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-comments',
          'title'   => __( 'Comments & Trackbacks', 'exmachina-core' ),
          'content' => $comments_help,
        ) );

      /* Load the 'Archives' helptab if supported. */
      if ( in_array( 'archives', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-archives',
          'title'   => __( 'Content Archives', 'exmachina-core' ),
          'content' => $archives_help,
        ) );

      /* Load the 'Blog Page' help tab if supported. */
      if ( in_array( 'blogpage', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-blogpage',
          'title'   => __( 'Blog Page', 'exmachina-core' ),
          'content' => $blog_help,
        ) );

      /* Load the 'Header & Footer Scripts' help tab if supported. */
      if ( in_array( 'scripts', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-scripts',
          'title'   => __( 'Header & Footer Scripts', 'exmachina-core' ),
          'content' => $scripts_help,
        ) );

      /* Adds the 'Footer Settings' help tab if supported. */
      if ( in_array( 'footer', $supports[0] ) )
        $screen->add_help_tab( array(
          'id'      => $this->pagehook . '-footer',
          'title'   => __( 'Footer Settings', 'exmachina-core' ),
          'content' => $footer_help,
        ) );

    } // end if (is_array($supports[0]))

    /* Adds help sidebar content. */
    $screen->set_help_sidebar(
      $template_help
    );

    /* Trigger the help content action hook. */
    do_action( 'exmachina_theme_settings_help', $this->pagehook );

  } // end function settings_page_help()

  /**
   * Theme Settings Load Metaboxes
   *
   * Registers metaboxes for the settings page. Metaboxes are only registered if
   * supported by the theme and the user capabilitiy allows it.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_meta_box
   * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
   * @link http://codex.wordpress.org/Function_Reference/get_theme_support
   *
   * @uses exmachina_get_prefix() Gets the theme prefix.
   * @uses \ExMachina_Admin_Theme_Settings::hidden_fields()
   * @uses \ExMachina_Admin_Theme_Settings::exmachina_metabox_theme_display_save()
   *
   * @todo prefix/add action hooks.
   *
   * @since 1.0.0
   */
  public function settings_page_load_metaboxes() {

    /* Get theme information. */
    $prefix = exmachina_get_prefix();
    $theme = wp_get_theme( get_template() );

    /* Adds hidden fields before the theme settings metabox display. */
    add_action( $this->pagehook . '_admin_before_metaboxes', array( $this, 'hidden_fields' ) );

    /* Register the 'Save Settings' metabox to the 'side' priority. */
    add_meta_box( 'exmachina-core-theme-settings-save', __( '<i class="uk-icon-save"></i> Save Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_theme_display_save' ), $this->pagehook, 'side', 'high' );

    /* Get theme-supported meta boxes for the settings page. */
    $supports = get_theme_support( 'exmachina-core-theme-settings' );

    /* If there are any supported meta boxes, load them. */
    if ( is_array( $supports[0] ) ) {

      /* Load the 'Theme Updates' meta box if it is supported. */
      if ( in_array( 'updates', $supports[0] ) )
      add_meta_box( 'exmachina-core-updates', __( '<i class="uk-icon-download"></i> Theme Updates', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_updates' ), $this->pagehook, 'normal', 'high' );

      /* Load the 'Branding' meta box if it is supported. */
      if ( in_array( 'brand', $supports[0] ) )
      add_meta_box( 'exmachina-core-branding', __( '<i class="uk-icon-bullseye"></i> Brand Settings', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_brand' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Header Settings' meta box if it is supported. */
      if ( in_array( 'header', $supports[0] ) || ! current_theme_supports( 'exmachina-custom-header' ) && ! current_theme_supports( 'custom-header' ) )
      add_meta_box( 'exmachina-core-header', __( '<i class="uk-icon-gears"></i> Header Settings', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_header' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Style Selector' meta box if it is supported. */
      if ( in_array( 'style', $supports[0] ) || current_theme_supports( 'exmachina-style-selector' ) )
      add_meta_box( 'exmachina-core-style', __( '<i class="uk-icon-adjust"></i> Style Selector', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_style' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Feed Settings' meta box if it is supported. */
      if ( in_array( 'feeds', $supports[0] ) )
      add_meta_box( 'exmachina-core-feeds', __( '<i class="uk-icon-rss"></i> Feed Settings', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_feeds' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Breadcrumbs' meta box if it is supported. */
      if ( in_array( 'breadcrumbs', $supports[0] ) || current_theme_supports( 'exmachina-breadcrumbs' ) )
      add_meta_box( 'exmachina-core-breadcrumbs', __( '<i class="uk-icon-chevron-right"></i> Breadcrumbs', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_breadcrumbs' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Layout' meta box if it is supported. */
      if ( in_array( 'layout', $supports[0] ) )
      add_meta_box( 'exmachina-core-layout', __( '<i class="uk-icon-columns"></i> Global Layout', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_layout' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Menus' meta box if it is supported. */
      if ( in_array( 'menus', $supports[0] ) || current_theme_supports( 'exmachina-core-menus' ) )
      add_meta_box( 'exmachina-core-menus', __( '<i class="uk-icon-compass"></i> Menu Settings', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_menus' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Post Edits' meta box if it is supported. */
      if ( in_array( 'edits', $supports[0] ) )
      add_meta_box( 'exmachina-core-edits', __( '<i class="uk-icon-edit"></i> Post Edits', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_edits' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Comments' meta box if it is supported. */
      if ( in_array( 'comments', $supports[0] ) )
      add_meta_box( 'exmachina-core-comments', __( '<i class="uk-icon-comments-alt"></i> Comments <span class="amp">&amp;</span> Trackbacks', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_comments' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Archives' meta box if it is supported. */
      if ( in_array( 'archives', $supports[0] ) )
      add_meta_box( 'exmachina-core-archives', __( '<i class="uk-icon-archive"></i> Content Archives', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_archives' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Blogpage' meta box if it is supported. */
      if ( in_array( 'blogpage', $supports[0] ) )
      add_meta_box( 'exmachina-core-blogpage', __( '<i class="uk-icon-cog"></i> Blogpage Template', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_blogpage' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Header & Footer Scripts' meta box if it is supported. */
      if ( in_array( 'scripts', $supports[0] ) && current_user_can( 'unfiltered_html' ) )
      add_meta_box( 'exmachina-core-scripts', __( '<i class="uk-icon-code"></i> Header <span class="amp">&amp;</span> Footer Scripts', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_scripts' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'Footer' meta box if it is supported. */
      if ( in_array( 'footer', $supports[0] ) )
      add_meta_box( 'exmachina-core-footer', __( '<i class="uk-icon-reorder"></i>  Footer settings', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_footer' ), $this->pagehook, 'normal', 'default' );

      /* Load the 'About' metabox if it is supported. */
      if ( in_array( 'about', $supports[0] ) ) {

        /* Adds the About box for the parent theme. */
        add_meta_box( 'exmachina-core-about-theme', sprintf( __( '<i class="uk-icon-info-sign"></i> About %s', 'exmachina-core' ), $theme->get( 'Name' ) ), array( $this, 'exmachina_metabox_theme_display_about' ), $this->pagehook, 'side', 'default' );

        /* If the user is using a child theme, add an About box for it. */
        if ( is_child_theme() ) {
          $child = wp_get_theme();
          add_meta_box( 'exmachina-core-about-child', sprintf( __( '<i class="uk-icon-info-sign"></i> About %s', 'exmachina-core' ), $child->get( 'Name' ) ), array( $this, 'exmachina_metabox_theme_display_about' ), $this->pagehook, 'side', 'default' );
        }
      } // end if  in_array('about', $supports[0]))

      /* Load the 'Help' meta box if it is supported. */
      if ( in_array( 'help', $supports[0] ) )
      add_meta_box( 'exmachina-core-help', __( '<i class="uk-icon-question-sign"></i> Need Help', 'exmachina-core' ), array( $this, 'exmachina_metabox_theme_display_help' ), $this->pagehook, 'side', 'default' );

    } // end if (is_array($supports[0]))

    /* Trigger the theme settings metabox action hook. */
    do_action( 'exmachina_theme_settings_metaboxes', $this->pagehook );

  } // end function settings_page_load_metaboxes()

  /**
   * Theme Settings Hidden Fields
   *
   * Echo hidden form fields before the metaboxes. This method adds the theme
   * and database version to the settings form.
   *
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   *
   * @param  string $pagehook Current page hook.
   * @return null             Returns early if not set to the correct admin page.
   */
  function hidden_fields( $pagehook ) {

    if ( $pagehook !== $this->pagehook )
      return;

    printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'theme_version' ), esc_attr( $this->get_field_value( 'theme_version' ) ) );
    printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'db_version' ), esc_attr( $this->get_field_value( 'db_version' ) ) );

  } // end function hidden_fields()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Save Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Save Settings Metabox Display
   *
   * Callback to display the 'Save Settings' metabox.
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_meta_box_theme_display_save() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <?php submit_button( $this->page_ops['save_button_text'], 'primary button-hero update-button uk-button-expand', 'submit', false, array( 'id' => '' ) ); ?>
                      <?php submit_button( $this->page_ops['reset_button_text'], 'secondary reset-button uk-button-expand uk-text-bold exmachina-js-confirm-reset', $this->get_field_name( 'reset' ), false, array( 'id' => '' ) ); ?>
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_meta_box_theme_display_save()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Theme Updates' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Theme Updates Metabox Display
   *
   * Callback to display the 'Theme Updates' metabox. Creates a metabox for the
   * theme settings page, which allows theme updates.
   *
   * Fields:
   * ~~~~~~~
   * 'theme_version'
   * 'license_key'
   * 'update'
   * 'update_email'
   * 'update_email_address'
   *
   * To use this feature, the theme must support the 'updates' argument for the
   * 'exmachina-core-theme-settings' feature.
   *
   * @todo add fields to defaults
   * @todo add fields to sanitizer
   * @todo replace release date field with constant
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_metabox_theme_display_updates() {

    /* Get theme information. */
    $theme = wp_get_theme( get_template() );
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label class="uk-text-bold"><?php _e( 'Theme Version:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls uk-form-controls-condensed">
                      <!-- Begin Form Inputs -->
                      <strong><?php _e( 'Version:', 'exmachina-core' ); ?></strong> <?php echo $this->get_field_value( 'theme_version' ); ?> &#x000B7; <strong><?php _e( 'Released:', 'exmachina-core' ); ?></strong> <?php echo $this->get_field_value( 'release_date' ); ?>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'license_key' ); ?>" class="uk-text-bold"><?php _e( 'License Key:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'license_key' ); ?>" id="<?php echo $this->get_field_id( 'license_key' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'license_key' ) ); ?>" placeholder="Enter your license key" size="50" />
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'update' ); ?>" class="uk-text-bold"><?php _e( 'Automatic Updates:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'update' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'update' ); ?>" id="<?php echo $this->get_field_id( 'update' ); ?>" value="1"<?php checked( $this->get_field_value( 'update' ) ) . disabled( is_super_admin(), 0 ); ?> />
                      <?php _e( 'Enable Automatic Updates', 'exmachina-core' ); ?></label>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'update_email' ); ?>" class="uk-text-bold"><?php _e( 'Update Email:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'update_email' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'update_email' ); ?>" id="<?php echo $this->get_field_id( 'update_email' ); ?>" value="1"<?php checked( $this->get_field_value( 'update_email' ) ) . disabled( is_super_admin(), 0 ); ?> />
                      <?php _e( 'Notify', 'exmachina-core' ); ?></label>
                      <input type="text" name="<?php echo $this->get_field_name( 'update_email_address' ); ?>" id="<?php echo $this->get_field_id( 'update_email_address' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'update_email_address' ) ); ?>" placeholder="enter your e-mail address" size="30"<?php disabled( 0, is_super_admin() ); ?> />
                      <label for="<?php echo $this->get_field_id( 'update_email_address' ); ?>"><?php _e( 'when updates are available', 'exmachina-core' ); ?></label>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->


                  <p class="uk-text-muted"><?php printf( __( 'If you provide an email address above, you will be notified via email when a new version of %1s is available.', 'exmachina-core' ), $theme->get( 'Name' ) ); ?></p>

                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_updates()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Branding' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Branding Settings Metabox Display
   *
   * Callback to display the 'Branding Settings' metabox. Creates a metabox for the
   * theme settings page, which allows users to modify the site's branding.
   *
   * Fields:
   * ~~~~~~~
   * 'TBD'
   *
   * To use this feature, the theme must support the 'brand' argument for the
   * 'exmachina-core-theme-settings' feature.
   *
   * @todo write header info text
   * @todo build out actual options
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_metabox_theme_display_brand() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'blog_title' ); ?>" class="uk-text-bold"><?php _e( 'Use for site title/logo:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->



                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_brand()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Header' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Header Settings Metabox Display
   *
   * Callback to display the 'Header Settings' metabox. Creates a metabox for the
   * theme settings page, which allows users to select a header style.
   *
   * Fields:
   * ~~~~~~~
   * 'blog_title'
   *
   * To use this feature, the theme must support the 'header' argument for the
   * 'exmachina-core-theme-settings' feature.
   *
   * @todo write header info text
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.5.5
   */
  function exmachina_metabox_theme_display_header() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'blog_title' ); ?>" class="uk-text-bold"><?php _e( 'Use for site title/logo:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <select name="<?php echo $this->get_field_name( 'blog_title' ); ?>">
                        <option value="text"<?php selected( $this->get_field_value( 'blog_title' ), 'text' ); ?>><?php _e( 'Dynamic text', 'exmachina-core' ); ?></option>
                        <option value="image"<?php selected( $this->get_field_value( 'blog_title' ), 'image' ); ?>><?php _e( 'Image logo', 'exmachina-core' ); ?></option>
                      </select>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_header()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Style Selection' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Style Selector Metabox Display
   *
   * Callback to display the 'Style Selector' metabox. Creates a metabox for the
   * theme settings page, which allows users to select a custom style. The style
   * selector can be enabled and populated by adding an associated array of
   * style => title when initiating support for exmachina-style-selector in the
   * child theme functions.php file.
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
   * When selected, the style will be added as a body class which can be used
   * within style.css to target elements when using a specific style.
   *
   * ~~~
   * h1 { background: #000; }
   * .childtheme-red h1 { background: #f00; }
   * ~~~
   *
   * Fields:
   * ~~~~~~~
   * 'style_selection'
   *
   * To use this feature, the theme must support the 'feeds' argument for the
   * 'exmachina-core-theme-settings' feature.
   *
   * @todo write header info text
   *
   * @link http://codex.wordpress.org/WordPress_Feeds
   * @link http://codex.wordpress.org/Customizing_Feeds
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.5.5
   */
  function exmachina_metabox_theme_display_style() {

    $current = $this->get_field_value( 'style_selection' );
    $styles  = get_theme_support( 'exmachina-style-selector' );

    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'style_selection' ); ?>" class="uk-text-bold"><?php _e( 'Color Style:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <select name="<?php echo $this->get_field_name( 'style_selection' ); ?>" id="<?php echo $this->get_field_id( 'style_selection' ); ?>">
                        <option value=""><?php _e( 'Default', 'exmachina-core' ); ?></option>
                        <?php
                        if ( ! empty( $styles ) ) {
                          $styles = array_shift( $styles );
                          foreach ( (array) $styles as $style => $title ) {
                            ?><option value="<?php echo esc_attr( $style ); ?>"<?php selected( $current, $style ); ?>><?php echo esc_html( $title ); ?></option><?php
                          }
                        }
                        ?>
                      </select>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><?php _e( 'Please select the color style from the drop down list and save your settings.', 'exmachina-core' ); ?></p>
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_style()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Feed Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Feed Settings Metabox Display
   *
   * Callback to display the 'Feed Settings' metabox. Creates a metabox for the
   * theme settings page, which allows a custom redirect of the default WordPress
   * feeds.
   *
   * Fields:
   * ~~~~~~~
   * 'feed_uri'
   * 'redirect_feed'
   * 'comments_feed_uri'
   * 'redirect_comments_feed'
   *
   * To use this feature, the theme must support the 'feeds' argument for the
   * 'exmachina-core-theme-settings' feature.
   *
   * @todo write header info text
   * @todo add different placeholder text
   *
   * @link http://codex.wordpress.org/WordPress_Feeds
   * @link http://codex.wordpress.org/Customizing_Feeds
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_metabox_theme_display_feeds() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'feed_uri' ); ?>" class="uk-text-bold"><?php _e( 'Enter your custom feed URL:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'feed_uri' ); ?>" id="<?php echo $this->get_field_id( 'feed_uri' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'feed_uri' ) ); ?>" placeholder="http://customfeedurl.com" size="50" />
                      <label for="<?php echo $this->get_field_id( 'redirect_feed' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'redirect_feed' ); ?>" id="<?php echo $this->get_field_id( 'redirect_feed' ); ?>" value="1"<?php checked( $this->get_field_value( 'redirect_feed' ) ); ?> />
                      <?php _e( 'Redirect Feed?', 'exmachina-core' ); ?></label>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'comments_feed_uri' ); ?>" class="uk-text-bold"><?php _e( 'Enter your custom comments feed URL:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'comments_feed_uri' ); ?>" id="<?php echo $this->get_field_id( 'comments_feed_uri' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comments_feed_uri' ) ); ?>" placeholder="http://customfeedurl.com" size="50" />
                      <label for="<?php echo $this->get_field_id( 'redirect_comments_feed' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'redirect_comments_feed' ); ?>" id="<?php echo $this->get_field_id( 'redirect_comments_feed' ); ?>" value="1"<?php checked( $this->get_field_value( 'redirect_comments_feed' ) ); ?> />
                      <?php _e( 'Redirect Feed?', 'exmachina-core' ); ?></label>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_feeds()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Breadcrumb Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Breadcrumb Settings Metabox Display
   *
   * Callback to display the 'Breadcrumb Settings' metabox. Creates a metabox
   * for the theme settings page, which allows customization of the breadcrumb
   * trail.
   *
   * Fields:
   * ~~~~~~~
   * 'breadcrumb_front_page'
   * 'breadcrumb_posts_page'
   * 'breadcrumb_home'
   * 'breadcrumb_single'
   * 'breadcrumb_page'
   * 'breadcrumb_archive'
   * 'breadcrumb_404'
   * 'breadcrumb_attachment'
   *
   * To use this feature, the theme must support the 'breadcrumbs' argument for
   * the 'exmachina-core-theme-settings' feature.
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_metabox_theme_display_breadcrumbs() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance. You can enable/disable them on certain areas of your site.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label class="uk-text-bold"><?php _e( 'Enable Breadcrumbs on:', 'exmachina-core' ); ?></label>
            </td>

            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <ul class="checkbox-list horizontal">

                        <?php if ( 'page' === get_option( 'show_on_front' ) ) : ?>

                          <li><label for="<?php echo $this->get_field_id( 'breadcrumb_front_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_front_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_front_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_front_page' ) ); ?> />
                          <?php _e( 'Front Page', 'exmachina-core' ); ?></label></li>

                          <li><label for="<?php echo $this->get_field_id( 'breadcrumb_posts_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_posts_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_posts_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_posts_page' ) ); ?> />
                          <?php _e( 'Posts Page', 'exmachina-core' ); ?></label></li>

                        <?php else : ?>

                          <li><label for="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_home' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_home' ) ); ?> />
                          <?php _e( 'Homepage', 'exmachina-core' ); ?></label></li>

                        <?php endif; ?>

                          <li><label for="<?php echo $this->get_field_id( 'breadcrumb_single' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_single' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_single' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_single' ) ); ?> />
                          <?php _e( 'Posts', 'exmachina-core' ); ?></label></li>

                          <li><label for="<?php echo $this->get_field_id( 'breadcrumb_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_page' ) ); ?> />
                          <?php _e( 'Pages', 'exmachina-core' ); ?></label></li>

                          <li><label for="<?php echo $this->get_field_id( 'breadcrumb_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_archive' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_archive' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_archive' ) ); ?> />
                          <?php _e( 'Archives', 'exmachina-core' ); ?></label></li>

                          <li><label for="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_404' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_404' ) ); ?> />
                          <?php _e( '404 Page', 'exmachina-core' ); ?></label></li>

                          <li><label for="<?php echo $this->get_field_id( 'breadcrumb_attachment' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_attachment' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_attachment' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_attachment' ) ); ?> />
                          <?php _e( 'Attachment Page', 'exmachina-core' ); ?></label></li>

                      </ul>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td>
          </tr>


        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_breadcrumbs()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Default Layout' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Layout Settings Metabox Display
   *
   * Callback to display the 'Layout Settings' metabox. Creates a metabox
   * for the theme settings page, which allows customization of the default
   * layout.
   *
   * Fields:
   * ~~~~~~~
   * 'site_layout'
   *
   * To use this feature, the theme must support the 'layout' argument for
   * the 'exmachina-core-theme-settings' feature.
   *
   * @todo replace with actual layout function
   * @todo docblock comment
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_metabox_theme_display_layout() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="radio-selector" colspan="2">
              <div class="fieldset-wrap uk-margin uk-grid">
                <fieldset class="uk-form uk-width-1-1">
                  <div class="exmachina-layout-selector radio-container uk-grid uk-grid-preserve">
                    <?php // exmachina_layout_selector( array( 'name' => $this->get_field_name( 'site_layout' ), 'selected' => $this->get_field_value( 'site_layout' ), 'type' => 'site' ) ); ?>
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img01.png' ); ?>">
                    </label>
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img02.png' ); ?>">
                    </label>
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img layout-img-selected" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img03.png' ); ?>">
                    </label>
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img04.png' ); ?>">
                    </label>
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img05.png' ); ?>">
                    </label>
                    <label class="layout-label uk-width-1-6">
                      <input type="radio" class="layout-radio" id="" name="" value="1" onclick="">
                      <img class="layout-img" src="<?php echo esc_url( trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'layouts/img06.png' ); ?>">
                    </label>
                  </div><!-- .radio-container -->
                </fieldset>
              </div><!-- .fieldset-wrap -->
            </td><!-- .radio-selector -->
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_layout()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Menu Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Menu Settings Metabox Display
   *
   * Callback to display the 'Menu Settings' metabox. Creates a metabox for the
   * theme settings page, which allows customization of the navigation menus.
   *
   * Fields:
   * ~~~~~~~
   * 'primary_nav_extras'
   * 'primary_nav_extras_twitter_id'
   * 'primary_nav_extras_text'
   *
   * @todo write header info text
   * @todo make actually work
   * @todo add additional menu features
   * @todo duplicate functionality for other menus.
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * To use this feature, the theme must support the 'menus' argument for the
   * 'exmachina-core-theme-settings' feature and each custom menu must be both
   * supported and active.
   *
   * @since 1.5.5
   */
  function exmachina_metabox_theme_display_menus() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td>

              <p>Come back to these settings.</p>
            </td>
          </tr>



        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_menus()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Post Edits' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Post Edits Metabox Display
   *
   * Callback to display the 'Post Edits' metabox. Creates a metabox
   * for the theme settings page, which allows customization of the post info
   * and post meta.
   *
   * Fields:
   * ~~~~~~~
   * 'post_info'
   * 'post_meta'
   *
   * To use this feature, the theme must support the 'edits' argument for
   * the 'exmachina-core-theme-settings' feature.
   *
   * @todo docblock comment
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_metabox_theme_display_edits() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'post_info' ); ?>" class="uk-text-bold"><?php _e( 'Post Info:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'post_info' ); ?>" id="<?php echo $this->get_field_id( 'post_info' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'post_info' ) ); ?>" size="50" />
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'post_meta' ); ?>" class="uk-text-bold"><?php _e( 'Post Meta:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'post_meta' ); ?>" id="<?php echo $this->get_field_id( 'post_meta' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'post_meta' ) ); ?>" size="50" />
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_edits()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Comment Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Comments & Trackbacks Metabox Display
   *
   * Callback to display the 'Comment & Trackbacks' metabox. Creates a metabox
   * for the theme settings page, which allows customization of the comment
   * and trackback settings on pages and posts.
   *
   * Fields:
   * ~~~~~~~
   * 'comments_posts'
   * 'comments_pages'
   * 'trackback_posts'
   * 'trackback_pages'
   *
   * To use this feature, the theme must support the 'comments' argument for
   * the 'exmachina-core-theme-settings' feature.
   *
   * @todo write header info text
   * @todo write description text
   * @todo cleanup form layout
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.5.5
   */
  function exmachina_metabox_theme_display_comments() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Comments and Trackbacks can also be disabled on a per post/page basis.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label class="uk-text-bold"><?php _e( 'Enable Comments:', 'exmachina-core' ); ?></label>
            </td>

            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <ul class="checkbox-list horizontal">

                        <li><label for="<?php echo $this->get_field_id( 'comments_posts' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'comments_posts' ); ?>" id="<?php echo $this->get_field_id( 'comments_posts' ); ?>" value="1"<?php checked( $this->get_field_value( 'comments_posts' ) ); ?> />
                        <?php _e( 'on posts?', 'exmachina-core' ); ?></label></li>

                        <li><label for="<?php echo $this->get_field_id( 'comments_pages' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'comments_pages' ); ?>" id="<?php echo $this->get_field_id( 'comments_pages' ); ?>" value="1"<?php checked( $this->get_field_value( 'comments_pages' ) ); ?> />
                        <?php _e( 'on pages?', 'exmachina-core' ); ?></label></li>

                      </ul>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td>
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label class="uk-text-bold"><?php _e( 'Enable Trackbacks:', 'exmachina-core' ); ?></label>
            </td>

            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <ul class="checkbox-list horizontal">

                        <li><label for="<?php echo $this->get_field_id( 'trackbacks_posts' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'trackbacks_posts' ); ?>" id="<?php echo $this->get_field_id( 'trackbacks_posts' ); ?>" value="1"<?php checked( $this->get_field_value( 'trackbacks_posts' ) ); ?> />
                        <?php _e( 'on posts?', 'exmachina-core' ); ?></label></li>

                        <li><label for="<?php echo $this->get_field_id( 'trackbacks_pages' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'trackbacks_pages' ); ?>" id="<?php echo $this->get_field_id( 'trackbacks_pages' ); ?>" value="1"<?php checked( $this->get_field_value( 'trackbacks_pages' ) ); ?> />
                        <?php _e( 'on pages?', 'exmachina-core' ); ?></label></li>

                      </ul>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td>
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_comments()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Content Archives' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Content Archives Metabox Display
   *
   * Callback to display the 'Content Archives' metabox. Creates a metabox
   * for the theme settings page, which allows customization of the content
   * archives.
   *
   * Fields:
   * ~~~~~~~
   * 'content_archive'
   * 'content_archive_limit'
   * 'content_archive_more'
   * 'content_archive_thumbnail'
   * 'image_size'
   * 'posts_nav'
   * 'single_nav'
   *
   * To use this feature, the theme must support the 'archives' argument for
   * the 'exmachina-core-theme-settings' feature.
   *
   * @todo test functionality
   * @todo add JS options
   * @todo add image size selectors
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.5.5
   */
  function exmachina_metabox_theme_display_archives() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'These options will affect any blog listings page, including archive, author, blog, category, search, and tag pages.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'content_archive' ); ?>" class="uk-text-bold"><?php _e( 'Select one of the following:', 'exmachina-core' ); ?></label>
            </td>

            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <select name="<?php echo $this->get_field_name( 'content_archive' ); ?>" id="<?php echo $this->get_field_id( 'content_archive' ); ?>">
                      <?php
                      $archive_display = apply_filters(
                        'exmachina_archive_display_options',
                        array(
                          'full'     => __( 'Display full post', 'exmachina-core' ),
                          'excerpts' => __( 'Display post excerpts', 'exmachina-core' ),
                        )
                      );
                      foreach ( (array) $archive_display as $value => $name )
                        echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->get_field_value( 'content_archive' ), esc_attr( $value ), false ) . '>' . esc_html( $name ) . '</option>' . "\n";
                      ?>
                      </select>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td>
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'content_archive_limit' ); ?>" class="uk-text-bold"><?php _e( 'Content limit:', 'exmachina-core' ); ?></label>
            </td>

            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'content_archive_limit' ); ?>"><?php _e( 'Limit content to', 'exmachina-core' ); ?>
                      <input type="text" name="<?php echo $this->get_field_name( 'content_archive_limit' ); ?>" id="<?php echo $this->get_field_id( 'content_archive_limit' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'content_archive_limit' ) ); ?>" size="3" />
                      <?php _e( 'characters', 'exmachina-core' ); ?></label>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><?php _e( 'Select "Display post excerpts" will limit the text and strip all formatting from the text displayed. Set 0 characters will display the first 55 words (default).', 'exmachina-core' ); ?></p>
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td>
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label class="uk-text-bold"><?php _e( 'More Text (if applicable):', 'exmachina-core' ); ?></label>
            </td>

            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'content_archive_more' ); ?>" id="<?php echo $this->get_field_id( 'content_archive_more' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'content_archive_more' ) ); ?>" size="25" />
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td>
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label class="uk-text-bold"><?php _e( 'Include the Featured Image?', 'exmachina-core' ); ?></label>
            </td>

            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'content_archive_thumbnail' ); ?>">
                      <input type="checkbox" name="<?php echo $this->get_field_name( 'content_archive_thumbnail' ); ?>" id="<?php echo $this->get_field_id( 'content_archive_thumbnail' ); ?>" value="1" <?php checked( $this->get_field_value( 'content_archive_thumbnail' ) ); ?> />
                      <?php _e( 'Include the Featured Image?', 'exmachina-core' ); ?></label>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td>
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'image_size' ); ?>" class="uk-text-bold"><?php _e( 'Image Size:', 'exmachina-core' ); ?></label>
            </td>

            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <select name="<?php echo $this->get_field_name( 'image_size' ); ?>" id="<?php echo $this->get_field_id( 'image_size' ); ?>">
                      <?php
                      /* @todo reconnect get_image_sizes */
                      $sizes = ''; //exmachina_get_image_sizes();
                      foreach ( (array) $sizes as $name => $size )
                        echo '<option value="' . esc_attr( $name ) . '"' . selected( $this->get_field_value( 'image_size' ), $name, FALSE ) . '>' . esc_html( $name ) . ' (' . absint( $size['width'] ) . ' &#x000D7; ' . absint( $size['height'] ) . ')</option>' . "\n";
                      ?>
                      </select>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td>
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'posts_nav' ); ?>" class="uk-text-bold"><?php _e( 'Select Post Navigation Format:', 'exmachina-core' ); ?></label>
            </td>

            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <select name="<?php echo $this->get_field_name( 'posts_nav' ); ?>" id="<?php echo $this->get_field_id( 'posts_nav' ); ?>">
                        <option value="prev-next"<?php selected( 'prev-next', $this->get_field_value( 'posts_nav' ) ); ?>><?php _e( 'Previous / Next', 'exmachina-core' ); ?></option>
                        <option value="numeric"<?php selected( 'numeric', $this->get_field_value( 'posts_nav' ) ); ?>><?php _e( 'Numeric', 'exmachina-core' ); ?></option>
                      </select>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td>
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'single_nav' ); ?>" class="uk-text-bold"><?php _e( 'Disable single post navigation link?', 'exmachina-core' ); ?></label>
            </td>

            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <label for="<?php echo $this->get_field_id( 'single_nav' ); ?>">
                      <input type="checkbox" name="<?php echo $this->get_field_name( 'single_nav' ); ?>" id="<?php echo $this->get_field_id( 'single_nav' ); ?>" value="1" <?php checked( $this->get_field_value( 'single_nav' ) ); ?> />
                      <?php _e( 'Disable single post navigation link?', 'exmachina-core' ); ?></label>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td>
          </tr>


        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_archives()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Blog Page Template' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Blog Page Template Metabox Display
   *
   * Callback to display the 'Blog Page Template' metabox. Creates a metabox for the
   * theme settings page, which allows users to modify the blog page template.
   *
   * Fields:
   * ~~~~~~~
   * 'blog_cat'
   * 'blog_cat_exclude'
   * 'blog_cat_num'
   *
   * To use this feature, the theme must support the 'blogpage' argument for the
   * 'exmachina-core-theme-settings' feature.
   *
   * @todo write header info text
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_metabox_theme_display_blogpage() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table postbox-bordered">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'These settings apply to any page given the "Blog" page template, not the homepage or post archive pages.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'blog_cat' ); ?>" class="uk-text-bold"><?php _e( 'Display which category:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <?php wp_dropdown_categories( array( 'selected' => $this->get_field_value( 'blog_cat' ), 'name' => $this->get_field_name( 'blog_cat' ), 'orderby' => 'Name', 'hierarchical' => 1, 'show_option_all' => __( 'All Categories', 'exmachina' ), 'hide_empty' => '0' ) ); ?>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'blog_cat_exclude' ); ?>" class="uk-text-bold"><?php _e( 'Exclude the following Category IDs:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'blog_cat_exclude' ); ?>" id="<?php echo $this->get_field_id( 'blog_cat_exclude' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'blog_cat_exclude' ) ); ?>" size="40" />
                      <br /><small><strong><?php _e( 'Comma separated - 1,2,3 for example', 'exmachina' ); ?></strong></small>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

          <tr class="uk-table-middle">
            <td class="uk-width-3-10 postbox-label">
              <label for="<?php echo $this->get_field_id( 'blog_cat_num' ); ?>" class="uk-text-bold"><?php _e( 'Number of Posts to Show:', 'exmachina-core' ); ?></label>
            </td>
            <td class="uk-width-7-10 postbox-fieldset">
              <div class="fieldset-wrap uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <input type="text" name="<?php echo $this->get_field_name( 'blog_cat_num' ); ?>" id="<?php echo $this->get_field_id( 'blog_cat_num' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'blog_cat_num' ) ); ?>" size="2" />
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>

        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_blogpage()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Header & Footer Scripts' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Header & Footer Scripts Metabox Display
   *
   * Callback to display the 'Header & Footer Scripts' metabox. Creates a metabox
   * for the theme settings page, which holds textareas to add custom scripts
   * (CSS or JS) within the header or the footer of the theme.
   *
   * Fields:
   * ~~~~~~~
   * 'header_scripts'
   * 'footer_scripts'
   *
   * To use this feature, the theme must support the 'scripts' argument for
   * the 'exmachina-core-theme-settings' feature.
   *
   * @todo write header info text
   * @todo CSS a no-lined legend and/or a non-lined table row
   * @todo docblock comment
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_metabox_theme_display_scripts() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <legend><?php _e( 'Header Scripts', 'exmachina-core' ); ?></legend>
                  <p class="uk-margin-top-remove"><label for="<?php echo $this->get_field_id( 'header_scripts' ); ?>"><?php printf( __( 'Enter scripts or code you would like output to %s:', 'exmachina-core' ), exmachina_code( 'wp_head()' ) ); ?></label></p>
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <textarea class="input-block-level vertical-resize code exmachina-code-area" name="<?php echo $this->get_field_name( 'header_scripts' ); ?>" id="<?php echo $this->get_field_id( 'header_scripts' ); ?>" cols="78" rows="8"><?php echo esc_textarea( $this->get_field_value( 'header_scripts' ) ); ?></textarea>
                      <link rel="stylesheet" href="<?php echo EXMACHINA_ADMIN_VENDOR . '/codemirror/css/theme/monokai.min.css'; ?>">
                      <script>
                        jQuery(document).ready(function($){
                            var editor_header_scripts = CodeMirror.fromTextArea(document.getElementById('<?= $this->get_field_id( 'header_scripts' );?>'), {
                                lineNumbers: true,
                                tabmode: 'indent',
                                mode: 'htmlmixed',
                                theme: 'monokai'
                            });
                        });
                      </script>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><?php printf( __( 'The %1$s hook executes immediately before the closing %2$s tag in the document source.', 'exmachina-core' ), exmachina_code( 'wp_head()' ), exmachina_code( '</head>' ) ); ?></p>
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <legend><?php _e( 'Footer Scripts', 'exmachina-core' ); ?></legend>
                  <p class="uk-margin-top-remove"><label for="<?php echo $this->get_field_id( 'footer_scripts' ); ?>"><?php printf( __( 'Enter scripts or code you would like output to %s:', 'exmachina-core' ), exmachina_code( 'wp_footer()' ) ); ?></label></p>
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <textarea class="input-block-level vertical-resize code exmachina-code-area" name="<?php echo $this->get_field_name( 'footer_scripts' ); ?>" id="<?php echo $this->get_field_id( 'footer_scripts' ); ?>" cols="78" rows="8"><?php echo esc_textarea( $this->get_field_value( 'footer_scripts' ) ); ?></textarea>
                      <link rel="stylesheet" href="<?php echo EXMACHINA_ADMIN_VENDOR . '/codemirror/css/theme/monokai.min.css'; ?>">
                      <script>
                        jQuery(document).ready(function($){
                            var editor_header_scripts = CodeMirror.fromTextArea(document.getElementById('<?= $this->get_field_id( 'footer_scripts' );?>'), {
                                lineNumbers: true,
                                tabmode: 'indent',
                                mode: 'htmlmixed',
                                theme: 'monokai'
                            });
                        });
                      </script>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><?php printf( __( 'The %1$s hook executes immediately before the closing %2$s tag in the document source.', 'exmachina-core' ), exmachina_code( 'wp_footer()' ), exmachina_code( '</body>' ) ); ?></p>
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_scripts()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Footer Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Footer Settings Metabox Display
   *
   * Callback to display the 'Footer Settings' metabox. Creates a metabox for
   * the theme settings page, which holds a textarea for custom footer text within
   * the theme.
   *
   * Settings:
   * ~~~~~~~~~
   * 'footer_insert'
   *
   * To use this feature, the theme must support the 'footer' argument
   * for the 'exmachina-core-theme-settings' feature.
   *
   * @todo Add header info content
   * @todo Add default footer insert content function
   *
   * @link http://codex.wordpress.org/Function_Reference/wp_editor
   * @link http://codex.wordpress.org/Function_Reference/esc_textarea
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_metabox_theme_display_footer() {
    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Header -->
        <thead>
          <tr>
            <td class="postbox-header info" colspan="2">
              <p><?php _e( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'exmachina-core' ); ?></p>
            </td><!-- .postbox-header -->
          </tr>
        </thead>
        <!-- End Table Header -->
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <p class="uk-margin-top-remove"><?php _e( 'You can add custom <abbr title="Hypertext Markup Language">HTML</abbr> and/or shortcodes, which will be automatically inserted into your theme.', 'exmachina-core' ); ?></p>
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <?php
                      /* Add a textarea using the wp_editor() function to make it easier on users to add custom content. */
                      wp_editor(
                        $this->get_field_value( 'footer_insert' ), // Editor content.
                        $this->get_field_id( 'footer_insert' ),    // Editor ID.
                        array(
                          'tinymce'       => false, // Don't use TinyMCE in a meta box.
                          'textarea_rows' => 5,     // Set the number of textarea rows.
                          'media_buttons' => false, // Don't display the media button.
                        ) );
                      ?>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                  <p class="uk-text-muted"><?php _e( 'Shortcodes and some <abbr title="Hypertext Markup Language">HTML</abbr> is allowed.', 'exmachina-core' ); ?></p>
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_footer()

  /*-------------------------------------------------------------------------*/
  /* Begin 'About' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * About Theme Metabox Display
   *
   * Callback to display the 'About Theme' metabox. Creates a meta box for the
   * theme settings page, which displays information about the theme. If a child
   * theme is in use, an additional meta box will be added with its information.
   *
   * Fields:
   * ~~~~~~~
   * none
   *
   * To use this feature, the theme must support the 'about' argument in the
   * 'exmachina-core-theme-settings' feature.
   *
   * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
   * @link http://codex.wordpress.org/Function_Reference/get_template
   *
   * @since 1.0.0
   * @access public
   *
   * @param  object $object Variable passed through the do_meta_boxes() call.
   * @param  array  $box    Specific information about the meta box being loaded.
   * @return void
   */
  function exmachina_metabox_theme_display_about( $object, $box ) {

    /* Grab theme information for the parent/child theme. */
    $theme = ( 'exmachina-core-about-child' == $box['id'] ) ? wp_get_theme() : wp_get_theme( get_template() );

    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <img class="uk-align-center uk-thumbnail uk-thumbnail-medium" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/screenshot.png' ); ?>" alt="<?php echo esc_attr( $theme->get( 'Name' ) ); ?>">
                      <dl class="uk-description-list uk-description-list-horizontal">
                        <dt class="uk-text-bold"><?php _e( 'Theme:', 'exmachina-core' ); ?></dt>
                        <dd><a href="<?php echo esc_url( $theme->get( 'ThemeURI' ) ); ?>" title="<?php echo esc_attr( $theme->get( 'Name' ) ); ?>"><?php echo $theme->get( 'Name' ); ?></a></dd>
                        <dt class="uk-text-bold"><?php _e( 'Author:', 'exmachina-core' ); ?></dt>
                        <dd><a href="<?php echo esc_url( $theme->get( 'AuthorURI' ) ); ?>" title="<?php echo esc_attr( $theme->get( 'Author' ) ); ?>"><?php echo $theme->get( 'Author' ); ?></a></dd>
                      </dl>
                      <dl class="uk-description-list">
                        <dt class="uk-text-bold"><?php _e( 'Description:', 'exmachina-core' ); ?></dt>
                        <dd><?php echo $theme->get( 'Description' ); ?></dd>
                      </dl>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_about()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Help Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Help Settings Metabox Display
   *
   * Callback to display the 'Help Settings' metabox. Creates a metabox on the
   * theme settings page which directs the user to a contextual help tabs.
   *
   * Fields:
   * ~~~~~~~
   * none
   *
   * To use this feature, the theme must support the 'help' argument in the
   * 'exmachina-core-theme-settings' feature.
   *
   * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
   *
   * @todo  create variable/function to get theme support answers.
   * @todo  add programatic link to help: http://wordpress.stackexchange.com/questions/10810/how-to-control-contextual-help-section-by-code
   *
   * @since 1.0.0
   * @access public
   *
   * @return void
   */
  function exmachina_metabox_theme_display_help() {

    /* Get theme information. */
    $theme = wp_get_theme();

    ?>
    <!-- Begin Markup -->
    <div class="postbox-inner-wrap">
      <table class="uk-table postbox-table">
        <!-- Begin Table Body -->
        <tbody>
          <tr>
            <td class="uk-width-1-1 postbox-fieldset">
              <div class="fieldset-wrap uk-margin uk-grid">
                <!-- Begin Fieldset -->
                <fieldset class="uk-form uk-width-1-1">
                  <div class="uk-form-row">
                    <div class="uk-form-controls">
                      <!-- Begin Form Inputs -->
                      <p class="help-block"><?php _e( 'Struggling with some of the theme options or settings? Click on the "Help" tab above.', 'exmachina-core' ); ?></p>
                      <p class="help-block"><?php echo sprintf( __( 'You can also visit the %s <a href="%s" target="_blank">support forum</a>', 'exmachina-core' ), $theme->{'Name'}, 'http://www.machinathemes.com/support/' ); ?></p>
                      <!-- End Form Inputs -->
                    </div><!-- .uk-form-controls -->
                  </div><!-- .uk-form-row -->
                </fieldset>
                <!-- End Fieldset -->
              </div><!-- .fieldset-wrap -->
            </td><!-- .postbox-fieldset -->
          </tr>
        </tbody>
        <!-- End Table Body -->
      </table>
    </div><!-- .postbox-inner-wrap -->
    <!-- End Markup -->
    <?php
  } // end function exmachina_metabox_theme_display_help()

} // end class ExMachina_Admin_Theme_Settings

add_action( 'exmachina_setup', 'exmachina_add_theme_settings_page' );
/**
 * Add Theme Settings Page
 *
 * Initializes a new instance of the ExMachina_Admin_Theme_Settings and adds
 * the Theme Settings Page.
 *
 * @todo move this to admin menu file
 *
 * @since 1.0.0
 */
function exmachina_add_theme_settings_page() {

  /* Globalize the $_exmachina_admin_theme_settings variable. */
  global $_exmachina_admin_theme_settings;

  /* Create a new instance of the ExMachina_Admin_Theme_Settings class. */
  $_exmachina_admin_theme_settings = new ExMachina_Admin_Theme_Settings;

  //* Set the old global pagehook var for backward compatibility (May not need this)
  global $_exmachina_admin_theme_settings_pagehook;
  $_exmachina_admin_theme_settings_pagehook = $_exmachina_admin_theme_settings->pagehook;

  do_action( 'exmachina_admin_menu' );

} // end function exmachina_add_theme_settings_page()