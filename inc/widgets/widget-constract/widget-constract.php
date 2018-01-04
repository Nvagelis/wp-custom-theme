<?php

class custom_widget extends WP_Widget{
    
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'custom_widget', 
            'description' => esc_html__('Displays the custom widget.', 'energy') 
            );
        parent::__construct( 
                'custom_widget', // Base ID
                esc_html__('Custom Widget', 'customtheme'), // Name
                $widget_ops 
            );
            $this->alt_option_name = 'custom_widget';
            add_action( 'admin_enqueue_scripts', array( $this, 'custom_widget_admin_scripts' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'custom_widget_enqueue_scripts' ) );
    }
    
    public function custom_widget_admin_scripts() {
        wp_enqueue_script('custom_widget-scripts-admin', get_stylesheet_directory_uri() . '/inc/widgets/widget-constract/assets/js/admin.js', array( 'jquery' ), '1.0', true);
        wp_enqueue_style('custom_widget-style-admin', get_stylesheet_directory_uri() . '/inc/widgets/widget-constract/assets/css/admin.css', array(), '1.0');
    }
    public function custom_widget_enqueue_scripts() {
        wp_enqueue_script('custom_widget-scripts', get_stylesheet_directory_uri() . '/inc/widgets/widget-constract/assets/js/js.js', array( 'jquery' ), '1.0', true);
        wp_enqueue_style('custom_widget-style', get_stylesheet_directory_uri() . '/inc/widgets/widget-constract/assets/css/style.css', array(), '1.0');
    }
    
    public function update($new_instance, $old_instance) {

        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
            
    }

    public function form($instance) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        ?>
        <div class="nav-menu-widget-form-controls">
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'custom_widget'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>    
        </div>
        <?php
    }

    public function widget($args, $instance) {
        /** This filter is documented in wp-includes/default-widgets.php */
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        
        echo wp_kses_post($args['before_widget']);

        if ( ! empty( $instance['title'] ) ) {
            echo wp_kses_post($args['before_title'] . $instance['title'] . $args['after_title']);
        }
        
        echo wp_kses_post($args['after_widget']);
    }


} 
register_widget('custom_widget');

