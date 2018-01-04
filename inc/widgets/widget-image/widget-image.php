<?php

class widget_image extends WP_Widget{
    
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'widget_image', 
            'description' => esc_html__('Displays the custom widget.', 'energy') 
            );
        parent::__construct( 
                'widget_image', // Base ID
                esc_html__('Widget Image', 'customtheme'), // Name
                $widget_ops 
            );
        $this->alt_option_name = 'widget_image';
        add_action( 'admin_enqueue_scripts', array( $this, 'widget_image_scripts' ) );
    }
    
    public function widget_image_scripts() {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('widget-image-scripts', get_stylesheet_directory_uri() . '/inc/widgets/widget-image/assets/js/widget-image.js', array( 'jquery' ));
        wp_enqueue_style('widget-image-styles', get_stylesheet_directory_uri() . '/inc/widgets/widget-image/assets/css/style.css');
        wp_enqueue_style('thickbox');
    }
    
    public function update($new_instance, $old_instance) {

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['image'] = strip_tags($new_instance['image']);
        return $instance;
            
    }

    public function form($instance) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $image = isset( $instance['image'] ) ? $instance['image'] : '';
        ?>
        <div class="nav-menu-widget-form-controls">
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'widget_image'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>    
        </div>
        <div class="nav-menu-widget-form-controls">
            <p>
                <label for="<?php echo $this->get_field_id('image'); ?>">Image</label>
                <img class="wd-img-image widefat" src="<?php if(!empty($instance['image'])){echo $instance['image'];} ?>"/>
                <input type="text" class="widefat wd-img-path" name="<?php echo $this->get_field_name('image'); ?>" id="<?php echo $this->get_field_id('image'); ?>" value="<?php echo $instance['image']; ?>">
                <input type="button" id="wd-img-upload-btn" value="<?php _e( 'Upload Image', 'customtheme' ); ?>" class="wd-img-upload-btn button"/>
                <input type="button" id="wd-img-remove-btn" value="<?php _e( 'Remove Image', 'customtheme' ); ?>" class="wd-img-remove-btn button"/>
            </p>
        </div>
        <?php
    }

    public function widget($args, $instance) {
        /** This filter is documented in wp-includes/default-widgets.php */
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $image = empty($instance['image']) ? '' : $instance['image'];
        
        echo wp_kses_post($args['before_widget']);

        if ( ! empty( $instance['title'] ) ) {
            echo wp_kses_post($args['before_title'] . $instance['title'] . $args['after_title']);
        }
        
        ?>
        <p>
            <img src='<?php echo $image ?>'>
        </p>    
        <?php
        
        echo wp_kses_post($args['after_widget']);
    }


} 
register_widget('widget_image');

