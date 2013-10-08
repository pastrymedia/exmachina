<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Import/Export
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
 * @subpackage  Admin Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/**
 * Register a new admin page, providing content and corresponding menu item for the Import / Export page.
 *
 * Although this class was added in 1.8.0, some of the methods were originally standalone functions added in previous
 * versions of ExMachina.
 *
 * @package ExMachina\Admin
 *
 * @since 1.8.0
 */
class ExMachina_Admin_Import_Export extends ExMachina_Admin_Basic {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * Also hook in the handling of file imports and exports.
	 *
	 * @since 1.8.0
	 *
	 * @uses \ExMachina_Admin::create() Create an admin menu item and settings page.
	 *
	 * @see \ExMachina_Admin_Import_Export::export() Handle settings file exports.
	 * @see \ExMachina_Admin_Import_Export::import() Handle settings file imports.
	 */
	public function __construct() {

		$page_id = 'exmachina-import-export';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'exmachina',
				'page_title'  => __( 'ExMachina - Import/Export', 'exmachina' ),
				'menu_title'  => __( 'Import/Export', 'exmachina' )
			)
		);

		$this->create( $page_id, $menu_ops );

		add_action( 'admin_init', array( $this, 'export' ) );
		add_action( 'admin_init', array( $this, 'import' ) );

	}

	/**
	 * Contextual help content.
	 *
	 * @since 2.0.0
	 */
	public function settings_page_help() {

		$screen = get_current_screen();

		$general_settings_help =
			'<h3>' . __( 'Import/Export', 'exmachina' ) . '</h3>' .
			'<p>'  . __( 'This allows you to import or export ExMachina Settings.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'This is specific to ExMachina settings and does not includes posts, pages, or images, which is what the built-in WordPress import/export menu does.', 'exmachina' ) . '</p>' .
			'<p>'  . __( 'It also does not include other settings for plugins, widgets, or post/page/term/user specific settings.', 'exmachina' ) . '</p>';

		$import_settings_help =
			'<h3>' . __( 'Import', 'exmachina' ) . '</h3>' .
			'<p>'  . sprintf( __( 'You can import a file you\'ve previously exported. The file name will start with %s followed by one or more strings indicating which settings it contains, finally followed by the date and time it was exported.', 'exmachina' ), exmachina_code( 'exmachina-' ) ) . '</p>' .
			'<p>' . __( 'Once you upload an import file, it will automatically overwrite your existing settings.', 'exmachina' ) . ' <strong>' . __( 'This cannot be undone', 'exmachina' ) . '</strong>.</p>';

		$export_settings_help =
			'<h3>' . __( 'Export', 'exmachina' ) . '</h3>' .
			'<p>'  . sprintf( __( 'You can export your ExMachina-related settings to back them up, or copy them to another site. Child themes and plugins may add their own checkboxes to the list. The settings are exported in %s format.', 'exmachina' ), '<abbr title="' . __( 'JavaScript Object Notation', 'exmachina' ) . '">' . __( 'JSON', 'exmachina' ) . '</abbr>' ) . '</p>';

		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-general-settings',
			'title'   => __( 'Import/Export', 'exmachina' ),
			'content' => $general_settings_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-import',
			'title'   => __( 'Import', 'exmachina' ),
			'content' => $import_settings_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-export',
			'title'   => __( 'Export', 'exmachina' ),
			'content' => $export_settings_help,
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
	 * Callback for displaying the ExMachina Import / Export admin page.
	 *
	 * Call the exmachina_import_export_form action after the last default table row.
	 *
	 * @since 1.4.0
	 *
	 * @uses \ExMachina_Admin_Import_Export::export_checkboxes()  Echo export checkboxes.
	 * @uses \ExMachina_Admin_Import_Export::get_export_options() Get array of export options.
	 */
	public function settings_page() {

		?>
		<div class="wrap">
			<?php screen_icon( 'tools' ); ?>
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

			<table class="form-table">
				<tbody>

					<tr>
						<th scope="row"><b><?php _e( 'Import ExMachina Settings File', 'exmachina' ); ?></p></th>
						<td>
							<p><?php printf( __( 'Upload the data file (%s) from your computer and we\'ll import your settings.', 'exmachina' ), exmachina_code( '.json' ) ); ?></p>
							<p><?php _e( 'Choose the file from your computer and click "Upload file and Import"', 'exmachina' ); ?></p>
							<p>
								<form enctype="multipart/form-data" method="post" action="<?php echo menu_page_url( 'exmachina-import-export', 0 ); ?>">
									<?php wp_nonce_field( 'exmachina-import' ); ?>
									<input type="hidden" name="exmachina-import" value="1" />
									<label for="exmachina-import-upload"><?php sprintf( __( 'Upload File: (Maximum Size: %s)', 'exmachina' ), ini_get( 'post_max_size' ) ); ?></label>
									<input type="file" id="exmachina-import-upload" name="exmachina-import-upload" size="25" />
									<?php
									submit_button( __( 'Upload File and Import', 'exmachina' ), 'primary', 'upload', false );
									?>
								</form>
							</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><b><?php _e( 'Export ExMachina Settings File', 'exmachina' ); ?></b></th>
						<td>
							<p><?php printf( __( 'When you click the button below, ExMachina will generate a data file (%s) for you to save to your computer.', 'exmachina' ), exmachina_code( '.json' ) ); ?></p>
							<p><?php _e( 'Once you have saved the download file, you can use the import function on another site to import this data.', 'exmachina' ); ?></p>
							<p>
								<form method="post" action="<?php echo menu_page_url( 'exmachina-import-export', 0 ); ?>">
									<?php
									wp_nonce_field( 'exmachina-export' );
									$this->export_checkboxes();
									if ( $this->get_export_options() )
										submit_button( __( 'Download Export File', 'exmachina' ), 'primary', 'download' );
									?>
								</form>
							</p>
						</td>
					</tr>

					<?php do_action( 'exmachina_import_export_form' ); ?>

				</tbody>
			</table>

		</div>
		<?php

	}

	/**
	 * Add custom notices that display after successfully importing or exporting the settings.
	 *
	 * @since 1.4.0
	 *
	 * @uses exmachina_is_menu_page() Check if we're on a ExMachina page.
	 *
	 * @return null Return early if not on the correct admin page.
	 */
	public function notices() {

		if ( ! exmachina_is_menu_page( 'exmachina-import-export' ) )
			return;

		if ( isset( $_REQUEST['imported'] ) && 'true' === $_REQUEST['imported'] )
			echo '<div id="message" class="updated"><p><strong>' . __( 'Settings successfully imported.', 'exmachina' ) . '</strong></p></div>';
		elseif ( isset( $_REQUEST['error'] ) && 'true' === $_REQUEST['error'] )
			echo '<div id="message" class="error"><p><strong>' . __( 'There was a problem importing your settings. Please try again.', 'exmachina' ) . '</strong></p></div>';

	}

	/**
	 * Return array of export options and their arguments.
	 *
	 * Plugins and themes can hook into the exmachina_export_options filter to add
	 * their own settings to the exporter.
	 *
	 * @since 1.6.0
	 *
	 * @return array Export options
	 */
	protected function get_export_options() {

		$options = array(
			'theme' => array(
				'label'          => __( 'Theme Settings', 'exmachina' ),
				'settings-field' => EXMACHINA_SETTINGS_FIELD,
			),
			'content' => array(
				'label' => __( 'Content Settings', 'exmachina' ),
				'settings-field' => EXMACHINA_CONTENT_SETTINGS_FIELD,
			),
			'hooks' => array(
				'label' => __( 'Hook Settings', 'exmachina' ),
				'settings-field' => EXMACHINA_HOOK_SETTINGS_FIELD,
			),
			'seo' => array(
				'label' => __( 'SEO Settings', 'exmachina' ),
				'settings-field' => EXMACHINA_SEO_SETTINGS_FIELD,
			),
		);

		return (array) apply_filters( 'exmachina_export_options', $options );

	}

	/**
	 * Echo out the checkboxes for the export options.
	 *
	 * @since 1.6.0
	 *
	 * @uses \ExMachina_Admin_Import_Export::get_export_options() Get array of export options.
	 *
	 * @return null Return null if there are no options to export.
	 */
	protected function export_checkboxes() {

		if ( ! $options = $this->get_export_options() ) {
			//* Not even the ExMachina theme / seo export options were returned from the filter
			printf( '<p><em>%s</em></p>', __( 'No export options available.', 'exmachina' ) );
			return;
		}

		foreach ( $options as $name => $args ) {
			//* Ensure option item has an array key, and that label and settings-field appear populated
			if ( is_int( $name ) || ! isset( $args['label'] ) || ! isset( $args['settings-field'] ) || '' === $args['label'] || '' === $args['settings-field'] )
				return;

			printf( '<p><label for="exmachina-export-%1$s"><input id="exmachina-export-%1$s" name="exmachina-export[%1$s]" type="checkbox" value="1" /> %2$s</label></p>', esc_attr( $name ), esc_html( $args['label'] ) );

		}

	}

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
	 * @since 1.4.0
	 *
	 * @uses exmachina_is_menu_page()                             Check if we're on a ExMachina page.
	 * @uses \ExMachina_Admin_Import_Export::get_export_options() Get array of export options.
	 *
	 * @return null Return null if not correct page, or we're not exporting.
	 */
	public function export() {

		if ( ! exmachina_is_menu_page( 'exmachina-import-export' ) )
			return;

		if ( empty( $_REQUEST['exmachina-export'] ) )
			return;

		check_admin_referer( 'exmachina-export' );

		do_action( 'exmachina_export', $_REQUEST['exmachina-export'] );

		$options = $this->get_export_options();

		$settings = array();

		//* Exported file name always starts with "exmachina"
		$prefix = array( 'exmachina' );

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

	}

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
	 * @since 1.4.0
	 *
	 * @uses exmachina_is_menu_page()   Check if we're on a ExMachina page
	 * @uses exmachina_admin_redirect() Redirect user to an admin page
	 *
	 * @return null Return null if not correct admin page, we're not importing
	 */
	public function import() {

		if ( ! exmachina_is_menu_page( 'exmachina-import-export' ) )
			return;

		if ( empty( $_REQUEST['exmachina-import'] ) )
			return;

		check_admin_referer( 'exmachina-import' );

		do_action( 'exmachina_import', $_REQUEST['exmachina-import'], $_FILES['exmachina-import-upload'] );

		$upload = file_get_contents( $_FILES['exmachina-import-upload']['tmp_name'] );

		$options = json_decode( $upload, true );

		//* Check for errors
		if ( ! $options || $_FILES['exmachina-import-upload']['error'] ) {
			exmachina_admin_redirect( 'exmachina-import-export', array( 'error' => 'true' ) );
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
		exmachina_admin_redirect( 'exmachina-import-export', array( 'imported' => 'true' ) );
		exit;

	}

}
