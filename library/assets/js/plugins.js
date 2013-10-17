 /*! ExMachina Scripts JavaScript v1.0.0 | (c) 2013, Machina Themes | http://machinathemes.com/ */

/**
 * ExMachina Scripts JavaScript
 *
 * @package     ExMachina
 * @subpackage  Assets
 * @version     1.0.0
 * @copyright   Copyright (c) 2013, Machina Themes
 */

var $j = jQuery.noConflict();

$j( document ).ready(

  function() {

    /* Mobile menu. */
    $j( '.menu-toggle' ).click(
      function() {
        $j( this ).parent().children( '.wrap, .menu-items' ).fadeToggle();
        $j( this ).toggleClass( 'active' );
      }
    );

    /* Responsive videos. */
    $j( '.format-video object, .format-video embed, .format-video iframe' ).removeAttr( 'width height' ).wrap( '<div class="embed-wrap" />' );

    /* Flexslider. */
    if ( $j.isFunction( $j.fn.flexslider ) ) {

      /* Flexslider */
      $j( '.flexslider' ).flexslider(
        {
          animation: "slide",
          selector: ".slides > .slide"
        }
      );
    }
  }
);