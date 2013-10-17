 /*! ExMachina Admin JavaScript v1.0.0 | (c) 2013, Machina Themes | http://machinathemes.com/ */

/**
 * ExMachina Admin JavaScript
 *
 * @package     ExMachina
 * @subpackage  Assets
 * @version     1.0.0
 * @copyright   Copyright (c) 2013, Machina Themes
 */

jQuery(document).ready(function($) {

  $('.collapsed input:checkbox').click(unhideHidden);

  function unhideHidden(){
    if ($(this).attr('checked')) {
      $(this).parent().parent().next().removeClass('hidden');
    }
    else {
      $(this).parent().parent().next().addClass('hidden');
    }
  }

  $('#exmachina_theme_settings-content_archive').on('change', function() {
      if (this.value != 'full') {
      $(this).parent().next().removeClass('hidden');
    }
    else {
      $(this).parent().next().addClass('hidden');
    }
  });

  var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;

  $('#exmachina-theme-favicon .button').click(function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = $(this);
    var id = button.attr('id').replace('_button', '');
    _custom_media = true;
    wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {
        $("#"+id).val(attachment.url);
      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }

    wp.media.editor.open(button);
    return false;
  });

  $('.add_media').on('click', function(){
    _custom_media = false;
  });

});