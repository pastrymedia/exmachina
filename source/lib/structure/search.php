<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Search Structure
 *
 * search.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <[DESCRIPTION GOES HERE]>
 *
 * @package     ExMachina
 * @subpackage  Structure
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin structure
###############################################################################

add_filter( 'get_search_form', 'exmachina_search_form' );
/**
 * Search Form Markup
 *
 * Replace the default search form with a ExMachina-specific form.
 *
 * Applies the `exmachina_search_text`, `exmachina_search_button_text`,
 * `exmachina_search_form_label` and `exmachina_search_form` filters.
 *
 * @todo inline comment
 * @todo compare against hybrid search
 * @todo google search possibility (???)
 *
 * @link http://codex.wordpress.org/Function_Reference/get_search_query
 * @link http://codex.wordpress.org/Function_Reference/esc_js
 * @link http://codex.wordpress.org/Function_Reference/esc_attr
 * @link http://codex.wordpress.org/Function_Reference/esc_html
 * @link http://codex.wordpress.org/Function_Reference/home_url
 *
 * @since 0.5.0
 * @access public
 *
 * @return string HTML markup.
 */
function exmachina_search_form() {
  $search_text = get_search_query() ? apply_filters( 'the_search_query', get_search_query() ) : apply_filters( 'exmachina_search_text', __( 'Search this website', 'exmachina' ) . '&#x02026;' );

  $button_text = apply_filters( 'exmachina_search_button_text', esc_attr__( 'Search', 'exmachina' ) );

  $onfocus = "if ('" . esc_js( $search_text ) . "' === this.value) {this.value = '';}";
  $onblur  = "if ('' === this.value) {this.value = '" . esc_js( $search_text ) . "';}";

  //* Empty label, by default. Filterable.
  $label = apply_filters( 'exmachina_search_form_label', '' );

  $form = sprintf( '<form method="get" class="search-form" action="%s" role="search">%s<input type="search" name="s" placeholder="%s" /><input type="submit" value="%s" /></form>', home_url( '/' ), esc_html( $label ), esc_attr( $search_text ), esc_attr( $button_text ) );

  return apply_filters( 'exmachina_search_form', $form, $search_text, $button_text, $label );

} // end function exmachina_search_form()