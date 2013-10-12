<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * SEO Settings
 *
 * seo-settings.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Handles the display and functionality of the seo settings page. This provides
 * the needed hooks and meta box calls to create any number of seo settings needed.
 * This file is only loaded if the theme supports the 'exmachina-core-seo-settings'
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
 * SEO Settings Admin Subclass
 *
 * Registers a new admin page, providing content and corresponding menu item for
 * the SEO Settings page.
 *
 * @since 1.0.0
 */
class ExMachina_Admin_SEO_Settings extends ExMachina_Admin_Metaboxes {

  /**
   * SEO Settings Class Constructor
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
   * @uses \ExMachina_Admin_SEO_Settings::sanitizer_filters()
   *
   * @todo prefix settings filters.
   * @todo add filters to page/menu titles
   * @todo maybe remove page_ops for defaults
   *
   * @since 1.0.0
   */
  function __construct() {

    /* Get the theme prefix. */
    $prefix = exmachina_get_prefix();

    /* Get theme information. */
    $theme = wp_get_theme( get_template(), get_theme_root( get_template_directory() ) );

    /* Get menu titles. */
    $menu_title = __( 'SEO Settings', 'exmachina-core' );
    $page_title = sprintf( esc_html__( '%1s %2s', 'exmachina-core' ), $theme->get( 'Name' ), $menu_title );

    /* Specify the unique page id. */
    $page_id = 'seo-settings';

    /* Define page titles and menu position. Can be filtered using 'exmachina_seo_settings_menu_ops'. */
    $menu_ops = apply_filters(
      'exmachina_seo_settings_menu_ops',
      array(
        'submenu' => array(
          'parent_slug' => 'theme-settings',
          'page_title'  => $page_title,
          'menu_title'  => $menu_title,
          'capability'  => 'edit_theme_options',
        ),
      )
    ); // end $menu_ops

    /* Define page options (notice text and screen icon). Can be filtered using 'exmachina_seo_settings_page_ops'. */
    $page_ops = apply_filters(
      'exmachina_seo_settings_page_ops',
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
    $settings_field = EXMACHINA_SEO_SETTINGS_FIELD;

    /* Define the default setting values. Can be filtered using 'exmachina_seo_settings_defaults'. */
    $default_settings = apply_filters(
      'exmachina_seo_settings_defaults',
      array(
        'append_description_home'      => 1,
        'append_site_title'            => 0,
        'doctitle_sep'                 => '–',
        'doctitle_seplocation'         => 'right',

        'semantic_headings'            => 1,
        'home_h1_on'                   => 'title',
        'home_doctitle'                => '',
        'home_description'             => '',
        'home_keywords'                => '',
        'home_noindex'                 => 0,
        'home_nofollow'                => 0,
        'home_noarchive'               => 0,
        'home_author'                  => 0,

        'canonical_archives'           => 1,

        'head_adjacent_posts_rel_link' => 0,
        'head_wlwmanifest_link'        => 0,
        'head_shortlink'               => 0,

        'noindex_cat_archive'          => 1,
        'noindex_tag_archive'          => 1,
        'noindex_author_archive'       => 1,
        'noindex_date_archive'         => 1,
        'noindex_search_archive'       => 1,
        'noarchive_cat_archive'        => 0,
        'noarchive_tag_archive'        => 0,
        'noarchive_author_archive'     => 0,
        'noarchive_date_archive'       => 0,
        'noarchive_search_archive'     => 0,
        'noarchive'                    => 0,
        'noodp'                        => 1,
        'noydir'                       => 1,
      )
    ); // end $default_settings

    /* Create the admin page. */
    $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

    /* Initialize the sanitization filter. */
    add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );

  } // end function __construct()

  /**
   * SEO Settings Sanitizer Filters
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
        'append_description_home',
        'append_site_title',
        'semantic_headings',
        'home_noindex',
        'home_nofollow',
        'home_noarchive',
        'head_adjacent_posts_rel_link',
        'head_wlwmanifest_link',
        'head_shortlink',
        'noindex_cat_archive',
        'noindex_tag_archive',
        'noindex_author_archive',
        'noindex_date_archive',
        'noindex_search_archive',
        'noarchive',
        'noarchive_cat_archive',
        'noarchive_tag_archive',
        'noarchive_author_archive',
        'noarchive_date_archive',
        'noarchive_search_archive',
        'noodp',
        'noydir',
        'canonical_archives',
    ) );

    /* Apply the positive integer sanitization filter. */
    exmachina_add_option_filter( 'absint', $this->settings_field,
      array(
        'home_author',
    ) );

