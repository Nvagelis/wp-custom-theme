<?php

//require get_template_directory() . '/inc/mods/Category-text.php';
require get_template_directory() . '/inc/mods/Category-image/Category-image.php';


/*
 *  Ή όλα σε μία κλάση ή το καθένα στη δική του και μετά τα columns συγκεντρωμένα εδώ σε ένα φίλτρο 
 * 
 *  */


//add_filter('manage_category_custom_column', 'display_custom_category_columns', 10, 3);
//add_filter('manage_edit-category_columns', 'add_costom_category_columns');
//
//function add_costom_category_columns($columns){
//    $columns['cat_image_url'] = __('Image URL');
//    $columns['vagelis'] = __('vagelis');
//    $columns['cat_image'] = __('Image ico URL');
//    return $columns;
//}
//
//function display_custom_category_columns($content, $column_name, $term_id){
//    if ( 'cat_image_url' == $column_name ) {
//        return get_term_meta($term_id, 'image-url', true);
//    }else if ( 'vagelis' == $column_name ) {
//        return 'ddd';
//    }else if ( 'cat_image' == $column_name ) {
//        $image_id = get_term_meta ( $term_id, 'category-image-id', true );
//        //echo wp_get_attachment_image ( $image_id, 'thumbnail' );
//        if($image_id){
//            return '<img width="40" height="40" src="'.wp_get_attachment_image_url( $image_id, 'thumbnail' ).'">';
//        }
//    }else {
//        return '';
//    }
//    
//}

