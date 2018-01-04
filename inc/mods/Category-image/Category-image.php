<?php

if ( ! class_exists( 'category_image_term_meta' ) ) {

class category_image_term_meta {

    public function __construct() {
        add_action( 'category_add_form_fields', array ( $this, 'add_category_image' ), 10, 2 );
        add_action( 'created_category', array ( $this, 'save_category_image' ), 10, 2 );
        add_action( 'category_edit_form_fields', array ( $this, 'update_category_image' ), 10, 2 );
        add_action( 'edited_category', array ( $this, 'updated_category_image' ), 10, 2 );
        add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
        add_filter( 'manage_edit-category_columns', array ( $this, 'add_category_image_column'));
        add_filter( 'manage_category_custom_column', array ( $this, 'display_category_image_column'), 10, 3 );
    }
    /* column filter after actions: actions(10,2) filter(10,3) */

    public function load_media() {
        wp_enqueue_media();
        wp_enqueue_script('category_image_scripts', get_stylesheet_directory_uri() . '/inc/mods/Category-image/assets/js/js.js', array( 'jquery' ));
    }

    public function add_category_image ( $taxonomy ) { ?>
        <div class="form-field term-group">
            <label for="category-image-id"><?php _e('Image', 'hero-theme'); ?></label>
            <input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
            <div id="category-image-wrapper"></div>
            <p>
                <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
                <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
            </p>
            <p><?php _e('select category icon, 60x60.'); ?></p>
        </div>
    <?php
    }

    public function save_category_image ( $term_id, $tt_id ) {
        if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
            $image = $_POST['category-image-id'];
            add_term_meta( $term_id, 'category-image-id', $image, true );
        }
    }

    public function update_category_image ( $term, $taxonomy ) { ?>
        <tr class="form-field term-group-wrap">
            <th scope="row">
                <label for="category-image-id"><?php _e( 'Image', 'hero-theme' ); ?></label>
            </th>
            <td>
                <?php $image_id = get_term_meta ( $term -> term_id, 'category-image-id', true ); ?>
                <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
                <div id="category-image-wrapper">
                    <?php if ( $image_id ) { ?>
                        <?php echo wp_get_attachment_image ( $image_id, 'full' ); ?>
                    <?php } ?>
                </div>
                <p>
                    <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
                    <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
                </p>
            </td>
        </tr>
    <?php
    }

    public function updated_category_image ( $term_id, $tt_id ) {
        if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
            $image = $_POST['category-image-id'];
            update_term_meta ( $term_id, 'category-image-id', $image );
        } else {
            update_term_meta ( $term_id, 'category-image-id', '' );
        }
    }
    
    public function add_category_image_column($columns){
        $columns['cat_image'] = __('Image ico URL');
        return $columns;
    }
    
    public function display_category_image_column($content, $column_name, $term_id){
        if ( 'cat_image' == $column_name ) {
            $image_id = get_term_meta ( $term_id, 'category-image-id', true );
            //echo wp_get_attachment_image ( $image_id, 'thumbnail' );
            if($image_id){
                return '<img width="40" height="40" src="'.wp_get_attachment_image_url( $image_id, 'thumbnail' ).'">';
            }
        }
    }

  }
 
$category_image_term_meta = new category_image_term_meta();
 
}


//display function
function ds_single_post_get_image($id){
    $category = get_the_category($id);
    $term_id = $category[0]->term_id;
    $image_id = get_term_meta ( $term_id, 'category-image-id', true );
    if($image_id){
        return wp_get_attachment_image ( $image_id, 'full' );
    }else{
        $image = get_stylesheet_directory_uri().'/img/icon-healing.png';
        return '<img src="'. $image .'">';
    }
}