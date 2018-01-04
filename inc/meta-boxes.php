<?php
/**
 * Add meta box
 *
 * @param post $post The post object
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */
if ( ! function_exists( 'add_custom_meta_box' ) ):
    function add_custom_meta_box()
    {
        //add_meta_box( 'my-meta-box-id', 'My First Meta Box', 'custom_meta_box_callBack', 'post', 'normal', 'high' ); //simple if i have only one screen
        $screens = ['post', 'page'];
        foreach ($screens as $screen) {
            add_meta_box(
                'my-meta-box-id',               // Unique ID
                'My First Meta Box',            // Box title
                'custom_meta_box_callBack',     // Content callback, must be of type callable
                $screen,                        // Post type  Default value: null
                'normal',                       // Position  ('normal', 'side', and 'advanced')  Default value: 'advanced'
                'high'                          // Priority ('high', 'low') Default value: 'default'
            );
        }
    }
    add_action( 'add_meta_boxes', 'add_custom_meta_box' );
endif;



function custom_meta_box_callBack($post)
{
    
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    
    // $post is already set, and contains an object: the WordPress post
    //global $post;  //i have $post as argument in function so i don't need global $post
    
    
    $values = get_post_custom( $post->ID ); //this returns array with all custom meta fields
    
    

    //$text = get_post_meta($post->ID, 'my_meta_box_text', true);
    isset($values['my_meta_box_text'])? $text = get_post_meta($post->ID, 'my_meta_box_text', true) :$text = '';

     
    

    ?>
    <p>
        <label for="my_meta_box_text">Text Label</label>
        <input type="text" name="my_meta_box_text" id="my_meta_box_text" value="<?php echo $text; ?>" />
    </p>
     
   
    <?php    
}

add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
     
    // now we can actually save the data
//    $allowed = array( 
//        'a' => array( // on allow a tags
//            'href' => array() // and those anchors can only have href attribute
//        )
//    );
     
    //1st simple way
    /* Get the posted data and sanitize it for use as an HTML class. */
    //$text = ( isset( $_POST['my_meta_box_text'] ) ? sanitize_text_field( $_POST['my_meta_box_text'] ) : '' );
    
    // Make sure your data is set before trying to save it
//    if( isset( $_POST['my_meta_box_text'] ) ){
//        update_post_meta( $post_id, 'my_meta_box_text', $text );
//    }
    
    //2nd full way
    $text = ( isset( $_POST['my_meta_box_text'] ) ? sanitize_text_field( $_POST['my_meta_box_text'] ) : '' );
    $text_old = get_post_meta( $post_id, 'my_meta_box_text', true );
    /* If a new meta value was added and there was no previous value, add it. */
    if($text && $text_old == ''){
        add_post_meta( $post_id, 'my_meta_box_text', $text, true );
    }
    /* If the new meta value does not match the old value, update it. */
    elseif($text && $text != $text_old){
        update_post_meta( $post_id, 'my_meta_box_text', $text );
    }
    /* If there is no new meta value but an old value exists, delete it. */
    elseif($text == '' && $text_old){
        delete_post_meta( $post_id, 'my_meta_box_text', $text_old );
    }

}