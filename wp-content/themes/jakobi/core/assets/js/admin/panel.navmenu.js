/**
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

jQuery(document).ready(function($){
    "use strict";

    //upload
    var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;

    $(document).on('click', 'input.upload_button', function(e) {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        var id = button.attr('id').replace('-button', '');
        _custom_media = true;

        wp.media.editor.send.attachment = function(props, attachment){

            if ( _custom_media ) {
                //console.log(id);
                if( $( "#" +id ).is('input[type=text]') ) {
                    $( "#" +id ).val(attachment.url);
                } else {
                    $("#"+id + '_custom').val(attachment.url);
                }


                var description =  $( "#" +id ).parents('.menu-item-settings').find('.edit-menu-item-description');
                var sfx = $( "#" +id ).data('sfx');
                var text = description.val();
                var regex = new RegExp("\\["+sfx+" [a-zA-Z0-9-:/%_.]+\\]");
                text = text.replace(regex,'');
                description.val( text + "["+sfx+" "+attachment.url+"]");

            } else {
                return _orig_send_attachment.apply( this, [props, attachment] );
            }
        };

        wp.media.editor.open(button);
        return false;
    });

    $('.yit-options .add_media').on('click', function(){
        _custom_media = false;
    });


    $(document).on('change','.menu-custom-field-select', function(){
        var select = $(this);
        var description = $(this).parents('.menu-item-settings').find('.edit-menu-item-description');
        var selected_val = select.val();
        var sfx = select.data('sfx');
        var text  = description.val();
        var regex = new RegExp("\\["+sfx+" [a-z0-9-]+\\]");
        text = text.replace(regex,'');
        description.val( text + "["+sfx+" "+selected_val+"]");
    });


    // icon-list
    $('.widget_icon_type').on('change', function(){
        var t       = $(this);
        var parents = t.closest('div.widget_select_action');
        var option  = $('option:selected', this).val();
        var to_show = option == 'none' ? '' : option == 'icon'  ? '.widget-icon-manager' : '.widget_custom_icon';

        parents.find('.widget-icon-manager, .widget_custom_icon').addClass('hidden');
        parents.find( to_show ).removeClass( 'hidden' ).addClass( 'show' );
    });

    $('.widget_icon_type').trigger('change');


});