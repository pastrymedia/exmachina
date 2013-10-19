<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Template Functions
 *
 * template.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Functions for loading template parts. These functions are helper functions
 * or more flexible functions than what core WordPress currently offers with
 * template part loading.
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
 * Loads a post content template based off the post type and/or the post format.  This functionality is
 * not feasible with the WordPress get_template_part() function, so we have to rely on some custom logic
 * and locate_template().
 *
 * Note that using this function assumes that you're creating a content template to handle attachments.
 * This filter must be removed since we're bypassing the WP template hierarchy and focusing on templates
 * specific to the content.
 *
 * @since  1.6.0
 * @access public
 * @return string
 */
function exmachina_get_content_template() {

	/* Set up an empty array and get the post type. */
	$templates = array();
	$post_type = get_post_type();

	/* Assume the theme developer is creating an attachment template. */
	if ( 'attachment' == $post_type )
		remove_filter( 'the_content', 'prepend_attachment' );

	/* If the post type supports 'post-formats', get the template based on the format. */
	if ( post_type_supports( $post_type, 'post-formats' ) ) {

		/* Get the post format. */
		$post_format = get_post_format() ? get_post_format() : 'standard';

		/* Template based off post type and post format. */
		$templates[] = "content-{$post_type}-{$post_format}.php";

		/* Template based off the post format. */
		$templates[] = "content-{$post_format}.php";
	}

	/* Template based off the post type. */
	$templates[] = "content-{$post_type}.php";

	/* Fallback 'content.php' template. */
	$templates[] = 'content.php';

	/* Apply filters and return the found content template. */
	include( apply_atomic( 'content_template', locate_template( $templates, true, false ) ) );
}

/**
 * Advance Get Template by Atomic Context.
 * An easy to use feature for developer to create context based template file.
 *
 * @param $dir	string	template files directory
 * @param $loop	bool	if it's used in the loop, to give extra template based on post data.
 * @since 0.1.0
 */
function exmachina_get_atomic_template( $dir, $loop = false ) {

	/* array of available templates */
	$templates = array();

	/* get theme path  */
	$theme_dir = trailingslashit( THEME_DIR ) . $dir;
	$child_dir = trailingslashit( CHILD_THEME_DIR ) . $dir;

	if ( is_dir( $child_dir ) || is_dir( $theme_dir ) ) {

		/* index.php in folder are fallback template */
		$templates[] = "{$dir}/index.php";
	}
	else{
		return ''; // empty string if dir not found
	}

	/* get current page (atomic) contexts */
	$contexts = exmachina_get_context();

	/* for each contexts */
	foreach ( $contexts as $context ){

		/* add context based template */
		$templates[] = "{$dir}/{$context}.php";

		/* if context is in the loop, ( how to check if it's in the loop? ) */
		if ( true === $loop ){

			/* file based on post data */
			$files = array();

			/* current post - post type */
			$files[] = get_post_type();

			/* if post type support post-formats */
			if ( post_type_supports( get_post_type(), 'post-formats' ) ){
				$files[] = get_post_type() . '-format-' . get_post_format();
			}

			/*
			 * In blog pages, archives and search result pages, add post type and post format template
			 * post format in singular pages is not needed, cause it's already added in core context.
			 */
			if ( !is_singular() ){

				/* add file based on post type and post format */
				foreach ( $files as $file ){
					$templates[] = "{$dir}/{$context}_{$file}.php";
				}

				/* add sticky post in home page */
				if ( is_home() && !is_paged() ){
					if ( is_sticky( get_the_ID() ) ){
						$templates[] = "{$dir}/_sticky.php";
					}
				}
			}
		}
	}
	/* allow developer to modify template */
	$templates = apply_filters( 'exmachina_atomic_template',  $templates, $dir, $loop );

	return locate_template( array_reverse( $templates ), true, false );
}


?>