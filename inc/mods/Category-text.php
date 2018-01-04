<?php

//Combine fields into class!!!

add_action('category_add_form_fields', 'category_metabox_add', 10, 1);
add_action('category_edit_form_fields', 'category_metabox_edit', 10, 1);	
 
function category_metabox_add($tag) { ?>
    <div class="form-field">
        <label for="image-url"><?php _e('Image URL') ?></label>
        <input name="image-url" id="image-url" type="text" value=""/>
        <p class="description"><?php _e('This image will be the thumbnail shown on the category page.'); ?></p>
    </div>
<?php } 	
 
function category_metabox_edit($tag) { ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="image-url"><?php _e('Image URL'); ?></label>
        </th>
        <td>
            <!--<input name="image-url" id="image-url" type="text" value="<?php //echo get_term_meta($tag->term_id, 'image-url', true); ?>"/>-->
            <input name="image-url" id="image-url" type="text" value="<?php echo empty(get_term_meta($tag->term_id, 'image-url', true))?'':get_term_meta($tag->term_id, 'image-url', true); ?>"/>
            <p class="description"><?php _e('This image will be the thumbnail shown on the category page.'); ?></p>
        </td>
    </tr>
<?php }	

add_action('created_category', 'save_category_metadata', 10, 1);	
add_action('edited_category', 'save_category_metadata', 10, 1);
 
function save_category_metadata($term_id)
{
    if (isset($_POST['image-url'])) 
        update_term_meta( $term_id, 'image-url', $_POST['image-url']);       			
}


/* add thumbnail to admin edit page  */
add_filter('manage_edit-category_columns', 'add_thumbnail_column_vv');
 
function add_thumbnail_column_vv($columns){
    $columns['cat_image_url'] = __('Image URL');
    $columns['vagelis'] = __('vagelis');
    return $columns;
}

add_filter('manage_category_custom_column', 'display_thumbnail_column_vv', 10, 3);
 
function display_thumbnail_column_vv($content, $column_name, $term_id){
    if ( 'cat_image_url' == $column_name ) {
        return get_term_meta($term_id, 'image-url', true);
    }else if ( 'vagelis' == $column_name ) {
        return 'some text';
    }else{
        return '';
    }
    
}