    /* Apply the URL sanitization filter. */
    exmachina_add_option_filter( 'url', $this->settings_field,
      array(

    ) );

    /* Apply the no HTML sanitization filter. */
    exmachina_add_option_filter( 'no_html', $this->settings_field,
      array(
        'home_doctitle',
        'home_description',
        'home_keywords',
        'doctitle_sep',
    ) );

    /* Apply the safe HTML sanitization filter. */
    exmachina_add_option_filter( 'safe_html', $this->settings_field,
      array(

    ) );

    /* Apply the unfiltered HTML sanitiation filter. */
    exmachina_add_option_filter( 'requires_unfiltered_html', $this->settings_field,
      array(

    ) );



  } // end function sanitizer_filters()

  /**
   * SEO Settings Help Tabs
   *
   * Setup contextual help tabs content. This method adds the appropiate help
   * tabs based on the metaboxes/settings the theme supports.
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

    /* Add the 'Sample Help' help content. */
    $seo_settings_help =
      '<h3>' . __( 'SEO Settings', 'exmachina-core' ) . '</h3>' .
      '<p>' .  __( 'ExMachina SEO (search engine optimization) is polite, and will disable itself when most popular SEO plugins (e.g., All-in-One SEO, WordPress SEO, etc.) are active.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'If you don’t see an SEO Settings sub menu, then you probably have another SEO plugin active.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'If you see the menu, then opening that menu item will let you set the General SEO settings for your site.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'Each page, post, and term will have its own SEO settings as well. The default settings are recommended for most users. If you wish to adjust your SEO settings, the boxes include internal descriptions.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'Below you\'ll find a few succinct notes on the options for each box:', 'exmachina-core' ) . '</p>';

    /* Add the 'Sample Help' help content. */
    $doctitle_help =
      '<h3>' . __( 'Doctitle Settings', 'exmachina-core' ) . '</h3>' .
      '<p>' .  __( '<strong>Append Site Description</strong> will insert the site description from your General Settings after the title on your home page.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( '<strong>Append Site Name</strong> will put the site name from the General Settings after the title on inner page.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( '<strong>Doctitle Append Location</strong> determines which side of the title to add the previously mentioned items.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'The <strong>Doctitle Separator</strong> is the character that will go between the title and appended text.', 'exmachina-core' ) . '</p>';

    /* Add the 'Sample Help' help content. */
    $homepage_help =
      '<h3>' . __( 'Homepage Settings', 'exmachina-core' ) . '</h3>' .
      '<p>' .  __( 'These are the homepage specific SEO settings. Note: these settings will not apply if a static page is set as the front page. If you\'re using a static WordPress page as your hompage, you\'ll need to set the SEO settings on that particular page.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'You can also specify if the Site Title, Description, or your own custom text should be wrapped in an &lt;h1&gt; tag (the primary heading in HTML).', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'To add custom text you\'ll have to either edit a php file, or use a text widget on a widget enabled homepage.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'The home doctitle sets what will appear within the <title></title> tags (unseen in the browser) for the home page.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'The home META description and keywords fill in the meta tags for the home page. The META description is the short text blurb that appear in search engine results.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'Most search engines do not use Keywords at this time or give them very little consideration; however, it\'s worth using in case keywords are given greater consideration in the future and also to help guide your content. If the content doesn’t match with your targeted key words, then you may need to consider your content more carefully.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'The Homepage Robots Meta Tags tell search engines how to handle the homepage. Noindex means not to index the page at all, and it will not appear in search results. Nofollow means do not follow any links from this page and noarchive tells them not to make an archive copy of the page.', 'exmachina-core' ) . '</p>';

    /* Add the 'Sample Help' help content. */
    $dochead_help =
      '<h3>' . __( 'Document Head Settings', 'exmachina-core' ) . '</h3>' .
      '<p>' .  __( 'The Relationship Link Tags are tags added by WordPress that currently have no SEO value but slow your site load down. They\'re disabled by default, but if you have a specific need&#8212;for a plugin or other non typical use&#8212;then you can enable as needed here.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'You can also add support for Windows Live Writer if you use software that supports this and include a shortlink tag if this is required by any third party service.', 'exmachina-core' ) . '</p>';

    /* Add the 'Sample Help' help content. */
    $robots_help =
      '<h3>' . __( 'Robots Meta Settings', 'exmachina-core' ) . '</h3>' .
      '<p>' .  __( 'Noarchive and noindex are explained in the home settings. Here you can select what other parts of the site to apply these options to.', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'At least one archive should be indexed, but indexing multiple archives will typically result in a duplicate content penalization (multiple pages with identical content look manipulative to search engines).', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'For most sites either the home page or blog page (using the blog template) will serve as this index which is why the default is not to index categories, tags, authors, dates, or searches.', 'exmachina-core' ) . '</p>';

    /* Add the 'Sample Help' help content. */
    $seoarchives_help =
      '<h3>' . __( 'Archives Settings', 'exmachina-core' ) . '</h3>' .
      '<p>' .  __( 'Canonical links will point search engines to the front page of paginated content (search engines have to choose the “preferred link” when there is duplicate content on pages).', 'exmachina-core' ) . '</p>' .
      '<p>' .  __( 'This tells them “this is paged content and the first page starts here” and helps to avoid spreading keywords across multiple pages.', 'exmachina-core' ) . '</p>';

    /* Adds the 'Sample Help' help tab. */
    $screen->add_help_tab( array(
      'id'  => $this->pagehook . '-seo-settings',
      'title' => __( 'SEO Settings', 'exmachina-core' ),
      'content' => $seo_settings_help,
    ) );
    /* Adds the 'Sample Help' help tab. */
    $screen->add_help_tab( array(
      'id'  => $this->pagehook . '-doctitle',
      'title' => __( 'Doctitle Settings', 'exmachina-core' ),
      'content' => $doctitle_help,
    ) );
    /* Adds the 'Sample Help' help tab. */
    $screen->add_help_tab( array(
      'id'  => $this->pagehook . '-homepage',
      'title' => __( 'Homepage Settings', 'exmachina-core' ),
      'content' => $homepage_help,
    ) );
    /* Adds the 'Sample Help' help tab. */
    $screen->add_help_tab( array(
      'id'  => $this->pagehook . '-dochead',
      'title' => __( 'Document Head Settings', 'exmachina-core' ),
      'content' => $dochead_help,
    ) );
    /* Adds the 'Sample Help' help tab. */
    $screen->add_help_tab( array(
      'id'  => $this->pagehook . '-robots',
      'title' => __( 'Robots Meta Settings', 'exmachina-core' ),
      'content' => $robots_help,
    ) );
    /* Adds the 'Sample Help' help tab. */
    $screen->add_help_tab( array(
      'id'  => $this->pagehook . '-seo-archives',
      'title' => __( 'SEO Archives', 'exmachina-core' ),
      'content' => $seoarchives_help,
    ) );

    /* Adds help sidebar content. */
    $screen->set_help_sidebar(
      $template_help
    );

    /* Trigger the help content action hook. */
    do_action( 'exmachina_seo_settings_help', $this->pagehook );

  } // end function settings_page_help()

  /**
   * SEO Settings Load Metaboxes
   *
   * Registers metaboxes for the settings page. Metaboxes are only registered if
   * supported by the theme and the user capabilitiy allows it.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_meta_box
   * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
   * @link http://codex.wordpress.org/Function_Reference/get_theme_support
   *
   * @uses exmachina_get_prefix() Gets the theme prefix.
   * @uses \ExMachina_Admin_SEO_Settings::exmachina_metabox_theme_display_save()
   *
   * @todo prefix/add action hooks.
   * @todo inline comment
   *
   * @since 1.0.0
   */
  public function settings_page_load_metaboxes() {

    /* Get theme information. */
    $prefix = exmachina_get_prefix();
    $theme = wp_get_theme( get_template() );

    /* Register the 'Save Settings' metabox to the 'side' priority. */
    add_meta_box( 'exmachina-core-seo-settings-save', __( '<i class="uk-icon-save"></i> Save Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_seo_display_save' ), $this->pagehook, 'side', 'high' );

    add_meta_box( 'exmachina-core-seo-settings-doctitle', __( '<i class="uk-icon-cog"></i> Document Title Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_seo_display_doctitle' ), $this->pagehook, 'normal' );
    add_meta_box( 'exmachina-core-seo-settings-homepage', __( '<i class="uk-icon-cog"></i> Homepage Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_seo_display_homepage' ), $this->pagehook, 'normal' );
    add_meta_box( 'exmachina-core-seo-settings-dochead', __( '<i class="uk-icon-cog"></i> Document Head Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_seo_display_document_head' ), $this->pagehook, 'normal' );
    add_meta_box( 'exmachina-core-seo-settings-robots', __( '<i class="uk-icon-cog"></i> Robots Meta Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_seo_display_robots_meta' ), $this->pagehook, 'normal' );
    add_meta_box( 'exmachina-core-seo-settings-archives', __( '<i class="uk-icon-cog"></i> Archives Settings', 'exmachina-core' ), array( $this, 'exmachina_meta_box_seo_display_archives' ), $this->pagehook, 'normal' );

    /* Trigger the seo settings metabox action hook. */
    do_action( 'exmachina_seo_settings_metaboxes', $this->pagehook );

  } // end function settings_page_load_metaboxes()

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
  function exmachina_meta_box_seo_display_save() {
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
  } // end function exmachina_meta_box_seo_display_save()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Document Title' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Document Title Metabox Display
   *
   * Callback for SEO Settings Document Title meta box.
   *
   * Settings:
   * ~~~~~~~~~
   * 'TBD'
   *
   *
   * @todo Add header info content
   * @todo inline comment
   * @todo docblock comment
   * @todo cleanup metabox markup
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_meta_box_seo_display_doctitle() {
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

                <p><span class="description"><?php printf( __( 'The document title (%s) is the single most important element in your document source for <abbr title="Search engine optimization">SEO</abbr>. It succinctly informs search engines of what information is contained in the document. The title can, and should, be different on each page, but these options will help you control what it will look like by default.', 'exmachina-core' ), exmachina_code( '<title>' ) ); ?></span></p>

                <p><span class="description"><?php _e( '<strong>By default</strong>, the home page document title will contain the site title, the single post and page document titles will contain the post or page title, the archive pages will contain the archive type, etc.', 'exmachina-core' ); ?></span></p>

                <p>
                  <label for="<?php echo $this->get_field_id( 'append_description_home' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'append_description_home' ); ?>" id="<?php echo $this->get_field_id( 'append_description_home' ); ?>" value="1" <?php checked( $this->get_field_value( 'append_description_home' ) ); ?> />
                  <?php printf( __( 'Add site description (tagline) to %s on home page?', 'exmachina-core' ), exmachina_code( '<title>' ) ); ?></label>
                </p>

                <p>
                  <label for="<?php echo $this->get_field_id( 'append_site_title' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'append_site_title' ); ?>" id="<?php echo $this->get_field_id( 'append_site_title' ); ?>" value="1" <?php checked( $this->get_field_value( 'append_site_title' ) ); ?> />
                  <?php printf( __( 'Add site name to %s on inner pages?', 'exmachina-core' ), exmachina_code( '<title>' ) ); ?> </label>
                </p>

                <fieldset>
                  <legend><?php _e( 'Document Title Additions Location:', 'exmachina-core' ); ?></legend>
                  <span class="description"><?php _e( 'Determines which side the added title text will go on.', 'exmachina-core' ); ?></span>

                  <p>
                    <input type="radio" name="<?php echo $this->get_field_name( 'doctitle_seplocation' ); ?>" id="<?php echo $this->get_field_id( 'doctitle_seplocation_left' ); ?>" value="left" <?php checked( $this->get_field_value( 'doctitle_seplocation' ), 'left' ); ?> />
                    <label for="<?php echo $this->get_field_id( 'doctitle_seplocation_left' ); ?>"><?php _e( 'Left', 'exmachina-core' ); ?></label>
                    <br />
                    <input type="radio" name="<?php echo $this->get_field_name( 'doctitle_seplocation' ); ?>" id="<?php echo $this->get_field_id( 'doctitle_seplocation_right' ); ?>" value="right" <?php checked( $this->get_field_value( 'doctitle_seplocation' ), 'right' ); ?> />
                    <label for="<?php echo $this->get_field_id( 'doctitle_seplocation_right' ); ?>"><?php _e( 'Right', 'exmachina-core' ); ?></label>
                  </p>
                </fieldset>

                <p>
                  <label for="<?php echo $this->get_field_id( 'doctitle_sep' ); ?>"><?php _e( 'Document Title Separator:', 'exmachina-core' ); ?></label>
                  <input type="text" name="<?php echo $this->get_field_name( 'doctitle_sep' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'doctitle_sep' ) ); ?>" size="15" /><br />
                  <span class="description"><?php _e( 'If the title consists of two parts (original title and optional addition), then the separator will go in between them.', 'exmachina-core' ); ?></span>
                </p>

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
  } // end function exmachina_meta_box_seo_display_doctitle()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Homepage Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Homepage Settings Metabox Display
   *
   * Callback for SEO Settings Homepage Settings meta box.
   *
   * Settings:
   * ~~~~~~~~~
   * 'TBD'
   *
   *
   * @todo Add header info content
   * @todo inline comment
   * @todo docblock comment
   * @todo cleanup metabox markup
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_meta_box_seo_display_homepage() {
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

                  <p>
                    <label for="<?php echo $this->get_field_id( 'semantic_headings' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'semantic_headings' ); ?>" id="<?php echo $this->get_field_id( 'semantic_headings' ); ?>" value="1" <?php checked( $this->get_field_value( 'semantic_headings' ) ); ?> />
                    <?php _e( 'Use semantic HTML5 page and section headings throughout site?', 'exmachina-core' ); ?></label>
                  </p>

                  <p><span class="description"><?php printf( __( 'HTML5 allows for multiple %s tags throughout the document source, provided they are the primary title for the section in which they appear. However, following this standard may have a marginal negative impact on SEO.', 'exmachina-core' ), exmachina_code( 'h1' ) ); ?></span></p>


                  <fieldset id="exmachina_seo_h1_wrap">
                    <legend><?php printf( __( 'Which text would you like to be wrapped in %s tags?', 'exmachina-core' ), exmachina_code( 'h1' ) ); ?></legend>

                    <p>
                      <input type="radio" name="<?php echo $this->get_field_name( 'home_h1_on' ); ?>" id="<?php echo $this->get_field_id( 'home_h1_on_title' ); ?>" value="title" <?php checked( $this->get_field_value( 'home_h1_on' ), 'title' ); ?> />
                      <label for="<?php echo $this->get_field_id( 'home_h1_on_title' ); ?>"><?php _e( 'Site Title', 'exmachina-core' ); ?></label>
                      <br />
                      <input type="radio" name="<?php echo $this->get_field_name( 'home_h1_on' ); ?>" id="<?php echo $this->get_field_id( 'home_h1_on_description' ); ?>" value="description" <?php checked( $this->get_field_value( 'home_h1_on' ), 'description' ); ?> />
                      <label for="<?php echo $this->get_field_id( 'home_h1_on_description' ); ?>"><?php _e( 'Site Description (Tagline)', 'exmachina-core' ); ?></label>
                      <br />
                      <input type="radio" name="<?php echo $this->get_field_name( 'home_h1_on' ); ?>" id="<?php echo $this->get_field_id( 'home_h1_on_neither' ); ?>" value="neither" <?php checked( $this->get_field_value( 'home_h1_on' ), 'neither' ); ?> />
                      <label for="<?php echo $this->get_field_id( 'home_h1_on_neither' ); ?>"><?php _e( 'Neither. I\'ll manually wrap my own text on the homepage', 'exmachina-core' ); ?></label>
                    </p>
                  </fieldset>

                  <p>
                    <label for="<?php echo $this->get_field_id( 'home_doctitle' ); ?>"><?php _e( 'Homepage Document Title:', 'exmachina-core' ); ?></label><br />
                    <input type="text" name="<?php echo $this->get_field_name( 'home_doctitle' ); ?>" id="<?php echo $this->get_field_id( 'home_doctitle' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'home_doctitle' ) ); ?>" size="80" /><br />
                    <span class="description"><?php _e( 'If you leave the document title field blank, your site&#8217;s title will be used instead.', 'exmachina-core' ); ?></span>
                  </p>

                  <p>
                    <label for="<?php echo $this->get_field_id( 'home_description' ); ?>"><?php _e( 'Home Meta Description:', 'exmachina-core' ); ?></label><br />
                    <textarea name="<?php echo $this->get_field_name( 'home_description' ); ?>" id="<?php echo $this->get_field_id( 'home_description' ); ?>" rows="3" cols="70"><?php echo esc_textarea( $this->get_field_value( 'home_description' ) ); ?></textarea><br />
                    <span class="description"><?php _e( 'The meta description can be used to determine the text used under the title on search engine results pages.', 'exmachina-core' ); ?></span>
                  </p>

                  <p>
                    <label for="<?php echo $this->get_field_id( 'home_keywords' ); ?>"><?php _e( 'Home Meta Keywords (comma separated):', 'exmachina-core' ); ?></label><br />
                    <input type="text" name="<?php echo $this->get_field_name( 'home_keywords' ); ?>" id="<?php echo $this->get_field_id( 'home_keywords' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'home_keywords' ) ); ?>" size="80" /><br />
                    <span class="description"><?php _e( 'Keywords are generally ignored by Search Engines.', 'exmachina-core' ); ?></span>
                  </p>

                  <h4><?php _e( 'Homepage Robots Meta Tags:', 'exmachina-core' ); ?></h4>

                  <p>
                    <label for="<?php echo $this->get_field_id( 'home_noindex' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'home_noindex' ); ?>" id="<?php echo $this->get_field_id( 'home_noindex' ); ?>" value="1" <?php checked( $this->get_field_value( 'home_noindex' ) ); ?> />
                    <?php printf( __( 'Apply %s to the homepage?', 'exmachina-core' ), exmachina_code( 'noindex' ) ); ?></label>
                    <br />
                    <label for="<?php echo $this->get_field_id( 'home_nofollow' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'home_nofollow' ); ?>" id="<?php echo $this->get_field_id( 'home_nofollow' ); ?>" value="1" <?php checked( $this->get_field_value( 'home_nofollow' ) ); ?> />
                    <?php printf( __( 'Apply %s to the homepage?', 'exmachina-core' ), exmachina_code( 'nofollow' ) ); ?></label>
                    <br />
                    <label for="<?php echo $this->get_field_id( 'home_noarchive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'home_noarchive' ); ?>" id="<?php echo $this->get_field_id( 'home_noarchive' ); ?>" value="1" <?php checked( $this->get_field_value( 'home_noarchive' ) ); ?> />
                    <?php printf( __( 'Apply %s to the homepage?', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?></label>
                  </p>

                  <h4><?php _e( 'Homepage Author', 'exmachina-core' ); ?></h4>

                  <p>
                    <span class="description"><?php printf( __( 'Select the user that you would like to be used as the %s for the homepage. Be sure the user you select has entered their Google+ profile address on the profile edit screen.', 'exmachina-core' ), exmachina_code( 'rel="author"' ) ); ?></span>
                  </p>
                  <p>
                    <?php
                    wp_dropdown_users( array(
                      'show_option_none' => __( 'Select User', 'exmachina-core' ),
                      'selected' => $this->get_field_value( 'home_author' ),
                      'name' => $this->get_field_name( 'home_author' ),
                    ) );
                    ?>
                  </p>

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
  } // end function exmachina_meta_box_seo_display_homepage()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Document Head Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Document Head Settings Metabox Display
   *
   * Callback for SEO Settings Document Head Settings meta box.
   *
   * Settings:
   * ~~~~~~~~~
   * 'TBD'
   *
   *
   * @todo Add header info content
   * @todo inline comment
   * @todo docblock comment
   * @todo cleanup metabox markup
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_meta_box_seo_display_document_head() {
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

                  <p><span class="description"><?php printf( __( 'By default, WordPress places several tags in your document %1$s. Most of these tags are completely unnecessary, and provide no <abbr title="Search engine optimization">SEO</abbr> value whatsoever; they just make your site slower to load. Choose which tags you would like included in your document %1$s. If you do not know what something is, leave it unchecked.', 'exmachina-core' ), exmachina_code( '<head>' ) ); ?></span></p>

                  <h4><?php _e( 'Relationship Link Tags:', 'exmachina-core' ); ?></h4>

                  <p>
                    <label for="<?php echo $this->get_field_id( 'head_adjacent_posts_rel_link' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'head_adjacent_posts_rel_link' ); ?>" id="<?php echo $this->get_field_id( 'head_adjacent_posts_rel_link' ); ?>" value="1" <?php checked( $this->get_field_value( 'head_adjacent_posts_rel_link' ) ); ?> />
                    <?php printf( __( 'Adjacent Posts %s link tags', 'exmachina-core' ), exmachina_code( 'rel' ) ); ?></label>
                  </p>

                  <h4><?php _e( 'Windows Live Writer Support:', 'exmachina-core' ); ?></h4>

                  <p>
                    <label for="<?php echo $this->get_field_id( 'head_wlmanifest_link' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'head_wlwmanifest_link' ); ?>" id="<?php echo $this->get_field_id( 'head_wlmanifest_link' ); ?>" value="1" <?php checked( $this->get_field_value( 'head_wlwmanifest_link' ) ); ?> />
                    <?php printf( __( 'Include Windows Live Writer Support Tag?', 'exmachina-core' ) ); ?></label>
                  </p>

                  <h4><?php _e( 'Shortlink Tag:', 'exmachina-core' ); ?></h4>

                  <p>
                    <label for="<?php echo $this->get_field_id( 'head_shortlink' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'head_shortlink' ); ?>" id="<?php echo $this->get_field_id( 'head_shortlink' ); ?>" value="1" <?php checked( $this->get_field_value( 'head_shortlink' ) ); ?> />
                    <?php printf( __( 'Include Shortlink tag?', 'exmachina-core' ) ); ?></label>
                  </p>
                  <p>
                    <span class="description"><?php _e( '<span class="exmachina-admin-note">Note:</span> The shortlink tag might have some use for 3rd party service discoverability, but it has no <abbr title="Search engine optimization">SEO</abbr> value whatsoever.', 'exmachina-core' ); ?></span>
                  </p>

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
  } // end function exmachina_meta_box_seo_display_document_head()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Robots Meta Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Robots Meta Settings Metabox Display
   *
   * Callback for SEO Settings Robots Meta Settings meta box.
   *
   * Settings:
   * ~~~~~~~~~
   * 'TBD'
   *
   *
   * @todo Add header info content
   * @todo inline comment
   * @todo docblock comment
   * @todo cleanup metabox markup
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_meta_box_seo_display_robots_meta() {
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

                  <p><span class="description"><?php _e( 'Depending on your situation, you may or may not want the following archive pages to be indexed by search engines. Only you can make that determination.', 'exmachina-core' ); ?></span></p>

                  <p>
                    <label for="<?php echo $this->get_field_id( 'noindex_cat_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex_cat_archive' ); ?>" id="<?php echo $this->get_field_id( 'noindex_cat_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex_cat_archive' ) ); ?> />
                    <?php printf( __( 'Apply %s to Category Archives?', 'exmachina-core' ), exmachina_code( 'noindex' ) ); ?></label>
                    <br />
                    <label for="<?php echo $this->get_field_id( 'noindex_tag_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex_tag_archive' ); ?>" id="<?php echo $this->get_field_id( 'noindex_tag_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex_tag_archive' ) ); ?> />
                    <?php printf( __( 'Apply %s to Tag Archives?', 'exmachina-core' ), exmachina_code( 'noindex' ) ); ?></label>
                    <br />
                    <label for="<?php echo $this->get_field_id( 'noindex_author_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex_author_archive' ); ?>" id="<?php echo $this->get_field_id( 'noindex_author_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex_author_archive' ) ); ?> />
                    <?php printf( __( 'Apply %s to Author Archives?', 'exmachina-core' ), exmachina_code( 'noindex' ) ); ?></label>
                    <br />
                    <label for="<?php echo $this->get_field_id( 'noindex_date_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex_date_archive' ); ?>" id="<?php echo $this->get_field_id( 'noindex_date_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex_date_archive' ) ); ?> />
                    <?php printf( __( 'Apply %s to Date Archives?', 'exmachina-core' ), exmachina_code( 'noindex' ) ); ?></label>
                    <br />
                    <label for="<?php echo $this->get_field_id( 'noindex_search_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex_search_archive' ); ?>" id="<?php echo $this->get_field_id( 'noindex_search_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex_search_archive' ) ); ?> />
                    <?php printf( __( 'Apply %s to Search Archives?', 'exmachina-core' ), exmachina_code( 'noindex' ) ); ?></label>
                  </p>

                  <p><span class="description"><?php printf( __( 'Some search engines will cache pages in your site (e.g. Google Cache). The %1$s tag will prevent them from doing so. Choose which archives you want %1$s applied to.', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?></span></p>

                  <p>
                    <label for="<?php echo $this->get_field_id( 'noarchive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive' ) ); ?> />
                    <?php printf( __( 'Apply %s to Entire Site?', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?></label>
                  </p>

                  <p>
                    <label for="<?php echo $this->get_field_id( 'noarchive_cat_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive_cat_archive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive_cat_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive_cat_archive' ) ); ?> />
                    <?php printf( __( 'Apply %s to Category Archives?', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?></label>
                    <br />
                    <label for="<?php echo $this->get_field_id( 'noarchive_tag_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive_tag_archive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive_tag_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive_tag_archive' ) ); ?> />
                    <?php printf( __( 'Apply %s to Tag Archives?', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?></label>
                    <br />
                    <label for="<?php echo $this->get_field_id( 'noarchive_author_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive_author_archive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive_author_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive_author_archive' ) ); ?> />
                    <?php printf( __( 'Apply %s to Author Archives?', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?></label>
                    <br />
                    <label for="<?php echo $this->get_field_id( 'noarchive_date_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive_date_archive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive_date_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive_date_archive' ) ); ?> />
                    <?php printf( __( 'Apply %s to Date Archives?', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?></label>
                    <br />
                    <label for="<?php echo $this->get_field_id( 'noarchive_search_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive_search_archive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive_search_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive_search_archive' ) ); ?> />
                    <?php printf( __( 'Apply %s to Search Archives?', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?></label>
                  </p>

                  <p><span class="description"><?php printf( __( 'Occasionally, search engines use resources like the Open Directory Project and the Yahoo! Directory to find titles and descriptions for your content. Generally, you will not want them to do this. The %s and %s tags prevent them from doing so.', 'exmachina-core' ), exmachina_code( 'noodp' ), exmachina_code( 'noydir' ) ); ?></span></p>

                  <p>
                    <label for="<?php echo $this->get_field_id( 'noodp' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noodp' ); ?>" id="<?php echo $this->get_field_id( 'noodp' ); ?>" value="1" <?php checked( $this->get_field_value( 'noodp' ) ); ?> />
                    <?php printf( __( 'Apply %s to your site?', 'exmachina-core' ), exmachina_code( 'nooodp' ) ) ?></label>
                    <br />
                    <label for="<?php echo $this->get_field_id( 'noydir' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noydir' ); ?>" id="<?php echo $this->get_field_id( 'noydir' ); ?>" value="1" <?php checked( $this->get_field_value( 'noydir' ) ); ?> />
                    <?php printf( __( 'Apply %s to your site?', 'exmachina-core' ), exmachina_code( 'noydir' ) ) ?></label>
                  </p>

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
  } // end function exmachina_meta_box_seo_display_robots_meta()

  /*-------------------------------------------------------------------------*/
  /* Begin 'Archives Settings' metabox display. */
  /*-------------------------------------------------------------------------*/

  /**
   * Archives Settings Metabox Display
   *
   * Callback for SEO Settings Archives Settings meta box.
   *
   * Settings:
   * ~~~~~~~~~
   * 'TBD'
   *
   *
   * @todo Add header info content
   * @todo inline comment
   * @todo docblock comment
   * @todo cleanup metabox markup
   *
   * @uses \ExMachina_Admin::get_field_id()    Construct field ID.
   * @uses \ExMachina_Admin::get_field_name()  Construct field name.
   * @uses \ExMachina_Admin::get_field_value() Retrieve value of key under $this->settings_field.
   *
   * @since 1.0.0
   */
  function exmachina_meta_box_seo_display_archives() {
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

                  <p>
                    <label for="<?php echo $this->get_field_id( 'canonical_archives' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'canonical_archives' ); ?>" id="<?php echo $this->get_field_id( 'canonical_archives' ); ?>" value="1" <?php checked( $this->get_field_value( 'canonical_archives' ) ); ?> />
                    <?php printf( __( 'Canonical Paginated Archives', 'exmachina-core' ) ); ?></label>
                  </p>
                  <p>
                    <span class="description"><?php _e( 'This option points search engines to the first page of an archive, if viewing a paginated page. If you do not know what this means, leave it on.', 'exmachina-core' ); ?></span>
                  </p>

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
  } // end function exmachina_meta_box_seo_display_archives()

} // end class ExMachina_Admin_SEO_Settings
