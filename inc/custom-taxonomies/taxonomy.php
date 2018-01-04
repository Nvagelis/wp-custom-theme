<?php
class custom_taxonomy_name{
    
    function __construct(){
        add_action( 'init', array( $this, 'custom_taxonomy' ),0 );
    }
    
    public function custom_taxonomy() {

        $taxonomy_names = array(
            'slug'   => 'taxonomy_name',
            'singular' => 'Taxonomy_name',
            'plural'   => 'Taxonomy_names'
            );
        
	$labels = array(
		'name'                       => _x( $taxonomy_names['plural'], 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( $taxonomy_names['singular'], 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( $taxonomy_names['singular'], 'text_domain' ),
		'all_items'                  => __( 'All '.$taxonomy_names['plural'], 'text_domain' ),
		'parent_item'                => __( 'Parent '.$taxonomy_names['singular'], 'text_domain' ),
		'parent_item_colon'          => __( 'Parent '.$taxonomy_names['singular'].':', 'text_domain' ),
		'new_item_name'              => __( 'New '.$taxonomy_names['singular'].' Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New '.$taxonomy_names['singular'], 'text_domain' ),
		'edit_item'                  => __( 'Edit '.$taxonomy_names['singular'], 'text_domain' ),
		'update_item'                => __( 'Update '.$taxonomy_names['singular'], 'text_domain' ),
		'view_item'                  => __( 'View '.$taxonomy_names['singular'], 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate '.$taxonomy_names['plural'].' with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove '.$taxonomy_names['plural'], 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular '.$taxonomy_names['plural'], 'text_domain' ),
		'search_items'               => __( 'Search '.$taxonomy_names['plural'], 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No '.$taxonomy_names['plural'], 'text_domain' ),
		'items_list'                 => __( $taxonomy_names['plural'].' list', 'text_domain' ),
		'items_list_navigation'      => __( $taxonomy_names['plural'].' list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
                'update_count_callback' => '_update_post_term_count',   //If 'hierarchical' => false, important
		'query_var' => true,
		'rewrite' => array('slug' => $taxonomy_names['slug'] )
	);
	register_taxonomy( $taxonomy_names['slug'], array( 'post', ' page' ), $args );

}

    
}

new custom_taxonomy_name();