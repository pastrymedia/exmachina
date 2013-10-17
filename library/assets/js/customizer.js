 /*! ExMachina Customizer JavaScript v1.0.0 | (c) 2013, Machina Themes | http://machinathemes.com/ */

/**
 * ExMachina Customizer JavaScript
 *
 * Theme Customizer enhancements for a better user experience. Contains handlers
 * to make Theme Customizer preview reload changes asynchronously.
 *
 * @package     ExMachina
 * @subpackage  Assets
 * @version     1.0.0
 * @copyright   Copyright (c) 2013, Machina Themes
 */

( function( $ ) {
  // Site title and description.
  wp.customize( 'blogname', function( value ) {
    value.bind( function( to ) {
      $( '.site-title a' ).text( to );
    } );
  } );
  wp.customize( 'blogdescription', function( value ) {
    value.bind( function( to ) {
      $( '.site-description' ).text( to );
    } );
  } );
} )( jQuery );