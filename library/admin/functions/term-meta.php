<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Term Meta Functions
 *
 * term-meta.php
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

add_action( 'admin_init', 'exmachina_add_taxonomy_archive_options' );
/**
 * Add Taxonomy Archive Options
 *
 * Add the archive options to each custom taxonomy edit screen.
 *
 * @uses exmachina_taxonomy_archive_options() Callback for headline and introduction fields.
 *
 * @since 1.0.0
 * @access public
 */
function exmachina_add_taxonomy_archive_options() {

	/* Loop through taxonomies and hook the callback. */
	foreach ( get_taxonomies( array( 'show_ui' => true ) ) as $tax_name )
		add_action( $tax_name . '_edit_form', 'exmachina_taxonomy_archive_options', 10, 2 );

} // end function exmachina_add_taxonomy_archive_options()

/**
 * Taxonomy Archive Options
 *
 * Echo headline and introduction fields on the taxonomy term edit form. If
 * populated, the values saved in these fields may display on taxonomy archives.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_taxonomy
 *
 * @uses exmachina_add_taxonomy_archive_options() Callback caller.
 *
 * @since 1.0.0
 * @access public
 *
 * @param \stdClass $tag      Term object.
 * @param string    $taxonomy Name of the taxonomy.
 */
function exmachina_taxonomy_archive_options( $tag, $taxonomy ) {

	$tax = get_taxonomy( $taxonomy );
	?>
	<h3><?php echo esc_html( $tax->labels->singular_name ) . ' ' . __( 'Archive Settings', 'exmachina-core' ); ?></h3>
	<table class="form-table">
		<tbody>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="exmachina-meta[headline]"><?php _e( 'Archive Headline', 'exmachina-core' ); ?></label></th>
				<td>
					<input name="exmachina-meta[headline]" id="exmachina-meta[headline]" type="text" value="<?php echo esc_attr( $tag->meta['headline'] ); ?>" size="40" />
					<p class="description"><?php _e( 'Leave empty if you do not want to display a headline.', 'exmachina-core' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="exmachina-meta[intro_text]"><?php _e( 'Archive Intro Text', 'exmachina-core' ); ?></label></th>
				<td>
					<textarea name="exmachina-meta[intro_text]" id="exmachina-meta[intro_text]" rows="5" cols="50" class="large-text"><?php echo esc_textarea( $tag->meta['intro_text'] ); ?></textarea>
					<p class="description"><?php _e( 'Leave empty if you do not want to display any intro text.', 'exmachina-core' ); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

} // end function exmachina_taxonomy_archive_options()

/*-------------------------------------------------------------------------*/
/* Begin taxonomy SEO options. */
/*-------------------------------------------------------------------------*/

add_action( 'admin_init', 'exmachina_add_taxonomy_seo_options' );
/**
 * Add Taxonomy SEO Options
 *
 * Add the SEO options to each custom taxonomy edit screen.
 *
 * @uses exmachina_taxonomy_seo_options() Callback for SEO fields.
 *
 * @since 1.0.0
 * @access public
 */
function exmachina_add_taxonomy_seo_options() {

	/* Loop through taxonomies and hook the callback. */
	foreach ( get_taxonomies( array( 'show_ui' => true ) ) as $tax_name )
		add_action( $tax_name . '_edit_form', 'exmachina_taxonomy_seo_options', 10, 2 );

} // end function exmachina_add_taxonomy_seo_options()

/**
 * Taxonomy SEO Options
 *
 * Echo title, description, keywords and robots meta SEO fields on the taxonomy
 * term edit form. If populated, the values saved in these fields may be used on
 * taxonomy archives.
 *
 * @uses exmachina_code() [description]
 *
 * @since 1.0.0
 * @access public
 *
 * @param \stdClass $tag      Term object.
 * @param string    $taxonomy Name of the taxonomy.
 */
function exmachina_taxonomy_seo_options( $tag, $taxonomy ) {

	?>
	<h3><?php _e( 'Theme SEO Settings', 'exmachina-core' ); ?></h3>
	<table class="form-table">
		<tbody>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="exmachina-meta[doctitle]"><?php _e( 'Custom Document Title', 'exmachina-core' ); ?></label></th>
				<td>
					<input name="exmachina-meta[doctitle]" id="exmachina-meta[doctitle]" type="text" value="<?php echo esc_attr( $tag->meta['doctitle'] ); ?>" size="40" />
				</td>
			</tr>

			<tr class="form-field">
				<th scope="row" valign="top"><label for="exmachina-meta[description]"><?php _e( 'Meta Description', 'exmachina-core' ); ?></label></th>
				<td>
					<textarea name="exmachina-meta[description]" id="exmachina-meta[description]" rows="5" cols="50" class="large-text"><?php echo esc_html( $tag->meta['description'] ); ?></textarea>
				</td>
			</tr>

			<tr class="form-field">
				<th scope="row" valign="top"><label for="exmachina-meta[keywords]"><?php _e( 'Meta Keywords', 'exmachina-core' ); ?></label></th>
				<td>
					<input name="exmachina-meta[keywords]" id="exmachina-meta[keywords]" type="text" value="<?php echo esc_attr( $tag->meta['keywords'] ); ?>" size="40" />
					<p class="description"><?php _e( 'Comma separated list', 'exmachina-core' ); ?></p>
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top"><?php _e( 'Robots Meta', 'exmachina-core' ); ?></th>
				<td>
					<label for="exmachina-meta[noindex]"><input name="exmachina-meta[noindex]" id="exmachina-meta[noindex]" type="checkbox" value="1" <?php checked( $tag->meta['noindex'] ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'exmachina-core' ), exmachina_code( 'noindex' ) ); ?></label><br />

					<label for="exmachina-meta[nofollow]"><input name="exmachina-meta[nofollow]" id="exmachina-meta[nofollow]" type="checkbox" value="1" <?php checked( $tag->meta['nofollow'] ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'exmachina-core' ), exmachina_code( 'nofollow' ) ); ?></label><br />

					<label for="exmachina-meta[noarchive]"><input name="exmachina-meta[noarchive]" id="exmachina-meta[noarchive]" type="checkbox" value="1" <?php checked( $tag->meta['noarchive'] ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'exmachina-core' ), exmachina_code( 'noarchive' ) ); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

} // end function exmachina_taxonomy_seo_options()

