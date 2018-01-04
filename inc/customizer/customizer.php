<?php

/*
 *  use values
 * 
    $ergacis_logo = get_theme_mod('ergacis_logo', '');
    $logo_text = get_theme_mod('logo_text', '');
    $anchor_color = get_theme_mod('anchor_color', '');
    $custom_checkbox = get_theme_mod('custom_checkbox', '');
    $custom_url = get_theme_mod('custom_url', '');
    $custom_email = get_theme_mod('custom_email', '');
    $custom_textarea = get_theme_mod('custom_textarea', '');
 * 
 *  */



/*
        Title                   ID                  Priority (Order)
        Site Title & Tagline 	title_tagline           20
        Colors                  colors                  40
        Header Image            header_image            60
        Background Image 	background_image 	80
        Menus (Panel)           nav_menus               100
        Widgets (Panel) 	widgets                 110
        Static Front Page 	static_front_page 	120
        default                                         160
        Additional CSS          custom_css              200
 *  */


function customtheme_customizer_live_preview(){
    wp_enqueue_script( 'customtheme-themecustomizer', get_template_directory_uri().'/js/customizer.js', array( 'jquery','customize-preview' ), '', true);
}
add_action( 'customize_preview_init', 'customtheme_customizer_live_preview' );


/*
 *  Αν θελω js validate κανω τα scripts regist στο customize_controls_enqueue_scripts για να εχω wp.customize.Notification
 */
