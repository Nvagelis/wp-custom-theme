<?php

//http://codex.wordpress.org/Function_Reference/add_action#Using_with_a_Class
//http://codex.wordpress.org/Function_Reference/add_meta_box
/*
 *
 * Βαζω name με underscore :  _cs_custom_message (έτσι Δεν δημιουργώ και extra πεδίο στα custom fields )
 * 
 *  */



class custom_meta_box{
    
    private $post_types = array('post', 'page');
    
    public function __construct() {
        
        add_action('add_meta_boxes', array($this, 'custom_add_meta_box'));
        add_action('save_post', array($this, 'custom_save_meta_box'));
        add_action('the_content', array($this, 'custom_message'));  // if is necessary or use $placeContent->custom_message();
        
    }
    
    public function custom_add_meta_box($post_type) {
       
        //limit meta box to certain post types
        if (in_array($post_type, $this->post_types)) {
            add_meta_box('cs-meta',
            'Add Custom Message',
            array($this, 'custom_meta_box_callback'),
            $post_type,
            'normal',
            'high');
        }
    }
    
    public function custom_meta_box_callback($post) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field('cs_nonce_check', 'cs_nonce_check_value');

        // Use get_post_meta to retrieve an existing value from the database.
        $custom_message = get_post_meta($post -> ID, '_cs_custom_message', true);

        // Display the form, using the current value.
        ?>
    <p>
        <label for="custom_message">Text Label</label>
        <input type="text" name="_cs_custom_message" id="custom_message" value="<?php echo esc_attr($custom_message); ?>" />
    </p>
     
   
    <?php
    }
    
    public function custom_save_meta_box($post_id) {
        // Check if our nonce is set.
        if (!isset($_POST['cs_nonce_check_value']))
        return $post_id;

        $nonce = $_POST['cs_nonce_check_value'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'cs_nonce_check'))
        return $post_id;

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) return $post_id;
        } else {
            if (!current_user_can('edit_post', $post_id)) return $post_id;
        }
        /* OK, its safe for us to save the data now. */

        //1st simple way. Sanitize the user input.
        //$data = sanitize_text_field($_POST['cs_custom_message']);
        // Update the meta field.
        //update_post_meta($post_id, '_cs_custom_message', $data);
        
        
        //2nd full way
        $data = ( isset( $_POST['_cs_custom_message'] ) ? sanitize_text_field( $_POST['_cs_custom_message'] ) : '' );
        $text_old = get_post_meta( $post_id, '_cs_custom_message', true );
        /* If a new meta value was added and there was no previous value, add it. */
        if($data && $text_old == ''){
            add_post_meta( $post_id, '_cs_custom_message', $data, true );
        }
        /* If the new meta value does not match the old value, update it. */
        elseif($data && $data != $text_old){
            update_post_meta( $post_id, '_cs_custom_message', $data );
        }
        /* If there is no new meta value but an old value exists, delete it. */
        elseif($data == '' && $text_old){
            delete_post_meta( $post_id, '_cs_custom_message' );
        }
       
    }
    
    public function custom_message($content) {
        global $post;
        //retrieve the metadata values if they exist
        $data = get_post_meta($post -> ID, '_cs_custom_message', true);
        if (!empty($data)) {
        $custom_message = "<div style='background-color: #FFEBE8;border-color: #C00;padding: 2px;margin:2px;font-weight:bold;text-align:center'>";
        $custom_message .= $data;
        $custom_message .= "</div>";
        $content = $custom_message . $content;
        }

        return $content;
    }
}

$placeContent = new custom_meta_box();
//place it with $placeContent->custom_message();