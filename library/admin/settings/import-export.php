<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Import/Export Settings
 *
 * import-export.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
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
 * Import/Export Settings Admin Subclass
 *
 * Registers a new admin page, providing content and corresponding menu item for
 * the Import/Export Settings page.
 *
 * @since 1.0.0
 */
class ExMachina_Admin_Import_Export extends ExMachina_Admin_Basic {

  /**
   * Import/Export Settings Class Constructor
   *
   * Creates an admin menu item and settings page. This constructor method defines
   * the page id, page title, and menu position. Also hooks in the handling of
   * file imports and exports.
   *
   * @link http://codex.wordpress.org/Function_Reference/wp_get_theme
   * @link http://codex.wordpress.org/Function_Reference/get_template
   * @link http://codex.wordpress.org/Function_Reference/get_theme_root
   * @link http://codex.wordpress.org/Function_Reference/get_template_directory
   *
   * @uses exmachina_get_prefix()
   * @uses \ExMachina_Admin::create()
   *
   * @todo prefix settings filters.
   * @todo add filters to page/menu titles
   * @todo maybe remove page_ops for defaults
   * @todo make sure nothing is using the import page id which orig was 'exmachina-import-export'
   *
   * @since 1.0.0
   */
  function __construct() {

    /* Get the theme prefix. */
    $prefix = exmachina_get_prefix();

    /* Get theme information. */
    $theme = wp_get_theme( get_template(), get_theme_root( get_template_directory() ) );

    /* Get menu titles. */
    $menu_title = __( 'Import/Export', 'exmachina-core' );
    $page_title = sprintf( esc_html__( '%1s %2s', 'exmachina-core' ), $theme->get( 'Name' ), $menu_title );

    /* Specify the unique page id. */
    $page_id = 'import-export';

    /* Define page titles and menu position. Can be filtered using 'exmachina_import_export_settings_menu_ops'. */
    $menu_ops = apply_filters(
      'exmachina_import_export_settings_menu_ops',
      array(
        'submenu' => array(
          'parent_slug' => 'theme-settings',
          'page_title'  => $page_title,
          'menu_title'  => $menu_title,
          'capability'  => 'edit_theme_options',
        ),
      )
    ); // end $menu_ops

    /* Create the admin page. */
    $this->create( $page_id, $menu_ops );

    /* Add import and export actions. */
    add_action( 'admin_init', array( $this, 'export' ) );
    add_action( 'admin_init', array( $this, 'import' ) );

  } // end function __construct()

  /**
   * Import/Export Settings Help Tabs
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


    /* Add the 'Import/Export' help content. */
    $general_settings_help =
      '<h3>' . __( 'Import/Export', 'exmachina-core' ) . '</h3>' .
      '<p>'  . __( 'This allows you to import or export ExMachina Settings.', 'exmachina-core' ) . '</p>' .
      '<p>'  . __( 'This is specific to ExMachina settings and does not includes posts, pages, or images, which is what the built-in WordPress import/export menu does.', 'exmachina-core' ) . '</p>' .
      '<p>'  . __( 'It also does not include other settings for plugins, widgets, or post/page/term/user specific settings.', 'exmachina-core' ) . '</p>';

    /* Add the 'Import' help content. */
    $import_settings_help =
      '<h3>' . __( 'Import', 'exmachina-core' ) . '</h3>' .
      '<p>'  . sprintf( __( 'You can import a file you\'ve previously exported. The file name will start with %s followed by one or more strings indicating which settings it contains, finally followed by the date and time it was exported.', 'exmachina-core' ), exmachina_code( 'exmachina-' ) ) . '</p>' .
      '<p>' . __( 'Once you upload an import file, it will automatically overwrite your existing settings.', 'exmachina-core' ) . ' <strong>' . __( 'This cannot be undone', 'exmachina-core' ) . '</strong>.</p>';

    /* Add the 'Export' help content. */
    $export_settings_help =
      '<h3>' . __( 'Export', 'exmachina-core' ) . '</h3>' .
      '<p>'  . sprintf( __( 'You can export your ExMachina-related settings to back them up, or copy them to another site. Child themes and plugins may add their own checkboxes to the list. The settings are exported in %s format.', 'exmachina-core' ), '<abbr title="' . __( 'JavaScript Object Notation', 'exmachina-core' ) . '">' . __( 'JSON', 'exmachina-core' ) . '</abbr>' ) . '</p>';

