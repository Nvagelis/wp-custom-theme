<?php

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




 
if (!function_exists('advanced_customize_register')) {
	function advanced_customize_register( $wp_customize ) {
            
            /**
            --------------------------
                Custom Controls
            -------------------------
             **/
            
            /**
            *  Multi input
            * 
            **/
            
            class Multi_Input_Custom_control extends WP_Customize_Control{
                public $type = 'multi_input';
                public function enqueue(){
                    wp_enqueue_script( 'custom_controls', get_template_directory_uri().'/inc/customizer/assets/js/multi_input.js', array( 'jquery' ),'', true );
                    wp_enqueue_style( 'custom_controls_css', get_template_directory_uri().'/inc/customizer/assets/css/multi_input.css');
                }
                public function render_content(){
                        ?>
                        <label class="customize_multi_input">
                                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                                <p><?php echo wp_kses_post($this->description); ?></p>
                                <input type="hidden" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this->value()); ?>" class="customize_multi_value_field" data-customize-setting-link="<?php echo esc_attr($this->id); ?>"/>
                                <div class="customize_multi_fields">
                                        <div class="set">
                                                <input type="text" value="" class="customize_multi_single_field"/>
                                                <a href="#" class="customize_multi_remove_field">X</a>
                                        </div>
                                </div>
                                <a href="#" class="button button-primary customize_multi_add_field"><?php esc_attr_e('Add More', 'mytheme') ?></a>
                        </label>
                        <?php
                }
            }

            
            /**
            ------------------------------------------------------------
            SECTION: Header
            ------------------------------------------------------------
            **/
            
            $wp_customize->add_section( 'advanced_section', array(
                'title'		=> esc_html__( 'Advanced Section', 'mytheme' ),
                'priority'	=> 10,
            ));
            
                /**
                 *  Multi input
                 * 
                **/
                               
               
                $wp_customize->add_setting('multi_field', array(
                    'default'           => '',
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'mytheme_text_sanitization',
                ));
                $wp_customize->add_control(new Multi_Input_Custom_control($wp_customize, 'multi_field', array(
                    'label'    		=> esc_html__('Multiple inputs', 'mytheme'),
                    'description' 	=> esc_html__('Add more and more and more...', 'mytheme'),
                    'settings'		=> 'multi_field',
                    'section'  		=> 'advanced_section',
                )));
            
        }
}

add_action( 'customize_register', 'advanced_customize_register' );