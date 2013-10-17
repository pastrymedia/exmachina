 /*! ExMachina Mobile Menu Toggle v1.0.0 | (c) 2013, Machina Themes | http://machinathemes.com/ */

/**
 * ExMachina Mobile Menu Toggle
 *
 * Toggles a nav menu in mobile-ready designs. The theme should have a link with
 * the '.menu-toggle' class for toggling the menu. The menu must be wrapped with
 * an element with the '.wrap' and/or the '.menu-items' class. The theme should
 * also use media queries to handle any other design elements. This script merely
 * toggles the menu when the '.menu-toggle' link is clicked.
 *
 * @package     ExMachina
 * @subpackage  Assets
 * @version     1.0.0
 * @copyright   Copyright (c) 2013, Machina Themes
 */

jQuery( document ).ready(
  function() {
    jQuery( '.menu-toggle' ).click(
      function() {
        jQuery( this ).parent().children( '.wrap, .menu-items' ).fadeToggle();
        jQuery( this ).toggleClass( 'active' );
      }
    );
  }
);