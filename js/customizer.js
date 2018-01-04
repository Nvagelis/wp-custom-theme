/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
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

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
            value.bind( function( to ) {
                if ( 'blank' === to ) {
                    $( '.site-title, .site-description' ).css( {
                        'clip': 'rect(1px, 1px, 1px, 1px)',
                        'position': 'absolute'
                    } );
                    } else {
                        $( '.site-title, .site-description' ).css( {
                            'clip': 'auto',
                            'position': 'relative'
                        } );
                        $( '.site-title a, .site-description' ).css( {
                            'color': to
                        } );
                    }
            } );
	} );
        
        wp.customize( 'custom_logo', function( value ) {
            value.bind( function( to ) {
                $('.custom_logo').text( to );
            });
        });
        
        wp.customize( 'logo_text', function( value ) {
            value.bind( function( to ) {
                $('.logo_text').text( to );
            });
        });
        
        wp.customize( 'anchor_color', function( value ) {
            value.bind( function( to ) {
                $('.anchor_color').text( to );
            });
        });
        
        wp.customize( 'custom_checkbox', function( value ) {
            value.bind( function( to ) {
                if(to === true){
                    $('.custom_checkbox').text('1');
                }else{
                    $('.custom_checkbox').text('0');
                }
                
            });
        });
        
        wp.customize( 'custom_url', function( value ) {
            value.bind( function( to ) {
                $('.custom_url').text( to );
            });
        });
        
        wp.customize( 'custom_email', function( value ) {
            value.bind( function( to ) {
                $('.custom_email').text( to );
            });
        });
        
        wp.customize( 'custom_textarea', function( value ) {
            value.bind( function( to ) {
                $('.custom_textarea').text( to );
            });
        });
        
        wp.customize( 'custom_number', function( value ) {
            value.bind( function( to ) {
                $('.custom_number').text( to );
            });
        });
        
        wp.customize( 'custom_date', function( value ) {
            value.bind( function( to ) {
                $('.custom_date').text( to );
            });
        });
        
        wp.customize( 'custom_range', function( value ) {
            value.bind( function( to ) {
                $('.custom_range').text( to );
            });
        });
        
        wp.customize( 'multi_field', function( value ) {
            value.bind( function( to ) {
                $('.multi_field').text( to );
            });
        });
        
            
        
        
        
} )( jQuery );