function customtheme_customizer_validation(){
    wp_enqueue_script( 'customtheme-validation', get_template_directory_uri().'/js/customizer-validation.js', array('jquery', 'customize-controls'), '', true);
}
add_action( 'customize_controls_enqueue_scripts', 'customtheme_customizer_validation' );

 
if (!function_exists('mytheme_customize_register')) {
	function mytheme_customize_register( $wp_customize ) {
            
            
            $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
            $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
            //$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
            
            /**
            --------------------------
                Custom Controls
            -------------------------
             **/
            class Toggle_Checkbox_Custom_control extends WP_Customize_Control{
                public $type = 'toogle_checkbox';
                public function enqueue(){
                    wp_enqueue_style( 'custom_controls_css', get_stylesheet_directory_uri().'/css/custom_controls_checkbox.css');
                }
                public function render_content(){
                    ?>
                    <div class="checkbox_switch">
                        <div class="onoffswitch">
                            <input type="checkbox" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" class="onoffswitch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?>>
                            <label class="onoffswitch-label" for="<?php echo esc_attr($this->id); ?>"></label>
                        </div>
                        <span class="customize-control-title onoffswitch_label"><?php echo esc_html( $this->label ); ?></span>
                        <p><?php echo wp_kses_post($this->description); ?></p>
                    </div>
                    <?php
                }
            }
            
            
            
//            $wp_customize->add_panel( 'header_panel', array(
//                'title' => esc_html__( 'Header Panel', 'mytheme' ),
//                'priority' => 10,
//            ));   //
            
            /**
            ------------------------------------------------------------
            SECTION: Header
            ------------------------------------------------------------
            **/
            
            $wp_customize->add_section( 'misc_section', array(
                'title'		=> esc_html__( 'Misc Section', 'mytheme' ),
                'priority'	=> 10,
                //'panel'     => 'header_panel',  //if panel is active
            ));
            
            $wp_customize->add_section( 'advanced_section', array(
                'title'		=> esc_html__( 'Advanced Section', 'mytheme' ),
                'priority'	=> 10,
                //'panel'     => 'header_panel',  //if panel is active
            ));
            
                /**
                    Ergacis Logo
                **/

                $wp_customize->add_setting( 'custom_logo', array(
                    'default'           => '',
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'esc_url_raw',
                ));

                $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'custom_logo', array(
                    'label'    => esc_html__( 'Custom logo', 'mytheme' ),
                    'settings' => 'custom_logo',
                    'section'  => 'misc_section',
                )));
                
                /**
                Logo Text
                **/
                
                $wp_customize->add_setting( 'logo_text', array(
                    'default'           => esc_html__( 'I\'m cool!', 'mytheme' ),
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'mytheme_text_sanitization',
                ));
                $wp_customize->add_control( 'logo_text', array(
                    'label'       => esc_html__( 'Logo Text', 'mytheme' ),
                    'description' => esc_html__( 'A piece of text that will be shown next to the header logo.', 'mytheme' ),
                    'type'        => 'text',
                    'section'     => 'misc_section',
                ));
                
                /**
                Anchor Color
                **/
                $wp_customize->add_setting('anchor_color', array(
                    'default'           => '#ff503f',
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'sanitize_hex_color',
                ));
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anchor_color', array(
                    'label'      => esc_attr__('Anchor Color', 'mytheme'),
                    'settings'   => 'anchor_color',
                    'section'    => 'misc_section',
                )));
                
                /**
                Custom Checkbox
                **/
                $wp_customize->add_setting('custom_checkbox', array(
                    'default'           => false,
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'mytheme_checkbox_sanitization',
                ));
                $wp_customize->add_control(new Toggle_Checkbox_Custom_control($wp_customize, 'custom_checkbox', array(
                    'label'    		=> esc_html__('Check me', 'mytheme'),
                    'description' 	=> esc_html__('There are times that you just need to say something.', 'mytheme'),
                    'type'     		=> 'checkbox',
                    'settings'		=> 'custom_checkbox',
                    'section'  		=> 'misc_section',
                )));
                
                /**
                Custom URL
                **/
                $wp_customize->add_setting( 'custom_url', array(
                    'default' => '',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage', 
                    'sanitize_callback' => 'esc_url',
                ));

                $wp_customize->add_control( 'custom_url', array(
                    'type' => 'url',
                    'section' => 'misc_section',
                    'label' => __( 'URL Field', 'mytheme' ),
                    'description' => 'this is the description of custom url',
                ));
                
                /**
                Custom email
                **/
                $wp_customize->add_setting( 'custom_email', array(
                    'default' => '',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage', 
                    'sanitize_callback' => 'sanitize_email',
                 ));

                $wp_customize->add_control( 'custom_email', array(
                    'type' => 'email',
                    'section' => 'misc_section',
                    'label' => __( 'Email Field', 'textdomain' ),
                    'description' => 'this is the description of custom email',
                ));
                
                /**
                Custom text field
                **/
                $wp_customize->add_setting( 'custom_textarea', array(
                    'default' => '',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage', 
                    'sanitize_callback' => 'esc_textarea',
                    ) );

                $wp_customize->add_control( 'custom_textarea', array(
                    'type' => 'textarea',
                    'section' => 'misc_section',
                    'label' => __( 'Textarea Field', 'textdomain' ),
                    'description' => '',
                ) );
                
                /**
                Custom number field
                **/
                $wp_customize->add_setting( 'custom_number', array(
                    'default' => '',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',       
                    'sanitize_callback' => 'absint',
                    'validate_callback' => 'validate_number_field'
                    ) );

                $wp_customize->add_control( 'custom_number', array(
                    'type' => 'text',
                    'section' => 'misc_section',
                    'label' => __( 'Number Field', 'textdomain' ),
                    'description' => '',
                ) );
                
                /**
                Custom Date field
                **/
                $wp_customize->add_setting( 'custom_date', array(
                    'default' => '',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',
                    //'sanitize_callback' => 'mytheme_sanitize_date',
                ));

                $wp_customize->add_control( new WP_Customize_Date_Time_Control( $wp_customize, 'custom_date', array(
                    //'type' => 'date',   //If i put 'type' => 'date' enable the old date field
                    'priority' => 10,
                    'section' => 'misc_section',
                    'label' => __( 'Date Field', 'textdomain' ),
                    'description' => '',
                    'include_time' => true, // Optional. Default: true
                    'allow_past_date' => true, // Optional. Default: true
                    'twelve_hour_format' => true, // Optional. Default: true
                    'min_year' => '2010', // Optional. Default: 1000
                    'max_year' => '2025' // Optional. Default: 9999
                )));
                
                
                /**
                Custom Range field
                **/
                $wp_customize->add_setting( 'custom_range', array(
                        'default' => '',
                        'type' => 'theme_mod',
                        'capability' => 'edit_theme_options',
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint',
                ) );

                $wp_customize->add_control( 'custom_range', array(
                    'type' => 'range',
                    'priority' => 10,
                    'section' => 'misc_section',
                    'label' => __( 'Range Field', 'textdomain' ),
                    'description' => '',
                    'input_attrs' => array(
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                        'class' => 'example-class',
                        'style' => 'color: #0a0',
                    ),
                ));
                
                
                /**
                Logo Text
                 * Advanced 
                **/
                
                $wp_customize->add_setting( 'advanced_text', array(
                    'default'           => esc_html__( 'I\'m cool!', 'mytheme' ),
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'mytheme_text_sanitization',
                ));
                $wp_customize->add_control( 'advanced_text', array(
                    'label'       => esc_html__( 'advanced Text', 'mytheme' ),
                    'description' => esc_html__( 'A piece of text that will be shown next to the header logo.', 'mytheme' ),
                    'type'        => 'text',
                    'section'     => 'advanced_section',
                ));
               
                
                
                /*
                 * Back end notifications.
                 *                  
                 */
                function validate_number_field( $validity, $value ) {
                    $value = intval( $value );
                    if ( $value < 10 ) {
                        $validity->add( 'too_small', __( 'Number is too small.' ) );
                    } elseif ( $value > 100 ) {
                        $validity->add( 'too_big', __( 'Number is too big.' ) );
                    }
                    return $validity;
                }
                
                
                /*
                 * Custom sanitization.
                 *                  
                 */
                if(!function_exists( 'mytheme_text_sanitization' ) ) {
                    function mytheme_text_sanitization( $input ) {
                        return wp_kses_post( force_balance_tags( $input ) );
                    }
                }
                
                if(!function_exists( 'mytheme_checkbox_sanitization' ) ) {
                    function mytheme_checkbox_sanitization( $input ) {
                        if ( $input == 1 ) {
                            return 1;
                        } else {
                            return 0;
                        }
                    }
                }
                
                function mytheme_sanitize_date( $input ) {
                    $date = new DateTime( $input );
                    return $date->format('d-m-Y');
                }
            
        }
}

add_action( 'customize_register', 'mytheme_customize_register' );