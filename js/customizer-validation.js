( function( $ ) {
    
    
    wp.customize( 'custom_number', function( setting ) {
            setting.validate = function ( value ) {
                var code, notification;

                code = 'required';
                if ( isNaN( value ) ) {
                    notification = new wp.customize.Notification( code, {message: 'Number is required'} );
                    setting.notifications.add( code, notification );
                } else {
                    setting.notifications.remove( code );
                }

                code = 'year_too_small';
                if ( value < 10 ) {
                    notification = new wp.customize.Notification( code, {message: 'Number is too small'} );
                    setting.notifications.add( code, notification );
                } else {
                    setting.notifications.remove( code );
                }

                code = 'year_too_big';
                if ( value > 100 ) {
                    notification = new wp.customize.Notification( code, {message: 'Number is too big'} );
                    setting.notifications.add( code, notification );
                } else {
                    setting.notifications.remove( code );
                }

                return value;
            };
        });
    
} )( jQuery );


