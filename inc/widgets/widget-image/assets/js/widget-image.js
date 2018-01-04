//jQuery(document).ready( function($){
//    var mediaUploader;
//    $('body').on('click', '.wd-img-upload-btn', function(e) {
//        e.preventDefault();
//        if ( mediaUploader ) {
//            mediaUploader.open();
//            return;
//        }
//
//        mediaUploader = wp.media.frames.file_frame = wp.media({
//            title: 'Select an Image',
//            button: {
//                text: 'Use This Image'
//            },
//            multiple: false
//        });
//
//        mediaUploader.on('select', function() {
//            var attachment = mediaUploader.state().get('selection').first().toJSON();      
//            $('.wd-img-path').val(attachment.url);
//            $('.wd-img-path').trigger('change');
//            $('.wd-img-image').attr('src', attachment.url);
//        });
//        mediaUploader.open();
//    });
//});



jQuery(document).ready( function($){
    var custom_uploader;
    $('body').on('click', '.wd-img-upload-btn', function(e){
        e.preventDefault();
        
        // If the media frame already exists, reopen it.
        if ( custom_uploader ) {
            custom_uploader.open();
            return;
        }
        
        custom_uploader = wp.media({
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
        }).on('select', function() { // it also has "open" and "close" events 
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('.wd-img-path').val(attachment.url);
            $('.wd-img-path').trigger('change');
            $('.wd-img-image').attr('src', attachment.url);
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
    
    $('body').on('click', '.wd-img-remove-btn', function(){
        $('.wd-img-image').attr('src', '');
        $('.wd-img-path').val('');
        $('.wd-img-path').trigger('change');
        return false;
    });
});