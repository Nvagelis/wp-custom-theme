<?php
class Widget_loop extends WP_Widget{
    
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'Widget_loop', 
            'description' => esc_html__('Displays time line list.', 'energy') 
            );
        parent::__construct( 
                'Widget_loop', // Base ID
                esc_html__('Widget Loop', 'energy'), // Name
                $widget_ops 
            );
            $this->alt_option_name = 'Widget_loop';
    }
    
    
    public function update($new_instance, $old_instance) {

            
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);

        for( $i = 0; $i < 5; $i++ ) {
            $title_item    = 'title-item-' . $i;
            $list_item    = 'list-item-' . $i;
            $instance[$title_item] = isset( $new_instance[ $title_item ] ) ? $new_instance[ $title_item ] : '';
            $instance[$list_item] = isset( $new_instance[ $list_item ] ) ? $new_instance[ $list_item ] : '';
        }
        return $instance;
            
    }

    public function form($instance) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        ?>

        <div class="nav-menu-widget-form-controls">
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'Widget_loop'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            
            <?php for( $i = 0; $i < 5; $i++ ){
                $title_item = 'title-item-'.$i;
                $list_item = 'list-item-'.$i;
                ${$title_item} = isset( $instance[$title_item] ) ? $instance[$title_item] : '';
                ${$list_item} = isset( $instance[$list_item] ) ? $instance[$list_item] : '';
                ?>
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id( $title_item )); ?>"><?php esc_attr_e( 'Title item ', 'Widget_loop' ); ?> <?php echo absint( $i + 1 ); ?>:</label>
                        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( $title_item )); ?>" name="<?php echo esc_attr($this->get_field_name( $title_item )); ?>" value="<?php echo esc_attr( ${$title_item} ); ?>"/>
                    </p>
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id( $list_item )); ?>"><?php esc_attr_e( 'List item ', 'Widget_loop' ); ?> <?php echo absint( $i + 1 ); ?>:</label>
                        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( $list_item )); ?>" name="<?php echo esc_attr($this->get_field_name( $list_item )); ?>" value="<?php echo esc_attr( ${$list_item} ); ?>"/>
                    </p>
            <?php } ?>
            
        </div>
        <?php
    }

    public function widget($args, $instance) {
        /** This filter is documented in wp-includes/default-widgets.php */
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        
        for( $i = 0; $i < 5; $i++ ){
            $title_item = 'title-item-'.$i;
            $list_item = 'list-item-'.$i;
            ${$title_item} = isset( $instance[$title_item] ) ? $instance[$title_item] : '';
            ${$list_item} = isset( $instance[$list_item] ) ? $instance[$list_item] : '';
        }
        
        echo wp_kses_post($args['before_widget']);

        if ( ! empty( $instance['title'] ) ) {
            echo wp_kses_post($args['before_title'] . $instance['title'] . $args['after_title']);
        }

        echo '<ul class="time--line clearfix">';
	    for ( $i = 0; $i < 5; $i ++ ) {
                $title_item = 'title-item-' . $i;
                $list_item = 'list-item-' . $i;
                if ( ! empty( ${$list_item} ) ) {
                    $timeline = '';
                    $timeline .= '<li class="time--line__item">';
                    $timeline .= '<div class="time--line__wrap">';
                    $timeline .= '<h3>';
                    $timeline .= wp_kses_post( ${$title_item}  );
                    $timeline .= '</h3>';
                    $timeline .= '<p>';
                    $timeline .= wp_kses_post(  ${$list_item}  );
                    $timeline .= '</p>';
                    $timeline .= '<span class="time--line__number">';
                    $timeline .= '<span class="time--line__number-inner">0';
                    $timeline .= $i+1;
                    $timeline .= '<span>';
                    $timeline .= '</span>';
                    $timeline .= '</div>';
                    $timeline .= '</li>';
                    echo $timeline;

                }
	    }
        echo '<span class="time--line__line"></span></ul>';
        
        echo wp_kses_post($args['after_widget']);
    }


} 
register_widget('Widget_loop');