/*-------------------------------------------------------------------------*/
/* Begin taxonomy Layout options. */
/*-------------------------------------------------------------------------*/

add_action( 'admin_init', 'exmachina_add_taxonomy_layout_options' );
/**
 * Add Taxonomy Layout Options
 *
 * Add the layout options to each custom taxonomy edit screen.
 *
 * @uses exmachina_taxonomy_layout_options() Callback for layout selector.
 *
 * @since 1.0.0
 * @access public
 */
function exmachina_add_taxonomy_layout_options() {

	/* Loop through taxonomies and hook the callback. */
	foreach ( get_taxonomies( array( 'show_ui' => true ) ) as $tax_name )
		add_action( $tax_name . '_edit_form', 'exmachina_taxonomy_layout_options', 10, 2 );

} // end function exmachina_add_taxonomy_layout_options()

/**
 * Taxonomy Layout Options
 *
 * Echo the layout options on the taxonomy term edit form.
 *
 * @todo fix layout selector markup
 *
 * @uses exmachina_layout_selector() Layout selector.
 *
 * @since 1.0.0
 * @access public
 *
 * @param \stdClass $tag      Term object.
 * @param string    $taxonomy Name of the taxonomy.
 */
function exmachina_taxonomy_layout_options( $tag, $taxonomy ) {

	?>
	<h3><?php _e( 'Layout Settings', 'exmachina-core' ); ?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" valign="top"><?php _e( 'Choose Layout', 'exmachina-core' ); ?></th>
				<td>
					<div class="exmachina-layout-selector">
						<p>
							<input type="radio" class="default-layout" name="exmachina-meta[layout]" id="default-layout" value="" <?php checked( $tag->meta['layout'], '' ); ?> />
							<label for="default-layout" class="default"><?php printf( __( 'Default Layout set in <a href="%s">Theme Settings</a>', 'exmachina-core' ), menu_page_url( 'exmachina-core', 0 ) ); ?></label>
						</p>

						<p><?php exmachina_layout_selector( array( 'name' => 'exmachina-meta[layout]', 'selected' => $tag->meta['layout'], 'type' => 'site' ) ); ?></p>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

} // end function exmachina_taxonomy_layout_options()

/*-------------------------------------------------------------------------*/
/* Begin term action functions. */
/*-------------------------------------------------------------------------*/

add_action( 'edit_term', 'exmachina_term_meta_save', 10, 2 );
/**
 * Save Term Meta
 *
 * Save term meta data. Fires when a user edits and saves a term.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/current_user_can
 * @link http://codex.wordpress.org/Function_Reference/update_option
 *
 * @uses exmachina_formatting_kses() ExMachina whitelist for wp_kses.
 *
 * @since 1.0.0
 * @access public
 *
 * @param  integer $term_id Term ID.
 * @param  integer $tt_id   Term Taxonomy ID.
 * @return null 						Return early if doing an autosave.
 */
function exmachina_term_meta_save( $term_id, $tt_id ) {

	/* Return early during autosave. */
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		return;

	/* Get the term meta options. */
	$term_meta = (array) get_option( 'exmachina-term-meta' );

	/* Set the term meta array. */
	$term_meta[$term_id] = isset( $_POST['exmachina-meta'] ) ? (array) $_POST['exmachina-meta'] : array();

	/* Sanitize the term meta. */
	if ( ! current_user_can( 'unfiltered_html' ) && isset( $term_meta[$term_id]['archive_description'] ) )
		$term_meta[$term_id]['archive_description'] = exmachina_formatting_kses( $term_meta[$term_id]['archive_description'] );

	/* Update the term meta. */
	update_option( 'exmachina-term-meta', $term_meta );

} // end function exmachina_term_meta_save()

add_action( 'delete_term', 'exmachina_term_meta_delete', 10, 2 );
/**
 * Delete Term Meta
 *
 * Delete term meta data. Fires when a user deletes a term.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_option
 * @link http://codex.wordpress.org/Function_Reference/update_option
 *
 * @since 1.0.0
 * @access public
 *
 * @param integer $term_id Term ID.
 * @param integer $tt_id   Taxonomy Term ID.
 */
function exmachina_term_meta_delete( $term_id, $tt_id ) {

	/* Get the term meta option. */
	$term_meta = (array) get_option( 'exmachina-term-meta' );

	/* Unset the term meta. */
	unset( $term_meta[$term_id] );

	/* Update the term meta option. */
	update_option( 'exmachina-term-meta', (array) $term_meta );

} // end function exmachina_term_meta_delete()
