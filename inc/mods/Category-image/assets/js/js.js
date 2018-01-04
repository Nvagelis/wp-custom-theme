jQuery(document).ready( function($) {
//            function ct_media_upload(button_class) {
//                var _custom_media = true,
//                    _orig_send_attachment = wp.media.editor.send.attachment;
//                $('body').on('click', button_class, function(e) {
//                    var button_id = '#'+$(this).attr('id');
//                    var send_attachment_bkp = wp.media.editor.send.attachment;
//                    var button = $(button_id);
//                    _custom_media = true;
//                    wp.media.editor.send.attachment = function(props, attachment){
//                        if ( _custom_media ) {
//                            $('#category-image-id').val(attachment.id);
//                            $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
//                            $('#category-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
//                        } else {
//                            return _orig_send_attachment.apply( button_id, [props, attachment] );
//                        }
//                    }
//                    wp.media.editor.open(button);
//                    return false;
//                });
//            }
//            ct_media_upload('.ct_tax_media_button.button'); 
//            
//            
//            
//            
//            
//            $('body').on('click','.ct_tax_media_remove',function(){
//                $('#category-image-id').val('');
//                $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
//            });
            // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
//            $(document).ajaxComplete(function(event, xhr, settings) {
//                var queryStringArr = settings.data.split('&');
//                if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
//                    var xml = xhr.responseXML;
//                    $response = $(xml).find('term_id').text();
//                    if($response != ""){
//                        // Clear the thumb image
//                        $('#category-image-wrapper').html('');
//                    }
//                }
//            });
            
            
            //
            var custom_uploader;
            $('body').on('click', '.ct_tax_media_button', function(e){
                e.preventDefault();

                // If the media frame already exists, reopen it.
                if ( custom_uploader ) {
                    custom_uploader.open();
                    return;
                }

                custom_uploader = wp.media({
                    frame: 'post',  //or select AND Remove state: 'insert'
                    /*
                     * Με frame: 'post' εχω το πληρες modal με insert url, ολες τις λεπτομεριες
                     * Με frame: 'select' εχω απλα modal για select image. χρειαζεται και state: 'insert', και μετα κανει trigger το select event.
                    */
                    //state: 'insert',
                    title: 'Insert image',
                    library : {
                            // uncomment the next line if you want to attach image to the current post
                            // uploadedTo : wp.media.view.settings.post.id, 
                            type : 'image'
                    },
                    button: {
                            text: 'Use this image' // button label text
                    },
                    multiple: false // for multiple image selection set to true
                }).on('close', function() { // it also has "open" and "close" events //Στο frame : 'select' εχω και select event αντι του close
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    console.log(attachment);
                    $('#category-image-id').val(attachment.id);
                    $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                    $('#category-image-wrapper img').attr('src', attachment.url);
                    $('#category-image-id').trigger('change');
                        /* if you sen multiple to true, here is some code for getting the image IDs
                        var attachments = frame.state().get('selection'),
                        attachment_ids = new Array(),
                        i = 0;
                        attachments.each(function(attachment) {
                            attachment_ids[i] = attachment['id'];
                            console.log( attachment );
                            i++;
                        });
                    */
                })
                .open();
            });

            $('body').on('click', '.ct_tax_media_remove', function(){
                $('#category-image-wrapper img').attr('src', '');
                $('#category-image-id').val('');
                $('#category-image-id').trigger('change');
                return false;
            });
            
            
            //Οταν κανω new category κανω clear το thumb μετα τη δημιουργία
            $(document).ajaxComplete(function(event, xhr, settings) {
                var queryStringArr = settings.data.split('&');
                if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
                    var xml = xhr.responseXML;
                    $response = $(xml).find('term_id').text();
                    if($response != ""){
                        // Clear the thumb image
                        $('#category-image-wrapper').html('');
                    }
                }
            });
});