
//Airline custom image
jQuery(document).ready(function ($) {
    function code_media_upload(button_class) {
        var _custom_media = true,
            _code_send_attachment = wp.media.editor.send.attachment;
        $('body').on('click', button_class, function (e) {
            var button_id = '#' + $(this).attr('id');
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(button_id);
            _custom_media = true;
            wp.media.editor.send.attachment = function (props, attachment) {
                if (_custom_media) {
                    $('#airlines-image-id').val(attachment.id);
                    $('#airlines-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                    $('#airlines-image-wrapper .custom_media_image').attr('src', attachment.url).css('display', 'block');
                } else {
                    return _code_send_attachment.apply(button_id, [props, attachment]);
                }
            }
            wp.media.editor.open(button);
            return false;
        });
    }
    code_media_upload('.meals_hub_media_button.button');
    $('body').on('click', '.code_media_remove', function () {
        $('#airlines-image-id').val('');
        $('#airlines-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
    });
    $(document).ajaxComplete(function (event, xhr, settings) {
        var queryStringArr = settings.data.split('&');
        if ($.inArray('action=add-tag', queryStringArr) !== -1) {
            var xml = xhr.responseXML;
            $response = $(xml).find('term_id').text();
            if ($response != "") {
                // Clear the thumb image
                $('#airlines-image-wrapper').html('');
            }
        }
    });
});

// Meals Media Upload


jQuery(function ($) {

    $('body').on('click', '.wc_multi_upload_image_button', function (e) {
        e.preventDefault();

        var button = $(this),
            custom_uploader = wp.media({
                title: 'Insert image',
                button: {
                    text: 'Use this image'
                },
                multiple: true
            }).on('select', function () {
                var attech_ids = '';
                attachments
                var attachments = custom_uploader.state().get('selection'),
                    attachment_ids = new Array(),
                    i = 0;
                attachments.each(function (attachment) {
                    attachment_ids[i] = attachment['id'];
                    attech_ids += ',' + attachment['id'];
                    if (attachment.attributes.type == 'image') {
                        $(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.url + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
                    } else {
                        $(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.icon + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
                    }

                    i++;
                });

                var ids = $(button).siblings('.attechments-ids').attr('value');
                if (ids) {
                    var ids = ids + attech_ids;
                    $(button).siblings('.attechments-ids').attr('value', ids);
                } else {
                    $(button).siblings('.attechments-ids').attr('value', attachment_ids);
                }
                $(button).siblings('.wc_multi_remove_image_button').show();
            })
                .open();
    });

    $('body').on('click', '.wc_multi_remove_image_button', function () {
        $(this).hide().prev().val('').prev().addClass('button').html('Add Media');
        $(this).parent().find('ul').empty();
        return false;
    });

});

jQuery(document).ready(function () {
    jQuery(document).on('click', '.multi-upload-medias ul li i.delete-img', function () {
        var ids = [];
        var this_c = jQuery(this);
        jQuery(this).parent().remove();
        jQuery('.multi-upload-medias ul li').each(function () {
            ids.push(jQuery(this).attr('data-attechment-id'));
        });
        jQuery('.multi-upload-medias').find('input[type="hidden"]').attr('value', ids);
    });
})