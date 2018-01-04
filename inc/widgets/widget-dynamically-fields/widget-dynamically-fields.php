<?php

class widget_dynamically_fields extends WP_Widget{
    
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'widget_dynamically_fields', 
            'description' => esc_html__('Displays the custom widget.', 'energy') 
            );
        parent::__construct( 
                'widget_dynamically_fields', // Base ID
                esc_html__('Widget dynamically fields', 'customtheme'), // Name
                $widget_ops 
            );
        $this->alt_option_name = 'widget_dynamically_fields';
        add_action( 'admin_enqueue_scripts', array( $this, 'widget_dynamically_scripts' ) );
    }
    
    public function widget_dynamically_scripts(){
        wp_enqueue_script('widget-dynamically-fields-scripts', get_stylesheet_directory_uri() . '/inc/widgets/widget-dynamically-fields/assets/js/js.js', array( 'jquery' ));
        wp_enqueue_style('widget-dynamically-fields-style', get_stylesheet_directory_uri() . '/inc/widgets/widget-dynamically-fields/assets/css/style.css');
    }
    public function update($new_instance, $old_instance) {

        $instance['title'] = strip_tags($new_instance['title']);
        
        $instance['text'] = array();
        if ( isset ( $new_instance['text'] ) ){
            foreach ( $new_instance['text'] as $value ){
                $instance['text'][] = strip_tags($value);
            }
        }
        return $instance;
            
    }

    public function form($instance) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $text = isset( $instance['text'] ) ? $instance['text'] : array();
        ?>
        <div class="nav-menu-widget-form-controls"> 
            <div class="widget_dynamically_fields"><!--Custom class for jquery append-->
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'widget_dynamically_fields'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>    
        <?php
            foreach ( $text as $key=>$value ){
            ?>
                <p class="widget_dynamically_fields_elements">
                    <label for="<?php echo $this->get_field_id('text').'-'.($key + 1); ?>"><?php _e('Text '.($key + 1).'', 'widget_dynamically_fields'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('text').'-'.($key + 1); ?>" name="<?php echo $this->get_field_name('text'); ?>[]" type="text" value="<?php echo $value; ?>" />
                    <span class="dashicons dashicons-dismiss wd-remove-text-field"></span>
                </p>    
            <?php
            }
            
        ?>
            </div>
            <input type="button" id="wd-add-text-field" value="<?php _e( 'Add Text Field', 'customtheme' ); ?>" class="wd-add-text-field button"/>
        </div>
        <?php
    }

    public function widget($args, $instance) {
        /** This filter is documented in wp-includes/default-widgets.php */
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $text = empty($instance['text']) ? array() : $instance['text'];
        
        echo wp_kses_post($args['before_widget']);

        if ( ! empty( $instance['title'] ) ) {
            echo wp_kses_post($args['before_title'] . $instance['title'] . $args['after_title']);
        }
        
        foreach ( $text as $value ){
            echo $value.'<br />';
        }
        
        echo wp_kses_post($args['after_widget']);
    }


} 
register_widget('widget_dynamically_fields');

