jQuery(document).ready( function($){
    
    var counter = $('input[name="widget-widget_dynamically_fields[2][text][]"]').length;
    $('body').on('click', '#wd-add-text-field', function (){
        counter ++;
        $('.widget_dynamically_fields').append('<p>\n\
                                                    <label for="widget-widget_dynamically_fields-2-text-'+ counter +'">New Text</label>\n\
                                                    <input class="widefat" \n\
                                                        id="widget-widget_dynamically_fields-2-text-'+ counter +'" \n\
                                                        name="widget-widget_dynamically_fields[2][text][]" \n\
                                                        type="text" \n\
                                                        value=""/>\n\
                                                </p>');
    });
    
    $('body').on('click', '.wd-remove-text-field', function (){
        $(this).parent('.widget_dynamically_fields_elements').remove();
    });
    
});