    /* Adds the 'Import/Export' help tab. */
    $screen->add_help_tab( array(
      'id'      => $this->pagehook . '-general-settings',
      'title'   => __( 'Import/Export', 'exmachina-core' ),
      'content' => $general_settings_help,
    ) );
    /* Adds the 'Import' help tab. */
    $screen->add_help_tab( array(
      'id'      => $this->pagehook . '-import',
      'title'   => __( 'Import', 'exmachina-core' ),
      'content' => $import_settings_help,
    ) );
    /* Adds the 'Export' help tab. */
    $screen->add_help_tab( array(
      'id'      => $this->pagehook . '-export',
      'title'   => __( 'Export', 'exmachina-core' ),
      'content' => $export_settings_help,
    ) );

    /* Adds help sidebar content. */
    $screen->set_help_sidebar(
      $template_help
    );

    /* Trigger the help content action hook. */
    do_action( 'exmachina_import_export_settings_help', $this->pagehook );

  } // end function settings_page_help()

  /**
   * Callback for displaying the ExMachina Import / Export admin page.
   *
   * Call the exmachina_import_export_form action after the last default table row.
   *
   * @todo docblock comment
   * @todo cleanup markup
   * @todo cleanup css
   *
   * @since 1.0.0
   *
   * @uses \ExMachina_Admin_Import_Export::export_checkboxes()  Echo export checkboxes.
   * @uses \ExMachina_Admin_Import_Export::get_export_options() Get array of export options.
   */
  public function settings_page() {
    ?>
    <?php do_action( $this->pagehook . '_before_settings_page', $this->pagehook ); ?>

    <div class="wrap exmachina-metaboxes">

      <?php screen_icon( $this->page_ops['screen_icon'] ); ?>

      <h2>
        <?php echo esc_html( get_admin_page_title() ); ?>
      </h2>

      <?php settings_errors( $this->pagehook . '-notices' ); ?>

      <div class="exmachina-core-settings-wrap">
      <div class="wp-box">
      <div class="title">
        <h3><i class="uk-icon-cloud-download"></i> Import/Export Settings</h3>
      </div><!-- .title -->
      <table class="acf_input widefat">
        <tbody>

          <tr>
            <td class="label" scope="row">
              <label><?php _e( 'Import ExMachina Settings File', 'exmachina-core' ); ?></label>
              </td>
            <td>
              <p><?php printf( __( 'Upload the data file (%s) from your computer and we\'ll import your settings.', 'exmachina-core' ), exmachina_code( '.json' ) ); ?></p>
              <p><?php _e( 'Choose the file from your computer and click "Upload file and Import"', 'exmachina-core' ); ?></p>
              <p>
                <form enctype="multipart/form-data" method="post" action="<?php echo menu_page_url( 'exmachina-import-export', 0 ); ?>">
                  <?php wp_nonce_field( 'exmachina-import' ); ?>
                  <input type="hidden" name="exmachina-import" value="1" />
                  <label for="exmachina-import-upload"><?php sprintf( __( 'Upload File: (Maximum Size: %s)', 'exmachina-core' ), ini_get( 'post_max_size' ) ); ?></label>
                  <input type="file" id="exmachina-import-upload" name="exmachina-import-upload" size="25" />
                  <?php
                  submit_button( __( 'Upload File and Import', 'exmachina-core' ), 'primary', 'upload', false );
                  ?>
                </form>
              </p>
            </td>
          </tr>

          <tr>
            <td class="label" scope="row">
            <label><?php _e( 'Export ExMachina Settings File', 'exmachina-core' ); ?></label></td>
            <td>
              <p><?php printf( __( 'When you click the button below, ExMachina will generate a data file (%s) for you to save to your computer.', 'exmachina-core' ), exmachina_code( '.json' ) ); ?></p>
              <p><?php _e( 'Once you have saved the download file, you can use the import function on another site to import this data.', 'exmachina-core' ); ?></p>
              <p>
                <form method="post" action="<?php echo menu_page_url( 'exmachina-import-export', 0 ); ?>">
                  <?php
                  wp_nonce_field( 'exmachina-export' );
                  $this->export_checkboxes();
                  if ( $this->get_export_options() )
                    submit_button( __( 'Download Export File', 'exmachina-core' ), 'primary', 'download' );
                  ?>
                </form>
              </p>
            </td>
          </tr>

          <?php do_action( 'exmachina_import_export_form' ); ?>

        </tbody>
      </table>
      </div><!-- .wp-box -->

      </div><!-- .exmachina-core-settings-wrap -->

    </div><!-- .wrap .exmachina-metaboxes -->

    <?php do_action( $this->pagehook . '_after_settings_page', $this->pagehook ); ?>
    <?php
  } // end function settings_page()

  /**
   * Import/Export Page Notices
   *
   * Adds custom notices that display after successfully importing or exporting
   * the settings from the page.
   *
   * @todo switch settings errors
   * @todo maybe change succes to green (???)
   *
   * @uses exmachina_is_menu_page() [description]
   *
   * @since 1.0.0
   * @access public
   *
   * @return null Returns early if not on the Import/Export page.
   */
  public function notices() {

    /* Return early if not on the Import/Export page. */
    if ( ! exmachina_is_menu_page( 'import-export' ) )
      return;

    /* Display the import success notice. */
    if ( isset( $_REQUEST['imported'] ) && 'true' === $_REQUEST['imported'] )
      echo '<div id="message" class="updated"><p><strong>' . __( 'Settings successfully imported.', 'exmachina-core' ) . '</strong></p></div>';
      //add_settings_error( $this->pagehook . '-notices', 'exmachina-settings-updated', __( 'Settings successfully imported.', 'exmachina-core' ), 'updated fade in' );

    /* Display the import error notice. */
    elseif ( isset( $_REQUEST['error'] ) && 'true' === $_REQUEST['error'] )
      echo '<div id="message" class="error"><p><strong>' . __( 'There was a problem importing your settings. Please try again.', 'exmachina-core' ) . '</strong></p></div>';
      //add_settings_error( $this->pagehook . '-notices', 'exmachina-settings-error', __( 'There was a problem importing your settings. Please try again.', 'exmachina-core' ), 'error' );

  } // end function notices()

  /**
   * Get Export Options
   *
   * Return array of export options and their arguments.
   *
   * Plugins and themes can hook into the exmachina_export_options filter to add
   * their own settings to the exporter.
   *
   * @todo docblock comment
   * @todo add conditional for more export settings
   *
   * @since 1.0.0
   * @access protected
   *
   * @return array $options Export options
   */
  protected function get_export_options() {

    $options = array(
      'theme' => array(
        'label'          => __( 'Theme Settings', 'exmachina-core' ),
        'settings-field' => EXMACHINA_SETTINGS_FIELD,
      ),
      'content' => array(
        'label' => __( 'Content Settings', 'exmachina-core' ),
        'settings-field' => EXMACHINA_CONTENT_SETTINGS_FIELD,
      ),
      'hooks' => array(
        'label' => __( 'Hook Settings', 'exmachina-core' ),
        'settings-field' => EXMACHINA_HOOK_SETTINGS_FIELD,
      ),
      'seo' => array(
        'label' => __( 'SEO Settings', 'exmachina-core' ),
        'settings-field' => EXMACHINA_SEO_SETTINGS_FIELD,
      ),
    );

    return (array) apply_filters( 'exmachina_export_options', $options );

  } // end function get_export_options()

  /**
   * Export Checkboxes Markup
   *
   * Echo out the checkboxes for the export options.
   *
   * @todo check markup
   * @todo inline comment
   *
   * @uses \ExMachina_Admin_Import_Export::get_export_options() Get array of export options.
   *
   * @since 1.0.0
   * @access protected
   *
   * @return null Return null if there are no options to export.
   */
  protected function export_checkboxes() {

    if ( ! $options = $this->get_export_options() ) {
      //* Not even the ExMachina theme / seo export options were returned from the filter
      printf( '<p><em>%s</em></p>', __( 'No export options available.', 'exmachina-core' ) );
      return;
    }

    foreach ( $options as $name => $args ) {
      //* Ensure option item has an array key, and that label and settings-field appear populated
      if ( is_int( $name ) || ! isset( $args['label'] ) || ! isset( $args['settings-field'] ) || '' === $args['label'] || '' === $args['settings-field'] )
        return;

      printf( '<p><label for="exmachina-export-%1$s"><input id="exmachina-export-%1$s" name="exmachina-export[%1$s]" type="checkbox" value="1" /> %2$s</label></p>', esc_attr( $name ), esc_html( $args['label'] ) );

    }

  } // end function export_checkboxes()

  /**
   * Generate the export file, if requested, in JSON format.
   *
   * After checking we're on the right page, and trying to export, loop through the list of requested options to
   * export, grabbing the settings from the database, and building up a file name that represents that collection of
   * settings.
   *
   * A .json file is then sent to the browser, named with "exmachina" at the start and ending with the current
   * date-time.
   *
   * The exmachina_export action is fired after checking we can proceed, but before the array of export options are
   * retrieved.
   *
   * @todo inline comment
   * @todo docblock comment
   * @todo prefix options (???)
   *
   * @since 1.0.0
   *
   * @uses exmachina_is_menu_page()                             Check if we're on a ExMachina page.
   * @uses \ExMachina_Admin_Import_Export::get_export_options() Get array of export options.
   *
   * @return null Return null if not correct page, or we're not exporting.
   */
  public function export() {

    if ( ! exmachina_is_menu_page( 'import-export' ) )
      return;

    if ( empty( $_REQUEST['exmachina-export'] ) )
      return;

    check_admin_referer( 'exmachina-export' );

    do_action( 'exmachina_export', $_REQUEST['exmachina-export'] );

    $options = $this->get_export_options();

    $settings = array();

    //* Exported file name always starts with "exmachina"
    $prefix = array( 'exmachina-core' );

    //* Loop through set(s) of options
    foreach ( (array) $_REQUEST['exmachina-export'] as $export => $value ) {
      //* Grab settings field name (key)
      $settings_field = $options[$export]['settings-field'];

      //* Grab all of the settings from the database under that key
      $settings[$settings_field] = get_option( $settings_field );

      //* Add name of option set to build up export file name
      $prefix[] = $export;
    }

    if ( ! $settings )
      return;

    //* Complete the export file name by joining parts together
    $prefix = join( '-', $prefix );

      $output = json_encode( (array) $settings );

    //* Prepare and send the export file to the browser
      header( 'Content-Description: File Transfer' );
      header( 'Cache-Control: public, must-revalidate' );
      header( 'Pragma: hack' );
      header( 'Content-Type: text/plain' );
      header( 'Content-Disposition: attachment; filename="' . $prefix . '-' . date( 'Ymd-His' ) . '.json"' );
      header( 'Content-Length: ' . mb_strlen( $output ) );
      echo $output;
      exit;

  } // end function export()

  /**
   * Handle the file uploaded to import settings.
   *
   * Upon upload, the file contents are JSON-decoded. If there were errors, or no options to import, then reload the
   * page to show an error message.
   *
   * Otherwise, loop through the array of option sets, and update the data under those keys in the database.
   * Afterwards, reload the page with a success message.
   *
   * Calls exmachina_import action is fired after checking we can proceed, but before attempting to extract the contents
   * from the uploaded file.
   *
   * @todo docblock comment
   * @todo inline comment
   *
   * @uses exmachina_is_menu_page()   Check if we're on a ExMachina page
   * @uses exmachina_admin_redirect() Redirect user to an admin page
   *
   * @since 1.0.0
   *
   * @return null Return null if not correct admin page, we're not importing
   */
  public function import() {

    if ( ! exmachina_is_menu_page( 'import-export' ) )
      return;

    if ( empty( $_REQUEST['exmachina-import'] ) )
      return;

    check_admin_referer( 'exmachina-import' );

    do_action( 'exmachina_import', $_REQUEST['exmachina-import'], $_FILES['exmachina-import-upload'] );

    $upload = file_get_contents( $_FILES['exmachina-import-upload']['tmp_name'] );

    $options = json_decode( $upload, true );

    //* Check for errors
    if ( ! $options || $_FILES['exmachina-import-upload']['error'] ) {
      exmachina_admin_redirect( 'import-export', array( 'error' => 'true' ) );
      exit;
    }

    //* Identify the settings keys that we should import
    $exportables = $this->get_export_options();
    $importable_keys = array();
    foreach ( $exportables as $exportable ) {
      $importable_keys[] = $exportable['settings-field'];
    }

    //* Cycle through data, import ExMachina settings
    foreach ( (array) $options as $key => $settings ) {
      if ( in_array( $key, $importable_keys ) )
        update_option( $key, $settings );
    }

    //* Redirect, add success flag to the URI
    exmachina_admin_redirect( 'import-export', array( 'imported' => 'true' ) );
    exit;

  } // end function import()

} // end class ExMachina_Admin_Import_Export
